
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark pt-lg-5" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <h1 class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"><?php echo $title; ?></h1>
        <!-- Form -->
        <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" 
              method="GET" id="formNavPesquisar" name="formNavPesquisar" action="<?php echo base_url().'pesquisar'; ?>">
          <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text text-white"><i class="fas fa-search"></i></span>
                <label class="form-control-label text-white pr-2" for="navPor">Pesquisar: </label>
              </div>
              <input class="form-control" id="navPor" name="por" type="text" placeholder="Digite algo para pesquisar">
            </div>
          </div>
        </form>

        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex itensNotificacoes">
          <li class="nav-item dropdown notficDropAvisos">
            <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" 
               aria-haspopup="true" aria-expanded="false" aria-label="Notificações">
              <i class="ni ni-bell-55"></i>
            </a>
            <div id="divNavAvisos" class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item">
            <?php
              $perfil = base_url().'perfil/'.$this->session->userdata('logged_in_colabad')['sesColabad_vId'].'/'.$this->session->userdata('logged_in_colabad')['sesColabad_vLink'];
            ?>
            <a class="nav-link pr-0" href="<?php echo $perfil;?>" role="button" aria-pressed="false" id="idUsuario" tabindex="0" aria-label="Usuário logado <?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vNome']; ?> (<?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vPerfilDescr']; ?>), clique para acessar seu perfil">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img id="imgTopo" alt="<?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vImgAlt']; ?>" src="<?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vImg']; ?>">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <h2 class="mb-0 text-sm text-white font-weight-bold"><?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vNome']; ?> (<?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vPerfilDescr']; ?>)</h2>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>
