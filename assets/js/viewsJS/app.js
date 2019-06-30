urlAtual = window.location.pathname.split('/')[2];
app = {
  initApp: () => {
    //recarrega a página em 15 minutos para expirar a sessão
    setTimeout(function(){
       window.location.reload(1);
    }, 901000);

    var clipboard = new ClipboardJS('button');
    clipboard.on('success', function(e) {
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });

    /* ACESSIBILIDADE */
    $(function(){
      $('#font-setting-buttons').easyView({
        container: 'body',
        tags: ['html', 'h1','h2','h3','h4','h5','h6', 'div', 'p', 'a', 'span', 'strong', 'em', 'ul', 'ol', 'li', 'button', 'nav', 'footer'],
        step: 10,
        bootstrap: true,
        increaseSelector: '.increase-me',
        decreaseSelector: '.decrease-me',
        normalSelector: '.reset-me',
        contrastSelector: '.change-me'
      });
    });

    $("#toConteudo").click(function() {
        $('html,body').animate({
          scrollTop: ($("#conteudo").offset().top - 50)
        }, 'slow')
        $("#idUsuario").focus()
        app.nextTab("#idUsuario")
    })
    $("#toMenu").click(function() {
        $('html,body').animate({scrollTop: $("#sidenav-main").offset().top}, 'slow')
        $("#mnPainel").focus()
    })

    /* ACESSIBILIDADE */

    // Verifica e controla as notificações quando inicia e depois a cada 5 minutos - 300000
    app.verificaNotificacao()
    setInterval(function () {
      app.verificaNotificacao()
    }, 300000)

    $("body").tooltip({ selector: '[data-toggle=tooltip]' })
 
    document.getElementById("formPesquisar").onsubmit = function onSubmit(form) {
      if ($('#por').val() != '') {
        return true
      } else {
        return false
      }
    }

    document.getElementById("formNavPesquisar").onsubmit = function onSubmit(form) {
      if ($('#navPor').val() != '') {
        return true
      } else {
        return false
      }
    }    
  },
  nextTab: (elemento) => {
    //Isolate the node that we're after
    const currentNode = document.querySelector(elemento);

    //find all tab-able elements
    const allElements = document.querySelectorAll('input, button, a, area, object, select, textarea, [contenteditable]');

    //Find the current tab index.
    const currentIndex = [...allElements].findIndex(el => currentNode.isEqualNode(el))

    //focus the following element
    allElements[currentIndex + 1].focus();
  },
  selectTab: (tabindex = 0) => {
    $('.nav-pills li a').removeClass('active show');
    $('.nav-pills li a').eq(tabindex).addClass('active show');
    $('.tab-pane').removeClass('active show');
    $('.tab-pane').eq(tabindex).addClass('active show');
  },
  showNotification: (message, type, time, multiply = 2000) => {
    $.notify({
        icon: "notifications",
        message: message
    }, {
        z_index: 9999,
        type: type,
        timer: time * multiply,
        placement: {
            from: 'top',
            align: 'center'
        }
    });
  },
  scrollPage:function(element, mais = 0) {
    $('.main-panel').animate({scrollTop:$(element).offset().top - mais}, 1000);
  },
  removerAcentos: s => { 
    let map={"â":"a","Â":"A","à":"a","À":"A","á":"a","Á":"A","ã":"a","Ã":"A","ê":"e","Ê":"E","è":"e","È":"E","é":"e","É":"E","î":"i","Î":"I","ì":"i","Ì":"I","í":"i","Í":"I","õ":"o","Õ":"O","ô":"o","Ô":"O","ò":"o","Ò":"O","ó":"o","Ó":"O","ü":"u","Ü":"U","û":"u","Û":"U","ú":"u","Ú":"U","ù":"u","Ù":"U","ç":"c","Ç":"C"};
    return s.replace(/[\W\[\] ]/g, a => {return map[a]||a}); 
  },
  matomoAnalytics: () => {
    const _paq = window._paq || []
    _paq.push(['trackPageView'])
    _paq.push(['enableLinkTracking'])
    const u = '//10.1.82.34/analytics/'
    _paq.push(['setTrackerUrl', `${u}matomo.php`])
    _paq.push(['setSiteId', '2'])
    const d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0]
    g.type = 'text/javascript'
    g.async = true
    g.defer = true
    g.src = `${u}matomo.js`
    s.parentNode.insertBefore(g, s)
  },
  carregaCombo: (idCombo, tipoInfo, codToSelect = null, codToControl = null) => {
    $("#"+idCombo).empty();
    let urlBusca = 'appajax/carregaDadosCombo';
    $.post(baseUrl + urlBusca, {CarregaDadosCombo: '', tipoInfo, codToControl}, function(j){
        if(j != null){
          for (let i = 0; i < j.length; i++) {
              $("#"+idCombo).append($('<option>', {
                value: j[i].vIdInfo,
                text: j[i].vNomeInfo, 
                selected: function(){
                  if(codToSelect != null){
                    if(j[i].vIdInfo == codToSelect){
                      return true;
                    } 
                  }
                  return false;
                }
              }));
          }
        }
        
        $("#"+idCombo)
          .selectpicker('refresh')
    }, "json");
  },
  carregaComboMultiplo: async (idCombo, tipoInfo, codToSelect = null, codToControl = null, getValue = false) => {
    let urlBusca = 'appajax/carregaDadosCombo';

    $("#"+idCombo).empty()
    let dados = []
    await $.post(baseUrl + urlBusca, {CarregaDadosCombo: '', tipoInfo, codToControl}, function(j){
      dados = j
    }, "json")

    $("#"+idCombo).each(function(index, element) {
      if (getValue) {
        codToSelect = $(element).attr('data-val')
      }

       if(dados != null){
          for (let i = 0; i < dados.length; i++) {
              $(element).append($('<option>', {
                'data-icon': dados[i].vIconInfo != '' ? dados[i].vIconInfo : '',
                value: dados[i].vIdInfo,
                text: dados[i].vNomeInfo, 
                style: dados[i].vCorInfo != '' ? 'border-bottom: 2px solid ' + dados[i].vCorInfo  : '',
                selected: function(){
                  if(codToSelect != null){
                    if(dados[i].vIdInfo == codToSelect){
                      return true;
                    } 
                  }
                  return false;
                }
              }));
          }
        }
        
        $(element)
          .selectpicker('refresh')
    })
  },
  carregaComboOpt: (idCombo, tipoInfo, codToSelect = null, codToControl = null) => {
    $("#"+idCombo).empty();
    $.post(baseUrl + 'appajax/carregaDadosComboOpt', {CarregaDadosComboOpt: '', tipoInfo, codToControl}, function(j){
      if(j != null){
        let control = 0;
        for(let i in j){
          $("#"+idCombo).append($('<optgroup>', {
            label: i,
            id: 'opt'+control+i.split(' ')[0]
          }));
          for (let n = 0; n < j[i].length; n++) {         
            $("#opt"+control+i.split(' ')[0]).append($('<option>', {
                'data-icon': j[i][n].vIconInfo != '' ? j[i][n].vIconInfo : '',
                value: j[i][n].vIdInfo,
                text: j[i][n].vNomeInfo, 
                style: j[i][n].vCorInfo != '' ? 'border-bottom: 2px solid ' + j[i][n].vCorInfo  : '',
                selected: function(){
                  if(codToSelect != null){
                    if(j[i][n].vIdInfo == codToSelect){
                      return true;
                    } 
                  }
                  return false;
                }
            }));
          }
          control ++;
        }
      }
      
      $("#"+idCombo).selectpicker('refresh')
    }, "json");
  },
  verificaNotificacao: function () {
    $('ul.itensNotificacoes .notficDropSoliticacoes ul li').remove()
    $('ul.itensNotificacoes .notficDropAvisos  #divAvisos div, ul.itensNotificacoes .notficDropAvisos  #divNavAvisos div').remove()
    $('ul.itensNotificacoes span').remove()

    $.post(
      baseUrl + 'appajax/buscaNotificacoes',
      {Notificacoes: ''},
      function (j) {
        if (j != null) {
          $('ul.itensNotificacoes .notficDropSoliticacoes ul').append(
            ['<span class="notification">'].join('')
          )
          let totalSolicitacoesNL = 0
          let totalAvisosNL = 0
          let contS = 0
          let contA = 0
          for (let i = 0; i < j.length; i++) {
            if (j[i].vNotTipo == 'S') {
              if (j[i].vNotLida == 'N') {
                totalSolicitacoesNL++
              }
              $('ul.itensNotificacoes .notficDropSoliticacoes ul').append(
                [
                  '<li>',
                  '<span class"text-muted" style="font-size:10px; float: right;">' +
                    j[i].vNotDataHora +
                    '</span>',
                  j[i].vNotLida == 'S'
                    ? '<button aria-label="Marcar como não lida esta notificação" class"text-muted" style="font-size:10px; float:left; cursor:pointer;" onclick="app.atualizaNotificacaoLerNaoLerExcluir(' +
                      j[i].vNotId +
                      ',\'N\')"><i class="iconAction fa fa-undo pr-1"></i>Não lida</button>'
                    : '',
                  '<button aria-label="Excluir esta notificação" class"text-muted" style="font-size:10px; float:left; cursor:pointer;" onclick="app.atualizaNotificacaoLerNaoLerExcluir(' +
                    j[i].vNotId +
                    ",'S','" +
                    '' +
                    '\',\'S\')"><i class="iconAction fa fa-close pr-1"></i>Excluir</button>',
                  '<a href="#" class="notfic" onclick="app.atualizaNotificacaoLerNaoLerExcluir(' +
                    j[i].vNotId +
                    ",'S','" +
                    j[i].vNotDireciona +
                    '\')">',
                  (j[i].vNotLida == 'S'
                    ? '<i class="fa fa-envelope-open pr-1" style="color:#17bcd0;" aria-hidden="true"></i> '
                    : '<i class="fa fa-envelope pr-1" style="color:#f44336;" aria-hidden="true"></i> ') +
                    j[i].vNotDesc,
                  '</a>',
                  '</li>'
                ].join('')
              )
              contS++
            } else {
              if (j[i].vNotLida == 'N') {
                totalAvisosNL++
              }
              $('ul.itensNotificacoes .notficDropAvisos #divAvisos, ul.itensNotificacoes .notficDropAvisos #divNavAvisos').append(
                [
                  '<div class="dropdown-item">',
                    '<div class="row pb-2">',
                      '<div class="col-sm-7 pb-2">',
                      '<button aria-label="Excluir esta notificação" class="btn btn-sm btn-outline-danger" style="font-size:12px; padding: 0.05rem .5rem;" onclick="app.atualizaNotificacaoLerNaoLerExcluir(' +
                          j[i].vNotId +
                          ",'S','" +
                          '' +
                          '\',\'S\')"><i class="iconAction fas fa-close pr-1"></i>Excluir</button>',
                      '</div>',
                      '<div class="col-sm-4 text-right">',
                        '<span  class="badge badge-success" style="font-size:12px;">' +
                          j[i].vNotDataHora +
                        '</span>',
                      '</div>',
                      '<div class="col-sm-12">',
                        '<a href="#" class="notfic" onclick="app.atualizaNotificacaoLerNaoLerExcluir(' +
                          j[i].vNotId + ",'S','" + j[i].vNotDireciona + '\')">',
                        
                          (j[i].vNotLida == 'S'
                            ? '<i class="fas fa-envelope-open pr-1" style="color:#17bcd0;" aria-hidden="true"></i> '
                            : '<i class="fas fa-envelope pr-1" style="color:#f44336;" aria-hidden="true"></i> ') + j[i].vNotDesc,
                        '</a>',
                      '</div>',
                    '</div>',
                  '</div>'
                ].join('')
              )
              contA++
            }
          }

          if (totalSolicitacoesNL > 0 && contS > 0) {
            $('ul.itensNotificacoes .notficDropSoliticacoes a.nav-link')
              .append(['<span class="badge badge-pill page-link"style="float: right; margin-left: 3px;">' + totalSolicitacoesNL + '</span>'].join(''))
            if (contS > 3) {
              $('ul.itensNotificacoes .notficDropSoliticacoes ul').css(
                'height',
                '350px')
            }
          } else if (totalSolicitacoesNL == 0 && contS == 0) {
            $('ul.itensNotificacoes .notficDropSoliticacoes ul').append(
              ['div class="dropdown-item"><a href="#" class="notfic">Sem solicitações</a></div>'].join('')
            )
          }

          if (totalAvisosNL > 0 && contA > 0) {
            $('ul.itensNotificacoes .notficDropAvisos a.nav-link')
              .append(['<span class="badge badge-pill page-link"style="float: right; margin-left: 3px;">' + totalAvisosNL + '</span>'].join('')
            )
            if (contA > 3) {
              $('ul.itensNotificacoes .notficDropAvisos ul').css(
                'height',
                '350px'
              )
            }
          } else if (totalAvisosNL == 0 && contA == 0) {
            $('ul.itensNotificacoes .notficDropAvisos #divAvisos, ul.itensNotificacoes .notficDropAvisos #divNavAvisos')
              .append(['<li><a href="#" class="notfic">Sem notificações</a></li>'].join(''))
          }
        } else {
          $('ul.itensNotificacoes .notficDropSoliticacoes #divAvisos, ul.itensNotificacoes .notficDropSoliticacoes #divNavAvisos')
            .append(['<div class="dropdown-item"><a href="#" class="notfic">Sem solicitações</a></div>'].join(''))
          $('ul.itensNotificacoes .notficDropAvisos #divAvisos, ul.itensNotificacoes .notficDropAvisos #divNavAvisos').append(
            ['<div class="dropdown-item"><a href="#" class="notfic">Sem notificações</a></div>'].join(
              ''
            )
          )
        }
      },
      'json'
    )
  },
  atualizaNotificacaoLerNaoLerExcluir: function ( cod, lerNaoler, linkDireciona = '', excluir = 'N') {
    $.post(baseUrl + 'appajax/atualizaStatusNotificacao', {
      Notificacao: '',
      codNotificacao: cod,
      lerNaoler: lerNaoler,
      excluir: excluir
    },
    function (data) {
      if (data.result == 'OK') {
        app.verificaNotificacao()
        setTimeout(function () {
          if (linkDireciona != '') {
            window.location = baseUrl + linkDireciona
          }
        }, 100)
      }
    }, 'json'
    )
  }
}



