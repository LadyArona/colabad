<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicar extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index($id = ''){
    $data['title']    = 'Publicar Imagem';
    $data['conteudo'] = 'publicar';
    $data['imgId']    = $id;

    if ($id != '') {
      $data['title']    = 'Revisar Imagem';
    }

    $this->load->view('estrutura/template', $data);
  }
}
