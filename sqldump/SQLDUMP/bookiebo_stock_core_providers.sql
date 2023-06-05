-- MySQL dump 10.13  Distrib 5.7.12, for osx10.9 (x86_64)
--
-- Host: 127.0.0.1    Database: bookiebo_stock
-- ------------------------------------------------------
-- Server version	5.7.20

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
-- Table structure for table `core_providers`
--

DROP TABLE IF EXISTS `core_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_providers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` char(36) NOT NULL,
  `guid_secret` char(36) NOT NULL,
  `provider_name` varchar(45) NOT NULL,
  `license_id` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1 - MGA\n2 - Curacao',
  PRIMARY KEY (`id`,`guid`),
  UNIQUE KEY `guid_UNIQUE` (`guid`),
  UNIQUE KEY `guid_secret_UNIQUE` (`guid_secret`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_providers`
--

LOCK TABLES `core_providers` WRITE;
/*!40000 ALTER TABLE `core_providers` DISABLE KEYS */;
INSERT INTO `core_providers` VALUES (1,'bfc583ee-ba0d-4ae1-a04a-b096a1e2f16d','d8c1b5ea-ef62-45b9-ab38-e22aa23e80a5','KENO',2),(2,'11c4fae0-c495-11e3-894d-005056a8fc2a','82815cda-fc05-4dbe-9808-113bf1035b76','BETSOFT',2),(3,'8f672252-7516-41dd-807c-f1532ae6aa1e','8b41ceeb-715b-4fd8-aff3-215d06709375','BETCONSTRUCT',2),(4,'dc204ed2-03b2-4c6d-a307-46f78797d623','65bbd321-fb08-44b9-b867-82724af4aeb5','BETCONSTRUCTSPORT',2),(5,'9ecaa978-26fb-45e0-9e37-4f4c975332ee','e4d2b9d4-1dc8-4cf1-9311-1c215f55d262','AFFILIATION',1);
/*!40000 ALTER TABLE `core_providers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:38
