<?php
/*
  @autor Maik Basso
  @email maik@maikbasso.com.br
  @telefone (55) 9952-9459
 */

//inclui as classes
include_once './negocio/emailnegocio.class.php';
include_once './dados/emailmodelo.class.php';
include_once './negocio/paginanegocio.class.php';
include_once './negocio/configuracaonegocio.class.php';

//criar objetos
$paginaNegocio = new PaginaNegocio();
$configuracaoNegocio = new ConfiguracaoNegocio();

$mensagem = "";

//se o formulario for envidado
if (isset($_POST["nome"])) {
    $email = new EmailModelo();
    
    $email->setEmail($_POST["email"]);
    $email->setMensagem($_POST["mensagem"]);
    $email->setNome($_POST["nome"]);
    $email->setTelefone($_POST["telefone"]);
    
    $emailNegocio = new EmailNegocio();
    $emailNegocio->setEmailsDestino($configuracaoNegocio->carregarValorDaConfiguracao("emailDoFormularioDeContato"));
    if($emailNegocio->enviaEmail($email)){
        $mensagem = "<h3>Email enviado com sucesso!</h3>";
    }
    else{
        $mensagem = "<h3>O email não pode ser enviado!</h3>";
    }
}

include_once 'ui/header.ui.php';
?>
<div class="corede-titulo">
    Contato
</div>
<div class="corede-texto">
    <form id="contato" class="formularioContato" action="contato.php" method="post" name="formularioContato">
        <label>Nome: <font color="red">*</font></label><br />
        <input type="text" name="nome" size="30" class="campotexto"><br />
        
        <label>Email: <font color="red">*</font></label><br />
        <input type="text" name="email" size="30" class="campotexto"><br />
        
        <label>Telefone:</label><br />
        <input type="text" name="telefone" size="30" class="campotexto"><br />
        
        <label>Mensagem: <font color="red">*</font></label><br />
        <textarea name="mensagem" rows="10" cols="50"></textarea><br />
        
        <label>(<font color="red">*</font>) Campos obrigatórios.</label><br>
        
        <input type="button" value="Enviar mensagem" onclick="contato.enviar();" class="btn">
    </form>
</div>
<?php
include_once 'ui/footer.ui.php';
?>