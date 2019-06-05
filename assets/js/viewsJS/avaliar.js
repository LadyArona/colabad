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
/*vImgId
vProjId
vProjTitulo
vProjLink*/

        let status = ''
        data.map((e) => {
          /*P = PUBLICADA | A = APROVADA | R = REPROVADA | V = PARA AVALIAR*/
          switch (e.vStatus) {
            case "P":
              status = ' has-default '
              break;
            case "A":
              status = ' has-success '
              break;
            case "R":
              status = ' has-danger '
              break;
            case "V":
              status = ' has-primary '
              break;
            default:
              status = ''
          }

          html +=
          `<div class="col-lg-4">
              <div class="card card-lift--hover ${status}" style="width: 18rem; margin-bottom: 2rem;">
                <img class="card-img-top" src="${e.vImg}" aria-labelledby="card-title">
                <div class="card-body">
                  <h5 class="card-title" aria-disabled>${e.vImgTitulo}</h5>
                  <a class="btn btn-primary btn-block mt-4" 
                     href="${baseUrl+e.vImgLink}"
                     aria-label="Avaliar imagem ${e.vImgTitulo}">
                    Avaliar esta Imagem
                  </a>
                </div>
              </div>
          </div>`
        })

        $('#vAvaliar').html(html)
    }).fail((err) => {
      console.log('error dados ', err)
      app.showNotification(`Ops! Ocorreu um erro`, 'danger', 2)
    }).always(() => {
      $.loader('close')
    })
  }
}
