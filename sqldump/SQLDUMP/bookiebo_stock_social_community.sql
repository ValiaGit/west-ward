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
-- Table structure for table `social_community`
--

DROP TABLE IF EXISTS `social_community`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `betting_competitors_id` int(11) DEFAULT NULL,
  `logo_path` varchar(125) NOT NULL,
  `cover_path` varchar(125) NOT NULL,
  `icon_path` varchar(125) DEFAULT NULL,
  `background_path` varchar(125) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `creator_user_id` int(11) DEFAULT NULL,
  `betting_sport_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `betting_teams_id_UNIQUE` (`betting_competitors_id`),
  KEY `fk_social_community_betting_teams1_idx` (`betting_competitors_id`),
  KEY `fk_social_community_betting_sport1_idx` (`betting_sport_id`),
  CONSTRAINT `fk_social_community_betting_sport1` FOREIGN KEY (`betting_sport_id`) REFERENCES `betting_sport` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_social_community_betting_teams1` FOREIGN KEY (`betting_competitors_id`) REFERENCES `betting_competitors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_community`
--

LOCK TABLES `social_community` WRITE;
/*!40000 ALTER TABLE `social_community` DISABLE KEYS */;
INSERT INTO `social_community` VALUES (1,'Sumo Club',NULL,'12345.jpg','28e4126fcd694b35c4742e4fd4ab0707.jpg',NULL,NULL,1,38,NULL),(2,'Bayern Munchen',NULL,'5ecb93e70bfc2116133b349c8a956920.jpg','5ecb93e70bfc2116133b349c8a956920.jpg',NULL,NULL,0,46,NULL),(3,'Bayern Munchen',NULL,'6a9353673a449b8ad68e24d95cc83a5d.jpg','6a9353673a449b8ad68e24d95cc83a5d.jpg',NULL,NULL,0,46,NULL),(4,'Bayern Munchen',NULL,'1b300afa0126293f1de5ba0db1cf06ce.jpg','1b300afa0126293f1de5ba0db1cf06ce.jpg',NULL,NULL,0,46,NULL),(5,'Bayern Munchen',NULL,'f12d149d7084b0572803e99b3896508c.jpg','f12d149d7084b0572803e99b3896508c.jpg',NULL,NULL,0,46,NULL),(6,'Bayern Munchen',NULL,'f12d149d7084b0572803e99b3896508c.jpg','f12d149d7084b0572803e99b3896508c.jpg',NULL,NULL,0,46,NULL),(7,'Bayern Munchen',NULL,'3f5cbe8f4a5ee6e6122ed79c76698a6c.jpg','3f5cbe8f4a5ee6e6122ed79c76698a6c.jpg',NULL,NULL,0,46,NULL),(8,'Bayern Munchen',NULL,'3f5cbe8f4a5ee6e6122ed79c76698a6c.jpg','3f5cbe8f4a5ee6e6122ed79c76698a6c.jpg',NULL,NULL,0,46,NULL),(9,'Bayern Munchen',NULL,'0a7ba5cfeb58145120b7bb37918b4770.jpg','0a7ba5cfeb58145120b7bb37918b4770.jpg',NULL,NULL,0,46,NULL),(10,'Bayern Munchen',NULL,'0a7ba5cfeb58145120b7bb37918b4770.jpg','0a7ba5cfeb58145120b7bb37918b4770.jpg',NULL,NULL,0,46,NULL),(11,'Bayern Munchen',NULL,'0a7ba5cfeb58145120b7bb37918b4770.jpg','0a7ba5cfeb58145120b7bb37918b4770.jpg',NULL,NULL,0,46,NULL),(12,'JUDO',NULL,'555ed4c2188eec2d75bacd5b7fe7eaa9.jpg','555ed4c2188eec2d75bacd5b7fe7eaa9.jpg',NULL,NULL,0,46,NULL),(13,'JUDO',NULL,'c6c0e8afcb30df14a6e20283d84b02a2.jpg','c6c0e8afcb30df14a6e20283d84b02a2.jpg',NULL,NULL,0,46,NULL),(14,'JUDO',NULL,'f40e9d3ce5e5eb92d5fd1766832d5452.jpg','f40e9d3ce5e5eb92d5fd1766832d5452.jpg',NULL,NULL,0,46,NULL),(15,'JUDO',NULL,'0e531dbd81dcc53e704f0e5c8ebdbccc.jpg','0e531dbd81dcc53e704f0e5c8ebdbccc.jpg',NULL,NULL,0,46,NULL),(16,'JUDO',NULL,'0e531dbd81dcc53e704f0e5c8ebdbccc.jpg','0e531dbd81dcc53e704f0e5c8ebdbccc.jpg',NULL,NULL,0,46,NULL),(17,'JUDO',NULL,'b0d68816424dc326bbdaa35c863c479e.jpg','b0d68816424dc326bbdaa35c863c479e.jpg',NULL,NULL,0,46,NULL),(18,'JUDO',NULL,'b0d68816424dc326bbdaa35c863c479e.jpg','b0d68816424dc326bbdaa35c863c479e.jpg',NULL,NULL,0,46,NULL),(19,'JP Baseball',NULL,'8cc20245a9aa9e05564d5cdbaee5c89c.jpg','8cc20245a9aa9e05564d5cdbaee5c89c.jpg',NULL,NULL,0,38,NULL),(20,'JP Baseball',NULL,'41216345fc031a114098d292fa289170.jpg','41216345fc031a114098d292fa289170.jpg',NULL,NULL,0,38,NULL),(21,'JP Baseball',NULL,'2a2392d555f98cb2be5f6864fa4ca0f1.jpg','2a2392d555f98cb2be5f6864fa4ca0f1.jpg',NULL,NULL,0,38,NULL),(22,'JP Baseball',NULL,'2a2392d555f98cb2be5f6864fa4ca0f1.jpg','2a2392d555f98cb2be5f6864fa4ca0f1.jpg',NULL,NULL,0,38,NULL),(23,'JP Baseball',NULL,'9bb36323a9f03774087a024e2965026d.jpg','9bb36323a9f03774087a024e2965026d.jpg',NULL,NULL,0,38,NULL),(24,'JP Baseball',NULL,'d1d9de17ed4a010980a66390ebbe9ffa.jpg','d1d9de17ed4a010980a66390ebbe9ffa.jpg',NULL,NULL,0,38,NULL),(25,'JP Baseball',NULL,'150859b07c6ea5cf39ed458c1e2a84bd.jpg','150859b07c6ea5cf39ed458c1e2a84bd.jpg',NULL,NULL,0,38,NULL),(26,'JP Baseball',NULL,'6a72629731c99d6d5e4f2397aabdb356.jpg','6a72629731c99d6d5e4f2397aabdb356.jpg',NULL,NULL,0,38,NULL),(27,'JP Baseball',NULL,'6a72629731c99d6d5e4f2397aabdb356.jpg','6a72629731c99d6d5e4f2397aabdb356.jpg',NULL,NULL,0,38,NULL);
/*!40000 ALTER TABLE `social_community` ENABLE KEYS */;
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
