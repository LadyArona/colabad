  <!-- Scripts -->

  <!-- Core -->
  <script src="<?php echo base_url();?>assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Optional JS -->
  <script src="<?php echo base_url();?>assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-notify.js"     type="text/javascript"></script>
  <script src="<?php echo base_url();?>assets/js/jquery.loader.min.js"    type="text/javascript"></script>

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
<?php } ?>
