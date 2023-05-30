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
-- Table structure for table `betting_bets`
--

DROP TABLE IF EXISTS `betting_bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betting_bets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `betting_match_odds_id` int(11) DEFAULT NULL,
  `betting_outright_odds_id` int(11) DEFAULT NULL,
  `core_users_id` int(11) NOT NULL,
  `bets_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bet_type` tinyint(3) unsigned NOT NULL COMMENT '1 - Lay; 2 - Back',
  `bet_amount` int(11) NOT NULL,
  `bet_odd` decimal(10,2) NOT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '0 - Bet Made\n1 - Fully Matched\n2 - Partly Matched\n3 - Won\n4 - Lose\n5 - Canceled Received Money Back\n6 - Partly Canceled\n7 - Partly Canceled Lost\n9 - Partly Canceled Won\n10 - Not Matched Returned Money\n11 - Private Rejected\n12 - Provate Accepted',
  `unmatched_amount` int(11) NOT NULL,
  `is_private` tinyint(4) DEFAULT NULL,
  `resulted` int(11) NOT NULL DEFAULT '0' COMMENT '1 - Resulted\n0 - Not Resulted',
  `resulted_date` timestamp NULL DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - Match;\n2 - Outright\n3 - Superlive',
  `odd_name` int(11) DEFAULT NULL,
  `selection` int(11) DEFAULT NULL,
  `match_name` varchar(800) DEFAULT NULL,
  `profit_lose` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deducted_commission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Commission that was cut for winner bet',
  `returned_unmatched_amount` decimal(10,2) DEFAULT '0.00' COMMENT 'If Some Part OF Bet Was Returned We Save Here Amount What Was Returned.',
  `balance_before_bet` float DEFAULT NULL,
  `balance_after_settlement` float DEFAULT NULL,
  `row_last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `session_id` varbinary(150) DEFAULT NULL,
  PRIMARY KEY (`id`,`core_users_id`),
  KEY `fk_betting_bets_betting_match_odds1_idx` (`betting_match_odds_id`),
  KEY `fk_betting_bets_core_users1_idx` (`core_users_id`),
  KEY `type` (`bet_type`),
  KEY `odd` (`bet_odd`),
  KEY `fk_betting_bets_betting_outright_odds1_idx` (`betting_outright_odds_id`),
  CONSTRAINT `fk_betting_bets_betting_match_odds1` FOREIGN KEY (`betting_match_odds_id`) REFERENCES `betting_match_odds` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_betting_bets_betting_outright_odds1` FOREIGN KEY (`betting_outright_odds_id`) REFERENCES `betting_outright_odds` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_betting_bets_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=574 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `betting_bets`
--

LOCK TABLES `betting_bets` WRITE;
/*!40000 ALTER TABLE `betting_bets` DISABLE KEYS */;
INSERT INTO `betting_bets` VALUES (566,4093303,NULL,38,'2017-01-01 14:41:06',2,200,2.00,1,0,0,0,NULL,1,NULL,NULL,NULL,0.00,0.00,0.00,3008,NULL,'2017-01-01 14:41:06','245SQTREV3B65KcqhlY7fQ=='),(567,4093303,NULL,38,'2017-01-01 14:41:06',1,200,2.00,1,0,0,0,NULL,1,NULL,NULL,NULL,0.00,0.00,0.00,2808,NULL,'2017-01-01 14:41:06','245SQTREV3B65KcqhlY7fQ=='),(568,4093304,NULL,38,'2017-01-01 19:07:28',2,200,2.00,1,0,0,0,NULL,1,NULL,NULL,NULL,0.00,0.00,0.00,2608,NULL,'2017-01-01 19:07:28','EefOcOfzJ5ve22SLsSNS+g=='),(569,4093304,NULL,38,'2017-01-01 19:07:28',1,200,2.00,1,0,0,0,NULL,1,NULL,NULL,NULL,0.00,0.00,0.00,2408,NULL,'2017-01-01 19:07:28','EefOcOfzJ5ve22SLsSNS+g=='),(570,4093255,NULL,38,'2017-01-02 11:45:36',2,200,2.00,1,0,0,0,NULL,1,NULL,NULL,NULL,0.00,0.00,0.00,2208,NULL,'2017-01-02 11:45:36','Zzx9lOo55WHusc+JUUxKLQ=='),(571,4093256,NULL,38,'2017-01-02 11:45:36',2,200,2.00,1,0,0,0,NULL,1,NULL,NULL,NULL,0.00,0.00,0.00,2008,NULL,'2017-01-02 11:45:36','Zzx9lOo55WHusc+JUUxKLQ=='),(572,4093255,NULL,38,'2017-01-02 11:45:36',1,200,2.00,1,0,0,0,NULL,1,NULL,NULL,NULL,0.00,0.00,0.00,1808,NULL,'2017-01-02 11:45:36','Zzx9lOo55WHusc+JUUxKLQ=='),(573,4093256,NULL,38,'2017-01-02 11:45:36',1,200,2.00,1,0,0,0,NULL,1,NULL,NULL,NULL,0.00,0.00,0.00,1608,NULL,'2017-01-02 11:45:36','Zzx9lOo55WHusc+JUUxKLQ==');
/*!40000 ALTER TABLE `betting_bets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:41
