
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark pt-5" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="<?php echo base_url().$conteudo; ?>"><?php echo $title; ?></a>
        <!-- Form -->
        <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" 
              method="GET" id="formPesquisar" name="formPesquisar" action="<?php echo base_url().'pesquisar'; ?>">
          <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text text-white"><i class="fas fa-search"></i></span>
                <label class="form-control-label text-white pr-2" for="pesquisar">Pesquisar: </label>
              </div>
              <input class="form-control" id="por" name="por" type="text">
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
            <div id="divAvisos" class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img id="imgTopo" alt="<?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vImgAlt']; ?>" src="<?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vImg']; ?>">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold"><?php echo $this->session->userdata('logged_in_colabad')['sesColabad_vNome']; ?></span>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </nav>
