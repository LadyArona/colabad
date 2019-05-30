<head>
  <?php 
    $keysPrincipal = $this->config->item('keys'); 
    $descPrincipal = $this->config->item('descr');

    setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
    date_default_timezone_set('America/Sao_Paulo');
  ?>
    <!-- META -->
  <meta http-equiv="Content-Type" content="charset=utf-8" />  
  <meta name="viewport"           content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description"        content="<?php echo (isset($descricao)) ? $descricao.'. '.$descPrincipal : $descPrincipal; ?>" />
  <meta name="author"             content="<?php echo $this->config->item('autor'); ?>">
  <meta name="keywords"           content="<?php echo (isset($keywords))  ? $keywords.','.$keysPrincipal   : $keysPrincipal; ?>" />
  <meta name="description"        content="<?php echo (isset($descricao)) ? $descricao.'. '.$descPrincipal : $descPrincipal; ?>" />
  <meta name="application-name"   content="<?php echo $this->config->item('nome'); ?>">

  <!-- TITULO -->
  <title><?php echo (isset($title)) ? $title.' | '.$this->config->item('nome') : $this->config->item('nome'); ?></title>

  <!-- Favicon -->
  <link href="<?php echo base_url();?>assets/img/brand/favicon.png" rel="icon" type="image/png">

  <!-- FONTES -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"        rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.css"  rel="stylesheet" type='text/css'>
  <link href="<?php echo base_url();?>assets/vendor/font-awesome/css/fontawesome.css"   rel="stylesheet" type='text/css'>
  <link href="<?php echo base_url();?>assets/vendor/font-awesome/css/brands.css"        rel="stylesheet" type='text/css'>
  <link href="<?php echo base_url();?>assets/vendor/font-awesome/css/solid.css"         rel="stylesheet" type='text/css'>
  <link href="<?php echo base_url();?>assets/fonts/Roboto.css"                          rel="stylesheet" type='text/css'>
  <!-- ICONES -->
  <link href="<?php echo base_url();?>assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  

  <!-- FERRAMENTAS -->

  <!-- CSS -->

  <link type='text/css' href="<?php echo base_url();?>assets/css/jquery.loader.min.css"           rel="stylesheet">
  <link type="text/css" href="<?php echo base_url();?>assets/css/style.css"                       rel="stylesheet">
  <link type="text/css" href="<?php echo base_url();?>assets/css/custom/login.css?v=1.0.1"        rel="stylesheet">

<script src="https://cdn.accesslint.com/accesslint-1.1.2.js"></script>
</head>
