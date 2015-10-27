<?php

/**
 * Arquivo: paginadao.class.php
 * Criado em: 25/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe tem a função de realizar todas as operações com banco de dados
 *  referentes ao objeto página.
 * 
 */

include_once 'conexaodao.class.php';
include_once './dados/paginamodelo.class.php';
include_once './config/sistema.class.php';

class PaginaDao{
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
    public function inserir(PaginaModelo $pagina) {
        $sql = "INSERT INTO " . $this->prefixoTabela . "paginas(id, titulo, conteudo, tags, idioma) VALUES('". $pagina->getId() ."', '". $pagina->getTitulo() ."', '". $pagina->getConteudo() ."', '". $pagina->getTags() ."', '". $pagina->getIdioma() ."');";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //Alterar
    public function alterar(PaginaModelo $pagina) {
        $sql = "UPDATE " . $this->prefixoTabela . "paginas SET titulo='". $pagina->getTitulo() ."', conteudo='". $pagina->getConteudo() ."', tags='". $pagina->getTags() ."' WHERE id='". $pagina->getId() ."' AND idioma = '".$pagina->getIdioma()."';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //deletar
    public function deletar(PaginaModelo $pagina) {
        $sql = "DELETE FROM " . $this->prefixoTabela . "paginas WHERE id='" . $pagina->getId() . "'";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //consultar
    public function consultar($pesquisar) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "paginas WHERE titulo LIKE '%" . $pesquisar . "%'";
        $resultado = $this->conexao->consultaDB($sql);
        
        $listaDePaginas = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $pagina = new PaginaModelo();
            
            $pagina->setId($linha["id"]);
            $pagina->setTags($linha["tags"]);
            $pagina->setTitulo($linha["titulo"]);
            $pagina->setConteudo($linha["conteudo"]);
            $pagina->setIdioma($linha["idioma"]);
            
            $listaDePaginas[] = $pagina;
        }
        
        $this->conexao->desconectar();
        return $listaDePaginas;
    }
    
    //consultar por tags
    public function consultarPorTags($pesquisarTags) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "paginas WHERE tags LIKE '%" . $pesquisarTags . "%'";
        $resultado = $this->conexao->consultaDB($sql);
        
        $listaDePaginas = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $pagina = new PaginaModelo();
            
            $pagina->setId($linha["id"]);
            $pagina->setTags($linha["tags"]);
            $pagina->setTitulo($linha["titulo"]);
            $pagina->setConteudo($linha["conteudo"]);
            $pagina->setIdioma($linha["idioma"]);
            
            $listaDePaginas[] = $pagina;
        }
        
        $this->conexao->desconectar();
        return $listaDePaginas;
    }
    
    //atualiza o numero de registros
    private function atualizaNumRegistros($sql){
        $this->dao = new PaginaDao();
        $result = $this->conexao->consultaDB($sql);
        $this->numTotalDeRegistros = mysql_num_rows($result);
    }
    
    //listar
    public function listar($numeroPagina, $numDeRegistrosPorPagina) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "paginas;";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "paginas ORDER BY id DESC LIMIT ". $numeroPagina . ", " . $numDeRegistrosPorPagina . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        
        $listaDePaginas = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $pagina = new PaginaModelo();
            
            $pagina->setId($linha["id"]);
            $pagina->setTags($linha["tags"]);
            $pagina->setTitulo($linha["titulo"]);
            $pagina->setConteudo($linha["conteudo"]);
            $pagina->setIdioma($linha["idioma"]);
            
            $listaDePaginas[] = $pagina;
        }
        
        $this->conexao->desconectar();
        return $listaDePaginas;
    }
    
    //consulta unica por id
    public function consultaUnicaPorId($id, $idioma) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "paginas WHERE id = '" . $id . "' AND idioma = '" . $idioma ."';";
        $resultado = $this->conexao->consultaDB($sql);
               
        $linha = mysql_fetch_array($resultado);
        
        $pagina = new PaginaModelo();
            
        $pagina->setId($linha["id"]);
        $pagina->setTags($linha["tags"]);
        $pagina->setTitulo($linha["titulo"]);
        $pagina->setConteudo($linha["conteudo"]);
        $pagina->setIdioma($linha["idioma"]);
        
        $this->conexao->desconectar();
        return $pagina;
    }
}
?>