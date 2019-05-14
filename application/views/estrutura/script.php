  <!-- Scripts -->

  <!-- Core -->
  <script src="<?php echo base_url();?>assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap.js" type="text/javascript"></script>

  <script src="<?php echo base_url();?>assets/js/core/popper.min.js" type="text/javascript"></script>

  <!-- Optional JS -->
  <script src="<?php echo base_url();?>assets/js/bootstrap-notify.js" type="text/javascript"></script>
  <script src="<?php echo base_url();?>assets/js/jquery.loader.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-select.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/dataTables.bootstrap.min.js"></script>

  <!-- Custom JS -->
  <script src="<?php echo base_url();?>assets/js/painel.js?v=1.0.0"></script>
  <script src="<?php echo base_url();?>assets/js/viewsJS/app.js" type="text/javascript"></script>

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
<?php } ?>




