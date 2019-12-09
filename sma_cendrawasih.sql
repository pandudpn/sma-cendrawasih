# Host: localhost  (Version 5.5.5-10.1.37-MariaDB)
# Date: 2019-06-01 22:56:20
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "guru"
#

DROP TABLE IF EXISTS `guru`;
CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL AUTO_INCREMENT,
  `nama_guru` varchar(150) NOT NULL DEFAULT '',
  `tempat` varchar(100) NOT NULL DEFAULT '',
  `tgl_lahir` date NOT NULL DEFAULT '0000-00-00',
  `jabatan` varchar(100) NOT NULL DEFAULT '',
  `tmt` date NOT NULL DEFAULT '0000-00-00',
  `bidang_studi` varchar(100) NOT NULL DEFAULT '',
  `ts_guru` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_guru`)
) ENGINE=InnoDB AUTO_INCREMENT=1612019312 DEFAULT CHARSET=latin1;

#
# Data for table "guru"
#

INSERT INTO `guru` VALUES (1,'Ramanda Eka Putra Nugroho','Jakarta','1992-11-13','Wakil Kepala Sekolah','2020-12-12','Fisika','2019-04-30 23:59:44'),(2,'Djuanarita','Tangerang','1996-09-09','Guru','2019-12-12','Kimia','2019-05-01 00:00:18'),(3,'Pandu dwi Putra Nugroho','Jakarta','1996-12-09','Kepala Sekolah','2022-12-12','Matematika','2019-04-30 23:59:13'),(4,'Wiwi Nugroho','Jakarta','1966-09-21','Guru','2024-12-12','Penjaskes','2019-05-01 00:01:03');

#
# Structure for table "hasil"
#

DROP TABLE IF EXISTS `hasil`;
CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `id_guru` int(11) NOT NULL DEFAULT '0',
  `nilai_akhir` bigint(15) NOT NULL DEFAULT '0',
  `id_periode` int(11) NOT NULL DEFAULT '0',
  `status` enum('Tidak Terpilih','Terpilih') NOT NULL DEFAULT 'Tidak Terpilih',
  PRIMARY KEY (`id_hasil`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Data for table "hasil"
#

INSERT INTO `hasil` VALUES (1,1,1660,1,'Tidak Terpilih'),(2,2,286,1,'Terpilih'),(3,4,802,1,'Tidak Terpilih'),(4,3,258,6,'Terpilih');

#
# Structure for table "kriteria"
#

DROP TABLE IF EXISTS `kriteria`;
CREATE TABLE `kriteria` (
  `id_kriteria` int(5) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(100) NOT NULL DEFAULT '',
  `bobot` decimal(10,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Data for table "kriteria"
#

INSERT INTO `kriteria` VALUES (1,'Kerjasama',3.0000),(2,'Disiplin',4.0000),(3,'Absensi',1.0000),(4,'Masa Kerja',2.0000);

#
# Structure for table "nilai"
#

DROP TABLE IF EXISTS `nilai`;
CREATE TABLE `nilai` (
  `id_guru` int(11) NOT NULL DEFAULT '0',
  `id_subkriteria` int(5) NOT NULL DEFAULT '0',
  `nilai` int(10) NOT NULL DEFAULT '0',
  `id_periode` int(11) NOT NULL DEFAULT '0',
  KEY `FK_guru` (`id_guru`),
  KEY `FK_subkriteria` (`id_subkriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "nilai"
#

INSERT INTO `nilai` VALUES (3,1,27,6),(3,7,27,6),(3,8,27,6),(3,2,81,6),(3,5,81,6),(3,3,3,6),(3,6,3,6),(3,4,9,6);

#
# Structure for table "periode"
#

DROP TABLE IF EXISTS `periode`;
CREATE TABLE `periode` (
  `id_periode` int(11) NOT NULL AUTO_INCREMENT,
  `nama_periode` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_periode`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# Data for table "periode"
#

INSERT INTO `periode` VALUES (1,'2015-2016'),(2,'2016-2017'),(3,'2017-2018'),(4,'2018-2019'),(5,'2019-2020'),(6,'2020-2021'),(7,'2021-2022'),(8,'2022-2023');

#
# Structure for table "subkriteria"
#

DROP TABLE IF EXISTS `subkriteria`;
CREATE TABLE `subkriteria` (
  `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(5) NOT NULL DEFAULT '0',
  `nama_subkriteria` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_subkriteria`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

#
# Data for table "subkriteria"
#

INSERT INTO `subkriteria` VALUES (1,1,'Bergotong Royong dalam mengerjakan tugas'),(2,2,'Tidak pernah telat'),(3,3,'Tidak pernah tidak ada kabar'),(4,4,'Lebih dari 10 tahun'),(5,2,'Rapih'),(6,3,'Absen'),(7,1,'Bertanggung jawab'),(8,1,'Teamwork antar team');

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `hak_akses` tinyint(1) NOT NULL DEFAULT '0',
  `ts_user` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'Administrator','admin','7b2e9f54cdff413fcde01f330af6896c3cd7e6cd',1,'2019-03-16 12:13:16');
