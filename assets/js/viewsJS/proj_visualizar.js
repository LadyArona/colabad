
const prv = {
  initConfig: (id) => {
    $.ajax({
      url: `${baseUrl}ajax/carregarProjetoVisualizar`,
      data: {
        carregarProjetoVisualizar: '',
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
        let imagens = ''
        let colab = ''

        $('#edTitulo').html(data.vTitulo)
        $('#edDescricao').html(data.vDescricao)
        $('#vPrivado').html(data.vPrivado)

        data.vParticipante.map((item) => {
          let responsavel = item.vResponsavel != '' ? `<small class="h6 text-muted">${item.vResponsavel}</small>` : ''
          colab +=
          `<div class="col-md-3 col-lg-2 mb-5 mb-lg-0">
            <div class="px-4">
              <img src="${baseUrl}assets/img/question.svg" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width: 10rem;">
              <div class="pt-2 text-center">
                <h5 class="title">
                  <span class="d-block mb-1">${item.vNome}</span>
                  <small class="h6 text-muted">${item.vPerfil}</small>
                  ${responsavel}
                </h5>
              </div>
            </div>
          </div>`
        })

        let imgQtd = data.vImagens.length
        let imgQtdDesc = imgQtd == 1 ? 'imagem' : 'imagens'
        $('#vImgQtd').html(`${imgQtd} ${imgQtdDesc}`)

        data.vImagens.map((e) => {
          imagens += 
            `<div class="col-lg-4">
              <div class="card card-lift--hover" style="width: 18rem;">
                <img class="card-img-top" src="${baseUrl}uploads/${e.vNome}" aria-labelledby="card-title">
                <div class="card-body">
                  <h5 class="card-title" aria-disabled>${e.vDesc}</h5>
                  <a class="btn btn-primary btn-block mt-4" 
                     href="${e.vLink}"
                     aria-label="Visualizar imagem ${e.vDesc}">
                    Visualizar Detalhes
                  </a>
                </div>
              </div>
          </div>`
        })

        $('#vParticipante').html(colab)
        $('#vImagensProj').html(imagens)
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
