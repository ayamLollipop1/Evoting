-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2023 at 03:07 PM
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
-- Database: `evoting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adminID` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `firstName` char(30) NOT NULL,
  `Surname` char(30) NOT NULL,
  `password` varchar(50) NOT NULL DEFAULT 'password',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminID`, `email`, `firstName`, `Surname`, `password`, `created_at`) VALUES
(2, 'admin@afterworld.com', 'tti', 'takoradi', '21232f297a57a5a743894a0e4a801fc3', '2023-02-25 15:05:17'),
(4, 'new@tti.com', 'new', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2023-03-03 23:02:51'),
(5, 'second@gmail.com', 'sec', 'ond', 'password', '2023-03-03 23:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `candidateID` int(3) NOT NULL,
  `studentID` int(3) NOT NULL,
  `image` varchar(40) NOT NULL,
  `positionID` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidateID`, `studentID`, `image`, `positionID`, `added_by`, `created_at`) VALUES
(3, 1, '522588.jpg', 1, 2, '2023-03-03 19:07:40'),
(4, 4, '747354.png', 2, 2, '2023-03-03 19:28:06'),
(5, 5, '45537.png', 1, 2, '2023-03-03 19:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `positionID` int(11) NOT NULL,
  `name` char(20) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`positionID`, `name`, `added_by`, `created_at`) VALUES
(1, 'Boys Prefect', 2, '2023-03-03 03:14:06'),
(2, 'Girls Prefect', 2, '2023-03-03 05:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentID` int(11) NOT NULL,
  `firstname` char(30) NOT NULL,
  `othername` varchar(50) DEFAULT NULL,
  `surname` char(30) NOT NULL,
  `house` varchar(20) NOT NULL,
  `department` varchar(30) NOT NULL,
  `class` varchar(10) NOT NULL,
  `uniqueCode` varchar(30) NOT NULL,
  `sex` char(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentID`, `firstname`, `othername`, `surname`, `house`, `department`, `class`, `uniqueCode`, `sex`, `created_at`) VALUES
(1, 'michael', '', 'boffie', 'house 5', 'I.T', 'form 1', 'BmEzkkFoKb', 'male', '2023-02-27 10:45:21'),
(4, 'Emmanul', '', 'Aglago', 'house 3', 'Oil & Gas', 'form 3', 'Jx5zNQQWsa', 'male', '2023-03-03 19:27:38'),
(5, 'Kelvin', 'Clement', 'Ackom', 'house 4', 'Auto Mechanic', 'form 2', 'Wdfn9HW6mk', 'male', '2023-03-03 19:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `votecount`
--

CREATE TABLE `votecount` (
  `voteID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  `candidateID` int(11) NOT NULL,
  `voted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candidateID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `positionID` (`positionID`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`positionID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentID`);

--
-- Indexes for table `votecount`
--
ALTER TABLE `votecount`
  ADD PRIMARY KEY (`voteID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `candidateID` (`candidateID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidateID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `positionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votecount`
--
ALTER TABLE `votecount`
  MODIFY `voteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`),
  ADD CONSTRAINT `candidates_ibfk_2` FOREIGN KEY (`positionID`) REFERENCES `positions` (`positionID`);

--
-- Constraints for table `votecount`
--
ALTER TABLE `votecount`
  ADD CONSTRAINT `votecount_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `students` (`studentID`),
  ADD CONSTRAINT `votecount_ibfk_2` FOREIGN KEY (`candidateID`) REFERENCES `candidates` (`candidateID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
