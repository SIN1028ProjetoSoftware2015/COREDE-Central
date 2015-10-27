<?php

/**
 * Arquivo: usuariomodelo.class.php
 * Criado em: 13/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe representa o objeto usuário.
 * 
 */

class UsuarioModelo{
    private $id;
    private $nome;
    private $senha;
    private $tipo;
    private $email;
    private $telefone;
    
    //setters
    public function setId($id){
        $this->id = $id;
    }
    
    public function setNome($nome){
        $this->nome = $nome;
    }
    
    public function setSenha($senha){
        $this->senha = $senha;
    }
    
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    
    public function setEmail($email){
        $this->email = $email;
    }
    
    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }
    
    //getters
    public function getId(){
        return $this->id;
    }
    
    public function getNome(){
        return $this->nome;
    }
    
    public function getSenha(){
        return $this->senha;
    }
    
    public function getTipo(){
        return $this->tipo;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function getTelefone(){
        return $this->telefone;
    }
}
?>