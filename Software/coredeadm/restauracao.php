<?php
/**
 * Arquivo: restauracao.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de backup do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(0, -1, -1);

//inclui as classes
include_once './negocio/backupnegocio.class.php';
include_once './negocio/arquivonegocio.class.php';
include_once './negocio/interfacenegocio.class.php';
//include_once './negocio/criptografianegocio.class.php';

//objetos
$backupNegocio = new BackupNegocio();
$arquivoNegocio = new ArquivoNegocio();
$interfaceNegocio = new InterfaceNegocio();

//$cp = new CriptografiaNegocio();

//restaurar a partir de backup no servidor
if(isset($_POST["backupOn"]) && $_POST["backupOn"] != ""){
    $backupNegocio->restaurarBackup($backupNegocio->getNomePastaDeBackups() . $_POST["backupOn"]);
    //echo $cp->descriptografar($arquivoNegocio->getConteudo($backupNegocio->getNomePastaDeBackups() . $_POST["backupOn"]));
    $interfaceNegocio->setMensagemDeAlerta("Backup restaurado com sucesso!");
}

//restaurar a partir de backup offline
if(isset($_FILES["backupOff"]) && $_FILES["backupOff"] != ""){
    if($arquivoNegocio->getExtensao($_FILES["backupOff"]) == $backupNegocio->getExtensaoDosBackups()){
        $backupNegocio->restaurarBackup($_FILES["backupOff"]);
        $interfaceNegocio->setMensagemDeAlerta("Backup restaurado com sucesso!");
    }
    else {
        $interfaceNegocio->setMensagemDeAlerta("Arquivo de backup inválido!");
    }
}

//obtem os itens dos arquivos de backup online
$itensDeBackups = "";
$pasta = $arquivoNegocio->abrirPasta($backupNegocio->getNomePastaDeBackups());
while($arquivo = $arquivoNegocio->lerPasta($pasta)){
    //se for arquivo de backup
    $ext = "." . $arquivoNegocio->getExtensao($arquivo);
    
    if(($ext == $backupNegocio->getExtensaoDosBackups()) && ($arquivo != ".") && ($arquivo != "..")){
        $itensDeBackups = $itensDeBackups . '
            <option value="' . $arquivo . '">' . $arquivo . '</option>';
    }
}

//define o titulo da página
$tituloPainel = "Restaurar banco de dados";

//inclui o header
include_once './ui/header.interface.php';

?>
<script type="text/javascript" src="js/backup.js"></script>
<form class="formulario" action="restauracao.php" method="post" name="formulario">
<table>
    <tr>
        <td>
            <div class="label">Restaurar a partir de:</div>
        </td>
        <td>
            <label onclick="negocioBackup.alterarBackup();"><input type="radio" name="tipoDeRestauracao" value="on" id="On" checked> Um arquivo no servidor.</label><br />
            <label onclick="negocioBackup.alterarBackup();"><input type="radio" name="tipoDeRestauracao" value="off" id="Off" > Um arquivo externo.</label>
        </td>
    </tr>
    <tr>
        <td>
            <div class="label">Selecione o arquivo de backup:</div>
        </td>
        <td>
            <select name="backupOn">
                <option value=""></option>
                <?php echo $itensDeBackups; ?>
            </select>
            <input type="file" name="backupOff" style="display: none;">
        </td>
    </tr>
</table>
</form>
<?php
//inclui os botoes
$interfaceNegocio->setFooterButtons('<input type="button" value="Carregar arquivo" onclick="negocioBackup.verificarDados();">');
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
