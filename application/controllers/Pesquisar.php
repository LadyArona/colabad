<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesquisar extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  function _remap($method){
    if (method_exists($this, $method) && $_SERVER['REQUEST_METHOD'] == 'GET'){
      $this->$method();
    }else {
      $this->index($method);
    }
  }

  public function index(){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      if ($this->input->get('por') != '') {
        $data['pesquisa'] = $this->input->get('por');
      } else {
        redirect(base_url('painel'), 'refresh');
      }
    } else {
      redirect(base_url('painel'), 'refresh');
    }

    $data['title']    = 'Pesquisar';
    $data['conteudo'] = 'pesquisar';

    $this->load->view('estrutura/template', $data);
  }
}
