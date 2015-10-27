<?php
/**
 * Arquivo: configuracao.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela inicial do sistema após o login.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, -1, -1);

//inclui as classes
include_once './negocio/configuracaonegocio.class.php';
include_once './negocio/interfacenegocio.class.php';

//cria os objetos
$configuracaoNegocio = new ConfiguracaoNegocio();
$interfaceNegocio = new InterfaceNegocio();

//se for restauração
if(isset($_GET["restaurar"])){
    if($_GET["restaurar"] == TRUE){
        //atualiza o titulo
        $configuracaoNegocio->alterarConfiguracao("Título", "tituloDoSite");
        $configuracaoNegocio->alterarConfiguracao("Descrição", "descricaoDoSite");
        $configuracaoNegocio->alterarConfiguracao(5, "numeroDeItensPorPaginaPainel");
        $configuracaoNegocio->alterarConfiguracao(10, "numeroDeItensPorPaginaSite");
        $configuracaoNegocio->alterarConfiguracao("jpg, jpeg", "extensoesDeImgagens");
        $configuracaoNegocio->alterarConfiguracao("email@servidor.com", "emailDoFormularioDeContato");

        //mensagem
        $interfaceNegocio->setMensagemDeAlerta("Configurações restauradas com sucesso!");
    }
}

//se o formlario foi enviado
if(isset($_POST["tituloSite"]) && isset($_POST["descricaoSite"])){     
    //altera as configuracoes na db
    $configuracaoNegocio->alterarConfiguracao($_POST["tituloSite"], "tituloDoSite");
    $configuracaoNegocio->alterarConfiguracao($_POST["descricaoSite"], "descricaoDoSite");
    $configuracaoNegocio->alterarConfiguracao($_POST["numeroDeItensPorPaginaPainel"], "numeroDeItensPorPaginaPainel");
    $configuracaoNegocio->alterarConfiguracao($_POST["numeroDeItensPorPaginaSite"], "numeroDeItensPorPaginaSite");
    $configuracaoNegocio->alterarConfiguracao($_POST["extensoesDeImgagens"], "extensoesDeImgagens");
    $configuracaoNegocio->alterarConfiguracao($_POST["emailDoFormularioDeContato"], "emailDoFormularioDeContato");
    
    //mensagem
    $interfaceNegocio->setMensagemDeAlerta("Configurações salvas com sucesso!");
}

//define o titulo da página
$tituloPainel = "Configurações";

//inclui o header do sistema
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/configuracao.js"></script>

<form class="formulario" action="configuracao.php" method="post" name="formulario">
<table>
    <tr>
        <td style="width: 200px;">
            <div class="label">Título do site:</div>
        </td>
        <td>
            <input type="text" name="tituloSite" value="<?php echo $configuracaoNegocio->carregarValorDaConfiguracao("tituloDoSite");?>">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Descrição do site:</div>
        </td>
        <td>
            <input type="text" name="descricaoSite" value="<?php echo $configuracaoNegocio->carregarValorDaConfiguracao("descricaoDoSite");?>">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Email do formulário de contato:</div>
        </td>
        <td>
            <input type="text" name="emailDoFormularioDeContato" value="<?php echo $configuracaoNegocio->carregarValorDaConfiguracao("emailDoFormularioDeContato");?>">
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Número de itens por página (Painel ADM):</div>
        </td>
        <td>
            <select name="numeroDeItensPorPaginaPainel">
                <?php $numeroDeItensPorPaginaPainel = $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel");?>
                <option value="<?php echo $numeroDeItensPorPaginaPainel; ?>"><?php echo $numeroDeItensPorPaginaPainel; ?></option>
                <?php for($i=1; $i<=100; $i++){ echo '<option value="'.$i.'">'.$i.'</option>'; } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Número de itens por página (Site):</div>
        </td>
        <td>
            <select name="numeroDeItensPorPaginaSite">
                <?php $numeroDeItensPorPaginaSite = $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaSite");?>
                <option value="<?php echo $numeroDeItensPorPaginaSite; ?>"><?php echo $numeroDeItensPorPaginaSite; ?></option>
                <?php for ($i = 1; $i <= 100; $i++) { echo '<option value="' . $i . '">' . $i . '</option>'; } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Extensões de imagens (álbuns/galerias):</div>
        </td>
        <td>
            <input type="text" name="extensoesDeImgagens" value="<?php echo $configuracaoNegocio->carregarValorDaConfiguracao("extensoesDeImgagens");?>">
        </td>
    </tr>
</table>
</form>

<?php
//seta o código dos botões
$interfaceNegocio->setFooterButtons('<input type="button" value="Salvar configurações" onclick="negocioConfiguracao.verificarDados();"><input type="button" value="Restaurar Padrões" onclick="negocioConfiguracao.restaurar();">');

//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>