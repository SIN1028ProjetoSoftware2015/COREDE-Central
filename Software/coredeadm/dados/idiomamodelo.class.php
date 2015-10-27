<?php

/**
 * Arquivo: idiomamodelo.class.php
 * Criado em: 22/09/2015
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe representa o objeto idioma.
 * 
 */

class IdiomaModelo{
    private $id;
    private $idioma;
    
    function getId() {
        return $this->id;
    }

    function getIdioma() {
        return $this->idioma;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdioma($idioma) {
        $this->idioma = $idioma;
    }
}
?>