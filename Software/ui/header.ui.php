<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Corede</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='imagens/corede_favicon.png' rel='icon' type='image/x-icon'/>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/corede.css" rel="stylesheet">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.slide.js"></script>
        <script src="js/nivoslider.js"></script>
        <script src="js/corede.js"></script>
    </head>
    <body>
        <nav role="navigation" class="navbar navbar-default corede-background corede-menu">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">                    
                        <span class="sr-only">Navegação Responsiva</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="corede-img-logo"> 
                        <a href="index.php" title="Corede > Página Inicial"><img src="imagens/logo.png" alt=""/></a>
                    </div>
                </div>
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav ">
                        <?php 
                        if($usuarioLogado != null){
                            echo '<li><a href="index.php">Home</a></li>
                                <li><a href="listnoticia.php?tag=noticia">Notícias</a></li>
                                <li><a href="listnoticia.php?tag=convocacoes">Convocações</a></li>
                                <li><a href="listnoticia.php?tag=convite">Convite</a></li>
                                <li><a href="atas.php">Atas</a></li>
                                <li><a href="pagina.php?id=1">Sobre</a></li>
                                <li><a href="contato.php">Contato</a></li>
                                <li><a href="coredeadm/index.php">Gerenciador</a></li>
                                <li><a href="index.php?sair">Sair</a></li>';
                        }
                        else {
                            echo '<li><a href="index.php">Home</a></li>
                                <li><a href="listnoticia.php?tag=noticia">Notícias</a></li>
                                <li><a href="listnoticia.php?tag=convocacoes">Convocações</a></li>
                                <li><a href="listnoticia.php?tag=convite">Convite</a></li>
                                <li><a href="pagina.php?id=1">Sobre</a></li>
                                <li><a href="contato.php">Contato</a></li>
                                <li><a href="login.php">Login</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>

        </nav>
        <div class="corede-conteudo">