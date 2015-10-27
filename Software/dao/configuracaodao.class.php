<?php

/**
 * Arquivo: configuracaodao.class.php
 * Criado em: 22/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe tem a função de realizar todas as operações com banco de dados
 *  referentes ao objeto configuracao.
 * 
 */

include_once 'conexaodao.class.php';
include_once './dados/configuracaomodelo.class.php';
include_once './saiadm/config/sistema.class.php';

class ConfiguracaoDao{
    private $conexao = null;
    private $prefixoTabela;

    //construtor
    public function __construct() {
        $this->conexao = new ConexaoDao();
        $this->conexao->getConexao();
        //prefixos de tabelas
        $sistema = new Sistema();
        $this->prefixoTabela = $sistema->getPrefixoTabelas();
    }
    
    //inserir
    public function inserir(ConfiguracaoModelo $configuracao) {
        $sql = "INSERT INTO " . $this->prefixoTabela . "configuracoes(descricao, valor) VALUES('" . $configuracao->getDescricao() . "', '" . $configuracao->getValor() . "');";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //Alterar
    public function alterar(ConfiguracaoModelo $configuracao) {
        $sql = "UPDATE " . $this->prefixoTabela . "configuracoes SET valor='" . $configuracao->getValor() . "' WHERE descricao='" . $configuracao->getDescricao() . "';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //deletar usuarios
    public function deletar(ConfiguracaoModelo $configuracao) {
        $sql = "DELETE * FROM " . $this->prefixoTabela . "configuracoes WHERE descricao='" . $configuracao->getDescricao() . "';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //consultar usuarios
    public function consultar($pesquisar) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "configuracoes WHERE descricao LIKE '%" . $pesquisar . "%';";
        $resultado = $this->conexao->consultaDB($sql);
        
        $listaDeConfiguracoes = array();
               
        while ($linha = mysql_fetch_assoc($resultado)) {
            $configuracao = new ConfiguracaoModelo();
            
            $configuracao->setId($linha["id"]);
            $configuracao->setDescricao($linha["descricao"]);
            $configuracao->setValor($linha["valor"]);
            
            $listaDeConfiguracoes[] = $configuracao;
        }
        
        $this->conexao->desconectar();
        return $listaDeConfiguracoes;
    }
}
?>