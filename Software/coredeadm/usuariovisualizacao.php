<?php
/**
 * Arquivo: usuariovisualizacao.php
 * Criado em: 24/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de visualização de usuário do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(1, -1, 1);

//inclui as classes
include_once './negocio/usuarionegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';
include_once './negocio/interfacenegocio.class.php';

//cria os objetos
$configuracaoNegocio = new ConfiguracaoNegocio();
$usuarioNegocio = new UsuarioNegocio();
$interfaceNegocio = new InterfaceNegocio();

//se um usuario for excluído
if(isset($_GET["excluir"])){
    if($usuarioNegocio->verificaSeExiste($_GET["excluir"])){
        $usuarioNegocio->deletarUsuario($_GET["excluir"]);
        $interfaceNegocio->setMensagemDeAlerta("Usuário deletado com sucesso!");
    }
    else{
        $interfaceNegocio->setMensagemDeAlerta("Usuário não encontrado!");
    }
}

//obtem a lista de usuarios
if(isset($_POST["busca"])){
    $listaDeUsuarios = $usuarioNegocio->consultarUsuario($_POST["busca"]);
}
else{
    $listaDeUsuarios = $usuarioNegocio->listarUsuarios($interfaceNegocio->getNumeroPaginaAtual(), $configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"));
}

$linhasDaTabela = "";

for($i = 0; $i < sizeof($listaDeUsuarios); $i++){
    //não irá exibir super usuários a adm e operador
    if($listaDeUsuarios[$i]->getTipo() != 0 || $usuarioNegocio->getPermissaoElemento($usuarioLogado->getTipo(), 0)){
        $linhasDaTabela = $linhasDaTabela . '
            <tr>
                <td><a href="usuarioform.php?editar=' . $listaDeUsuarios[$i]->getId() . '" title="Editar">'.
                    $listaDeUsuarios[$i]->getNome()
                .'</a></td>
                <td>'.
                    $listaDeUsuarios[$i]->getEmail()
                .'</td>
                <td>'.
                    $usuarioNegocio->tipoUsuario($listaDeUsuarios[$i]->getTipo())
                .'</td>
                <td>
                    <label>
                        <a href="usuarioform.php?editar=' . $listaDeUsuarios[$i]->getId() . '" title="Editar"><div class="editar"></div></a>
                        <a href="#" title="Excluir"><div onclick="negocioCadastro.excluir(\''.$listaDeUsuarios[$i]->getId().'\');" class="excluir"></div></a>
                    </label>
                </td>
            </tr>  
        ';
    }
}

//define o titulo da página
$tituloPainel = "Usuários";

//inclui o header
include_once './ui/header.interface.php';

?>
<script type="text/javascript" src="js/usuario.js"></script>
<form class="campodebusca" action="usuariovisualizacao.php" method="post">
    <input type="text" name="busca" class="campodetexto">
    <input type="submit" value="buscar" class="btn">
</form>
<table id="tabela" class="tabelaDeVisualizacao">
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Tipo</th>
        <th style="width: 10%">Ações</th>
    </tr>
    <?php echo $linhasDaTabela;?>
</table>
<?php
//inclui a barra de navegação
$interfaceNegocio->getBarraDePaginacao($configuracaoNegocio->carregarValorDaConfiguracao("numeroDeItensPorPaginaPainel"), $usuarioNegocio->getNumTotalDeRegistros(), "usuariovisualizacao.php");
//inclui os botoes
$interfaceNegocio->setFooterButtons('<a href="usuarioform.php">Cadastrar um novo usuário</a>');
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
