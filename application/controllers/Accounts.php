<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accounts extends CI_Controller {

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
      'min' => $min,
      'max' => date('Y') + 1
    );

    if ( $this->input->post() ) {

      if ( $this->input->post('action') == 'add' || $this->input->post('action') == 'save' )
        $this->save();
      else if ( $this->input->post('action') == 'delete' )
        $this->delete();
      else if ( $this->input->post('action') == 'edit' ) {
        $ejercicio = $this->Jesus->dice(array(
          'get'   => 'cuentas',
          'where' => array('id' => $this->input->post('value'))
        ))->row_array();
        echo json_encode(array(
          'clases'		=> 'blue-grey darken-1',
          'html'			=> "Listo para modificar",
          'head'   => $this->load->view('accountsHead', array_merge( $param, $ejercicio), true)
        ));
      }else if ( $this->input->post('action') == 'btnNew') {
        echo json_encode(array(
          'clases'		=> 'blue-grey darken-1',
          'html'			=> "Listo para agregar",
          'head'   => $this->load->view('accountsHead', $param, true)
        ));
      }
      return;
    }

    $this->load->view('accounts', array(
        'head'    => $this->load->view('accountsHead', $param, true),
        'details' => $this->load->view('accountsDetails', false, true)
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

  function delete() {
    // echo 'en delete';
    // return;
    $this->Jesus->dice(array(
      'update'  => 'cuentas',
      'set'     => array('estado' => 'D'),
      'where'   => array('id' => $this->input->post('value'))
    ));
    echo json_encode(array(
      'clases'		=> 'green',
      'html'			=> 'Se elimino exitosamente',
      'details'   => $this->load->view('accountsDetails', false, true)
    ));
    return true;
  }
  private function save() {

    $id           = $this->input->post('id');
    $denominacion = $this->input->post('denominacion');
    $codigo       = $this->input->post('codigo');
    $imputable    = (bool) $this->input->post('imputable');
    if ( !$this->checkExistence( $denominacion, $codigo, $id))
      return false;
    // Update
    if ( $id ) {
      if ( $this->Jesus->dice(array(
        'get' => 'cuentas',
        'where' => array(
          'id'      => $id,
          'estado'  => 'T'
        )
      ))->result() ) {
        $this->Jesus->dice(array(
          'update'    => 'cuentas',
          'set'       => array(
            'denominacion'  => $denominacion,
            'codigo'        => $codigo,
            'imputable'     => $imputable? 1 : 0
          ),
          'where'   => array('id' => $id)
        ));
        echo json_encode(array(
          'clases'		=> 'green',
          'html'			=> 'Se actualizo exitosamente -' . $imputable . '-',
          'details'   => $this->load->view('accountsDetails', false, true)
        ));
      } else
        echo json_encode(array(
          'clases'		=> 'red',
          'html'			=> 'La cuenta fue eliminado',
          'details'   => $this->load->view('accountsDetails', false, true)
        ));
    // Insert
    } else {
      $this->Jesus->dice(array('insert' => array('cuentas' => array(
        'denominacion'  => $denominacion,
        'codigo'        => $codigo,
        'imputable'     => $imputable,
        'estado'        => 'T'
      ))));
      echo json_encode(array(
        'clases'		=> 'green',
        'html'			=> 'Se guardo exitosamente',
        'details'   => $this->load->view('accountsDetails', false, true)
      ));
    }
    
    return true;
  }

    private function checkExistence( $denominacion, $codigo, $id = false ) {
    // Denominacion
    if ( $this->Jesus->dice(array(
      'get'   => 'cuentas',
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
    // codigo
    if ( $this->Jesus->dice(array(
      'get'   => 'cuentas',
      'where' => array(
        'codigo'  => $codigo,
        'estado'  => 'T'
      ),
      'where_not_in'  => array('id' => $id)
    ))->result() ) {
      echo json_encode(array(
        'clases'		=> 'red',
        'html'			=> 'El código ya existe',
      ));
      return false;
    }

    return true;
  }
}
?>