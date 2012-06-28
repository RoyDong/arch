-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 28, 2012 at 03:39 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `email` char(50) NOT NULL COMMENT 'email',
  `password` char(40) NOT NULL,
  `salt` char(16) NOT NULL,
  `ctime` int(10) unsigned NOT NULL COMMENT 'create time',
  `utime` int(10) unsigned NOT NULL COMMENT 'update time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='user';

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `uid` int(10) unsigned NOT NULL,
  `name` varchar(100) DEFAULT '' COMMENT 'user name',
  `sex` char(1) DEFAULT 'm' COMMENT 'female or male',
  `birth` int(10) unsigned NOT NULL COMMENT 'birth time',
  `ctime` int(10) unsigned NOT NULL COMMENT 'create time',
  `utime` int(10) unsigned NOT NULL COMMENT 'update time',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='user_profile';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
