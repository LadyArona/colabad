const perfil = {
  initConfig: () => {
    app.carregaCombo('cbParticipante', 'U')

    $('#btnCancelar').click(function(event) {  
      perfil.limparCampos()
      $('#edTitulo').focus()
    })

    $('#btnSalvar').click(function(event) {
      perfil.salvarCadastro()
    })

    $('#cbParticipante').on('changed.bs.select', function(e) {
      perfil.addRow($(this).selectpicker('val'), $(this).find(':selected').text(), 'N')
    })
    //$('.nav-pills a[href="#perfil"]').tab('show')
    perfil.initProjetos()
  }
}
