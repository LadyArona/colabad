  <!-- Scripts -->

  <!-- Core -->
  <script src="<?php echo base_url();?>assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <script src="<?php echo base_url();?>assets/js/core/popper.min.js" type="text/javascript"></script>

  <!-- Optional JS -->
  <script src="<?php echo base_url();?>assets/js/bootstrap-notify.js" type="text/javascript"></script>
  <script src="<?php echo base_url();?>assets/js/jquery.loader.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-select.min.js" type="text/javascript"></script>

  <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/js/froala_editor.min.js'></script>
  <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/js/languages/pt_br.js'></script>
  <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/js/plugins/help.min.js'></script>
  
  <!-- Custom JS -->
  <script src="<?php echo base_url();?>assets/js/painel.js?v=1.0.0"></script>
  <script src="<?php echo base_url();?>assets/js/viewsJS/app.js" type="text/javascript"></script>

  <script>
  $(document).ready(() => { app.initApp() })
  </script>

<?php if ($conteudo == 'publicar') { ?>
  <script src="<?php echo base_url();?>assets/js/viewsJS/publicar.js"></script>

  <script>
    $(document).ready(() => {
      publicar.initConfig()
    })
  </script>
<?php 
  } else

  if ($conteudo == 'projetos') { ?>
  <script src="<?php echo base_url();?>assets/js/viewsJS/projetos.js"></script>

  <script>
    $(document).ready(() => {
      projetos.initConfig()
    })
  </script>
<?php 
} else
  if ($conteudo == 'proj_visualizar') { ?>
  <script src="<?php echo base_url();?>assets/js/viewsJS/proj_visualizar.js"></script>

  <script>
    $(document).ready(() => {
      prv.initConfig(<?php echo json_encode($id); ?>)
    })
  </script>
<?php 
} else
  if ($conteudo == 'img_visualizar') { ?>
  <script src="<?php echo base_url();?>assets/js/viewsJS/img_visualizar.js"></script>

  <script>
    $(document).ready(() => {
      img.initConfig(<?php echo json_encode($id); ?>)
    })
  </script>
<?php 
} else
  if ($conteudo == 'painel') { ?>
  <script src="<?php echo base_url();?>assets/js/viewsJS/painel.js"></script>

  <script>
    $(document).ready(() => {
      painel.initConfig()
    })
  </script>
<?php 
}

 ?>




