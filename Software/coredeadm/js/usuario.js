/**
 * Arquivo: usuario.js
 * Criado em: 19/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções javascript de interação com usuário,
 *  referentes ao objeto usuário.
 *
 */

//cria os objetos das classes para serem utilizados em suas respectivas páginas

function negocioLogin(){
    //envia o form
    function enviaFormulario(){
        document.formulario.submit();
    }
    //está função e responsável por verificar os dados
    this.verificarDados = function(){
        formulario = document.formulario;
        
        if(formulario.nome.value === ""){
            return alert("Preencha o campo login.");
        }
        if(formulario.senha.value === ""){
            return alert("Você esqueceu da senha.");
        }
        else{
            return enviaFormulario();
        }
    };
    //funções responsáveis por ações no campo senha
    this.visibilidadeDaSenha = function(){
        if(formulario.senha.type === "text"){
            formulario.senha.type = "password";
        }
        else{
            formulario.senha.type = "text";
        }
    };
}

function negocioCadastro(){
    //envia o form
    function enviaFormulario(){
        //mostra a div carregando
        document.getElementById("carregando").style.display = "block";
        document.formulario.submit();
    }
    //está função e responsável por verificar os dados do form
    this.verificarDados = function(){
        formulario = document.formulario;
        
        if(formulario.nome.value === ""){
            return alert("Preencha o campo Nome.");
        }
        if(formulario.senha.value === ""){
            return alert("Você esqueceu da Senha.");
        }
        if(formulario.senhaconfirmada.value === ""){
            return alert("Você esqueceu de confirmar a sua Senha.");
        }
        if(formulario.senha.value !== formulario.senhaconfirmada.value){
            return alert("As senhas não combinam!");
        }
        if(formulario.email.value === ""){
            return alert("O email é obrigatório.");
        }
        if(formulario.telefone.value === ""){
            return alert("Precisamos de um número de telefone.");
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
negocioLogin = new negocioLogin();
negocioCadastro = new negocioCadastro();