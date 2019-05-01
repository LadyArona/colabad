<?php 
  $link = base_url(); 
  $img = '../assets/img/question.svg'; 
  $titulo = 'Ops...';
  $msg = 'Não encontramos o que você estava procurando';
  $count = 10;

  if ($tipo == 'OK') {
    $link = $link.'login'; 
    $img = '../assets/img/check.svg'; 
    $titulo = 'Parabéns!';
    $msg = 'Seu email foi verificado com sucesso, <br>agora você faz parte do '.$this->config->item('abrv');
  } else
  if ($tipo == 'ERRO') {
    $img = '../assets/img/cross.svg'; 
    $titulo = $msg;
    $msg = 'Este email já foi verificado ou algo deu errado...';
  }
?>

  <main class="profile-page">
    <section class="section-profile-cover section-shaped my-0">
      <!-- Circles background -->
      <div class="shape shape-style-1 shape-primary alpha-4">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <!-- SVG separator -->
      <div class="separator separator-bottom separator-skew">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section>
    <section class="section">
      <div class="container">
        <div class="card card-profile shadow mt--300">
          <div class="px-4">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <img src="<?php echo $img; ?>" class="rounded-circle">
                </div>
              </div>
              <div class="col-lg-4 order-lg-3 text-lg-right align-self-lg-center">
              </div>
              <div class="col-lg-4 order-lg-1">
              </div>
            </div>
            <div class="text-center mt-9">
              <h3><?php echo $titulo; ?></h3>
              <div class="h6 mt-4"><?php echo $msg; ?></div>
            </div>
            <div class="mt-5 py-5 border-top text-center">
              <div class="row justify-content-center">
                <div class="col-lg-9">
                  <p>Você será redirecionado para a próxima página em <span id="segundos" class="segundos"><?php echo $count; ?></span> segundos
                    <br>Se não quiser esperar, clique no link abaixo :)</p>
                  <a href="<?php echo $link; ?>">Clique aqui para ir para a página</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
<script>
  // Set the date we're counting down to
  let countDown = <?php echo $count; ?>;
  let now = 1
  // Update the count down every 1 second
  let x = setInterval(function() {
    let distance = countDown - now
    document.getElementById("segundos").innerHTML = distance

    now = now + 1;

    if (distance <= 0) {
      clearInterval(x);
      //document.getElementById("segundos").innerHTML = "EXPIRED";
      window.location.href = "<?php echo $link; ?>";
    }
  }, 1000);
</script>
