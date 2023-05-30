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
-- Table structure for table `money_accounts`
--

DROP TABLE IF EXISTS `money_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `money_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_users_id` int(11) NOT NULL,
  `money_providers_id` int(11) NOT NULL,
  `AccountReference` varchar(45) DEFAULT NULL,
  `OrderReference` varchar(75) DEFAULT NULL,
  `RequestReference` varchar(45) DEFAULT NULL,
  `Pan` varchar(45) DEFAULT NULL COMMENT 'For Card\nCardId Numbers\n\nFor Wire\nAccountNumber',
  `IssuerCountry` varchar(3) DEFAULT NULL,
  `Active` tinyint(4) DEFAULT NULL,
  `AddDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Type` varchar(15) DEFAULT NULL,
  `IsDeleted` tinyint(2) NOT NULL DEFAULT '0',
  `account_type` tinyint(4) DEFAULT '1' COMMENT '1 - Card,2 - Bank Account',
  `BankName` varchar(45) DEFAULT NULL,
  `BankAccount` varchar(45) DEFAULT NULL,
  `BankCode` varchar(45) DEFAULT NULL,
  `Payee` varchar(45) DEFAULT NULL,
  `SwiftCode` varchar(45) DEFAULT NULL,
  `ConfirmationStatus` tinyint(4) DEFAULT '0' COMMENT 'Default Status Is Not Confirmed',
  PRIMARY KEY (`id`,`core_users_id`,`money_providers_id`),
  KEY `fk_money_cards_core_users1_idx` (`core_users_id`),
  KEY `fk_money_accounts_money_providers1_idx` (`money_providers_id`),
  CONSTRAINT `fk_money_accounts_money_providers1` FOREIGN KEY (`money_providers_id`) REFERENCES `money_providers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_money_cards_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `money_accounts`
--

LOCK TABLES `money_accounts` WRITE;
/*!40000 ALTER TABLE `money_accounts` DISABLE KEYS */;
INSERT INTO `money_accounts` VALUES (41,1,1,'6-52-1531915','c8e39629daed454a0a1465843273e8cfc8682fac','W6-v1jrhdp5','516746######3246','GE',1,'2016-10-05 17:12:56','MASTERCARD',0,1,NULL,NULL,NULL,'Shalva Kakauridze',NULL,0),(42,3,1,'5-52-1284752','ea271b6bb99cfeef8dda617db9cecfe3431c5430','W5-x0yn7hte','515881######2469','GE',1,'2016-11-10 16:46:27','MASTERCARD',1,1,NULL,NULL,NULL,'peter seisenbacher',NULL,0),(43,1,10,'39743898','340a5a3a8f5bf1e7c3334cdaca9abdbb',NULL,'444444,4444',NULL,1,'2016-11-11 05:51:19','Visa',0,1,NULL,NULL,NULL,'Shalva Kakauridze',NULL,1),(44,38,1,'5-52-1286227','71e89f6451a367348109db7e59796fa672ebf356','W5-7wmtnu94','411634######2842','GE',1,'2016-11-12 15:04:39','VISA',0,1,NULL,NULL,NULL,'kyoh kunishio',NULL,0),(48,46,1,'7-52-1076750','496f1131e347cc2257ccc258daa923719c79e57e','W7-2pdcbcae','414051######4077','GE',1,'2016-11-16 09:41:46','VISA',0,1,NULL,NULL,NULL,'David Bordzikuli',NULL,0),(49,49,1,'4-52-1591995','215a005751a4c1990d62df55ff2ba1c87c165c7b','W4-807ay7a4','464520######1131','GE',1,'2016-11-16 09:42:00','VISA',0,1,NULL,NULL,NULL,'giorgi aleksidze',NULL,0),(50,48,10,'39826703','0afe4e464368f33f745188d27b2d33ef',NULL,'444444,4444',NULL,1,'2016-11-16 02:08:12','Visa',0,1,NULL,NULL,NULL,'Giorgi Berikelashvili',NULL,1),(51,47,1,'2-52-1045413','385f75cd95c47a35411cda5e768a66a0c3e7c683','W2-91x6x9jg','526998######2971','AZ',1,'2016-11-19 07:33:01','MASTERCARD',0,1,NULL,NULL,NULL,'Azer Novruzov',NULL,0),(52,1,10,'39889931','01ef09896f56ed7335d731c5de1fc65e',NULL,'',NULL,1,'2016-11-20 09:08:42','',0,1,NULL,NULL,NULL,'',NULL,0),(53,48,17,'39903481','d64ee0cb17083b725ab8db22a9d7be4f',NULL,'',NULL,1,'2016-11-21 09:35:19','',0,1,NULL,NULL,NULL,'',NULL,0),(54,48,17,'39907759','21a8fc5a8a8e1f070fd8eb85ccc93876',NULL,'453501020503',NULL,1,'2016-11-21 01:16:57','',0,1,NULL,NULL,NULL,'',NULL,1),(55,48,18,'39909629','f18ba49f180be91f418c933eed4fd123',NULL,'',NULL,1,'2016-11-21 01:52:03','',0,1,NULL,NULL,NULL,'',NULL,0),(56,48,20,'39926450','c23efadab7f68b2d42162fe954a00075',NULL,'pspsupport@apco.com.mt',NULL,1,'2016-11-22 09:24:49','',0,1,NULL,NULL,NULL,'',NULL,0),(57,38,1,'4-52-1618807','d6e810f3689e04567520d9348293b10c3ef50948','W4-5u75919w','430190######8739','GE',1,'2016-12-16 11:25:30','VISA',0,1,NULL,NULL,NULL,'kyoh kunishio',NULL,0),(58,110,1,'2-52-1068305','79fe9725e78927032582ce165e30d44c1143866f','W2-j86a3jqd','516930######9323','UA',1,'2016-12-16 17:34:02','VISA',0,1,NULL,NULL,NULL,'Stepan Stepanov',NULL,0);
/*!40000 ALTER TABLE `money_accounts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:39
