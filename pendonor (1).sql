-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2022 at 05:29 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `pendonor`
--

CREATE TABLE `pendonor` (
  `id_pendonor` int(11) NOT NULL,
  `nama_pendonor` varchar(200) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(2) NOT NULL,
  `golongan_darah` varchar(2) NOT NULL,
  `rhesus` varchar(1) NOT NULL,
  `alamat_rumah` varchar(200) NOT NULL,
  `id_kelurahan_rumah` int(11) NOT NULL,
  `alamat_kantor` varchar(200) NOT NULL,
  `id_kelurahan_kantor` int(11) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendonor`
--

INSERT INTO `pendonor` (`id_pendonor`, `nama_pendonor`, `tanggal_lahir`, `jenis_kelamin`, `golongan_darah`, `rhesus`, `alamat_rumah`, `id_kelurahan_rumah`, `alamat_kantor`, `id_kelurahan_kantor`, `no_telp`, `email`) VALUES
(1, 'KELLY', '1974-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(2, 'BILLY', '1972-10-01', 'L', 'B', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221835555', 'hahaha'),
(3, 'GRACE', '1980-09-11', 'L', 'AB', '-', 'hihi', 42766, 'hihi', 42766, '08221855555', 'hihi@gmail.com'),
(4, 'REGINA', '1977-08-01', 'P', 'A', '+', 'hoho', 42766, 'hoho', 42766, '08221827373', 'hoho'),
(5, 'TIFFANY', '1975-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08221847373', 'kkkk'),
(6, 'GOLDY', '1976-10-01', 'L', 'O', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221865555', 'hahaha'),
(7, 'JOHN', '1975-10-11', 'L', 'AB', '-', 'hihi', 42766, 'hihi', 42766, '08221855557', 'hihi@gmail.com'),
(8, 'MICHAEL', '1981-10-01', 'P', 'AB', '+', 'hoho', 42766, 'hoho', 42766, '08221821373', 'hoho'),
(9, 'BAMBANG', '1976-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08121827373', 'kkkk'),
(10, 'AGUS', '1976-10-01', 'L', 'O', '-', 'hahahahaahha', 42766, 'haha', 42766, '08121855555', 'hahaha'),
(11, 'RYAN', '1976-11-24', 'P', 'A', '+', 'pakuwon city', 42766, '--', 42766, '08220827373', 'kkkk'),
(12, 'CATHERINE', '1976-10-01', 'L', 'O', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(13, 'LALA', '1980-10-11', 'L', 'A', '-', 'hihi', 42766, 'hihi', 42766, '08221855555', 'hihi@gmail.com'),
(14, 'LULU', '1976-10-01', 'P', 'AB', '+', 'hoho', 42766, 'hoho', 42766, '08221827373', 'hoho'),
(15, 'LILI', '1976-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(16, 'LIA', '1976-10-01', 'L', 'O', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(17, 'BUDI', '1980-10-11', 'L', 'AB', '-', 'hihi', 42766, 'hihi', 42766, '08221855555', 'hihi@gmail.com'),
(18, 'GISELE', '1980-10-01', 'P', 'AB', '+', 'hoho', 42766, 'hoho', 42766, '08221827373', 'hoho'),
(19, 'NICOLE', '1982-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(20, 'CUAN', '1983-10-01', 'L', 'B', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(21, 'FELIA', '1980-11-24', 'P', 'A', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(22, 'RACHEL', '1980-10-01', 'L', 'O', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(23, 'MONICA', '1980-10-11', 'L', 'AB', '-', 'hihi', 42766, 'hihi', 42766, '08221855555', 'hihi@gmail.com'),
(24, 'TED', '1980-10-01', 'P', 'AB', '+', 'hoho', 42766, 'hoho', 42766, '08221827373', 'hoho'),
(25, 'JOE', '1971-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(26, 'FLORENCES', '1972-10-01', 'L', 'O', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(27, 'NATASHA', '1976-10-11', 'L', 'AB', '-', 'hihi', 42766, 'hihi', 42766, '08221855555', 'hihi@gmail.com'),
(28, 'RICKY', '1978-10-01', 'P', 'B', '+', 'hoho', 42766, 'hoho', 42766, '08221827373', 'hoho'),
(29, 'DANIEL', '1972-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(30, 'JEFF', '1973-10-01', 'L', 'A', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(31, 'TIM', '1976-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(32, 'TOM', '1975-10-01', 'L', 'O', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(33, 'DARREN', '1976-10-11', 'L', 'AB', '-', 'hihi', 42766, 'hihi', 42766, '08221855555', 'hihi@gmail.com'),
(34, 'KEN', '1976-10-01', 'P', 'AB', '+', 'hoho', 42766, 'hoho', 42766, '08221827373', 'hoho'),
(35, 'BARBIE', '1977-11-24', 'P', 'O', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(36, 'MILEY', '1979-10-01', 'L', 'A', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(37, 'JUSTIN', '1970-10-11', 'L', 'AB', '-', 'hihi', 42766, 'hihi', 42766, '08221855555', 'hihi@gmail.com'),
(38, 'HAILEY', '1970-10-01', 'P', 'AB', '+', 'hoho', 42766, 'hoho', 42766, '08221827373', 'hoho'),
(39, 'KEANU', '1978-11-24', 'P', 'A', '+', 'pakuwon city', 42766, '--', 42766, '08221827373', 'kkkk'),
(40, 'MIKE', '1972-10-01', 'L', 'B', '-', 'hahahahaahha', 42766, 'haha', 42766, '08221855555', 'hahaha'),
(41, 'FELI', '2000-01-02', 'P', 'B', '-', 'hahaha', 42766, 'haha', 42766, '08221812555', 'hahih'),
(42, 'BRIAN', '2001-02-03', 'L', 'O', '+', 'haahaahha', 42766, 'haha', 42766, '08224735555', 'haheha'),
(43, 'MICHELLE', '2002-03-04', 'P', 'O', '-', 'haahaha', 42766, 'haha', 42766, '08222375555', 'eahaha'),
(44, 'KODRI', '2003-04-05', 'L', 'A', '-', 'hahahaahha', 42766, '--', 42766, '08221809855', 'rahaha'),
(45, 'KAREN', '2005-05-06', 'P', 'AB', '-', 'hahaaahha', 42766, '--', 42766, '08221647555', 'gahaha'),
(46, 'JOKO', '1999-06-07', 'L', 'O', '-', 'hahaahha', 42766, '--', 42766, '08221904555', 'kahaha'),
(47, 'TARUB', '1998-07-08', 'L', 'A', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(48, 'SANGKURIANG', '1997-08-09', 'L', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '082238655515', 'sahaha'),
(49, 'NYAI', '1996-09-10', 'P', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(50, 'RORO', '1995-10-11', 'P', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(51, 'DIMAS', '1994-11-12', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(52, 'ADI', '1993-12-13', 'L', 'A', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(53, 'PEPPA', '1990-12-14', 'P', 'O', '+', 'hahaahha', 42766, 'haha', 42766, '08221763255', 'bahaha'),
(54, 'BEMA', '1991-08-15', 'L', 'AB', '+', 'hahahahha', 42766, 'haha', 42766, '08223871455', 'sahaha'),
(55, 'BIMA', '1992-09-16', 'L', 'B', '+', 'hahahaahhh', 42766, 'haha', 42766, '082218552303', 'qahaha'),
(56, 'BOBO', '1993-10-17', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(57, 'BOHDI', '1994-11-18', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(58, 'ARTHUR', '1983-12-19', 'L', 'O', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(59, 'TESSIA', '1988-07-20', 'P', 'A', '+', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(60, 'HELEN', '1977-08-21', 'P', 'AB', '+', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(61, 'REIN', '1986-09-22', 'L', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(62, 'REYN', '1975-10-23', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(63, 'RAINER', '1964-11-24', 'L', 'AB', '+', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(64, 'KEVIN', '1976-12-25', 'L', 'A', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(65, 'NANA', '1988-07-26', 'P', 'B', '+', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(66, 'LIA', '1979-08-27', 'P', 'A', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(67, 'CECIL', '1977-09-28', 'P', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(68, 'VIVI', '1965-10-29', 'P', 'O', '+', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(69, 'VEVE', '1984-11-30', 'P', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(70, 'KIVIER', '1973-12-13', 'P', 'O', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(71, 'CHIKA', '1978-07-08', 'P', 'O', '-', 'hahaahha', 42766, 'haha', 42766, '08221763255', 'bahaha'),
(72, 'SENO', '1967-08-09', 'L', 'AB', '+', 'hahahahha', 42766, 'haha', 42766, '08223871455', 'sahaha'),
(73, 'RENO', '1986-09-10', 'L', 'B', '+', 'hahahaahhh', 42766, 'haha', 42766, '082218552303', 'qahaha'),
(74, 'BRUNO', '1995-10-11', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(75, 'DODO', '1994-11-12', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(76, 'KITO', '1993-12-13', 'L', 'O', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(77, 'VINA', '1998-07-08', 'P', 'A', '+', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(78, 'KANA', '1997-08-09', 'P', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(79, 'BEN', '1996-09-10', 'L', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(80, 'MAYNARD', '1995-10-11', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(81, 'CHRIS', '1994-11-12', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(82, 'CAESAR', '1993-12-13', 'L', 'A', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(83, 'BRENDA', '1998-07-08', 'P', 'B', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(84, 'BONI', '1997-08-09', 'P', 'A', '+', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(85, 'LINA', '1996-09-10', 'P', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(86, 'EVELYN', '1995-10-11', 'P', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(87, 'SANA', '1994-11-12', 'P', 'AB', '+', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(88, 'RENA', '1993-12-13', 'P', 'O', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(89, 'VENA', '1998-07-08', 'P', 'O', '-', 'hahaahha', 42766, 'haha', 42766, '08221763255', 'bahaha'),
(90, 'JENO', '1997-08-09', 'L', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '08223871455', 'sahaha'),
(91, 'JAVIER', '1996-09-10', 'L', 'B', '+', 'hahahaahhh', 42766, 'haha', 42766, '082218552303', 'qahaha'),
(92, 'DONO', '1995-10-11', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(93, 'KASINO', '1994-11-12', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(94, 'ENDRO', '1993-12-13', 'L', 'O', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(95, 'SUSI', '1998-07-08', 'P', 'A', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(96, 'LILI', '1997-08-09', 'P', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(97, 'INDRA', '1996-09-10', 'L', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(98, 'SURYA', '1995-10-11', 'L', 'O', '+', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(99, 'RAFI', '1994-11-12', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(100, 'ASTRO', '1993-12-13', 'L', 'A', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(101, 'MIRNA', '1998-07-08', 'P', 'B', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(102, 'PETRA', '1997-08-09', 'P', 'A', '+', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(103, 'FIO', '1996-09-10', 'P', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(104, 'VIO', '1995-10-11', 'P', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(105, 'VIA', '1994-11-12', 'P', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(106, 'GINA', '1993-12-13', 'P', 'O', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(107, 'KIKI', '1998-07-08', 'P', 'O', '-', 'hahaahha', 42766, 'haha', 42766, '08221763255', 'bahaha'),
(108, 'BONBON', '1997-08-09', 'L', 'AB', '+', 'hahahahha', 42766, 'haha', 42766, '08223871455', 'sahaha'),
(109, 'TINTIN', '1996-09-10', 'L', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218552303', 'qahaha'),
(110, 'ANTON', '1995-10-11', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(111, 'KRASNI', '1994-11-12', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(112, 'FERRY', '1993-12-13', 'L', 'O', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(113, 'AUDREY', '1998-07-08', 'P', 'A', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(114, 'VERO', '1997-08-09', 'P', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(115, 'PANJI', '1996-09-10', 'L', 'B', '+', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(116, 'ANJI', '1995-10-11', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(117, 'PETRUS', '1994-11-12', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(118, 'SIMON', '1993-12-13', 'L', 'A', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(119, 'ELISA', '1998-07-08', 'P', 'B', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(120, 'ELIA', '1997-08-09', 'P', 'A', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(121, 'ELSA', '1996-09-10', 'P', 'B', '+', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(122, 'ERZA', '1995-10-20', 'P', 'O', '+', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(123, 'HILDA', '1994-11-25', 'P', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(124, 'INA', '1993-12-30', 'P', 'O', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(125, 'RAFAEL', '1994-11-08', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(126, 'ASTA', '2006-03-14', 'L', 'A', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(127, 'MARNI', '1998-07-05', 'P', 'B', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(128, 'RANI', '1997-08-09', 'P', 'A', '+', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(129, 'FARA', '1996-09-10', 'P', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(130, 'FLORIN', '1995-10-20', 'P', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(131, 'VIVIAN', '2003-04-17', 'P', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(132, 'GIGI', '2003-02-12', 'P', 'O', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(133, 'KENDAL', '1998-07-01', 'P', 'O', '-', 'hahaahha', 42766, 'haha', 42766, '08221763255', 'bahaha'),
(134, 'BARNABAS', '2002-08-09', 'L', 'AB', '+', 'hahahahha', 42766, 'haha', 42766, '08223871455', 'sahaha'),
(135, 'TADEUS', '2000-09-10', 'L', 'B', '-', 'hahahaahhh', 42766, 'haha', 42766, '082218552303', 'qahaha'),
(136, 'AKON', '2003-10-11', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(137, 'KIM', '2004-11-12', 'L', 'AB', '+', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(138, 'MANCA', '2005-05-21', 'L', 'O', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(139, 'AUBREY', '1998-07-08', 'P', 'A', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(140, 'VERA', '1997-08-09', 'P', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(141, 'SANJI', '1996-09-10', 'L', 'B', '+', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(142, 'BANDI', '1995-10-01', 'L', 'O', '-', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(143, 'BERTRAN', '1994-11-17', 'L', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(144, 'MORIS', '2005-07-03', 'L', 'A', '-', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(145, 'BELLA', '1998-07-18', 'P', 'B', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(146, 'ELI', '1995-06-03', 'P', 'A', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(147, 'ANNA', '1996-09-30', 'P', 'B', '+', 'hahahaahhh', 42766, 'haha', 42766, '082218555203', 'qahaha'),
(148, 'EZRA', '1995-10-21', 'P', 'O', '+', 'hahaahahh', 42766, '--', 42766, '08221855595', 'rahaha'),
(149, 'NABILA', '1994-11-02', 'P', 'AB', '-', 'haahahha', 42766, '--', 42766, '08221855025', 'tahaha'),
(150, 'SENA', '2002-03-06', 'P', 'O', '+', 'hahhahha', 42766, 'haha', 42766, '082218555944', 'yahaha'),
(151, 'BENITA', '2000-01-02', 'P', 'B', '-', 'hahaha', 42766, 'haha', 42766, '08221812555', 'hahih'),
(152, 'BELARUS', '2001-02-03', 'L', 'O', '+', 'haahaahha', 42766, 'haha', 42766, '08224735555', 'haheha'),
(153, 'BELINDA', '2002-10-24', 'P', 'O', '-', 'haahaha', 42766, 'haha', 42766, '08222375555', 'eahaha'),
(154, 'BRAN', '2003-03-25', 'L', 'A', '-', 'hahahaahha', 42766, '--', 42766, '08221809855', 'rahaha'),
(155, 'KESIA', '2005-02-16', 'P', 'AB', '-', 'hahaaahha', 42766, '--', 42766, '08221647555', 'gahaha'),
(156, 'PATRICK', '1999-12-17', 'L', 'O', '-', 'hahaahha', 42766, '--', 42766, '08221904555', 'kahaha'),
(157, 'NICO', '1998-07-08', 'L', 'A', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(158, 'BRAD', '1997-08-09', 'L', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(159, 'VERINA', '2000-01-02', 'P', 'B', '-', 'hahaha', 42766, 'haha', 42766, '08221812555', 'hahih'),
(160, 'LUVIAN', '2001-02-03', 'L', 'O', '+', 'haahaahha', 42766, 'haha', 42766, '08224735555', 'haheha'),
(161, 'MICHEN', '2002-03-13', 'P', 'O', '-', 'haahaha', 42766, 'haha', 42766, '08222375555', 'eahaha'),
(162, 'GRANT', '2003-06-15', 'L', 'A', '-', 'hahahaahha', 42766, '--', 42766, '08221809855', 'rahaha'),
(163, 'VINNY', '2005-05-30', 'P', 'AB', '-', 'hahaaahha', 42766, '--', 42766, '08221647555', 'gahaha'),
(164, 'VONZI', '2005-01-18', 'L', 'O', '-', 'hahaahha', 42766, '--', 42766, '08221904555', 'kahaha'),
(165, 'LOUIS', '2003-04-29', 'L', 'A', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(166, 'YEREMIA', '2000-12-19', 'L', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '08223865555', 'sahaha'),
(167, 'KAKA', '1970-01-02', 'L', 'B', '-', 'hahaha', 42766, 'haha', 42766, '08221812555', 'hahih'),
(168, 'RONAL', '1971-02-03', 'L', 'O', '+', 'haahaahha', 42766, 'haha', 42766, '08224735555', 'haheha'),
(169, 'KIRO', '1972-03-04', 'L', 'O', '-', 'haahaha', 42766, 'haha', 42766, '08222375555', 'eahaha'),
(170, 'VICO', '1977-04-05', 'L', 'A', '+', 'hahahaahha', 42766, '--', 42766, '08221809855', 'rahaha'),
(171, 'VICTOR', '1975-05-06', 'L', 'AB', '+', 'hahaaahha', 42766, '--', 42766, '08221647555', 'gahaha'),
(172, 'BINTORO', '1979-06-07', 'L', 'O', '-', 'hahaahha', 42766, '--', 42766, '08221904555', 'kahaha'),
(173, 'BEJO', '1968-07-08', 'L', 'A', '+', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(174, 'YUDI', '1977-11-29', 'L', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '082238655515', 'sahaha'),
(175, 'RONI', '1980-01-02', 'L', 'B', '-', 'hahaha', 42766, 'haha', 42766, '08221812555', 'hahih'),
(176, 'PRI', '1967-02-03', 'L', 'O', '+', 'haahaahha', 42766, 'haha', 42766, '08224735555', 'haheha'),
(177, 'YANTO', '1976-03-04', 'L', 'O', '-', 'haahaha', 42766, 'haha', 42766, '08222375555', 'eahaha'),
(178, 'SUMANTO', '1978-04-05', 'L', 'A', '+', 'hahahaahha', 42766, '--', 42766, '08221809855', 'rahaha'),
(179, 'BAMBANG', '1978-05-06', 'L', 'AB', '-', 'hahaaahha', 42766, '--', 42766, '08221647555', 'gahaha'),
(180, 'HARIYANTO', '1978-06-07', 'L', 'O', '+', 'hahaahha', 42766, '--', 42766, '08221904555', 'kahaha'),
(181, 'SUYATNO', '1978-07-08', 'L', 'A', '-', 'hahaahha', 42766, 'haha', 42766, '08221726555', 'bahaha'),
(182, 'SUPARNO', '1978-08-09', 'L', 'AB', '-', 'hahahahha', 42766, 'haha', 42766, '082238655515', 'sahaha');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pendonor`
--
ALTER TABLE `pendonor`
  ADD PRIMARY KEY (`id_pendonor`),
  ADD KEY `id_kelurahan_rumah` (`id_kelurahan_rumah`),
  ADD KEY `id_kelurahan_kantor` (`id_kelurahan_kantor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pendonor`
--
ALTER TABLE `pendonor`
  MODIFY `id_pendonor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pendonor`
--
ALTER TABLE `pendonor`
  ADD CONSTRAINT `id_kelurahan_kantor` FOREIGN KEY (`id_kelurahan_kantor`) REFERENCES `kelurahan` (`id_kelurahan`),
  ADD CONSTRAINT `id_kelurahan_rumah` FOREIGN KEY (`id_kelurahan_rumah`) REFERENCES `kelurahan` (`id_kelurahan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
