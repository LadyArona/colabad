const painel = {
  initConfig: () => {
    painel.initProjetos()
    painel.initPublicos()
  },
  initProjetos: () => {
    $('#vProjetos').html('')

    $.ajax({
      url: `${baseUrl}ajax/buscarProjeto`,
      data: {
        buscarProjeto: '',
        limit: 3
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

        if (data.vProjetos.length == 0) {
          html +=
            `<div class="col-lg-4">
              <div class="card card-lift--hover shadow border-0 mb--150">
                <div class="card-body py-4">
                  <h3 class="title text-uppercase">Nenhum Projeto Recente</h3>
                </div>
              </div>
            </div>`
        } else {
          data.vProjetos.map((item) => {
            let privado = `<span class="badge badge-pill badge-${item.vPrivado == 0 ? 'success' : 'warning'}">${item.vPrivado == 0 ? 'Público' : 'Privado'}</span>`
            let status = `<span class="badge badge-pill badge-${item.vStatus == 'A' ? 'info' : 'danger'}">${item.vStatus == 'A' ? 'Ativo' : 'Inativo'}</span>`
            let imagem = `<span class="badge badge-pill badge-primary">${item.vImagens}${item.vImagens == 1 ? ' imagem' : ' imagens'}</span>`

            let colab = ''
            item.vColab.map((e) => {
              colab += 
                `<a href="" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="${e.vNome}">
                  <img alt="Colaborador do Projeto: ${e.vNome}" src="${e.vImg}" class="rounded-circle">
                </a>`
            })

            html +=
            `<div class="col-lg-4">
              <div class="card card-lift--hover shadow border-0 mb--150">
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
        }

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
  },
  initPublicos: (page = 1) => {
    $('#vPublicos').html('')

    $.ajax({
      url: `${baseUrl}ajax/buscarProjetoPublico`,
      data: {
        buscarProjetoPublico: '',
        page
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
        let pagination = ''

        if (data.vProjetos.length == 0) {
          html +=
            `<div class="col-lg-4">
              <div class="card card-lift--hover shadow border-0">
                <div class="card-body py-4">
                  <h3 class="title text-uppercase">Nenhum Projeto Público</h3>
                </div>
              </div>
            </div>`
        } else {
          data.vProjetos.map((item) => {
            let privado = `<span class="badge badge-pill badge-${item.vPrivado == 0 ? 'success' : 'warning'}">${item.vPrivado == 0 ? 'Público' : 'Privado'}</span>`
            let status = `<span class="badge badge-pill badge-${item.vStatus == 'A' ? 'info' : 'danger'}">${item.vStatus == 'A' ? 'Ativo' : 'Inativo'}</span>`
            let imagem = `<span class="badge badge-pill badge-primary">${item.vImagens}${item.vImagens == 1 ? ' imagem' : ' imagens'}</span>`

            let colab = ''
            item.vColab.map((e) => {
              colab += 
                `<a href="" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="${e.vNome}">
                  <img alt="Colaborador do Projeto: ${e.vNome}" src="${e.vImg}" class="rounded-circle">
                </a>`
            })

            html +=
            `<div class="col-lg-4">
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
        }

        let paginas = data.vTotal
        for (var i = 1; i <= paginas; i++) {
          pagination +=
          `<li class="page-item ${(i == page) ? ' active' : ''}">
            <a class="page-link" href="${(i != page) ? 'javascript:painel.initPublicos('+i+')' : ''}">
              ${i} ${(i == page) ? ' <span class="sr-only">(Página Atual)</span>' : ''}
            </a>
          </li>`
        }
          pagination =
          `<li class="page-item ${(page == 1) ? ' disabled' : ''}">
              <a class="page-link" href="${(page != 1) ? 'javascript:painel.initPublicos('+(page-1)+')' : ''}" ${(page == 1) ? ' tabindex="-1"' : ''}>
                <i class="fa fa-angle-left"></i>
                <span class="sr-only">Página Anterior</span>
              </a>
            </li>
              ${pagination}
            <li class="page-item ${(page == paginas) ? ' disabled' : ''}">
              <a class="page-link" href="${(page != paginas) ? 'javascript:painel.initPublicos('+(page+1)+')' : ''}" ${(page == paginas) ? ' tabindex="-1"' : ''}>
                <i class="fa fa-angle-right"></i>
                <span class="sr-only">Próxima Página</span>
              </a>
            </li>`

        $('#vPublicos').html(html)
        $('#vPagination').html(pagination)

        if (page != 1) {
          $('html,body').animate({
            scrollTop: $("#pgPublicos").offset().top
          }, 'slow')
        }
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
