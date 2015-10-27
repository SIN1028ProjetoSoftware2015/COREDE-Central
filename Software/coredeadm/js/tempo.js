/**
 * Arquivo: tempo.js
 * Criado em: 17/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe contém as funções javascript de manipulação de data e hora.
 *
 */

function negocioTempo(){
    this.getDataAtual = function(){
        hoje = new Date();
        mes = hoje.getMonth();
        mes++;
        dia = hoje.getDate();
        if(dia <= 9){
            dia = "0" + dia;
        }
        if(mes <= 9){
            mes = "0" + mes;
        }
        return dia + "/" + mes + "/" + hoje.getFullYear();
    };
}

//cria os objetos das classes para serem utilizados em suas respectivas páginas
negocioTempo = new negocioTempo();