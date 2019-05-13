<div class="row">
  <div class="col-xl-12">
    <div class="card bg-secondary shadow">
      <div class="card-header bg-white border-0">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" role="tablist">
          <li class="nav-item mr-2 mr-md-0">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="projetos-tab" data-toggle="tab" href="#projetos" role="tab" aria-controls="projetos" aria-selected="true">
              <i class="ni ni-album-2"></i> Meus Projetos
            </a>
          </li>
          <li class="nav-item mr-2 mr-md-0">
            <a class="nav-link mb-sm-3 mb-md-0" id="cadastrar-tab" data-toggle="tab" href="#cadastrar" role="tab" aria-controls="cadastrar" aria-selected="false">
              <i class="fas fa-edit"></i> Cadastrar Projeto
            </a>
          </li>
        </ul>
      </div>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="projetos" role="tabpanel" aria-labelledby="projetos-tab">
          <div class="table-responsive">
            <table id="tabelaProjetos" class="table table-bordered display nowrap small" cellspacing="0" width="100%">
              <thead class="thead-light">
                <tr>
                  <?php 
                    if(isset($tabelaProjetos)){
                      foreach ($tabelaProjetos as $key => $value) {
                        if($key == 'theadsTabela'){
                          foreach ($value as $nomes => $conf) {
                            echo "<th scope='col' width='".$conf['width']."%' style='text-align:".$conf['posicao'].";'";
                            echo " title='".$conf['tooltip']."' ";
                            echo " class='text-default'>";
                            echo $nomes;
                            echo "</th>";
                          }
                        }
                      }
                    }
                  ?>
                </tr>
              </thead>
            </table>   
          </div>
        </div>
        <div class="tab-pane fade" id="cadastrar" role="tabpanel" aria-labelledby="cadastrar-tab">
          <div class="card-body">
          <form action="" method="POST" enctype="multipart/form-data" id="formProjeto">

            <h6 class="heading-small text-muted mb-4">DADOS DO PROJETO</h6>
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-control-label" for="edTitulo">Título do Projeto</label>
                    <input id="edTitulo" name="edTitulo" class="form-control" required
                           value="" type="text">
                  </div>
                </div>
              </div>
            </div>
            <div class="pl-lg-4">
              <div class="form-group">
                <label class="form-control-label" for="edDescricao">Descrição do Projeto</label>
                <textarea rows="10" class="form-control" id="edDescricao" name="edDescricao"></textarea>
              </div>
            </div>
            
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" for="cbPublico">Privacidade do Projeto</label>
                    <select class="selectpicker form-control" data-style="select-with-transition" 
                            title="Selecione" id="cbPublico" name="cbPublico">
                      <option value="0" selected>Público</option>
                      <option value="1">Privado</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" for="cbStatus">Status do Projeto</label>
                    <select class="selectpicker form-control" data-style="select-with-transition" 
                            title="Selecione" id="cbStatus" name="cbStatus">
                      <option value="A" selected>Ativo</option>
                      <option value="I">Inativo</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <hr class="my-4" />
            <h6 class="heading-small text-muted mb-4">COLABORADORES DO PROJETO</h6>
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label" for="cbParticipante">Selecione os colaboradores</label>
                    <select class="selectpicker form-control" 
                            data-style="select-with-transition" 
                            data-live-search="true" 
                            title="Selecione os colaboradores do projeto" 
                            id="cbParticipante" 
                            name="cbParticipante">
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h2><small class="text-muted"><i class="fa fa-users"></i> Colaboradores</small></h2>
                  <table class="table table-striped table-bordered table-flush custab tableParticipantes">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" width="70%"><strong>Nome</strong></th>
                        <th scope="col" width="30%"><strong>Ação</strong></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <hr class="my-4" />
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-lg-6 col-md-3">
                  <button type="button" class="btn btn-block btn-success" 
                          value="Salvar" id="btnSalvar">SALVAR</button>
                </div>
                <div class="col-lg-6 col-md-3">
                  <button type="reset" class="btn btn-block btn-default" 
                          value="Cancelar" id="btnCancelar">CANCELAR</button>
                </div>
              </div>
            </div>

              <input type="hidden" name="edEditar" id="edEditar" value="N">
              <input type="hidden" name="edCodigo" id="edCodigo">
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
  $conf     = array();
  $colOrdem = array();
  $arrayDefsProjetos  = json_encode(array());
  $arrayOrdemProjetos = json_encode(array());
  if(isset($tabelaProjetos)){
    foreach ($tabelaProjetos as $key => $value) {
      if($key == 'columnDefs'){
        foreach ($value as $defs) {
          $conf[] = $defs;
        }
      }
      if($key == 'ordemInicial'){
        foreach ($value as $sort) {
          $colOrdem[] = $sort;
        }
      }
    }
    $arrayDefsProjetos  = json_encode($conf);
    $arrayOrdemProjetos = json_encode($colOrdem); 
  }
?>

<script>
  let columnDefsProjetos = [];
  let colOrdemProjetos = [];
  columnDefsProjetos = <?php echo $arrayDefsProjetos;  ?>;
  colOrdemProjetos = <?php echo $arrayOrdemProjetos; ?>;
</script>
