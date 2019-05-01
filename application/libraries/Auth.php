<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth {
  private $CI; // Receberá a instância do Codeigniter
  private $permissaoView = 'login'; // Recebe o nome da view correspondente à página informativa de usuário sem permissão de acesso
  private $loginView     = 'login'; // Recebe o nome da view correspondente à tela de login
  private $index         = 'index'; // Recebe o nome da view correspondente à tela de login
  
  public function __construct(){
    /*
     * Criamos uma instância do CodeIgniter na variável $CI
     */
    $this->CI = &get_instance();
  }

  function CheckAuth($classe, $metodo, $valida=false) {
    $classe = $classe; //detalhado
    $metodo = $metodo; //1
    /*
     * Pesquisa a classe e o método passados como parâmetro em CheckAuth
     */
    $array = array('TELA_CAMINHO' => $classe);
    $qryMetodos = $this->CI->db->where($array)->get('usu_tela');
    $resultMetodos = $qryMetodos->result();
    /*
     * Caso a classe passada ainda não conste na tabela "usu_tela"
     * ele é inserido através de $this->CI->db->insert('metodos', $data);
     */
    if (count($resultMetodos)==0) {
      $data = array(
        'TELA_CAMINHO' => $classe,
        'TELA_PRIVADO'  => 1
      );
      $this->CI->db->insert('usu_tela', $data);
      redirect(base_url($classe), 'refresh');
    } else {
      /*
       * Se o método ja existir na tabela, então recupera se ele é público ou privado
       * O método sendo público (0), então não verifica o login e libera o acesso
       * Mas se for privado (1) então é verificado o login e a permissão do usuário
       */
      if($resultMetodos[0]->TELA_PRIVADO==0){
        if ($valida) {
          //verifica se a tela é pública ou privada
            return true;
          } else {
            return false;
          }
      } else {
        //$data
        //$email      = $this->CI->session->userdata('email');
        $id_tela = $resultMetodos[0]->TELA_CODIGO;

        $login = $this->CI->session->userdata('logged_in_agile'); //$logged_in_agile

        $sessao_agile        = $login['sessao_agile']; //$logged_in_agile
        $sessao_cod_user     = $login['sessao_cod_user']; //$id_usuario
        $sessao_usuario_user = $login['sessao_usuario_user'];
        $sessao_nome_user    = $login['sessao_nome_user']; //$nome
        $sessao_cod_pes      = $login['sessao_cod_pes'];
        /*
         * Se o usuário estiver logado faz a verificação da permissão
         * caso contrário redireciona para uma tela de login
         */
        if($sessao_nome_user && $sessao_agile && $sessao_cod_user){
          $array = array('TELA_CODIGO' => $id_tela, 'USU_CODIGO' => $sessao_cod_user);
          $qryPermissoes = $this->CI->db->where($array)->get('usu_acessotela');
          $resultPermissoes = $qryPermissoes->result();
/*
    echo "<pre>";
    print_r($this->CI->db->last_query());
    exit;*/
          /*
           * Se o usuário não tiver a permissão para acessar o método,
           * ou seja, não estiver relacionado na tabela "permissoes",
           * ele deve ser redirecionado para uma tela informando que
           * não tem permissão de acesso;
           * caso contrário o acesso é liberado
           */
          if(count($resultPermissoes)==0){
            if ($valida) {
              return false;
            } else {
              $this->CI->session->set_flashdata('message', 'Você não possui permissão');
              redirect(base_url($this->permissaoView), 'refresh');
            }
          } else {
            return true;
          }
        } else {
          if ($valida) {
            //verifica se a tela é pública ou privada
            return false;
          } else {
            $this->CI->session->set_flashdata('message', 'Tela privada, efetue login e/ou solicite permissão');
            redirect(base_url($this->loginView), 'refresh');
          }
        }
      }
    }
  }

  function logout()
  {
    if ($this->CI->session->userdata() != null) {
      $this->CI->session->unset_userdata('logged_in_agile');
      $this->CI->session->sess_destroy(); //destroi a sessao
    }
    redirect(base_url()); // redireciona para a raiz do sistema(pagina de login)
  }  

}
