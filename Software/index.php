<?php
include_once 'ui/seguranca.interface.php';

include_once 'ui/header.ui.php';

//incluir as classes
include_once './negocio/bannernegocio.class.php';
include_once './negocio/noticianegocio.class.php';

//criar objetos
$bannerNegocio = new BannerNegocio();
$noticiaNegocio = new noticiaNegocio();

//constantes
$PASTADEIMAGENS = "arquivos/imagens/";

//carrega banner do slide
$listaBanners = $bannerNegocio->consultarBanner("");
echo '<div id="w2bSlideContainer">
    <div id="w2bNivoSlider">';

for ($i = 0; $i < sizeof($listaBanners); $i++) {
    echo '<a href="'. $listaBanners[$i]->getLinkSite().'"><img src="' . $PASTADEIMAGENS . $listaBanners[$i]->getLinkBanner() . '"/></a>';
}

echo '</div></div>';

?>

<div class="corede-subtitulo">Notícias</div>

<div class="corede-noticia">
    
    <?php 
    $listaDeNoticias = $noticiaNegocio->consultarNoticiaPorTags("", 1);
    $cont = 0;
    for ($i = count($listaDeNoticias)-1; $i >= 0 ; $i--) {
        if($cont < 6 && $listaDeNoticias[$i]->getTags() == "noticia"){
            if ($listaDeNoticias[$i]->getLinkFoto() == "") {
                echo 
                '<div class="corede-noticia-item">
                    <a href="noticia.php?id='.$listaDeNoticias[$i]->getId().'" title="'.$listaDeNoticias[$i]->getTitulo().'">
                        <img src="imagens/semimagem.png" alt="'.$listaDeNoticias[$i]->getTitulo().'"/>
                        <p>'.substr(strip_tags($listaDeNoticias[$i]->getTitulo()), 0, 100).'</p>
                    </a>
                </div>';
            }
            else{
                echo 
                '<div class="corede-noticia-item">
                    <a href="noticia.php?id='.$listaDeNoticias[$i]->getId().'" title="'.$listaDeNoticias[$i]->getTitulo().'">
                        <img src="arquivos/imagens/'.$listaDeNoticias[$i]->getLinkFoto().'" alt="'.$listaDeNoticias[$i]->getTitulo().'"/>
                        <p>'.substr(strip_tags($listaDeNoticias[$i]->getTitulo()), 0, 100).'</p>
                    </a>
                </div>';
            }
        }
        $cont++;
    }
    ?>
</div>

<div class="corede-subtitulo">Localize-se</div>
<iframe class="corede-mapas" src="mapas/principal/index.html"></iframe>
<?php
include_once 'ui/footer.ui.php';
?>