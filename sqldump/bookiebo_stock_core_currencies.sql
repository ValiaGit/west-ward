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
-- Table structure for table `core_currencies`
--

DROP TABLE IF EXISTS `core_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `is_base` tinyint(4) NOT NULL DEFAULT '0',
  `exchange_rate` decimal(18,2) NOT NULL,
  `iso_code` char(3) NOT NULL,
  `iso_name` char(3) DEFAULT NULL,
  `modification_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_currencies`
--

LOCK TABLES `core_currencies` WRITE;
/*!40000 ALTER TABLE `core_currencies` DISABLE KEYS */;
INSERT INTO `core_currencies` VALUES (1,'EUR',1,1.00,'978','EUR','2016-11-06 17:24:21'),(2,'USD',0,1.11,'840','USD','2016-11-06 17:36:26'),(3,'GEL',0,2.71,'981','GEL','2016-11-06 17:36:26'),(4,'RUB',0,71.85,'643','RUB','2016-11-06 17:36:26'),(5,'GBP',0,1.00,'826','GBP','2016-11-06 18:31:41'),(6,'AZN',0,1.00,'944','AZN','2016-11-06 18:31:42'),(7,'CNY',0,1.00,'156','CNY','2016-11-06 18:31:42'),(8,'UAH',0,1.00,'980','UAH','2016-11-06 18:31:42'),(9,'JPY',0,1.00,'392','JPY','2016-11-06 18:31:42'),(10,'KZT',0,1.00,'398','KZT','2016-11-06 18:31:43'),(11,'SEK',0,1.00,'752','SEK','2016-11-06 18:31:43'),(12,'TRY',0,1.00,'949','TRY','2016-11-06 18:31:43'),(13,'AUD',0,1.00,'036','AUD','2016-11-06 18:31:43'),(14,'AED',0,1.00,'784','AED','2016-11-06 18:31:43'),(15,'AMD',0,1.00,'051','AMD','2016-11-06 18:31:44'),(16,'PLN',0,1.00,'985','PLN','2016-11-06 18:34:05');
/*!40000 ALTER TABLE `core_currencies` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:36
