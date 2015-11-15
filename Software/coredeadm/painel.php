<?php
/**
 * Arquivo: painel.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface e a tela inicial do sistema após o login.
 * 
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';
$usuarioNegocio->setPermissoes(2, -1, -1);

//define o titulo da página
$tituloPainel = "Painel";

//inclui o header do sistema
include_once './ui/header.interface.php';
?>

<div class="painelHome">
    
</div>

<?php
//inclui o footer do sistema
include_once './ui/footer.interface.php';
?>
