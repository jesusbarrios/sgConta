<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Entries extends CI_Controller {

  public $sesion;

  function __construct(){
		parent::__construct();
    if ( !$this->session->userdata('logged_in') )
      redirect('', 'refresh');
    $this->sesion = $this->session->userdata('logged_in');
	}

  function index( $endpoint = false ) {

    

    if ( $parametros = $this->input->post() ) {
      $this->insert($parametros);
      return;
    }
    
    

    if ( $this->input->get() ) {
      // print_r($this->input->get());
      // return;
      if ( $endpoint == 'accounts' ) {
        echo json_encode($this->accountSlcMake());
        return;
      } else if ( $endpoint == 'details' ) {
        // print_r($this->input->get());
        $parametros = $this->input->get();
        // echo $parametros['date'];

        // echo $this->input->post()['date'];
        echo json_encode(array(
          'details' => $this->load->view('entriesDetails', array('date' => $parametros['date']), true)
        ));
        return;
      }
    }

    $this->load->view('entries', array(
      // 'options' => json_encode($this->accountSlcMake()),
      'head'    => $this->load->view('entriesHead', array('date' => $this->sesion['ejercicio'] . date('-m-d')), true),
      'details' => $this->load->view('entriesDetails', array('date' => $this->sesion['ejercicio'] . date('-m-d')), true)
    ));
    return;
  }

  private function insert($parametros) {
    // echo $parametros['date'];
    // print_r($parametros);
    // return;
    $year = date('Y', strtotime($parametros['date']));
    if ( $this->sesion['ejercicio'] != $year )
      echo json_encode(array(
        'clases'		=> 'red',
        'html'			=> 'Incoherencia con el ejercicio activo'
      ));
    else if ( $parametros['totalDebe'] != $parametros['totalHaber'] )
      echo json_encode(array(
        'clases'		=> 'red',
        'html'			=> 'No cumple la partida dobre'
      ));
    else {
      $datetime = date('Y-m-d H:i:s');
      
      $this->Jesus->dice(array('insert' => array('asientos' => array(
        'ejercicio_id'  => $this->sesion['ejercicio_id'],
        'fecha'         => $datetime,
        'descripcion'   => $parametros['descripcion'],
        'totalDebe'     => $parametros['totalDebe'],
        'totalHaber'    => $parametros['totalHaber'],
        'estado'        => 'T'
      ))));
      $entrie_id = $this->db->insert_id();
      
      // print_r($parametros['account']);
      
      foreach( $parametros['account'] as $key => $account_value ){
        $account_code = explode(' ', $account_value)[0];
        $account_ = $this->Jesus->dice(array(
          'get'     => 'cuentas',
          'where'   => array(
            'codigo'  => $account_code,
            'estado'  => 'T'
          ),
          'select'  => array('id')
        ))->row_array();
        // echo $parametros['haber'][$key] . br();
        $this->Jesus->dice(array('insert' => array('asientoDetalles' => array(
          'asiento_id'  => $entrie_id,
          'cuenta_id'   => $account_['id'],
          'debe'        => $parametros['debe'][$key],
          'haber'       => $parametros['haber'][$key],
          'estado'      => 'T'
        ))));

      }
      echo json_encode(array(
        'clases'		=> 'green',
        'html'			=> 'Se agrego exitosamente',
        'details'   => $this->load->view('entriesDetails', array('date' => date("Y-m-d", strtotime($datetime))), true)
      ));
    }
    return;
  }

  private function accountSlcMake() {
    $options = array();
    if ( $accounts = $this->Jesus->dice(array(
        'get'       => 'cuentas',
        'where'     => array(
          'estado'    => 'T',
          'imputable' => 'T'
        ),
        'order_by'  => array('codigo' => 'asc'),
    ))->result() )
      foreach($accounts as $accounts_)
        $options[$accounts_->codigo . " " . $accounts_->denominacion] = NULL;
      return $options;
  }
}
?>