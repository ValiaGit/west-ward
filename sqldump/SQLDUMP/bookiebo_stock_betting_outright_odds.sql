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
-- Table structure for table `betting_outright_odds`
--

DROP TABLE IF EXISTS `betting_outright_odds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betting_outright_odds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `betting_outright_id` int(11) NOT NULL,
  `BetradarOutrightOddID` int(11) DEFAULT NULL,
  `title` blob,
  `status` int(11) NOT NULL DEFAULT '0',
  `betting_outright_competitors_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`betting_outright_id`),
  KEY `fk_betting_outright_odds_betting_outright1_idx` (`betting_outright_id`),
  KEY `fk_betting_outright_odds_betting_outright_competitors1_idx` (`betting_outright_competitors_id`),
  CONSTRAINT `fk_betting_outright_odds_betting_outright1` FOREIGN KEY (`betting_outright_id`) REFERENCES `betting_outright` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_betting_outright_odds_betting_outright_competitors1` FOREIGN KEY (`betting_outright_competitors_id`) REFERENCES `betting_outright_competitors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=209015 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `betting_outright_odds`
--

LOCK TABLES `betting_outright_odds` WRITE;
/*!40000 ALTER TABLE `betting_outright_odds` DISABLE KEYS */;
INSERT INTO `betting_outright_odds` VALUES (209010,10487,NULL,'NATELA',1,15721),(209013,10487,NULL,'ZOIA',1,15721),(209014,10487,NULL,'ARTURA',1,15721);
/*!40000 ALTER TABLE `betting_outright_odds` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:37
