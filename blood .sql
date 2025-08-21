-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 21 مايو 2025 الساعة 12:29
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `FullName` varchar(250) NOT NULL,
  `Username` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Phone` varchar(250) NOT NULL,
  `Role` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admin`
--

INSERT INTO `admin` (`id`, `FullName`, `Username`, `Password`, `Email`, `Phone`, `Role`) VALUES
(2, '8', '8', '88888888', 'c@gmail.com', '+966555755389', 'Department Admin'),
(3, '8', '1', '11111111', 'c@gmail.com', '+966555755389', 'Super Admin'),
(4, 'يسيس', '3', '33333333', '1@gmail.com', '+966111111111', 'Super admin'),
(5, 'asd', '1', '22222222', 'qew@gmail.com', '+966999999999', 'Super Admin');

-- --------------------------------------------------------

--
-- بنية الجدول `donationrequest`
--

CREATE TABLE `donationrequest` (
  `id` int(11) NOT NULL,
  `DonatorName` varchar(250) NOT NULL,
  `BloodType` varchar(250) NOT NULL,
  `RequestDate` date NOT NULL DEFAULT current_timestamp(),
  `Message` varchar(250) NOT NULL,
  `Status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `donationrequest`
--

INSERT INTO `donationrequest` (`id`, `DonatorName`, `BloodType`, `RequestDate`, `Message`, `Status`) VALUES
(27, 'y', 'AB+', '2025-05-20', 'hjhg', 'Accepted'),
(48, 'AS', 'AB+', '2025-05-20', 'DAFS', 'Accepted'),
(49, 'D', 'AB+', '2025-05-20', 'DD', 'Accepted'),
(50, 'y', 'AB+', '2025-05-20', 'ASDASD', 'Accepted'),
(51, 'A', 'AB+', '2025-05-20', 'SDA', 'Accepted'),
(52, 'A', 'AB+', '2025-05-20', 'ASDDSA', 'Accepted'),
(53, 'A', 'AB+', '2025-05-20', 'ASDDSA', 'Accepted'),
(64, 'v', 'AB+', '2025-05-20', 'dew', 'Accepted'),
(65, 'k', 'AB+', '2025-05-20', 'kkk', 'Accepted'),
(66, 'z', 'AB+', '2025-05-20', 'zzzz', 'Accepted'),
(67, 'p', 'AB+', '2025-05-20', 'ppp', 'Accepted'),
(68, 't', 'AB+', '2025-05-20', 'tt', 'Accepted'),
(72, 'mm', 'A+', '2025-05-21', 'mm', 'Accepted'),
(73, '77', 'B-', '2025-05-21', 'ss', 'Pending');

-- --------------------------------------------------------

--
-- بنية الجدول `doner`
--

CREATE TABLE `doner` (
  `id` int(11) NOT NULL,
  `FullName` varchar(250) NOT NULL,
  `Username` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Phone` varchar(250) NOT NULL,
  `BloodType` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `doner`
--

INSERT INTO `doner` (`id`, `FullName`, `Username`, `Password`, `Email`, `Phone`, `BloodType`) VALUES
(27, 'a', 'a', '11111111', 'yosfeid9999@hotmail.com', '+966530947212', 'AB+'),
(28, 'v', 'v', 'vvvvvvvv', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(29, 'k', 'k', 'kkkkkkkk', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(30, 'z', 'z', 'zzzzzzzz', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(31, 'p', 'p', 'pppppppp', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(32, 't', 't', 'tttttttt', 'yosfeid9999@hotmail.com', '+966539997212', 'AB+'),
(33, 'q', 'q', 'qqqqqqqq', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(34, 'vvv', 'vvv', 'vvvvvvvv', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(35, 'ccc', 'ccc', 'cccccccc', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(40, 'rr', 'rr', 'rrrrrrrr', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(41, 'mm', 'mm', 'mmmmmmmm', 'yosfeid9999@hotmail.com', '+966530997212', 'A+'),
(42, 'ff', 'ff', 'ffffffff', 'yosfeid9999@hotmail.com', '+966530997212', 'AB+'),
(43, '77', '77', '77777777', 'yosfeid9999@hotmail.com', '+966530997212', 'B-');

-- --------------------------------------------------------

--
-- بنية الجدول `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `FullName` varchar(250) NOT NULL,
  `Username` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Phone` varchar(250) NOT NULL,
  `Job` varchar(250) NOT NULL,
  `Department` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `employee`
--

INSERT INTO `employee` (`id`, `FullName`, `Username`, `Password`, `Email`, `Phone`, `Job`, `Department`) VALUES
(1, '3', '3', '12345678', 'A@gmail.com', '+966555755389', 'Other', 'Radiology'),
(9, 'ads', 'ewrwr', '11111111', 'sfdgsfd@gmail.com', '+966111111111', 'dfgfgd', 'Radiology'),
(10, 'yousef', 'yousef', 'ggggggggggggggg', 'ddddffffdd@gmail.com', '+966111114444', 'other', 'Radiology');

-- --------------------------------------------------------

--
-- بنية الجدول `hospital`
--

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Location` varchar(250) NOT NULL,
  `Contact` varchar(250) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `hospital`
--

INSERT INTO `hospital` (`id`, `Name`, `Location`, `Contact`, `latitude`, `longitude`) VALUES
(9, 'مستشفى الملك فهد التخصصي ', 'Tabuk', '0141234567 ', 28.44685002154529, 36.51353789410572),
(10, 'مستشفى الملك فيصل التخصصي ومركز الأبحاث بجدة', 'Jeddah', '0141234523', 21.560176248870686, 39.14790733644437),
(11, 'التخصصي', 'Tabuk', '0141234567 ', 28.44685002154529, 36.51353789410572),
(12, 'مستشفى الجدعاني', 'Jeddah', '0141234555', 21.587679268164933, 39.207298771955216);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donationrequest`
--
ALTER TABLE `donationrequest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doner`
--
ALTER TABLE `doner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `donationrequest`
--
ALTER TABLE `donationrequest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `doner`
--
ALTER TABLE `doner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
