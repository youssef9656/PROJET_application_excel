-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 12:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `journale`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id_article` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `stock_min` float NOT NULL,
  `stock_initial` float NOT NULL,
  `prix` float DEFAULT NULL,
  `unite` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id_article`, `nom`, `description`, `stock_min`, `stock_initial`, `prix`, `unite`) VALUES
(8, 'Article 1', 'Description de l\'article 1', 10, 50, 29.99, 'Unité 1'),
(9, 'Article 2', 'Description de l\'article 2', 20, 100, 25, 'Unité 2'),
(10, 'Article 3', 'Description de l\'article 3', 15, 75, 19.99, 'Unité 3'),
(11, 'Article 4', 'Description de l\'article 4', 12, 60, 35, 'Unité 4'),
(12, 'Article 5', 'Description de l\'article 5', 8, 40, 22.5, 'Unité 5'),
(13, 'Article 6', 'Description de l\'article 6', 18, 90, 27, 'Unité 6'),
(14, 'Article 7', 'Description de l\'article 7', 20, 100, 30, 'Unité 7'),
(15, 'Article 8', 'Description de l\'article 8', 5, 25, 15, 'Unité 8'),
(16, 'Article 9', 'Description de l\'article 9', 25, 125, 40, 'Unité 9'),
(17, 'Article 10', 'Description de l\'article 10', 10, 50, 28, 'Unité 10'),
(18, 'Article 11', 'Description de l\'article 11', 22, 110, 33, 'Unité 11'),
(19, 'Article 12', 'Description de l\'article 12', 14, 70, 20, 'Unité 12'),
(20, 'Article 13', 'Description de l\'article 13', 19, 95, 24.5, 'Unité 13'),
(21, 'Article 14', 'Description de l\'article 14', 16, 80, 29, 'Unité 14'),
(22, 'Article 15', 'Description de l\'article 15', 13, 65, 31.5, 'Unité 15'),
(23, 'Article 16', 'Description de l\'article 16', 11, 55, 26, 'Unité 16'),
(24, 'Article 17', 'Description de l\'article 17', 17, 85, 21, 'Unité 17'),
(25, 'Article 18', 'Description de l\'article 18', 21, 105, 34, 'Unité 18'),
(26, 'Article 19', 'Description de l\'article 19', 9, 45, 18, 'Unité 19'),
(27, 'Article 20', 'Description de l\'article 20', 12, 60, 22, 'Unité 20'),
(28, 'Article 21', 'Description de l\'article 21', 14, 70, 25.5, 'Unité 21'),
(29, 'Article 22', 'Description de l\'article 22', 18, 90, 28, 'Unité 22'),
(30, 'Article 23', 'Description de l\'article 23', 16, 80, 31, 'Unité 23'),
(31, 'Article 24', 'Description de l\'article 24', 20, 100, 34.5, 'Unité 24'),
(32, 'Article 25', 'Description de l\'article 25', 23, 115, 37, 'Unité 25'),
(33, 'Article 26', 'Description de l\'article 26', 15, 75, 32, 'Unité 26'),
(34, 'Article 27', 'Description de l\'article 27', 19, 95, 29.5, 'Unité 27'),
(35, 'Article 28', 'Description de l\'article 28', 22, 110, 36, 'Unité 28'),
(36, 'Article 29', 'Description de l\'article 29', 11, 55, 24, 'Unité 29'),
(37, 'Article 30', 'Description de l\'article 30', 13, 65, 26.5, 'Unité 30'),
(38, 'Article 31', 'Description de l\'article 31', 17, 85, 29, 'Unité 31'),
(39, 'Article 32', 'Description de l\'article 32', 12, 60, 31.5, 'Unité 32'),
(40, 'Article 33', 'Description de l\'article 33', 15, 75, 34, 'Unité 33'),
(41, 'Article 34', 'Description de l\'article 34', 18, 90, 36.5, 'Unité 34'),
(42, 'Article 35', 'Description de l\'article 35', 14, 70, 39, 'Unité 35'),
(43, 'Article 36', 'Description de l\'article 36', 22, 110, 41, 'Unité 36'),
(44, 'Article 37', 'Description de l\'article 37', 19, 95, 43, 'Unité 37'),
(45, 'Article 38', 'Description de l\'article 38', 21, 105, 45, 'Unité 38'),
(46, 'Article 39', 'Description de l\'article 39', 16, 80, 48, 'Unité 39'),
(47, 'Article 40', 'Description de l\'article 40', 12, 60, 50, 'Unité 40'),
(48, 'Article 41', 'Description de l\'article 41', 13, 65, 52, 'Unité 41'),
(49, 'Article 42', 'Description de l\'article 42', 17, 85, 54, 'Unité 42'),
(50, 'Article 43', 'Description de l\'article 43', 15, 75, 56, 'Unité 43'),
(51, 'Article 44', 'Description de l\'article 44', 19, 95, 58, 'Unité 44'),
(52, 'Article 45', 'Description de l\'article 45', 21, 105, 60, 'Unité 45'),
(53, 'Article 46', 'Description de l\'article 46', 16, 80, 62, 'Unité 46'),
(54, 'Article 47', 'Description de l\'article 47', 22, 110, 64, 'Unité 47'),
(55, 'Article 48', 'Description de l\'article 48', 19, 95, 66, 'Unité 48'),
(56, 'Article 49', 'Description de l\'article 49', 14, 70, 68, 'Unité 49'),
(57, 'Article 50', 'Description de l\'article 50', 13, 65, 70, 'Unité 50'),
(58, 'Article 51', 'Description de l\'article 51', 17, 85, 72, 'Unité 51'),
(59, 'Article 52', 'Description de l\'article 52', 12, 60, 74, 'Unité 52'),
(60, 'Article 53', 'Description de l\'article 53', 15, 75, 76, 'Unité 53'),
(61, 'Article 54', 'Description de l\'article 54', 18, 90, 78, 'Unité 54'),
(62, 'Article 55', 'Description de l\'article 55', 20, 100, 80, 'Unité 55'),
(63, 'Article 56', 'Description de l\'article 56', 22, 110, 82, 'Unité 56'),
(64, 'Article 57', 'Description de l\'article 57', 24, 120, 84, 'Unité 57'),
(65, 'Article 58', 'Description de l\'article 58', 26, 130, 86, 'Unité 58'),
(66, 'Article 59', 'Description de l\'article 59', 28, 140, 88, 'Unité 59'),
(67, 'Article 60', 'Description de l\'article 60', 30, 150, 90, 'Unité 60'),
(68, 'Article 61', 'Description de l\'article 61', 32, 160, 92, 'Unité 61'),
(69, 'Article 62', 'Description de l\'article 62', 34, 170, 94, 'Unité 62'),
(70, 'Article 63', 'Description de l\'article 63', 36, 180, 96, 'Unité 63'),
(71, 'Article 64', 'Description de l\'article 64', 38, 190, 98, 'Unité 64'),
(72, 'Article 65', 'Description de l\'article 65', 40, 200, 100, 'Unité 65'),
(73, 'Article 66', 'Description de l\'article 66', 42, 210, 102, 'Unité 66'),
(74, 'Article 67', 'Description de l\'article 67', 44, 220, 104, 'Unité 67'),
(75, 'Article 68', 'Description de l\'article 68', 46, 230, 106, 'Unité 68'),
(76, 'Article 69', 'Description de l\'article 69', 48, 240, 108, 'Unité 69'),
(77, 'Article 70', 'Description de l\'article 70', 50, 250, 110, 'Unité 70'),
(78, 'Article 71', 'Description de l\'article 71', 52, 260, 112, 'Unité 71'),
(79, 'Article 72', 'Description de l\'article 72', 54, 270, 114, 'Unité 72'),
(80, 'Article 73', 'Description de l\'article 73', 56, 280, 116, 'Unité 73'),
(81, 'Article 74', 'Description de l\'article 74', 58, 290, 118, 'Unité 74'),
(82, 'Article 75', 'Description de l\'article 75', 60, 300, 120, 'Unité 75'),
(83, 'Article 76', 'Description de l\'article 76', 62, 310, 122, 'Unité 76'),
(84, 'Article 77', 'Description de l\'article 77', 64, 320, 124, 'Unité 77'),
(85, 'Article 78', 'Description de l\'article 78', 66, 330, 126, 'Unité 78'),
(86, 'Article 79', 'Description de l\'article 79', 68, 340, 128, 'Unité 79'),
(87, 'Article 80', 'Description de l\'article 80', 70, 350, 130, 'Unité 80'),
(88, 'Article 81', 'Description de l\'article 81', 72, 360, 132, 'Unité 81'),
(89, 'Article 82', 'Description de l\'article 82', 74, 370, 134, 'Unité 82'),
(90, 'Article 83', 'Description de l\'article 83', 76, 380, 136, 'Unité 83'),
(91, 'Article 84', 'Description de l\'article 84', 78, 390, 138, 'Unité 84'),
(92, 'Article 85', 'Description de l\'article 85', 80, 400, 140, 'Unité 85'),
(93, 'Article 86', 'Description de l\'article 86', 82, 410, 142, 'Unité 86'),
(94, 'Article 87', 'Description de l\'article 87', 84, 420, 144, 'Unité 87'),
(95, 'Article 88', 'Description de l\'article 88', 86, 430, 146, 'Unité 88'),
(96, 'Article 89', 'Description de l\'article 89', 88, 440, 148, 'Unité 89'),
(97, 'Article 90', 'Description de l\'article 90', 90, 450, 150, 'Unité 90'),
(98, 'Article 91', 'Description de l\'article 91', 92, 460, 152, 'Unité 91'),
(99, 'Article 92', 'Description de l\'article 92', 94, 470, 154, 'Unité 92'),
(100, 'Article 93', 'Description de l\'article 93', 96, 480, 156, 'Unité 93'),
(101, 'Article 94', 'Description de l\'article 94', 98, 490, 158, 'Unité 94'),
(102, 'Article 95', 'Description de l\'article 95', 100, 500, 160, 'Unité 95'),
(103, 'Article 96', 'Description de l\'article 96', 102, 510, 162, 'Unité 96'),
(104, 'Article 97', 'Description de l\'article 97', 104, 520, 164, 'Unité 97'),
(105, 'Article 98', 'Description de l\'article 98', 106, 530, 166, 'Unité 98'),
(106, 'Article 99', 'Description de l\'article 99', 108, 540, 168, 'Unité 99'),
(107, 'Article 100', 'Description de l\'article 100', 110, 550, 170, 'Unité 100'),
(108, 'pomme', 'pomme vert', 10, 30, 3.33, 'kg'),
(109, 'hhhhhhhhhh', 'jjjjjjj', 22, 110000, 0, 'hhhh'),
(110, 'lait de coco 400g', 'fg', 22, 10000, 0, 'bt'),
(111, 'recotta 294g', 'fg', 22, 29000, 0, 'kg'),
(112, 'fromage parmesan', 'gg', 2, 6900, 0, 'kg'),
(113, 'fro', 'yyyyyyyyyyyyyy', 2, 1000, 0, 'seau'),
(114, 'filet d\'anchois marine 0,75 kg', 'fg', 2, 12000, 0, 'bt'),
(115, 'capre au vinaigre bangor 4/4', 'df', 2, 3000, 0, 'bt'),
(116, 'cornichons 1,6 kg', 'cv', 2, 7000, 0, 'ut'),
(117, 'poivre vert 35g', 'df', 222, 21000, 0, 'ut'),
(118, 'germ de soja', 'df', 222, 21000, 0, 'bt'),
(119, 'mais dadisol boite 1/2', 'df', 222, 0, 0, 'bt'),
(120, 'tomate concentre 4/4', 'fg', 222, 21000, 0, 'bt'),
(121, 'banan 1', 'gh', 67, 56, 0, 'bt'),
(122, 'banan 2', 'gh', 67, 56, 0, 'bt'),
(123, 'banan 3', 'gh', 67, 56, 0, 'bt'),
(124, 'banan 4', 'gh', 67, 56, 0, 'bt'),
(125, 'banan 5', 'gh', 67, 56, 0, 'bt'),
(126, 'banan 6', 'gh', 67, 56, 0, 'bt'),
(127, 'banan 7', 'gh', 67, 56, 0, 'bt'),
(128, 'banan 8', 'gh', 67, 56, 0, 'bt'),
(129, 'banan 9', 'gh', 67, 56, 0, 'bt'),
(130, 'banan 10', 'gh', 67, 56, 0, 'bt'),
(131, 'banan 11', 'gh', 67, 56, 0, 'bt'),
(132, 'banan 12', 'gh', 67, 56, 0, 'bt'),
(133, 'banan 13', 'gh', 67, 56, 0, 'bt'),
(134, 'banan 14', 'gh', 67, 56, 0, 'bt'),
(135, 'banan 15', 'gh', 67, 56, 0, 'bt'),
(136, 'banan 16', 'gh', 67, 56, 0, 'bt'),
(137, 'banan 17', 'gh', 67, 56, 0, 'bt'),
(138, 'tomat 1', 'lot ggg', 67, 56, 0, 'lot ggg'),
(139, 'tomat 2', 'lot ggg', 67, 56, 0, 'lot ggg'),
(140, 'tomat 3', 'lot ggg', 67, 56, 0, 'lot ggg'),
(141, 'tomat 4', 'lot ggg', 67, 56, 0, 'lot ggg'),
(142, 'tomat 5', 'lot ggg', 67, 56, 0, 'lot ggg'),
(143, 'tomat 6', 'lot ggg', 67, 56, 0, 'lot ggg'),
(144, 'tomat 7', 'lot ggg', 67, 56, 0, 'lot ggg'),
(145, 'tomat 8', 'lot ggg', 67, 56, 0, 'lot ggg'),
(146, 'tomat 9', 'lot ggg', 67, 56, 0, 'lot ggg'),
(147, 'tomat 10', 'lot ggg', 67, 56, 0, 'lot ggg'),
(148, 'tomat 11', 'lot ggg', 67, 56, 0, 'lot ggg'),
(149, 'tomat 12', 'lot ggg', 67, 56, 0, 'lot ggg'),
(150, 'tomat 13', 'lot ggg', 67, 56, 0, 'lot ggg'),
(151, 'tomat 14', 'lot ggg', 67, 56, 0, 'lot ggg'),
(152, 'tomat 15', 'lot ggg', 67, 56, 0, 'lot ggg'),
(153, 'tomat 16', 'lot ggg', 67, 56, 0, 'lot ggg'),
(154, 'tomat 17', 'lot ggg', 67, 56, 0, 'lot ggg'),
(155, 'tomat 18', 'lot ggg', 67, 56, 0, 'lot ggg'),
(156, 'tomat 19', 'lot ggg', 67, 56, 0, 'lot ggg'),
(157, 'tomat 20', 'lot ggg', 67, 56, 0, 'lot ggg'),
(158, 'tomat 21', 'lot ggg', 67, 56, 0, 'lot ggg'),
(159, 'tomat 22', 'lot ggg', 67, 56, 0, 'lot ggg'),
(160, 'tomat 23', 'lot ggg', 67, 56, 0, 'lot ggg'),
(161, 'tomat 24', 'lot ggg', 67, 56, 0, 'lot ggg'),
(162, 'tomat 25', 'lot ggg', 67, 56, 0, 'lot ggg'),
(163, 'tomat 26', 'lot ggg', 67, 56, 0, 'lot ggg'),
(164, 'tomat 27', 'lot ggg', 67, 56, 0, 'lot ggg'),
(165, 'tomat 28', 'lot ggg', 67, 56, 0, 'lot ggg'),
(166, 'tomat 29', 'lot ggg', 67, 56, 0, 'lot ggg'),
(167, 'tomat 30', 'lot ggg', 67, 56, 0, 'lot ggg'),
(168, 'tomat 31', 'lot ggg', 67, 56, 0, 'lot ggg'),
(169, 'tomat 32', 'lot ggg', 67, 56, 0, 'lot ggg'),
(170, 'tomat 33', 'lot ggg', 67, 56, 0, 'lot ggg'),
(171, 'tomat 34', 'lot ggg', 67, 56, 0, 'lot ggg'),
(172, 'tomat 35', 'lot ggg', 67, 56, 0, 'lot ggg'),
(173, 'tomat 36', 'lot ggg', 67, 56, 0, 'lot ggg'),
(174, 'tomat 37', 'lot ggg', 67, 56, 0, 'lot ggg'),
(175, 'tomat 38', 'lot ggg', 67, 56, 0, 'lot ggg'),
(176, 'tomat 39', 'lot ggg', 67, 56, 0, 'lot ggg'),
(177, 'tomat 40', 'lot ggg', 67, 56, 0, 'lot ggg'),
(178, 'tomat 41', 'lot ggg', 67, 56, 0, 'lot ggg'),
(179, 'tomat 42', 'lot ggg', 67, 56, 0, 'lot ggg'),
(180, 'tomat 43', 'lot ggg', 67, 56, 0, 'lot ggg'),
(181, 'tomat 44', 'lot ggg', 67, 56, 0, 'lot ggg'),
(182, 'tomat 45', 'lot ggg', 67, 56, 0, 'lot ggg'),
(183, 'tomat 46', 'lot ggg', 67, 56, 0, 'lot ggg'),
(184, 'tomat 47', 'lot ggg', 67, 56, 0, 'lot ggg'),
(185, 'tomat 48', 'lot ggg', 67, 56, 0, 'lot ggg'),
(186, 'tomat 49', 'lot ggg', 67, 56, 0, 'lot ggg'),
(187, 'tomat 50', 'lot ggg', 67, 56, 0, 'lot ggg'),
(188, 'tomat 51', 'lot ggg', 67, 56, 0, 'lot ggg'),
(189, 'tomat 52', 'lot ggg', 67, 56, 0, 'lot ggg'),
(190, 'tomat 53', 'lot ggg', 67, 56, 0, 'lot ggg'),
(191, 'tomat 54', 'lot ggg', 67, 56, 0, 'lot ggg'),
(192, 'tomat 55', 'lot ggg', 67, 56, 0, 'lot ggg'),
(193, 'tomat 56', 'lot ggg', 67, 56, 0, 'lot ggg'),
(194, 'tomat 57', 'lot ggg', 67, 56, 0, 'lot ggg'),
(195, 'tomat 58', 'lot ggg', 67, 56, 0, 'lot ggg'),
(196, 'tomat 59', 'lot ggg', 67, 56, 0, 'lot ggg'),
(197, 'tomat 60', 'lot ggg', 67, 56, 0, 'lot ggg'),
(198, 'tomat 61', 'lot ggg', 67, 56, 0, 'lot ggg'),
(199, 'tomat 62', 'lot ggg', 67, 56, 0, 'lot ggg'),
(200, 'tomat 63', 'lot ggg', 67, 56, 0, 'lot ggg'),
(201, 'tomat 64', 'lot ggg', 67, 56, 0, 'lot ggg'),
(202, 'tomat 65', 'lot ggg', 67, 56, 0, 'lot ggg'),
(203, 'tomat 66', 'lot ggg', 67, 56, 0, 'lot ggg'),
(204, 'tomat 67', 'lot ggg', 67, 56, 0, 'lot ggg'),
(205, 'tomat 68', 'lot ggg', 67, 56, 0, 'lot ggg'),
(206, 'tomat 69', 'lot ggg', 67, 56, 0, 'lot ggg'),
(207, 'tomat 70', 'lot ggg', 67, 56, 0, 'lot ggg'),
(208, 'tomat 71', 'lot ggg', 67, 56, 0, 'lot ggg'),
(209, 'tomat 72', 'lot ggg', 67, 56, 0, 'lot ggg'),
(210, 'tomat 73', 'lot ggg', 67, 56, 0, 'lot ggg'),
(211, 'tomat 74', 'lot ggg', 67, 56, 0, 'lot ggg'),
(212, 'tomat 75', 'lot ggg', 67, 56, 0, 'lot ggg'),
(213, 'tomat 76', 'lot ggg', 67, 56, 0, 'lot ggg'),
(214, 'tomat 77', 'lot ggg', 67, 56, 0, 'lot ggg'),
(215, 'tomat 78', 'lot ggg', 67, 56, 0, 'lot ggg'),
(216, 'tomat 79', 'lot ggg', 67, 56, 0, 'lot ggg'),
(217, 'tomat 80', 'lot ggg', 67, 56, 0, 'lot ggg'),
(218, 'tomat 81', 'lot ggg', 67, 56, 0, 'lot ggg'),
(219, 'tomat 82', 'lot ggg', 67, 56, 0, 'lot ggg'),
(220, 'tomat 83', 'lot ggg', 67, 56, 0, 'lot ggg'),
(221, 'tomat 84', 'lot ggg', 67, 56, 0, 'lot ggg'),
(222, 'tomat 85', 'lot ggg', 67, 56, 0, 'lot ggg'),
(223, 'tomat 86', 'lot ggg', 67, 56, 0, 'lot ggg'),
(224, 'tomat 87', 'lot ggg', 67, 56, 0, 'lot ggg'),
(225, 'tomat 88', 'lot ggg', 67, 56, 0, 'lot ggg'),
(226, 'tomat 89', 'lot ggg', 67, 56, 0, 'lot ggg'),
(227, 'tomat 90', 'lot ggg', 67, 56, 0, 'lot ggg'),
(228, 'tomat 91', 'lot ggg', 67, 56, 0, 'lot ggg'),
(229, 'tomat 92', 'lot ggg', 67, 56, 0, 'lot ggg'),
(230, 'tomat 93', 'lot ggg', 67, 56, 0, 'lot ggg'),
(231, 'tomat 94', 'lot ggg', 67, 56, 0, 'lot ggg'),
(232, 'tomat 95', 'lot ggg', 67, 56, 0, 'lot ggg'),
(233, 'tomat 96', 'lot ggg', 67, 56, 0, 'lot ggg'),
(234, 'tomat 97', 'lot ggg', 67, 56, 0, 'lot ggg'),
(235, 'tomat 98', 'lot ggg', 67, 56, 0, 'lot ggg'),
(236, 'tomat 99', 'lot ggg', 67, 56, 0, 'lot ggg'),
(237, 'tomat 100', 'lot ggg', 67, 56, 0, 'lot ggg'),
(238, 'tomat 101', 'lot ggg', 67, 56, 0, 'lot ggg'),
(239, 'tomat 102', 'lot ggg', 67, 56, 0, 'lot ggg'),
(240, 'tomat 103', 'lot ggg', 67, 56, 0, 'lot ggg'),
(241, 'tomat 104', 'lot ggg', 67, 56, 0, 'lot ggg'),
(242, 'tomat 105', 'lot ggg', 67, 56, 0, 'lot ggg'),
(243, 'tomat 106', 'lot ggg', 67, 56, 0, 'lot ggg'),
(244, 'tomat 107', 'lot ggg', 67, 56, 0, 'lot ggg'),
(245, 'tomat 108', 'lot ggg', 67, 56, 0, 'lot ggg'),
(246, 'tomat 109', 'lot ggg', 67, 56, 0, 'lot ggg'),
(247, 'tomat 110', 'lot ggg', 67, 56, 0, 'lot ggg'),
(248, 'tomat 111', 'lot ggg', 67, 56, 0, 'lot ggg'),
(249, 'tomat 112', 'lot ggg', 67, 56, 0, 'lot ggg'),
(250, 'tomat 113', 'lot ggg', 67, 56, 0, 'lot ggg'),
(251, 'tomat 114', 'lot ggg', 67, 56, 0, 'lot ggg'),
(252, 'tomat 115', 'lot ggg', 67, 56, 0, 'lot ggg'),
(253, 'tomat 116', 'lot ggg', 67, 56, 0, 'lot ggg'),
(254, 'tomat 117', 'lot ggg', 67, 56, 0, 'lot ggg'),
(255, 'tomat 118', 'lot ggg', 67, 56, 0, 'lot ggg'),
(256, 'tomat 119', 'lot ggg', 67, 56, 0, 'lot ggg'),
(257, 'tomat 120', 'lot ggg', 67, 56, 0, 'lot ggg'),
(258, 'tomat 121', 'lot ggg', 67, 56, 0, 'lot ggg'),
(259, 'tomat 122', 'lot ggg', 67, 56, 0, 'lot ggg'),
(260, 'tomat 123', 'lot ggg', 67, 56, 0, 'lot ggg'),
(261, 'tomat 124', 'lot ggg', 67, 56, 0, 'lot ggg'),
(262, 'tomat 125', 'lot ggg', 67, 56, 0, 'lot ggg'),
(263, 'tomat 126', 'lot ggg', 67, 56, 0, 'lot ggg'),
(264, 'tomat 127', 'lot ggg', 67, 56, 0, 'lot ggg'),
(265, 'tomat 128', 'lot ggg', 67, 56, 0, 'lot ggg'),
(266, 'tomat 129', 'lot ggg', 67, 56, 0, 'lot ggg'),
(267, 'tomat 130', 'lot ggg', 67, 56, 0, 'lot ggg'),
(268, 'tomat 131', 'lot ggg', 67, 56, 0, 'lot ggg'),
(269, 'tomat 132', 'lot ggg', 67, 56, 0, 'lot ggg'),
(270, 'tomat 133', 'lot ggg', 67, 56, 0, 'lot ggg'),
(271, 'tomat 134', 'lot ggg', 67, 56, 0, 'lot ggg'),
(272, 'tomat 135', 'lot ggg', 67, 56, 0, 'lot ggg'),
(273, 'tomat 136', 'lot ggg', 67, 56, 0, 'lot ggg'),
(274, 'tomat 137', 'lot ggg', 67, 56, 0, 'lot ggg'),
(275, 'tomat 138', 'lot ggg', 67, 56, 0, 'lot ggg'),
(276, 'tomat 139', 'lot ggg', 67, 56, 0, 'lot ggg'),
(277, 'tomat 140', 'lot ggg', 67, 56, 0, 'lot ggg'),
(278, 'tomat 141', 'lot ggg', 67, 56, 0, 'lot ggg'),
(279, 'tomat 142', 'lot ggg', 67, 56, 0, 'lot ggg'),
(280, 'tomat 143', 'lot ggg', 67, 56, 0, 'lot ggg'),
(281, 'tomat 144', 'lot ggg', 67, 56, 0, 'lot ggg'),
(282, 'tomat 145', 'lot ggg', 67, 56, 0, 'lot ggg'),
(283, 'tomat 146', 'lot ggg', 67, 56, 0, 'lot ggg'),
(284, 'tomat 147', 'lot ggg', 67, 56, 0, 'lot ggg'),
(285, 'tomat 148', 'lot ggg', 67, 56, 0, 'lot ggg'),
(286, 'tomat 149', 'lot ggg', 67, 56, 0, 'lot ggg'),
(287, 'tomat 150', 'lot ggg', 67, 56, 0, 'lot ggg'),
(288, 'tomat 151', 'lot ggg', 67, 56, 0, 'lot ggg'),
(289, 'tomat 152', 'lot ggg', 67, 56, 0, 'lot ggg'),
(290, 'tomat 153', 'lot ggg', 67, 56, 0, 'lot ggg'),
(291, 'tomat 154', 'lot ggg', 67, 56, 0, 'lot ggg'),
(292, 'tomat 155', 'lot ggg', 67, 56, 0, 'lot ggg'),
(293, 'tomat 156', 'lot ggg', 67, 56, 0, 'lot ggg'),
(294, 'tomat 157', 'lot ggg', 67, 56, 0, 'lot ggg'),
(295, 'tomat 158', 'lot ggg', 67, 56, 0, 'lot ggg'),
(296, '12', '12', 12, 12, 12, '12'),
(297, 'aaaa', 'aaaa', 1212, 12, 1221, 'g'),
(298, 'zzzzzzzzzu uf fl.  ljsdfs dlfjkhdlfas jhalsjdkfhlasjd ad fkjaljsdf ajsdf ajfl ksajdf ', 'efs', 12, 12, 12, '12'),
(299, 'zzzzzzzzzu uf fl. ljsdfs dlfjkhdlfas jhalsjdkfhlasjd ad fkjaljsdf ajsdf ajfl ksajdf	g', 'ert', 324, 324, 24, '342');

-- --------------------------------------------------------

--
-- Table structure for table `etat_de_stocks`
--
-- Error reading structure for table journale.etat_de_stocks: #1932 - Table &#039;journale.etat_de_stocks&#039; doesn&#039;t exist in engine
-- Error reading data for table journale.etat_de_stocks: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `journale`.`etat_de_stocks`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `filtered_data`
--

CREATE TABLE `filtered_data` (
  `id` int(11) NOT NULL,
  `article` varchar(250) NOT NULL,
  `stock_initial` float NOT NULL,
  `entree_operation` decimal(10,2) DEFAULT 0.00,
  `sortie_operation` decimal(10,2) DEFAULT 0.00,
  `stock_final` float NOT NULL,
  `valeur_stock` decimal(10,2) DEFAULT 0.00,
  `stock_min` float NOT NULL,
  `besoin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id_fournisseur` int(11) NOT NULL,
  `nom_fournisseur` varchar(250) NOT NULL,
  `prenom_fournisseur` varchar(250) NOT NULL,
  `cp_fournisseur` varchar(250) DEFAULT NULL,
  `ville_fournisseur` varchar(250) DEFAULT NULL,
  `pay_fournisseur` varchar(250) DEFAULT NULL,
  `telephone_fixe_fournisseur` varchar(250) DEFAULT NULL,
  `telephone_portable_fournisseur` varchar(250) DEFAULT NULL,
  `commande_fournisseur` varchar(250) DEFAULT NULL,
  `condition_livraison` varchar(250) DEFAULT NULL,
  `coord_livreur` varchar(250) DEFAULT NULL,
  `calendrier_livraison` varchar(250) DEFAULT NULL,
  `details_livraison` varchar(250) DEFAULT NULL,
  `condition_paiement` varchar(250) DEFAULT NULL,
  `facturation` varchar(250) DEFAULT NULL,
  `certificatione` varchar(250) DEFAULT NULL,
  `produit_service_fourni` varchar(250) DEFAULT NULL,
  `siuvi_fournisseur` varchar(250) DEFAULT NULL,
  `mail_fournisseur` varchar(250) DEFAULT NULL,
  `groupe_fournisseur` varchar(250) DEFAULT NULL,
  `adress_fournisseur` varchar(250) DEFAULT NULL,
  `action_A_D` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id_fournisseur`, `nom_fournisseur`, `prenom_fournisseur`, `cp_fournisseur`, `ville_fournisseur`, `pay_fournisseur`, `telephone_fixe_fournisseur`, `telephone_portable_fournisseur`, `commande_fournisseur`, `condition_livraison`, `coord_livreur`, `calendrier_livraison`, `details_livraison`, `condition_paiement`, `facturation`, `certificatione`, `produit_service_fourni`, `siuvi_fournisseur`, `mail_fournisseur`, `groupe_fournisseur`, `adress_fournisseur`, `action_A_D`) VALUES
(1, 'mouad', 'harimech', '75001', 'Paris', 'France', '0142010202', '0612345678', 'Commande rapide', 'Livraison sous 48h', 'Livreur X', 'Lundi-Vendredi', 'Livraison gratuite', 'Paiement à 30 jours', 'Facture standard', 'Certifié ISO', 'Matériel informatique', 'SIU123', 'jean.dupont@example.com', 'Groupe A', '1 rue de Paris', 0),
(5, 'Benoit', 'Luc', '13001', 'Marseille', 'France', '0482345678', '0623456789', 'Commande urgente', 'Livraison sous 48h', 'Livreur B', 'Lundi-Dimanche', 'Livraison gratuite', 'Paiement anticipé', 'Facture électronique', 'Certifié NF', 'Matériel de sport', 'SIU345', 'luc.benoit@example.com', 'Groupe E', '5 rue de Marseille', 0),
(6, 'Petit', 'Élise', '59000', 'Lille', 'France', '0324567890', '0612345678', 'Commande simple', 'Livraison sous 72h', 'Livreur C', 'Mardi-Samedi', 'Livraison gratuite au-delà de 50€', 'Paiement à 30 jours', 'Facture PDF', 'Certifié ISO', 'Livres et publications', 'SIU678', 'elise.petit@example.com', 'Groupe F', '6 rue de Lille', 1),
(7, 'Garnier', 'Marcel', '06000', 'Nice', 'France', '0493123456', '0634567890', 'Commande régulière', 'Livraison sous 5 jours', 'Livreur D', 'Lundi-Vendredi', 'Livraison gratuite', 'Paiement à 60 jours', 'Facture classique', 'Non certifié', 'Produits alimentaires', 'SIU901', 'marcel.garnier@example.com', 'Groupe G', '7 rue de Nice', 0),
(8, 'Moreau', 'Anne', '44000', 'Nantes', 'France', '0244123456', '0612345678', 'Commande express', 'Livraison sous 24h', 'Livreur E', 'Lundi-Dimanche', 'Livraison gratuite', 'Paiement à 15 jours', 'Facture détaillée', 'Certifié ISO', 'Matériel médical', 'SIU234', 'anne.moreau@example.com', 'Groupe H', '8 rue de Nantes', 1),
(9, 'Lemoine', 'Jacques', '34000', 'Montpellier', 'France', '0467123456', '0623456789', 'Commande normale', 'Livraison sous 48h', 'Livreur F', 'Mardi-Dimanche', 'Livraison gratuite', 'Paiement à la livraison', 'Facture standard', 'Certifié CE', 'Équipements de bureau', 'SIU567', 'jacques.lemoine@example.com', 'Groupe I', '9 rue de Montpellier', 0),
(10, 'Roussea', 'Hélène', '69002', 'Lyon', 'France', '0478567890', '0612345678', 'Commande régulière', 'Livraison sous 72h', 'Livreur G', 'Lundi-Samedi', 'Livraison gratuite au-delà de 75€', 'Paiement en 3 fois', 'Facture électronique', 'Certifié NF', 'Vêtements', 'SIU890', 'helene.rousseau@example.com', 'Groupe J', '10 rue de Lyon', 0),
(11, 'Durand', 'Marie', '31000', 'Toulouse', 'France', '0567890123', '0612345678', 'Commande express', 'Livraison sous 24h', 'Livreur H', 'Lundi-Vendredi', 'Livraison gratuite au-delà de 100€', 'Paiement à 15 jours', 'Facture détaillée', 'Certifié ISO', 'Équipements de jardin', 'SIU234', 'marie.durand@example.com', 'Groupe K', '11 rue de Toulouse', 0),
(12, 'Brun', 'Robert', '67000', 'Strasbourg', 'France', '0382567890', '0634567890', 'Commande standard', 'Livraison sous 48h', 'Livreur I', 'Lundi-Samedi', 'Livraison gratuite', 'Paiement à la livraison', 'Facture classique', 'Non certifié', 'Instruments de musique', 'SIU345', 'robert.brun@example.com', 'Groupe L', '12 rue de Strasbourg', 0),
(13, 'Gauthier', 'Éric', '35000', 'Rennes', 'France', '0298567890', '0623456789', 'Commande rapide', 'Livraison sous 72h', 'Livreur J', 'Lundi-Dimanche', 'Livraison gratuite', 'Paiement en 3 fois', 'Facture PDF', 'Certifié NF', 'Équipements sportifs', 'SIU456', 'eric.gauthier@example.com', 'Groupe M', '13 rue de Rennes', 1),
(14, 'Dumas', 'Sylvie', '08000', 'Charleville-Mézières', 'France', '0325647890', '0612345678', 'Commande spéciale', 'Livraison sous 5 jours', 'Livreur K', 'Mardi-Samedi', 'Livraison gratuite au-delà de 75€', 'Paiement anticipé', 'Facture électronique', 'Certifié CE', 'Matériel de bureau', 'SIU567', 'sylvie.dumas@example.com', 'Groupe N', '14 rue de Charleville', 0),
(15, 'Lemoine', 'Antoine', '37000', 'Tours', 'France', '0248123456', '0634567890', 'Commande normale', 'Livraison sous 48h', 'Livreur L', 'Lundi-Vendredi', 'Livraison gratuite', 'Paiement à 30 jours', 'Facture standard', 'Certifié ISO', 'Matériel de construction', 'SIU678', 'antoine.lemoine@example.com', 'Groupe O', '15 rue de Tours', 1),
(16, 'Nom 1', 'Prénom 1', '00000', 'Ville 1', 'Pays 1', '0123456789', '0612345678', 'Commande 1', 'Condition 1', 'Coord 1', 'Calendrier 1', 'Détails 1', 'Condition 1', 'Facturation 1', 'Certification 1', 'Produit 1', 'Siuvi 1', 'email1@example.com', 'Groupe 1', 'Adresse 1', 0),
(17, 'Nom 2', 'Prénom 2', '00001', 'Ville 2', 'Pays 2', '0123456790', '0612345679', 'Commande 2', 'Condition 2', 'Coord 2', 'Calendrier 2', 'Détails 2', 'Condition 2', 'Facturation 2', 'Certification 2', 'Produit 2', 'Siuvi 2', 'email2@example.com', 'Groupe 2', 'Adresse 2', 0),
(18, 'Nom 3', 'Prénom 3', '00002', 'Ville 3', 'Pays 3', '0123456791', '0612345680', 'Commande 3', 'Condition 3', 'Coord 3', 'Calendrier 3', 'Détails 3', 'Condition 3', 'Facturation 3', 'Certification 3', 'Produit 3', 'Siuvi 3', 'email3@example.com', 'Groupe 3', 'Adresse 3', 0),
(19, 'Nom 4', 'Prénom 4', '00003', 'Ville 4', 'Pays 4', '0123456792', '0612345681', 'Commande 4', 'Condition 4', 'Coord 4', 'Calendrier 4', 'Détails 4', 'Condition 4', 'Facturation 4', 'Certification 4', 'Produit 4', 'Siuvi 4', 'email4@example.com', 'Groupe 4', 'Adresse 4', 0),
(20, 'Nom 5', 'Prénom 5', '00004', 'Ville 5', 'Pays 5', '0123456793', '0612345682', 'Commande 5', 'Condition 5', 'Coord 5', 'Calendrier 5', 'Détails 5', 'Condition 5', 'Facturation 5', 'Certification 5', 'Produit 5', 'Siuvi 5', 'email5@example.com', 'Groupe 5', 'Adresse 5', 0),
(21, 'Nom 6', 'Prénom 6', '00005', 'Ville 6', 'Pays 6', '0123456794', '0612345683', 'Commande 6', 'Condition 6', 'Coord 6', 'Calendrier 6', 'Détails 6', 'Condition 6', 'Facturation 6', 'Certification 6', 'Produit 6', 'Siuvi 6', 'email6@example.com', 'Groupe 6', 'Adresse 6', 0),
(22, 'Nom 7', 'Prénom 7', '00006', 'Ville 7', 'Pays 7', '0123456795', '0612345684', 'Commande 7', 'Condition 7', 'Coord 7', 'Calendrier 7', 'Détails 7', 'Condition 7', 'Facturation 7', 'Certification 7', 'Produit 7', 'Siuvi 7', 'email7@example.com', 'Groupe 7', 'Adresse 7', 0),
(23, 'Nom 8', 'Prénom 8', '00007', 'Ville 8', 'Pays 8', '0123456796', '0612345685', 'Commande 8', 'Condition 8', 'Coord 8', 'Calendrier 8', 'Détails 8', 'Condition 8', 'Facturation 8', 'Certification 8', 'Produit 8', 'Siuvi 8', 'email8@example.com', 'Groupe 8', 'Adresse 8', 0),
(24, 'Nom 9', 'Prénom 9', '00008', 'Ville 9', 'Pays 9', '0123456797', '0612345686', 'Commande 9', 'Condition 9', 'Coord 9', 'Calendrier 9', 'Détails 9', 'Condition 9', 'Facturation 9', 'Certification 9', 'Produit 9', 'Siuvi 9', 'email9@example.com', 'Groupe 9', 'Adresse 9', 0),
(25, 'Nom 10', 'Prénom 10', '00009', 'Ville 10', 'Pays 10', '0123456798', '0612345687', 'Commande 10', 'Condition 10', 'Coord 10', 'Calendrier 10', 'Détails 10', 'Condition 10', 'Facturation 10', 'Certification 10', 'Produit 10', 'Siuvi 10', 'email10@example.com', 'Groupe 10', 'Adresse 10', 0),
(26, 'Nom 11', 'Prénom 11', '00010', 'Ville 11', 'Pays 11', '0123456799', '0612345688', 'Commande 11', 'Condition 11', 'Coord 11', 'Calendrier 11', 'Détails 11', 'Condition 11', 'Facturation 11', 'Certification 11', 'Produit 11', 'Siuvi 11', 'email11@example.com', 'Groupe 11', 'Adresse 11', 0),
(27, 'Nom 12', 'Prénom 12', '00011', 'Ville 12', 'Pays 12', '0123456700', '0612345689', 'Commande 12', 'Condition 12', 'Coord 12', 'Calendrier 12', 'Détails 12', 'Condition 12', 'Facturation 12', 'Certification 12', 'Produit 12', 'Siuvi 12', 'email12@example.com', 'Groupe 12', 'Adresse 12', 0),
(28, 'Nom 13', 'Prénom 13', '00012', 'Ville 13', 'Pays 13', '0123456701', '0612345690', 'Commande 13', 'Condition 13', 'Coord 13', 'Calendrier 13', 'Détails 13', 'Condition 13', 'Facturation 13', 'Certification 13', 'Produit 13', 'Siuvi 13', 'email13@example.com', 'Groupe 13', 'Adresse 13', 0),
(29, 'Nom 14', 'Prénom 14', '00013', 'Ville 14', 'Pays 14', '0123456702', '0612345691', 'Commande 14', 'Condition 14', 'Coord 14', 'Calendrier 14', 'Détails 14', 'Condition 14', 'Facturation 14', 'Certification 14', 'Produit 14', 'Siuvi 14', 'email14@example.com', 'Groupe 14', 'Adresse 14', 0),
(30, 'Nom 15', 'Prénom 15', '00014', 'Ville 15', 'Pays 15', '0123456703', '0612345692', 'Commande 15', 'Condition 15', 'Coord 15', 'Calendrier 15', 'Détails 15', 'Condition 15', 'Facturation 15', 'Certification 15', 'Produit 15', 'Siuvi 15', 'email15@example.com', 'Groupe 15', 'Adresse 15', 0),
(31, 'Nom 16', 'Prénom 16', '00015', 'Ville 16', 'Pays 16', '0123456704', '0612345693', 'Commande 16', 'Condition 16', 'Coord 16', 'Calendrier 16', 'Détails 16', 'Condition 16', 'Facturation 16', 'Certification 16', 'Produit 16', 'Siuvi 16', 'email16@example.com', 'Groupe 16', 'Adresse 16', 0),
(32, 'Nom 17', 'Prénom 17', '00016', 'Ville 17', 'Pays 17', '0123456705', '0612345694', 'Commande 17', 'Condition 17', 'Coord 17', 'Calendrier 17', 'Détails 17', 'Condition 17', 'Facturation 17', 'Certification 17', 'Produit 17', 'Siuvi 17', 'email17@example.com', 'Groupe 17', 'Adresse 17', 1),
(33, 'Nom 18', 'Prénom 18', '00017', 'Ville 18', 'Pays 18', '0123456706', '0612345695', 'Commande 18', 'Condition 18', 'Coord 18', 'Calendrier 18', 'Détails 18', 'Condition 18', 'Facturation 18', 'Certification 18', 'Produit 18', 'Siuvi 18', 'email18@example.com', 'Groupe 18', 'Adresse 18', 0),
(34, 'Nom 19', 'Prénom 19', '00018', 'Ville 19', 'Pays 19', '0123456707', '0612345696', 'Commande 19', 'Condition 19', 'Coord 19', 'Calendrier 19', 'Détails 19', 'Condition 19', 'Facturation 19', 'Certification 19', 'Produit 19', 'Siuvi 19', 'email19@example.com', 'Groupe 19', 'Adresse 19', 1),
(35, 'Nom 20', 'Prénom 20', '00019', 'Ville 20', 'Pays 20', '0123456708', '0612345697', 'Commande 20', 'Condition 20', 'Coord 20', 'Calendrier 20', 'Détails 20', 'Condition 20', 'Facturation 20', 'Certification 20', 'Produit 20', 'Siuvi 20', 'email20@example.com', 'Groupe 20', 'Adresse 20', 1),
(37, 'Nom 22', 'Prénom 22', '00021', 'Ville 22', 'Pays 22', '0123456710', '0612345699', 'Commande 22', 'Condition 22', 'Coord 22', 'Calendrier 22', 'Détails 22', 'Condition 22', 'Facturation 22', 'Certification 22', 'Produit 22', 'Siuvi 22', 'email22@example.com', 'Groupe 22', 'Adresse 22', 1),
(38, 'Nom 23', 'Prénom 23', '00022', 'Ville 23', 'Pays 23', '0123456711', '0612345700', 'Commande 23', 'Condition 23', 'Coord 23', 'Calendrier 23', 'Détails 23', 'Condition 23', 'Facturation 23', 'Certification 23', 'Produit 23', 'Siuvi 23', 'email23@example.com', 'Groupe 23', 'Adresse 23', 1),
(39, 'Nom 24', 'Prénom 24', '00023', 'Ville 24', 'Pays 24', '0123456712', '0612345701', 'Commande 24', 'Condition 24', 'Coord 24', 'Calendrier 24', 'Détails 24', 'Condition 24', 'Facturation 24', 'Certification 24', 'Produit 24', 'Siuvi 24', 'email24@example.com', 'Groupe 24', 'Adresse 24', 1),
(40, 'Nom 25', 'Prénom 25', '00024', 'Ville 25', 'Pays 25', '0123456713', '0612345702', 'Commande 25', 'Condition 25', 'Coord 25', 'Calendrier 25', 'Détails 25', 'Condition 25', 'Facturation 25', 'Certification 25', 'Produit 25', 'Siuvi 25', 'email25@example.com', 'Groupe 25', 'Adresse 25', 1),
(41, 'Nom 26', 'Prénom 26', '00025', 'Ville 26', 'Pays 26', '0123456714', '0612345703', 'Commande 26', 'Condition 26', 'Coord 26', 'Calendrier 26', 'Détails 26', 'Condition 26', 'Facturation 26', 'Certification 26', 'Produit 26', 'Siuvi 26', 'email26@example.com', 'Groupe 26', 'Adresse 26', 1),
(42, 'Nom 27', 'Prénom 27', '00026', 'Ville 27', 'Pays 27', '0123456715', '0612345704', 'Commande 27', 'Condition 27', 'Coord 27', 'Calendrier 27', 'Détails 27', 'Condition 27', 'Facturation 27', 'Certification 27', 'Produit 27', 'Siuvi 27', 'email27@example.com', 'Groupe 27', 'Adresse 27', 1),
(43, 'Nom 28', 'Prénom 28', '00027', 'Ville 28', 'Pays 28', '0123456716', '0612345705', 'Commande 28', 'Condition 28', 'Coord 28', 'Calendrier 28', 'Détails 28', 'Condition 28', 'Facturation 28', 'Certification 28', 'Produit 28', 'Siuvi 28', 'email28@example.com', 'Groupe 28', 'Adresse 28', 0),
(44, 'Nom 29', 'Prénom 29', '00028', 'Ville 29', 'Pays 29', '0123456717', '0612345706', 'Commande 29', 'Condition 29', 'Coord 29', 'Calendrier 29', 'Détails 29', 'Condition 29', 'Facturation 29', 'Certification 29', 'Produit 29', 'Siuvi 29', 'email29@example.com', 'Groupe 29', 'Adresse 29', 0),
(45, 'Nom 30', 'Prénom 30', '00029', 'Ville 30', 'Pays 30', '0123456718', '0612345707', 'Commande 30', 'Condition 30', 'Coord 30', 'Calendrier 30', 'Détails 30', 'Condition 30', 'Facturation 30', 'Certification 30', 'Produit 30', 'Siuvi 30', 'email30@example.com', 'Groupe 30', 'Adresse 30', 0),
(46, 'Harimech', 'Mouad', '20020', 'berrechid', 'morocco', '0943234354', '0987654', '', '', '', '', '', '', '', '', '', '', 'mouad@gmail.com', '', '', 1),
(47, 'hysdh sdhhj', 'hysdh sdhhj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(48, 'gsfdg sdfhjgh', 'gsfdg sdfhjgh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(49, 'driss adil', 'driss adil', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(50, 'kkk mpoy', 'kkk mpoy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(51, 'med ali', 'med ali', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(52, 'youssef hamroui', 'youssef hamroui', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(53, 'mouade', 'mouade', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(54, 'mouad harimech', 'mouad harimech', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

CREATE TABLE `lots` (
  `lot_id` int(11) NOT NULL,
  `lot_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`lot_id`, `lot_name`) VALUES
(2, 'lot2 222'),
(4, 'Lot D4'),
(5, 'Lot E'),
(6, 'Lot F'),
(7, 'Lot G'),
(8, 'Lot H'),
(9, 'Lot I'),
(10, 'Sous-Lot 1848'),
(26, 're n n'),
(28, 'adassd'),
(29, 'mouad'),
(30, 'mouad 1'),
(31, 'mouad 12'),
(32, 'mouad 233'),
(33, 'new lot'),
(34, 'fruits'),
(35, 'ppp'),
(36, 'h+i14+a2:i13'),
(37, 'lot produits laitirees'),
(38, 'mou'),
(39, 'lot epicerie,conserv et sauce'),
(40, 'lot'),
(41, 'mouad youssef'),
(42, 'a a a'),
(43, 'lot 1'),
(44, '0123');

-- --------------------------------------------------------

--
-- Table structure for table `lot_fournisseurs`
--

CREATE TABLE `lot_fournisseurs` (
  `lot_id` int(11) NOT NULL,
  `id_fournisseur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lot_fournisseurs`
--

INSERT INTO `lot_fournisseurs` (`lot_id`, `id_fournisseur`) VALUES
(2, 1),
(2, 6),
(2, 7),
(2, 11),
(2, 47),
(8, 1),
(34, 5),
(34, 52),
(36, 47),
(37, 48),
(37, 49),
(38, 50),
(39, 51),
(40, 52),
(41, 52),
(41, 54),
(42, 52),
(42, 54),
(44, 50);

-- --------------------------------------------------------

--
-- Table structure for table `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `lot_name` varchar(100) NOT NULL,
  `sous_lot_name` varchar(100) NOT NULL,
  `nom_article` varchar(150) NOT NULL,
  `date_operation` datetime NOT NULL,
  `entree_operation` decimal(10,2) DEFAULT 0.00,
  `sortie_operation` decimal(10,2) DEFAULT 0.00,
  `pj_operation` varchar(255) DEFAULT NULL,
  `nom_pre_fournisseur` varchar(150) DEFAULT NULL,
  `service_operation` varchar(150) DEFAULT NULL,
  `prix_operation` decimal(10,2) DEFAULT NULL,
  `unite_operation` varchar(100) DEFAULT NULL,
  `ref` varchar(250) DEFAULT NULL,
  `depense_entre` int(250) DEFAULT NULL,
  `depense_sortie` int(250) DEFAULT NULL,
  `reclamation` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operation`
--

INSERT INTO `operation` (`id`, `lot_name`, `sous_lot_name`, `nom_article`, `date_operation`, `entree_operation`, `sortie_operation`, `pj_operation`, `nom_pre_fournisseur`, `service_operation`, `prix_operation`, `unite_operation`, `ref`, `depense_entre`, `depense_sortie`, `reclamation`) VALUES
(15, 'lot2 222', '12345', 'Article 45', '2024-10-14 20:03:29', 12.00, 0.00, 'Bon entrée', 'mouad harimech', '', 12.00, 'Unité 45', '12', 144, 0, NULL),
(16, 'lot2 222', '12345', 'Article 52', '2024-10-14 20:03:44', 12.00, 0.00, 'Bon entrée', 'Petit Élise', '', 12.00, 'Unité 52', '12', 144, 0, NULL),
(17, 'lot2 222', '12345', 'Article 55', '2024-10-14 20:03:56', 12.00, 0.00, 'Bon entrée', 'Garnier Marcel', '', 12.00, 'Unité 55', '12', 144, 0, NULL),
(19, 'lot2 222', '12345', 'Article 68', '2024-10-14 20:04:28', 12.00, 0.00, 'Bon entrée', 'hysdh sdhhj hysdh sdhhj', '', 12.00, 'Unité 68', '12', 144, 0, NULL),
(20, 'lot2 222', '12345', 'Article 61', '2024-10-14 20:05:12', 0.00, 2.00, 'Bon sortie', '', '8943', 12.00, 'Unité 61', '', 0, 24, NULL),
(21, 'lot2 222', '12345', 'Article 61', '2024-10-14 20:06:00', 2.00, 0.00, 'Bon entrée', 'Durand Marie', '', 12.00, 'Unité 61', '23', 24, 0, NULL),
(22, 'lot2 222', '12345', 'Article 50', '2024-10-14 20:06:37', 4.00, 0.00, 'Bon entrée', 'mouad harimech', '', 44.00, 'Unité 50', '', 176, 0, 'doit  add  cet linge'),
(24, 'lot2 222', '12345', 'Article 61', '2024-10-14 20:04:00', 12.00, 0.00, 'Bon entrée', 'Durand Marie', '', 12.00, 'Unité 61', '121', 144, 0, NULL),
(25, 'lot2 222', '12345', 'Article 45', '2024-10-18 19:59:31', 0.00, 115.00, 'Bon sortie', '', 'mouad', 12.00, 'Unité 45', '32', 0, 1380, NULL),
(26, 'lot2 222', '12345', 'Article 45', '2024-10-18 20:01:56', 0.00, 1.00, 'Bon sortie', '', 'cuisin 124', 12.00, 'Unité 45', '123', 0, 12, NULL),
(27, 'lot2 222', '12345', 'Article 45', '2024-10-18 20:02:42', 100.00, 0.00, 'Bon entrée', 'mouad harimech', '', 23234.00, 'Unité 45', '', 2323400, 0, NULL),
(28, 'lot2 222', '12345', 'Article 45', '2024-10-18 20:03:24', 0.00, 100.00, 'Bon sortie', '', 'service 5', 23234.00, 'Unité 45', '23434', 0, 2323400, NULL),
(29, 'lot2 222', '12345', 'Article 45', '2024-10-18 20:05:28', 1.00, 0.00, 'Bon entrée', '', '', 3.00, 'Unité 45', '23', 3, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_zone`
--

CREATE TABLE `service_zone` (
  `id` int(11) NOT NULL,
  `service` varchar(150) NOT NULL,
  `zone` varchar(255) DEFAULT NULL,
  `ref` varchar(250) DEFAULT NULL,
  `equip` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_zone`
--

INSERT INTO `service_zone` (`id`, `service`, `zone`, `ref`, `equip`) VALUES
(2, '8943', '2342434', '2343424', '234234'),
(3, 'service 3', 'hhhh', NULL, ''),
(4, 'service 4', 'hhhh', NULL, ''),
(5, 'service 5', 'hhhh', NULL, ''),
(6, 'service 6', 'hhhh', 'asda', 'sd'),
(8, 'mouad', '23', '129', '23'),
(10, 'cuisin 124', '3asdfa', 'cuisine', 'equipe 2 adsfs'),
(23, 'service ', 'hhhh', 'erer', 'ere');

-- --------------------------------------------------------

--
-- Table structure for table `sous_lots`
--

CREATE TABLE `sous_lots` (
  `sous_lot_id` int(11) NOT NULL,
  `lot_id` int(11) NOT NULL,
  `sous_lot_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sous_lots`
--

INSERT INTO `sous_lots` (`sous_lot_id`, `lot_id`, `sous_lot_name`) VALUES
(140, 36, 'hhh'),
(141, 37, 'e'),
(142, 37, 'e7777777'),
(143, 38, 'jjjjjjjj'),
(145, 39, 's/lot conserves'),
(147, 40, 'sous2'),
(149, 40, 'sous4'),
(150, 40, 'sous5'),
(151, 40, 'sous6'),
(153, 40, 'sous8'),
(154, 40, 'sous9'),
(155, 40, 'sous10'),
(156, 40, 'sous11'),
(157, 40, 'sous12'),
(158, 40, 'sous13'),
(159, 40, 'sous14'),
(160, 40, 'sous15'),
(161, 40, 'sous16'),
(162, 40, 'sous17'),
(163, 41, 'sousa'),
(324, 2, '12345'),
(325, 34, 'banane'),
(326, 43, 'SOU toyu'),
(327, 44, '0123'),
(328, 33, 'm,m');

-- --------------------------------------------------------

--
-- Table structure for table `sous_lot_articles`
--

CREATE TABLE `sous_lot_articles` (
  `id` int(11) NOT NULL,
  `sous_lot_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sous_lot_articles`
--

INSERT INTO `sous_lot_articles` (`id`, `sous_lot_id`, `article_id`) VALUES
(3, 126, 1),
(5, 17, 4),
(6, 17, 7),
(7, 18, 2),
(12, 134, 5),
(13, 134, 3),
(14, 134, 9),
(22, 135, 108),
(23, 135, 15),
(24, 135, 13),
(25, 135, 12),
(26, 135, 18),
(27, 135, 23),
(28, 135, 27),
(29, 135, 8),
(30, 135, 11),
(31, 135, 14),
(32, 135, 16),
(33, 135, 17),
(34, 135, 19),
(35, 135, 20),
(36, 135, 25),
(37, 135, 24),
(38, 135, 21),
(39, 135, 22),
(40, 135, 28),
(41, 135, 26),
(42, 135, 29),
(43, 135, 30),
(44, 135, 31),
(45, 135, 32),
(46, 135, 96),
(47, 135, 97),
(48, 129, 100),
(49, 129, 95),
(50, 129, 93),
(51, 129, 38),
(52, 129, 39),
(53, 129, 41),
(54, 129, 37),
(55, 129, 34),
(56, 129, 33),
(57, 129, 42),
(58, 129, 43),
(59, 129, 36),
(60, 129, 46),
(61, 129, 45),
(65, 140, 109),
(66, 141, 110),
(67, 142, 111),
(68, 141, 112),
(69, 143, 113),
(70, 0, 114),
(71, 145, 115),
(72, 145, 116),
(73, 145, 117),
(74, 145, 118),
(75, 145, 119),
(76, 145, 120),
(78, 147, 122),
(80, 149, 124),
(81, 150, 125),
(82, 151, 126),
(84, 153, 128),
(85, 154, 129),
(86, 155, 130),
(87, 156, 131),
(88, 157, 132),
(89, 158, 133),
(90, 159, 134),
(91, 160, 135),
(92, 161, 136),
(93, 162, 137),
(94, 163, 138),
(95, 163, 139),
(96, 163, 140),
(97, 163, 141),
(98, 163, 142),
(99, 163, 143),
(100, 163, 144),
(101, 163, 145),
(102, 163, 146),
(103, 163, 147),
(104, 163, 148),
(105, 163, 149),
(106, 163, 150),
(107, 163, 151),
(108, 163, 152),
(109, 163, 153),
(110, 163, 154),
(111, 163, 155),
(112, 163, 156),
(113, 163, 157),
(114, 163, 158),
(115, 163, 159),
(116, 163, 160),
(117, 163, 161),
(118, 163, 162),
(119, 163, 163),
(120, 163, 164),
(121, 163, 165),
(122, 163, 166),
(123, 163, 167),
(124, 163, 168),
(125, 163, 169),
(126, 163, 170),
(127, 163, 171),
(128, 163, 172),
(129, 163, 173),
(130, 163, 174),
(131, 163, 175),
(132, 163, 176),
(133, 163, 177),
(134, 163, 178),
(135, 163, 179),
(136, 163, 180),
(137, 163, 181),
(138, 163, 182),
(139, 163, 183),
(140, 163, 184),
(141, 163, 185),
(142, 163, 186),
(143, 163, 187),
(144, 163, 188),
(145, 163, 189),
(146, 163, 190),
(147, 163, 191),
(148, 163, 192),
(149, 163, 193),
(150, 163, 194),
(151, 163, 195),
(152, 163, 196),
(153, 163, 197),
(154, 163, 198),
(155, 163, 199),
(156, 163, 200),
(157, 163, 201),
(158, 163, 202),
(159, 163, 203),
(160, 163, 204),
(161, 163, 205),
(162, 163, 206),
(163, 163, 207),
(164, 163, 208),
(165, 163, 209),
(166, 163, 210),
(167, 163, 211),
(168, 163, 212),
(169, 163, 213),
(170, 163, 214),
(171, 163, 215),
(172, 163, 216),
(173, 163, 217),
(174, 163, 218),
(175, 163, 219),
(176, 163, 220),
(177, 163, 221),
(178, 163, 222),
(179, 163, 223),
(180, 163, 224),
(181, 163, 225),
(182, 163, 226),
(183, 163, 227),
(184, 163, 228),
(185, 163, 229),
(186, 163, 230),
(187, 163, 231),
(188, 163, 232),
(189, 163, 233),
(190, 163, 234),
(191, 163, 235),
(192, 163, 236),
(193, 163, 237),
(194, 163, 238),
(195, 163, 239),
(196, 163, 240),
(197, 163, 241),
(198, 163, 242),
(199, 163, 243),
(200, 163, 244),
(201, 163, 245),
(202, 163, 246),
(203, 163, 247),
(204, 163, 248),
(205, 163, 249),
(206, 163, 250),
(207, 163, 251),
(208, 163, 252),
(209, 163, 253),
(210, 163, 254),
(211, 163, 255),
(212, 163, 256),
(213, 163, 257),
(214, 163, 258),
(215, 163, 259),
(216, 163, 260),
(217, 163, 261),
(218, 163, 262),
(219, 163, 263),
(220, 163, 264),
(221, 163, 265),
(222, 163, 266),
(223, 163, 267),
(224, 163, 268),
(225, 163, 269),
(226, 163, 270),
(227, 163, 271),
(228, 163, 272),
(229, 163, 273),
(230, 163, 274),
(231, 163, 275),
(232, 163, 276),
(233, 163, 277),
(234, 163, 278),
(235, 163, 279),
(236, 163, 280),
(237, 163, 281),
(238, 163, 282),
(239, 163, 283),
(240, 163, 284),
(241, 163, 285),
(242, 163, 286),
(243, 163, 287),
(244, 163, 288),
(245, 163, 289),
(246, 163, 290),
(247, 163, 291),
(248, 163, 292),
(249, 163, 293),
(250, 163, 294),
(251, 163, 295),
(252, 0, 138),
(253, 0, 139),
(254, 0, 140),
(255, 0, 141),
(256, 0, 142),
(257, 0, 143),
(258, 0, 144),
(259, 0, 145),
(260, 0, 146),
(261, 0, 147),
(262, 0, 148),
(263, 0, 149),
(264, 0, 150),
(265, 0, 151),
(266, 0, 152),
(267, 0, 153),
(268, 0, 154),
(269, 0, 155),
(270, 0, 156),
(271, 0, 157),
(272, 0, 158),
(273, 0, 159),
(274, 0, 160),
(275, 0, 161),
(276, 0, 162),
(277, 0, 163),
(278, 0, 164),
(279, 0, 165),
(280, 0, 166),
(281, 0, 167),
(282, 0, 168),
(283, 0, 169),
(284, 0, 170),
(285, 0, 171),
(286, 0, 172),
(287, 0, 173),
(288, 0, 174),
(289, 0, 175),
(290, 0, 176),
(291, 0, 177),
(292, 0, 178),
(293, 0, 179),
(294, 0, 180),
(295, 0, 181),
(296, 0, 182),
(297, 0, 183),
(298, 0, 184),
(299, 0, 185),
(300, 0, 186),
(301, 0, 187),
(302, 0, 188),
(303, 0, 189),
(304, 0, 190),
(305, 0, 191),
(306, 0, 192),
(307, 0, 193),
(308, 0, 194),
(309, 0, 195),
(310, 0, 196),
(311, 0, 197),
(312, 0, 198),
(313, 0, 199),
(314, 0, 200),
(315, 0, 201),
(316, 0, 202),
(317, 0, 203),
(318, 0, 204),
(319, 0, 205),
(320, 0, 206),
(321, 0, 207),
(322, 0, 208),
(323, 0, 209),
(324, 0, 210),
(325, 0, 211),
(326, 0, 212),
(327, 0, 213),
(328, 0, 214),
(329, 0, 215),
(330, 0, 216),
(331, 0, 217),
(332, 0, 218),
(333, 0, 219),
(334, 0, 220),
(335, 0, 221),
(336, 0, 222),
(337, 0, 223),
(338, 0, 224),
(339, 0, 225),
(340, 0, 226),
(341, 0, 227),
(342, 0, 228),
(343, 0, 229),
(344, 0, 230),
(345, 0, 231),
(346, 0, 232),
(347, 0, 233),
(348, 0, 234),
(349, 0, 235),
(350, 0, 236),
(351, 0, 237),
(352, 0, 238),
(353, 0, 239),
(354, 0, 240),
(355, 0, 241),
(356, 0, 242),
(357, 0, 243),
(358, 0, 244),
(359, 0, 245),
(360, 0, 246),
(361, 0, 247),
(362, 0, 248),
(363, 0, 249),
(364, 0, 250),
(365, 0, 251),
(366, 0, 252),
(367, 0, 253),
(368, 0, 254),
(369, 0, 255),
(370, 0, 256),
(371, 0, 257),
(372, 0, 258),
(373, 0, 259),
(374, 0, 260),
(375, 0, 261),
(376, 0, 262),
(377, 0, 263),
(378, 0, 264),
(379, 0, 265),
(380, 0, 266),
(381, 0, 267),
(382, 0, 268),
(383, 0, 269),
(384, 0, 270),
(385, 0, 271),
(386, 0, 272),
(387, 0, 273),
(388, 0, 274),
(389, 0, 275),
(390, 0, 276),
(391, 0, 277),
(392, 0, 278),
(393, 0, 279),
(394, 0, 280),
(395, 0, 281),
(396, 0, 282),
(397, 0, 283),
(398, 0, 284),
(399, 0, 285),
(400, 0, 286),
(401, 0, 287),
(402, 0, 288),
(403, 0, 289),
(404, 0, 290),
(405, 0, 291),
(406, 0, 292),
(407, 0, 293),
(408, 0, 294),
(409, 0, 295),
(410, 325, 35),
(411, 325, 47),
(412, 325, 49),
(413, 325, 50),
(414, 325, 10),
(415, 325, 48),
(416, 325, 44),
(417, 325, 40),
(418, 325, 53),
(419, 325, 298),
(420, 324, 52),
(421, 324, 51),
(422, 324, 54),
(423, 324, 56),
(424, 324, 55),
(425, 324, 58),
(426, 324, 59),
(427, 324, 60),
(428, 324, 61),
(429, 324, 62),
(430, 324, 64),
(431, 324, 67),
(432, 324, 66),
(433, 324, 68),
(434, 324, 65),
(435, 324, 63),
(436, 324, 57),
(437, 324, 71),
(438, 324, 76),
(439, 324, 81),
(440, 324, 79),
(441, 324, 82),
(442, 324, 75),
(443, 324, 73),
(444, 324, 80),
(445, 324, 77),
(446, 324, 74),
(447, 324, 78),
(448, 324, 69),
(449, 324, 83),
(450, 324, 89),
(451, 324, 103),
(452, 324, 102),
(453, 324, 90),
(454, 324, 94),
(455, 324, 87),
(456, 324, 86),
(457, 324, 85),
(458, 324, 84),
(459, 324, 72),
(460, 324, 70),
(461, 324, 88),
(463, 324, 99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `password` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`) VALUES
(1, 'admin', '123'),
(2, 'user', '123');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vue_articles_fournisseurs`
-- (See below for the actual view)
--
CREATE TABLE `vue_articles_fournisseurs` (
`lot` varchar(255)
,`souslot` varchar(255)
,`fournisseur` varchar(250)
,`article` varchar(250)
,`description` text
,`unité` varchar(100)
,`stockmin` float
,`stockinitial` float
,`prix` float
);

-- --------------------------------------------------------

--
-- Structure for view `vue_articles_fournisseurs`
--
DROP TABLE IF EXISTS `vue_articles_fournisseurs`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vue_articles_fournisseurs`  AS SELECT `l`.`lot_name` AS `lot`, `sl`.`sous_lot_name` AS `souslot`, `f`.`nom_fournisseur` AS `fournisseur`, `a`.`nom` AS `article`, `a`.`description` AS `description`, `a`.`unite` AS `unité`, `a`.`stock_min` AS `stockmin`, `a`.`stock_initial` AS `stockinitial`, `a`.`prix` AS `prix` FROM (((((`article` `a` join `sous_lot_articles` `sla` on(`a`.`id_article` = `sla`.`article_id`)) join `sous_lots` `sl` on(`sla`.`sous_lot_id` = `sl`.`sous_lot_id`)) join `lots` `l` on(`sl`.`lot_id` = `l`.`lot_id`)) join `lot_fournisseurs` `lf` on(`l`.`lot_id` = `lf`.`lot_id`)) join `fournisseurs` `f` on(`lf`.`id_fournisseur` = `f`.`id_fournisseur`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Indexes for table `filtered_data`
--
ALTER TABLE `filtered_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id_fournisseur`);

--
-- Indexes for table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`lot_id`);

--
-- Indexes for table `lot_fournisseurs`
--
ALTER TABLE `lot_fournisseurs`
  ADD PRIMARY KEY (`lot_id`,`id_fournisseur`),
  ADD KEY `id_fournisseur` (`id_fournisseur`);

--
-- Indexes for table `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_zone`
--
ALTER TABLE `service_zone`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service` (`service`);

--
-- Indexes for table `sous_lots`
--
ALTER TABLE `sous_lots`
  ADD PRIMARY KEY (`sous_lot_id`),
  ADD UNIQUE KEY `sous_lot_name` (`sous_lot_name`),
  ADD KEY `lot_id` (`lot_id`);

--
-- Indexes for table `sous_lot_articles`
--
ALTER TABLE `sous_lot_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sous_lot_id` (`sous_lot_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT for table `filtered_data`
--
ALTER TABLE `filtered_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id_fournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `lot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `service_zone`
--
ALTER TABLE `service_zone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sous_lots`
--
ALTER TABLE `sous_lots`
  MODIFY `sous_lot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT for table `sous_lot_articles`
--
ALTER TABLE `sous_lot_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=464;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lot_fournisseurs`
--
ALTER TABLE `lot_fournisseurs`
  ADD CONSTRAINT `lot_fournisseurs_ibfk_1` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`lot_id`),
  ADD CONSTRAINT `lot_fournisseurs_ibfk_2` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseurs` (`id_fournisseur`);

--
-- Constraints for table `sous_lots`
--
ALTER TABLE `sous_lots`
  ADD CONSTRAINT `sous_lots_ibfk_1` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`lot_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
