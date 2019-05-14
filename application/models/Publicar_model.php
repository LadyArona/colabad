<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicar_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->model('App_model', 'app');
  }

  public function salvaImagem ($imagem, $titulo, $descricao, $projeto) {
    try{
      $tabela = 'img_cadastro';

      // Pega extensão da imagem
      $ext = explode(".", $imagem['name']);
      $ext = end($ext);
 
      // Gera um nome único para a imagem
      $nome_imagem = md5(uniqid(time())) . "." . $ext;

      // Caminho de onde ficará a imagem
      $caminho = realpath(APPPATH.'../');
      $caminho = $caminho.'/uploads/';
      $caminho_imagem = $caminho . $nome_imagem;
 
      // Faz o upload da imagem para seu respectivo caminho
      move_uploaded_file($imagem["tmp_name"], $caminho_imagem);

      $dados = 
        array(
          'IMG_NOME'           => $imagem['name'],
          'IMG_NOMEUNIQ'       => $nome_imagem,
          'IMG_TYPE'           => $imagem['type'],
          'IMG_TITULO'         => $titulo,
          'IMG_AUDIODESCRICAO' => $descricao,
          'PROJ_ID'            => $projeto
        );  

      $this->db->insert($tabela, $dados);
      $id = $this->db->insert_id();

      $this->app->gravaLog($id, 1);
      $this->auth->logUsuario($tabela, $id, 1);

      return
        array(
          'result' => 'OK',
          'mensagem' => $imagem['name']
        );

    } catch(PDOException $e) { 
      return
        array(
          'result' => 'ERRO',
          'mensagem' => $e->getMessage()
        );
    }
  }

}
