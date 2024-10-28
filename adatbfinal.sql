-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2022 at 09:01 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adatbproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `nev` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szekhely` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`nev`, `szekhely`) VALUES
('JóTP', 'Hajdú-Bihar megye, Debrecen, Dab körút 18.'),
('K&H', 'Pest megye, Budapest xyz út 106.'),
('OTP', 'Csongrád megye, Szeged asd utca 20.'),
('Ráfázen', 'Győr-Moson-Sopron megye, Győr, egyetem utca 76.'),
('Raiffeisen', 'Pest megye, Budapest xyz út 100.');

-- --------------------------------------------------------

--
-- Table structure for table `bankfiok`
--

CREATE TABLE `bankfiok` (
  `bfiokszam` int(11) NOT NULL,
  `nev` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `cim` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `bankfiok`
--

INSERT INTO `bankfiok` (`bfiokszam`, `nev`, `cim`) VALUES
(1, 'K&H', 'Győr-Moson-Sopron megye, Győr selyem út 10.'),
(2, 'OTP', 'Vas megye, Szombathely zala utca 89'),
(3, 'Raiffeisen', 'Pest megye, Érd Érdekes körút 16.'),
(4, 'OTP', 'Csongrád megye, Szeged, Aradi tér 16.'),
(5, 'JóTP', 'Csongrád megye, Szeged, Széchenyi tér 30.'),
(6, 'Ráfázen', 'Somogy megye, Kaposvár, Zita árok 13. 73. emelet'),
(7, 'Ráfázen', 'Győr-Moson-Sopron megye, Győr, Mirella lejtő 90. 34. ajtó');

-- --------------------------------------------------------

--
-- Table structure for table `bankszamla`
--

CREATE TABLE `bankszamla` (
  `szamlaszam` int(11) NOT NULL,
  `banknev` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `tipus` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `egyenleg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `bankszamla`
--

INSERT INTO `bankszamla` (`szamlaszam`, `banknev`, `tipus`, `egyenleg`) VALUES
(10001, 'JóTP', 'Folyószámla', 15000),
(10002, 'Raiffeisen', 'Folyószámla', 10000),
(10003, 'K&H', 'Folyószámla', 0),
(10004, 'OTP', 'Folyószámla', 75000),
(10005, 'Raiffeisen', 'Folyószámla', 15000),
(10006, 'K&H', 'Folyószámla', 0),
(10007, 'Raiffeisen', 'Folyószámla', 5000),
(10008, 'Raiffeisen', 'Folyószámla', 0),
(10009, 'K&H', 'Megtakarítási számla', 45000),
(10010, 'OTP', 'Megtakarítási számla', 15000),
(10011, 'Raiffeisen', 'Megtakarítási számla', 0),
(10012, 'K&H', 'Megtakarítási számla', 100000),
(10013, 'OTP', 'Megtakarítási számla', 85000),
(10014, 'JóTP', 'Hitelszámla', 1000000),
(10015, 'Ráfázen', 'Hitelszámla', 1000000),
(10016, 'Ráfázen', 'Hitelszámla', 600000),
(10017, 'JóTP', 'Megtakarítási számla', 54000),
(10018, 'Ráfázen', 'Folyószámla', 100000),
(10019, 'K&H', 'Megtakarítási számla', 500000),
(10020, 'OTP', 'Hitelszámla', 750000),
(10021, 'OTP', 'Folyószámla', 10000),
(10022, 'Ráfázen', 'Hitelszámla', 290000),
(10023, 'Raiffeisen', 'Folyószámla', 70000);

-- --------------------------------------------------------

--
-- Table structure for table `jogiszemely`
--

CREATE TABLE `jogiszemely` (
  `ugyfelid` int(11) NOT NULL,
  `cegnev` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `adoszam` varchar(10) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `szekhely` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `jogiszemely`
--

INSERT INTO `jogiszemely` (`ugyfelid`, `cegnev`, `adoszam`, `szekhely`) VALUES
(1, NULL, NULL, NULL),
(2, NULL, NULL, NULL),
(3, NULL, NULL, NULL),
(4, NULL, NULL, NULL),
(5, NULL, NULL, NULL),
(6, NULL, NULL, NULL),
(7, NULL, NULL, NULL),
(8, NULL, NULL, NULL),
(9, NULL, NULL, NULL),
(10, NULL, NULL, NULL),
(11, 'Soós BT', '11AEAF1234', 'Pest megye, Budapest, Pintér sor 8.'),
(12, 'Németh NyRT', '45HZLI9574', 'Jász-Nagykun-Szolnok megye, Szolnok, Henrietta lejáró 153.'),
(13, 'Bakos Kht', '45KHSZ7894', 'Csongrád megyek, Hódmezővásárhely, Török lejáró 23.'),
(14, 'Pál Kht', '95PGHN4567', 'Pest megye, Budapest, Vass dűlősor 931. 19. ajtó'),
(15, 'OroszGép', '91AEWQ5371', 'Pest megye, Budapest, Szűcs körtér 96.'),
(16, 'Gulyás Kft', '56FBHD5612', 'Pest megye, Budapest, Lukács sugárút 095. 19. ajtó'),
(17, 'Dobos', '67FVSD8735', 'Szabolcs-Szatmár-Bereg, Csenger, Kevin híd 50. 85. emelet'),
(18, 'Kocsis BT', '29MWKI6234', 'Veszprém megye, Devecser, Király körút 96. 57. ajtó'),
(19, 'Tamás BT', '88ASDC8765', 'Szabolcs-Szatmár-Bereg megye, Nagykálló, Sára határsor 7. 24. ajtó'),
(20, 'Orbán Kft', '98KLTI01', 'Pest megye, Szob, Ernő üdülőpart 233. 40. emelet'),
(21, NULL, NULL, NULL),
(22, NULL, NULL, NULL),
(23, 'Ceg-BT', '0123ceg', 'Fejér megye, Dunaújváros, Sára turista út 3.'),
(24, NULL, NULL, NULL),
(25, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maganszemely`
--

CREATE TABLE `maganszemely` (
  `ugyfelid` int(11) NOT NULL,
  `szemelyiszam` varchar(6) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `lakcim` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `vezeteknev` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `keresztnev` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `maganszemely`
--

INSERT INTO `maganszemely` (`ugyfelid`, `szemelyiszam`, `lakcim`, `vezeteknev`, `keresztnev`) VALUES
(1, 'A456EE', 'Pest megye, Budapest, Barna határsor 42. 85. emelet', 'Kozma', 'Bendegúz'),
(2, 'A9856B', 'Nógrád megye, Salgótarján, Tóth határút 629.', 'Török', 'Benedek'),
(3, 'L9532A', 'Borsod-Abaúj-Zemplén megye, Miskolc, Fodor part 485. 41. ajtó', 'Fábián', 'Vilmos'),
(4, 'A0123E', 'Nógrád megye, Salgótarján, Tóth határút 629.', 'Orosz', 'István'),
(5, 'I5430A', 'Pest megye, Érd, Andrea út 65.', 'Dudás', 'Johanna'),
(6, 'M5141A', 'Pest megye, Budapest, Patrícia út 432.', 'Vincze', 'Katalin'),
(7, '1234EE', 'Pest megye, Budapest, Zita körönd 773. 93. ajtó', 'Sipos ', 'Ádám '),
(8, 'N6321O', 'Tolna megye, Szekszárd, Szervác híd 564. 90. emelet', 'Vörös', 'Katinka'),
(9, 'B8923K', 'Pest megye, Budapest, Rebeka gát 89.', 'Simon', 'Dorina'),
(10, 'P4916M', 'Borsod-Abaúj-Zemplén megye, Miskolc, Papp sétány 40.', 'Pásztor', 'Beatrix'),
(11, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, NULL),
(15, NULL, NULL, NULL, NULL),
(16, NULL, NULL, NULL, NULL),
(17, NULL, NULL, NULL, NULL),
(18, NULL, NULL, NULL, NULL),
(19, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, NULL),
(21, 'admin', 'admin', 'admin', 'admin'),
(22, '5148ME', 'Békés megye, Gyomaendrőd, Fő út 206.', 'Vincze', 'Levente'),
(23, NULL, NULL, NULL, NULL),
(24, 'asd', 'asd', 'asd', 'asd'),
(25, 'szia', 'szia', 'szia', 'szia');

-- --------------------------------------------------------

--
-- Table structure for table `penzforgalom`
--

CREATE TABLE `penzforgalom` (
  `azonosito` int(11) NOT NULL,
  `tipus` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `megbizottnev` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `megbizottszamlaszam` int(11) DEFAULT NULL,
  `kozlemeny` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `helyszin` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `megbizoszamlaszam` int(11) NOT NULL,
  `osszeg` int(11) NOT NULL,
  `datum` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `penzforgalom`
--

INSERT INTO `penzforgalom` (`azonosito`, `tipus`, `megbizottnev`, `megbizottszamlaszam`, `kozlemeny`, `helyszin`, `megbizoszamlaszam`, `osszeg`, `datum`) VALUES
(59, 'Bankszámla nyitás', NULL, NULL, NULL, 'Vas megye, Szombathely zala utca 89', 10021, 10000, '2022-11-21 22:05:27'),
(68, 'Bankszámla nyitás', NULL, NULL, NULL, 'Csongrád megye, Szeged, Széchenyi tér 30.', 10001, 15000, '2022-11-22 11:45:24'),
(70, 'Bankszámla nyitás', NULL, NULL, NULL, 'Győr-Moson-Sopron megye, Győr selyem út 10.', 10003, 0, '2022-11-22 12:01:16'),
(71, 'Bankszámla nyitás', NULL, NULL, NULL, 'Vas megye, Szombathely zala utca 89', 10004, 75000, '2022-11-22 12:01:45'),
(72, 'Bankszámla nyitás', NULL, NULL, NULL, 'Győr-Moson-Sopron megye, Győr, Mirella lejtő 90. 34. ajtó', 10015, 1000000, '2022-11-22 12:02:22'),
(73, 'Bankszámla nyitás', NULL, NULL, NULL, 'Győr-Moson-Sopron megye, Győr selyem út 10.', 10009, 45000, '2022-11-22 12:03:02'),
(74, 'Bankszámla nyitás', NULL, NULL, NULL, 'Pest megye, Érd Érdekes körút 16.', 10005, 15000, '2022-11-22 12:03:30'),
(75, 'Bankszámla nyitás', NULL, NULL, NULL, 'Győr-Moson-Sopron megye, Győr selyem út 10.', 10006, 0, '2022-11-22 12:04:01'),
(76, 'Bankszámla nyitás', NULL, NULL, NULL, 'Csongrád megye, Szeged, Aradi tér 16.', 10010, 15000, '2022-11-22 12:04:27'),
(77, 'Bankszámla nyitás', NULL, NULL, NULL, 'Győr-Moson-Sopron megye, Győr, Mirella lejtő 90. 34. ajtó', 10016, 600000, '2022-11-22 12:04:52'),
(78, 'Bankszámla nyitás', NULL, NULL, NULL, 'Pest megye, Érd Érdekes körút 16.', 10007, 5000, '2022-11-22 12:05:20'),
(79, 'Bankszámla nyitás', NULL, NULL, NULL, 'Csongrád megye, Szeged, Széchenyi tér 30.', 10017, 54000, '2022-11-22 12:05:47'),
(80, 'Bankszámla nyitás', NULL, NULL, NULL, 'Pest megye, Érd Érdekes körút 16.', 10008, 0, '2022-11-22 12:06:13'),
(81, 'Bankszámla nyitás', NULL, NULL, NULL, 'Győr-Moson-Sopron megye, Győr selyem út 10.', 10012, 100000, '2022-11-22 12:06:39'),
(82, 'Bankszámla nyitás', NULL, NULL, NULL, 'Csongrád megye, Szeged, Aradi tér 16.', 10013, 85000, '2022-11-22 12:07:12'),
(83, 'Bankszámla nyitás', NULL, NULL, NULL, 'Csongrád megye, Szeged, Széchenyi tér 30.', 10014, 1000000, '2022-11-22 12:08:01'),
(84, 'Bankszámla nyitás', NULL, NULL, NULL, 'Somogy megye, Kaposvár, Zita árok 13. 73. emelet', 10018, 100000, '2022-11-22 12:08:38'),
(85, 'Bankszámla nyitás', NULL, NULL, NULL, 'Pest megye, Érd Érdekes körút 16.', 10011, 0, '2022-11-22 12:09:39'),
(86, 'Bankszámla nyitás', NULL, NULL, NULL, 'Győr-Moson-Sopron megye, Győr selyem út 10.', 10019, 500000, '2022-11-22 12:10:48'),
(87, 'Bankszámla nyitás', NULL, NULL, NULL, 'Csongrád megye, Szeged, Aradi tér 16.', 10020, 750000, '2022-11-22 12:11:46'),
(88, 'Bankszámla nyitás', NULL, NULL, NULL, 'Pest megye, Érd Érdekes körút 16.', 10002, 10000, '2022-11-22 12:17:51'),
(89, 'Bankszámla nyitás', NULL, NULL, NULL, 'Somogy megye, Kaposvár, Zita árok 13. 73. emelet', 10022, 300000, '2022-11-22 17:24:13'),
(96, 'Bankszámla nyitás', NULL, NULL, NULL, 'Pest megye, Érd Érdekes körút 16.', 10023, 60000, '2022-11-22 17:38:03'),
(97, 'Átutalás', 'Vincze Levente', 10023, 'Szia', NULL, 10022, -10000, '2022-11-22 17:43:22'),
(98, 'Átutalás', 'Ceg-BT', 10022, 'Szia', NULL, 10023, 10000, '2022-11-22 17:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `tulajdona`
--

CREATE TABLE `tulajdona` (
  `ugyfelid` int(11) NOT NULL,
  `szamlaszam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `tulajdona`
--

INSERT INTO `tulajdona` (`ugyfelid`, `szamlaszam`) VALUES
(1, 10001),
(2, 10001),
(2, 10002),
(3, 10003),
(4, 10004),
(5, 10015),
(6, 10009),
(7, 10005),
(8, 10006),
(9, 10010),
(10, 10016),
(11, 10007),
(12, 10017),
(13, 10008),
(14, 10012),
(15, 10013),
(16, 10014),
(17, 10018),
(18, 10011),
(19, 10019),
(20, 10020),
(22, 10023),
(23, 10021),
(23, 10022);

-- --------------------------------------------------------

--
-- Table structure for table `ugyfel`
--

CREATE TABLE `ugyfel` (
  `ugyfelid` int(11) NOT NULL,
  `felhasznalonev` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `telefonszam` int(8) NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `jelszo` varchar(256) COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `ugyfel`
--

INSERT INTO `ugyfel` (`ugyfelid`, `felhasznalonev`, `telefonszam`, `email`, `jelszo`) VALUES
(1, 'jazmal', 306952851, 'juhasz.jazmin@hotmail.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(2, 'kiradudas', 306287051, 'boros.flora@yahoo.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(3, 'gittaog', 302301231, 'alexa.csonka@kiraly.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(4, 'istvosz', 309785099, 'albert53@peter.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(5, 'johandas', 309112870, 'balog.henriett@yahoo.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(6, 'katalize', 301374415, 'szekely.dorottya@yahoo.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(7, 'adamspos', 309605632, 'barnabas.meszaros@kiss.biz', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(8, 'katinos', 703627418, 'nbarta@gmail.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(9, 'dorinon', 208806910, 'szucs.livia@halasz.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(10, 'beatritor', 703430765, 'judit.gaspar@lakatos.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(11, 'patrzma', 206287059, 'boros.flora@yahoo.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(12, 'izabeabo', 207876091, 'zsombor66@molnar.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(13, 'oliviares', 204820205, 'boglarka.halasz@yahoo.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(14, 'katabkos', 305102286, 'antal55@fulop.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(15, 'ernopki', 702673361, 'lmeszaros@orsos.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(16, 'aranosz', 702998311, 'rszoke@yahoo.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(17, 'lizaboar', 209302472, 'rudolf40@major.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(18, 'martondi', 708895034, 'barna.mate@yahoo.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(19, 'liviath', 302583935, 'kovacs.mia@novak.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(20, 'kinctos', 206001167, 'kornel.budai@hotmail.com', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(21, 'admin', 309876543, 'asd@asd.hu', '$2y$10$OTEYDo60gxx7Oo3ojaOQ8OeGA5tAjd4NHfMfM56mLW6GPVh.4/Lf2'),
(22, 'magánszemély', 309876540, 'mag@mag.hu', '$2y$10$HxqujLbpvoDw3keHZ/wTP.kWZ2mSTaaz7x/JYPch9soZGnagNb7qu'),
(23, 'ceg', 309988570, 'ceg@ceg.huu', '$2y$10$D.T/SPBHA2Cc4BwPegIpo.Ava.3oV0iNp/ShrgZbVTQeKyy5zXQ.S'),
(24, 'asd', 309876543, 'asd@asd.hu', '$2y$10$Q.2v/aY1fNLLSCL93PekaeQmzmt6lWb5FUMTId7SXP3DC3MsEVnZW'),
(25, 'szia', 709837560, 'szia@szia.hu', '$2y$10$IlJU/Fu7ofKyj2CdMNZwOuHa3sjL0cOCF4XWzfSUIEGedWAiEqBy2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`nev`);

--
-- Indexes for table `bankfiok`
--
ALTER TABLE `bankfiok`
  ADD PRIMARY KEY (`bfiokszam`),
  ADD KEY `nev` (`nev`),
  ADD KEY `cim` (`cim`);

--
-- Indexes for table `bankszamla`
--
ALTER TABLE `bankszamla`
  ADD PRIMARY KEY (`szamlaszam`),
  ADD KEY `banknev` (`banknev`),
  ADD KEY `szamlaszam` (`szamlaszam`);

--
-- Indexes for table `jogiszemely`
--
ALTER TABLE `jogiszemely`
  ADD PRIMARY KEY (`ugyfelid`),
  ADD UNIQUE KEY `cegnev` (`cegnev`),
  ADD KEY `ugyfelid` (`ugyfelid`);

--
-- Indexes for table `maganszemely`
--
ALTER TABLE `maganszemely`
  ADD PRIMARY KEY (`ugyfelid`),
  ADD UNIQUE KEY `szemelyiszam` (`szemelyiszam`),
  ADD KEY `ugyfelid` (`ugyfelid`);

--
-- Indexes for table `penzforgalom`
--
ALTER TABLE `penzforgalom`
  ADD PRIMARY KEY (`azonosito`),
  ADD KEY `megbizoszamlaszam` (`megbizoszamlaszam`),
  ADD KEY `helyszin` (`helyszin`);

--
-- Indexes for table `tulajdona`
--
ALTER TABLE `tulajdona`
  ADD PRIMARY KEY (`ugyfelid`,`szamlaszam`),
  ADD UNIQUE KEY `ugyfelid_2` (`ugyfelid`,`szamlaszam`),
  ADD KEY `ugyfelid` (`ugyfelid`),
  ADD KEY `szamlaszam` (`szamlaszam`);

--
-- Indexes for table `ugyfel`
--
ALTER TABLE `ugyfel`
  ADD PRIMARY KEY (`ugyfelid`),
  ADD UNIQUE KEY `felhasznalonev` (`felhasznalonev`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bankfiok`
--
ALTER TABLE `bankfiok`
  MODIFY `bfiokszam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penzforgalom`
--
ALTER TABLE `penzforgalom`
  MODIFY `azonosito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bankfiok`
--
ALTER TABLE `bankfiok`
  ADD CONSTRAINT `bankfiok_ibfk_1` FOREIGN KEY (`nev`) REFERENCES `bank` (`nev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bankszamla`
--
ALTER TABLE `bankszamla`
  ADD CONSTRAINT `bankszamla_ibfk_1` FOREIGN KEY (`banknev`) REFERENCES `bankfiok` (`nev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jogiszemely`
--
ALTER TABLE `jogiszemely`
  ADD CONSTRAINT `jogiszemely_ibfk_1` FOREIGN KEY (`ugyfelid`) REFERENCES `ugyfel` (`ugyfelid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `maganszemely`
--
ALTER TABLE `maganszemely`
  ADD CONSTRAINT `maganszemely_ibfk_1` FOREIGN KEY (`ugyfelid`) REFERENCES `ugyfel` (`ugyfelid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penzforgalom`
--
ALTER TABLE `penzforgalom`
  ADD CONSTRAINT `penzforgalom_ibfk_2` FOREIGN KEY (`helyszin`) REFERENCES `bankfiok` (`cim`) ON UPDATE CASCADE,
  ADD CONSTRAINT `penzforgalom_ibfk_3` FOREIGN KEY (`megbizoszamlaszam`) REFERENCES `bankszamla` (`szamlaszam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tulajdona`
--
ALTER TABLE `tulajdona`
  ADD CONSTRAINT `tulajdona_ibfk_1` FOREIGN KEY (`ugyfelid`) REFERENCES `ugyfel` (`ugyfelid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tulajdona_ibfk_2` FOREIGN KEY (`szamlaszam`) REFERENCES `bankszamla` (`szamlaszam`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
