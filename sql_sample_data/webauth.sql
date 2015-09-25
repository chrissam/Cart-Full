-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2015 at 05:16 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webauth`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE IF NOT EXISTS `product_list` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `price` varchar(16) COLLATE latin1_general_ci NOT NULL,
  `details` text COLLATE latin1_general_ci NOT NULL,
  `category` varchar(16) COLLATE latin1_general_ci NOT NULL,
  `subcategory` varchar(16) COLLATE latin1_general_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `sellerid` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `product_name`, `price`, `details`, `category`, `subcategory`, `date_added`, `sellerid`) VALUES
(1, 'T-Shirt', '100', 'Polo T-Shirt Size-XL Red Color', 'Clothing', 'T-Shirt', '2015-09-17 00:45:09', 'chrissam'),
(2, 'Polo Pant', '150', 'Black Pant from Polo - 32cm', 'Clothing', 'Trousers', '2015-09-17 01:00:00', 'chrissam'),
(3, 'Shirt', '150', 'Formal Shirt from Arrow - Black Color', 'Clothing', 'Shirt', '2015-09-17 01:03:00', 'check'),
(4, 'KHI Men''s Checkered Ankle Length Socks(Pack of 5)', '25', 'Red Socks - Size - Small', 'Clothing', 'Accessories', '2015-09-18 00:13:00', 'chrissam'),
(5, 'Zacharias Men''s Striped Ankle Length Socks(Pack of 5)', '175', 'Men''s Striped Ankle Length Socks(Pack of 5)', 'Cothing', 'Accessories', '2015-09-18 01:00:00', 'chrissam'),
(6, 'KHI Men''s Checkered Footie Socks', '300', 'KHI Men''s Checkered Footie Socks', 'Clothing', 'Accessories', '2015-09-18 02:08:00', 'chrissam'),
(7, 'Little''s Junior Ring', '167', 'Little''s Junior Ring - Toys for boys', 'Toys', 'Toys for boys', '2015-09-18 05:00:00', 'chrissam'),
(8, 'Funskool Rubiks Cube', '365', 'Funskool Rubiks Cube for kids', 'Toys', 'Toys for Boys', '2015-09-18 05:00:00', 'chrissam'),
(9, 'Mattel UNO Fast Fun for Everyone', '125', 'Mattel UNO Fast Fun for Everyone', 'Toys', 'Toys for boys', '2015-09-18 03:00:00', 'chrissam'),
(10, 'Bburago Star Lamborghini Sesto Elemento', '931', 'Bburago Star Lamborghini Sesto Elemento', 'Toys', 'Toys for Boys', '2015-09-18 08:00:00', 'chrissam'),
(11, '\r\nDurian Berry Leatherette 2 Seater Sofa\r\n', '21300', '\r\nDurian Berry Leatherette 2 Seater Sofa\r\n(Finish Color - BLACK, Upholstery Color - BLACK) ', 'Furniture', 'Sofa', '2015-09-18 05:12:00', 'chrissam'),
(12, '\r\nhometown Alexander Leather 2 Seater Sofa\r\n', '113000', '\r\nhometown Alexander Leather 2 Seater Sofa\r\n(Finish Color - Brown, Upholstery Color - Brown) ', 'Furniture', 'Sofa', '2015-09-18 11:00:00', 'chrissam');

-- --------------------------------------------------------

--
-- Table structure for table `user_authentication`
--

CREATE TABLE IF NOT EXISTS `user_authentication` (
  `sellerid` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `FirstName` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `Gender` enum('M','F') COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user_authentication`
--

INSERT INTO `user_authentication` (`sellerid`, `FirstName`, `LastName`, `password`, `Email`, `Gender`) VALUES
('check', 'Check', 'Check', '0ba4439ee9a46d9d9f14c60f88f45f87', 'check@check.com', 'M'),
('chrissam', 'Chris', 'Sam', '04c73ef7aa19bba31cba829132c2b5f9', '', 'M'),
('success', 'Name', 'name', 'b068931cc450442b63f5b3d276ea4297', 'name@name.com', 'M'),
('test', 'testfirstname', 'testlastname', '098f6bcd4621d373cade4e832627b4f6', 'test@gmail.com', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `user_pwd`
--

CREATE TABLE IF NOT EXISTS `user_pwd` (
  `name` char(30) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `pass` char(32) COLLATE latin1_general_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `user_pwd`
--

INSERT INTO `user_pwd` (`name`, `pass`) VALUES
('xampp', 'wampp');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_name` (`product_name`);

--
-- Indexes for table `user_authentication`
--
ALTER TABLE `user_authentication`
  ADD PRIMARY KEY (`sellerid`),
  ADD UNIQUE KEY `id` (`sellerid`);

--
-- Indexes for table `user_pwd`
--
ALTER TABLE `user_pwd`
  ADD PRIMARY KEY (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
