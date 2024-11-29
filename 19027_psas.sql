-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 10:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `19027_psas`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `ktp` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `lama_sewa` int(11) NOT NULL,
  `status` enum('Menunggu Pembayaran','Selesai') NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status_pembayaran` enum('Sedang Diproses','Sudah Dibayar') DEFAULT 'Sedang Diproses',
  `no_rekening` varchar(50) DEFAULT NULL,
  `atas_nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `id_mobil`, `ktp`, `nama`, `alamat`, `telepon`, `tanggal_booking`, `lama_sewa`, `status`, `total_harga`, `status_pembayaran`, `no_rekening`, `atas_nama`) VALUES
(48, 5, '980765', 'Salsa', 'Banjarnegara', '0876541123', '2024-11-29', 2, '', 2300000.00, 'Sedang Diproses', NULL, NULL),
(49, 5, '065432', 'Nola', 'Purbalingga', '097654', '2024-11-21', 4, '', 4600000.00, 'Sedang Diproses', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi_transaksi`
--

CREATE TABLE `konfirmasi_transaksi` (
  `id` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `tanggal_transfer` date NOT NULL,
  `status` enum('pending','confirmed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konfirmasi_transaksi`
--

INSERT INTO `konfirmasi_transaksi` (`id`, `id_booking`, `no_rekening`, `atas_nama`, `nominal`, `tanggal_transfer`, `status`, `created_at`, `updated_at`) VALUES
(18, 48, '456231', 'Salsa', 2.30, '2024-11-24', 'pending', '2024-11-29 09:26:12', '2024-11-29 09:26:12'),
(19, 49, '896644', 'Nola', 4.60, '2024-11-03', 'pending', '2024-11-29 09:32:15', '2024-11-29 09:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga_sewa` decimal(10,2) NOT NULL,
  `no_plat` varchar(50) NOT NULL,
  `merk` varchar(100) NOT NULL,
  `status` enum('tersedia','disewa') DEFAULT 'tersedia',
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id`, `nama`, `harga_sewa`, `no_plat`, `merk`, `status`, `gambar`) VALUES
(3, 'Civic Turbo', 1550000.00, 'AB 890 SWI', 'Honda', 'tersedia', '67485b9ee8d81.jpg'),
(4, 'Pajero Sport', 1350000.00, 'AB 6734 HE', 'Mitsubishi', 'disewa', '67485dc9436d5.jpeg'),
(5, 'Honda HR-V ', 1150000.00, 'AB 1290 YU', 'Honda', 'tersedia', 'hrv.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `kode_booking` varchar(50) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_pembayaran` enum('Belum Dibayar','Sudah Dibayar') DEFAULT 'Belum Dibayar',
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pengunjung') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(13, 'inez', '$2y$10$U0oGtyO636QCWvEPRPOVp.uDvugUZXuc.QXJvXvQ0.xykGNSxOtpm', 'admin'),
(14, 'raisya', '$2y$10$dlCnoxDrkZm1avDjxjtd5u.n.if5Uf2O8bJ2V5oyJWjvJtITZaOvG', 'pengunjung');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mobil` (`id_mobil`);

--
-- Indexes for table `konfirmasi_transaksi`
--
ALTER TABLE `konfirmasi_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_booking` (`id_booking`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_booking` (`id_booking`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `konfirmasi_transaksi`
--
ALTER TABLE `konfirmasi_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`id_mobil`) REFERENCES `mobil` (`id`);

--
-- Constraints for table `konfirmasi_transaksi`
--
ALTER TABLE `konfirmasi_transaksi`
  ADD CONSTRAINT `konfirmasi_transaksi_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
