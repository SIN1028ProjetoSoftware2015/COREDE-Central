<?php
/**
 * Arquivo: backup.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de backup do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, -1, 1);

//includes
include_once './negocio/backupnegocio.class.php';
include_once './negocio/arquivonegocio.class.php';
include_once './negocio/interfacenegocio.class.php';

//objetos
$backupNegocio = new BackupNegocio();
$arquivoNegocio = new ArquivoNegocio();
$interfaceNegocio = new InterfaceNegocio();

//se tiver solicitação de backup
if(isset($_GET["backup"])){    
    if($backupNegocio->gerarBackup()){
        $interfaceNegocio->setMensagemDeAlerta("Backup criado com sucesso!");
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Erro ao criar o backup!");
    }
}

//se tiver solicitação de exclusao de backup
if(isset($_GET["excluir"])){    
    if($arquivoNegocio->deletar($backupNegocio->getNomePastaDeBackups().$_GET["excluir"])){
        $interfaceNegocio->setMensagemDeAlerta("Backup excluido com sucesso!");
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Erro ao excluir o backup!");
    }
}

//criar a tabela de arquivos
$linhasDaTabela = "";
$pasta = $arquivoNegocio->abrirPasta($backupNegocio->getNomePastaDeBackups());
$contArquivos = 0;
while($arquivo = $arquivoNegocio->lerPasta($pasta)){
    //se for arquivo de backup
    $ext = ".".$arquivoNegocio->getExtensao($arquivo);
    
    if(($ext == $backupNegocio->getExtensaoDosBackups()) && ($arquivo != ".") && ($arquivo != "..")){
        $linhasDaTabela = $linhasDaTabela . '
            <tr>
                <td>'.
                    $arquivo
                .'</td>
                <td>'.
                    $arquivoNegocio->getTamanho($backupNegocio->getNomePastaDeBackups().$arquivo)
                .'</td>
                <td>
                    <label>
                        <a href="#" title="Excluir"><div onclick="negocioBackup.excluir(\''.$arquivo.'\');" class="excluir"></div></a>
                        <a href="download.php?pasta=' . $backupNegocio->getNomePastaDeBackups() . "&arquivo=" . $arquivo . '" title="Download"><div class="download"></div></a>
                    </label>
                </td>
            </tr>  
        ';
        $contArquivos++;
    }
}
if($contArquivos > 10){
    $interfaceNegocio->setMensagemDeAlerta("Um arquivo de backup ocupa espaço no servidor, como temos mais de 10 backups salvos é totalmente recomendado apagar os mais antigos. Mas atenção a data do backup se encontra no nome do arquivo de backup!");
}
if($contArquivos == 0){
    $interfaceNegocio->setMensagemDeAlerta("Não foram encontrados arquivos de backup. Clique no botão 'Gerar Backup!' para fazer uma cópia de segurança do banco de dados!");
}

//define o titulo da página
$tituloPainel = "Backup do bando de dados";

//inclui o header
include_once './ui/header.interface.php';
?>
<script type="text/javascript" src="js/backup.js"></script>
<table id="tabela" class="tabelaDeVisualizacao">
    <tr>
        <th>backup _ hora _ data <?php echo $backupNegocio->getExtensaoDosBackups();?></th>
        <th style="width: 10%">Tamanho</th>
        <th style="width: 10%">Ações</th>
    </tr>
    <?php echo $linhasDaTabela;?>
</table>
<?php
//inclui os botoes
$interfaceNegocio->setFooterButtons('<a href="backup.php?backup=true">Gerar Backup!</a>');
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
