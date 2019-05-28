<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    if ($this->session->userdata('logged_in_colabad') != null) {
      redirect(base_url().'painel');
    }

    $data['title']    = 'Login';
    $data['conteudo'] = 'login';

    $this->load->view('acesso/template', $data);
  }
}
