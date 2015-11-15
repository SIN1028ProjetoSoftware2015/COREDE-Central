<?php

/*
  @autor Maik Basso
  @email maik@maikbasso.com.br
  @telefone (55) 9952-9459
 */

//classes
include_once './negocio/noticianegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';
include_once './negocio/interfacenegocio.class.php';

//cria os objetos
$configuracaoNegocio = new ConfiguracaoNegocio();
$noticiaNegocio = new noticiaNegocio();
$interfaceNegocio = new InterfaceNegocio();

//variaveis
$PASTADEIMAGENS = "arquivos/imagens/";
$h1 = "";
if (isset($_GET["tag"])) {
    if($_GET["tag"] == "noticia"){
        $h1 = "Notícias";
    }
    if($_GET["tag"] == "convocacoes"){
        $h1 = "Convocações";
    }
    if($_GET["tag"] == "convite"){
        $h1 = "Convite";
    }
}
 else {
    $h1 = "";
}

//define o título da página
$titulo = $h1;

//inclui o header
include_once './ui/header.ui.php';


if (isset($_GET["tag"])) {
    $lista = $lista = $noticiaNegocio->listarNoticia($interfaceNegocio->getNumeroPaginaAtual(), $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaSite"), $_GET["tag"]);

    if (count($lista) == 0) {
        echo '<div class="corede-subtitulo">Não há nada cadastrado!</div>';
    } else {
        echo '<div class="corede-subtitulo">'.$h1.'</div>';
        echo '<div class="corede-noticia">';
        for ($i = 0; $i < sizeof($lista); $i++) {
            if ($lista[$i]->getPublicar() == 1) {
                if ($lista[$i]->getLinkFoto() == "") {
                    echo '<div class="corede-noticia-item">
                            <a href="noticia.php?id='.$lista[$i]->getId().'" title="'.$lista[$i]->getTitulo().'">
                                <img src="imagens/semimagem.png" alt="'.$lista[$i]->getTitulo().'"/>
                                <p>'.substr(strip_tags($lista[$i]->getTitulo()), 0, 100).'</p>
                            </a>
                        </div>';
                } else {
                    echo '<div class="corede-noticia-item">
                            <a href="noticia.php?id=' . $lista[$i]->getId() . '" title="' . $lista[$i]->getTitulo() . '">
                                <img src="arquivos/imagens/' . $lista[$i]->getLinkFoto() . '" alt="' . $lista[$i]->getTitulo() . '"/>
                                <p>' . substr(strip_tags($lista[$i]->getTitulo()), 0, 100) . '</p>
                            </a>
                        </div>';
                }
            }
        }
        echo '</div>';
        echo '<div id="barraDeNavegacao">';
        $interfaceNegocio->getBarraDePaginacao($configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaSite"), $noticiaNegocio->getNumTotalDeRegistros(), "listnoticia.php?tag=".$_GET["tag"]);
        echo '</div>';
        }
}
else {
    echo '<h1>Não há nada cadastrado!</h1>';
}

include_once 'ui/footer.ui.php';

?>