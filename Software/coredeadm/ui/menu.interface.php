<?php
/**
 * Arquivo: menu.interface.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface refere-se ao menu do sistema.
 * 
*/

//inclui as classes
include_once './negocio/usuarionegocio.class.php';

//cria os objetos a serem utilizados
$usuarioNegocio = new UsuarioNegocio();

?>
<script type="text/javascript" src="js/menuprincipal.jquery.min.js"></script>
<script>
    $(document).ready(function(){
        //recolhe todos os menus dd
        $("dd").hide();
        //ação ao clicar no titulo dt da barra lateral
        $("dt a").click(function(){
            $("dd:visible").slideUp("slow");
            $(this).parent().next().slideDown("slow");
            return false;
        });
    });
</script>

<div id="menu_v">
    <dl>
        <dt><a title="Acessar o site" href="#" onclick="window.open('../','_blank');">Ir ao site</a></dt>

        <?php
        if($usuarioLogado->getTipo() < 2){
        ?>
        <dt><a title="Abre menu" href="#">Banner Principal</a></dt>
        <dd>
            <ul>
                <li><a href="bannerform.php">Cadastrar Banner</a></li>
                <li><a href="bannervisualizacao.php">Listar Banner</a></li>
            </ul>
        </dd>

        <dt><a title="Abre menu" href="#">Ferramentas</a></dt>
        <dd>
            <ul>
                <li><a href="arquivos.php">Gerenciar arquivos</a></li>
            </ul>
        </dd>
        <?php } ?>
        <?php
        /*
        <dt><a title="Abre menu" href="#">Idiomas</a></dt>
        <dd>
            <ul>
                <li><a href="idiomaform.php">Cadastrar idioma</a></li>
                <li><a href="idiomavisualizacao.php">Listar idiomas</a></li>
            </ul>
        </dd>*/
        ?>
        
        <dt><a title="Abre menu" href="#">Notícias</a></dt>
        <dd>
            <ul>
                <li><a href="noticiaform.php">Cadastrar Notícias</a></li>
                <li><a href="noticiavisualizacao.php">Listar Noticias</a></li>
            </ul>
        </dd>
        
        <?php
        if($usuarioLogado->getTipo() < 2){
        ?>
        <dt><a title="Abre menu" href="#">Opções</a></dt>
        <dd>
            <ul>
                <li><a href="backup.php">Backup</a></li>
                <li><a href="configuracao.php">Configuração</a></li>
            </ul>
        </dd>

        
        <dt><a title="Abre menu" href="#">Páginas</a></dt>
        <dd>
            <ul>
                <li><a href="paginaform.php">Cadastrar páginas</a></li>
                <li><a href="paginavisualizacao.php">Listar páginas</a></li>
            </ul>
        </dd>

        <dt><a title="Abre menu" href="#">Usuários</a></dt>
        <dd>
            <ul>
                <li><a href="usuarioform.php">Cadastrar usuários</a></li>
                <li><a href="usuariovisualizacao.php">Listar usuários</a></li>
            </ul>
        </dd>
        
        <?php } ?>
    </dl>
</div>