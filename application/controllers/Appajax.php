<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appajax extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('App_model', 'app');
  }

  public function index(){
    redirect(base_url());
  }
  
  function _remap($method){
    if (method_exists($this, $method) && $_SERVER['REQUEST_METHOD'] == 'POST'){
      $this->$method();
    }else {
      $this->index($method);
    }
  }

  /*Funções para as notificações*/
  function buscaNotificacoes(){
    if($this->input->post('Notificacoes') == ""){
      $dados = $this->app->buscaNotificacoes();
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($dados));
    }
  }

  function atualizaStatusNotificacao(){
    if($this->input->post('Notificacao') == ""){
      $codNotificacao = $this->input->post('codNotificacao');
      $lerNaoler      = $this->input->post('lerNaoler');
      $excluir        = $this->input->post('excluir');
      $result         = $this->app->atualizaStatusNotificacao($codNotificacao, $lerNaoler, $excluir);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode(($result > 0) ? array("result" => "OK") : array("result" => "")));
    } 
  }
  /*Funções para as notificações*/

    
  /*-- Função para buscar os dados dos combos padrões --*/   
  function carregaDadosCombo(){
    if($this->input->post('CarregaDadosCombo') == ""){
      $tipoInfo     = $this->input->post('tipoInfo');
      $codToControl = $this->input->post('codToControl');
      $dados        = $this->app->buscaDadosCombo($tipoInfo, $codToControl);
      $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($dados));
    }
  }

  function carregaDadosComboOpt(){

      if($this->input->post('CarregaDadosComboOpt') == ""){
          $tipoInfo     = $this->input->post('tipoInfo');
          $codToControl = $this->input->post('codToControl');
          $dados        = $this->app->buscaDadosComboOpt($tipoInfo, $codToControl);
          $this->output
               ->set_content_type('application/json')
               ->set_output(json_encode($dados));
      }
  }

}
