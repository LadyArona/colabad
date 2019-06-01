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

  function buscarProjeto(){
    if($this->input->post('buscarProjeto') == ""){
      $this->load->model('Projetos_model', 'proj');
      $limit = $this->input->post('limit');
      $registros = $this->proj->buscarProjeto($limit);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
  }  

  function carregarProjeto(){
    if($this->input->post('carregarProjeto') == ""){
      $this->load->model('Projetos_model', 'proj');
      $id        = $this->input->post('id');
      $registros = $this->proj->carregarProjeto($id);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
  }  
  
  function carregarProjetoVisualizar(){
    if($this->input->post('carregarProjetoVisualizar') == ""){
      $this->load->model('Projetos_model', 'proj');
      $id        = $this->input->post('id');
      $registros = $this->proj->carregarProjetoVisualizar($id);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
  }  

  function salvaImagem(){
    $this->load->model('Imagem_model', 'img');
    
    $titulo    = $this->input->post('titulo');
    $descricao = $this->input->post('descricao');
    $projeto   = $this->input->post('projeto');

    $registros = $this->img->salvaImagem($_FILES['imagem'], $titulo, $descricao, $projeto);
    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($registros));
  }
  
  function carregarPerfil(){
    if($this->input->post('carregarPerfil') == ""){
      $this->load->model('Perfil_model', 'perf');
      $registros = $this->perf->carregarPerfil();
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
  }  

  function salvarPerfil(){
    $this->load->model('Perfil_model', 'perf');

    $imagem = null;
    if (isset($_FILES['imagem'])) {
      if (array_key_exists('imagem', $_FILES)) {
        $imagem = $_FILES['imagem'];
      }
    }

    $edNome           = $this->input->post('edNome');
    $edEmail          = $this->input->post('edEmail');
    $edPass           = $this->input->post('edPass');
    $edAudiodescricao = $this->input->post('edAudiodescricao');
    $cbEstado         = $this->input->post('cbEstado');
    $cbCidade         = $this->input->post('cbCidade');
    $edOrg            = $this->input->post('edOrg');
    $cbDefic          = $this->input->post('cbDefic');
    $cbQual           = $this->input->post('cbQual');
    $edObs            = $this->input->post('edObs');

    $registros = $this->perf->salvarPerfil($imagem, $edNome, $edEmail, $edPass, $edAudiodescricao, $cbEstado, $cbCidade, $edOrg, $cbDefic, $cbQual, $edObs);
    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($registros));
  }
  
  function carregarImagemVisualizar(){
    if($this->input->post('carregarImagemVisualizar') == ""){
      $this->load->model('Imagem_model', 'img');
      $id        = $this->input->post('id');
      $registros = $this->img->carregarImagemVisualizar($id);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
  }  

  function salvarProjeto(){
    if($this->input->post('salvarProjeto') == ""){
      $this->load->model('Projetos_model', 'proj');
      $form   = $this->input->post('form');
      $participantes = $this->input->post('participantes');
      $result = $this->proj->salvarProjeto($form, $participantes);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($result));
    }
  }

}
