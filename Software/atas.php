<?php
include_once 'ui/seguranca.interface.php';

include_once './negocio/atanegocio.class.php';
include_once './negocio/arquivonegocio.class.php';
include_once './negocio/interfacenegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';

$ataNegocio = new AtaNegocio();
$configuracaoNegocio = new ConfiguracaoNegocio();
$arquivoNegocio = new ArquivoNegocio();
$interfaceNegocio = new InterfaceNegocio();

$pastaDeImagens = "arquivos/atas/";

$mensagem = "";

//se for cadastrar uma ata
if(isset($_POST["descricao"]) && isset($_FILES["arquivo"])){
    if ($_FILES['arquivo']['name'] != "" && $_POST["descricao"] != "") {
        $extensao = strtolower($arquivoNegocio->getExtensao($_FILES['arquivo']['name']));
        if ($extensao == "jpeg" || $extensao == "jpg" || $extensao == "pdf") {
            
            //tratamento de nome para não sobreescrever um arquivo
            if ($arquivoNegocio->verificaSeExiste($pastaDeImagens . $_FILES['arquivo']['name'])) {
                $_FILES['arquivo']['name'] = "mb_" . date("dmYHis") . "_" . $_FILES['arquivo']['name'];
            } else {
                $_FILES['arquivo']['name'] = date("dmYHis") . "_" . $_FILES['arquivo']['name'];
            }
            
            if ($arquivoNegocio->upload($pastaDeImagens, $_FILES["arquivo"])) {
                $ataNegocio->inserirAta($_POST["descricao"], date("d/m/Y"), $_FILES['arquivo']['name']);
            } 
        }
        else{
            $mensagem = "A extensão do arquivo não permitida!";
        }
    }
    else{
        $mensagem = "Ata não cadastrada. Descrição não inserida ou o arquivo não selecionado.";
    }
}

//se tentar excluir
if($usuarioLogado->getTipo() < 2){
    if(isset($_GET["remover"])){
        $id = $_GET["remover"];
        
        if($ataNegocio->verificaSeExiste($id)){
            $ataAtual = $ataNegocio->consultarUnicaAta($id);
            $arquivoNegocio->deletar("arquivos/atas/". $ataAtual->getAta());
            $ataNegocio->deletarAta($id);
        }
    }
}

$listaDeAtas = $ataNegocio->listarAtas($interfaceNegocio->getNumeroPaginaAtual(), $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaSite"));

include_once 'ui/header.ui.php';
?>

<div class="corede-subtitulo">Atas</div>

<div class="corede-atas">
    <form action="atas.php" method="post" enctype="multipart/form-data">
        <?php
        if($mensagem != ""){
            echo '<p>'.$mensagem.'</p>';
        }
        ?>
        <input name="descricao" type="text" placeholder="descrição da ata">
        <input name="arquivo" type="file"> <p>As atas só poderão ser anexadas nos segintes formatos: pdf, jpeg, jpg.</p>
        <input type="submit" value="enviar ata">
    </form>
    <table id="tabelaDeAtas">
        <tr>
            <th>Descrição</th>
            <th>Data</th>
            <th>Download</th>
        </tr>
        <?php
        for ($i = 0; $i < count($listaDeAtas); $i++) {
            echo '<tr>
                    <td>' . $listaDeAtas[$i]->getDescricao() . '</td>
                    <td>' . $listaDeAtas[$i]->getData() . '</td>
                    <td><a href="arquivos/atas/' . $listaDeAtas[$i]->getAta() . '">baixar</a>';
            if ($usuarioLogado->getTipo() < 2) {
                echo '<a class="remover" href="?remover='.$listaDeAtas[$i]->getId().'">remover</a>';
            }
            echo '</td>
                </tr>';
        }
        ?>
    </table>
    <?php
        echo '<div id="barraDeNavegacao">';
        $interfaceNegocio->getBarraDePaginacao($configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaSite"), $ataNegocio->getNumTotalDeRegistros(), "atas.php");
        echo '</div>';
    ?>
</div>
<?php
include_once 'ui/footer.ui.php';
?>