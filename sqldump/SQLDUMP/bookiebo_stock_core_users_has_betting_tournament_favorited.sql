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
-- Table structure for table `core_users_has_betting_tournament_favorited`
--

DROP TABLE IF EXISTS `core_users_has_betting_tournament_favorited`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_users_has_betting_tournament_favorited` (
  `core_users_id` int(11) NOT NULL,
  `betting_tournament_id` int(11) NOT NULL,
  PRIMARY KEY (`core_users_id`,`betting_tournament_id`),
  KEY `fk_core_users_has_betting_tournament_betting_tournament1_idx` (`betting_tournament_id`),
  KEY `fk_core_users_has_betting_tournament_core_users1_idx` (`core_users_id`),
  CONSTRAINT `fk_core_users_has_betting_tournament_betting_tournament1` FOREIGN KEY (`betting_tournament_id`) REFERENCES `betting_tournament` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_core_users_has_betting_tournament_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_users_has_betting_tournament_favorited`
--

LOCK TABLES `core_users_has_betting_tournament_favorited` WRITE;
/*!40000 ALTER TABLE `core_users_has_betting_tournament_favorited` DISABLE KEYS */;
INSERT INTO `core_users_has_betting_tournament_favorited` VALUES (1,10097),(3,10772),(38,14762),(46,14769),(46,14770),(48,14786);
/*!40000 ALTER TABLE `core_users_has_betting_tournament_favorited` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:35
