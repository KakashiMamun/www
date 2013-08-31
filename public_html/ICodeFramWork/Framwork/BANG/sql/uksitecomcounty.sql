-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2011 at 06:11 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0
use bang;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sitecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`state_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `name`) VALUES
(1, 'Aberdeenshire'),
(2, 'Anglesey/Sir Fon'),
(3, 'Angus/Forfarshire'),
(4, 'Argyllshire'),
(5, 'Ayrshire'),
(6, 'Banffshire'),
(7, 'Bedfordshire'),
(8, 'Berkshire'),
(9, 'Berwickshire'),
(10, 'Brecknockshire/Sir Frycheiniog'),
(11, 'Buckinghamshire'),
(12, 'Buteshire'),
(13, 'Caernarfonshire/Sir Gaernarfon'),
(14, 'Caithness'),
(15, 'Cambridgeshire'),
(16, 'Cardiganshire/Ceredigion'),
(17, 'Carmarthenshire/Sir Gaerfyrddin'),
(18, 'Cheshire'),
(19, 'Clackmannanshire'),
(20, 'Cornwall'),
(21, 'County Antrim'),
(22, 'County Armagh'),
(23, 'County Down'),
(24, 'County Fermanagh'),
(25, 'County Londonderry/Derry'),
(26, 'County Tyrone'),
(27, 'Cromartyshire'),
(28, 'Cumberland'),
(29, 'Denbighshire/Sir Ddinbych'),
(30, 'Derbyshire'),
(31, 'Devon'),
(32, 'Dorset'),
(33, 'Dumfriesshire'),
(34, 'Dunbartonshire/Dumbartonshire'),
(35, 'Durham'),
(36, 'East Lothian/Haddingtonshire'),
(37, 'East Yorkshire'),
(38, 'Essex'),
(39, 'Fife'),
(40, 'Flintshire/Sir Fflint'),
(41, 'Glamorgan/Morgannwg'),
(42, 'Gloucestershire'),
(43, 'Hampshire'),
(44, 'Herefordshire'),
(45, 'Hertfordshire'),
(46, 'Huntingdonshire'),
(47, 'Inverness-shire'),
(48, 'Kent'),
(49, 'Kincardineshire'),
(50, 'Kinross-shire'),
(51, 'Kirkcudbrightshire'),
(52, 'Lanarkshire'),
(53, 'Lancashire'),
(54, 'Leicestershire'),
(55, 'Lincolnshire'),
(56, 'Merioneth/Meirionnydd'),
(57, 'Middlesex'),
(58, 'Midlothian/Edinburghshire'),
(59, 'Monmouthshire/Sir Fynwy'),
(60, 'Montgomeryshire/Sir Drefaldwyn'),
(61, 'Morayshire'),
(62, 'Nairnshire'),
(63, 'Norfolk'),
(64, 'North Yorkshire'),
(65, 'Northamptonshire'),
(66, 'Northumberland'),
(67, 'Nottinghamshire'),
(68, 'Orkney'),
(69, 'Oxfordshire'),
(70, 'Peeblesshire '),
(71, 'Pembrokeshire/Sir Benfro'),
(72, 'Perthshire'),
(73, 'Radnorshire/Sir Faesyfed'),
(74, 'Renfrewshire'),
(75, 'Ross-shire'),
(76, 'Roxburghshire'),
(77, 'Rutland'),
(78, 'Selkirkshire'),
(79, 'Shetland'),
(80, 'Shropshire'),
(81, 'Somerset'),
(82, 'South Yorkshire'),
(83, 'Staffordshire'),
(84, 'Stirlingshire'),
(85, 'Suffolk'),
(86, 'Surrey'),
(87, 'Sussex'),
(88, 'Sutherland'),
(89, 'Warwickshire'),
(90, 'West Lothian/Linlithgowshire'),
(91, 'West Yorkshire'),
(92, 'Westmorland'),
(93, 'Wigtownshire'),
(94, 'Wiltshire'),
(95, 'Worcestershire');
