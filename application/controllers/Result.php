<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Result extends CI_Controller {

  public $sesion;

  function __construct(){
		parent::__construct();
    if ( !$this->session->userdata('logged_in') )
      redirect('', 'refresh');
    $this->sesion = $this->session->userdata('logged_in');
    $this->db->query("SET lc_time_names = 'es_ES'");
	}

  function index( $endpoint = false ) {
    // Generación de reportes
    if ( $this->input->get() ) {
      $parametros = $this->input->get();
      echo json_encode(array(
        'clases'		      => 'green',
        'html'			      => 'Reporte generado',
        'details'         => $this->load->view('resultDetails', array(
          'until'           => $parametros['until'],
          'ejercicio_id'    => $this->sesion['ejercicio_id'],
          'ejercicio'       => $this->sesion['ejercicio']
        ), true)
      ));
      return;
    }

    // Registrar en la base de datos
    if ( $parametros = $this->input->post() ) {
      $this->accountsValidate( $parametros );
      $this->insert($parametros);
      return;
    }

    // Consulta de datos
    if ( $this->input->get() ) {
      if ( $endpoint == 'accounts' ) {
        echo json_encode($this->accountSlcMake());
        return;
      } else if ( $endpoint == 'details' ) {
        $parametros = $this->input->get();
        echo json_encode(array(
          'details' => $this->load->view($_SERVER["REQUEST_URI"] . 'Details', array('date' => $parametros['date']), true)
        ));
        return;
      }
    }

    //Si el ejercicio activo coincide con el año actual toma la fecha actual.
    if ( $this->sesion['ejercicio'] == date('Y') )
      $data = array(
        'ejercicio_id'    => $this->sesion['ejercicio_id'],
        'ejercicio'       => $this->sesion['ejercicio'],
        'until'           => date('Y-m-d')
      );
    else
      $data = array(
        'ejercicio_id'    => $this->sesion['ejercicio_id'],
        'ejercicio'       => $this->sesion['ejercicio'],
        'until'           => $this->sesion['ejercicio'] . '-12-31'
      );
    $this->load->view($_SERVER["REQUEST_URI"], array(
      'head'    => $this->load->view($_SERVER["REQUEST_URI"] . 'Head', $data, true),
      'details' => $this->load->view($_SERVER["REQUEST_URI"] . 'Details', $data, true)
    ));
    return;
  }
}
?>