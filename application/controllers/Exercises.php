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
    /*echo json_encode(array(
      'clases'		=> 'red',
      'html'			=> 'hola mundo',
    ));
    return;*/
    // Empresa
    if ($company_ = $this->Jesus->dice(array(
      'get'       => 'empresas as t1',
      'order_by'  => array('t1.id' => 'desc'),
      'select'    => array('DATE_FORMAT(t1.inicioActividad,	"%Y") as year')
    ))->row_array() )
      $min = $company_['year'];
    else
      $min = date('Y');

      $this->load->view('exercises', array(
        'min'   => $min,
        'max'   => date('Y') + 1,
        'lista' => $this->load->view('exercisesList', false, true)
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

  function userValidate($attr = false ) {
    // Usuario
    $this->db->join('personas as t2', 't2.id = t1.persona_id', 'left');
    $this->db->join('roles as t3', 't3.id = t1.rol_id', 'left');
    if ( $user_ = $this->Jesus->dice(array(
      'get'   => 'usuarios as t1',
      'where' => array(
        't1.password'   => $attr['password'],
        't1.estado'     => 'T',
        't2.documento'  => $attr['user']
      ),
      'select'  => array(
        't1.id as user_id',
        't1.rol_id',
        'DATE_FORMAT(t1.loged_at,	" %d/%c/%Y %T") as loged_at',
        'concat(t2.nombres, " ", t2.apellidos ) as usuario',
        't3.denominacion as rol',
        "FORMAT(t2.documento, 0, 'de_DE') as documento",
      )
    ))->row_array() ) {

      // Sesion data
      $data = array(
        'user_id'   => $user_['user_id'],
        'usuario'   => $user_['usuario'],
        'rol_id'    => $user_['rol_id'],
        'loged_at'  => $user_['loged_at'],
        'rol'       => $user_['rol'],
        'documento' => $user_['documento']
      );

      // Empresa
      $this->db->join('personas as t2', 't2.id = t1.persona_id', 'left');
      if ($company_ = $this->Jesus->dice(array(
        'get'       => 'empresas as t1',
        'order_by'  => array('t1.id' => 'desc'),
        // 'limit'     => 1,
        'select'    => array(
          't1.persona_id',
          'concat_ws(" ", t2.nombres, t2.apellidos) as empresa',
          't2.ruc',
          'DATE_FORMAT(t1.inicioActividad,	" %d/%c/%Y") as inicioActividad',
          'DATE_FORMAT(t2.fechaNacimiento,	" %d/%c/%Y") as constitucion'
        )
      ))->row_array() ) {

        // Sesion data
          $data = array_merge($data, array(
            'empresa'           => $company_['empresa'],
            'ruc'               => $company_['ruc'],
            'inicioActividad'   => $company_['inicioActividad'],
            'constitucion'      => $company_['constitucion']
          ));
        }

        // Update logedAt
      $this->Jesus->dice(array(
        'update'  => 'usuarios',
        'set'     => array('loged_at' => date("Y-m-d H:i:s")),
        'where'   => array('id' => $user_['user_id'])
      ));

      // Sesion data
      $this->session->set_userdata('logged_in', $data);
      return true;
    }
    return false;
  }
}
?>