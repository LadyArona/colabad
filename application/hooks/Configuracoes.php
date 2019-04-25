<?php

class Configuracoes {
  function carregaConfigSite(){
    $CI =& get_instance();

    $CI->load->model('App_model', 'cfg');

    $config = $CI->cfg->configuracoes();

    foreach ($config as $key => $value) {
      $CI->config->set_item($key, $value);
    }
  }

  function author(){
    $CI =& get_instance();
      $CI->auth->CheckAuth($CI->router->fetch_class(), $CI->router->fetch_method());
  }
}
