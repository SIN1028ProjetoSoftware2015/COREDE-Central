/**
 * Arquivo: usuario.js
 * Criado em: 24/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Contém as funções javascript que serão executadas em qualquer parte do
 *  sistema.
 *
 */
window.onload = function () {
    ocultarCarregando();
    zebrarTabela("tabela");
};

function ocultarCarregando() {
    document.getElementById("carregando").style.display = "none";
}

function zebrarTabela(id) {
    var linhasTabela = document.getElementById(id).getElementsByTagName("tr");

    for (var i = 0; i < linhasTabela.length; i++) {
        if (i % 2 === 0) {
            linhasTabela[i].style.background = "#ddd";
        }
        else {
            linhasTabela[i].style.background = "#eee";
        }
    }
}

//vsualizador de imagens do sistema
function VisualizadorDeImagens() {
    this.abrir = function (linkImagem) {
        document.getElementById("visualizadorDeImagens").style.display = "block";
        document.getElementById("visualizadorDeImagens").getElementsByTagName("img")[0].src = linkImagem;
    };
    this.fechar = function () {
        document.getElementById("visualizadorDeImagens").style.display = "none";
        document.getElementById("visualizadorDeImagens").getElementsByTagName("img")[0].src = "";
    };
}
visualizadorDeImagens = new VisualizadorDeImagens();

//pop up do usuario logado
function popUpUsuario() {
    this.abrir = function () {
        document.getElementById("popUpUsuario").style.display = "block";
    };
    this.fechar = function () {
        document.getElementById("popUpUsuario").style.display = "none";
    };
}
popUpUsuario = new popUpUsuario();

//mensagem do sistema
function popUpMensagem() {
    this.abrir = function () {
        document.getElementById("popUpMensagem").style.display = "block";
    };
    this.fechar = function () {
        document.getElementById("popUpMensagem").style.display = "none";
    };
}
popUpMensagem = new popUpMensagem();


//está função cria uma janela na tela do sistema
function Janela() {
    this.abrir = function (id, altura, largura) {
        document.getElementById(id).style.display = "block";
        document.getElementById(id).style.height = altura + "px";
        document.getElementById(id).style.width = largura + "px";
        //alinha a janela ao centro
        x = parseInt((screen.width - largura) / 2);
        y = parseInt((screen.height - altura) / 3);
        document.getElementById(id).style.top = y + "px";
        document.getElementById(id).style.left = x + "px";
        //conserta bug ao alternar entre botoes
        zIndex = parseInt(document.getElementById(id).style.zIndex + 1);
        document.getElementById(id).style.zIndex = "" + zIndex;
    };
    this.fechar = function (id) {
        document.getElementById(id).style.display = "none";
    };
    this.enviaFormUpload = function (formulario){
        document.getElementById("carregando").style.display = "block";
        document.formulario.submit();
    };
}
Janela = new Janela();

//esta classe possui métodos para a formatação de campos de texto
function Formatacao() {
    this.formatarCampoDeMoeda = function (el) {
        var ex = /^[0-9]+\.?[0-9]*$/;
        if (ex.test(el.value) == false) {
            el.value = el.value.substring(0, el.value.length - 1);
        }
    };
    this.mascaraDeData = function (inputData, e) {
        if (document.all) // Internet Explorer
            var tecla = event.keyCode;
        else //Outros Browsers
            var tecla = e.which;

        if (tecla >= 47 && tecla < 58) { // numeros de 0 a 9 e "/"
            var data = inputData.value;
            if (data.length == 2 || data.length == 5) {
                data += '/';
                inputData.value = data;
            }
        } else if (tecla == 8 || tecla == 0) // Backspace, Delete e setas direcionais(para mover o cursor, apenas para FF)
            return true;
        else
            return false;
    };
    this.mascaraDeTelefone = function(t, e) {
        if (document.all) // Internet Explorer
            var tecla = event.keyCode;
        else //Outros Browsers
            var tecla = e.which;
        if(tecla != 8){
            mask = "## ####-####";
            var i = t.value.length;
            var saida = mask.substring(1,0);
            var texto = mask.substring(i)
            if (texto.substring(0,1) != saida){
                t.value += texto.substring(0,1);
            }
        }
    };
    this.mascaraDeNumero = function (campo){
        //Remove tudo o que não é dígito
        campo.value = campo.value.replace(/\D/g,"");
    };
}
formatacao = new Formatacao();

//editor de texto
tinymce.init({
    language: "pt_BR",
    selector: "textarea#editordetexto",
    theme: "modern",
    width: 700,
    height: 300,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor jbimages"
    ],
    content_css: "css/content.css",
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages | print preview media fullpage | forecolor backcolor emoticons",
    style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ],
    relative_urls: false
});