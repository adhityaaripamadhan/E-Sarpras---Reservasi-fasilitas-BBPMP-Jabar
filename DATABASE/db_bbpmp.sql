-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 03:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bbpmp`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('admin','pengguna') NOT NULL DEFAULT 'pengguna'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id`, `username`, `email`, `nohp`, `password`, `role`) VALUES
(11, 'adit', 'aditsopo@gmail.com', '08925254327', '$2y$10$QGqR3mnWnoLluFA4hfLazOtzHmKcaKZa7ey5SQi5rPeqrsm3QzTze', 'pengguna'),
(13, 'riski', NULL, NULL, '$2y$10$Otj2cpzNWAxzIDol0dusde6a8vG65aKGYdhTSeKCLcIOFlqxO7.Dy', 'admin'),
(14, 'admin', NULL, NULL, '$2y$10$DqFJUWwzcyAcC/j3fi/89.K0./YDCBp2l7QxeR0wlxbYQjnrCgy9a', 'admin'),
(20, 'adhitya', 'adits@gmail.com', '0896735628285', '$2y$10$x3ARK1N99jNwuQypJQIk1.jez38Zvr.xivVtkCv4HQYKrFyOCiX7W', 'pengguna'),
(25, 'YUXIE', 'yuxiemixue@gmail.com', '08925141624', '$2y$10$UaxVxKuaIHdKYPI7EOPfNOFvDNnTNvuDYdF8wsCvse7.N3a8Dgniq', ''),
(26, 'riskiw', 'robloxamki@gmail.com', '08927652451', '$2y$10$qVtzuw2JnsDG5Q8FV3..l.eEup23rX7gApxOCIPCCshQOxKBffILW', ''),
(27, 'andira', 'apalah@gmail.com', '08881726162', '$2y$10$acNjYPEp3MbnWUOD6i7CHOuJQ1a65PeOcqhPZjlSpTc2T4uX.cZYu', ''),
(28, 'yuxi', 'yuxinotyuki@gmail.com', '089252415432', '$2y$10$GDxIVE8cNnv2CfkeubuOr.ApuMQ7RX6Vw3gdRuDxK2Kt/L4hrDbwq', ''),
(29, 'rumasi', 'rumasi666@gmail.com', '0837138137132', '$2y$10$M44ioP74WbwS0Pz/i6QOIOYiW.RgnBpU9blhvWzrjKE/Wn6f6SKTS', '');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `aktivitas`, `tanggal`) VALUES
(1, 11, 'Login ke sistem', '2025-09-12 10:21:15'),
(2, 11, 'Melakukan reservasi Aula Tangkuban Parahu', '2025-09-12 10:21:15'),
(3, 20, 'Mengubah data reservasi kelas A', '2025-09-12 10:21:15'),
(4, 20, 'Logout dari sistem', '2025-09-12 10:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reservasi_id` int(11) DEFAULT NULL,
  `pesan` varchar(255) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `status` enum('belum_dibaca','dibaca') DEFAULT 'belum_dibaca'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `reservasi_id`, `pesan`, `tanggal`, `status`) VALUES
(3, 20, 85, 'Status reservasi \"Lomba Olahraga\" di MESS 1 telah diubah menjadi proses.', '2025-09-12 11:32:13', 'dibaca'),
(4, 20, 85, 'Status reservasi \"Lomba Olahraga\" di MESS 1 telah diubah menjadi disetujui.', '2025-09-12 11:34:57', 'dibaca'),
(5, 20, 85, 'Status reservasi \"Lomba Olahraga\" di MESS 1 telah diubah menjadi proses.', '2025-09-12 11:38:14', 'belum_dibaca'),
(6, 20, 85, 'Status reservasi \"Lomba Olahraga\" di MESS 1 telah diubah menjadi disetujui.', '2025-09-12 13:18:01', 'belum_dibaca');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id` int(11) NOT NULL,
  `Nama` varchar(225) NOT NULL,
  `NoHP` varchar(225) NOT NULL,
  `Email` varchar(225) NOT NULL,
  `NamaKegiatan` varchar(225) NOT NULL,
  `Pengusul` varchar(225) NOT NULL,
  `Namainstansi` varchar(225) NOT NULL,
  `Alamat` varchar(225) NOT NULL,
  `TanggalAwal` varchar(255) NOT NULL,
  `TanggalAkhir` varchar(255) NOT NULL,
  `WaktuAwal` varchar(255) NOT NULL,
  `WaktuAkhir` varchar(255) NOT NULL,
  `JenisUsulan` varchar(225) NOT NULL,
  `Ruangan` varchar(255) DEFAULT NULL,
  `status` enum('pending','proses','disetujui','ditolak') DEFAULT 'pending',
  `lampiran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi`
--

INSERT INTO `reservasi` (`id`, `Nama`, `NoHP`, `Email`, `NamaKegiatan`, `Pengusul`, `Namainstansi`, `Alamat`, `TanggalAwal`, `TanggalAkhir`, `WaktuAwal`, `WaktuAkhir`, `JenisUsulan`, `Ruangan`, `status`, `lampiran`) VALUES
(79, 'adit', '08925254327', 'aditsopo@gmail.com', 'Seminar', 'Pribadi', 'Arif n the gang', 'Batujajar', '2025-08-27', '2025-08-31', '07:15', '19:15', 'eksternal/umum', 'AULA TANGKUBAN PARAHU', 'pending', ''),
(80, 'adhitya', '0896735628285', 'adits@gmail.com', 'Podcast', 'Pribadi', 'Arif n the gang', 'Pasar kosong', '2025-08-27', '2025-08-31', '07:18', '22:18', 'internal', 'KELAS A', 'ditolak', ''),
(81, 'riskiw', '08927652451', 'robloxamki@gmail.com', 'Mabar', 'Organisasi', 'Sulai', 'Babakan pari', '2025-08-27', '2025-08-31', '07:22', '19:22', 'eksternal/umum', 'KELAS C', 'pending', ''),
(82, 'andira', '08881726162', 'apalah@gmail.com', 'Ngelamun', 'Dukman / Bag. Umum (Internal BBPMP)', 'Bagian Umum', 'Cibinong', '2025-08-27', '2025-08-31', '07:32', '19:32', 'internal', 'KELAS B', 'disetujui', ''),
(83, 'yuxi', '089252415432', 'yuxinotyuki@gmail.com', 'Event Kantor', 'Instansi', 'Timker eropa', 'Berlin', '2025-08-27', '2025-08-31', '07:35', '19:35', 'eksternal/umum', 'KELAS D', 'proses', ''),
(84, 'adhitya', '0896735628285', 'adits@gmail.com', 'Event Kantor', 'Instansi', 'Timker eropa', 'cikurai', '2025-08-31', '2025-08-31', '17:45', '05:45', 'internal', 'KELAS A', 'pending', ''),
(85, 'adhitya', '0896735628285', 'adits@gmail.com', 'Lomba Olahraga', 'Organisasi', 'ORGANISASI PACE BERGOYANG', 'cibacang', '2025-09-12', '2025-09-20', '22:27', '22:27', 'internal', 'MESS 1', 'disetujui', '1757647661_data_reservasi (2).pdf'),
(86, 'adhitya', '0896735628285', 'adits@gmail.com', 'Event Kantor', 'Organisasi', 'Timker eropa', 'Rumasi', '2025-09-18', '2025-09-19', '07:27', '07:30', 'internal', 'AULA TANGKUBAN PARAHU', 'pending', ''),
(87, 'adhitya', '0896735628285', 'adits@gmail.com', 'Event Kantor', 'Organisasi', 'Timker eropa', 'Rumasi', '2025-09-18', '2025-09-19', '07:27', '07:30', 'internal', 'AULA TANGKUBAN PARAHU', 'pending', ''),
(88, 'adhitya', '0896735628285', 'adits@gmail.com', 'Event Kantor', 'Organisasi', 'Timker eropa', 'Rumasi', '2025-09-18', '2025-09-19', '07:27', '07:30', 'internal', 'AULA TANGKUBAN PARAHU', 'pending', ''),
(89, 'adhitya', '0896735628285', 'adits@gmail.com', 'Event Kantor', 'Pribadi', 'Timker eropa', 'Rumasi', '2025-09-18', '2025-09-19', '08:42', '10:43', 'internal', 'AULA TANGKUBAN PARAHU', 'pending', ''),
(90, 'adhitya', '0896735628285', 'adits@gmail.com', 'Event Kantor', 'Pribadi', 'Timker eropa', 'Rumasi', '2025-09-18', '2025-09-19', '08:42', '10:43', 'internal', 'AULA TANGKUBAN PARAHU', 'pending', ''),
(91, 'adhitya', '0896735628285', 'adits@gmail.com', 'Event Kantor', 'Tim Kerja (Internal BBPMP)', 'Timker eropa', 'Rumasi', '2025-09-17', '2025-09-18', '07:55', '07:58', 'internal', 'AULA TANGKUBAN PARAHU', 'pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `photo` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `deskripsi`, `photo`) VALUES
(30, 'AULA TANGKUBAN PARAHU', '🪑 Tanpa meja: 250 kursi\r\n🪑 Dengan meja: 120 kursi', 0x363839343066333161306434325f41756c612e6a7067),
(31, 'KELAS A', '👥 Maksimal 40 orang dengan meja & kursi', 0x363839326265313636653662665f6b656c61732e6a706567),
(32, 'KELAS B', '👥 Maksimal 40 orang dengan meja & kursi', 0x363839326265336334316639665f6b656c61732e6a706567),
(33, 'MESS 1', '🛏️ 2 orang per kamar\n📞 Info lebih lanjut: hubungi Bagian Informasi', 0x363839326265373530613362625f6d6573732064616e20617372616d612e6a7067),
(41, 'KELAS C', '👥 Maksimal 40 orang dengan meja & kursi', 0x363839353564653839313063375f363839326265336334316639665f6b656c61732e6a706567),
(42, 'KELAS D', '👥 Maksimal 40 orang dengan meja & kursi', 0x363839353565316139643736635f363839326265336334316639665f6b656c61732e6a706567);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `akun` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `akun` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
