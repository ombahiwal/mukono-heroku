-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 09, 2020 at 10:54 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mukono-master`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `docid` bigint(20) NOT NULL,
  `dnid` text NOT NULL,
  `speciality` text,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `phone` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online_status` int(11) DEFAULT NULL,
  `pwd` text,
  `gender` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`docid`, `dnid`, `speciality`, `fname`, `lname`, `phone`, `email`, `updated_at`, `online_status`, `pwd`, `gender`, `dob`, `address`, `created_on`, `logtime`) VALUES
(6, 'T123', 'Neurology', 'Omkar', 'Bahiwal', '9373130909', 'ombahiwal@gmail.com', '2020-03-19 13:12:23', 0, 'Omkar109', 1, '1998-09-10', 'Nabuti Rd., Mukono', '2020-03-19 13:12:23', '2020-06-08 20:51:51'),
(7, 'Test', 'Test', 'Test', 'Test', '9373130909', 'bahiwal@aol.com', '2020-03-19 13:22:49', 0, 'Mukono', 0, '1998-09-10', 'Mukono MMC', '2020-03-19 13:22:49', '2020-03-19 13:32:41'),
(9, 'sdada', 'dasda', 'Omkar', 'sdasd', 'asdasda', 'test@test.test.com', '2020-06-05 10:58:17', 0, '$2y$10$A0bK014/LvV6v49d57jvA.6Q2/OogNkdi3hb8oD4xUMhJHlxoh1FG', 0, '1123-11-11', 'test', '2020-06-05 10:58:17', '2020-06-08 20:52:09'),
(10, '321', 'Test', 'Omkar', 'Bahiwal', '9373130909', 'ombahiwal@icloud.com', '2020-06-05 11:06:24', 0, '$2y$10$3iC4pTX9J4izUoA3y9p1u.rFhx.NkTH24t7P6y43hP/DPreO2z9CS', 0, '1998-09-10', 'India', '2020-06-05 11:06:24', '2020-06-05 11:07:34'),
(11, '21844', '1', 'Omkar', 'Bahiwal', '9373130909', 't@t.co', '2020-06-05 11:30:23', 1, '$2y$10$3dKuvVtc3tqa1tSj4Aa1XuJv3/lpLQkcnHwI74GQrZdko5kI9G2K2', 0, '1998-09-10', 'Test', '2020-06-05 11:30:23', '2020-06-09 00:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `labtests`
--

CREATE TABLE `labtests` (
  `testid` int(11) NOT NULL,
  `test` text NOT NULL,
  `samples` text NOT NULL,
  `inference` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `labtests`
--

INSERT INTO `labtests` (`testid`, `test`, `samples`, `inference`, `created_on`) VALUES
(1, 'CBC', 'Blood', '-', '2020-03-23 10:43:58'),
(2, 'Blood Smear Test for Malaria', 'Blood', '-', '2020-03-23 10:43:58'),
(7, 'HIV Test', 'Blood', NULL, '2020-03-23 10:46:26'),
(8, 'Blood Group Identification', 'Blood', NULL, '2020-03-23 10:46:26'),
(9, 'Urinanalysis', 'Urine', '-ve, +ve', '2020-03-23 11:57:23'),
(10, 'Random Blood Sugar (RBS)', 'Blood', 'NV', '2020-03-23 11:57:23'),
(11, 'TPHA', '', NULL, '2020-03-23 11:58:09'),
(12, 'RPR', '', NULL, '2020-03-23 11:58:09'),
(13, 'Urine TB LAM', '', NULL, '2020-03-23 11:58:31'),
(14, 'Gene Xpert', 'Blood', NULL, '2020-03-23 11:58:31'),
(15, 'LFTs', '', NULL, '2020-03-23 12:00:19'),
(16, 'Electrolytes', '', NULL, '2020-03-23 12:00:19'),
(17, 'CD4 Count', '', NULL, '2020-03-23 12:00:19'),
(18, 'Hepatitis B', '', NULL, '2020-03-23 12:00:19'),
(19, 'HIV Viral Load', '', NULL, '2020-03-23 12:00:19'),
(20, 'Hepatitis B Viral Load', '', NULL, '2020-03-23 12:00:19'),
(21, 'ZN', '', NULL, '2020-03-23 12:00:19'),
(22, 'Stool Analysis', 'Stool', NULL, '2020-03-23 12:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `lab_records`
--

CREATE TABLE `lab_records` (
  `recid` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `testids` text,
  `samples` text,
  `pnid` int(11) DEFAULT NULL,
  `tokenrefid` int(11) DEFAULT NULL,
  `inference` text COMMENT 'Notes from the Lab',
  `report` text COMMENT 'report path',
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sample_collected_by` text,
  `tested_by` text,
  `active` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lab_records`
--

INSERT INTO `lab_records` (`recid`, `timestamp`, `testids`, `samples`, `pnid`, `tokenrefid`, `inference`, `report`, `time_updated`, `sample_collected_by`, `tested_by`, `active`) VALUES
(15, '2020-06-06 13:33:52', '1 ', '1 ', 123, 33, 'Test ', 'labreports/123/', '2020-06-06 23:50:20', '3', '3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_stats`
--

CREATE TABLE `login_stats` (
  `logid` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_stats`
--

INSERT INTO `login_stats` (`logid`, `timestamp`, `userid`, `status`) VALUES
(1, '2020-06-09 22:09:00', '12', 0),
(2, '2020-06-09 22:09:26', '1', 1),
(3, '2020-06-09 22:09:59', '21844', 0),
(4, '2020-06-09 22:10:11', '4', 1),
(5, '2020-06-09 22:29:44', '12', 0),
(6, '2020-06-09 22:29:52', '1', 1),
(7, '2020-06-09 22:33:34', '21844', 0),
(8, '2020-06-09 22:33:54', '4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `mid` bigint(20) NOT NULL,
  `medicine` text NOT NULL,
  `dosage` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text NOT NULL,
  `expiry` date DEFAULT NULL,
  `personnel` text,
  `doe` date DEFAULT NULL,
  `type` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`mid`, `medicine`, `dosage`, `created_on`, `notes`, `expiry`, `personnel`, `doe`, `type`) VALUES
(1, 'Amoxicillin', '500mg', '2020-03-09 10:29:22', 'Antibiotic', NULL, NULL, NULL, 'Tablet'),
(10, 'Crocin', '500mg', '2020-05-30 20:43:44', 'Head Ache', '2020-09-10', 'NULL', '2020-09-10', 'Tablet'),
(11, 'test', 'test', '2020-05-31 21:53:02', 'test', '2020-06-02', 'NULL', '2020-06-02', 'test'),
(12, 'Honitus', '1ml', '2020-06-09 20:26:30', 'Used for Cough, Honey Based', '2021-09-10', '2', '2020-01-01', 'Syrup');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_stock`
--

CREATE TABLE `medicine_stock` (
  `stockid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicine_stock`
--

INSERT INTO `medicine_stock` (`stockid`, `mid`, `stock`, `last_updated`) VALUES
(1, 1, 989, '2020-03-09 10:41:20'),
(2, 10, 1000, '2020-05-30 20:43:44'),
(4, 11, 1000, '2020-05-31 21:53:02'),
(5, 12, 20, '2020-06-09 20:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `misc_logs`
--

CREATE TABLE `misc_logs` (
  `logid` bigint(20) NOT NULL,
  `uid` text,
  `description` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `misc_logs`
--

INSERT INTO `misc_logs` (`logid`, `uid`, `description`, `timestamp`) VALUES
(2, '1', '31,Prescription Access', '2020-06-06 23:34:45'),
(3, '1', '31,Prescription Access', '2020-06-06 23:35:03'),
(4, '3', '31,Prescription Access', '2020-06-06 23:50:32'),
(5, '2', '31,Prescription Access', '2020-06-07 00:10:21'),
(6, '2', '31,Prescription Access', '2020-06-07 00:11:57'),
(7, '2', '31,Prescription Access', '2020-06-07 00:12:20'),
(8, '2', '31,Prescription Access', '2020-06-07 00:13:40'),
(9, '2', '31,Prescription Access', '2020-06-07 00:37:48'),
(10, '2', '31,Prescription Access', '2020-06-07 00:38:05'),
(11, '2', '31,Prescription Access', '2020-06-07 00:59:45'),
(12, '4', '31,Prescription Access', '2020-06-08 23:32:41'),
(13, '4', '31,Prescription Access', '2020-06-08 23:33:13'),
(14, '4', '31,Prescription Access', '2020-06-09 00:26:14'),
(15, '11', '31,Prescription Access', '2020-06-09 11:20:33'),
(16, '4', '31,Prescription Access', '2020-06-09 11:20:33'),
(17, '4', 'Export Pharmacy Stock', '2020-06-09 20:49:26'),
(18, '4', 'Export Data - doctors', '2020-06-09 20:56:40'),
(19, '4', 'Export Data - doctors', '2020-06-09 20:57:12'),
(20, '4', 'Export Data - users', '2020-06-09 20:57:28'),
(21, '4', 'Export Data - patient_info', '2020-06-09 20:57:37'),
(22, '4', 'Export Data - 1', '2020-06-09 20:57:41'),
(23, '4', 'Export Data - lab_records', '2020-06-09 20:59:33');

-- --------------------------------------------------------

--
-- Table structure for table `opd_prescription`
--

CREATE TABLE `opd_prescription` (
  `refid` bigint(20) NOT NULL,
  `pnid` varchar(50) NOT NULL,
  `ptoken` int(11) DEFAULT NULL,
  `medicines` text,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `diagnosis` text,
  `treatment_notes` text,
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bp` float DEFAULT NULL,
  `dnid` varchar(50) DEFAULT NULL,
  `labtestids` text,
  `labtestinference` text,
  `active` int(11) DEFAULT '1',
  `uid` text,
  `labrecid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `opd_prescription`
--

INSERT INTO `opd_prescription` (`refid`, `pnid`, `ptoken`, `medicines`, `height`, `weight`, `diagnosis`, `treatment_notes`, `last_updated`, `timestamp`, `bp`, `dnid`, `labtestids`, `labtestinference`, `active`, `uid`, `labrecid`) VALUES
(31, '123', 33, '1', 20, 20, 'Malaria', ' Eat Passion Fruit', '2020-06-06 23:50:20', '2020-06-06 13:15:11', 20, '21844', '1 ', 'Test ', 1, '2', 15);

-- --------------------------------------------------------

--
-- Table structure for table `patient_info`
--

CREATE TABLE `patient_info` (
  `pnid` varchar(20) NOT NULL,
  `paddress` text,
  `pgender` int(11) NOT NULL,
  `pcategory` int(11) NOT NULL,
  `pfname` text NOT NULL,
  `plname` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` text,
  `phone` text,
  `dob` date DEFAULT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `bp` float DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient_info`
--

INSERT INTO `patient_info` (`pnid`, `paddress`, `pgender`, `pcategory`, `pfname`, `plname`, `timestamp`, `comments`, `phone`, `dob`, `height`, `weight`, `bp`, `bmi`, `time_updated`) VALUES
('123', 'Nabuti Rd., Mukono, Uganda', 0, 1, 'Omkar', 'Bahiwal', '2020-05-26 19:39:08', 'test user', '+919373130909', '1998-09-10', 20, 20, 20, 500, '2020-06-06 23:22:01'),
('222', 'Test Address', 0, 0, 'Test', 'User', '2020-06-08 22:57:55', NULL, '123123', '1212-12-12', NULL, NULL, NULL, NULL, '2020-06-08 22:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_stats`
--

CREATE TABLE `pharmacy_stats` (
  `logid` bigint(20) NOT NULL,
  `userid` text NOT NULL,
  `data` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pharmacy_stats`
--

INSERT INTO `pharmacy_stats` (`logid`, `userid`, `data`, `timestamp`) VALUES
(12, '0', '1,200,', '2020-05-30 20:55:25'),
(13, '0', '1,200,100', '2020-05-30 20:55:31'),
(14, '0', '10,300,2', '2020-05-30 20:55:35'),
(15, '0', '10,2,2000', '2020-05-30 20:55:37'),
(16, '0', '1,100,2000', '2020-05-30 20:55:39'),
(17, '0', '1,2000,200', '2020-05-30 21:24:18'),
(18, '0', '1,200,190', '2020-06-04 20:55:09'),
(19, '0', '10,2000,1990', '2020-06-04 20:55:09'),
(20, '0', '1,200,190', '2020-06-04 21:05:26'),
(21, '0', '10,2000,1990', '2020-06-04 21:05:26'),
(22, '0', '1,190,179', '2020-06-04 21:12:59'),
(23, '0', '10,1990,1979', '2020-06-04 21:12:59'),
(24, '0', '10,1979,1979', '2020-06-04 21:24:24'),
(25, '0', '1,179,178', '2020-06-04 21:28:12'),
(26, '0', '10,1979,1978', '2020-06-04 21:28:12'),
(27, '0', '11,1290,1000', '2020-06-04 21:40:45'),
(28, '0', '1,178,1000', '2020-06-04 21:40:50'),
(29, '0', '10,1978,1000', '2020-06-04 21:40:53'),
(30, '2', '1,1000,999', '2020-06-05 14:14:36'),
(31, '0', '1,999,989', '2020-06-06 13:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptionrec`
--

CREATE TABLE `prescriptionrec` (
  `recid` bigint(20) NOT NULL,
  `dosage` text NOT NULL COMMENT 'strength',
  `course` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prid` int(11) NOT NULL COMMENT 'Prescription Reference ID',
  `type` text,
  `mid` int(11) DEFAULT NULL,
  `medicine` text,
  `dispensed` int(11) DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prescriptionrec`
--

INSERT INTO `prescriptionrec` (`recid`, `dosage`, `course`, `timestamp`, `prid`, `type`, `mid`, `medicine`, `dispensed`, `time_updated`, `uid`) VALUES
(10, '500mg', '3/7', '2020-06-06 13:50:57', 31, 'Tablet', 1, 'Amoxicillin', 10, '2020-06-06 14:59:39', 2),
(11, 'tt', 'tt', '2020-06-06 13:50:57', 31, 'tt', 0, 'tesst', 0, '2020-06-06 14:59:42', 2);

-- --------------------------------------------------------

--
-- Table structure for table `screening_stats`
--

CREATE TABLE `screening_stats` (
  `logid` bigint(20) NOT NULL,
  `pnid` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` text COMMENT 'cm, kg, mmHg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `refid` bigint(20) NOT NULL,
  `pnid` text NOT NULL,
  `docid` text NOT NULL,
  `comments` text,
  `active` int(11) DEFAULT '0',
  `prid` bigint(20) DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`refid`, `pnid`, `docid`, `comments`, `active`, `prid`, `time_updated`, `created_at`, `uid`) VALUES
(1, '123', '21844', 'Test', 1, NULL, '2020-06-09 22:39:26', '2020-06-09 22:39:26', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tokens_log`
--

CREATE TABLE `tokens_log` (
  `logid` bigint(20) NOT NULL,
  `refid` bigint(20) NOT NULL,
  `pnid` text NOT NULL,
  `docid` text NOT NULL,
  `comments` text,
  `active` int(11) DEFAULT '0',
  `prid` bigint(20) DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens_log`
--

INSERT INTO `tokens_log` (`logid`, `refid`, `pnid`, `docid`, `comments`, `active`, `prid`, `time_updated`, `created_at`, `uid`) VALUES
(1, 1, '123', '21844', 'Test Users', 0, 123, '2020-06-09 22:19:23', '2020-06-09 22:19:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `token_states`
--

CREATE TABLE `token_states` (
  `stateid` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `statename` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `token_states`
--

INSERT INTO `token_states` (`stateid`, `state`, `statename`, `timestamp`) VALUES
(1, 0, 'Expired', '2020-06-08 22:27:08'),
(2, 1, 'OPD Waiting', '2020-06-08 22:27:08'),
(3, 2, 'Screening', '2020-06-08 22:28:10'),
(4, 3, 'Doctor', '2020-06-08 22:28:10'),
(5, 5, 'Lab Waiting', '2020-06-08 22:29:03'),
(6, 6, 'Lab Sample', '2020-06-08 22:29:03'),
(7, 7, 'Lab Testing', '2020-06-08 22:29:43'),
(8, 8, 'Lab Tested', '2020-06-08 22:29:43'),
(9, 4, 'Pharmacy', '2020-06-08 22:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `section` text,
  `secid` int(11) DEFAULT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `phone` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online_status` int(11) DEFAULT NULL,
  `pwd` text,
  `gender` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `unid` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `section`, `secid`, `fname`, `lname`, `phone`, `email`, `updated_at`, `online_status`, `pwd`, `gender`, `dob`, `address`, `created_on`, `logtime`, `unid`) VALUES
(1, 'OPD', 1, 'Omkar ', 'Bahiwal', '9373130909', 'r@t.co', '2020-06-05 11:31:45', 0, '$2y$10$3xVKXZxa.d24vKWsZAVTNem/Vh4FWq9EYcTtioIoPFls5lgRUBJOO', 0, '1998-09-10', 'Test', '2020-06-05 11:31:45', '2020-06-09 22:33:34', '21844'),
(2, 'Pharmacy', 2, 'Omkar', 'Bahiwal', '123123131', 'p@t.co', '2020-06-05 13:51:13', 0, '$2y$10$e5XhruQw/gnGbsJsZJbPLe5vGFGK96IK6xVS2If/ZR.Sdth8v71C2', 0, '9123-10-10', 'Test', '2020-06-05 13:51:13', '2020-06-09 20:33:14', '1234'),
(3, 'Laboratory', 3, 'Omkar', 'Bahiwal', '9373130909', 'l@t.co', '2020-06-05 14:07:56', 0, '$2y$10$OKv5ocSp4hUB1YK6k0mZqu0jhw1qSMMW2cAyjuvFYrOYiDmWrwJMa', 0, '1998-09-10', 'Test', '2020-06-05 14:07:56', '2020-06-06 23:50:43', '12345'),
(4, 'Administration', 4, 'Omkar ', 'Bahiwal', '9373130909', 'a@t.co', '2020-06-05 15:00:58', 1, '$2y$10$657GPEzxSSxCRT3PHQWNRu3rUBFQr6r5Z7UacSI1u7QX34OrA83k.', 0, '1998-09-10', 'Test Address', '2020-06-05 15:00:58', '2020-06-09 22:33:54', '12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`docid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `labtests`
--
ALTER TABLE `labtests`
  ADD PRIMARY KEY (`testid`);

--
-- Indexes for table `lab_records`
--
ALTER TABLE `lab_records`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `login_stats`
--
ALTER TABLE `login_stats`
  ADD PRIMARY KEY (`logid`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  ADD PRIMARY KEY (`stockid`);

--
-- Indexes for table `misc_logs`
--
ALTER TABLE `misc_logs`
  ADD PRIMARY KEY (`logid`);

--
-- Indexes for table `opd_prescription`
--
ALTER TABLE `opd_prescription`
  ADD PRIMARY KEY (`refid`);

--
-- Indexes for table `patient_info`
--
ALTER TABLE `patient_info`
  ADD PRIMARY KEY (`pnid`);

--
-- Indexes for table `pharmacy_stats`
--
ALTER TABLE `pharmacy_stats`
  ADD PRIMARY KEY (`logid`);

--
-- Indexes for table `prescriptionrec`
--
ALTER TABLE `prescriptionrec`
  ADD PRIMARY KEY (`recid`);

--
-- Indexes for table `screening_stats`
--
ALTER TABLE `screening_stats`
  ADD PRIMARY KEY (`logid`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`refid`);

--
-- Indexes for table `tokens_log`
--
ALTER TABLE `tokens_log`
  ADD PRIMARY KEY (`logid`);

--
-- Indexes for table `token_states`
--
ALTER TABLE `token_states`
  ADD PRIMARY KEY (`stateid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `docid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `labtests`
--
ALTER TABLE `labtests`
  MODIFY `testid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `lab_records`
--
ALTER TABLE `lab_records`
  MODIFY `recid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `login_stats`
--
ALTER TABLE `login_stats`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `mid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `medicine_stock`
--
ALTER TABLE `medicine_stock`
  MODIFY `stockid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `misc_logs`
--
ALTER TABLE `misc_logs`
  MODIFY `logid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `opd_prescription`
--
ALTER TABLE `opd_prescription`
  MODIFY `refid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `pharmacy_stats`
--
ALTER TABLE `pharmacy_stats`
  MODIFY `logid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `prescriptionrec`
--
ALTER TABLE `prescriptionrec`
  MODIFY `recid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `screening_stats`
--
ALTER TABLE `screening_stats`
  MODIFY `logid` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `refid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tokens_log`
--
ALTER TABLE `tokens_log`
  MODIFY `logid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `token_states`
--
ALTER TABLE `token_states`
  MODIFY `stateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
