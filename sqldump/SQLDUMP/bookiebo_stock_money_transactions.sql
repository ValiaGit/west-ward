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
-- Table structure for table `money_transactions`
--

DROP TABLE IF EXISTS `money_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `money_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_users_id` int(11) NOT NULL,
  `money_providers_id` int(11) NOT NULL,
  `money_accounts_id` int(11) DEFAULT NULL,
  `transaction_unique_id` varchar(45) NOT NULL,
  `bank_transaction_id` varchar(45) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `cut_amount` int(11) DEFAULT NULL,
  `commission` varchar(10) DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bank_transaction_date` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - Initialisation\n1 - Confirmation\n2 - Canceled\n3 - Filed Transaction\n4 - Needs Revision\n5 - Waiting Wire\n6 - Pending',
  `bank_status` varchar(40) DEFAULT NULL,
  `ip` bigint(20) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL COMMENT '1 - Deposit\n2 - Withdraw',
  `transfer_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 - Card\n2 - Wire',
  `note` varchar(255) DEFAULT NULL,
  `is_manual_adjustment` tinyint(4) DEFAULT '0',
  `core_currencies_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`core_users_id`,`money_providers_id`,`core_currencies_id`),
  UNIQUE KEY `transaction_unique_id_UNIQUE` (`transaction_unique_id`),
  KEY `fk_money_deposits_money_providers1_idx` (`money_providers_id`),
  KEY `fk_money_deposits_core_users1_idx` (`core_users_id`),
  KEY `fk_money_transactions_money_accounts1_idx` (`money_accounts_id`),
  KEY `fk_money_transactions_core_currencies1_idx` (`core_currencies_id`),
  CONSTRAINT `fk_money_deposits_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_money_deposits_money_providers1` FOREIGN KEY (`money_providers_id`) REFERENCES `money_providers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_money_transactions_core_currencies1` FOREIGN KEY (`core_currencies_id`) REFERENCES `core_currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_money_transactions_money_accounts1` FOREIGN KEY (`money_accounts_id`) REFERENCES `money_accounts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=825 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `money_transactions`
--

LOCK TABLES `money_transactions` WRITE;
/*!40000 ALTER TABLE `money_transactions` DISABLE KEYS */;
INSERT INTO `money_transactions` VALUES (390,1,1,41,'aa6568a228b0a414eddf13b706e7b3cf','2-70-7771872',100,102,'2','2016-10-05 17:13:20','2016-10-05 15:13:21',1,'0',1579877202,1,1,NULL,0,0),(420,3,1,42,'22dee6155ff04fc25e431363059e5a33','7-70-6753804',100,102,'2','2016-11-10 16:48:48','2016-11-10 15:48:48',1,'0',2967331104,1,1,NULL,0,1),(488,3,1,42,'86c8ea1da348401f52576ab441de5b9a','6-70-14230924',100,102,'2','2016-11-12 13:10:11','2016-11-12 12:10:11',1,'0',2967331104,1,1,NULL,0,1),(575,49,1,49,'c65659f9214af6245db4e2e9f4be52d0','6-70-14305148',1000,1020,'20','2016-11-16 09:45:36','2016-11-16 08:45:37',1,'0',2967331104,1,1,NULL,0,1),(594,46,1,48,'e4e65de56c2896701fc6380853049e9d','5-70-6859207',1000,1020,'20','2016-11-17 10:40:31','2016-11-17 09:40:31',1,'0',2967331104,1,1,NULL,0,1),(665,47,1,51,'5f81bdfa35f0fc4e0c7dec51a63265d2','2-70-9137884',1000,1020,'20','2016-11-19 07:33:20','2016-11-19 06:33:21',1,'0',2967331104,1,1,NULL,0,1),(822,38,1,57,'7f42d5596d80defdf97b3aafc050f61d','1-70-4717306',3000,3060,'60','2016-12-16 11:25:50','2016-12-16 10:25:51',1,'0',2967331104,1,1,NULL,0,1),(823,110,1,58,'1988946f94bc92f6cdea34129e888396',NULL,1100,NULL,NULL,'2016-12-16 17:34:26',NULL,0,NULL,86855453,1,1,NULL,0,1),(824,110,1,58,'e217762eae2435850ba215e113a571a0','4-70-14925241',1100,1122,'22','2016-12-16 17:36:16','2016-12-16 16:36:16',1,'0',86855453,1,1,NULL,0,1);
/*!40000 ALTER TABLE `money_transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:38
