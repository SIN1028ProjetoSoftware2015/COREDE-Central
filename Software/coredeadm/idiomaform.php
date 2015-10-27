<?php
/**
 * Arquivo: idiomaform.php
 * Criado em: 22/09/2015
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de ediçao e cadastro de idiomas.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, 1, -1);

//inclui as classes
include_once './negocio/interfacenegocio.class.php';
include_once './negocio/idiomanegocio.class.php';

//cria os objetos
$interfaceNegocio = new InterfaceNegocio();
$idiomaNegocio = new IdiomaNegocio();

//se o formlario foi enviado
if(isset($_POST["idioma"])){
    if(isset($_GET["editar"])){
        $idiomaNegocio->alterarIdioma($_GET["editar"], $_POST["idioma"]);
        //mensagem
        $interfaceNegocio->setMensagemDeAlerta("Idioma alterada com sucesso!");
    }
    else{
        $idiomaNegocio->inserirIdioma($_POST["idioma"]);
        //mensagem
        $interfaceNegocio->setMensagemDeAlerta("Idioma criada com sucesso!");
    }
}

//se for edição preenche a tabela
if(isset($_GET["editar"])){
    $id = $_GET["editar"];
    if($idiomaNegocio->verificaSeExiste($id)){
        
        $SendoEditada = $idiomaNegocio->consultarUnicaIdioma($id);
        
        $idioma = $SendoEditada->getIdioma();
        $urlEdicao = "?editar=" . $id;
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Idioma não encontrado!");
        $idioma = "";
        $urlEdicao = "";
    }
}
else{
    //url da edicao
    $urlEdicao = "";
    $idioma = "";
}

//define o titulo da página
$tituloPainel = "Idioma";

//inclui o header
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/idioma.js"></script>

<form class="formulario" action="idiomaform.php<?php echo $urlEdicao;?>" method="post" name="formulario">
<table>
    <tr>
        <td>
            <div class="label">Idioma:</div>
        </td>
        <td>
            <input type="text" name="idioma" value="<?php echo $idioma; ?>">
        </td>
    </tr>
</table>
</form>

<?php
//seta o código dos botões
$interfaceNegocio->setFooterButtons('<input type="button" value="Salvar idioma" onclick="negocioIdioma.verificarDados();"><a href="idiomavisualizacao.php">Listar idiomas</a>');

//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>