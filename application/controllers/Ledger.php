<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ledger extends CI_Controller {
  public $sesion;
  function __construct(){
		parent::__construct();
    if ( !$this->session->userdata('logged_in') )
      redirect('', 'refresh');
    $this->sesion = $this->session->userdata('logged_in');
    $this->db->query("SET lc_time_names = 'es_ES'");
	}

  function index( $endpoint = false ) {
    // Reporte
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
          'details' => $this->load->view('ledgerDetails', array(
            'since'         => $parametros['since'],
            'until'         => $parametros['until'],
            'cuentas'       => isset($parametros['cuentas'])? $parametros['cuentas'] : false,
            'ejercicio_id'  => $this->sesion['ejercicio_id'],
            'ejercicio'     => $this->sesion['ejercicio']
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
          'details' => $this->load->view('ledgerDetails', array('date' => $parametros['date']), true)
          // 'details'   => $this->load->view('entriesDetails', array('date' => date("Y-m-d", strtotime($datetime))), true)
        ));
        return;
      }
    }

    //Si el ejercicio activo coincide con el año actual toma la fecha actual.
    if ( $this->sesion['ejercicio'] == date('Y') )
      $data = array(
        'since'         => date('Y-m-d'),
        'until'         => date('Y-m-d'),
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
    $this->load->view('ledger', array(
      'head'    => $this->load->view('ledgerHead', $data, true),
      'details' => $this->load->view('ledgerDetails', array_merge($data, array('cuentas' => false)), true)
    ));
    return;
  }
}
?>