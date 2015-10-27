/**
 * Arquivo: patrocinador.js
 * Criado em: 24/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções javascript de interação com patrocinadores,
 *  referentes ao objeto banner.
 *
 */

function negocioNoticia(){
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
        if(formulario.data.value === ""){
            return alert("Precisamos de uma data.");
        }
        if(formulario.alterarImagem){
            if(formulario.alterarImagem.checked){
                if(formulario.imagem.value === ""){
                    return alert("Selecione uma imagem ou desmarque a caixa acima.");
                }
                else{
                    return enviaFormulario();
                }
            }
            return enviaFormulario();
        }
        else{
            return enviaFormulario();
        }
    };
    
    this.habilitaSelecaoArquivo = function(){
        formulario = document.formulario;
        
        if(formulario.alterarImagem.checked){
            formulario.imagem.type = "file";
        }
        else{
            formulario.imagem.type = "text";
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
negocioNoticia = new negocioNoticia();