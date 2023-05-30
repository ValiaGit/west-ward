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
-- Table structure for table `betting_oddtypes`
--

DROP TABLE IF EXISTS `betting_oddtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betting_oddtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BetradarOddsTypeID` char(3) NOT NULL DEFAULT '',
  `title` varchar(155) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '0-Disabled;1-Active',
  `TeamReplace` tinyint(4) DEFAULT '0',
  `priority` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`BetradarOddsTypeID`),
  UNIQUE KEY `BetradarOddsTypeID_UNIQUE` (`BetradarOddsTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `betting_oddtypes`
--

LOCK TABLES `betting_oddtypes` WRITE;
/*!40000 ALTER TABLE `betting_oddtypes` DISABLE KEYS */;
INSERT INTO `betting_oddtypes` VALUES (3,'10','Match Odds',1,1,0),(4,'1','title-1',1,0,0),(5,'2','Correct score',1,0,0),(6,'317','Home to score in both halves?',1,0,0),(7,'329','2nd Half - Both Teams to score',1,0,0),(8,'353','Totals home team',1,0,0),(9,'401','2nd Half - Clean sheet away team',1,0,0),(10,'409','Awaywin to Nil',1,0,0),(11,'42','1st Half – Odds',1,0,0),(12,'203','1st Half - Correct Score',1,0,0),(13,'51','Asian Hand- icaps',1,0,0),(14,'237','1st Half Total Number of Bookings',1,0,0),(15,'246','First Team Booked',1,0,0),(16,'254','Home Team Player\rSent Off',1,0,0),(17,'264','Penalty shootout',1,0,0),(18,'275','1st Half Corner Handicap',1,0,0),(19,'285','2nd Half Totals',1,0,0),(20,'288','title-288',1,0,0),(21,'320','Away to score in both halves?',1,0,0),(22,'332','Correct score (incl. Other)',1,0,0),(23,'404','2nd Half - First Team to score',1,0,0),(24,'411','Odd/Even away team',1,0,0),(25,'45','Odd/Even Goals',1,0,0),(26,'209','Matchflow',1,0,0),(27,'54','1st Half Asian Totals',1,0,0),(28,'240','Player sent off?',1,0,0),(29,'249','1st Half Match Bookings',1,0,0),(30,'259','2nd Half Odds',1,0,0),(31,'268','Clean Sheet Away Team',1,0,0),(32,'280','title-280',1,0,0),(33,'315','Home to win both halves?',1,0,0),(34,'324','1st Half Draw no Bet',1,0,0),(35,'390','1st Half - First Team to score',1,0,0),(36,'407','Away no bet',1,0,0),(37,'48','Goals Home Team',1,0,0),(38,'222','Winning Margins',1,0,0),(39,'244','Number of Bookings Away',1,0,0),(40,'252','Exact Bookings',1,0,0),(41,'262','Half Time / Full Time Correct Score',1,0,0),(42,'271','2nd Half Total Goals',1,0,0),(43,'283','title-283',1,0,0),(44,'318','Away to win both halves?',1,0,0),(45,'330','Highest Scoring Half Home team',1,0,0),(46,'393','1st Half - Totals away team',1,0,0),(47,'41','First Team to Score',1,0,0),(48,'43','Both Teams to Score',1,0,0),(49,'207','Highest Scoring Half',1,0,0),(50,'52','Asian Totals',1,0,0),(51,'238','Total Number of Booking Points',1,0,0),(52,'247','1st Half First Team Booked',1,0,0),(53,'256','Away Team Player Sent Off',1,0,0),(54,'265','How will the match be decided?',1,0,0),(55,'276','Corner Matchbet',1,0,0),(56,'286','title-286',1,0,0),(57,'289','title-289',1,0,0),(58,'321','Both halves over 1.5?',1,0,0),(59,'334','2nd Half - Odd/Even Goals',1,0,0),(60,'386','Matchbet + Both Teams to Score',1,0,0),(61,'396','1st Half - European Handicap',1,0,0),(62,'412','First Half - Matchbet + Totals',1,0,0),(63,'220','1st Half - Odd/Even Goals',1,0,0),(64,'55','European Handicaps',1,0,0),(65,'242','Number of Bookings Home',1,0,0),(66,'250','Aggregated Booking Points',1,0,0),(67,'260','2nd Half Asian Total',1,0,0),(68,'269','Which Team To Score',1,0,0),(69,'281','title-281',1,0,0),(70,'316','Home to win either half?',1,0,0),(71,'328','1st Half - Both Teams to score',1,0,0),(72,'352','Totals away team',1,0,0),(73,'391','1st Half - Correct Score 2',1,0,0),(74,'399','2nd Half - Clean sheet home team',1,0,0),(75,'202','Total Goals Aggregated',1,0,0),(76,'49','Goals Away Team',1,0,0),(77,'236','Total Number of Bookings',1,0,0),(78,'245','1st Half Number of Bookings Away',1,0,0),(79,'253','1st Half Exact Bookings',1,0,0),(80,'263','Overtime + goal',1,0,0),(81,'274','Corner Handicap',1,0,0),(82,'284','1st Half Totals',1,0,0),(83,'319','Away to win either half?',1,0,0),(84,'331','Highest Scoring Half Away team',1,0,0),(85,'394','1st Half - Clean sheet home team',1,0,0),(86,'403','2nd Half - Correct Score 2',1,0,0),(87,'410','Odd/Even home team',1,0,0),(88,'44','Halftime / Fulltime',1,0,0),(89,'208','Matchbet + Totals',1,0,0),(90,'53','1st Half Asian Handicaps',1,0,0),(91,'239','1st Half Total Number of Booking Points',1,0,0),(92,'248','Match Bookings',1,0,0),(93,'258','Total Goals',1,0,0),(94,'267','Clean Sheet Home Team',1,0,0),(95,'277','1st Half Corner Matchbet',1,0,0),(96,'287','title-287',1,0,0),(97,'290','Last team to score',1,0,0),(98,'335','2nd Half - Draw no Bet',1,0,0),(99,'387','To Qualify',1,0,0),(100,'397','2nd Half - Totals home team',1,0,0),(101,'406','Home no bet',1,0,0),(102,'413','First Half - Matchbet + Both Teams To Score',1,0,0),(103,'47','Draw No Bet',1,0,0),(104,'221','Overtime Yes/No?',1,0,0),(105,'56','Totals',1,0,0),(106,'243','1st Half Number of Bookings Home',1,0,0),(107,'251','1st Half Aggregated Booking Points',1,0,0),(108,'261','2nd Half Asian Handicaps',1,0,0),(109,'270','1st Half Total Goals',1,0,0),(110,'282','title-282',1,0,0),(111,'322','Both halves under 1.5?',1,0,0),(112,'234','Correct Set Score (best of 5 sets)',1,0,0),(113,'204','1st Set Winner',1,0,0),(114,'231','2nd Set Winner',1,0,0),(115,'232','Total Number of Sets (best of 5)',1,0,0),(116,'226','Total',1,0,0),(117,'60','Totals',1,0,0),(118,'388','Correct Score (incl. other)',1,0,0),(119,'362','1st Quarter - Total Spread',1,0,0),(120,'365','4th Quarter - Total Spread',1,0,0),(121,'225','Match Odds',1,0,0),(122,'356','3rd Quarter - 1X2',1,0,0),(123,'349','Total margins Regular-ranges',1,0,0),(124,'20','Who Wins?',1,1,0),(125,'292','title-292',1,0,0),(126,'273','1st Half Total Corners',1,0,0),(127,'293','title-293',1,0,0),(128,'272','Total Corners',1,0,0),(129,'228','Points Spreads (Overtime)',1,0,0),(130,'229','Total Spreads (Overtime)',1,0,0),(131,'380','Winning Margins Rugby League',1,0,0),(132,'230','Odd/Even Points (overtime)',1,0,0),(133,'206','Total Number of Sets (best of 3)',1,0,0),(134,'233','Correct Set Score (best of 3 sets)',1,0,0),(135,'337','Correct Set Score',1,0,0),(136,'346','5th Set Played?',1,0,0),(137,'340','1st Set Total',1,0,0),(138,'344','Who wins fourth set',1,0,0),(139,'338','How many sets will exceed score limit?',1,0,0),(140,'351','4th Set Played?',1,0,0),(141,'342','1st Set Odd/even',1,0,0),(142,'345','Who wins fifth set',1,0,0),(143,'339','1st Set Handicap',1,0,0),(144,'343','Who wins third set',1,0,0),(145,'354','1st Quarter - 1X2',1,0,0),(146,'375','Total AAMS',1,0,0),(147,'357','4th Quarter - 1X2',1,0,0),(148,'364','3rd Quarter - Total Spread',1,0,0),(149,'355','2nd Quarter - 1X2',1,0,0),(150,'376','Total 3way',1,0,0),(151,'358','1st Quarter - Draw no bet',1,0,0),(152,'348','title-348',1,0,0),(153,'367','2nd Quarter - Points Spread',1,0,0),(154,'361','4th Quarter - Draw no bet',1,0,0),(155,'223','1st Half - 2way',1,0,0),(156,'368','3rd Quarter - Points Spread',1,0,0),(157,'359','2nd Quarter - Draw no bet',1,0,0),(158,'325','First goal interval 10',1,0,0),(159,'326','First goal interval 15',1,0,0),(160,'327','First ten minutes – Odds',1,0,0),(161,'366','1st Quarter - Points Spread',1,0,0),(162,'369','4th Quarter - Points Spread',1,0,0),(163,'360','3rd Quarter - Draw no bet',1,0,0),(164,'363','2nd Quarter - Total Spread',1,0,0),(165,'372','3rd Quarter - Odd/Even Points',1,0,0),(166,'224','Highest Scoring Quarter',1,0,0),(167,'373','4th Quarter - Odd/Even Points',1,0,0),(168,'371','2nd Quarter - Odd/Even Points',1,0,0),(169,'370','1st Quarter - Odd/Even Points',1,0,0),(170,'379','Winning Margins Rugby Union',1,0,0),(171,'201','First Goalscorer',1,0,0),(172,'235','Anytime Goalscorer',1,0,0),(173,'278','Corner Odd Even',1,0,0),(174,'279','1st Half Corner Odd Even',1,0,0),(175,'241','1st Half Player sent off?',1,0,0),(176,'257','1st Half Away Team Player Sent Off',1,0,0),(177,'255','1st Half Home Team Player\rSent Off',1,0,0),(178,'313','title-313',1,0,0),(179,'312','title-312',1,0,0),(180,'211','title-211',1,0,0),(181,'298','title-298',1,0,0),(182,'214','title-214',1,0,0),(183,'302','title-302',1,0,0),(184,'378','title-378',1,0,0),(185,'295','title-295',1,0,0),(186,'305','title-305',1,0,0),(187,'212','title-212',1,0,0),(188,'227','title-227',1,0,0),(189,'299','title-299',1,0,0),(190,'291','title-291',1,0,0),(191,'303','title-303',1,0,0),(192,'210','title-210',1,0,0),(193,'218','title-218',1,0,0),(194,'297','title-297',1,0,0),(195,'314','title-314',1,0,0),(196,'213','title-213',1,0,0),(197,'301','title-301',1,0,0),(198,'377','title-377',1,0,0),(199,'294','title-294',1,0,0),(200,'304','title-304',1,0,0),(201,'296','title-296',1,0,0),(202,'307','title-307',1,0,0),(203,'310','title-310',1,0,0),(204,'308','title-308',1,0,0),(205,'311','title-311',1,0,0),(206,'306','title-306',1,0,0),(207,'309','title-309',1,0,0),(208,'333','title-333',1,0,0);
/*!40000 ALTER TABLE `betting_oddtypes` ENABLE KEYS */;
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
