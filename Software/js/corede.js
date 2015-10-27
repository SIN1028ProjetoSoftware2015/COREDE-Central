/* 
    Created on : 25/08/2015, 20:25:19
    Author     : maik
*/

function Site(){
    this.abreElemento = function(id){
        document.getElementById(id).style.display = "block";
        $(id).animate({
                "left":"10px"
        },750);
    };
    this.fechaElemento = function(id){
        document.getElementById(id).style.display = "none";
        $(id).animate({
                "opacity":"0.0"
        },750);
    };
    this.abreLink = function(link){
        location.href=link;
    };
}
site = new Site();