let tabelaProjetos = []
let participantes = []

const projetos = {
  initConfig: () => {
    app.carregaCombo('cbParticipante', 'U')

    $('#btnCancelar').click(function(event) {  
      projetos.limparCampos()
      $('#edTitulo').focus()
    })

    $('#btnSalvar').click(function(event) {  
      projetos.salvarCadastro()
    })

    $('#cbParticipante').on('changed.bs.select', function(e) {
      projetos.addRow($(this).selectpicker('val'), $(this).find(':selected').text(), 'N')
    })
    //$('.nav-pills a[href="#projetos"]').tab('show')
    projetos.initTabelaProjetos(columnDefsProjetos, colOrdemProjetos)
  },
  addRow: (idColaborador, nomeColaborador, resp) => {
    if (participantes.findIndex(x => x.cod === idColaborador) === -1) {
      const responsavel = (resp === 'S') ? '&nbsp;&nbsp;<span class="label label-success">(Responsável)</span>' : ''
      $('table.tableParticipantes').find('tbody').append([
        `<tr id="tr_${idColaborador}">
            <td class="nomeColab">${nomeColaborador}${responsavel}</td>
            <td style="cursor:pointer">
              <i class="fa fa-user" data-toggle="tooltip" data-placement="top" title="Tornar Responsável pelo Projeto"
               style="cursor: pointer;font-size: 0.9em;border: 1px solid #cad1d7; padding: 5px 6px 5px 6px; background-color: lightsteelblue; border-radius: 3px;"
               onclick="projetos.carregaDefineResponsavel(${idColaborador})"></i>&nbsp;&nbsp;
              <i class="fa fa-close" data-toggle="tooltip" title="Remover do Projeto" 
               style="cursor: pointer;font-size: 0.9em;border: 1px solid #cad1d7; padding: 5px 6px 5px 6px; background-color: tomato; border-radius: 3px;"
               onclick="projetos.removeRow(${idColaborador}, 1)"></i>
            </td>
        </tr>`
      ].join(''))
      participantes.push({
        cod: idColaborador,
        nome: nomeColaborador,
        resp
      })
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
  carregaDefineResponsavel: (id = 0, arrColabEdit = null) => {
    const participantesAux = (arrColabEdit != null) ? arrColabEdit : participantes
    $(participantes).each((index, el) => {
      projetos.removeRow(el.cod)
    })
    setTimeout(() => {
      $(participantesAux).each((index, el) => {
        if (id > 0) {
          projetos.addRow(el.cod, el.nome, (parseInt(el.cod, 10) === parseInt(id, 10)) ? 'S' : 'N')
        } else if (arrColabEdit != null) {
          projetos.addRow(el.cod, el.nome, el.resp)
        }
      })
    }, 500)
  },
  initTabelaProjetos: (columnDefs, colOrdem) => {
    $('#tabelaProjetos').dataTable().fnDestroy()
    tabelaProjetos =
      $('#tabelaProjetos').DataTable({
        language: {
          url: `${baseUrl}assets/js/pt-br_datatables.js`
        },
        serverSide: true,
        processing: true,
        responsive: true,
        info: true,
        stateSave: true,
        ajax: {
          url: `${baseUrl}ajax/buscarProjeto`,
          data: {buscarProjeto: ''},
          type: 'POST'
        },
        ordering: true,
        columnDefs,
        deferRender: true,
        scrollCollapse: true,
        scroller: {
          loadingIndicator: true
        }
      })

    if (colOrdem.length > 0) {
      tabelaProjetos.order(colOrdem).draw()
    }

    tabelaProjetos.columns.adjust()
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
          app.showNotification(
            `Projeto cadastrado com sucesso! <br>
            <strong>${data.mensagem}</strong>`,
            'success', 2
          )

          $('#btnCancelar').click()
          tabelaProjetos.ajax.reload()
          //$('.nav-pills a[href="#projetos"]').tab('show')
          app.selectTab(0)
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

        $('#cbPublico').val(data.vPublico).selectpicker('render').selectpicker('refresh')
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
  }
}
