<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliar extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Avaliar Imagem';
    $data['conteudo'] = 'avaliar';

    $this->load->view('estrutura/template', $data);
  }
}
