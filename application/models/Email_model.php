<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

    public function __construct(){
      parent::__construct();
    }

    function envia_email($data){
      $this->load->library('phpmailer_lib');
      $mail = $this->phpmailer_lib->load();
      $mail->isSMTP();
      //$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
      $mail->SMTPAuth   = true; // authentication enabled
      $mail->SMTPSecure = false;

      $mail->SMTPSecure = $this->config->item('email_SMTPSecure');
      $mail->Mailer     = $this->config->item('email_Mailer');
      $mail->Host       = $this->config->item('email_Host');
      $mail->Port       = $this->config->item('email_Port');

      $mail->Username   = $this->config->item('email_Username');
      $mail->Password   = $this->config->item('email_Password');

      $mail->setFrom($this->config->item('email_Username'), $this->config->item('email_Autor'));
      $mail->addReplyTo($this->config->item('email_Username'), $this->config->item('email_Autor'));
      
      // Add a recipient
      $mail->addAddress($data['para']);
      
      // Add cc or bcc 
      //$mail->addCC($para);
      //$mail->addBCC($para);
      $assunto = '';
      $caminho = '';

      if ($data['tipo'] == 'verificacao') {
        $caminho = 'emails/verificar';
        $assunto = ' - Confirme seu email';
      }

      if ($data['tipo'] == 'esqueceu') {
        $caminho = 'emails/esqueceu';
        $assunto = ' - Recuperar senha';
      }

      // Email subject
      $mail->Subject = $this->config->item('abrv').$assunto;
      
      // Set email format to HTML
      $mail->isHTML(true);
      
      // Email body content
      $mailContent = $this->load->view($caminho, $data, true);

      $mail->Body = $mailContent;
      
      // Send email
      if(!$mail->send()){
        $result = 
          array(
            'result'   => 'ERRO',
            'mensagem' => 'Email não pode ser enviado <br> Mailer Error: ' . $mail->ErrorInfo
          );
      } else {
         $result = 
          array(
            'result'   => 'OK',
            'mensagem' => 'verifique seu email!'
          );
      }

      return $result;
    }

    function verifica_email($codigo){
      $sql = "UPDATE usu_usuario U
              SET U.USU_EMAILCONF = 1
              WHERE U.USU_TOKEN = ? ;";
      $this->db->query($sql, array($codigo));
      return ($this->db->affected_rows() > 0) ? 'OK' : 'ERRO';
    }

    function verifica_token($codigo){
      $retorno = '0';

      $sql = "SELECT U.USU_ID
              FROM usu_usuario U
              WHERE U.USU_PWDTOKEN = ? 
              AND CURRENT_TIMESTAMP <= U.USU_PWDTOKENEXP ;";

      $query = $this->db->query($sql, array($codigo));

      if ($query->num_rows() > 0){
        $retorno = $query->result()[0]->USU_ID;
      }

      return $retorno;
    }
  }
?>
