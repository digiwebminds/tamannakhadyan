-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2023 at 06:10 PM
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
)

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
  `ldol` date DEFAULT NULL,
  `timestamp` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `principle`, `comment`, `dor`, `loan_type`, `installment`, `roi`, `total`, `days_weeks_month`, `ldol`, `timestamp`) VALUES
(2, 3, 1000, 'kbhweyf', '2023-05-28', 1, 0, 10, NULL, NULL, NULL, '2023-05-28 22:17:34'),
(3, 3, 1000, 'this is comment\r\n', '2023-05-28', 1, 100, 10, NULL, NULL, NULL, '2023-05-28 22:38:42'),
(4, 2, 10000, 'daily 1%', '2023-05-28', 1, 100, 1, NULL, NULL, NULL, '2023-05-28 22:48:09'),
(5, 3, 1000, 'bjwy', '2023-05-28', 1, 100, 10, NULL, NULL, NULL, '2023-05-28 22:54:36'),
(6, 3, 1000, 'bjwy', '2023-05-28', 1, 100, 10, NULL, NULL, NULL, '2023-05-28 22:58:00'),
(7, 2, 10000, 'gqwygyw', '2023-05-28', 1, 1000, 10, NULL, NULL, NULL, '2023-05-28 23:00:09'),
(8, 17, 100000, 'daily 1000 inr', '2023-05-12', 1, 1000, 1, NULL, NULL, NULL, '2023-05-29 23:06:26'),
(9, 18, 50000, 'daily 500 inr', '2023-05-09', 1, 500, 1, NULL, NULL, NULL, '2023-05-29 23:07:15'),
(12, 2, 10000, '', '2023-06-01', 2, 100, 1, '13000', NULL, NULL, '1686070599'),
(13, 3, 100, '', '2023-06-07', 2, 1, 1, '110', 10, NULL, '1686156559'),
(14, 3, 1000, '', '2023-06-07', 3, 100, 10, '1400', 4, NULL, '1686157146'),
(15, 3, 10000, '', '2023-06-07', 4, 500, 5, '16000', 12, NULL, '1686157189'),
(16, 3, 100, '', '2023-06-08', 2, 34, 1, '103', 3, '2023-06-11', '1686247085'),
(17, 3, 100, '', '2023-06-07', 2, 34, 1, '103', 3, '2023-06-10', '1686247188');

-- --------------------------------------------------------

--
-- Table structure for table `principle_repayment`
--

CREATE TABLE `principle_repayment` (
  `id` int NOT NULL,
  `loan_id` int NOT NULL,
  `dorepayment` date NOT NULL,
  `repay_amount` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `principle_repayment`
--

INSERT INTO `principle_repayment` (`id`, `loan_id`, `dorepayment`, `repay_amount`) VALUES
(1, 9, '2023-06-01', '1000'),
(2, 9, '2023-06-04', '1000'),
(3, 9, '2023-06-01', '100'),
(4, 9, '2023-06-02', '1000'),
(5, 9, '2023-06-01', '500'),
(6, 11, '2023-06-02', '2000'),
(7, 9, '2023-06-01', '10000');

-- --------------------------------------------------------

--
-- Table structure for table `repayment`
--

CREATE TABLE `repayment` (
  `id` int NOT NULL,
  `loan_id` int NOT NULL,
  `DORepayment` date NOT NULL,
  `installment_amount` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `repayment`
--

INSERT INTO `repayment` (`id`, `loan_id`, `DORepayment`, `installment_amount`, `timestamp`) VALUES
(1, 9, '2023-05-25', 500, '2023-05-31 10:25:03'),
(2, 9, '2023-05-25', 500, '2023-05-31 10:25:05'),
(3, 9, '2023-05-21', 500, '2023-05-31 10:32:21'),
(4, 9, '2023-05-02', 500, '2023-05-31 10:32:45'),
(5, 9, '2023-05-20', 500, '2023-05-31 11:09:12'),
(6, 9, '2023-05-18', 500, '2023-05-31 11:09:42'),
(7, 9, '2023-05-10', 500, '2023-05-31 14:21:51'),
(8, 9, '2023-05-18', 500, '2023-05-31 14:22:07'),
(9, 9, '2023-05-18', 500, '2023-05-31 14:22:09'),
(10, 9, '2023-05-18', 500, '2023-05-31 14:22:09'),
(11, 9, '2023-06-07', 500, '2023-05-31 14:27:16'),
(12, 9, '2023-06-17', 500, '2023-05-31 14:28:28'),
(13, 9, '2023-06-16', 500, '2023-05-31 15:01:44'),
(14, 9, '2023-05-04', 500, '2023-05-31 15:02:11'),
(15, 9, '2023-06-04', 500, '2023-06-01 11:59:31'),
(16, 8, '2023-06-06', 1000, '2023-06-06 10:38:42'),
(17, 8, '2023-06-06', 1000, '2023-06-06 10:38:43'),
(18, 9, '2023-06-09', 500, '2023-06-06 11:21:54'),
(19, 9, '2023-06-09', 500, '2023-06-06 11:21:55'),
(20, 9, '2023-06-03', 500, '2023-06-06 11:39:50'),
(25, 9, '2023-06-10', 500, '2023-06-06 12:58:02'),
(27, 9, '2023-06-01', 500, '2023-06-06 13:10:36'),
(32, 9, '2023-06-08', 500, '2023-06-07 12:24:18'),
(33, 9, '2023-06-07', 500, '2023-06-07 12:27:53'),
(34, 9, '2023-06-03', 500, '2023-06-07 12:59:23'),
(35, 9, '2023-06-01', 364, '2023-06-08 12:08:15'),
(36, 9, '2023-06-01', 364, '2023-06-08 12:23:02'),
(37, 17, '2023-06-08', 34, '2023-06-08 12:39:50');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `principle_repayment`
--
ALTER TABLE `principle_repayment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `repayment`
--
ALTER TABLE `repayment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
