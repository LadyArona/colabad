<div class="row">
  <div class="col-xl-12">
    <div class="card bg-secondary shadow">
      <div class="card-header bg-white border-0">
        <h3 class="mb-0">Dados da Imagem</h3>
      </div>
      <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" for="input-address">Título</label>
                  <input id="input-address" class="form-control" 
                         placeholder="Home Address" value="" type="text">
                </div>
              </div>
            </div>
          </div>
          <div class="pl-lg-4">
            <div class="form-group">
              <label class="form-control-label" for="input-obs">Áudiodescrição da imagem</label>
              <textarea rows="6" class="form-control" id="input-obs" 
                        placeholder="A few words about you ..."></textarea>
            </div>
          </div>
          
          <div class="pl-lg-4">
            <div class="form-group"> 
              <div class="custom-file">
                <input type="file" id="inputGroupFile01" 
                       class="imgInp custom-file-input" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01" data-browse="Buscar">
                  Selecione a imagem
                </label>
              </div>
            </div>
            <div class="alert"></div>
            <div id='img_contain'>
              <img id="blah" align='middle' 
                   src="http://www.clker.com/cliparts/c/W/h/n/P/W/generic-image-file-icon-hi.png" 
                   alt="your image" title=''/>
            </div> 
          </div>
          <hr class="my-4" />
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <button type="button" class="btn btn-block btn-success" value="Salvar">SALVAR</button>
              </div>
              <div class="col-lg-6">
                <button type="submit" class="btn btn-block btn-default" value="Cancelar">CANCELAR</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
