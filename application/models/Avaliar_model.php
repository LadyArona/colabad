<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliar_model extends CI_Model {
  public function __construct(){
    parent::__construct();
  }

  public function carregarAvaliar(){
    $dados = array();
    try {
      $sql = "SELECT I.IMG_ID vImgId,
                     I.IMG_NOMEUNIQ vImg,
                     I.IMG_TITULO vImgTitulo,
                     I.IMG_STATUS vStatus,
                     
                     I.IMG_LINK vImgLink,
                     
                     I.PROJ_ID vProjId,
                     P.PROJ_TITULO vProjTitulo,
                     P.PROJ_LINK vProjLink

              FROM img_cadastro I
                JOIN proj_cadastro P ON P.PROJ_ID = I.PROJ_ID

              WHERE I.IMG_ID NOT IN (SELECT DISTINCT(L.IMG_ID)
                                     FROM img_log L
                                     WHERE L.LT_ID = 6); ";

      $query = $this->db->query($sql);

      if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $dados[] = array(  
            'vImgId'      => $row->vImgId,
            'vStatus'     => $row->vStatus,
            'vImg'        => base_url().'uploads/'.$row->vImg,
            'vImgTitulo'  => $row->vImgTitulo,
            'vImgLink'    => 'avaliar/'.$row->vImgId.'/'.$row->vImgLink,
            'vProjId'     => $row->vProjId,
            'vProjTitulo' => $row->vProjTitulo,
            'vProjLink'   => $row->vProjLink
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
