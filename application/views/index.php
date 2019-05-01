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
  <main>
    <div class="wrapper">
      <div class="main-panel">
        <div class="content">
          <div class="row">
            <div class="col-md-12">
              <a class="btn btn-success mt-4" href="<?php echo base_url();?>acesso/login">Login</a>

<pre>
<?php print_r($_SESSION); ?>
</pre>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

</body>
<?php 
  $this->load->view('acesso/footer');
  $this->load->view('acesso/scripts');
?> 
</html>
