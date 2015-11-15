<?php

/**
 * Arquivo: backupdao.class.php
 * Criado em: 29/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe faz backup do banco de dados mysql.
 * 
 */

include_once 'conexaodao.class.php';
include_once './config/sistema.class.php';

class BackupDao{
    private $conexao = null;
    private $sistema;

    //construtor
    public function __construct() {
        $this->conexao = new ConexaoDao();
        $this->conexao->getConexao();
        $this->sistema = new Sistema();
    }
    
    //faz o backup do banco e retorna uma string
    public function getBackup(){
        //inicia a variavel que armazena a string do backup
        $backup = "";
        //obtem a lista de tabelas
        $listaDeTabelas = $this->conexao->consultaDB("SHOW TABLES;");
        
        //faz o backup de cada tabela
        while($tabela = mysql_fetch_row($listaDeTabelas)) {
            $tabelaAtual = $tabela[0];
            
            //obtem o sql de criação da tabela
            $sqlCriacaoTabela = $this->conexao->consultaDB("SHOW CREATE TABLE " . $tabelaAtual);
            
            while($createTable = mysql_fetch_row($sqlCriacaoTabela)) {
                $backup .= "\n/*\n" . $createTable[1] . ";\n*/\n\n";
                
                //seleciona todos os registros da tabela
                $ItensTabelaAtual = $this->conexao->consultaDB("SELECT * FROM " . $tabelaAtual);
                
                //insert
                $contInsert = 0;
                $insert = "INSERT INTO " . $tabelaAtual . " VALUES\n";
                    
                //obtem as tuplas para insert
                while($tupla = mysql_fetch_assoc($ItensTabelaAtual)) {
                    $insert .= "('" . implode("', '", $tupla) . "'),\n";
                    $contInsert++;
                }
                
                //limpa a tabela antes da inserção
                $backup .= "TRUNCATE TABLE " . $tabelaAtual . ";\n\n";
                
                //define os inserts
                if($contInsert > 0){
                    //substitui a ultima , por ;
                    $backup .= substr($insert, 0, -2) . ";\n\n";
                }
            }
        }
        $this->conexao->desconectar();
        return $backup;
    }
    
    //restaura o backup do banco de dados
    public function restaurarDB($backup){
        $resultado = $this->conexao->consultaDB($backup);
    }
    
    //obtem o tamanho total da db
    public function getTamanhoTotalDBemMB(){
        $sql = "SELECT Round( Sum( data_length + index_length ) / 1024 / 1024, 3 ) AS tamanhodb "
              ."FROM information_schema.tables "
              ."where table_schema = '".$this->sistema->getBancoDeDados()."' "
              ."GROUP BY table_schema;";
        $resultado = $this->conexao->consultaDB($sql);
        $linha = mysql_fetch_assoc($resultado);
        return $linha["tamanhodb"];
    }
    
    //obtem o espaco livre da db
    public function getEspacoLivreDBemMB(){
        $sql = "SELECT Round( Sum( data_free ) / 1024 / 1024, 3 ) AS espacoLivre "
              ."FROM information_schema.tables "
              ."where table_schema = '".$this->sistema->getBancoDeDados()."' "
              ."GROUP BY table_schema;";
        $resultado = $this->conexao->consultaDB($sql);
        $linha = mysql_fetch_assoc($resultado);
        return $linha["espacoLivre"];
    }
}
?>