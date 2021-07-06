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

    // echo 'hola mundo';
    // return;

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
      $this->delete($endpoint);
      /*echo json_encode(array(
        'details' => $this->load->view('entriesDetails', array('date' => $parametros['date']), true)
        // 'details'   => $this->load->view('entriesDetails', array('date' => date("Y-m-d", strtotime($datetime))), true)
      ));*/
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
          'details' => $this->load->view('entriesDetails', array('date' => $parametros['date']), true)
          // 'details'   => $this->load->view('entriesDetails', array('date' => date("Y-m-d", strtotime($datetime))), true)
        ));
        return;
      }
    }

    // Varga de la primera vista
    $this->load->view('entries', array(
      'head'    => $this->load->view('entriesHead', array('date' => $this->sesion['ejercicio'] . date('-m-d')), true),
      'details' => $this->load->view('entriesDetails', array('date' => $this->sesion['ejercicio'] . date('-m-d')), true)
    ));
    return;
  }

  function accountsValidate( $parametros ) {
    $year = date('Y', strtotime($parametros['date']));
    if ( $this->sesion['ejercicio'] != $year ) {
      echo json_encode(array(
        'clases'		=> 'red',
        'html'			=> 'Incoherencia con el ejercicio activo'
      ));
      return false;
    } else if ( $parametros['totalDebe'] != $parametros['totalHaber'] ) {
      echo json_encode(array(
        'clases'		=> 'red',
        'html'			=> 'No cumple la partida dobre'
      ));
      return false;
    } else {
      foreach($parametros['account'] as $key => $val ) {
        $account = explode( " ", $val );
        if ( !$account_ = $this->Jesus->dice(array(
          'get'   => 'cuentas',
          'where' => array(
            'codigo'  => $account[0],
            'estado'  => 'T'
            )
        ))->row_array() ) {
          echo json_encode(array(
            'clases'		=> 'red',
            'html'			=> "No existe la cuenta \"$val\"",
          ));
          return false;
        } else if ( !$account_['imputable'] ) {
          echo json_encode(array(
            'clases'		=> 'red',
            'html'			=> "La cuenta \"$val\" no es imputable",
          ));
          return false;
        }
      }
    }
    return true;
  }

  private function delete($id){
    $this->Jesus->dice(array(
      'update'  => 'asientoDetalles',
      'set'     => array('estado'   => 'D'),
      'where'   => array('asiento_id'  => $id)
    ));
    
    $this->Jesus->dice(array(
      'update'  => 'asientos',
      'set'     => array('estado' => 'D'),
      'where'   => array('id' => $id)
    ));
    
    echo json_encode(array(
      'clases'		=> 'green',
      'html'			=> 'Se elimino exitosamente ' . $id
      // 'details'   => $this->load->view('entriesDetails', array('date' => $parametros['date']), true)
    ));
  }

  private function insert($parametros) {
    $createAt = date('Y-m-d H:i:s');
    $numero = 1;
    if ( $entrie_ = $this->Jesus->dice(array(
      'get' => 'asientos',
      'where' => array(
        'ejercicio_id'  => $this->sesion['ejercicio_id'],
        'estado'        => 'T',
        'numero !='    => NULL
      ),
      'limit'     => 1,
      'order_by'  => array('numero' => 'desc')
    ))->row_array() )
      $numero += $entrie_['numero'];
    $this->Jesus->dice(array('insert' => array('asientos' => array(
      'ejercicio_id'  => $this->sesion['ejercicio_id'],
      'numero'        => $numero,
      'fecha'         => $parametros['date'],
      'descripcion'   => $parametros['descripcion'],
      'totalDebe'     => $parametros['totalDebe'],
      'totalHaber'    => $parametros['totalHaber'],
      'createAt'      => $createAt,
      'estado'        => 'T'
    ))));
    $entrie_id = $this->db->insert_id();
    $contador = 0;
    foreach( $parametros['account'] as $key => $account_value ){
      $contador ++;
      $account_code = explode(' ', $account_value)[0];
      $account_ = $this->Jesus->dice(array(
        'get'     => 'cuentas',
        'where'   => array(
          'codigo'  => $account_code,
          'estado'  => 'T'
        ),
        'select'  => array('id')
      ))->row_array();
      $this->Jesus->dice(array('insert' => array('asientoDetalles' => array(
        'asiento_id'  => $entrie_id,
        'cuenta_id'   => $account_['id'],
        'debe'        => isset($parametros['debe'][$key])?  $parametros['debe'][$key]   : NULL,
        'haber'       => isset($parametros['haber'][$key])? $parametros['haber'][$key]  : NULL,
        'estado'      => 'T'
      ))));
      
    }
    echo json_encode(array(
      'clases'		=> 'green',
      'html'			=> 'Se agrego exitosamente',
      'details'   => $this->load->view('entriesDetails', array('date' => $parametros['date']), true)
    ));
  }

  private function accountSlcMake() {
    $options = array();
    if ( $accounts = $this->Jesus->dice(array(
        'get'       => 'cuentas',
        'where'     => array(
          'estado'    => 'T',
          'imputable' => true
        ),
        'order_by'  => array('codigo' => 'asc'),
    ))->result() )
      foreach($accounts as $accounts_)
        $options[$accounts_->codigo . " " . $accounts_->denominacion] = NULL;
      return $options;
    return $options;
  }
}
?>