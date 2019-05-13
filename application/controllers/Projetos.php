<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projetos extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index(){
    $data['title']    = 'Projetos';
    $data['conteudo'] = 'projetos';

    $data['tabelaProjetos'] = array(
      'theadsTabela' => 
        array(
          '<strong>ID</strong>'           => array('posicao' => 'center', 'width' => 5, 'tooltip' => ''), //0
          '<strong>Título</strong>'       => array('posicao' => 'left',   'width' => 55, 'tooltip' => ''),  //1
          '<strong>Status</strong>'       => array('posicao' => 'center', 'width' => 10, 'tooltip' => ''),  //2
          '<strong>Privacidade</strong>'  => array('posicao' => 'center', 'width' => 10, 'tooltip' => ''),  //3, 
          '<strong>Colaboradores</strong>' => array('posicao' => 'center', 'width' => 10, 'tooltip' => ''),
          '<strong>-</strong>'            => array('posicao' => 'center', 'width' => 10, 'tooltip' => '')
      ),
      'columnDefs' => 
        array(
          array('targets' => array(1), 'className' => 'dt-left'),
          array('targets' => array(0,2,3,4), 'className' => 'dt-center'),
          array('targets' => array(5),   'orderable' => false, 'className' => 'dt-center')
        ),
      'ordemInicial' => array(1, 'ASC')
    );

    $this->load->view('estrutura/template', $data);
  }
}
