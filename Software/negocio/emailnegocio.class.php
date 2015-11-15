<?php
/* 
    Created on : 20/01/2014, 21:47:30
    Author     : Maik Basso - maik@maikbasso.com.br
    Site: www.websetbrasil.com
*/

include_once './dados/emailmodelo.class.php';

class EmailNegocio{
    private $emailsDestino;
    
    public function setEmailsDestino($emailsDestino) {
        $this->emailsDestino = $emailsDestino;
    }
    
    public function enviaEmail(EmailModelo $email){
        $mensagem = '<html><head><meta charset="UTF-8"></head><body>';
        $mensagem .= "<b>Nome:</b> " . $email->getNome(). "<br />";
        $mensagem .= "<b>Email:</b> " .$email->getEmail(). "<br />";
        $mensagem .= "<b>Telefone:</b> " .$email->getTelefone(). "<br />";
        $mensagem .= "<b>Mensagem:</b> <br />" .$email->getMensagem(). "<br /><br />";
        $mensagem .= "</body></html>";
                
        //para o envio em formato HTML
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html;
        charset=UTF-8\r\n";

        //endereço do remitente
        $headers .= "From: " . $email->getNome() . " <". $email->getEmail() .">\r\n";

        //endereço de resposta, se queremos que seja diferente a do remitente
        $headers .= "Reply-To: ".$email->getEmail()."\r\n";
        
        if(mail($this->emailsDestino,"Contato de " . $email->getNome(), $mensagem, $headers)){
            return TRUE;
        }
        else {
            return FALSE;
        }
        
    } 
}
?>