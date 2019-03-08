-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 08, 2019 at 02:33 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nia`
--
CREATE DATABASE IF NOT EXISTS `nia` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nia`;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `name`) VALUES
(1, 'Create Project'),
(2, 'Edit Project'),
(3, 'Delete Project'),
(4, 'Restore Project'),
(5, 'Upload Attachment'),
(6, 'Delete Attachment'),
(7, 'Create Employee'),
(8, 'Edit Employee'),
(9, 'Delete Employee'),
(10, 'Block Employee'),
(11, 'Upload Report'),
(12, 'Delete Report'),
(13, 'Start Project'),
(14, 'Extend Project'),
(15, 'Complete Project'),
(16, 'Generate Report'),
(17, 'Edit Project Progress');

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sub_category` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `name`, `sub_category`, `category`, `sequence`) VALUES
(12, 'Project Procurement Management Plan', NULL, 'Public Bidding', 21),
(15, 'Notice To Proceed', NULL, 'Public Bidding', 24),
(16, 'Attachment A', NULL, 'Program of Work', 1),
(17, 'Attachment B', NULL, 'Program of Work', 2),
(18, 'Attachment C', NULL, 'Program of Work', 3),
(19, 'Attachment D', NULL, 'Program of Work', 4),
(20, 'Attachment E', NULL, 'Program of Work', 5),
(21, 'Attachment F', NULL, 'Program of Work', 6),
(22, 'Attachment G', NULL, 'Program of Work', 7),
(23, 'Attachment H', NULL, 'Program of Work', 8),
(24, 'Attachment I', NULL, 'Program of Work', 9);

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

DROP TABLE IF EXISTS `audit`;
CREATE TABLE IF NOT EXISTS `audit` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_recorded` datetime NOT NULL,
  `employee_id` int(11) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id`, `date_recorded`, `employee_id`, `action`) VALUES
(147, '2019-03-08 22:06:55', 1, 'Logged out.'),
(148, '2019-03-08 22:07:24', 8, 'Logged in.'),
(149, '2019-03-08 22:09:09', 8, 'Added new project.'),
(150, '2019-03-08 22:11:34', 8, 'Sent project to Alpha, Unit Head ');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `given_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `name_suffix` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position_id` int(11) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`),
  KEY `last_modified_by` (`last_modified_by`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `given_name`, `middle_name`, `last_name`, `name_suffix`, `username`, `password`, `email`, `position_id`, `status`, `last_login`, `last_logout`, `date_created`, `created_by`, `last_modified`, `last_modified_by`) VALUES
(1, 'John', 'Smith', 'Doe', NULL, 'admin', 'admin', 'admin@nia.com', 7, 'Active', '2017-06-17 16:35:49', '2019-03-08 22:06:55', '2017-05-03 16:15:21', NULL, '2017-05-11 09:33:12', 1),
(5, 'Regional', 'Manager', 'Beta', NULL, 'manager2', 'manager2', 'manager@nia.com', 3, 'Inactive', '2017-05-25 17:26:28', '2017-05-25 17:26:38', '2017-05-04 18:20:05', 1, '2017-06-17 16:18:44', 1),
(6, 'Regional', 'Manager', 'Celo', NULL, 'manager3', 'manager3', 'manager3@nia.com', 1, 'Active', '2017-06-13 14:55:24', '2017-06-13 14:55:37', '2017-05-04 18:24:01', 1, '2017-06-17 16:18:53', 1),
(7, 'Regional', 'Manager', 'Dingo', NULL, 'manager4', 'manager4', 'manager4@nia.com', 3, 'Active', '2017-06-13 14:54:46', '2017-06-13 14:55:03', '2017-05-04 18:25:49', 1, '2017-06-17 16:18:55', 1),
(8, 'Regional', 'Secretary', 'Alpha', NULL, 'secretary', 'secretary', 'secretary@nia.com', 2, 'Active', '2019-03-08 22:07:24', '2017-06-17 16:35:46', '2017-05-05 09:28:30', 1, '2017-05-12 10:55:38', 1),
(11, 'Juan', 'Manager', 'Masipag', NULL, 'sample', 'sample', 'sample@nia.com', 1, 'Inactive', '2017-05-12 11:06:59', '2017-05-12 11:17:10', '2017-05-12 10:35:21', 1, '2017-06-17 16:18:48', 1),
(12, 'Juan', 'Basta', 'Alpha', NULL, 'sample2', 'sample2', 'sample2@nia.com', 4, 'Active', '2017-06-13 14:54:28', '2017-06-13 14:54:32', '2017-05-12 10:39:40', 1, '2017-05-12 15:46:51', 1),
(13, 'Unit', 'Head', 'Alpha', NULL, 'unit', 'unitunit', 'unit@nia.com', 9, 'Active', '2017-06-13 14:53:49', '2017-06-13 14:54:01', '2017-05-29 02:04:37', 1, '2017-05-29 02:07:24', 1);

--
-- Triggers `employees`
--
DROP TRIGGER IF EXISTS `employees_after_insert`;
DELIMITER $$
CREATE TRIGGER `employees_after_insert` AFTER INSERT ON `employees` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), NEW.created_by, 'Added new employee.');
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `employees_after_update`;
DELIMITER $$
CREATE TRIGGER `employees_after_update` AFTER UPDATE ON `employees` FOR EACH ROW BEGIN
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
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `employees_before_delete`;
DELIMITER $$
CREATE TRIGGER `employees_before_delete` BEFORE DELETE ON `employees` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), OLD.created_by, 'Deleted an employee.');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `municipalities`
--

DROP TABLE IF EXISTS `municipalities`;
CREATE TABLE IF NOT EXISTS `municipalities` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `municipalities`
--

INSERT INTO `municipalities` (`id`, `name`) VALUES
(1, 'Aguinaldo, Ifugao'),
(2, 'Alfonso Lista, Ifugao'),
(3, 'Asipulo, Ifugao'),
(4, 'Atok, Benguet'),
(5, 'Baguio City, Benguet'),
(6, 'Bakun, Benguet'),
(7, 'Balbalan, Kalinga'),
(8, 'Banaue, Ifugao'),
(9, 'Bangued, Abra'),
(10, 'Barlig, Mountain Province'),
(11, 'Bauko, Mountain Province'),
(12, 'Besao, Mountain Province'),
(13, 'Bokod, Benguet'),
(14, 'Boliney, Abra'),
(15, 'Bontoc, Mountain Province'),
(16, 'Bucay, Abra'),
(17, 'Bucloc, Abra'),
(18, 'Buguias, Benguet'),
(19, 'Calanasan, Apayao'),
(20, 'Conner, Apayao'),
(21, 'Daguioman, Abra'),
(22, 'Danglas, Abra'),
(23, 'Dolores, Abra'),
(24, 'Flora, Apayao'),
(25, 'Hingyon, Ifugao'),
(26, 'Hungduan, Ifugao'),
(27, 'Itogon, Benguet'),
(28, 'Kabayan, Benguet'),
(29, 'Kabugao, Apayao'),
(30, 'Kapangan, Benguet'),
(31, 'Kiangan, Ifugao'),
(32, 'Kibungan, Benguet'),
(33, 'La Paz, Abra'),
(34, 'La Trinidad, Benguet'),
(35, 'Lacub, Abra'),
(36, 'Lagangilang, Abra'),
(37, 'Lagawe, Ifugao'),
(38, 'Lagayan, Abra'),
(39, 'Lamut, Ifugao'),
(40, 'Langiden, Abra'),
(41, 'Licuan-Baay, Abra'),
(42, 'Luba, Abra'),
(43, 'Lubuagan, Kalinga'),
(44, 'Luna, Apayao'),
(45, 'Malibcong, Abra'),
(46, 'Manabo, Abra'),
(47, 'Mankayan, Benguet'),
(48, 'Mayoyao, Ifugao'),
(49, 'Natonin, Mountain Province'),
(50, 'Paracelis, Mountain Province'),
(51, 'Pasil, Kalinga'),
(52, 'Peñarrubia, Abra'),
(53, 'Pidigan, Abra'),
(54, 'Pilar, Abra'),
(55, 'Pinukpuk, Kalinga'),
(56, 'Pudtol, Apayao'),
(57, 'Rizal, Kalinga'),
(58, 'Sabangan, Mountain Province'),
(59, 'Sablan, Benguet'),
(60, 'Sadanga, Mountain Province'),
(61, 'Sallapadan, Abra'),
(62, 'San Isidro, Abra'),
(63, 'San Juan, Abra'),
(64, 'San Quintin, Abra'),
(65, 'Santa Marcela, Apayao'),
(66, 'Tadian, Mountain Province'),
(67, 'Tanudan, Kalinga'),
(68, 'Tayum, Abra'),
(69, 'Tineg, Abra'),
(70, 'Tinglayan, Kalinga'),
(71, 'Tinoc, Ifugao'),
(72, 'Tuba, Benguet'),
(73, 'Tublay, Benguet'),
(74, 'Tubo, Abra'),
(75, 'Villaviciosa, Abra'),
(76, 'Tabuk City, Kalinga');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`) VALUES
(1, 'Regional Irrigation Manager'),
(2, 'Regional Irrigation Manager\'s Secretary'),
(3, 'Division Manager'),
(4, 'Head of Planning & Design Section'),
(5, 'Head of Operation, Institutional & Equipment Section'),
(6, 'Head of Finance Section'),
(7, 'System Administrator'),
(8, 'Field Agent'),
(9, 'Head of Planning & Design Unit');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

DROP TABLE IF EXISTS `privileges`;
CREATE TABLE IF NOT EXISTS `privileges` (
  `position_id` int(11) UNSIGNED NOT NULL,
  `action_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`position_id`,`action_id`),
  KEY `privileges_ibfk_2` (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`position_id`, `action_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(7, 4),
(2, 5),
(2, 6),
(7, 7),
(7, 8),
(7, 9),
(7, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_proposed` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `municipality_id` int(11) UNSIGNED NOT NULL,
  `cost` decimal(15,2) NOT NULL,
  `area` decimal(15,2) NOT NULL,
  `area_unit` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `last_modified_by` int(11) UNSIGNED DEFAULT NULL,
  `deleted` tinyint(11) UNSIGNED NOT NULL DEFAULT '0',
  `pa_progress` int(11) UNSIGNED DEFAULT '0',
  `fr_progress` int(11) UNSIGNED DEFAULT '0',
  `approvals` int(11) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_modified_by` (`last_modified_by`),
  KEY `municipality_id` (`municipality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `date_proposed`, `title`, `name`, `category`, `description`, `municipality_id`, `cost`, `area`, `area_unit`, `start_date`, `completion_date`, `status`, `date_created`, `created_by`, `last_modified`, `last_modified_by`, `deleted`, `pa_progress`, `fr_progress`, `approvals`) VALUES
(1, '2017-05-01', 'RRREIS', 'Gaswiling CIS', 'Communal Irrigation System', 'Construction of Canalization and Canal Structure', 1, '1500000.00', '500.00', 'ha', NULL, NULL, 'Pending Approval', '2017-05-29 01:48:38', 8, '2017-05-29 01:57:18', 8, 0, 0, 0, 0);

--
-- Triggers `projects`
--
DROP TRIGGER IF EXISTS `projects_after_delete`;
DELIMITER $$
CREATE TRIGGER `projects_after_delete` AFTER DELETE ON `projects` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), OLD.created_by, 'Deleted a project.');
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `projects_after_insert`;
DELIMITER $$
CREATE TRIGGER `projects_after_insert` AFTER INSERT ON `projects` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), NEW.created_by, 'Added new project.');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project_attachments`
--

DROP TABLE IF EXISTS `project_attachments`;
CREATE TABLE IF NOT EXISTS `project_attachments` (
  `project_id` int(11) UNSIGNED NOT NULL,
  `attachment_id` int(11) UNSIGNED NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `uploaded_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`project_id`,`attachment_id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `attachment_id` (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_attachments`
--

INSERT INTO `project_attachments` (`project_id`, `attachment_id`, `filepath`, `filename`, `date_uploaded`, `uploaded_by`) VALUES
(1, 12, 'assets/projects/1/Public_Bidding/', 'ProjectProcurementManagementPlan1495994453.pdf', '2017-05-29 02:00:53', 8),
(1, 15, 'assets/projects/1/Public_Bidding/', 'NoticeToProceed1495994457.pdf', '2017-05-29 02:00:57', 8),
(1, 16, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentA1495704240.pdf', '2017-05-29 01:52:44', 8),
(1, 17, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentB1495704245.pdf', '2017-05-29 01:52:58', 8),
(1, 18, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentC1495704250.pdf', '2017-05-29 01:53:03', 8),
(1, 19, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentD1495718021.pdf', '2017-05-29 02:00:31', 8),
(1, 20, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentE1495704261.pdf', '2017-05-29 02:00:34', 8),
(1, 21, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentF1495704267.pdf', '2017-05-29 02:00:38', 8),
(1, 22, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentG1495704271.pdf', '2017-05-29 02:00:42', 8),
(1, 23, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentH1495704276.pdf', '2017-05-29 02:00:46', 8),
(1, 24, 'assets/projects/1/Program_of_Work/Attachment_A_to_I/', 'AttachmentI1495704279.pdf', '2017-05-29 02:00:50', 8);

-- --------------------------------------------------------

--
-- Table structure for table `project_attachment_revisions`
--

DROP TABLE IF EXISTS `project_attachment_revisions`;
CREATE TABLE IF NOT EXISTS `project_attachment_revisions` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `attachment_id` int(11) UNSIGNED NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `uploaded_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `attachment_id` (`attachment_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `project_reports`
--

DROP TABLE IF EXISTS `project_reports`;
CREATE TABLE IF NOT EXISTS `project_reports` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `uploaded_by` int(11) UNSIGNED NOT NULL,
  `pa_progress` int(10) UNSIGNED NOT NULL,
  `fr_progress` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `FK_project_reports_projects` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Triggers `project_reports`
--
DROP TRIGGER IF EXISTS `project_reports_after_insert`;
DELIMITER $$
CREATE TRIGGER `project_reports_after_insert` AFTER INSERT ON `project_reports` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), NEW.uploaded_by, 'Uploaded a report.');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project_report_revisions`
--

DROP TABLE IF EXISTS `project_report_revisions`;
CREATE TABLE IF NOT EXISTS `project_report_revisions` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `report_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `project_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `uploaded_by` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  KEY `FK_project_reports_projects` (`project_id`),
  KEY `report_id` (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `project_transition`
--

DROP TABLE IF EXISTS `project_transition`;
CREATE TABLE IF NOT EXISTS `project_transition` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `sender_id` int(11) UNSIGNED NOT NULL,
  `recipient_id` int(11) UNSIGNED NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `date_recorded` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_transition`
--

INSERT INTO `project_transition` (`id`, `project_id`, `sender_id`, `recipient_id`, `remarks`, `status`, `date_recorded`) VALUES
(15, 1, 8, 13, '\n											For Checking.\n									 					dasdas				', 'Sent', '2019-03-08 22:11:34');

--
-- Triggers `project_transition`
--
DROP TRIGGER IF EXISTS `project_transition_after_insert`;
DELIMITER $$
CREATE TRIGGER `project_transition_after_insert` AFTER INSERT ON `project_transition` FOR EACH ROW BEGIN
	INSERT INTO audit VALUES(NULL, NOW(), NEW.sender_id, CONCAT('Sent project to ', (SELECT CONCAT_WS('', last_name, ', ', given_name, ' ', middle_name, ' ', name_suffix) FROM employees WHERE id = NEW.recipient_id)));
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `project_transition_after_update`;
DELIMITER $$
CREATE TRIGGER `project_transition_after_update` AFTER UPDATE ON `project_transition` FOR EACH ROW BEGIN
	CASE 
		WHEN OLD.status = 'Sent' && NEW.status = 'Received'
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.recipient_id, 'Received project documents.');
		WHEN OLD.status = 'Received' && NEW.status = 'Approved'
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.recipient_id, CONCAT('Approved ', (SELECT name FROM projects WHERE id = NEW.project_id)));
		WHEN OLD.status = 'Received' && NEW.status = 'Declined'
			THEN INSERT INTO audit VALUES(NULL, NOW(), NEW.recipient_id, CONCAT('Declined ', (SELECT name FROM projects WHERE id = NEW.project_id)));
	END CASE;
END
$$
DELIMITER ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit`
--
ALTER TABLE `audit`
  ADD CONSTRAINT `FK_audit_employees` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`last_modified_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `privileges`
--
ALTER TABLE `privileges`
  ADD CONSTRAINT `privileges_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `privileges_ibfk_2` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `FK_projects_municipalities` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`id`),
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`last_modified_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `project_attachments`
--
ALTER TABLE `project_attachments`
  ADD CONSTRAINT `project_attachments_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_attachments_ibfk_2` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`),
  ADD CONSTRAINT `project_attachments_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `project_attachment_revisions`
--
ALTER TABLE `project_attachment_revisions`
  ADD CONSTRAINT `project_attachment_revisions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_attachment_revisions_ibfk_2` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`),
  ADD CONSTRAINT `project_attachment_revisions_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `project_reports`
--
ALTER TABLE `project_reports`
  ADD CONSTRAINT `FK_project_reports_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `project_reports_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `project_report_revisions`
--
ALTER TABLE `project_report_revisions`
  ADD CONSTRAINT `FK_project_report_revisions_project_reports` FOREIGN KEY (`report_id`) REFERENCES `project_reports` (`id`),
  ADD CONSTRAINT `project_report_revisions_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `project_report_revisions_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `employees` (`id`);

--
-- Constraints for table `project_transition`
--
ALTER TABLE `project_transition`
  ADD CONSTRAINT `project_transition_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `project_transition_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `project_transition_ibfk_3` FOREIGN KEY (`recipient_id`) REFERENCES `employees` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
