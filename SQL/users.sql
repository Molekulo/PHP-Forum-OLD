-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2017 at 11:32 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comm_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `comment_text` text COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comm_id`, `news_id`, `comment_text`, `username`) VALUES
(1, 3, 'Ovo je komentar za prvi tekst', 'admin'),
(2, 4, 'Ovo je komentar za drugi tekst', 'admin'),
(3, 3, 'I ovo je komentar za PRVI tekst', 'admin'),
(4, 4, 'I ovo je komentar za DRUGI tekst', 'admin'),
(5, 6, 'ovo je komentar u kat putovanja', 'admin'),
(7, 4, 'Komentar je ostavio korisnik moleculo', 'moleculo'),
(8, 4, 'Komentar na stranici sport', 'mrgud'),
(9, 5, 'Komentar u kategoriji kultura', 'admin'),
(12, 3, 'komentar za prvi tekst u kateg vesti', 'Milos'),
(14, 3, 'komentar test test test', 'moleculo');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_text` text COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `user_id`, `news_text`, `category`) VALUES
(3, 1, 'Ovo je prvi tekst na stranici u kategoriji Vesti', 'Vesti'),
(5, 13, 'Ovo je tekst u kategoriji Kultura', 'Kultura'),
(6, 13, 'Ovo je tekst u kategoriji Putovanja', 'Putovanja'),
(8, 13, 'sportske vesti', 'Sport');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `password` char(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `admin`, `password`) VALUES
(1, 'moleculo', 'mvidanovic@gmail.com', 0, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(4, 'micko', 'mvaaidanovic@gmail.com', 0, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(9, 'brat', 'misda@gfg.vi', 0, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(10, 'mile', 'asdasd@gsad.sasd', 0, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(13, 'admin', 'admin@mail.com', 1, 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(14, '8464466', 'adminasd@sadas.ad', 0, '011c945f30ce2cbafc452f39840f025693339c42'),
(15, 'mrgud', 'mrgud@mail.com', 0, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(16, 'Milos', 'milos@gmial.com', 0, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(17, 'Prase', 'prase.ja@gmail.com', 0, '3cacfd9c7fb9cb4cb9e97f95107e5e56bf020c5d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comm_id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
