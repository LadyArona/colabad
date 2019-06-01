<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->model('Email_model', 'email');
  }

  function salvarCadastro($form){
    $id  = 0;
    $values = array();

    if (isset($form)) { 
      parse_str($form, $values); 

      try{
        $edNome          = (isset($values['edNome']))          ? $values['edNome']          : null;
        $edEmail         = (isset($values['edEmail']))         ? $values['edEmail']         : null;
        $edPass          = (isset($values['edPass']))          ? $values['edPass']          : null;
        $txtDetalhe      = (isset($values['txtDetalhe']))      ? $values['txtDetalhe']      : null;
        $txtConhecimento = (isset($values['txtConhecimento'])) ? $values['txtConhecimento'] : null;

        $token = gerarToken();
        $hash  = password_hash($edPass, PASSWORD_BCRYPT);
        $link = criaLink($edNome);

        $dados = array(
          'USU_NOME'  => $edNome,
          'USU_EMAIL' => $edEmail,
          'USU_PWD'   => $hash,
          'USU_TOKEN' => $token,
          'USU_LINK'  => $link
        ); 

        $data['tipo'] = 'verificacao';
        $data['para'] = $edEmail;
        $data['conteudo'] = $token;

        $emailResult = $this->email->envia_email($data);

        if ($emailResult['result'] == 'OK') {
          $this->db->insert('usu_usuario', $dados);
          $id = $this->db->insert_id();
          $this->auth->logUsuario('usu_usuario', $id, 1);
        }

        return $emailResult;
      } catch(PDOException $e) { 
         return array(
            'result'   => 'ERRO',
            'mensagem' => 'Erro: ' . $e->getMessage()
          );
      }
    }
  }

  function esqueceuSenha($form){
    $values = array();

    if (isset($form)) { 
      parse_str($form, $values); 

      try{
        $edEmail = (isset($values['edEmailLogin'])) ? $values['edEmailLogin'] : null;

        $token = gerarToken();

        $sqlU = " UPDATE usu_usuario U
                 SET U.USU_PWDTOKEN = '$token',
                     U.USU_PWDTOKENEXP = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 15 MINUTE)
                 WHERE U.USU_EMAIL = '$edEmail' ;";
        $this->db->query($sqlU);        

        $data['tipo'] = 'esqueceu';
        $data['para'] = $edEmail;
        $data['conteudo'] = $token;

        $emailResult = $this->email->envia_email($data);
        $this->auth->logUsuario('recuperar_senha', 0, 4);

        return $emailResult;
      } catch(PDOException $e) { 
         return array(
            'result'   => 'ERRO',
            'mensagem' => 'Erro: ' . $e->getMessage()
          );
      }
    }
  }

  function mudarSenha($form){
    $values = array();

    if (isset($form)) { 
      parse_str($form, $values); 

      try{
        $edToken    = (isset($values['edToken']))    ? $values['edToken']    : null;
        $edNivelSec = (isset($values['edNivelSec'])) ? $values['edNivelSec'] : null;
        $edPass     = (isset($values['edPass']))     ? $values['edPass']     : null;
        $hash       = password_hash($edPass, PASSWORD_BCRYPT);

        $sqlU = " UPDATE usu_usuario U
                  SET U.USU_PWD  = '$hash',
                      U.USU_PWDTOKEN = NULL
                  WHERE U.USU_ID = $edNivelSec
                   AND U.USU_PWDTOKEN = '$edToken'
                   AND CURRENT_TIMESTAMP <= U.USU_PWDTOKENEXP ; ";
        $query = $this->db->query($sqlU);
        $id    = $this->db->affected_rows();

        if ($id > 0) {
          $this->auth->logUsuario('usu_usuario', $id, 5);
          return array(
            'result'   => 'OK',
            'mensagem' => 'Senha alterada'
          );
        } else {
          return array(
            'result'   => 'ERRO',
            'mensagem' => 'Token expirou, repita o procedimento'
          );
        }
      } catch(PDOException $e) { 
         return array(
            'result'   => 'ERRO',
            'mensagem' => 'Erro: ' . $e->getMessage()
          );
      }
    }
  }

  function verificarEmail($email) {
    $dados  = array();

    if ($this->session->userdata('logged_in_colabad') != null) {
      //está verificando na alteração do perfil
      //não dá problema pois o usuário logando não consegue acessar a página de cadastro
      $dados['USU_ID!='] = $this->session->userdata('logged_in_colabad')['sesColabad_vId'];
    }

    $tabela = 'usu_usuario';
    $dados['USU_EMAIL'] = $email;
    $dataFiltered = $this->db->get_where($tabela, $dados)->num_rows();
    return $dataFiltered;
  }

  function login($form) {
    if (isset($form)) { 
      parse_str($form, $values); 

      $login = $values['edEmailLogin'];
      $senha = $values['edPassLogin'];

      //busca dados do usuário
      $this->db->select(
        "U.USU_ID,
         U.USU_CADDATA,
         U.USU_SITUACAO,
         SUBSTRING_INDEX(SUBSTRING_INDEX(U.USU_NOME, ' ', 1), ' ', -1) USU_NOME,
         U.USU_NOME NOME,
         U.USU_EMAIL,
         U.USU_PWD,
         U.USU_EMAILCONF,
         U.USU_TOKEN,
         U.PERF_ID,
         P.PERF_NIVEL,
         U.USU_LINK,
         USU_IMG_NOMEUNIQ,
         USU_IMG_AUDIODESCRICAO
         ")    
      ->from('usu_usuario U')
      ->join('usu_perfil P', ' P.PERF_ID = U.PERF_ID')
      ->where('U.USU_EMAIL', $login)
      ->limit(1);
      
      $query = $this->db->get();

      if($query->num_rows() == 1){
        $row = $query->result()[0];
        if (password_verify($senha, $row->USU_PWD)) {
          if ($row->USU_SITUACAO == 'I') {
            return 
              array(
                'result'   => 'ERRO',
                'mensagem' => 'Usuário Inativo! <br> Entre em contato com a nossa equipe'
              );
            exit;
          }

          if ($row->USU_EMAILCONF == 0) {
            return 
              array(
                'result'   => 'ERRO',
                'mensagem' => 'Email não verificado! <br> Verifique seu email para poder entrar'
              );
            exit;
          }

          $img = base_url().$this->config->item('img_usu_padrao');
          if ($row->USU_IMG_NOMEUNIQ != '') {
            $img = base_url().'assets/img/users/'.$row->USU_IMG_NOMEUNIQ;
          }

          $session_data = array(
            'sesColabad'              => true,
            'sesColabad_vId'          => $row->USU_ID,
            'sesColabad_vCadastro'    => $row->USU_CADDATA,
            'sesColabad_vStatus'      => $row->USU_SITUACAO,
            'sesColabad_vNome'        => $row->USU_NOME,
            'sesColabad_vEmail'       => $row->USU_EMAIL,
            'sesColabad_vPw'          => $row->USU_PWD,
            'sesColabad_vEmailConf'   => $row->USU_EMAILCONF,
            'sesColabad_vPerfilId'    => $row->PERF_ID,
            'sesColabad_vPerfilNivel' => $row->PERF_NIVEL,
            'sesColabad_vLink'        => $row->USU_LINK,
            'sesColabad_vImg'         => $img,
            'sesColabad_vImgAlt'      => $row->USU_IMG_AUDIODESCRICAO
          );

          //atualiza ultimo login
          $this->auth->logUsuario('usu_usuario', $row->USU_ID, 2);

          $this->session->set_userdata('logged_in_colabad', $session_data);
          return 
            array(
              'result'   => 'OK',
              'mensagem' => 'Entrando!'
            );
          exit;
        } else {
          return 
            array(
              'result'   => 'ERRO',
              'mensagem' => 'Senha inválida!'
            );
          exit;
        }
      }
    }
  }

}
