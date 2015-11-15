<?php

/**
 * Arquivo: download.php
 * Criado em: 31/01/2015
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função:
 *  Este script força o download de arquivos do servidor
 *
 */

//incluir a interface de segurança
include_once './ui/seguranca.interface.php';

//recupera o arquivo para o download
$arquivo = $_GET["arquivo"];
$pasta = $_GET["pasta"];

$testa = pathinfo($arquivo);

$bloqueados = array('php', 'html', 'htm', 'asp', 'sql', 'css');

if (!in_array($testa, $bloqueados)) {
        
        if ((stripos($arquivo, './') !== false) ||
            (stripos($arquivo, '../') !== false) ||
            (!file_exists($pasta.$arquivo))){
            exit('Erro!');
        }

        $arquivo = $pasta.$arquivo;

        header('Content-type: octet/stream');
        header('Content-disposition: attachment; filename="'.basename($arquivo).'";');
        header('Content-Length: '.filesize($arquivo));
        readfile($arquivo);
        exit();
}
else {
    exit('Arquivo não encontrado!');
}
?>