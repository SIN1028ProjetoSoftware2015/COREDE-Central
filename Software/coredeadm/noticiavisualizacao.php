<?php
/**
 * Arquivo: noticiavisualizacao.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de visualização da tabela de noticias do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(2, -1, 2);

//classes
include_once './negocio/noticianegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';
include_once './negocio/arquivonegocio.class.php';
include_once './config/sistema.class.php';
include_once './negocio/interfacenegocio.class.php';
include_once './negocio/idiomanegocio.class.php';

//cria os objetos
$configuracaoNegocio = new ConfiguracaoNegocio();
$noticiaNegocio = new NoticiaNegocio();
$arquivoNegocio = new ArquivoNegocio();
$Sistema = new Sistema();
$interfaceNegocio = new InterfaceNegocio();
$idiomaNegocio = new IdiomaNegocio();

//lista de idiomas
$listaDeIdiomas = $idiomaNegocio->consultarIdioma("");

//se a ação for excluir
if(isset($_GET["excluir"])){
    
    for ($i = 0; $i < count($listaDeIdiomas); $i++) {        
        $aux = $noticiaNegocio->consultarUnicaNoticia($_GET["excluir"], $listaDeIdiomas[$i].getId());

        $arquivoNegocio->deletar($Sistema->getDirImagens().$aux->getLinkFoto());
    }

    $noticiaNegocio->deletarNoticia($_GET["excluir"]);
    $interfaceNegocio->setMensagemDeAlerta("Notícia deletada com sucesso!");

}

//obtem a lista
if(isset($_POST["busca"])){
    $lista = $noticiaNegocio->consultarNoticia($_POST["busca"]);
}
else{
    $lista = $noticiaNegocio->listarNoticia($interfaceNegocio->getNumeroPaginaAtual(), $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"));
}

$linhasDaTabela = "";

for($i = 0; $i < sizeof($lista); $i++){
    if($lista[$i]->getPublicar() == 1){
        $statusNoticia = "Sim";
    }
    else{
        $statusNoticia = "Não";
    }
    
    $idiomaAtual = "";
    
    for ($x = 0; $x < count($listaDeIdiomas); $x++) {
        if($listaDeIdiomas[$x]->getId() == $lista[$i]->getIdioma()){
           $idiomaAtual = $listaDeIdiomas[$x]->getIdioma(); 
        }
    }
    
    $linhasDaTabela = $linhasDaTabela . '
        <tr>
            <td>'.
              $lista[$i]->getId()  
            .'</td>
            <td><a href="noticiaform.php?editar=' . $lista[$i]->getId() . '&idioma=' . $lista[$i]->getIdioma() . '" title="Editar">'.
                $lista[$i]->getTitulo()
            .'</a></td>
            <td>'.
                $idiomaAtual
            .'</td>
            <td>'.
                $lista[$i]->getDataNoticia()
            .'</td>
            <td>'.
                $statusNoticia
            .'</td>
            <td>
                <label>
                    <a href="noticiaform.php?editar=' . $lista[$i]->getId() . '&idioma=' . $lista[$i]->getIdioma() . '" title="Editar"><div class="editar"></div></a>
                    <a href="#" title="Excluir"><div onclick="negocioNoticia.excluir(\''.$lista[$i]->getId().'\');" class="excluir"></div></a>
                    <a target="_blank" href="../noticia.php?id=' . $lista[$i]->getId() . '" title="Ver no site"><div class="visualizar"></div></a>
                </label>
            </td>
        </tr>  
    ';
}

//define o titulo da página
$tituloPainel = "Notícias";

//inclui o header
include_once './ui/header.interface.php';

?>
<script type="text/javascript" src="js/noticia.js"></script>
<form class="campodebusca" action="noticiavisualizacao.php" method="post">
    <input type="text" name="busca" class="campodetexto">
    <input type="submit" value="buscar" class="btn">
</form>
<table id="tabela" class="tabelaDeVisualizacao">
    <tr>
        <th style="width: 10%">Código</th>
        <th style="width: 30%">Título</th>
        <th style="width: 15%">Idioma</th>
        <th style="width: 15%">Data</th>
        <th style="width: 15%">Publicada</th>
        <th style="width: 15%">Ações</th>
    </tr>
    <?php echo $linhasDaTabela;?>
</table>
<?php
//inclui a barra de navegação
$interfaceNegocio->getBarraDePaginacao($configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"), $noticiaNegocio->getNumTotalDeRegistros(), "noticiavisualizacao.php");
//inclui os botoes
$interfaceNegocio->setFooterButtons('<a href="noticiaform.php">Nova notícia</a>');
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
