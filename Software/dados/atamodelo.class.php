<?php

class AtaModelo{
    private $id;
    private $descricao;
    private $data;
    private $ata;
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getData() {
        return $this->data;
    }

    function getAta() {
        return $this->ata;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setAta($ata) {
        $this->ata = $ata;
    }


}
?>