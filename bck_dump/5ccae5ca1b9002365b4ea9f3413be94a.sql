-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: template
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_admin`
--

DROP TABLE IF EXISTS `tb_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoa` int(11) NOT NULL,
  `senha_admin` varchar(32) NOT NULL DEFAULT md5(1234),
  `data_admin` date DEFAULT current_timestamp(),
  `data_actualizacao_admin` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_admin` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `id_pessoa` (`id_pessoa`),
  CONSTRAINT `tb_admin_ibfk_1` FOREIGN KEY (`id_pessoa`) REFERENCES `tb_pessoa` (`id_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_admin`
--

LOCK TABLES `tb_admin` WRITE;
/*!40000 ALTER TABLE `tb_admin` DISABLE KEYS */;
INSERT INTO `tb_admin` VALUES (1,1,'81dc9bdb52d04dc20036dbd8313ed055','2023-06-30','2023-06-30 21:08:21',1);
/*!40000 ALTER TABLE `tb_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_disciplina`
--

DROP TABLE IF EXISTS `tb_disciplina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_disciplina` (
  `id_disciplina` int(11) NOT NULL AUTO_INCREMENT,
  `disciplina` varchar(255) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `data_disciplina` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_disciplina` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_disciplina`),
  UNIQUE KEY `disciplina` (`disciplina`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `tb_disciplina_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `tb_admin` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_disciplina`
--

LOCK TABLES `tb_disciplina` WRITE;
/*!40000 ALTER TABLE `tb_disciplina` DISABLE KEYS */;
INSERT INTO `tb_disciplina` VALUES (1,'SEAC',1,'2023-06-30 21:36:04',0),(2,'tic',1,'2023-06-30 21:53:39',0),(3,'khgfvgn',1,'2023-06-30 21:53:43',0),(4,'khkjjbvgcv',1,'2023-06-30 21:53:47',0),(5,'jkbhjvgc',1,'2023-06-30 21:53:53',0),(6,'hjk,',1,'2023-06-30 22:04:35',0),(7,'lkl',1,'2023-06-30 22:04:39',0),(8,'<script>alert(0)</script>',1,'2023-06-30 22:21:15',0),(9,'aaaa',1,'2023-06-30 22:34:54',0),(10,'kkkk',1,'2023-06-30 23:31:10',0),(11,'jkhkjhkj',1,'2023-07-01 00:03:30',0),(12,',..,,.',1,'2023-07-01 00:06:25',0),(13,'kjkjknk',1,'2023-07-01 00:06:29',0),(14,'voad',1,'2023-07-01 00:18:54',0),(15,'akskddm',1,'2023-07-01 00:22:26',0),(16,'tcc',1,'2023-07-01 00:23:38',0),(17,'ssa',1,'2023-07-01 00:24:24',0),(18,'exe',1,'2023-07-01 00:36:28',0),(19,'mm,',1,'2023-07-01 00:50:32',0),(20,'ddff',1,'2023-07-01 00:58:20',0),(21,'ccccccc',1,'2023-07-01 00:58:36',1);
/*!40000 ALTER TABLE `tb_disciplina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_pessoa`
--

DROP TABLE IF EXISTS `tb_pessoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_pessoa` (
  `id_pessoa` int(11) NOT NULL AUTO_INCREMENT,
  `nome_pessoa` varchar(255) NOT NULL,
  `identidade_pessoa` varchar(14) NOT NULL,
  `telefone` varchar(32) DEFAULT NULL,
  `nascimento_pessoa` date DEFAULT NULL,
  `perfil` text DEFAULT NULL,
  PRIMARY KEY (`id_pessoa`),
  UNIQUE KEY `identidade_pessoa` (`identidade_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_pessoa`
--

LOCK TABLES `tb_pessoa` WRITE;
/*!40000 ALTER TABLE `tb_pessoa` DISABLE KEYS */;
INSERT INTO `tb_pessoa` VALUES (1,'admin','admin',NULL,'2023-06-30',NULL);
/*!40000 ALTER TABLE `tb_pessoa` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-01 13:30:29
