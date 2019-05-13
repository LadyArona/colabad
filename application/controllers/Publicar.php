<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicar extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Publicar Imagem';
    $data['conteudo'] = 'publicar';

    $this->load->view('estrutura/template', $data);
  }
}
