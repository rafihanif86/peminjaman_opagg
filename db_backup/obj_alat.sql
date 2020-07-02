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

/*Table structure for table `alat` */

DROP TABLE IF EXISTS `alat`;

CREATE TABLE `alat` (
  `id_alat` varchar(25) NOT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `id_jenis_alat` int(11) DEFAULT NULL,
  `checklist_masuk` int(5) DEFAULT NULL,
  `checklist_keluar` int(5) DEFAULT NULL,
  `foto_alat` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id_alat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `alat` */

insert  into `alat` values ('1/INV-ALT/OPA-GG/037','Black Diamond','ATC',1,0,0,NULL,NULL),('10/INV-ALT/OPA-GG/039','Petzl ','Autostop',10,NULL,NULL,'','bekas, ada lecet'),('11/INV-ALT/OPA-GG/037','Petzl ','Ascenssion',11,0,0,NULL,NULL),('11/INV-ALT/OPA-GG/040','Petzl ','Ascenssion',11,NULL,NULL,'','kiri hitam'),('12/INV-ALT/OPA-GG/038','Petzl ','Croll',12,7,0,NULL,NULL),('21/INV-ALT/OPA-GG/035','Black Diamond','Momentum',21,0,0,'bd_momentum.jpg',NULL),('21/INV-ALT/OPA-GG/036','Petzl ','Luna',21,0,0,'',NULL),('7/INV-ALT/OPA-GG/041','Petzl ','Wiliam',7,11,NULL,'0c2b71e6-3b6b-4337-bd0a-dcce62bc8197.jpg','masih baru');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
