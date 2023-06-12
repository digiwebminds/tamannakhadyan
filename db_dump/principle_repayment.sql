-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2023 at 06:25 PM
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
-- Database: `tamanna_khadyan`
--

-- --------------------------------------------------------

--
-- Table structure for table `principle_repayment`
--

CREATE TABLE `principle_repayment` (
  `id` int NOT NULL,
  `loan_id` int NOT NULL,
  `dorepayment` date NOT NULL,
  `repay_amount` varchar(256) NOT NULL
)

--
-- Dumping data for table `principle_repayment`
--

INSERT INTO `principle_repayment` (`id`, `loan_id`, `dorepayment`, `repay_amount`) VALUES
(1, 9, '2023-06-01', '1000'),
(2, 9, '2023-06-04', '1000'),
(3, 9, '2023-06-01', '100'),
(4, 9, '2023-06-02', '1000'),
(5, 9, '2023-06-01', '500'),
(6, 11, '2023-06-02', '2000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `principle_repayment`
--
ALTER TABLE `principle_repayment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `principle_repayment`
--
ALTER TABLE `principle_repayment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
