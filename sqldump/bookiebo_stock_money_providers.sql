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
-- Table structure for table `money_providers`
--

DROP TABLE IF EXISTS `money_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `money_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '1 - Deposit; \n2 - Withdraw',
  `title` varchar(155) NOT NULL,
  `min_amount` text NOT NULL,
  `max_amount` text NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1 - Active; 0 - Hidden;',
  `class_name` varchar(45) NOT NULL COMMENT 'Class Which will handle operations',
  `commission` varchar(100) NOT NULL DEFAULT '0',
  `has_accounts` tinyint(4) DEFAULT '0' COMMENT '1 - Has Account To Process Money Should Add Account First\n0 -  Doesn’t have accounts',
  `supported_currencies` varchar(150) DEFAULT NULL,
  `interface` tinyint(4) DEFAULT NULL COMMENT 'If transaction needs new window or not.\n0 - BackEnd type\n1- FrontEnd type',
  PRIMARY KEY (`id`,`type`,`class_name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `money_providers`
--

LOCK TABLES `money_providers` WRITE;
/*!40000 ALTER TABLE `money_providers` DISABLE KEYS */;
INSERT INTO `money_providers` VALUES (1,1,'Visa/Mastercard','{\"EUR\":10}','{\"EUR\":1000}',1,'securetrading','2',1,'EUR',1),(1,2,'Visa/Mastercard','{\"EUR\":10}','{\"EUR\":1000}',1,'securetrading','2',1,'EUR',1),(2,2,'Bank Transfer','{\"EUR\":10}','{\"EUR\":1000}',1,'wiretransfer','2',1,'EUR',1),(8,1,'Visa/Mastercard - APCO','{\"EUR\":10}','{\"EUR\":1000}',0,'apco','2',0,'EUR,GEL,USD',1),(9,1,'Visa/Mastercard - SecureTrading Pages','{\"EUR\":10}','{\"EUR\":1000}',1,'securetradingpages','2',0,'EUR',1),(10,2,'APCO PayOut','{\"EUR\":10,\"USD\":15}','{\"EUR\":1000,\"USD\":1500}',0,'apco','2',1,'EUR,USD',0),(11,1,'Webmoney','{\"EUR\":1}','{\"EUR\":3000}',0,'apco','2',0,'EUR',1),(12,1,'EcoPayz','{\"EUR\":1}','{\"EUR\":2000}',0,'apco','2',0,'EUR',1),(13,1,'Neteller','{\"EUR\":2}','{\"EUR\":2000}',0,'apco','2',0,'EUR',1),(14,1,'Qiwi wallet','{\"EUR\":1}','{\"EUR\":500}',0,'apco','2',0,'EUR',1),(15,2,'Webmoney','{\"EUR\":1}','{\"EUR\":2000}',0,'apco','2',1,'EUR',0),(16,2,'EcoPayz','{\"EUR\":1}','{\"EUR\":2000}',0,'apco','2',1,'EUR',0),(17,2,'Neteller','{\"EUR\":1}','{\"EUR\":2000}',0,'apco','2',1,'EUR',0),(18,2,'Qiwi wallet','{\"EUR\":1}','{\"EUR\":2000}',0,'apco','2',1,'EUR',0),(19,1,'Skrill','{\"EUR\":1}','{\"EUR\":2000}',0,'apco','2',0,'EUR',1),(20,2,'Skrill','{\"EUR\":1}','{\"EUR\":2000}',0,'apco','2',1,'EUR',0);
/*!40000 ALTER TABLE `money_providers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:40
