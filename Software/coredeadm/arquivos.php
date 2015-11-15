<?php
/**
 * Arquivo: arquivos.php
 * Criado em: 13/06/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela do gerenciador de arquivos do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(2, -1, 2);

//bloqueia acesso a arquivos do sistema a usuários não autorizados
if(isset($_GET["end"]) && strstr($_GET["end"], '../arquivos/home/') == FALSE){
    $usuarioNegocio->getPermissao(0);
}

//includes
include_once './negocio/arquivonegocio.class.php';
include_once './config/sistema.class.php';
include_once './negocio/interfacenegocio.class.php';

//objetos
$arquivoNegocio = new ArquivoNegocio();
$Sistema = new Sistema();
$interfaceNegocio = new InterfaceNegocio();

//define a pasta de arquivos do usuário
$pastaArquivosUsuario = $Sistema->getDirHomeGerenciadorDeArquivos();

//atualiza a pasta atual na navegação do usuário
if(isset($_GET["end"])){
    $pastaAtual = $_GET["end"];
}
else{
    $pastaAtual = $pastaArquivosUsuario;
}

//habilita e desabilita o modoUpload
//o modo upload so da a opção de upload para uma unica pasta e elimina a possibilidade de navegação
if(isset($_GET["modoUpload"]) && $_GET["modoUpload"]==1){
    $modoUpload = true;
    $formActionUrl = "?end=".$pastaAtual."&modoUpload=1";
    $urlExcluir = "&modoUpload=1";
}
else {
    $modoUpload = false;
    $formActionUrl = "?end=".$pastaAtual;
    $urlExcluir = "";
}

//se tiver solicitação de exclusao
if(isset($_GET["excluir"])){    
    if($arquivoNegocio->deletar($pastaAtual.$_GET["excluir"])){
        $interfaceNegocio->setMensagemDeAlerta("Arquivo excluído com sucesso!");
    }
    else{
        if($arquivoNegocio->deletarPastaComConteudo($pastaAtual.$_GET["excluir"])){
            $interfaceNegocio->setMensagemDeAlerta("Pasta excluída com sucesso!");
        }
        else{
            $interfaceNegocio->setMensagemDeAlerta("Erro ao excluir!");
        }
    }
}

//se tiver solicitação de criar nova pasta
if(isset($_POST["novaPasta"])){    
    if($arquivoNegocio->criarPasta($pastaAtual, $_POST["novaPasta"])){
        $interfaceNegocio->setMensagemDeAlerta("Pasta criada com sucesso!");
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Erro ao criar a nova pasta! Possivelmente você está tentando criar uma pasta que já existe ou uma pasta sem nome.");
    }
}

//se tiver solicitação de upload / multiulpoad
if(isset($_FILES["arquivos"])){
    //obtem um array de arquivos filtrando os arquivos por extensoes
    $arrayDeArquivos = $arquivoNegocio->getArrayMultiUpload($_FILES["arquivos"]);
    
    $falha = FALSE;
    $numUploads = 0;
    foreach ($arrayDeArquivos as $arquivo) {
        //upload
        if($arquivoNegocio->upload($pastaAtual, $arquivo)){
            $numUploads++;
        }
        else{
            $falha = TRUE;
        }
    }
    //relatório do upload
    if ($numUploads == 0) {
        $interfaceNegocio->setMensagemDeAlerta("Erro ao carregar os arquivos!");
    }
    elseif($falha == TRUE){
        $interfaceNegocio->setMensagemDeAlerta("Concluído, porém não foi possível carregar todos os arquivos!");
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Arquivos carregados com sucesso!");
    }
}

//criar a tabela de arquivos
$linhasDaTabela = "";
$contVazia = 0;
$pasta = $arquivoNegocio->abrirPasta($pastaAtual);
while($arquivo = $arquivoNegocio->lerPasta($pasta)){
    if(($arquivo != ".") && ($arquivo != "..")){
        $contVazia++;
        //verifica se é pasta ou nao
        if($arquivoNegocio->isPasta($pastaAtual.$arquivo)){
            
            $linhasDaTabela = $linhasDaTabela . '
                <tr>
                    <td><div class="pasta"></div></td>
                    <td><a href="?end='.$pastaAtual.$arquivo.'/" title="Abrir pasta">'. $arquivo .'</a></td>
                    <td>'. $arquivoNegocio->getTamanho($pastaAtual.$arquivo).'</td>
                    <td>
                        <label>
                            <a href="#" title="Excluir"><div onclick="negocioArquivos.confirmacaoDeExclusao(\'?end=' .$pastaAtual . '&excluir=' . $arquivo . '/' . $urlExcluir . '\');" class="excluir"></div></a>
                        </label>
                    </td>
                </tr>  
            ';
            
        }
        else if(substr($arquivo, 0, 1) == "."){ //se o nome do arquivo começar com ponto (.) arquivo oculto
            //so exibe o arquivo se for super usruario
            if($usuarioLogado->getTipo() <= 0){
                $linhasDaTabela = $linhasDaTabela . '
                    <tr>
                        <td><div class="arquivo"></div></td>
                        <td><a href="download.php?pasta=' . $pastaAtual . "&arquivo=" . $arquivo . '" title="Download" target="_blank">' . $arquivo . '</a></td>
                        <td>'. $arquivoNegocio->getTamanho($pastaAtual.$arquivo).'</td>
                        <td>
                            <label>
                                <a href="#" title="Excluir"><div onclick="negocioArquivos.confirmacaoDeExclusao(\'?end=' .$pastaAtual . '&excluir=' . $arquivo . $urlExcluir . '\');" class="excluir"></div></a>
                                <a href="download.php?pasta=' . $pastaAtual . "&rquivo=" . $arquivo . '" title="Download" target="_blank"><div class="download"></div></a>
                            </label>
                        </td>
                    </tr>  
                ';
            }
        }
        else{
            $linhasDaTabela = $linhasDaTabela . '
                <tr>
                    <td><div class="arquivo"></div></td>
                    <td><a href="download.php?pasta=' . $pastaAtual . "&arquivo=" . $arquivo . '" title="Download" target="_blank">' . $arquivo . '</a></td>
                    <td>'. $arquivoNegocio->getTamanho($pastaAtual.$arquivo).'</td>
                    <td>
                        <label>
                            <a href="#" title="Excluir"><div onclick="negocioArquivos.confirmacaoDeExclusao(\'?end=' .$pastaAtual . '&excluir=' . $arquivo . $urlExcluir . '\');" class="excluir"></div></a>
                            <a href="download.php?pasta=' . $pastaAtual . "&arquivo=" . $arquivo . '" title="Download" target="_blank"><div class="download"></div></a>
                        </label>
                    </td>
                </tr>  
            ';
        }
    }
}

//gera o menu de navegação entre os diretórios
$pastas = explode("/", $pastaAtual); //cria um vetor com os nomes das pastas
$menuDeNavegacao = "";
for ($i = 2; $i < sizeof($pastas)-1; $i++) {
    //obtem o link
    $link = "";
    for ($index = 0; $index <= $i; $index++) {
        $link = $link . $pastas[$index] . "/";
    }
    $menuDeNavegacao = $menuDeNavegacao . '<a href="arquivos.php?end=' . $link . '" title="' . $pastas[$i] . '">' . $pastas[$i] . '</a> > ';
}

//define o titulo da página
$tituloPainel = "Meus arquivos";

//inclui o header
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/arquivos.js"></script>
<?php
if($modoUpload != true){
    echo '<table class="tabelaDeVisualizacao">'; 
        echo"<tr>";
            echo "<th>" . $menuDeNavegacao . "</th>";
        echo "</tr>";
    echo "</table>";
}
?>
<table id="tabela" class="tabelaDeVisualizacao">
    <tr>
        <th style="width: 6%"></th>
        <th>Nome do arquivo</th>
        <th style="width: 10%">Tamanho</th>
        <th style="width: 10%">Ações</th>
    </tr>
    <?php echo $linhasDaTabela;?>
</table>
<div id="janelaNovaPasta" class="janela">
    <a href="javascript:Janela.fechar('janelaNovaPasta');" class="fechar">X</a>
    <div class="titulo">Nova Pasta</div>
    <form class="formulario" action="<?php echo $formActionUrl; ?>" method="post" name="criarPasta">
        <table>
            <tr>
                <td>
                    <div class="label">Nome:</div>
                </td>
                <td>
                    <input type="text" name="novaPasta">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="button" value="Criar" class="btn" onclick="negocioArquivos.criarPasta();">
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="janelaUpload" class="janela">
    <a href="javascript:Janela.fechar('janelaUpload');" class="fechar">X</a>
    <div class="titulo">Enviar Arquivos</div>
    <form class="formulario" action="<?php echo $formActionUrl; ?>" method="post" name="enviarArquivos" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    <div class="label">Selecionar arquivo:</div>
                </td>
                <td>
                    <input type="file" name="arquivos[]" multiple>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="button" value="Enviar" class="btn" onclick="negocioArquivos.enviarArquivos();">
                </td>
            </tr>
        </table>
    </form>
</div>
<?php
//inclui os botoes
if($modoUpload != true){
    $interfaceNegocio->setFooterButtons('<a href="javascript:Janela.abrir(\'janelaNovaPasta\', 150, 530);">Nova pasta</a><a href="javascript:Janela.abrir(\'janelaUpload\', 160, 620);">Enviar</a>');
}
else {
    $interfaceNegocio->setFooterButtons('<a href="javascript:Janela.abrir(\'janelaUpload\', 160, 620);">Enviar</a>');
}
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
