/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 5.1.37 : Database - simppuh
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`simppuh` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;

USE `simppuh`;

/*Table structure for table `m_daftunit` */

DROP TABLE IF EXISTS `m_daftunit`;

CREATE TABLE `m_daftunit` (
  `unitkey` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `kode_unit` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nama_unit` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `create_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `update_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`unitkey`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='daftar Dinas';

/*Data for the table `m_daftunit` */

insert  into `m_daftunit`(`unitkey`,`kode_unit`,`nama_unit`,`create_user`,`create_date`,`update_user`,`update_date`) values 
('14_','1.02.01','Dinas Pendidikan','','0000-00-00 00:00:00','32','2018-10-06 23:37:33'),
('2_','1.01.01','Dinas Kesehatan','','0000-00-00 00:00:00','32','2018-10-06 23:43:13');

/*Table structure for table `m_group_menu` */

DROP TABLE IF EXISTS `m_group_menu`;

CREATE TABLE `m_group_menu` (
  `group_menu_id` char(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nama_group_menu` varchar(225) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `urut` int(11) DEFAULT NULL,
  `create_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `update_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`group_menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_group_menu` */

insert  into `m_group_menu`(`group_menu_id`,`nama_group_menu`,`urut`,`create_user`,`create_date`,`update_user`,`update_date`) values 
('admin','admin',0,'32','0000-00-00 00:00:00','32','2018-10-06 22:49:14'),
('kabag','kabag',2,'32','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('kasubag','kasubag',3,'32','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('pelaksana','Pelaksana',4,'32','2018-10-06 16:53:56','','0000-00-00 00:00:00'),
('skpd','SKPD',1,'32','0000-00-00 00:00:00','','0000-00-00 00:00:00');

/*Table structure for table `m_menu` */

DROP TABLE IF EXISTS `m_menu`;

CREATE TABLE `m_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_parent_id` int(11) NOT NULL DEFAULT '0',
  `nama_menu` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `url_path` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `is_context_menu` enum('0','1') CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '0',
  `aktif` enum('0','1') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `create_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `update_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=latin1;

/*Data for the table `m_menu` */

insert  into `m_menu`(`menu_id`,`menu_parent_id`,`nama_menu`,`icon`,`url_path`,`is_context_menu`,`aktif`,`create_user`,`create_date`,`update_user`,`update_date`) values 
(1,0,'Master',NULL,'','0','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2,1,'Menu',NULL,'pemda/menu','1','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(3,1,'Group Menu',NULL,'pemda/group_menu','1','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(4,1,'User',NULL,'pemda/user','1','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(166,0,'Transaksi SKPD',NULL,'','0','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(167,166,'Dashboard','zmdi zmdi-view-dashboard','pemda/dasboard','1','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(168,166,'Create Nota Dinas','zmdi zmdi-border-color','pemda/nota_dinas','1','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(169,166,'My Profile','zmdi zmdi-account','pemda/profile','1','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(170,1,'Setting Nama File Upload',NULL,'','1','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(171,1,'Daftar Dinas',NULL,'pemda/daftar_dinas','1','1','','0000-00-00 00:00:00','','0000-00-00 00:00:00');

/*Table structure for table `m_setting` */

DROP TABLE IF EXISTS `m_setting`;

CREATE TABLE `m_setting` (
  `col_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `col_value` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`col_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `m_setting` */

insert  into `m_setting`(`col_name`,`col_value`) values 
('logo','LOGO_KABUPATEN_GARUT.png'),
('nama_aplikasi','Sistem Informasi Manajemen Pembentukan Produk Hukum');

/*Table structure for table `m_status_dokumen` */

DROP TABLE IF EXISTS `m_status_dokumen`;

CREATE TABLE `m_status_dokumen` (
  `status_dokumen_id` int(11) NOT NULL,
  `status_dokumen` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `create_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`status_dokumen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='untuk cek status dokumen tersebut sudah dimana';

/*Data for the table `m_status_dokumen` */

insert  into `m_status_dokumen`(`status_dokumen_id`,`status_dokumen`,`create_user`,`create_date`,`update_user`,`update_date`) values 
(1,'New',NULL,NULL,NULL,NULL),
(2,'waiting approval kabag hukum',NULL,NULL,NULL,NULL),
(3,'waiting approval kasubag',NULL,NULL,NULL,NULL),
(4,'returned kasubag - Lengkapi Dokumen',NULL,NULL,NULL,NULL),
(5,'rejected kasubag',NULL,NULL,NULL,NULL),
(6,'waiting approval pelaksana',NULL,NULL,NULL,NULL),
(7,'waiting skpd to complete document',NULL,NULL,NULL,NULL),
(8,'waiting re-approval kasubag',NULL,NULL,NULL,NULL),
(9,'Done',NULL,NULL,NULL,NULL);

/*Table structure for table `m_upload_file` */

DROP TABLE IF EXISTS `m_upload_file`;

CREATE TABLE `m_upload_file` (
  `upload_file_code` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `upload_file_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `no_urut` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 = utama, 1 = pendukung',
  `create_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `update_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`upload_file_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_upload_file` */

insert  into `m_upload_file`(`upload_file_code`,`upload_file_name`,`no_urut`,`status`,`create_user`,`create_date`,`update_user`,`update_date`) values 
('BA','Berita Acara',8,1,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('KEPBUP','keputusan bupati',1,0,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('LAMP1','Lampiran 1',2,0,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('LAMP2','Lampiran 2',3,0,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('LAMP3','Lampiran 3',4,0,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('LAMP4','Lampiran 4',5,0,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('LAMP5','Lampiran 5',6,0,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('OTHERS','Kelengkapan',5,1,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('PERBUP','peraturan bupati',0,0,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('PERDAKAB','Peraturan Daerah Kabupaten Garut',7,1,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('PERDAPROV','Perda Provinsi Jawa Barat',4,1,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('PERGUB','Peraturan Gubernur Jawa Barat',6,1,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('PERMEN','Peraturan Menteri',3,1,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('PP','Peraturan Pemerintah',2,1,'','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
('UU','Undang - Undang',1,1,'','0000-00-00 00:00:00','','0000-00-00 00:00:00');

/*Table structure for table `m_user` */

DROP TABLE IF EXISTS `m_user`;

CREATE TABLE `m_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `unitkey` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `foto` blob NOT NULL,
  `group_menu_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_expired` date DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `create_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`username`),
  UNIQUE KEY `username` (`username`),
  KEY `group_menu` (`group_menu_id`(1))
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COMMENT='master user dan password untuk mengakses program';

/*Data for the table `m_user` */

insert  into `m_user`(`user_id`,`username`,`nama`,`password`,`unitkey`,`email`,`foto`,`group_menu_id`,`tgl_expired`,`last_login`,`create_user`,`create_date`,`update_user`,`update_date`) values 
(27,'dinkes','dinas kesehatan','25d55ad283aa400af464c76d713c07ad','2_','dinkes@mail.id','doraemon.jpg','skpd','2019-01-11','2021-07-16 11:08:22','admin','2018-08-25 00:00:00','27','2021-07-16 10:37:20'),
(28,'disdik','dinas pendidikan','25d55ad283aa400af464c76d713c07ad','14_','disdik@mail.id','dinas-kesehatan.jpg','skpd','2019-01-11','2018-10-10 22:21:16','admin','2018-09-01 13:59:03','28','2018-10-05 22:04:24'),
(29,'kasubag','kepala sub bagian','25d55ad283aa400af464c76d713c07ad',NULL,'kasubag@mail.id','','kasubag','2019-01-11','2021-07-16 11:08:44','admin','2018-09-15 15:24:41','','0000-00-00 00:00:00'),
(30,'kabag','kabag hukum','25d55ad283aa400af464c76d713c07ad',NULL,'kabag@mail.id','einstein.png','kabag','2019-01-11','2021-07-16 11:07:06','admin','2018-09-18 21:45:28','30','2021-07-16 10:47:08'),
(31,'pelaksana','pelaksana','25d55ad283aa400af464c76d713c07ad',NULL,'pelaksana@mail.id','dinas-kesehatan.jpg','pelaksana','2019-01-11','2021-07-16 10:57:34','827ccb0eea8a706c4c34a16891f84e','2018-10-06 11:47:04','31','2018-10-06 12:31:24'),
(32,'admin','admin','25d55ad283aa400af464c76d713c07ad',NULL,'admin@mail.id','','admin','2019-01-11','2018-10-09 21:49:50',NULL,'2018-10-06 12:15:56','','0000-00-00 00:00:00');

/*Table structure for table `m_user_group_menu` */

DROP TABLE IF EXISTS `m_user_group_menu`;

CREATE TABLE `m_user_group_menu` (
  `uniq_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_menu_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `menu_id` int(11) NOT NULL DEFAULT '0',
  `tambah` enum('1','0') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `edit` enum('1','0') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `view` enum('1','0') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `hapus` enum('1','0') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `refresh` enum('1','0') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `cari` enum('0','1') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `print_pdf` enum('1','0') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `print_excel` enum('0','1') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `other_button` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `combobox` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `other` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `create_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `create_date` datetime NOT NULL,
  `update_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`uniq_id`,`group_menu_id`,`menu_id`),
  UNIQUE KEY `group_menu_user` (`group_menu_id`,`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2083 DEFAULT CHARSET=latin1 COMMENT='master group menu untuk mengakses program';

/*Data for the table `m_user_group_menu` */

insert  into `m_user_group_menu`(`uniq_id`,`group_menu_id`,`menu_id`,`tambah`,`edit`,`view`,`hapus`,`refresh`,`cari`,`print_pdf`,`print_excel`,`other_button`,`combobox`,`other`,`create_user`,`create_date`,`update_user`,`update_date`) values 
(2070,'skpd',167,'0','0','1','0','0','1','0','1','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2071,'skpd',168,'1','1','1','1','1','0','1','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2072,'skpd',169,'0','1','1','0','1','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2073,'kabag',167,'0','0','1','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2074,'kabag',169,'1','1','1','1','1','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2075,'kasubag',167,'0','0','1','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2076,'kasubag',169,'0','0','0','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2077,'pelaksana',167,'0','0','0','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2078,'pelaksana',169,'0','0','0','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2079,'admin',2,'0','0','0','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2080,'admin',3,'0','0','0','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2081,'admin',4,'0','0','0','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00'),
(2082,'admin',171,'0','0','0','0','0','1','0','0','0','0','0','','0000-00-00 00:00:00','','0000-00-00 00:00:00');

/*Table structure for table `t_ceklis_dokumen` */

DROP TABLE IF EXISTS `t_ceklis_dokumen`;

CREATE TABLE `t_ceklis_dokumen` (
  `no_nota_dinas` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `upload_file_code` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `upload_file_name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `is_ready` tinyint(1) DEFAULT NULL COMMENT 'dokumen pendukung 1 = ada 0=tidak ada',
  `keterangan` text COLLATE latin1_general_ci,
  `status` char(1) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'A=Approve;R=reject;T=Return',
  `app_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `app_date` datetime DEFAULT NULL,
  `create_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`no_nota_dinas`,`upload_file_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `t_ceklis_dokumen` */

/*Table structure for table `t_disposisi` */

DROP TABLE IF EXISTS `t_disposisi`;

CREATE TABLE `t_disposisi` (
  `no_surat_disposisi` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `no_nota_dinas` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `unitkey` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `nama_unit` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_surat` datetime DEFAULT NULL,
  `tgl_terima` datetime DEFAULT NULL,
  `no_agenda` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `sifat` tinyint(2) DEFAULT NULL COMMENT '1=sangat segera;2=Segera; 3 = Rahasia',
  `perihal` text COLLATE latin1_general_ci,
  `send_to` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `status_note` tinyint(2) DEFAULT NULL COMMENT '1 = tanggapan dan saran; 2= proses lebih lanjut; 3 = korrdinasi/kondismasikan',
  `catatan` text COLLATE latin1_general_ci,
  `kota_disposisi` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `tgl_ttd` date DEFAULT NULL,
  `submit_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `create_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`no_surat_disposisi`,`no_nota_dinas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `t_disposisi` */

/*Table structure for table `t_draft_perbup` */

DROP TABLE IF EXISTS `t_draft_perbup`;

CREATE TABLE `t_draft_perbup` (
  `no_nota_dinas` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `tgl_approve` datetime DEFAULT NULL,
  `draft_dokumen` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `keterangan` text COLLATE latin1_general_ci,
  `submit_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `create_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`no_nota_dinas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `t_draft_perbup` */

/*Table structure for table `t_history_return` */

DROP TABLE IF EXISTS `t_history_return`;

CREATE TABLE `t_history_return` (
  `no_nota_dinas` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `revisi` int(11) NOT NULL,
  `return_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `submit_skpd_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `submit_skpd_date` datetime DEFAULT NULL,
  `create_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`no_nota_dinas`,`revisi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `t_history_return` */

/*Table structure for table `t_nota_dinas` */

DROP TABLE IF EXISTS `t_nota_dinas`;

CREATE TABLE `t_nota_dinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota_dinas` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `unitkey` varchar(15) COLLATE latin1_general_ci NOT NULL COMMENT 'nama_dinas',
  `tgl_nota_dinas` datetime NOT NULL,
  `jns_nota_dinas` char(1) COLLATE latin1_general_ci NOT NULL COMMENT '0 = Perbup1 = Kepbup',
  `status` char(1) COLLATE latin1_general_ci NOT NULL COMMENT 'N=New;S=Submit;R=Reject;A=Approve;T = Return;',
  `perihal` text COLLATE latin1_general_ci,
  `status_dokumen_id` int(11) NOT NULL COMMENT 'menjelaskan posisi dokumen terakhir dimana',
  `status_dokumen` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `nota_dinas_doc` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `submit_user` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `submit_date` datetime NOT NULL,
  `create_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_user` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Semua Data Nota Dinas	';

/*Data for the table `t_nota_dinas` */

/*Table structure for table `t_upload_dokumen_utama` */

DROP TABLE IF EXISTS `t_upload_dokumen_utama`;

CREATE TABLE `t_upload_dokumen_utama` (
  `no_nota_dinas` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `upload_file_code` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `upload_file_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `revisi` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `create_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_user` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`no_nota_dinas`,`upload_file_code`,`revisi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `t_upload_dokumen_utama` */

/*Table structure for table `v_user_menu` */

DROP TABLE IF EXISTS `v_user_menu`;

/*!50001 DROP VIEW IF EXISTS `v_user_menu` */;
/*!50001 DROP TABLE IF EXISTS `v_user_menu` */;

/*!50001 CREATE TABLE  `v_user_menu`(
 `menu_parent_id` int(11) ,
 `user_id` int(11) ,
 `username` varchar(30) ,
 `nama` varchar(50) ,
 `password` varchar(100) ,
 `unitkey` varchar(15) ,
 `email` varchar(50) ,
 `group_menu_id` varchar(30) ,
 `menu_id` int(11) ,
 `nama_menu` varchar(50) ,
 `tambah` enum('1','0') ,
 `edit` enum('1','0') ,
 `view` enum('1','0') ,
 `hapus` enum('1','0') ,
 `refresh` enum('1','0') ,
 `cari` enum('0','1') ,
 `print_pdf` enum('1','0') ,
 `print_excel` enum('0','1') ,
 `other_button` varchar(100) ,
 `combobox` varchar(100) ,
 `other` varchar(100) ,
 `icon` varchar(100) ,
 `url_path` varchar(100) 
)*/;

/*View structure for view v_user_menu */

/*!50001 DROP TABLE IF EXISTS `v_user_menu` */;
/*!50001 DROP VIEW IF EXISTS `v_user_menu` */;

/*!50001 CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER VIEW `v_user_menu` AS (select `mm`.`menu_parent_id` AS `menu_parent_id`,`mu`.`user_id` AS `user_id`,`mu`.`username` AS `username`,`mu`.`nama` AS `nama`,`mu`.`password` AS `password`,`mu`.`unitkey` AS `unitkey`,`mu`.`email` AS `email`,`mu`.`group_menu_id` AS `group_menu_id`,`mgm`.`menu_id` AS `menu_id`,`mm`.`nama_menu` AS `nama_menu`,`mgm`.`tambah` AS `tambah`,`mgm`.`edit` AS `edit`,`mgm`.`view` AS `view`,`mgm`.`hapus` AS `hapus`,`mgm`.`refresh` AS `refresh`,`mgm`.`cari` AS `cari`,`mgm`.`print_pdf` AS `print_pdf`,`mgm`.`print_excel` AS `print_excel`,`mgm`.`other_button` AS `other_button`,`mgm`.`combobox` AS `combobox`,`mgm`.`other` AS `other`,`mm`.`icon` AS `icon`,`mm`.`url_path` AS `url_path` from ((`m_user` `mu` join `m_user_group_menu` `mgm`) join `m_menu` `mm`) where ((`mu`.`group_menu_id` = `mgm`.`group_menu_id`) and (`mgm`.`menu_id` = `mm`.`menu_id`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
