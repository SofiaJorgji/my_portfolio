CREATE DATABASE  IF NOT EXISTS `mvc_basic` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mvc_basic`;
-- MySQL dump 10.13  Distrib 5.5.24, for osx10.5 (i386)
--
-- Host: 127.0.0.1    Database: mvc_basic
-- ------------------------------------------------------
-- Server version	5.5.33

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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `re_password` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'sjorgji@lbl.gov','SOFIA','Jorgji','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-02 04:43:26',NULL),(2,'padmini.lingaraju@gmail.com','Bala','Lingaraju','fd44bad268edc4fcea62279dc231f05e',NULL,'2014-02-04 01:23:52',NULL),(3,'padminhki.lingaraju@gmail.com','Bala','Lingaraju','fd44bad268edc4fcea62279dc231f05e',NULL,'2014-02-04 02:20:07',NULL),(4,'sdjorgji@lbl.gov','SOFIA','Jorgji','fd44bad268edc4fcea62279dc231f05e',NULL,'2014-02-04 02:27:44',NULL),(5,'ipadmini.lingaraju@gmail.com','Bala','Lingaraju','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-04 04:59:39',NULL),(6,'sijorgji@lbl.gov','sd','jk','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-11 05:49:55',NULL),(7,'sejorgji@lbl.gov','yjk','yuik','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-11 07:21:17',NULL),(8,'piadmini.lingaraju@gmail.com','Bala','Lingaraju','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-11 07:22:50',NULL),(9,'dfghj@gmail.com','dfg','tgh','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-11 07:25:22',NULL),(10,'sajorgji@lbl.gov','hjk','jkl','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-11 07:31:06',NULL),(11,'ssjorgji@lbl.gov','SOFIA','Jorgji','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-14 01:10:50',NULL),(12,'pamdmini.lingaraju@gmail.com','Bala','Lingaraju','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-14 01:44:40',NULL),(13,'pssadmini.lingaraju@gmail.com','Bala','Lingaraju','386f447f2da619d8c7ab5fa844803233',NULL,'2014-02-15 20:04:32',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-04 18:54:44
