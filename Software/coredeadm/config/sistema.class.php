<?php

/**
 * Arquivo: sistema.class.php
 * Criado em: 29/08/2013 as 22:21:25
 * @author Maik Basso - maik@maikbasso.com.br
 *
 * Função da classe:
 *  Está classe contém as configurações manuais do sistema.
 *
 */

class Sistema{
    
    /*  Sobre o sistema
    -----------------------------------------------------*/
    //nome do sistema
    private $nomeDoSistema = "SistemaWeb";
    //versão do sistema
    private $versaoDoSistema = "1.1";
    //ano de inicio do projeto
    private $anoDeInicioDoProjeto = "2015";
    
    /*  BANCO DE DADOS
    -----------------------------------------------------*/
    //nome do servidor de banco de dados MySQL
    private $servidor = "saiguia.mysql.uhserver.com";
    //usuário do banco de dados com permissão chmod 777
    private $usuario = "saiguia";
    //senha do bando de dados
    private $senha = "cssjm@2015";
    //nome do banco de dados
    private $bancoDeDados = "saiguia";
    //prefixo das tabelas no banco de dados
    private $prefixoTabelas = "mb_";

        /*  SESSÕES DE USUÁRIOS
    -----------------------------------------------------*/
    //nome da variável de sessão
    private $nomeSessaoDeUsuario = "saiguia";

    /*  PÁGINAS ESPECÍFICAS
    -----------------------------------------------------*/
    //página de erro
    private $paginaDeErro = "error.php";
    //página inicial do painel
    private $paginaInicial = "painel.php";
    //página de login
    private $paginaDeLogin = "index.php";
    //página de permissão negada
    private $paginaDePermissaoNegada = "permissaonegada.php";


    /*  ENDEREÇOS DE DIRETÓRIOS PADRÕES
    -----------------------------------------------------*/
    //pasta de imagens
    private $dirImagens = "../arquivos/imagens/";
    //pasta das imagens do editor de texto
    private $dirImagensEditor = "/projects/SistemaWeb/arquivos/imagens_editor";
    //pasta de arquivos de backup
    private $dirArqivosDeBackup = "../arquivos/backups/";
    //pasta home do gerenciador de arquivos
    private $dirHomeGerenciadorDeArquivos = "../arquivos/home/";
    
    /*  EXTENSÕES PADRÃO
    -----------------------------------------------------*/
    //extensão dos arquivos de backup
    private $extArqivosDeBackup = ".mb";
    
    /*  SENHAS INTERNAS DO SISTEMA
    -----------------------------------------------------*/
    private $senhaCriptografia = "Maik Basso";

    /*  GETTERS
     -----------------------------------------------------*/
    function getNomeDoSistema() {
        return $this->nomeDoSistema;
    }

    function getVersaoDoSistema() {
        return $this->versaoDoSistema;
    }

    function getAnoDeInicioDoProjeto() {
        return $this->anoDeInicioDoProjeto;
    }

    public function getServidor() {
        return $this->servidor;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getBancoDeDados() {
        return $this->bancoDeDados;
    }

    public function getPrefixoTabelas() {
        return $this->prefixoTabelas;
    }

    public function getNomeSessaoDeUsuario() {
        return $this->nomeSessaoDeUsuario;
    }

    public function getPaginaDeErro() {
        return $this->paginaDeErro;
    }

    public function getPaginaInicial() {
        return $this->paginaInicial;
    }

    public function getPaginaDeLogin() {
        return $this->paginaDeLogin;
    }

    public function getPaginaDePermissaoNegada() {
        return $this->paginaDePermissaoNegada;
    }

    public function getDirImagens() {
        return $this->dirImagens;
    }

    public function getDirImagensEditor() {
        return $this->dirImagensEditor;
    }

    public function getDirArqivosDeBackup() {
        return $this->dirArqivosDeBackup;
    }

    public function getDirHomeGerenciadorDeArquivos() {
        return $this->dirHomeGerenciadorDeArquivos;
    }
    
    public function getExtArqivosDeBackup() {
        return $this->extArqivosDeBackup;
    }
    
    function getSenhaCriptografia() {
        return $this->senhaCriptografia;
    }
}
?>
