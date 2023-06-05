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
-- Table structure for table `old_used_passwords`
--

DROP TABLE IF EXISTS `old_used_passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `old_used_passwords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_users_id` int(11) NOT NULL,
  `password` blob NOT NULL,
  PRIMARY KEY (`id`,`core_users_id`),
  KEY `fk_old_used_passwords_core_users1_idx` (`core_users_id`),
  CONSTRAINT `fk_old_used_passwords_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `old_used_passwords`
--

LOCK TABLES `old_used_passwords` WRITE;
/*!40000 ALTER TABLE `old_used_passwords` DISABLE KEYS */;
INSERT INTO `old_used_passwords` VALUES (8,37,'c5dc0434e64af70ff33b4fa63ccdc15ae856bece'),(9,38,'17f3bab408be0c4b62f343dc030ad09c130bdea4'),(10,39,'e5d28d0f28c21e30fd073a094978363252f9fb91'),(13,42,'88c277aa05ff838dabd3c95d5985c90f7f60670d'),(14,43,'9c7ebce63ce479f79eb6c588db69e59b9e7bf424'),(15,44,'7c1b0af8eb7d824be92811dbe1d6cb3758877055'),(16,45,'c15fb288fc6150a5af3945725b303103b75a625e'),(17,46,'ebe6e2ef4d633f8857945c8c68d258e4c3b8dd83'),(18,47,'f4bcad41bd9b3159d18094e13c8abc635e425eec'),(19,48,'8b116299fa02cb24025a5b519e5ea00280fc6a90'),(20,49,'ca5f05453bc871943927c64b9ab2616c570d7d95'),(21,1,'174031289831432eef56121132e59716a0c8228c'),(22,100,'b0a6745c7121b05ab0ee7a868be249cbed229a50'),(23,101,'95d4f6522cb2584180a777077e61977916773068'),(25,103,'863f75a51a4547ad47246d494c5b2b938af0ef23'),(26,104,'f4bcad41bd9b3159d18094e13c8abc635e425eec'),(27,105,'ae0d2f75631a08312ed7070aa0c229d4d055f08d'),(28,106,'0b434e57d4f0e9ec0c431c2f3e13df6e8ef5e4c6'),(29,107,'2d8bae1cd0a87560e957e21fcf73c816347287e1'),(30,108,'fec211ee7238c9547c3dbd33b5d7f01dd6ef9c5a'),(31,109,'5f1d7d7c4dfc93d96f684aed4fcc5603071203b8'),(32,110,'7b63c2b808106b881182f916fb5677e026dfbab4'),(33,111,'389909fcb64adbf3517d219258a289746208b371'),(40,119,'8b116299fa02cb24025a5b519e5ea00280fc6a90');
/*!40000 ALTER TABLE `old_used_passwords` ENABLE KEYS */;
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
