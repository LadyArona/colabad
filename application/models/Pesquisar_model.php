<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesquisar_model extends CI_Model {
  public function __construct(){
    parent::__construct();
  }

  public function carregarPesquisar($pesquisa){
    $dados = array();
    $usuario = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];
    $pesquisa = $this->db->escape($pesquisa);
    try {
      $sql = "
        SELECT TABELA.DESCR,
           TABELA.CAMPO,
           TABELA.LINK

        FROM (
          SELECT 'Imagem: Título' DESCR,
                 I.IMG_TITULO CAMPO,
                 CONCAT('imagem/', I.IMG_ID, '/', I.IMG_LINK) LINK,
                 MATCH(I.IMG_TITULO) AGAINST($pesquisa IN NATURAL LANGUAGE MODE) SOMA
                 
          FROM img_cadastro I
          
          WHERE I.PROJ_ID IN (SELECT P.PROJ_ID FROM proj_cadastro P 
                              WHERE P.PROJ_PRIVADO = 0
                              OR P.PROJ_ID IN (SELECT C.PROJ_ID 
                                              FROM proj_participantes C 
                                              WHERE C.USU_ID = $usuario))
            AND MATCH(I.IMG_TITULO) AGAINST($pesquisa IN NATURAL LANGUAGE MODE)
          
          UNION
          
          SELECT 'Imagem: Audiodescricao' DESCR,
                 I.IMG_TITULO CAMPO,
                 CONCAT('imagem/', I.IMG_ID, '/', I.IMG_LINK) LINK,
                 MATCH(I.IMG_AUDIODESCRICAO) AGAINST($pesquisa IN NATURAL LANGUAGE MODE) SOMA
                 
          FROM img_cadastro I
          
          WHERE I.PROJ_ID IN (SELECT P.PROJ_ID FROM proj_cadastro P 
                              WHERE P.PROJ_PRIVADO = 0
                              OR P.PROJ_ID IN (SELECT C.PROJ_ID 
                                              FROM proj_participantes C 
                                              WHERE C.USU_ID = $usuario))
            AND MATCH(I.IMG_AUDIODESCRICAO) AGAINST($pesquisa IN NATURAL LANGUAGE MODE)
          
          UNION
          
          SELECT 'Projeto: Título' DESCR,
                 P.PROJ_TITULO CAMPO,
                 CONCAT('projeto/', P.PROJ_ID, '/', P.PROJ_LINK) LINK,
                 MATCH(P.PROJ_TITULO) AGAINST($pesquisa IN NATURAL LANGUAGE MODE) SOMA
                 
          FROM proj_cadastro P
          
          WHERE P.PROJ_PRIVADO = 0
            OR P.PROJ_ID IN (SELECT C.PROJ_ID 
                              FROM proj_participantes C 
                              WHERE C.USU_ID = $usuario)
          AND MATCH(P.PROJ_TITULO) AGAINST($pesquisa IN NATURAL LANGUAGE MODE)
          
          UNION
          
          SELECT 'Projeto: Descrição' DESCR,
                 P.PROJ_TITULO CAMPO,
                 CONCAT('projeto/', P.PROJ_ID, '/', P.PROJ_LINK) LINK,
                 MATCH(P.PROJ_DESCRICAO) AGAINST($pesquisa IN NATURAL LANGUAGE MODE) SOMA
                 
          FROM proj_cadastro P
          
          WHERE P.PROJ_PRIVADO = 0
             OR P.PROJ_ID IN (SELECT C.PROJ_ID 
                              FROM proj_participantes C 
                              WHERE C.USU_ID = $usuario)
            AND MATCH(P.PROJ_DESCRICAO) AGAINST($pesquisa IN NATURAL LANGUAGE MODE) 
        ) TABELA

        WHERE TABELA.SOMA > 0

        GROUP BY TABELA.LINK
        ORDER BY TABELA.SOMA, TABELA.DESCR ; ";

      $query = $this->db->query($sql);

      if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $dados[] = array(  
            'vDescr' => $row->DESCR,
            'vCampo' => $row->CAMPO,
            'vLink'  => $row->LINK
          );
        }
      }

      return $dados;

    } catch(PDOException $e) { 
      return
        array(
          'result' => 'ERRO',
          'mensagem' => $e->getMessage()
        );
    }
  }

}        
