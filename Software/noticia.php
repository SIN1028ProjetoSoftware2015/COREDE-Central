<?php

/*
  @autor Maik Basso
  @email maik@maikbasso.com.br
  @telefone (55) 9952-9459
 */

include_once 'ui/seguranca.interface.php';

//inclui as classes
include_once './negocio/segurancanegocio.class.php';
include_once './negocio/noticianegocio.class.php';

//cria os objetos
$segurancaNegocio = new SegurancaNegocio();
$noticiaNegocio = new NoticiaNegocio();

if (isset($_GET["id"])) {
    $id = $segurancaNegocio->filtroDeMetodoGet($_GET["id"], "int");

    if ($noticiaNegocio->verificaSeExiste($id, 1)) {
        $atual = $noticiaNegocio->consultarUnicaNoticia($id, 1);

        if ($atual->getPublicar() == 1) {
            $noticiaAtual = $atual;
        } else {
            $id = -1;
        }
    } else {
        $id = -1;
    }
} else {
    $id = -1;
}

include_once 'ui/header.ui.php';


if ($id == -1) {
    echo '<div class="corede-titulo">A notícia não existe!</div>';
} 
else {
    echo '<div class="corede-titulo">'.$atual->getTitulo().'</div>';
    if ($noticiaAtual->getLinkFoto() != "") {
        echo '<div class="corede-img-principal"><img title="' . $noticiaAtual->getTitulo() . '" alt="' . $noticiaAtual->getTitulo() . '" src="arquivos/imagens/' . $noticiaAtual->getLinkFoto() . '"></div>';
    }
    echo '<div class="corede-texto">';
    echo '<br>Publicada em ' . $noticiaAtual->getDataNoticia().'<br><br>';
    echo $atual->getConteudo();
    echo '</div>';
}
echo '</div>';

include_once 'ui/footer.ui.php';
?>