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
-- Table structure for table `core_password_reset_tokens`
--

DROP TABLE IF EXISTS `core_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_password_reset_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_users_id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expire_time` datetime NOT NULL COMMENT 'Time When This Token Will Be Expired',
  PRIMARY KEY (`id`,`core_users_id`),
  UNIQUE KEY `core_users_id_UNIQUE` (`core_users_id`),
  KEY `fk_core_password_reset_tokens_core_users1_idx` (`core_users_id`),
  CONSTRAINT `fk_core_password_reset_tokens_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_password_reset_tokens`
--

LOCK TABLES `core_password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `core_password_reset_tokens` DISABLE KEYS */;
INSERT INTO `core_password_reset_tokens` VALUES (71,32,'3dc23dd910a6034a911ca396b7b9bcd3','2016-02-22 02:59:24'),(83,1,'d6a2fc8c90fa7a16e8c078a66bf80d50','2016-11-29 06:09:31');
/*!40000 ALTER TABLE `core_password_reset_tokens` ENABLE KEYS */;
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
