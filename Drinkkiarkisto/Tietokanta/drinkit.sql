-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05.02.2021 klo 16:17
-- Palvelimen versio: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drinkit`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `ainesosat`
--

CREATE TABLE `ainesosat` (
  `id` int(11) NOT NULL,
  `ainesosa` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `ainesosat`
--

INSERT INTO `ainesosat` (`id`, `ainesosa`) VALUES
(35, 'Vesi'),
(36, 'Vodka'),
(37, 'Viski'),
(38, 'Lonkero'),
(39, 'Jagermaister'),
(40, 'Hunajaolut'),
(41, 'Savuolut'),
(42, 'Jääpaloja'),
(43, 'Kahvi'),
(44, 'Tomaattimehu'),
(45, 'Sitruunamehu'),
(46, 'Tabasco'),
(47, 'Worcesterkastike'),
(48, 'Suola'),
(49, 'Mustapippuri'),
(50, 'Selleri'),
(51, 'Battery'),
(52, 'Mintunlehti'),
(53, 'Ruokosokeri'),
(54, 'Lime'),
(55, 'Vaalea rommi'),
(56, 'Soodavesi'),
(57, 'Salmiakkiviina'),
(58, 'Minttuviina'),
(59, 'Absintti'),
(60, 'Energiajuoma'),
(61, 'Sininen curacaoliköö'),
(62, 'Tequila'),
(63, 'iojiojcsdpo'),
(64, 'Absitti');

-- --------------------------------------------------------

--
-- Rakenne taululle `juomat`
--

CREATE TABLE `juomat` (
  `id` int(11) NOT NULL,
  `nimi` varchar(50) DEFAULT NULL,
  `kuvaus` text DEFAULT NULL,
  `juomalaji` varchar(30) DEFAULT NULL,
  `ohje` text DEFAULT NULL,
  `lisatty` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `juomat`
--

INSERT INTO `juomat` (`id`, `nimi`, `kuvaus`, `juomalaji`, `ohje`, `lisatty`) VALUES
(23, 'jekkuzufee', NULL, 'drinkki', 'sekoita ensin ja nauti, tai toisinpäin ', 1),
(24, 'Bloody Mary', NULL, 'Drinkki', 'Sekoita ensin, siivilöi jääpalan päälle ja koristele sellerinvarrella.	', 1),
(25, 'Jekkubattery', NULL, 'Drinkit', 'Sekoita jollain	', 1),
(26, 'Mojito', NULL, 'Drinkit', ' Sekoita	', 1),
(27, 'Minttusalmari', NULL, 'Shotti', 'Sekoita', 1),
(28, 'Absinttipommi', NULL, 'Shotti', 'Sekoita', 1),
(29, 'Blue Ice', NULL, 'Shotti', 'Sekoita	', 0),
(30, 'Minttuvodka', NULL, 'Shotti', 'Sekoita	', 1),
(31, 'Bull', NULL, 'Shot', '	', 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `j_ainekset`
--

CREATE TABLE `j_ainekset` (
  `ID` int(11) NOT NULL,
  `juomaID` int(11) DEFAULT NULL,
  `ainesosa` int(11) DEFAULT NULL,
  `maara` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `j_ainekset`
--

INSERT INTO `j_ainekset` (`ID`, `juomaID`, `ainesosa`, `maara`) VALUES
(79, 23, 39, '4cl'),
(80, 23, 43, '1dl'),
(81, 23, 42, '5kpl'),
(82, 24, 36, '4 cl'),
(83, 24, 44, '8 cl'),
(84, 24, 46, '2 tippaa'),
(85, 25, 39, '4 cl'),
(86, 25, 51, 'tölkki'),
(87, 25, 42, 'Kolme'),
(88, 26, 54, '1 kpl'),
(89, 26, 55, '4 cl'),
(90, 26, 56, '6 cl'),
(91, 27, 58, '2 cl'),
(92, 27, 57, '2 cl'),
(93, 28, 59, '2 cl'),
(94, 28, 60, '2 cl'),
(95, 29, 61, '1 cl'),
(96, 29, 62, '2 cl'),
(97, 29, 58, '1 cl'),
(98, 30, 58, '2 cl'),
(99, 30, 36, '2 cl'),
(109, 31, 35, '1'),
(110, 31, 36, '11');

-- --------------------------------------------------------

--
-- Rakenne taululle `kayttajat`
--

CREATE TABLE `kayttajat` (
  `tunnus` varchar(30) NOT NULL,
  `salasana` varchar(255) DEFAULT NULL,
  `sahkoposti` varchar(50) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vedos taulusta `kayttajat`
--

INSERT INTO `kayttajat` (`tunnus`, `salasana`, `sahkoposti`, `admin`) VALUES
('admin', 'admin', 'drinkkiarkisto@email.com', 1),
('pekka', 'pege', 'pege', 0),
('tavallinen', 'tavallinen', 'tavallinen@email.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ainesosat`
--
ALTER TABLE `ainesosat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `juomat`
--
ALTER TABLE `juomat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `j_ainekset`
--
ALTER TABLE `j_ainekset`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `juomaID` (`juomaID`),
  ADD KEY `ainesosa` (`ainesosa`);

--
-- Indexes for table `kayttajat`
--
ALTER TABLE `kayttajat`
  ADD PRIMARY KEY (`tunnus`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ainesosat`
--
ALTER TABLE `ainesosat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `juomat`
--
ALTER TABLE `juomat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `j_ainekset`
--
ALTER TABLE `j_ainekset`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `j_ainekset`
--
ALTER TABLE `j_ainekset`
  ADD CONSTRAINT `j_ainekset_ibfk_1` FOREIGN KEY (`juomaID`) REFERENCES `juomat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `j_ainekset_ibfk_2` FOREIGN KEY (`ainesosa`) REFERENCES `ainesosat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
