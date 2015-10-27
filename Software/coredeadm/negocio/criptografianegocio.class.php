<?php

/**
 * Arquivo: criptografianegocio.class.php
 * Criado em: 27/06/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Classe responsavel pela criptografia de dados.
 *  Seguindo padrões MD5.
 * 
 */

include_once './config/sistema.class.php';

class CriptografiaNegocio{
    
    private $senhaCriptografia;
    
    //construtor
    public function __construct() {
        $sistema = new Sistema();
        $this->senhaCriptografia = $sistema->getSenhaCriptografia();
    }

    //função utilizada para obter carazteres randomicos
    private function Randomizar($iv_len) {
        $iv = '';
        while ($iv_len-- > 0) {
            $iv .= chr(mt_rand() & 0xff);
        }
        return $iv;
    }
    
    public function criptografar($texto, $iv_len = 16) {
        $senha = $this->senhaCriptografia;
        $texto .= "\x13";
        $n = strlen($texto);
        if ($n % 16)
            $texto .= str_repeat("\0", 16 - ($n % 16));
        $i = 0;
        $Enc_Texto = $this->Randomizar($iv_len);
        $iv = substr($senha ^ $Enc_Texto, 0, 512);
        while ($i < $n) {
            $Bloco = substr($texto, $i, 16) ^ pack('H*', md5($iv));
            $Enc_Texto .= $Bloco;
            $iv = substr($Bloco . $iv, 0, 512) ^ $senha;
            $i += 16;
        }
        return base64_encode($Enc_Texto);
    }

    public function descriptografar($Enc_Texto, $iv_len = 16) {
        $senha = $this->senhaCriptografia;
        $Enc_Texto = base64_decode($Enc_Texto);
        $n = strlen($Enc_Texto);
        $i = $iv_len;
        $texto = '';
        $iv = substr($senha ^ substr($Enc_Texto, 0, $iv_len), 0, 512);
        while ($i < $n) {
            $Bloco = substr($Enc_Texto, $i, 16);
            $texto .= $Bloco ^ pack('H*', md5($iv));
            $iv = substr($Bloco . $iv, 0, 512) ^ $senha;
            $i += 16;
        }
        return preg_replace('/\\x13\\x00*$/', '', $texto);
    }
}
?>
