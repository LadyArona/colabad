let revisar = false
let imgId = ''

const publicar = {
  initConfig: (id) => {
    app.carregaCombo('cbProjeto', 'P', null, 1)

    $('#cbProjeto').focus()

    $('#inputGroupFile01').change(function(event) {  
      publicar.readURL(this)   
    })

    if (id != '') {
      revisar = true
      imgId = id
      setTimeout(function(){
        publicar.carregaDadosImg(id)
      }, 300);
    }

    $('#btnCancelar').click(function(event) { 
      if (revisar) {
        history.go(-1)
      } else {
        publicar.limpaImagem()
        app.carregaCombo('cbProjeto', 'P', null, 0)
        $('#cbProjeto').focus()
      }
    })

  },
  carregaDadosImg: (id) => {
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
        $('#cbProjeto').closest('div').find('.selectpicker').attr('disabled', false).selectpicker('refresh')
        $('#cbProjeto').val(data.vProjetoId).selectpicker('render').selectpicker('refresh')

        $('#edTitulo').val(data.vTitulo)
        $('#edAudiodescricao').val(data.vDescr)

        let avaliacoes = ''
        if (data.vAvaliacoes.length > 0) {
          data.vAvaliacoes.map((e) => {
            avaliacoes +=
            `<li class="title">
              ${e.vConsultor} ${e.vAcao} em ${e.vData}: ${e.vAvaliacao}
            </li>`
          })
        } else {
          avaliacoes +=
            `<li class="title">
              Esta imagem ainda não foi avaliada por um Consultor.
            </li>`
        }
        avaliacoes = 
          `<ul>
            ${avaliacoes}
          </ul>`

        $('#vAvaliacoes').html(avaliacoes)

        $('#blah').attr('src', `${baseUrl}uploads/${data.vNomeUnico}`)
          $('#blah').attr('alt', data.vNome)
          $('#blah').hide()
          $('#blah').fadeIn(500)      
          $('.custom-file-label').text(data.vNome)

        // bloqueia os campos
        $('#edTitulo').attr('disabled', true)
        $('#inputGroupFile01').attr('disabled', true)
        $('#cbProjeto').closest('div').find('.selectpicker').attr('disabled', true).selectpicker('refresh')
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
      if (revisar) {
        $.ajax({
          url: `${baseUrl}ajax/revisarImagem`,
          data: {
            revisarImagem: '',
            form: $('#formImagem').serialize(),
            imgId: imgId
          },
          dataType: 'JSON',
          type: 'POST',
          beforeSend: () => {
            $.loader({
              className: 'blue-with-image-2',
              content: 'Aguarde, salvando...'
            })
          }
        }).done((data) => {
          if (data.result === 'OK') {
            app.showNotification(`Imagem revisada com sucesso!`, 'success', 2)
            setTimeout(function(){
              history.go(-1)
            }, 2500);
          }
        }).fail((err) => {
          console.log('error dados ', err)
          app.showNotification(`Ops! Ocorreu um erro`, 'danger', 2)
        }).always(() => {
          $.loader('close')
        })
      } else {
        let formData = new FormData()
        formData.append('imagem', $('#inputGroupFile01')[0].files[0])
        formData.append('titulo', $('#edTitulo').val())
        formData.append('projeto', $('#cbProjeto').val())
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
    }
  },
  validaSalvar: () => {
    if (revisar) { 
      if ($('#edAudiodescricao').val() == '') {
        app.showNotification(`Informe a áudiodescrição da imagem!`, 'danger', 5)
        $('#edAudiodescricao').focus()
        return false
      }
    } else {
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

      if(!$("#cbProjeto").selectpicker('val')){
        app.showNotification("Selecione um Projeto para a Imagem", 'danger', 5);
        $("#cbProjeto").selectpicker('toggle').selectpicker('render')
        return false;
      }

      if ($('#inputGroupFile01')[0].files[0] == null) {
        app.showNotification(`Informe a imagem que deseja publicar!`, 'danger', 5)
        $('#inputGroupFile01').focus()
        return false
      }
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

