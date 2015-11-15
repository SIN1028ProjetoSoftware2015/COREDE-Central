<?php

/**
 * Arquivo: configuracaomodelo.class.php
 * Criado em: 22/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe representa o objeto configuração.
 * 
 */

class ConfiguracaoModelo{
    private $id;
    private $descricao;
    private $valor;
    
    //setters
    public function setId($id){
        $this->id = $id;
    }
    
    public function setDescricao($string){
        $this->descricao = $string;
    }
    
    public function setValor($string){
        $this->valor = $string;
    }
    
    //getters
    public function getId(){
        return $this->id;
    }
    
    public function getDescricao(){
        return $this->descricao;
    }
    
    public function getValor(){
        return $this->valor;
    }
}
?>