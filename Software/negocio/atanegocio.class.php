<?php

include_once './dao/atadao.class.php';
include_once './dados/atamodelo.class.php';

class AtaNegocio{
    
    //construtor
    public function __construct() {
        $this->dao = new AtaDao();
    }
    
   //inserir
    public function inserirAta($descricao, $data, $ata1) {
        
        $ata = new AtaModelo();
        
        $ata->setDescricao($descricao);
        $ata->setData($data);
        $ata->setAta($ata1);
        
        $dao = new AtaDao();

        $dao->inserir($ata);
    }
    
    //Alterar
    public function alterarAta($id, $descricao, $data, $ata1) {
        $ata = new AtaModelo();

        $ata->setId($id);
        $ata->setDescricao($descricao);
        $ata->setData($data);
        $ata->setAta($ata1);

        $dao = new AtaDao();

        $dao->alterar($ata);
    }
    
    //deletar
    public function deletarAta($id) {
        $ata = new AtaModelo();

        $ata->setId($id);

        $dao = new AtaDao();

        $dao->deletar($ata);
    }
    
    //consultar
    public function consultarAta($pesquisa) {
        $dao = new AtaDao();
        return $dao->consultar($pesquisa);
    }
    
    //retorna o numero total de usuários cadastrados
    public function getNumTotalDeRegistros(){
        return $this->dao->numTotalDeRegistros();
    }
    
    //consultar todos os usuarios
    public function listarAtas($numAtaAtual, $numDeRegistrosPorAta) {
        return $this->dao->listar($numAtaAtual, $numDeRegistrosPorAta);
    }
    
    //verificar a existencia
    public function verificaSeExiste($id) {
        $dao = new AtaDao();
        $lista = $dao->consultaUnicaPorId($id);
        if(sizeof($lista) >= 1){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //consultar unica
    public function consultarUnicaAta($id) {
        $dao = new AtaDao();
        return $dao->consultaUnicaPorId($id);
    }
}
?>