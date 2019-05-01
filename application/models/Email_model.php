<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

    public function __construct(){
      parent::__construct();
    }

    function envia_verificacao($para, $verificacao){
      // Load PHPMailer library
      $this->load->library('phpmailer_lib');
      
      // PHPMailer object
      $mail = $this->phpmailer_lib->load();
      
      // SMTP configuration
      $mail->isSMTP();
      //$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only

      //$mail->SMTPAuth   = true;
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
      $mail->addAddress($para);
      
      // Add cc or bcc 
      //$mail->addCC($para);
      //$mail->addBCC($para);
      
      // Email subject
      $mail->Subject = $this->config->item('abrv').' - Confirme seu email';
      
      // Set email format to HTML
      $mail->isHTML(true);
      
      // Email body content
      
      $data['verificacao'] = $verificacao;
      $mailContent = $this->load->view('emails/verificar', $data, true);

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
            'mensagem' => 'agora verifique seu email!'
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
  }
?>
