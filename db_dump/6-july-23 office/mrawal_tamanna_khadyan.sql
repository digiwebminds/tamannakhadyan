-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2023 at 06:47 PM
-- Server version: 8.0.32-24
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mrawal_tamanna_khadyan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `id` int NOT NULL,
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
  `deleted` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `dor`, `sname`, `name`, `fname`, `address`, `city`, `phone`, `photo`, `gname`, `gfname`, `gaddress`, `gcity`, `gphone`, `gphoto`, `documents`, `username`, `password`, `deleted`) VALUES
(2, '2023-05-24', 'asdasdas', 'sadsadad', 'sadasdasd', 'asdasda', 'asdasd', '+91 asdadasdasdas', '../uploaded/ayye-pyaari-samajh-gayi-aunty-meme-template.jpg', 'sdadsa', 'asdasdasdas', 'asdasdasd', 'asdasd', '+91 asdasdasd', '../uploaded/42fhq0.jpg', 'asdasdsa', 'asdasd', 'asdasd', 0),
(3, '2023-05-25', 'Developer Chai Wala', 'Digvijay Singh Bisht', 'Manmohan Singh Bisht', 'Village Quitter, Post Office Quitter', 'Pithoragarh', '+919315121086', '../uploaded/DSC_0600.jpg', 'Chetan Soun', 'Laxman Singh Soun', 'Near Nanda Devi Farms', 'Dehradun', '+91 7465076129', '../uploaded/Snapchat-255001790.jpg', 'Aadhaar Card, PAN Card', 'vickysoun', 'vickysoun', 0),
(13, '2023-05-25', '', 'yuiyuiuyi', 'yiuyuiyui', 'iyuiyuiyui', 'yuiyuiyui', '+91 iuuyiyuiyuiyu', '../uploaded/IMG_20200924_170909.jpg', '', '', '', '', '+91 ', NULL, 'yuiyuiyui', 'yuiyuiyui', 'yuiyuiyui', 1),
(16, '2023-05-27', 'gfhgfhfghfghf', 'werewrwer', 'rwerwerwe', 'werwerwer', 'werwerwe', '1231231231', '', 'qweqweqw', 'qweqwe', 'wqeqwewq', 'qweqweqw', '4564564564', '../uploaded/IMG_20221030_201512_copy_223x274.jpg', 'hfhfgh', 'asdasdasd', 'asdasd', 1),
(17, '2023-05-27', 'hjkhjkjkjh', 'vbnvbn', 'vbnvbnn', 'vbnvbnvbnvb', 'vbnbvnvbn', '7897897897', '', 'hjkhjk', 'hjkhjkhjk', 'hjkhjkh', 'hjkhjkhj', '', '../uploaded/photo.jpg', '', 'hjkhjkhjk', 'hjkhjk', 0),
(18, '2023-05-30', 'vxcvxcvcxvxcv', 'qweqweqwe', 'qwewqeqe', 'weqeqweqwe', 'qwewqeq', '1234567890', '', 'asdadasdas', 'asdasdasdas', 'adasdsasdsa', 'asdadasdsad', '9876543210', '../uploaded/Remini20220301231854438.jpg', 'xcvxvxcvcxvcx', 'niharika', 'niharika', 0),
(19, '2023-06-08', 'eyg', 'mohit', 'rawaywdf', 'hwgdyu', 'jqgfyu', '7623762337', '../uploaded/Modern Digital Marketing Agency Instagram Post.png', 'g34yg', 'weufyg', 'uweg', 'weug', '0987678787', '', 'erg', 'hwegy', 'Mohit@123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `principle` int NOT NULL,
  `comment` varchar(256) NOT NULL,
  `dor` date NOT NULL,
  `loan_type` int NOT NULL COMMENT '1=cc,2=daily,3=weekly,4=monthly',
  `installment` int NOT NULL COMMENT 'calculated from roi',
  `roi` int NOT NULL COMMENT 'not using, just for calculation',
  `total` varchar(256) DEFAULT NULL,
  `days_weeks_month` int DEFAULT NULL,
  `ldol` date NOT NULL,
  `latefine` varchar(256) DEFAULT NULL,
  `latefineafter` varchar(256) DEFAULT NULL,
  `timestamp` varchar(256) NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1=active,0=closed',
  `delete_status` int NOT NULL DEFAULT '0' COMMENT '0=not deleted,1=deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `principle`, `comment`, `dor`, `loan_type`, `installment`, `roi`, `total`, `days_weeks_month`, `ldol`, `latefine`, `latefineafter`, `timestamp`, `status`, `delete_status`) VALUES
(31, 3, 10000, 'daily loan', '2023-06-17', 2, 100, 0, '10000', 100, '0000-00-00', NULL, NULL, '1686990208', 1, 0),
(32, 19, 20000, '', '2023-06-17', 3, 220, 0, '22000', 100, '0000-00-00', NULL, NULL, '1686990244', 1, 0),
(33, 2, 50000, 'yess', '2023-06-17', 4, 5000, 0, '60000', 12, '0000-00-00', NULL, NULL, '1686990282', 1, 0),
(34, 3, 500, '', '2023-06-17', 2, 60, 0, '600', 10, '0000-00-00', NULL, NULL, '1686990933', 1, 0),
(35, 19, 1500, '', '2023-06-17', 1, 30, 2, NULL, NULL, '0000-00-00', NULL, NULL, '1686991558', 1, 0),
(36, 19, 10000, '', '2023-06-01', 2, 110, 0, '11000', 100, '2023-09-09', '50', '3', '1687074648', 1, 1),
(37, 19, 10000, '', '2023-05-01', 1, 100, 1, NULL, NULL, '0000-00-00', '20', '7', '1687681465', 1, 0),
(38, 19, 1000, '', '2023-06-01', 1, 10, 1, NULL, NULL, '0000-00-00', '10', '10', '1688233170', 1, 0),
(39, 19, 5000, 'heyyyyy', '2023-06-23', 2, 200, 0, '6000', 30, '2023-07-23', '30', '7', '1688233282', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `principle_repayment`
--

CREATE TABLE `principle_repayment` (
  `id` int NOT NULL,
  `loan_id` int NOT NULL,
  `dorepayment` date NOT NULL,
  `repay_amount` varchar(256) NOT NULL,
  `comment_prirepay` varchar(256) NOT NULL,
  `info` int DEFAULT NULL COMMENT '0 = repay, 1=lend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `principle_repayment`
--

INSERT INTO `principle_repayment` (`id`, `loan_id`, `dorepayment`, `repay_amount`, `comment_prirepay`, `info`) VALUES
(8, 35, '2023-06-19', '100', '', NULL),
(9, 35, '2023-06-22', '-500', 'khgy', NULL),
(10, 35, '2023-06-24', '200', 'bs aise hi', NULL),
(16, 37, '2023-06-23', '-1000', 'new loan', 1),
(17, 37, '2023-06-09', '2500', '', 0),
(18, 38, '2023-06-02', '-10', '', NULL),
(19, 38, '2023-06-03', '-10', '', NULL),
(20, 38, '2023-06-04', '-10', '', NULL),
(21, 38, '2023-06-05', '-10', '', NULL),
(22, 38, '2023-06-06', '-10', '', NULL),
(23, 38, '2023-06-07', '-10', '', NULL),
(24, 38, '2023-06-08', '-10', '', NULL),
(25, 38, '2023-06-09', '-10', '', NULL),
(26, 38, '2023-06-10', '-10', '', NULL),
(27, 38, '2023-06-11', '-10', '', NULL),
(28, 38, '2023-06-12', '-10', '', NULL),
(29, 38, '2023-06-13', '-10', '', NULL),
(30, 38, '2023-06-14', '-10', '', NULL),
(31, 38, '2023-06-15', '-10', '', NULL),
(32, 38, '2023-06-16', '-10', '', NULL),
(33, 38, '2023-06-17', '-10', '', NULL),
(34, 38, '2023-06-18', '-10', '', NULL),
(35, 38, '2023-06-19', '-10', '', NULL),
(36, 38, '2023-06-20', '-10', '', NULL),
(37, 38, '2023-06-21', '-10', '', NULL),
(38, 38, '2023-06-22', '-10', '', NULL),
(39, 38, '2023-06-23', '-10', '', NULL),
(40, 38, '2023-06-24', '-10', '', NULL),
(41, 38, '2023-06-25', '-10', '', NULL),
(42, 38, '2023-06-26', '-10', '', NULL),
(43, 38, '2023-06-27', '-10', '', NULL),
(44, 38, '2023-06-28', '-10', '', NULL),
(45, 38, '2023-06-29', '-10', '', NULL),
(46, 38, '2023-06-30', '-10', '', NULL),
(47, 38, '2023-07-01', '-10', '', NULL),
(48, 38, '2023-07-02', '-10', '', NULL),
(49, 38, '2023-07-03', '-10', '', NULL),
(50, 38, '2023-07-04', '-10', '', NULL),
(51, 38, '2023-07-05', '-10', '', NULL),
(52, 38, '2023-07-06', '-10', '', NULL),
(53, 35, '2023-06-20', '0', '', NULL),
(54, 35, '2023-06-21', '0', '', NULL),
(55, 35, '2023-06-23', '0', '', NULL),
(56, 35, '2023-06-25', '0', '', NULL),
(57, 35, '2023-06-26', '0', '', NULL),
(58, 35, '2023-06-27', '0', '', NULL),
(59, 35, '2023-06-28', '0', '', NULL),
(60, 35, '2023-06-29', '0', '', NULL),
(61, 35, '2023-06-30', '0', '', NULL),
(62, 35, '2023-07-01', '0', '', NULL),
(63, 35, '2023-07-02', '0', '', NULL),
(64, 35, '2023-07-03', '0', '', NULL),
(65, 35, '2023-07-04', '0', '', NULL),
(66, 35, '2023-07-05', '0', '', NULL),
(67, 35, '2023-07-06', '0', '', NULL),
(68, 37, '2023-05-11', '-20', '', NULL),
(69, 37, '2023-05-12', '-20', '', NULL),
(70, 37, '2023-05-13', '-20', '', NULL),
(71, 37, '2023-05-14', '-20', '', NULL),
(72, 37, '2023-05-15', '-20', '', NULL),
(73, 37, '2023-05-16', '-20', '', NULL),
(74, 37, '2023-05-17', '-20', '', NULL),
(75, 37, '2023-05-18', '-20', '', NULL),
(76, 37, '2023-05-19', '-20', '', NULL),
(77, 37, '2023-05-28', '-20', '', NULL),
(78, 37, '2023-05-29', '-20', '', NULL),
(79, 37, '2023-05-30', '-20', '', NULL),
(80, 37, '2023-05-31', '-20', '', NULL),
(81, 37, '2023-06-01', '-20', '', NULL),
(82, 37, '2023-06-02', '-20', '', NULL),
(83, 37, '2023-06-03', '-20', '', NULL),
(84, 37, '2023-06-04', '-20', '', NULL),
(85, 37, '2023-06-05', '-20', '', NULL),
(86, 37, '2023-06-06', '-20', '', NULL),
(87, 37, '2023-06-07', '-20', '', NULL),
(88, 37, '2023-06-08', '-20', '', NULL),
(89, 37, '2023-06-10', '-20', '', NULL),
(90, 37, '2023-06-11', '-20', '', NULL),
(91, 37, '2023-06-12', '-20', '', NULL),
(92, 37, '2023-06-13', '-20', '', NULL),
(93, 37, '2023-06-14', '-20', '', NULL),
(94, 37, '2023-06-15', '-20', '', NULL),
(95, 37, '2023-06-16', '-20', '', NULL),
(96, 37, '2023-06-17', '-20', '', NULL),
(97, 37, '2023-06-18', '-20', '', NULL),
(98, 37, '2023-06-19', '-20', '', NULL),
(99, 37, '2023-06-20', '-20', '', NULL),
(100, 37, '2023-06-21', '-20', '', NULL),
(101, 37, '2023-06-22', '-20', '', NULL),
(102, 37, '2023-06-24', '-20', '', NULL),
(103, 37, '2023-06-25', '-20', '', NULL),
(104, 37, '2023-06-26', '-20', '', NULL),
(105, 37, '2023-06-27', '-20', '', NULL),
(106, 37, '2023-06-28', '-20', '', NULL),
(107, 37, '2023-06-29', '-20', '', NULL),
(108, 37, '2023-06-30', '-20', '', NULL),
(109, 37, '2023-07-01', '-20', '', NULL),
(110, 37, '2023-07-02', '-20', '', NULL),
(111, 37, '2023-07-03', '-20', '', NULL),
(112, 37, '2023-07-04', '-20', '', NULL),
(113, 37, '2023-07-05', '-20', '', NULL),
(114, 37, '2023-07-06', '-20', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `repayment`
--

CREATE TABLE `repayment` (
  `id` int NOT NULL,
  `loan_id` int NOT NULL,
  `DORepayment` date NOT NULL,
  `installment_amount` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_repay` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(49, 35, '2023-06-18', 28, '2023-06-20 17:53:53', 'nitesh'),
(50, 37, '2023-05-06', 100, '2023-06-25 08:25:26', ''),
(52, 37, '2023-05-10', 100, '2023-06-29 05:00:58', ''),
(53, 37, '2023-05-20', 85, '2023-06-29 06:11:23', ''),
(54, 37, '2023-05-27', 85, '2023-06-29 06:16:35', ''),
(55, 39, '2023-06-28', 400, '2023-07-01 17:42:25', 'bhwqdw');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `salary` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  `emptype` int NOT NULL COMMENT '0=staff,1=manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `fname`, `address`, `phone`, `photo`, `salary`, `username`, `password`, `deleted`, `emptype`) VALUES
(1, 'Gurudaas', 'Gurudaas Ke Papaji', 'Sonipat ya Panipat m khi', '9899561383', '../uploaded/WIN_20230612_19_42_13_Pro.jpg', '20000', 'guru', 'Guru@121', 1, 0),
(2, 'Sanjog Kumar', 'Sanjog ke PapaJi', 'Mandhawali ke Paas khi Faridabad ke side m', '7678521307', '../uploaded/WIN_20230612_14_53_44_Pro.jpg', '18500', 'sanjog', 'Sanjog@121', 1, 0),
(4, 'asda', 'asdasd', 'asdad', 'asdas', '', 'adsa', 'asdas', 'asda', 1, 0),
(5, 'mohit', 'sushil Rawal', 'VPO KOhand', '7015626838', '../uploaded/Screenshot from 2023-05-23 13-24-47.png', '25000', 'mohitt', '12321', 1, 0),
(6, 'digvijay.bi', 'sushil Rawal', 'VPO KOhand', '7015626838', '../uploaded/Screenshot from 2023-06-12 15-17-18.png', '25000', '423432', '12321', 1, 1),
(7, 'mohit', 'sushil Rawal', 'VPO KOhand', '7015626838', '../uploaded/Screenshot from 2023-06-12 17-20-48.png', '25000', 'mohit', '12321', 0, 0);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `principle_repayment`
--
ALTER TABLE `principle_repayment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `repayment`
--
ALTER TABLE `repayment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
