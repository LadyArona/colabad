<div class="row">
  <div class="col-xl-12">
    <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
        <div class="row align-items-center">
          <div class="col-8">
            <button onclick='history.go(-1)' class="btn btn-neutral btn-icon" >
              <span class="btn-inner--icon">
                <i class="fas fa-arrow-left mr-2"></i>
              </span>
              <span class="nav-link-inner--text">VOLTAR</span>
            </button>
          </div>
        </div>
      </div>
      <div class="card-body pt-5">
        <div class="row">
          <div class="col-lg-12 text-center">
            <div class="h3 font-weight-400" id="vProjeto"></div>
          </div>
          <div class="col-lg-12 text-center">
            <h1 class="display-3 text-center" id="edTitulo"></h1>
          </div>
          <div class="col-lg-12 my-4">
            <div id='img_contain' align='middle'>
            </div>
          </div>
          <div class="col-lg-12">
            <hr class="my-4" />
            <h6 class="heading text-muted mb-4">Audiodescrição</h6>
            <p class="lead p-md-4" id="edDescricao"></p>
            <button type="button" class="btn btn-sm btn-icon-clipboard" 
                    data-clipboard-target="#edDescricao" title="" data-original-title="Copiar audiodescrição para área de transferência">
              <i class="fas fa-copy"></i> Copiar Audiodescrição
            </button>
          </div>
          <div class="col-lg-12">
            <hr class="my-4" />
            <h6 class="heading text-muted mb-4">Colaboradores</h6>
          </div>
          <div class="col-lg-12">
            <div class="row row-grid" id="vParticipante">
            </div>
          </div>
          <div class="col-lg-12">
            <hr class="my-4" />
            <h6 class="heading text-muted mb-4">Histórico da Imagem</h6>
          </div>
          <div class="col-lg-12">
            <div class="row row-grid" id="vHistorico">
            </div>
          </div>
          <div class="col-lg-12">
            <hr class="my-4" />
            <h6 class="heading text-muted mb-4">Avaliações da Imagem</h6>
          </div>
          <div class="col-lg-12">
            <div class="row row-grid" id="vAvaliacoes">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


