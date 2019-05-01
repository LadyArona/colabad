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
    $data['conteudo'] = 'verificacao';
    $data['tipo'] = 'EMPTY'; 

    if ($verifica != null) {
      // ERRO ou OK
      $data['tipo'] = $this->email->verifica_email($verifica);
    }

    $this->load->view('acesso/template', $data);
  }

  function redefinir_senha($verifica = null) {

    if ($verifica != null) {
      $result = $this->email->verifica_token($verifica);

      if ($result <= 0) {
        $data['conteudo'] = 'verificacao';
        $data['tipo']     = 'ERRO_REDEF'; 
      } else {
        $data['conteudo'] = 'redefinir';
        $data['tipo']     = $result;
        $data['token']    = $verifica;
      }
      $this->load->view('acesso/template', $data);
    } else {
      redirect(base_url(), 'refresh');
    }

  }

  //function envia_verificacao() {  
    //$this->email->envia_verificacao("loja.anima.animus@gmail.com","13nRGi7UDv4CkE7JHP1o");
    //redirect(base_url(), 'refresh');
  //}
}
?>
