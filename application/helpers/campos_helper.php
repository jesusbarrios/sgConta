<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('format_date'))
{
    function format_date ($fecha, $hr = false, $seg = false) {
        if ( $fecha ) {
        	if( $hr ) {
        		if($seg)
        			return date('d/m/Y H:i:s', strtotime($fecha));
        		else
	        		return date('d/m/Y H:i', strtotime($fecha));
        	}else
	        	return date('d/m/Y', strtotime($fecha));

        } else 
        	return  "<span title='Indefinido'>-----</span>";
    }
}

	// function generar_slcPeriodo($backend = false, $frontEnd = true, $persona = false, $periodo = false, $facultad = false){
	function generar_SlcPeriodo($parametros = false) {

		// $this->db->join('carreraDetalles as t2',	't2.id = t1.carreraDetalle', 'left');
		// $this->db->join('asignaturaDetalles as t3',	't3.id = t1.asignaturaDetalle', 'left');
		// $this->db->join('semestres as t4',			't4.id = t3.semestre', 'left');

		/*if(isset($parametros['docente']))
			$this->db->join('docentes 	as t5',	't5.periodo = t1.periodo AND t5.inscripcion = t1.inscripcion', 'left');

		$inscripciones 	= Jesus->dice(array(
			'get'		=> 'inscripciones as t1',
			'where'		=> array(
				't1.periodo'			=> isset($parametros['periodo'])? 			$parametros['periodo'] 				: false,
				't1.carreraDetalle'		=> isset($parametros['carreraDetalle'])? 	$parametros['carreraDetalle'] 		: false,
				't1.asignaturaDetalle'	=> isset($parametros['asignaturaDetalle'])?	$parametros['asignaturaDetalle'] 	: false,
				't1.estado'				=> 'V',

				't2.facultad'			=> isset($parametros['facultad'])? 			$parametros['facultad']				: false,
				't2.carrera'			=> isset($parametros['carrera'])? 			$parametros['carrera'] 				: false,
				't2.sede'				=> isset($parametros['sede'])? 				$parametros['sede'] 				: false,
				't2.turno'				=> isset($parametros['turno'])? 			$parametros['turno'] 				: false,

				't3.asignatura'			=> isset($parametros['asignatura'])? 		$parametros['asignatura'] 			: false,
				't3.curso'				=> isset($parametros['curso'])?	 			$parametros['curso'] 				: false,
				't3.semestre'			=> isset($parametros['semestre'])? 			$parametros['semestre'] 			: false,
				't4.base'				=> isset($parametros['paridad'])? 			$parametros['paridad'] 				: false,
			),
			'select'	=> array(
				't1.periodo',
			),
		));

		if($inscripciones->result()) {
			$slc		= array();
			if($inscripciones->num_rows() > 1 )
				$slc['']	= '-----';
			foreach ($inscripciones->result() as $inscripciones_) {
				$slc[ '?' . $inscripciones_->periodo ]	= $inscripciones_->periodo;
			}
		} else 	$slc['']	= '-----';

		return $slc;*/



		/*
		$this->db->join('carreraDetalles as t2', 't2.carrera = t1.carrera AND t2.id = t1.carreraDetalle', 'left');
		if($persona)
			$this->db->join('docentes as t4', 't4.carrera = t1.carrera AND t4.carreraDetalle = t1.carreraDetalle AND t4.asignatura = t1.asignatura AND t4.grupo = t1.grupo AND t4.periodoAlta <= t1.periodo', 'left');
		$consulta = $this->Jesus->dice(array(
			'get'		=> 'inscripciones as t1',
			'where'	=> array(
			 	't1.periodo'	=> $periodo,
			 	't1.estado'		=> 'V',
			 	't2.facultad'	=> $facultad? $facultad : false,
			 	't2.estado'		=> 'V',
			 	't4.persona'	=> $persona?	$persona	: false,
			 	't4.estado'		=> $persona?	'V'			: false,
			 ),
			'limit'		=> in_array($this->sesion['rol'], array(1, 3))? false : array(1),// linea de codigo temporal, hasta que funcione el control de fechas
			'group_by'	=> array('t1.periodo'),
			'order_by'	=> array('t1.periodo' => 'desc'),
			'select'	=> array('t1.periodo as id', 't1.periodo as concepto'),
			));
		$slc = $this->generarSlc(true, $slc, $consulta);
		if(!$this->input->post('slcPeriodo') || sizeof($slc) == 1)
			list($periodo)	= str_replace('?', '', each($slc));
		return array_merge(array('slcPeriodo' => $slc), $this->generarSlcFacultad(true, $frontEnd, $persona, $periodo, $facultad));*/
	}