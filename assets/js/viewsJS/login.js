const login = {
  initConfigTela: () => {
    $('body').tooltip({selector: '[data-toggle=tooltip]'})

    $('#edPass').keyup(function(event) {
      login.validaSenha(this.value)
    })
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
    let qtd = await login.verificarEmail()
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

    if (!$('#CheckRegistrar')[0].checked) {
      app.showNotification("Concorde com a Política de Privacidade e Termos de Uso para se cadastrar!", 'danger', 5)
      $("#CheckRegistrar").focus()
      return false
    }

    return true
  },
  salvarCadastro: async () => {
    let validar = await login.validaCampos()
    if (validar) {
      $.ajax({
        url: `${baseUrl}acesso/loginajax/salvarCadastro`,
        data: {
          salvarCadastro: '', 
          Form: $('#formCadastrar').serialize()
        },
        dataType: "JSON",
        type: "POST",
        beforeSend: function() {
         $.loader({
             className:"blue-with-image-2",
             content:'Aguarde, salvando dados.'
         }) 
        }
      }).done((data) => {
        if (data.result === 'OK') {
          app.showNotification(
            `Você se cadastrou, <br>
            <strong>${data.mensagem}</strong>`,
            'success', 1
          )
        } else
        if (data.result === 'ERRO') {
          console.log('error dados ')
          app.showNotification(`Erro ao cadastrar ${data.mensagem}`, 'danger', 2)
        }
      }).fail((err) => {
        console.log('error dados ', err)
        app.showNotification('Erro ao cadastrar', 'danger', 2)
      }).always(() => {
        $.loader('close')
      })
    }
  },
  verificarEmail: async () => {
    const email = $("#edEmail").val()
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
  validaSenha: (password) => {
    // Do not show anything when the length of password is zero.
    if (password.length === 0) {
        $('#msg').html('Sua senha deve ter pelo menos 6 caracteres!')
        document.getElementById("msg").style.color = 'grey';
        return;
    }
    // Create an array and push all possible values that you want in password
    var matchedCase = new Array();
    matchedCase.push("[$@$!%*#?&]"); // Special Charector
    matchedCase.push("[A-Z]");      // Uppercase Alpabates
    matchedCase.push("[0-9]");      // Numbers
    matchedCase.push("[a-z]");     // Lowercase Alphabates

    // Check the conditions
    var ctr = 0;
    for (var i = 0; i < matchedCase.length; i++) {
        if (new RegExp(matchedCase[i]).test(password)) {
            ctr++;
        }
    }
    // Display it
    var color = "";
    var strength = "";
    switch (ctr) {
        case 0:
        case 1:
        case 2:
            strength = "Fraca";
            color = "red";
            break;
        case 3:
            strength = "Média";
            color = "orange";
            break;
        case 4:
            strength = "Forte";
            color = "green";
            break;
    }
    $('#msg').html(strength);
    document.getElementById("msg").style.color = color;
  }
}
