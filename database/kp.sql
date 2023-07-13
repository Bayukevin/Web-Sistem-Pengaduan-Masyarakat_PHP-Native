-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2023 at 03:08 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `divisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `divisi`) VALUES
(0, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 0),
(1, 'admin1', '25f43b1486ad95a1398e3eeb3d83bc4010015fcc9bedb35b432e00298d5021f7', 1),
(2, 'admin2', '1c142b2d01aa34e9a36bde480645a57fd69e14155dacfab5a3f9257b77fdc8d8', 2),
(3, 'admin3', '4fc2b5673a201ad9b1fc03dcb346e1baad44351daa0503d5534b4dfdcc4332e0', 3),
(4, 'admin4', '110198831a426807bccd9dbdf54b6dcb5298bc5d31ac49069e0ba3d210d970ae', 4);

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
(0, 'Super Admin'),
(1, 'Kerusakan Jalan'),
(2, 'Pencemaran Lingkungan'),
(3, 'Kerusakan Infastruktur'),
(4, 'Lain-Lain');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `nama` varchar(64) COLLATE utf8_bin NOT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `telpon` varchar(12) COLLATE utf8_bin NOT NULL,
  `alamat` varchar(256) COLLATE utf8_bin NOT NULL,
  `tujuan` int(11) NOT NULL,
  `isi` varchar(2048) COLLATE utf8_bin NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(12) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `nama`, `email`, `telpon`, `alamat`, `tujuan`, `isi`, `tanggal`, `status`) VALUES
(103, 'Bayu Kevin Farindra', 'bayukevinfarindra23@gmail.com', '082279293661', 'Ketintang Barat No 166C', 1, 'Sering terjadinya banjir akibat kurangnya sistem drainase di daerah ketintang barat', '2023-01-31 13:39:22', 'Ditanggapi'),
(104, 'Mister X', 'mister-x@gmail.com', '081212343456', 'Surabaya Barat', 2, 'Adanya pencemaran terhadap air sungai yang disebabkan oleh salah satu pabrik yang membuang limbahnya di sungai, mohon pemerintahan kota Surabaya untuk mengatasi masalah ini agar tidak menyebabkan efek buruk uuntuk warga sekitar', '2023-01-31 13:44:45', 'Ditanggapi'),
(105, 'Bintang Rasya Nugraha', 'star123@gmail.com', '087854356543', 'Wiyung Surabaya', 3, 'Saya ingin melaporkan kerusakan pada beberapa lampu jalan daerah wiyung. Mohon pemerintah kota untuk segera memperbaikinya supaya pengguna jalan menjadi nyaman dengan adanya penerangan yang memadai', '2023-02-04 10:34:53', 'Ditanggapi'),
(106, 'Rafael Fillah', 'el_sby@gmail.com', '082345672345', 'Wiyung Surabaya', 3, 'Ada beberapa kerusakan pada jembatan rolag,  mohon pemerintah untuk memperbaikinya supaya tidak sampai terjadi kecelakaan', '2023-01-31 14:52:16', 'Menunggu');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL,
  `id_laporan` int(11) NOT NULL,
  `admin` varchar(64) COLLATE utf8_bin NOT NULL,
  `isi_tanggapan` varchar(2048) COLLATE utf8_bin NOT NULL,
  `tanggal_tanggapan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tanggapan`
--

INSERT INTO `tanggapan` (`id_tanggapan`, `id_laporan`, `admin`, `isi_tanggapan`, `tanggal_tanggapan`) VALUES
(1, 103, 'admin', 'Terimakasih telah memberikan laporan. Pengaduan anda telah kami proses, kerusakan jalan dan sering terjadinya banjir pada daerah ketintang barat sedang kami perbaiki.', '2023-01-31 14:10:17'),
(2, 106, 'admin', 'Laporan anda telah kami proses', '2023-02-03 00:42:06'),
(3, 105, 'admin', 'Laporan anda telah kami proses. Terimakasih telah memberikan laporan.', '2023-02-04 10:34:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `divisi` (`divisi`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tujuan` (`tujuan`);

--
-- Indexes for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`divisi`) REFERENCES `divisi` (`id_divisi`);

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`tujuan`) REFERENCES `divisi` (`id_divisi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
