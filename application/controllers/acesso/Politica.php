<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Politica extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Politica de Privacidade';
    $data['conteudo'] = 'politica';

    $this->load->view('acesso/template', $data);
  }
}
