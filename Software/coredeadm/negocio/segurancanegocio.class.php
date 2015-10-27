<?php

/**
 * Arquivo: segurancanegocio.class.php
 * Criado em: 04/12/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções referentes a segurança do sistema.
 * 
 */

class SegurancaNegocio{
    
    //construtor
    public function __construct() {
        
    }
    
    /*
     * Este filtro funciona de forma a remover conteudo indesejado dos ids
     * passados por metodos get em formularios, visando proteger o sistema
     * contra sql injection. O tipo referesse a um tipo primitivo.
     */
    public function filtroDeMetodoGet($valor, $tipo) {
        switch($tipo){
                case "int":
                    return preg_replace("/[^0-9]/", "", $valor);
                case "string":
                    $valor = preg_replace('/[áàãâä]/ui', 'a', $valor); //trata a
                    $valor = preg_replace('/[éèêë]/ui', 'e', $valor); //trata e
                    $valor = preg_replace('/[íìîï]/ui', 'i', $valor); //trata i
                    $valor = preg_replace('/[óòõôö]/ui', 'o', $valor); //trata o
                    $valor = preg_replace('/[úùûü]/ui', 'u', $valor); //trata u
                    $valor = preg_replace('/[ç]/ui', 'c', $valor); //trata c
                    $valor = preg_replace('/_+/', '_', $valor);   //trata _
                    $valor = preg_replace("/[^[:alpha:] ]/", "", $valor); //remove outros caracteres especiais mantendo espaços
                    return $valor;
                default:
                        return $valor;
        }
    }
}
?>