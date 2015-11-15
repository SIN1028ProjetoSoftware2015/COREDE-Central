<?php
/**
 * Arquivo: bannervisualizacao.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de visualização da tabela de banners do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, -1, 1);

//classes
include_once './negocio/bannernegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';
include_once './negocio/arquivonegocio.class.php';
include_once './config/sistema.class.php';
include_once './negocio/interfacenegocio.class.php';

//cria os objetos
$configuracaoNegocio = new ConfiguracaoNegocio();
$bannerNegocio = new BannerNegocio();
$arquivoNegocio = new ArquivoNegocio();
$Sistema = new Sistema();
$interfaceNegocio = new InterfaceNegocio();

//se a ação for excluir
if(isset($_GET["excluir"])){
    if($bannerNegocio->verificaSeExiste($_GET["excluir"])){
        $aux = $bannerNegocio->consultarUnicaBanner($_GET["excluir"]);
        if($arquivoNegocio->deletar($Sistema->getDirImagens().$aux->getLinkBanner())){
            $bannerNegocio->deletarBanner($_GET["excluir"]);
            $interfaceNegocio->setMensagemDeAlerta("Banner deletado com sucesso!");
        }
        else{
            $interfaceNegocio->setMensagemDeAlerta("Erro ao excluir a imagem do banner!");
        }
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("O banner a ser deletado não foi encontrado!");
    }
}

//obtem a lista
if(isset($_POST["busca"])){
    $lista = $bannerNegocio->consultarBanner($_POST["busca"]);
}
else{
    $lista = $bannerNegocio->listarBanner($interfaceNegocio->getNumeroPaginaAtual(), $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"));
}

$linhasDaTabela = "";

for($i = 0; $i < sizeof($lista); $i++){
    $linhasDaTabela = $linhasDaTabela . '
        <tr>
            <td>'.
              $lista[$i]->getId()  
            .'</td>
            <td>
                <img style="width: 600px; height: 250px;" src="'.$Sistema->getDirImagens().$lista[$i]->getLinkBanner().'">
            </td>
            <td>
                <label>
                    <a href="bannerform.php?editar=' . $lista[$i]->getId() . '" title="Editar"><div class="editar"></div></a>
                    <a href="#" title="Excluir"><div onclick="negocioBanner.excluir(\''.$lista[$i]->getId().'\');" class="excluir"></div></a>
                </label>
            </td>
        </tr>  
    ';
}

//define o titulo da página
$tituloPainel = "Banners";

//inclui o header
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/banner.js"></script>
<table id="tabela" class="tabelaDeVisualizacao">
    <tr>
        <th style="width: 10%">Código</th>
        <th style="width: 40%">Miniatura</th>
        <th style="width: 10%">Ações</th>
    </tr>
    <?php echo $linhasDaTabela;?>
</table>
<?php
//inclui a barra de navegação
$interfaceNegocio->getBarraDePaginacao($configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"), $bannerNegocio->getNumTotalDeRegistros(), "bannervisualizacao.php");
//inclui os botoes
$interfaceNegocio->setFooterButtons('<a href="bannerform.php">Novo Banner</a>');
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
