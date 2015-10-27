<?php

/**
 * Arquivo: usuariodao.class.php
 * Criado em: 13/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe tem a função de realizar todas as operações com banco de dados
 *  referentes ao objeto usuário.
 * 
 */

include_once 'conexaodao.class.php';
include_once './dados/usuariomodelo.class.php';
include_once './negocio/criptografianegocio.class.php';
include_once './config/sistema.class.php';

class UsuarioDao{
    private $conexao = null;
    private $numTotalDeRegistros;
    private $criptografia;
    private $prefixoTabela;

    //construtor
    public function __construct() {
        $this->conexao = new ConexaoDao();
        $this->conexao->getConexao();
        $this->numTotalDeRegistros = 0;
        $this->criptografia = new CriptografiaNegocio();
        //prefixos de tabelas
        $sistema = new Sistema();
        $this->prefixoTabela = $sistema->getPrefixoTabelas();
    }
    
    //retorna o numero total de registros de uma tabela
    public function numTotalDeRegistros(){
        return $this->numTotalDeRegistros;
    }

    //inserir usuarios
    public function inserir(UsuarioModelo $usuario) {
        //tratamento de segurança para senhas
        $usuario->setSenha($this->criptografia->criptografar($usuario->getSenha()));
        $sql = "INSERT INTO " . $this->prefixoTabela . "usuarios(nome, senha, tipo, email, telefone) VALUES('" . $usuario->getNome() . "', '" . $usuario->getSenha() . "', '" . $usuario->getTipo() . "', '" . $usuario->getEmail() . "', '" . $usuario->getTelefone() . "');";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //Alterar usuarios
    public function alterar(UsuarioModelo $usuario) {
        //tratamento de segurança para senhas
        $usuario->setSenha($this->criptografia->criptografar($usuario->getSenha()));
        $sql = "UPDATE " . $this->prefixoTabela . "usuarios SET nome='" . $usuario->getNome() . "', senha='" . $usuario->getSenha() . "', tipo='" . $usuario->getTipo() . "', email='" . $usuario->getEmail() . "', telefone='" . $usuario->getTelefone() . "' WHERE id='" . $usuario->getId() . "';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //deletar usuarios
    public function deletar(UsuarioModelo $usuario) {
        $sql = "DELETE FROM " . $this->prefixoTabela . "usuarios WHERE id='" . $usuario->getId() . "'";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //consultar
     public function consultar($pesquisar) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "usuarios WHERE nome LIKE '%" . $pesquisar . "%'";
        $resultado = $this->conexao->consultaDB($sql);
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $usuario = new UsuarioModelo();
            
            $usuario->setId($linha["id"]);
            $usuario->setNome($linha["nome"]);
            //tratamento de segurança para senhas
            $usuario->setSenha($this->criptografia->descriptografar($linha["senha"]));
            $usuario->setTipo($linha["tipo"]);
            $usuario->setEmail($linha["email"]);
            $usuario->setTelefone($linha["telefone"]);
            
            $lista[] = $usuario;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    //atualiza o numero de registros
    private function atualizaNumRegistros($sql){
        $this->dao = new UsuarioDao();
        $result = $this->conexao->consultaDB($sql);
        $this->numTotalDeRegistros = mysql_num_rows($result);
    }
    
    //listar usuarios
    public function listar($numeroPagina, $numDeRegistrosPorPagina) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "usuarios;";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "usuarios ORDER BY id DESC LIMIT ". $numeroPagina . ", " . $numDeRegistrosPorPagina . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        $listaDeUsuarios = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $usuario = new UsuarioModelo();
            
            $usuario->setId($linha["id"]);
            $usuario->setNome($linha["nome"]);
            //tratamento de segurança para senhas
            $usuario->setSenha($this->criptografia->descriptografar($linha["senha"]));
            $usuario->setTipo($linha["tipo"]);
            $usuario->setEmail($linha["email"]);
            $usuario->setTelefone($linha["telefone"]);
            
            $listaDeUsuarios[] = $usuario;
        }
        
        $this->conexao->desconectar();
        return $listaDeUsuarios;
    }
    
    //consulta unica por id
    public function consultaUnicaPorId($id) {
        $this->conexao->getConexao();
        $sql = "SELECT * FROM " . $this->prefixoTabela . "usuarios WHERE id = '" . $id . "';";
        $resultado = $this->conexao->consultaDB($sql);
        
        $linha = mysql_fetch_assoc($resultado);
        
        $usuario = new UsuarioModelo();
            
        $usuario->setId($linha["id"]);
        $usuario->setNome($linha["nome"]);
        //tratamento de segurança para senhas
        $usuario->setSenha($this->criptografia->descriptografar($linha["senha"]));
        $usuario->setTipo($linha["tipo"]);
        $usuario->setEmail($linha["email"]);
        $usuario->setTelefone($linha["telefone"]);

        $this->conexao->desconectar();
        return $usuario;
    }
    
    //verifica se o usuario existe se existir retorna um array
    public function existe(UsuarioModelo $usuarioLogin){
        $sql = "SELECT * FROM " . $this->prefixoTabela . "usuarios WHERE nome = '" . $usuarioLogin->getNome() . "';";
        
        $resultado = $this->conexao->consultaDB($sql);
        
        $minhaLista = array();
        
        while($linha = mysql_fetch_assoc($resultado)){
            $usuario = new UsuarioModelo();
            $usuario->setId($linha["id"]);
            $usuario->setNome($linha["nome"]);
            //tratamento de segurança para senhas
            $usuario->setSenha($this->criptografia->descriptografar($linha["senha"]));
            $usuario->setTipo($linha["tipo"]);
            $usuario->setEmail($linha["email"]);
            $usuario->setTelefone($linha["telefone"]);
            
            //a comparação da senha acontece aqui por causa da criptografia
            if($usuarioLogin->getSenha() == $usuario->getSenha()){
                $minhaLista[] = $usuario;
            }
        }
        $this->conexao->desconectar();
        return $minhaLista;
    }
}
?>