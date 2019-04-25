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
                    DATE_FORMAT(C.CONF_DATAATT,'%d/%m/%Y') AS CONF_DATAATT,
                    DATE_FORMAT(C.CONF_DATACAD,'%d/%m/%Y') AS CONF_DATACAD,
                    C.CONF_VERSAO,
                    C.CONF_AUTOR,
                    C.CONF_KEYWORDS,
                    C.CONF_FACEBOOK
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
          'nome' => $row->CONF_NOME,
          'abrv' => $row->CONF_ABRV,
          'descr' => $row->CONF_DESCRICAO,
          'logo' => $row->CONF_LOGO,
          'logo_alt' => $row->CONF_LOGOALT,
          'cidade' => $row->CID_DESCRICAO,
          'estado' => $row->EST_DESCRICAO,
          'email' => $row->CONF_EMAIL,
          'dt_att' => $row->CONF_DATAATT,
          'dt_cad' => $row->CONF_DATACAD,
          'versao' => $row->CONF_VERSAO,
          'autor' => $row->CONF_AUTOR,
          'keys' => $row->CONF_KEYWORDS,
          'facebook' => $row->CONF_FACEBOOK
        ); 
      }
      return $dados;
    } else {
      return null;
    }
  }
}

