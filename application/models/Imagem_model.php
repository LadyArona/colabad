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

      $consultor = $this->db->select('USU_ID')->from('usu_usuario')->where('PERF_ID', 2)->get()->result();
      $link = 'avaliar/'.$id.'/'.$link;
      foreach ($consultor as $key => $value) {
        $this->app->geraNotificacao('Nova Imagem para avaliar: <b>'.$titulo.'</b>.', 'A', 'N', $link, $value->USU_ID);
      }

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
                     P.PROJ_ID vProjetoId,
                     P.PROJ_LINK vProjetoLink,
                     I.IMG_NOME vNome,
                     I.IMG_NOMEUNIQ vNomeUnico,
                     I.IMG_STATUS vStatus,
                     
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
            'vProjetoId'      => $row->vProjetoId,
            'vProjeto'        => '<a href="'.base_url().'projeto/'.$row->vProjetoId.'/'.$row->vProjetoLink.'">Projeto: '.$row->vProjeto.'</a>',
            'vAudiodescritor' => $row->vAudiodescritor,
            'vConsultor'      => $row->vConsultor,
            'vNome'           => $row->vNome,
            'vNomeUnico'      => $row->vNomeUnico,
            'vStatus'         => $row->vStatus,
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
                       CONCAT(P.PERF_DESCRICAO, ' <strong>', U.USU_NOME, '</strong> <span class=\'text-blue\'>', T.LT_DESCRICAO, '</span> a imagem em ',  DATE_FORMAT(L.ILOG_DATA, '%d de %M de %Y as %H:%i')) vHistorico
                       
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

        //busca avaliações da imagem
        $sql = "SELECT U.USU_NOME vConsultor,
                       A.AVAL_OBS vAvaliacao,
                       CASE
                        WHEN A.AVAL_STATUS = 1 THEN '<span class=\"text-success\">aprovou a imagem</span>'
                        WHEN A.AVAL_STATUS = 1 THEN '<span class=\"text-danger\">reprovou a imagem</span>'
                       END vAcao,
                       DATE_FORMAT(L.LOG_DATA, '%d de %M de %Y as %H:%i') vData

                FROM img_avaliacao A
                  JOIN usu_log L ON L.LOG_ORIGEM_ID = A.AVAL_ID AND L.LOG_ORIGEM = 'img_avaliacao'
                    JOIN usu_usuario U ON U.USU_ID = L.USU_ID

                WHERE A.IMG_ID = $id
                ORDER BY L.LOG_DATA DESC ;";

        $this->db->query('SET lc_time_names = "pt_br"'); //para os meses sairem em portugues
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0){
          foreach ($query->result() as $row) {
            $dados['vAvaliacoes'][] = array(
              'vData'      => $row->vData,
              'vConsultor' => $row->vConsultor,
              'vAcao'      => $row->vAcao,
              'vAvaliacao' => $row->vAvaliacao
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
