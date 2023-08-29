-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 23, 2018 at 11:15 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php_plantdisease`
--
CREATE DATABASE IF NOT EXISTS `php_plantdisease` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `php_plantdisease`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cname` varchar(100) NOT NULL,
  PRIMARY KEY (`cname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cname`) VALUES
('Flower'),
('Fruit'),
('Plants'),
('Rice'),
('Vegetable'),
('Wheat');

-- --------------------------------------------------------

--
-- Table structure for table `newuser`
--

CREATE TABLE IF NOT EXISTS `newuser` (
  `name` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newuser`
--

INSERT INTO `newuser` (`name`, `gender`, `addr`, `city`, `userid`, `pwd`) VALUES
('Balaji', 'Male', '34,South Street,', 'Madurai', 'balaji@gmail.com', 'balaji'),
('Ganesh', 'Male', '24,South Street,', 'Madurai', 'ganesh@gmail.com', 'ganesh');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(100) NOT NULL,
  `cropname` varchar(100) NOT NULL,
  `dname` varchar(100) NOT NULL,
  `descr` varchar(500) NOT NULL,
  `solution` varchar(500) NOT NULL,
  `fname` varchar(500) NOT NULL,
  `ftype` varchar(300) NOT NULL,
  `fsize` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `cname`, `cropname`, `dname`, `descr`, `solution`, `fname`, `ftype`, `fsize`) VALUES
(2, 'Flower', 'Fuchsia Flower', 'Anthrocnose', 'This is a spread disease found rarely', 'On the disease affected area, first benzynol needs to be spread once...', 'uploads/1514555863anthracnose__cycad.jpg', 'image/jpeg', '8300'),
(3, 'Fruit', 'Mango', 'AnthrocMango', 'This is a black coloured spread found in mango fruit', 'To overcome this spread benzynol in the tree leaves once', 'uploads/1514556131anthracnose__mango.jpg', 'image/jpeg', '7762'),
(4, 'Plants', 'Teak Plant', 'Dryanthracs', 'This is a dry disease which is formed by abnormal climatic conditions.', 'For this the plant leaves needs to be trdated first.  Spray the fleeces of the organic in the outer layer of the diseased area', 'uploads/1514811320rustteak1.jpg', 'image/jpeg', '21371');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
