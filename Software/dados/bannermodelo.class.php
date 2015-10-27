<?php

/**
 * Arquivo: bannermodelo.class.php
 * Criado em: 23/01/2014
 * @author Maik Basso - maik@maikbasso.com.br
 * 
 * Função da classe:
 *  Está classe representa o objeto banner.
 * 
 */

class BannerModelo{
    private $id;
    private $linkSite;
    private $linkBanner;
    
    public function getId() {
        return $this->id;
    }

    public function getLinkSite() {
        return $this->linkSite;
    }

    public function getLinkBanner() {
        return $this->linkBanner;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLinkSite($linkSite) {
        $this->linkSite = $linkSite;
    }

    public function setLinkBanner($linkBanner) {
        $this->linkBanner = $linkBanner;
    }
}
?>