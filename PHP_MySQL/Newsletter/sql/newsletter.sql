CREATE DATABASE  IF NOT EXISTS `newsletter` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `newsletter`;
-- MySQL dump 10.13  Distrib 5.5.24, for osx10.5 (i386)
--
-- Host: 127.0.0.1    Database: newsletter
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
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `pic_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (23,'Bala','Lingaraju','padmini.lingaraju@gmail.com','upload/silence.jpg','2014-01-04 14:33:05','2014-01-04 14:33:05'),(24,'Sofia','Jorgji','sjorgji@lbl.gov','upload/DSCN2558.JPG','2014-01-04 14:42:46','2014-01-04 14:42:46'),(25,'Das','Pemmaraju','pemmaras@tcd.ie','upload/4.jpg','2014-01-04 14:43:21','2014-01-04 14:43:21'),(26,'Sofia','Back','inspire1me@gmail.com','upload/Wall.png','2014-01-04 15:05:05','2014-01-04 15:05:05'),(27,'Bala','Lingaraju','padmini.lingaraju@gmail.com','upload/51ZpU.jpg','2014-02-12 16:22:08',NULL),(28,'Bala','Lingaraju','pdadmini.lingaraju@gmail.com','upload/51ZpU.jpg','2014-02-12 17:08:52',NULL),(29,'gfhj','hgjhkjl','ckrofi_hm@hotmail.com','upload/binary tree.png','2014-02-24 15:07:25',NULL),(30,'Sofia','Jorgji','jorgjis@tcd.ie','upload/1.jpg','2014-02-24 16:03:09',NULL),(31,'George','Krey','naomikrey@gmail.com','upload/2.jpg','2014-02-24 16:04:03',NULL),(32,'Mary','Cordon','marycordon@gmail.com','upload/3.jpg','2014-02-24 16:05:13',NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_has_topics`
--

DROP TABLE IF EXISTS `students_has_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_has_topics` (
  `students_id` int(11) NOT NULL,
  `topics_id` int(11) NOT NULL,
  PRIMARY KEY (`students_id`,`topics_id`),
  KEY `fk_students_has_topics_topics1_idx` (`topics_id`),
  KEY `fk_students_has_topics_students_idx` (`students_id`),
  CONSTRAINT `fk_students_has_topics_students` FOREIGN KEY (`students_id`) REFERENCES `students` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_students_has_topics_topics1` FOREIGN KEY (`topics_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_has_topics`
--

LOCK TABLES `students_has_topics` WRITE;
/*!40000 ALTER TABLE `students_has_topics` DISABLE KEYS */;
INSERT INTO `students_has_topics` VALUES (30,2),(32,2),(30,3),(31,3),(31,4),(31,5),(32,5),(30,6),(30,7),(31,7),(32,7),(31,8),(32,8),(30,9),(32,9);
/*!40000 ALTER TABLE `students_has_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (2,'NodeJS','2013-12-09 14:06:23','2013-12-09 14:06:23'),(3,'SQL','2013-12-09 14:08:15','2013-12-09 14:08:15'),(4,'App Engine','2013-12-09 14:08:26','2013-12-09 14:08:26'),(5,'Ruby on Rails','2013-12-09 14:08:35','2013-12-09 14:08:35'),(6,'PHP','2013-12-09 14:08:41','2013-12-09 14:08:41'),(7,'Javascript','2013-12-09 14:08:50','2013-12-09 14:08:50'),(8,'iOS','2013-12-09 14:09:00','2013-12-09 14:09:00'),(9,'Database Design','2013-12-09 14:09:14','2013-12-09 14:09:14');
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-04 18:39:24
