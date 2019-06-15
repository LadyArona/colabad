const avaliar = {
  initConfig: () => {

    avaliar.initAvaliar()
  },
  initAvaliar: () => {
    $('#vAvaliar').html('')

    $.ajax({
      url: `${baseUrl}ajax/carregarAvaliar`,
      data: {
        carregarAvaliar: ''
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

        if (data.length > 0) {
          data.map((e) => {
            html +=
            `<div class="col-lg-4">
                <div class="card card-lift--hover ${e.vStatusClass}" style="width: 18rem; margin-bottom: 2rem;">
                  <img class="card-img-top" src="${e.vImg}" aria-labelledby="card-title${e.vImgId}" alt="">
                  <div class="card-body">
                    <h5 class="card-title" id="card-title${e.vImgId}" aria-disabled="true">${e.vImgTitulo}</h5>
                    <a class="btn btn-primary btn-block mt-4" 
                       href="${baseUrl+e.vImgLink}"
                       aria-label="Avaliar imagem ${e.vImgTitulo}">
                      Avaliar esta Imagem
                    </a>
                  </div>
                </div>
            </div>`
          })
        } else {
          html +=
            `<div class="col-lg-4">
              <h5>Não há imagens para avaliar</h5>
            </div>`
        }

        $('#vAvaliar').html(html)
    }).fail((err) => {
      console.log('error dados ', err)
      app.showNotification(`Ops! Ocorreu um erro`, 'danger', 2)
    }).always(() => {
      $.loader('close')
    })
  }
}
