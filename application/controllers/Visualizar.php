<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visualizar extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){

  }    

  function projeto($id) {
    //testa se é privado e se a pessoa faz parte do projeto
    if ($this->testaProjeto($id)) {
      redirect(base_url('painel'), 'refresh');
    }

    $data['title']    = 'Visualização do Projeto';
    $data['conteudo'] = 'proj_visualizar';

    $data['id'] = $id; 

    $this->load->view('estrutura/template', $data);
  }

  private function testaProjeto($id, $img = null) {
    if ($img != null) {
      $query = $this->db->get_where('img_cadastro', array('IMG_ID' => $img));
      $id = $query->result()[0]->PROJ_ID;
    }

    $query = $this->db->get_where('proj_cadastro', array('PROJ_ID' => $id));

    if ($query->result()[0]->PROJ_PRIVADO > 0) {
      $query = $this->db->get_where('proj_participantes', array('PROJ_ID' => $id, 'USU_ID' => $this->session->userdata('logged_in_colabad')['sesColabad_vId']));

      if ($query->num_rows() <= 0) {
        return true;
      }
    }

    return false;
  }

  function imagem($id = null) {
    //testa se é privado e se a pessoa faz parte do projeto
    if ($this->testaProjeto(null, $id)) {
      redirect(base_url('painel'), 'refresh');
    }

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
