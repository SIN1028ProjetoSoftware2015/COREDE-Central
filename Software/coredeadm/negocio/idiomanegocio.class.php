<?php

/**
 * Arquivo: idiomanegocio.class.php
 * Criado em: 22/03/2015
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções que ligam a interface ao banco de dados,
 *  funções estas referentes ao objeto idioma.
 * 
 */

include_once './dao/idiomadao.class.php';
include_once './dados/idiomamodelo.class.php';

class IdiomaNegocio{
    
    //construtor
    public function __construct() {
        $this->dao = new IdiomaDao();
    }
    
   //inserir
    public function inserirIdioma($idioma) {
        $i = new IdiomaModelo();

        $i->setIdioma($idioma);

        $dao = new IdiomaDao();

        $dao->inserir($i);
    }
    
    //Alterar
    public function alterarIdioma($id, $idioma) {
        $i = new IdiomaModelo();

        $i->setId($id);
        $i->setIdioma($idioma);

        $dao = new IdiomaDao();

        $dao->alterar($i);
    }
    
    //deletar
    public function deletarIdioma($id) {
        $i = new IdiomaModelo();

        $i->setId($id);

        $dao = new IdiomaDao();

        $dao->deletar($i);
    }
    
    //consultar
    public function consultarIdioma($pesquisa) {
        $dao = new IdiomaDao();
        return $dao->consultar($pesquisa);
    }
    
    //retorna o numero total de usuários cadastrados
    public function getNumTotalDeRegistros(){
        return $this->dao->numTotalDeRegistros();
    }
    
    //consultar todos os usuarios
    public function listarIdiomas($numIdiomaAtual, $numDeRegistrosPorIdioma) {
        return $this->dao->listar($numIdiomaAtual, $numDeRegistrosPorIdioma);
    }
    
    //verificar a existencia
    public function verificaSeExiste($id) {
        $dao = new IdiomaDao();
        $lista = $dao->consultaUnicaPorId($id);
        if(sizeof($lista) >= 1){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //consultar unica
    public function consultarUnicaIdioma($id) {
        $dao = new IdiomaDao();
        return $dao->consultaUnicaPorId($id);
    }
}
?>