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
-- Table structure for table `core_attempt_restrictions`
--

DROP TABLE IF EXISTS `core_attempt_restrictions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_attempt_restrictions` (
  `ip` bigint(20) NOT NULL,
  `attempts` int(11) NOT NULL,
  `restriction_expiry_time` timestamp NULL DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `last_attempt` timestamp NULL DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_attempt_restrictions`
--

LOCK TABLES `core_attempt_restrictions` WRITE;
/*!40000 ALTER TABLE `core_attempt_restrictions` DISABLE KEYS */;
INSERT INTO `core_attempt_restrictions` VALUES (2728317515,1,NULL,1,NULL,'kyoh'),(2728287929,0,NULL,1,NULL,'shako'),(2918528210,1,NULL,1,NULL,'landish'),(2918528192,1,NULL,1,NULL,'testbet09'),(2918528192,0,NULL,1,NULL,'giorgi'),(2918528192,1,NULL,1,NULL,'kaimaruiama'),(2728317550,2,NULL,1,NULL,'kyoh kunishio'),(2728317550,2,NULL,1,NULL,'kyohkunishio'),(2372230193,0,NULL,1,NULL,'peter'),(2728317515,3,'2016-12-13 06:29:34',1,NULL,'asd'),(2728287891,1,NULL,1,NULL,'sandrasmith@yahoo.com'),(2967315778,1,NULL,1,NULL,'dsfsdfsdf'),(2957664618,1,NULL,1,NULL,'dsds'),(2967331104,3,'2016-11-05 12:25:23',1,NULL,'kyoh@wayward.la'),(2967331104,0,NULL,1,NULL,'azernovruzlu'),(2967331104,0,NULL,1,NULL,'kaimaruyama'),(2967331104,0,NULL,1,NULL,'komisia'),(2967331104,2,NULL,1,NULL,'japan1'),(2967331104,2,NULL,1,NULL,'azernovruzlu@icloud.com'),(2967331104,2,NULL,1,NULL,'azermlspp@gmail.com'),(529723790,0,NULL,1,NULL,'data1985'),(84550445,1,NULL,1,NULL,'kaymaruiama'),(2967331104,1,NULL,1,NULL,'kaimaruyamak'),(2967331104,2,NULL,1,NULL,'data§985'),(2967331104,0,NULL,1,NULL,'hb@spowi-projekt.at'),(2967331104,1,NULL,1,NULL,'MexmanMextiyev'),(622469895,2,NULL,1,NULL,'balakhanova@yahoo.com'),(1360090238,3,'2016-12-05 09:40:27',1,NULL,'muradakhundov93@gmail.com'),(2967331104,2,NULL,1,NULL,'Bzbzz'),(2967331104,2,NULL,1,NULL,'asdsad'),(2967331104,1,NULL,1,NULL,'sdfsdf'),(2967331104,1,NULL,1,NULL,'asdasd'),(2967331104,3,'2016-12-13 16:28:31',1,NULL,'sadasd'),(2967331104,3,'2016-12-13 16:30:04',1,NULL,'sadasdasdasd'),(2967331104,2,NULL,1,NULL,'asdas'),(3584067510,1,NULL,1,NULL,'roman@start2pay.com'),(3452720047,0,NULL,1,NULL,'johnhighsky');
/*!40000 ALTER TABLE `core_attempt_restrictions` ENABLE KEYS */;
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
