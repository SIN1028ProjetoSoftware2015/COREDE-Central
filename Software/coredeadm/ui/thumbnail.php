<?php
/**
 * Arquivo: thumbnail.interface.php
 * Criado em: 02/11/2014
 * @author Maik Basso - maik@maikbasso.com.br
 *
 */

class cCropImage {

    private $imgSrc;
    private $myImage; 
    private $cropHeight;
    private $cropWidth;
    private $x;
    private $y;
    private $thumb;

    function setImage($image) {
        //Sua Imagem
        $this->imgSrc = $image;

        //Capturando as dimensões da imagem
        list($width, $height) = getimagesize($this->imgSrc);

        //Criando a imagem
        $this->myImage = imagecreatefromjpeg($this->imgSrc) or die("Erro: Não foi possível encontrar a imagem!");

        if ($width > $height) {
            $biggestSide = $width; //Procurando pelo maior (largura ou altura)
        } else {
            $biggestSide = $height;
        }

        //Proporção do crop
        $cropPercent = .5; // Esta proporção gerará um zoom de 50% (crop)
        $this->cropWidth = $biggestSide * $cropPercent;
        $this->cropHeight = $biggestSide * $cropPercent;

        $this->x = ($width - $this->cropWidth) / 2;
        $this->y = ($height - $this->cropHeight) / 2;
    }

    function createThumb($tamanho) {
        $thumbSize = $tamanho; // Definição do tamanho do thumbnail
        $this->thumb = imagecreatetruecolor($thumbSize, $thumbSize);
        imagecopyresampled($this->thumb, $this->myImage, 0, 0, $this->x, $this->y, $thumbSize, $thumbSize, $this->cropWidth, $this->cropHeight);
    }

    function renderImage() {
        header('Content-type: image/jpeg');
        imagejpeg($this->thumb);
        imagedestroy($this->thumb);
    }

}

//Capturando a imagem passada via get
$img = $_GET['img'];
$tamanho = $_GET['tamanho'];

if ($img && $tamanho) {
    //Criando e renderizando a imagem
    $image = new cCropImage();
    $image->setImage($img);
    $image->createThumb($tamanho);
    $image->renderImage();
}
?>