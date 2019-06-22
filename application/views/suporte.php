


<div class="row">
  <div class="col-xl-12">
    <div class="card bg-secondary shadow">
      <div class="card-header bg-white border-0">
        Suporte / Contato
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12 col-md-12 pb-3">
            <a role="button" aria-pressed="false" tabindex="0" class="btn btn-block btn-lg btn-default"
               href="<?php echo base_url().'termos';?>">
              Termos de serviço e Contrato do usuário
            </a>
          </div>
        </div>

        <div class="card bg-gradient-secondary shadow">
          <div class="card-body p-lg-5">
            <h4 class="mb-1">Deseja entrar em contato?</h4>
            <p class="mt-0">Envie uma mensagem para a nossa equipe.</p>

            <form action="" method="POST" id="formSuporte">
              <div class="form-group">
                <label class="form-control-label" for="edNome">Nome</label>
                <input autocomplete="off" type="text" id="edNome" name="edNome" class="form-control">
              </div>

              <div class="form-group">
                <label class="form-control-label" for="edEmail">Email</label>
                <input autocomplete="off" type="email" id="edEmail" name="edEmail" class="form-control">
              </div>

              <div class="form-group mb-4">
                <label class="form-control-label" for="edMensagem">Mensagem</label>
                <textarea rows="10" class="form-control" id="edMensagem" name="edMensagem"></textarea>
              </div>
              <div>
                <button type="button" class="btn btn-default btn-round btn-block btn-lg" id="btnEnviar" name="btnEnviar">Enviar Mensagem</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



