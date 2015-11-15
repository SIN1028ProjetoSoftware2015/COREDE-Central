<?php
/**
 * Arquivo: paginavisualizacao.php
 * Criado em: 26/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de visualização da tabela de páginas do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, -1, 1);

//inclui as classes
include_once './negocio/paginanegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';
include_once './negocio/interfacenegocio.class.php';
include_once './negocio/idiomanegocio.class.php';

//cria os objetos
$configuracaoNegocio = new ConfiguracaoNegocio();
$paginaNegocio = new PaginaNegocio();
$interfaceNegocio = new InterfaceNegocio();
$idiomaNegocio = new IdiomaNegocio();

//se a ação for excluir
if(isset($_GET["excluir"])){
    $paginaNegocio->deletarPagina($_GET["excluir"]);
    $interfaceNegocio->setMensagemDeAlerta("Página deletada com sucesso!");
}

//obtem a lista de páginas
if(isset($_POST["busca"])){
    $lista = $paginaNegocio->consultarPagina($_POST["busca"]);
}
else{
    $lista = $paginaNegocio->listarPaginas($interfaceNegocio->getNumeroPaginaAtual(), $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"));
}

$linhasDaTabela = "";

$idiomas = $idiomaNegocio->consultarIdioma("");

for($i = 0; $i < sizeof($lista); $i++){
    
    $idiomaAtual = "não identificado";
    
    for ($x = 0; $x < count($idiomas); $x++) {
        if($idiomas[$x]->getId() == $lista[$i]->getIdioma()){
            $idiomaAtual = $idiomas[$x]->getIdioma();
        }
    }
    
    $linhasDaTabela = $linhasDaTabela . '
        <tr>
            <td>'.
              $lista[$i]->getId()  
            .'</td>
            <td><a href="paginaform.php?editar=' . $lista[$i]->getId() . '&idioma=' . $lista[$i]->getIdioma() . '" title="Editar">'.
                $lista[$i]->getTitulo()
            .'</a></td>
            <td>
                <label>
                    <a href="paginaform.php?editar=' . $lista[$i]->getId() . '&idioma=' . $lista[$i]->getIdioma() . '" title="Editar"><div class="editar"></div></a>
                    <a href="#" title="Excluir"><div onclick="negocioPagina.excluir(\''.$lista[$i]->getId().'\');" class="excluir"></div></a>
                </label>
            </td>
        </tr>  
    ';
}

//define o titulo da página
$tituloPainel = "Páginas";

//inclui o header
include_once './ui/header.interface.php';

?>
<script type="text/javascript" src="js/pagina.js"></script>
<form class="campodebusca" action="paginavisualizacao.php" method="post">
    <input type="text" name="busca" class="campodetexto">
    <input type="submit" value="buscar" class="btn">
</form>
<table id="tabela" class="tabelaDeVisualizacao">
    <tr>
        <th style="width: 10%">Código</th>
        <th style="width: 75%">Título</th>
        <th style="width: 15%">Ações</th>
    </tr>
    <?php echo $linhasDaTabela;?>
</table>
<?php
//inclui a barra de navegação
$interfaceNegocio->getBarraDePaginacao($configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"), $paginaNegocio->getNumTotalDeRegistros(), "paginavisualizacao.php");
//inclui os botoes
$interfaceNegocio->setFooterButtons('<a href="paginaform.php">Criar uma nova página</a>');
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
