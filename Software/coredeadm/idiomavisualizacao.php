<?php
/**
 * Arquivo: idiomavisualizacao.php
 * Criado em: 23/09/2015
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de visualização da tabela de idiomas do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, -1, 1);

//inclui as classes
include_once './negocio/configuracaonegocio.class.php';
include_once './negocio/interfacenegocio.class.php';
include_once './negocio/idiomanegocio.class.php';

//cria os objetos
$configuracaoNegocio = new ConfiguracaoNegocio();
$interfaceNegocio = new InterfaceNegocio();
$idiomaNegocio = new IdiomaNegocio();

//se a ação for excluir
if(isset($_GET["excluir"])){
    $idiomaNegocio->deletarIdioma($_GET["excluir"]);
    $interfaceNegocio->setMensagemDeAlerta("Idioma deletada com sucesso!");
}

//obtem a lista de páginas
if(isset($_POST["busca"])){
    $lista = $idiomaNegocio->consultarIdioma($_POST["busca"]);
}
else{
    $lista = $idiomaNegocio->listarIdiomas($interfaceNegocio->getNumeroPaginaAtual(), $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"));
}

$linhasDaTabela = "";

for($i = 0; $i < sizeof($lista); $i++){
    
    $linhasDaTabela = $linhasDaTabela . '
        <tr>
            <td>'.
              $lista[$i]->getId()  
            .'</td>
            <td><a href="idiomaform.php?editar=' . $lista[$i]->getId() . '" title="Editar">'.
                $lista[$i]->getIdioma()
            .'</a></td>
            <td>
                <label>
                    <a href="idiomaform.php?editar=' . $lista[$i]->getId() . '" title="Editar"><div class="editar"></div></a>
                    <a href="#" title="Excluir"><div onclick="negocioIdioma.excluir(\''.$lista[$i]->getId().'\');" class="excluir"></div></a>
                </label>
            </td>
        </tr>  
    ';
}

//define o titulo da página
$tituloPainel = "Idiomas";

//inclui o header
include_once './ui/header.interface.php';

?>
<script type="text/javascript" src="js/idioma.js"></script>
<form class="campodebusca" action="idiomavisualizacao.php" method="post">
    <input type="text" name="busca" class="campodetexto">
    <input type="submit" value="buscar" class="btn">
</form>
<table id="tabela" class="tabelaDeVisualizacao">
    <tr>
        <th style="width: 10%">Código</th>
        <th style="width: 75%">Idioma</th>
        <th style="width: 15%">Ações</th>
    </tr>
    <?php echo $linhasDaTabela;?>
</table>
<?php
//inclui a barra de navegação
$interfaceNegocio->getBarraDePaginacao($configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"), $idiomaNegocio->getNumTotalDeRegistros(), "idiomavisualizacao.php");
//inclui os botoes
$interfaceNegocio->setFooterButtons('<a href="idiomaform.php">Criar uma novo idioma</a>');
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
