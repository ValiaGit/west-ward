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
-- Table structure for table `core_users`
--

DROP TABLE IF EXISTS `core_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `core_countries_id` int(11) NOT NULL,
  `core_currencies_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `nickname` varchar(45) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` tinyblob NOT NULL COMMENT '1 - Male\n2 - Female',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `grantSession` varbinary(150) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '0 Female; \n1 Male;',
  `birthdate` date NOT NULL,
  `city` varchar(125) NOT NULL,
  `address` varchar(125) NOT NULL,
  `address_zip_code` varchar(25) DEFAULT '99999',
  `phone` varchar(50) NOT NULL,
  `is_email_confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `is_phone_confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `is_passport_confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `is_address_confirmed` tinyint(4) DEFAULT '0',
  `bet_privacy` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - Public,\n2 - Private',
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) DEFAULT '1' COMMENT '1 - Active\n2 - Blocked\n3 - Suspended\n4 - Self Excluded\n6 - Deregistered\n7 - Suspended Permanently\n8 - VIP and etc',
  `name_privacy` tinyint(4) DEFAULT '1' COMMENT '1 - Full name, 2 - Nickname',
  `receive_email_notifications` tinyint(4) NOT NULL DEFAULT '1',
  `receive_phone_notifications` tinyint(4) DEFAULT '1',
  `last_login_date` timestamp NULL DEFAULT NULL,
  `last_session_activity_time` timestamp NULL DEFAULT NULL,
  `gaming_index` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`,`core_countries_id`,`core_currencies_id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `grantSession_UNIQUE` (`grantSession`),
  KEY `fk_core_users_core_countries1_idx` (`core_countries_id`),
  KEY `privacy` (`bet_privacy`),
  KEY `fk_core_users_core_currencies1_idx` (`core_currencies_id`),
  CONSTRAINT `fk_core_users_core_countries1` FOREIGN KEY (`core_countries_id`) REFERENCES `core_countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_core_users_core_currencies1` FOREIGN KEY (`core_currencies_id`) REFERENCES `core_currencies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_users`
--

LOCK TABLES `core_users` WRITE;
/*!40000 ALTER TABLE `core_users` DISABLE KEYS */;
INSERT INTO `core_users` VALUES (1,82,1,'shako.kakauridze@gmail.com','Shalva','Kakauridze','user3','shako','174031289831432eef56121132e59716a0c8228c',576990.00,'q2BLRG0aHjEiD45r55/FhQ==',1,'1992-09-07','Tbilisi','andronikashvili 83','99999','+995593712517',1,1,1,0,1,'2015-06-25 20:57:34',1,1,1,1,'2017-01-13 05:45:44','2017-01-13 06:52:34',0),(3,15,1,'peter@wayward.la','peter','seisenbacher','yawaraken','peter','e3e46f5fb94025c8b199eb4c2a778065108f5d92',200.00,'87d6f47f606347c3c115092c7309f47c',1,'1966-02-09','Vienna','test#1','99999','+43123123123',1,0,1,0,1,'2015-06-28 21:40:21',1,0,1,1,'2017-01-09 02:33:32','2017-01-09 02:33:50',0),(5,82,1,'mariam.arveladze91@gmail.com','Mariam','Arveladze','mariam','mariam','8b116299fa02cb24025a5b519e5ea00280fc6a90',0.00,'9aR8HZMy5l8H7CH+pfiM6g==',2,'1991-12-20','Tbilisi','Andronikashvili 81','99999','+995599334414',1,0,0,0,1,'2015-07-26 14:59:43',1,1,1,1,NULL,NULL,0),(6,82,1,'levan.kakauridze@gmail.com','Levan','Kakauridze','Damn6','levan','ab453cb0dbb0f8fddd225f30294ea5a80e7bc6e6',0.00,'yyRVXnzeZnP52Tl7meUXsw==',1,'1994-10-04','tbilisi','andronikashvili 81','99999','+995598506035',1,0,0,0,1,'2015-07-26 15:14:13',1,1,1,1,NULL,NULL,0),(9,136,1,'pierremangion@gmail.com','Pierre','mangion','pierrem','pierrem','88aaf86294efb7524806a5efffe29dc70ae09775',0.00,'+aThDmMcfC7qNBBkUBEuPQ==',1,'1981-10-21','gzira','gzira','99999','+35621335511',0,0,0,0,1,'2015-09-11 09:42:24',7,1,1,1,NULL,NULL,0),(10,1,1,'pierremangion@icloud.com','Pierre','mangion','pierremangion','pierremangion','88aaf86294efb7524806a5efffe29dc70ae09775',0.00,'KLtb9U3PFMmcNCq6ceiEkQ==',1,'1981-10-21','gzira','gzira','99999','+35621335510',1,0,0,0,1,'2015-09-11 09:44:53',1,1,1,1,'2016-03-14 11:10:46','2016-03-14 11:10:46',0),(11,1,1,'pierre_mangion@hotmail.com','Pierre','mangion','folio','folio','88aaf86294efb7524806a5efffe29dc70ae09775',0.00,'sJZlrCXsZxYBqTxXUEoF8Q==',1,'1981-10-21','gzira','gzira','99999','+35699429590',1,1,0,0,1,'2015-09-11 09:47:08',1,1,1,1,'2016-02-24 07:29:34','2016-02-24 07:29:56',0),(12,15,1,'spitz.karin@gmail.com','Karin','Spitz','karin','karin','14e50ed848fdcd9123eaf6fe607f945aea169607',0.00,'QGnEIO5srd5fjot5JguMyA==',2,'1969-02-06','Neuaigen','Waldsee','99999','+436649114614',1,0,0,0,1,'2015-11-14 09:49:52',2,1,1,1,NULL,NULL,0),(27,136,1,'capstoneassurance@gmail.com','Capstone','Assurance','CASL1','CASL1','a163d23b3b20a3d79a117054a3535a7f8048a5fc',0.00,'0xBjVT4OXxVt9nLiBoV1tg==',1,'1980-01-03','Birkikara','Test Street','TST1231','+35611224455',1,0,1,0,1,'2016-02-15 11:52:07',1,1,1,1,'2016-03-01 15:55:28','2016-03-01 17:00:22',0),(28,136,1,'capstoneassurance2@gmail.com','Capstone','Assurance','CASL2','CASL2','a163d23b3b20a3d79a117054a3535a7f8048a5fc',0.00,'pO5W4OreFyIy3hFYV6ac3A==',1,'1982-02-10','Birkirkara','Test Street','TST11231','+35611221133',1,0,0,0,1,'2016-02-15 11:55:06',1,1,1,1,'2016-02-24 11:09:51','2016-02-24 11:10:06',0),(29,136,1,'capstoneassurancelimited@gmail.com','Capstone','Assurance','CASL3','CASL3','a163d23b3b20a3d79a117054a3535a7f8048a5fc',0.00,'IsQcvMhFfHm9ln7m3tiOSg==',1,'1980-02-13','Birkirara','Test Street','TST1131','+35611221134',1,0,0,0,1,'2016-02-15 11:57:46',9,1,1,1,'2016-02-26 12:55:37','2016-02-26 12:55:56',0),(31,136,1,'krisbaron@gmail.com','kris','baron','krsbrn','krsbrn','8120bccaef1f1257dd1edd582633a9b2155a32e2',0.00,NULL,1,'1998-02-05','Mscala','agkjkg','MSK2214','+35698786543',0,0,0,0,1,'2016-02-18 11:33:50',1,1,1,1,NULL,NULL,0),(32,136,1,'pierremangion@outlook.com','pierre','mangion','pmangion','pmangion','88aaf86294efb7524806a5efffe29dc70ae09775',0.00,'kVpJCPYUA9jyi+3/gXH7RA==',1,'1976-10-20','sliema','sliema','slm2312','+35621335715',1,0,0,0,1,'2016-02-22 13:18:03',1,1,1,1,'2016-02-24 10:15:34','2016-02-24 11:07:19',0),(33,136,1,'capstoneassurancelimited@hotmail.com','Capstone','Assurance','CASL4','CASL4','a163d23b3b20a3d79a117054a3535a7f8048a5fc',0.00,'S7kTbDG6bL2m4Iyn+zAGXw==',1,'1980-02-01','Test','Test','TST123','+35611223322',0,0,0,0,1,'2016-02-24 11:24:02',1,1,1,1,'2016-02-24 11:24:15','2016-02-24 11:24:22',0),(34,136,1,'capstoneassurance2@hotmail.com','Capston','Assurance','CASL5','CASL5','a163d23b3b20a3d79a117054a3535a7f8048a5fc',0.00,'tieDhyh0Ho1LX/lQbXweXA==',1,'1980-02-01','Test','Test','TST123','+35611223321',0,0,0,0,1,'2016-02-24 11:27:23',1,1,1,1,'2016-02-24 11:27:34','2016-02-24 11:28:42',0),(37,136,1,'pierremangion@me.com','victor','micallef','vmicallef','vmicallef','c5dc0434e64af70ff33b4fa63ccdc15ae856bece',0.00,NULL,1,'1996-12-03','malta','malta','slm2222','+35699112233',0,0,0,0,1,'2016-03-10 15:49:37',1,1,1,1,NULL,NULL,0),(38,111,1,'kyoh@wayward.la','kyoh','kunishio','Don Donaway','kaimaruyama','dabe68757f11b1c531509d683a93292b7788c0c0',1408.00,'CQ85GOCkM9/VY29Vu1IUxg==',1,'1960-02-12','Tokyo','Kyohs home','0119','+995599572990',1,1,0,0,1,'2016-05-21 19:04:14',1,0,1,1,'2017-01-08 09:19:26','2017-01-08 09:22:24',0),(39,1,1,'menarguez.brian@yahoo.com','Brian','Menarguez','bsesh','bsesh','e5d28d0f28c21e30fd073a094978363252f9fb91',0.00,'mypJwA3RdZPZjNTtwv0gNg==',1,'1998-05-15','Basking Ridge','54 Lurline Drive','07920','+3553340209',0,0,0,0,1,'2016-05-28 12:23:58',1,1,1,1,'2016-05-28 12:24:15','2016-05-28 12:29:21',0),(42,235,1,'sandrasmith@hotmail.com','Sandra','Smith','Sandy16!!','Sandy16!!','88c277aa05ff838dabd3c95d5985c90f7f60670d',0.00,NULL,2,'1979-07-10','london','75 paradise street london','NW16 4SH','+44',0,0,0,0,1,'2016-07-26 10:09:31',1,1,1,1,NULL,NULL,0),(43,235,1,'sandrasmith@yahoo.com','Sandra','Smith','Sandy16','Sandy16','9c7ebce63ce479f79eb6c588db69e59b9e7bf424',0.00,'oACUbEaxfjnhowcVr7l/0A==',2,'1974-07-02','London','47 Paradise street London','NW16 4SH','+444567 8945',0,0,0,0,1,'2016-07-26 10:14:09',1,1,1,1,'2016-07-26 10:14:34','2016-07-26 10:41:26',0),(44,102,1,'Jaikeysarraf@gmail.com','Jky','Srf','Jkysrf','Jkysrf','7c1b0af8eb7d824be92811dbe1d6cb3758877055',0.00,'Drqa74TMaGiJ1eJ5UtgV2A==',1,'1990-04-28','Jaipur','25 jain','304021','+919529998889',0,0,0,0,1,'2016-08-04 04:13:11',1,1,1,1,'2016-08-04 04:13:42','2016-08-04 04:14:12',0),(45,61,1,'crlnlarsen@gmail.com','c aroline','larsen','carolinelarsen','carolinelarsen','c15fb288fc6150a5af3945725b303103b75a625e',0.00,'9FSkdJsorHeCrKjaxOXX5A==',2,'1998-05-05','aalborg','Nytrov','9000','+4542159010',0,0,0,0,1,'2016-09-07 11:35:17',1,1,1,1,'2016-09-07 11:36:27','2016-09-07 11:53:58',0),(46,82,1,'data030785@yahoo.com','David','Bordzikuli','data1985','data1985','ebe6e2ef4d633f8857945c8c68d258e4c3b8dd83',1000.00,'kNYKhwGOraCevIA+wqvC6w==',1,'1985-07-03','Tbilisi','vaja-pshavela ave','0186','+995599553134',1,1,0,0,1,'2016-11-06 07:33:27',1,1,1,1,'2016-12-12 13:50:41','2016-12-12 13:51:14',0),(47,16,1,'azernovruzlu@icloud.com','Azer','Novruzov','azernovruzlu','azernovruzlu','f4bcad41bd9b3159d18094e13c8abc635e425eec',1000.00,'Zh2On2eDLG3YvSGD4KzBRA==',1,'1983-04-02','Baku','Baku, Azerbaijan','AZ1029','+994502005085',1,0,0,0,1,'2016-11-06 07:52:06',1,1,1,1,'2016-12-28 08:12:52','2016-12-28 08:12:52',0),(48,82,1,'berikelashvili@gmail.com','Giorgi','Berikelashvili','komisia','komisia','8b116299fa02cb24025a5b519e5ea00280fc6a90',0.00,'Zraq03CqLHyFRD6XEyaOzQ==',1,'1989-06-19','Tsnori','Nugzar Motkecili str #19','0137','+995551852851',1,0,1,0,1,'2016-11-16 08:51:47',1,1,1,1,'2017-01-02 11:49:37','2017-01-02 11:49:55',0),(49,82,1,'giorgi@wayward.la','giorgi','aleksidze','giorgi','giorgi','ca5f05453bc871943927c64b9ab2616c570d7d95',1000.00,'OMyTyCXbE2JikrPqjpuRgA==',1,'1974-09-27','tbilisi','6, bashaleishvili str','0179','+995577515858',1,0,0,0,1,'2016-11-16 09:33:00',1,1,1,1,'2016-12-19 08:25:10','2016-12-19 08:25:31',0),(100,1,1,'test@top.ge','markus','davarashvili','markus123123','markus123123','b0a6745c7121b05ab0ee7a868be249cbed229a50',0.00,NULL,1,'1987-11-10','tbilisi','andronikashvili 81','9987','+355599292296',0,0,0,0,1,'2016-11-26 11:48:22',1,1,1,1,NULL,NULL,0),(101,15,1,'lehmton@hotmail.com','markus','flenner','markus','markus','95d4f6522cb2584180a777077e61977916773068',0.00,'m/AF/61qxlZS1GQtzJuZ0w==',1,'1971-10-04','vienna','brantinggasse 63','1100','+4306607825233',1,0,0,0,1,'2016-11-26 11:57:49',1,1,1,1,'2016-11-26 11:58:20','2016-11-26 12:58:20',0),(103,234,1,'hb@spowi-projekt.at','Harald','Horschinegg','hb@spowi-projekt.at','hb@spowi-projekt.at','863f75a51a4547ad47246d494c5b2b938af0ef23',0.00,'zJQ8UEAmaZWzF7bOgD2XIQ==',1,'1968-01-07','Al Hamra Village','Palace Hotel 6010','0000','+971564428034',0,0,0,0,1,'2016-11-29 16:44:06',1,1,1,1,'2016-12-01 09:07:51','2016-12-01 09:34:25',0),(104,16,2,'mehman@gmail.com','Mehman','Mehtiyev','MehmanMextiyev','MehmanMextiyev','f4bcad41bd9b3159d18094e13c8abc635e425eec',0.00,'k/yw4qa5GJ7LCIxGLS0fVA==',1,'1998-12-02','Baku','Maharramov 25','AZ1101','+994502005000',0,0,0,0,1,'2016-12-04 12:53:32',1,1,1,1,'2016-12-04 12:55:05','2016-12-04 12:55:05',0),(105,16,6,'Sahilazizoglu@gmail.com','Sahil','Novruzov','Saxo','Saxo','ae0d2f75631a08312ed7070aa0c229d4d055f08d',0.00,NULL,1,'1998-08-01','Baku','Bineqedi.,İ dagistanli.,ev 57 .,m 58','1113','+994705444547',0,0,0,0,1,'2016-12-05 01:52:08',1,1,1,1,NULL,NULL,0),(106,16,1,'balakhanova@yahoo.com','Irada','Balakhanova','Iradabalakhanova','Iradabalakhanova','0b434e57d4f0e9ec0c431c2f3e13df6e8ef5e4c6',0.00,'M2lGKu9CYxsfyY3UL8Ze5A==',2,'1988-06-13','Baku','Baku','Aze1000','+994506794088',0,0,0,0,1,'2016-12-05 08:42:38',1,1,1,1,'2016-12-05 11:57:06','2016-12-05 12:25:32',0),(107,16,6,'muradakhundov93@gmail.com','Murad','Axundov','murad','murad','2d8bae1cd0a87560e957e21fcf73c816347287e1',0.00,'0w2+9laW+J2d9bpwSQ4Jcg==',1,'1993-11-07','Bakı','X.Bayramov, 2','AZ1000','+994558084829',1,0,0,0,1,'2016-12-05 09:09:02',1,0,1,1,NULL,'2016-12-05 09:30:39',0),(108,233,1,'roman@start2pay.com','roman','Zhdan','roman','roman','fec211ee7238c9547c3dbd33b5d7f01dd6ef9c5a',0.00,'wR4ZN1p+MKnft1RavPaS/A==',1,'1998-12-01','Kyiv','01001','01001','+380',1,0,0,0,1,'2016-12-15 16:06:30',1,1,1,1,NULL,'2016-12-15 16:30:52',0),(109,233,4,'sslam59@gmail.com','Stepan','Salmonov','sslam59','sslam59','5f1d7d7c4dfc93d96f684aed4fcc5603071203b8',0.00,'d896a49bc16d057d33f3ba0f5654a183',1,'1980-08-12','Kiev','Khreschatik 16, flat 78','02095','+380937610293',0,0,0,0,1,'2016-12-16 17:30:30',1,1,1,1,'2016-12-16 17:30:35','2016-12-16 17:31:41',0),(110,233,1,'sslam59f@gmail.com','Stepan','Stepanov','sslam59f','sslam59f','7b63c2b808106b881182f916fb5677e026dfbab4',1100.00,'pp1EG4A7bgjb0YvEJDwU6Q==',1,'1980-07-15','Kiev','sslam59f@gmail.com','','+380937618922',1,0,0,0,1,'2016-12-16 17:33:12',1,1,1,1,'2016-12-16 17:33:16','2016-12-16 17:37:32',0),(111,182,2,'johnhighsky@mail.ru','john','highsky','johnhighsky','johnhighsky','389909fcb64adbf3517d219258a289746208b371',0.00,'wWLfJOBAoZk5v2HNn863Nw==',1,'1986-04-24','Moscow','Gagarina','9956566','+79602349803',1,0,0,0,1,'2016-12-20 09:32:26',1,1,1,1,'2016-12-21 11:05:54','2016-12-21 11:05:55',0),(119,1,1,'mariami@gmail.com','mariami','arveladze`','mariami','mariami','8b116299fa02cb24025a5b519e5ea00280fc6a90',0.00,NULL,1,'1999-01-01','tbilisi','politkas #1','0186','+355123123123',0,0,0,0,1,'2017-01-09 03:09:23',1,1,1,1,NULL,NULL,0);
/*!40000 ALTER TABLE `core_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:44
