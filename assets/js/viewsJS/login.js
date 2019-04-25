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
          complete: function(){
            $.loader('close')
          },
          success: function(data){
            if (data.result == "OK") {
              app.showNotification('Cadastro realizado!', 'success', 2)
            }
          }
        })
    }
  }
}
