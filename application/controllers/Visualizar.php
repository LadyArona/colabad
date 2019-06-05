<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visualizar extends CI_Controller {

  public function __construct() {
      parent::__construct();
  }

  public function index(){

  }    

  function projeto($id) {
    $data['title']    = 'Visualização do Projeto';
    $data['conteudo'] = 'proj_visualizar';

    $data['id'] = $id; 

    $this->load->view('estrutura/template', $data);
  }

  function imagem($id = null) {
    $data['title']    = 'Visualização da Imagem';
    $data['conteudo'] = 'img_visualizar';

    $data['id'] = $id;

    $this->load->view('estrutura/template', $data);
  }

  function avaliar($id = null) {
    $data['title']    = 'Avaliar Imagem';
    $data['conteudo'] = 'avaliar_visualizar';

    $data['id'] = $id;

    $this->load->view('estrutura/template', $data);
  }

  function perfil($id = null) {
    $data['id'] = $id;

    $logado = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];

    if ($id == $logado) {
      //carrega com edição
      $data['title']    = 'Meu Perfil';
      $data['conteudo'] = 'perfil';
    } else {
      //carrega visualizacao
      $data['title']    = 'Visualizar Perfil';
      $data['conteudo'] = 'perfil_visualizar';
    }

    $this->load->view('estrutura/template', $data);
  }
}
?>
