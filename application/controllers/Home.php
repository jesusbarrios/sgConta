<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
  function index($var1 = false) {
    if ( !$var1 || $var1 == 'login')
      
      $elements = array(
        'nav'     => $this->load->view('nav',    array('login' => false), true),
        'body'    => $this->load->view('login',  array(), true)
      );
    else
      $elements = array(
        'nav'     => $this->load->view('nav',     array('login' => true), true),
        'body'    => $this->load->view($var1,    array('company' => $var1), true)
      );
    $this->load->view('container', $elements, false);
  }
}
?>