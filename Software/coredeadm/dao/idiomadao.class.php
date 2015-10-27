<?php

/**
 * Arquivo: idiomadao.class.php
 * Criado em: 22/09/2015
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe tem a função de realizar todas as operações com banco de dados
 *  referentes ao objeto idioma.
 * 
 */

include_once 'conexaodao.class.php';
include_once './dados/idiomamodelo.class.php';
include_once './config/sistema.class.php';

class IdiomaDao{
    private $conexao = null;
    private $numTotalDeRegistros;
    private $prefixoTabela;

    //construtor
    public function __construct() {
        $this->conexao = new ConexaoDao();
        $this->conexao->getConexao();
        //prefixos de tabelas
        $sistema = new Sistema();
        $this->prefixoTabela = $sistema->getPrefixoTabelas();
    }
    
    //retorna o numero total de registros de uma tabela
    public function numTotalDeRegistros(){
        return $this->numTotalDeRegistros;
    }
    
    //inserir
    public function inserir(IdiomaModelo $idioma) {
        $sql = "INSERT INTO " . $this->prefixoTabela . "idioma(idioma) VALUES('". $idioma->getIdioma() ."');";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //Alterar
    public function alterar(IdiomaModelo $idioma) {
        $sql = "UPDATE " . $this->prefixoTabela . "idioma SET idioma='". $idioma->getIdioma() ."' WHERE id='". $idioma->getId() ."';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //deletar
    public function deletar(IdiomaModelo $idioma) {
        $sql = "DELETE FROM " . $this->prefixoTabela . "idioma WHERE id='" . $idioma->getId() . "'";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //consultar
    public function consultar($pesquisar) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "idioma WHERE idioma LIKE '%" . $pesquisar . "%'";
        $resultado = $this->conexao->consultaDB($sql);
        
        $listaDeIdiomas = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $i = new IdiomaModelo();
            
            $i->setId($linha["id"]);
            $i->setIdioma($linha["idioma"]);
            
            $listaDeIdiomas[] = $i;
        }
        
        $this->conexao->desconectar();
        return $listaDeIdiomas;
    }
    
    //atualiza o numero de registros
    private function atualizaNumRegistros($sql){
        $this->dao = new IdiomaDao();
        $result = $this->conexao->consultaDB($sql);
        $this->numTotalDeRegistros = mysql_num_rows($result);
    }
    
    //listar
    public function listar($numeroIdioma, $numDeRegistrosPorIdioma) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "idioma;";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "idioma ORDER BY id DESC LIMIT ". $numeroIdioma . ", " . $numDeRegistrosPorIdioma . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        
        $listaDeIdiomas = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $idioma = new IdiomaModelo();
            
            $idioma->setId($linha["id"]);
            $idioma->setIdioma($linha["idioma"]);
            
            $listaDeIdiomas[] = $idioma;
        }
        
        $this->conexao->desconectar();
        return $listaDeIdiomas;
    }
    
    //consulta unica por id
    public function consultaUnicaPorId($id) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "idioma WHERE id = " . $id;
        $resultado = $this->conexao->consultaDB($sql);
               
        $linha = mysql_fetch_array($resultado);
        
        $idioma = new IdiomaModelo();
        
        $idioma->setId($linha["id"]);
        $idioma->setIdioma($linha["idioma"]);
        
        $this->conexao->desconectar();
        return $idioma;
    }
}
?>