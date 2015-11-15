<?php
/* 
    Created on : 20/01/2014, 21:47:30
    Author     : Maik Basso - maik@maikbasso.com.br
    Site: www.websetbrasil.com
*/

class EmailModelo{
    private $nome;
    private $email;
    private $telefone;
    private $mensagem;
    
    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }
}
?>