<?php
/*
  @autor Maik Basso
  @email maik@maikbasso.com.br
  @telefone (55) 9952-9459
 */

include_once 'ui/seguranca.interface.php';

//inclui as classes
include_once './negocio/segurancanegocio.class.php';
include_once './negocio/paginanegocio.class.php';

//cria os objetos
$segurancaNegocio = new SegurancaNegocio();
$paginaNegocio = new PaginaNegocio();

if(isset($_GET["id"])){
    $id = $segurancaNegocio->filtroDeMetodoGet($_GET["id"], "int");
    
    if($paginaNegocio->verificaSeExiste($id, 1)){
        $pagina = $paginaNegocio->consultarUnicaPagina($id, 1);
        $titulo = $pagina->getTitulo();
    }
    else{
        $id = -1;
    }
}
else{
    $id = -1;
}

include_once 'ui/header.ui.php';

echo '<div class="conteudo">';
    if($id == -1){
        echo '<div class="corede-titulo">A página não existe!</div>';
    }
    else {
        echo '<div class="corede-titulo">'.$pagina->getTitulo().'</div>';
        echo '<div class="corede-texto">'.$pagina->getConteudo().'</div>';
    }
echo '</div>';

include_once 'ui/footer.ui.php';
?>