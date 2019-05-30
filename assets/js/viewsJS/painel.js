const painel = {
  initConfig: () => {
    painel.initProjetos()
  },
  initProjetos: () => {
    $('#vProjetos').html('')

    $.ajax({
      url: `${baseUrl}ajax/buscarProjeto`,
      data: {
        buscarProjeto: '',
        limit: 2
      },
      dataType: 'JSON',
      type: 'POST',
      beforeSend: () => {
        $.loader({
          className: 'blue-with-image-2',
          content: 'Aguarde, carregando...'
        })
      }
    }).done((data) => {
      if (data.result == 'OK') {
        let html = ''

        data.vProjetos.map((item) => {
          let privado = `<span class="badge badge-pill badge-${item.vPrivado == 0 ? 'success' : 'warning'}">${item.vPrivado == 0 ? 'Público' : 'Privado'}</span>`
          let status = `<span class="badge badge-pill badge-${item.vStatus == 'A' ? 'info' : 'danger'}">${item.vStatus == 'A' ? 'Ativo' : 'Inativo'}</span>`
          let imagem = `<span class="badge badge-pill badge-primary">${item.vImagens}${item.vImagens == 1 ? ' imagem' : ' imagens'}</span>`

          let colab = ''
          item.vColab.map((e) => {
            colab += 
              `<a href="" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="${e.vNome}">
                <img alt="Colaborador do Projeto: ${e.vNome}" src="${baseUrl}assets/img/theme/team-1-800x800.jpg" class="rounded-circle">
              </a>`
          })

          html +=
          `<div class="col-lg-6 pb-4">
            <div class="card card-lift--hover shadow border-0">
              <div class="card-body py-4">
                <h3 class="title text-uppercase">${item.vTitulo}</h3>
                <p>Cadastrado em ${item.vData}</p>
                <div>
                  ${privado}
                  ${status}
                  ${imagem}
                </div>
                <div class="avatar-group mt-4">
                  ${colab}
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <a class="btn btn-primary btn-block"
                    href='${item.vLink}'
                    aria-label="Visualizar este Projeto">
                      <i class="fas fa-eye"></i> Visualizar
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>`
        })

        $('#vProjetos').html(html)
      } else
      if (data.result == 'ERRO') {
        console.log('error dados ', data)
        app.showNotification(`Ops! Erro ao carregar`, 'danger', 2)
      }
    }).fail((err) => {
      console.log('error dados ', err)
      app.showNotification(`Ops! Ocorreu um erro`, 'danger', 2)
    }).always(() => {
      $.loader('close')
    })
  }
}