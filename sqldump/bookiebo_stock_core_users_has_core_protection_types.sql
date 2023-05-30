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
-- Table structure for table `core_users_has_core_protection_types`
--

DROP TABLE IF EXISTS `core_users_has_core_protection_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_users_has_core_protection_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_users_id` int(11) NOT NULL,
  `core_protection_types_id` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `expire_date` datetime NOT NULL,
  `is_repeatable` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - Not Iterable One Time\n1 - Iterable Gets Zero On Every Iteration\n\nIterable Means That is is repeated',
  `period_minutes` float NOT NULL COMMENT 'I f current protection is iterable=true, than we should same period minutes, when every iteration end we should add this minutes, to active_until value. This will reactivate Protection.',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `repeat_count` tinyint(4) DEFAULT '0',
  `period_id` tinyint(4) DEFAULT NULL COMMENT '//Dates Fixed 1=>array("title"=>"24 Hours","minutes"=>1440), 2=>array("title"=>"48 Hours","minutes"=>2880), 4=>array("title"=>"7 Days","minutes"=>10080), 5=>array("title"=>"30 Days","minutes"=>40320), 6=>array("title"=>"6 Months","minutes"=>241920),  //Dates Repeatable 7=>array("title"=>"Per Day","minutes"=>1440), 8=>array("title"=>"Per Week","minutes"=>10080), 9=>array("title"=>"Per Month","minutes"=>40320), 10=>array("title"=>"Per Year","minutes"=>483800)\n',
  PRIMARY KEY (`id`,`core_users_id`,`core_protection_types_id`),
  KEY `fk_core_users_has_core_protection_types_core_users1_idx` (`core_users_id`),
  KEY `fk_core_users_has_core_protection_types_core_protection_typ_idx` (`core_protection_types_id`),
  CONSTRAINT `fk_core_users_has_core_protection_types_core_protection_types1` FOREIGN KEY (`core_protection_types_id`) REFERENCES `core_protection_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_core_users_has_core_protection_types_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_users_has_core_protection_types`
--

LOCK TABLES `core_users_has_core_protection_types` WRITE;
/*!40000 ALTER TABLE `core_users_has_core_protection_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `core_users_has_core_protection_types` ENABLE KEYS */;
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
