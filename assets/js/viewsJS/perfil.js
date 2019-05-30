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
        publicar.limpaImagem()
        $('#inputGroupFile01').focus()
        return false
      } else {
        var reader = new FileReader()
        var filename = $('#inputGroupFile01').val()
        filename = filename.substring(filename.lastIndexOf('\\')+1)
        reader.onload = function(e) {
          // debugger      
          $('#blah').attr('src', e.target.result)
          $('#blah').attr('alt', filename)
          $('#blah').hide()
          $('#blah').fadeIn(500)      
          $('.custom-file-label').text(filename)
          $('#blah').focus()
        }
        reader.readAsDataURL(input.files[0])
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
        $('#edTitulo').val(data.vTitulo)
        $('#edDescricao').froalaEditor('html.set', data.vDescricao)

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
  salvarPerfil: async () => {
    let validar = await login.validaCampos()
    if (validar) {
        let formData = new FormData()
        formData.append('imagem', $('#inputGroupFile01')[0].files[0])
        formData.append('edNome', $('#edNome').val())
        formData.append('edEmail', $('#edEmail').val())
        formData.append('edPass', $('#edPass').val())
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

    if ($("#edPass").val() == '') {
      app.showNotification("Informe a senha!", 'danger', 5)
      $("#edPass").focus()
      return false
    }

    if ($("#edPass").val().length < 6) {
      app.showNotification("Sua senha deve ter pelo menos 6 caracteres!", 'danger', 5)
      $("#edPass").focus()
      return false
    }

    if ($("#edConfPass").val() == '') {
      app.showNotification("Confirme a senha!", 'danger', 5)
      $("#edConfPass").focus()
      return false
    }

    if ($("#edPass").val() != $("#edConfPass").val()) {
      app.showNotification("Verifique as senhas, estão diferentes!", 'danger', 5)
      $("#edPass").focus()
      return false
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
  },
  limpaImagem: () => {
    $('#inputGroupFile01').val('')
    $('#blah').hide()
    $('#blah').attr('src', `${baseUrl}assets/img/imagem_generica.png`)
    $('#blah').attr('alt', 'Imagem Genérica (sua imagem aparece aqui)')
    $('#blah').fadeIn(500)
    $('.custom-file-label').text('Selecione a imagem')
  }
}
