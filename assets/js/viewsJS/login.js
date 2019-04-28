const login = {
  initConfigTela: () => {
    $('body').tooltip({selector: '[data-toggle=tooltip]'})
  },
  validaCampos: function() {
    if($("#edNome").val() == ''){
      app.showNotification("Informe o seu nome!", 'danger', 5)
      $("#edNome").focus()
      return false
    }

    if($("#edEmail").val() == ''){
      app.showNotification("Informe o seu email!", 'danger', 5)
      $("#edEmail").focus()
      return false
    }

    // VERIFICAR SE O EMAIL JÁ EXISTE

    if($("#edPass").val() == ''){
      app.showNotification("Informe a senha!", 'danger', 5)
      $("#edPass").focus()
      return false
    }

    if($("#edConfPass").val() == ''){
      app.showNotification("Confirme a senha!", 'danger', 5)
      $("#edConfPass").focus()
      return false
    }

    if($("#edPass").val() != $("#edConfPass").val()){
      app.showNotification("Verifique as senhas, estão diferentes!", 'danger', 5)
      $("#edPass").focus()
      return false
    }

    return true
  },
  salvarCadastro: function() {
    if(login.validaCampos()){
        $.ajax({
          url: `${baseUrl}acesso/loginajax/salvarCadastro`,
          data: {salvarCadastro: '', Form: $('#formCadastrar').serialize(), },
          dataType: "JSON",
          type: "POST",
          beforeSend: function() {
           $.loader({
               className:"blue-with-image-2",
               content:'Aguarde, salvando dados.'
           }) 
          },
          error: function (){
            app.showNotification('Erro ao cadastrar', 'danger', 2)
          },
        }).done((data) => {
          if (data.result === 'OK') {
            app.showNotification(
              `Você se cadastrou, <br>
              <strong>${data.mensagem}</strong>`,
              'success', 1
            )
          } else
          if (data.result === 'ERRO') {
            console.log('error dados ', err)
            app.showNotification(`Erro ao cadastrar ${data.mensagem}`, 'danger', 2)
          }
        }).fail((err) => {
          console.log('error dados ', err)
          app.showNotification('Erro ao cadastrar', 'danger', 2)
        }).always(() => {
          $.loader('close')
        })
    }
  }
}
