-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2025 at 03:25 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `role`, `email`, `mobile`, `status`) VALUES
(1, 'Nabin', 'admin', 0, '', '', 1),
(6, 'Bishal', 'ok123', 1, 'bishal@gmail.com', '9810989811', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `heading1` varchar(255) NOT NULL,
  `heading2` varchar(255) NOT NULL,
  `btn_txt` varchar(255) DEFAULT NULL,
  `btn_link` varchar(55) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `order_no` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `heading1`, `heading2`, `btn_txt`, `btn_link`, `image`, `order_no`, `status`) VALUES
(2, 'Collection 2024', 'Embrace Music', '', '', '586796925_musical-instruments.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories`, `status`) VALUES
(2, 'Companies', 1),
(9, 'Categories', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(75) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `comment` text NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `mobile`, `comment`, `added_on`) VALUES
(10, 'Nabin', 'ok@gmail.com', '981191911', 'ok xa t a', '2024-06-22 11:25:39'),
(11, 'Bishal', 'Bishwakarmab046@Gmail.Com', '91819191', 'awesome', '2024-07-20 12:16:31'),
(12, 'Sahil', 'sahil@gmial.com', '9812345677', 'Message sent', '2024-07-21 06:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(11) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `total_price` float NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `order_status` int(11) NOT NULL,
  `txnid` varchar(20) NOT NULL,
  `esewa_txnid` varchar(20) NOT NULL,
  `esewa_status` varchar(20) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user_id`, `address`, `city`, `pincode`, `payment_type`, `total_price`, `payment_status`, `order_status`, `txnid`, `esewa_txnid`, `esewa_status`, `added_on`) VALUES
(70, 10, 'basundhara', 'Kathmandu', 7881, 'cod', 1239, 'pending', 1, 'f291ae5b06c242a0aee3', '', '', '2024-07-15 04:32:28'),
(71, 10, 'kalanki', 'Kathmandu', 2020, 'cod', 1239, 'Success', 5, '72f9eb615c3d59ce2236', '', '', '2024-07-22 06:56:06'),
(72, 10, 'Dolakha', 'Krihca', 91, 'esewa', 1239, 'pending', 1, '882fbc662dd1ecdb625b', '', '', '2025-01-25 02:35:42'),
(73, 10, 'Nepal-Bagmati-Kathmandu-Thapathali', 'Krihca', 23233, 'esewa', 1239, 'pending', 1, '9acdfad97999a1cd4965', '', '', '2025-01-27 03:07:32'),
(74, 10, 'Nepal-Bagmati-Kathmandu-Thapathali', 'Krihca', 23233, 'esewa', 1239, 'pending', 1, '2c9aad8be5d50862a8fd', '', '', '2025-01-27 03:17:53'),
(75, 10, 'jhabskj', 'sSsS', 90019, 'esewa', 0, 'pending', 1, '86a06bc0735e32eb50bb', '', '', '2025-01-27 03:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 12, 1, 100),
(2, 1, 10, 1, 10),
(3, 2, 13, 1, 150),
(4, 2, 12, 1, 100),
(5, 3, 6, 1, 1500),
(6, 4, 11, 2, 50),
(7, 6, 1, 1, 8499),
(8, 7, 1, 1, 8499),
(9, 8, 1, 1, 5),
(10, 10, 1, 1, 5),
(11, 11, 1, 1, 5),
(12, 12, 1, 1, 5),
(13, 14, 1, 1, 5),
(14, 15, 1, 1, 5),
(15, 16, 1, 1, 5),
(16, 17, 1, 1, 5),
(17, 18, 1, 1, 5),
(18, 19, 1, 1, 5),
(19, 20, 1, 1, 5),
(20, 21, 1, 1, 5),
(21, 22, 1, 1, 5),
(22, 23, 1, 1, 5),
(23, 24, 1, 1, 5),
(24, 25, 1, 1, 5),
(25, 26, 1, 1, 8999),
(26, 27, 19, 1, 7500),
(27, 27, 21, 1, 19000),
(28, 28, 20, 1, 17000),
(29, 29, 21, 1, 19000),
(30, 30, 21, 1, 19000),
(31, 31, 21, 1, 19000),
(32, 32, 21, 1, 19000),
(33, 33, 21, 1, 19000),
(34, 34, 20, 1, 17000),
(35, 35, 20, 1, 17000),
(36, 36, 20, 1, 17000),
(37, 37, 20, 1, 17000),
(38, 38, 20, 1, 17000),
(39, 39, 20, 1, 17000),
(40, 40, 20, 1, 17000),
(41, 41, 20, 1, 17000),
(42, 42, 21, 1, 19000),
(43, 43, 21, 1, 19000),
(44, 44, 20, 1, 17000),
(45, 45, 20, 1, 17000),
(46, 46, 20, 1, 17000),
(47, 47, 20, 1, 17000),
(48, 48, 19, 1, 7500),
(49, 49, 19, 1, 7500),
(50, 50, 21, 1, 19000),
(51, 51, 21, 1, 19000),
(52, 52, 21, 1, 19000),
(53, 53, 21, 4, 19000),
(54, 54, 21, 2, 19000),
(55, 55, 20, 1, 17000),
(56, 56, 21, 1, 19000),
(57, 57, 21, 1, 19000),
(58, 58, 21, 1, 19000),
(59, 59, 21, 1, 19000),
(60, 60, 21, 4, 19000),
(61, 61, 21, 1, 19000),
(62, 62, 21, 1, 19000),
(63, 63, 20, 3, 17000),
(64, 64, 21, 1, 19000),
(65, 65, 21, 1, 19000),
(66, 66, 21, 4, 19000),
(67, 67, 21, 1, 19000),
(68, 68, 21, 1, 19000),
(69, 69, 21, 3, 19000),
(70, 70, 21, 1, 1239),
(71, 71, 21, 1, 1239),
(72, 72, 20, 2, 0),
(73, 72, 21, 1, 1239),
(74, 73, 21, 1, 1239),
(75, 74, 21, 1, 1239),
(76, 75, 20, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(4, 'Canceled'),
(5, 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mrp` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `short_desc` varchar(2000) NOT NULL,
  `description` text NOT NULL,
  `best_seller` int(11) NOT NULL,
  `meta_title` varchar(2000) NOT NULL,
  `meta_desc` varchar(2000) NOT NULL,
  `meta_keyword` varchar(2000) NOT NULL,
  `added_by` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `categories_id`, `sub_categories_id`, `name`, `mrp`, `price`, `qty`, `image`, `short_desc`, `description`, `best_seller`, `meta_title`, `meta_desc`, `meta_keyword`, `added_by`, `status`) VALUES
(11, 9, 0, 'Mantra Karma 3 Band Equalizer with Tuner (Natural)', 'Rs10000', 0.00, 10, '426118845_1.jpg', 'Mantra Karma 3 Band Equalizer with Tuner (Natural)', 'Mantra Karma 3 Band Equalizer with Tuner (Natural)', 0, 'Mantra Karma 3 Band Equalizer with Tuner (Natural)', 'Mantra Karma 3 Band Equalizer with Tuner (Natural)', 'Mantra Karma 3 Band Equalizer with Tuner (Natural)', 0, 1),
(17, 9, 0, 'Mantra Acoustic Guitar Karma Non-EQ (Black)', 'Rs12000', 0.00, 10, '451587907_2.jpg', 'Mantra Acoustic Guitar Karma Non-EQ (Black)', 'Mantra Acoustic Guitar Karma Non-EQ (Black)', 0, 'Mantra Acoustic Guitar Karma Non-EQ (Black)', 'Mantra Acoustic Guitar Karma Non-EQ (Black)', 'Mantra Acoustic Guitar Karma Non-EQ (Black)', 1, 1),
(18, 9, 0, 'Mantra Acoustic Guitar Prakriti Non-EQ', 'Rs15000', 0.00, 5, '824263553_3.jpg', 'Mantra Acoustic Guitar Prakriti Non-EQ', 'Mantra Acoustic Guitar Prakriti Non-EQ', 0, 'Mantra Acoustic Guitar Prakriti Non-EQ', 'Mantra Acoustic Guitar Prakriti Non-EQ', 'Mantra Acoustic Guitar Prakriti Non-EQ', 1, 1),
(19, 9, 0, 'Mantra Acoustic Guitar Karma Non-EQ (Blue)', 'Rs8000', 0.00, 2, '715699699_4.jpg', 'Mantra Acoustic Guitar Karma Non-EQ (Blue)', 'Mantra Acoustic Guitar Karma Non-EQ (Blue)', 0, 'Mantra Acoustic Guitar Karma Non-EQ (Blue)', 'Mantra Acoustic Guitar Karma Non-EQ (Blue)', 'Mantra Acoustic Guitar Karma Non-EQ (Blue)', 1, 1),
(20, 9, 0, 'Mantra Semi Acoustic Guitar Moksha', 'Rs18000', 0.00, 6, '911053495_5.jpg', 'Mantra Semi Acoustic Guitar Moksha', 'Mantra Semi Acoustic Guitar Moksha', 1, 'Mantra Semi Acoustic Guitar Moksha', 'Mantra Semi Acoustic Guitar Moksha', 'Mantra Semi Acoustic Guitar Moksha', 1, 1),
(21, 9, 0, 'Mantra Avatar', '1200', 1239.00, 10, '551384845_6.jpg', 'Mantra Avatar', 'Mantra Avatar', 1, 'Mantra Avatar', 'Mantra Avatar', 'Mantra Avatar', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_images` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `product_images`) VALUES
(1, 8, '479197953_526258680_Floral-Print-Polo-T-shirt1.jpg'),
(2, 8, '301120849_309027777_Floral-Print-Polo-T-shirt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `categories_id`, `sub_categories`, `status`) VALUES
(4, 9, 'Acoustic Guitar', 1),
(5, 9, 'Electric Guitar', 1),
(6, 9, 'Bass Guitar', 1),
(7, 9, 'Ukelele', 1),
(8, 9, 'Drums', 1),
(9, 9, 'Keyboards', 1),
(10, 9, 'More', 1),
(11, 2, 'Mantra', 1),
(12, 2, 'Yamaha', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` int(40) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `mobile`, `added_on`) VALUES
(5, 'dileep', 'dileep123', 'dileepkushwaha2222@gmail.com', 0, '2024-06-19 02:11:35'),
(6, 'bishal', 'bishal123', 'bishwakarmab046@gmail.com', 0, '2024-06-26 03:19:09'),
(7, 'anil stha', 'AsTheGoat1011#$', 'sthaanill.2059@gmail.com', 0, '2024-06-26 03:26:36'),
(8, 'mukesh', 'mukesh123', 'chymukesh5@gmail.com', 0, '2024-07-20 12:22:45'),
(10, 'Nabin', 'ok123', 'nabdabop10@gmail.com', 0, '2024-07-21 06:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `added_on`) VALUES
(1, 1, 12, '2021-04-08 01:53:31'),
(4, 4, 21, '2024-07-20 02:41:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
