/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `kasir`;
USE `kasir`;

-- 1. Table: satuan (Master)
CREATE TABLE IF NOT EXISTS `satuan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `satuan` (`id`, `nama`) VALUES (1, 'pcs');

-- 2. Table: tipe (Master)
CREATE TABLE IF NOT EXISTS `tipe` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tipe` (`id`, `nama`) VALUES (2, 'Listrik');

-- 3. Table: customers (Master)
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(50) NOT NULL DEFAULT '0',
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT '0',
  `alamat` text NOT NULL,
  `no_telp` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `customers` (`id`, `customer_code`, `nama`, `email`, `alamat`, `no_telp`) VALUES
	(1, 'CODE001', 'PT. Coba', 'coba@gmail.com', 'karanganyar punkll\r\n', '013896253'),
	(3, 'CODE002', 'PT. Dani', 'dani@gmail.com', 'desa dani', '0918376');

-- 4. Table: users (Master)
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `username`, `password`) VALUES
	(1, 'root', '$2y$10$5SkUqLeq2mxm3THN28zzfuKPvjs8W6pTdauDpjEeJnP/l14Ch8qmq');

-- 5. Table: bahan (Master - Depends on satuan)
CREATE TABLE IF NOT EXISTS `bahan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_bahan` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `satuan_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `satuanToBahan` (`satuan_id`),
  CONSTRAINT `satuanToBahan` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `bahan` (`id`, `kode_bahan`, `nama`, `satuan_id`) VALUES
	(6, 'SKU-0001', 'sosis', 1),
	(7, 'SKU-0007', 'Madu', 1);

-- 6. Table: pengeluaran (Depends on tipe)
CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `keterangan` text NOT NULL,
  `jumlah` decimal(20,0) NOT NULL DEFAULT '0',
  `tipe_id` bigint NOT NULL DEFAULT '0',
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipeToPengeluaran` (`tipe_id`),
  CONSTRAINT `tipeToPengeluaran` FOREIGN KEY (`tipe_id`) REFERENCES `tipe` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pengeluaran` (`id`, `keterangan`, `jumlah`, `tipe_id`, `tanggal`) VALUES
	(3, 'coba', 100000, 2, '2026-01-07 00:00:00');

-- 7. Table: transaksi (Depends on users, customers)
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(50) NOT NULL DEFAULT '0',
  `tanggal` datetime NOT NULL,
  `total_belanja` decimal(20,0) DEFAULT NULL,
  `total_jual` decimal(20,0) NOT NULL DEFAULT '0',
  `catatan` text,
  `user_id` bigint NOT NULL DEFAULT '0',
  `customer_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userToTransaksi` (`user_id`),
  KEY `customerToTransaksi` (`customer_id`),
  CONSTRAINT `customerToTransaksi` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `userToTransaksi` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `transaksi` (`id`, `kode_transaksi`, `tanggal`, `total_belanja`, `total_jual`, `catatan`, `user_id`, `customer_id`) VALUES
	(19, 'CODE002-2026011209283395', '2026-01-01 15:35:25', 1000000, 10000000, 'pppp', 1, 3),
	(21, 'CODE001-2026011415575538', '2026-01-14 15:57:55', 1000000, 1200000, 'hallo', 1, 1);

-- 8. Table: detail_transaksi (Depends on transaksi, bahan)
CREATE TABLE IF NOT EXISTS `detail_transaksi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `transaksi_id` bigint NOT NULL DEFAULT '0',
  `bahan_id` bigint NOT NULL DEFAULT '0',
  `harga_jual` decimal(20,0) NOT NULL DEFAULT '0',
  `harga_beli` decimal(20,0) NOT NULL DEFAULT '0',
  `deskripsi` text,
  `jumlah` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `transaksiToDetailTransaksi` (`transaksi_id`),
  KEY `bahanToDetailTransaksi` (`bahan_id`),
  CONSTRAINT `bahanToDetailTransaksi` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksiToDetailTransaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `bahan_id`, `harga_jual`, `harga_beli`, `deskripsi`, `jumlah`) VALUES
	(29, 19, 7, 1000000, 100000, 'madu untuk batuk', 10),
	(31, 21, 7, 120000, 100000, 'coba', 10);

-- 9. Table: temp (Depends on users, bahan, customers)
CREATE TABLE IF NOT EXISTS `temp` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL DEFAULT '0',
  `bahan_id` bigint NOT NULL DEFAULT '0',
  `harga_beli` decimal(20,0) NOT NULL DEFAULT '0',
  `harga_jual` decimal(20,0) NOT NULL DEFAULT '0',
  `jumlah` int NOT NULL DEFAULT '0',
  `deskripsi` text,
  `customer_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userToTemp` (`user_id`),
  KEY `bahanToTemp` (`bahan_id`),
  KEY `customerToTemp` (`customer_id`),
  CONSTRAINT `bahanToTemp` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customerToTemp` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `userToTemp` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
