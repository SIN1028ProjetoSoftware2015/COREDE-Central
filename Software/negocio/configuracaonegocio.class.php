<?php
/**
 * Arquivo: configuracaonegocio.class.php
 * Criado em: 23/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções que ligam a interface ao banco de dados,
 *  funções estas referentes ao objeto usuário.
 * 
 */

include_once './dao/configuracaodao.class.php';
include_once './dados/configuracaomodelo.class.php';

class ConfiguracaoNegocio{
    
   //inserir usuarios
    public function inserirConfiguracao($descricao, $valor) {
        $configuracao = new ConfiguracaoModelo();

        $configuracao->setDescricao($descricao);
        $configuracao->setValor($valor);

        $dao = new ConfiguracaoDao();

        $dao->inserir($configuracao);
    }
    
    //alterar configurações
    public function alterarConfiguracao($valor, $descricao) {
        $configuracao = new ConfiguracaoModelo();
        
        //titulo
        $configuracao->setDescricao($descricao);
        $configuracao->setValor($valor);
        
        $dao = new ConfiguracaoDao();
        $dao->alterar($configuracao);
    }
    
    //consultar valor das configurações
    public function carregarValorDaConfiguracao($nomeConfiguracao) {
        $dao = new ConfiguracaoDao();
        $configuracao = $dao->consultar($nomeConfiguracao);
        return $configuracao[0]->getValor();
    }
}
?>