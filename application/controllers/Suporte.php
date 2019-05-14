<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suporte extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Suporte';
    $data['conteudo'] = 'suporte';

    $this->load->view('estrutura/template', $data);
  }
}
