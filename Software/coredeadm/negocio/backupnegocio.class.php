<?php

/**
 * Arquivo: backupnegocio.class.php
 * Criado em: 29/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções que ligam a interface ao banco de dados,
 *  funções estas referentes ao backup do sistema.
 * 
 *  A extenção dos arquivos de backup do sistema é .bkp
 * 
 */

include_once './dao/backupdao.class.php';
include_once './negocio/arquivonegocio.class.php';
include_once 'criptografianegocio.class.php';
include_once './config/sistema.class.php';


class BackupNegocio{
    
    private $pastaDeBackups;
    private $bkpExtensao;
    private $Sistema;
    
    public function __construct() {
        $this->Sistema = new Sistema();
        //carregar configs
        $this->pastaDeBackups = $this->Sistema->getDirArqivosDeBackup();
        $this->bkpExtensao = $this->Sistema->getExtArqivosDeBackup();
    }

        //get nome pasta
    public function getNomePastaDeBackups(){
        return $this->pastaDeBackups;
    }
    
    //get a extensao dos bkp
    public function getExtensaoDosBackups(){
        return $this->bkpExtensao;
    }

    //obtem o nome de um arquivo de backup a ser criado
    private function obterNomeBackup(){
        $nome = "backup_" . date("H-i-s_d-m-Y") . $this->bkpExtensao;
        return $nome;
    }

    //metodo que cria um arquivo de backup
    public function gerarBackup(){
        //obtem a string de backup
        $dao = new BackupDao();
        $backup = $dao->getBackup();
        
        //criptografa  backup
        $criptografia = new CriptografiaNegocio();
        $backup = $criptografia->criptografar($backup);
        
        //grava o backup num arquivo
        $arquivoNegocio = new ArquivoNegocio();
        
        if($arquivoNegocio->criarOuEditar($this->pastaDeBackups, $this->obterNomeBackup(), "w", $backup)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    //metodo que restaura um backup
    public function restaurarBackup($arquivo){
        //obtem o conteudo do arquivo
        $arquivoNegocio = new ArquivoNegocio();
        $conteudoArquivo = $arquivoNegocio->getConteudo($arquivo);
        
        //descriptografa o conteudo do arquivo
        $criptografia = new CriptografiaNegocio();
        $backup = $criptografia->descriptografar($conteudoArquivo);
        
        //restaura o backup
        $dao = new BackupDao();
        $dao->restaurarDB($backup);        
    }
    
    //metodo que pega informaçoes da db
    public function getTamanhoTotalDB(){
        $dao = new BackupDao();
        return $dao->getTamanhoTotalDBemMB();
    }
    
    //metodo que pega informaçoes da db
    public function getEspacoLivreDB(){
        $dao = new BackupDao();
        return $dao->getEspacoLivreDBemMB();
    }
    
}
?>