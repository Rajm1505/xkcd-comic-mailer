-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2023 at 06:33 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rtcampdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jobid` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `verification_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `email`, `jobid`, `is_active`, `verification_code`) VALUES
(39, 'rajm150503@gmail.com', 4209409, 1, '5d65fce721d76f8d1473de5b64598ff7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
