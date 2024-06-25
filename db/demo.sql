-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 10:34 AM
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
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` varchar(200) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `middle_name`, `last_name`, `address`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Yawal', NULL, NULL, 'kaayu', 'Student', 'pending', '2024-06-20 07:44:04', '2024-06-20 07:44:04'),
(2, 'Troy Israel', NULL, NULL, 'Manolos', 'student', 'active', '2024-06-25 01:14:10', '2024-06-25 01:14:10'),
(3, 'Troy Israel', NULL, NULL, 'manolo', 'Student', 'pending', '2024-06-25 01:23:30', '2024-06-25 01:23:30'),
(5, 'animal', NULL, NULL, 'manolo', 'Student', 'pending', '2024-06-25 01:43:41', '2024-06-25 01:43:41'),
(6, 'Troy Estillore', NULL, NULL, 'libona', 'Student', 'pending', '2024-06-25 01:57:11', '2024-06-25 01:57:11'),
(7, 'Troy bago', NULL, NULL, 'manolo', 'Student', 'pending', '2024-06-25 02:53:05', '2024-06-25 02:53:05'),
(8, 'Ellyzen Gwapa', NULL, NULL, 'Santiago', 'Student', 'pending', '2024-06-25 03:07:48', '2024-06-25 03:07:48'),
(9, 'Troy Israel', NULL, NULL, 'manolo', '1', 'pending', '2024-06-25 04:53:44', '2024-06-25 04:53:44'),
(10, 'Troy Israel', NULL, NULL, 'AMAW', '1', 'pending', '2024-06-25 04:54:21', '2024-06-25 04:54:21'),
(11, 'Troy Israel', NULL, NULL, 'amawsasasas', '1', 'pending', '2024-06-25 04:56:56', '2024-06-25 04:56:56'),
(12, 'Troy Israel', NULL, NULL, 'pesti', '1', 'pending', '2024-06-25 04:57:28', '2024-06-25 04:57:28'),
(13, 'Troy Israel', NULL, NULL, 'manolo', 'Admin', 'pending', '2024-06-25 05:01:07', '2024-06-25 05:01:07'),
(14, 'Troy Israel', NULL, NULL, 'manolos', 'Student', 'pending', '2024-06-25 05:01:27', '2024-06-25 05:01:27'),
(15, 'Troy Israel', NULL, NULL, 'manolo', 'Student', 'Active', '2024-06-25 05:03:36', '2024-06-25 05:03:36'),
(16, 'Beazel', 'P', '', 'amwa', 'Student', 'Pending', '2024-06-25 08:07:42', '2024-06-25 08:07:42'),
(17, 'Alacon', 'C', '', 'manolo', 'Student', 'Pending', '2024-06-25 08:08:38', '2024-06-25 08:08:38'),
(18, 'Amaw', 'A', '', 'Manolo', 'Student', 'Pending', '2024-06-25 08:09:41', '2024-06-25 08:09:41'),
(19, 'Galaw', 'G', 'Ka', 'Manolo', 'Student', 'Pending', '2024-06-25 08:10:41', '2024-06-25 08:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_tag` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_descriptive_title` text DEFAULT NULL,
  `subject_semester_offered` varchar(255) NOT NULL,
  `subject_units` int(255) NOT NULL,
  `subject_date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `subject_date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_tag`, `subject_code`, `subject_descriptive_title`, `subject_semester_offered`, `subject_units`, `subject_date_created`, `subject_date_updated`) VALUES
(1, 'IT', 'LAM01', 'Lami-on', '1sr', 3, '2024-06-20 07:44:40', '2024-06-20 07:44:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'iraq', '$2y$10$cCwDB8Bztq1xtHc1uQ46MexgCVVuNRaTmM8umHo8LJGToHdlNZlmK', '2024-06-05 14:00:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
