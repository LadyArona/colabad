<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
  public function __construct() {
    parent::__construct();     
  }

  function _remap($method){
    if (method_exists($this, $method) && $_SERVER['REQUEST_METHOD'] == 'POST'){
      $this->$method();
    }else {
      $this->index($method);
    }
  }

  function salvaImagem(){
    $this->load->model('Publicar_model', 'pub');
    
    $titulo    = $this->input->post('titulo');
    $descricao = $this->input->post('descricao');

    $registros = $this->pub->salvaImagem($_FILES['imagem'], $titulo, $descricao);
    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($registros));
  }
}
