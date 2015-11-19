<?php
/**
 * Arquivo: index.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de login do sistema, contém a autenticação de
 *  usuários.
 * 
 */

include_once 'ui/seguranca.interface.php';

//inclui as classes
include_once './negocio/usuarionegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';

//cria os objetos
$usuarioNegocio = new UsuarioNegocio();
$configuracaoNegocio = new ConfiguracaoNegocio();

$mensagem = "";

//se o form for enviado
if(isset($_POST["nome"]) && isset($_POST["senha"])){
    //verifica se pode ou não prosseguir
    if($usuarioNegocio->login($_POST["nome"], $_POST["senha"])){
        //direciona para o painel
        header("LOCATION: index.php");
    }
    else{
        //mensagem de erro de login
        $mensagem = "<script>alert('Os dados do usuário não conferem!');</script>";
    }
}

//pula o login se o mesmo já estiver logado
if($usuarioNegocio->verificaSeHaUsuarioLogado()){
    //direciona para o painel
    header("LOCATION: index.php");
}

include_once 'ui/header.ui.php';

?>

<div class="corede-atas">
    <form action="login.php" method="post">
        <input name="nome" type="text" placeholder="login">
        <input name="senha" type="password" placeholder="senha">
        <input type="submit" value="entrar">
    </form>
</div>

<?php
echo $mensagem;
include_once 'ui/footer.ui.php';
?>