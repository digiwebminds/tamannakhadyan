-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2023 at 08:48 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tamanna_khadyan`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) NOT NULL,
  `dor` varchar(20) DEFAULT NULL,
  `sname` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gname` varchar(100) DEFAULT NULL,
  `gfname` varchar(100) DEFAULT NULL,
  `gaddress` varchar(255) DEFAULT NULL,
  `gcity` varchar(255) DEFAULT NULL,
  `gphone` varchar(100) DEFAULT NULL,
  `gphoto` varchar(255) DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='List of all Customers';

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `dor`, `sname`, `name`, `fname`, `address`, `city`, `phone`, `photo`, `gname`, `gfname`, `gaddress`, `gcity`, `gphone`, `gphoto`, `documents`, `username`, `password`) VALUES
(2, '2023-05-24', 'asdasdas', 'sadsadad', 'sadasdasd', 'asdasda', 'asdasd', '+91 asdadasdasdas', '../uploaded/ayye-pyaari-samajh-gayi-aunty-meme-template.jpg', 'sdadsa', 'asdasdasdas', 'asdasdasd', 'asdasd', '+91 asdasdasd', '../uploaded/42fhq0.jpg', 'asdasdsa', 'asdasd', 'asdasd'),
(3, '2023-05-25', 'Developer Chai Wala', 'Digvijay Singh Bisht', 'Manmohan Singh Bisht', 'Village Quitter, Post Office Quitter', 'Pithoragarh', '+919315121086', '../uploaded/DSC_0600.jpg', 'Chetan Soun', 'Laxman Singh Soun', 'Near Nanda Devi Farms', 'Dehradun', '+91 7465076129', '../uploaded/Snapchat-255001790.jpg', 'Aadhaar Card, PAN Card', 'vickysoun', 'vickysoun'),
(13, '2023-05-25', '', 'yuiyuiuyi', 'yiuyuiyui', 'iyuiyuiyui', 'yuiyuiyui', '+91 iuuyiyuiyuiyu', '../uploaded/IMG_20200924_170909.jpg', '', '', '', '', '+91 ', '', 'yuiyuiyui', 'yuiyuiyui', 'yuiyuiyui');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
