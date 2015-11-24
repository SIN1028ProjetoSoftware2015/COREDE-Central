<?php
/**
 * Arquivo: seguranca.interface.php
 * Criado em: 12/02/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface refere-se a segurança do sistema.
 * 
 */

//inclui as classes
include_once './negocio/usuarionegocio.class.php';
include_once './coredeadm/config/sistema.class.php';

//cria os objetos
$usuarioNegocio = new UsuarioNegocio();
$sistema = new Sistema();

//inicia a sessão de usuário no sistema 
$usuarioNegocio->iniciarSessao();

//se o usuário sair do sistema
if(isset($_GET["sair"])){
    $usuarioNegocio->sair();
}

//direciona ao login se não houver usuario logado
if($usuarioNegocio->verificaSeHaUsuarioLogado() == FALSE){
    $usuarioLogado = null;
}
else{
    $usuarioLogado = $usuarioNegocio->getUsuarioLogado();
}
?>