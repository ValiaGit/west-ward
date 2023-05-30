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
-- Table structure for table `core_protection_action_queue`
--

DROP TABLE IF EXISTS `core_protection_action_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_protection_action_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - Modify\n2 - Disable',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `affect_time` timestamp NULL DEFAULT NULL COMMENT 'The time when this protection queue action will affect protection.',
  `amount` float DEFAULT NULL,
  `interval_minutes` int(11) DEFAULT NULL,
  `period_id` tinyint(4) DEFAULT NULL,
  `comment` varchar(85) DEFAULT NULL,
  `core_users_has_core_protection_types_id` int(11) NOT NULL,
  `core_users_has_core_protection_types_core_users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`core_users_has_core_protection_types_id`,`core_users_has_core_protection_types_core_users_id`),
  KEY `fk_core_protection_action_queue_core_users_has_core_protect_idx` (`core_users_has_core_protection_types_core_users_id`),
  CONSTRAINT `fk_core_protection_action_queue_core_users_has_core_protectio1` FOREIGN KEY (`core_users_has_core_protection_types_core_users_id`) REFERENCES `core_users_has_core_protection_types` (`core_users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_protection_action_queue`
--

LOCK TABLES `core_protection_action_queue` WRITE;
/*!40000 ALTER TABLE `core_protection_action_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_protection_action_queue` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:43
