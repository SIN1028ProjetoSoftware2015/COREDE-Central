-- MySQL dump 10.13  Distrib 5.6.19, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: corede
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu0.15.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mb_atas`
--

DROP TABLE IF EXISTS `mb_atas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mb_atas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(250) NOT NULL,
  `data` varchar(250) NOT NULL,
  `ata` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mb_atas`
--

LOCK TABLES `mb_atas` WRITE;
/*!40000 ALTER TABLE `mb_atas` DISABLE KEYS */;
/*!40000 ALTER TABLE `mb_atas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mb_banners`
--

DROP TABLE IF EXISTS `mb_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mb_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_site` longtext NOT NULL,
  `link_banner` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mb_banners`
--

LOCK TABLES `mb_banners` WRITE;
/*!40000 ALTER TABLE `mb_banners` DISABLE KEYS */;
INSERT INTO `mb_banners` VALUES (1,'#','29092015204205_banner 1.jpg'),(2,'#','29092015204212_banner 2.jpg'),(3,'#','29092015204218_banner 3.jpg'),(4,'#','29092015204251_banner 4.jpg'),(5,'#','29092015204300_banner 5.jpg'),(6,'#','29092015204312_banner 6.jpg');
/*!40000 ALTER TABLE `mb_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mb_configuracoes`
--

DROP TABLE IF EXISTS `mb_configuracoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mb_configuracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `valor` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mb_configuracoes`
--

LOCK TABLES `mb_configuracoes` WRITE;
/*!40000 ALTER TABLE `mb_configuracoes` DISABLE KEYS */;
INSERT INTO `mb_configuracoes` VALUES (1,'tituloDoSite','COREDE Central'),(2,'descricaoDoSite','Guia da Secretaria de Apoio Internacional'),(3,'numeroDeItensPorPaginaPainel','10'),(4,'numeroDeItensPorPaginaSite','10'),(5,'numeroDeItensPorPaginaFotografia','10'),(6,'extensoesDeImgagens','jpg, jpeg'),(7,'emailDoFormularioDeContato','corede@ufsm.br');
/*!40000 ALTER TABLE `mb_configuracoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mb_idioma`
--

DROP TABLE IF EXISTS `mb_idioma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mb_idioma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mb_idioma`
--

LOCK TABLES `mb_idioma` WRITE;
/*!40000 ALTER TABLE `mb_idioma` DISABLE KEYS */;
INSERT INTO `mb_idioma` VALUES (1,'PortuguÃªs');
/*!40000 ALTER TABLE `mb_idioma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mb_noticias`
--

DROP TABLE IF EXISTS `mb_noticias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mb_noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `data_noticia` varchar(250) NOT NULL,
  `link_foto` longtext,
  `conteudo` longtext NOT NULL,
  `galeria` int(11) NOT NULL,
  `publicar` int(11) NOT NULL,
  `tags` longtext,
  `idioma` int(11) NOT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mb_noticias`
--

LOCK TABLES `mb_noticias` WRITE;
/*!40000 ALTER TABLE `mb_noticias` DISABLE KEYS */;
/*!40000 ALTER TABLE `mb_noticias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mb_paginas`
--

DROP TABLE IF EXISTS `mb_paginas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mb_paginas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `tags` longtext NOT NULL,
  `conteudo` longtext NOT NULL,
  `idioma` int(11) NOT NULL,
  PRIMARY KEY (`id`,`idioma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mb_paginas`
--

LOCK TABLES `mb_paginas` WRITE;
/*!40000 ALTER TABLE `mb_paginas` DISABLE KEYS */;
INSERT INTO `mb_paginas` VALUES (1,'Sobre','','<p>teste01</p>',1);
/*!40000 ALTER TABLE `mb_paginas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mb_usuarios`
--

DROP TABLE IF EXISTS `mb_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mb_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `tipo` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mb_usuarios`
--

LOCK TABLES `mb_usuarios` WRITE;
/*!40000 ALTER TABLE `mb_usuarios` DISABLE KEYS */;
INSERT INTO `mb_usuarios` VALUES (10,'administrador','Gglmhy8WH1Yy1oV1oHDdBp/WHwjFPAnDDCtYQN9QkGQ=',1,'admin@exemplo.com','(00) 0000-0000'),(11,'Maik Basso','YmkYooFLndoqvchCLtw9nPt2nQdAYrY63C90Xx+R0XE=',0,'maik@maikbasso.com.br','(00) 0000-0000');
/*!40000 ALTER TABLE `mb_usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-01 20:59:23
