urlAtual = window.location.pathname.split('/')[2];
app = { 
    showNotification: (message, type, time, multiply = 1000) => {
      $.notify({
          icon: "notifications",
          message: message
      }, {
          z_index: 9999,
          type: type,
          timer: time * multiply,
          placement: {
              from: 'top',
              align: 'right'
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
    verificaNotificacao: () => {
      $.post(baseUrl + 'appajax/buscaNotificacoes', {Notificacoes: ''}, data => {
        if (data != null) {
          let title   = data.vNotTitle;
          let size    = (data.vNotSize == 'S') ? 'small' : 'large';
          let message = data.vNotMessage;
          bootbox.alert({ title, size, message });
        }
      });
    }, 
    initApp: () => {
      setInterval(function(){app.verificaNotificacao();}, 300000); 

      //Controla active li do menu.
      $('.sidebar-wrapper ul.nav li a.firstA').click(function() {
          $('.sidebar-wrapper ul.nav li').removeClass('active');
          $(this).parent().addClass('active');
      });

      app.matomoAnalytics()
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
    formataValorReal: (valor, casas, separdor_decimal, separador_milhar) => { 
     
     var valor_total = parseInt(valor * (Math.pow(10,casas)));
     var inteiros =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas)));
     var centavos = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas)));
         
     if(centavos%10 == 0 && centavos+"".length<2 ){
      centavos = centavos+"0";
     }else if(centavos<10){
      centavos = "0"+centavos;
     }
      
     var milhares = parseInt(inteiros/1000);
     inteiros = inteiros % 1000; 
     
     var retorno = "";
     
     if(milhares>0){
      retorno = milhares+""+separador_milhar+""+retorno
      if(inteiros == 0){
       inteiros = "000";
      } else if(inteiros < 10){
       inteiros = "00"+inteiros; 
      } else if(inteiros < 100){
       inteiros = "0"+inteiros; 
      }
     }
      retorno += inteiros+""+separdor_decimal+""+centavos;
      return retorno;
    },
    openModal: modal => {
      $('#' + modal).modal();
    },
    carregaCombo: (idCombo, tipoInfo, codToSelect = null, codToControl = null) => {
      $("#"+idCombo).empty();
      let urlBusca = (urlAtual == 'propostas') ? 'propostas/appajax/carregaDadosCombo' : 'appajax/carregaDadosCombo';
      $.post(baseUrl + urlBusca, {CarregaDadosCombo: '', tipoInfo, codToControl}, function(j){
          if(j != null){
            for (let i = 0; i < j.length; i++) {
                $("#"+idCombo).append($('<option>', {
                  'data-icon': j[i].vIconInfo != '' ? j[i].vIconInfo : '',
                  value: j[i].vIdInfo,
                  text: j[i].vNomeInfo, 
                  style: j[i].vCorInfo != '' ? 'border-bottom: 2px solid ' + j[i].vCorInfo  : '',
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
      let urlBusca = (urlAtual == 'propostas') ? 'propostas/appajax/carregaDadosCombo' : 'appajax/carregaDadosCombo';

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
          
          $("#"+idCombo)
            .selectpicker('refresh')
      }, "json");
    }
}



