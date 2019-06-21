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

            <div class="nav-wrapper">
              <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0 active show" id="entrar-tab" data-toggle="tab" href="#entrar" role="tab" aria-controls="entrar" aria-selected="true">
                    <i class="fas fa-sign-in-alt"></i> ENTRAR
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" id="cadastro-tab" data-toggle="tab" href="#cadastro" role="tab" aria-controls="cadastro" aria-selected="false">
                    <i class="fas fa-edit"></i> CADASTRE-SE
                  </a>
                </li>
              </ul>
            </div>


            <div class="tab-content" id="myTabContent">
              <!-- ENTRAR -->
              <div class="tab-pane fade active show" id="entrar" role="tabpanel" aria-labelledby="entrar-tab">              

                <div class="card bg-secondary shadow border-0">
                  <div class="card-header bg-white">
                    <div class="text-muted text-center">
                      <h1>ENTRAR</h1>
                    </div>
                  </div>
                  <div class="card-body px-lg-5 py-lg-5">
                    <form name="formLogin" id="formLogin" action="" method="">
                      <div class="form-group mb-3">
                        <label class="form-control-label" for="edEmailLogin">Email</label>
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                          </div>
                          <input class="form-control" id="edEmailLogin" name="edEmailLogin" placeholder="Email" type="email" required autocomplete="email">
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="form-control-label" for="edPassLogin">Senha</label>
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                          </div>
                          <input class="form-control" id="edPassLogin" name="edPassLogin" placeholder="Senha"
                                 type="password" minlength="6" required>
                        </div>
                      </div>
                        <div class="row mt-3">
                          <div class="col-12 text-right">
                            <a href="javascript:login.esqueceuSenha()" class="text-light">
                             Esqueceu sua senha?
                            </a>
                          </div>
                        </div>
                      <div class="text-center">
                        <button type="button" class="btn btn-primary btn-block my-4" onclick="login.login()">
                          <i class="fas fa-sign-in-alt"></i> ENTRAR
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- CADASTRE-SE -->
              <div class="tab-pane fade" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">              

                <div class="card bg-secondary shadow border-0">
                  <div class="card-header bg-white">
                    <div class="text-muted text-center">
                      <h1>CADASTRE-SE</h1>
                    </div>
                  </div>
                  <div class="card-body px-lg-5 py-lg-5">
                    <form name="formCadastrar" id="formCadastrar" action="" method="">
                      <!-- NOME -->
                      <div class="form-group">
                        <label class="form-control-label" for="edNome">Nome</label>
                        <div class="input-group input-group-alternative mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                          </div>
                          <input class="form-control" id="edNome" name="edNome" placeholder="Nome" type="text" required>
                        </div>
                      </div>

                      <!-- EMAIL -->
                      <div class="form-group mb-3">
                        <label class="form-control-label" for="edEmail">Email</label>
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                          </div>
                          <input class="form-control" id="edEmail" name="edEmail" placeholder="Email" type="email" required autocomplete="email">
                        </div>
                      </div>
                      <!-- SENHA -->
                      <div class="form-group">
                        <label class="form-control-label" for="edPass">Senha</label>
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                          </div>
                          <input class="form-control" id="edPass" name="edPass" placeholder="Senha"
                                 type="password" minlength="6" required>
                        </div>
                        <div class="text-muted font-italic">
                         Segurança da senha:
                            <span class="msg font-weight-700" id="msg">...</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label" for="edConfPass">Confirmar Senha</label>
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                          </div>
                          <input class="form-control" id="edConfPass" name="edConfPass" placeholder="Confirmar senha" 
                                 type="password" minlength="6" required>
                        </div> 
                      </div>
                      <div class="row my-4">
                        <div class="col-12">
                          <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id="CheckRegistrar" type="checkbox" required>
                            <label class="custom-control-label" for="CheckRegistrar">
                              <span>Ao se cadastrar, você concorda com a 
                                    <a href="<?php echo base_url().'politica';?>" class="text-light" target="_blanck">Política de Privacidade</a> e 
                                    <a href="<?php echo base_url().'termos';?>" class="text-light" target="_blanck">Termos de Uso</a> 
                                    e aceita receber as nossas novidades por email.
                              </span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="button" class="btn btn-primary my-4 btn-block"
                                id="btnSalvarCadastro" id="btnSalvarCadastro" name="btnSalvarCadastro" onclick="login.salvarCadastro()">
                                <i class="fas fa-edit"></i> CADASTRAR
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
