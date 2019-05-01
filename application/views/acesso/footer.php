<?php 
    $base = base_url();
?>
<script>
  let baseUrl = ''
  baseUrl = '<?php echo $base; ?>'
</script>

<footer class="footer">
    <div class="container">
      <div class="row row-grid align-items-center mb-5">
        <div class="col-lg-6">
          <h3 class="text-primary font-weight-light mb-2">Agradecemos seu apoio!</h3>
        </div>
        <div class="col-lg-6 text-lg-right btn-wrapper">
          <a target="_blank" href="<?php echo $this->config->item('facebook'); ?>" class="btn btn-neutral btn-icon-only btn-facebook btn-round btn-lg" data-toggle="tooltip" data-original-title="Curta nossa página no Facebook">
            <i class="fa fa-facebook-square"></i>
          </a>
          <a target="_blank" href="<?php echo $this->config->item('repositorio'); ?>" class="btn btn-neutral btn-icon-only btn-github btn-round btn-lg" data-toggle="tooltip" data-original-title="Colabore com nosso desenvolvimento">
            <i class="fab fa-github-alt"></i>
          </a>
        </div>
      </div>
      <hr>
      <div class="row align-items-center justify-content-md-between">
        <div class="col-md-6">
          <div class="copyright">
            &copy; 2019
            <a href="<?php echo $this->config->item('autor_link'); ?>" target="_blank"><?php echo $this->config->item('autor'); ?></a>.
          </div>
        </div>
        <div class="col-md-6">
          <ul class="nav nav-footer justify-content-end">
            <li class="nav-item">
              <a href="#" class="nav-link" target="_blank">Mapa do Site</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
