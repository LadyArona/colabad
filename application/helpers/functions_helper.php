<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('autenticacaoLDAP')){

}

if ( ! function_exists('criaLink')){
  function criaLink($str){
    $slug = $str;
    $slug = sanitizeString($slug, false);
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug);
    $slug = strtolower($slug);
    $slug = substr($slug, 0, 50);

    return $slug;
  }
}

if(! function_exists('sanitizeString')){
  function sanitizeString($str, $under = true) {
    $str = trim($str);
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    $str = trim($str);
    if ($under) {
      //$str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '', $str);
      $str = preg_replace('/[,(),;:|!"#$%&=?~^><ªº-]/', '', $str);
      $str = preg_replace('/[^a-z0-9]/i', '_', $str);
      $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
      $str = strtolower($str);
    }
    return $str;
  }
}

if ( ! function_exists('gerarToken')){
  function gerarToken($tam = 12){
    $token = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123467890';
    $token = str_shuffle($token);
    $token = substr($token, 0, $tam);

    return $token;
  }
} 

if ( ! function_exists('formataValor')){

    function formataValor($valor, $tipo = 1){
      // 1 - americano para real
      // 2 - real para americano
      if ($tipo == 1){
        return number_format($valor, 2, ',', '.');
      }else if($tipo == 2){
          return str_replace(',','.', str_replace('.','',  $valor));
      }
    }
} 

  /*FUNÇÃO USADA PARA CONVERTER A DATA PARA SALVAR NO BANCO*/
  /*O PADRÃO DOS SEPARADORES PARA SALVAR É '-' E '/' */
if ( ! function_exists('formataData')){
    function formataData( $data, $separador1, $separador2 ) {
        return implode( $separador1, array_reverse( explode( $separador2, $data ) ) );
    }
}

if ( ! function_exists('formataDataHora')){
    function formataDataHora($dataHora, $separador1, $separador2){
      $dataHora = explode(" ", $dataHora);
      return formataData($dataHora[0], $separador1, $separador2).' '.$dataHora[1];
    }
}

if ( ! function_exists('retornaDataHoraTexto')){
    function retornaDataHoraTexto($dataHora, $hora = true){
      $dataHora = strtotime($dataHora);
      return utf8_encode(
                ucwords(strftime('%A', $dataHora)).', '.strftime('%d',  $dataHora).' de '.ucwords(strftime('%B', $dataHora)).' de '.strftime('%Y', $dataHora).(($hora) ? ' &agrave;s '.strftime('%H:%M', $dataHora) : '')
             );
    }
}

if ( ! function_exists('somarDiasUteis')){
  function somarDiasUteis($str_data, $int_qtd_dias_somar = 7, $feriados = array('')) {

      // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
      // Transforma para DATE - aaaa-mm-dd
      $str_data = substr($str_data, 0, 10);
      
      // Se a data estiver no formato brasileiro: dd/mm/aaaa
      // Converte-a para o padrão americano: aaaa-mm-dd
      if ( preg_match("@/@", $str_data) == 1 ) {
          $str_data = implode("-", array_reverse(explode("/", $str_data)));
      }
      $array_data = explode('-', $str_data);
      $count_days = 0;
      $int_qtd_dias_uteis = 0;
      while ( $int_qtd_dias_uteis < $int_qtd_dias_somar ) {
          $count_days++;
          $currDate = gmdate('Y-m-d',strtotime('+'.$count_days.' day',strtotime($str_data)));
          
          if ( ( $dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' && !in_array($currDate, $feriados) ) {
             $int_qtd_dias_uteis++;
          }
      }
      return gmdate('Y-m-d',strtotime('+'.$count_days.' day',strtotime($str_data)));
  }
}

if ( ! function_exists('diferencaEmDias')){
  function diferencaEmDias($data1, $data2){
   
      // diferença em segundos entre as datas 2 e 1
      $diferenca = strtotime($data2) - strtotime($data1);
   
      // 1 dia = 86400 segundos
      $segundos_de_um_dia = 60 * 60 * 24;
   
      // total de dias entre as datas
      $dias = intval( $diferenca / $segundos_de_um_dia );
   
      return $dias;
  }
}

/*
  function percentDataAtingimento($data_inicial, $data_final){
    
    $data_atual = date('Y-m-d');

    // retorna número de dias entre a data inicial e final
    $dias_dtInicial_x_dtFinal = diferencaEmDias($data_inicial, $data_final);
       
    // retorna número de dias entre a data atual e inicial
    $dias_dtAtual_x_dtInicial = $data_atual > $data_inicial ? diferencaEmDias($data_inicial, $data_atual) : diferencaEmDias($data_atual, $data_inicial);

    $porcentagem = $dias_dtInicial_x_dtFinal != 0 ? round((($dias_dtAtual_x_dtInicial / $dias_dtInicial_x_dtFinal) * 100), 2) : 0;

    return $porcentagem;
  }
*/

if ( ! function_exists('percentDataAtingimento')){
  function percentDataAtingimento($data_inicial, $data_final){
    
    $data_atual = date('Y-m-d');

    // retorna número de dias entre a data inicial e final
    $dias_dtInicial_x_dtFinal = diferencaEmDias($data_inicial, $data_final);
    
    // retorna número de dias entre a data atual e inicial
    $dias_dtAtual_x_dtInicial = $data_atual < $data_inicial ? diferencaEmDias($data_atual, $data_inicial) : diferencaEmDias($data_inicial, $data_atual);

    $porcentagem = ($dias_dtInicial_x_dtFinal != 0 && $data_atual > $data_inicial) ? round((($dias_dtAtual_x_dtInicial / $dias_dtInicial_x_dtFinal) * 100), 2) : 0;

    return $porcentagem;
  }
}

if ( ! function_exists('procuraMatchPalavra')){
    function procuraMatchPalavra($haystack, $needle, $caseSensitive = false) {
        return $caseSensitive ?
                (strpos($haystack, $needle) === FALSE ? FALSE : TRUE):
                (stripos($haystack, $needle) === FALSE ? FALSE : TRUE);
    }
}

if ( ! function_exists('montaNomeUrl')){

    function montaNomeUrl($nome){
        return strtolower(preg_replace('{\W}', '-', preg_replace('{ +}', '-', strtr(
            utf8_decode(html_entity_decode($nome)),
            utf8_decode('ÀÁÃÂÉÊÍÓÕÔÚÜÇÑàáãâéêíóõôúüçñ'),
            'AAAAEEIOOOUUCNaaaaeeiooouucn'))));
    }
}

if ( ! function_exists('validaAjustaUrl')){
    function validaAjustaUrl($url){
        $baseUrl     = $url; 
        $posted_url  = $url;

        $regularExpression  = "((https?|ftp)\:\/\/)?"; // SCHEME Check
        $regularExpression .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass Check
        $regularExpression .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP Check
        $regularExpression .= "(\:[0-9]{2,5})?"; // Port Check
        $regularExpression .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path Check
        $regularExpression .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query String Check
        $regularExpression .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor Check

        if(preg_match("/^$regularExpression$/i", $posted_url)) { 
            if(preg_match("@^http|https://@i",$posted_url)) {
                $final_url = preg_replace("@(https://)+@i",'https://',$posted_url);
            }else { 
                $final_url = 'https://'.$posted_url;
            }
        }else {
            $final_url = "";
        }
        return $final_url;
    }
}

if ( ! function_exists('geraProtocolo')){
   function geraProtocolo($qtd){
       $chars        = '1234567890';
       $chars_length = (strlen($chars) - 1);
       $token        = $chars{rand(0, $chars_length)};

       for ($i = 1; $i < $qtd; $i = strlen($token)){
           $r = $chars{rand(0, $chars_length)};
           if ($r != $token{$i - 1}) $token .=  $r;
       }

       return $token;
   }
}

if ( ! function_exists('carregaMenu')){

    function carregaMenu(){
        $CI = get_instance();

        $CI->load->model('Index_model', 'index');

        $itensMenu = $CI->index->menu();   

        if(isset($itensMenu)){
          return $itensMenu;
        }else{
          return false;
        }


    }
}

if ( ! function_exists('incrementaContador')){

    function incrementaContador($campo){
        $CI = get_instance();

        $CI->load->model('Index_model', 'index');

        $itensMenu = $CI->index->contadorAcesso($campo);   
    }
}


if ( ! function_exists('retornaDatasProximas')){
    function retornaDatasProximas($dataAtual){
        $datas        = array();
        $dataAtual    = formataData($dataAtual, '-', '/');
        $dataAjustada = new DateTime($dataAtual);
        $proximosDias = new DatePeriod(
            $dataAjustada,
            DateInterval::createFromDateString('+1 days'),
            14
        );

        foreach($proximosDias as $value){
          foreach($value as $key => $data){
            if($key == 'date'){
              array_push($datas, date_format(date_create($data), 'Y-m-d'));
            }
          }
        }
        return $datas;
    }
}

if ( ! function_exists('carregaConfigSite')){

    function carregaConfigSite($sistema=null){
        $CI = get_instance();

        $CI->load->model($sistema, 'cfg');

        $config = $CI->cfg->configuracoes(1);   

        return $config;
    }
}

if(! function_exists('criptografaSenha')){
    function criptografaSenha($senha) {

        $custo = '08';
        $salt = substr(md5(uniqid(rand(), true)),0,22);
        
        // Gera um hash baseado em bcrypt
        $hash = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');
        
        return $hash;
    }
}

if(! function_exists('retornaParamsDatatables')){

    function retornaParamsDatatables($tabela){
      
        $urlCallBack  = "";
        $conf         = array();
        $colOrdem     = array();
        $arrayDefs    = json_encode(array());
        $arrayOrdem   = json_encode(array());

        if(isset($tabela)){
          foreach ($tabela as $key => $value) {
            if($key == 'urlCallBack'){
              $urlCallBack = $value;
            }
            if($key == 'columnDefs'){
              foreach ($value as $defs) {
                $conf[] = $defs;
              }
            }
            if($key == 'ordemInicial'){
              foreach ($value as $sort) {
                $colOrdem[] = $sort;
              }
            }
          }
          $arrayDefs  = json_encode($conf);
          $arrayOrdem = json_encode($colOrdem); 
          return (array('urlCallBack' => $urlCallBack, 'arrayDefs' => $arrayDefs, 'arrayOrdem' => $arrayOrdem));
        }
    }
}

if(! function_exists('generateCSV')){

  function generateCSV($name, $header, $data, $json = false, $delimiter = ';') {

    if (sizeof($data) > 0) {

      $fileName = $name.'.csv';

      ob_clean();
      header('Pragma: public');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Cache-Control: private', false);
      header('Content-Type: text/csv');
      header('Content-Disposition: attachment;filename=' . $fileName);       

      $arr = ($json) ? json_decode($data, true) : $data;

      $fp = fopen('php://output', 'w'); //r+
      fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

      fputcsv($fp, $header, $delimiter);

      $arrAux = array();  
      foreach($arr as $key => $values){
        foreach ($header as $head) {
          array_push($arrAux, $values[$head]);
        }
        fputcsv($fp, $arrAux, $delimiter);
        $arrAux = array();
      }

      fclose($fp);
      ob_flush();

    }
  }
}

if(! function_exists('horas_para_segundos')){
  function horas_para_segundos($hora) { 
    list($h, $m, $s) = explode(':', $hora); 
    return ($h * 3600) + ($m * 60) + $s; 
  }
}

if(! function_exists('segundos_para_dias')){
  function segundos_para_dias($segundos) {
    $dias =    0;
    $horas =   0;
    $minutos = 0;
    $sobrou =  0;
    $segundos = $segundos;

    //24 horas = 86400 segundos 9 horas = 32400
    $dias     = $segundos / 32400;
    if (!is_float($dias)) {
      $segundos %= 32400;
      $sobrou = $segundos;
    } else {
      $dias = 0;
    }

    //1 hora = 3600 segundos
    if ($segundos > 0) {
      $horas    = $segundos / 3600;
      $segundos %= 3600;

      if ($segundos > 0) {
        //1 minuto = 60 segundos
        $minutos  = $segundos / 60;
        $segundos %= 60;
      }
    }

    $dia   = '';
    $tempo = 'NA';

    if (($dias >= 1) && ($sobrou <= 0)) {
      $dia = $dias.($dias == 1 ? ' dia' : ' dias');
    }

    if ($horas >= 1 ) {
      $tempo = $horas.($horas == 1 ? ' hora' : ' horas');
    } else if ($minutos >= 1 ) {
      $tempo = $minutos.($minutos == 1 ? ' minuto' : ' minutos');
    } else if ($segundos >= 1 ) {
      $tempo = $segundos.($segundos == 1 ? ' segundo' : ' segundos');
    }

    //O que restar são segundos.
    $result = 
      array(
        'dia'  => $dia,
        'temp' => $tempo
      );
    return $result;
  }
}
