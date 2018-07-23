-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 23, 2018 at 06:11 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `straight_talk`
--

-- --------------------------------------------------------

--
-- Table structure for table `amount`
--

CREATE TABLE `amount` (
  `id` bigint(14) NOT NULL,
  `amount` varchar(14) DEFAULT NULL,
  `student_id` varchar(30) DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `form` varchar(10) DEFAULT NULL,
  `year` date DEFAULT NULL,
  `term` varchar(100) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `amount`
--

INSERT INTO `amount` (`id`, `amount`, `student_id`, `reason`, `bank`, `form`, `year`, `term`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '600,000', '201637', 'Tuition', 'Bank Of Africa', 'S4', '2018-01-01', 'Term One', 'Admin', '2018-07-08 07:40:08', '2018-07-08 07:40:08'),
(2, '600,000', '201637', 'Tuition', 'Bank Of Africa', 'S4', '2018-05-05', 'Term Two', 'Admin', '2018-07-08 07:40:31', '2018-07-08 07:40:31'),
(3, '600,000', '201637', 'Tuition', 'Bank Of Africa', 'S4', '2018-08-08', 'Term Three', 'Admin', '2018-07-08 07:40:55', '2018-07-08 07:40:55'),
(4, '30,000', '201637', 'Transport', 'Barclays Bank', 'S4', '2018-08-08', 'Term Two', 'Admin', '2018-07-08 08:05:44', '2018-07-08 08:05:44'),
(5, '1,000,000', '201738', 'Tuition', 'Barclays Bank', 'Year Four', '2018-01-01', 'Semester One', 'Admin', '2018-07-08 08:09:29', '2018-07-08 08:09:29'),
(6, '300,000', '201738', 'Accomodation', 'Finance Trust Bank', 'Year Four', '2018-01-01', 'Semester One', 'Admin', '2018-07-08 08:09:58', '2018-07-08 08:09:58'),
(7, '600,000', '201738', 'Upkeep', 'Stanbic Bank ', 'Year Four', '2018-08-08', 'Semester One', 'Admin', '2018-07-08 08:33:26', '2018-07-08 08:33:26'),
(8, '1,000,000', '201736', 'Tuition', 'Finance Trust Bank', 'Year One', '2018-09-09', 'Semester One', 'Admin', '2018-07-13 20:07:36', '2018-07-13 20:07:36'),
(9, '700,000', '201736', 'Internship', 'Bank Of Africa', 'Year One', '2018-07-07', 'Semester One', 'Admin', '2018-07-13 20:08:03', '2018-07-13 20:08:03'),
(10, '1,000,000', '201839', 'Accomodation', 'Barclays Bank', 'S5', '8888-08-08', 'Term One', 'Admin', '2018-07-21 07:21:11', '2018-07-21 07:21:11'),
(11, '1,000,000', '2017188', 'Tuition', 'Bank Of Africa', 'S1', '2018-09-09', 'Term One', 'Admin', '2018-07-23 08:50:32', '2018-07-23 08:50:32'),
(12, '1,000,000', '201839', 'Accomodation', 'Barclays Bank', 'Year One', '2018-08-05', 'Semester One', 'Admin', '2018-07-23 13:39:12', '2018-07-23 13:39:12'),
(13, '200,000', '201839', 'Transport', 'Equity Bank', 'Year One', '2018-07-07', 'Semester One', 'Admin', '2018-07-23 13:40:08', '2018-07-23 13:40:08'),
(14, '800,000', '201839', 'Upkeep', 'Equity Bank', 'Year One', '2018-07-07', 'Semester One', 'Admin', '2018-07-23 13:40:40', '2018-07-23 13:40:40'),
(15, '1,500,000', '201839', 'Tuition', 'Barclays Bank', 'Year One', '2018-07-07', 'Semester Two', 'Admin', '2018-07-23 13:41:09', '2018-07-23 13:41:09'),
(16, '900,000', '201839', 'Accomodation', 'Barclays Bank', 'Year One', '2018-06-06', 'Semester Two', 'Admin', '2018-07-23 13:41:35', '2018-07-23 13:41:35'),
(17, '300,000', '201839', 'Internship', 'Equity Bank', 'Year One', '2018-04-04', 'Semester Two', 'Admin', '2018-07-23 13:42:27', '2018-07-23 13:42:27'),
(18, '100,000', '201839', 'NCHE', 'Orient Bank', 'Year One', '2018-08-08', 'Semester One', 'Admin', '2018-07-23 13:43:39', '2018-07-23 13:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `website` varchar(300) DEFAULT NULL,
  `other_notes` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank_name`, `website`, `other_notes`, `created_at`, `updated_at`) VALUES
(1, 'Stanbic Bank ', 'https://www.stanbicbank.co.ug', '                                        \r\n                                       \r\n                                        ', '2018-06-02 11:32:19', '2018-06-02 11:32:19'),
(2, 'Bank Of Africa', 'http://www.boauganda.com', '', '2018-06-02 11:32:45', '2018-06-02 17:44:27'),
(3, 'Equity Bank', 'http://www.equitybank.co.ug', '                                        \r\n                                       \r\n                                        ', '2018-06-02 11:33:30', '2018-06-02 11:33:30'),
(4, 'Orient Bank', 'http://www.orient-bank.com/', '                                        \r\n                                       \r\n                                        ', '2018-06-03 11:34:23', '2018-06-03 11:34:23'),
(5, 'Barclays Bank', 'https://www.ug.barclaysafrica.com', '                                        \r\n                                       \r\n                                        ', '2018-06-03 11:34:59', '2018-06-03 11:34:59'),
(6, 'Finance Trust Bank', '', 'snsmsms', '2018-06-19 15:42:53', '2018-06-19 15:42:53');

-- --------------------------------------------------------

--
-- Table structure for table `complains`
--

CREATE TABLE `complains` (
  `id` bigint(11) NOT NULL,
  `title` text,
  `body` longtext,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `student_id` varchar(50) DEFAULT NULL,
  `student_name` varchar(300) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complains`
--

INSERT INTO `complains` (`id`, `title`, `body`, `status`, `student_id`, `student_name`, `created_at`, `updated_at`) VALUES
(1, 'Upkeep  for Semester One', 'I received only UGX 80,000  for my upkeep for my Semester One yet the summary indicates UGX 150,0000 ', 'pending', '201839', 'Akel Bia', '2018-07-23 15:06:47', '2018-07-23 15:06:47'),
(2, 'Transport for  Semester One', 'Dear Sir/Madam,\r\n\r\nI  did not receive my transport for semester one', 'pending', '201839', 'Akel Bia', '2018-07-23 15:09:30', '2018-07-23 15:09:30'),
(3, 'I did not receive  money for Internship', 'Dear Sir/Madam,\r\n\r\nI did not get  internship for second Year , Semester Two.\r\n\r\nI would appreciate your urgent positive feedback.\r\n\r\nRegards,\r\nAkia', 'pending', '201839', 'Akel Bia', '2018-07-23 15:11:26', '2018-07-23 15:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `category` varchar(10) NOT NULL,
  `level` varchar(100) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `deleted_by` varchar(300) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `category`, `level`, `deleted`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Telecommunication Engineering', 'science', 'bachelor', '0', 'Ocaka Alfred', '2018-05-30 13:19:48', '2018-05-30 12:49:23', '2018-07-17 02:59:05'),
(2, 'electrical engineering', 'science', 'diploma', '0', NULL, '2018-05-30 12:49:46', '2018-05-30 12:49:46', '2018-05-30 12:49:46'),
(3, 'Business administration', 'art', 'Certificate', '0', NULL, '2018-05-30 12:50:38', '2018-05-30 12:50:38', '2018-05-30 12:50:38'),
(4, 'Business Managment', 'art', 'diploma', '0', 'Ocaka Alfred', '2018-05-30 13:19:56', '2018-05-30 12:52:08', '2018-06-19 15:38:58'),
(5, 'Computer Science', 'science', 'bachelor', '0', NULL, NULL, '2018-05-30 12:53:30', '2018-05-30 13:20:04'),
(6, 'Information technology', 'science', NULL, '0', NULL, NULL, '2018-05-30 13:00:00', '2018-05-30 13:00:00'),
(7, 'Hotel Management', 'art', NULL, '0', NULL, NULL, '2018-05-30 13:17:40', '2018-05-30 13:17:40'),
(8, 'Project Management', 'art', NULL, '0', NULL, NULL, '2018-06-19 15:38:39', '2018-06-19 15:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `district_name` varchar(100) DEFAULT NULL,
  `region` varchar(50) NOT NULL,
  `province` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `district_name`, `region`, `province`, `created_at`, `deleted_at`) VALUES
(1, 'Buikwe', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(2, 'Bukomansimbi', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(3, 'Butambala', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(4, 'Buvuma', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(5, 'Gomba', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(6, 'Kalangala', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(7, 'Kalungu', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(8, 'Kampala', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(9, 'Kayunga', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(10, 'Kiboga', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(11, 'Kyankwanzi', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(12, 'Luweero', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(13, 'Lwengo', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(14, 'Lyantonde', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(15, 'Masaka', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(16, 'Mityana', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(17, 'Mpigi', 'Central Region', NULL, '2018-05-30 14:07:51', '2018-05-30 14:07:51'),
(18, 'Mubende', 'Central Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(19, 'Mukono', 'Central Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(20, 'Nakaseke', 'Central Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(21, 'Nakasongola', 'Central Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(22, 'Rakai', 'Central Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(23, 'Sembabule', 'Central Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(24, 'Wakiso', 'Central Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(25, 'Amuria', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(26, 'Budaka', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(27, 'Bududa', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(28, 'Bugiri', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(29, 'Bukedea', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(30, 'Bukwa', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(31, 'Bulambuli', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(32, 'Busia', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(33, 'Butaleja', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(34, 'Buyende', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(35, 'Iganga', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(36, 'Jinja', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(37, 'Kaberamaido', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(38, 'Kaliro', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(39, 'Kamuli', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(40, 'Kapchorwa', 'Eastern Region', NULL, '2018-05-30 14:07:52', '2018-05-30 14:07:52'),
(41, 'Katakwi', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(42, 'Kibuku', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(43, 'Kumi', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(44, 'Kween', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(45, 'Luuka', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(46, 'Manafwa', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(47, 'Mayuge', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(48, 'Mbale', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(49, 'Namayingo', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(50, 'Namutumba', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(51, 'Ngora', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(52, 'Pallisa', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(53, 'Serere', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(54, 'Sironko', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(55, 'Soroti', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(56, 'Tororo', 'Eastern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(57, 'Abim', 'Northern Region', 'karamoja', '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(58, 'Adjumani', 'Northern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(59, 'Agago', 'Northern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(60, 'Alebtong', 'Northern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(61, 'Amolatar', 'Northern Region', NULL, '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(62, 'Amudat', 'Northern Region', 'karamoja', '2018-05-30 14:07:53', '2018-05-30 14:07:53'),
(63, 'Amuru', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(64, 'Apac', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(65, 'Arua', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(66, 'Dokolo', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(67, 'Gulu', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(68, 'Kaabong', 'Northern Region', 'karamoja', '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(69, 'Kitgum', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(70, 'Koboko', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(71, 'Kole', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(72, 'Kotido', 'Northern Region', 'karamoja', '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(73, 'Lamwo', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(74, 'Lira', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(75, 'Maracha', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(76, 'Moroto', 'Northern Region', 'karamoja', '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(77, 'Moyo', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(78, 'Nakapiripirit', 'Northern Region', 'karamoja', '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(79, 'Napak', 'Northern Region', 'karamoja', '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(80, 'Nebbi', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(81, 'Nwoya', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(82, 'Otuke', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(83, 'Oyam', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(84, 'Pader', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(85, 'Yumbe', 'Northern Region', NULL, '2018-05-30 14:07:54', '2018-05-30 14:07:54'),
(86, 'Zombo', 'Northern Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(87, 'Buhweju', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(88, 'Buliisa', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(89, 'Bundibugyo', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(90, 'Bushenyi', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(91, 'Hoima', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(92, 'Ibanda', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(93, 'Isingiro', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(94, 'Kabale', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(95, 'Kabarole', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(96, 'Kamwenge', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(97, 'Kanungu', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(98, 'Kasese', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(99, 'Kibaale', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(100, 'Kiruhura', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(101, 'Kiryandongo', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(102, 'Kisoro', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(103, 'Kyegegwa', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(104, 'Kyenjojo', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(105, 'Masindi', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(106, 'Mbarara', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(107, 'Mitooma', 'Western Region', NULL, '2018-05-30 14:07:55', '2018-05-30 14:07:55'),
(108, 'Ntoroko', 'Western Region', NULL, '2018-05-30 14:07:56', '2018-05-30 14:07:56'),
(109, 'Ntungamo', 'Western Region', NULL, '2018-05-30 14:07:56', '2018-05-30 14:07:56'),
(110, 'Rubirizi', 'Western Region', NULL, '2018-05-30 14:07:56', '2018-05-30 14:07:56'),
(111, 'Rukungiri', 'Western Region', NULL, '2018-05-30 14:07:56', '2018-05-30 14:07:56'),
(112, 'Sheema', 'Western Region', NULL, '2018-05-30 14:07:56', '2018-05-30 14:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `dropouts`
--

CREATE TABLE `dropouts` (
  `id` int(11) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dropouts`
--

INSERT INTO `dropouts` (`id`, `reason`, `created_at`, `updated_at`) VALUES
(1, 'Pregnancy', NULL, NULL),
(2, 'Poverty', NULL, NULL),
(3, 'Accessibility ', NULL, NULL),
(4, 'Constant failure', NULL, NULL),
(5, 'Severe bullying', NULL, NULL),
(6, 'Need to support family ', NULL, NULL),
(7, 'Others', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `form_name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `form_name`, `created_at`, `updated_at`) VALUES
(1, 'S1', NULL, NULL),
(2, 'S2', NULL, NULL),
(3, 'S3', NULL, NULL),
(4, 'S4', NULL, NULL),
(5, 'S5', NULL, NULL),
(6, 'S6', NULL, NULL),
(7, 'Year One', NULL, NULL),
(8, 'Year Two', NULL, NULL),
(9, 'Year Three', NULL, NULL),
(10, 'Year  Four', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `funders`
--

CREATE TABLE `funders` (
  `id` int(11) NOT NULL,
  `funder_name` varchar(300) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `funders`
--

INSERT INTO `funders` (`id`, `funder_name`, `created_at`, `updated_at`) VALUES
(1, 'Irish Aid Scholarship', '2018-06-03 12:01:09', '2018-06-03 12:01:09'),
(2, 'Government Scholarship', '2018-06-03 12:01:09', '2018-06-03 12:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `hostels`
--

CREATE TABLE `hostels` (
  `id` int(11) NOT NULL,
  `hostel_name` varchar(500) DEFAULT NULL,
  `hostel_address` text,
  `owner_name` varchar(200) DEFAULT NULL,
  `owner_phone` varchar(20) DEFAULT NULL,
  `owner_email` varchar(50) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hostels`
--

INSERT INTO `hostels` (`id`, `hostel_name`, `hostel_address`, `owner_name`, `owner_phone`, `owner_email`, `deleted_at`, `deleted_by`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Mary Stuart Hall', NULL, 'Makerere University', '+256 7029938383', 'fredocaka@gmail.com', NULL, NULL, '0', '2018-06-09 18:53:54', '2018-06-09 18:53:54'),
(2, 'Livingstone Hall', NULL, 'Makerere University', '+256 7029938383', 'info@mak.ac.ug', NULL, NULL, '0', '2018-06-09 18:54:53', '2018-06-09 18:54:53'),
(3, 'Nana Hostel', '                                                                                \r\n              900020222222222222                         \r\n                                        Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.\r\n                                       \r\n                                        ', 'Kikoni, Makerere University', '+2567490024904', 'jamammaa@gmail.com', NULL, NULL, '0', '2018-06-09 19:09:46', '2018-06-09 21:44:00'),
(4, 'Baskon Hostel', '                                                                                \r\n                                       \r\n                                        Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.\r\n                                       \r\n                                        ', 'Kuma Duma', '+256748494904', 'jamammaa@gmail.com', NULL, NULL, '0', '2018-06-09 21:35:30', '2018-06-09 21:35:30'),
(5, 'God Is Able Hostel', '                                                                                                                        \r\n                                       \r\n                                        Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.\r\n                                       \r\n                                        \r\n                                       \r\n                                        ', 'Francis Kiev', '+256748494904', 'jamammaa@gmail.com', NULL, NULL, '0', '2018-06-09 21:36:47', '2018-06-09 21:56:13'),
(6, 'Garden Courts', '                                                                                \r\n                                       \r\n                                        Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.\r\n                                       \r\n                                        ', 'Johnson Patrict', '+256783933993', 'jamaa@gmail.com', NULL, NULL, '0', '2018-06-09 21:42:10', '2018-06-09 21:42:10'),
(7, 'Home', NULL, NULL, NULL, '', NULL, NULL, '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `id` bigint(14) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `school_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `qualification` varchar(50) DEFAULT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `registration_number` varchar(100) DEFAULT NULL,
  `hostel_id` int(11) NOT NULL,
  `s_form` varchar(50) DEFAULT NULL,
  `student_bank_name` varchar(100) DEFAULT NULL,
  `student_bank_account` varchar(100) DEFAULT NULL,
  `student_bank_address` varchar(500) DEFAULT NULL,
  `other_bank_name` varchar(100) DEFAULT NULL,
  `other_bank_account` varchar(100) DEFAULT NULL,
  `other_bank_address` varchar(500) DEFAULT NULL,
  `myear_start` date DEFAULT NULL,
  `myear_stop` date DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`id`, `student_id`, `school_id`, `course_id`, `qualification`, `student_number`, `registration_number`, `hostel_id`, `s_form`, `student_bank_name`, `student_bank_account`, `student_bank_address`, `other_bank_name`, `other_bank_account`, `other_bank_address`, `myear_start`, `myear_stop`, `created_by`, `created_at`, `updated_at`) VALUES
(3, '201738', 6, 4, 'Ordinary Diploma', '', '12/902020202', 5, 'Year Four', 'Barclays Bank', '2829292922929', 'Kampala, uganda', 'Barclays Bank', '292929292929', 'Arua, Uganda', NULL, NULL, 'Ocaka Alfred', '2018-06-30 05:09:12', '2018-06-30 05:09:12'),
(4, '201839', 6, 5, 'Certificate', '26262728892', '18/U/1525627', 7, 'Year One', 'Equity Bank', '262727828292299', 'Kampala, uganda', '', '', '', '2018-07-07', '2020-07-07', 'Admin', '2018-07-21 08:20:16', '2018-07-21 13:28:04'),
(5, '201839', 6, 8, 'Ordinary Diploma', '', '12/u/902020209999', 7, 'Year One', 'Barclays Bank', '67282829299992', 'Kampala, uganda', '', '', '', '8888-08-08', '8888-08-08', 'Admin', '2018-07-21 08:37:00', '2018-07-21 08:37:00'),
(6, '2017188', 1, 4, 'Bachelor', '', '12/u/9020202089909', 7, 'Year One', 'Bank Of Africa', '455676788999', 'Kampala, uganda7', '', '', '', '2018-09-09', '2021-09-09', 'Admin', '2018-07-23 08:58:10', '2018-07-23 08:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'secondary', '2018-05-30 14:12:49', '2018-05-30 14:12:49'),
(2, 'tertiary', '2018-05-30 14:12:49', '2018-05-30 14:12:49'),
(3, 'university', '2018-05-30 14:12:59', '2018-05-30 14:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` int(11) NOT NULL,
  `qualification_name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `qualification_name`, `created_at`, `updated_at`) VALUES
(1, 'Bachelor', NULL, NULL),
(2, 'Ordinary Diploma', NULL, NULL),
(3, 'Certificate', NULL, NULL),
(4, 'Higher Diploma', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` bigint(14) NOT NULL,
  `student_id` bigint(11) DEFAULT NULL,
  `subject_id` bigint(11) DEFAULT NULL,
  `mark` varchar(8) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `term` varchar(20) DEFAULT NULL,
  `s_form` varchar(50) DEFAULT NULL,
  `academic_year` varchar(6) DEFAULT NULL,
  `performance` text,
  `created_id` int(11) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `student_id`, `subject_id`, `mark`, `grade`, `term`, `s_form`, `academic_year`, `performance`, `created_id`, `created_by`, `created_at`, `updated_at`) VALUES
(17, 2017133, 2, '30', NULL, 'first_term', 'S2', '2019', NULL, 14, 'Admin', '2018-07-22 15:24:57', '2018-07-22 15:24:57'),
(18, 2017133, 4, '30', NULL, 'first_term', 'S2', '2019', NULL, 14, 'Admin', '2018-07-22 15:24:57', '2018-07-22 15:24:57'),
(19, 2017133, 6, '30', NULL, 'first_term', 'S2', '2019', NULL, 14, 'Admin', '2018-07-22 15:24:57', '2018-07-22 15:24:57');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'read', '1', '2018-05-25 15:39:52', '2018-05-25 15:39:52'),
(2, 'read & write', '1', '2018-05-25 15:39:52', '2018-05-25 15:39:52'),
(3, 'read,write &  update', '1', '2018-05-25 15:40:39', '2018-05-25 15:40:39'),
(4, 'all privileges', '1', '2018-05-25 15:40:39', '2018-05-25 15:40:39'),
(5, 'Super Admin', '0', '2018-06-29 05:04:03', '2018-06-29 05:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(11) NOT NULL,
  `school_name` varchar(500) NOT NULL,
  `district_id` int(11) DEFAULT NULL,
  `school_code` varchar(200) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account` varchar(100) DEFAULT NULL,
  `bank_address` varchar(500) DEFAULT NULL,
  `school_address` text,
  `school_phone` varchar(50) DEFAULT NULL,
  `school_email` varchar(100) DEFAULT NULL,
  `school_website` varchar(500) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `school_name`, `district_id`, `school_code`, `level`, `bank_name`, `bank_account`, `bank_address`, `school_address`, `school_phone`, `school_email`, `school_website`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Makerere University Business School', 8, '12/u/763883939', 'university', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-02 07:45:57', '2018-06-02 07:45:57'),
(2, 'Kotido Senior Secondary School', 72, '', 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-02 07:51:50', '2018-06-02 07:51:50'),
(3, 'Murolem Girls\' Secondary School', 57, '', 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-02 08:10:37', '2018-06-02 10:27:39'),
(4, 'Abim Secondary School', 57, 'U108/8191/PS', 'secondary', 'Barclays Bank', '672782822999000', 'Abim, Uganda', 'Abim, Uganda', '0702242877', 'abim@abim.co.ug', 'http://abim.co.ug', 'Ocaka Alfred', '2018-06-02 08:11:07', '2018-06-28 16:24:53'),
(5, 'Kiira College Butiki', 36, '', 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-02 08:12:33', '2018-06-02 08:12:33'),
(6, 'Gulu University', 67, '', 'university', 'Barclays Bank', '67228289300393', 'Alero Road, Gulu Municipality', '', '', '', '', 'Ocaka Alfred', '2018-06-02 08:35:12', '2018-07-21 12:25:20'),
(7, 'National Teachers college Unyama', 67, '', 'tertiary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-02 08:36:17', '2018-06-02 08:36:17'),
(8, 'Uganda Christian University Mukono', 19, '', 'university', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-02 09:17:26', '2018-06-02 17:49:39'),
(9, 'Namula Seed Secondary School', 78, '', 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-04 12:34:40', '2018-06-04 12:34:40'),
(10, 'Moroto High School', 76, '', 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-04 13:04:21', '2018-06-04 13:04:21'),
(11, 'Lubiri Secondary School', 8, 'U01282922889292', 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ocaka Alfred', '2018-06-19 15:31:47', '2018-06-19 15:32:14'),
(12, 'Lira High School', 74, '', 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Johnson Ocaka', '2018-06-20 06:49:18', '2018-06-20 06:49:18'),
(13, 'Kabalega', 36, 'U102929', 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Admin', '2018-06-21 13:25:20', '2018-06-21 13:25:20'),
(14, 'Busitema University', 56, 'UGJ-7889-10', 'university', 'Barclays Bank', '26272829202008889', 'Kampala Uganda ', 'Toorooo, ', '098282929,07282822929', 'info@busitema.com', 'http://busitemauniversity.com', 'Ocaka Alfred', '2018-06-28 16:10:41', '2018-06-28 16:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `secondary`
--

CREATE TABLE `secondary` (
  `id` bigint(14) NOT NULL,
  `school_id` bigint(13) DEFAULT NULL,
  `s_form` varchar(10) NOT NULL,
  `stream` varchar(20) DEFAULT NULL,
  `student_id` bigint(13) DEFAULT NULL,
  `student_number` varchar(100) DEFAULT NULL,
  `student_index` varchar(50) DEFAULT NULL,
  `fav_subject` varchar(50) DEFAULT NULL,
  `fav_sport` varchar(50) DEFAULT NULL,
  `myear_start` date DEFAULT NULL,
  `myear_stop` date DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secondary`
--

INSERT INTO `secondary` (`id`, `school_id`, `s_form`, `stream`, `student_id`, `student_number`, `student_index`, `fav_subject`, `fav_sport`, `myear_start`, `myear_stop`, `status`, `deleted_at`, `deleted_by`, `deleted`, `created_by`, `created_at`, `updated_at`) VALUES
(7, 2, 'S4', 'Green', 201637, '782892w0ww0', 'UJ6/839030', 'Luganda', 'Swiming', NULL, NULL, NULL, NULL, NULL, '0', 'Ocaka Alfred', '2018-06-30 06:27:42', '2018-07-01 08:14:49'),
(8, 5, 'S4', 'Yellow', 201940, '', 'U160/7289', 'Fine Art', 'tennis', NULL, NULL, NULL, NULL, NULL, '0', 'Admin', '2018-07-10 19:06:10', '2018-07-10 19:06:10'),
(10, 10, 'S6', '', 201541, '', '', 'Local Languages', 'netball', NULL, NULL, NULL, NULL, NULL, '0', 'Admin', '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(26, 4, 'S2', '', 201839, '', '', 'Geography', 'rugby', NULL, NULL, NULL, NULL, NULL, '0', 'Admin', '2018-07-21 07:24:47', '2018-07-21 07:26:05'),
(30, 9, 'S5', '', 201839, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '0', 'Admin', '2018-07-21 07:53:34', '2018-07-21 07:53:34'),
(31, 11, 'S3', '', 2019132, '', '', 'Mathematics', 'cricket', NULL, NULL, NULL, NULL, NULL, '0', 'Admin', '2018-07-21 07:57:30', '2018-07-21 07:57:30'),
(32, 5, 'S4', '', 2019132, '', '', 'Home Economics', 'soccer', NULL, NULL, NULL, NULL, NULL, '0', 'Admin', '2018-07-21 08:05:14', '2018-07-21 08:05:14'),
(33, 10, 'S3', '', 2017133, '', '', 'Agriculture Principles and Practices', 'cricket', '2017-09-09', '2020-08-08', NULL, NULL, NULL, '0', 'Admin', '2018-07-21 13:36:52', '2018-07-21 13:36:52'),
(51, 4, 'S4', '', 2018180, NULL, 'U25556', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '2018-07-23 06:14:04', '2018-07-23 06:14:04'),
(52, 2, 'S1', '', 2018184, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '2018-07-23 06:29:36', '2018-07-23 06:29:36'),
(53, 2, 'S1', '', 2018186, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '2018-07-23 06:32:48', '2018-07-23 06:32:48'),
(54, 4, 'S1', '', 2017188, '', '', 'Computer Studies', 'rugby', '2017-08-08', '2020-09-09', NULL, NULL, NULL, '0', 'Admin', '2018-07-23 08:47:28', '2018-07-23 08:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(11) NOT NULL,
  `bursary_id` varchar(50) DEFAULT NULL,
  `name` varchar(300) NOT NULL,
  `dob` date DEFAULT NULL,
  `level` varchar(30) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `ethnicity` varchar(100) DEFAULT NULL,
  `national_id` varchar(200) DEFAULT NULL,
  `registration_year` varchar(50) DEFAULT NULL,
  `year_start` varchar(100) DEFAULT NULL,
  `year_stop` varchar(100) DEFAULT NULL,
  `uce_grade` varchar(100) DEFAULT NULL,
  `uace_grade` varchar(100) DEFAULT NULL,
  `entry_grade` varchar(50) DEFAULT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `student_phone` varchar(15) DEFAULT NULL,
  `student_email` varchar(50) DEFAULT NULL,
  `parent1_name` varchar(100) DEFAULT NULL,
  `parent1_phone` varchar(15) DEFAULT NULL,
  `parent2_name` varchar(100) DEFAULT NULL,
  `parent2_phone` varchar(100) DEFAULT NULL,
  `district` int(3) DEFAULT NULL,
  `dist_name` varchar(100) DEFAULT NULL,
  `funder` varchar(500) DEFAULT NULL,
  `subcounty` varchar(200) DEFAULT NULL,
  `village` varchar(200) DEFAULT NULL,
  `current_state` varchar(50) DEFAULT NULL,
  `dropout_reason` varchar(200) DEFAULT NULL,
  `comments` text,
  `notes` longtext,
  `school` int(11) DEFAULT NULL,
  `s_form` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `draft` enum('0','1') NOT NULL DEFAULT '1',
  `created_by` varchar(100) DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  `deleted_by` varchar(150) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `bursary_id`, `name`, `dob`, `level`, `gender`, `ethnicity`, `national_id`, `registration_year`, `year_start`, `year_stop`, `uce_grade`, `uace_grade`, `entry_grade`, `photo`, `student_phone`, `student_email`, `parent1_name`, `parent1_phone`, `parent2_name`, `parent2_phone`, `district`, `dist_name`, `funder`, `subcounty`, `village`, `current_state`, `dropout_reason`, `comments`, `notes`, `school`, `s_form`, `password`, `draft`, `created_by`, `created_id`, `deleted_by`, `deleted_at`, `deleted`, `created_at`, `updated_at`) VALUES
(36, '201736', 'Ocaka Alfred', '1993-09-09', 'university', 'M', 'Bukwo', 'GX89393JD900303', '2017-03-31', '2017-03-31', '2019-10-10', '12', '16', '15', '1530253934Alfred.jpg', '077777000000', 'fredocaka@gmail.com', 'Acan Monica', '07738383839929', 'Okello Dad', '0837338389390', 62, 'Amudat', 'Irish Embassy', 'Kaabong', '', 'continuing', '', '                                                                                MySQL is one of the most widely used database systems for dynamic websites and content management systems. And phpMyAdmin is the most common method of administering a MySQL database, included in many CMSs as well as the XAMPP and MAMP testing environments.           <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', '                                                                                   MySQL is one of the most widely used database systems for dynamic websites and content management systems. And phpMyAdmin is the most common method of administering a MySQL database, included in many CMSs as well as the XAMPP and MAMP testing environments.                                                                                                                                                                                                     <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', 7, 'Year One', NULL, '0', 'Super Admin', 24, NULL, NULL, '0', '2018-06-29 06:32:14', '2018-06-29 07:18:05'),
(37, '201637', 'Drako Emmaqqq', '2000-08-08', 'secondary', 'F', 'Bukwo', 'LKM7383939002', '2016-07-07', '2016-07-07', '2020-07-07', '10', '17', '10', '1530432681kev.jpeg', '073838383801020', 'fredocaka@gmail.com', 'Akema JB', '072728289292', '', '', 68, 'Kaabong', 'Government Scholarship', 'Kaabong', '', 'continuing', '', '                                                                                                                                                                                                                            SMSSSSSSSSSSSSSS                    <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', '                                                                                                                                                                                                                                                <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', 2, 'S4', NULL, '0', 'Ocaka Alfred', 13, 'Super Admin', '2018-07-17 03:58:40', '1', '2018-06-29 14:23:44', '2018-07-17 03:58:40'),
(38, '201738', 'Joshua Amaida', '9999-09-09', 'tertiary', 'M', 'Bukwo', '', '2017-09-08', '2017-09-08', '2020-08-08', '', '', '9', '1532331830hey.jpeg', '', '', 'Kmamamss Mmssm', '07088889879', '', '', 62, 'Amudat', 'Government Scholarship', 'Kaabong', '', 'continuing', '', '                                                                                                                                                                                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', '                                                                                                                                                                                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', 6, 'Year Four', NULL, '0', 'Ocaka Alfred', 13, NULL, NULL, '0', '2018-06-29 19:00:36', '2018-07-23 07:43:50'),
(39, '201839', 'Akel Bia', '1993-09-09', 'tertiary', 'F', 'Kadam', 'IX72828292929', '2018-09-09', '8888-08-08', '8888-08-08', '12', '22', '7', '1531248912black.jpeg', '0777770508', 'ab@gmail.com', 'GOLF DUMBA', '0777770508', '', '', 68, 'Kaabong', 'Government Scholarship', 'Kaabong', '', 'continuing', '', '                                                                                                                                                                                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', '                                                                                                                                                                                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', 6, 'Year One', NULL, '0', 'Admin', 14, 'Super Admin', '2018-07-17 03:58:35', '0', '2018-07-10 18:55:12', '2018-07-21 13:28:04'),
(40, '201940', 'Okot Daniel', '2000-06-06', 'secondary', 'M', 'Kadam', '', '2019-07-07', '2019-07-07', '2022-07-07', '10', '10', '6', '1531249379men.jpeg', '', '', 'Dombo Jones', '07828282992', '', '', 78, 'Nakapiripirit', 'Irish Aid Scholarship', 'Kalapata', '', 'completed', '', '                                                                                <br />\r\n                                        <br />\r\n                                        ', '                                                                                <br />\r\n                                        <br />\r\n                                        ', 5, 'S4', NULL, '0', 'Admin', 14, NULL, NULL, '0', '2018-07-10 19:02:59', '2018-07-14 13:31:37'),
(41, '201541', 'Jambo Tran', '1991-08-08', 'secondary', 'M', 'Kadam', '', '2015-09-09', '2015-09-09', '2018-09-09', '', '17', '27', '1531581292t3.jpeg', '07282822292929', '', 'Agan Mary', '07772828291', '', '', 78, 'Nakapiripirit', 'Irish Aid Scholarship', 'Loyoro', '', 'completed', '', '                                                                                                                                                                                                                                                                                                                                                                                                                                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', '                                                                                                                                                                                                                                                                                                                                                                                                                                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        <br />\r\n                                        ', 4, 'S2', NULL, '0', 'Admin', 14, NULL, NULL, '0', '2018-07-14 15:14:52', '2018-07-21 06:18:34'),
(132, '2019132', 'Patrick Akol', '2000-08-08', 'secondary', 'M', 'Oropoi', '', '2019-07-07', '7777-07-07', '7777-07-07', '10', '14', '7', '1532331887jos.jpeg', '0777770508', 'fredocaka@gmail.com', 'Omona James', '0777770508', '', '', 76, 'Moroto', 'Government Scholarship', 'Kaabong', '', 'continuing', 'Poverty', '                                                                                <br />\r\n                                        <br />\r\n                                        ', '                                                                                <br />\r\n                                        <br />\r\n                                        ', 5, 'S4', NULL, '0', 'Admin', 14, NULL, NULL, '0', '2018-07-21 07:57:17', '2018-07-23 07:44:47'),
(133, '2017133', 'Ayello Patricia', '2000-07-07', 'secondary', 'F', 'Oropoi', 'UX3637338383939', '2017-09-09', '2017-09-09', '2020-08-08', '', '17', '10', '1532331854images.jpeg', '07727272882', 'fredocaka@gmail.com', 'Juma Keifer', '077822937383', '', '', 62, 'Amudat', 'Irish Aid Scholarship', 'Kalapata', '', 'continuing', '', '                                                                                <br />\r\n                                        <br />\r\n                                        ', '                                                                                <br />\r\n                                        <br />\r\n                                        ', 10, 'S3', NULL, '0', 'Admin', 14, NULL, NULL, '0', '2018-07-21 13:36:24', '2018-07-23 07:44:14'),
(188, '2017188', 'John Doe', '1998-09-09', 'tertiary', 'M', 'Bukwo', '', '2017-08-08', '2018-09-09', '2021-09-09', '', '', '8', '1532335492hey.jpeg', '', '', 'Jane Doe', '0777777777', '', '', 57, 'Abim', 'Irish Aid Scholarship', ' Lotukei', '', 'continuing', '', '                                        <br />\r\n                                        ', '                                        <br />\r\n                                        ', 1, 'Year One', NULL, '0', 'Admin', 14, 'Admin', '2018-07-23 08:59:59', '0', '2018-07-23 08:44:52', '2018-07-23 09:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `id` bigint(14) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`id`, `student_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(240, '37', 1, '2018-07-01 08:47:21', '2018-07-01 08:47:21'),
(243, '201637', 2, '2018-07-02 15:42:42', '2018-07-02 15:42:42'),
(244, '201637', 4, '2018-07-02 15:42:53', '2018-07-02 15:42:53'),
(245, '201637', 8, '2018-07-02 15:43:09', '2018-07-02 15:43:09'),
(246, '201637', 12, '2018-07-02 15:43:20', '2018-07-02 15:43:20'),
(247, '201940', 1, '2018-07-10 19:06:10', '2018-07-10 19:06:10'),
(248, '201940', 2, '2018-07-10 19:06:10', '2018-07-10 19:06:10'),
(249, '201940', 4, '2018-07-10 19:06:10', '2018-07-10 19:06:10'),
(250, '201940', 6, '2018-07-10 19:06:10', '2018-07-10 19:06:10'),
(251, '201839', 19, '2018-07-13 19:13:30', '2018-07-13 19:13:30'),
(252, '201839', 22, '2018-07-13 19:13:30', '2018-07-13 19:13:30'),
(253, '201839', 5, '2018-07-13 19:13:30', '2018-07-13 19:13:30'),
(254, '201839', 1, '2018-07-13 19:13:30', '2018-07-13 19:13:30'),
(255, '201839', 2, '2018-07-13 19:13:30', '2018-07-13 19:13:30'),
(256, '201541', 19, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(257, '201541', 22, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(258, '201541', 5, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(259, '201541', 1, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(260, '201541', 2, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(261, '201541', 4, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(262, '201541', 6, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(263, '201541', 7, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(264, '201541', 8, '2018-07-14 15:15:29', '2018-07-14 15:15:29'),
(265, '201839', 7, '2018-07-20 18:21:22', '2018-07-20 18:21:22'),
(266, '2917130', 5, '2018-07-21 06:09:56', '2018-07-21 06:09:56'),
(267, '2917130', 1, '2018-07-21 06:09:56', '2018-07-21 06:09:56'),
(268, '2917130', 2, '2018-07-21 06:09:56', '2018-07-21 06:09:56'),
(269, '2917130', 4, '2018-07-21 06:09:56', '2018-07-21 06:09:56'),
(270, '2917130', 6, '2018-07-21 06:09:56', '2018-07-21 06:09:56'),
(271, '2917130', 7, '2018-07-21 06:09:56', '2018-07-21 06:09:56'),
(272, '2917130', 8, '2018-07-21 06:09:56', '2018-07-21 06:09:56'),
(273, '201839', 10, '2018-07-21 07:37:02', '2018-07-21 07:37:02'),
(274, '201839', 11, '2018-07-21 07:37:02', '2018-07-21 07:37:02'),
(275, '201839', 12, '2018-07-21 07:37:02', '2018-07-21 07:37:02'),
(276, '201839', 13, '2018-07-21 07:37:02', '2018-07-21 07:37:02'),
(277, '201839', 17, '2018-07-21 07:37:02', '2018-07-21 07:37:02'),
(282, '2017133', 2, '2018-07-21 13:36:52', '2018-07-21 13:36:52'),
(283, '2017133', 4, '2018-07-21 13:36:52', '2018-07-21 13:36:52'),
(284, '2017133', 6, '2018-07-21 13:36:52', '2018-07-21 13:36:52'),
(288, '2017188', 1, '2018-07-23 08:47:28', '2018-07-23 08:47:28'),
(289, '2017188', 2, '2018-07-23 08:47:28', '2018-07-23 08:47:28'),
(290, '2017188', 4, '2018-07-23 08:47:28', '2018-07-23 08:47:28'),
(291, '2017188', 6, '2018-07-23 08:47:28', '2018-07-23 08:47:28'),
(292, '2017188', 7, '2018-07-23 08:47:28', '2018-07-23 08:47:28'),
(293, '2017188', 8, '2018-07-23 08:47:28', '2018-07-23 08:47:28'),
(294, '2017188', 5, '2018-07-23 08:48:56', '2018-07-23 08:48:56');

-- --------------------------------------------------------

--
-- Table structure for table `subcounties`
--

CREATE TABLE `subcounties` (
  `id` int(11) NOT NULL,
  `subcounty_name` varchar(100) DEFAULT NULL,
  `district_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcounties`
--

INSERT INTO `subcounties` (`id`, `subcounty_name`, `district_name`, `created_at`, `updated_at`) VALUES
(1, 'Abim', 'Abim', '2018-06-24 08:38:47', '2018-06-24 10:03:40'),
(2, 'Morulem', 'Abim', '2018-06-24 08:40:24', '2018-06-24 08:40:24'),
(3, ' Lotukei', 'Abim', '2018-06-24 08:40:42', '2018-06-24 08:40:42'),
(4, 'Kaabong', 'Kaabong', '2018-06-24 08:41:26', '2018-06-24 08:41:26'),
(5, 'Loyoro', 'Kaabong', '2018-06-24 08:41:45', '2018-06-24 08:41:45'),
(6, 'Kalapata', 'Kaabong', '2018-06-24 08:42:05', '2018-06-24 08:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` varchar(20) NOT NULL,
  `deleted_by` varchar(200) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `category`, `deleted_by`, `deleted_at`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Biology', 'science', 'Ocaka Alfred', '2018-05-30 13:19:02', '0', '2018-05-30 07:14:26', '2018-05-30 13:19:03'),
(2, 'Chemistry', 'science', '', NULL, '0', '2018-05-30 07:14:50', '2018-05-30 07:14:50'),
(3, 'History', 'art', 'Ocaka Alfred', NULL, '0', '2018-05-30 07:15:01', '2018-05-30 13:11:07'),
(4, 'Commerce', 'art', NULL, NULL, '0', '2018-05-30 13:14:19', '2018-05-30 13:14:19'),
(5, 'Agriculture Principles and Practices', 'art', NULL, NULL, '0', '2018-05-31 20:16:24', '2018-05-31 20:16:24'),
(6, 'Computer Studies', 'science', NULL, NULL, '0', '2018-05-31 20:17:15', '2018-05-31 20:17:15'),
(7, 'Entrepreneurship Education', 'art', NULL, NULL, '0', '2018-05-31 20:17:31', '2018-05-31 20:17:31'),
(8, 'Fine Art', 'art', NULL, NULL, '0', '2018-05-31 20:18:05', '2018-05-31 20:18:05'),
(9, 'General Science', 'science', NULL, NULL, '0', '2018-05-31 20:18:23', '2018-05-31 20:18:23'),
(10, 'Geography', 'art', NULL, NULL, '0', '2018-05-31 20:18:36', '2018-05-31 20:18:36'),
(11, 'Home Economics', 'art', NULL, NULL, '0', '2018-05-31 20:18:56', '2018-05-31 20:18:56'),
(12, 'Kiswahili', 'art', NULL, NULL, '0', '2018-05-31 20:19:25', '2018-05-31 20:19:25'),
(13, 'Literature in English', 'art', NULL, NULL, '0', '2018-05-31 20:19:42', '2018-05-31 20:19:42'),
(14, 'Mathematics', 'science', NULL, NULL, '0', '2018-05-31 20:20:06', '2018-05-31 20:20:06'),
(15, 'Metal Work', 'science', NULL, NULL, '0', '2018-05-31 20:20:26', '2018-05-31 20:20:26'),
(16, 'Music', 'art', NULL, NULL, '0', '2018-05-31 20:20:42', '2018-05-31 20:20:42'),
(17, 'Physical Education', 'art', NULL, NULL, '0', '2018-05-31 20:21:02', '2018-05-31 20:21:02'),
(18, 'Religious Education', 'art', NULL, NULL, '0', '2018-05-31 20:21:15', '2018-05-31 20:21:15'),
(19, ' Wood Work', 'art', NULL, NULL, '0', '2018-05-31 20:21:30', '2018-05-31 20:21:30'),
(20, 'Technical Drawing', 'art', NULL, NULL, '0', '2018-05-31 20:21:48', '2018-05-31 20:21:48'),
(21, 'Local Languages', 'art', NULL, NULL, '0', '2018-05-31 20:22:02', '2018-05-31 20:22:02'),
(22, 'Additional  Mathematics', 'science', NULL, NULL, '0', '2018-06-19 15:35:25', '2018-06-19 15:36:09'),
(23, 'Luganda', 'art', NULL, NULL, '0', '2018-06-21 13:27:51', '2018-06-21 13:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `tribes`
--

CREATE TABLE `tribes` (
  `id` int(11) NOT NULL,
  `tribe_name` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tribes`
--

INSERT INTO `tribes` (`id`, `tribe_name`, `created_at`, `updated_at`) VALUES
(1, 'Pokpt', '2018-06-25 06:18:48', NULL),
(2, 'Oropoi', '2018-06-25 06:18:48', NULL),
(3, 'Kadam', '2018-06-25 06:19:37', NULL),
(4, 'Bukwo', '2018-06-25 06:19:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `api_token` varchar(100) DEFAULT NULL,
  `role_id` int(10) DEFAULT '1',
  `deleted` enum('0','1') DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `api_token`, `role_id`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `updated_at`) VALUES
(14, 'Admin', 'admin@gmail.com', '$2y$10$fLQ0ezoj.DBJHLifkgmC2.9xDnWFhsWWg9JbP6p6tKr2Pa9/GMwPq', '0999900000', NULL, 4, '0', '2018-07-17 03:18:17', 'Admin', '2018-05-26 17:16:03', '2018-07-17 03:20:24'),
(25, 'Alfred Ocaka', 'fredocaka@gmail.com', '$2y$10$qYZ0DTzrMZM1tYBZUQY5iuXHWFqRmz.r.tYFHCcRQbjzRig/InCI6', '+256702242866', 'd09b745cb122d076934ebb2d0fd09350', 2, '1', '2018-07-17 03:21:04', 'Admin', '2018-07-14 19:02:40', '2018-07-17 03:21:04'),
(26, 'Super Admin', 'superadmin@gmail.com', '$2y$10$xqN6Ln4NRb5LcbzeyW1jXODeJ4JiPXxztEyIHVnKf8dTFU.0Q0ZbC', '07022428667', '896c036118b06e7e695dff1a337110a4', 5, '0', '2018-07-17 03:06:26', 'Admin', '2018-07-14 19:58:03', '2018-07-17 03:20:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amount`
--
ALTER TABLE `amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complains`
--
ALTER TABLE `complains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropouts`
--
ALTER TABLE `dropouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funders`
--
ALTER TABLE `funders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hostels`
--
ALTER TABLE `hostels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `secondary`
--
ALTER TABLE `secondary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `district` (`district`);

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcounties`
--
ALTER TABLE `subcounties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tribes`
--
ALTER TABLE `tribes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amount`
--
ALTER TABLE `amount`
  MODIFY `id` bigint(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `complains`
--
ALTER TABLE `complains`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT for table `dropouts`
--
ALTER TABLE `dropouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `funders`
--
ALTER TABLE `funders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `hostels`
--
ALTER TABLE `hostels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` bigint(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` bigint(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `secondary`
--
ALTER TABLE `secondary`
  MODIFY `id` bigint(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;
--
-- AUTO_INCREMENT for table `student_subjects`
--
ALTER TABLE `student_subjects`
  MODIFY `id` bigint(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
--
-- AUTO_INCREMENT for table `subcounties`
--
ALTER TABLE `subcounties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tribes`
--
ALTER TABLE `tribes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `schools_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`district`) REFERENCES `districts` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;