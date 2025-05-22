-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2025 at 06:51 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_koperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_nominal_simpanan`
--

CREATE TABLE `tb_nominal_simpanan` (
  `id` int NOT NULL,
  `jenis` enum('simpanan_pokok','simpanan_wajib') NOT NULL,
  `nominal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_nominal_simpanan`
--

INSERT INTO `tb_nominal_simpanan` (`id`, `jenis`, `nominal`) VALUES
(1, 'simpanan_pokok', 100000),
(2, 'simpanan_wajib', 200000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengajuan_peminjaman`
--

CREATE TABLE `tb_pengajuan_peminjaman` (
  `id` int NOT NULL,
  `id_pengguna` int DEFAULT NULL,
  `jenis_pengajuan` enum('reguler','insidental') NOT NULL,
  `nominal` int NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('proses','diterima','ditolak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `role` enum('admin','pengguna') NOT NULL DEFAULT 'pengguna'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id`, `nama`, `email`, `password`, `alamat`, `no_telepon`, `foto_profil`, `role`) VALUES
(1, 'Admin Koperasi Skaga', 'admin@gmail.com', '$2y$10$izZZXsTn1ng7N4EHu6EbW.6llc.VDiGv6wDTN4miB8yqS78uYcQBG', 'Jalan Dr. Subandi No. 31, Kreongan, Patrang, Jember', '0331 484566', NULL, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pinjaman_insidental`
--

CREATE TABLE `tb_pinjaman_insidental` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `bulan` varchar(255) NOT NULL,
  `tahun` year NOT NULL,
  `jumlah_angsuran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pinjaman_reguler`
--

CREATE TABLE `tb_pinjaman_reguler` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `bulan` varchar(255) NOT NULL,
  `tahun` year NOT NULL,
  `jumlah_angsuran` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_simpanan_pokok`
--

CREATE TABLE `tb_simpanan_pokok` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `tanggal_simpanan` date NOT NULL,
  `jumlah_simpanan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_simpanan_sukarela`
--

CREATE TABLE `tb_simpanan_sukarela` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `bulan` varchar(255) NOT NULL,
  `tahun` year NOT NULL,
  `jumlah_simpanan` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_simpanan_wajib`
--

CREATE TABLE `tb_simpanan_wajib` (
  `id` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `bulan` varchar(255) NOT NULL,
  `tahun` year NOT NULL,
  `jumlah_simpanan` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_nominal_simpanan`
--
ALTER TABLE `tb_nominal_simpanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pengajuan_peminjaman`
--
ALTER TABLE `tb_pengajuan_peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_pinjaman_insidental`
--
ALTER TABLE `tb_pinjaman_insidental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_pinjaman_reguler`
--
ALTER TABLE `tb_pinjaman_reguler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_simpanan_pokok`
--
ALTER TABLE `tb_simpanan_pokok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_simpanan_sukarela`
--
ALTER TABLE `tb_simpanan_sukarela`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_simpanan_wajib`
--
ALTER TABLE `tb_simpanan_wajib`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_nominal_simpanan`
--
ALTER TABLE `tb_nominal_simpanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pengajuan_peminjaman`
--
ALTER TABLE `tb_pengajuan_peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pinjaman_insidental`
--
ALTER TABLE `tb_pinjaman_insidental`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pinjaman_reguler`
--
ALTER TABLE `tb_pinjaman_reguler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_simpanan_pokok`
--
ALTER TABLE `tb_simpanan_pokok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_simpanan_sukarela`
--
ALTER TABLE `tb_simpanan_sukarela`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_simpanan_wajib`
--
ALTER TABLE `tb_simpanan_wajib`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_pengajuan_peminjaman`
--
ALTER TABLE `tb_pengajuan_peminjaman`
  ADD CONSTRAINT `tb_pengajuan_peminjaman_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pinjaman_insidental`
--
ALTER TABLE `tb_pinjaman_insidental`
  ADD CONSTRAINT `tb_pinjaman_insidental_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pinjaman_reguler`
--
ALTER TABLE `tb_pinjaman_reguler`
  ADD CONSTRAINT `tb_pinjaman_reguler_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_simpanan_pokok`
--
ALTER TABLE `tb_simpanan_pokok`
  ADD CONSTRAINT `tb_simpanan_pokok_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_simpanan_sukarela`
--
ALTER TABLE `tb_simpanan_sukarela`
  ADD CONSTRAINT `tb_simpanan_sukarela_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_simpanan_wajib`
--
ALTER TABLE `tb_simpanan_wajib`
  ADD CONSTRAINT `tb_simpanan_wajib_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
