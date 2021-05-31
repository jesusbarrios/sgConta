<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Entries extends CI_Controller {

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

      $this->load->view('entries', array(
        'lista' => $this->load->view('entriesList', false, true)
      ));
  }
}
?>