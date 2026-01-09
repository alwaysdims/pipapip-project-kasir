-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.14.0.7165
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table pipapip-project.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`) VALUES
	(1, 'root', '$2y$10$5SkUqLeq2mxm3THN28zzfuKPvjs8W6pTdauDpjEeJnP/l14Ch8qmq');

-- Dumping structure for table pipapip-project.satuan
CREATE TABLE IF NOT EXISTS `satuan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.satuan: ~1 rows (approximately)
INSERT INTO `satuan` (`id`, `nama`) VALUES
	(1, 'pcs');

-- Dumping structure for table pipapip-project.bahan
CREATE TABLE IF NOT EXISTS `bahan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_bahan` varchar(50) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `satuan_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `satuanToBahan` (`satuan_id`),
  CONSTRAINT `satuanToBahan` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.bahan: ~4 rows (approximately)
INSERT INTO `bahan` (`id`, `kode_bahan`, `nama`, `deskripsi`, `satuan_id`) VALUES
	(2, 'CODE01', 'Tegar Goreng', 'isi 5\r\n', 1),
	(3, 'CODE02', 'Kecap', 'manis', 1),
	(4, 'CODE03', 'Kangkung', 'goreng', 1),
	(5, 'CODE04', 'Madu', 'manu tawon', 1);

-- Dumping structure for table pipapip-project.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(50) NOT NULL DEFAULT '0',
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT '0',
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `no_telp` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.customers: ~2 rows (approximately)
INSERT INTO `customers` (`id`, `customer_code`, `nama`, `email`, `alamat`, `no_telp`) VALUES
	(1, 'CODE001', 'PT. Coba', 'coba@gmail.com', 'karanganyar punkll\r\n', '013896253'),
	(3, 'CODE002', 'PT. Dani', 'dani@gmail.com', 'desa dani', '0918376');

-- Dumping structure for table pipapip-project.tipe
CREATE TABLE IF NOT EXISTS `tipe` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.tipe: ~1 rows (approximately)
INSERT INTO `tipe` (`id`, `nama`) VALUES
	(2, 'Listrik');

-- Dumping structure for table pipapip-project.pengeluaran
CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `keterangan` text NOT NULL,
  `jumlah` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `tipe_id` bigint NOT NULL DEFAULT '0',
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipeToPengeluaran` (`tipe_id`),
  CONSTRAINT `tipeToPengeluaran` FOREIGN KEY (`tipe_id`) REFERENCES `tipe` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.pengeluaran: ~1 rows (approximately)
INSERT INTO `pengeluaran` (`id`, `keterangan`, `jumlah`, `tipe_id`, `tanggal`) VALUES
	(3, 'coba', 100000.000000, 2, '2026-01-07 00:00:00');

-- Dumping structure for table pipapip-project.temp
CREATE TABLE IF NOT EXISTS `temp` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `bahan_id` bigint NOT NULL,
  `harga_beli` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `harga_jual` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `jumlah` int NOT NULL DEFAULT '0',
  `customer_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userToTemp` (`user_id`),
  KEY `bahanToTemp` (`bahan_id`),
  KEY `customerToTemp` (`customer_id`),
  CONSTRAINT `bahanToTemp` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `customerToTemp` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `userToTemp` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.temp: ~0 rows (approximately)

-- Dumping structure for table pipapip-project.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(50) NOT NULL DEFAULT '0',
  `tanggal` datetime NOT NULL,
  `total` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `user_id` bigint NOT NULL DEFAULT '0',
  `customer_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userToTransaksi` (`user_id`),
  KEY `customerToTransaksi` (`customer_id`),
  CONSTRAINT `customerToTransaksi` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `userToTransaksi` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.transaksi: ~8 rows (approximately)
INSERT INTO `transaksi` (`id`, `kode_transaksi`, `tanggal`, `total`, `user_id`, `customer_id`) VALUES
	(7, 'CODE001-2026010808060836', '2026-01-08 08:06:08', 252000.000000, 1, 1),
	(8, 'CODE001-2026010809313968', '2026-01-08 09:31:39', 260000.000000, 1, 1),
	(9, 'CODE001-2026010809470055', '2026-01-08 09:47:00', 600000.000000, 1, 1),
	(10, 'CODE001-2026010810411238', '2026-01-08 10:41:12', 120000.000000, 1, 3),
	(11, 'CODE001-2026010810441207', '2026-01-08 10:44:12', 210000.000000, 1, 1),
	(12, 'CODE001-2026010811040558', '2026-01-08 11:04:05', 40000.000000, 1, 1),
	(13, 'CODE001-2026010811042701', '2026-01-08 11:04:27', 120000.000000, 1, 3),
	(14, 'CODE001-2026010920031601', '2026-01-09 20:03:16', 132000.000000, 1, 1);


-- Dumping structure for table pipapip-project.detail_transaksi
CREATE TABLE IF NOT EXISTS `detail_transaksi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `transaksi_id` bigint NOT NULL DEFAULT '0',
  `bahan_id` bigint NOT NULL DEFAULT '0',
  `harga_jual` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `harga_beli` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `jumlah` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `transaksiToDetailTransaksi` (`transaksi_id`),
  KEY `bahanToDetailTransaksi` (`bahan_id`),
  CONSTRAINT `bahanToDetailTransaksi` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksiToDetailTransaksi` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table pipapip-project.detail_transaksi: ~12 rows (approximately)
INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `bahan_id`, `harga_jual`, `harga_beli`, `jumlah`) VALUES
	(10, 7, 3, 12000.000000, 10000.000000, 21),
	(11, 8, 2, 12000.000000, 10000.000000, 10),
	(12, 8, 3, 12000.000000, 10000.000000, 10),
	(13, 8, 5, 20000.000000, 10000.000000, 1),
	(14, 9, 3, 60000.000000, 50000.000000, 10),
	(15, 10, 3, 12000.000000, 10000.000000, 10),
	(16, 10, 2, 12000.000000, 10000.000000, 12),
	(17, 11, 5, 70000.000000, 50000.000000, 3),
	(18, 12, 5, 20000.000000, 10000.000000, 2),
	(19, 13, 3, 12000.000000, 10000.000000, 10),
	(20, 14, 2, 12000.000000, 10000.000000, 1),
	(21, 14, 3, 12000.000000, 10000.000000, 10);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
