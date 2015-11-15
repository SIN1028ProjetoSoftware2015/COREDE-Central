<?php
/**
 * Arquivo: header.interface.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface refere-se ao cabeçalho do sistema.
 * 
 */

//inclui as classes
include_once './negocio/usuarionegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';

//cria os objetos
$usuarioNegocio = new UsuarioNegocio();
$configuracaoNegocio = new ConfiguracaoNegocio();

//tratamento para títulos
if(!isset($tituloPainel)){
    $tituloPainel = "Painel > " . $configuracaoNegocio->carregarValorDaConfiguracao("tituloDoSite");
    $subtitulo = "";
}
else{
    $subtitulo = " > " . $tituloPainel;
    $tituloPainel = $tituloPainel . " | " . $configuracaoNegocio->carregarValorDaConfiguracao("tituloDoSite");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $tituloPainel; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href='style/img/favicon.png' rel='icon' type='image/x-icon'/>
        <link rel="stylesheet" type="text/css" href="style/painel.css">
        <script type="text/javascript" src="plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="js/painel.js"></script>
    </head>
    <body>
        <div id="carregando"></div>
        <div id="header">
            <div id="titulo"><a href="painel.php" title="Ir para a página inicial do painel"><?php echo $configuracaoNegocio->carregarValorDaConfiguracao("tituloDoSite");?></a></div>
            <div id="subtitulo"><?php echo $subtitulo; ?></div>
            <div id="mensagemUsuario" onmouseover="popUpUsuario.abrir();" >Olá <?php echo $usuarioLogado->getNome(); ?>!
                <div id="popUpUsuario" class="popUp" onmouseout="popUpUsuario.fechar();">
                    <div class="triangulo"></div>
                    <h1><?php echo $usuarioLogado->getNome(); ?></h1>
                    <h2><?php echo $usuarioNegocio->tipoUsuario($usuarioLogado->getTipo()); ?></h2>
                    <ul>
                        <li><a title="Visualizar perfil!" href="usuarioform.php?editar=<?php echo $usuarioLogado->getId(); ?>">Editar perfil</a></li>
                        <li><a title="Configurações do sistema" href="configuracao.php">Configurações</a></li>
                        <li><a title="Sair do sistema" href="?sair=1">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php include_once './ui/menu.interface.php'; ?>
        <div id="conteudo">