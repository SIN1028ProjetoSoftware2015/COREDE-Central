<?php

/**
 * Arquivo: noticiamodelo.class.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe representa o objeto notícia.
 * 
 */

class NoticiaModelo{
    private $id;
    private $titulo;
    private $dataNoticia;
    private $linkFoto;
    private $conteudo;
    private $galeria;
    private $publicar;
    private $tags;
    private $idioma;
    
    function getIdioma() {
        return $this->idioma;
    }

    function setIdioma($idioma) {
        $this->idioma = $idioma;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDataNoticia() {
        return $this->dataNoticia;
    }

    public function getLinkFoto() {
        return $this->linkFoto;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

    public function getGaleria() {
        return $this->galeria;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDataNoticia($dataNoticia) {
        $this->dataNoticia = $dataNoticia;
    }

    public function setLinkFoto($linkFoto) {
        $this->linkFoto = $linkFoto;
    }

    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function setGaleria($galeria) {
        $this->galeria = $galeria;
    }
    
    public function getPublicar() {
        return $this->publicar;
    }

    public function setPublicar($publicar) {
        $this->publicar = $publicar;
    }

    function getTags() {
        return $this->tags;
    }

    function setTags($tags) {
        $this->tags = $tags;
    }
    
}
?>