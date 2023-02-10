-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creation Time and Date: 25. Sep 2021 um 17:33
-- Server-Version: 10.4.19-MariaDB
-- PHP-Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- database: `diystore`
--

-- --------------------------------------------------------

--
-- table structure for table `benutzer`
--

CREATE TABLE `benutzer` (
  `userID` int(11) NOT NULL,
  `userName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userRole` int(11) NOT NULL DEFAULT 1,
  `userPassword` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- data for table `benutzer`
--

INSERT INTO `benutzer` (`userID`, `userName`, `userEmail`, `userRole`, `userPassword`) VALUES
(1, 'Alfred', 'aa@aa.aa', 2, 'aaa'),
(2, 'Berta', 'bb@bb.bb', 2, ''),
(3, 'Chris', 'cc@cc.cc', 1, ''),
(4, 'Dora', 'dd@dd.dd', 1, ''),
(5, 'Andi', 'andi@aa.aa', 1, '$2y$12$7lSGjrA9gUc/NrFJYroBo.AKvKrviO2MqiYE6N/PVw.EmwsbhTW3m'),
(6, 'Test', 'test@test.at', 1, '$2y$12$FvMud031IAoBPpZMsFX6JuHiul7z8BhxFVL8iFT5Lo5saomieS8zu');

-- --------------------------------------------------------

--
-- table structure for table `bestellung`
--

CREATE TABLE `bestellung` (
  `bestell_nr` int(6) NOT NULL,
  `bestell_date` date DEFAULT NULL,
  `versandkosten` decimal(9,2) NOT NULL,
  `um_steuer` decimal(9,2) NOT NULL,
  `status_auftrag` enum('ja','nein') COLLATE latin1_german1_ci NOT NULL,
  `vers_name` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `vers_strasse` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `vers_postl` char(10) COLLATE latin1_german1_ci NOT NULL,
  `vers_ort` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `sta` char(2) COLLATE latin1_german1_ci NOT NULL,
  `email` char(50) COLLATE latin1_german1_ci NOT NULL,
  `telefon` char(20) COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- data for table `bestellung`
--

INSERT INTO `bestellung` (`bestell_nr`, `bestell_date`, `versandkosten`, `um_steuer`, `status_auftrag`, `vers_name`, `vers_strasse`, `vers_postl`, `vers_ort`, `sta`, `email`, `telefon`) VALUES
(0, '2021-09-25', '0.00', '0.00', 'ja', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- table structure for table `bestell_auftrag`
--

CREATE TABLE `bestell_auftrag` (
  `bestell_nr` int(6) NOT NULL,
  `pos_nr` int(4) NOT NULL,
  `katalog_nr` int(8) NOT NULL,
  `menge` decimal(7,2) NOT NULL,
  `preis` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- table structure for table `katalog`
--

CREATE TABLE `katalog` (
  `katalog_nr` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `fabrikat` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `best_nr` int(9) NOT NULL,
  `preis` decimal(7,2) NOT NULL,
  `pr_beschr` varchar(200) COLLATE latin1_german1_ci NOT NULL,
  `kateins` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `katzwei` varchar(30) COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- data for table `katalog`
--

INSERT INTO `katalog` (`katalog_nr`, `name`, `fabrikat`, `best_nr`, `preis`, `pr_beschr`, `kateins`, `katzwei`) VALUES
(1, 'Gartenstuhl', 'Kettler', 3455556, '209.00', 'Aufklappbarer Gartenstuhl', 'Garten', 'Gartenmoebel'),
(2, 'Gartentisch', 'MWH', 445897, '499.00', 'Stelltisch fuer den Garten', 'Garten', 'Gartenmoebel'),
(3, 'Gartenrechen', 'Maurer', 337561, '22.00', 'Multifunktions Rechen', 'Garten', 'Gartengeräte'),
(4, 'Schaufel', 'Inso', 127834, '15.00', 'HOEKEL Schaufel', 'Garten', 'Gartengeräte'),
(5, 'Duschbecken', 'Krisall', 679124, '478.89', 'Duschbecken spezial fuer Kinder', 'Sanitär', 'Badausbau'),
(6, 'Brause', 'Wellness', 765467, '78.99', 'MIELE Brause fuer Stemp', 'Sanitär', 'Badausbau'),
(7, 'Toilettenschüssel', 'Krana', 235886, '123.00', 'Keramikschuessel und goldener Rand', 'Sanitär', 'Toilettenausbau'),
(8, 'Wasserhahn', 'Miller', 349789, '56.00', 'Hahn mit Wasser aus Edelstahl', 'Sanitär', 'Toilettenausbau');

--
-- indices for exported tables
--

--
-- indices for tables `bestellung`
--
ALTER TABLE `bestellung`
  ADD PRIMARY KEY (`bestell_nr`);

--
-- indices for tables `bestell_auftrag`
--
ALTER TABLE `bestell_auftrag`
  ADD PRIMARY KEY (`bestell_nr`);

--
-- indices for tables `katalog`
--
ALTER TABLE `katalog`
  ADD PRIMARY KEY (`katalog_nr`);

--
-- AUTO_INCREMENT for exported tables
--

--
-- AUTO_INCREMENT for tables `katalog`
--
ALTER TABLE `katalog`
  MODIFY `katalog_nr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
