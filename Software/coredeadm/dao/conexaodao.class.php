<?php

/**
 * Arquivo: conexaodao.class.php
 * Criado em: 13/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe tem a função de conectar o software ao banco de dados MYSQL.
 * 
 */

include_once './config/sistema.class.php';

class ConexaoDao{
    private $Sistema;
    private $servidor;
    private $usuario;
    private $senha;
    private $bancoDeDados;
    private $paginaDeErro;
    
    //construtor da classe
    public function __construct() {
        $this->Sistema = new Sistema();
        //carregando as configurações
        $this->servidor = $this->Sistema->getServidor();
        $this->usuario = $this->Sistema->getUsuario();
        $this->senha = $this->Sistema->getSenha();
        $this->bancoDeDados = $this->Sistema->getBancoDeDados();
        $this->paginaDeErro = $this->Sistema->getPaginaDeErro();
    }


    //conecta e seleciona o banco de dados
    public function getConexao(){
        $this->conectar();
        $this->selecionarDB();
    }

    //conecta a db
    private function conectar(){
        mysql_connect($this->servidor, $this->usuario, $this->senha) or die(header("LOCATION: " . $this->paginaDeErro));    
    }
    
    //seleciona a db
    private function selecionarDB(){
        mysql_select_db($this->bancoDeDados) or die(header("LOCATION: " . $this->paginaDeErro));
    }
    
    //consulta a db
    public function consultaDB($sql){
        //neste caso nao é possível o retorno imediato senão ocorre erro no tipo de dados
        $resultado = mysql_query($sql);// or die(header("LOCATION: " . $this->paginaDeErro));
        return $resultado;
    }
    
    //fecha a conexão
    public function desconectar(){
        mysql_close() or die(header("LOCATION: " . $this->paginaDeErro));
    }
}
?>