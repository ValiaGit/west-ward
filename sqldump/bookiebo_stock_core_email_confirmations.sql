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
-- Table structure for table `core_email_confirmations`
--

DROP TABLE IF EXISTS `core_email_confirmations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_email_confirmations` (
  `core_users_id` int(11) NOT NULL,
  `confirmation_code` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`core_users_id`),
  UNIQUE KEY `core_users_id_UNIQUE` (`core_users_id`),
  KEY `fk_email_confirmations_core_users1_idx` (`core_users_id`),
  CONSTRAINT `fk_email_confirmations_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_email_confirmations`
--

LOCK TABLES `core_email_confirmations` WRITE;
/*!40000 ALTER TABLE `core_email_confirmations` DISABLE KEYS */;
INSERT INTO `core_email_confirmations` VALUES (9,'cb65571879ac8867d420545dbdd9f04d','2015-09-11 09:42:24'),(31,'76588197cfdb6ab90921afa22acbfce6','2016-02-18 11:33:50'),(33,'756f158a926b6ace642c577cb1d150bf','2016-02-24 11:24:03'),(34,'b002644dc8fabe55b7c5deba825be87b','2016-02-24 11:27:23'),(37,'614ab59703045630d885dbe28a04a65c','2016-03-10 15:49:37'),(38,'f18dbf2672cc775bf4552bab9608f0ef','2016-05-21 19:07:37'),(39,'4b4767638787cf5252bacce6643e9978','2016-05-28 12:23:58'),(42,'4fbaa34ad95339cf2f0d37e42c8005e8','2016-07-26 10:09:31'),(43,'32181ae75a964c983a80a554007de63c','2016-07-26 10:14:09'),(44,'52f9375af737f1b6cc6e4aabb9614f2d','2016-08-04 04:13:11'),(45,'1dfc98f781024cb0da6f25e140fdcfa8','2016-09-07 11:52:49'),(100,'828adc9fd8dd15ed8a5f3414f1326b1b','2016-11-26 11:48:22'),(103,'e07fce361f7bb4bbaa8ced29b666dcd4','2016-11-29 16:44:06'),(104,'e521f9aaefcb37501280ece04d31d2c1','2016-12-04 12:53:32'),(105,'0cf50c3b3099f5dbb14fa7f5051090d2','2016-12-05 01:52:08'),(106,'c8c2a595c9876f2e2cb5f3947f95d101','2016-12-05 08:42:38'),(109,'4df034f5847cab5e5306ee090621ba91','2016-12-16 17:30:30'),(119,'a530fc030755586afc16e422845cc6d9','2017-01-09 03:09:23');
/*!40000 ALTER TABLE `core_email_confirmations` ENABLE KEYS */;
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
