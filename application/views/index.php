<?php 
  header('Content-Type: text/html; charset=utf-8');
  header("Expires: Mon, 12 Jan 1983 05:00:00 GMT");
  header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
  header("Cache-Control: no-cache");
  header("Cache-Control: post-check=0, pre-check=0");
  header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="pt-br">
<?php 
  $this->load->view('acesso/head');
?>
<body>

  <header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
      <div class="container">
        <a class="navbar-brand mr-lg-5" href="<?php echo base_url();?>">
          <img src="<?php echo base_url(); echo $this->config->item('logo'); ?>" 
               alt="<?php echo $this->config->item('logo_alt'); ?>">
        </a>
      </div>
    </nav>
  </header>
  <main>
    <div class="position-relative">
      <!-- shape Hero -->
      <section class="section section-lg section-shaped pb-250">
        <div class="shape shape-style-1 shape-default">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="container py-lg-md d-flex">
          <div class="col px-0">
            <div class="row">
              <div class="col-lg-6">
                <h1 class="display-3 text-white">Uma Rede Colaborativa
                  de Audiodescrição
                </h1>
                <p class="lead  text-white">Possibilitando o acesso à áudiodescrição de imagens para pessoas com deficiência visual e profissionais que precisam do recurso de áudio-descrição em suas imagens. </p>
                <div class="btn-wrapper">
                  <a type="button" href="<?php echo base_url();?>login" class="btn btn-block btn-neutral btn-icon mb-3 mb-sm-0">
                    <span class="btn-inner--icon"><i class="fas fa-sign-in-alt mr-2"></i></span>
                    <span class="nav-link-inner--text">ENTRAR</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- SVG separator -->
        <div class="separator separator-bottom separator-skew">
          <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-gray" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div>
      </section>
      <!-- 1st Hero Variation -->
    </div>
    <section class="section section-lg pt-lg-0 mt--200 gradiente-cinza">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="row row-grid">
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                      <i class="ni ni-istanbul"></i>
                    </div>
                    <h6 class="text-primary text-uppercase">Crie Projetos</h6>
                    <p class="description mt-3">Cria projetos públicos ou privados e convide amigos para audiodescrever imagens com você.
                    <br>O seu projeto é importante.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape icon-shape-success rounded-circle mb-4">
                      <i class="ni ni-check-bold"></i>
                    </div>
                    <h6 class="text-success text-uppercase">Publique Imagens</h6>
                    <p class="description mt-3">Ao publicar suas imagens com audiodescrição em um projeto você está contribuindo mais um pouquinho pra disseminar a audiodescrição.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape icon-shape-warning rounded-circle mb-4">
                      <i class="ni ni-planet"></i>
                    </div>
                    <h6 class="text-warning text-uppercase">Colabore</h6>
                    <p class="description mt-3">Afinal, o trabalho em equipe pode gerar resultados melhores para todos! <br><br>O que você quer compartilhar hoje?</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

</body>
<?php 
  $this->load->view('acesso/footer');
  $this->load->view('acesso/scripts');
?> 
</html>
