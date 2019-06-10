<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Projetos_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->model('App_model', 'app');
  }

  public function buscarProjeto ($limit = 0, $order = '', $usuWhere = 0, $where = '') {
    $tabela  = 'proj_cadastro';
    $dados   = array();
    $result  = array();

    $order = ($order == '') ? ' ORDER BY P.PROJ_DATACAD DESC ' : $order;
    $order = ($order == 1) ? ' ORDER BY RAND() ' : $order;
    $where = ($where == 1) ? ' AND P.PROJ_PRIVADO = 0 ' : $where;
    $limit = ($limit > 0) ? ' LIMIT '.$limit : '';

    /*echo "<pre>";
      print_r($limit);
      exit;*/
    $usuario = '';
    if ($usuWhere == 0) {
      $usuario = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];
      $usuario = "AND P.USU_ID = $usuario 
                  OR P.PROJ_ID IN 
                    (SELECT C.PROJ_ID 
                    FROM proj_participantes C 
                    WHERE C.USU_ID = $usuario
                    AND C.PAR_RESPONSAVEL = 'S') ";
    }

    try{
      $sql = "SELECT P.PROJ_ID vId,
                   P.PROJ_TITULO vTitulo,
                   P.PROJ_DESCRICAO vDescricao,
                   P.PROJ_LINK vLink,
                   P.PROJ_STATUS vStatus,
                   P.PROJ_PRIVADO vPrivado,
                   DATE_FORMAT(P.PROJ_DATACAD, '%d de %M de %Y as %H:%i') vData,
                   (SELECT COUNT(C.PROJ_ID) FROM proj_participantes C WHERE C.PROJ_ID = P.PROJ_ID) vColab,
                   (SELECT COUNT(I.IMG_ID) FROM img_cadastro I WHERE I.PROJ_ID = P.PROJ_ID) vImagens

            FROM proj_cadastro P

            WHERE P.PROJ_ID > 0
            $usuario
            $where

            $order 
            $limit ;";
      
      $this->db->query('SET lc_time_names = "pt_br"'); //para os meses sairem em portugues
      $query = $this->db->query($sql);

      foreach ($query->result() as $row) {
        $link = ($row->vLink != '') ? base_url().'projeto/'.$row->vId.'/'.$row->vLink : '';
        $dados[] = 
          array(
            'vId'      => $row->vId,
            'vTitulo'  => '<strong>'.$row->vTitulo.'</strong>',
            'vStatus'  => $row->vStatus,
            'vPrivado' => $row->vPrivado,
            'vData'    => $row->vData,
            'vImagens' => $row->vImagens,
            'vLink'    => $link,
            'vColab'   => $this->carregaColaboradores($row->vId)
          );
      }

      $result = array('result'   => 'OK',
                     'vProjetos' => $dados);

      return $result;

    } catch(PDOException $e) { 
      return
        array(
          'result' => 'ERRO',
          'mensagem' => $e->getMessage()
        );
    }           
  }

  public function carregarProjeto ($id) {
    $tabela = 'proj_cadastro';

    try{
      $sql = "SELECT P.PROJ_ID vId,
                     P.PROJ_TITULO vTitulo,
                     P.PROJ_DESCRICAO vDescricao,
                     P.PROJ_STATUS vStatus,
                     P.PROJ_PRIVADO vPrivado

              FROM proj_cadastro P

              WHERE P.PROJ_ID = $id ;";

      $query = $this->db->query($sql);

      if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $dados = array(
            'result'        => 'OK',
            'vTitulo'       => $row->vTitulo,
            'vDescricao'    => $row->vDescricao,
            'vPrivado'      => $row->vPrivado,
            'vStatus'       => $row->vStatus,
            'vId'           => $row->vId,
            'vParticipante' => $this->carregaColaboradores($row->vId)
          );


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

  private function carregaColaboradores ($id) {
    $dados = array();
    //busca participantes
    $sql = "SELECT P.USU_ID vId,
                   U.USU_NOME vNome,
                   U.USU_IMG_NOMEUNIQ vImg,
                   U.USU_LINK vLink,
                   P.PAR_RESPONSAVEL vResponsavel

            FROM proj_participantes P
              JOIN usu_usuario U ON U.USU_ID = P.USU_ID

            WHERE P.PROJ_ID = $id ;";

    $query = $this->db->query($sql);

    if ($query->num_rows() > 0){
      foreach ($query->result() as $row) {
        $dados[] = array(
          'vId'          => $row->vId,
          'vNome'        => $row->vNome,
          'vResponsavel' => $row->vResponsavel,
          'vLink'        => base_url().'perfil/'.$row->vId.'/'.$row->vLink,
          'vImg' => ($row->vImg != '') ? (base_url().'assets/img/users/'.$row->vImg) : (base_url().$this->config->item('img_usu_padrao'))
        );
      }
    }

    return $dados;
  }

  public function carregarProjetoVisualizar ($id) {
    $tabela  = 'proj_cadastro';
    $dados   = array();

    try{
      $sql = "SELECT P.PROJ_ID vId,
                     P.PROJ_TITULO vTitulo,
                     P.PROJ_DESCRICAO vDescricao,
                     P.PROJ_STATUS vStatus,
                     CASE 
                      WHEN P.PROJ_PRIVADO = 0 THEN 'Projeto Público'
                      ELSE 'Projeto Privado'
                    END vPrivado

              FROM proj_cadastro P

              WHERE P.PROJ_ID = $id ;";

      $query = $this->db->query($sql);

      if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $dados = array(
            'result'        => 'OK',
            'vTitulo'       => $row->vTitulo,
            'vDescricao'    => $row->vDescricao,
            'vPrivado'      => $row->vPrivado,
            'vStatus'       => $row->vStatus,
            'vId'           => $row->vId,
            'vParticipante' => array(),
            'vImagens'      => array()
          );
        }

        //busca participantes
        $sql = "SELECT P.USU_ID vId,
                       U.USU_NOME vNome,
                       U.USU_IMG_NOMEUNIQ vImg,
                       U.USU_LINK vLink,
                       CASE
                        WHEN P.PAR_RESPONSAVEL = 'S' THEN 'Responsável'
                        ELSE ''
                       END vResponsavel,
                       PF.PERF_DESCRICAO vPerfil

                FROM proj_participantes P
                  JOIN usu_usuario U ON U.USU_ID = P.USU_ID
                  JOIN usu_perfil PF ON PF.PERF_ID = U.PERF_ID

                WHERE P.PROJ_ID = $id ;";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0){
          foreach ($query->result() as $row) {
            $dados['vParticipante'][] = array(
              'vId'          => $row->vId,
              'vNome'        => $row->vNome,
              'vResponsavel' => $row->vResponsavel,
              'vPerfil'      => $row->vPerfil,
              'vLink'        => base_url().'perfil/'.$row->vId.'/'.$row->vLink,
              'vImg' => ($row->vImg != '') ? (base_url().'assets/img/users/'.$row->vImg) : (base_url().$this->config->item('img_usu_padrao'))
            );
          }
        }

        //busca imagens
        $sqlImg = "SELECT I.IMG_ID vId,
                       I.IMG_NOMEUNIQ vNome,
                       I.IMG_LINK vLink,
                       I.IMG_TITULO vDesc,
                       CASE
                        WHEN I.IMG_STATUS = 'P' THEN ' has-default '
                        WHEN I.IMG_STATUS = 'A' THEN ' has-success '
                        WHEN I.IMG_STATUS = 'R' THEN ' has-danger '
                        WHEN I.IMG_STATUS = 'V' THEN ' has-primary '
                        ELSE ''
                       END vStatusClass

                FROM img_cadastro I

                WHERE I.PROJ_ID = $id ;";

        $queryImg = $this->db->query($sqlImg);

        if ($queryImg->num_rows() > 0){
          foreach ($queryImg->result() as $rowImg) {
            $linkImg = ($rowImg->vLink != '') ? base_url().'imagem/'.$rowImg->vId.'/'.$rowImg->vLink : '';
            $dados['vImagens'][] = array(
              'vId'   => $rowImg->vId,
              'vNome' => $rowImg->vNome,
              'vLink' => $linkImg,
              'vDesc' => $rowImg->vDesc,
              'vStatusClass' => $rowImg->vStatusClass
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

  public function salvarProjeto ($form, $participantes) {
    $id  = 0;
    $values = array();

    if (isset($form)) {
      parse_str($form, $values); 

      /*echo "<pre>";
      print_r($values);
      exit;*/

      try{
        $tabela = 'proj_cadastro';

        $edTitulo     = ($values['edTitulo'] != '')     ? $values['edTitulo'] : null;
        $edDescricao  = ($values['edDescricao'] != '')  ? $values['edDescricao'] : null;
        $cbPublico    = ($values['cbPublico'] != '')    ? $values['cbPublico'] : null;
        $cbStatus     = ($values['cbStatus'] != '')     ? $values['cbStatus'] : null;
        $edEditar     = ($values['edEditar'] == 'S')    ? 'S' : 'N';

        $link = criaLink($edTitulo);

        $dados = 
          array(
            'PROJ_TITULO'    => $edTitulo,
            'PROJ_DESCRICAO' => $edDescricao,
            'PROJ_PRIVADO'   => $cbPublico,
            'PROJ_STATUS'    => $cbStatus,
            'PROJ_LINK'      => $link,
            'USU_ID'         => $this->session->userdata('logged_in_colabad')['sesColabad_vId']
          );

        if ($edEditar == 'S') {  
          $this->db->update($tabela, $dados, array("PROJ_ID" => $values['edCodigo']));
          $id = $values['edCodigo'];

          $this->auth->logUsuario($tabela, $id, 3);
        } else {
          $this->db->insert($tabela, $dados);
          $id = $this->db->insert_id();
          $this->auth->logUsuario($tabela, $id, 1);
        }

        $link = 'projeto/'.$id.'/'.$link;
        $this->salvaParticipantes($id, $participantes, $edEditar, $edTitulo, $link);

        return
          array(
            'result' => 'OK',
            'mensagem' => $id.' - '.$edTitulo
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

  function salvaParticipantes($id, $participantes, $editar, $projeto, $link) {
    $tabela = 'proj_participantes';

    if ($editar == 'S') {
      $this->db->delete($tabela, array('PROJ_ID' => $id));
    }

    if ($participantes != null) {
      foreach ($participantes as $value) {
        $this->db->insert(
          $tabela, 
          array(
            'PROJ_ID'         => $id,
            'USU_ID'          => $value['cod'],
            'PAR_RESPONSAVEL' => $value['resp']
          )
        );

        $this->app->geraNotificacao('Você foi adicionado como colaborador do projeto: <b>'.$projeto.'</b>.', 'A', 'N', $link, $value['cod']);
      }
    }
  }  

}
