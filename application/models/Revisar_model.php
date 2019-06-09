<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Revisar_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->model('App_model', 'app');
  }

  public function carregarRevisar(){
    $dados = array();
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

              WHERE I.IMG_ID > 0
                AND I.IMG_STATUS IN ('R') ; ";

      $query = $this->db->query($sql);

      if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $dados[] = array(  
            'vImgId'        => $row->vImgId,
            'vStatus'       => $row->vStatus,
            'vImg'          => base_url().'uploads/'.$row->vImg,
            'vImgTitulo'    => $row->vImgTitulo,
            'vStatusClass'  => $row->vStatusClass,
            'vImgLink'      => 'revisar/'.$row->vImgId.'/'.$row->vImgLink,
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

  public function revisarImagem($form, $imgId){
    if (isset($form)) {
      parse_str($form, $values);

      try {
        $tabela = 'img_revisao';
        $dados = 
          array(
            'IMG_ID'  => $imgId,
            'REV_OBS' => $values['edAudiodescricao']
          );

        $this->db->insert($tabela, $dados);
        $id = $this->db->insert_id();

        //troca Status da Imagem P = PUBLICADA | A = APROVADA | R = REPROVADA | V = PARA AVALIAR
        $data = 
          array(
            'IMG_STATUS' => 'V',
            'IMG_AUDIODESCRICAO' => $values['edAudiodescricao']
          );
        $this->db->where('IMG_ID', $imgId);
        $this->db->update('img_cadastro', $data);

        $this->app->gravaLog($imgId, 7);
        $this->auth->logUsuario($tabela, $id, 7);

        $consultor = $this->db->select('USU_ID')->from('usu_usuario')->where('PERF_ID', 2)->get()->result();
        $imagem = $this->db->select('IMG_TITULO, IMG_LINK')->from('img_cadastro')->where('IMG_ID', $imgId)->get()->result()[0];
        $link = 'imagem/'.$imgId.'/'.$imagem->IMG_LINK;
        foreach ($consultor as $key => $value) {
          $this->app->geraNotificacao('Imagem revisada para avaliar: <b>'.$imagem->IMG_TITULO.'</b>.', 'A', 'N', $link, $value->USU_ID);
        }

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

}
