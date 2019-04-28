<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emails extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->model('Email_model', 'email');
  }

  public function index(){

  }    

  function verificar_email($verifica = null) {
    if ($verifica == null) {
      //envia para página de erro
    } else {
      $registro = $this->Emails_model->verifica_email($verifica);

      if ($registro > 0){
        $msg = array('success' => "Email Verified Successfully!"); 
        //Envia para página de sucesso
      } else {
        $msg = array('error'   => "Sorry Unable to Verify Your Email!"); 
        //envia para página de erro
      }

      $data['msg'] = $msg; 
    }
    //$this->load->view('index.php', $data);
  }

  //function envia_verificacao() {  
    //$this->email->envia_verificacao("loja.anima.animus@gmail.com","13nRGi7UDv4CkE7JHP1o");
    //redirect(base_url(), 'refresh');
  //}
}
?>
