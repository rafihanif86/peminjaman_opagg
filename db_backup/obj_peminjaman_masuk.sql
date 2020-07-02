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

/*Table structure for table `peminjaman_masuk` */

DROP TABLE IF EXISTS `peminjaman_masuk`;

CREATE TABLE `peminjaman_masuk` (
  `id_peminjaman_masuk` varchar(25) NOT NULL,
  `nik` varchar(25) DEFAULT NULL,
  `nama_kegiatan` varchar(50) DEFAULT NULL,
  `tgl_ambil` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `foto_jaminan` varchar(100) DEFAULT NULL,
  `petugas_menyetujui` int(9) DEFAULT NULL,
  `petugas_pengambilan` int(9) DEFAULT NULL,
  `petugas_pengembalian` int(9) DEFAULT NULL,
  `lampiran_surat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_peminjaman_masuk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `peminjaman_masuk` */

insert  into `peminjaman_masuk` values ('PJ20200525001','1234567890','dikjut RC','2020-05-28','2020-05-30','dikembalikan','logo_GGWCC_2020.png',910280519,910280519,910280519,NULL),('PJ20200604002','1234567890','dikjut RC','2020-06-13','2020-06-16','disetujui',NULL,910280519,NULL,0,''),('PJ20200615003','1234567890','pendakian','2020-06-25','2020-06-26','disetujui',NULL,910280519,NULL,NULL,NULL),('PJ20200616004','1234567890','latgab','2020-06-27','2020-08-29','baru',NULL,NULL,NULL,NULL,NULL),('PJ20200619005','1234567890','fun rafting','2020-06-22','2020-06-23','baru',NULL,NULL,NULL,NULL,NULL),('PJ20200627006','1234567890','latgab','2020-06-30','2020-07-01','disetujui',NULL,910280519,NULL,NULL,''),('PJ20200629007','1234567890','dikjut RC','2020-07-03','2020-07-04','disetujui',NULL,910280519,NULL,NULL,'pengumuman ujian TA045.pdf'),('PJ20200630008','910280519','Latihan Panjat di LK','2020-07-01','2020-07-01','baru',NULL,NULL,NULL,NULL,''),('PJ20200701009','910290520','Latihan Panjat','2020-07-02','2020-07-02','baru',NULL,910280519,NULL,NULL,'');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
