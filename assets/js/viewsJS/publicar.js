
const publicar = {
  initConfig: () => {
    $('#edTitulo').focus()

    $('#inputGroupFile01').change(function(event) {  
      publicar.readURL(this)   
    })

    $('#btnCancelar').click(function(event) {  
      publicar.limpaImagem()
      $('#edTitulo').focus()
    })
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
          $('#btnSalvar').focus()
        }
        reader.readAsDataURL(input.files[0])
      }
    } 
  },
  salvaImagem: () => {
    if (publicar.validaSalvar()) {
        let formData = new FormData()
        formData.append('imagem', $('#inputGroupFile01')[0].files[0])
        formData.append('titulo', $('#edTitulo').val())
        formData.append('descricao', $('#edAudiodescricao').val())

      $.ajax({
        url: `${baseUrl}ajax/salvaImagem`,
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
            `Imagem publicada com sucesso! <br>
            <strong>${data.mensagem}</strong>`,
            'success', 2
          )
          $('#btnCancelar').click()
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
      app.showNotification(`Informe o título da imagem!`, 'danger', 5)
      $('#edTitulo').focus()
      return false
    }

    if ($('#edAudiodescricao').val() == '') {
      app.showNotification(`Informe a áudiodescrição da imagem!`, 'danger', 5)
      $('#edAudiodescricao').focus()
      return false
    }

    if ($('#inputGroupFile01')[0].files[0] == null) {
      app.showNotification(`Informe a imagem que deseja publicar!`, 'danger', 5)
      $('#inputGroupFile01').focus()
      return false
    }

    return true
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

