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

/*Table structure for table `checklist_record` */

DROP TABLE IF EXISTS `checklist_record`;

CREATE TABLE `checklist_record` (
  `id_check` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_checklist` date DEFAULT NULL,
  `id_alat` varchar(25) DEFAULT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  `keterangan` tinytext DEFAULT NULL,
  `petugas` varchar(20) DEFAULT NULL,
  `status_peminjaman` varchar(15) DEFAULT NULL,
  `id_peminjaman_masuk` varchar(15) DEFAULT NULL,
  `id_checklist_group` varchar(11) DEFAULT NULL,
  `foto_alat_check` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_check`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `checklist_record` */

insert  into `checklist_record` values (5,'2020-06-05','21/INV-ALT/OPA-GG/035','valid','baik seperti baru','910280519','diambil','PJ20200525810','',''),(6,'2020-06-11','21/INV-ALT/OPA-GG/035','valid','baik seperti pada saat pengambilan','910280519','dikembalikan','PJ20200525810','',''),(7,'2020-06-19','12/INV-ALT/OPA-GG/038','valid','Kondisi seperti baru','910280519','','','',''),(8,'2020-06-23','12/INV-ALT/OPA-GG/038','valid','ada lecet sedikit','910280519','','','',''),(9,'2020-06-30','7/INV-ALT/OPA-GG/042','valid','masih baru','910280519','','','',''),(10,'2020-06-30','7/INV-ALT/OPA-GG/041','valid','masih baru','910280519','','','',''),(11,'2020-06-30','7/INV-ALT/OPA-GG/041','valid','baik seperti baru','910280519','','','','0c2b71e6-3b6b-4337-bd0a-dcce62bc8197.jpg');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
