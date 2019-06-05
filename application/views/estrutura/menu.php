  <!-- Sidenav -->
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white pt-6" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="<?php echo base_url();?>">
        <img src="<?php echo base_url();?>assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
      </a>
      
      <ul class="nav align-items-center d-md-none itensNotificacoes">
        <li class="nav-item dropdown notficDropAvisos">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" 
             aria-haspopup="true" aria-expanded="false" aria-label="Notificações">
            <i class="ni ni-bell-55"></i>
          </a>
          <div id="divAvisos" class="dropdown-menu dropdown-menu-arrow dropdown-menu-right dropdown-menu-sm-right" aria-labelledby="navbar-default_dropdown_1">
          </div>
        </li>
      </ul>      
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="<?php echo base_url();?>">
                <img src="<?php echo base_url();?>assets/img/brand/blue.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
          <div class="input-group input-group-rounded input-group-merge">
            <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fa fa-search"></span>
              </div>
            </div>
          </div>
        </form>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url();?>painel" role="button" aria-pressed="false" tabindex="0" id="mnPainel">
              <i class="ni ni-tv-2 text-primary"></i> Painel
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url();?>projetos" role="button" aria-pressed="false" tabindex="0" >
              <i class="ni ni-album-2 text-red"></i> Projetos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url();?>publicar" role="button" aria-pressed="false" tabindex="0" >
              <i class="ni ni-image text-info"></i> Publicar Imagem
            </a>
          </li>
          <?php if ($this->session->userdata('logged_in_colabad')['sesColabad_vPerfilNivel'] > 1) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url();?>avaliar" role="button" aria-pressed="false" tabindex="0" >
              <i class="fas fa-calendar-check text-success"></i> Avaliar Imagem
            </a>
          </li>
          <?php } ?>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <h6 class="navbar-heading text-muted">Usuário</h6>
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <?php
              $perfil = base_url().'perfil/'.$this->session->userdata('logged_in_colabad')['sesColabad_vId'].'/'.$this->session->userdata('logged_in_colabad')['sesColabad_vLink'];
            ?>
            <a class="nav-link" href="<?php echo $perfil;?>" role="button" aria-pressed="false" tabindex="0" >
              <i class="ni ni-single-02 text-yellow"></i> Meu Perfil
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" role="button" aria-pressed="false" tabindex="0" >
              <i class="ni ni-calendar-grid-58"></i>
              <span>Atividade</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>suporte" class="nav-link" role="button" aria-pressed="false" tabindex="0" >
              <i class="ni ni-support-16"></i>
              <span>Suporte</span>
            </a>
          </li>
        </ul>

        <hr class="my-3">
        <a href="<?php echo base_url('index/logout'); ?>" class="nav-link" role="button" aria-pressed="false" tabindex="0" >
          <i class="ni ni-user-run"></i>
          <span>Sair</span> 
        </a>
      </div>
    </div>
  </nav>
