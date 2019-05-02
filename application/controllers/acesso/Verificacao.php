<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verificacao extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Mensagem';
    $data['conteudo'] = 'verificacao';

    $data['tipo'] = 'PERMISSAO';

    $this->load->view('acesso/template', $data);
  }
}
