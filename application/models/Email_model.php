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

      $mail->SMTPSecure = 'ssl';
      $mail->Mailer     = 'smtp';
      $mail->Host       = 'smtp.gmail.com';
      $mail->Port       = 465; // or 587

      $mail->Username   = 'tallinydn@gmail.com';
      $mail->Password   = '022189Adn';

      $mail->setFrom('tallinydn@gmail.com', 'Talliny ColabAD');
      $mail->addReplyTo('tallinydn@gmail.com', 'Talliny ColabAD');
      
      // Add a recipient
      $mail->addAddress($para);
      
      // Add cc or bcc 
      //$mail->addCC($para);
      //$mail->addBCC($para);
      
      // Email subject
      $mail->Subject = 'ColabAD - Confirme seu email';
      
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
