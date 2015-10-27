<?php

/**
 * Arquivo: bannerdao.class.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe tem a função de realizar todas as operações com banco de dados
 *  referentes ao objeto banner.
 * 
 */

include_once 'conexaodao.class.php';
include_once './dados/bannermodelo.class.php';
include_once './config/sistema.class.php';

class BannerDao{
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
    public function inserir(BannerModelo $banner) {
        $sql = "INSERT INTO " . $this->prefixoTabela . "banners(link_site, link_banner) VALUES('". $banner->getLinkSite() ."', '". $banner->getLinkBanner() ."');";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //Alterar
    public function alterar(BannerModelo $banner) {
        $sql = "UPDATE " . $this->prefixoTabela . "banners SET link_site='". $banner->getLinkSite() ."', link_banner='". $banner->getLinkBanner() ."' WHERE id='". $banner->getId() ."';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //deletar
    public function deletar(BannerModelo $banner) {
        $sql = "DELETE FROM " . $this->prefixoTabela . "banners WHERE id='" . $banner->getId() . "'";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //consultar
    public function consultar($pesquisar) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "banners WHERE link_site LIKE '%" . $pesquisar . "%'";
        $resultado = $this->conexao->consultaDB($sql);
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $banner = new BannerModelo();
            
            $banner->setId($linha["id"]);
            $banner->setLinkSite($linha["link_site"]);
            $banner->setLinkBanner($linha["link_banner"]);

            $lista[] = $banner;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    //atualiza o numero de registros
    private function atualizaNumRegistros($sql){
        $this->dao = new BannerDao();
        $result = $this->conexao->consultaDB($sql);
        $this->numTotalDeRegistros = mysql_num_rows($result);
    }
    
    //listar
    public function listar($numeroPagina, $numDeRegistrosPorPagina) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "banners;";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "banners ORDER BY id DESC LIMIT ". $numeroPagina . ", " . $numDeRegistrosPorPagina . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $banner = new BannerModelo();
            
            $banner->setId($linha["id"]);
            $banner->setLinkSite($linha["link_site"]);
            $banner->setLinkBanner($linha["link_banner"]);

            $lista[] = $banner;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    //consulta unica por id
    public function consultaUnicaPorId($id) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "banners WHERE id = " . $id;
        $resultado = $this->conexao->consultaDB($sql);
               
        $linha = mysql_fetch_array($resultado);
        
        $banner = new BannerModelo();
            
        $banner->setId($linha["id"]);
        $banner->setLinkSite($linha["link_site"]);
        $banner->setLinkBanner($linha["link_banner"]);
        
        $this->conexao->desconectar();
        return $banner;
    }
}
?>
