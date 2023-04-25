-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2023 at 03:03 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `com_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_classroom`
--

CREATE TABLE `tb_classroom` (
  `classroom_id` int(11) NOT NULL,
  `classroom_des` varchar(255) NOT NULL,
  `year_no` int(11) NOT NULL,
  `class_no` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `classroom_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_classroom`
--

INSERT INTO `tb_classroom` (`classroom_id`, `classroom_des`, `year_no`, `class_no`, `course_id`, `classroom_status`) VALUES
(29, '1 COM 1', 1, 1, 1, 1),
(30, '2 COM 1', 2, 1, 1, 1),
(31, '3 COM 1', 3, 1, 1, 1),
(32, '4 COM 1', 4, 1, 1, 1),
(33, '1 COM 2', 1, 2, 1, 1),
(34, '2 COM 2', 2, 2, 1, 1),
(35, '3 COM 2', 3, 2, 1, 1),
(36, '4 COM 2', 4, 2, 1, 1),
(37, '1 IT 1', 1, 1, 2, 1),
(38, '2 IT 1', 2, 1, 2, 1),
(39, '3 IT 1', 3, 1, 2, 1),
(40, '4 IT 1', 4, 1, 2, 1),
(41, '1 IT 2', 1, 2, 2, 1),
(42, '2 IT 2', 2, 2, 2, 1),
(43, '3 IT 2', 3, 2, 2, 1),
(44, '4 IT 2', 4, 2, 2, 1),
(45, '1 COM CON 1', 1, 1, 3, 1),
(46, '2 COM CON 1', 2, 1, 3, 1),
(47, '1 COM CON 2', 1, 2, 3, 1),
(48, '2 COM CON 2', 2, 2, 3, 1),
(49, '1 IT CON 1', 1, 1, 4, 1),
(50, '2 IT CON 1', 2, 1, 4, 1),
(51, '1 IT CON 2', 1, 2, 4, 1),
(52, '2 IT CON 2', 2, 2, 4, 1),
(53, '1 IT 3', 1, 3, 2, 1),
(54, '2 IT 3', 2, 3, 2, 1),
(55, '3 IT 3', 3, 3, 2, 1),
(56, '4 IT 3', 4, 3, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_course`
--

CREATE TABLE `tb_course` (
  `course_id` int(11) NOT NULL,
  `scheme_id` int(11) NOT NULL,
  `course_des` varchar(255) NOT NULL,
  `class_pattern` varchar(255) NOT NULL,
  `course_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_course`
--

INSERT INTO `tb_course` (`course_id`, `scheme_id`, `course_des`, `class_pattern`, `course_status`) VALUES
(1, 1, 'ວິສະວະກໍາ ຄອມພິວເຕີ', '[year_no] COM [class_no]', 1),
(2, 1, 'ວິສະວະກໍາ ຂໍ້ມູນຂ່າວສານ', '[year_no] IT [class_no]', 1),
(3, 2, 'ວິສະວະກໍາ ຄອມພິວເຕີ', '[year_no] COM CON [class_no]', 1),
(4, 2, 'ວິສະວະກໍາ ຂໍ້ມູນຂ່າວສານ', '[year_no] IT CON [class_no]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_group_permission`
--

CREATE TABLE `tb_group_permission` (
  `id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_group_permission`
--

INSERT INTO `tb_group_permission` (`id`, `user_group_id`, `module_id`) VALUES
(1, 1, 34),
(2, 1, 35),
(3, 1, 36),
(4, 1, 30),
(5, 1, 31),
(6, 1, 32),
(7, 1, 33),
(8, 1, 25),
(9, 1, 26),
(10, 1, 27),
(11, 1, 28),
(12, 1, 29),
(13, 1, 17),
(14, 1, 18),
(15, 1, 19),
(16, 1, 20),
(17, 1, 21),
(18, 1, 22),
(19, 1, 23),
(20, 1, 24),
(30, 2, 17);

-- --------------------------------------------------------

--
-- Table structure for table `tb_module`
--

CREATE TABLE `tb_module` (
  `module_id` int(11) NOT NULL,
  `module_code` varchar(50) NOT NULL,
  `module_des` text NOT NULL,
  `module_group_id` int(11) NOT NULL,
  `module_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_module`
--

INSERT INTO `tb_module` (`module_id`, `module_code`, `module_des`, `module_group_id`, `module_status`) VALUES
(17, 'manage_em', 'ຈັດການຂໍ້ມູນພະນັກງານ', 1, 1),
(18, 'manage_user_group', 'ຈັດການກຸ່ມຜູ້ໃຊ້ງານລະບົບ', 1, 1),
(19, 'change_user_pwd', 'ປ່ຽນລະຫັດຜ່ານໃຫ້ຜູ້ໃຊ້ອື່ນ', 1, 1),
(20, 'manage_permission', 'ກໍານົດສິດການເຂົ້າໃຊ້ງານລະບົບ', 1, 1),
(21, 'manage_course', 'ຈັດການຂໍ້ມູນຫຼັກສູດ', 1, 1),
(22, 'manage_course_year', 'ຈັດການຂໍ້ມູນປີຮຽນ', 1, 0),
(23, 'manage_classroom', 'ຈັດການຂໍ້ມູນຫ້ອງຮຽນ', 1, 1),
(24, 'manage_student', 'ຈັດການຂໍ້ມູນນັກສຶກສາ', 1, 1),
(25, 'access_em', 'ເຂົ້າເຖິງຂໍ້ມູນພະນັກງານ', 2, 1),
(26, 'access_user_group', 'ເຂົ້າເຖິງຂໍ້ມູນກຸ່ມຜູ້ໃຊ້ງານລະບົບ', 2, 1),
(27, 'access_course', 'ເຂົ້າເຖິງຂໍ້ມູນຫຼັກສູດ', 2, 1),
(28, 'access_classroom', 'ເຂົ້າເຖິງຂໍ້ມູນຫ້ອງຮຽນ', 2, 1),
(29, 'access_student', 'ເຂົ້າເຖິງຂໍ້ມູນນັກສຶກສາ', 2, 1),
(30, 'module_register', 'ແຈ້ງລົງທະບຽນ', 3, 1),
(31, 'module_class_member', 'ຈັດຫ້ອງຮຽນ', 3, 1),
(32, 'module_drop_lerning', 'ແຈ້ງຢຸດຮຽນຊົ່ວຄາວ', 3, 1),
(33, 'module_register_check', 'ກວດການລົງທະບຽນ', 3, 1),
(34, 'student_report', 'ລາຍງານຂໍ້ມູນນັກສຶກສາ', 4, 1),
(35, 'register_report', 'ລາຍງານການລົງທະບຽນ', 4, 1),
(36, 'drop_lerning_report', 'ລາຍງານການຢຸດຮຽນຊົ່ວຄາວ', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_module_group`
--

CREATE TABLE `tb_module_group` (
  `module_group_id` int(11) NOT NULL,
  `module_group_des` text NOT NULL,
  `module_group_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_module_group`
--

INSERT INTO `tb_module_group` (`module_group_id`, `module_group_des`, `module_group_status`) VALUES
(1, 'ຈັດການຂໍ້ມູນ', 1),
(2, 'ການເຂົ້າເຖິງຂໍ້ມູນ', 1),
(3, 'ການໃຊ້ງານລະບົບ', 1),
(4, 'ລາຍງານ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_scheme`
--

CREATE TABLE `tb_scheme` (
  `scheme_id` int(11) NOT NULL,
  `scheme_des` varchar(255) NOT NULL,
  `duration_year` int(11) NOT NULL,
  `scheme_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_scheme`
--

INSERT INTO `tb_scheme` (`scheme_id`, `scheme_des`, `duration_year`, `scheme_status`) VALUES
(1, 'ປະລິນຍາຕີ', 4, 1),
(2, 'ປະລິນຍາຕີ (ຕໍ່ເນື້ອງ)', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `student_id` int(11) NOT NULL,
  `student_code` varchar(255) NOT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `name_la` text DEFAULT NULL,
  `name_en` text DEFAULT NULL,
  `surname_la` text DEFAULT NULL,
  `surname_en` text DEFAULT NULL,
  `date_of_birthday` date DEFAULT NULL,
  `birth_address_la` varchar(500) DEFAULT NULL,
  `birth_address_en` varchar(500) DEFAULT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `current_year` int(11) NOT NULL DEFAULT 1,
  `remark` text DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_status` enum('ACTIVE','DELETED','DROPPED') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`student_id`, `student_code`, `gender`, `name_la`, `name_en`, `surname_la`, `surname_en`, `date_of_birthday`, `birth_address_la`, `birth_address_en`, `start_year`, `end_year`, `course_id`, `current_year`, `remark`, `last_update`, `student_status`) VALUES
(265, '225Q0080/19', 'ທ້າວ', 'ວິຊະວະ', NULL, 'ທຳມະວົງ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(266, '225Q0082/20', 'ທ້າວ', 'ອະນິສອນ', NULL, 'ໄຊຍະວົງ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(267, '225Q0082/21', 'ທ້າວ', 'ອະນິສອນ', NULL, 'ໄຊຍະວົງ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(268, '225Q0085/20', 'ທ້າວ', 'ສຸລິຍາ', NULL, 'ສະຫວັດດີ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(269, '225Q0086/20', 'ທ້າວ', 'ຕົ່ງຢ່າງ', NULL, 'ເຍ່ຍຢີຢ່າງ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(270, '225Q0087/20', 'ທ້າວ', 'ແສນດີ', NULL, 'ຫຼວງຄຳຊາວ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(271, '225Q0088/20', 'ທ້າວ', 'ພູພະຈັນ', NULL, 'ບຸດຕະວົງ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(272, '225Q0089/20', 'ນາງ', 'ນຸ້ມນິ້ມ', NULL, 'ທອງສະຫວັດ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(273, '225Q0146/20', 'ທ້າວ', 'ເດືອນມົວ', NULL, 'ຢ່າເຊັ່ງ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE'),
(274, '225Q0175/20', 'ນາງ', 'ລັດສຸດາ', NULL, 'ວົງຖາວະດີ', NULL, NULL, NULL, NULL, 2023, 2027, 1, 1, '', '2023-04-18 03:31:57', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_log`
--

CREATE TABLE `tb_student_log` (
  `id` int(11) NOT NULL,
  `student_code` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `userparse` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_student_log`
--

INSERT INTO `tb_student_log` (`id`, `student_code`, `desc`, `issue_date`, `userparse`) VALUES
(280, '225Q0080/19', 'created', '2023-04-18 03:31:57', 'tik'),
(281, '225Q0082/20', 'created', '2023-04-18 03:31:57', 'tik'),
(282, '225Q0082/21', 'created', '2023-04-18 03:31:57', 'tik'),
(283, '225Q0085/20', 'created', '2023-04-18 03:31:57', 'tik'),
(284, '225Q0086/20', 'created', '2023-04-18 03:31:57', 'tik'),
(285, '225Q0087/20', 'created', '2023-04-18 03:31:57', 'tik'),
(286, '225Q0088/20', 'created', '2023-04-18 03:31:57', 'tik'),
(287, '225Q0089/20', 'created', '2023-04-18 03:31:57', 'tik'),
(288, '225Q0146/20', 'created', '2023-04-18 03:31:57', 'tik'),
(289, '225Q0175/20', 'created', '2023-04-18 03:31:57', 'tik'),
(290, '225Q0080/19', 'set classroom to 1 COM 1', '2023-04-18 03:33:09', 'tik'),
(291, '225Q0082/20', 'set classroom to 1 COM 1', '2023-04-18 03:33:11', 'tik'),
(292, '225Q0082/21', 'set classroom to 1 COM 1', '2023-04-18 03:33:17', 'tik'),
(293, '225Q0085/20', 'set classroom to 1 COM 1', '2023-04-18 03:33:18', 'tik'),
(294, '225Q0086/20', 'set classroom to 1 COM 2', '2023-04-18 03:33:19', 'tik'),
(295, '225Q0087/20', 'set classroom to 1 COM 2', '2023-04-18 03:33:20', 'tik'),
(296, '225Q0088/20', 'set classroom to 1 COM 2', '2023-04-18 03:33:21', 'tik'),
(297, '225Q0089/20', 'set classroom to 1 COM 2', '2023-04-18 03:33:22', 'tik'),
(298, '225Q0146/20', 'set classroom to 1 COM 1', '2023-04-18 03:33:23', 'tik'),
(299, '225Q0175/20', 'set classroom to 1 COM 1', '2023-04-18 03:33:23', 'tik'),
(300, '225Q0080/19', 'Register year 1', '2023-04-24 08:08:30', 'tik');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_register`
--

CREATE TABLE `tb_student_register` (
  `register_id` int(11) NOT NULL,
  `student_code` varchar(255) NOT NULL,
  `school_year` varchar(255) NOT NULL,
  `year_no` int(11) NOT NULL,
  `classroom_id` int(11) DEFAULT NULL,
  `classroom_des` varchar(50) DEFAULT NULL,
  `create_date` date NOT NULL,
  `last_update` datetime NOT NULL DEFAULT current_timestamp(),
  `user_update` varchar(255) NOT NULL,
  `register_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_student_register`
--

INSERT INTO `tb_student_register` (`register_id`, `student_code`, `school_year`, `year_no`, `classroom_id`, `classroom_des`, `create_date`, `last_update`, `user_update`, `register_status`) VALUES
(591, '225Q0080/19', '2023-2024', 1, 29, '1 COM 1', '2023-04-18', '2023-04-24 15:08:30', 'tik', 1),
(592, '225Q0080/19', '2024-2025', 2, 30, '2 COM 1', '2023-04-18', '2023-04-18 10:33:09', 'tik', 0),
(593, '225Q0080/19', '2025-2026', 3, 31, '3 COM 1', '2023-04-18', '2023-04-18 10:33:09', 'tik', 0),
(594, '225Q0080/19', '2026-2027', 4, 32, '4 COM 1', '2023-04-18', '2023-04-18 10:33:09', 'tik', 0),
(595, '225Q0082/20', '2023-2024', 1, 29, '1 COM 1', '2023-04-18', '2023-04-18 10:33:11', 'tik', 0),
(596, '225Q0082/20', '2024-2025', 2, 30, '2 COM 1', '2023-04-18', '2023-04-18 10:33:11', 'tik', 0),
(597, '225Q0082/20', '2025-2026', 3, 31, '3 COM 1', '2023-04-18', '2023-04-18 10:33:11', 'tik', 0),
(598, '225Q0082/20', '2026-2027', 4, 32, '4 COM 1', '2023-04-18', '2023-04-18 10:33:11', 'tik', 0),
(599, '225Q0082/21', '2023-2024', 1, 29, '1 COM 1', '2023-04-18', '2023-04-18 10:33:17', 'tik', 0),
(600, '225Q0082/21', '2024-2025', 2, 30, '2 COM 1', '2023-04-18', '2023-04-18 10:33:17', 'tik', 0),
(601, '225Q0082/21', '2025-2026', 3, 31, '3 COM 1', '2023-04-18', '2023-04-18 10:33:17', 'tik', 0),
(602, '225Q0082/21', '2026-2027', 4, 32, '4 COM 1', '2023-04-18', '2023-04-18 10:33:17', 'tik', 0),
(603, '225Q0085/20', '2023-2024', 1, 29, '1 COM 1', '2023-04-18', '2023-04-18 10:33:18', 'tik', 0),
(604, '225Q0085/20', '2024-2025', 2, 30, '2 COM 1', '2023-04-18', '2023-04-18 10:33:18', 'tik', 0),
(605, '225Q0085/20', '2025-2026', 3, 31, '3 COM 1', '2023-04-18', '2023-04-18 10:33:18', 'tik', 0),
(606, '225Q0085/20', '2026-2027', 4, 32, '4 COM 1', '2023-04-18', '2023-04-18 10:33:18', 'tik', 0),
(607, '225Q0086/20', '2023-2024', 1, 33, '1 COM 2', '2023-04-18', '2023-04-18 10:33:19', 'tik', 0),
(608, '225Q0086/20', '2024-2025', 2, 34, '2 COM 2', '2023-04-18', '2023-04-18 10:33:19', 'tik', 0),
(609, '225Q0086/20', '2025-2026', 3, 35, '3 COM 2', '2023-04-18', '2023-04-18 10:33:19', 'tik', 0),
(610, '225Q0086/20', '2026-2027', 4, 36, '4 COM 2', '2023-04-18', '2023-04-18 10:33:19', 'tik', 0),
(611, '225Q0087/20', '2023-2024', 1, 33, '1 COM 2', '2023-04-18', '2023-04-18 10:33:20', 'tik', 0),
(612, '225Q0087/20', '2024-2025', 2, 34, '2 COM 2', '2023-04-18', '2023-04-18 10:33:20', 'tik', 0),
(613, '225Q0087/20', '2025-2026', 3, 35, '3 COM 2', '2023-04-18', '2023-04-18 10:33:20', 'tik', 0),
(614, '225Q0087/20', '2026-2027', 4, 36, '4 COM 2', '2023-04-18', '2023-04-18 10:33:20', 'tik', 0),
(615, '225Q0088/20', '2023-2024', 1, 33, '1 COM 2', '2023-04-18', '2023-04-18 10:33:21', 'tik', 0),
(616, '225Q0088/20', '2024-2025', 2, 34, '2 COM 2', '2023-04-18', '2023-04-18 10:33:21', 'tik', 0),
(617, '225Q0088/20', '2025-2026', 3, 35, '3 COM 2', '2023-04-18', '2023-04-18 10:33:21', 'tik', 0),
(618, '225Q0088/20', '2026-2027', 4, 36, '4 COM 2', '2023-04-18', '2023-04-18 10:33:21', 'tik', 0),
(619, '225Q0089/20', '2023-2024', 1, 33, '1 COM 2', '2023-04-18', '2023-04-18 10:33:22', 'tik', 0),
(620, '225Q0089/20', '2024-2025', 2, 34, '2 COM 2', '2023-04-18', '2023-04-18 10:33:22', 'tik', 0),
(621, '225Q0089/20', '2025-2026', 3, 35, '3 COM 2', '2023-04-18', '2023-04-18 10:33:22', 'tik', 0),
(622, '225Q0089/20', '2026-2027', 4, 36, '4 COM 2', '2023-04-18', '2023-04-18 10:33:22', 'tik', 0),
(623, '225Q0146/20', '2023-2024', 1, 29, '1 COM 1', '2023-04-18', '2023-04-18 10:33:23', 'tik', 0),
(624, '225Q0146/20', '2024-2025', 2, 30, '2 COM 1', '2023-04-18', '2023-04-18 10:33:23', 'tik', 0),
(625, '225Q0146/20', '2025-2026', 3, 31, '3 COM 1', '2023-04-18', '2023-04-18 10:33:23', 'tik', 0),
(626, '225Q0146/20', '2026-2027', 4, 32, '4 COM 1', '2023-04-18', '2023-04-18 10:33:23', 'tik', 0),
(627, '225Q0175/20', '2023-2024', 1, 29, '1 COM 1', '2023-04-18', '2023-04-18 10:33:23', 'tik', 0),
(628, '225Q0175/20', '2024-2025', 2, 30, '2 COM 1', '2023-04-18', '2023-04-18 10:33:23', 'tik', 0),
(629, '225Q0175/20', '2025-2026', 3, 31, '3 COM 1', '2023-04-18', '2023-04-18 10:33:23', 'tik', 0),
(630, '225Q0175/20', '2026-2027', 4, 32, '4 COM 1', '2023-04-18', '2023-04-18 10:33:23', 'tik', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `gender` int(11) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `fullname`, `gender`, `phone_number`, `user_group_id`, `username`, `password`, `user_status`) VALUES
(1, 'Tik KHAMTHALAR', 1, '020 55210711', 1, 'tik', '$2y$10$mtjy..kLYlrFkqduudN39uk8lBW4V9Vd1WnitlHy8V8BFZFBmwO/W', 1),
(2, 'demo', 1, '020 55667788', 2, 'demo', '$2y$10$cweHxNA/AOW1sYFe3UsPveEcsax6eFfdfx/rHhgkb9TxQB7hOlXVO', 1),
(3, 'ຫອມສຸດາ', 2, '020', 1, 'hom', '$2y$10$x1MWtYuzs.lYy61jUI9fIu5bzmIpIXxAymQnfMR0ko.GUIFu2v2R.', 1),
(4, 'ສິງຄໍາ', 1, NULL, 1, 'jia', '$2y$10$VhfN1aYzi7zHV4nZEBDelOOFVKnVgrKKMS0Qojixxv4elbaXnaNe6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_group`
--

CREATE TABLE `tb_user_group` (
  `user_group_id` int(11) NOT NULL,
  `group_des` text NOT NULL,
  `read_only` int(11) NOT NULL DEFAULT 0,
  `user_group_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_group`
--

INSERT INTO `tb_user_group` (`user_group_id`, `group_des`, `read_only`, `user_group_status`) VALUES
(1, 'ຜູ້ຄຸມລະບົບ', 0, 1),
(2, 'ບໍລະຫານ', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_classroom`
--
ALTER TABLE `tb_classroom`
  ADD PRIMARY KEY (`classroom_id`);

--
-- Indexes for table `tb_course`
--
ALTER TABLE `tb_course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tb_group_permission`
--
ALTER TABLE `tb_group_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_module`
--
ALTER TABLE `tb_module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `tb_module_group`
--
ALTER TABLE `tb_module_group`
  ADD PRIMARY KEY (`module_group_id`);

--
-- Indexes for table `tb_scheme`
--
ALTER TABLE `tb_scheme`
  ADD PRIMARY KEY (`scheme_id`);

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tb_student_log`
--
ALTER TABLE `tb_student_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_student_register`
--
ALTER TABLE `tb_student_register`
  ADD PRIMARY KEY (`register_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_classroom`
--
ALTER TABLE `tb_classroom`
  MODIFY `classroom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tb_course`
--
ALTER TABLE `tb_course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_group_permission`
--
ALTER TABLE `tb_group_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_module`
--
ALTER TABLE `tb_module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tb_module_group`
--
ALTER TABLE `tb_module_group`
  MODIFY `module_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_scheme`
--
ALTER TABLE `tb_scheme`
  MODIFY `scheme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT for table `tb_student_log`
--
ALTER TABLE `tb_student_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `tb_student_register`
--
ALTER TABLE `tb_student_register`
  MODIFY `register_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=631;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
