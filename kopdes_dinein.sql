-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 07, 2026 at 02:59 PM
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
-- Database: `kopdes_dinein`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', 'kopdes123');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `kategori_menu` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` text DEFAULT NULL,
  `status` enum('tersedia','tidak tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `kategori_menu`, `deskripsi`, `gambar`, `status`) VALUES
(1, 'Espresso Single', 10000, 'Coffee', 'Kopi espresso murni dengan rasa kuat dan pekat', NULL, 'tersedia'),
(2, 'Long Black', 12000, 'Coffee', 'Espresso dengan tambahan air panas, rasa lebih ringan', NULL, 'tersedia'),
(3, 'Americano', 12000, 'Coffee', 'Espresso dicampur air panas dengan cita rasa smooth', NULL, 'tersedia'),
(4, 'Caffe Latte', 12000, 'Coffee', 'Perpaduan espresso dengan susu creamy', NULL, 'tersedia'),
(5, 'Cappuccino', 12000, 'Non-Coffee', 'Espresso dengan susu dan foam lembut', NULL, 'tersedia'),
(6, 'Milkpresso', 12000, 'Coffee', 'Espresso dengan dominasi susu lebih creamy', NULL, 'tersedia'),
(7, 'Moccacino', 14000, 'Coffee', 'Espresso dengan coklat dan susu', NULL, 'tersedia'),
(8, 'Aren Latte', 14000, 'Non-Coffee', 'Latte dengan gula aren khas Indonesia', NULL, 'tersedia'),
(9, 'Banana Latte', 14000, 'Non-Coffee', 'Latte dengan rasa pisang manis', NULL, 'tersedia'),
(10, 'Caramel Latte', 14000, 'Non-Coffee', 'Latte dengan sirup karamel', NULL, 'tersedia'),
(11, 'Hazelnut Latte', 14000, 'Non-Coffee', 'Latte dengan aroma hazelnut', NULL, 'tersedia'),
(12, 'Vanilla Latte', 14000, 'Non-Coffee', 'Latte dengan rasa vanilla lembut', NULL, 'tersedia'),
(13, 'Rum Latte', 14000, 'Non-Coffee', 'Latte dengan aroma rum (non-alkohol)', NULL, 'tersedia'),
(14, 'Baileys Latte', 15000, 'Non-Coffee', 'Latte dengan rasa creamy ala baileys', NULL, 'tersedia'),
(15, 'Strawberry Tea', 10000, 'Non-Coffee', 'Teh dengan rasa stroberi segar', NULL, 'tersedia'),
(16, 'Caramel Tea', 10000, 'Non-Coffee', 'Teh dengan sentuhan karamel manis', NULL, 'tersedia'),
(17, 'Lemon Tea', 10000, 'Non-Coffee', 'Teh dengan rasa lemon segar', NULL, 'tersedia'),
(18, 'Milk Tea', 10000, 'Non-Coffee', 'Teh susu creamy', NULL, 'tersedia'),
(19, 'Rum Tea', 10000, 'Non-Coffee', 'Teh dengan aroma rum (non-alkohol)', NULL, 'tersedia'),
(20, 'Lychee Tea', 13000, 'Non-Coffee', 'Teh dengan rasa leci segar', NULL, 'tersedia'),
(21, 'Strawberry Yakult', 14000, 'Non-Coffee', 'Minuman susu dengan yakult dan stroberi', NULL, 'tersedia'),
(22, 'Choco Hazelnut', 12000, 'Non-Coffee', 'Susu coklat dengan hazelnut', NULL, 'tersedia'),
(23, 'Cookies n Cream', 12000, 'Non-Coffee', 'Susu dengan rasa cookies and cream', NULL, 'tersedia'),
(24, 'Lychee Yakult', 12000, 'Non-Coffee', 'Yakult dengan rasa leci segar', NULL, 'tersedia'),
(25, 'Mango Yakult', 12000, 'Non-Coffee', 'Yakult dengan rasa mangga', NULL, 'tersedia'),
(26, 'Strawberry Milk', 12000, 'Non-Coffee', 'Susu rasa stroberi', NULL, 'tersedia'),
(27, 'Red Velvet', 12000, 'Non-Coffee', 'Minuman susu rasa red velvet', NULL, 'tersedia'),
(28, 'Chocolate Milk', 12000, 'Non-Coffee', 'Susu coklat klasik', NULL, 'tersedia'),
(29, 'Avocado Milk', 12000, 'Non-Coffee', 'Susu dengan rasa alpukat', NULL, 'tersedia'),
(30, 'Matcha Milk', 12000, 'Non-Coffee', 'Susu dengan matcha khas Jepang', NULL, 'tersedia'),
(31, 'Taro Milk', 10000, 'Non-Coffee', 'Susu dengan rasa taro', NULL, 'tersedia'),
(32, 'Thai Tea', 10000, 'Non-Coffee', 'Minuman teh Thailand dengan susu', NULL, 'tersedia'),
(33, 'Vanilla Milk', 10000, 'Non-Coffee', 'Susu dengan rasa vanilla', NULL, 'tersedia'),
(34, 'Cocopandan', 10000, 'Non-Coffee', 'Minuman soda dengan rasa cocopandan', NULL, 'tersedia'),
(35, 'Blue Rose', 10000, 'Non-Coffee', 'Minuman soda rasa manis segar', NULL, 'tersedia'),
(36, 'Mojito', 10000, 'Non-Coffee', 'Minuman soda dengan rasa mint dan lemon', NULL, 'tersedia'),
(37, 'Melon Squash', 10000, 'Non-Coffee', 'Minuman soda rasa melon segar', NULL, 'tersedia'),
(38, 'Nutrisari Jeruk', 5000, 'Non-Coffee', 'Minuman jeruk segar', NULL, 'tersedia'),
(39, 'Susu Coklat', 5000, 'Non-Coffee', 'Susu coklat hangat/dingin', NULL, 'tersedia'),
(40, 'Susu Putih', 5000, 'Non-Coffee', 'Susu putih plain', NULL, 'tersedia'),
(41, 'Susu Jahe', 6000, 'Non-Coffee', 'Susu dengan jahe hangat', NULL, 'tersedia'),
(42, 'Teh', 6000, 'Non-Coffee', 'Teh hangat/dingin', NULL, 'tersedia'),
(43, 'Beng Beng Drink', 7000, 'Non-Coffee', 'Minuman coklat beng beng', NULL, 'tersedia'),
(44, 'Milo', 8000, 'Non-Coffee', 'Minuman coklat milo', NULL, 'tersedia'),
(45, 'Good Day Freeze', 8000, 'Non-Coffee', 'Minuman kopi instan dingin', NULL, 'tersedia'),
(46, 'Kopi Hitam', 8000, 'Coffee', 'Kopi hitam klasik', NULL, 'tersedia'),
(47, 'Kopi Susu', 8000, 'Coffee', 'Kopi dengan susu', NULL, 'tersedia'),
(48, 'Susu Soda', 8000, 'Non-Coffee', 'Susu dengan soda segar', NULL, 'tersedia'),
(49, 'Joshua', 8000, 'Non-Coffee', 'Minuman soda dengan susu', NULL, 'tersedia'),
(50, 'Nugget', 8000, 'Snack', 'Nugget goreng crispy', NULL, 'tersedia'),
(51, 'Sosis', 8000, 'Snack', 'Sosis goreng', NULL, 'tersedia'),
(52, 'Kentang Goreng', 10000, 'Snack', 'Kentang goreng renyah', NULL, 'tersedia'),
(53, 'Mix Platter', 18000, 'Snack', 'Kombinasi snack (nugget, sosis, kentang)', NULL, 'tersedia'),
(54, 'Tahu Walik', 10000, 'Snack', 'Tahu walik isi aci khas', NULL, 'tersedia'),
(55, 'Mie Goreng Telur', 10000, 'Snack', 'Mie goreng dengan telur', NULL, 'tersedia'),
(56, 'Mie Kuah Telur', 10000, 'Snack', 'Mie kuah hangat dengan telur', NULL, 'tersedia'),
(57, 'Mie Goreng Double', 15000, 'Snack', 'Mie goreng porsi double dengan telur', NULL, 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `total_harga` int(11) NOT NULL,
  `no_meja` int(11) NOT NULL,
  `status` enum('menunggu','diproses','selesai') DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `tanggal`, `total_harga`, `no_meja`, `status`) VALUES
(1, '2026-05-05 23:52:13', 48000, 0, 'menunggu'),
(2, '2026-05-06 07:39:00', 74000, 8, 'menunggu'),
(3, '2026-05-06 13:03:44', 12000, 8, 'menunggu');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_pesanan_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id_pesanan_detail`, `id_pesanan`, `id_menu`, `harga`, `jumlah`, `subtotal`) VALUES
(1, 1, 2, 12000, 4, 48000),
(2, 2, 1, 10000, 4, 40000),
(3, 2, 2, 12000, 1, 12000),
(4, 2, 51, 8000, 1, 8000),
(5, 2, 8, 14000, 1, 14000),
(6, 3, 2, 12000, 1, 12000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id_pesanan_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_pesanan_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
