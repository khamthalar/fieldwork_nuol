-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2022 at 08:52 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `COM_DB`
--

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
(20, 1, 24);

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
(22, 'manage_course_year', 'ຈັດການຂໍ້ມູນປີຮຽນ', 1, 1),
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
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `gender` int(11) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `fullname`, `gender`, `phone_number`, `user_group_id`, `username`, `password`, `user_status`) VALUES
(1, 'Tik KHAMTHALAR', 1, '020 55210711', 1, 'tik', '$2y$10$QLYlErxoIx43KP3qPH6pv.1zs7dIgrdprW4lE3nedaCzAvh4T8B56', 1);

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
(1, 'ຜູ້ຄຸມລະບົບ', 0, 1);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `tb_group_permission`
--
ALTER TABLE `tb_group_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_user_group`
--
ALTER TABLE `tb_user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
