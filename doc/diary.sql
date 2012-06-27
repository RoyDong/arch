-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 27, 2012 at 11:19 PM
-- Server version: 5.5.25-log
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `diary`
--

-- --------------------------------------------------------

--
-- Table structure for table `diary`
--

CREATE TABLE IF NOT EXISTS `diary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'diary id',
  `text` text NOT NULL COMMENT 'diary content',
  `uid` int(10) unsigned NOT NULL COMMENT 'writer id',
  `ctime` int(10) unsigned NOT NULL COMMENT 'create time',
  `utime` int(10) unsigned NOT NULL COMMENT 'update time',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='diary' AUTO_INCREMENT=1 ;
