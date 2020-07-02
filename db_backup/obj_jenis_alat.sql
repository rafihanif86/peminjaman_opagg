/*
SQLyog Job Agent v11.11 (64 bit) Copyright(c) Webyog Inc. All Rights Reserved.


MySQL - 5.5.5-10.4.6-MariaDB : Database - inventorygg
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`inventorygg` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `inventorygg`;

/*Table structure for table `jenis_alat` */

DROP TABLE IF EXISTS `jenis_alat`;

CREATE TABLE `jenis_alat` (
  `id_jenis_alat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_alat` varchar(50) DEFAULT NULL,
  `foto_jenis_alat` varchar(100) DEFAULT NULL,
  `id_kat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jenis_alat`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `jenis_alat` */

insert  into `jenis_alat` values (4,'Carrabiner Screw Delta',NULL,1),(5,'Carrabiner Snap Delta',NULL,1),(6,'Carrabiner Screw Oval',NULL,1),(7,'Carrabiner Screw A',NULL,1),(8,'Carrabiner TriadLock delta',NULL,1),(9,'Figure of eight (descender)',NULL,1),(10,'AutoStop (descender)','autostop.jpg',1),(11,'Hand Ascender','handascender.jpg',1),(12,'Chest Ascender','chestascender.jpg',1),(13,'Mellion Rapid Delta',NULL,1),(14,'Mellion Rapid Oval','',1),(15,'Piton',NULL,1),(16,'Chock Stopper',NULL,1),(17,'Choker',NULL,1),(18,'Hammer',NULL,1),(19,'Pully Mono',NULL,1),(20,'Sit Harness gym climbing',NULL,1),(21,'Sit Harness wall climbing','climbingHarness.jpg',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
