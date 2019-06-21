<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliar_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->model('App_model', 'app');
  }

  public function carregarAvaliar(){
    $dados = array();
    $usu = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];
    try {
      $sql = "SELECT I.IMG_ID vImgId,
                     I.IMG_NOMEUNIQ vImg,
                     I.IMG_TITULO vImgTitulo,
                     I.IMG_STATUS vStatus,
                       CASE
                        WHEN I.IMG_STATUS = 'P' THEN ' has-default '
                        WHEN I.IMG_STATUS = 'A' THEN ' has-success '
                        WHEN I.IMG_STATUS = 'R' THEN ' has-danger '
                        WHEN I.IMG_STATUS = 'V' THEN ' has-primary '
                        ELSE ''
                       END vStatusClass,
                     
                     I.IMG_LINK vImgLink,
                     
                     I.PROJ_ID vProjId,
                     P.PROJ_TITULO vProjTitulo,
                     P.PROJ_LINK vProjLink

              FROM img_cadastro I
                JOIN proj_cadastro P ON P.PROJ_ID = I.PROJ_ID

              WHERE I.IMG_STATUS IN ('P', 'V')
                AND I.IMG_ID NOT IN (SELECT I.IMG_ID
                                      FROM img_cadastro I
                                        JOIN img_log L ON L.IMG_ID = I.IMG_ID
                                      WHERE L.USU_ID = $usu 
                                       AND L.LT_ID = 1) ; ";

      $query = $this->db->query($sql);

      /*echo "<pre>";
      print_r($this->db->last_query());
      exit;*/

      if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $dados[] = array(  
            'vImgId'        => $row->vImgId,
            'vStatus'       => $row->vStatus,
            'vImg'          => base_url().'uploads/'.$row->vImg,
            'vImgTitulo'    => $row->vImgTitulo,
            'vStatusClass'  => $row->vStatusClass,
            'vImgLink'      => 'avaliar/'.$row->vImgId.'/'.$row->vImgLink,
            'vProjId'       => $row->vProjId,
            'vProjTitulo'   => $row->vProjTitulo,
            'vProjLink'     => $row->vProjLink
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

  public function avaliarImagem($imgId, $tipo, $obs, $descr){
    try {
      $tabela = 'img_avaliacao';
      $dados = 
        array(
          'IMG_ID'      => $imgId,
          'AVAL_STATUS' => $tipo,
          'AVAL_OBS'    => $obs,
          'AVAL_DESCR'  => $descr
        );

      $this->db->insert($tabela, $dados);
      $id = $this->db->insert_id();

      //troca Status da Imagem P = PUBLICADA | A = APROVADA | R = REPROVADA | V = PARA AVALIAR
      //aprovou
      $status = ($tipo == 1) ? 'A' : (($tipo == 2) ? 'R' : '');
      if ($status != '') {
        //update
        $data = array('IMG_STATUS' => $status, 'IMG_AUDIODESCRICAO' => $descr);
        $this->db->where('IMG_ID', $imgId);
        $this->db->update('img_cadastro', $data);
      }

      $this->app->gravaLog($imgId, 6);
      $this->auth->logUsuario($tabela, $id, 6);

      $usu = $this->db->select('USU_ID')->from('img_log')->where('IMG_ID', $imgId)->where('LT_ID', 1)->get()->result()[0]->USU_ID;
      $imagem = $this->db->select('IMG_TITULO, IMG_LINK')->from('img_cadastro')->where('IMG_ID', $imgId)->get()->result()[0];
      $link = 'imagem/'.$imgId.'/'.$imagem->IMG_LINK;
      $this->app->geraNotificacao('Sua audiodescrição foi avaliada por um Consultor: <b>'.$imagem->IMG_TITULO.'</b>.', 'A', 'N', $link, $usu);

      $this->session->set_flashdata('avaliar_ok', $imagem->IMG_TITULO.' avaliada com sucesso!');

      return
        array(
          'result' => 'OK',
          'mensagem' => $imagem->IMG_TITULO
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
