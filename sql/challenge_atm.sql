-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2018 at 10:20 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `challenge_atm`
--
CREATE DATABASE IF NOT EXISTS `challenge_atm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `challenge_atm`;

-- --------------------------------------------------------

--
-- Table structure for table `banknotes`
--

CREATE TABLE `banknotes` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `deposit` int(11) NOT NULL DEFAULT '0',
  `withdraw` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banknotes`
--

INSERT INTO `banknotes` (`id`, `code`, `name`, `deposit`, `withdraw`) VALUES
(1, '20', '20฿', 1000, 0),
(2, '50', '50฿', 1000, 0),
(3, '100', '100฿', 1000, 0),
(4, '500', '500฿', 1000, 0),
(5, '1000', '1000฿', 1000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `log_withdraw`
--

CREATE TABLE `log_withdraw` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banknotes`
--
ALTER TABLE `banknotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_withdraw`
--
ALTER TABLE `log_withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banknotes`
--
ALTER TABLE `banknotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `log_withdraw`
--
ALTER TABLE `log_withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
