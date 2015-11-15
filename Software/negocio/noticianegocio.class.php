<?php

/**
 * Arquivo: noticianegocio.class.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções que ligam a interface ao banco de dados,
 *  funções estas referentes ao objeto noticia.
 * 
 */

include_once './dao/noticiadao.class.php';
include_once './dados/noticiamodelo.class.php';

class NoticiaNegocio{
    
    //construtor
    public function __construct() {
        $this->dao = new NoticiaDao();
    }
    
    //inserir
    public function inserirNoticia($id, $titulo, $dataNoticia, $linkFoto, $conteudo, $galeria, $publicar, $tags, $idioma) {
        
        $noticia = new NoticiaModelo();
        
        $noticia->setId($id);
        $noticia->setTitulo($titulo);
        $noticia->setDataNoticia($dataNoticia);
        $noticia->setLinkFoto($linkFoto);
        $noticia->setConteudo($conteudo);
        $noticia->setGaleria($galeria);
        $noticia->setPublicar($publicar);
        $noticia->setTags($tags);
        $noticia->setIdioma($idioma);
        
        $dao = new NoticiaDao();
    
        $dao->inserir($noticia);
    }
    
    //Alterar
    public function alterarNoticia($id, $titulo, $dataNoticia, $linkFoto, $conteudo, $galeria, $publicar, $tags, $idioma) {
        $noticia = new NoticiaModelo();
        
        $noticia->setId($id);
        $noticia->setTitulo($titulo);
        $noticia->setDataNoticia($dataNoticia);
        $noticia->setLinkFoto($linkFoto);
        $noticia->setConteudo($conteudo);
        $noticia->setGaleria($galeria);
        $noticia->setPublicar($publicar);
        $noticia->setTags($tags);
        $noticia->setIdioma($idioma);

        $dao = new NoticiaDao();

        $dao->alterar($noticia);
    }
    
    //deletar
    public function deletarNoticia($id) {
        $noticia = new NoticiaModelo();

        $noticia->setId($id);

        $dao = new NoticiaDao();

        $dao->deletar($noticia);
    }
    
    //consultar
    public function consultarNoticia($pesquisa) {
        $dao = new NoticiaDao();
        return $dao->consultar($pesquisa);
    }
    
    public function consultarNoticiaIdioma($pesquisa) {
        $dao = new NoticiaDao();
        return $dao->consultarIdioma($pesquisa);
    }
    
    public function consultarNoticiaPorData($pesquisa, $idioma) {
        $dao = new NoticiaDao();
        return $dao->consultarPorData($pesquisa, $idioma);
    }
    
    //consultar por tags
    public function consultarNoticiaPorTags($tag, $idioma) {
        $dao = new NoticiaDao();
        return $dao->consultarPorTags($tag, $idioma);
    }
    
    //retorna o numero total
    public function getNumTotalDeRegistros(){
        return $this->dao->numTotalDeRegistros();
    }
    
    //consultar todos
    public function listarNoticia($numPaginaAtual, $numDeRegistrosPorPagina, $tag) {
        return $this->dao->listar($numPaginaAtual, $numDeRegistrosPorPagina, $tag);
    }
    
    public function listarNoticiaIdioma($numPaginaAtual, $numDeRegistrosPorPagina, $idioma) {
        return $this->dao->listar($numPaginaAtual, $numDeRegistrosPorPagina, $idioma);
    }
    
    //listar ordenada por data
    public function listarNoticiaOrdenadaPorData($numPaginaAtual, $numDeRegistrosPorPagina) {
        return $this->dao->listarOrdenadoPorData($numPaginaAtual, $numDeRegistrosPorPagina);
    }
    
    public function listarNoticiaOrdenadaPorDataIdioma($numPaginaAtual, $numDeRegistrosPorPagina, $idioma) {
        return $this->dao->listarOrdenadoPorData($numPaginaAtual, $numDeRegistrosPorPagina, $idioma);
    }
    
    //verificar a existencia
    public function verificaSeExiste($id, $idioma) {
        $dao = new NoticiaDao();
        $lista = $dao->consultaUnicaPorId($id, $idioma);
        if(sizeof($lista) >= 1){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //consultar unica
    public function consultarUnicaNoticia($id, $idioma) {
        $dao = new NoticiaDao();
        return $dao->consultaUnicaPorId($id, $idioma);
    }
}
?>