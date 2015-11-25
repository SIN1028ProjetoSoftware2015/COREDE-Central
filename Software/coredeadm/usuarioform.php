<?php
/**
 * Arquivo: usuarioform.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de ediçao e cadastro de usuários.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, 2, -1);

//inclui as classes
include_once './negocio/usuarionegocio.class.php';
include_once './config/sistema.class.php';
include_once './negocio/interfacenegocio.class.php';

//cria os objetos
$usuarioNegocio = new UsuarioNegocio();
$sistema = new Sistema();
$interfaceNegocio = new InterfaceNegocio();

//se o formlario foi enviado
if(isset($_POST["nome"]) && isset($_POST["senha"]) && isset($_POST["tipo"]) && isset($_POST["email"]) && isset($_POST["telefone"])){
    if(isset($_GET["editar"])){
        $usuarioNegocio->alterarUsuario($_GET["editar"], $_POST["nome"], $_POST["senha"], $_POST["tipo"], $_POST["email"], $_POST["telefone"]);
        //mensagem
        $interfaceNegocio->setMensagemDeAlerta("Usuário alterado com sucesso!");
    }
    else{
        $usuarioNegocio->inserirUsuario($_POST["nome"], $_POST["senha"], $_POST["tipo"], $_POST["email"], $_POST["telefone"]);
        //mensagem
        $interfaceNegocio->setMensagemDeAlerta("Usuário salvo com sucesso!");
    }
}

//se for edição preenche a tabela
if(isset($_GET["editar"])){
    $id = $_GET["editar"];
    if($usuarioNegocio->verificaSeExiste($id)){
        //obtem dados do usuario a ser editado
        $usuarioSendoEditado = $usuarioNegocio->consultarUnicoUsuario($id);
        
        //editando super user
        if($usuarioSendoEditado->getTipo() == 0){
            //editado por super user
            if($usuarioLogado->getTipo() == 0){
                //nome
                $nome = $usuarioSendoEditado->getNome();
                //senha
                $senha = $usuarioSendoEditado->getSenha();
                //marcar caixas de tipo
                $superUser = TRUE;
                $administrador = FALSE;
                $operador = FALSE;
                //email
                $email = $usuarioSendoEditado->getEmail();
                //telefone
                $telefone = $usuarioSendoEditado->getTelefone();

                $urlEdicao = "?editar=" . $id;
            }
            //editado por adiministrador
            if($usuarioLogado->getTipo() == 1){
                $interfaceNegocio->setLocation($sistema->getPaginaDePermissaoNegada());
            }
            //editado por operador
            if($usuarioLogado->getTipo() == 2){
                $interfaceNegocio->setLocation($sistema->getPaginaDePermissaoNegada());
            }
        }
        //ediando adiministrador
        if($usuarioSendoEditado->getTipo() == 1){
            //editado por super user
            if($usuarioLogado->getTipo() == 0){
                //nome
                $nome = $usuarioSendoEditado->getNome();
                //senha
                $senha = $usuarioSendoEditado->getSenha();
                //marcar caixas de tipo
                $superUser = FALSE;
                $administrador = TRUE;
                $operador = FALSE;
                //email
                $email = $usuarioSendoEditado->getEmail();
                //telefone
                $telefone = $usuarioSendoEditado->getTelefone();

                $urlEdicao = "?editar=" . $id;
            }
            //editado por adiministrador
            if($usuarioLogado->getTipo() == 1){
                if($usuarioSendoEditado->getId() == $usuarioNegocio->getIdUsuarioLogado()){
                    //nome
                    $nome = $usuarioSendoEditado->getNome();
                    //senha
                    $senha = $usuarioSendoEditado->getSenha();
                    //marcar caixas de tipo
                    $superUser = FALSE;
                    $administrador = TRUE;
                    $operador = FALSE;
                    //email
                    $email = $usuarioSendoEditado->getEmail();
                    //telefone
                    $telefone = $usuarioSendoEditado->getTelefone();

                    $urlEdicao = "?editar=" . $id;
                }
                else{
                    $interfaceNegocio->setLocation($sistema->getPaginaDePermissaoNegada());
                }
            }
            //editado por operador
            if($usuarioLogado->getTipo() == 2){
                $interfaceNegocio->setLocation($sistema->getPaginaDePermissaoNegada());
            }
        }
        //editando operador
        if($usuarioSendoEditado->getTipo() == 2){
            //editado por super user
            if($usuarioLogado->getTipo() == 0){
                //nome
                $nome = $usuarioSendoEditado->getNome();
                //senha
                $senha = $usuarioSendoEditado->getSenha();
                //marcar caixas de tipo
                $superUser = FALSE;
                $administrador = FALSE;
                $operador = TRUE;
                //email
                $email = $usuarioSendoEditado->getEmail();
                //telefone
                $telefone = $usuarioSendoEditado->getTelefone();

                $urlEdicao = "?editar=" . $id;
            }
            //editado por adiministrador
            if($usuarioLogado->getTipo() == 1){
                //nome
                $nome = $usuarioSendoEditado->getNome();
                //senha
                $senha = $usuarioSendoEditado->getSenha();
                //marcar caixas de tipo
                $superUser = FALSE;
                $administrador = FALSE;
                $operador = TRUE;
                //email
                $email = $usuarioSendoEditado->getEmail();
                //telefone
                $telefone = $usuarioSendoEditado->getTelefone();

                $urlEdicao = "?editar=" . $id;
            }
            //editado por operador
            if($usuarioLogado->getTipo() == 2){
                if($usuarioSendoEditado->getId() == $usuarioNegocio->getIdUsuarioLogado()){
                    //nome
                    $nome = $usuarioSendoEditado->getNome();
                    //senha
                    $senha = $usuarioSendoEditado->getSenha();
                    //marcar caixas de tipo
                    $superUser = FALSE;
                    $administrador = FALSE;
                    $operador = TRUE;
                    //email
                    $email = $usuarioSendoEditado->getEmail();
                    //telefone
                    $telefone = $usuarioSendoEditado->getTelefone();

                    $urlEdicao = "?editar=" . $id;
                }
                else {
                    $interfaceNegocio->setLocation($sistema->getPaginaDePermissaoNegada());
                }
            }            
        }
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Usuário não encontrado!");
        //nome
        $nome = "";
        //senha
        $senha = "";
        //marcar caixas de tipo
        $superUser = FALSE;
        $administrador = FALSE;
        $operador = TRUE;
        //email
        $email = "";
        //telefone
        $telefone = "";
        
        $urlEdicao = "";
    }
}
else{
    //url da edicao
    $urlEdicao = "";
    //nome
    $nome = "";
    //senha
    $senha = "";
    //marcar caixas de tipo
    $superUser = FALSE;
    $administrador = FALSE;
    $operador = TRUE;
    //email
    $email = "";
    //telefone
    $telefone = "";
}

//menu de tipos
$menuSeletorTipo = "";

if(isset($_GET["editar"])){
    if($usuarioLogado->getTipo() == 0){
        if($superUser == TRUE){
            $menuSeletorTipo = 
                    '<label><input type="radio" name="tipo" value="0" checked> Super Usuário</label>' .
                    '<label><input type="radio" name="tipo" value="1"> Administrador</label>' .
                    '<label><input type="radio" name="tipo" value="2"> Membro</label>';
        }
        if($administrador == TRUE){
            $menuSeletorTipo = 
                    '<label><input type="radio" name="tipo" value="0"> Super Usuário</label>' .
                    '<label><input type="radio" name="tipo" value="1" checked> Administrador</label>' .
                    '<label><input type="radio" name="tipo" value="2"> Membro</label>';
        }
        if($operador == TRUE){
            $menuSeletorTipo = 
                    '<label><input type="radio" name="tipo" value="0"> Super Usuário</label>' .
                    '<label><input type="radio" name="tipo" value="1"> Administrador</label>' .
                    '<label><input type="radio" name="tipo" value="2" checked> Membro</label>';
        }
    }
    if($usuarioLogado->getTipo() == 1){
        if($administrador == TRUE){
            $menuSeletorTipo = 
                    '<label><input type="radio" name="tipo" value="1" checked> Administrador</label>' .
                    '<label><input type="radio" name="tipo" value="2"> Membro</label>';
        }
        if($operador == TRUE){
            $menuSeletorTipo = 
                    '<label><input type="radio" name="tipo" value="1"> Administrador</label>' .
                    '<label><input type="radio" name="tipo" value="2" checked> Membro</label>';
        }
    }
    if($usuarioLogado->getTipo() == 2){
        if($operador == TRUE){
            $menuSeletorTipo = 
                    '<label><input type="radio" name="tipo" value="2" checked> Membro</label>';
        }
    }
}
else{
    if($usuarioLogado->getTipo() == 0){
        $menuSeletorTipo = 
                '<label><input type="radio" name="tipo" value="0"> Super Usuário</label>' .
                '<label><input type="radio" name="tipo" value="1"> Administrador</label>' .
                '<label><input type="radio" name="tipo" value="2" checked> Membro</label>';
    }
    if($usuarioLogado->getTipo() == 1){
        $menuSeletorTipo = 
                '<label><input type="radio" name="tipo" value="1"> Administrador</label>' .
                '<label><input type="radio" name="tipo" value="2" checked> Membro</label>';
    }   
}

//define o titulo da página
$tituloPainel = "Usuário";

//inclui o header
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/usuario.js"></script>

<form class="formulario" action="usuarioform.php<?php echo $urlEdicao;?>" method="post" name="formulario">
<table>
    <tr>
        <td>
            <div class="label">Nome:</div>
        </td>
        <td>
            <input type="text" name="nome" value="<?php echo $nome; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Senha:</div>
        </td>
        <td>
            <input type="password" name="senha" value="<?php echo $senha; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Confirme a senha:</div>
        </td>
        <td>
            <input type="password" name="senhaconfirmada" value="">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Tipo:</div>
        </td>
        <td>
            <?php echo $menuSeletorTipo; ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Email:</div>
        </td>
        <td>
            <input type="text" name="email" value="<?php echo $email; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Telefone:</div>
        </td>
        <td>
            <input type="text" name="telefone" value="<?php echo $telefone; ?>">
        </td>
    </tr>
</table>
</form>

<?php
//seta o código dos botões
$interfaceNegocio->setFooterButtons('<input type="button" value="Salvar usuário" onclick="negocioCadastro.verificarDados();"><a href="usuariovisualizacao.php">Listar usuários</a>');

//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>