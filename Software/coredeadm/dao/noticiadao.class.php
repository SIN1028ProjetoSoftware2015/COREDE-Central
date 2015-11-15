<?php

/**
 * Arquivo: noticiadao.class.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe tem a função de realizar todas as operações com banco de dados
 *  referentes ao objeto noticia.
 * 
 */

include_once 'conexaodao.class.php';
include_once './dados/noticiamodelo.class.php';
include_once './config/sistema.class.php';

class NoticiaDao{
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
    public function inserir(NoticiaModelo $noticia) {
        $sql = "INSERT INTO " . $this->prefixoTabela . "noticias(id, titulo, data_noticia, link_foto, conteudo, galeria, publicar, tags, idioma) VALUES('". $noticia->getId() ."', '". $noticia->getTitulo() ."', '". $noticia->getDataNoticia() ."', '". $noticia->getLinkFoto() ."', '". $noticia->getConteudo() ."', '". $noticia->getGaleria() ."', '". $noticia->getPublicar() ."', '". $noticia->getTags() ."', '". $noticia->getIdioma() ."');";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //Alterar
    public function alterar(NoticiaModelo $noticia) {
        $sql = "UPDATE " . $this->prefixoTabela . "noticias SET titulo='". $noticia->getTitulo() ."', data_noticia='". $noticia->getDataNoticia() ."', link_foto='". $noticia->getLinkFoto() ."', conteudo='". $noticia->getConteudo() ."', galeria='". $noticia->getGaleria() ."', publicar='". $noticia->getPublicar() ."', tags='". $noticia->getTags() ."' WHERE id='". $noticia->getId() ."' AND idioma='". $noticia->getIdioma() ."';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //deletar
    public function deletar(NoticiaModelo $noticia) {
        $sql = "DELETE FROM " . $this->prefixoTabela . "noticias WHERE id='" . $noticia->getId() . "';";
        $this->conexao->consultaDB($sql);
        $this->conexao->desconectar();
    }
    
    //consultar
    public function consultar($pesquisar) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE titulo LIKE '%" . $pesquisar . "%'";
        $resultado = $this->conexao->consultaDB($sql);
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $noticia = new NoticiaModelo();
            
            $noticia->setId($linha["id"]);
            $noticia->setTitulo($linha["titulo"]);
            $noticia->setDataNoticia($linha["data_noticia"]);
            $noticia->setLinkFoto($linha["link_foto"]);
            $noticia->setConteudo($linha["conteudo"]);
            $noticia->setGaleria($linha["galeria"]);
            $noticia->setPublicar($linha["publicar"]);
            $noticia->setTags($linha["tags"]);
            $noticia->setIdioma($linha["idioma"]);

            $lista[] = $noticia;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    public function consultarIdioma($pesquisar, $idioma) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE titulo LIKE '%" . $pesquisar . "%' AND idioma='".$idioma."';";
        $resultado = $this->conexao->consultaDB($sql);
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $noticia = new NoticiaModelo();
            
            $noticia->setId($linha["id"]);
            $noticia->setTitulo($linha["titulo"]);
            $noticia->setDataNoticia($linha["data_noticia"]);
            $noticia->setLinkFoto($linha["link_foto"]);
            $noticia->setConteudo($linha["conteudo"]);
            $noticia->setGaleria($linha["galeria"]);
            $noticia->setPublicar($linha["publicar"]);
            $noticia->setTags($linha["tags"]);
            $noticia->setIdioma($linha["idioma"]);

            $lista[] = $noticia;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    public function consultarPorData($pesquisar, $idioma) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE idioma='".$idioma."' ORDER BY STR_TO_DATE(data_noticia,'%d/%m/%Y') DESC;";
        $resultado = $this->conexao->consultaDB($sql);
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $noticia = new NoticiaModelo();
            
            $noticia->setId($linha["id"]);
            $noticia->setTitulo($linha["titulo"]);
            $noticia->setDataNoticia($linha["data_noticia"]);
            $noticia->setLinkFoto($linha["link_foto"]);
            $noticia->setConteudo($linha["conteudo"]);
            $noticia->setGaleria($linha["galeria"]);
            $noticia->setPublicar($linha["publicar"]);
            $noticia->setTags($linha["tags"]);
            $noticia->setIdioma($linha["idioma"]);

            $lista[] = $noticia;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    //consultar tags
    public function consultarPorTags($tag, $idioma) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE tags LIKE '%" . $tag . "%' AND idioma='".$idioma."';";
        $resultado = $this->conexao->consultaDB($sql);
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $noticia = new NoticiaModelo();
            
            $noticia->setId($linha["id"]);
            $noticia->setTitulo($linha["titulo"]);
            $noticia->setDataNoticia($linha["data_noticia"]);
            $noticia->setLinkFoto($linha["link_foto"]);
            $noticia->setConteudo($linha["conteudo"]);
            $noticia->setGaleria($linha["galeria"]);
            $noticia->setPublicar($linha["publicar"]);
            $noticia->setTags($linha["tags"]);
            $noticia->setIdioma($linha["idioma"]);

            $lista[] = $noticia;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    //atualiza o numero de registros
    private function atualizaNumRegistros($sql){
        $this->dao = new NoticiaDao();
        $result = $this->conexao->consultaDB($sql);
        $this->numTotalDeRegistros = mysql_num_rows($result);
    }
    
    //listar
    public function listar($numeroPagina, $numDeRegistrosPorPagina) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "noticias;";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias ORDER BY id DESC LIMIT ". $numeroPagina . ", " . $numDeRegistrosPorPagina . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $noticia = new NoticiaModelo();
            
            $noticia->setId($linha["id"]);
            $noticia->setTitulo($linha["titulo"]);
            $noticia->setDataNoticia($linha["data_noticia"]);
            $noticia->setLinkFoto($linha["link_foto"]);
            $noticia->setConteudo($linha["conteudo"]);
            $noticia->setGaleria($linha["galeria"]);
            $noticia->setPublicar($linha["publicar"]);
            $noticia->setTags($linha["tags"]);
            $noticia->setIdioma($linha["idioma"]);

            $lista[] = $noticia;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    public function listarIdioma($numeroPagina, $numDeRegistrosPorPagina, $idioma) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE idioma='".$idioma."';";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE idioma='".$idioma."' ORDER BY id DESC LIMIT ". $numeroPagina . ", " . $numDeRegistrosPorPagina . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $noticia = new NoticiaModelo();
            
            $noticia->setId($linha["id"]);
            $noticia->setTitulo($linha["titulo"]);
            $noticia->setDataNoticia($linha["data_noticia"]);
            $noticia->setLinkFoto($linha["link_foto"]);
            $noticia->setConteudo($linha["conteudo"]);
            $noticia->setGaleria($linha["galeria"]);
            $noticia->setPublicar($linha["publicar"]);
            $noticia->setTags($linha["tags"]);
            $noticia->setIdioma($linha["idioma"]);

            $lista[] = $noticia;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    public function listarOrdenadoPorData($numeroPagina, $numDeRegistrosPorPagina) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "noticias;";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias ORDER BY STR_TO_DATE(data_noticia,'%d/%m/%Y') DESC LIMIT ". $numeroPagina . ", " . $numDeRegistrosPorPagina . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $noticia = new NoticiaModelo();
            
            $noticia->setId($linha["id"]);
            $noticia->setTitulo($linha["titulo"]);
            $noticia->setDataNoticia($linha["data_noticia"]);
            $noticia->setLinkFoto($linha["link_foto"]);
            $noticia->setConteudo($linha["conteudo"]);
            $noticia->setGaleria($linha["galeria"]);
            $noticia->setPublicar($linha["publicar"]);
            $noticia->setTags($linha["tags"]);
            $noticia->setIdioma($linha["idioma"]);

            $lista[] = $noticia;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    public function listarOrdenadoPorDataIdioma($numeroPagina, $numDeRegistrosPorPagina, $idioma) {
        $sqlCalculo = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE idioma='".$idioma."';";
        $this->atualizaNumRegistros($sqlCalculo);
        
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE idioma='".$idioma."' ORDER BY STR_TO_DATE(data_noticia,'%d/%m/%Y') DESC LIMIT ". $numeroPagina . ", " . $numDeRegistrosPorPagina . ";";
        $resultado = $this->conexao->consultaDB($sql);
        
        
        $lista = array();
               
        while ($linha = mysql_fetch_array($resultado)) {
            $noticia = new NoticiaModelo();
            
            $noticia->setId($linha["id"]);
            $noticia->setTitulo($linha["titulo"]);
            $noticia->setDataNoticia($linha["data_noticia"]);
            $noticia->setLinkFoto($linha["link_foto"]);
            $noticia->setConteudo($linha["conteudo"]);
            $noticia->setGaleria($linha["galeria"]);
            $noticia->setPublicar($linha["publicar"]);
            $noticia->setTags($linha["tags"]);
            $noticia->setIdioma($linha["idioma"]);

            $lista[] = $noticia;
        }
        
        $this->conexao->desconectar();
        return $lista;
    }
    
    //consulta unica por id
    public function consultaUnicaPorId($id, $idioma) {
        $sql = "SELECT * FROM " . $this->prefixoTabela . "noticias WHERE id = '" . $id . "' AND idioma='".$idioma."';";
        $resultado = $this->conexao->consultaDB($sql);
               
        $linha = mysql_fetch_array($resultado);
        
        $noticia = new NoticiaModelo();
            
        $noticia->setId($linha["id"]);
        $noticia->setTitulo($linha["titulo"]);
        $noticia->setDataNoticia($linha["data_noticia"]);
        $noticia->setLinkFoto($linha["link_foto"]);
        $noticia->setConteudo($linha["conteudo"]);
        $noticia->setGaleria($linha["galeria"]);
        $noticia->setPublicar($linha["publicar"]);
        $noticia->setTags($linha["tags"]);
        $noticia->setIdioma($linha["idioma"]);
        
        $this->conexao->desconectar();
        return $noticia;
    }
}
?>
