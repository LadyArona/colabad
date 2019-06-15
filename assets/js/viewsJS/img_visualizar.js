
const img = {
  initConfig: (id) => {
    $.ajax({
      url: `${baseUrl}ajax/carregarImagemVisualizar`,
      data: {
        carregarImagemVisualizar: '',
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
        
        $('#edTitulo').html(data.vTitulo)
        $('#edDescricao').html(data.vDescr)
        $('#vProjeto').html(data.vProjeto)

        let img = 
          `<a href="${baseUrl}uploads/${data.vNomeUnico}" download="${data.vNome}">
            <img src="${baseUrl}uploads/${data.vNomeUnico}" 
              alt="${data.vTitulo}" title='${data.vTitulo}'/>
          </a>`

        $('#img_contain').html(img)

        let colab = ''
        data.vParticipante.map((item) => {
          colab +=
          `<div class="col-md-3 col-lg-2 mb-5 mb-lg-0">
            <div class="px-4">
              <a href="${item.vLink}" target="_blanck">
              <img src="${item.vImg}" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width: 10rem;"
                   alt="Colaborador da Imagem: ${item.vNome}">
                <div class="pt-2 text-center">
                  <h5 class="title">
                    <span class="d-block mb-1">${item.vNome}</span>
                    <span class="h5 text-muted">${item.vPerfil}</span>
                  </h5>
                </div>
              </a>
            </div>
          </div>`
        })
        $('#vParticipante').html(colab)

        let historico = ''
        data.vHistorico.map((e) => {
          historico +=
          `<li class="title">
            ${e.vHistorico}
          </li>`
        })

        historico = 
          `<ul>
            ${historico}
          </ul>`

        $('#vHistorico').html(historico)

        let avaliacoes = ''
        data.vAvaliacoes.map((e) => {
          avaliacoes +=
          `<li class="title">
            ${e.vConsultor} ${e.vAcao} em ${e.vData}: ${e.vAvaliacao}
          </li>`
        })

        avaliacoes = 
          `<ul>
            ${avaliacoes != '' ? avaliacoes : `Nenhuma avaliação`}
          </ul>`

        $('#vAvaliacoes').html(avaliacoes)
        let vAvaliada = (data.vStatus != 'A') ? ' Roteiro da ' : ''
        $('#vAvaliada').html(vAvaliada)
        $('#vBtnAvaliada').html((vAvaliada == '') ? `<i class="fas fa-copy"></i> Copiar Audiodescrição` : `<i class="fas fa-copy"></i> Copiar Roteiro da Audiodescrição`)

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
