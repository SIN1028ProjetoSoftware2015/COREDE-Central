/**
 * Arquivo: pagina.js
 * Criado em: 25/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções javascript de interação com paginas,
 *  referentes ao objeto pagina.
 *
 */

function negocioPagina(){
    //envia o form
    function enviaFormulario(){
        //mostra a div carregando
        document.getElementById("carregando").style.display = "block";
        document.formulario.submit();
    }
    //está função e responsável por verificar os dados
    this.verificarDados = function(){
        formulario = document.formulario;
        
        if(formulario.titulo.value === ""){
            return alert("Precisamos de um título.");
        }
        else{
            return enviaFormulario();
        }
    };
    this.excluir = function(id){
        if (confirm("Tem certeza que deseja excluir?")) {  
            //mostra a div carregando
            document.getElementById("carregando").style.display = "block";
            location.href="?excluir=" + id;  
        }   
    };
}

//cria os objetos das classes para serem utilizados em suas respectivas páginas
negocioPagina = new negocioPagina();