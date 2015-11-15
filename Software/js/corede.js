/*
 @autor Maik Basso
 @email maik@maikbasso.com.br
 @telefone (55) 9952-9459
 */

/*  Slide
------------------------------------------------------------------------------*/
jQuery(document).ready(function($) {
    $('#w2bNivoSlider').nivoSlider({
    effect           : 'random',
    slices           : 10,
    boxCols          : 8,
    boxRows          : 4,
    animSpeed        : 500,
    pauseTime        : 4000,
    startSlide       : 0,
    directionNav     : false,
    directionNavHide : false,
    controlNav       : true,
    keyboardNav      : false,
    pauseOnHover     : false,
    captionOpacity   : 0.8
    });
});

function Contato() {
    function enviaFormulario() {
        document.formularioContato.submit();
    }
    function validarEmail() {
        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (filter.test(document.formularioContato.email.value)) {
            return true;
        }
        else {
            return false;
        }
    }
    this.enviar = function () {
        formulario = document.formularioContato;
        if (formulario.nome.value == "") {
            return alert("Preencha o campo nome!");
        }
        if (formulario.email.value == "") {
            return alert("Preencha o campo e-mail!");
        }
        else {
            if (validarEmail()) {
                if (formulario.mensagem.value == "") {
                    return alert("Preencha o campo mensagem!");
                }
                else {
                    return enviaFormulario();
                }
            }
            else {
                return alert("E-mail inválido!");
            }
        }
    };
}
contato = new Contato();

window.onload = function (){
  var linhasTabelas = document.getElementsByTagName("tr");
  for(var i=0; i< linhasTabelas.length; i++){
      if(i%2 !== 0){
        linhasTabelas[i].style.background = "#000";
      }
  }
};