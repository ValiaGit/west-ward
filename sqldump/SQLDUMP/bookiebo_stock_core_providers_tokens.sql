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
-- Table structure for table `core_providers_tokens`
--

DROP TABLE IF EXISTS `core_providers_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_providers_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `core_providers_id` int(10) unsigned NOT NULL,
  `core_users_id` int(11) NOT NULL,
  `guid` char(36) NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`core_providers_id`,`core_users_id`),
  UNIQUE KEY `guid_UNIQUE` (`guid`),
  KEY `fk_core_providers_tokens_core_providers1_idx` (`core_providers_id`),
  KEY `fk_core_providers_tokens_core_users1_idx` (`core_users_id`),
  CONSTRAINT `fk_core_providers_tokens_core_providers1` FOREIGN KEY (`core_providers_id`) REFERENCES `core_providers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_core_providers_tokens_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4947 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_providers_tokens`
--

LOCK TABLES `core_providers_tokens` WRITE;
/*!40000 ALTER TABLE `core_providers_tokens` DISABLE KEYS */;
INSERT INTO `core_providers_tokens` VALUES (2985,4,103,'d382e482-c653-46f7-a13e-da57ca449c1f','2016-12-01 10:15:34',2967331104),(3542,4,107,'73503b15-2815-4972-b40c-f36130210cd5','2016-12-05 10:30:39',1360090238),(3623,4,106,'77c96b4e-7bdd-4ec1-bd84-352c2eaf61c2','2016-12-05 13:25:32',622469895),(3935,4,46,'ea31ca6c-231e-495f-ae56-3831f5e727f2','2016-12-12 14:51:08',529723790),(4334,4,3,'a612643a-aa48-4b5b-a83d-aeb88f76972e','2016-12-15 16:33:33',2967331104),(4354,4,108,'b8ef0d29-6325-4d8e-be07-3a39daef8039','2016-12-15 17:30:52',3584067510),(4522,4,109,'933c7aba-fc93-402e-ba16-a264aafced1c','2016-12-16 18:31:17',86855453),(4541,4,110,'d14ace57-5bc0-4fe5-b0db-83d15c9e88b5','2016-12-16 18:37:32',86855453),(4663,4,111,'550c5ed5-7af2-460e-aa47-f97952c80a84','2016-12-20 13:18:23',3452720104),(4791,4,47,'71cbf54d-e298-4a9a-9cd2-53c19aaaf47a','2016-12-27 09:28:43',3642302095),(4863,4,48,'7500b832-c7b8-448d-89eb-2af09391303c','2017-01-02 12:49:55',1583672585),(4892,4,38,'806a9378-2616-4fac-af8e-73ea6b6d5a79','2017-01-08 10:22:24',1389598018),(4931,3,1,'c5f009ea-0f91-4bf2-ae4a-5c249dfde486','2017-01-13 09:52:40',0),(4938,5,1,'8ce6926e-a474-4ced-ade4-a8dc5f7e898f','2017-01-13 10:23:03',0),(4946,4,1,'4a16169d-77fd-48d3-83ff-235ef692c28a','2017-01-13 10:52:34',0);
/*!40000 ALTER TABLE `core_providers_tokens` ENABLE KEYS */;
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
