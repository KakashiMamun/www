-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2011 at 09:20 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0
use Bang;
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
-- Table structure for table `icode_configuration`
--

CREATE TABLE IF NOT EXISTS `icode_configuration` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` enum('developer','pagination','server','email') NOT NULL DEFAULT 'developer',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `icode_configuration`
--

INSERT INTO `icode_configuration` (`name`, `value`, `type`) VALUES
('LOG_TRANSACTIONS', '1', 'developer'),
('WEBSITE_NAME', 'bang.com', 'server'),
('FORGET_HOURS', '48', 'server'),
('PAYPAL_INVOICE_PREFIX', 'sitecom', 'server'),
('SYSTEM_EMAIL_ADDRESS', 'admin@bang.com', 'server'),
('DATE_FORMAT', 'date_format(%date%,', 'developer'),
('WEBMASTER_EMAIL', '', 'server'),
('CONTACT_EMAIL', '', 'server'),
('PAYPAL_SANDBOX', '1', 'server'),
('CURRENCY_CODE', 'EUR', 'server'),
('PAYPAL_BUSINESS_ACCOUNT', 'seller@paypalsandbox.com', 'server'),
('ANNUAL_PRICE_PER_SITE', '100', 'developer'),
('PAYMENT_NOTIFICATION_EMAIL', 'admin@bang.com', 'server'),
('NOTIFICATION_FILE_DIR', '', 'server');