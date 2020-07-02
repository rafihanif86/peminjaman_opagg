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

/*Table structure for table `detail_peminjaman_masuk` */

DROP TABLE IF EXISTS `detail_peminjaman_masuk`;

CREATE TABLE `detail_peminjaman_masuk` (
  `id_detail_masuk` int(11) NOT NULL AUTO_INCREMENT,
  `id_peminjaman_masuk` varchar(25) DEFAULT NULL,
  `id_jenis_alat` int(11) DEFAULT NULL,
  `jumlah` int(5) DEFAULT NULL,
  `jumlah_dikeluarkan` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_detail_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

/*Data for the table `detail_peminjaman_masuk` */

insert  into `detail_peminjaman_masuk` values (30,'PJ20200525001',21,2,1),(32,'PJ20200604002',21,2,1),(33,'PJ20200604002',11,1,1),(34,'PJ20200615003',11,1,1),(35,'PJ20200615003',21,2,2),(36,'PJ20200615003',12,1,1),(37,'PJ20200619004',21,1,NULL),(38,'PJ20200627005',11,1,NULL),(39,'PJ20200627006',21,2,NULL),(40,'PJ20200629007',21,2,2),(41,'PJ20200630008',7,1,NULL),(44,'PJ20200701009',21,2,1),(45,'PJ20200701009',11,1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
