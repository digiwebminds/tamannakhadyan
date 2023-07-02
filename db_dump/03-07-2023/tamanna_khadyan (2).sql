-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2023 at 11:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(19, '2023-06-09', 'eyg', 'Mohit Rawal', 'Mohit ke papaji', 'Sonipat Pannipat m khi', 'Pta nhi', '7623762337', '../uploaded/Modern Digital Marketing Agency Instagram Post.png', 'Ankit', 'Ankit ke papa', 'Mohit ke ghr ke paas', 'Mohit ki city', '9876787872', '', 'erg', 'hwegy', 'Mohit@123', 0),
(20, '2023-06-28', 'bmnb', 'jkkhj', 'm,nm,nn', 'hgjgg', 'jbgjhg', 'bjhk', '', 'jhkhkj', 'kj', '', '', 'jkj', '', 'jkj', NULL, NULL, 1);

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
  `ldol` date DEFAULT NULL,
  `latefine` varchar(256) DEFAULT NULL,
  `latefineafter` varchar(256) DEFAULT NULL,
  `timestamp` varchar(256) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1=active,0=closed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `principle`, `comment`, `dor`, `loan_type`, `installment`, `roi`, `total`, `days_weeks_month`, `ldol`, `latefine`, `latefineafter`, `timestamp`, `status`) VALUES
(31, 3, 10000, 'daily loan', '2023-06-17', 2, 100, 0, '10000', 100, '0000-00-00', NULL, NULL, '1686990208', 1),
(32, 19, 20000, '', '2023-06-17', 3, 220, 0, '22000', 100, '0000-00-00', NULL, NULL, '1686990244', 1),
(33, 2, 50000, 'yess', '2023-06-17', 4, 5000, 0, '60000', 12, '0000-00-00', NULL, NULL, '1686990282', 1),
(34, 3, 500, '', '2023-06-17', 2, 60, 0, '600', 10, '0000-00-00', NULL, NULL, '1686990933', 1),
(35, 19, 1500, '', '2023-06-17', 1, 30, 2, NULL, NULL, '0000-00-00', NULL, NULL, '1686991558', 1),
(36, 19, 10000, '', '2023-06-01', 2, 110, 0, '11000', 100, '2023-09-09', '50', '3', '1687074648', 1),
(37, 19, 10000, '', '2023-05-01', 1, 100, 1, NULL, NULL, '0000-00-00', '20', '7', '1687681465', 1),
(38, 3, 10000, 'Pese lauta do wrna shraap lgega...', '2023-06-30', 4, 1200, 0, '12000', 10, '2024-04-25', '100', '3', '1688069855', 1),
(39, 19, 5000, 'Moj le', '2023-06-30', 1, 100, 2, NULL, NULL, '0000-00-00', '100', '30', '1688069965', 1),
(40, 19, 100000, 'Pese nhi diye to gaadi jabt krli jaegi', '2023-06-30', 1, 10000, 10, NULL, NULL, NULL, '1000', '30', '1688070075', 1),
(41, 3, 1000, 'Yeah boi', '2023-07-03', 3, 200, 0, '2000', 10, '2023-09-11', '100', '5', '1688332705', 1),
(42, 19, 10000, 'Jldi de diyo', '2023-07-03', 4, 1100, 0, '11000', 10, '2024-04-28', '500', '5', '1688333209', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `principle_repayment`
--

INSERT INTO `principle_repayment` (`id`, `loan_id`, `dorepayment`, `repay_amount`, `comment_prirepay`) VALUES
(8, 35, '2023-06-19', '100', ''),
(9, 35, '2023-06-22', '-500', 'khgy'),
(10, 35, '2023-06-24', '200', 'bs aise hi');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `repayment`
--

INSERT INTO `repayment` (`id`, `loan_id`, `DORepayment`, `installment_amount`, `timestamp`, `comment_repay`) VALUES
(1, 9, '2023-05-25', 500, '2023-05-30 23:25:03', ''),
(2, 9, '2023-05-25', 500, '2023-05-30 23:25:05', ''),
(3, 9, '2023-05-21', 500, '2023-05-30 23:32:21', ''),
(4, 9, '2023-05-02', 500, '2023-05-30 23:32:45', ''),
(5, 9, '2023-05-20', 500, '2023-05-31 00:09:12', ''),
(6, 9, '2023-05-18', 500, '2023-05-31 00:09:42', ''),
(7, 9, '2023-05-10', 500, '2023-05-31 03:21:51', ''),
(8, 9, '2023-05-18', 500, '2023-05-31 03:22:07', ''),
(9, 9, '2023-05-18', 500, '2023-05-31 03:22:09', ''),
(10, 9, '2023-05-18', 500, '2023-05-31 03:22:09', ''),
(11, 9, '2023-06-07', 500, '2023-05-31 03:27:16', ''),
(12, 9, '2023-06-17', 500, '2023-05-31 03:28:28', ''),
(13, 9, '2023-06-16', 500, '2023-05-31 04:01:44', ''),
(14, 9, '2023-05-04', 500, '2023-05-31 04:02:11', ''),
(15, 9, '2023-06-04', 500, '2023-06-01 00:59:31', ''),
(16, 8, '2023-06-06', 1000, '2023-06-05 23:38:42', ''),
(17, 8, '2023-06-06', 1000, '2023-06-05 23:38:43', ''),
(18, 9, '2023-06-09', 500, '2023-06-06 00:21:54', ''),
(19, 9, '2023-06-09', 500, '2023-06-06 00:21:55', ''),
(20, 9, '2023-06-03', 500, '2023-06-06 00:39:50', ''),
(25, 9, '2023-06-10', 500, '2023-06-06 01:58:02', ''),
(27, 9, '2023-06-01', 500, '2023-06-06 02:10:36', ''),
(32, 9, '2023-06-08', 500, '2023-06-07 01:24:18', ''),
(33, 9, '2023-06-07', 500, '2023-06-07 01:27:53', ''),
(34, 9, '2023-06-03', 500, '2023-06-07 01:59:23', ''),
(35, 9, '2023-06-01', 364, '2023-06-08 01:08:15', ''),
(36, 9, '2023-06-01', 364, '2023-06-08 01:23:02', ''),
(37, 17, '2023-06-08', 34, '2023-06-08 01:39:50', ''),
(40, 12, '2023-06-11', 100, '2023-06-11 09:08:42', ''),
(41, 9, '2023-06-11', 364, '2023-06-11 10:17:41', ''),
(42, 16, '2023-06-11', 34, '2023-06-11 10:19:57', ''),
(43, 9, '2023-06-12', 364, '2023-06-12 09:47:13', ''),
(44, 12, '2023-06-02', 100, '2023-06-12 09:57:19', ''),
(45, 12, '2023-06-03', 100, '2023-06-12 09:57:28', ''),
(46, 33, '2023-06-17', 5000, '2023-06-17 03:45:12', 'yeash biii'),
(47, 36, '2023-06-02', 110, '2023-06-18 02:30:56', ''),
(48, 36, '2023-06-03', 110, '2023-06-18 02:31:03', ''),
(49, 35, '2023-06-18', 28, '2023-06-20 12:23:53', 'nitesh'),
(50, 37, '2023-05-10', 100, '2023-06-25 02:55:26', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `salary` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `fname`, `address`, `phone`, `photo`, `salary`, `username`, `password`, `deleted`) VALUES
(1, 'Gurudaas', 'Gurudaas Ke Papaji', 'Sonipat ya Panipat m khi', '9899561383', '../uploaded/WIN_20230612_19_42_13_Pro.jpg', '20000', 'guru', 'Guru@121', 0),
(2, 'Sanjog Kumar', 'Sanjog ke PapaJi', 'Mandhawali ke Paas khi Faridabad ke side m', '7678521307', '../uploaded/WIN_20230612_14_53_44_Pro.jpg', '18500', 'sanjog', 'Sanjog@121', 0),
(4, 'asda', 'asda ke papaji', 'asdad', 'asdas', '', 'adsa', 'asdasd', 'asdasd', 0);

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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `principle_repayment`
--
ALTER TABLE `principle_repayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `repayment`
--
ALTER TABLE `repayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
