<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginajax extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('acesso/Login_model', 'login');
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

  function salvarCadastro(){
    if($this->input->post('SalvaCadastro') == ""){
        $form   = $this->input->post('Form');
        $result = $this->login->salvarCadastro($form);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($result));
    }
  }
  
  function esqueceuSenha(){
    if($this->input->post('esqueceuSenha') == ""){
        $form   = $this->input->post('Form');
        $result = $this->login->esqueceuSenha($form);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($result));
    }
  }  
  
  function mudarSenha(){
    if($this->input->post('mudarSenha') == ""){
        $form   = $this->input->post('Form');
        $result = $this->login->mudarSenha($form);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($result));
    }
  }

  function verificarEmail(){
    if($this->input->post('SalvaCadastro') == ""){
        $email  = $this->input->post('email');
        $result = $this->login->verificarEmail($email);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($result));
    }
  }

  function login(){
    if($this->input->post('Login') == ""){
        $form   = $this->input->post('Form');
        $result = $this->login->login($form);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($result));
    }
  }  

}
