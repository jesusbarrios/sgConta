<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
Genera el arreglo para el select tomando como parametro una arreglo inicial
Si el $slc es false, genera el primer elemento del arreglo de forma estandar,
Si se le pasa un arreglo al $slc la funcion concatena los siguientes elementos.

En la iteracion verifica si existe el campo fecha para agregarlo a la opcion
*/

function generarListPersona($facultad = false, $userType = false) {
    $ci     =& get_instance();
    $list   = '';
    $ci->db->join('carreraDetalles    as t2', 't2.id = t1.carreraDetalle', 'left');
    $ci->db->join('personas           as t3', 't3.id = t1.persona', 'left');
    $ci->db->join('documentos         as t4', 't4.persona = t1.persona AND t4.estado = "V"', 'left');
    if( $result = $ci->Jesus->dice(array(
        'get'       => 'estudiantes as t1',
        'where'     => array(
            't2.facultad'   => $facultad? $facultad : false,
            't1.estado'     => 'V',
            't1.tipo'       => is_array($userType)? false : $userType,
        ),
        'where_in'  => array('t1.tipo' => is_array($userType)? $userType : false, 't3.estado' => array('V', 'T')),
        'group_by'  => array('t3.id'),
        'order_by'  => array('t3.apellido' => 'ASC'),
        'select'    => array(
            't3.id as id',
            't3.nombre',
            't3.apellido',
            't4.documento'),
    ))->result() )
        foreach( $result as $result_ )
            if( in_array($ci->sesion['rol'], array(1)) )
                $list   .= "<option value='" . $result_->documento . ", " . $result_->nombre . ", " . $result_->apellido . ' [' . $result_->id . "]'>";
            else
                $list   .= "<option value='" . $result_->documento . ", " . $result_->nombre . ", " . $result_->apellido . "'>";
    return $list;
}

function validarPersona( $facultad = false, $persona = false ) {
    $ci     =& get_instance();

    if ( isset($_POST['txtId']) && $_POST['txtId'] ) {
        if ( $result_ = $ci->Jesus->dice(array(
            'get'       => 'personas',
            'where'     => array(
                'id'        => $_POST['txtId'],
                // 'estado'    => 'V'
            ),
            'select'    => array('id')
        ))->row_array() )
            return $result_['id'];
        return false;
    } else if ( isset($_POST['txtPersona']) ) {
        if( !$persona && !($persona = $ci->input->post('txtPersona')) )
            return;
        $persona_   = explode(', ', $persona);

        $documento  = str_replace('.', '', $persona_[0]);
        $ci->db->join('personas as t2', 't2.id = t1.persona', 'left');
        $documentos = $ci->Jesus->dice(array(
            'get'   => 'documentos as t1',
            'where' => array(
                't1.documento'  => $documento,
                't1.estado'     => 'V'
            ),
            'where_in'  => array('t2.estado' => array('V', 'T')),
        ));
        if( !$documentos_ = $documentos->row_array() )
            return false;
        if( $documentos->num_rows() == 1 )
            $persona = $documentos_['persona'];
        if( isset($persona_[1]) && isset($persona_[2]) )
            foreach( $documentos->result() as $documentos_ )
                if( $personas = $ci->Jesus->dice(array(
                    'get'   => 'personas',
                    'where' => array(
                        'id'         => $documentos_->persona,
                        'nombre'     => $persona_[1],
                        'apellido'   => $persona_[2],
                        'estado'     => 'V'
                    )
                )) )
                    $persona = $documentos_->persona;
    } else {
        $documento  = str_replace('.', '', $ci->input->post('txtDocumento'));
        $tipo       = $ci->input->post('slcDocumentoTipo');
        if( $documento 
            && $tipo 
            && $documentos_ = $ci->Jesus->dice(array(
                'get'   => 'documentos',
                'where' => array(
                    'tipo'      => $tipo,
                    'documento' => $documento,
                    'estado'    => 'V'
                )
            ))->row_array() )
            if ( $persona_ = $ci->Jesus->dice(array(
                'get'   => 'personas',
                'where' => array(
                    'id'    => $documentos_['persona'],
                ),
                'where_in'  => array('estado' => array('V', 'T')),
            ))->row_array() ) {
                $persona = $documentos_['persona'];
            }
    }
    // Verifica si pertenece a la facultad
    if ( $persona && $facultad ) {
        // Estudiante
        $ci->db->join('carreraDetalles as t2', 't2.id = t1.carreraDetalle', 'left');
        if ( $ci->Jesus->dice(array(
            'get'   => 'estudiantes as t1',
            'where' => array(
                't1.persona'    => $persona,
                't1.estado'     => 'V',
                't2.facultad'   => $facultad
            )
        ))->result() )
            return $persona;

        // Docente
        return false;
    }
    return $persona;
}
function generarSlc( $rol, $slc, $consulta, $selected = false ) {
    if ( $consulta && $result = $consulta->result() ) {
        if ( !is_array($slc) && $consulta->num_rows() == 1 )
            $slc = array();
        else if ( !is_array($slc) && $consulta->num_rows() > 1 )
            $slc = array('' => '-----');
        if ( $rol == 1 ) {
            if ( $selected )
                foreach ( $result as $result_ )
                    if ( $result_->id == $selected )
                        $slc['?' . $result_->id] = array( 'value' => "[$result_->id] " . $result_->concepto . (isset($result_->fecha)? date(' d/m/Y', strtotime($result_->fecha)) : ''), 'selected' => 'selected' );
                    else
                        $slc['?' . $result_->id] = "[$result_->id] " . $result_->concepto . (isset($result_->fecha)? date(' d/m/Y', strtotime($result_->fecha)) : '');
            else
                foreach ( $result as $result_ )
                    $slc['?' . $result_->id] = "[$result_->id] " . $result_->concepto  . (isset($result_->fecha)? date(' d/m/Y', strtotime($result_->fecha)) : '');
        } else {
            if ( $selected )
                foreach ( $result as $result_ )
                    if ( $result_->id == $selected )
                        $slc['?' . $result_->id] = array('value' => $result_->concepto  . (isset($result_->fecha)? date(' d/m/Y', strtotime($result_->fecha)) : ''), 'selected' => 'selected');
                    else
                        $slc['?' . $result_->id] = array('value' => $result_->concepto . (isset($result_->fecha)? date(' d/m/Y', strtotime($result_->fecha)) : ''));
            else
                foreach ( $result as $result_ )
                    $slc['?' . $result_->id] = $result_->concepto . (isset($result_->fecha)? date(' d/m/Y', strtotime($result_->fecha)) : '');
        }

    } else if ( !$slc || (sizeof($slc) == 0) )
        $slc    = array('' => '-----');
    return $slc;

}

function form_dropdown_fill( $slc, $consulta, $selected = false ) {
    if ( $consulta && ($result = $consulta->result()) ) {
        if ( !is_array($slc) && $consulta->num_rows() == 1 )
            $slc = array();
        else if ( !is_array($slc) && $consulta->num_rows() > 1 )
            $slc = array('' => '-----');
        foreach ( $result as $result_ )
            $slc['?' . $result_->key]    = $result_->val;
        // if ( $selected && isset( $slc['?' . $selected] ) )
            // $slc['?' . $selected]       = array( 'value' => $slc['?' . $selected], 'selected' => 'selected' );
    } else if ( !$slc || (sizeof($slc) == 0) )
        $slc    = array('' => '-----');
    return $slc;

}

function getDatee($fecha, $avance, $tipo, $habil) {
    // echo $fecha . ' ' . $avance . ' ' . $tipo . br(1);
    $contador = 0;
    if ( $avance < 0 )
        $signo  = -1;
    else
        $signo  = 1;
    $contador   = 0;
    // echo 'ok';
    if ( $tipo == 'hour' ) {
        while ( (24 * $contador) < ($avance * $signo)  ) {
            $fecha  = date ( 'Y-m-j H:i:s' , strtotime ( (24 * $signo) . " hours" , strtotime ($fecha) ));
            if ( ($habil && esFechaHabil($fecha)) || !$habil )
                $contador ++;
        }
    } else if ($tipo == 'day' ) {
        while ( ( $contador ) < ( $avance * $signo )  ) {
            $fecha  = date ( 'Y-m-j' , strtotime ( (1 * $signo) . " day" , strtotime ($fecha) )) . ' 23:59:59';
            if ( ($habil && esFechaHabil($fecha)) || !$habil )
                $contador ++;
        }
    }
    // echo $fecha . br(2);
    return $fecha;
}

function esFechaHabil( $fecha ) {
    // Fines de semana
    if ( in_array(date('w', strtotime($fecha)), array(0, 6) ) )
        return false;

    // Feriados
    $feriados   = array(
        '2019-08-15',                   //Fundación de Asunción
        (date('Y') - 1) . '-12-24',     //Noche buena
        date('Y') . '-12-24',           //Noche buena
        (date('Y') + 1) . '-12-24',     //Noche buena
        (date('Y') - 1) . '-12-25',     //Navidad
        date('Y') . '-12-25',           //Navidad
        (date('Y') + 1) . '-12-25',     //Navidad
        (date('Y') - 1) . '-12-31',     //Fin de año
        date('Y') . '-12-31',           //Fin de año
        (date('Y') + 1) . '-12-31',     //Fin de año
        (date('Y') - 1) . '-01-01',     //Año nuevo
        date('Y') . '-01-01',           //Año nuevo
        (date('Y') + 1) . '-01-01'     //Año nuevo
    );

    // print_r($feriados);

    if ( in_array(date('Y-m-d', strtotime($fecha)), $feriados ) )
        return false;

    return true;
}

function makeUserList( $parametros = false ) {
    if ( !$parametros )
        $parametros = array();
    $ci     =& get_instance();
    $ci->db->join('documentos   as t2', "t2.persona = t1.id AND t2.estado ='V'", 'left');
    $ci->db->join('usuarios     as t3', "t3.usuario = t1.id", 'left');
    if ( $result = $ci->Jesus->dice(array(
        'get'       => 'personas as t1',
        'where'     => array(
            't1.tipo'           => 1,
            't1.estado'         => 'V',
            't3.institucion'    => ( array_key_exists('facultad',   $parametros)  && $parametros['facultad'])?    $parametros['facultad']     : false,
            't3.estado'         => 'V',
        ),
        'where_in'  => array(
            't3.rol'            => ( array_key_exists('rol',        $parametros)  && $parametros['rol'])?         $parametros['rol']          : false,
        ),
        'group_by'  => array('t1.id'),
        'order_by'  => array('t1.nombre' => 'ASC', 't1.apellido' => 'ASC'),
        'select'    => array(
            in_array($ci->sesion['rol'], array(1))?
            "concat('<option value=\'', t2.documento, ' ', t1.nombre, ' ', t1.apellido, ' [', t1.id, ']\'>') as nombres" :
            "concat('<option value=\'', t2.documento, ' ', t1.nombre, ' ', t1.apellido, '\'>') as nombres"),
        ))->result_array() )
        return implode('', array_column($result, 'nombres') );
    return '';
}

function makeStudentList( $parametros = false ) {
    if ( !$parametros )
        $parametros = array();
    $ci     =& get_instance();
    $ci->db->join('documentos       as t2', "t2.persona = t1.id AND t2.estado ='V'", 'left');
    $ci->db->join('estudiantes      as t3', "t3.persona = t1.id", 'left');
    $ci->db->join('carreraDetalles  as t4', "t4.id = t3.carreraDetalle", 'left');
    if ( $result = $ci->Jesus->dice(array(
        'get'       => 'personas as t1',
        'where'     => array(
            't4.facultad'       => ( array_key_exists('facultad',   $parametros)  && $parametros['facultad'])?      $parametros['facultad']     : false,
            't4.carrera'        => ( array_key_exists('carrera',    $parametros)  && $parametros['carrera'])?       $parametros['carrera']      : false,
            't4.sede'           => ( array_key_exists('sede',       $parametros)  && $parametros['sede'])?          $parametros['sede']         : false,
            't4.turno'          => ( array_key_exists('turno',      $parametros)  && $parametros['turno'])?         $parametros['turno']        : false,
            't4.estado'         => 'V',
        ),
        'where_in'  => array(
            't3.tipo'           => ( array_key_exists('tipo',       $parametros)  && $parametros['tipo'])?          $parametros['tipo']         : false,
        ),
        'group_by'  => array('t1.id'),
        'order_by'  => array('t1.nombre' => 'ASC', 't1.apellido' => 'ASC'),
        'select'    => array(
            in_array($ci->sesion['rol'], array(1))?
            "concat('<option value=\'', t2.documento, ', ', t1.nombre, ', ', t1.apellido, ', [', t1.id, ']\'>') as nombres" :
            "concat('<option value=\'', t2.documento, ', ', t1.nombre, ', ', t1.apellido, '\'>') as nombres"),
        ))->result_array() )
        return implode('', array_column($result, 'nombres') );
    return '';
}

function makeTeacherList( $parametros = false ) {
    if ( !$parametros )
        $parametros = array();
    $ci     =& get_instance();
    $ci->db->join('carreraDetalles      as t2', "t2.id = t1.carreraDetalle", 'left');
    $ci->db->join('asignaturaDetalles   as t3', "t3.id = t1.asignaturaDetalle", 'left');
    $ci->db->join('semestres            as t4', "t4.id = t3.semestre", 'left');
    $ci->db->join('docentes             as t5', "t5.periodo = t1.periodo AND t5.inscripcion = t1.id AND t5.estado = 'V'", 'left');
    $ci->db->join('personas             as t6', "t6.id = t5.persona", 'left');
    $ci->db->join('documentos           as t7', "t7.persona = t6.id AND t7.estado ='V'", 'left');
    if ( $result = $ci->Jesus->dice(array(
        'get'       => 'inscripciones as t1',
        'where'     => array(
            't1.periodo'        => ( array_key_exists('periodo',        $parametros)  && $parametros['periodo'])?           $parametros['periodo']          : false,
            't1.estado'         => 'V',
            't2.facultad'       => ( array_key_exists('facultad',       $parametros)  && $parametros['facultad'])?          $parametros['facultad']         : false,
            't2.carrera'        => ( array_key_exists('carrera',        $parametros)  && $parametros['carrera'])?           $parametros['carrera']          : false,
            't2.sede'           => ( array_key_exists('sede',           $parametros)  && $parametros['sede'])?              $parametros['sede']             : false,
            't2.turno'          => ( array_key_exists('turno',          $parametros)  && $parametros['turno'])?             $parametros['turno']            : false,

            't3.curso'          => ( array_key_exists('curso',          $parametros)  && $parametros['curso'])?             $parametros['curso']            : false,
            't3.semestre'       => ( array_key_exists('semestre',       $parametros)  && $parametros['semestre'])?          $parametros['semestre']         : false,
            't3.asignatura'     => ( array_key_exists('asignatura',     $parametros)  && $parametros['asignatura'])?        $parametros['asignatura']       : false,
            't4.tipo'           => ( array_key_exists('tipoSemestre',   $parametros)  && $parametros['semestreTipo'])?      $parametros['semestreTipo']     : false,
        ),
        'where_in'  => array(
            't3.tipo'           => ( array_key_exists('tipo',           $parametros)  && $parametros['tipo'])?              $parametros['tipo']             : false,
        ),
        'group_by'  => array('t6.id'),
        'order_by'  => array('t6.nombre' => 'ASC', 't6.apellido' => 'ASC'),
        'select'    => array(
            in_array($ci->sesion['rol'], array(1))?
            "concat('<option value=\'', t7.documento, ', ', t6.nombre, ', ', t6.apellido, ', [', t6.id, ']\'>') as nombres" :
            "concat('<option value=\'', t7.documento, ', ', t6.nombre, ', ', t6.apellido, '\'>') as nombres"),
        ))->result_array() )
        return implode('', array_column($result, 'nombres') );
    return '';
}
?>