<?php
/**
 * Arquivo: permissaonegada.php
 * Criado em: 26/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela de permissão negada do sistema.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(2, 2, 2);

//define o titulo da página
$tituloPainel = "Permissão negada";

//inclui o header do sistema
include_once './ui/header.interface.php';
?>

<div class="permissaoNegada">
</div>

<?php
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
