<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicar extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['msg'] = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $cpf          = $this->input->post('cpf');
      $curriculo    = $_FILES['curriculo'];
      $configuracao = array(
          'upload_path'   => './curriculos/',
          'allowed_types' => 'jpg',
          'file_name'     => $cpf.'.jpg',
          'max_size'      => '50000'
      );      
      $this->load->library('upload');
      $this->upload->initialize($configuracao);
      if ($this->upload->do_upload('curriculo'))
          $data['msg'] = 'Arquivo salvo com sucesso.';
      else
          $data['msg'] = $this->upload->display_errors();
    }

    $data['title']    = 'Publicar';
    $data['conteudo'] = 'publicar';

    $data['breadcrumbs'] = array($data['conteudo'] => $data['title']);

    $this->load->view('estrutura/template', $data);
  }
}
