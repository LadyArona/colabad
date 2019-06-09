const perfilVis = {
  initConfig: (id) => {
    perfilVis.initPerfil(id)
  },
  initPerfil: (id) => {
    $.ajax({
      url: `${baseUrl}ajax/carregarPerfil`,
      data: {
        carregarPerfil: '',
        id
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
        perfilVis.carregaVisualizarPerfil(data)
      } else
      if (data.result == 'ERRO') {
        console.log('error dados ', data)
        app.showNotification(`Ops! Erro ao carregar ${data.mensagem}`, 'danger', 2)
      }
    }).fail((err) => {
      console.log('error dados ', err)
      app.showNotification(`Ops! Ocorreu um erro`, 'danger', 2)
    }).always(() => {
      $.loader('close')
    })
  },
  carregaVisualizarPerfil: (data) => {
    $('#imgPerfil').attr('src', `${baseUrl}assets/img/usuario_padrao.jpg`)
    $('#imgPerfil').attr('alt', `Imagem Padrão`)
    if (data.vImgNomeUniq != '') {
      $('#imgPerfil').attr('src', `${baseUrl}assets/img/users/${data.vImgNomeUniq}`)
      $('#imgPerfil').attr('alt', data.vImgAudiodesc)
    }

    $('#vProjetos').html(data.vProjetos)
    $('#vFotos').html(data.vFotos)
    $('#vAprovadas').html(data.vAprovadas)

    let html = 
          `<h2>
            ${data.vNome}
          </h2>`

    if ((data.vCidadeDescr != '') && (data.vEstadoDescr != '')) {
      html +=
        `<div class="h5 font-weight-300">
          ${data.vCidadeDescr}, ${data.vEstadoDescr}
        </div>`
    } else {
      if (data.vCidadeDescr != '') {
        html +=
          `<div class="h5 font-weight-300">
            ${data.vCidadeDescr}
          </div>`
      }

      if (data.vEstadoDescr != '') {
        html +=
          `<div class="h5 font-weight-300">
            ${data.vEstadoDescr}
          </div>`
      }
    }

    if (data.vOrganizacao != '') {
      html +=
        `<br>
        <div class="h5 font-weight-300">
          ${data.vOrganizacao}
        </div>`
    }

    if (data.vPerfil != '') {
      html +=
        `<div>
          ${data.vPerfil}
        </div>`
    }

    if (data.vDeficiencia != '') {
      html +=
        `<div class="pt-2">
          <span class="badge badge-pill badge-primary">${data.vDeficiencia}</span>
        </div>`
    }

    if (data.vObs != '') {
      html +=
        `<hr class="my-4" />
        ${data.vObs}`
    }

    $('#divPerfilInfo').html(html)
  }
}
