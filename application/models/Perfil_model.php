<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->model('App_model', 'app');
  }

  public function carregarPerfil($id = ''){
    $alterar = ($id == '') ? true : false;
    $dados = array();
    if ($id == '') {
      $id = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];
    }

    try{
      $sql = " SELECT U.USU_NOME vNome,
                      COALESCE(U.USU_CADDATA, '') vDataCad,
                      COALESCE(U.USU_SITUACAO, '') vSituacao,
                      COALESCE(U.USU_EMAIL, '') vEmail,
                      COALESCE(U.PERF_ID, '') vPerfilId,
                      COALESCE(P.PERF_DESCRICAO, '') vPerfil,
                      COALESCE(U.USU_LINK, '') vLink,
                      COALESCE(U.USU_IMG_NOME, '') vImgNome,
                      COALESCE(U.USU_IMG_NOMEUNIQ, '') vImgNomeUniq,
                      COALESCE(U.USU_IMG_AUDIODESCRICAO, '') vImgAudiodesc,
                      COALESCE(U.EST_ID, '') vEstadoId,
                      COALESCE(E.EST_DESCRICAO, '') vEstadoDescr,
                      COALESCE(E.EST_UF, '') vEstadoUF,
                      COALESCE(U.CID_ID, '') vCidadeId,
                      COALESCE(C.CID_DESCRICAO, '') vCidadeDescr,
                      COALESCE(U.USU_ORG, '') vOrganização,
                      COALESCE(U.DEF_ID, '') vDeficienciaId,
                      COALESCE(D.DEF_DESCRICAO, '') vDeficiencia,
                      COALESCE(U.USU_DEF, '') vPossuiDeficiencia,
                      COALESCE(U.USU_OBS, '') vObs

              FROM usu_usuario U
                LEFT JOIN usu_perfil P ON P.PERF_ID = U.PERF_ID
                LEFT JOIN conf_estado E ON E.EST_ID = U.EST_ID
                LEFT JOIN conf_cidade C ON C.CID_ID = U.CID_ID
                LEFT JOIN conf_deficiencia D ON D.DEF_ID = U.DEF_ID
              WHERE U.USU_ID = $id ;";

      $this->db->query('SET lc_time_names = "pt_br"'); //para os meses sairem em portugues
      $query = $this->db->query($sql);

      if ($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $projetos   = $this->usuTotProjetos($id);
          $fotos      = $this->usuTotFotos($id);
          $aprovadas  = $this->usuTotAprovadas($id);

          $dados = array(     
            'result'             => 'OK',
            'vNome'              => $row->vNome,
            'vDataCad'           => $row->vDataCad,
            'vSituacao'          => $row->vSituacao,
            'vEmail'             => $row->vEmail,
            'vPerfilId'          => $row->vPerfilId,
            'vPerfil'            => $row->vPerfil,
            'vLink'              => $row->vLink,
            'vImgNome'           => $row->vImgNome,
            'vImgNomeUniq'       => $row->vImgNomeUniq,
            'vImgAudiodesc'      => $row->vImgAudiodesc,
            'vEstadoId'          => $row->vEstadoId,
            'vEstadoDescr'       => $row->vEstadoDescr,
            'vEstadoUF'          => $row->vEstadoUF,
            'vCidadeId'          => $row->vCidadeId,
            'vCidadeDescr'       => $row->vCidadeDescr,
            'vOrganizacao'       => $row->vOrganização,
            'vDeficienciaId'     => $row->vDeficienciaId,
            'vDeficiencia'       => $row->vDeficiencia,
            'vPossuiDeficiencia' => $row->vPossuiDeficiencia,
            'vObs'               => $row->vObs,
            'vProjetos'          => $projetos,
            'vFotos'             => $fotos,
            'vAprovadas'         => $aprovadas
          );

          if ($alterar) {
            $img = base_url().$this->config->item('img_usu_padrao');
            if ($row->vImgNomeUniq != '') {
              $img = base_url().'assets/img/users/'.$row->vImgNomeUniq;
            }

            $_SESSION['logged_in_colabad']['sesColabad_vImg'] = $img;
            $_SESSION['logged_in_colabad']['sesColabad_vImgAlt'] = $row->vImgAudiodesc;
          }
        }
      } else {
        $dados = array(     
            'result'   => 'ERRO',
            'mensagem' => '<strong>Usuário não encontrado</strong>'
          );
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

  private function usuTotProjetos($id) {
    $retorno = '0'; //default

    $sql = "SELECT COUNT(P.PROJ_ID) TOT
            FROM proj_cadastro P
            WHERE P.USU_ID = $id
              OR P.PROJ_ID IN 
                (SELECT C.PROJ_ID 
                FROM proj_participantes C 
                WHERE C.USU_ID = $id ) ; ";

    $query = $this->db->query($sql);
    
    if ($query->num_rows() > 0){
      $retorno = $query->result()[0]->TOT;
    }

    return $retorno;
  }

  private function usuTotFotos($id) {
    $retorno = '0'; //default

    $sql = "SELECT COUNT(I.IMG_ID) TOT
            FROM img_log I
            WHERE I.USU_ID = $id
            AND I.LT_ID = 1 ; ";

    $query = $this->db->query($sql);
    
    if ($query->num_rows() > 0){
      $retorno = $query->result()[0]->TOT;
    }

    return $retorno;
  }

  private function usuTotAprovadas($id) {
    $retorno = '0'; //default

    $sql = "SELECT COUNT(C.IMG_ID) TOT
            FROM img_cadastro C
            WHERE C.IMG_STATUS = 'A'
            AND C.IMG_ID IN (SELECT I.IMG_ID
                            FROM img_log I
                            WHERE I.USU_ID = $id
                            AND I.LT_ID = 1 ) ; ";

    $query = $this->db->query($sql);
    
    if ($query->num_rows() > 0){
      $retorno = $query->result()[0]->TOT;
    }

    return $retorno;
  }

  public function salvarPerfil($imagem, $edNome, $edEmail, $edPass, $edAudiodescricao, $cbEstado, $cbCidade, $edOrg, $cbDefic, $cbQual, $edObs, $rbPerfil) {
    try{
      $id = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];

      $USU_IMG_NOME           = '';
      $USU_IMG_NOMEUNIQ       = '';
      $USU_IMG_TYPE           = '';

      if ($imagem != null) {
        // Pega extensão da imagem
        $ext = explode(".", $imagem['name']);
        $ext = end($ext);
   
        // Gera um nome único para a imagem
        $nome_imagem = $id.".png";

        // Caminho de onde ficará a imagem
        $caminho = realpath(APPPATH.'../');
        $caminho = $caminho.'/assets/img/users/';
        $caminho_imagem = $caminho . $nome_imagem;
        
        if (file_exists($caminho_imagem)) {
          unlink($caminho_imagem);
        }

        // Faz o upload da imagem para seu respectivo caminho
        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);

        $img = base_url().$this->config->item('img_usu_padrao');
        if ($nome_imagem != '') {
          $img = base_url().'assets/img/users/'.$nome_imagem;
        }

        $USU_IMG_NOME     = ' USU_IMG_NOME = '.$this->db->escape($imagem['name']).', ';
        $USU_IMG_NOMEUNIQ = ' USU_IMG_NOMEUNIQ = '.$this->db->escape($nome_imagem).', ';
        $USU_IMG_TYPE     = ' USU_IMG_TYPE = '.$this->db->escape($imagem['type']).', ';
      }

      $hash = '';
      if ($edPass != '') {
        $hash = password_hash($edPass, PASSWORD_BCRYPT);
        $hash = " USU_PWD = '".$hash."'";
      } 

      $link = ' USU_LINK = '.$this->db->escape(criaLink($edNome)).', ';

      $edAudiodescricao = ($edAudiodescricao != '')  ? ' USU_IMG_AUDIODESCRICAO = '.$this->db->escape($edAudiodescricao).', ' : '';
      $edNome   = ($edNome != '')   ? ' USU_NOME = '.$this->db->escape($edNome).', '   : '';
      $edEmail  = ($edEmail != '')  ? ' USU_EMAIL = '.$this->db->escape($edEmail).', ' : '';
      $edPass   = ($edPass != '')   ? ' USU_PWD = '.$this->db->escape($hash).', '      : '';
      $cbEstado = ($cbEstado != '') ? ' EST_ID = '.$this->db->escape($cbEstado).', '   : '';
      $cbCidade = ($cbCidade != '') ? ' CID_ID = '.$this->db->escape($cbCidade).', '   : '';
      $edOrg    = ($edOrg != '')    ? ' USU_ORG = '.$this->db->escape($edOrg).', '     : '';
      $cbDefic  = ($cbDefic != '')  ? ' USU_DEF = '.$this->db->escape($cbDefic).', '   : '';
      $cbQual   = ($cbQual != '')   ? ' DEF_ID = '.$this->db->escape($cbQual).', '     : '';
      $edObs    = ($edObs != '')    ? ' USU_OBS = '.$this->db->escape($edObs).', '     : '';
      $rbPerfil = ($rbPerfil != '') ? ' PERF_ID = '.$this->db->escape($rbPerfil).', '     : '';

      $update = 
        $link.
        $USU_IMG_NOME.
        $USU_IMG_NOMEUNIQ.
        $USU_IMG_TYPE.
        $edAudiodescricao.
        $edNome.
        $edEmail.
        $edPass.
        $cbEstado.
        $cbCidade.
        $edOrg.
        $cbDefic.
        $cbQual.
        $edObs.
        $rbPerfil;

      $update = substr($update, 0, -2);

      $sql = " UPDATE usu_usuario
               SET $update
               WHERE USU_ID = $id ;";

      /*echo "<pre>";
      print_r($sql);
      exit;*/
      $this->db->query($sql);
      $this->auth->logUsuario('usu_usuario', $id, 3);

      $this->load->model('acesso/login_model', 'login');
      $this->login->carregaSessao($id);

      $this->session->set_flashdata('perfil_ok', 'Perfil alterado com sucesso!');

      return
        array(
          'result' => 'OK',
          'mensagem' => ''
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
                     I.IMG_NOMEUNIQ vNomeUnico,,
                     CASE
                      WHEN I.IMG_STATUS = 'P' THEN ' has-default '
                      WHEN I.IMG_STATUS = 'A' THEN ' has-success '
                      WHEN I.IMG_STATUS = 'R' THEN ' has-danger '
                      WHEN I.IMG_STATUS = 'V' THEN ' has-primary '
                      ELSE ''
                     END vStatusClass,
                     
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
            'vStatusClass'    => $row->vStatusClass,
            'vParticipante'   => array(),
            'vHistorico'      => array()
          );
        }

        //busca participantes
        $sql = "SELECT DISTINCT(U.USU_NOME) vNome,
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
              'vPerfil'      => $row->vPerfil
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
