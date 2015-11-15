/**
 * Arquivo: arquivos.js
 * Criado em: 13/06/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções javascript do gerenciador de arquivos.
 *
 */

function negocioArquivos(){
    
    this.enviarArquivos = function(){
        //mostra a div carregando
        document.getElementById("carregando").style.display = "block";
        document.enviarArquivos.submit();
    };
    
    this.criarPasta = function(){
        //mostra a div carregando
        document.getElementById("carregando").style.display = "block";
        document.criarPasta.submit();
    };
    
    this.confirmacaoDeExclusao = function(link){
        if (confirm("Tem certeza que deseja excluir?")) {  
            //mostra a div carregando
            document.getElementById("carregando").style.display = "block";
            location.href=link;  
        }   
    };
}

//cria os objetos das classes para serem utilizados em suas respectivas páginas
negocioArquivos = new negocioArquivos();

