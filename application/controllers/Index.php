<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();         
    }

    public function index()
    {        
        $data['title']    = 'Início';
        $data['conteudo'] = 'index';
        
        $this->load->view('index'); 
    }

    function logout()
    {        
        $this->auth->logout();  
    }    

}
