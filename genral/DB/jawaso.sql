-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Nov 2024 pada 06.12
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jawaso`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertProduct` (IN `p_image` TEXT, IN `p_image2` TEXT, IN `p_image3` TEXT, IN `p_title` VARCHAR(50), IN `p_descriptions` VARCHAR(255), IN `p_price` INT, IN `p_categoryId` INT, IN `p_stok` INT)   BEGIN
    INSERT INTO product (image, image2, image3, title, descriptions, price, categoryId, stok)
    VALUES (p_image, p_image2, p_image3, p_title, p_descriptions, p_price, p_categoryId, p_stok);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(12) NOT NULL,
  `roles` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `roles`) VALUES
(1, 'admin', 'admin@gmail.com', '123', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog`
--

CREATE TABLE `blog` (
  `blogId` int(11) NOT NULL,
  `message` text NOT NULL,
  `time_blog` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `customerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `blog`
--

INSERT INTO `blog` (`blogId`, `message`, `time_blog`, `customerId`) VALUES
(1, 'Produk JAWASO apik apik. JOSS pokoke.', '2024-11-01 05:05:01', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Dekorasi Pernikahan'),
(2, 'Dekorasi Ulang Tahun');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chekout`
--

CREATE TABLE `chekout` (
  `order_Id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `chekout`
--

INSERT INTO `chekout` (`order_Id`, `product_name`, `price`, `quantity`) VALUES
(1, 'Kue Ulang Tahun', 100000, 1),
(33, 'Bunga Pernikahan', 200000, 1),
(33, 'Undangan', 50000, 1),
(33, 'Dekorasi Ulang Tahun', 50000, 1),
(34, 'Boneka', 100000, 1),
(34, 'Kue Ulang Tahun', 100000, 2),
(35, 'Bunga Pernikahan', 200000, 1),
(36, 'Boneka', 100000, 1),
(37, 'Dekorasi Ulang Tahun', 50000, 3),
(38, 'Kue Ulang Tahun', 100000, 1),
(39, 'Kue Ulang Tahun', 100000, 1),
(40, 'Boneka', 100000, 1),
(41, 'Dekorasi Ulang Tahun', 50000, 1),
(42, 'Kue Ulang Tahun', 100000, 1),
(43, 'Kue Ulang Tahun', 100000, 1),
(43, 'Bunga Pernikahan', 200000, 1),
(43, 'Dekorasi Ulang Tahun', 50000, 1),
(43, 'Undangan', 50000, 1),
(44, 'Boneka', 100000, 1);

--
-- Trigger `chekout`
--
DELIMITER $$
CREATE TRIGGER `after_checkout_insert` AFTER INSERT ON `chekout` FOR EACH ROW BEGIN
    -- Mengurangi stok produk berdasarkan product_name yang di-checkout
    UPDATE product 
    SET stok = stok - NEW.quantity
    WHERE title = NEW.product_name;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `comment_blog`
--

CREATE TABLE `comment_blog` (
  `id_comment` int(11) NOT NULL,
  `comment` text NOT NULL,
  `customer_Id` int(11) NOT NULL,
  `blog_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(12) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(256) NOT NULL,
  `image_user` text DEFAULT 'pp.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `phone`, `address`, `image_user`) VALUES
(1, 'Dimas', 'Dimas@gmail.com', '1234', '01234567891', 'Bumiayu Brebes', 'pp.png'),
(8, 'Test123', 'Test123@gmail.com', '1235', '12345678910', 'Test', 'pp.png'),
(9, 'Test123', 'Test1234@gmail.com', '1234', '123412512412', 'Test', 'pp.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `quantity` int(1) NOT NULL DEFAULT 1,
  `customerId` int(11) NOT NULL,
  `productId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_manager`
--

CREATE TABLE `order_manager` (
  `order_Id` int(11) NOT NULL,
  `name_customer` varchar(20) NOT NULL,
  `phone_customer` varchar(11) NOT NULL,
  `address_customer` varchar(20) NOT NULL,
  `sumTotal` int(11) NOT NULL,
  `payment_method` enum('pay cash','Qris','master card') NOT NULL DEFAULT 'pay cash',
  `order_status` enum('OnProcess','Ready','Shipping','Shipped') NOT NULL DEFAULT 'OnProcess',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `order_manager`
--

INSERT INTO `order_manager` (`order_Id`, `name_customer`, `phone_customer`, `address_customer`, `sumTotal`, `payment_method`, `order_status`, `order_date`) VALUES
(1, 'Dimas', '01234567891', 'Bumiayu', 100000, 'pay cash', 'Ready', '2024-11-01 05:00:00'),
(33, 'Test123', '12341251241', 'Test', 300000, '', 'OnProcess', '2024-11-01 09:59:05'),
(34, 'Dimas', '01234567891', 'Bumiayu', 300000, '', 'OnProcess', '2024-11-01 10:06:58'),
(35, 'Test123', '12345678910', 'Test', 200000, 'pay cash', 'OnProcess', '2024-11-01 10:12:03'),
(36, 'Dimas', '01234567891', 'Bumiayu', 100000, 'pay cash', 'OnProcess', '2024-11-01 10:15:06'),
(37, 'Dimas', '01234567891', 'Bumiayu', 150000, '', 'OnProcess', '2024-11-01 10:26:18'),
(38, 'Dimas', '01234567891', 'Bumiayu', 100000, '', 'OnProcess', '2024-11-01 10:30:24'),
(39, 'Dimas', '01234567891', 'Bumiayu', 100000, 'Qris', 'OnProcess', '2024-11-01 10:35:19'),
(40, 'Dimas', '01234567891', 'Bumiayu', 100000, 'pay cash', 'OnProcess', '2024-11-01 10:37:11'),
(41, 'Dimas', '01234567891', 'Bumiayu', 50000, 'master card', 'OnProcess', '2024-11-01 10:37:34'),
(42, 'Dimas', '01234567891', 'Bumiayu', 100000, 'Qris', 'OnProcess', '2024-11-01 10:39:15'),
(43, 'Dimas', '01234567891', 'Bumiayu Brebes', 400000, 'Qris', 'Shipped', '2024-11-02 12:13:15'),
(44, 'Dimas', '01234567891', 'Bumiayu Brebes', 100000, 'master card', 'OnProcess', '2024-11-02 14:42:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `image2` text NOT NULL,
  `image3` text NOT NULL,
  `title` varchar(50) NOT NULL,
  `descriptions` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id`, `image`, `image2`, `image3`, `title`, `descriptions`, `price`, `categoryId`, `stok`) VALUES
(1, '1.jpg', '1.jpg', '1.jpg', 'Kue Ulang Tahun', 'Kue Ulang Tahun bisa custom atau sudah jadi.', 100000, 2, 93),
(2, '2.jpg', '2.jpg', '2.jpg', 'Bunga Pernikahan', 'Bunga Artifisial yang di custom sesuai kebutuhan customer.', 200000, 1, 96),
(3, '3.jpg', '3.jpg', '3.jpg', 'Dekorasi Ulang Tahun', 'Paket Dekorasi Ulang Tahun per 10 pcs.', 50000, 2, 93),
(4, '4.jpg', '4.jpg', '4.jpg', 'Undangan', 'Paket Undangan Pernikahan per 50 pcs.', 50000, 1, 97),
(5, '6.jpg', '6.jpg', '6.jpg', 'Boneka', 'Boneka untuk kado ulang tahun.', 100000, 2, 95);

-- --------------------------------------------------------

--
-- Struktur dari tabel `view_product_details`
--

CREATE TABLE `view_product_details` (
  `categoryName` varchar(25) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blogId`),
  ADD KEY `customerId` (`customerId`);

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `chekout`
--
ALTER TABLE `chekout`
  ADD KEY `order_Id` (`order_Id`);

--
-- Indeks untuk tabel `comment_blog`
--
ALTER TABLE `comment_blog`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `blog_Id` (`blog_Id`),
  ADD KEY `customer_Id` (`customer_Id`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerId` (`customerId`),
  ADD KEY `productId` (`productId`);

--
-- Indeks untuk tabel `order_manager`
--
ALTER TABLE `order_manager`
  ADD PRIMARY KEY (`order_Id`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryId` (`categoryId`),
  ADD KEY `idx_title` (`title`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `blog`
--
ALTER TABLE `blog`
  MODIFY `blogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `comment_blog`
--
ALTER TABLE `comment_blog`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `order_manager`
--
ALTER TABLE `order_manager`
  MODIFY `order_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chekout`
--
ALTER TABLE `chekout`
  ADD CONSTRAINT `chekout_ibfk_1` FOREIGN KEY (`order_Id`) REFERENCES `order_manager` (`order_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `comment_blog`
--
ALTER TABLE `comment_blog`
  ADD CONSTRAINT `comment_blog_ibfk_1` FOREIGN KEY (`customer_Id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_blog_ibfk_2` FOREIGN KEY (`blog_Id`) REFERENCES `blog` (`blogId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`customerId`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
