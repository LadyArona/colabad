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
                  <div class="card-header bg-white pb-5">
                    <div class="text-muted text-center mb-3">
                      <h1>ENTRAR</h1>
                    </div>
                    <div class="text-muted text-center mb-3">
                     com seu perfil nas redes sociais
                    </div>
                    <div class="btn-wrapper text-center">
                      <a href="#" class="btn btn-neutral btn-icon btn-block facebook">
                        <span class="btn-inner--icon">
                          <img src="<?php echo base_url();?>assets/img/icons/common/facebook.svg">
                        </span>
                        <span class="btn-inner--text">Facebook</span>
                      </a>
                      <a href="#" class="btn btn-neutral btn-icon btn-block">
                        <span class="btn-inner--icon">
                          <img src="<?php echo base_url();?>assets/img/icons/common/google.svg">
                        </span>
                        <span class="btn-inner--text">Google</span>
                      </a>
                    </div>
                  </div>
                  <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                     ou
                    </div>
                    <form role="form">
                      <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                          </div>
                          <input class="form-control" placeholder="Email" type="email">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                          </div>
                          <input class="form-control" placeholder="Password" type="password">
                        </div>
                      </div>
                        <div class="row mt-3">
                          <div class="col-6">
                            <div class="custom-control custom-control-alternative custom-checkbox">
                              <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                              <label class="custom-control-label" for=" customCheckLogin">
                                <span>Lembrar usuário?</span>
                              </label>
                            </div>
                          </div>
                          <div class="col-6 text-right">
                            <a href="#" class="text-light">
                             Esqueceu sua senha?
                            </a>
                          </div>
                        </div>
                      <div class="text-center">
                        <button type="button" class="btn btn-primary btn-block my-4"><i class="fas fa-sign-in-alt"></i> ENTRAR</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- CADASTRE-SE -->
              <div class="tab-pane fade" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">              

                <div class="card bg-secondary shadow border-0">
                  <div class="card-header bg-white pb-5">
                    <div class="text-muted text-center mb-3">
                      <h1>CADASTRE-SE</h1>
                    </div>
                    <div class="text-muted text-center mb-3">
                     com seu perfil nas redes sociais
                    </div>
                    <div class="btn-wrapper text-center">
                      <a href="#" class="btn btn-neutral btn-icon btn-block facebook">
                        <span class="btn-inner--icon">
                          <img src="<?php echo base_url();?>assets/img/icons/common/facebook.svg">
                        </span>
                        <span class="btn-inner--text">Facebook</span>
                      </a>
                      <a href="#" class="btn btn-neutral btn-icon btn-block">
                        <span class="btn-inner--icon">
                          <img src="<?php echo base_url();?>assets/img/icons/common/google.svg">
                        </span>
                        <span class="btn-inner--text">Google</span>
                      </a>
                    </div>
                  </div>
                  <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                     ou
                    </div>
                    <form name="formCadastrar" id="formCadastrar" action="" method="">
                      <!-- NOME -->
                      <div class="form-group">
                        <div class="input-group input-group-alternative mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                          </div>
                          <input class="form-control" id="edNome" name="edNome" placeholder="Nome" type="text">
                        </div>
                      </div>

                      <!-- EMAIL -->
                      <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                          </div>
                          <input class="form-control" id="edEmail" name="edEmail" placeholder="Email" type="email">
                        </div>
                      </div>
                      <!-- SENHA -->
                      <div class="form-group">
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                          </div>
                          <input class="form-control" id="edPass" name="edPass" placeholder="Senha"
                                 type="password" minlength="6">
                        </div>
                      </div>
                      <div class="text-muted font-italic">
                       Segurança da senha:
                          <span class="text-success font-weight-700">Forte</span>
                      </div>
                      <span class="alignl font-sm">Sua senha deve ter pelo menos 6 caracteres e conter apenas números e letras.</span>
                      <div class="form-group">
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                          </div>
                          <input class="form-control" id="edConfPass" name="edConfPass" placeholder="Confirmar senha" 
                                 type="password" minlength="6">
                        </div> 
                      </div>
                      <br>

                <div class="form-group mb-4">
                  <textarea class="form-control form-control-alternative" id="txtDetalhe" name="txtDetalhe" rows="4" cols="80" 
                            placeholder="QUER DETALHAR ALGUMA ESPECIFICIDADE? Escreva aqui..."></textarea>
                </div>
                <div class="form-group mb-4">
                  <textarea class="form-control form-control-alternative" id="txtConhecimento" name="txtConhecimento" rows="4" cols="80" 
                            placeholder="Conte-nos qual é o seu conhecimento sobre áudio-descrição: (opcional)"></textarea>
                </div>
                Deseja contribuir também como: (Para ser aceito seu usuário será avaliado pelo administrador do sistema)  
                <div class="custom-control custom-checkbox mb-3">
                  <input class="custom-control-input" id="customCheck1" type="checkbox">
                  <label class="custom-control-label" for="customCheck1">Áudio-descritor (O usuário tem permissão de fazer áudio-descricao nas imagens)</label>
                </div>
                <div class="custom-control custom-checkbox mb-3">
                  <input class="custom-control-input" id="customCheck2" type="checkbox" checked>
                  <label class="custom-control-label" for="customCheck2">
                Revisor (O usuário tem permissão de fazer revisões das imagens com áudio-descrição)</label>
                </div>

                    <div class="row my-4">
                      <div class="col-12">
                        <div class="custom-control custom-control-alternative custom-checkbox">
                          <input class="custom-control-input" id="customCheckRegister" type="checkbox">
                          <label class="custom-control-label" for="customCheckRegister">
                            <span>Ao se cadastrar, você concorda com a <a href="#" class="text-light">Política de Privacidade</a> e <a href="#" class="text-light">Termos de Uso</a> e aceita receber as nossas novidades.
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
