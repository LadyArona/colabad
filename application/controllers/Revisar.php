<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revisar extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Revisar Imagem';
    $data['conteudo'] = 'revisar';

    $this->load->view('estrutura/template', $data);
  }
}
