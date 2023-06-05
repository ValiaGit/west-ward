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
-- Table structure for table `social_messages`
--

DROP TABLE IF EXISTS `social_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_users_sender` int(11) NOT NULL,
  `core_users_receiver` int(11) NOT NULL,
  `status` tinyint(3) unsigned DEFAULT '0' COMMENT '0 - New\n1 - Seen',
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text,
  PRIMARY KEY (`id`,`core_users_sender`,`core_users_receiver`),
  KEY `fk_social_messages_core_users1_idx` (`core_users_sender`),
  KEY `fk_social_messages_core_users2_idx` (`core_users_receiver`),
  CONSTRAINT `fk_social_messages_core_users1` FOREIGN KEY (`core_users_sender`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_messages_core_users2` FOREIGN KEY (`core_users_receiver`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_messages`
--

LOCK TABLES `social_messages` WRITE;
/*!40000 ALTER TABLE `social_messages` DISABLE KEYS */;
INSERT INTO `social_messages` VALUES (119,3,1,0,'2016-11-05 11:07:42','hi'),(120,3,1,0,'2016-11-05 11:08:00','hELLO'),(121,3,1,0,'2016-11-05 11:08:11','how are you shako today?'),(122,1,3,0,'2016-11-05 11:08:29','hi shako'),(123,3,1,0,'2016-11-07 18:16:05','hi'),(124,3,1,0,'2016-11-07 18:16:10','komis rogor xar?'),(125,1,3,0,'2016-11-07 18:16:26','hah?'),(126,3,38,0,'2016-11-16 10:25:39','Hi'),(127,3,49,0,'2016-11-16 10:26:42','Hi gio'),(128,3,1,0,'2016-11-16 10:27:13','This is complicated '),(129,49,3,0,'2016-11-17 10:34:32','hi peter \r\nam beting on judo pls join'),(130,46,49,0,'2016-11-19 08:25:37','lets play bro'),(131,49,46,0,'2016-11-19 08:30:01','fk u brother'),(132,49,47,0,'2016-11-19 08:30:42','hi azer\r\n'),(133,47,49,0,'2016-11-26 11:02:39','test ');
/*!40000 ALTER TABLE `social_messages` ENABLE KEYS */;
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
