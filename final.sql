-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 04:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_types`
--

CREATE TABLE `admin_types` (
  `admin_id` int(11) NOT NULL,
  `admin_type` enum('HOD','Lecturer','Network Manager','Instructor','Technical Officer','Laboratory Attendent','Staff Management Assistant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_types`
--

INSERT INTO `admin_types` (`admin_id`, `admin_type`) VALUES
(33, 'HOD'),
(35, 'Lecturer'),
(36, 'Lecturer');

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `user_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `otp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `issue_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `contact` int(15) DEFAULT NULL,
  `location` varchar(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `issue` varchar(400) NOT NULL,
  `serial` int(30) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `image_path` varchar(70) DEFAULT NULL,
  `up_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`issue_id`, `user_id`, `user_name`, `contact`, `location`, `type`, `date`, `issue`, `serial`, `status`, `image_path`, `up_count`) VALUES
(10, 12, 'student', 464534534, 'csl2', 'Network Issues', '2024-11-07', 'dfdfd', 3, 'unresolved', '../Cimg/complaint.png', 0),
(11, 12, 'student', 464534534, 'csl2', 'sdfdfd', '2024-11-28', 'dsads', 34, 'unresolved', '../Cimg/complaint.png', 0),
(12, 12, 'student', 464534534, 'csl2', 'sdfdfd', '2024-11-07', 'fsf', 345, 'unresolved', '../Cimg/complaint.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `complaint_type`
--

CREATE TABLE `complaint_type` (
  `type_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `admin_type` enum('HOD','Lecturer','Network Manager','Instructor','Technical Officer','Laboratory Attendent','Staff Management Assistant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_type`
--

INSERT INTO `complaint_type` (`type_id`, `type`, `admin_type`) VALUES
(8, 'Network Issues', 'HOD'),
(9, 'sdfdfd', 'Lecturer'),
(10, 'fdfdf', 'Lecturer');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_name`) VALUES
(2, 'csl2'),
(3, 'csl3'),
(4, 'csl4'),
(5, 'csl1');

-- --------------------------------------------------------

--
-- Table structure for table `resolved_complaints`
--

CREATE TABLE `resolved_complaints` (
  `resolved_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_solved` date NOT NULL,
  `comments` varchar(300) NOT NULL,
  `resolved_by` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stmp`
--

CREATE TABLE `stmp` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stmp`
--

INSERT INTO `stmp` (`id`, `email`) VALUES
(1, 'travelguidearchive@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `name`, `email`, `password`, `role`, `status`) VALUES
(11, 'MAIN_ADMIN', 'mainadmin', 'mainadmin@gmail.com', '$2y$10$A.z.YEDFdfb84A/hIqIo/eY3tm648Jk0wr6If8cbVGaQQGWV0rD2G', 'admin', 'active'),
(12, 'student', 'student', 'student@gmail.com', '$2y$10$U/HB9Et4N12Wb/pyJaouZ.XLu/xL5Xk.zlwUeSV7ZqootDbduR3Pi', 'student', 'active'),
(33, 'staffTypetest', 'staff_01', 'staff_01@gmail.com', '$2y$10$Ea0Qda/LdqDTp972Md57xujn6nMmACrqcyrAaczKUdlho9VYDbORK', 'staff', 'active'),
(35, 'staff1', 'staff1', 'staff1@gmail.com', '$2y$10$QKw1Umih/NwAltbkp4breuXv2zdk8lakhD4S8j9o97LsD43HYN1zS', 'staff', 'active'),
(36, 'staff2', 'staff2', 'staff2@gmail.com', '$2y$10$Ldh0WymbH.0lZe60zhsJ7Olz1w/6HxdKb44gmE6MFSFEnv7k.lAii', 'staff', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `path` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_types`
--
ALTER TABLE `admin_types`
  ADD PRIMARY KEY (`admin_id`,`admin_type`);

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`user_id`,`timestamp`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`issue_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `complaint_type`
--
ALTER TABLE `complaint_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `resolved_complaints`
--
ALTER TABLE `resolved_complaints`
  ADD PRIMARY KEY (`resolved_id`),
  ADD KEY `issue_id` (`issue_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stmp`
--
ALTER TABLE `stmp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`issue_id`),
  ADD KEY `issue_id` (`issue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `complaint_type`
--
ALTER TABLE `complaint_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `resolved_complaints`
--
ALTER TABLE `resolved_complaints`
  MODIFY `resolved_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stmp`
--
ALTER TABLE `stmp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_types`
--
ALTER TABLE `admin_types`
  ADD CONSTRAINT `admin_types_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `authentication`
--
ALTER TABLE `authentication`
  ADD CONSTRAINT `authentication_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resolved_complaints`
--
ALTER TABLE `resolved_complaints`
  ADD CONSTRAINT `resolved_complaints_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `complaints` (`issue_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resolved_complaints_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`issue_id`) REFERENCES `complaints` (`issue_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
