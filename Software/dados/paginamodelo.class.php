<?php

/**
 * Arquivo: paginamodelo.class.php
 * Criado em: 25/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe representa o objeto página.
 * 
 */

class PaginaModelo{
    private $id;
    private $titulo;
    private $tags;
    private $conteudo;
    private $idioma;
    
    function getIdioma() {
        return $this->idioma;
    }

    function setIdioma($idioma) {
        $this->idioma = $idioma;
    }
    
    //setters
    public function setId($id){
        $this->id = $id;
    }
    
    public function setTitulo($string){
        $this->titulo = $string;
    }
    
    public function setConteudo($string){
        $this->conteudo = $string;
    }
    public function setTags($tags) {
        $this->tags = $tags;
    }

        
    //getters
    public function getId(){
        return $this->id;
    }
    
    public function getTitulo(){
        return $this->titulo;
    }
    
    public function getConteudo(){
        return $this->conteudo;
    }
    
    public function getTags() {
        return $this->tags;
    }
}
?>