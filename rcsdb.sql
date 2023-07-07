-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2023 at 11:55 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rcsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `center`
--

CREATE TABLE `center` (
  `c_id` int(11) NOT NULL,
  `c_rcs_No` varchar(255) NOT NULL,
  `c_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `center`
--

INSERT INTO `center` (`c_id`, `c_rcs_No`, `c_Name`) VALUES
(4, 'D1', 'madam kai'),
(5, 'z1234', 'madam kai');

-- --------------------------------------------------------

--
-- Table structure for table `effects`
--

CREATE TABLE `effects` (
  `e_id` int(11) NOT NULL,
  `e_rcsNo` varchar(255) NOT NULL,
  `e_1` varchar(255) NOT NULL,
  `e_2` varchar(255) NOT NULL,
  `e_3` varchar(255) NOT NULL,
  `e_4` varchar(255) NOT NULL,
  `e_5` varchar(255) NOT NULL,
  `e_6` varchar(255) NOT NULL,
  `e_7` varchar(255) NOT NULL,
  `e_8` varchar(255) NOT NULL,
  `e_9` varchar(255) NOT NULL,
  `e_allow` varchar(255) NOT NULL,
  `e_Rname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `effects`
--

INSERT INTO `effects` (`e_id`, `e_rcsNo`, `e_1`, `e_2`, `e_3`, `e_4`, `e_5`, `e_6`, `e_7`, `e_8`, `e_9`, `e_allow`, `e_Rname`) VALUES
(3, 'D1', 'กระทบ', 'กระทบ', 'ไม่กระทบ', 'กระทบ', 'ไม่กระทบ', 'กระทบ', 'ไม่กระทบ', 'ไม่กระทบ', 'ไม่กระทบ', 'ได้', 'madam kai'),
(4, 'z1234', 'กระทบ', 'ไม่กระทบ', 'ไม่กระทบ', 'กระทบ', 'กระทบ', 'ไม่กระทบ', 'ไม่กระทบ', 'ไม่กระทบ', 'ไม่กระทบ', 'ได้', 'madam kai');

-- --------------------------------------------------------

--
-- Table structure for table `objects`
--

CREATE TABLE `objects` (
  `obj_id` varchar(255) NOT NULL,
  `obj_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `objects`
--

INSERT INTO `objects` (`obj_id`, `obj_value`) VALUES
('12356', 'ปรับปรุงกระบานการผลิต'),
('12356', 'แก้ไขปัญหาการผลิต'),
('12356', 'เพิ่มผลผลิต'),
('12356', ''),
('a123', 'ปรับปรุงกระบานการผลิต'),
('a123', 'แก้ไขปัญหาการผลิต'),
('a123', 'ECR หรือ ECN'),
('b123', 'ลดต้นทุน'),
('b123', 'asdasd'),
('c1234', 'ลดต้นทุน'),
('c1234', 'แก้ไขปัญหาการผลิต'),
('c1234', 'เพิ่มผลผลิต'),
('c1234', 'ECR หรือ ECN'),
('E1', 'ปรับปรุงกระบานการผลิต'),
('E1', 'แก้ไขปัญหาการผลิต'),
('E1', 'ECR หรือ ECN'),
('D1', 'ปรับปรุงกระบานการผลิต'),
('D1', 'ลดต้นทุน'),
('D1', 'ปรับปรุงคุณภาพ'),
('D1', 'ECR หรือ ECN'),
('z1234', 'ปรับปรุงคุณภาพ'),
('z1234', 'เพิ่มผลผลิต'),
('z1234', 'ECR หรือ ECN'),
('h1234', 'ปรับปรุงกระบานการผลิต'),
('h1234', 'ลดต้นทุน'),
('h1234', 'ECR หรือ ECN'),
('h1234', 'ก็นั้นเเหละ'),
('m6778', 'ปรับปรุงกระบานการผลิต'),
('m6778', 'ปรับปรุงคุณภาพ'),
('m6778', 'เพิ่มผลผลิต'),
('m6778', 'ECR หรือ ECN');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `re_id` int(11) NOT NULL,
  `re_rcsNo` varchar(255) NOT NULL,
  `re_to` varchar(255) NOT NULL,
  `re_pName` varchar(255) NOT NULL,
  `re_pNo` varchar(255) NOT NULL,
  `re_model` varchar(255) NOT NULL,
  `re_obj` varchar(255) NOT NULL,
  `re_from` varchar(255) NOT NULL,
  `re_problem` varchar(255) NOT NULL,
  `re_change` varchar(255) NOT NULL,
  `re_user_Rname` varchar(255) NOT NULL,
  `rcs_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`re_id`, `re_rcsNo`, `re_to`, `re_pName`, `re_pNo`, `re_model`, `re_obj`, `re_from`, `re_problem`, `re_change`, `re_user_Rname`, `rcs_status`) VALUES
(7, 'D1', 'manager monkey', 'AZURE', '56-7', 'XZ-3-2', 'D1', 'EIEI', 'asdkf;laksdfl;\'ksadlfkasd\';lfaDSasdfasdfasASDadfasdfasdfsADFasedASDaewrASDF', 'asdasl;dkfl;sadkf;lsadkf;adsasdASDasdASDSADasdaSDasdASDasdASD', 'santhiti malee', 'Approved'),
(8, 'z1234', 'manager monkey', 'glass', 'g123', 'XZ-3-8', 'z1234', 'EIEI', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to ', 'santhiti malee', 'F MANAGER'),
(9, 'h1234', 'manager monkey', 'door', 'ASe67', 's123asd', 'h1234', 'KAI', 'เละเทะมากกกกกกกกกกก', 'ลบใหม่หมด', 'santhiti malee', 'ไม่อนุญาติ'),
(10, 'm6778', 'santhiti malee', 'hotdog', '09kkk', 'godcat', 'm6778', 'KAI', 'asdasdasdweftsdfwERSDFafsDF', 'SDfAFQWEGASSdfwEFASDFDfASDSGASDDsdfasdfADasfASFasfADF', 'manager monkey', 'Manager1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_gmail` varchar(255) NOT NULL,
  `user_Rname` varchar(255) NOT NULL,
  `user_position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_gmail`, `user_Rname`, `user_position`) VALUES
(1, 'earth', '12345', 'earthfg@gmail.com', 'santhiti malee', 'requestor'),
(2, 'mixzaza', '12345', 'earthfg@gmail.com', 'madam kai', 'center'),
(3, 'Monk', 'm1234', 'earthfg@gmail.com', 'manager monkey', 'manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `center`
--
ALTER TABLE `center`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `effects`
--
ALTER TABLE `effects`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`re_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `center`
--
ALTER TABLE `center`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `effects`
--
ALTER TABLE `effects`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `re_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
