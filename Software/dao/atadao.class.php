<?php

include_once 'conexaodao.class.php';
include_once './dados/atamodelo.class.php';
include_once './coredeadm/config/sistema.class.php';

class AtaDao{
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
    public function inserir(AtaModelo $ata) {
        $sql = "INSERT INTO " . $this->prefixoTabela . "atas(descricao, data, ata) VALUES('". $ata->getDescricao() ."', '". $ata->getData() ."', '". $ata->getAta() ."');";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //Alterar
    public function alterar(AtaModelo $ata) {
        $sql = "UPDATE " . $this->prefixoTabela . "atas SET descricao='". $ata->getDescricao() ."', data='". $ata->getAta() ."' WHERE id='". $ata->getId() ."';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //deletar
    public function deletar(AtaModelo $ata) {
        $sql = "DELETE FROM " . $this->prefixoTabela . "atas WHERE id='" . $ata->getId() . "'";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //consultar
    public function consultar($pesquisar) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "atas WHERE descricao LIKE '%" . $pesquisar . "%'";
        $resultado = $this->conexao->consultaDB($sql);
        
        $listaDeAtas = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $ata = new AtaModelo();
            
            $ata->setId($linha["id"]);
            $ata->setDescricao($linha["descricao"]);
            $ata->setData($linha["data"]);
            $ata->setAta($linha["ata"]);
            
            $listaDeAtas[] = $ata;
        }
        
        $this->conexao->desconectar();
        return $listaDeAtas;
    }
    
    //atualiza o numero de registros
    private function atualizaNumRegistros($sql){
        $this->dao = new AtaDao();
        $result = $this->conexao->consultaDB($sql);
        $this->numTotalDeRegistros = mysql_num_rows($result);
    }
    
    //listar
    public function listar($numeroAta, $numDeRegistrosPorAta) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "atas;";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "atas ORDER BY id DESC LIMIT ". $numeroAta . ", " . $numDeRegistrosPorAta . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        
        $listaDeAtas = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $ata = new AtaModelo();
            
            $ata->setId($linha["id"]);
            $ata->setDescricao($linha["descricao"]);
            $ata->setData($linha["data"]);
            $ata->setAta($linha["ata"]);
            
            $listaDeAtas[] = $ata;
        }
        
        $this->conexao->desconectar();
        return $listaDeAtas;
    }
    
    //consulta unica por id
    public function consultaUnicaPorId($id) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "atas WHERE id = '" . $id . "';";
        $resultado = $this->conexao->consultaDB($sql);
               
        $linha = mysql_fetch_array($resultado);
        
        $ata = new AtaModelo();
            
        $ata->setId($linha["id"]);
        $ata->setDescricao($linha["descricao"]);
        $ata->setData($linha["data"]);
        $ata->setAta($linha["ata"]);
        
        $this->conexao->desconectar();
        return $ata;
    }
}
?>