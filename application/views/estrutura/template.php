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
  $this->load->view('estrutura/head');
?>
<body>
<?php 
  $this->load->view('estrutura/acessibilidade');
  $this->load->view('estrutura/menu');
?>
  <!-- Main content -->
  <div class="main-content pt-4">
    <?php 
      $this->load->view('estrutura/nav');
      $this->load->view('estrutura/header');
    ?>
    <!-- Page content -->
    <div class="container-fluid mt--9" id="conteudo">
      <?php
        $this->load->view($conteudo);
        $this->load->view('estrutura/footer');
      ?>      
    </div>
  </div>

  <?php 
    $this->load->view('estrutura/script');
  ?>
</body>

</html>
