      <div class="row  mt-6">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image thumbnail">
                    <img id="imgPerfil" src="" class="rounded-circle portrait">
                </div>
              </div>
            </div>
            <div class="card-body pt-0 mt-md-5 mt-sm-7">
              <div class="row">
                <div class="col col col-sm-auto">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5 mt-sm-7">
                    <div>
                      <span class="heading" id="vProjetos"></span>
                      <span class="description">Projetos</span>
                    </div>
                    <div>
                      <span class="heading" id="vFotos"></span>
                      <span class="description">Imagens</span>
                    </div>
                    <div>
                      <span class="heading" id="vAprovadas"></span>
                      <span class="description">Aprovadas</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center" id="divPerfilInfo">
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-body">
              <span id="msg">
                <?php 
                $msg = $this->session->flashdata('perfil_ok');
                if ($msg != '') {
                ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon mr-3"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><strong><?php echo $msg; ?></strong></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar Notificação">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php 
                }
                ?>
              </span>
              <form action="" method="POST" enctype="multipart/form-data" id="formPerfil" autocomplete="off">
                <h3 class="heading-small text-muted mb-4">Imagem de Perfil</h3>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12 mb-sm-8">
                      <div class="form-group"> 
                        <div class="custom-file">
                          <input autocomplete="off" type="file" id="inputGroupFile01"
                                 class="custom-file-input"
                                 accept="image/jpg, image/jpeg, image/png">
                          <label class="custom-file-label" for="inputGroupFile01">
                            Selecione a sua imagem de perfil
                          </label>
                        </div>
                      </div>
                      <div class="demo-wrap upload-demo img_contain">
                        <div class="upload-demo-wrap">
                            <div class="blah" id="blah"></div>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="edAudiodescricao">Roteiro da Áudiodescrição da Imagem de Perfil</label>
                        <textarea rows="10" class="form-control" id="edAudiodescricao" name="edAudiodescricao"></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <hr class="my-4" />

                <h3 class="heading-small text-muted mb-4">Informação do Usuário</h3>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="edNome">Nome</label>
                        <input autocomplete="off" type="text" id="edNome" class="form-control" disabled="disabled">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="edEmail">Email</label>
                        <input autocomplete="off" type="email" id="edEmail" class="form-control" disabled="disabled">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="edPerfilPass">Nova Senha</label>
                        <input autocomplete="off" type="password" id="edPerfilPass" class="form-control" value="">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="edConfPass">Confirmar Senha</label>
                        <input autocomplete="off" type="password" id="edConfPass" class="form-control" value="">
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Endereco -->
                <h3 class="heading-small text-muted mb-4">Informação de Contato</h3>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label" for="cbEstado">Estado</label>
                        <select class="selectpicker form-control"   
                                title="Selecione o Estado" id="cbEstado" name="cbEstado"
                                data-live-search="true">
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="cbCidade">Cidade</label>
                        <select class="selectpicker form-control"   
                                title="Selecione a Cidade" id="cbCidade" name="cbCidade"
                                data-live-search="true">
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="edOrg">Empresa/Organização</label>
                        <input autocomplete="off" type="text" id="edOrg" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Descricao -->
                <h3 class="heading-small text-muted mb-4">Sobre você</h3>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label" for="cbDefic">Você tem alguma deficiência?</label>
                        <select class="selectpicker form-control"   
                                title="Selecione uma opção" id="cbDefic" name="cbDefic">
                          <option value="S">Sim</option>
                          <option value="N">Não</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label" for="cbQual">Qual?</label>
                        <select class="selectpicker form-control"   
                                title="Selecione sua Deficiência" id="cbQual" name="cbQual">
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="edObs">Escreva um pouco sobre você</label>
                        <textarea rows="5" class="form-control" id="edObs" name="edObs"
                                  placeholder="Escreva um pouco sobre você..."></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <hr class="my-4" />
                <!-- Descricao -->
                <h3 class="heading-small text-muted mb-4">Perfil</h3>
                <div class="pl-lg-5">
                  <p>
                    O perfil autodeclarado pelo usuário é de sua inteira responsabilidade.
                  </p>
                  <div class="custom-control custom-radio mb-3">
                    <input name="rbPerfil" class="custom-control-input" id="customRadio1" type="radio" value="1" checked="">
                    <label class="custom-control-label" for="customRadio1">
                      <strong>AUDIODESCRITOR ROTEIRISTA</strong> (ABNT NBR 16452:2016)
                      <br>Profissional que elabora o roteiro da audiodescrição, com formação técnica adequada
                      <br><span class="text-blue"><strong>No ColabAD:</strong> Cadastra projetos, publica e revisa imagens e roteiro da audiodescrição.</span>
                    </label>
                  </div>
                  <div class="custom-control custom-radio mb-3">
                    <input name="rbPerfil" class="custom-control-input" id="customRadio2" type="radio" value="2">
                    <label class="custom-control-label" for="customRadio2">
                      <strong>AUDIODESCRITOR CONSULTOR</strong> (ABNT NBR 16452:2016)
                      <br>Profissional que realiza a revisão e adequação do roteiro e da narração da audiodescrição com formação técnica adequada. Convém que seja um profissional com deficiência visual
                      <br><span class="text-blue"><strong>No ColabAD:</strong> Cadastra projetos, publica e revisa imagens e roteiro da audiodescrição. Faz as avaliações das imagens e roteiro da audiodescrição, como consultor.</span>
                    </label>
                  </div>
                </div>

                <hr class="my-4" />
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6 col-md-3 pb-4">
                      <button type="button" class="btn btn-block btn-success" 
                              value="Salvar" id="btnSalvar">SALVAR</button>
                    </div>
                    <div class="col-lg-6 col-md-3">
                      <button type="reset" class="btn btn-block btn-default" 
                              value="Cancelar" id="btnCancelar">CANCELAR</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
