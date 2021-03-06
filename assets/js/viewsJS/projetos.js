let participantes = []

const projetos = {
  initConfig: (colabAtual) => {
    app.carregaCombo('cbParticipante', 'U', colabAtual)

    setTimeout(function(){
      projetos.addRow($('#cbParticipante').selectpicker('val'), $('#cbParticipante').find(':selected').text(), 'N')
      $('#cbParticipante').val('').selectpicker('render').selectpicker('refresh')
    }, 2000);

    $('#btnCancelar').click(function(event) {  
      projetos.limparCampos()
    })

    $('#btnSalvar').click(function(event) {  
      projetos.salvarCadastro()
    })

    $('#cbParticipante').on('changed.bs.select', function(e) {
      projetos.addRow($(this).selectpicker('val'), $(this).find(':selected').text(), 'N')
    })
    
    projetos.initProjetos()
  },
  addRow: (idColaborador, nomeColaborador) => {
    if (participantes.findIndex(x => x.cod === idColaborador) === -1) {
      $('table.tableParticipantes').find('tbody').append([
        `<tr id="tr_${idColaborador}">
            <td class="nomeColab">${nomeColaborador}</td>
            <td style="cursor:pointer">
              <a role="button" aria-pressed="false" tabindex="0" class="fa fa-close" data-toggle="tooltip" title="Remover ${nomeColaborador} do Projeto" 
               style="cursor: pointer;font-size: 0.9em;border: 1px solid #cad1d7; padding: 5px 6px 5px 6px; background-color: tomato; border-radius: 3px;"
               onclick="projetos.removeRow(${idColaborador}, 1)"></a>
            </td>
        </tr>`
      ].join(''))
      participantes.push({
        cod: idColaborador,
        nome: nomeColaborador,
        resp: 'N'})
    }
    $('#cbParticipante').val('').selectpicker('render').selectpicker('refresh')
  },
  removeRow: (p, reloadCombo = false) => {
    const tr = $(`#tr_${p}`)
    tr.fadeOut(400, () => {
      tr.remove()
    })
    if (reloadCombo) {
      app.carregaCombo('cbParticipante', 'U')
    }
    participantes = $.grep(participantes, (n, i) => {
      return n.cod !== String(p)
    })
    return false
  },
  initProjetos: () => {
    $('#vProjetos').html('')

    $.ajax({
      url: `${baseUrl}ajax/buscarProjeto`,
      data: {
        buscarProjeto: ''
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
            `<div class="col-lg-4 pb-4">
              <div class="card card-lift--hover shadow border-0">
                <div class="card-body py-4">
                  <h3 class="title text-uppercase">Nenhum Projeto</h3>
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
                `<a href="${e.vLink}" tabindex="-1" target="_blanck" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="${e.vNome}">
                  <img tabindex="-1" alt="Colaborador do Projeto: ${e.vNome}" src="${e.vImg}" class="rounded-circle">
                </a>`
            })

            let editar = ''
            if (item.vResp == 'S') {
              editar =
                `<div class="col-md-6">
                  <button class="btn btn-default btn-block"
                  onclick='projetos.carregaEdit(${item.vId});'
                  aria-label="Editar projeto ${item.vTitulo}">
                    <i class="fas fa-edit"></i> Editar
                  </button>
                </div>`
            }

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
                    ${editar}
                    <div class="col-md-${(editar != '') ? '6' : '12'}">
                      <a class="btn btn-primary btn-block"
                      href='${item.vLink}'
                      aria-label="Visualizar projeto ${item.vTitulo}">
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
  salvarCadastro: () => {
    if (projetos.validaSalvar()) {
      $.ajax({
        url: `${baseUrl}ajax/salvarProjeto`,
        data: {
          salvarProjeto: '',
          form: $('#formProjeto').serialize(),
          participantes
        },
        dataType: 'JSON',
        type: 'POST',
        beforeSend: () => {
          $.loader({
            className: 'blue-with-image-2',
            content: ''
          })
        }
      }).done((data) => {
        if (data.result === 'OK') {
          window.location.reload()
        }
      }).fail((err) => {
        console.log('error dados ', err)
        app.showNotification(`Ops! Ocorreu um erro`, 'danger', 1)
      }).always(() => {
        $.loader('close')
      })
    }
  },
  validaSalvar: () => {
    if ($('#edTitulo').val() == '') {
      app.showNotification(`Informe o título do Projeto!`, 'danger', 5)
      $('#edTitulo').focus()
      return false
    }

    if(!$("#cbPublico").selectpicker('val')){
      app.showNotification("Selecione o Tipo de Privacidade do Projeto", 'danger', 5);
      $("#cbPublico").selectpicker('toggle').selectpicker('render')
      return false;
    }

    if(!$("#cbStatus").selectpicker('val')){
      app.showNotification("Selecione o Status do Projeto", 'danger', 5);
      $("#cbStatus")
        .selectpicker('toggle')
        .selectpicker('render');
      return false;
    }

    if (participantes.length == 0) {
      app.showNotification('Informe os Colaboradores do Projeto', 'danger', 5)
      $('#cbParticipante').selectpicker('toggle').selectpicker('render')
      return false
    }

    return true
  },
  carregaEdit:(id) => {
    $.ajax({
      url: `${baseUrl}ajax/carregarProjeto`,
      data: {
        carregarProjeto: '',
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
        app.selectTab(1)

        $('#edTitulo').val(data.vTitulo)
        $('#edDescricao').val(data.vDescricao)

        $('#cbPublico').val(data.vPrivado).selectpicker('render').selectpicker('refresh')
        $('#cbStatus').val(data.vStatus).selectpicker('render').selectpicker('refresh')

        $('#edEditar').val('S')
        $('#edCodigo').val(data.vId)

        if (data.vParticipante.length > 0) {
          data.vParticipante.map(function (el) {
            projetos.addRow(el.vId, el.vNome, el.vResponsavel)
          })
        }

         $('#edTitulo').focus()
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
  limparCampos: () => {
    $('#cbPublico').val(0).selectpicker('render').selectpicker('refresh')
    $('#cbStatus').val('A').selectpicker('render').selectpicker('refresh')
    $('#cbParticipante').val('').selectpicker('render').selectpicker('refresh')

    $('#edEditar').val('N')
    $('#edCodigo').val('')

    $(participantes).each(function (index, el) {
      projetos.removeRow(el.cod)
    })

    app.selectTab(0)
  }
}
