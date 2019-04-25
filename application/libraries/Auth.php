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

  function autenticacaoLDAP ($sicrediLogin, $sicrediSenha) {
    /*LDAP: base de dados local com as informações de identidades e entidades. Nela contam os dados e
    informações dos colaboradores, tais como fotos e senhas, entre outros. Somente após a replicação desta
    base de dados para o servidor local, efetuada durante o processo de instalação, os colaboradores
    conseguirão os devidos acessos. Este processo ocorre diariamente, de forma automática, durante a noite,
    quando todas as bases das Cooperativas são geradas e descarregadas nos respectivos servidores de UA.*/

    $dominio = "@sicredi.com.br";
    $usuarioSicredi = $sicrediLogin.$dominio;

    if(strpos($sicrediLogin, $dominio)) {
      $usuarioSicredi = $sicrediLogin;
    }

    $sicrediSenha =  $sicrediSenha;
    $ip_server    = "172.21.12.59";

    $ldap_server  = $ip_server;
    $auth_user    = $usuarioSicredi;
    $auth_pass    = $sicrediSenha;
    // $base_dn = "cn=users,dc=sicredi,dc=com,dc=br";

    // Tenta se conectar com o servidor
    if (!($connect = @ldap_connect($ldap_server, '389'))){
      return FALSE;
    }

    // Tenta autenticar no servidor
    if (!(@ldap_bind($connect, $auth_user, $auth_pass))) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function login($sicrediLogin){

    $this->CI->db->select('
                U.USU_CODIGO,
                U.USU_USUARIO,
                P.PES_ID,
                P.PES_NOME,
                P.CARG_ID,
                (SELECT GROUP_CONCAT(A.SIS_ID) FROM usu_acessosistema A WHERE A.USU_CODIGO = U.USU_CODIGO) SISTEMAS
             ')    
             ->from('usu_usuario U')
             ->join('conf_pessoas P', ' P.PES_ID = U.PES_ID')
             ->where('U.USU_USUARIO', $sicrediLogin)
             ->where('U.USU_SITUACAO', 'A')
             ->limit(1);
    
    $query = $this->CI->db->get()->row();
    
    if(count($query) == 1){
        $dados = array(
         'cod'        => $query->USU_CODIGO,
         'usuario'    => $query->USU_USUARIO,
         'nome'       => $query->PES_NOME,
         'codPes'     => $query->PES_ID,
         'codCargo'   => $query->CARG_ID,
         'sisAcessos' => $query->SISTEMAS
        );

        //atualiza contador e ultimo login
        $sqlU = "UPDATE usu_usuario U
                 SET U.USU_CONTACESSO = (U.USU_CONTACESSO + 1),
                     U.USU_ULTIMOACESSO = CURRENT_TIMESTAMP
                 WHERE U.USU_CODIGO = $query->USU_CODIGO ";
        $this->CI->db->query($sqlU);

        return $dados;
      } else {
        return null;
      }
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