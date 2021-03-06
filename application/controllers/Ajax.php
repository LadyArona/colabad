<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
  public function __construct() {
    parent::__construct();
  }

  function buscarProjeto(){
    if($this->input->post('buscarProjeto') == ""){
      $this->load->model('Projetos_model', 'proj');
      $limit    = ($this->input->post('limit') == "") ? 0 : $this->input->post('limit');

      $registros = $this->proj->buscarProjeto($limit);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
  }  

  function buscarProjetoPublico(){
    if($this->input->post('buscarProjetoPublico') == ""){
      $this->load->model('Projetos_model', 'proj');
      $page  = ($this->input->post('page') == "")  ? 1 : $this->input->post('page');
      $registros = $this->proj->buscarProjetoPublico($page);
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
      $id   = $this->input->post('id');
      $registros = $this->perf->carregarPerfil($id);
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
    $rbPerfil         = $this->input->post('rbPerfil');

    $registros = $this->perf->salvarPerfil($imagem, $edNome, $edEmail, $edPass, $edAudiodescricao, $cbEstado, $cbCidade, $edOrg, $cbDefic, $cbQual, $edObs, $rbPerfil);
    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($registros));
  }
  
  function avaliarImagem(){
    if($this->input->post('avaliarImagem') == ""){
      $this->load->model('Avaliar_model', 'aval');
      $tipo      = $this->input->post('tipo');
      $obs       = $this->input->post('obs');
      $descr     = $this->input->post('descr');
      $imgId     = $this->input->post('imgId');
      $registros = $this->aval->avaliarImagem($imgId, $tipo, $obs, $descr);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
  }    

  function revisarImagem(){
    if($this->input->post('revisarImagem') == ""){
      $this->load->model('Revisar_model', 'aval');
      $form      = $this->input->post('form');
      $imgId     = $this->input->post('imgId');
      $registros = $this->aval->revisarImagem($form, $imgId);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($registros));
    }
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

  function emailSuporte(){
    if($this->input->post('emailSuporte') == ""){
      $this->load->model('Email_model', 'email');
      $form   = $this->input->post('form');
      $result = $this->email->emailSuporte($form);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($result));
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

  function carregarAvaliar(){
    if($this->input->post('carregarAvaliar') == ""){
      $this->load->model('Avaliar_model', 'aval');
      $result = $this->aval->carregarAvaliar();
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($result));
    }
  }

  function carregarRevisar(){
    if($this->input->post('carregarRevisar') == ""){
      $this->load->model('Revisar_model', 'rev');
      $result = $this->rev->carregarRevisar();
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($result));
    }
  }

  function carregarPesquisar(){
    if($this->input->post('carregarPesquisar') == ""){
      $this->load->model('Pesquisar_model', 'pesq');
      $pesquisa = $this->input->post('pesquisa');
      $result = $this->pesq->carregarPesquisar($pesquisa);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($result));
    }
  }

}
