<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Diarybook extends CI_Controller {
  public $sesion;
  function __construct(){
		parent::__construct();
    if ( !$this->session->userdata('logged_in') )
      redirect('', 'refresh');
    $this->sesion = $this->session->userdata('logged_in');
    $this->db->query("SET lc_time_names = 'es_ES'");
	}

  function index( $endpoint = false ) {
    if ( $this->input->get() ) {
      $parametros = $this->input->get();
      if ( $parametros['since'] > $parametros['until'])
        echo json_encode(array(
          'clases'		=> 'red',
          'html'			=> 'Fechas incoherentes'
        ));
      else
        echo json_encode(array(
          'clases'		=> 'green',
          'html'			=> 'Reporte generado',
          'details' => $this->load->view('diarybookDetails', array(
            'since'         => $parametros['since'],
            'until'         => $parametros['until'],
            'ejercicio_id'  => $this->sesion['ejercicio_id'],
            'ejercicio'     => $this->sesion['ejercicio']
          ), true)
        ));
      return;
    }
    //Si el ejercicio activo coincide con el año actual toma la fecha actual.
    if ( $this->sesion['ejercicio'] == date('Y') )
      $data = array(
        'since' => date('Y-m-d'),
        'until' => date('Y-m-d'),
        'ejercicio_id'  => $this->sesion['ejercicio_id'],
        'ejercicio'     => $this->sesion['ejercicio']
      );
    else
      $data = array(
        'since'         => $this->sesion['ejercicio'] . '-01-01',
        'until'         => $this->sesion['ejercicio'] . '-12-31',
        'ejercicio_id'  => $this->sesion['ejercicio_id'],
        'ejercicio'     => $this->sesion['ejercicio']
      );

    $this->load->view('diarybook', array(
      'titulo'  => 'Libro diario',
      'head'    => $this->load->view('diarybookHead', $data, true),
      'details' => $this->load->view('diarybookDetails', $data, true)
    ));
    return;
  }
}
?>