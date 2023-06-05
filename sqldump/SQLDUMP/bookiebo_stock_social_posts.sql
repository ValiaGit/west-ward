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
-- Table structure for table `social_posts`
--

DROP TABLE IF EXISTS `social_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_users_id` int(11) NOT NULL,
  `social_community_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1 - Text; 2 - Image',
  `image` varchar(155) NOT NULL,
  PRIMARY KEY (`id`,`core_users_id`),
  KEY `fk_social_posts_core_users1_idx` (`core_users_id`),
  KEY `community` (`social_community_id`),
  CONSTRAINT `fk_social_posts_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_posts`
--

LOCK TABLES `social_posts` WRITE;
/*!40000 ALTER TABLE `social_posts` DISABLE KEYS */;
INSERT INTO `social_posts` VALUES (250,1,0,'done1','2015-06-25 22:10:26',1,'0'),(253,1,0,'asdasdasd','2015-07-01 20:28:58',2,'bd407b1b719b57562ea4154404b04e21.png'),(256,6,0,'hi there','2015-08-03 10:21:54',1,'0'),(257,3,0,'test post','2015-09-04 23:58:38',1,'0'),(258,12,0,'fghdthjzjzjtzj','2015-11-14 10:17:20',1,'0'),(259,12,0,'fghdthjzjzjtzj','2015-11-14 10:17:48',1,'0'),(260,1,0,'this is my dayy!!!','2015-11-15 08:00:33',1,'0'),(261,3,0,'ghjdtzukzukrfzukfukkrfik','2016-01-01 10:02:13',1,'0'),(264,3,0,'Hello My Friends','2016-02-11 21:01:48',1,'0'),(266,1,0,'https://www.youtube.com/watch?v=dW7n2UP60bk','2016-05-21 19:39:58',1,'0'),(267,3,0,'rghjtk75ik68k68k6','2016-06-21 08:56:23',2,'89da7c20f911401997bff72211d5b0a6.jpg'),(268,38,1,'Hello Friend','2016-11-05 12:05:20',1,'0'),(270,38,0,'The Sumo Tournament begins on Sunday 13 Nov.','2016-11-12 12:33:07',2,'da01aebaff730a9ab66dfd921851a824.png'),(273,38,0,'Yokozuna Hakuho, Congratulations for his 1000th win!','2016-11-15 13:12:12',2,'605b0b6dda1fda03f99ca62a7891e476.png'),(275,38,1,'Day 5 Information! You can refer to the Bet Exchange Matches.','2016-11-16 13:44:03',2,'c93b0b4942d89678b90179a903516828.png'),(285,38,1,'Highlight Day 8! Only Kakuryu No Loss until today!','2016-11-19 13:32:27',2,'024be8ab84def5362b68a6bf16657ce1.png'),(286,38,1,'Kyushu Day 10, Kakuryu is still no Loss','2016-11-21 09:31:41',2,'47f8e1733028336c9e6c77ffefa82b24.png'),(287,38,1,'Tournament Winner gets big Macaroon!','2016-11-23 11:14:20',2,'4ac911be80e0b50b73ef01c1a6bbb895.png'),(288,38,1,'After winning, these 22 Gold Macaroons will be delivered to the Winner!','2016-11-23 11:18:38',2,'c5781ff2819f8679ffe90d8395274ad6.png'),(289,38,0,'Tournament Winner gets Gold Macaroon as well!','2016-11-23 11:20:12',2,'5791b279b9bd64e6fab64f9b055b81d7.png'),(290,38,1,'Yokozuna Kakuryu won the Kyushu Tournament on Day 14, as Harumafuji and Kisenosato lost.','2016-11-27 07:16:41',2,'25156a23d8997800353cec7b0a29832d.png'),(291,38,1,'Kyushu Day 14 evening, Kakuryu celebrated his Win with Red-snapper!!','2016-11-27 07:22:54',2,'e52ba74c4e8cc6ca426fa68ac7e44659.png'),(292,38,0,'Victory and Red-snapper in Japan!','2016-11-27 07:25:47',2,'5f84c636b62ac1ee78c654a659a98fab.png'),(296,38,1,'https://youtu.be/RuayS5uPRCU','2016-11-29 09:02:01',2,'5d43092d8a2d3df7e795c0e7b821cee1.png');
/*!40000 ALTER TABLE `social_posts` ENABLE KEYS */;
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
