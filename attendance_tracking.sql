-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2018 at 01:57 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance_tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `Sr_No.` int(5) NOT NULL,
  `Date` date NOT NULL,
  `Roll_No` int(4) NOT NULL,
  `ERP_Attended` int(2) NOT NULL,
  `CSM_Attended` int(2) NOT NULL,
  `BDA_Attended` int(2) NOT NULL,
  `SNMR_Attended` int(2) NOT NULL,
  `SC_Attended` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_subjects`
--

INSERT INTO `class_subjects` (`Sr_No.`, `Date`, `Roll_No`, `ERP_Attended`, `CSM_Attended`, `BDA_Attended`, `SNMR_Attended`, `SC_Attended`) VALUES
(1, '2018-01-06', 7475, 1, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `daily_class`
--

CREATE TABLE `daily_class` (
  `Rfid_No` int(10) NOT NULL,
  `Roll_No` int(4) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_class`
--

INSERT INTO `daily_class` (`Rfid_No`, `Roll_No`, `Date`) VALUES
(123456, 7475, '2018-01-06');

-- --------------------------------------------------------

--
-- Table structure for table `student_rfid`
--

CREATE TABLE `student_rfid` (
  `Rfid_No` int(10) NOT NULL,
  `Roll_No` int(4) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Year` int(4) NOT NULL,
  `Stream` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_rfid`
--

INSERT INTO `student_rfid` (`Rfid_No`, `Roll_No`, `Name`, `Year`, `Stream`) VALUES
(123456, 7475, 'Nisarg Deepak Shah', 4, 'Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `subject_lecturetaken`
--

CREATE TABLE `subject_lecturetaken` (
  `Sub_Sr_No` int(2) NOT NULL,
  `Subject_Name` varchar(30) NOT NULL,
  `Lectures_Taken` int(2) NOT NULL,
  `Date` date NOT NULL,
  `SSN` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_lecturetaken`
--

INSERT INTO `subject_lecturetaken` (`Sub_Sr_No`, `Subject_Name`, `Lectures_Taken`, `Date`, `SSN`) VALUES
(1, 'ERP', 2, '2018-01-06', 12345);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subject`
--

CREATE TABLE `teacher_subject` (
  `SSN` int(5) NOT NULL,
  `Faculty_Name` varchar(30) NOT NULL,
  `Semester` int(1) NOT NULL,
  `Subject_Name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher_subject`
--

INSERT INTO `teacher_subject` (`SSN`, `Faculty_Name`, `Semester`, `Subject_Name`) VALUES
(98765, 'Jagruti Save', 8, 'SC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`Sr_No.`);

--
-- Indexes for table `daily_class`
--
ALTER TABLE `daily_class`
  ADD PRIMARY KEY (`Rfid_No`,`Roll_No`);

--
-- Indexes for table `student_rfid`
--
ALTER TABLE `student_rfid`
  ADD PRIMARY KEY (`Rfid_No`,`Roll_No`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
