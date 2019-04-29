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

        $token = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123467890';
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);

        $hash = password_hash($edPass, PASSWORD_BCRYPT);

        $dados = array(
          'USU_NOME'  => $edNome,
          'USU_EMAIL' => $edEmail,
          'USU_PWD'   => $hash,
          'USU_TOKEN' => $token
        ); 

        $emailResult = $this->email->envia_verificacao($edEmail, $token);

        if ($emailResult['result'] == 'OK') {
          $this->db->insert('usu_usuario', $dados);
          $id = $this->db->insert_id();
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

  function verificarEmail($email) {
    $tabela = 'usu_usuario';
    $dados  = 
      array(
        'USU_EMAIL' => $email
      );
    $dataFiltered = $this->db->get_where($tabela, $dados)->num_rows();
    return $dataFiltered;
  }

  function login($form) {
    if (isset($form)) { 
      parse_str($form, $values); 

      // AQUI VALIDA NO SICREDI
      $sicrediLogin = $this->input->post('edUsername');
      $sicrediSenha = $this->input->post('edPassword');

      $result = $this->auth->autenticacaoLDAP($sicrediLogin, $sicrediSenha);

      if ($result) {
        //se validou no sistema do Sicredi então busca usuário na base
        $login = $this->auth->login($sicrediLogin);

        if (isset($login)) {
          $session_data = array(
              'sessao_agile'        => $result,
              'sessao_cod_user'     => $login['cod'],
              'sessao_usuario_user' => $login['usuario'],
              'sessao_nome_user'    => $login['nome'],
              'sessao_cod_pes'      => $login['codPes'],
              'sessao_cod_cargo'    => $login['codCargo'],
              'sessao_sis_acesso'   => $login['sisAcessos']
          );

          $this->session->set_userdata('logged_in_agile', $session_data);
          redirect(base_url());
        } else {
          $this->session->set_flashdata('message', 'Usuário não possui perfil no Agile');
          redirect(base_url().'login');
        }

      } else {
        $this->session->set_flashdata('message', 'Usuário ou Senha inválidos');
        redirect(base_url().'login');
      }
    }
  }

}
