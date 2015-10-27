/**
 * Arquivo: backup.js
 * Criado em: 09/09/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções javascript relacionadas a backup.
 *
 */

function negocioBackup(){
    
    function enviarFormulario(){
        //mostra a div carregando
        document.getElementById("carregando").style.display = "block";
        document.formulario.submit();
    }
    
    this.verificarDados = function(){
        if(confirm("Deseja restaurar o backup selecionado?")){
           return enviarFormulario();
        }
    };
    
    this.alterarBackup = function(){
        if(document.getElementById("Off").checked == true){
            document.formulario.backupOff.style.display = "block";
            document.formulario.backupOn.style.display = "none";
        }
        else{
            document.formulario.backupOff.style.display = "none";
            document.formulario.backupOn.style.display = "block";
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
negocioBackup = new negocioBackup();

