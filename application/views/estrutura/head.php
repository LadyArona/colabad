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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" >
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/vendor/font-awesome/css/fontawesome.css">
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/vendor/font-awesome/css/brands.css">
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/vendor/font-awesome/css/solid.css">
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/fonts/Roboto.css">

  <!-- ICONES -->
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/vendor/nucleo/css/nucleo.css">
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
  
  <!-- CSS -->
  <link rel="stylesheet" type='text/css' href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.10/dist/css/bootstrap-select.min.css">

  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/css/jquery.loader.min.css">
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/css/style.css">
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/css/painel.css?v=1.0.0">

  <link href='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.css' rel='stylesheet' type='text/css' />

  <!-- CSS ESPECÍFICO -->
<?php if ($conteudo == 'publicar') { ?>
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/css/custom/publicar.css">
<?php } ?>
<?php if ($conteudo == 'perfil') { ?>
  <link rel="stylesheet" type='text/css' href="<?php echo base_url();?>assets/css/custom/perfil.css">
<?php } ?>

<!-- <script src="https://cdn.accesslint.com/accesslint-1.1.2.js"></script> -->
</head>
