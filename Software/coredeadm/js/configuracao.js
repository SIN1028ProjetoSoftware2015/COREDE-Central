/**
 * Arquivo: configuracao.js
 * Criado em: 19/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções javascript de interação com usuário,
 *  referentes a interface de configuração.
 *
 */

function negocioConfiguracao(){
    //envia o form
    function enviaFormulario(){
        //mostra a div carregando
        document.getElementById("carregando").style.display = "block";
        document.formulario.submit();
    }
    //está função e responsável por verificar os dados
    this.verificarDados = function(){
        formulario = document.formulario;
        
        if(formulario.tituloSite.value === ""){
            return alert("Entre com um nome para o site.");
        }
        if(formulario.descricaoSite.value === ""){
            return alert("Preencha a descrição do site.");
        }
        else{
            return enviaFormulario();
        }
    };
    
    this.restaurar = function(){
        if (confirm("Tem certeza que deseja restaurar as configurções padrões?")) {  
            //mostra a div carregando
            document.getElementById("carregando").style.display = "block";
            location.href="?restaurar=true";  
        }   
    };
}

//cria os objetos das classes para serem utilizados em suas respectivas páginas
negocioConfiguracao = new negocioConfiguracao();