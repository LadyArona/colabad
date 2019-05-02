<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Termos extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Termos de Uso';
    $data['conteudo'] = 'termos';

    $this->load->view('acesso/template', $data);
  }
}
