-- MySQL dump 10.13  Distrib 5.7.37, for Linux (x86_64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	5.7.37-0ubuntu0.18.04.1

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
-- Table structure for table `cards`
--


--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` VALUES (3,'New card','5tu5fre34',NULL,NULL,NULL,1,2,'2022-03-08 13:54:19','2022-03-08 14:58:09'),(4,'New card','p4r0b0s6n',NULL,NULL,NULL,1,2,'2022-03-08 13:55:16','2022-03-08 13:55:16'),(5,'New card','mlfqrg7ge',NULL,NULL,NULL,1,3,'2022-03-08 13:55:27','2022-03-08 13:55:27'),(6,'New card','2tdcr3rze',NULL,NULL,NULL,1,3,'2022-03-08 13:55:28','2022-03-08 13:55:28'),(7,'New card','4ci1q106j',NULL,NULL,NULL,1,1,'2022-03-08 14:56:05','2022-03-08 14:58:09'),(8,'New card','v3rozbp8p',NULL,NULL,NULL,1,1,'2022-03-08 15:04:48','2022-03-08 15:04:53'),(9,'New card','8h6p7vq3y',NULL,NULL,NULL,1,1,'2022-03-08 15:18:46','2022-03-08 15:18:48'),(10,'New card','ipmrvitho',NULL,NULL,NULL,1,3,'2022-03-08 15:19:45','2022-03-09 10:59:10'),(11,'New card','mk1yjo76a',NULL,NULL,NULL,1,2,'2022-03-08 15:21:33','2022-03-09 10:59:10'),(12,'New card','k7j14ejxi',NULL,NULL,NULL,1,3,'2022-03-08 15:22:23','2022-03-09 10:59:10'),(13,'New card','5ttihwu3i',NULL,NULL,NULL,1,3,'2022-03-08 15:22:26','2022-03-09 10:59:10'),(14,'New card','wj5hn26x1',NULL,NULL,NULL,1,2,'2022-03-08 15:27:03','2022-03-08 15:27:03'),(15,'New card','9x3xkarfi',NULL,NULL,NULL,1,2,'2022-03-08 15:27:03','2022-03-08 15:27:03'),(16,'New card','cd78jzplv',NULL,NULL,NULL,1,2,'2022-03-08 15:27:04','2022-03-08 15:27:04'),(17,'New card','v0euni2r7',NULL,NULL,NULL,1,2,'2022-03-08 15:27:04','2022-03-08 15:27:04'),(18,'New card','g1vv3t6r9',NULL,NULL,NULL,1,2,'2022-03-08 15:27:04','2022-03-08 15:27:04'),(19,'New card','t03mv8bcm',NULL,NULL,NULL,1,3,'2022-03-08 15:27:04','2022-03-09 10:59:10'),(20,'New card','ma2vg6wgz',NULL,NULL,NULL,1,3,'2022-03-08 15:27:15','2022-03-09 10:59:10'),(22,'New card','tsqtkphsl',NULL,NULL,NULL,1,7,'2022-03-09 10:04:12','2022-03-09 10:59:10'),(23,'New card','jx87f6ibg',NULL,NULL,NULL,1,1,'2022-03-09 10:12:19','2022-03-09 10:59:10'),(24,'New card','379da3e9j',NULL,NULL,NULL,1,2,'2022-03-09 10:42:20','2022-03-09 10:42:22'),(25,'New card','b2qyhs2mc',NULL,NULL,NULL,1,2,'2022-03-09 10:42:29','2022-03-09 10:59:10');
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--


-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kanbans`
--


-- Dumping data for table `kanbans`
--

LOCK TABLES `kanbans` WRITE;
/*!40000 ALTER TABLE `kanbans` DISABLE KEYS */;
INSERT INTO `kanbans` VALUES (1,'First kanban','[{\"id\":\"6\"},{\"id\":\"1\",\"items\":[\"jx87f6ibg\"]},{\"id\":\"3\",\"items\":[\"t03mv8bcm\",\"t03mv8bcm\",\"t03mv8bcm\",\"t03mv8bcm\",\"t03mv8bcm\",\"t03mv8bcm\",\"ipmrvitho\",\"k7j14ejxi\",\"5ttihwu3i\",\"ma2vg6wgz\"]},{\"id\":\"7\",\"items\":[\"tsqtkphsl\"]},{\"id\":\"2\",\"items\":[\"mk1yjo76a\"]}]',NULL,'2022-03-09 10:42:05');
/*!40000 ALTER TABLE `kanbans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--


LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2022_02_23_081612_create_cards_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--


--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--


--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` VALUES (1,'First table',1,NULL,NULL),(2,'Second table',1,NULL,NULL),(3,'Third table',1,NULL,NULL),(4,'Kanban Default',1,'2022-03-09 10:01:13','2022-03-09 10:01:13'),(5,'Kanban Default',1,'2022-03-09 10:02:06','2022-03-09 10:02:06'),(6,'Kanban Default',1,'2022-03-09 10:02:23','2022-03-09 10:02:23'),(7,'Kanban Default',1,'2022-03-09 10:04:01','2022-03-09 10:04:01');
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--


/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2022-03-09 12:08:48
