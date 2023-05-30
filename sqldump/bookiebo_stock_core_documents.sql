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
-- Table structure for table `core_documents`
--

DROP TABLE IF EXISTS `core_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_users_id` int(11) NOT NULL,
  `core_countries_id` int(11) NOT NULL,
  `identity_type` int(11) NOT NULL COMMENT '1 - Passport\n2 - Driving License\n3 - Personal Card',
  `document_number` varchar(45) NOT NULL,
  `copy_file_path` varchar(255) DEFAULT NULL,
  `IsVerified` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 - Checked\n0 - Not Checked',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`core_users_id`,`core_countries_id`,`identity_type`,`document_number`),
  KEY `fk_core_identitis_core_users1_idx` (`core_users_id`),
  KEY `fk_core_identities_core_countries1_idx` (`core_countries_id`),
  CONSTRAINT `fk_core_identities_core_countries1` FOREIGN KEY (`core_countries_id`) REFERENCES `core_countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_core_identitis_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_documents`
--

LOCK TABLES `core_documents` WRITE;
/*!40000 ALTER TABLE `core_documents` DISABLE KEYS */;
INSERT INTO `core_documents` VALUES (34,1,75,3,'sadsaddsad','uploads/personal_documents/d9674debbe7cef13d6e23da25bc72b799093c163/808969020ce9e5b11d2b4e738f09127e.JPG',1,'2015-06-27 22:51:06'),(35,1,4,3,'123123123123',NULL,0,'2015-09-14 10:27:02'),(36,1,82,2,'11AAbb5554',NULL,0,'2015-11-14 11:19:24'),(37,3,82,3,'01001066580',NULL,0,'2015-12-29 14:26:37'),(38,3,82,2,'01001066890','uploads/personal_documents/8c4079414e4f710043422d236b57bcce81c1dc5d/ff4c16e4eec367a40ad7928491cd090d.png',0,'2015-12-29 14:26:52'),(42,11,136,3,'532476m','uploads/personal_documents/b4b27c400d171840af5c2e3bdc4b96959ebfd0cf/50edd937d4df88e3883afe52e2a0af44.png',0,'2016-02-23 06:36:05'),(43,27,136,3,'000000','uploads/personal_documents/bac4d41d91eef3f2e2cfc9cf36480effa6a2caec/174437e5785c0d77d6d119e8af332719.png',1,'2016-02-24 09:31:31'),(44,1,22,1,'xxxyyyzzz','uploads/personal_documents/d9674debbe7cef13d6e23da25bc72b799093c163/2e17682ca0b294351327b80a54318ec3.png',0,'2016-11-01 09:30:50'),(45,48,82,3,'96876865653543','uploads/personal_documents/09776aed5f5198886f720bb6f7280ced8c741a8b/984d149e6d69e07a90eb0f8e68955a29.PNG',1,'2016-11-16 14:24:32');
/*!40000 ALTER TABLE `core_documents` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:44
