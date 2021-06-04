<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exercises extends CI_Controller {

  public $sesion;

  function __construct(){
		parent::__construct();
    if ( !$this->session->userdata('logged_in') )
      redirect('', 'refresh');
    $this->sesion = $this->session->userdata('logged_in');
	}

  function index() {
    // Empresa
    if ($company_ = $this->Jesus->dice(array(
      'get'       => 'empresas as t1',
      'order_by'  => array('t1.id' => 'desc'),
      'select'    => array('DATE_FORMAT(t1.inicioActividad,	"%Y") as year')
    ))->row_array() )
      $min = $company_['year'];
    else
      $min = date('Y');
    $param = array(
      'id'  => false,
      'min' => $min,
      'max' => date('Y') + 1
    );

    if ( $this->input->post() ) {
      if ( $this->input->post('action') == 'add' || $this->input->post('action') == 'save')
        $this->save();
      else if ( $this->input->post('action') == 'delete')
        $this->delete();
      else if ( $this->input->post('action') == 'edit') {
        $ejercicio = $this->Jesus->dice(array(
          'get'   => 'ejercicios',
          'where' => array('id' => $this->input->post('value'))
        ))->row_array();
        echo json_encode(array(
          'clases'		=> 'blue-grey darken-1',
          'html'			=> "Listo para modificar",
          'head'   => $this->load->view('exercisesHead', array_merge( $param, $ejercicio), true)
        ));
      }else if ( $this->input->post('action') == 'btnNew') {
        echo json_encode(array(
          'clases'		=> 'blue-grey darken-1',
          'html'			=> "Listo para agregar",
          'head'   => $this->load->view('exercisesHead', $param, true)
        ));
      }
      return;
    }

    $this->load->view('exercises', array(
        'head'    => $this->load->view('exercisesHead', $param, true),
        'details' => $this->load->view('exercisesDetails', false, true)
      ));

      return;

    if ( $this->session->userdata('logged_in') ) {
      $this->load->view('home', false, false);
    } else {
      $attr = $this->input->post();
      if ( array_key_exists('user', $attr) ) {
        if ( $this->userValidate($attr) )
          echo true;
        else
          echo false;
        return;
      }
      
    }
  }

  private function delete() {
    $this->Jesus->dice(array(
      'update'  => 'ejercicios',
      'set'     => array('estado' => 'D'),
      'where'   => array('id' => $this->input->post('value'))
    ));
    echo json_encode(array(
      'clases'		=> 'green',
      'html'			=> 'Se elimino exitosamente',
      'details'   => $this->load->view('exercisesDetails', false, true)
    ));
    return true;
  }
  private function save() {
    $id           = $this->input->post('id');
    $year         = $this->input->post('year');
    $denominacion = $this->input->post('denominacion');
    $activo       = $this->input->post('activo');
    if ( !$this->checkExistence( $year, $denominacion, $id))
      return false;
    
    if ( $activo )
      $this->Jesus->dice(array(
        'update'  => 'ejercicios',
        'set'     => array('activo' => 0)
      ));
    // Update
    if ( $id ) {
      if ( $this->Jesus->dice(array(
        'get' => 'ejercicios',
        'where' => array(
          'id'      => $id,
          'estado'  => 'T'
        )
      ))->result() ) {
        $this->Jesus->dice(array(
          'update'    => 'ejercicios',
          'set'       => array(
            'anho'          => $year,
            'denominacion'  => $denominacion,
            'activo'        => $activo? 1 : 0
          ),
          'where'   => array('id' => $id)
        ));
        echo json_encode(array(
          'clases'		=> 'green',
          'html'			=> 'Se actualizo exitosamente',
          'details'   => $this->load->view('exercisesDetails', false, true)
        ));
      } else
        echo json_encode(array(
          'clases'		=> 'red',
          'html'			=> 'El ejercicio contable fue eliminado',
          'details'   => $this->load->view('exercisesDetails', false, true)
        ));
    // Insert
    } else {
      $this->Jesus->dice(array('insert' => array('ejercicios' => array(
        'anho'          => $year,
        'denominacion'  => $denominacion,
        'activo'        => $activo? 1 : 0,
        'estado'        => 'T'
      ))));
      $id = $this->db->insert_id();
      echo json_encode(array(
        'clases'		=> 'green',
        'html'			=> 'Se guardo exitosamente',
        'details'   => $this->load->view('exercisesDetails', false, true)
      ));
    }
    if ( $activo )
      $this->session->set_userdata('logged_in', array_replace(
        $this->sesion,
        array(
          'ejercicio'     => $year,
          'ejercicio_id'  => $id
        )
      ));
    return true;
  }

  private function checkExistence( $year, $denominacion, $id = false ) {
    // Año
    if ( $this->Jesus->dice(array(
      'get'   => 'ejercicios',
      'where' => array(
        'anho'    => $year,
        'estado'  => 'T'
      ),
      'where_not_in'  => array('id' => $id)
    ))->result() ) {
      echo json_encode(array(
        'clases'		=> 'red',
        'html'			=> 'El año ya existe',
      ));
      return false;
    }

    // Denominacion
    if ( $this->Jesus->dice(array(
      'get'   => 'ejercicios',
      'where' => array(
        'denominacion'  => $denominacion,
        'estado'        => 'T'
      ),
      'where_not_in'  => array('id' => $id)
    ))->result() ) {
      echo json_encode(array(
        'clases'		=> 'red',
        'html'			=> 'La denominación ya existe',
      ));
      return false;
    }
    return true;
  }
}
?>