-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 07:05 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

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
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(256) NOT NULL,
  `principle` int(10) NOT NULL,
  `comment` varchar(256) NOT NULL,
  `dor` date NOT NULL,
  `loan_type` int(20) NOT NULL COMMENT '1=cc,2=daily,3=weekly,4=monthly',
  `installment` int(10) NOT NULL COMMENT 'calculated from roi',
  `roi` int(10) NOT NULL COMMENT 'not using, just for calculation',
  `total` varchar(256) DEFAULT NULL,
  `days-weeks-month` int(10) DEFAULT NULL,
  `timestamp` varchar(256) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `customer_name`, `principle`, `comment`, `dor`, `loan_type`, `installment`, `roi`, `total`, `days-weeks-month`, `timestamp`) VALUES
(2, 3, 'Digvijay Singh Bisht', 1000, 'kbhweyf', '2023-05-28', 1, 0, 10, NULL, NULL, '2023-05-28 22:17:34'),
(3, 3, 'Digvijay Singh Bisht', 1000, 'this is comment\r\n', '2023-05-28', 1, 100, 10, NULL, NULL, '2023-05-28 22:38:42'),
(4, 2, 'sadsadad', 10000, 'daily 1%', '2023-05-28', 1, 100, 1, NULL, NULL, '2023-05-28 22:48:09'),
(5, 3, 'Digvijay Singh Bisht', 1000, 'bjwy', '2023-05-28', 1, 100, 10, NULL, NULL, '2023-05-28 22:54:36'),
(6, 3, 'Digvijay Singh Bisht', 1000, 'bjwy', '2023-05-28', 1, 100, 10, NULL, NULL, '2023-05-28 22:58:00'),
(7, 2, 'sadsadad', 10000, 'gqwygyw', '2023-05-28', 1, 1000, 10, NULL, NULL, '2023-05-28 23:00:09'),
(8, 17, 'Mohit', 100000, 'daily 1000 inr', '2023-05-12', 1, 1000, 1, NULL, NULL, '2023-05-29 23:06:26'),
(9, 18, 'gurudass', 50000, 'daily 500 inr', '2023-05-09', 1, 500, 1, NULL, NULL, '2023-05-29 23:07:15'),
(12, 2, 'sadsadad', 10000, '', '2023-06-01', 2, 100, 1, '13000', NULL, '1686070599'),
(13, 3, 'Digvijay Singh Bisht', 100, '', '2023-06-07', 2, 1, 1, '110', 10, '1686156559'),
(14, 3, 'Digvijay Singh Bisht', 1000, '', '2023-06-07', 3, 100, 10, '1400', 4, '1686157146'),
(15, 3, 'Digvijay Singh Bisht', 10000, '', '2023-06-07', 4, 500, 5, '16000', 12, '1686157189');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
