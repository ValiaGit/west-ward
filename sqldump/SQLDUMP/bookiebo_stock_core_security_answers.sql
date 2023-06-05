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
-- Table structure for table `core_security_answers`
--

DROP TABLE IF EXISTS `core_security_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_security_answers` (
  `core_users_id` int(11) NOT NULL,
  `core_security_questions_id` int(11) NOT NULL,
  `answer_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`core_users_id`,`core_security_questions_id`),
  UNIQUE KEY `core_users_id_UNIQUE` (`core_users_id`),
  KEY `fk_core_security_answers_core_users1_idx` (`core_users_id`),
  KEY `fk_core_security_answers_core_security_questions1_idx` (`core_security_questions_id`),
  CONSTRAINT `fk_core_security_answers_core_security_questions1` FOREIGN KEY (`core_security_questions_id`) REFERENCES `core_security_questions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_core_security_answers_core_users1` FOREIGN KEY (`core_users_id`) REFERENCES `core_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_security_answers`
--

LOCK TABLES `core_security_answers` WRITE;
/*!40000 ALTER TABLE `core_security_answers` DISABLE KEYS */;
INSERT INTO `core_security_answers` VALUES (1,1,'DBxMF8Kk5sG87IBCQGMPR3F03WY5GvQzQUFOdAg4hEyup2diC8frqnvUPKuhBfzYSI6q3Ny7z5SywWjrvk80hw=='),(3,1,'V2D9jEmMi1DxYH64VZOhSe9PdeMXEVZFN4D+xLkOCM2pFqXSrwG5FL7Bvkgr8PKQdJauWHmlNXEmpoW0ZOK75A=='),(5,1,'dpR9fvlHub61JJTD0Szk+8lnyF2McV0PVQ8FEpTwoFwzAfx+kagYFlYCNGdPg0fhz7nMEH5cFtqibA8EthvE/A=='),(6,1,'DBxMF8Kk5sG87IBCQGMPR3F03WY5GvQzQUFOdAg4hEyup2diC8frqnvUPKuhBfzYSI6q3Ny7z5SywWjrvk80hw=='),(9,1,'L4NmhKEJ/XY+N8ORL3stkiIKpN7JQBQF7ctt5n9/E8JLwZZUREV4u71SbHEAiQT0oE3uLrw9iFBsH45u9nngOw=='),(10,1,'L4NmhKEJ/XY+N8ORL3stkiIKpN7JQBQF7ctt5n9/E8JLwZZUREV4u71SbHEAiQT0oE3uLrw9iFBsH45u9nngOw=='),(11,1,'L4NmhKEJ/XY+N8ORL3stkiIKpN7JQBQF7ctt5n9/E8JLwZZUREV4u71SbHEAiQT0oE3uLrw9iFBsH45u9nngOw=='),(27,1,'V7iKhK4CwXZu9L95LC2FU2sSxs5f3pSFe/rU8NBSlWmweM0S/tqkdy7j6miIBFJB8qrHMuvixkT76G15T2EEpQ=='),(28,1,'V7iKhK4CwXZu9L95LC2FU2sSxs5f3pSFe/rU8NBSlWmweM0S/tqkdy7j6miIBFJB8qrHMuvixkT76G15T2EEpQ=='),(29,1,'V7iKhK4CwXZu9L95LC2FU2sSxs5f3pSFe/rU8NBSlWmweM0S/tqkdy7j6miIBFJB8qrHMuvixkT76G15T2EEpQ=='),(31,1,'m/YjtikDdpqV1JhKABSDrNmZJitLzb4bjpJkgyQG7VFaMvIFkBttaBOmfh5y3KKKs9MqKEQxiJgjYvbHYp5U7Q=='),(32,1,'L4NmhKEJ/XY+N8ORL3stkiIKpN7JQBQF7ctt5n9/E8JLwZZUREV4u71SbHEAiQT0oE3uLrw9iFBsH45u9nngOw=='),(33,1,'i3dgP+mpdT+jJ0MuxwY0aXCMeGXWub/K6A9Ap0upuc8OgqjnMQNIUqH+4QVqn50w2GNz/JuJ11Tn3EPtZn8uEg=='),(34,1,'i3dgP+mpdT+jJ0MuxwY0aXCMeGXWub/K6A9Ap0upuc8OgqjnMQNIUqH+4QVqn50w2GNz/JuJ11Tn3EPtZn8uEg=='),(37,1,'0UuXRxT29QT1H4TfUEUtIjEl8pbb8IZpTam0Rx5XDaCGhj8rxZNu0jOraSFUnqsRrneqlUHoP1jHJI2UvX9NIw=='),(38,1,'KCN1E2WWeQRhR62jq/mM00PoE4CksAFowuYsh0jWD31eHSpjEJIhPraBQ/V2bFcc7QuV9MZaK/RwYct7tvpMZQ=='),(39,1,'dbZafeIKRr6N2Wzt3o781C9hl67wGi+xW0sKK1CrJnviEtTZDBA9bP7fo+QqqQ7tzD6BcXv0Mw3XaoX8Zca5Ag=='),(42,1,'Me4yvzbXfMV8w4hsMDKPLT5hkuQsMVUUcsow51Xt2KEH3ekKho3VYJHK8cVhy8s3lCvwVnwcyQyP0erxoTL2yg=='),(43,1,'Me4yvzbXfMV8w4hsMDKPLT5hkuQsMVUUcsow51Xt2KEH3ekKho3VYJHK8cVhy8s3lCvwVnwcyQyP0erxoTL2yg=='),(44,1,'CRnJi6rzLezD7XWrQg294wX1oft+2UTNXTMFot9twrUFp287jo/t1NIjqNki1GPvQ60FEjItjOmsr0wLl+A1nQ=='),(45,2,'kuUNOjK7pY9xS7dE8kZif7FKE29lBh14HuKnFNNeIJridqHc6cPrcfqLpybxFzWBryw+Xaeb8m3H3AgoZPZh6Q=='),(46,1,'i1i8Nag6Q1cy69VXFIptFYNkFIrK8KM37CDgw6RRFg9DLUI65nF2m/95SS650CbsRb9xI+86CVaADZ8DUf/b8A=='),(47,1,'nCyydWWAJOA7fJyCq/XngEDgRc6Nnw1VePV4PN30VYjw+2Xed5jssqt1a59uXCB6WV6BgExKFRlDms2ySzO+PA=='),(48,1,'U2fCT5UbPfFWtZxHnu01p+iFcwxn+F2J3EnPUTAztbd3h0M06fgkIIPn1Ui0zy6SU6aAVOwCsvHmMmDN018JKQ=='),(49,1,'U2fCT5UbPfFWtZxHnu01p+iFcwxn+F2J3EnPUTAztbd3h0M06fgkIIPn1Ui0zy6SU6aAVOwCsvHmMmDN018JKQ=='),(100,1,'DBxMF8Kk5sG87IBCQGMPR3F03WY5GvQzQUFOdAg4hEyup2diC8frqnvUPKuhBfzYSI6q3Ny7z5SywWjrvk80hw=='),(101,2,'pkFNQr+ngiEgiYtXmthbc6XSo8NxzLWXX9EcBgn0bKoQBs9QKSBlIY3n++7kuN9fToMYCOHimehmTHSBvhJMVQ=='),(103,1,'bxwQn2/JFxShY/xf96dtZEemsbElUq1HHJ/yupJRAo15DDXpLQXuFtVexkC+cKwj1cNYAaW052iHa3g7gLVOjg=='),(104,1,'aOUp7vuS03LNnYI1Q1WFVn9QyO8mztAbaJMt/wIQQkY7Wg9+EqRt52WqJSv5bPXG5NDAiM2Ibqqc58aDjeMe9Q=='),(105,1,'H3eycHBzJoP+iiB/wv4mFn71olxvJ3AMtr7OMWLC+8JWc8kNv6Kx1E6VF8ESdaj8lColq/yss57fL3CEmJwR2A=='),(106,1,'DhVIF+E/NRrhTNjadT5/Qfqfu4Co1m5dZHpYgoeriWttAy8BuxFm6gEKTB5UwcJZUUVx+/IybhE0haxahwCBJQ=='),(107,6,'yMmO8xv0p4KD1aCKzdUNsglHy4TWggTD9JOT22OkrLM6d4TWeHoj8/5vpZMXsyqDvHZqhsLExl6IQ0nNXoffJw=='),(108,6,'gWhlgN4zRwOaKCywvdOfIbLSrKICxxLs1J4Vnhit1Pyt08F8JfdP2o98ypmp0F2G6+RRK2Wpun4RLfZibGJIOg=='),(109,2,'5CkgnmAnlNW7R9+rurOC3vZlbk2ck9PhlXT2AagBgh1/43tTYYCgrZ6bEAj9QDbv/Q/bdDA2pLCU6zDNkwA6Mg=='),(110,2,'5CkgnmAnlNW7R9+rurOC3vZlbk2ck9PhlXT2AagBgh1/43tTYYCgrZ6bEAj9QDbv/Q/bdDA2pLCU6zDNkwA6Mg=='),(111,2,'uIh53d1j1IUwtAwgiWQQQr2ttveqzzKDtDqwm5ejvbdV2ITA3nh8SOjyuGSUPW5VQjEIMaYJWjjUTokqKGqO5Q=='),(119,1,'SQJ+o7DeE9GhWSkJAWgLlUhE7fy6B+IregbDUdz2oaQKBFnYqrzqw+mS5/WRZXbsspU5uitjrprcHt6fTIm33A==');
/*!40000 ALTER TABLE `core_security_answers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-01  9:16:42
