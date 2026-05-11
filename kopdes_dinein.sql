-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2026 at 09:03 PM
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
(1, 'Espresso Single', 10000, 'Coffee', 'Kopi espresso murni dengan rasa kuat dan aroma khas biji kopi pilihan', 'espresso-single-1778393565.jpg', 'tersedia'),
(2, 'Long Black', 12000, 'Coffee', 'Espresso dengan tambahan air panas menghasilkan rasa lebih ringan dan smooth', '', 'tersedia'),
(3, 'Americano', 12000, 'Coffee', 'Kopi americano dengan rasa klasik dan sensasi pahit yang seimbang', '', 'tersedia'),
(4, 'Caffe Latte', 12000, 'Coffee', 'Perpaduan espresso dan susu creamy yang lembut dan nikmat', '', 'tersedia'),
(5, 'Cappuccino', 12000, 'Non-Coffee', 'Minuman creamy dengan foam susu lembut dan rasa kopi khas', '', 'tersedia'),
(6, 'Milkpresso', 12000, 'Coffee', 'Espresso susu creamy dengan tekstur lembut dan rasa manis ringan', '', 'tersedia'),
(7, 'Moccacino', 14000, 'Coffee', 'Perpaduan kopi, coklat, dan susu dengan rasa manis creamy', '', 'tersedia'),
(8, 'Aren Latte', 14000, 'Non-Coffee', 'Latte dengan gula aren asli Indonesia yang manis dan harum', '', 'tersedia'),
(9, 'Banana Latte', 14000, 'Non-Coffee', 'Minuman latte dengan rasa pisang lembut dan creamy', '', 'tersedia'),
(10, 'Caramel Latte', 14000, 'Non-Coffee', 'Latte dengan sirup karamel manis dan aroma menggoda', '', 'tersedia'),
(11, 'Hazelnut Latte', 14000, 'Non-Coffee', 'Latte creamy dengan aroma hazelnut yang khas dan nikmat', '', 'tersedia'),
(12, 'Vanilla Latte', 14000, 'Non-Coffee', 'Latte lembut dengan rasa vanilla manis dan creamy', '', 'tersedia'),
(13, 'Rum Latte', 14000, 'Non-Coffee', 'Latte dengan aroma rum khas tanpa kandungan alkohol', '', 'tersedia'),
(14, 'Baileys Latte', 15000, 'Non-Coffee', 'Minuman latte creamy dengan rasa ala baileys yang lembut', '', 'tersedia'),
(15, 'Strawberry Tea', 10000, 'Non-Coffee', 'Teh segar dengan rasa stroberi manis dan aroma fruity', '', 'tersedia'),
(16, 'Caramel Tea', 10000, 'Non-Coffee', 'Teh dengan sentuhan karamel manis yang unik dan lezat', '', 'tersedia'),
(17, 'Lemon Tea', 10000, 'Non-Coffee', 'Teh lemon segar dengan rasa asam manis menyegarkan', '', 'tersedia'),
(18, 'Milk Tea', 10000, 'Non-Coffee', 'Perpaduan teh dan susu creamy dengan rasa lembut', '', 'tersedia'),
(19, 'Rum Tea', 10000, 'Non-Coffee', 'Teh dengan aroma rum khas tanpa alkohol yang unik', '', 'tersedia'),
(20, 'Lychee Tea', 13000, 'Non-Coffee', 'Teh dengan rasa leci segar dan sensasi fruity', '', 'tersedia'),
(21, 'Strawberry Yakult', 14000, 'Non-Coffee', 'Yakult dengan rasa stroberi segar dan creamy menyenangkan', '', 'tersedia'),
(22, 'Choco Hazelnut', 12000, 'Non-Coffee', 'Minuman coklat hazelnut dengan rasa manis dan creamy', '', 'tersedia'),
(23, 'Cookies n Cream', 12000, 'Non-Coffee', 'Minuman susu dengan rasa cookies and cream favorit semua kalangan', '', 'tersedia'),
(24, 'Lychee Yakult', 12000, 'Non-Coffee', 'Yakult segar dengan rasa leci yang manis dan menyegarkan', '', 'tersedia'),
(25, 'Mango Yakult', 12000, 'Non-Coffee', 'Yakult dengan rasa mangga segar dan sensasi tropis', '', 'tersedia'),
(26, 'Strawberry Milk', 12000, 'Non-Coffee', 'Susu stroberi creamy dengan rasa manis yang lembut', '', 'tersedia'),
(27, 'Red Velvet', 12000, 'Non-Coffee', 'Minuman susu red velvet dengan rasa manis dan creamy', '', 'tersedia'),
(28, 'Chocolate Milk', 12000, 'Non-Coffee', 'Susu coklat klasik dengan rasa manis dan creamy', '', 'tersedia'),
(29, 'Avocado Milk', 12000, 'Non-Coffee', 'Minuman susu alpukat creamy dengan rasa lembut dan segar', '', 'tersedia'),
(30, 'Matcha Milk', 12000, 'Non-Coffee', 'Susu matcha khas Jepang dengan rasa creamy dan harum', '', 'tersedia'),
(31, 'Taro Milk', 10000, 'Non-Coffee', 'Minuman susu rasa taro dengan warna dan rasa khas', '', 'tersedia'),
(32, 'Thai Tea', 10000, 'Non-Coffee', 'Teh Thailand creamy dengan rasa manis dan aroma khas', '', 'tersedia'),
(33, 'Vanilla Milk', 10000, 'Non-Coffee', 'Susu vanilla dengan rasa lembut dan aroma manis khas', '', 'tersedia'),
(34, 'Cocopandan', 10000, 'Non-Coffee', 'Minuman soda cocopandan segar dengan rasa manis unik', '', 'tersedia'),
(35, 'Blue Rose', 10000, 'Non-Coffee', 'Minuman soda segar dengan warna cantik dan rasa manis', '', 'tersedia'),
(36, 'Mojito', 10000, 'Non-Coffee', 'Minuman soda mint lemon segar khas mojito non alkohol', '', 'tersedia'),
(37, 'Melon Squash', 10000, 'Non-Coffee', 'Soda melon segar dengan rasa manis dan menyegarkan', '', 'tersedia'),
(38, 'Nutrisari Jeruk', 5000, 'Non-Coffee', 'Minuman jeruk segar dengan rasa manis dan asam seimbang', '', 'tersedia'),
(39, 'Susu Coklat', 5000, 'Non-Coffee', 'Susu coklat hangat atau dingin yang creamy dan nikmat', '', 'tersedia'),
(40, 'Susu Putih', 5000, 'Non-Coffee', 'Susu putih plain dengan rasa lembut dan creamy', '', 'tersedia'),
(41, 'Susu Jahe', 6000, 'Non-Coffee', 'Susu jahe hangat yang cocok dinikmati saat dingin', '', 'tersedia'),
(42, 'Teh', 6000, 'Non-Coffee', 'Teh hangat atau dingin dengan rasa klasik menyegarkan', '', 'tersedia'),
(43, 'Beng Beng Drink', 7000, 'Non-Coffee', 'Minuman coklat beng beng dengan rasa manis favorit', '', 'tersedia'),
(44, 'Milo', 8000, 'Non-Coffee', 'Minuman milo creamy dengan rasa coklat khas dan lezat', '', 'tersedia'),
(45, 'Good Day Freeze', 8000, 'Non-Coffee', 'Minuman kopi instan dingin dengan rasa manis segar', '', 'tersedia'),
(46, 'Kopi Hitam', 8000, 'Coffee', 'Kopi hitam klasik dengan aroma kuat dan rasa autentik', 'kopi-hitam-1778391582.jpeg', 'tersedia'),
(47, 'Kopi Susu', 8000, 'Coffee', 'Perpaduan kopi dan susu dengan rasa creamy seimbang', '', 'tersedia'),
(48, 'Susu Soda', 8000, 'Non-Coffee', 'Minuman susu soda segar dengan sensasi unik dan creamy', '', 'tersedia'),
(49, 'Joshua', 8000, 'Non-Coffee', 'Perpaduan soda dan susu dengan rasa manis menyegarkan', '', 'tersedia'),
(50, 'Nugget', 8000, 'Snack', 'Nugget goreng crispy cocok untuk camilan santai', '', 'tersedia'),
(51, 'Sosis', 8000, 'Snack', 'Sosis goreng dengan rasa gurih dan tekstur juicy', '', 'tersedia'),
(52, 'Kentang Goreng', 10000, 'Snack', 'Kentang goreng renyah dengan rasa gurih dan nikmat', 'kentang-goreng-1778392398.png', 'tidak tersedia'),
(53, 'Mix Platter', 18000, 'Snack', 'Kombinasi nugget, sosis, dan kentang dalam satu platter', '', 'tersedia'),
(54, 'Tahu Walik', 10000, 'Snack', 'Tahu walik isi aci dengan tekstur gurih dan renyah', '', 'tersedia'),
(55, 'Mie Goreng Telur', 10000, 'Snack', 'Mie goreng dengan telur dan bumbu gurih spesial', '', 'tersedia'),
(56, 'Mie Kuah Telur', 10000, 'Snack', 'Pokoknya minya itu enak terus panjang sedikit berkuah banyak toping telor 3 butir di masak mateng ', 'mie-kuah-telur-1778392374.jpeg', 'tidak tersedia'),
(57, 'Mie Goreng Single', 400, 'Snack', 'Mie goreng double porsi besar dengan topping telur lezat', 'mie-goreng-single-1778390922.jpeg', 'tersedia'),
(63, 'Cimol', 20000, 'Snack', NULL, '', 'tidak tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `total_harga` int(11) NOT NULL,
  `no_meja` int(11) NOT NULL,
  `status` enum('menunggu','terkonfirmasi','diproses','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `tanggal`, `total_harga`, `no_meja`, `status`) VALUES
(1, '2026-05-05 23:52:13', 48000, 0, 'dibatalkan'),
(2, '2026-05-06 07:39:00', 74000, 8, 'dibatalkan'),
(3, '2026-05-06 13:03:44', 12000, 8, 'dibatalkan'),
(4, '2026-05-07 21:27:32', 70000, 7, 'terkonfirmasi'),
(5, '2026-05-07 22:28:54', 288000, 7, 'dibatalkan'),
(6, '2026-05-07 22:47:07', 220000, 7, 'dibatalkan'),
(7, '2026-05-07 23:41:36', 72000, 12, 'dibatalkan'),
(8, '2026-05-07 23:41:49', 10000, 12, 'dibatalkan'),
(9, '2026-05-08 00:29:15', 310000, 7, 'dibatalkan'),
(10, '2026-05-08 08:41:23', 24000, 12, 'dibatalkan'),
(11, '2026-05-08 08:50:43', 40000, 12, 'dibatalkan'),
(12, '2026-05-08 08:55:03', 10000, 12, 'dibatalkan'),
(13, '2026-05-08 08:56:08', 52000, 12, 'terkonfirmasi'),
(14, '2026-05-08 09:17:02', 60000, 12, 'dibatalkan'),
(15, '2026-05-08 11:08:00', 460000, 12, 'terkonfirmasi'),
(16, '2026-05-08 11:25:53', 94000, 12, 'terkonfirmasi'),
(17, '2026-05-08 13:11:20', 60000, 12, 'terkonfirmasi'),
(18, '2026-05-08 13:16:27', 20000, 12, 'terkonfirmasi'),
(19, '2026-05-08 13:28:27', 46000, 12, 'terkonfirmasi'),
(20, '2026-05-08 13:35:47', 94000, 12, 'terkonfirmasi'),
(21, '2026-05-08 13:45:05', 66000, 12, 'terkonfirmasi'),
(22, '2026-05-08 13:51:13', 10000, 12, 'terkonfirmasi'),
(23, '2026-05-08 13:56:21', 138000, 12, 'terkonfirmasi'),
(28, '2026-05-08 14:09:45', 88000, 20, 'terkonfirmasi'),
(29, '2026-05-08 14:24:45', 26000, 20, 'terkonfirmasi'),
(30, '2026-05-08 14:49:10', 56000, 20, 'terkonfirmasi'),
(31, '2026-05-08 14:56:57', 72000, 20, 'terkonfirmasi'),
(32, '2026-05-08 15:01:15', 40000, 20, 'terkonfirmasi'),
(33, '2026-05-08 15:05:15', 36000, 20, 'terkonfirmasi'),
(34, '2026-05-08 15:06:40', 80000, 20, 'terkonfirmasi'),
(35, '2026-05-08 15:07:41', 52000, 20, 'terkonfirmasi'),
(36, '2026-05-08 15:34:02', 100000, 20, 'terkonfirmasi'),
(37, '2026-05-08 15:37:46', 64000, 20, 'terkonfirmasi'),
(38, '2026-05-08 15:42:38', 95000, 20, 'terkonfirmasi'),
(39, '2026-05-08 16:51:55', 172000, 20, 'terkonfirmasi'),
(40, '2026-05-09 02:34:51', 60000, 7, 'terkonfirmasi'),
(41, '2026-05-09 03:46:38', 94000, 7, 'terkonfirmasi'),
(42, '2026-05-09 03:47:59', 71000, 7, 'terkonfirmasi'),
(43, '2026-05-09 03:52:37', 56000, 90, 'terkonfirmasi'),
(44, '2026-05-09 03:55:12', 24000, 12, 'dibatalkan'),
(45, '2026-05-09 03:56:52', 36000, 12, 'terkonfirmasi'),
(46, '2026-05-09 04:24:47', 46000, 30, 'dibatalkan'),
(47, '2026-05-09 04:45:31', 50000, 30, 'terkonfirmasi'),
(48, '2026-05-09 05:04:17', 24000, 7, 'terkonfirmasi'),
(49, '2026-05-09 05:04:52', 24000, 7, 'dibatalkan'),
(50, '2026-05-09 05:12:48', 38000, 12, 'terkonfirmasi'),
(51, '2026-05-09 05:13:25', 24000, 12, 'dibatalkan'),
(52, '2026-05-09 05:15:42', 76000, 12, 'terkonfirmasi'),
(53, '2026-05-09 08:52:34', 50000, 7, 'terkonfirmasi'),
(54, '2026-05-09 08:53:30', 58000, 7, 'dibatalkan'),
(55, '2026-05-09 08:54:04', 44000, 10, 'terkonfirmasi'),
(56, '2026-05-09 09:10:56', 48000, 10, 'terkonfirmasi'),
(57, '2026-05-09 11:18:30', 33000, 0, 'terkonfirmasi'),
(58, '2026-05-09 11:19:46', 12000, 0, 'dibatalkan'),
(59, '2026-05-10 08:49:44', 10000, 0, 'terkonfirmasi'),
(60, '2026-05-10 14:57:26', 216000, 10, 'menunggu'),
(61, '2026-05-10 14:58:27', 60000, 10, 'dibatalkan'),
(62, '2026-05-10 14:58:46', 12000, 10, 'dibatalkan'),
(63, '2026-05-10 16:24:36', 46000, 10, 'terkonfirmasi');

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
(6, 3, 2, 12000, 1, 12000),
(7, 4, 4, 12000, 5, 60000),
(8, 4, 55, 10000, 1, 10000),
(9, 5, 6, 12000, 11, 132000),
(10, 5, 3, 12000, 6, 72000),
(11, 5, 11, 14000, 6, 84000),
(12, 6, 2, 12000, 1, 12000),
(13, 6, 5, 12000, 10, 120000),
(14, 6, 18, 10000, 2, 20000),
(15, 6, 21, 14000, 2, 28000),
(16, 6, 12, 14000, 1, 14000),
(17, 6, 10, 14000, 1, 14000),
(18, 6, 3, 12000, 1, 12000),
(19, 7, 2, 12000, 6, 72000),
(20, 8, 1, 10000, 1, 10000),
(21, 9, 3, 12000, 6, 72000),
(22, 9, 2, 12000, 19, 228000),
(23, 9, 32, 10000, 1, 10000),
(24, 10, 3, 12000, 1, 12000),
(25, 10, 2, 12000, 1, 12000),
(26, 11, 51, 8000, 5, 40000),
(27, 12, 1, 10000, 1, 10000),
(28, 13, 3, 12000, 1, 12000),
(29, 13, 1, 10000, 4, 40000),
(30, 14, 2, 12000, 5, 60000),
(31, 15, 1, 10000, 11, 110000),
(32, 15, 8, 14000, 11, 154000),
(33, 15, 3, 12000, 7, 84000),
(34, 15, 9, 14000, 7, 98000),
(35, 15, 12, 14000, 1, 14000),
(36, 16, 1, 10000, 1, 10000),
(37, 16, 4, 12000, 7, 84000),
(38, 17, 2, 12000, 1, 12000),
(39, 17, 3, 12000, 3, 36000),
(40, 17, 4, 12000, 1, 12000),
(41, 18, 2, 12000, 1, 12000),
(42, 18, 51, 8000, 1, 8000),
(43, 19, 2, 12000, 1, 12000),
(44, 19, 1, 10000, 1, 10000),
(45, 19, 3, 12000, 1, 12000),
(46, 19, 4, 12000, 1, 12000),
(47, 20, 1, 10000, 1, 10000),
(48, 20, 2, 12000, 1, 12000),
(49, 20, 3, 12000, 1, 12000),
(50, 20, 4, 12000, 1, 12000),
(51, 20, 5, 12000, 4, 48000),
(52, 21, 3, 12000, 1, 12000),
(53, 21, 2, 12000, 1, 12000),
(54, 21, 8, 14000, 1, 14000),
(55, 21, 9, 14000, 1, 14000),
(56, 21, 10, 14000, 1, 14000),
(57, 22, 1, 10000, 1, 10000),
(58, 23, 1, 10000, 1, 10000),
(59, 23, 2, 12000, 1, 12000),
(60, 23, 6, 12000, 1, 12000),
(61, 23, 5, 12000, 4, 48000),
(62, 23, 10, 14000, 4, 56000),
(77, 28, 2, 12000, 5, 60000),
(78, 28, 7, 14000, 2, 28000),
(79, 29, 6, 12000, 1, 12000),
(80, 29, 7, 14000, 1, 14000),
(81, 30, 7, 14000, 1, 14000),
(82, 30, 8, 14000, 1, 14000),
(83, 30, 9, 14000, 1, 14000),
(84, 30, 10, 14000, 1, 14000),
(85, 31, 2, 12000, 1, 12000),
(86, 31, 3, 12000, 1, 12000),
(87, 31, 5, 12000, 4, 48000),
(88, 32, 3, 12000, 1, 12000),
(89, 32, 7, 14000, 2, 28000),
(90, 33, 4, 12000, 1, 12000),
(91, 33, 2, 12000, 2, 24000),
(92, 34, 3, 12000, 3, 36000),
(93, 34, 4, 12000, 1, 12000),
(94, 34, 2, 12000, 1, 12000),
(95, 34, 1, 10000, 2, 20000),
(96, 35, 3, 12000, 1, 12000),
(97, 35, 2, 12000, 1, 12000),
(98, 35, 8, 14000, 1, 14000),
(99, 35, 9, 14000, 1, 14000),
(100, 36, 2, 12000, 2, 24000),
(101, 36, 5, 12000, 4, 48000),
(102, 36, 9, 14000, 2, 28000),
(103, 37, 3, 12000, 2, 24000),
(104, 37, 4, 12000, 1, 12000),
(105, 37, 10, 14000, 1, 14000),
(106, 37, 12, 14000, 1, 14000),
(107, 38, 2, 12000, 1, 12000),
(108, 38, 9, 14000, 1, 14000),
(109, 38, 20, 13000, 3, 39000),
(110, 38, 37, 10000, 3, 30000),
(111, 39, 2, 12000, 1, 12000),
(112, 39, 3, 12000, 3, 36000),
(113, 39, 8, 14000, 3, 42000),
(114, 39, 10, 14000, 3, 42000),
(115, 39, 17, 10000, 4, 40000),
(116, 40, 2, 12000, 1, 12000),
(117, 40, 3, 12000, 1, 12000),
(118, 40, 4, 12000, 3, 36000),
(119, 41, 2, 12000, 1, 12000),
(120, 41, 4, 12000, 1, 12000),
(121, 41, 9, 14000, 1, 14000),
(122, 41, 12, 14000, 4, 56000),
(123, 42, 2, 12000, 1, 12000),
(124, 42, 3, 12000, 1, 12000),
(125, 42, 8, 14000, 1, 14000),
(126, 42, 39, 5000, 1, 5000),
(127, 42, 44, 8000, 1, 8000),
(128, 42, 54, 10000, 1, 10000),
(129, 42, 55, 10000, 1, 10000),
(130, 43, 7, 14000, 4, 56000),
(131, 44, 2, 12000, 1, 12000),
(132, 44, 3, 12000, 1, 12000),
(133, 45, 2, 12000, 1, 12000),
(134, 45, 3, 12000, 1, 12000),
(135, 45, 4, 12000, 1, 12000),
(136, 46, 51, 8000, 1, 8000),
(137, 46, 52, 10000, 1, 10000),
(138, 46, 53, 18000, 1, 18000),
(139, 46, 54, 10000, 1, 10000),
(140, 47, 3, 12000, 1, 12000),
(141, 47, 4, 12000, 1, 12000),
(142, 47, 5, 12000, 1, 12000),
(143, 47, 10, 14000, 1, 14000),
(144, 48, 3, 12000, 2, 24000),
(145, 49, 3, 12000, 2, 24000),
(146, 50, 2, 12000, 2, 24000),
(147, 50, 8, 14000, 1, 14000),
(148, 51, 2, 12000, 1, 12000),
(149, 51, 3, 12000, 1, 12000),
(150, 52, 55, 10000, 2, 20000),
(151, 52, 11, 14000, 3, 42000),
(152, 52, 7, 14000, 1, 14000),
(153, 53, 2, 12000, 1, 12000),
(154, 53, 3, 12000, 1, 12000),
(155, 53, 4, 12000, 1, 12000),
(156, 53, 8, 14000, 1, 14000),
(157, 54, 1, 10000, 1, 10000),
(158, 54, 2, 12000, 1, 12000),
(159, 54, 3, 12000, 1, 12000),
(160, 54, 4, 12000, 1, 12000),
(161, 54, 5, 12000, 1, 12000),
(162, 55, 2, 12000, 1, 12000),
(163, 55, 7, 14000, 1, 14000),
(164, 55, 51, 8000, 1, 8000),
(165, 55, 52, 10000, 1, 10000),
(166, 56, 1, 10000, 1, 10000),
(167, 56, 2, 12000, 1, 12000),
(168, 56, 3, 12000, 1, 12000),
(169, 56, 7, 14000, 1, 14000),
(170, 57, 57, 15000, 1, 15000),
(171, 57, 50, 8000, 1, 8000),
(172, 57, 1, 10000, 1, 10000),
(173, 58, 2, 12000, 1, 12000),
(174, 59, 1, 10000, 1, 10000),
(175, 60, 1, 10000, 3, 30000),
(176, 60, 2, 12000, 8, 96000),
(177, 60, 3, 12000, 2, 24000),
(178, 60, 5, 12000, 2, 24000),
(179, 60, 7, 14000, 3, 42000),
(180, 61, 3, 12000, 1, 12000),
(181, 61, 4, 12000, 1, 12000),
(182, 61, 5, 12000, 1, 12000),
(183, 61, 11, 14000, 1, 14000),
(184, 61, 1, 10000, 1, 10000),
(185, 62, 29, 12000, 1, 12000),
(186, 63, 1, 10000, 1, 10000),
(187, 63, 2, 12000, 1, 12000),
(188, 63, 3, 12000, 1, 12000),
(189, 63, 4, 12000, 1, 12000);

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
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_pesanan_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

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
