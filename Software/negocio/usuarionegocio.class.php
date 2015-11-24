<?php

/**
 * Arquivo: usuarionegocio.class.php
 * Criado em: 14/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções que ligam a interface ao banco de dados,
 *  funções estas referentes ao objeto usuário.
 * 
 */

include_once './dao/usuariodao.class.php';
include_once './dados/usuariomodelo.class.php';
include_once './coredeadm/config/sistema.class.php';

class UsuarioNegocio{
    private $dao;
    private $Sistema;


    //construtor
    public function __construct() {
        $this->dao = new UsuarioDao();
        $this->Sistema = new Sistema();
    }

    //inserir usuarios
    public function inserirUsuario($nome, $senha, $tipo, $email, $telefone) {
        $usuario = new UsuarioModelo();

        $usuario->setNome($nome);
        $usuario->setSenha($senha);
        $usuario->setTipo($tipo);
        $usuario->setEmail($email);
        $usuario->setTelefone($telefone);

        $this->dao->inserir($usuario);
    }
    
    //Alterar usuarios
    public function alterarUsuario($id, $nome, $senha, $tipo, $email, $telefone) {
        $usuario = new UsuarioModelo();
        
        $usuario->setId($id);
        $usuario->setNome($nome);
        $usuario->setSenha($senha);
        $usuario->setTipo($tipo);
        $usuario->setEmail($email);
        $usuario->setTelefone($telefone);
        
        $this->dao = new UsuarioDao();

        $this->dao->alterar($usuario);
    }
    
    //deletar usuarios
    public function deletarUsuario($id) {
        $usuario = new UsuarioModelo();
        
        $usuario->setId($id);
        
        $this->dao = new UsuarioDao();
        
        $this->dao->deletar($usuario);
    }
    
    //consultar
    public function consultarUsuario($pesquisa) {
        $dao = new UsuarioDao();
        return $dao->consultar($pesquisa);
    }
    
    //retorna o numero total de usuários cadastrados
    public function getNumTotalDeRegistros(){
        return $this->dao->numTotalDeRegistros();
    }
          
    //consultar todos os usuarios
    public function listarUsuarios($numPaginaAtual, $numDeRegistrosPorPagina) {
        return $this->dao->listar($numPaginaAtual, $numDeRegistrosPorPagina);
    }
    
    //consultar todos os usuarios
    public function verificaSeExiste($id) {
        $lista = $this->dao->consultaUnicaPorId($id);
        if(sizeof($lista) >= 1){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //consultar usuarios
    public function consultarUnicoUsuario($id) {
        $this->dao = new UsuarioDao();
        return $this->dao->consultaUnicaPorId($id);
    }
    
    //este metodo retorna a string do tipo de usuario do sistema
    public function tipoUsuario($tipo){
        switch($tipo){
            case 0:
                return "Super Usuário";
            case 1:
                return "Administrador";
            case 2:
                return "Membro";
            default:
                return "Membro";
        }
    }
    
    //iniciar uma sessão
    public function iniciarSessao(){
        //define o id da sessão para não ter conflito
        session_name($this->Sistema->getNomeSessaoDeUsuario());
        //inicia a sessão
        session_start();
    }

    //esse metodo realiza o login
    public function login($nome, $senha){
        $usuario = new UsuarioModelo();
        
        $usuario->setNome($nome);
        $usuario->setSenha($senha);
        
        $listaUsuarios = $this->dao->existe($usuario);
        
        if($listaUsuarios != NULL){
            //armazena temporariamente os dados do usuario logado
            //isso com variaveis de sessão 
            $this->iniciarSessao();
            $_SESSION[$this->Sistema->getNomeSessaoDeUsuario()] = $listaUsuarios[0];
            //bloqueia os dados da sessão
            session_write_close();
            return true;
        }
        return false;
    }
    
    //retorna o usuário logado
    public function getUsuarioLogado(){
        return $_SESSION[$this->Sistema->getNomeSessaoDeUsuario()];
    }
     
    //pega o nome do usuário logado
    public function getNomeUsuarioLogado(){
        $usuario = $_SESSION[$this->Sistema->getNomeSessaoDeUsuario()];
        return $usuario->getNome();
    }
    
    //pega o id do usuário logado
    public function getIdUsuarioLogado(){
        $usuario = $_SESSION[$this->Sistema->getNomeSessaoDeUsuario()];
        return $usuario->getId();
    }

    //pega o nome do usuário logado
    public function getTipoUsuarioLogado(){
        $usuario = $_SESSION[$this->Sistema->getNomeSessaoDeUsuario()];
        return $usuario->getTipo();
    }

    //verifica se temos uma sessão de usuario
    public function verificaSeHaUsuarioLogado(){
        if(isset($_SESSION[$this->Sistema->getNomeSessaoDeUsuario()])){
            return true;
        }
        return false;
    }
    
    //obtem permissao de acesso
    public function getPermissao($permissao){
        if(!($this->getTipoUsuarioLogado() <= $permissao)){
            header("LOCATION: " . $this->Sistema->getPaginaDePermissaoNegada());
        }
    }
    
    //seta as permissoes de acesso para determinados eventos que ocorram com a página
    //setar -1 onde não houver determinada ação
    //setar as permissoes de acesso devidamente relacionadas aos tipos de usuario
    public function setPermissoes($normal, $editar, $excluir){
        if(isset($_GET["excluir"])){
            if(!($this->getTipoUsuarioLogado() <= $excluir)){
                header("LOCATION: " . $this->Sistema->getPaginaDePermissaoNegada());
            }
        }
        if(isset($_GET["editar"])){
            if(!($this->getTipoUsuarioLogado() <= $editar)){
                header("LOCATION: " . $this->Sistema->getPaginaDePermissaoNegada());
            }
        }
        else {
            if(!($this->getTipoUsuarioLogado() <= $normal)){
                header("LOCATION: " . $this->Sistema->getPaginaDePermissaoNegada());
            }
        }
    }

    //obtem permissao para exibir um elemento de pagina
    //não acessamos diretamante cookies aqui porque senão temos erros de headers
    //porque está função é utilizada geralmente dentro de <body></body>
    public function getPermissaoElemento($tipoUsuarioLogado, $permissao){
        if($tipoUsuarioLogado <= $permissao){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    //sair do sistema
    public function sair(){
        unset($_SESSION[$this->Sistema->getNomeSessaoDeUsuario()]);
        session_destroy();
    }
}
?>