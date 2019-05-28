<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projetos extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Projetos';
    $data['conteudo'] = 'projetos';

    $this->load->view('estrutura/template', $data);
  }
}
