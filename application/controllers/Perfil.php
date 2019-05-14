<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Perfil';
    $data['conteudo'] = 'perfil';

    $this->load->view('estrutura/template', $data);
  }
}
