<?php
/**
 * Arquivo: noticiaform.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de ediçao e cadastro de noticias.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(2, 2, -1);

//inclui as classes
include_once './negocio/noticianegocio.class.php';
include_once './negocio/arquivonegocio.class.php';
include_once './config/sistema.class.php';
include_once './negocio/interfacenegocio.class.php';
include_once './negocio/idiomanegocio.class.php';

//cria os objetos
$noticiaNegocio = new NoticiaNegocio();
$arquivoNegocio = new ArquivoNegocio();
$Sistema = new Sistema();
$interfaceNegocio = new InterfaceNegocio();
$idiomaNegocio = new IdiomaNegocio();

//define padroes
$pastaDeImagens = $Sistema->getDirImagens();
$listaDeIdiomas = $idiomaNegocio->consultarIdioma("");

//se o formlario foi enviado
if(isset($_POST["titulo"]) && (isset($_FILES["imagem"]) || isset($_POST["imagem"]))){
    if(isset($_GET["editar"]) && isset($_GET["idioma"])){
        if(isset($_FILES["imagem"])){
            $extensao = $arquivoNegocio->getExtensao($_FILES['imagem']['name']);
            if($extensao == "jpeg" || $extensao == "jpg"){
                $SendoEditado = $noticiaNegocio->consultarUnicaNoticia($_GET["editar"], $_GET["idioma"]);
                //excluir o arquivo antigo
                if($arquivoNegocio->deletar($pastaDeImagens.$SendoEditado->getLinkFoto())){
                    //tratamento de nome para não sobreescrever um arquivo
                    if($arquivoNegocio->verificaSeExiste($pastaDeImagens . $_FILES['imagem']['name'])){
                        $_FILES['imagem']['name'] = "mb_" . date("dmYHis") . "_" . $_FILES['imagem']['name'];
                    }
                    else{
                        $_FILES['imagem']['name'] = date("dmYHis") . "_" . $_FILES['imagem']['name'];
                    }
                    //enviar o novo arquivo
                    if($arquivoNegocio->upload($pastaDeImagens, $_FILES["imagem"])){
                        $noticiaNegocio->alterarNoticia($_GET["editar"], $_POST["titulo"], $_POST["data"], $_FILES['imagem']['name'], $_POST["conteudo"], 0, $_POST["publicar"], $_POST["tags"], $_GET["idioma"]);
                        $interfaceNegocio->setMensagemDeAlerta("Notícia alterada com sucesso!");
                    }
                    else{
                        $interfaceNegocio->setMensagemDeAlerta("Erro ao enviar a imagem.");
                    }
                }
                elseif ($SendoEditado->getLinkFoto() == "") {
                    //tratamento de nome para não sobreescrever um arquivo
                    if($arquivoNegocio->verificaSeExiste($pastaDeImagens . $_FILES['imagem']['name'])){
                        $_FILES['imagem']['name'] = "mb_" . date("dmYHis") . "_" . $_FILES['imagem']['name'];
                    }
                    else{
                        $_FILES['imagem']['name'] = date("dmYHis") . "_" . $_FILES['imagem']['name'];
                    }
                    //enviar o novo arquivo
                    if($arquivoNegocio->upload($pastaDeImagens, $_FILES["imagem"])){
                        $noticiaNegocio->alterarNoticia($_GET["editar"], $_POST["titulo"], $_POST["data"], $_FILES['imagem']['name'], $_POST["conteudo"], 0, $_POST["publicar"], $_POST["tags"], $_GET["idioma"]);
                        $interfaceNegocio->setMensagemDeAlerta("Notícia alterada com sucesso!");
                    }
                    else{
                        $interfaceNegocio->setMensagemDeAlerta("Erro ao enviar a imagem.");
                    }
                }
                else{
                    $interfaceNegocio->setMensagemDeAlerta("Erro ao excluir a imagem antiga desta notícia. Portanto o processo de alteração foi cancelado!");
                }
            }
            else{
                $interfaceNegocio->setMensagemDeAlerta("Erro na alteração. O arquivo selecionado não é uma imagem válida.");
            }
        }
        else{
            $noticiaNegocio->alterarNoticia($_GET["editar"], $_POST["titulo"], $_POST["data"], $_POST['imagem'], $_POST["conteudo"], 0, $_POST["publicar"], $_POST["tags"], $_GET["idioma"]);
            $interfaceNegocio->setMensagemDeAlerta("Notícia alterado com sucesso!");
        }
    }
    else{
        $lista = $noticiaNegocio->consultarNoticia("");
                
        $maiorID = 0;
        
        for ($i = 0; $i < count($lista); $i++) {
            if($maiorID < $lista[$i]->getId()){
                $maiorID = $lista[$i]->getId();
            }
        }
        
        //proximo ID
        $maiorID++;
        
        //se for cadastro
        if(isset($_FILES["imagem"])){
            if($_FILES['imagem']['name'] != ""){
                $extensao = $arquivoNegocio->getExtensao($_FILES['imagem']['name']);
                if($extensao == "jpeg" || $extensao == "jpg"){
                    //tratamento de nome para não sobreescrever um arquivo
                    if($arquivoNegocio->verificaSeExiste($pastaDeImagens . $_FILES['imagem']['name'])){
                        $_FILES['imagem']['name'] = "mb_" . date("dmYHis") . "_" . $_FILES['imagem']['name'];
                    }
                    else{
                        $_FILES['imagem']['name'] = date("dmYHis") . "_" . $_FILES['imagem']['name'];
                    }
                    if($arquivoNegocio->upload($pastaDeImagens, $_FILES["imagem"])){
                        for ($i = 0; $i < count($listaDeIdiomas); $i++) {
                            $noticiaNegocio->inserirNoticia($maiorID, $_POST["titulo"], $_POST["data"], $_FILES['imagem']['name'], $_POST["conteudo"], 0, $_POST["publicar"], $_POST["tags"], $listaDeIdiomas[$i]->getId());
                        }
                        //mensagem
                        $interfaceNegocio->setMensagemDeAlerta("Noticia criada com sucesso!");
                    }
                    else{
                        $interfaceNegocio->setMensagemDeAlerta("Erro ao enviar o arquivo.");
                    }
                }
                else{
                    $interfaceNegocio->setMensagemDeAlerta("Erro no cadastro. O arquivo selecionado não é uma imagem válida.");
                }
            }
            else {
                for ($i = 0; $i < count($listaDeIdiomas); $i++) {
                    echo "testemb=".$listaDeIdiomas[$i]->getId();
                    $noticiaNegocio->inserirNoticia($maiorID, $_POST["titulo"], $_POST["data"], "", $_POST["conteudo"], 0, $_POST["publicar"], $_POST["tags"], $listaDeIdiomas[$i]->getId());
                }
                    //mensagem
                $interfaceNegocio->setMensagemDeAlerta("Noticia criada com sucesso!");
            }
        }
    }
}

//se for edição preenche a tabela
if(isset($_GET["editar"]) && isset($_GET["idioma"])){
    $id = $_GET["editar"];
    $idioma = $_GET["idioma"];
    if($noticiaNegocio->verificaSeExiste($id, $idioma)){
        
        $SendoEditado = $noticiaNegocio->consultarUnicaNoticia($id, $idioma);
        
        $nome = $SendoEditado->getTitulo();
        $data = $SendoEditado->getDataNoticia();
        $imagem = $SendoEditado->getLinkFoto();
        $conteudo = $SendoEditado->getConteudo();
        $publicar = $SendoEditado->getPublicar();
        $tags = $SendoEditado->getTags();
        $urlEdicao = "?editar=" . $id . "&idioma=" . $idioma;
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Notícia não encontrado!");
        $nome = "";
        $data = "";
        $imagem = "";
        $conteudo = "";
        $publicar = "";
        $tags = "";
        $urlEdicao = "?editar=" . $id;
    }
}
else{
    //url da edicao
    $urlEdicao = "";
    $nome = "";
    $data = "";
    $imagem = "";
    $conteudo = "";
    $publicar = "";
    $tags = "";
}

//define o titulo da página
$tituloPainel = "Notícia";

//inclui o header
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/noticia.js"></script>
<script type="text/javascript" src="js/tempo.js"></script>

<form class="formulario" action="noticiaform.php<?php echo $urlEdicao;?>" method="post" name="formulario"  enctype="multipart/form-data">
<table>
    <?php
    if(isset($_GET["editar"])){
        $idiomaAtual = $idiomaNegocio->consultarUnicaIdioma($idioma);
        echo 
        '<tr>
            <td>
                <div class="label">Idioma:</div>
            </td>
            <td>
                <input type="text" value="'.$idiomaAtual->getIdioma().'" disabled>
            </td>
        </tr>';
    }
    if($usuarioLogado->getTipo() > 1){
        echo '<tr>
            <td>
                <div class="label">Aviso:</div>
            </td>
                <td>
                    As notícias só aparecerão no site após avaliação do administrador. 
                </td>
            </tr>';
    }
    ?>
    <tr>
        <td>
            <div class="label">Título:</div>
        </td>
        <td>
            <input type="text" name="titulo" value="<?php echo $nome; ?>">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Data:</div>
        </td>
        <td>
            <input type="text" name="data" value="<?php echo $data; ?>">
        </td>
    </tr>
    <?php
        if(isset($_GET["editar"])){
        echo'<tr>
                <td></td>
                <td>
                    <label onclick="negocioNoticia.habilitaSelecaoArquivo();"><input type="checkbox" name="alterarImagem"> Marque esta caixa para alterar a imagem.</label>
                </td>
            </tr>';
         }
     ?>
    <tr>
        <td>
            <div class="label">Imagem:</div>
        </td>
        <td>
            <?php 
            if(isset($_GET["editar"])){
                echo'<input type="text" name="imagem" value="'.$imagem.'" readonly="true" >';
            }
            else{
                echo'<input type="file" name="imagem" value="">';
            }
            ?>
        </td>
    </tr>
    <?php
        
        echo '<tr><td><div class="label">Publicar:</div></td><td><select name="publicar">';
            
        if(isset($_GET["editar"])){
            if($usuarioLogado->getTipo() > 1){
                if($publicar == 1){
                    echo '<option value="1">Sim</option>';
                }
                else{
                    echo '<option value="0">Não</option>';
                }
            }
            else{
                if($publicar == 1){
                    echo '
                        <option value="1">Sim</option>
                        <option value="0">Não</option>';
                }
                else{
                    echo '<option value="0">Não</option>'
                    . '<option value="1">Sim</option>';
                }
            }
        }
        else{
            if($usuarioLogado->getTipo() > 1){
                echo '<option value="0">Não</option>';
            }
            else{
                echo '<option value="0">Não</option>'
                . '<option value="1">Sim</option>';
            }
        }
        
        echo '</select></td></tr>';
    ?>
    <tr>
        <td>
            <div class="label">Conteúdo:</div>
        </td>
        <td>
            <textarea id="editordetexto"  name="conteudo"><?php echo $conteudo; ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Categoria:</div>
        </td>
        <td>
            <select name="tags">
                <?php
                    switch ($tags) {
                        case "convocacoes":
                            echo '
                            <option value="convocacoes">Convocações</option>
                            <option value="noticia">Notícias</option>
                            <option value="convites">Convites</option>';
                            break;
                        case "convites":
                            echo '
                            <option value="convites">Convites</option>
                            <option value="convocacoes">Convocações</option>
                            <option value="noticia">Notícias</option>';
                            break;

                        default:
                            echo '<option value="noticia">Notícias</option>
                            <option value="convocacoes">Convocações</option>
                            <option value="convites">Convites</option>';
                    }
                ?>
            </select>
        </td>
    </tr>
</table>
</form>

<?php
//se não estiver editando pega a hora do pc cliente
if(!isset($_GET["editar"])){
    echo '<script type="text/javascript">
              document.formulario.data.value = negocioTempo.getDataAtual();
          </script>';
}
//seta o código dos botões
$interfaceNegocio->setFooterButtons('<input type="button" value="Salvar" onclick="negocioNoticia.verificarDados();"><a href="noticiavisualizacao.php">Listar notícias</a>');

//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>