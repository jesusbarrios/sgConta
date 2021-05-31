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
      if ( $this->input->post() ) {
        echo json_encode(array(
          'clases'		=> 'red',
          'html'			=> 'Falta implementar',
        ));
        return;
      }

      $this->load->view('accounts', array(
        'lista' => $this->load->view('accountsList', false, true)
      ));
  }
}
?>