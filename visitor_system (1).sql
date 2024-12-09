-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 09:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `condo_visitor_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$B98kiPC9YNsMFK6mR1SlM.2euJ0emaa35570zwtiRK7a4OpscJCzG');

-- --------------------------------------------------------

--
-- Table structure for table `qr_codes`
--

CREATE TABLE `qr_codes` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) DEFAULT NULL,
  `qr_code` text NOT NULL,
  `generated_at` datetime NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qr_codes`
--

INSERT INTO `qr_codes` (`id`, `visitor_id`, `qr_code`, `generated_at`, `expires_at`) VALUES
(19, 23, 'CHEN SHAO XI_20240902', '2024-09-02 08:42:51', '2024-09-03 00:00:00'),
(20, 24, 'Ali_20240923', '2024-09-23 08:57:11', '2024-09-24 00:00:00'),
(21, 25, 'Chin Chuang_20240930', '2024-09-30 14:29:47', '2024-10-01 00:00:00'),
(22, 26, 'Richie Chah_20241204', '2024-12-04 09:35:22', '2024-12-05 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `unit`, `phone`) VALUES
(3, 'CHEN SHAO XI', 'shaoxi97@outlook.com', '$2y$10$ho0t/mpsn61UIQtiKu0E4.bS.eJFTo8lY9qn4OLGhaJg0BFiSP6jC', '9', '0164237177'),
(4, 'Chahlize', 'ritchie121600@gmail.com', '$2y$10$6TSv5VsIkOcl8altpniqH.1YppkSpl/B6Ha93rnRpA27ilAYbgNf2', '48', '0124478218'),
(5, 'sy', 'sy123@gmail.com', '$2y$10$VLuR4ysksNdGd1qo3G.iDOqUEkYrWZshNIgT3PQG8jixkw5/szHXC', '49', '1234567890'),
(6, 'Richie Chah', 'lize1234@gmail.com', '$2y$10$k5.sjV3S0Q8BeJ1dXtMMZ.QEz0jew7Zfa79aQWwv4b2DewRyomsEu', '88', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `IC` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `visitor_code` varchar(255) NOT NULL,
  `qr_code` text DEFAULT NULL,
  `visit_date` date NOT NULL,
  `status` enum('pending','approved','rejected','checked_in') DEFAULT 'pending',
  `owner_id` int(11) DEFAULT NULL,
  `valid_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `name`, `IC`, `email`, `phone`, `visitor_code`, `qr_code`, `visit_date`, `status`, `owner_id`, `valid_days`) VALUES
(23, 'CHEN SHAO XI', 1123085500, 'shaoxi97@outlook.com', '0164237177', 'CHEN SHAO XI_20240902', '../qrcodes/CHEN SHAO XI_20240902.png', '2024-09-02', 'approved', 3, 1),
(24, 'Ali', 1123085500, 'shaoxi97@outlook.com', '0164237177', 'Ali_20240923', '../qrcodes/Ali_20240923.png', '2024-09-23', 'approved', 3, 1),
(25, 'Chin Chuang', 1123085500, 'shaoxi97@outlook.com', '0164237177', 'Chin Chuang_20240930', '../qrcodes/Chin Chuang_20240930.png', '2024-09-30', 'approved', 3, 1),
(26, 'Richie Chah', 2147483647, 'ritchie121600@gmail.com', '0123456789', 'Richie Chah_20241204', '../qrcodes/Richie Chah_20241204.png', '2024-12-04', 'approved', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `visit_date` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected','checked_in','checked_out') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_codes`
--
ALTER TABLE `qr_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_id` (`visitor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visitor_code` (`visitor_code`),
  ADD UNIQUE KEY `owner_id` (`owner_id`,`visit_date`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_id` (`visitor_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qr_codes`
--
ALTER TABLE `qr_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `qr_codes`
--
ALTER TABLE `qr_codes`
  ADD CONSTRAINT `qr_codes_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
  ADD CONSTRAINT `visitors_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`visitor_id`) REFERENCES `visitors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
