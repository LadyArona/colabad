<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Termos extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $usu = '';
    if ($this->session->userdata('logged_in_colabad') != null) {
      $usu = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];
    }

    //se o usuário estiver logado carrega no template do painel
    $data['title']    = 'Termos de serviço e Contrato do usuário';

    if ($usu != '') {
      $data['conteudo'] = 'acesso/termos';
      $this->load->view('estrutura/template', $data);
    } else {
      $data['conteudo'] = 'termos';
      $this->load->view('acesso/template', $data);
    }
  }    
}
?>
