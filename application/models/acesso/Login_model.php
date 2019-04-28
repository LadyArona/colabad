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

}
