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

/*Table structure for table `detail_peminjaman_diterima` */

DROP TABLE IF EXISTS `detail_peminjaman_diterima`;

CREATE TABLE `detail_peminjaman_diterima` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_masuk` int(11) DEFAULT NULL,
  `id_alat` varchar(25) DEFAULT NULL,
  `id_check_keluar` int(11) DEFAULT NULL,
  `id_check_masuk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `detail_peminjaman_diterima` */

insert  into `detail_peminjaman_diterima` values (4,30,'21/INV-ALT/OPA-GG/035',5,6);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
