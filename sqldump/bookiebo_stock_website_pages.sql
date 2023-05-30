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
-- Table structure for table `website_pages`
--

DROP TABLE IF EXISTS `website_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `website_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `icon` char(20) DEFAULT NULL,
  `type` tinyint(3) unsigned NOT NULL COMMENT '1 - Main Menu\n2 - Account Management Pages\n3 - Static Pages(About etc..)\n4 - Footer Menu\n5 - Social Menu(Friends,Messages)\n\n',
  `priority` tinyint(3) unsigned DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `htaccess` varchar(45) DEFAULT NULL,
  `controller` varchar(45) DEFAULT NULL,
  `link` varchar(55) DEFAULT NULL,
  `onclick` varchar(55) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website_pages`
--

LOCK TABLES `website_pages` WRITE;
/*!40000 ALTER TABLE `website_pages` DISABLE KEYS */;
INSERT INTO `website_pages` VALUES (1,0,'betting',1,0,'{\"en\":\"BETTING\",\"ka\":\"ბეთინგი\"}','index','',NULL,NULL,1),(2,0,NULL,3,0,'{\"en\":\"About Us\",\"ka\":\"ჩვენს შესახებ\"}','about_us','',NULL,NULL,1),(3,0,NULL,2,3,'{\"en\":\"Betting History\",\"ka\":\"ბეთების ისტორია\"}',NULL,NULL,'/{lang}/user/betting_history',NULL,1),(4,15,NULL,2,1,'{\"en\":\"Withdraw Money\",\"ka\":\"თანხის გატანა\"}',NULL,NULL,'/{lang}/user/withdraw',NULL,1),(5,15,NULL,2,2,'{\"en\":\"Deposit Money\",\"ka\":\"თანხის შემოტანა\"}',NULL,NULL,'/{lang}/user/deposit',NULL,1),(6,0,NULL,2,2,'{\"en\":\"Settings\",\"ka\":\"პარამეტრები\"}',NULL,NULL,'/{lang}/user/settings',NULL,1),(7,0,NULL,3,0,'{\"en\":\"How Make Bets\",\"ka\":\"რას გთავაზობთ betstock?\"}','what_is_betstock',NULL,'',NULL,1),(8,0,NULL,3,0,'{\"en\":\"FAQ\",\"ka\":\"ხდკ\"}',NULL,NULL,'/{lang}/blog',NULL,1),(10,0,'social',1,0,'{\"en\":\"PEOPLE\",\"ka\":\"ხალხი და ჯგუფები\"}','social','social',NULL,'openSocial();return false;',1),(11,0,'user',5,3,'{\"en\":\"Friends\",\"ka\":\"მეგობრები\"}',NULL,NULL,'/{lang}/social/friends',NULL,1),(12,0,'envelope',5,2,'{\"en\":\"Messages\",\"ka\":\"შეტყობინებები\"}',NULL,NULL,'/{lang}/social/messages',NULL,1),(13,0,'th-list',5,1,'{\"en\":\"Feed\",\"ka\":\"სტრიმი\"}','social','social',NULL,NULL,1),(14,0,NULL,2,5,'{\"en\":\"Promotions\",\"ka\":\"Rewards/Promotions\"}','rewards','','/{lang}/user/rewards',NULL,1),(15,0,NULL,2,1,'{\"en\":\"Balance Management\",\"ka\":\"ბალანსის მართვა\"}',NULL,NULL,'/{lang}/user/balance_management',NULL,1),(17,15,NULL,2,7,'{\"en\":\"Transfers History\",\"ka\":\"გადარიცხვების ისტორია\"}',NULL,NULL,'/{lang}/user/transfer_history',NULL,1),(18,0,NULL,2,9,'{\"en\":\"Access Log\",\"ka\":\"შემოსვლების ისტორია\"}',NULL,NULL,'/{lang}/user/access_log',NULL,1),(19,0,NULL,4,1,'{\"en\":\"Terms and Conditions\",\"ka\":\"Terms and Conditions\"}','terms_and_conditions',NULL,NULL,NULL,1),(20,0,NULL,4,2,'{\"en\":\"Responsible Betting\",\"ka\":\"Responsible Betting\"}','responsible_betting',NULL,NULL,NULL,1),(21,0,NULL,4,3,'{\"en\":\"Confidentiality\",\"ka\":\"Confidentiality\"}','confidentiality',NULL,NULL,NULL,1),(22,0,'th-list',5,213,'{\"en\":\"All Clubs\",\"ka\":\"კლუბები\"}',NULL,NULL,'/{lang}/social/communities',NULL,1),(23,0,NULL,2,8,'{\"en\":\"Protection\",\"ka\":\"მომხმარებელზე ზრუნვა\"}','protection',NULL,'/{lang}/user/protection',NULL,1),(24,0,NULL,3,6,'{\"en\":\"Trailers\",\"ka\":\"პრომოები\"}','trailers',NULL,NULL,NULL,1),(25,0,NULL,2,0,'{\"en\":\"Nofifications\",\"ka\":\"ნოტიფიკაციები\"}','notifications',NULL,'/{lang}/user/notifications',NULL,1),(26,0,'usd',1,0,'{\"en\":\"Casino\",\"ka\":\"კაზინო\"}','casino','casino',NULL,NULL,0),(27,15,NULL,2,8,'{\"en\":\"Card Details\",\"ka\":\"ბარათები\"}',NULL,NULL,'/{lang}/user/card_details',NULL,1);
/*!40000 ALTER TABLE `website_pages` ENABLE KEYS */;
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
