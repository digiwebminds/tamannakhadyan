-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2023 at 09:29 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'Admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
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
  `password` varchar(50) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `dor`, `sname`, `name`, `fname`, `address`, `city`, `phone`, `photo`, `gname`, `gfname`, `gaddress`, `gcity`, `gphone`, `gphoto`, `documents`, `username`, `password`, `deleted`) VALUES
(2, '2023-05-24', 'asdasdas', 'sadsadad', 'sadasdasd', 'asdasda', 'asdasd', '+91 asdadasdasdas', '../uploaded/ayye-pyaari-samajh-gayi-aunty-meme-template.jpg', 'sdadsa', 'asdasdasdas', 'asdasdasd', 'asdasd', '+91 asdasdasd', '../uploaded/42fhq0.jpg', 'asdasdsa', 'asdasd', 'asdasd', 0),
(3, '2023-05-25', 'Developer Chai Wala', 'Digvijay Singh Bisht', 'Manmohan Singh Bisht', 'Village Quitter, Post Office Quitter', 'Pithoragarh', '+919315121086', '../uploaded/DSC_0600.jpg', 'Chetan Soun', 'Laxman Singh Soun', 'Near Nanda Devi Farms', 'Dehradun', '+91 7465076129', '../uploaded/Snapchat-255001790.jpg', 'Aadhaar Card, PAN Card', 'vickysoun', 'vickysoun', 0),
(13, '2023-05-25', '', 'yuiyuiuyi', 'yiuyuiyui', 'iyuiyuiyui', 'yuiyuiyui', '+91 iuuyiyuiyuiyu', '../uploaded/IMG_20200924_170909.jpg', '', '', '', '', '+91 ', NULL, 'yuiyuiyui', 'yuiyuiyui', 'yuiyuiyui', 1),
(16, '2023-05-27', 'gfhgfhfghfghf', 'werewrwer', 'rwerwerwe', 'werwerwer', 'werwerwe', '1231231231', '', 'qweqweqw', 'qweqwe', 'wqeqwewq', 'qweqweqw', '4564564564', '../uploaded/IMG_20221030_201512_copy_223x274.jpg', 'hfhfgh', 'asdasdasd', 'asdasd', 0),
(17, '2023-05-27', 'hjkhjkjkjh', 'vbnvbn', 'vbnvbnn', 'vbnvbnvbnvb', 'vbnbvnvbn', '7897897897', '', 'hjkhjk', 'hjkhjkhjk', 'hjkhjkh', 'hjkhjkhj', '', '../uploaded/photo.jpg', '', 'hjkhjkhjk', 'hjkhjk', 0),
(18, '2023-05-30', 'vxcvxcvcxvxcv', 'qweqweqwe', 'qwewqeqe', 'weqeqweqwe', 'qwewqeq', '1234567890', '', 'asdadasdas', 'asdasdasdas', 'adasdsasdsa', 'asdadasdsad', '9876543210', '../uploaded/Remini20220301231854438.jpg', 'xcvxvxcvcxvcx', 'niharika', 'niharika', 0),
(19, '2023-06-08', 'eyg', 'mohit', 'rawaywdf', 'hwgdyu', 'jqgfyu', '7623762337', '../uploaded/Modern Digital Marketing Agency Instagram Post.png', 'g34yg', 'weufyg', 'uweg', 'weug', '0987678787', '', 'erg', 'hwegy', 'Mohit@123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `principle` int(11) NOT NULL,
  `comment` varchar(256) NOT NULL,
  `dor` date NOT NULL,
  `loan_type` int(11) NOT NULL COMMENT '1=cc,2=daily,3=weekly,4=monthly',
  `installment` int(11) NOT NULL COMMENT 'calculated from roi',
  `roi` int(11) NOT NULL COMMENT 'not using, just for calculation',
  `total` varchar(256) DEFAULT NULL,
  `days_weeks_month` int(11) DEFAULT NULL,
  `ldol` date NOT NULL,
  `timestamp` varchar(256) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1=active,0=closed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `principle`, `comment`, `dor`, `loan_type`, `installment`, `roi`, `total`, `days_weeks_month`, `ldol`, `timestamp`, `status`) VALUES
(31, 3, 10000, 'daily loan', '2023-06-17', 2, 100, 0, '10000', 100, '0000-00-00', '1686990208', 1),
(32, 19, 20000, '', '2023-06-17', 3, 220, 0, '22000', 100, '0000-00-00', '1686990244', 1),
(33, 2, 50000, 'yess', '2023-06-17', 4, 5000, 0, '60000', 12, '0000-00-00', '1686990282', 1),
(34, 3, 500, '', '2023-06-17', 2, 60, 0, '600', 10, '0000-00-00', '1686990933', 1),
(35, 19, 1500, '', '2023-06-17', 1, 30, 2, NULL, NULL, '0000-00-00', '1686991558', 1),
(36, 19, 10000, '', '2023-06-01', 2, 110, 0, '11000', 100, '2023-09-09', '1687074648', 1);

-- --------------------------------------------------------

--
-- Table structure for table `principle_repayment`
--

CREATE TABLE `principle_repayment` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `dorepayment` date NOT NULL,
  `repay_amount` varchar(256) NOT NULL,
  `comment_prirepay` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `principle_repayment`
--

INSERT INTO `principle_repayment` (`id`, `loan_id`, `dorepayment`, `repay_amount`, `comment_prirepay`) VALUES
(8, 35, '2023-06-17', '100', '');

-- --------------------------------------------------------

--
-- Table structure for table `repayment`
--

CREATE TABLE `repayment` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `DORepayment` date NOT NULL,
  `installment_amount` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment_repay` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repayment`
--

INSERT INTO `repayment` (`id`, `loan_id`, `DORepayment`, `installment_amount`, `timestamp`, `comment_repay`) VALUES
(1, 9, '2023-05-25', 500, '2023-05-31 04:55:03', ''),
(2, 9, '2023-05-25', 500, '2023-05-31 04:55:05', ''),
(3, 9, '2023-05-21', 500, '2023-05-31 05:02:21', ''),
(4, 9, '2023-05-02', 500, '2023-05-31 05:02:45', ''),
(5, 9, '2023-05-20', 500, '2023-05-31 05:39:12', ''),
(6, 9, '2023-05-18', 500, '2023-05-31 05:39:42', ''),
(7, 9, '2023-05-10', 500, '2023-05-31 08:51:51', ''),
(8, 9, '2023-05-18', 500, '2023-05-31 08:52:07', ''),
(9, 9, '2023-05-18', 500, '2023-05-31 08:52:09', ''),
(10, 9, '2023-05-18', 500, '2023-05-31 08:52:09', ''),
(11, 9, '2023-06-07', 500, '2023-05-31 08:57:16', ''),
(12, 9, '2023-06-17', 500, '2023-05-31 08:58:28', ''),
(13, 9, '2023-06-16', 500, '2023-05-31 09:31:44', ''),
(14, 9, '2023-05-04', 500, '2023-05-31 09:32:11', ''),
(15, 9, '2023-06-04', 500, '2023-06-01 06:29:31', ''),
(16, 8, '2023-06-06', 1000, '2023-06-06 05:08:42', ''),
(17, 8, '2023-06-06', 1000, '2023-06-06 05:08:43', ''),
(18, 9, '2023-06-09', 500, '2023-06-06 05:51:54', ''),
(19, 9, '2023-06-09', 500, '2023-06-06 05:51:55', ''),
(20, 9, '2023-06-03', 500, '2023-06-06 06:09:50', ''),
(25, 9, '2023-06-10', 500, '2023-06-06 07:28:02', ''),
(27, 9, '2023-06-01', 500, '2023-06-06 07:40:36', ''),
(32, 9, '2023-06-08', 500, '2023-06-07 06:54:18', ''),
(33, 9, '2023-06-07', 500, '2023-06-07 06:57:53', ''),
(34, 9, '2023-06-03', 500, '2023-06-07 07:29:23', ''),
(35, 9, '2023-06-01', 364, '2023-06-08 06:38:15', ''),
(36, 9, '2023-06-01', 364, '2023-06-08 06:53:02', ''),
(37, 17, '2023-06-08', 34, '2023-06-08 07:09:50', ''),
(40, 12, '2023-06-11', 100, '2023-06-11 14:38:42', ''),
(41, 9, '2023-06-11', 364, '2023-06-11 15:47:41', ''),
(42, 16, '2023-06-11', 34, '2023-06-11 15:49:57', ''),
(43, 9, '2023-06-12', 364, '2023-06-12 15:17:13', ''),
(44, 12, '2023-06-02', 100, '2023-06-12 15:27:19', ''),
(45, 12, '2023-06-03', 100, '2023-06-12 15:27:28', ''),
(46, 33, '2023-06-17', 5000, '2023-06-17 09:15:12', 'yeash biii'),
(47, 36, '2023-06-02', 110, '2023-06-18 08:00:56', ''),
(48, 36, '2023-06-03', 110, '2023-06-18 08:01:03', ''),
(49, 35, '2023-06-18', 28, '2023-06-20 17:53:53', 'nitesh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `principle_repayment`
--
ALTER TABLE `principle_repayment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repayment`
--
ALTER TABLE `repayment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `principle_repayment`
--
ALTER TABLE `principle_repayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `repayment`
--
ALTER TABLE `repayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
