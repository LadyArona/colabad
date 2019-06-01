<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagem_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->model('App_model', 'app');
  }

  public function salvaImagem($imagem, $titulo, $descricao, $projeto) {
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

      $link = criaLink($titulo);

      $dados = 
        array(
          'IMG_NOME'           => $imagem['name'],
          'IMG_NOMEUNIQ'       => $nome_imagem,
          'IMG_TYPE'           => $imagem['type'],
          'IMG_TITULO'         => $titulo,
          'IMG_AUDIODESCRICAO' => $descricao,
          'PROJ_ID'            => $projeto,
          'IMG_LINK'           => $link
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

  public function carregarImagemVisualizar($id) {
    $tabela  = 'proj_cadastro';
    $dados   = array();

    try{
      $sql = "SELECT I.IMG_TITULO vTitulo,
                     I.IMG_AUDIODESCRICAO vDescr,
                     P.PROJ_TITULO vProjeto,
                     I.IMG_NOME vNome,
                     I.IMG_NOMEUNIQ vNomeUnico,
                     
                     (SELECT U.USU_NOME
                      FROM img_log L JOIN usu_usuario U ON U.USU_ID = L.USU_ID
                      WHERE L.LT_ID = 1
                      AND L.IMG_ID = I.IMG_ID) vAudiodescritor,
                      
                     COALESCE((SELECT U.USU_NOME
                      FROM img_log L JOIN usu_usuario U ON U.USU_ID = L.USU_ID
                      WHERE L.LT_ID = 6 
                      AND L.IMG_ID = I.IMG_ID
                      ORDER BY L.ILOG_DATA LIMIT 1), 'Imagem sem consulta') vConsultor

              FROM img_cadastro I
                JOIN proj_cadastro P ON P.PROJ_ID = I.PROJ_ID

              WHERE I.IMG_ID = $id ;";

      $this->db->query('SET lc_time_names = "pt_br"'); //para os meses sairem em portugues
      $query = $this->db->query($sql);

      if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $dados = array(
            'result'          => 'OK',
            'vTitulo'         => $row->vTitulo,
            'vDescr'          => $row->vDescr,
            'vProjeto'        => $row->vProjeto,
            'vAudiodescritor' => $row->vAudiodescritor,
            'vConsultor'      => $row->vConsultor,
            'vNome'           => $row->vNome,
            'vNomeUnico'      => $row->vNomeUnico,
            'vParticipante'   => array(),
            'vHistorico'      => array()
          );
        }

        //busca participantes
        $sql = "SELECT DISTINCT(U.USU_NOME) vNome,
                       U.USU_ID vId,
                       U.USU_IMG_NOMEUNIQ vImg,
                       U.USU_LINK vLink,
                        P.PERF_DESCRICAO vPerfil
       
                FROM img_log L 
                  JOIN usu_usuario U ON U.USU_ID = L.USU_ID
                    JOIN usu_perfil P ON P.PERF_ID = U.PERF_ID
                WHERE L.IMG_ID = $id ;";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0){
          foreach ($query->result() as $row) {
            $dados['vParticipante'][] = array(
              'vNome'        => $row->vNome,
              'vPerfil'      => $row->vPerfil,
              'vLink'        => base_url().'perfil/'.$row->vId.'/'.$row->vLink,
              'vImg' => ($row->vImg != '') ? (base_url().'assets/img/users/'.$row->vImg) : (base_url().$this->config->item('img_usu_padrao'))
            );
          }
        }

        //busca log da imagem
        $sql = "SELECT U.USU_NOME,
                       P.PERF_DESCRICAO,
                       L.ILOG_DATA,
                       T.LT_DESCRICAO,
                       CONCAT(P.PERF_DESCRICAO, ' ', U.USU_NOME, ' ', T.LT_DESCRICAO, ' a imagem em ',  DATE_FORMAT(L.ILOG_DATA, '%d de %M de %Y as %H:%i')) vHistorico
                       
                FROM img_log L 
                  JOIN usu_usuario U ON U.USU_ID = L.USU_ID
                    JOIN usu_perfil P ON P.PERF_ID = U.PERF_ID
                  JOIN conf_logtipo T ON T.LT_ID = L.LT_ID
                WHERE L.IMG_ID = $id 
                ORDER BY L.ILOG_DATA ;";

        $this->db->query('SET lc_time_names = "pt_br"'); //para os meses sairem em portugues
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0){
          foreach ($query->result() as $row) {
            $dados['vHistorico'][] = array(
              'vHistorico' => $row->vHistorico
            );
          }
        }

        return $dados;

      }
    } catch(PDOException $e) { 
      return
        array(
          'result' => 'ERRO',
          $dados
        );
    }           
  }

}
