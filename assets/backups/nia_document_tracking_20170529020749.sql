-- MySQL dump 10.13  Distrib 5.7.14, for Win64 (x86_64)
--
-- Host: localhost    Database: nia_document_tracking
-- ------------------------------------------------------
-- Server version	5.7.14

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
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions`
--

LOCK TABLES `actions` WRITE;
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` VALUES (1,'Create Project'),(2,'Edit Project'),(3,'Delete Project'),(4,'Restore Project'),(5,'Upload Attachment'),(6,'Delete Attachment'),(7,'Create Employee'),(8,'Edit Employee'),(9,'Delete Employee'),(10,'Block Employee'),(11,'Upload Report'),(12,'Delete Report'),(13,'Start Project'),(14,'Extend Project'),(15,'Complete Project'),(16,'Generate Report'),(17,'Edit Project Progress');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sub_category` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
INSERT INTO `attachments` VALUES (12,'Project Procurement Management Plan',NULL,'Public Bidding',21),(15,'Notice To Proceed',NULL,'Public Bidding',24),(16,'Attachment A',NULL,'Program of Work',1),(17,'Attachment B',NULL,'Program of Work',2),(18,'Attachment C',NULL,'Program of Work',3),(19,'Attachment D',NULL,'Program of Work',4),(20,'Attachment E',NULL,'Program of Work',5),(21,'Attachment F',NULL,'Program of Work',6),(22,'Attachment G',NULL,'Program of Work',7),(23,'Attachment H',NULL,'Program of Work',8),(24,'Attachment I',NULL,'Program of Work',9);
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit`
--

DROP TABLE IF EXISTS `audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_recorded` datetime NOT NULL,
  `employee_id` int(11) unsigned NOT NULL,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `FK_audit_employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit`
--

LOCK TABLES `audit` WRITE;
/*!40000 ALTER TABLE `audit` DISABLE KEYS */;
INSERT INTO `audit` VALUES (1,'2017-05-27 23:11:13',8,'Logged in.'),(2,'2017-05-28 14:03:47',8,'Logged in.'),(3,'2017-05-29 01:48:38',8,'Added new project.'),(4,'2017-05-29 02:03:03',8,'Logged out.'),(5,'2017-05-29 02:03:06',1,'Logged in.'),(6,'2017-05-29 02:04:37',1,'Blocked an employee.'),(7,'2017-05-29 02:04:37',1,'Added new employee.'),(8,'2017-05-29 02:05:50',1,'Logged out.'),(9,'2017-05-29 02:05:55',8,'Logged in.'),(10,'2017-05-29 02:06:12',8,'Logged out.'),(11,'2017-05-29 02:06:14',1,'Logged in.'),(12,'2017-05-29 02:06:31',1,'Updated employee information.'),(13,'2017-05-29 02:07:24',1,'Updated employee information.');
/*!40000 ALTER TABLE `audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `given_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `name_suffix` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position_id` int(11) unsigned NOT NULL,
  `status` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`),
  KEY `last_modified_by` (`last_modified_by`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`last_modified_by`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'John','Smith','Doe',NULL,'admin','admin','admin@nia.com',7,'Active','2017-05-29 02:06:14','2017-05-29 02:05:50','2017-05-03 16:15:21',NULL,'2017-05-11 09:33:12',1),(5,'Regional','Manager','Beta',NULL,'manager2','manager2','manager@nia.com',3,'Blocked','2017-05-25 17:26:28','2017-05-25 17:26:38','2017-05-04 18:20:05',1,'2017-05-12 16:38:48',1),(6,'Regional','Manager','Celo',NULL,'manager3','manager3','manager3@nia.com',1,'Active','2017-05-25 17:26:44','2017-05-25 17:26:58','2017-05-04 18:24:01',1,'2017-05-12 15:47:16',1),(7,'Regional','Manager','Dingo',NULL,'manager4','manager4','manager4@nia.com',3,'Blocked','2017-05-12 11:05:25','2017-05-12 11:06:56','2017-05-04 18:25:49',1,'2017-05-12 16:34:54',1),(8,'Regional','Secretary','Alpha',NULL,'secretary','secretary','secretary@nia.com',2,'Active','2017-05-29 02:05:55','2017-05-29 02:06:12','2017-05-05 09:28:30',1,'2017-05-12 10:55:38',1),(11,'Juan','Manager','Masipag',NULL,'sample','sample','sample@nia.com',1,'Blocked','2017-05-12 11:06:59','2017-05-12 11:17:10','2017-05-12 10:35:21',1,'2017-05-12 15:47:14',1),(12,'Juan','Basta','Alpha',NULL,'sample2','sample2','sample2@nia.com',4,'Active','2017-05-25 17:26:15','2017-05-25 17:26:24','2017-05-12 10:39:40',1,'2017-05-12 15:46:51',1),(13,'Unit','Head','Alpha',NULL,'unit','unitunit','unit@nia.com',9,'Active',NULL,NULL,'2017-05-29 02:04:37',1,'2017-05-29 02:07:24',1);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `employees_after_insert` AFTER INSERT ON `employees` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), NEW.created_by, 'Added new employee.');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `employees_after_update` AFTER UPDATE ON `employees` FOR EACH ROW BEGIN
	CASE
		WHEN (OLD.last_login IS NULL && NEW.last_login IS NOT NULL) OR OLD.last_login != NEW.last_login
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.id, 'Logged in.');
		WHEN (OLD.last_logout IS NULL && NEW.last_logout IS NOT NULL) OR OLD .last_logout != NEW.last_logout
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.id, 'Logged out.');
		WHEN OLD.status = 'Active' && NEW.status = 'Blocked'
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.last_modified_by, 'Blocked an employee.');
		WHEN OLD.status = 'Blocked' && NEW.status = 'Active'
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.last_modified_by, 'Unblocked an employee.');
		ELSE INSERT INTO audit VALUES(NULL, NOW(), NEW.last_modified_by, 'Updated employee information.');
	END CASE;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `employees_before_delete` BEFORE DELETE ON `employees` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), OLD.created_by, 'Deleted an employee.');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `municipalities`
--

DROP TABLE IF EXISTS `municipalities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `municipalities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipalities`
--

LOCK TABLES `municipalities` WRITE;
/*!40000 ALTER TABLE `municipalities` DISABLE KEYS */;
INSERT INTO `municipalities` VALUES (1,'Aguinaldo, Ifugao'),(2,'Alfonso Lista, Ifugao'),(3,'Asipulo, Ifugao'),(4,'Atok, Benguet'),(5,'Baguio City, Benguet'),(6,'Bakun, Benguet'),(7,'Balbalan, Kalinga'),(8,'Banaue, Ifugao'),(9,'Bangued, Abra');
/*!40000 ALTER TABLE `municipalities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `positions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'Regional Irrigation Manager'),(2,'Regional Irrigation Manager\'s Secretary'),(3,'Division Manager'),(4,'Head of Planning & Design Section'),(5,'Head of Operation, Institutional & Equipment Section'),(6,'Head of Finance Section'),(7,'System Administrator'),(8,'Field Agent'),(9,'Head of Planning & Design Unit');
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privileges` (
  `position_id` int(11) unsigned NOT NULL,
  `action_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`position_id`,`action_id`),
  KEY `privileges_ibfk_2` (`action_id`),
  CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  CONSTRAINT `privileges_ibfk_2` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privileges`
--

LOCK TABLES `privileges` WRITE;
/*!40000 ALTER TABLE `privileges` DISABLE KEYS */;
INSERT INTO `privileges` VALUES (2,1),(2,2),(2,3),(7,4),(2,5),(2,6),(7,7),(7,8),(7,9),(7,10),(2,11),(2,12),(2,13),(2,14),(2,15),(2,16),(2,17);
/*!40000 ALTER TABLE `privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_attachment_revisions`
--

DROP TABLE IF EXISTS `project_attachment_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_attachment_revisions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `attachment_id` int(11) unsigned NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `uploaded_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `attachment_id` (`attachment_id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_attachment_revisions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_attachment_revisions_ibfk_2` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`),
  CONSTRAINT `project_attachment_revisions_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_attachment_revisions`
--

LOCK TABLES `project_attachment_revisions` WRITE;
/*!40000 ALTER TABLE `project_attachment_revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_attachment_revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_attachments`
--

DROP TABLE IF EXISTS `project_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_attachments` (
  `project_id` int(11) unsigned NOT NULL,
  `attachment_id` int(11) unsigned NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `uploaded_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`project_id`,`attachment_id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `attachment_id` (`attachment_id`),
  CONSTRAINT `project_attachments_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_attachments_ibfk_2` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`),
  CONSTRAINT `project_attachments_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_attachments`
--

LOCK TABLES `project_attachments` WRITE;
/*!40000 ALTER TABLE `project_attachments` DISABLE KEYS */;
INSERT INTO `project_attachments` VALUES (1,12,'assets/projects/1/Public_Bidding/','ProjectProcurementManagementPlan1495994453.pdf','2017-05-29 02:00:53',8),(1,15,'assets/projects/1/Public_Bidding/','NoticeToProceed1495994457.pdf','2017-05-29 02:00:57',8),(1,16,'assets/projects/1/Program_of_Work/','AttachmentA1495993964.pdf','2017-05-29 01:52:44',8),(1,17,'assets/projects/1/Program_of_Work/','AttachmentB1495993978.pdf','2017-05-29 01:52:58',8),(1,18,'assets/projects/1/Program_of_Work/','AttachmentC1495993983.pdf','2017-05-29 01:53:03',8),(1,19,'assets/projects/1/Program_of_Work/','AttachmentD1495994431.pdf','2017-05-29 02:00:31',8),(1,20,'assets/projects/1/Program_of_Work/','AttachmentE1495994434.pdf','2017-05-29 02:00:34',8),(1,21,'assets/projects/1/Program_of_Work/','AttachmentF1495994438.pdf','2017-05-29 02:00:38',8),(1,22,'assets/projects/1/Program_of_Work/','AttachmentG1495994442.pdf','2017-05-29 02:00:42',8),(1,23,'assets/projects/1/Program_of_Work/','AttachmentH1495994446.pdf','2017-05-29 02:00:46',8),(1,24,'assets/projects/1/Program_of_Work/','AttachmentI1495994450.pdf','2017-05-29 02:00:50',8);
/*!40000 ALTER TABLE `project_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_report_revisions`
--

DROP TABLE IF EXISTS `project_report_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_report_revisions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `report_id` int(11) unsigned NOT NULL DEFAULT '0',
  `project_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `uploaded_by` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `FK_project_reports_projects` (`project_id`),
  KEY `report_id` (`report_id`),
  CONSTRAINT `FK_project_report_revisions_project_reports` FOREIGN KEY (`report_id`) REFERENCES `project_reports` (`id`),
  CONSTRAINT `project_report_revisions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `project_report_revisions_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_report_revisions`
--

LOCK TABLES `project_report_revisions` WRITE;
/*!40000 ALTER TABLE `project_report_revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_report_revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_reports`
--

DROP TABLE IF EXISTS `project_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `uploaded_by` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `FK_project_reports_projects` (`project_id`),
  CONSTRAINT `FK_project_reports_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `project_reports_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_reports`
--

LOCK TABLES `project_reports` WRITE;
/*!40000 ALTER TABLE `project_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_reports` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `project_reports_after_insert` AFTER INSERT ON `project_reports` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), NEW.uploaded_by, 'Uploaded a report.');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `project_transition`
--

DROP TABLE IF EXISTS `project_transition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_transition` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `sender_id` int(11) unsigned NOT NULL,
  `recipient_id` int(11) unsigned NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `date_recorded` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_transition_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `project_transition_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `employees` (`id`),
  CONSTRAINT `project_transition_ibfk_3` FOREIGN KEY (`recipient_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_transition`
--

LOCK TABLES `project_transition` WRITE;
/*!40000 ALTER TABLE `project_transition` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_transition` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `project_transition_after_insert` AFTER INSERT ON `project_transition` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), NEW.sender_id, CONCAT('Sent project to ', (SELECT CONCAT_WS('', last_name, ', ', given_name, ' ', middle_name, ' ', name_suffix) FROM employees WHERE id = NEW.recipient_id)));
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `project_transition_after_update` AFTER UPDATE ON `project_transition` FOR EACH ROW BEGIN
	CASE 
		WHEN OLD.status = 'Sent' && NEW.status = 'Received'
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.recipient_id, 'Received project documents.');
		WHEN OLD.status = 'Received' && NEW.status = 'Approved'
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.recipient_id, CONCAT('Approved ', (SELECT name FROM projects WHERE id = NEW.project_id)));
		WHEN OLD.status = 'Received' && NEW.status = 'Declined'
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.recipient_id, CONCAT('Declined ', (SELECT name FROM projects WHERE id = NEW.project_id)));
	END CASE;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_proposed` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `municipality_id` int(11) unsigned NOT NULL,
  `cost` decimal(15,2) NOT NULL,
  `area` decimal(15,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `created_by` int(11) unsigned NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` int(11) unsigned DEFAULT NULL,
  `deleted` tinyint(11) unsigned NOT NULL DEFAULT '0',
  `pa_progress` int(11) unsigned DEFAULT '0',
  `fr_progress` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_modified_by` (`last_modified_by`),
  KEY `municipality_id` (`municipality_id`),
  CONSTRAINT `FK_projects_municipalities` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`id`),
  CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`),
  CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`last_modified_by`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'2017-05-01','RRREIS','Gaswiling CIS','Communal Irrigation System','Construction of Canalization and Canal Structure',1,1500000.00,500.00,NULL,NULL,'Pending Approval','2017-05-29 01:48:38',8,'2017-05-29 01:57:18',8,0,0,0);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `projects_after_insert` AFTER INSERT ON `projects` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), NEW.created_by, 'Added new project.');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `projects_after_delete` AFTER DELETE ON `projects` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), OLD.created_by, 'Deleted a project.');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-29  2:07:49
