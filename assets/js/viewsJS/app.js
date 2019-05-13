urlAtual = window.location.pathname.split('/')[2];
app = {
    initApp: () => {
      $('.selectpicker').selectpicker();
      
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
          
          $("#"+idCombo)
            .selectpicker('refresh')
      }, "json");
    }
}



