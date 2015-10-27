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

//inclui as classes
include_once './negocio/usuarionegocio.class.php';
include_once './config/sistema.class.php';
include_once './negocio/configuracaonegocio.class.php';

//cria os objetos
$usuarioNegocio = new UsuarioNegocio();
$sistema = new Sistema();
$configuracaoNegocio = new ConfiguracaoNegocio();

//inicia sessão
$usuarioNegocio->iniciarSessao();

//se o form for enviado
if(isset($_POST["nome"]) && isset($_POST["senha"])){
    //verifica se pode ou não prosseguir
    if($usuarioNegocio->login($_POST["nome"], $_POST["senha"])){
        //direciona para o painel
        header("LOCATION: " . $sistema->getPaginaInicial());
    }
    else{
        //mensagem de erro de login
        $mensagem = "<script>alert('Os dados do usuário não conferem!');</script>";
    }
}

//pula o login se o mesmo já estiver logado
if($usuarioNegocio->verificaSeHaUsuarioLogado()){
    header("LOCATION: " . $sistema->getPaginaInicial());
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo "Login > " . $configuracaoNegocio->carregarValorDaConfiguracao("tituloDoSite"); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style/teladelogin.css">
        <link href='style/img/favicon.png' rel='icon' type='image/x-icon'/>
        <script type="text/javascript" src="js/usuario.js"></script>
    </head>
    <body>
        <div id="header">
            <div id="titulo">login</div>
            <div id="btn"><a href="../" title="Voltar">voltar para o site</a></div>
        </div>
        <div id="conteudo">
            <form action="index.php" method="post" name="formulario">
                <table>
                    <tr>
                        <td class="lable">login</td>
                        <td><input class="campodetexto" type="text" name="nome" value=""></td>
                    </tr>
                    <tr>
                        <td class="lable">senha</td>
                        <td><input class="campodetexto" type="password" name="senha" value=""></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="visibilidadeDaSenha"><input type="checkbox" name="visibilidadeDaSenha" onclick="negocioLogin.visibilidadeDaSenha()"/> ocultar/mostrar a senha.</label><input type="button" class="btn" value="entrar" onclick="negocioLogin.verificarDados()"/></td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="footer">
        </div>
        <?php 
        if(isset($mensagem)){
            echo $mensagem;
        }
        ?>
    </body>
</html>