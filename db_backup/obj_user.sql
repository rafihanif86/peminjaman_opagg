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

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `nia` int(9) NOT NULL,
  `nama_user` varchar(50) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `posisi` varchar(25) DEFAULT NULL,
  `login_status` varchar(10) DEFAULT NULL,
  `status_anggota` varchar(50) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `foto_anggota` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`nia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user` values (910280513,'M.Yusril Iqbal','palapa','palapa','admin','logout','Departemen Rumah Tangga',NULL,'myusriliqbal@hmail.com',NULL),(910280515,'Aldy Zazmi Yuliansyah','aldyzazmi','aldyzazmi','anggota','logout','Anggota Biasa','081203469015','aldyzazmi@gmail.com',''),(910280519,'Rafi Hanif Rahmadhani','kagura','kagura','admin','login','Wakil Ketua 1','085896404314','rafizmujahid86@gmail.com','DSC_1239-min.jpg'),(910290520,'Arikh Thuqo','nagoya','nagoya','anggota','login','Anggota Biasa','085608583337','arikhthuqo@gmail.com','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
