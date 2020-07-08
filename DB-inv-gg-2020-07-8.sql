/*
SQLyog Ultimate v11.11 (64 bit)
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

insert  into `alat`(`id_alat`,`merk`,`type`,`id_jenis_alat`,`checklist_masuk`,`checklist_keluar`,`foto_alat`,`deskripsi`) values ('1/INV-ALT/OPA-GG/037','Black Diamond','ATC',1,0,0,NULL,NULL),('10/INV-ALT/OPA-GG/039','Petzl ','Autostop',10,NULL,NULL,'','bekas, ada lecet'),('11/INV-ALT/OPA-GG/037','Petzl ','Ascenssion',11,0,0,NULL,NULL),('11/INV-ALT/OPA-GG/040','Petzl ','Ascenssion',11,NULL,NULL,'','kiri hitam'),('12/INV-ALT/OPA-GG/038','Petzl ','Croll',12,7,0,NULL,NULL),('21/INV-ALT/OPA-GG/035','Black Diamond','Momentum',21,0,0,'bd_momentum.jpg',NULL),('21/INV-ALT/OPA-GG/036','Petzl ','Luna',21,0,0,'',NULL),('7/INV-ALT/OPA-GG/041','Petzl ','Wiliam',7,11,NULL,'0c2b71e6-3b6b-4337-bd0a-dcce62bc8197.jpg','masih baru');

/*Table structure for table `checklist_group` */

DROP TABLE IF EXISTS `checklist_group`;

CREATE TABLE `checklist_group` (
  `id_checklist_group` int(11) NOT NULL AUTO_INCREMENT,
  `koordinator` varchar(50) DEFAULT NULL,
  `tgl_checklist_group` date DEFAULT NULL,
  `status` varbinary(15) DEFAULT NULL,
  `resume` text DEFAULT NULL,
  `dokumentasi` varbinary(40) DEFAULT NULL,
  PRIMARY KEY (`id_checklist_group`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `checklist_group` */

insert  into `checklist_group`(`id_checklist_group`,`koordinator`,`tgl_checklist_group`,`status`,`resume`,`dokumentasi`) values (1,'910280519','2020-07-02','done','berjalan lancar','');

/*Table structure for table `checklist_group_item` */

DROP TABLE IF EXISTS `checklist_group_item`;

CREATE TABLE `checklist_group_item` (
  `id_checklist_group_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_checklist_group` int(11) DEFAULT NULL,
  `petugas_check` int(9) DEFAULT NULL,
  `id_alat` varchar(25) DEFAULT NULL,
  `id_check` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_checklist_group_item`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

/*Data for the table `checklist_group_item` */

insert  into `checklist_group_item`(`id_checklist_group_item`,`id_checklist_group`,`petugas_check`,`id_alat`,`id_check`) values (40,1,910280515,'21/INV-ALT/OPA-GG/035',19),(41,1,910290520,'7/INV-ALT/OPA-GG/041',18);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `checklist_record` */

insert  into `checklist_record`(`id_check`,`tgl_checklist`,`id_alat`,`kondisi`,`keterangan`,`petugas`,`status_peminjaman`,`id_peminjaman_masuk`,`id_checklist_group`,`foto_alat_check`) values (5,'2020-06-05','21/INV-ALT/OPA-GG/035','valid','baik seperti baru','910280519','diambil','PJ20200525810','',''),(6,'2020-06-11','21/INV-ALT/OPA-GG/035','valid','baik seperti pada saat pengambilan','910280519','dikembalikan','PJ20200525810','',''),(7,'2020-06-19','12/INV-ALT/OPA-GG/038','valid','Kondisi seperti baru','910280519','','','',''),(8,'2020-06-23','12/INV-ALT/OPA-GG/038','valid','ada lecet sedikit','910280519','','','',''),(10,'2020-06-30','7/INV-ALT/OPA-GG/041','valid','masih baru','910280519','','','',''),(11,'2020-06-30','7/INV-ALT/OPA-GG/041','valid','baik seperti baru','910280519','','','','0c2b71e6-3b6b-4337-bd0a-dcce62bc8197.jpg'),(13,'2020-07-03','12/INV-ALT/OPA-GG/038','valid','lecet-lecet','910280519','diambil','PJ20200604002','',''),(14,'2020-07-03','11/INV-ALT/OPA-GG/037','valid','baru','910280519','diambil','PJ20200604002','',''),(15,'2020-07-03','21/INV-ALT/OPA-GG/036','valid','baru','910280519','diambil','PJ20200604002','',''),(18,'2020-07-03','7/INV-ALT/OPA-GG/041','valid','baik','910290520','','','1',''),(19,'2020-07-03','21/INV-ALT/OPA-GG/035','valid','baik','910280515','','','1','');

/*Table structure for table `detail_peminjaman_diterima` */

DROP TABLE IF EXISTS `detail_peminjaman_diterima`;

CREATE TABLE `detail_peminjaman_diterima` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_masuk` int(11) DEFAULT NULL,
  `id_alat` varchar(25) DEFAULT NULL,
  `id_check_keluar` int(11) DEFAULT NULL,
  `id_check_masuk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `detail_peminjaman_diterima` */

insert  into `detail_peminjaman_diterima`(`id_detail`,`id_detail_masuk`,`id_alat`,`id_check_keluar`,`id_check_masuk`) values (4,30,'21/INV-ALT/OPA-GG/035',5,6),(6,46,'12/INV-ALT/OPA-GG/038',13,NULL),(7,33,'11/INV-ALT/OPA-GG/037',14,NULL),(8,32,'21/INV-ALT/OPA-GG/036',15,NULL);

/*Table structure for table `detail_peminjaman_masuk` */

DROP TABLE IF EXISTS `detail_peminjaman_masuk`;

CREATE TABLE `detail_peminjaman_masuk` (
  `id_detail_masuk` int(11) NOT NULL AUTO_INCREMENT,
  `id_peminjaman_masuk` varchar(25) DEFAULT NULL,
  `id_jenis_alat` int(11) DEFAULT NULL,
  `jumlah` int(5) DEFAULT NULL,
  `jumlah_dikeluarkan` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_detail_masuk`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

/*Data for the table `detail_peminjaman_masuk` */

insert  into `detail_peminjaman_masuk`(`id_detail_masuk`,`id_peminjaman_masuk`,`id_jenis_alat`,`jumlah`,`jumlah_dikeluarkan`) values (30,'PJ20200525001',21,2,1),(32,'PJ20200604002',21,2,1),(33,'PJ20200604002',11,1,1),(34,'PJ20200615003',11,1,1),(35,'PJ20200615003',21,2,2),(36,'PJ20200615003',12,1,1),(37,'PJ20200619004',21,1,NULL),(38,'PJ20200627005',11,1,NULL),(39,'PJ20200627006',21,2,1),(40,'PJ20200629007',21,2,2),(41,'PJ20200630008',7,1,NULL),(44,'PJ20200701009',21,2,1),(45,'PJ20200701009',11,1,1),(46,'PJ20200604002',12,1,1);

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

insert  into `jenis_alat`(`id_jenis_alat`,`nama_jenis_alat`,`foto_jenis_alat`,`id_kat`) values (4,'Carrabiner Screw Delta',NULL,1),(5,'Carrabiner Snap Delta',NULL,1),(6,'Carrabiner Screw Oval',NULL,1),(7,'Carrabiner Screw A',NULL,1),(8,'Carrabiner TriadLock delta',NULL,1),(9,'Figure of eight (descender)',NULL,1),(10,'AutoStop (descender)','autostop.jpg',1),(11,'Hand Ascender','handascender.jpg',1),(12,'Chest Ascender','chestascender.jpg',1),(13,'Mellion Rapid Delta',NULL,1),(14,'Mellion Rapid Oval','',1),(15,'Piton',NULL,1),(16,'Chock Stopper',NULL,1),(17,'Choker',NULL,1),(18,'Hammer',NULL,1),(19,'Pully Mono',NULL,1),(20,'Sit Harness gym climbing',NULL,1),(21,'Sit Harness wall climbing','climbingHarness.jpg',1);

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id_kat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kat` varchar(25) DEFAULT NULL,
  `foto_kat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kat`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `kategori` */

insert  into `kategori`(`id_kat`,`nama_kat`,`foto_kat`) values (1,'Caving dan Climbing',''),(4,'Pendakian dan Berkemah','');

/*Table structure for table `peminjam` */

DROP TABLE IF EXISTS `peminjam`;

CREATE TABLE `peminjam` (
  `nik` varchar(25) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `no_telepon` varchar(14) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `instansi` varbinary(50) DEFAULT NULL,
  PRIMARY KEY (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `peminjam` */

insert  into `peminjam`(`nik`,`nama`,`no_telepon`,`email`,`instansi`) values ('1234567890','Renfro Faraby','081212351239','rafizmujahid86@gmail.com','Harpa');

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
  `foto_alat_pengambilan` varchar(50) DEFAULT NULL,
  `foto_alat_pengembalian` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_peminjaman_masuk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `peminjaman_masuk` */

insert  into `peminjaman_masuk`(`id_peminjaman_masuk`,`nik`,`nama_kegiatan`,`tgl_ambil`,`tgl_kembali`,`status`,`foto_jaminan`,`petugas_menyetujui`,`petugas_pengambilan`,`petugas_pengembalian`,`lampiran_surat`,`foto_alat_pengambilan`,`foto_alat_pengembalian`) values ('PJ20200525001','1234567890','dikjut RC','2020-05-28','2020-05-30','dikembalikan','logo_GGWCC_2020.png',910280519,910280519,910280519,NULL,NULL,NULL),('PJ20200604002','1234567890','dikjut RC','2020-06-13','2020-06-16','diambil','4660f4d0-73e8-4873-a060-ec5f06c76542.jpg',910280519,910280519,0,'','',''),('PJ20200615003','1234567890','pendakian','2020-06-25','2020-06-26','disetujui',NULL,910280519,NULL,NULL,NULL,NULL,NULL),('PJ20200616004','1234567890','latgab','2020-06-27','2020-08-29','baru',NULL,NULL,NULL,NULL,NULL,NULL,NULL),('PJ20200619005','1234567890','fun rafting','2020-06-22','2020-06-23','baru',NULL,NULL,NULL,NULL,NULL,NULL,NULL),('PJ20200627006','1234567890','latgab','2020-06-30','2020-07-01','disetujui',NULL,910280519,NULL,NULL,'',NULL,NULL),('PJ20200629007','1234567890','dikjut RC','2020-07-03','2020-07-04','disetujui',NULL,910280519,NULL,NULL,'pengumuman ujian TA045.pdf',NULL,NULL),('PJ20200630008','910280519','Latihan Panjat di LK','2020-07-01','2020-07-01','baru',NULL,NULL,NULL,NULL,'',NULL,NULL),('PJ20200701009','910290520','Latihan Panjat','2020-07-02','2020-07-02','baru',NULL,910280519,NULL,NULL,'',NULL,NULL);

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

insert  into `user`(`nia`,`nama_user`,`username`,`password`,`posisi`,`login_status`,`status_anggota`,`no_telp`,`email`,`foto_anggota`) values (910280509,'Fricelia Andrianing Putri','sniper','sniper','anggota','logout','Anggota Biasa','081938734916','friceliaandrian@gmail.com',''),(910280513,'M.Yusril Iqbal','palapa','palapa','anggota','logout','Departemen Rumah Tangga','','myusriliqbal@hmail.com','GOPR3570.jpg'),(910280515,'Aldy Zazmi Yuliansyah','aldyzazmi','aldyzazmi','admin','logout','Ketua Umum','081203469015','aldyzazmi@gmail.com',''),(910280519,'Rafi Hanif Rahmadhani','kagura','kagura','admin','login','Wakil Ketua 1','085896404314','rafizmujahid86@gmail.com','DSC_1239-min.jpg'),(910290520,'Arikh Thuqo','nagoya','nagoya','anggota','login','Anggota Biasa','085608583337','arikhthuqo@gmail.com','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
