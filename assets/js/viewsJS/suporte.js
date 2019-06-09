const suporte = {
  initConfig: () => {
    $('#btnEnviar').click(function(event) {  
      suporte.enviarMensagem()
    })
  },
  enviarMensagem: () => {
    if (suporte.validaCampos()) {
      $.ajax({
        url: `${baseUrl}ajax/emailSuporte`,
        data: {
          emailSuporte: '',
          form: $('#formSuporte').serialize()
        },
        dataType: 'JSON',
        type: 'POST',
        beforeSend: () => {
          $.loader({
            className: 'blue-with-image-2',
            content: 'Aguarde, enviando mensagem...'
          })
        }
      }).done((data) => {
        if (data.result === 'OK') {
          app.showNotification(`Mensagem enviada!`, 'success', 2)
          $('#formSuporte').trigger("reset")
        }
      }).fail((err) => {
        console.log('error dados ', err)
        app.showNotification(`Ops! Ocorreu um erro`, 'danger', 2)
      }).always(() => {
        $.loader('close')
      })
    }
  },
  validaCampos: () => {
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

    if ($('#edMensagem').val() == '') {
      app.showNotification(`Informe a sua mensagem!`, 'danger', 5)
      $('#edMensagem').focus()
      return false
    }

    return true
  }
}
