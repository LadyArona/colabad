<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class App_model extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  function configuracoes() {
    $sql = " SELECT C.CONF_ID,
                    C.CONF_NOME,
                    C.CONF_ABRV,
                    C.CONF_DESCRICAO,
                    C.CONF_LOGO,
                    C.CONF_LOGOALT,
                    CD.CID_DESCRICAO,
                    E.EST_DESCRICAO,
                    C.CONF_EMAIL,
                    C.CONF_EMAILPWD,
                    C.CONF_EMAILHOST,
                    DATE_FORMAT(C.CONF_DATAATT,'%d/%m/%Y') AS CONF_DATAATT,
                    DATE_FORMAT(C.CONF_DATACAD,'%d/%m/%Y') AS CONF_DATACAD,
                    C.CONF_VERSAO,
                    C.CONF_AUTOR,
                    C.CONF_KEYWORDS,
                    C.CONF_FACEBOOK,
                    C.CONF_REPOSITORIO
               FROM conf_configuracoes C
               INNER JOIN conf_cidade CD
                  ON CD.CID_ID = C.CID_ID
               INNER JOIN conf_estado E 
                  ON E.EST_ID = CD.EST_ID
             WHERE C.CONF_ID > 0
             LIMIT 1; ";

    $query = $this->db->query($sql);

    if ($query->num_rows() > 0){
      foreach ($query->result() as $row) {
        $dados = array(
          'nome'        => $row->CONF_NOME,
          'abrv'        => $row->CONF_ABRV,
          'descr'       => $row->CONF_DESCRICAO,
          'logo'        => $row->CONF_LOGO,
          'logo_alt'    => $row->CONF_LOGOALT,
          'cidade'      => $row->CID_DESCRICAO,
          'estado'      => $row->EST_DESCRICAO,

          'email_SMTPSecure' => 'ssl',
          'email_Mailer'     => 'smtp',
          'email_Host'       => $row->CONF_EMAILHOST,
          'email_Port'       => 465, // or 587

          'email_Username'   => $row->CONF_EMAIL,
          'email_Password'   => $row->CONF_EMAILPWD,
          'email_Autor'      => 'Equipe '.$row->CONF_ABRV,
 
          'dt_att'      => $row->CONF_DATAATT,
          'dt_cad'      => $row->CONF_DATACAD,
          'versao'      => $row->CONF_VERSAO,
          'autor'       => $row->CONF_AUTOR,
          'autor_link'  => '#',
          'keys'        => $row->CONF_KEYWORDS,
          'facebook'    => $row->CONF_FACEBOOK,
          'repositorio' => $row->CONF_REPOSITORIO
        ); 
      }
      return $dados;
    } else {
      return null;
    }
  }

  function gravaLog($img, $tipo) {
    try{
      $tabela = 'img_log';

      $dados = 
        array(
          'IMG_ID' => $img,
          'LT_ID'  => $tipo,
          'USU_ID' => $this->session->userdata('logged_in_colabad')['sesColabad_vId']
        );

        $this->db->insert($tabela, $dados);
    } catch(PDOException $e) { 
      echo 'Erro: ' . $e->getMessage();
      print_r($e);
    }
  }

  /*-- Função para buscar os dados dos combos padrões --*/    
  function buscaDadosCombo($tipoInfo, $codToControl){
    $dados = array();
    $sql = '';

    if ($tipoInfo == 'U') {
      $where = ($codToControl != '') ? ' AND U.USU_ID = '.$codToControl.' ' : '';            
      $sql = " SELECT U.USU_ID ID, U.USU_NOME DESCRICAO, '' COR, '' ICON 
                FROM usu_usuario U
                WHERE U.USU_SITUACAO = 'A'
                $where 
                ORDER BY U.USU_NOME; ";
    } else 
    if ($tipoInfo == 'P') {
      if ($codToControl == 0) {
        $usuario = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];
        $where = " AND P.USU_ID = $usuario
                OR P.PROJ_ID IN 
                  (SELECT C.PROJ_ID 
                  FROM proj_participantes C 
                  WHERE C.USU_ID = $usuario
                  AND C.PAR_RESPONSAVEL = 'S') ";
      } else 
      if ($codToControl != '')  { 
        $where = ' AND P.PROJ_ID = '.$codToControl;
      }

      $sql = " SELECT P.PROJ_ID ID, P.PROJ_TITULO DESCRICAO, '' COR, '' ICON 
              FROM proj_cadastro P
              WHERE P.PROJ_STATUS = 'A'
              $where
              ORDER BY P.PROJ_TITULO; ";
    }

    $query = $this->db->query($sql);

    if ($query->num_rows() > 0){
      foreach ($query->result() as $row) {
            $dados[] = array(
                'vIdInfo'   => $row->ID,
                'vNomeInfo' => $row->DESCRICAO,
                'vCorInfo'  => $row->COR,
                'vIconInfo' => $row->ICON
            );  
      }

      return $dados;
    }

    return null;
  }

  function geraNotificacao($descricao, $tipo, $notificacaoPadrao = 'N', $linkDirecionamento = null, $codUser = null){ 
    /* tipos:
      S = Solicitações
      A = Avisos
      Notificações padrões são as geradas pelo sistema. Do contrário, setar o parâmetro como N. */

    $this->db->set('NOTF_DATA_HORA', 'NOW()', false);
    $this->db->insert(
      'conf_notificacoes',
      array('NOTF_DESCRICAO' => $descricao,
            'NOTF_TIPO'      => $tipo,
            'NOTF_LIDA'      => 'N',
            'NOTF_PADRAO'    => $notificacaoPadrao,
            'NOTF_DIRECIONA' => $linkDirecionamento,
            'NOTF_USUARIO'   => ($codUser != null) ? $codUser : $this->session->userdata('logged_in_colabad')['sesColabad_vId'])
      );
  }

    
  function buscaNotificacoes() {
    //Controle pra não alertar o usuário mais que uma vez para a mesma notificação
    //$contaNotficPadrao = $this->db->get_where('notificacoes', array('NOTF_PADRAO' => 'S', 'NOTF_USUARIO' => $this->codPes, "DATE_FORMAT(NOTF_DATA_HORA, '%Y-%m-%d') = " => date('Y-m-d')))->num_rows();
    //if($contaNotficPadrao == 0){
      //$this->notificacoesPadroes();
    //}

    $dados = array();

    $sql = " SELECT N.NOTF_ID,
                    N.NOTF_DESCRICAO,
                    N.NOTF_TIPO,
                    N.NOTF_LIDA,
                    COALESCE(N.NOTF_DIRECIONA, '') NOTF_DIRECIONA,
                    DATE_FORMAT(N.NOTF_DATA_HORA, '%d/%m/%Y %H:%i') NOTF_DATA_HORA
            FROM conf_notificacoes N 
            WHERE N.NOTF_USUARIO = ?
            ORDER BY N.NOTF_DATA_HORA DESC, N.NOTF_LIDA ASC; ";

    $query = $this->db->query($sql, array($this->session->userdata('logged_in_colabad')['sesColabad_vId']));
        
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $dados[] = array(
          'vNotId'        => $row->NOTF_ID,
          'vNotDesc'      => $row->NOTF_DESCRICAO,
          'vNotTipo'      => $row->NOTF_TIPO,
          'vNotLida'      => $row->NOTF_LIDA,
          'vNotDireciona' => $row->NOTF_DIRECIONA,
          'vNotDataHora'  => $row->NOTF_DATA_HORA
        );  
      }
      return $dados;
    } else {
      return null;
    }
  }

  function atualizaStatusNotificacao($codNotificacao, $lerNaoler, $excluir) {
    if($excluir != 'S'){
      $this->db->set('NOTF_LIDA', $lerNaoler);
      $this->db->where('NOTF_ID', $codNotificacao);
      $this->db->update('conf_notificacoes');
    } else {
      $this->db->delete('conf_notificacoes', array('NOTF_ID' => $codNotificacao));
    }

    return $this->db->affected_rows();
  }  
}

