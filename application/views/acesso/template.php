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
    <?php
      $this->load->view('acesso/nav');
    ?>
  <main>
    <?php
       $this->load->view('acesso/'.$conteudo);
    ?>
  </main>

</body>
<?php 
  $this->load->view('acesso/footer');
  $this->load->view('acesso/scripts');
?> 
</html>
