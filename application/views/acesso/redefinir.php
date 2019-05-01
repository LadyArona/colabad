<section class="section section-shaped section-lg">
  <div class="shape shape-style-1 bg-gradient-default">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div class="container pt-lg-md">
    <div class="row justify-content-center">
      <div class="col-lg-8">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-white">
              <div class="text-muted text-center">
                <h1>REDEFINIR SENHA</h1>
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form name="formRedefinir" id="formRedefinir" action="" method="">

                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" id="edPass" name="edPass" placeholder="Nova senha"
                           type="password" minlength="6">
                  </div>
                  <div class="text-muted font-italic">
                   Segurança da senha:
                      <span class="msg font-weight-700" id="msg">...</span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" id="edConfPass" name="edConfPass" placeholder="Confirmar nova senha" 
                           type="password" minlength="6">
                  </div> 
                </div>

                <div class="text-center">
                  <input type="hidden" id="edToken"    name="edToken"    value="<?php echo $token; ?>">
                  <input type="hidden" id="edNivelSec" name="edNivelSec" value="<?php echo $tipo; ?>">
                  <button type="button" class="btn btn-primary btn-block my-4" onclick="login.redefinir()">
                    <i class="fas fa-sign-in-alt"></i> REDEFINIR
                  </button>
                </div>
              </form>
            </div>
          </div>
      </div>

    </div>
  </div>
</section>
