/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `pipapip-project` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pipapip-project`;

CREATE TABLE IF NOT EXISTS `bahan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `satuan_id` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `satuanToBahan` (`satuan_id`),
  CONSTRAINT `satuanToBahan` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

REPLACE INTO `bahan` (`id`, `nama`, `satuan_id`) VALUES
	(2, 'Tegar Goreng', 1);

CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '0',
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `no_telp` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

REPLACE INTO `customers` (`id`, `customer_code`, `email`, `alamat`, `no_telp`) VALUES
	(2, 'CODE001', 'coba@gmail.com', 'karanganyar punk\r\n', '013896253');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `pengeluaran` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `keterangan` text NOT NULL,
  `jumlah` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `tipe_id` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tipeToPengeluaran` (`tipe_id`),
  CONSTRAINT `tipeToPengeluaran` FOREIGN KEY (`tipe_id`) REFERENCES `tipe` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `satuan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

REPLACE INTO `satuan` (`id`, `nama`) VALUES
	(1, 'pcs');

CREATE TABLE IF NOT EXISTS `temp` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL DEFAULT '0',
  `bahan_id` bigint NOT NULL DEFAULT '0',
  `harga_beli` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `harga_jual` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `jumlah` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userToTemp` (`user_id`),
  KEY `bahanToTemp` (`bahan_id`),
  CONSTRAINT `bahanToTemp` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `userToTemp` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `tipe` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(50) NOT NULL DEFAULT '0',
  `tanggal` datetime NOT NULL,
  `total` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `user_id` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userToTransaksi` (`user_id`),
  CONSTRAINT `userToTransaksi` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

REPLACE INTO `users` (`id`, `username`, `password`) VALUES
	(1, 'root', '$2y$10$5SkUqLeq2mxm3THN28zzfuKPvjs8W6pTdauDpjEeJnP/l14Ch8qmq');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
