<?php

/**
 * Arquivo: arquivonegocio.class.php
 * Criado em: 16/01/2013 as 01:06:25
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém todos os métodos para o trabalho com arquivos.
 * 
 */

class ArquivoNegocio{
    /*
    Modos de abertura:
        - r: abre o arquivo no modo somente leitura e posiciona o ponteiro no início do arquivo, o arquivo já deve existir;
        - r+: abre o arquivo para leitura/escrita, posiciona o ponteiro no início do arquivo;
        - w: abre o arquivo no modo somente escrita; se o arquivo já existir, será sobrescrito; senão, será criado um novo;
        - w+: abre o arquivo para escrita/leitura; se o arquivo já existir, será sobrescrito; senão, será criado um novo;
        - a: abre o arquivo para anexar dados, posiciona o ponteiro no final do arquivo; se o arquivo não existir, será criado um novo;
        - a+: abre o arquivo para anexo/leitura, posiciona o ponteiro no final do arquivo; se o arquivo não existir, será criado um novo;

        Obs: Além dos modos de abertura descritos acima, um arquivo pode ser aberto como binário, especificando o modo de abertura como “b”.
    */
    
    //está função cria um arquivo
    public function criarOuEditar($pasta, $nomeArquivo, $tipo, $conteudo){
        if($arq = @fopen($pasta.$nomeArquivo, $tipo)){
            @fwrite($arq, $conteudo);
            @fclose($arq);
            return true;
        }
        else{
            return false;
        }
    }
    
    //está função cria pastas no sistema
    public function criarPasta($pastaAtual, $novaPasta){
        if(@mkdir($pastaAtual.$novaPasta, 0700 )){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    //função que deleta um arquivo
    public function deletar($arquivo){
	if(@unlink($arquivo)){
            return true;
	}
	else{
            return false;
	}
    }
    
    //função que deleta uma pasta vazia
    public function deletarPasta($pasta){
	if(@rmdir($pasta)){
            return true;
	}
	else{
            return false;
	}
    }
    
    //deletar uma pasta não vazia
    public function deletarPastaComConteudo($pasta){
        if ($pastaPrincipal = @opendir($pasta)) {
            while (FALSE !== ($arquivo = @readdir($pastaPrincipal))) {
                if($arquivo != "." && $arquivo != ".."){
                    $arquivoAtual = $pasta . "/" . $arquivo;
                    if(@is_dir($arquivoAtual)){
                        $this->deletarPastaComConteudo($arquivoAtual);
                    }elseif(@is_file($arquivoAtual)){
                        @unlink($arquivoAtual);
                    }
                }
            }
            @closedir($pastaPrincipal);
        }
        @rmdir($pasta);
    }
    
    //função q retorna a extenção do arquivo
    public function getExtensao($nomeArquivo){
        $nomeArquivo = @explode(".", $nomeArquivo);
	$nomeArquivo = @end($nomeArquivo);
        $nomeArquivo = @strtolower($nomeArquivo);
        return $nomeArquivo;
    }
    
    //obtem o tamanho do arquivo
    public function getTamanho($arquivo){
        $tamanhoarquivo = @filesize($arquivo);
 
        /* Medidas */
        $medidas = array('KB', 'MB', 'GB', 'TB');

        /* Se for menor que 1KB arredonda para 1KB */
        if($tamanhoarquivo < 999){
            $tamanhoarquivo = 1000;
        }

        for ($i = 0; $tamanhoarquivo > 999; $i++){
            $tamanhoarquivo /= 1024;
        }

        return @round($tamanhoarquivo) . " " . $medidas[$i - 1];
    }
    
    //obtem o espaço livre no servidor
    public function getEspacoLivreNoServidor(){
        $bytes = disk_free_space(".");
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
        return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
    }

    //obtem o espaço total no servidor
    public function getEspacoTotalNoServidor(){
        $bytes = disk_total_space(".");
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
        return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
    }

    //função que le uma pasta
    public function abrirPasta($pasta){
	$resultado = @opendir($pasta);
        return $resultado;
    }
    
    //função que le uma pasta
    public function lerPasta($pasta){
	$resultado = @readdir($pasta);
        return $resultado;
    }
    
    //verifica se é pasta ou é arquivo
    public function isPasta($pasta){
	if(@is_dir($pasta)){
            return TRUE;
        }
        return FALSE;
    }
    
    //retorna o conteudo de um arquivo
    public function getConteudo($arquivo){
        if(@file_get_contents($arquivo)){
            return @file_get_contents($arquivo);
        }
        return "";
    }
    
    //faz o upload de um arquivo
    public function upload($destino, $arquivo){
        $_FILES['arquivo'] = $arquivo;
        if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino . $_FILES['arquivo']['name'])){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    //upload com tratamento em nomes
    public function tratamentoEmNomes($destino, $arquivo) {
        $_FILES['arquivo'] = $arquivo;
        if($this->verificaSeExiste($destino . $_FILES['arquivo']['name'])){
            $_FILES['arquivo']['name'] = "mb_" . date("dmYHis") . "_" . $_FILES['arquivo']['name'];
        }
        else{
            $_FILES['arquivo']['name'] = date("dmYHis") . "_" . $_FILES['arquivo']['name'];
        }
        return $_FILES['arquivo'];
    }
    
    //retorna um array de arquivos para multiupload
    public function getArrayMultiUpload(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }
    
    //filtra array de arquivos por extensao
    public function getArrayMultiUploadComFiltro(&$file_post, $arrayExtensoes){
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            $status = FALSE;
            for($x=0; $x < sizeof($arrayExtensoes); $x++){
                if($this->getExtensao($file_post['name'][$i]) == $arrayExtensoes[$x]){
                   $status = TRUE; 
                }
            }
            if($status == TRUE){
                foreach ($file_keys as $key) {
                    $file_ary[$i][$key] = $file_post[$key][$i];
                }
            }
        }

        return $file_ary;
    }

    //verifica se um arquivo ou pasta existe
    public function verificaSeExiste($link){
        if(@file_exists($link)){
            return TRUE;
        }
        return FALSE;
    }
    
}
?>