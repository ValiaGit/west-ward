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
-- Table structure for table `betting_outright`
--

DROP TABLE IF EXISTS `betting_outright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betting_outright` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BetradarOutrightID` int(11) DEFAULT NULL,
  `TournamentId` int(11) NOT NULL,
  `title` blob NOT NULL,
  `betting_category_id` int(11) NOT NULL,
  `betting_category_betting_sport_id` int(11) NOT NULL,
  `EventDate` timestamp NULL DEFAULT NULL,
  `EventEndDate` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`betting_category_id`,`betting_category_betting_sport_id`),
  KEY `fk_betting_outright_betting_category1_idx` (`betting_category_id`,`betting_category_betting_sport_id`),
  CONSTRAINT `fk_betting_outright_betting_category1` FOREIGN KEY (`betting_category_id`, `betting_category_betting_sport_id`) REFERENCES `betting_category` (`id`, `betting_sport_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10488 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `betting_outright`
--

LOCK TABLES `betting_outright` WRITE;
/*!40000 ALTER TABLE `betting_outright` DISABLE KEYS */;
INSERT INTO `betting_outright` VALUES (10487,NULL,14803,'{\"ja\":\"Grand Slam Tokyo 2016  +78 KG\",\"BET Winner\":\"Grand Slam Tokyo 2016  +78 KG\",\"en\":\"Grand Slam Tokyo 2016  +78 KG Winner\",\"ru\":\"Grand Slam Tokyo 2016  +78 KG\",\"ka\":\"Grand Slam Tokyo 2016  +78 KG Winner\",\"de\":\"Grand Slam Tokyo 2016  +78 KG Winner\", \"BET\":\"Grand Slam Tokyo 2016  +78 KG Winner\"}',1687,406,'2014-12-31 23:00:00','2017-11-30 23:00:00',0);
/*!40000 ALTER TABLE `betting_outright` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:40
