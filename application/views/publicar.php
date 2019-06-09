<div class="row">
  <div class="col-xl-12">
    <div class="card bg-secondary shadow">
      <div class="card-header bg-white border-0">
        <h3 class="mb-0">Dados da Imagem</h3>
      </div>
      <div class="card-body">
        <?php if ($imgId != '') { ?>
          <div class="row">
            <div class="col-lg-12">
              <h6 class="heading text-muted mb-4">Avaliações da Imagem</h6>
            </div>
            <div class="col-lg-12">
              <div class="row row-grid" id="vAvaliacoes">
              </div>
              <hr class="my-4" />
            </div>
          </div>
        <?php } ?>

        <form action="" method="POST" enctype="multipart/form-data" id="formImagem">
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="edTitulo">Título da imagem</label>
                  <input id="edTitulo" name="edTitulo" class="form-control" required
                         value="" type="text">
                </div>
              </div>
            </div>
          </div>
          <div class="pl-lg-4">
            <div class="form-group">
              <label class="form-control-label" for="edAudiodescricao">Áudiodescrição da imagem</label>
              <textarea rows="10" class="form-control" id="edAudiodescricao" name="edAudiodescricao" required></textarea>
            </div>
          </div>
          <div class="pl-lg-4">
            <div class="form-group">
              <label class="form-control-label" for="cbProjeto">Projeto</label>
              <select class="selectpicker form-control" data-style="select-with-transition" 
                      title="Selecione" id="cbProjeto" name="cbProjeto" required>
              </select>
            </div>
          </div>
          <hr class="my-4" />
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group"> 
                  <div class="custom-file">
                    <input type="file" id="inputGroupFile01" required
                           class="custom-file-input"
                           accept="image/jpg, image/jpeg, image/png">
                    <label class="custom-file-label" for="inputGroupFile01">
                      Selecione a imagem
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div id='img_contain'>
                  <img id="blah" align='middle' 
                       src="<?php echo base_url();?>assets/img/imagem_generica.png" 
                       alt="Sua imagem aparece aqui" title=''/>
                </div> 
              </div>
            </div>
          </div>
          <hr class="my-4" />
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6 col-md-3">
                <button type="button" class="btn btn-block btn-success" 
                        value="Salvar" id="btnSalvar"
                        onclick="publicar.salvaImagem()">SALVAR</button>
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
