<?php
/**
 * Arquivo: footer.interface.php
 * Criado em: 21/03/2013
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Essa interface refere-se ao rodapé do sistema.
 * 
 */

//incluir as classes
include_once 'config/sistema.class.php';

//objetos
$sistema = new Sistema();

//correção para NULL de interfaceNegocio
if(!isset($interfaceNegocio)){
    include_once './negocio/interfacenegocio.class.php';
    $interfaceNegocio = new InterfaceNegocio();
}
?>  
            <div id="visualizadorDeImagens">
                <img title="Clique para fechar a imagem" onclick="visualizadorDeImagens.fechar();" class="imagem" src="../arquivos/imagens/teste1.jpg">
                <a title="Clique para fechar a imagem" class="fechar" href="javascript:visualizadorDeImagens.fechar();">Clique na imagem para fechar</a>
            </div>
        </div>
        <div id="footer">
            <div class="btnConteiner">
                <?php echo $interfaceNegocio->getFooterButtons(); ?>
            </div>
        </div>
        <?php
            echo $interfaceNegocio->getMensagemDeAlerta();
            echo $interfaceNegocio->getMensagemHTML();
        ?>
    </body>
</html>