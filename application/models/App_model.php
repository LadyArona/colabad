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
          'ILT_ID' => $tipo,
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

}

