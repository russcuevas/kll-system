-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 06:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kll_future`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `profile_picture`, `fullname`, `email`, `password`, `contact_number`, `created_at`, `updated_at`) VALUES
(7, '6806ff0ea1753.jpg', 'Mark Angelo Tiquis', 'markangelotiquis@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '09495748302', '2025-04-04 02:04:08', '2025-04-22 02:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chatbot`
--

CREATE TABLE `tbl_chatbot` (
  `id` int(11) NOT NULL,
  `chat_question` text NOT NULL,
  `bot_response` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sequence` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_chatbot`
--

INSERT INTO `tbl_chatbot` (`id`, `chat_question`, `bot_response`, `created_at`, `updated_at`, `sequence`) VALUES
(12, 'Get started', 'You can check the offered course ✔️\r\nYou can inquire to us by using contact us ✔️\r\nStay updated ✔️', '2025-04-21 08:44:14', '2025-04-21 08:44:14', 1),
(13, 'Check offered course', 'Bachelor of Elementary Education (BEEd)\r\n\r\nBachelor of Secondary Education (BSEd)\r\n\r\nBachelor of Science in Business Administration (BSBA)\r\n\r\nBachelor of Arts in Communication (BA Comm)\r\n\r\nBachelor of Science in Computer Science (BSCS)\r\n\r\nBachelor of Science in Criminology (BSCrim)\r\n\r\nBachelor of Science in Nursing (BSN)\r\n\r\nAssociation of Computer Technology (ACT)', '2025-04-22 00:56:48', '2025-04-22 00:56:48', 2),
(14, 'Contact us', 'Location: Marawoy-Dagatan 4217\r\nLipa Batangas Philippines\r\n\r\nEmail: college.registrar.kll\r\n\r\nContact: 0966 415 1764', '2025-04-22 00:57:34', '2025-04-22 00:57:34', 2),
(15, 'How long the course takes?', 'Bachelor of Elementary Education (BEEd) - takes 4 years without irregular\r\n\r\nBachelor of Secondary Education (BSEd) - takes 4 years without irregular\r\n\r\nBachelor of Science in Business Administration (BSBA) - takes 4 years without irregular\r\n\r\nBachelor of Arts in Communication (BA Comm) - takes 4 years without irregular\r\n\r\nBachelor of Science in Computer Science (BSCS) - takes 4 years without irregular\r\n\r\nBachelor of Science in Criminology (BSCrim) - takes 4 years without irregular\r\n\r\nBachelor of Science in Nursing (BSN) - 4 years without irregular\r\n\r\nAssociation of Computer Technology (ACT) - 2 years without irregular', '2025-04-22 01:07:35', '2025-04-22 01:07:35', 3),
(16, 'Check the description of each course', 'Bachelor of Elementary Education (BEEd) - is a four-year program that focuses on preparing excellent educators for reflective classroom practice in elementary schools.\r\n\r\nBachelor of Secondary Education (BSEd) - degree program aims to prepare students for teaching in the secondary school.\r\n\r\nBachelor of Science in Business Administration (BSBA) - is a four-year program which provides professional business and management education for those who would like to become entrepreneurs or pursue a career in any field of business such as economics, finance, human capital management, and marketing.\r\n\r\nBachelor of Arts in Communication (BA Comm) - program provides students with an in-depth understanding of critical and analytical frames used in the communication discipline.\r\n\r\nBachelor of Science in Computer Science (BSCS) - is a four-year program that includes the study of computing concepts and theories, algorithmic foundations, and new developments in computing.\r\n\r\nBachelor of Science in Criminology (BSCrim) - degree program that focuses on the study of crime, criminal behavior, and the justice system.\r\n\r\nBachelor of Science in Nursing (BSN) - program aims to develop a professional nurse who is able to assume entry-level positions in either health facilities or community settings.\r\n\r\nAssociation of Computer Technology (ACT) - is a 2-year degree program that provides specialized computing and information technology tracks equipping graduates with the required skills            ', '2025-04-22 01:08:25', '2025-04-22 01:08:25', 3),
(25, 'About KLL', 'Our students are our greatest asset, and they take center place in our community. KLL\'s students are eager learners and curious about the world around them. We aim to prepare well-rounded global citizens who strive for excellence and understand the importance of respect and tolerance for others', '2025-04-22 01:29:03', '2025-04-22 01:29:03', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE `tbl_courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_description` text NOT NULL,
  `course_picture` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`course_picture`)),
  `school_year` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`id`, `course_name`, `course_description`, `course_picture`, `school_year`, `created_at`, `updated_at`) VALUES
(12, 'Bachelor of Elementary Education (BEEd)', 'is a four-year program that focuses on preparing excellent educators for reflective classroom practice in elementary schools.', '[\"6806f43df0617.png\",\"6806f43df0bf5.jpg\"]', NULL, '2025-04-22 01:43:25', '2025-04-22 01:43:25'),
(13, 'Bachelor of Secondary Education (BSEd)', 'degree program aims to prepare students for teaching in the secondary school.', '[\"6806f56e0dde5.jpg\",\"6806f56e0e3e9.jpg\"]', NULL, '2025-04-22 01:48:30', '2025-04-22 01:48:30'),
(14, 'Bachelor of Science in Business Administration (BSBA)', 'is a four-year program which provides professional business and management education for those who would like to become entrepreneurs or pursue a career in any field of business such as economics, finance, human capital management, and marketing.', '[\"6806f5c7425ee.jpg\"]', NULL, '2025-04-22 01:49:59', '2025-04-22 01:49:59'),
(15, 'Bachelor of Arts in Communication (BA Comm)', 'program provides students with an in-depth understanding of critical and analytical frames used in the communication discipline.', '[\"6806f6ade7a8d.jpg\",\"6806f6ade81df.jpg\"]', NULL, '2025-04-22 01:53:49', '2025-04-22 01:53:49'),
(16, 'Bachelor of Science in Computer Science (BSCS)', 'is a four-year program that includes the study of computing concepts and theories, algorithmic foundations, and new developments in computing.', '[\"6806f7b72cb5a.jpg\"]', NULL, '2025-04-22 01:58:15', '2025-04-22 01:58:15'),
(17, 'Bachelor of Science in Criminology (BSCrim)', 'degree program that focuses on the study of crime, criminal behavior, and the justice system.', '[\"6806f82708feb.jpg\"]', NULL, '2025-04-22 02:00:07', '2025-04-22 02:00:07'),
(18, 'Bachelor of Science in Nursing (BSN)', 'program aims to develop a professional nurse who is able to assume entry-level positions in either health facilities or community settings.', '[\"6806f9ab1ccd1.jpg\"]', NULL, '2025-04-22 02:06:35', '2025-04-22 02:06:35'),
(19, 'Association of Computer Technology (ACT)', 'is a 2-year degree program that provides specialized computing and information technology tracks equipping graduates with the required skills', '[\"6806f9cf6e481.jpg\"]', NULL, '2025-04-22 02:07:11', '2025-04-22 02:07:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_examiners`
--

CREATE TABLE `tbl_examiners` (
  `id` int(11) NOT NULL,
  `default_id` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `age` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `strand` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_preferred_courses`
--

CREATE TABLE `tbl_preferred_courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_1` int(11) NOT NULL,
  `course_2` int(11) NOT NULL,
  `course_3` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_questions`
--

CREATE TABLE `tbl_questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_questions`
--

INSERT INTO `tbl_questions` (`id`, `question_text`, `created_at`, `updated_at`) VALUES
(20, 'I like to work on cars', '2025-04-22 15:22:51', '2025-04-22 15:22:51'),
(21, 'I like to do puzzles', '2025-04-22 15:29:35', '2025-04-22 15:29:35'),
(22, 'I am good at working independently', '2025-04-22 15:32:56', '2025-04-22 15:32:56'),
(23, 'I like to work in teams', '2025-04-22 15:33:51', '2025-04-22 15:33:51'),
(24, 'I am an ambitious person, I set goals for myself', '2025-04-22 15:34:39', '2025-04-22 15:34:39'),
(25, 'I like to organize things (files, desks/offices)', '2025-04-22 15:36:20', '2025-04-22 15:36:20'),
(26, 'I like to build things', '2025-04-22 15:37:32', '2025-04-22 15:37:32'),
(27, 'I like to read about art and music', '2025-04-22 15:40:46', '2025-04-22 15:40:46'),
(28, 'I like to have clear instructions to follow', '2025-04-22 15:41:17', '2025-04-22 15:41:17'),
(29, 'I like to try to influence or  persuade people', '2025-04-22 15:42:00', '2025-04-22 15:42:00'),
(30, 'I like to do experiments', '2025-04-22 15:42:19', '2025-04-22 15:42:19'),
(31, 'I like to teach or train people', '2025-04-22 15:42:45', '2025-04-22 15:42:45'),
(32, 'I like trying to help people solve their problems', '2025-04-22 15:43:10', '2025-04-22 15:43:10'),
(33, 'I like to take care of animals', '2025-04-22 15:43:34', '2025-04-22 15:43:34'),
(34, 'I wouldn’t mind working 8 hours  per day in an office', '2025-04-22 15:43:53', '2025-04-22 15:43:53'),
(35, 'I like selling things', '2025-04-22 15:44:14', '2025-04-22 15:44:14'),
(36, 'I enjoy creative writing', '2025-04-22 15:44:33', '2025-04-22 15:44:33'),
(37, 'I enjoy science', '2025-04-22 15:45:42', '2025-04-22 15:45:42'),
(38, 'I am quick to take on new responsibilities', '2025-04-22 15:46:12', '2025-04-22 15:46:12'),
(39, 'I am interested in healing people', '2025-04-22 15:46:26', '2025-04-22 15:46:26'),
(40, 'I enjoy trying to figure out how things work', '2025-04-22 15:48:43', '2025-04-22 15:48:43'),
(41, 'I like putting things together or assembling things', '2025-04-22 15:51:24', '2025-04-22 15:51:24'),
(42, 'I am a creative person', '2025-04-22 15:52:48', '2025-04-22 15:52:48'),
(43, ' I pay attention to details', '2025-04-22 15:53:37', '2025-04-22 15:53:37'),
(44, 'I like to do filing or typing', '2025-04-22 15:54:05', '2025-04-22 15:54:05'),
(45, 'I like to analyze things (problems/situations)', '2025-04-22 15:54:35', '2025-04-22 15:54:35'),
(46, 'I like to play instruments or sing', '2025-04-22 15:54:54', '2025-04-22 15:54:54'),
(47, 'I enjoy learning about other cultures', '2025-04-22 15:55:25', '2025-04-22 15:55:25'),
(48, 'I would like to start my own  business', '2025-04-22 15:56:09', '2025-04-22 15:56:09'),
(49, 'I like to cook', '2025-04-22 15:56:42', '2025-04-22 15:56:42'),
(50, 'I like acting in plays', '2025-04-22 15:57:02', '2025-04-22 15:57:02'),
(51, 'I am a practical person', '2025-04-22 15:57:30', '2025-04-22 15:57:30'),
(52, 'I like working with numbers or charts', '2025-04-22 15:58:28', '2025-04-22 15:58:28'),
(53, 'I like to get into discussions about issues', '2025-04-22 15:59:10', '2025-04-22 15:59:18'),
(54, 'I am good at keeping records of my work', '2025-04-22 16:00:13', '2025-04-22 16:00:13'),
(55, 'I like to lead', '2025-04-22 16:00:30', '2025-04-22 16:00:30'),
(56, 'I like working outdoors', '2025-04-22 16:00:59', '2025-04-22 16:00:59'),
(57, 'I would like to work in an office', '2025-04-22 16:04:30', '2025-04-22 16:04:30'),
(58, 'I’m good at math', '2025-04-22 16:04:49', '2025-04-22 16:04:49'),
(59, 'I like helping people', '2025-04-22 16:05:11', '2025-04-22 16:05:11'),
(60, 'I like to draw', '2025-04-22 16:05:25', '2025-04-22 16:05:25'),
(61, 'I like to give speeches', '2025-04-22 16:05:49', '2025-04-22 16:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question_courses`
--

CREATE TABLE `tbl_question_courses` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_question_courses`
--

INSERT INTO `tbl_question_courses` (`id`, `question_id`, `course_id`, `created_at`, `updated_at`) VALUES
(52, 20, 15, '2025-04-22 15:22:51', '2025-04-22 15:22:51'),
(53, 20, 16, '2025-04-22 15:22:51', '2025-04-22 15:22:51'),
(54, 20, 18, '2025-04-22 15:22:51', '2025-04-22 15:22:51'),
(55, 20, 19, '2025-04-22 15:22:51', '2025-04-22 15:22:51'),
(56, 21, 14, '2025-04-22 15:29:35', '2025-04-22 15:29:35'),
(57, 21, 16, '2025-04-22 15:29:35', '2025-04-22 15:29:35'),
(58, 21, 18, '2025-04-22 15:29:35', '2025-04-22 15:29:35'),
(59, 21, 19, '2025-04-22 15:29:35', '2025-04-22 15:29:35'),
(60, 22, 15, '2025-04-22 15:32:56', '2025-04-22 15:32:56'),
(61, 23, 12, '2025-04-22 15:33:51', '2025-04-22 15:33:51'),
(62, 23, 13, '2025-04-22 15:33:51', '2025-04-22 15:33:51'),
(63, 23, 17, '2025-04-22 15:33:51', '2025-04-22 15:33:51'),
(64, 23, 18, '2025-04-22 15:33:51', '2025-04-22 15:33:51'),
(65, 24, 14, '2025-04-22 15:34:39', '2025-04-22 15:34:39'),
(66, 24, 15, '2025-04-22 15:34:39', '2025-04-22 15:34:39'),
(67, 24, 17, '2025-04-22 15:34:39', '2025-04-22 15:34:39'),
(68, 25, 14, '2025-04-22 15:36:20', '2025-04-22 15:36:20'),
(69, 25, 16, '2025-04-22 15:36:20', '2025-04-22 15:36:20'),
(70, 25, 18, '2025-04-22 15:36:20', '2025-04-22 15:36:20'),
(71, 25, 19, '2025-04-22 15:36:20', '2025-04-22 15:36:20'),
(72, 26, 14, '2025-04-22 15:37:32', '2025-04-22 15:37:32'),
(73, 26, 16, '2025-04-22 15:37:32', '2025-04-22 15:37:32'),
(74, 26, 18, '2025-04-22 15:37:32', '2025-04-22 15:37:32'),
(75, 26, 19, '2025-04-22 15:37:32', '2025-04-22 15:37:32'),
(76, 27, 12, '2025-04-22 15:40:46', '2025-04-22 15:40:46'),
(77, 27, 13, '2025-04-22 15:40:46', '2025-04-22 15:40:46'),
(78, 27, 17, '2025-04-22 15:40:46', '2025-04-22 15:40:46'),
(79, 27, 18, '2025-04-22 15:40:46', '2025-04-22 15:40:46'),
(80, 28, 15, '2025-04-22 15:41:17', '2025-04-22 15:41:17'),
(81, 28, 16, '2025-04-22 15:41:17', '2025-04-22 15:41:17'),
(82, 28, 18, '2025-04-22 15:41:17', '2025-04-22 15:41:17'),
(83, 28, 19, '2025-04-22 15:41:17', '2025-04-22 15:41:17'),
(84, 29, 15, '2025-04-22 15:42:00', '2025-04-22 15:42:00'),
(85, 29, 16, '2025-04-22 15:42:00', '2025-04-22 15:42:00'),
(86, 29, 18, '2025-04-22 15:42:00', '2025-04-22 15:42:00'),
(87, 29, 19, '2025-04-22 15:42:00', '2025-04-22 15:42:00'),
(88, 30, 14, '2025-04-22 15:42:19', '2025-04-22 15:42:19'),
(89, 30, 15, '2025-04-22 15:42:19', '2025-04-22 15:42:19'),
(90, 30, 17, '2025-04-22 15:42:19', '2025-04-22 15:42:19'),
(91, 31, 15, '2025-04-22 15:42:45', '2025-04-22 15:42:45'),
(92, 32, 15, '2025-04-22 15:43:10', '2025-04-22 15:43:10'),
(93, 33, 14, '2025-04-22 15:43:34', '2025-04-22 15:43:34'),
(94, 33, 16, '2025-04-22 15:43:34', '2025-04-22 15:43:34'),
(95, 33, 18, '2025-04-22 15:43:34', '2025-04-22 15:43:34'),
(96, 33, 19, '2025-04-22 15:43:34', '2025-04-22 15:43:34'),
(97, 34, 15, '2025-04-22 15:43:53', '2025-04-22 15:43:53'),
(98, 34, 16, '2025-04-22 15:43:53', '2025-04-22 15:43:53'),
(99, 34, 18, '2025-04-22 15:43:53', '2025-04-22 15:43:53'),
(100, 34, 19, '2025-04-22 15:43:53', '2025-04-22 15:43:53'),
(101, 35, 14, '2025-04-22 15:44:14', '2025-04-22 15:44:14'),
(102, 35, 16, '2025-04-22 15:44:14', '2025-04-22 15:44:14'),
(103, 35, 18, '2025-04-22 15:44:14', '2025-04-22 15:44:14'),
(104, 35, 19, '2025-04-22 15:44:14', '2025-04-22 15:44:14'),
(105, 36, 12, '2025-04-22 15:44:33', '2025-04-22 15:44:33'),
(106, 36, 13, '2025-04-22 15:44:33', '2025-04-22 15:44:33'),
(107, 36, 17, '2025-04-22 15:44:33', '2025-04-22 15:44:33'),
(108, 36, 18, '2025-04-22 15:44:33', '2025-04-22 15:44:33'),
(109, 37, 14, '2025-04-22 15:45:42', '2025-04-22 15:45:42'),
(110, 37, 15, '2025-04-22 15:45:42', '2025-04-22 15:45:42'),
(111, 37, 17, '2025-04-22 15:45:42', '2025-04-22 15:45:42'),
(112, 38, 14, '2025-04-22 15:46:12', '2025-04-22 15:46:12'),
(113, 38, 16, '2025-04-22 15:46:12', '2025-04-22 15:46:12'),
(114, 38, 18, '2025-04-22 15:46:12', '2025-04-22 15:46:12'),
(115, 38, 19, '2025-04-22 15:46:12', '2025-04-22 15:46:12'),
(116, 39, 15, '2025-04-22 15:46:26', '2025-04-22 15:46:26'),
(117, 40, 14, '2025-04-22 15:48:43', '2025-04-22 15:48:43'),
(118, 40, 15, '2025-04-22 15:48:43', '2025-04-22 15:48:43'),
(119, 40, 17, '2025-04-22 15:48:43', '2025-04-22 15:48:43'),
(120, 41, 15, '2025-04-22 15:51:24', '2025-04-22 15:51:24'),
(121, 41, 16, '2025-04-22 15:51:24', '2025-04-22 15:51:24'),
(122, 41, 18, '2025-04-22 15:51:24', '2025-04-22 15:51:24'),
(123, 41, 19, '2025-04-22 15:51:24', '2025-04-22 15:51:24'),
(124, 42, 15, '2025-04-22 15:52:48', '2025-04-22 15:52:48'),
(125, 43, 14, '2025-04-22 15:53:37', '2025-04-22 15:53:37'),
(126, 43, 16, '2025-04-22 15:53:37', '2025-04-22 15:53:37'),
(127, 43, 18, '2025-04-22 15:53:37', '2025-04-22 15:53:37'),
(128, 43, 19, '2025-04-22 15:53:37', '2025-04-22 15:53:37'),
(129, 44, 14, '2025-04-22 15:54:05', '2025-04-22 15:54:05'),
(130, 44, 16, '2025-04-22 15:54:05', '2025-04-22 15:54:05'),
(131, 44, 18, '2025-04-22 15:54:05', '2025-04-22 15:54:05'),
(132, 44, 19, '2025-04-22 15:54:05', '2025-04-22 15:54:05'),
(133, 45, 14, '2025-04-22 15:54:35', '2025-04-22 15:54:35'),
(134, 45, 16, '2025-04-22 15:54:35', '2025-04-22 15:54:35'),
(135, 45, 18, '2025-04-22 15:54:35', '2025-04-22 15:54:35'),
(136, 45, 19, '2025-04-22 15:54:35', '2025-04-22 15:54:35'),
(137, 46, 15, '2025-04-22 15:54:54', '2025-04-22 15:54:54'),
(138, 47, 12, '2025-04-22 15:55:25', '2025-04-22 15:55:25'),
(139, 47, 13, '2025-04-22 15:55:25', '2025-04-22 15:55:25'),
(140, 47, 17, '2025-04-22 15:55:25', '2025-04-22 15:55:25'),
(141, 47, 18, '2025-04-22 15:55:25', '2025-04-22 15:55:25'),
(142, 48, 14, '2025-04-22 15:56:09', '2025-04-22 15:56:09'),
(143, 48, 15, '2025-04-22 15:56:09', '2025-04-22 15:56:09'),
(144, 48, 17, '2025-04-22 15:56:09', '2025-04-22 15:56:09'),
(145, 49, 15, '2025-04-22 15:56:42', '2025-04-22 15:56:42'),
(146, 49, 16, '2025-04-22 15:56:42', '2025-04-22 15:56:42'),
(147, 49, 18, '2025-04-22 15:56:42', '2025-04-22 15:56:42'),
(148, 49, 19, '2025-04-22 15:56:42', '2025-04-22 15:56:42'),
(149, 50, 15, '2025-04-22 15:57:02', '2025-04-22 15:57:02'),
(150, 51, 15, '2025-04-22 15:57:30', '2025-04-22 15:57:30'),
(151, 51, 16, '2025-04-22 15:57:30', '2025-04-22 15:57:30'),
(152, 51, 18, '2025-04-22 15:57:30', '2025-04-22 15:57:30'),
(153, 51, 19, '2025-04-22 15:57:30', '2025-04-22 15:57:30'),
(154, 52, 14, '2025-04-22 15:58:28', '2025-04-22 15:58:28'),
(155, 52, 15, '2025-04-22 15:58:28', '2025-04-22 15:58:28'),
(156, 52, 19, '2025-04-22 15:58:28', '2025-04-22 15:58:28'),
(161, 53, 12, '2025-04-22 15:59:18', '2025-04-22 15:59:18'),
(162, 53, 13, '2025-04-22 15:59:18', '2025-04-22 15:59:18'),
(163, 53, 17, '2025-04-22 15:59:18', '2025-04-22 15:59:18'),
(164, 53, 18, '2025-04-22 15:59:18', '2025-04-22 15:59:18'),
(165, 54, 14, '2025-04-22 16:00:13', '2025-04-22 16:00:13'),
(166, 54, 16, '2025-04-22 16:00:13', '2025-04-22 16:00:13'),
(167, 54, 18, '2025-04-22 16:00:13', '2025-04-22 16:00:13'),
(168, 54, 19, '2025-04-22 16:00:13', '2025-04-22 16:00:13'),
(169, 55, 14, '2025-04-22 16:00:30', '2025-04-22 16:00:30'),
(170, 55, 15, '2025-04-22 16:00:30', '2025-04-22 16:00:30'),
(171, 55, 17, '2025-04-22 16:00:30', '2025-04-22 16:00:30'),
(172, 56, 15, '2025-04-22 16:00:59', '2025-04-22 16:00:59'),
(173, 56, 16, '2025-04-22 16:00:59', '2025-04-22 16:00:59'),
(174, 56, 18, '2025-04-22 16:00:59', '2025-04-22 16:00:59'),
(175, 56, 19, '2025-04-22 16:00:59', '2025-04-22 16:00:59'),
(176, 57, 14, '2025-04-22 16:04:30', '2025-04-22 16:04:30'),
(177, 57, 16, '2025-04-22 16:04:30', '2025-04-22 16:04:30'),
(178, 57, 18, '2025-04-22 16:04:30', '2025-04-22 16:04:30'),
(179, 57, 19, '2025-04-22 16:04:30', '2025-04-22 16:04:30'),
(180, 58, 14, '2025-04-22 16:04:49', '2025-04-22 16:04:49'),
(181, 58, 16, '2025-04-22 16:04:49', '2025-04-22 16:04:49'),
(182, 58, 18, '2025-04-22 16:04:49', '2025-04-22 16:04:49'),
(183, 58, 19, '2025-04-22 16:04:49', '2025-04-22 16:04:49'),
(184, 59, 12, '2025-04-22 16:05:11', '2025-04-22 16:05:11'),
(185, 59, 13, '2025-04-22 16:05:11', '2025-04-22 16:05:11'),
(186, 59, 17, '2025-04-22 16:05:11', '2025-04-22 16:05:11'),
(187, 59, 18, '2025-04-22 16:05:11', '2025-04-22 16:05:11'),
(188, 60, 15, '2025-04-22 16:05:25', '2025-04-22 16:05:25'),
(189, 61, 12, '2025-04-22 16:05:49', '2025-04-22 16:05:49'),
(190, 61, 13, '2025-04-22 16:05:49', '2025-04-22 16:05:49'),
(191, 61, 17, '2025-04-22 16:05:49', '2025-04-22 16:05:49'),
(192, 61, 18, '2025-04-22 16:05:49', '2025-04-22 16:05:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_responses`
--

CREATE TABLE `tbl_responses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_option_id` tinyint(1) NOT NULL,
  `points` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_chatbot`
--
ALTER TABLE `tbl_chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_examiners`
--
ALTER TABLE `tbl_examiners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_preferred_courses`
--
ALTER TABLE `tbl_preferred_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_1` (`course_1`),
  ADD KEY `course_2` (`course_2`),
  ADD KEY `course_3` (`course_3`);

--
-- Indexes for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_question_courses`
--
ALTER TABLE `tbl_question_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `tbl_responses`
--
ALTER TABLE `tbl_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_chatbot`
--
ALTER TABLE `tbl_chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_examiners`
--
ALTER TABLE `tbl_examiners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_preferred_courses`
--
ALTER TABLE `tbl_preferred_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tbl_question_courses`
--
ALTER TABLE `tbl_question_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `tbl_responses`
--
ALTER TABLE `tbl_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_preferred_courses`
--
ALTER TABLE `tbl_preferred_courses`
  ADD CONSTRAINT `tbl_preferred_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_examiners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_preferred_courses_ibfk_2` FOREIGN KEY (`course_1`) REFERENCES `tbl_courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_preferred_courses_ibfk_3` FOREIGN KEY (`course_2`) REFERENCES `tbl_courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_preferred_courses_ibfk_4` FOREIGN KEY (`course_3`) REFERENCES `tbl_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_question_courses`
--
ALTER TABLE `tbl_question_courses`
  ADD CONSTRAINT `tbl_question_courses_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `tbl_questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_question_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `tbl_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_responses`
--
ALTER TABLE `tbl_responses`
  ADD CONSTRAINT `tbl_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_examiners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `tbl_questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
