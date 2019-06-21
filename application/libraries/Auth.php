<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth {
  private $CI; // Receberá a instância do Codeigniter
  private $permissaoView = 'mensagem'; // Recebe o nome da view correspondente à página informativa de usuário sem permissão de acesso
  private $loginView     = 'login'; // Recebe o nome da view correspondente à tela de login
  private $index         = 'index'; // Recebe o nome da view correspondente à tela de inicio
  
  public function __construct(){
    /*
     * Criamos uma instância do CodeIgniter na variável $CI
     */
    $this->CI = &get_instance();
  }

  function CheckAuth($classe, $metodo, $valida=false) {
    // antes de autenticar, testa a sessão de 15 minutos
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] >= 900)) {
        // last request was more than 15 minutes ago
      $this->logout();
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

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
       * Mas se for privado (maior que 0) então é verificado o login e a permissão do usuário
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
        $id_tela = $resultMetodos[0]->TELA_ID;

        $login = $this->CI->session->userdata('logged_in_colabad');

        $sessao_colabad      = $login['sesColabad']; //$logged_in_colabad
        $sessao_cod_user     = $login['sesColabad_vId']; //$id_usuario
        $sessao_usuario_user = $login['sesColabad_vEmail'];
        $sessao_usu_nivel    = $login['sesColabad_vPerfilNivel'];
        /*
         * Se o usuário estiver logado faz a verificação da permissão
         * caso contrário redireciona para uma tela de login
         */
        if($sessao_usu_nivel && $sessao_colabad && $sessao_cod_user){
          /*
           * Se o usuário não tiver a permissão para acessar o método,
           * ou seja, não estiver relacionado na tabela "permissoes",
           * ele deve ser redirecionado para uma tela informando que
           * não tem permissão de acesso;
           * caso contrário o acesso é liberado
           */
          if($sessao_usu_nivel < $resultMetodos[0]->TELA_PRIVADO){
            if ($valida) {
              return false;
            } else {
              // não possui permissão'
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
            redirect(base_url($this->loginView), 'refresh');
          }
        }
      }
    }
  }

  function logout() {
    if ($this->CI->session->userdata() != null) {
      $this->CI->session->unset_userdata('logged_in_colabad');
      $this->CI->session->sess_destroy(); //destroi a sessao
    }
    redirect(base_url()); // redireciona para a raiz do sistema(pagina de login)
  }

  function logUsuario ($origem, $id, $tipo) {
    $tabela = 'usu_log';

    $usuario = $this->CI->session->userdata('logged_in_colabad') != null ? $this->CI->session->userdata('logged_in_colabad')['sesColabad_vId'] : $id;
    $perfil = $this->CI->session->userdata('logged_in_colabad') != null ? $this->CI->session->userdata('logged_in_colabad')['sesColabad_vPerfilId'] : null;

    $dados = 
      array(
        'LOG_ORIGEM'    => $origem,
        'LOG_ORIGEM_ID' => $id,
        'LT_ID'         => $tipo,
        'USU_ID'        => $usuario,
        'PERF_ID'       => $perfil
      );

    $this->CI->db->insert($tabela, $dados);
  }

}
