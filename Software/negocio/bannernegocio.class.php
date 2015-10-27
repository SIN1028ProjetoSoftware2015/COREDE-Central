<?php

/**
 * Arquivo: bannernegocio.class.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções que ligam a interface ao banco de dados,
 *  funções estas referentes ao objeto banner.
 * 
 */

include_once './dao/bannerdao.class.php';
include_once './dados/bannermodelo.class.php';

class BannerNegocio{
    
    //construtor
    public function __construct() {
        $this->dao = new BannerDao();
    }
    
   //inserir
    public function inserirBanner($linkSite, $linkBanner) {
        $banner = new BannerModelo();

        $banner->setLinkSite($linkSite);
	$banner->setLinkBanner($linkBanner);

        $dao = new BannerDao();

        $dao->inserir($banner);
    }
    
    //Alterar
    public function alterarBanner($id, $linkSite, $linkBanner) {
        $banner = new BannerModelo();

	$banner->setId($id);
        $banner->setLinkSite($linkSite);
	$banner->setLinkBanner($linkBanner);

        $dao = new BannerDao();

        $dao->alterar($banner);
    }
    
    //deletar
    public function deletarBanner($id) {
        $banner = new BannerModelo();

	$banner->setId($id);

        $dao = new BannerDao();

        $dao->deletar($banner);
    }
    
    //consultar
    public function consultarBanner($pesquisa) {
        $dao = new BannerDao();
        return $dao->consultar($pesquisa);
    }
    
    //retorna o numero total
    public function getNumTotalDeRegistros(){
        return $this->dao->numTotalDeRegistros();
    }
    
    //consultar todos
    public function listarBanner($numPaginaAtual, $numDeRegistrosPorPagina) {
        return $this->dao->listar($numPaginaAtual, $numDeRegistrosPorPagina);
    }
    
    //verificar a existencia
    public function verificaSeExiste($id) {
        $dao = new BannerDao();
        $lista = $dao->consultaUnicaPorId($id);
        if(sizeof($lista) >= 1){
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //consultar unica
    public function consultarUnicaBanner($id) {
        $dao = new BannerDao();
        return $dao->consultaUnicaPorId($id);
    }
}
?>
