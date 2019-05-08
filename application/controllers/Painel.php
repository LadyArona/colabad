<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Painel';
    $data['conteudo'] = 'painel';

    $this->load->view('estrutura/template', $data);
  }
}
