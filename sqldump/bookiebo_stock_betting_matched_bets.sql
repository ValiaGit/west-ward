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
-- Table structure for table `betting_matched_bets`
--

DROP TABLE IF EXISTS `betting_matched_bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betting_matched_bets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `betting_lay_id` int(11) NOT NULL,
  `betting_back_id` int(11) NOT NULL,
  `betting_pot_amount` decimal(10,2) NOT NULL,
  `back_amount_in_pot` decimal(10,2) NOT NULL,
  `lay_amount_in_pot` decimal(10,2) NOT NULL,
  `backer_user_id` int(11) NOT NULL,
  `layer_user_id` int(11) NOT NULL,
  `odd_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL COMMENT 'match_id, or outright event id',
  `bet_type` int(11) NOT NULL COMMENT '1 - Prematch\n2 - Outright\n3 - Live',
  `settle_status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - Waitting Settlement; \n1 - Settled',
  `matching_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`betting_lay_id`,`betting_back_id`),
  KEY `fk_betting_matched_bets_betting_bets1_idx` (`betting_lay_id`),
  KEY `fk_betting_matched_bets_betting_bets2_idx` (`betting_back_id`),
  CONSTRAINT `fk_betting_matched_bets_betting_bets1` FOREIGN KEY (`betting_lay_id`) REFERENCES `betting_bets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_betting_matched_bets_betting_bets2` FOREIGN KEY (`betting_back_id`) REFERENCES `betting_bets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `betting_matched_bets`
--

LOCK TABLES `betting_matched_bets` WRITE;
/*!40000 ALTER TABLE `betting_matched_bets` DISABLE KEYS */;
INSERT INTO `betting_matched_bets` VALUES (184,567,566,400.00,200.00,200.00,38,38,4093303,125824,1,0,'2017-01-01 14:41:06'),(185,569,568,400.00,200.00,200.00,38,38,4093304,125824,1,0,'2017-01-01 19:07:28'),(186,572,570,400.00,200.00,200.00,38,38,4093255,125800,1,0,'2017-01-02 11:45:36'),(187,573,571,400.00,200.00,200.00,38,38,4093256,125800,1,0,'2017-01-02 11:45:36');
/*!40000 ALTER TABLE `betting_matched_bets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:42
