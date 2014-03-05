CREATE DATABASE  IF NOT EXISTS `exam` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `exam`;
-- MySQL dump 10.13  Distrib 5.5.24, for osx10.5 (i386)
--
-- Host: 127.0.0.1    Database: exam
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
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(45) DEFAULT NULL,
  `grade` int(11) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `note` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `students_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_exams_students_idx` (`students_id`),
  CONSTRAINT `fk_exams_students` FOREIGN KEY (`students_id`) REFERENCES `students` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
INSERT INTO `exams` VALUES (1,'Math',100,'Passed','Excellent!','2014-01-05 12:38:06','2014-01-05 12:38:06',1),(2,'English',88,'Passed','Very Good!','2014-01-05 13:49:47','2014-01-05 13:49:47',1),(3,'Physics',100,'Passed','Perfect!','2014-01-05 13:52:16','2014-01-05 13:52:16',1),(4,'English',80,'Passed','Very good! Tries hard.','2014-01-05 13:52:50','2014-01-05 13:52:50',2),(5,'Math',79,'Passed','Fairly good!','2014-01-05 13:53:13','2014-01-05 13:53:13',2),(6,'Physics',78,'Passed','Good!','2014-01-05 13:53:32','2014-01-05 13:53:32',2),(7,'Math',91,'Passed','Very good!','2014-01-05 13:54:34','2014-01-05 13:54:34',3),(10,'English',88,'Passed','Very intelligent!','2014-01-05 14:00:13','2014-01-05 14:00:13',3),(11,'Physics',76,'Passed','Good!','2014-01-05 14:00:31','2014-01-05 14:00:31',3),(12,'English',37,'Failed','She needs more work!','2014-01-05 14:01:00','2014-01-05 14:01:00',4),(13,'Physics',94,'Passed','Nearly perfect!','2014-01-05 14:01:23','2014-01-05 14:01:23',4),(14,'Math',100,'Passed','Excellent!','2014-01-05 14:01:50','2014-01-05 14:01:50',4),(18,'Math',40,'Failed','He tries hard but still not quite good!','2014-01-05 14:17:41','2014-01-05 14:17:41',5),(19,'English',76,'Passed','Quite good!','2014-01-05 14:18:52','2014-01-05 14:18:52',5),(20,'Physics',86,'Passed','Enjoys physics!','2014-01-05 14:19:13','2014-01-05 14:19:13',5),(23,'English',96,'Passed','Impressive!','2014-01-05 14:21:08','2014-01-05 14:21:08',6),(24,'Physics',76,'Passed','Can do better!','2014-01-05 14:21:24','2014-01-05 14:21:24',6),(25,'Math',40,'Failed','Not very good!','2014-01-05 14:21:44','2014-01-05 14:21:44',6),(26,'Math',49,'Failed','Needs more work!','2014-01-05 14:22:03','2014-01-05 14:22:03',7),(27,'English',93,'Passed','Impressive','2014-01-05 14:22:20','2014-01-05 14:22:20',7),(28,'Physics',35,'Failed','Needs more work!','2014-01-05 14:22:41','2014-01-05 14:22:41',7),(29,'English',80,'Passed','Very good!','2014-01-05 14:23:00','2014-01-05 14:23:00',8),(30,'Math',67,'Failed','Needs more work!','2014-01-05 14:23:19','2014-01-05 14:23:19',8),(31,'Physics',69,'Failed','Tries hard but needs more work!','2014-01-05 14:23:56','2014-01-05 14:23:56',8),(32,'English',100,'Passed','Excellent!','2014-01-05 14:24:19','2014-01-05 14:24:19',9),(33,'Math',20,'Failed','Needs a lot of work!','2014-01-05 14:24:41','2014-01-05 14:24:41',9),(34,'Physics',75,'Passed','Good!','2014-01-05 14:24:57','2014-01-05 14:24:57',9),(35,'English',100,'Passed','Excellent!','2014-01-05 14:25:32','2014-01-05 14:25:32',10),(36,'Math',85,'Passed','Very good!','2014-01-05 14:25:52','2014-01-05 14:25:52',10),(37,'Physics',75,'Passed','Good!','2014-01-05 14:26:08','2014-01-05 14:26:08',10),(38,'Chemistry',9,'Failed','Bad!','2014-01-05 14:31:36','2014-01-05 14:31:36',10),(39,'Biology',9,'Failed','Poor effort!','2014-01-05 15:15:20','2014-01-05 15:15:20',10),(40,'English',3,'Failed','jk,','2014-01-05 19:41:20','2014-01-05 19:41:20',1),(41,'Science',3,'Failed','Very bad!','2014-01-06 22:18:18','2014-01-06 22:18:18',1),(42,'jl;',1,'Failed','lk','2014-02-24 15:04:45','2014-02-24 15:04:45',4);
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(145) DEFAULT NULL,
  `last_name` varchar(145) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'Das','Pemmaraju','2014-01-05 12:31:09','2014-01-05 12:31:09'),(2,'Sofia','Jorgji','2014-01-05 12:31:09','2014-01-05 12:31:09'),(3,'Padmini','Lingaraju','2014-01-05 12:31:09','2014-01-05 12:31:09'),(4,'Eleni','Nika','2014-01-05 12:31:09','2014-01-05 12:31:09'),(5,'Petros','Nikas','2014-01-05 12:31:09','2014-01-05 12:31:09'),(6,'Alda','Vardhami','2014-01-05 12:31:09','2014-01-05 12:31:09'),(7,'Vasiliki','Galani','2014-01-05 12:31:09','2014-01-05 12:31:09'),(8,'Vasiliki','Tsika','2014-01-05 12:31:09','2014-01-05 12:31:09'),(9,'Rion','Paige','2014-01-05 12:31:09','2014-01-05 12:31:09'),(10,'Carly','Sonenclar','2014-01-05 12:31:09','2014-01-05 12:31:09');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-04 18:37:45
