let myCroppie = []
let blob = []
const perfil = {
  initConfig: () => {
    app.carregaCombo('cbEstado', 'EST')
    $('#cbCidade').closest('div').find('.selectpicker').attr('disabled', true).selectpicker('refresh')
    $('#cbQual').closest('div').find('.selectpicker').attr('disabled', true).selectpicker('refresh')

    $('#cbEstado').on('changed.bs.select', function(e) {
      if ($('#cbEstado').selectpicker('val') > 0){
        app.carregaCombo('cbCidade', 'CID', null, $('#cbEstado').selectpicker('val'))
        $('#cbCidade').closest('div').find('.selectpicker').attr('disabled', false).selectpicker('refresh')
      } else {
        $('#cbCidade').val('').selectpicker('render').selectpicker('refresh')
        $('#cbCidade').closest('div').find('.selectpicker').attr('disabled', true).selectpicker('refresh')
      }
    })

    $('#cbDefic').on('changed.bs.select', function(e) {
      if ($('#cbDefic').selectpicker('val') == 'S') {
        app.carregaCombo('cbQual', 'DEF')
        $('#cbQual').closest('div').find('.selectpicker').attr('disabled', false).selectpicker('refresh')
      } else {
        $('#cbQual').val('').selectpicker('render').selectpicker('refresh')
        $('#cbQual').closest('div').find('.selectpicker').attr('disabled', true).selectpicker('refresh')
      }
    })

    myCroppie = $('#blah').croppie({
      enableExif: true,
      viewport: {
          width: 270,
          height: 270,
          type: 'circle'
      },
      boundary: {
          width: 280,
          height: 280
      },
      update: function(resp){
        myCroppie.croppie('result', {
            type: 'canvas'
          }).then(function (resp) {
            $('#imgPerfil').attr('src', resp);
            $('#imgTopo').attr('src', resp);
          });

        myCroppie.croppie('result', {
            type: 'blob'
          }).then(function (resp) {
            blob = resp;
          });
      }
    })

    $('#img').on('change', function () {
      readFile(this);
    });
  
    $('#btnCancelar').click(function(event) {  
      perfil.initPerfil()
      $('#edNome').focus()
    })

    $('#btnSalvar').click(function(event) {
      perfil.salvarPerfil()
    })

    $('#inputGroupFile01').change(function(event) {  
      perfil.readURL(this)   
    })

    perfil.initPerfil()
  },
  readURL: (input) => {    
    if (input.files && input.files[0]) {
      let file = input.files[0]
      if (file.type != 'image/jpeg' && file.type != 'image/png') {
        app.showNotification(`Tipo de arquivo inválido!<br><strong>${file.type}</strong>`, 'danger', 5)
        return false
      } else {
        var reader = new FileReader();
        var filename = $('#inputGroupFile01').val()
        filename = filename.substring(filename.lastIndexOf('\\')+1)

        reader.onload = function (e) {
          myCroppie.croppie('bind', {
            url: e.target.result
          }).then(function(){
            console.log('Imagem lida com sucesso');
          })
          $('#blah').attr('alt', filename)
          $('.custom-file-label').text(filename)
        }
        reader.readAsDataURL(input.files[0]);
      }
    } 
  },
  initPerfil: () => {
    $.ajax({
      url: `${baseUrl}ajax/carregarPerfil`,
      data: {
        carregarPerfil: ''
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
        console.log(data)
        $('#edNome').val(data.vNome)
        $('#edEmail').val(data.vEmail)
        $('#edAudiodescricao').froalaEditor('html.set', data.vImgAudiodesc)

        app.carregaCombo('cbEstado', 'EST', data.vEstadoId)
        if (data.vCidadeId != '') {
          $('#cbCidade').closest('div').find('.selectpicker').attr('disabled', false).selectpicker('refresh')
          app.carregaCombo('cbCidade', 'CID', data.vCidadeId, data.vEstadoId)
        }
        $('#edOrg').val(data.vOrganizacao)
        $('#cbDefic').val(data.vPossuiDeficiencia).selectpicker('render').selectpicker('refresh')
        if (data.vDeficienciaId != '') {
          $('#cbQual').closest('div').find('.selectpicker').attr('disabled', false).selectpicker('refresh')
          app.carregaCombo('cbQual', 'DEF', data.vDeficienciaId)
        }
        $('#edObs').froalaEditor('html.set', data.vObs)

        perfil.carregaVisualizarPerfil(data)
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
  },
  salvarPerfil: async () => {
    let validar = await perfil.validaCampos()
    if (validar) {
        let formData = new FormData()
        formData.append('imagem', blob);
        formData.append('edNome', $('#edNome').val())
        formData.append('edEmail', $('#edEmail').val())
        formData.append('edPerfilPass', $('#edPerfilPass').val())
        formData.append('edAudiodescricao', $('#edAudiodescricao').val())
        formData.append('cbEstado', $('#cbEstado').val())
        formData.append('cbCidade', $('#cbCidade').val())
        formData.append('edOrg', $('#edOrg').val())
        formData.append('cbDefic', $('#cbDefic').val())
        formData.append('cbQual', $('#cbQual').val())
        formData.append('edObs', $('#edObs').val())

      $.ajax({
        url: `${baseUrl}ajax/salvarPerfil`,
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: () => {
          $.loader({
            className: 'blue-with-image-2',
            content: ''
          })
        }
      }).done((data) => {
        if (data.result === 'OK') {
          app.showNotification(
            `Perfil alterado com sucesso! <br>
            <strong>${data.mensagem}</strong>`,
            'success', 4
          )
        }
      }).fail((err) => {
        console.log('error dados ', err)
        app.showNotification(`Ops! Ocorreu um erro`, 'danger', 1)
      }).always(() => {
        $.loader('close')
      })
    }
  },
  validaCampos: async () => {
    if ($("#edNome").val() == '') {
      app.showNotification("Informe o seu nome!", 'danger', 5)
      $("#edNome").focus()
      return false
    }

    if ($("#edEmail").val() == '') {
      app.showNotification("Informe o seu email!", 'danger', 5)
      $("#edEmail").focus()
      return false
    }

    if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($("#edEmail").val()) == false) {
      app.showNotification("Informe um email válido!", 'danger', 5)
      $("#edEmail").focus()
      return false
    }

    // VERIFICAR SE O EMAIL JÁ EXISTE
    let qtd = await perfil.verificarEmail('edEmail')
    if (qtd > 0) {
      app.showNotification("Email já está cadastrado,<br><strong>tente recuperar sua senha</strong>", 'danger', 5)
      $("#edEmail").focus()
      return false
    }    

    if ($("#edPerfilPass").val() != '') {
      if ($("#edPerfilPass").val().length < 6) {
        app.showNotification("Sua senha deve ter pelo menos 6 caracteres!", 'danger', 5)
        $("#edPerfilPass").focus()
        return false
      }

      if ($("#edConfPass").val() == '') {
        app.showNotification("Confirme a senha!", 'danger', 5)
        $("#edConfPass").focus()
        return false
      }

      if ($("#edPerfilPass").val() != $("#edConfPass").val()) {
        app.showNotification("Verifique as senhas, estão diferentes!", 'danger', 5)
        $("#edPerfilPass").focus()
        return false
      }
    }

    return true
  },
  verificarEmail: async (campo) => {
    const email = $(`#${campo}`).val()
    let result = 0

    await $.ajax({
      url: `${baseUrl}acesso/loginajax/verificarEmail`,
      data: {verificarEmail: '', email},
      dataType: "JSON",
      type: "POST"
    }).done((data) => {
      result = data
    })

    return result
  }
}
