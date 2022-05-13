-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 13, 2022 at 07:48 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ho93_reva`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `submit_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_datetime` datetime NOT NULL,
  `to_datetime` datetime NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinytext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `submit_datetime`, `from_datetime`, `to_datetime`, `reason`, `status`) VALUES
(4, 14, '2022-05-13 20:04:30', '2022-05-11 00:00:00', '2022-05-24 00:00:00', 'efasasdf', 'pending'),
(5, 14, '2022-05-13 20:05:04', '2022-05-24 00:00:00', '2022-05-31 00:00:00', 'dasadsf', 'pending'),
(6, 14, '2022-05-13 20:06:05', '2022-05-06 00:00:00', '2022-10-28 00:00:00', 'dfsdfa', 'rejected'),
(7, 1, '2022-05-13 20:16:15', '2022-05-26 00:00:00', '2022-05-24 00:00:00', 'sfgsgfd', 'pending'),
(8, 14, '2022-05-13 20:18:55', '2022-05-11 00:00:00', '2022-05-15 00:00:00', 'fdsf', 'pending'),
(31, 1, '2022-05-13 21:32:27', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(32, 1, '2022-05-13 21:32:38', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(33, 1, '2022-05-13 21:36:55', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(34, 1, '2022-05-13 21:39:09', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(35, 1, '2022-05-13 21:41:08', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(36, 1, '2022-05-13 21:41:30', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(37, 1, '2022-05-13 21:42:19', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(38, 1, '2022-05-13 21:42:31', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(39, 1, '2022-05-13 21:42:47', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(40, 1, '2022-05-13 21:43:35', '2022-05-19 00:00:00', '2022-05-17 00:00:00', 'fagsdf', 'pending'),
(41, 1, '2022-05-13 21:43:45', '2022-05-21 00:00:00', '2022-05-10 00:00:00', '', 'pending'),
(42, 1, '2022-05-13 21:45:28', '2022-05-19 00:00:00', '2022-05-25 00:00:00', '', 'approved'),
(43, 1, '2022-05-13 21:48:36', '2022-05-20 00:00:00', '2022-05-16 00:00:00', 'fdas', 'pending'),
(44, 1, '2022-05-13 21:54:58', '2022-05-26 00:00:00', '2022-05-30 00:00:00', 'dsfsdss a s', 'approved'),
(45, 14, '2022-05-13 22:08:16', '2022-05-20 00:00:00', '2022-05-24 00:00:00', 'Lorem ipsum dolor sit amet', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `token_auth`
--

CREATE TABLE `token_auth` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_expired` int(11) NOT NULL DEFAULT '0',
  `expiry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `token_auth`
--

INSERT INTO `token_auth` (`id`, `user_email`, `password_hash`, `selector_hash`, `is_expired`, `expiry_date`) VALUES
(23, 'spiroszermalias@gmail.com', '$2y$10$m8AjnByUcyoVJWlTgDFPFeBeMKqRdMJVLLBjHBOWDE4RKZ3OUZLv.', '$2y$10$5oRiygNypQJ1V3W6UGwLROzo1wL0rvBwuN7aQDtPo88NV6vBMi0ge', 1, '2022-05-13 07:23:04'),
(24, 'spiroszermalias@gmail.com', '$2y$10$ULkRyx5Sjb488zUpFDyk1urmOfkswNN/HzNXdOnlN.HZW.WgXvUpS', '$2y$10$H3KCy8//ghx5L1rC7OVeKuSGbfDQg3fuOCCBXASY5x.Ycxtam5z0G', 1, '2022-05-13 09:26:22'),
(25, 'spiroszermalias@gmail.com', '$2y$10$J1w1EGrO8RDtB.s2doWMu.hmijdx3dY94UtZeFUMc71zDmzgSuOQi', '$2y$10$hvDv.sniNCLFNHjGZJbBpemfEoytBVUvEFTMHeoLR6iCa2H3kepXy', 1, '2022-05-13 09:41:15'),
(26, 'luk.black@somewhere.gr', '$2y$10$Rm786UtUFQDc9eP07RvrIuiu2HWtROmKYQWk3ZEqcF9vDl8.HHfw6', '$2y$10$xM2SBw5EnhD32SECSjey8Ov7g67SxELbXYCU5GwaRWJFz5ie6lnfO', 1, '2022-05-13 09:45:10'),
(27, 'spiroszermalias@gmail.com', '$2y$10$Xb7/B5lho2GxjYwYJpym0uLyTvxLdRe4aA5ly7J9T.aW/ADpIPyGu', '$2y$10$X7YLZ29GsOA9NQYLh/0TbOw7BW480efLo.oupSKR0q18nfcPQjtD6', 1, '2022-05-13 09:41:25'),
(28, 'spiroszermalias@gmail.com', '$2y$10$cWythVgytuDfSnOA.NqcrOD7k9b9ER08WkvfwCZkQId3QlT.eszUq', '$2y$10$VyC8fLsLHDnbKt.vyhiVrOuduTvC.nCVaLkNKpFZMhNRWdr7EmI3O', 1, '2022-05-13 09:42:37'),
(29, 'spiroszermalias@gmail.com', '$2y$10$SHyUEHPTiLmj/BaQlejoqOr8MXh04Uyv/4O0MNNYgvre/6ObYpAx.', '$2y$10$w7qzu1jpMEBIAHI3pMaHK.tNPVH59JADoO8qf5rD7stIn63SkNa3.', 1, '2022-05-13 09:42:46'),
(30, 'spiroszermalias@gmail.com', '$2y$10$Ns/92jMy2eW.nR2kXfpwVOsoGwE76nzwQKpTGscFSpKAcHYCay5/K', '$2y$10$3lyXz/ZBAB8VHa3eLtU3rOz1kYu7GwElrDAZ40ZuLjvgHgABNS19i', 1, '2022-05-13 09:43:13'),
(31, 'spiroszermalias@gmail.com', '$2y$10$9BVvtu6lUR0HJdvFjwrAVugIHqRYGhMA6UeFLWHwEe6qQPrgAOIYm', '$2y$10$FINr2zHCAbd0cCKNABi4GO6/UIElXQl/sOk0URbZlX6iUmZi00i1W', 1, '2022-05-13 09:44:23'),
(32, 'spiroszermalias@gmail.com', '$2y$10$JfEwSD9Dm6HKYCib1Ah2q.xZUbTxbVn/LQiYmHtAi/PnYR5/5NRKy', '$2y$10$4uZUjdBvmXxfrwucfvasyea.NnAAGJ3fwQW7V9NclVig94whGKyta', 1, '2022-05-13 09:47:03'),
(33, 'luk.black@somewhere.gr', '$2y$10$l4FsM1FA.uGvVHz6CwolpO06l7pxpaNUrmJaQD5N.CdjWo0KSbmEq', '$2y$10$xgi2OuQRqBVuGk/4bd5KBe1LERDBEsRyUYMUytr2ZLWbgdMnO5Azu', 1, '2022-05-13 10:40:56'),
(34, 'spiroszermalias@gmail.com', '$2y$10$jsiL2pa89Vu3xN31bV6NKen4O6ZQl1r0fGMI0QxxOnrFzuFEpTpAq', '$2y$10$yf45d/gDnErMV8duCotbSOMsGowNVYHcxAJG/OEnmrmalRBTnoAp.', 0, '2022-06-12 09:47:13'),
(35, 'maya@somewhere.eu', '$2y$10$dKsobAJwkifRzz5fLKPg1OQIsTwXqW1gvQRtrhM7Hxq862FIQbsr2', '$2y$10$WGW2EyUIxBIiBRWDqbENseuXvCaSR.xs4qBtO61ScdKfbIuLzF.qS', 0, '2022-06-12 13:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` tinytext COLLATE utf8mb4_unicode_ci,
  `last_name` tinytext COLLATE utf8mb4_unicode_ci,
  `role` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `first_name`, `last_name`, `role`, `user_pass`) VALUES
(1, 'spiroszermalias@gmail.com', 'Σπύρος', 'Ζερμαλιάς', 'admin', '$2y$10$2EjR4D8hOeR2SC/2ew8GM.rYn6ppmEiJ6Pg8FaPMw6.fEo0o6EdA6'),
(12, 'johndoe@somewhere.gr', 'Joe', 'Doe', 'employee', '$2y$10$Fq5WSargZlOYnCrahEvzXeJsuxUhiwWY5HlmETS8qcwSy0Z.7St6i'),
(13, 'luk.black@somewhere.gr', 'Luke', 'Skywalker', 'admin', '$2y$10$/CTBnPNJ4jtG73km3dQ1q.BxxAlrq1WpuxR6UiMF/XSE9FrkpKNR2'),
(14, 'maya@somewhere.eu', 'Maya', 'Angelou', 'employee', '$2y$10$BEaDOpUQm4QTo1gBxnk1auy8mSiqc.E4XJPeRyPwnwuBKs5aqmM7W');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `token_auth`
--
ALTER TABLE `token_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `token_auth`
--
ALTER TABLE `token_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
