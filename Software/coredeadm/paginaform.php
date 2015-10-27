<?php
/**
 * Arquivo: paginaform.php
 * Criado em: 26/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de ediçao e cadastro de páginas.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, 1, -1);

//inclui as classes
include_once './negocio/paginanegocio.class.php';
include_once './negocio/interfacenegocio.class.php';
include_once './negocio/idiomanegocio.class.php';

//cria os objetos
$paginaNegocio = new PaginaNegocio();
$interfaceNegocio = new InterfaceNegocio();
$idiomaNegocio = new IdiomaNegocio();

//se o formlario foi enviado
if(isset($_POST["titulo"]) && isset($_POST["conteudo"])){
    if(isset($_GET["editar"]) && isset($_GET["idioma"])){
        $paginaNegocio->alterarPagina($_GET["editar"], $_POST["titulo"], $_POST["conteudo"], $_POST["tags"], $_GET["idioma"]);
        //mensagem
        $interfaceNegocio->setMensagemDeAlerta("Página alterada com sucesso!");
    }
    else{
        $listaDePaginas = $paginaNegocio->consultarPagina("");
                
        $maiorID = 0;
        
        for ($i = 0; $i < count($listaDePaginas); $i++) {
            if($maiorID < $listaDePaginas[$i]->getId()){
                $maiorID = $listaDePaginas[$i]->getId();
            }
        }
        
        //proxima
        $maiorID++;
        
        $idioma = $idiomaNegocio->consultarIdioma("");
        for ($i = 0; $i < count($idioma); $i++) {
            $paginaNegocio->inserirPagina($maiorID, $_POST["titulo"], $_POST["conteudo"], $_POST["tags"], $idioma[$i]->getId());
        }
        //mensagem
        $interfaceNegocio->setMensagemDeAlerta("Página criada com sucesso!");
    }
}

//se for edição preenche a tabela
if(isset($_GET["editar"])){
    $id = $_GET["editar"];
    $idioma = $_GET["idioma"];
    if($paginaNegocio->verificaSeExiste($id, $idioma)){
        
        $paginaSendoEditada = $paginaNegocio->consultarUnicaPagina($id, $idioma);
        
        $nome = $paginaSendoEditada->getTitulo();
        $conteudo = $paginaSendoEditada->getConteudo();
        $tags = $paginaSendoEditada->getTags();
        $urlEdicao = "?editar=" . $id . "&idioma=" . $idioma;
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Página não encontrado!");
        $nome = "";
        $conteudo = "";
        $tags = "";
        $urlEdicao = "";
    }
}
else{
    //url da edicao
    $urlEdicao = "";
    $nome = "";
    $conteudo = "";
    $tags = "";
}

//define o titulo da página
$tituloPainel = "Página";

//inclui o header
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/pagina.js"></script>

<form class="formulario" action="paginaform.php<?php echo $urlEdicao;?>" method="post" name="formulario">
<table>
    <?php
    if(isset($_GET["editar"])){
        $idiomaAtual = $idiomaNegocio->consultarUnicaIdioma($idioma);
        echo 
        '<tr>
            <td>
                <div class="label">Idioma:</div>
            </td>
            <td>
                <input type="text" value="'.$idiomaAtual->getIdioma().'" disabled>
            </td>
        </tr>';
    }
    ?>
    <tr>
        <td>
            <div class="label">Título:</div>
        </td>
        <td>
            <input type="text" name="titulo" value="<?php echo $nome; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Conteúdo:</div>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <textarea id="editordetexto" name="conteudo" class="ckeditor"><?php echo $conteudo; ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Tags:</div>
        </td>
        <td>
            <input type="text" name="tags" value="<?php echo $tags; ?>">
        </td>
    </tr>
</table>
</form>

<?php
//seta o código dos botões
$interfaceNegocio->setFooterButtons('<input type="button" value="Salvar página" onclick="negocioPagina.verificarDados();"><a href="paginavisualizacao.php">Listar páginas</a>');

//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>