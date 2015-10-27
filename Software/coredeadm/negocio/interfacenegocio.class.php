<?php
/**
 * Arquivo: interfacenegocio.class.php
 * Criado em: 14/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém metodos de manipulação de interface do sistema.
 * 
 */

class InterfaceNegocio{
    private $footerButtons = "";
    private $mensagemDeAlerta = "";
    private $mensagemHTML = "";
    
    //setters
    public function setFooterButtons($valor){
        $this->footerButtons .= $valor;
    }
    public function setMensagemDeAlerta($valor){
        /*$this->mensagemDeAlerta .= 
                '<script type="text/javascript">'
                . 'ocultarCarregando();'
                . 'alert("' . $valor . '");'
                . '</script>';*/
        //abilitando os popups internos do sistema
        $this->mensagemDeAlerta .= $valor . " ";
    }
    public function setMensagemHTML($valor){
        $this->mensagemHTML .= $valor;
    }
    public function setLocation($valor){
        header("LOCATION: " . $valor);
    }

    //getters
    public function getFooterButtons(){
        return $this->footerButtons;
    }
    public function getMensagemDeAlerta(){
        $html = '<div id="popUpMensagem" class="popUp">
                <div class="triangulo"></div>
                <h3>Mensagem:</h3>
                <h4>'.$this->mensagemDeAlerta.'</h4>
                <div class="btnOk" onclick="popUpMensagem.fechar();" title="OK">OK</div>
                <!--<div class="btnCancelar" onclick="popUpMensagem.fechar();" title="Cancelar">Cancelar</div>-->
                </div>';
        if($this->mensagemDeAlerta != ""){
            return $html;
        }
        else{
            return "";
        }
    }
    public function getMensagemHTML(){
        return $this->mensagemHTML;
    }
    

    //outros
    //--------------------------------------------------------------------------

    //este metodo obtem o id do item atual a ser usado em uma consulta
    public function getIdItemAtual($numeroTotalDeItens){
        if(isset($_GET["p"])){
            if($_GET["p"] < 0){
                return 0;
            }
            elseif($_GET["p"] > $numeroTotalDeItens){
                return $numeroTotalDeItens;
            }
            else{
                return $_GET["p"];
            }
        }
        else{
            return 0;
        }
    }

    //tratamento para numero das páginas
    public function getNumeroPaginaAtual(){
        if(isset($_GET["p"])){
            $numPagina = $_GET["p"];
            if($numPagina != "" && is_numeric($numPagina)){
                if($numPagina >= 0){
                    return $numPagina;
                }
                else{
                    return 0;
                }
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }

    //gera o menu de paginação
    public function getBarraDePaginacao($numeroDeItensPorPagina, $numeroTotalDeItens, $enderecoDaPagina){
        
        //tratamento para endereço
        if(substr($enderecoDaPagina, -4) != ".php"){
            $variavelGet = "&p=";
        }
        else{
            $variavelGet = "?p=";
        }
        
        //calcula o total de páginas
        $totalDePaginas = ceil($numeroTotalDeItens / $numeroDeItensPorPagina);//a função ceil arredonda o valor da operação para cima
        
        //obtem o numero da pagina atual        
        $numeroPaginaAtual = $this->getIdItemAtual($numeroTotalDeItens);
        
        //a bara de navegação irá aparecer somente se tiver mais de uma página
        if($totalDePaginas > 1){
        
            echo'<ul class="barradenavegacao">';

            //mostrador
            echo'<li><div class="display">Página: '.(ceil($numeroPaginaAtual/$numeroDeItensPorPagina)+1).' de '.$totalDePaginas.'</div></li>';

            //botoes inico e anterior
            if($numeroPaginaAtual!=0){
                echo'<li><a href="'.$enderecoDaPagina.'">Início</a></li>';
                echo'<li><a href="'.$enderecoDaPagina.$variavelGet.($numeroPaginaAtual-$numeroDeItensPorPagina).'">Anterior</a></li>';
            }

            //calcula os indices das páginas
            $menorElemento = ceil(($numeroPaginaAtual-($numeroDeItensPorPagina*2))/$numeroDeItensPorPagina);
            $maiorElemento = ceil(($numeroPaginaAtual+($numeroDeItensPorPagina*2))/$numeroDeItensPorPagina);
            for($i=$menorElemento; $i<=$maiorElemento; $i++){
                if(($i>=0) && ($i<($totalDePaginas))){
                    echo'<li><a href="'.$enderecoDaPagina.$variavelGet.($i*$numeroDeItensPorPagina).'">'.($i+1).'</a></li>';
                }
            }

            //botoes ultimo e proximo
            if($numeroPaginaAtual != $totalDePaginas){
                if(($totalDePaginas-1)*($numeroDeItensPorPagina)!= $numeroPaginaAtual){
                    echo'<li><div class="display">...</div></li>';
                    echo'<li><a href="'.$enderecoDaPagina.$variavelGet.(($totalDePaginas-1)*($numeroDeItensPorPagina)).'">Última</a></li>';
                    echo'<li><a href="'.$enderecoDaPagina.$variavelGet.($numeroPaginaAtual+$numeroDeItensPorPagina).'">Próxima</a></li>';
                }
            }

            echo'</ul>';
        }
    }
}
?>