<div class="row">
  <div class="col-xl-12">
    <div class="card bg-secondary shadow">
      <div class="card-header bg-white border-0">
        <h3 class="mb-0">Imagens Para Avaliar</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <span id="msg">
              <?php 
                $msg = $this->session->flashdata('avaliar_ok');
                if ($msg != '') {
                ?>
                  <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                    <span class="alert-inner--icon mr-3"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong><?php echo $msg; ?></strong></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar Notificação">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php 
                }
              ?>
            </span>
            <div class="row row-grid" id="vAvaliar">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
