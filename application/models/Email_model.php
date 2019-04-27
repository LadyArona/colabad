<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

    public function __construct(){
      parent::__construct();
    }

    function envia_verificacao($para, $verificacao){
      $html = "Dear User,\nPlease click on below URL or paste into your browser to verify your Email Address\n\n http://www.yourdomain.com/verify/".$verificacao."\n"."\n\nThanks\nAdmin Team";

      $config = 
        array(
          'protocol'  => 'smtp',
          'smtp_host' => 'smtp.gmail.com',
          'smtp_port' => 587,
          'smtp_user' => 'tallinydn@gmail.com', // change it to yours
          'smtp_pass' => '022189Adn', // change it to yours
          'mailtype'  => 'html',
          'charset'   => 'iso-8859-1',
          'wordwrap'  => TRUE
        );
       
      $this->load->library('email', $config);

      $this->email->set_newline("\r\n");
      $this->email->from('tallinydn@gmail.com', "Talliny ColabAD");
      $this->email->to($para);  
      $this->email->subject("Email Verification");
      $this->email->message($html);
      $this->email->send();

      echo "foi";
    }

    function verifica_email($codigo){  
      $sql = "update trn_user set active_status='A' WHERE email_verification_code=?";
      $this->db->query($sql, array($codigo));
      return $this->db->affected_rows(); 
    }
  }
?>
