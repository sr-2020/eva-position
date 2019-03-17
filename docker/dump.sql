-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: lumen
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
-- Table structure for table `audios`
--

DROP TABLE IF EXISTS `audios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `frequency` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audios`
--

LOCK TABLES `audios` WRITE;
/*!40000 ALTER TABLE `audios` DISABLE KEYS */;
/*!40000 ALTER TABLE `audios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beacons`
--

DROP TABLE IF EXISTS `beacons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beacons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ssid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bssid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `beacons_bssid_unique` (`bssid`),
  KEY `beacons_location_id_index` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beacons`
--

LOCK TABLES `beacons` WRITE;
/*!40000 ALTER TABLE `beacons` DISABLE KEYS */;
INSERT INTO `beacons` VALUES (1,'E9:DC:0E:20:E3:DC','E9:DC:0E:20:E3:DC','2019-03-17 16:27:17','2019-03-17 16:27:17','Танц-фойе Рим, 2 этаж, #1',1),(2,'D2:7E:91:02:AB:64','D2:7E:91:02:AB:64','2019-03-17 16:27:17','2019-03-17 16:27:17','Танц-фойе Рим, 2 этаж, #2',1),(3,'F3:86:35:4C:6E:03','F3:86:35:4C:6E:03','2019-03-17 16:27:17','2019-03-17 16:27:17','Танц-фойе Рим, 2 этаж, #3',1),(4,'EA:93:BA:E7:99:82','EA:93:BA:E7:99:82','2019-03-17 16:27:17','2019-03-17 16:27:17','Танц-фойе Рим, 2 этаж, #4',1),(5,'C0:DA:B3:09:A9:FB','C0:DA:B3:09:A9:FB','2019-03-17 16:27:18','2019-03-17 16:27:18','Концертный зал Москва, #5',2),(6,'F6:A3:B4:E1:D1:15','F6:A3:B4:E1:D1:15','2019-03-17 16:27:18','2019-03-17 16:27:18','Концертный зал Москва, #6',2),(7,'CA:18:A2:88:34:DE','CA:18:A2:88:34:DE','2019-03-17 16:27:18','2019-03-17 16:27:18','Концертный зал Москва, #7',2),(8,'FA:86:25:BE:3C:21','FA:86:25:BE:3C:21','2019-03-17 16:27:18','2019-03-17 16:27:18','Концертный зал Москва, #8',2),(9,'F3:8F:DE:2F:66:C9','F3:8F:DE:2F:66:C9','2019-03-17 16:27:18','2019-03-17 16:27:18','Левый коридор, 2 этаж, #9',3),(10,'EE:D2:A8:E2:1C:62','EE:D2:A8:E2:1C:62','2019-03-17 16:27:19','2019-03-17 16:27:19','Левый коридор, 2 этаж, #10',3),(11,'FE:B1:7B:B6:2B:4A','FE:B1:7B:B6:2B:4A','2019-03-17 16:27:19','2019-03-17 16:27:19','Правый коридор, 2 этаж, #11',4),(12,'FE:7B:B7:53:58:CB','FE:7B:B7:53:58:CB','2019-03-17 16:27:19','2019-03-17 16:27:19','Правый коридор, 2 этаж, #12',4),(13,'CE:1B:0B:7F:5A:78','CE:1B:0B:7F:5A:78','2019-03-17 16:27:19','2019-03-17 16:27:19','Зал Рио, 2 этаж, #13',5),(14,'DD:C3:4A:60:04:B2','DD:C3:4A:60:04:B2','2019-03-17 16:27:19','2019-03-17 16:27:19','Зал Рио, 2 этаж, #14',5),(15,'D2:28:CC:D7:E7:25','D2:28:CC:D7:E7:25','2019-03-17 16:27:19','2019-03-17 16:27:19','Зал Рио, 2 этаж, #15',5),(16,'C1:22:25:79:BF:01','C1:22:25:79:BF:01','2019-03-17 16:27:19','2019-03-17 16:27:19','Оргкомитет, 2 этаж, #16',6),(17,'D8:BE:39:1F:C1:B9','D8:BE:39:1F:C1:B9','2019-03-17 16:27:20','2019-03-17 16:27:20','Холл правая сторона, 2 этаж, #17',7),(18,'FE:89:92:CF:68:DC','FE:89:92:CF:68:DC','2019-03-17 16:27:20','2019-03-17 16:27:20','Оргкомитет, 2 этаж, #18',6),(19,'C8:16:32:73:E6:12','C8:16:32:73:E6:12','2019-03-17 16:27:20','2019-03-17 16:27:20','Зал Атланта, 2 этаж, #19',8),(20,'D7:FC:39:B0:C3:3F','D7:FC:39:B0:C3:3F','2019-03-17 16:27:20','2019-03-17 16:27:20','Зал Атланта, 2 этаж, #20',8),(21,'F2:89:3D:99:E4:ED','F2:89:3D:99:E4:ED','2019-03-17 16:27:20','2019-03-17 16:27:20','Зал Атланта, 2 этаж, #21',8),(22,'EF:CF:7F:3D:AC:BE','EF:CF:7F:3D:AC:BE','2019-03-17 16:27:20','2019-03-17 16:27:20','Холл левая сторона, 2 этаж, #22',9),(23,'F5:3F:62:31:D5:77','F5:3F:62:31:D5:77','2019-03-17 16:27:20','2019-03-17 16:27:20','Холл левая сторона, 2 этаж, #23',9),(24,'EA:0A:9D:97:5C:0B','EA:0A:9D:97:5C:0B','2019-03-17 16:27:20','2019-03-17 16:27:20','Холл левая сторона, 2 этаж, #24',9),(25,'F2:D0:8F:FB:03:13','F2:D0:8F:FB:03:13','2019-03-17 16:27:20','2019-03-17 16:27:20','Корридор у прохода в к. 2, 2 этаж, #25',10),(26,'FC:07:F4:BD:CE:99','FC:07:F4:BD:CE:99','2019-03-17 16:27:20','2019-03-17 16:27:20','Корридор у прохода в к. 2, 2 этаж, #26',10),(27,'D4:D4:99:45:85:62','D4:D4:99:45:85:62','2019-03-17 16:27:21','2019-03-17 16:27:21','Холл у лифтов в к. 2, 2 этаж, #27',11),(28,'C7:50:4F:33:F8:A8','C7:50:4F:33:F8:A8','2019-03-17 16:27:21','2019-03-17 16:27:21','Холл правая сторона, 2 этаж, #28',7),(29,'D4:CA:FF:13:EC:66','D4:CA:FF:13:EC:66','2019-03-17 16:27:21','2019-03-17 16:27:21','Холл правая сторона, 2 этаж, #29',7),(30,'F9:D8:BB:48:39:85','F9:D8:BB:48:39:85','2019-03-17 16:27:21','2019-03-17 16:27:21','Холл у входа в к. 3, 2 этаж, #30',12),(31,'C5:B8:18:6D:92:6C','C5:B8:18:6D:92:6C','2019-03-17 16:27:21','2019-03-17 16:27:21','Холл у входа в к. 3, 2 этаж, #31',12),(32,'F1:20:B3:13:21:10','F1:20:B3:13:21:10','2019-03-17 16:27:21','2019-03-17 16:27:21','Коридор у Афин, 2 этаж, #32',13),(33,'E5:D4:15:A0:D7:53','E5:D4:15:A0:D7:53','2019-03-17 16:27:21','2019-03-17 16:27:21','Коридор у Афин, 2 этаж, #33',13),(34,'DF:8C:6D:50:E0:16','DF:8C:6D:50:E0:16','2019-03-17 16:27:21','2019-03-17 16:27:21','Зал Афины. Ауд. 301, 2 этаж, #34',14),(35,'EB:A9:56:03:77:B0','EB:A9:56:03:77:B0','2019-03-17 16:27:21','2019-03-17 16:27:21','Зал Афины. Ауд. 302, 2 этаж, #35',15),(36,'E9:FD:82:B3:F6:32','E9:FD:82:B3:F6:32','2019-03-17 16:27:22','2019-03-17 16:27:22','Зал Афины. Ауд. 304, 2 этаж, #36',16),(37,'E9:69:E1:63:07:52','E9:69:E1:63:07:52','2019-03-17 16:27:22','2019-03-17 16:27:22','Зал Афины. Ауд. 305, 2 этаж, #37',17),(38,'EA:13:F9:38:56:BA','EA:13:F9:38:56:BA','2019-03-17 16:27:22','2019-03-17 16:27:22','Зал Афины. Ауд. 308, 2 этаж, #38',18),(39,'C3:95:20:82:41:33','C3:95:20:82:41:33','2019-03-17 16:27:22','2019-03-17 16:27:22','Зал Афины. Ауд. 307, 2 этаж, #39',19),(40,'FE:7F:61:D0:1E:F1','FE:7F:61:D0:1E:F1','2019-03-17 16:27:22','2019-03-17 16:27:22','Бар, 2 этаж, #40',20),(41,'E4:BA:D7:C6:09:B6','E4:BA:D7:C6:09:B6','2019-03-17 16:27:22','2019-03-17 16:27:22','Зимний сад, 1 этаж, #41',21),(42,'F1:73:DA:77:7F:7A','F1:73:DA:77:7F:7A','2019-03-17 16:27:22','2019-03-17 16:27:22','Зимний сад, 1 этаж, #42',21),(43,'DE:4E:8A:C7:44:28','DE:4E:8A:C7:44:28','2019-03-17 16:27:22','2019-03-17 16:27:22','Зимний сад, 1 этаж, #43',21),(44,'DF:64:7F:DE:2C:D1','DF:64:7F:DE:2C:D1','2019-03-17 16:27:22','2019-03-17 16:27:22','Ресепшен, 1 этаж, #44',22),(45,'F4:4B:23:B8:93:33','F4:4B:23:B8:93:33','2019-03-17 16:27:23','2019-03-17 16:27:23','Ресепшен, 1 этаж, #45',22),(46,'F6:72:08:A0:ED:A8','F6:72:08:A0:ED:A8','2019-03-17 16:27:23','2019-03-17 16:27:23','Коридор, 1 этаж, #46',23),(47,'F5:63:B4:C6:E9:69','F5:63:B4:C6:E9:69','2019-03-17 16:27:23','2019-03-17 16:27:23','Зал Пекин, 1 этаж, #47',24),(48,'E6:62:DB:D9:79:D5','E6:62:DB:D9:79:D5','2019-03-17 16:27:23','2019-03-17 16:27:23','Зал Пекин, 1 этаж, #48',24),(49,'DF:AE:D8:DD:4E:F9','DF:AE:D8:DD:4E:F9','2019-03-17 16:27:23','2019-03-17 16:27:23','Зал Пекин, 1 этаж, #49',24),(50,'C1:FE:95:F1:D8:2D','C1:FE:95:F1:D8:2D','2019-03-17 16:27:23','2019-03-17 16:27:23','Зал Барселона, 1 этаж, #50',25),(51,'F0:CB:52:9D:E6:28','F0:CB:52:9D:E6:28','2019-03-17 16:27:23','2019-03-17 16:27:23','Зал Барселона, 1 этаж, #51',25),(52,'F5:FD:E6:A1:69:CB','F5:FD:E6:A1:69:CB','2019-03-17 16:27:23','2019-03-17 16:27:23','Зал Барселона, 1 этаж, #52',25),(53,'F0:FA:77:98:B0:AA','F0:FA:77:98:B0:AA','2019-03-17 16:27:23','2019-03-17 16:27:23','Зал Барселона, 1 этаж, #53',25),(54,'D8:28:B9:6B:CF:79','D8:28:B9:6B:CF:79','2019-03-17 16:27:24','2019-03-17 16:27:24','Столовая Лондон, 1 этаж, #54',26),(55,'D9:45:28:2C:C4:F9','D9:45:28:2C:C4:F9','2019-03-17 16:27:24','2019-03-17 16:27:24','Столовая Лондон, 1 этаж, #55',26),(56,'CC:B2:5C:1E:B2:7C','CC:B2:5C:1E:B2:7C','2019-03-17 16:27:24','2019-03-17 16:27:24','Столовая Берлин, 1 этаж, #56',27),(57,'D2:8B:6A:9C:30:AF','D2:8B:6A:9C:30:AF','2019-03-17 16:27:24','2019-03-17 16:27:24','Столовая Берлин, 1 этаж, #57',27),(58,'D3:1A:6C:B8:5F:CB','D3:1A:6C:B8:5F:CB','2019-03-17 16:27:24','2019-03-17 16:27:24','2 корпус, 5 этаж, #58',28);
/*!40000 ALTER TABLE `beacons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_shop`
--

DROP TABLE IF EXISTS `item_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_shop` (
  `shop_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_shop`
--

LOCK TABLES `item_shop` WRITE;
/*!40000 ALTER TABLE `item_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_user`
--

DROP TABLE IF EXISTS `item_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_user` (
  `item_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_user`
--

LOCK TABLES `item_user` WRITE;
/*!40000 ALTER TABLE `item_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Танц-фойе Рим, 2 этаж','2019-03-17 16:27:15','2019-03-17 16:27:15'),(2,'Концертный зал Москва','2019-03-17 16:27:15','2019-03-17 16:27:15'),(3,'Левый коридор, 2 этаж','2019-03-17 16:27:15','2019-03-17 16:27:15'),(4,'Правый коридор, 2 этаж','2019-03-17 16:27:15','2019-03-17 16:27:15'),(5,'Зал Рио, 2 этаж','2019-03-17 16:27:15','2019-03-17 16:27:15'),(6,'Оргкомитет, 2 этаж','2019-03-17 16:27:15','2019-03-17 16:27:15'),(7,'Холл правая сторона, 2 этаж','2019-03-17 16:27:15','2019-03-17 16:27:15'),(8,'Зал Атланта, 2 этаж','2019-03-17 16:27:15','2019-03-17 16:27:15'),(9,'Холл левая сторона, 2 этаж','2019-03-17 16:27:15','2019-03-17 16:27:15'),(10,'Корридор у прохода в к. 2, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(11,'Холл у лифтов в к. 2, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(12,'Холл у входа в к. 3, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(13,'Коридор у Афин, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(14,'Зал Афины. Ауд. 301, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(15,'Зал Афины. Ауд. 302, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(16,'Зал Афины. Ауд. 304, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(17,'Зал Афины. Ауд. 305, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(18,'Зал Афины. Ауд. 308, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(19,'Зал Афины. Ауд. 307, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(20,'Бар, 2 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(21,'Зимний сад, 1 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(22,'Ресепшен, 1 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(23,'Коридор, 1 этаж','2019-03-17 16:27:16','2019-03-17 16:27:16'),(24,'Зал Пекин, 1 этаж','2019-03-17 16:27:17','2019-03-17 16:27:17'),(25,'Зал Барселона, 1 этаж','2019-03-17 16:27:17','2019-03-17 16:27:17'),(26,'Столовая Лондон, 1 этаж','2019-03-17 16:27:17','2019-03-17 16:27:17'),(27,'Столовая Берлин, 1 этаж','2019-03-17 16:27:17','2019-03-17 16:27:17'),(28,'2 корпус, 5 этаж','2019-03-17 16:27:17','2019-03-17 16:27:17');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (43,'2018_10_14_000000_create_items_table',1),(44,'2018_10_14_000000_create_shops_table',1),(45,'2018_10_14_000000_create_users_table',1),(46,'2018_10_14_195110_create_item_user_table',1),(47,'2018_10_14_195112_create_item_shop_table',1),(48,'2018_10_14_195115_create_shop_user_table',1),(49,'2019_01_02_181032_create_routers_table',1),(50,'2019_01_03_053129_create_positions_table',1),(51,'2019_01_20_101812_create_audios_table',1),(52,'2019_01_26_092838_add_frequency_to_audios',1),(53,'2019_01_30_175738_create_beacons_table',1),(54,'2019_02_01_061731_add_beacon_id_to_users',1),(55,'2019_02_01_065517_add_beacons_id_to_positions',1),(56,'2019_02_06_054944_add_label_to_beacons',1),(57,'2019_02_10_110008_add_status_to_users',1),(58,'2019_02_10_132148_create_paths_table',1),(59,'2019_02_24_154706_add_email_uniq_to_users',1),(60,'2019_02_27_182843_add_bssid_uniq_to_beacons',1),(61,'2019_03_03_135919_create_locations_table',1),(62,'2019_03_03_140125_add_location_id_to_beacons',1),(63,'2019_03_03_165249_add_location_id_to_users',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paths`
--

DROP TABLE IF EXISTS `paths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paths` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `beacon_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paths`
--

LOCK TABLES `paths` WRITE;
/*!40000 ALTER TABLE `paths` DISABLE KEYS */;
/*!40000 ALTER TABLE `paths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `positions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `routers` json NOT NULL,
  `beacons` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routers`
--

DROP TABLE IF EXISTS `routers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `routers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ssid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bssid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routers`
--

LOCK TABLES `routers` WRITE;
/*!40000 ALTER TABLE `routers` DISABLE KEYS */;
/*!40000 ALTER TABLE `routers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_user`
--

DROP TABLE IF EXISTS `shop_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_user` (
  `shop_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_user`
--

LOCK TABLES `shop_user` WRITE;
/*!40000 ALTER TABLE `shop_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `router_id` int(11) DEFAULT NULL,
  `beacon_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'test',
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sex` enum('female','male','unknown') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unknown',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  KEY `users_location_id_index` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,NULL,'Мистер X','admin@evarun.ru','$2y$10$eDkcj1Fn.2nnEBg3/RQuUumb7Lq46OOGYGHBErz9zJGp48p8Drw4K','TkRVem4yTERSQTNQRHFxcmo4SUozNWZp',62,'navy','female','2019-03-17 16:27:24','2019-03-17 16:27:24',NULL);
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

-- Dump completed on 2019-03-17 19:28:59
