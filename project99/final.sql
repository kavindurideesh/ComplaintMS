-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 06:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `user_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `otp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`user_id`, `timestamp`, `otp`) VALUES
(2, '2024-10-14 12:49:47', 145307),
(3, '2023-09-05 18:33:03', 90033),
(9, '2024-10-15 00:16:21', 385724);

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
  `type` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `issue` varchar(400) NOT NULL,
  `serial` int(30) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `up_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`issue_id`, `user_id`, `user_name`, `contact`, `location`, `type`, `date`, `issue`, `serial`, `status`, `up_count`) VALUES
(2, 4, '2020CSC024', 775857385, 'csl3', 'equipment malfunction', '2023-09-04', '1st row 2nd PC not working', NULL, 'resolved', 0),
(5, 4, 'csc007', 0, 'csl2', 'maintainance', '2023-09-15', 'VSBSBSB', 0, 'unresolved', 3),
(7, 7, 'zvfzv', 243, 'csl3', 'equipment malfunction', '2024-10-22', 'fsdvd', 0, 'unresolved', 32),
(8, 7, 'sgb s', 0, 'csl3', 'equipment malfunction', '2024-10-24', 'r', 0, 'unresolved', 264),
(9, 7, '1234', 1243, 'csl2', 'equipment malfunction', '2024-10-15', '1324', 1234, 'unresolved', 30);

-- --------------------------------------------------------

--
-- Table structure for table `complaint_type`
--

CREATE TABLE `complaint_type` (
  `type_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_type`
--

INSERT INTO `complaint_type` (`type_id`, `type`) VALUES
(1, 'equipment malfunction'),
(2, 'maintainance'),
(3, 'other');

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

--
-- Dumping data for table `resolved_complaints`
--

INSERT INTO `resolved_complaints` (`resolved_id`, `issue_id`, `user_id`, `date_solved`, `comments`, `resolved_by`) VALUES
(3, 5, 4, '2024-10-14', 'dfgdf', 'drgf'),
(4, 2, 4, '2024-10-14', 'dfhd', 'dfg');

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
(1, '2020CSC075', 'Sinega', 'anathansinega@gmail.com', '$2y$10$HVEnn8IBud02i0ZpMagASeKWUZMtAEmvUKEtHaJjqRmxGcTjEerPW', 'admin', 'active'),
(2, '2020CSC057', 'Vithurshan', 'sivavithu15@live.com', '$2y$10$SBHLtBXW8uEfPT4MR9FaBO2H.Buxwmh8D72yn0utsskKK41i48bVa', 'admin', 'active'),
(3, '2020CSC027', 'Gobikatheesh', 'kgobi24lk@gmail.com', '$2y$10$WM5Wrk/g3ykBk0sIC5qYAe/XMXEyrnifT0IVgVmgoGlBH4I8thGWW', 'admin', 'active'),
(4, '2020CSC024', 'Isath', 'muhamadissath92@gmail.com', '$2y$10$/FwXel75JMDImYDHzAKYU.Ewe87Fq9Hzsy9.9jE8HniGlLgD/dzvi', 'student', 'active'),
(5, '2020CSC016', 'Nadeera', 'nadeerarukshanhewawasam@gmail.com', '$2y$10$4kxJdIAsqn.jdQqV8x26k.H4z2vmFUWQe4WT6Lsm6A6gJNnNe3bqS', 'student', 'active'),
(7, '2020CSC020', 'Joshna', 'venevijay09@gmail.com', '$2y$10$/7YExFQxJ6qWYhrnstK/lOYhIs7sGpIRnzs.td4BCsu/CN1NMM58i', 'student', 'active'),
(9, '2021csc060', 'Rideesh', 'kavindurideesh@gmail.com', '$2y$10$.LDgNTIbidGHe217Rwnwk.DXinxwW.DVAoYO2ZvcRwHRduWQMfgfa', 'admin', 'active'),
(10, 'abcd', 'abcd', 'abcd@gmail.com', '$2y$10$BiR81Bc2FseGOyZI4LE0SOn9XdXoxjGxKosAI3tGW.YRogLbALggC', 'admin', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `path` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `path`) VALUES
(1, 3, '../profileimages/.jpg'),
(2, 7, '../profileimages/Leonardo_Anime_XL_Create_an_illustration_of_a_tranquil_garden_1.jpg');

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
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `complaint_type`
--
ALTER TABLE `complaint_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `resolved_complaints`
--
ALTER TABLE `resolved_complaints`
  MODIFY `resolved_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stmp`
--
ALTER TABLE `stmp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
