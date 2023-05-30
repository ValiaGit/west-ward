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
-- Table structure for table `betting_resulting_queue`
--

DROP TABLE IF EXISTS `betting_resulting_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `betting_resulting_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_receive_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0' COMMENT '0 - Has To Be Settled\n1 - Already Settled Results',
  `event_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1 - Prematch\n2 - Outright\n3 - In Play',
  `file_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21150 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `betting_resulting_queue`
--

LOCK TABLES `betting_resulting_queue` WRITE;
/*!40000 ALTER TABLE `betting_resulting_queue` DISABLE KEYS */;
INSERT INTO `betting_resulting_queue` VALUES (20385,'2016-11-13 09:28:15',1,125007,1,NULL),(20386,'2016-11-13 10:29:23',1,125023,1,NULL),(20387,'2016-11-15 13:22:05',1,125029,1,NULL),(20388,'2016-11-15 13:22:46',1,125030,1,NULL),(20389,'2016-11-15 13:23:16',1,125031,1,NULL),(20390,'2016-11-15 13:23:57',1,125032,1,NULL),(20391,'2016-11-15 13:24:29',1,125033,1,NULL),(20392,'2016-11-15 13:30:32',1,125008,1,NULL),(20393,'2016-11-15 13:33:40',1,125026,1,NULL),(20394,'2016-11-15 13:42:45',1,125009,1,NULL),(20395,'2016-11-15 13:48:31',1,125020,1,NULL),(20396,'2016-11-15 13:50:25',1,125027,1,NULL),(20397,'2016-11-15 13:53:24',1,125012,1,NULL),(20398,'2016-11-15 13:55:58',1,125021,1,NULL),(20399,'2016-11-15 13:56:57',1,125024,1,NULL),(20400,'2016-11-15 13:57:52',1,125017,1,NULL),(20401,'2016-11-15 13:59:06',1,125014,1,NULL),(20402,'2016-11-15 14:00:08',1,125028,1,NULL),(20403,'2016-11-15 14:01:04',1,125022,1,NULL),(20404,'2016-11-15 14:02:21',1,125019,1,NULL),(20405,'2016-11-15 14:03:19',1,125011,1,NULL),(20406,'2016-11-15 14:12:05',1,125025,1,NULL),(20407,'2016-11-15 14:13:57',1,125015,1,NULL),(20408,'2016-11-15 14:18:02',1,125016,1,NULL),(20409,'2016-11-15 14:22:15',1,125034,1,NULL),(20410,'2016-11-15 14:23:27',1,125035,1,NULL),(20411,'2016-11-15 14:24:14',1,125037,1,NULL),(20412,'2016-11-15 14:25:10',1,125038,1,NULL),(20413,'2016-11-15 14:26:06',1,125039,1,NULL),(20414,'2016-11-15 14:26:49',1,125040,1,NULL),(20415,'2016-11-15 14:27:42',1,125041,1,NULL),(20416,'2016-11-15 14:28:43',1,125042,1,NULL),(20417,'2016-11-15 14:30:01',1,125043,1,NULL),(20418,'2016-11-15 14:30:42',1,125044,1,NULL),(20419,'2016-11-15 14:31:29',1,125045,1,NULL),(20420,'2016-11-15 14:32:14',1,125046,1,NULL),(20421,'2016-11-15 14:32:57',1,125047,1,NULL),(20422,'2016-11-15 14:33:49',1,125048,1,NULL),(20423,'2016-11-15 14:34:39',1,125049,1,NULL),(20424,'2016-11-15 14:35:13',1,125050,1,NULL),(20425,'2016-11-15 14:36:15',1,125051,1,NULL),(20426,'2016-11-15 14:37:11',1,125052,1,NULL),(20427,'2016-11-15 14:37:56',1,125053,1,NULL),(20428,'2016-11-15 14:39:42',1,125054,1,NULL),(20429,'2016-11-15 14:40:34',1,125055,1,NULL),(20430,'2016-11-15 14:41:15',1,125056,1,NULL),(20431,'2016-11-15 14:41:58',1,125057,1,NULL),(20432,'2016-11-15 14:42:35',1,125058,1,NULL),(20433,'2016-11-15 14:43:10',1,125059,1,NULL),(20434,'2016-11-15 14:43:54',1,125060,1,NULL),(20435,'2016-11-15 14:44:30',1,125061,1,NULL),(20436,'2016-11-15 14:45:10',1,125062,1,NULL),(20437,'2016-11-15 14:45:48',1,125063,1,NULL),(20438,'2016-11-15 14:46:24',1,125064,1,NULL),(20439,'2016-11-15 14:46:58',1,125065,1,NULL),(20440,'2016-11-15 14:47:33',1,125066,1,NULL),(20441,'2016-11-15 14:48:08',1,125067,1,NULL),(20442,'2016-11-15 14:48:54',1,125068,1,NULL),(20443,'2016-11-15 14:49:33',1,125069,1,NULL),(20444,'2016-11-15 14:50:09',1,125070,1,NULL),(20445,'2016-11-15 14:50:49',1,125071,1,NULL),(20446,'2016-11-15 15:04:39',1,125018,1,NULL),(20447,'2016-11-16 08:48:43',1,125072,1,NULL),(20448,'2016-11-16 08:49:36',1,125073,1,NULL),(20449,'2016-11-16 08:50:39',1,125010,1,NULL),(20450,'2016-11-16 08:51:54',1,125075,1,NULL),(20451,'2016-11-16 08:53:05',1,125076,1,NULL),(20452,'2016-11-16 08:53:47',1,125077,1,NULL),(20453,'2016-11-16 08:54:33',1,125078,1,NULL),(20454,'2016-11-16 08:55:04',1,125079,1,NULL),(20455,'2016-11-16 08:55:42',1,125080,1,NULL),(20456,'2016-11-16 08:56:14',1,125081,1,NULL),(20457,'2016-11-16 08:56:51',1,125082,1,NULL),(20458,'2016-11-16 08:57:36',1,125083,1,NULL),(20459,'2016-11-16 08:58:13',1,125084,1,NULL),(20460,'2016-11-16 08:58:45',1,125085,1,NULL),(20461,'2016-11-16 08:59:35',1,125086,1,NULL),(20462,'2016-11-16 09:00:37',1,125088,1,NULL),(20463,'2016-11-16 09:01:39',1,125091,1,NULL),(20464,'2016-11-16 09:03:19',1,125090,1,NULL),(20465,'2016-11-16 09:05:20',1,125092,1,NULL),(20466,'2016-11-16 09:05:57',1,125093,1,NULL),(20467,'2016-11-16 09:06:29',1,125094,1,NULL),(20468,'2016-11-16 09:08:02',1,125074,1,NULL),(20469,'2016-11-17 07:57:30',1,125095,1,NULL),(20470,'2016-11-17 07:58:12',1,125096,1,NULL),(20471,'2016-11-17 07:58:57',1,125097,1,NULL),(20472,'2016-11-17 07:59:47',1,125098,1,NULL),(20473,'2016-11-17 08:00:44',1,125099,1,NULL),(20474,'2016-11-17 08:01:57',1,125100,1,NULL),(20475,'2016-11-17 08:02:37',1,125101,1,NULL),(20476,'2016-11-17 08:03:20',1,125102,1,NULL),(20477,'2016-11-17 08:04:06',1,125103,1,NULL),(20478,'2016-11-17 08:04:42',1,125104,1,NULL),(20479,'2016-11-17 08:06:55',1,125105,1,NULL),(20480,'2016-11-17 08:25:52',1,125117,1,NULL),(20481,'2016-11-17 08:37:30',1,125013,1,NULL),(20482,'2016-11-17 09:03:48',1,125106,1,NULL),(20483,'2016-11-17 09:04:27',1,125107,1,NULL),(20484,'2016-11-17 09:05:09',1,125108,1,NULL),(20485,'2016-11-17 09:05:44',1,125110,1,NULL),(20486,'2016-11-17 09:07:17',1,125111,1,NULL),(20487,'2016-11-17 09:10:09',1,125112,1,NULL),(20488,'2016-11-17 09:10:59',1,125113,1,NULL),(20489,'2016-11-17 09:11:45',1,125114,1,NULL),(20490,'2016-11-17 09:12:15',1,125115,1,NULL),(20491,'2016-11-18 00:45:11',1,125118,1,NULL),(20492,'2016-11-18 04:38:46',1,125123,1,NULL),(20493,'2016-11-18 04:47:34',1,125126,1,NULL),(20494,'2016-11-18 04:52:43',1,125131,1,NULL),(20495,'2016-11-18 04:55:15',1,125139,1,NULL),(20496,'2016-11-18 04:58:44',1,125144,1,NULL),(20497,'2016-11-18 05:02:33',1,125142,1,NULL),(20498,'2016-11-18 05:06:48',1,125146,1,NULL),(20499,'2016-11-18 05:08:42',1,125147,1,NULL),(20500,'2016-11-18 05:11:07',1,125171,1,NULL),(20501,'2016-11-18 05:19:09',1,125173,1,NULL),(20502,'2016-11-18 05:26:17',1,125172,1,NULL),(20503,'2016-11-18 05:33:30',1,125174,1,NULL),(20504,'2016-11-18 05:38:18',1,125175,1,NULL),(20505,'2016-11-18 05:46:12',1,125177,1,NULL),(20506,'2016-11-18 05:52:15',1,125176,1,NULL),(20507,'2016-11-18 05:53:10',1,125178,1,NULL),(20508,'2016-11-18 06:09:34',1,125181,1,NULL),(20509,'2016-11-18 06:12:41',1,125182,1,NULL),(20510,'2016-11-18 06:23:20',1,125180,1,NULL),(20511,'2016-11-18 06:25:25',1,125184,1,NULL),(20512,'2016-11-18 06:27:00',1,125179,1,NULL),(20513,'2016-11-18 06:30:54',1,125186,1,NULL),(20514,'2016-11-18 06:45:11',1,125183,1,NULL),(20515,'2016-11-18 06:53:27',1,125185,1,NULL),(20516,'2016-11-18 07:55:19',1,125119,1,NULL),(20517,'2016-11-18 07:56:04',1,125120,1,NULL),(20518,'2016-11-18 07:57:00',1,125121,1,NULL),(20519,'2016-11-18 07:57:38',1,125122,1,NULL),(20520,'2016-11-18 07:58:22',1,125124,1,NULL),(20521,'2016-11-18 07:59:10',1,125125,1,NULL),(20522,'2016-11-18 08:00:40',1,125127,1,NULL),(20523,'2016-11-18 08:01:11',1,125128,1,NULL),(20524,'2016-11-18 08:03:03',1,125129,1,NULL),(20525,'2016-11-18 08:03:43',1,125130,1,NULL),(20526,'2016-11-18 08:04:19',1,125132,1,NULL),(20527,'2016-11-18 08:46:34',1,125133,1,NULL),(20528,'2016-11-18 08:47:11',1,125134,1,NULL),(20529,'2016-11-18 08:48:20',1,125135,1,NULL),(20530,'2016-11-18 08:50:06',1,125136,1,NULL),(20531,'2016-11-18 08:51:01',1,125137,1,NULL),(20532,'2016-11-18 08:51:39',1,125138,1,NULL),(20533,'2016-11-18 08:52:28',1,125140,1,NULL),(20534,'2016-11-18 08:53:47',1,125141,1,NULL),(20535,'2016-11-18 08:55:52',1,125143,1,NULL),(20536,'2016-11-18 09:02:13',1,125145,1,NULL),(20537,'2016-11-18 09:38:45',1,125187,1,NULL),(20538,'2016-11-18 09:48:21',1,125188,1,NULL),(20539,'2016-11-18 09:55:29',1,125189,1,NULL),(20540,'2016-11-18 10:28:19',1,125190,1,NULL),(20541,'2016-11-18 10:38:33',1,125191,1,NULL),(20542,'2016-11-18 10:43:02',1,125192,1,NULL),(20543,'2016-11-19 04:42:12',1,125148,1,NULL),(20544,'2016-11-19 04:44:45',1,125151,1,NULL),(20545,'2016-11-19 04:51:26',1,125149,1,NULL),(20546,'2016-11-19 04:54:48',1,125152,1,NULL),(20547,'2016-11-19 04:56:37',1,125153,1,NULL),(20548,'2016-11-19 05:03:26',1,125150,1,NULL),(20549,'2016-11-19 05:04:03',1,125154,1,NULL),(20550,'2016-11-19 05:16:06',1,125155,1,NULL),(20551,'2016-11-19 05:22:44',1,125157,1,NULL),(20552,'2016-11-19 05:24:17',1,125156,1,NULL),(20553,'2016-11-19 05:28:41',1,125158,1,NULL),(20554,'2016-11-19 05:36:02',1,125214,1,NULL),(20555,'2016-11-19 05:46:05',1,125216,1,NULL),(20556,'2016-11-19 05:46:51',1,125215,1,NULL),(20557,'2016-11-19 05:49:19',1,125217,1,NULL),(20558,'2016-11-19 06:05:46',1,125218,1,NULL),(20559,'2016-11-19 06:10:51',1,125219,1,NULL),(20560,'2016-11-19 06:12:47',1,125220,1,NULL),(20561,'2016-11-19 06:19:16',1,125221,1,NULL),(20562,'2016-11-19 06:29:33',1,125222,1,NULL),(20563,'2016-11-19 06:31:23',1,125223,1,NULL),(20564,'2016-11-19 06:32:16',1,125224,1,NULL),(20565,'2016-11-19 06:36:52',1,125225,1,NULL),(20566,'2016-11-19 06:49:14',1,125226,1,NULL),(20567,'2016-11-19 06:57:36',1,125228,1,NULL),(20568,'2016-11-19 06:58:10',1,125227,1,NULL),(20569,'2016-11-19 07:04:48',1,125229,1,NULL),(20570,'2016-11-19 07:25:25',1,125193,1,NULL),(20571,'2016-11-19 07:26:11',1,125194,1,NULL),(20572,'2016-11-19 07:27:19',1,125195,1,NULL),(20573,'2016-11-19 07:37:14',1,125196,1,NULL),(20574,'2016-11-19 07:38:09',1,125197,1,NULL),(20575,'2016-11-19 07:38:49',1,125198,1,NULL),(20576,'2016-11-19 07:39:47',1,125199,1,NULL),(20577,'2016-11-19 07:55:06',1,125200,1,NULL),(20578,'2016-11-19 07:55:53',1,125201,1,NULL),(20579,'2016-11-19 07:56:34',1,125202,1,NULL),(20580,'2016-11-19 08:15:22',1,125203,1,NULL),(20581,'2016-11-19 08:17:00',1,125204,1,NULL),(20582,'2016-11-19 08:18:12',1,125205,1,NULL),(20583,'2016-11-19 08:19:51',1,125206,1,NULL),(20584,'2016-11-19 09:12:45',1,125207,1,NULL),(20585,'2016-11-19 09:13:57',1,125208,1,NULL),(20586,'2016-11-19 09:14:41',1,125209,1,NULL),(20587,'2016-11-19 09:15:34',1,125210,1,NULL),(20588,'2016-11-19 09:16:59',1,125212,1,NULL),(20589,'2016-11-19 09:17:47',1,125213,1,NULL),(20590,'2016-11-19 09:18:37',1,125211,1,NULL),(20591,'2016-11-19 09:29:19',1,125230,1,NULL),(20592,'2016-11-19 09:35:47',1,125231,1,NULL),(20593,'2016-11-19 09:43:15',1,125232,1,NULL),(20594,'2016-11-19 10:16:35',1,125233,1,NULL),(20595,'2016-11-19 10:24:49',1,125234,1,NULL),(20596,'2016-11-19 10:33:43',1,125235,1,NULL),(20597,'2016-11-19 12:48:05',1,125252,1,NULL),(20598,'2016-11-20 04:40:35',1,125159,1,NULL),(20599,'2016-11-20 04:41:03',1,125161,1,NULL),(20600,'2016-11-20 04:46:17',1,125160,1,NULL),(20601,'2016-11-20 04:46:46',1,125162,1,NULL),(20602,'2016-11-20 04:51:40',1,125163,1,NULL),(20603,'2016-11-20 04:55:31',1,125164,1,NULL),(20604,'2016-11-20 04:59:47',1,125165,1,NULL),(20605,'2016-11-20 05:01:50',1,125167,1,NULL),(20606,'2016-11-20 05:02:30',1,125169,1,NULL),(20607,'2016-11-20 05:09:07',1,125260,1,NULL),(20608,'2016-11-20 05:11:01',1,125261,1,NULL),(20609,'2016-11-20 05:18:47',1,125264,1,NULL),(20610,'2016-11-20 05:23:28',1,125262,1,NULL),(20611,'2016-11-20 05:24:40',1,125166,1,NULL),(20612,'2016-11-20 05:31:21',1,125263,1,NULL),(20613,'2016-11-20 05:39:09',1,125265,1,NULL),(20614,'2016-11-20 05:43:11',1,125168,1,NULL),(20615,'2016-11-20 05:44:26',1,125266,1,NULL),(20616,'2016-11-20 05:45:08',1,125170,1,NULL),(20617,'2016-11-20 05:45:44',1,125267,1,NULL),(20618,'2016-11-20 05:59:03',1,125268,1,NULL),(20619,'2016-11-20 06:01:27',1,125270,1,NULL),(20620,'2016-11-20 06:04:07',1,125272,1,NULL),(20621,'2016-11-20 06:09:57',1,125273,1,NULL),(20622,'2016-11-20 06:11:12',1,125269,1,NULL),(20623,'2016-11-20 06:14:21',1,125271,1,NULL),(20624,'2016-11-20 06:18:45',1,125277,1,NULL),(20625,'2016-11-20 06:20:09',1,125275,1,NULL),(20626,'2016-11-20 06:24:06',1,125274,1,NULL),(20627,'2016-11-20 06:29:16',1,125276,1,NULL),(20628,'2016-11-20 06:32:14',1,125278,1,NULL),(20629,'2016-11-20 07:17:02',1,125236,1,NULL),(20630,'2016-11-20 07:17:44',1,125237,1,NULL),(20631,'2016-11-20 07:19:07',1,125238,1,NULL),(20632,'2016-11-20 07:32:45',1,125239,1,NULL),(20633,'2016-11-20 07:33:24',1,125240,1,NULL),(20634,'2016-11-20 07:34:59',1,125241,1,NULL),(20635,'2016-11-20 08:02:10',1,125242,1,NULL),(20636,'2016-11-20 08:02:55',1,125243,1,NULL),(20637,'2016-11-20 08:03:37',1,125244,1,NULL),(20638,'2016-11-20 08:04:32',1,125245,1,NULL),(20639,'2016-11-20 08:05:28',1,125246,1,NULL),(20640,'2016-11-20 08:17:03',1,125247,1,NULL),(20641,'2016-11-20 08:17:41',1,125248,1,NULL),(20642,'2016-11-20 08:19:08',1,125249,1,NULL),(20643,'2016-11-20 08:31:31',1,125250,1,NULL),(20644,'2016-11-20 08:32:41',1,125251,1,NULL),(20645,'2016-11-20 09:07:23',1,125279,1,NULL),(20646,'2016-11-20 09:07:38',1,125253,1,NULL),(20647,'2016-11-20 09:08:20',1,125254,1,NULL),(20648,'2016-11-20 09:08:58',1,125255,1,NULL),(20649,'2016-11-20 09:10:03',1,125256,1,NULL),(20650,'2016-11-20 09:11:41',1,125257,1,NULL),(20651,'2016-11-20 09:12:23',1,125258,1,NULL),(20652,'2016-11-20 09:16:00',1,125280,1,NULL),(20653,'2016-11-20 09:22:56',1,125281,1,NULL),(20654,'2016-11-20 09:55:29',1,125282,1,NULL),(20655,'2016-11-20 10:08:57',1,125283,1,NULL),(20656,'2016-11-20 10:11:19',1,125284,1,NULL),(20657,'2016-11-20 10:46:13',1,125285,1,NULL),(20658,'2016-11-20 10:57:06',1,125286,1,NULL),(20659,'2016-11-20 11:06:17',1,125287,1,NULL),(20660,'2016-11-21 07:40:34',1,125288,1,NULL),(20661,'2016-11-21 07:41:09',1,125289,1,NULL),(20662,'2016-11-21 07:41:49',1,125290,1,NULL),(20663,'2016-11-21 07:42:28',1,125291,1,NULL),(20664,'2016-11-21 07:43:03',1,125292,1,NULL),(20665,'2016-11-21 07:45:06',1,125293,1,NULL),(20666,'2016-11-21 07:45:56',1,125294,1,NULL),(20667,'2016-11-21 07:48:44',1,125295,1,NULL),(20668,'2016-11-21 07:49:20',1,125296,1,NULL),(20669,'2016-11-21 08:32:25',1,125297,1,NULL),(20670,'2016-11-21 08:33:05',1,125298,1,NULL),(20671,'2016-11-21 08:33:36',1,125299,1,NULL),(20672,'2016-11-21 08:34:19',1,125300,1,NULL),(20673,'2016-11-21 08:34:58',1,125301,1,NULL),(20674,'2016-11-21 08:35:32',1,125302,1,NULL),(20675,'2016-11-21 08:36:06',1,125303,1,NULL),(20676,'2016-11-21 09:07:03',1,125304,1,NULL),(20677,'2016-11-21 09:07:40',1,125305,1,NULL),(20678,'2016-11-21 09:08:25',1,125306,1,NULL),(20679,'2016-11-21 09:09:08',1,125307,1,NULL),(20680,'2016-11-21 09:09:45',1,125308,1,NULL),(20681,'2016-11-22 08:24:52',1,125309,1,NULL),(20682,'2016-11-22 08:25:46',1,125310,1,NULL),(20683,'2016-11-22 08:26:31',1,125311,1,NULL),(20684,'2016-11-22 08:27:08',1,125312,1,NULL),(20685,'2016-11-22 08:27:51',1,125313,1,NULL),(20686,'2016-11-22 08:28:26',1,125314,1,NULL),(20687,'2016-11-22 08:29:40',1,125315,1,NULL),(20688,'2016-11-22 08:30:26',1,125316,1,NULL),(20689,'2016-11-22 08:33:04',1,125317,1,NULL),(20690,'2016-11-22 08:33:52',1,125318,1,NULL),(20691,'2016-11-22 08:34:57',1,125319,1,NULL),(20692,'2016-11-22 08:35:34',1,125320,1,NULL),(20693,'2016-11-22 08:36:16',1,125321,1,NULL),(20694,'2016-11-22 08:36:51',1,125322,1,NULL),(20695,'2016-11-22 08:39:00',1,125323,1,NULL),(20696,'2016-11-22 08:39:42',1,125324,1,NULL),(20697,'2016-11-22 08:40:48',1,125325,1,NULL),(20698,'2016-11-22 09:06:43',1,125326,1,NULL),(20699,'2016-11-22 09:07:30',1,125327,1,NULL),(20700,'2016-11-22 09:08:24',1,125328,1,NULL),(20701,'2016-11-22 09:51:25',1,125329,1,NULL),(20702,'2016-11-23 07:27:12',1,125330,1,NULL),(20703,'2016-11-23 07:27:58',1,125331,1,NULL),(20704,'2016-11-23 07:28:36',1,125332,1,NULL),(20705,'2016-11-23 07:29:14',1,125333,1,NULL),(20706,'2016-11-23 07:59:36',1,125334,1,NULL),(20707,'2016-11-23 08:00:31',1,125335,1,NULL),(20708,'2016-11-23 08:01:38',1,125336,1,NULL),(20709,'2016-11-23 08:02:10',1,125337,1,NULL),(20710,'2016-11-23 08:02:45',1,125338,1,NULL),(20711,'2016-11-23 08:03:25',1,125339,1,NULL),(20712,'2016-11-23 08:04:06',1,125340,1,NULL),(20713,'2016-11-23 08:28:01',1,125341,1,NULL),(20714,'2016-11-23 08:28:44',1,125342,1,NULL),(20715,'2016-11-23 08:29:26',1,125343,1,NULL),(20716,'2016-11-23 08:30:19',1,125344,1,NULL),(20717,'2016-11-23 08:31:35',1,125345,1,NULL),(20718,'2016-11-23 08:33:01',1,125346,1,NULL),(20719,'2016-11-23 08:46:11',1,125347,1,NULL),(20720,'2016-11-23 08:47:31',1,125348,1,NULL),(20721,'2016-11-23 10:06:01',1,125349,1,NULL),(20722,'2016-11-23 10:06:45',1,125350,1,NULL),(20723,'2016-11-24 07:37:28',1,125351,1,NULL),(20724,'2016-11-24 07:37:59',1,125352,1,NULL),(20725,'2016-11-24 07:38:26',1,125353,1,NULL),(20726,'2016-11-24 07:39:09',1,125354,1,NULL),(20727,'2016-11-24 07:39:37',1,125355,1,NULL),(20728,'2016-11-24 07:40:13',1,125356,1,NULL),(20729,'2016-11-24 07:57:48',1,125357,1,NULL),(20730,'2016-11-24 07:58:37',1,125358,1,NULL),(20731,'2016-11-24 07:59:29',1,125359,1,NULL),(20732,'2016-11-24 08:01:03',1,125360,1,NULL),(20733,'2016-11-24 08:01:41',1,125361,1,NULL),(20734,'2016-11-24 08:29:28',1,125362,1,NULL),(20735,'2016-11-24 08:30:11',1,125363,1,NULL),(20736,'2016-11-24 08:31:01',1,125364,1,NULL),(20737,'2016-11-24 08:31:48',1,125365,1,NULL),(20738,'2016-11-24 08:32:20',1,125366,1,NULL),(20739,'2016-11-24 08:33:53',1,125367,1,NULL),(20740,'2016-11-24 09:05:03',1,125368,1,NULL),(20741,'2016-11-24 09:05:40',1,125369,1,NULL),(20742,'2016-11-24 09:06:18',1,125370,1,NULL),(20743,'2016-11-24 09:06:58',1,125371,1,NULL),(20744,'2016-11-25 08:33:30',1,125372,1,NULL),(20745,'2016-11-25 08:34:06',1,125373,1,NULL),(20746,'2016-11-25 08:34:37',1,125374,1,NULL),(20747,'2016-11-25 08:35:08',1,125375,1,NULL),(20748,'2016-11-25 08:35:45',1,125376,1,NULL),(20749,'2016-11-25 08:36:18',1,125377,1,NULL),(20750,'2016-11-25 08:36:57',1,125378,1,NULL),(20751,'2016-11-25 08:37:28',1,125379,1,NULL),(20752,'2016-11-25 08:38:05',1,125380,1,NULL),(20753,'2016-11-25 08:38:40',1,125381,1,NULL),(20754,'2016-11-25 08:39:14',1,125382,1,NULL),(20755,'2016-11-25 08:40:36',1,125383,1,NULL),(20756,'2016-11-25 08:41:17',1,125384,1,NULL),(20757,'2016-11-25 08:41:52',1,125385,1,NULL),(20758,'2016-11-25 08:42:26',1,125386,1,NULL),(20759,'2016-11-25 08:43:08',1,125387,1,NULL),(20760,'2016-11-25 08:43:47',1,125388,1,NULL),(20761,'2016-11-25 08:44:27',1,125389,1,NULL),(20762,'2016-11-25 09:17:55',1,125390,1,NULL),(20763,'2016-11-25 09:18:25',1,125391,1,NULL),(20764,'2016-11-25 09:19:00',1,125392,1,NULL),(20765,'2016-11-26 09:19:40',1,125393,1,NULL),(20766,'2016-11-26 09:20:36',1,125394,1,NULL),(20767,'2016-11-26 09:21:10',1,125395,1,NULL),(20768,'2016-11-26 09:21:58',1,125396,1,NULL),(20769,'2016-11-26 09:22:36',1,125397,1,NULL),(20770,'2016-11-26 09:23:22',1,125398,1,NULL),(20771,'2016-11-26 09:23:57',1,125399,1,NULL),(20772,'2016-11-26 09:24:44',1,125400,1,NULL),(20773,'2016-11-26 09:25:17',1,125401,1,NULL),(20774,'2016-11-26 09:26:01',1,125402,1,NULL),(20775,'2016-11-26 09:26:39',1,125403,1,NULL),(20776,'2016-11-26 09:27:17',1,125404,1,NULL),(20777,'2016-11-26 09:27:57',1,125405,1,NULL),(20778,'2016-11-26 09:28:38',1,125406,1,NULL),(20779,'2016-11-26 09:29:10',1,125407,1,NULL),(20780,'2016-11-26 09:29:57',1,125408,1,NULL),(20781,'2016-11-26 09:30:40',1,125409,1,NULL),(20782,'2016-11-26 09:32:15',1,125410,1,NULL),(20783,'2016-11-26 09:32:45',1,125411,1,NULL),(20784,'2016-11-26 09:33:16',1,125412,1,NULL),(20785,'2016-11-26 09:33:46',1,125413,1,NULL),(20786,'2016-11-27 07:29:50',1,125414,1,NULL),(20787,'2016-11-27 07:30:23',1,125415,1,NULL),(20788,'2016-11-27 07:30:54',1,125416,1,NULL),(20789,'2016-11-27 07:31:51',1,125417,1,NULL),(20790,'2016-11-27 07:32:22',1,125418,1,NULL),(20791,'2016-11-27 07:33:09',1,125419,1,NULL),(20792,'2016-11-27 07:33:53',1,125420,1,NULL),(20793,'2016-11-27 07:34:41',1,125421,1,NULL),(20794,'2016-11-27 07:35:21',1,125422,1,NULL),(20795,'2016-11-27 07:38:13',1,125423,1,NULL),(20796,'2016-11-27 07:39:04',1,125424,1,NULL),(20797,'2016-11-27 08:11:40',1,125425,1,NULL),(20798,'2016-11-27 08:12:27',1,125426,1,NULL),(20799,'2016-11-27 08:13:05',1,125427,1,NULL),(20800,'2016-11-27 08:13:51',1,125428,1,NULL),(20801,'2016-11-27 08:14:36',1,125429,1,NULL),(20802,'2016-11-27 08:15:26',1,125430,1,NULL),(20803,'2016-11-27 08:17:01',1,125432,1,NULL),(20804,'2016-11-27 08:38:19',1,125433,1,NULL),(20805,'2016-11-27 08:39:04',1,125434,1,NULL),(20806,'2016-11-27 08:39:49',1,125435,1,NULL),(20807,'2016-12-01 08:18:23',1,125436,1,NULL),(20808,'2016-12-02 01:41:14',1,125472,1,NULL),(20809,'2016-12-02 01:45:48',1,125514,1,NULL),(20810,'2016-12-02 01:48:50',1,125449,1,NULL),(20811,'2016-12-02 01:49:25',1,125515,1,NULL),(20812,'2016-12-02 01:51:57',1,125516,1,NULL),(20813,'2016-12-02 01:55:05',1,125517,1,NULL),(20814,'2016-12-02 01:56:02',1,125453,1,NULL),(20815,'2016-12-02 01:57:52',1,125518,1,NULL),(20816,'2016-12-02 02:00:03',1,125519,1,NULL),(20817,'2016-12-02 02:00:21',1,125438,1,NULL),(20818,'2016-12-02 02:04:58',1,125454,1,NULL),(20819,'2016-12-02 02:06:04',1,125520,1,NULL),(20820,'2016-12-02 02:06:51',1,125440,1,NULL),(20821,'2016-12-02 02:08:24',1,125437,1,NULL),(20822,'2016-12-02 02:09:01',1,125473,1,NULL),(20823,'2016-12-02 02:11:17',1,125460,1,NULL),(20824,'2016-12-02 02:12:39',1,125441,1,NULL),(20825,'2016-12-02 02:13:53',1,125476,1,NULL),(20826,'2016-12-02 02:15:46',1,125456,1,NULL),(20827,'2016-12-02 02:17:59',1,125461,1,NULL),(20828,'2016-12-02 02:20:57',1,125551,1,NULL),(20829,'2016-12-02 02:23:32',1,125553,1,NULL),(20830,'2016-12-02 02:23:59',1,125457,1,NULL),(20831,'2016-12-02 02:26:12',1,125458,1,NULL),(20832,'2016-12-02 02:27:33',1,125480,1,NULL),(20833,'2016-12-02 02:28:42',1,125482,1,NULL),(20834,'2016-12-02 02:31:42',1,125459,1,NULL),(20835,'2016-12-02 02:36:01',1,125455,1,NULL),(20836,'2016-12-02 02:36:50',1,125548,1,NULL),(20837,'2016-12-02 02:41:22',1,125511,1,NULL),(20838,'2016-12-02 02:45:44',1,125445,1,NULL),(20839,'2016-12-02 02:46:22',1,125447,1,NULL),(20840,'2016-12-02 02:47:23',1,125444,1,NULL),(20841,'2016-12-02 02:50:48',1,125567,1,NULL),(20842,'2016-12-02 02:52:44',1,125565,1,NULL),(20843,'2016-12-02 02:53:49',1,125468,1,NULL),(20844,'2016-12-02 02:58:29',1,125558,1,NULL),(20845,'2016-12-02 02:59:49',1,125559,1,NULL),(20846,'2016-12-02 03:00:00',1,125566,1,NULL),(20847,'2016-12-02 03:01:54',1,125560,1,NULL),(20848,'2016-12-02 03:02:35',1,125564,1,NULL),(20849,'2016-12-02 03:04:06',1,125568,1,NULL),(20850,'2016-12-02 03:06:13',1,125484,1,NULL),(20851,'2016-12-02 03:07:05',1,125512,1,NULL),(20852,'2016-12-02 03:10:30',1,125569,1,NULL),(20853,'2016-12-02 03:11:15',1,125443,1,NULL),(20854,'2016-12-02 03:14:25',1,125450,1,NULL),(20855,'2016-12-02 03:15:02',1,125471,1,NULL),(20856,'2016-12-02 03:17:35',1,125557,1,NULL),(20857,'2016-12-02 03:20:30',1,125554,1,NULL),(20858,'2016-12-02 03:22:10',1,125556,1,NULL),(20859,'2016-12-02 03:22:43',1,125555,1,NULL),(20860,'2016-12-02 03:24:27',1,125574,1,NULL),(20861,'2016-12-02 03:26:42',1,125446,1,NULL),(20862,'2016-12-02 03:27:14',1,125563,1,NULL),(20863,'2016-12-02 03:28:00',1,125577,1,NULL),(20864,'2016-12-02 03:30:19',1,125583,1,NULL),(20865,'2016-12-02 03:31:19',1,125591,1,NULL),(20866,'2016-12-02 03:34:50',1,125562,1,NULL),(20867,'2016-12-02 03:36:24',1,125570,1,NULL),(20868,'2016-12-02 03:39:24',1,125575,1,NULL),(20869,'2016-12-02 03:41:15',1,125572,1,NULL),(20870,'2016-12-02 03:42:53',1,125582,1,NULL),(20871,'2016-12-02 03:46:31',1,125576,1,NULL),(20872,'2016-12-02 03:47:20',1,125571,1,NULL),(20873,'2016-12-02 03:49:10',1,125584,1,NULL),(20874,'2016-12-02 03:56:01',1,125579,1,NULL),(20875,'2016-12-02 03:56:14',1,125578,1,NULL),(20876,'2016-12-02 04:11:10',1,125581,1,NULL),(20877,'2016-12-02 04:13:47',1,125587,1,NULL),(20878,'2016-12-02 04:16:12',1,125580,1,NULL),(20879,'2016-12-02 04:19:44',1,125586,1,NULL),(20880,'2016-12-02 04:19:55',1,125588,1,NULL),(20881,'2016-12-02 04:20:19',1,125585,1,NULL),(20882,'2016-12-02 04:22:17',1,125589,1,NULL),(20883,'2016-12-02 04:24:10',1,125592,1,NULL),(20884,'2016-12-02 04:27:47',1,125593,1,NULL),(20885,'2016-12-02 04:32:00',1,125594,1,NULL),(20886,'2016-12-02 04:35:02',1,125596,1,NULL),(20887,'2016-12-02 04:36:11',1,125595,1,NULL),(20888,'2016-12-02 04:45:17',1,125590,1,NULL),(20889,'2016-12-02 05:10:16',1,125598,1,NULL),(20890,'2016-12-02 05:11:07',1,125597,1,NULL),(20891,'2016-12-02 05:11:29',1,125599,1,NULL),(20892,'2016-12-02 05:12:09',1,125605,1,NULL),(20893,'2016-12-02 05:18:46',1,125603,1,NULL),(20894,'2016-12-02 05:19:27',1,125602,1,NULL),(20895,'2016-12-02 05:29:45',1,125610,1,NULL),(20896,'2016-12-02 05:30:16',1,125604,1,NULL),(20897,'2016-12-02 05:34:15',1,125611,1,NULL),(20898,'2016-12-02 05:38:10',1,125609,1,NULL),(20899,'2016-12-02 05:38:39',1,125613,1,NULL),(20900,'2016-12-02 05:39:16',1,125607,1,NULL),(20901,'2016-12-02 05:40:43',1,125612,1,NULL),(20902,'2016-12-02 05:41:07',1,125617,1,NULL),(20903,'2016-12-02 05:44:09',1,125608,1,NULL),(20904,'2016-12-02 05:47:24',1,125614,1,NULL),(20905,'2016-12-02 05:50:32',1,125618,1,NULL),(20906,'2016-12-02 05:54:40',1,125615,1,NULL),(20907,'2016-12-02 06:04:40',1,125616,1,NULL),(20908,'2016-12-02 07:21:38',1,125620,1,NULL),(20909,'2016-12-02 07:25:03',1,125621,1,NULL),(20910,'2016-12-02 07:26:39',1,125619,1,NULL),(20911,'2016-12-02 07:36:19',1,125622,1,NULL),(20912,'2016-12-02 07:45:06',1,125623,1,NULL),(20913,'2016-12-02 07:54:56',1,125624,1,NULL),(20914,'2016-12-02 08:21:09',1,125626,1,NULL),(20915,'2016-12-02 08:21:50',1,125627,1,NULL),(20916,'2016-12-02 08:22:40',1,125625,1,NULL),(20917,'2016-12-02 08:34:32',1,125628,1,NULL),(20918,'2016-12-02 08:41:34',1,125629,1,NULL),(20919,'2016-12-02 08:42:35',1,125630,1,NULL),(20920,'2016-12-02 09:22:48',1,125632,1,NULL),(20921,'2016-12-02 09:23:33',1,125633,1,NULL),(20922,'2016-12-02 09:24:05',1,125631,1,NULL),(20923,'2016-12-03 01:38:12',1,125521,1,NULL),(20924,'2016-12-03 01:42:12',1,125532,1,NULL),(20925,'2016-12-03 01:46:15',1,125533,1,NULL),(20926,'2016-12-03 01:47:25',1,125534,1,NULL),(20927,'2016-12-03 01:53:04',1,125522,1,NULL),(20928,'2016-12-03 01:53:45',1,125523,1,NULL),(20929,'2016-12-03 01:57:20',1,125464,1,NULL),(20930,'2016-12-03 02:00:16',1,125477,1,NULL),(20931,'2016-12-03 02:03:00',1,125531,1,NULL),(20932,'2016-12-03 02:04:40',1,125479,1,NULL),(20933,'2016-12-03 02:05:01',1,125536,1,NULL),(20934,'2016-12-03 02:05:39',1,125537,1,NULL),(20935,'2016-12-03 02:06:33',1,125535,1,NULL),(20936,'2016-12-03 02:09:29',1,125465,1,NULL),(20937,'2016-12-03 02:11:41',1,125466,1,NULL),(20938,'2016-12-03 02:13:40',1,125481,1,NULL),(20939,'2016-12-03 02:15:12',1,125524,1,NULL),(20940,'2016-12-03 02:15:29',1,125462,1,NULL),(20941,'2016-12-03 02:16:10',1,125525,1,NULL),(20942,'2016-12-03 02:16:56',1,125526,1,NULL),(20943,'2016-12-03 02:17:32',1,125527,1,NULL),(20944,'2016-12-03 02:18:18',1,125483,1,NULL),(20945,'2016-12-03 02:18:24',1,125546,1,NULL),(20946,'2016-12-03 02:18:57',1,125528,1,NULL),(20947,'2016-12-03 02:19:28',1,125529,1,NULL),(20948,'2016-12-03 02:20:53',1,125463,1,NULL),(20949,'2016-12-03 02:28:10',1,125638,1,NULL),(20950,'2016-12-03 02:28:17',1,125643,1,NULL),(20951,'2016-12-03 02:34:46',1,125467,1,NULL),(20952,'2016-12-03 02:36:14',1,125469,1,NULL),(20953,'2016-12-03 02:37:56',1,125474,1,NULL),(20954,'2016-12-03 02:38:55',1,125538,1,NULL),(20955,'2016-12-03 02:39:33',1,125475,1,NULL),(20956,'2016-12-03 02:39:49',1,125635,1,NULL),(20957,'2016-12-03 02:44:52',1,125485,1,NULL),(20958,'2016-12-03 02:50:33',1,125636,1,NULL),(20959,'2016-12-03 02:50:42',1,125470,1,NULL),(20960,'2016-12-03 02:52:01',1,125657,1,NULL),(20961,'2016-12-03 02:52:50',1,125644,1,NULL),(20962,'2016-12-03 02:57:02',1,125639,1,NULL),(20963,'2016-12-03 02:57:48',1,125634,1,NULL),(20964,'2016-12-03 02:58:36',1,125637,1,NULL),(20965,'2016-12-03 03:01:27',1,125649,1,NULL),(20966,'2016-12-03 03:02:14',1,125641,1,NULL),(20967,'2016-12-03 03:03:10',1,125655,1,NULL),(20968,'2016-12-03 03:06:25',1,125640,1,NULL),(20969,'2016-12-03 03:06:51',1,125642,1,NULL),(20970,'2016-12-03 03:07:28',1,125659,1,NULL),(20971,'2016-12-03 03:11:40',1,125650,1,NULL),(20972,'2016-12-03 03:12:14',1,125645,1,NULL),(20973,'2016-12-03 03:12:52',1,125646,1,NULL),(20974,'2016-12-03 03:13:37',1,125653,1,NULL),(20975,'2016-12-03 03:16:23',1,125654,1,NULL),(20976,'2016-12-03 03:17:30',1,125656,1,NULL),(20977,'2016-12-03 03:18:59',1,125647,1,NULL),(20978,'2016-12-03 03:21:45',1,125658,1,NULL),(20979,'2016-12-03 03:22:47',1,125648,1,NULL),(20980,'2016-12-03 03:24:48',1,125652,1,NULL),(20981,'2016-12-03 03:26:49',1,125660,1,NULL),(20982,'2016-12-03 03:31:36',1,125665,1,NULL),(20983,'2016-12-03 03:34:16',1,125661,1,NULL),(20984,'2016-12-03 03:35:39',1,125664,1,NULL),(20985,'2016-12-03 03:39:49',1,125486,1,NULL),(20986,'2016-12-03 03:40:24',1,125663,1,NULL),(20987,'2016-12-03 03:52:08',1,125671,1,NULL),(20988,'2016-12-03 03:52:26',1,125662,1,NULL),(20989,'2016-12-03 03:53:03',1,125672,1,NULL),(20990,'2016-12-03 03:56:18',1,125667,1,NULL),(20991,'2016-12-03 03:57:07',1,125668,1,NULL),(20992,'2016-12-03 03:59:21',1,125676,1,NULL),(20993,'2016-12-03 04:00:29',1,125666,1,NULL),(20994,'2016-12-03 04:01:12',1,125673,1,NULL),(20995,'2016-12-03 04:05:06',1,125678,1,NULL),(20996,'2016-12-03 04:05:16',1,125674,1,NULL),(20997,'2016-12-03 04:05:55',1,125675,1,NULL),(20998,'2016-12-03 04:06:22',1,125679,1,NULL),(20999,'2016-12-03 04:13:53',1,125669,1,NULL),(21000,'2016-12-03 04:14:28',1,125682,1,NULL),(21001,'2016-12-03 04:19:49',1,125677,1,NULL),(21002,'2016-12-03 04:28:29',1,125680,1,NULL),(21003,'2016-12-03 04:56:09',1,125686,1,NULL),(21004,'2016-12-03 05:00:57',1,125685,1,NULL),(21005,'2016-12-03 05:04:16',1,125688,1,NULL),(21006,'2016-12-03 05:05:22',1,125689,1,NULL),(21007,'2016-12-03 05:06:06',1,125687,1,NULL),(21008,'2016-12-03 05:11:21',1,125694,1,NULL),(21009,'2016-12-03 05:11:51',1,125692,1,NULL),(21010,'2016-12-03 05:12:20',1,125693,1,NULL),(21011,'2016-12-03 05:18:59',1,125697,1,NULL),(21012,'2016-12-03 05:25:08',1,125698,1,NULL),(21013,'2016-12-03 05:27:23',1,125683,1,NULL),(21014,'2016-12-03 05:31:26',1,125684,1,NULL),(21015,'2016-12-03 05:32:15',1,125695,1,NULL),(21016,'2016-12-03 05:32:54',1,125696,1,NULL),(21017,'2016-12-03 05:33:53',1,125699,1,NULL),(21018,'2016-12-03 05:40:53',1,125700,1,NULL),(21019,'2016-12-03 07:26:00',1,125705,1,NULL),(21020,'2016-12-03 07:26:35',1,125706,1,NULL),(21021,'2016-12-03 07:27:24',1,125701,1,NULL),(21022,'2016-12-03 07:31:35',1,125702,1,NULL),(21023,'2016-12-03 07:42:32',1,125703,1,NULL),(21024,'2016-12-03 07:52:58',1,125704,1,NULL),(21025,'2016-12-03 08:22:05',1,125708,1,NULL),(21026,'2016-12-03 08:22:44',1,125709,1,NULL),(21027,'2016-12-03 08:24:09',1,125707,1,NULL),(21028,'2016-12-03 08:46:38',1,125710,1,NULL),(21029,'2016-12-03 08:47:14',1,125712,1,NULL),(21030,'2016-12-03 08:52:58',1,125713,1,NULL),(21031,'2016-12-04 01:34:26',1,125493,1,NULL),(21032,'2016-12-04 01:38:19',1,125487,1,NULL),(21033,'2016-12-04 01:39:22',1,125494,1,NULL),(21034,'2016-12-04 01:42:45',1,125497,1,NULL),(21035,'2016-12-04 01:43:22',1,125498,1,NULL),(21036,'2016-12-04 01:44:31',1,125502,1,NULL),(21037,'2016-12-04 01:48:45',1,125503,1,NULL),(21038,'2016-12-04 01:50:44',1,125488,1,NULL),(21039,'2016-12-04 01:51:51',1,125499,1,NULL),(21040,'2016-12-04 01:53:38',1,125489,1,NULL),(21041,'2016-12-04 01:56:32',1,125504,1,NULL),(21042,'2016-12-04 01:58:31',1,125501,1,NULL),(21043,'2016-12-04 02:00:53',1,125505,1,NULL),(21044,'2016-12-04 02:07:38',1,125490,1,NULL),(21045,'2016-12-04 02:09:33',1,125492,1,NULL),(21046,'2016-12-04 02:14:46',1,125495,1,NULL),(21047,'2016-12-04 02:16:55',1,125496,1,NULL),(21048,'2016-12-04 02:20:00',1,125506,1,NULL),(21049,'2016-12-04 02:21:06',1,125507,1,NULL),(21050,'2016-12-04 02:21:32',1,125509,1,NULL),(21051,'2016-12-04 02:22:55',1,125510,1,NULL),(21052,'2016-12-04 02:28:13',1,125714,1,NULL),(21053,'2016-12-04 02:29:00',1,125715,1,NULL),(21054,'2016-12-04 02:29:20',1,125539,1,NULL),(21055,'2016-12-04 02:30:01',1,125542,1,NULL),(21056,'2016-12-04 02:32:31',1,125718,1,NULL),(21057,'2016-12-04 02:36:20',1,125540,1,NULL),(21058,'2016-12-04 02:37:08',1,125541,1,NULL),(21059,'2016-12-04 02:37:42',1,125721,1,NULL),(21060,'2016-12-04 02:38:47',1,125724,1,NULL),(21061,'2016-12-04 02:39:44',1,125543,1,NULL),(21062,'2016-12-04 02:41:27',1,125723,1,NULL),(21063,'2016-12-04 02:42:26',1,125730,1,NULL),(21064,'2016-12-04 02:45:13',1,125720,1,NULL),(21065,'2016-12-04 02:45:23',1,125725,1,NULL),(21066,'2016-12-04 02:47:09',1,125544,1,NULL),(21067,'2016-12-04 02:49:46',1,125719,1,NULL),(21068,'2016-12-04 02:51:39',1,125728,1,NULL),(21069,'2016-12-04 02:52:17',1,125731,1,NULL),(21070,'2016-12-04 02:58:29',1,125732,1,NULL),(21071,'2016-12-04 02:59:15',1,125735,1,NULL),(21072,'2016-12-04 03:03:31',1,125729,1,NULL),(21073,'2016-12-04 03:04:43',1,125752,1,NULL),(21074,'2016-12-04 03:05:16',1,125734,1,NULL),(21075,'2016-12-04 03:06:36',1,125727,1,NULL),(21076,'2016-12-04 03:14:19',1,125737,1,NULL),(21077,'2016-12-04 03:15:03',1,125738,1,NULL),(21078,'2016-12-04 03:18:12',1,125748,1,NULL),(21079,'2016-12-04 03:21:51',1,125739,1,NULL),(21080,'2016-12-04 03:26:56',1,125740,1,NULL),(21081,'2016-12-04 03:27:21',1,125749,1,NULL),(21082,'2016-12-04 03:27:41',1,125742,1,NULL),(21083,'2016-12-04 03:28:18',1,125741,1,NULL),(21084,'2016-12-04 03:28:30',1,125750,1,NULL),(21085,'2016-12-04 03:33:26',1,125751,1,NULL),(21086,'2016-12-04 03:37:20',1,125549,1,NULL),(21087,'2016-12-04 03:37:54',1,125550,1,NULL),(21088,'2016-12-04 03:38:34',1,125743,1,NULL),(21089,'2016-12-04 03:39:07',1,125744,1,NULL),(21090,'2016-12-04 03:46:50',1,125756,1,NULL),(21091,'2016-12-04 03:47:13',1,125759,1,NULL),(21092,'2016-12-04 03:47:33',1,125753,1,NULL),(21093,'2016-12-04 03:51:28',1,125754,1,NULL),(21094,'2016-12-04 04:28:19',1,125767,1,NULL),(21095,'2016-12-04 04:28:41',1,125771,1,NULL),(21096,'2016-12-04 04:29:04',1,125769,1,NULL),(21097,'2016-12-04 04:31:52',1,125772,1,NULL),(21098,'2016-12-04 04:44:14',1,125778,1,NULL),(21099,'2016-12-04 04:45:08',1,125780,1,NULL),(21100,'2016-12-04 04:52:17',1,125775,1,NULL),(21101,'2016-12-04 04:52:53',1,125776,1,NULL),(21102,'2016-12-04 04:53:25',1,125765,1,NULL),(21103,'2016-12-04 04:54:03',1,125766,1,NULL),(21104,'2016-12-04 04:55:14',1,125763,1,NULL),(21105,'2016-12-04 04:57:27',1,125764,1,NULL),(21106,'2016-12-04 04:58:18',1,125781,1,NULL),(21107,'2016-12-04 05:01:48',1,125777,1,NULL),(21108,'2016-12-04 05:02:56',1,125779,1,NULL),(21109,'2016-12-04 05:05:48',1,125782,1,NULL),(21110,'2016-12-04 05:18:41',1,125773,1,NULL),(21111,'2016-12-04 05:19:10',1,125774,1,NULL),(21112,'2016-12-04 05:27:08',1,125761,1,NULL),(21113,'2016-12-04 05:36:30',1,125762,1,NULL),(21114,'2016-12-04 07:11:31',1,125783,1,NULL),(21115,'2016-12-04 07:18:53',1,125784,1,NULL),(21116,'2016-12-04 07:28:31',1,125785,1,NULL),(21117,'2016-12-04 07:57:45',1,125786,1,NULL),(21118,'2016-12-04 07:58:21',1,125787,1,NULL),(21119,'2016-12-04 07:58:59',1,125788,1,NULL),(21120,'2016-12-04 08:09:18',1,125790,1,NULL),(21121,'2016-12-04 08:17:25',1,125791,1,NULL),(21122,'2016-12-04 08:24:24',1,125792,1,NULL),(21123,'2016-12-04 08:55:17',1,125793,1,NULL),(21124,'2016-12-04 08:56:11',1,125794,1,NULL),(21125,'2016-12-04 08:57:22',1,125795,1,NULL),(21126,'2016-12-04 09:03:08',1,125796,1,NULL),(21127,'2016-12-04 09:10:18',1,125797,1,NULL),(21128,'2016-12-04 09:17:53',1,125798,1,NULL),(21129,'2017-01-08 08:47:19',1,125825,1,NULL),(21130,'2017-01-08 08:48:12',1,125826,1,NULL),(21131,'2017-01-08 08:48:48',1,125827,1,NULL),(21132,'2017-01-08 08:49:26',1,125828,1,NULL),(21133,'2017-01-08 08:50:13',1,125829,1,NULL),(21134,'2017-01-08 08:50:45',1,125830,1,NULL),(21135,'2017-01-08 08:51:19',1,125831,1,NULL),(21136,'2017-01-08 08:51:58',1,125832,1,NULL),(21137,'2017-01-08 08:52:31',1,125833,1,NULL),(21138,'2017-01-08 08:53:09',1,125834,1,NULL),(21139,'2017-01-08 08:53:48',1,125835,1,NULL),(21140,'2017-01-08 08:54:38',1,125836,1,NULL),(21141,'2017-01-08 08:55:07',1,125837,1,NULL),(21142,'2017-01-08 08:55:40',1,125838,1,NULL),(21143,'2017-01-08 08:56:14',1,125839,1,NULL),(21144,'2017-01-08 08:56:51',1,125840,1,NULL),(21145,'2017-01-08 08:57:27',1,125841,1,NULL),(21146,'2017-01-08 08:57:57',1,125842,1,NULL),(21147,'2017-01-08 08:59:13',1,110853,1,NULL),(21148,'2017-01-08 08:59:55',1,125844,1,NULL),(21149,'2017-01-08 09:00:30',1,125845,1,NULL);
/*!40000 ALTER TABLE `betting_resulting_queue` ENABLE KEYS */;
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
