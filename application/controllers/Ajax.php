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
    if($this->input->post('salvaImagem') == ""){
      $this->load->model('Publicar_model', 'pub');
      $registros = $this->pub->salvaImagem();
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
  }
}
