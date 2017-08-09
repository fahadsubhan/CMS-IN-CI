-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2017 at 12:24 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shuja_livamobile`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('4e7ec8782d0ed5c9f36c6fee43da2fc27aafaa73', '::1', 1501760798, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530313736303738383b),
('a4fd16ea7c981c56d2e614b25cf10cd93e63a5ec', '::1', 1501756744, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530313735363733313b),
('f43abe26c37f473695f14c8f87dd090388b10c81', '::1', 1501753280, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530313735333237333b);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL,
  `role_title` varchar(200) NOT NULL,
  `role_key` varchar(200) NOT NULL,
  `role_status` tinyint(1) NOT NULL,
  `role_created_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_title`, `role_key`, `role_status`, `role_created_date`) VALUES
(1, 'admin', 'admin', 1, '2017-08-07 14:21:34'),
(2, 'subscriber', 'subscriber', 1, '2017-08-08 00:00:00'),
(3, 'Sale Officer', 'saleofficer', 1, '2017-08-08 09:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `user_email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `user_role_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `user_email`, `password`, `created_at`, `updated_at`, `is_active`, `user_role_id`) VALUES
(1, 'admin', 'admin@livamobile.com', 'e10adc3949ba59abbe56e057f20f883e', '2017-08-03 11:40:09', NULL, 1, 1),
(2, 'fahad', 'fahad@livamobile.com', 'e10adc3949ba59abbe56e057f20f883e', '2017-08-03 13:22:38', '2017-08-07 13:03:52', 0, 3),
(8, 'nabeel', 'nabeel@test.com', 'e10adc3949ba59abbe56e057f20f883e', '2017-08-08 12:16:06', '2017-08-08 12:18:25', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `whitelistips`
--

CREATE TABLE IF NOT EXISTS `whitelistips` (
  `ip_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `whitelistips`
--

INSERT INTO `whitelistips` (`ip_id`, `title`, `ip_address`, `is_active`) VALUES
(1, 'Office IP User', '192.168.0.1', 1),
(2, 'Local IP', '::1', 1),
(6, 'Shuja Telenor', '192.168.8.14', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whitelistips`
--
ALTER TABLE `whitelistips`
  ADD PRIMARY KEY (`ip_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `whitelistips`
--
ALTER TABLE `whitelistips`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
