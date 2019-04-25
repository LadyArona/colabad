<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emails extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->model('Emails_model', 'Emails_model');
  }

  public function index(){
      redirect(base_url().'login');
  }    
  
  function _remap($method){
    if (method_exists($this, $method) && $_SERVER['REQUEST_METHOD'] == 'POST'){
      $this->$method();
    }else {
      $this->index($method);
    }
  }

  function verificar_email($verifica = null) {  
    $registro = $this->Emails_model->verifica_email($verifica);

    if ($registro > 0){
      $msg = array('success' => "Email Verified Successfully!"); 
    } else {
      $msg = array('error'   => "Sorry Unable to Verify Your Email!"); 
    }

    $data['msg'] = $msg; 
    $this->load->view('index.php', $data);
  }

  function envia_verificacao() {  
    $this->Emails_model->envia_verificacao("yashwantchavan@technicalkeeda.com","13nRGi7UDv4CkE7JHP1o");
    $this->load->view('index.php', $data);   
  } 
}
?>
