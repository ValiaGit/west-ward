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
-- Table structure for table `social_friendship`
--

DROP TABLE IF EXISTS `social_friendship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_friendship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_user_id` int(11) NOT NULL,
  `core_user_friend` int(11) NOT NULL,
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(3) unsigned DEFAULT '0' COMMENT '0 - Send\n1 - Approved\n3 - Declined\n',
  `receiver_id` int(10) unsigned NOT NULL,
  `seen` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0 - Unseen; 1 - Seen;',
  PRIMARY KEY (`id`,`core_user_id`,`core_user_friend`),
  KEY `fk_social_friendrequests_core_users1_idx` (`core_user_id`),
  KEY `fk_social_friendrequests_core_users2_idx` (`core_user_friend`),
  CONSTRAINT `fk_social_friendrequests_core_users1` FOREIGN KEY (`core_user_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_friendrequests_core_users2` FOREIGN KEY (`core_user_friend`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_friendship`
--

LOCK TABLES `social_friendship` WRITE;
/*!40000 ALTER TABLE `social_friendship` DISABLE KEYS */;
INSERT INTO `social_friendship` VALUES (129,6,5,'2015-08-02 10:37:01',1,5,1),(130,5,6,'2015-08-02 10:37:01',1,5,1),(145,11,1,'2016-02-23 06:45:30',1,1,1),(146,1,11,'2016-02-23 06:45:30',1,1,1),(149,11,9,'2016-02-23 06:45:42',0,9,0),(150,9,11,'2016-02-23 06:45:42',0,9,0),(151,11,10,'2016-02-23 06:45:43',1,10,1),(152,10,11,'2016-02-23 06:45:43',1,10,1),(153,11,32,'2016-02-23 06:48:50',0,32,1),(154,32,11,'2016-02-23 06:48:50',0,32,1),(157,38,3,'2016-05-21 19:12:34',1,3,1),(158,3,38,'2016-05-21 19:12:34',1,3,1),(159,38,1,'2016-11-05 12:06:47',1,1,1),(160,1,38,'2016-11-05 12:06:47',1,1,1),(161,3,1,'2016-11-07 18:16:51',1,1,1),(162,1,3,'2016-11-07 18:16:51',1,1,1),(163,49,3,'2016-11-16 10:25:32',1,3,1),(164,3,49,'2016-11-16 10:25:32',1,3,1),(165,49,46,'2016-11-19 08:19:18',1,46,1),(166,46,49,'2016-11-19 08:19:18',1,46,1),(167,47,46,'2016-11-19 08:21:03',1,46,1),(168,46,47,'2016-11-19 08:21:03',1,46,1),(169,47,49,'2016-11-19 08:21:11',1,49,1),(170,49,47,'2016-11-19 08:21:11',1,49,1),(171,47,3,'2016-11-19 08:21:19',1,3,0),(172,3,47,'2016-11-19 08:21:19',1,3,0),(173,47,12,'2016-11-19 08:27:16',1,12,0),(174,12,47,'2016-11-19 08:27:16',1,12,0),(175,49,38,'2016-11-19 08:27:46',1,38,1),(176,38,49,'2016-11-19 08:27:46',1,38,1),(179,1,46,'2016-11-19 13:27:13',1,46,1),(180,46,1,'2016-11-19 13:27:13',1,46,1),(181,1,47,'2016-11-19 13:28:02',1,47,1),(182,47,1,'2016-11-19 13:28:02',1,47,1),(183,46,3,'2016-11-21 15:52:29',1,3,1),(184,3,46,'2016-11-21 15:52:29',1,3,1),(185,46,38,'2016-11-29 16:13:48',1,38,1),(186,38,46,'2016-11-29 16:13:48',1,38,1);
/*!40000 ALTER TABLE `social_friendship` ENABLE KEYS */;
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
