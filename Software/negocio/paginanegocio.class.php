<?php

/**
 * Arquivo: paginanegocio.class.php
 * Criado em: 25/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções que ligam a interface ao banco de dados,
 *  funções estas referentes ao objeto página.
 * 
 */

include_once './dao/paginadao.class.php';
include_once './dados/paginamodelo.class.php';

class PaginaNegocio{
    
    //construtor
    public function __construct() {
        $this->dao = new PaginaDao();
    }
    
   //inserir
    public function inserirPagina($id, $titulo, $conteudo, $tags, $idioma) {
        
        $pagina = new PaginaModelo();

        $pagina->setId($id);
        $pagina->setTitulo($titulo);
        $pagina->setTags($tags);
        $pagina->setConteudo($conteudo);
        $pagina->setIdioma($idioma);
        $dao = new PaginaDao();

        $dao->inserir($pagina);
    }
    
    //Alterar
    public function alterarPagina($id, $titulo, $conteudo, $tags, $idioma) {
        $pagina = new PaginaModelo();

        $pagina->setId($id);
        $pagina->setTags($tags);
        $pagina->setTitulo($titulo);
        $pagina->setConteudo($conteudo);
        $pagina->setIdioma($idioma);

        $dao = new PaginaDao();

        $dao->alterar($pagina);
    }
    
    //deletar
    public function deletarPagina($id) {
        $pagina = new PaginaModelo();

        $pagina->setId($id);

        $dao = new PaginaDao();

        $dao->deletar($pagina);
    }
    
    //consultar
    public function consultarPagina($pesquisa) {
        $dao = new PaginaDao();
        return $dao->consultar($pesquisa);
    }
    
    //consultar paginas por tag
    public function consultarPaginasPorTags($tags) {
        $dao = new PaginaDao();
        return $dao->consultarPorTags($tags);
    }
    
    //retorna o numero total de usuários cadastrados
    public function getNumTotalDeRegistros(){
        return $this->dao->numTotalDeRegistros();
    }
    
    //consultar todos os usuarios
    public function listarPaginas($numPaginaAtual, $numDeRegistrosPorPagina) {
        return $this->dao->listar($numPaginaAtual, $numDeRegistrosPorPagina);
    }
    
    //verificar a existencia
    public function verificaSeExiste($id, $idioma) {
        $dao = new PaginaDao();
        $lista = $dao->consultaUnicaPorId($id, $idioma);
        if(sizeof($lista) >= 1){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //consultar unica
    public function consultarUnicaPagina($id, $idioma) {
        $dao = new PaginaDao();
        return $dao->consultaUnicaPorId($id, $idioma);
    }
}
?>