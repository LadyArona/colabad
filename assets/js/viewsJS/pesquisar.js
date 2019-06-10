const pesquisar = {
  initConfig: (pesquisa) => {
    pesquisar.initPesquisar(pesquisa)
  },
  initPesquisar: (pesquisa) => {
    $('#vPesquisar').html('')

    $.ajax({
      url: `${baseUrl}ajax/carregarPesquisar`,
      data: {
        carregarPesquisar: '',
        pesquisa
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
        let html = ''
        let lista = ''

        if (data.length > 0) {
          data.map((e) => {
            lista +=
            `<li class="mb-3">
              <a href="${baseUrl+e.vLink}"
                 aria-label="${e.vDescr}">
                <span class="badge badge-primary">${e.vDescr}</span> ${e.vCampo}
              </a>
            </li>`
          })
        } else {
          lista += `Nenhum registro encontrado.`
        }

        html += 
          `<ul class="navbar-nav d-md-inline-flex ml-3">
          ${lista}
          </ul>`

        $('#vPesquisar').html(html)
    }).fail((err) => {
      console.log('error dados ', err)
      app.showNotification(`Ops! Ocorreu um erro`, 'danger', 2)
    }).always(() => {
      $.loader('close')
    })
  }
}
