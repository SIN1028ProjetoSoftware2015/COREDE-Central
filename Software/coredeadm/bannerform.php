<?php
/**
 * Arquivo: bannerform.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de ediçao e cadastro de banners.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, 1, -1);

//inclui o header do sistema
include_once './negocio/bannernegocio.class.php';
include_once './negocio/arquivonegocio.class.php';
include_once './config/sistema.class.php';
include_once './negocio/interfacenegocio.class.php';

//cria os objetos
$bannerNegocio = new BannerNegocio();
$arquivoNegocio = new ArquivoNegocio();
$Sistema = new Sistema();
$interfaceNegocio = new InterfaceNegocio();

//define padroes
$pastaDeImagens = $Sistema->getDirImagens();

//se o formlario foi enviado
if(isset($_POST["link"]) && (isset($_FILES["imagem"]) || isset($_POST["imagem"]))){
    if(isset($_GET["editar"])){
        if(isset($_FILES["imagem"])){
            $extensao = $arquivoNegocio->getExtensao($_FILES['imagem']['name']);
            if($extensao == "png" ||  $extensao == "jpeg" || $extensao == "jpg" || $extensao == "gif"){
                $SendoEditado = $bannerNegocio->consultarUnicaBanner($_GET["editar"]);
                //excluir o arquivo antigo
                if($arquivoNegocio->deletar($pastaDeImagens.$SendoEditado->getLinkBanner())){
                    //tratamento de nome para não sobreescrever um arquivo
                    if($arquivoNegocio->verificaSeExiste($pastaDeImagens . $_FILES['imagem']['name'])){
                        $_FILES['imagem']['name'] = "mb_" . date("dmYHis") . "_" . $_FILES['imagem']['name'];
                    }
                    else{
                        $_FILES['imagem']['name'] = date("dmYHis") . "_" . $_FILES['imagem']['name'];
                    }
                    //enviar o novo arquivo
                    if($arquivoNegocio->upload($pastaDeImagens, $_FILES["imagem"])){
                        $bannerNegocio->alterarBanner($_GET["editar"], $_POST["link"], $_FILES['imagem']['name']);
                        $interfaceNegocio->setMensagemDeAlerta("Banner alterado com sucesso!");
                    }
                    else{
                        $interfaceNegocio->setMensagemDeAlerta("Erro ao enviar o arquivo.");
                    }
                }
                else{
                    $interfaceNegocio->setMensagemDeAlerta("Erro ao excluir a imagem antiga deste banner. Portanto o processo de alteração foi cancelado!");
                }
            }
            else{
                $interfaceNegocio->setMensagemDeAlerta("Erro na alteração. O arquivo selecionado não é uma imagem válida.");
            }
        }
        else{
            $bannerNegocio->alterarBanner($_GET["editar"], $_POST["link"], $_POST["imagem"]);
            $interfaceNegocio->setMensagemDeAlerta("Banner alterado com sucesso!");
        }
    }
    else{
        //se for cadastro
        if(isset($_FILES["imagem"])){
            $extensao = $arquivoNegocio->getExtensao($_FILES['imagem']['name']);
            if($extensao == "png" ||  $extensao == "jpeg" || $extensao == "jpg" || $extensao == "gif"){
                //tratamento de nome para não sobreescrever um arquivo
                if($arquivoNegocio->verificaSeExiste($pastaDeImagens . $_FILES['imagem']['name'])){
                    $_FILES['imagem']['name'] = "mb_" . date("dmYHis") . "_" . $_FILES['imagem']['name'];
                }
                else{
                    $_FILES['imagem']['name'] = date("dmYHis") . "_" . $_FILES['imagem']['name'];
                }
                if($arquivoNegocio->upload($pastaDeImagens, $_FILES["imagem"])){
                    $bannerNegocio->inserirBanner($_POST["link"], $_FILES['imagem']['name']);
                    //mensagem
                    $interfaceNegocio->setMensagemDeAlerta("Banner criado com sucesso!");
                }
                else{
                    $interfaceNegocio->setMensagemDeAlerta("Erro ao enviar o arquivo.");
                }
            }
            else{
                $interfaceNegocio->setMensagemDeAlerta("Erro no cadastro. O arquivo selecionado não é uma imagem válida.");
            }
        }
    }
}

//se for edição preenche a tabela
if(isset($_GET["editar"])){
    $id = $_GET["editar"];
    if($bannerNegocio->verificaSeExiste($id)){
        $SendoEditado = $bannerNegocio->consultarUnicaBanner($id);
        
        $link = $SendoEditado->getLinkSite();
        $imagem = $SendoEditado->getLinkBanner();
        $urlEdicao = "?editar=" . $id;
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Banner não encontrado!");
        $imagem = "";
        $link = "";
        $urlEdicao = "";
    }
}
else{
    //url da edicao
    $urlEdicao = "";
    $imagem = "";
    $link = "";
}

//define o titulo da página
$tituloPainel = "Banner";

//inclui o header
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/banner.js"></script>

<form class="formulario" action="bannerform.php<?php echo $urlEdicao;?>" method="post" name="formulario" enctype="multipart/form-data">
<table>
    <tr>
        <td>
            <div class="label">Link:</div>
        </td>
        <td>
            <input type="text" name="link" value="<?php if(isset($_GET["editar"])){echo $link;}else{echo "#";} ?>">
        </td>
    </tr>
        <?php
        if(isset($_GET["editar"])){
        echo'<tr>
                <td></td>
                <td>
                    <label onclick="negocioBanner.habilitaSelecaoArquivo();"><input type="checkbox" name="alterarImagem"> Marque esta caixa para alterar a imagem.</label>
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
    <tr>
        <td>
            <div class="label">Aviso:</div>
        </td>
        <td>
            <p>Este banner deve ter o tamanho de 1000 pixels de largura e 366 pixels de altura.</p>
            <p>Este link deve conter http:// na frente.</p>
        </td>
    </tr>
</table>
</form>

<?php
//seta o código dos botões
$interfaceNegocio->setFooterButtons('<input type="button" value="Salvar banner" onclick="negocioBanner.verificarDados();"><a href="bannervisualizacao.php">Listar banners</a>');

//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>