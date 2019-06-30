<!-- Scripts -->

<!-- Core -->
<!-- <script src="assets/vendor/jquery/dist/jquery.min.js"></script> -->
<script src="<?php echo base_url();?>assets/js/jquery-2.2.3.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url();?>assets/js/core/popper.min.js" type="text/javascript"></script>

<!-- Optional JS -->
<script src="<?php echo base_url();?>assets/js/bootstrap-notify.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/jquery.loader.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.10/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

<!-- IMAGEM -->
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/exif-js'></script>
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.js'></script>

<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>

<script src="<?php echo base_url();?>assets/js/EasyView.min.js" type="text/javascript"></script>

<!-- Custom JS -->
<script src="<?php echo base_url();?>assets/js/painel.js?v=1.0.0"></script>
<script src="<?php echo base_url();?>assets/js/viewsJs/app.js" type="text/javascript"></script>

<script>
$(document).ready(() => { app.initApp() })
</script>

<?php if ($conteudo == 'publicar') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/publicar.js"></script>

<script>
  $(document).ready(() => {
    publicar.initConfig(<?php echo json_encode($imgId); ?>)
  })
</script>
<?php 
} else

if ($conteudo == 'projetos') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/projetos.js"></script>

<script>
  $(document).ready(() => {
    projetos.initConfig(<?php echo json_encode($this->session->userdata('logged_in_colabad')['sesColabad_vId']); ?>)
  })
</script>
<?php 
} else
if ($conteudo == 'proj_visualizar') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/proj_visualizar.js"></script>

<script>
  $(document).ready(() => {
    prv.initConfig(<?php echo json_encode($id); ?>)
  })
</script>
<?php 
} else
if ($conteudo == 'img_visualizar') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/img_visualizar.js"></script>

<script>
  $(document).ready(() => {
    img.initConfig(<?php echo json_encode($id); ?>)
  })
</script>
<?php 
} else
if ($conteudo == 'avaliar_visualizar') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/avaliar_visualizar.js"></script>

<script>
  $(document).ready(() => {
    avalVis.initConfig(<?php echo json_encode($id); ?>)
  })
</script>
<?php 
} else
if ($conteudo == 'painel') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/painel.js"></script>

<script>
  $(document).ready(() => {
    painel.initConfig()
  })
</script>
<?php 
} else
if ($conteudo == 'perfil') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/perfil.js"></script>

<script>
  $(document).ready(() => {
    perfil.initConfig()
  })
</script>
<?php 
} else
if ($conteudo == 'perfil_visualizar') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/perfil_visualizar.js"></script>

<script>
  $(document).ready(() => {
    perfilVis.initConfig(<?php echo json_encode($id); ?>)
  })
</script>
<?php 
} else
if ($conteudo == 'avaliar') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/avaliar.js"></script>

<script>
  $(document).ready(() => {
    avaliar.initConfig()
  })
</script>
<?php 
} else
if ($conteudo == 'suporte') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/suporte.js"></script>

<script>
  $(document).ready(() => {
    suporte.initConfig()
  })
</script>
<?php 
} else
if ($conteudo == 'revisar') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/revisar.js"></script>

<script>
  $(document).ready(() => {
    revisar.initConfig()
  })
</script>
<?php 
} else
if ($conteudo == 'pesquisar') { ?>
<script src="<?php echo base_url();?>assets/js/viewsJs/pesquisar.js"></script>

<script>
  $(document).ready(() => {
    pesquisar.initConfig(<?php echo json_encode($pesquisa); ?>)
  })
</script>
<?php 
}

?>




