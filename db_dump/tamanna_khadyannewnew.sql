-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2023 at 08:13 PM
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
  `password` varchar(50) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='List of all Customers';

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
  `days_weeks_month` int(10) DEFAULT NULL,
  `timestamp` varchar(256) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `customer_name`, `principle`, `comment`, `dor`, `loan_type`, `installment`, `roi`, `total`, `days_weeks_month`, `timestamp`) VALUES
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
(15, 3, 'Digvijay Singh Bisht', 10000, '', '2023-06-07', 4, 500, 5, '16000', 12, '1686157189'),
(16, 3, 'Digvijay Singh Bisht', 100, '', '2023-06-08', 2, 34, 1, '103', 3, '1686247085'),
(17, 3, 'Digvijay Singh Bisht', 100, '', '2023-06-08', 2, 34, 1, '103', 3, '1686247188');

-- --------------------------------------------------------

--
-- Table structure for table `principle_repayment`
--

CREATE TABLE `principle_repayment` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `dorepayment` date NOT NULL,
  `repay_amount` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `DORepayment` date NOT NULL,
  `installment_amount` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repayment`
--

INSERT INTO `repayment` (`id`, `loan_id`, `DORepayment`, `installment_amount`, `timestamp`) VALUES
(1, 9, '2023-05-25', 500, '2023-05-31 15:55:03'),
(2, 9, '2023-05-25', 500, '2023-05-31 15:55:05'),
(3, 9, '2023-05-21', 500, '2023-05-31 16:02:21'),
(4, 9, '2023-05-02', 500, '2023-05-31 16:02:45'),
(5, 9, '2023-05-20', 500, '2023-05-31 16:39:12'),
(6, 9, '2023-05-18', 500, '2023-05-31 16:39:42'),
(7, 9, '2023-05-10', 500, '2023-05-31 19:51:51'),
(8, 9, '2023-05-18', 500, '2023-05-31 19:52:07'),
(9, 9, '2023-05-18', 500, '2023-05-31 19:52:09'),
(10, 9, '2023-05-18', 500, '2023-05-31 19:52:09'),
(11, 9, '2023-06-07', 500, '2023-05-31 19:57:16'),
(12, 9, '2023-06-17', 500, '2023-05-31 19:58:28'),
(13, 9, '2023-06-16', 500, '2023-05-31 20:31:44'),
(14, 9, '2023-05-04', 500, '2023-05-31 20:32:11'),
(15, 9, '2023-06-04', 500, '2023-06-01 17:29:31'),
(16, 8, '2023-06-06', 1000, '2023-06-06 16:08:42'),
(17, 8, '2023-06-06', 1000, '2023-06-06 16:08:43'),
(18, 9, '2023-06-09', 500, '2023-06-06 16:51:54'),
(19, 9, '2023-06-09', 500, '2023-06-06 16:51:55'),
(20, 9, '2023-06-03', 500, '2023-06-06 17:09:50'),
(21, 12, '2023-06-05', 100, '2023-06-06 17:10:10'),
(22, 12, '2023-06-01', 100, '2023-06-06 17:29:42'),
(23, 9, '0000-00-00', 500, '2023-06-06 18:24:46'),
(24, 9, '0000-00-00', 500, '2023-06-06 18:27:57'),
(25, 9, '2023-06-10', 500, '2023-06-06 18:28:02'),
(26, 9, '0000-00-00', 500, '2023-06-06 18:29:03'),
(27, 9, '2023-06-01', 500, '2023-06-06 18:40:36'),
(28, 12, '0000-00-00', 100, '2023-06-06 18:43:11'),
(29, 12, '0000-00-00', 100, '2023-06-06 18:43:11'),
(30, 12, '0000-00-00', 100, '2023-06-06 18:43:12'),
(31, 12, '0000-00-00', 100, '2023-06-06 18:43:13'),
(32, 9, '2023-06-08', 500, '2023-06-07 17:54:18'),
(33, 9, '2023-06-07', 500, '2023-06-07 17:57:53'),
(34, 9, '2023-06-03', 500, '2023-06-07 18:29:23'),
(35, 9, '2023-06-01', 364, '2023-06-08 17:38:15'),
(36, 9, '2023-06-01', 364, '2023-06-08 17:53:02'),
(37, 17, '2023-06-02', 34, '2023-06-08 18:09:50'),
(38, 17, '2023-06-02', 34, '2023-06-08 18:09:51'),
(39, 17, '2023-06-02', 34, '2023-06-08 18:09:51');

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `principle_repayment`
--
ALTER TABLE `principle_repayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `repayment`
--
ALTER TABLE `repayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
