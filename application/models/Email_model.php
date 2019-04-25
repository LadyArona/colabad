<?php
  class Email_model extends Model {
    function Email_model(){
      parent::Model();
    }

    function envia_verificacao($email, $html){
      $html = "Dear User,\nPlease click on below URL or paste into your browser to verify your Email Address\n\n http://www.yourdomain.com/verify/".$verificationText."\n"."\n\nThanks\nAdmin Team";

      $config = 
        array(
          'protocol'  => 'smtp',
          'smtp_host' => 'smtp.yourdomain.com.',
          'smtp_port' => 465,
          'smtp_user' => 'admin@yourdomain.com', // change it to yours
          'smtp_pass' => '########', // change it to yours
          'mailtype'  => 'html',
          'charset'   => 'iso-8859-1',
          'wordwrap'  => TRUE
        );
       
      $this->load->library('email', $config);

      $this->email->set_newline("\r\n");
      $this->email->from('admin@yourdomain.com', "Admin Team");
      $this->email->to($email);  
      $this->email->subject("Email Verification");
      $this->email->message($html);
      $this->email->send();
    }

    function verifica_email($codigo){  
      $sql = "update trn_user set active_status='A' WHERE email_verification_code=?";
      $this->db->query($sql, array($codigo));
      return $this->db->affected_rows(); 
    }
  }
?>
