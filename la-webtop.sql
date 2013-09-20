-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: nas.s3131212.com
-- Generation Time: Aug 09, 2013 at 11:19 PM
-- Server version: 5.1.49
-- PHP Version: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `allenos`
--

-- --------------------------------------------------------

--
-- Table structure for table `app`
--

CREATE TABLE IF NOT EXISTS `app` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `app_key` varchar(40) DEFAULT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `canvas_url` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `perms` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PERMISSON_NONE',
  `is_system_app` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `app`
--

INSERT INTO `app` (`id`, `app_key`, `name`, `canvas_url`, `logo`, `perms`, `is_system_app`) VALUES
(1, NULL, '雲端硬碟', 'content/file/index.php', 'img/icons/filemaneger.png', 'PERMISSON_NONE', 1),
(2, NULL, '計算機', 'content/calculator/index.html', 'img/icons/calculator.png', 'PERMISSON_NONE', 0),
(3, NULL, '照相機', 'content/webcam/photobooth.html', 'img/icons/webcam.png', 'PERMISSON_NONE', 0),
(4, NULL, '小畫家', 'content/drawpad/index.html', 'img/icons/drawpad.png', 'PERMISSON_NONE', 0),
(5, NULL, 'Email寄送', 'content/mail/index.html', 'img/icons/email.png', 'PERMISSON_NONE', 0),
(6, NULL, '網路電台', 'content/radio/index.html', 'img/icons/radio.png', 'PERMISSON_NONE', 0),
(7, NULL, '時鐘', 'content/clock/index.html', 'img/icons/clock.png', 'PERMISSON_NONE', 0),
(8, NULL, '養老鼠', 'game/hamster.html', 'img/icons/hamster.png', 'PERMISSON_NONE', 0),
(9, NULL, '打彈珠', 'game/disc-drop.html', 'img/icons/disc-drop.png', 'PERMISSON_NONE', 0),
(10, NULL, 'HexGL(3D賽車)', 'http://serve-licson.net23.net/demos/hexgl/', 'img/icons/hexgl.png', 'PERMISSON_NONE', 0),
(12, NULL, '控制台', 'admin/index.php', 'img/icons/setting.png', 'PERMISSON_CHANGE_SETTINGS', 1),
(11, NULL, '記事本', 'content/notepad/index.php', 'img/icons/notepad.png', 'PERMISSON_NONE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `filename` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `real_location` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notepad`
--

CREATE TABLE IF NOT EXISTS `notepad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`name`, `value`) VALUES
('system_name', 'LA Webtop '),
('bg', 'img/bg.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', '', '76ef95ebf2c0782ad40d136152726bf7');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
