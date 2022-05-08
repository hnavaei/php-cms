-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2022 at 03:06 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `admin_password` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `admin_email` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `admin_gender` enum('خانم','آقا') COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_username`, `admin_password`, `admin_email`, `admin_gender`) VALUES
(1, 'hnavaei', '1234', 'hnavaei@gmail.com', 'خانم');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment`
--

CREATE TABLE `tbl_appointment` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `in_date` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `in_hour` time NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_appointment`
--

INSERT INTO `tbl_appointment` (`id`, `patient_id`, `doctor_id`, `in_date`, `in_hour`, `code`) VALUES
(12, 1, 8, '۱۴۰۱-۰۱-۰۳', '08:45:00', 9826433);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doctors`
--

CREATE TABLE `tbl_doctors` (
  `doctor_id` int(11) NOT NULL,
  `doctor_name` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `doctor_lastname` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `doctor_group` int(11) NOT NULL,
  `doctor_pic` varchar(256) COLLATE utf8_persian_ci NOT NULL DEFAULT '000.png',
  `doctor_gender` enum('خانم','آقا') COLLATE utf8_persian_ci NOT NULL,
  `doctor_phone` varchar(156) COLLATE utf8_persian_ci NOT NULL,
  `doctor_email` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `doctor_password` varchar(256) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_doctors`
--

INSERT INTO `tbl_doctors` (`doctor_id`, `doctor_name`, `doctor_lastname`, `doctor_group`, `doctor_pic`, `doctor_gender`, `doctor_phone`, `doctor_email`, `doctor_password`) VALUES
(8, 'محسن', 'میری', 1, '142949df56ea8ae0be8b5306971900a4profile1.jpg', 'آقا', '9128553641', 'mohsenmiri@yahoo.com', '9111');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE `tbl_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(256) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_group`
--

INSERT INTO `tbl_group` (`group_id`, `group_name`) VALUES
(1, 'جراح عمومی'),
(2, ' ارتوپدی'),
(3, 'زنان و زایمان'),
(4, 'کلیه و مجاری ادراری'),
(5, 'مغز و اعصاب و ستون فقرات'),
(6, 'گوش و حلق وبینی'),
(7, 'قلب و عروق'),
(8, 'اعصاب و روان'),
(9, 'بیماری های عفونی'),
(10, 'پوست، مو و زیبایی'),
(11, 'بیماری های کودکان'),
(12, 'بیهوشی');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patients`
--

CREATE TABLE `tbl_patients` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `patient_lastname` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `patient_age` int(11) NOT NULL,
  `patient_gender` enum('خانم','آقا') COLLATE utf8_persian_ci NOT NULL,
  `patient_phone` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `patient_info` mediumtext COLLATE utf8_persian_ci NOT NULL,
  `patient_password` varchar(256) COLLATE utf8_persian_ci NOT NULL,
  `patient_email` varchar(256) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_patients`
--

INSERT INTO `tbl_patients` (`patient_id`, `patient_name`, `patient_lastname`, `patient_age`, `patient_gender`, `patient_phone`, `patient_info`, `patient_password`, `patient_email`) VALUES
(1, 'امیر', 'ترابی', 40, 'آقا', '9197896541', 'بیمار سابقه عمل قلب دارد', '3539', 'amirtorabi@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_working_time_doctor`
--

CREATE TABLE `tbl_working_time_doctor` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `day` enum('شنبه','یکشنیه','دوشنبه','سه شنبه','چهارشنبه','پنجشنبه','جمعه') COLLATE utf8_persian_ci NOT NULL,
  `from_hour` time NOT NULL,
  `to_hour` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tbl_working_time_doctor`
--

INSERT INTO `tbl_working_time_doctor` (`id`, `doctor_id`, `day`, `from_hour`, `to_hour`) VALUES
(10, 8, 'چهارشنبه', '08:00:00', '14:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `tbl_doctors`
--
ALTER TABLE `tbl_doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `doctor_group` (`doctor_group`);

--
-- Indexes for table `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `tbl_working_time_doctor`
--
ALTER TABLE `tbl_working_time_doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `doctor_id_2` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tbl_doctors`
--
ALTER TABLE `tbl_doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_patients`
--
ALTER TABLE `tbl_patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_working_time_doctor`
--
ALTER TABLE `tbl_working_time_doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD CONSTRAINT `tbl_appointment_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `tbl_patients` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_appointment_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `tbl_doctors` (`doctor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_doctors`
--
ALTER TABLE `tbl_doctors`
  ADD CONSTRAINT `tbl_doctors_ibfk_1` FOREIGN KEY (`doctor_group`) REFERENCES `tbl_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_working_time_doctor`
--
ALTER TABLE `tbl_working_time_doctor`
  ADD CONSTRAINT `tbl_working_time_doctor_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `tbl_doctors` (`doctor_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
