-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 12:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ssd_y4_assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_Name` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  PRIMARY KEY (`Admin_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `COMMENT` text NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`COMMENT_ID`),
  KEY `POST_ID` (`POST_ID`),
  KEY `USER_ID` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments_events`
--

CREATE TABLE IF NOT EXISTS `comments_events` (
  `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `COMMENT` text NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`COMMENT_ID`),
  KEY `Event_ID` (`Event_ID`),
  KEY `USER_ID` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments_vid`
--

CREATE TABLE IF NOT EXISTS `comments_vid` (
  `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `VIDEO_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `COMMENT` text NOT NULL,
  `DATE` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`COMMENT_ID`),
  KEY `VIDEO_ID` (`VIDEO_ID`),
  KEY `USER_ID` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `Event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Likes` int(11) NOT NULL,
  `Event_Poster` text NOT NULL,
  `Caption` varchar(250) NOT NULL,
  `Event_Time` time NOT NULL,
  `Event_Date` datetime NOT NULL,
  `Invite_Link` text NOT NULL,
  `HashTags` varchar(250) NOT NULL,
  `Date_Upload` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Event_ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fallowing`
--

CREATE TABLE IF NOT EXISTS `fallowing` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_Id` int(11) NOT NULL,
  `Other_user_id` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `Like_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Post_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  PRIMARY KEY (`Like_ID`),
  KEY `Post_ID` (`Post_ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes_events`
--

CREATE TABLE IF NOT EXISTS `likes_events` (
  `Like_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Event_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  PRIMARY KEY (`Like_ID`),
  KEY `Event_ID` (`Event_ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes_vid`
--

CREATE TABLE IF NOT EXISTS `likes_vid` (
  `Like_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Video_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  PRIMARY KEY (`Like_ID`),
  KEY `Video_ID` (`Video_ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `Post_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Likes` int(11) NOT NULL,
  `Img_Path` text NOT NULL,
  `Caption` varchar(700) NOT NULL,
  `HashTags` varchar(250) NOT NULL,
  `Date_Upload` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Post_ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `special_events`
--

CREATE TABLE IF NOT EXISTS `special_events` (
  `Event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Caption` varchar(250) NOT NULL,
  `Event_Time` time NOT NULL,
  `Event_Date` datetime NOT NULL,
  `Invite_Link` text NOT NULL,
  `Date_Upload` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`Event_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FULL_NAME` varchar(100) NOT NULL,
  `USER_NAME` varchar(50) NOT NULL,
  `USER_TYPE` varchar(2) NOT NULL,
  `PASSWORD_S` longtext NOT NULL,
  `EMAIL` varchar(60) NOT NULL,
  `GOOGLE_ID` varchar(255) DEFAULT NULL,
  `PROFILE_PICTURE` varchar(255) DEFAULT NULL,
  `IMAGE` varchar(200) DEFAULT 'default.png',
  `FACEBOOK` varchar(200) DEFAULT 'www.facebook.com',
  `WHATSAPP` varchar(200) DEFAULT 'www.webwhatsapp.com',
  `BIO` varchar(500) DEFAULT 'bio here',
  `FALLOWERS` int(11) DEFAULT 0,
  `FALLOWING` int(11) DEFAULT 0,
  `POSTS` int(11) DEFAULT 0,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `Video_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Likes` int(11) NOT NULL,
  `Video_Path` text NOT NULL,
  `Caption` varchar(250) NOT NULL,
  `HashTags` varchar(250) NOT NULL,
  `Date_Upload` datetime NOT NULL DEFAULT current_timestamp(),
  `Thumbnail_Path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Video_ID`),
  KEY `User_ID` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`POST_ID`) REFERENCES `posts` (`Post_ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `comments_events`
--
ALTER TABLE `comments_events`
  ADD CONSTRAINT `comments_events_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `events` (`Event_ID`),
  ADD CONSTRAINT `comments_events_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `comments_vid`
--
ALTER TABLE `comments_vid`
  ADD CONSTRAINT `comments_vid_ibfk_1` FOREIGN KEY (`VIDEO_ID`) REFERENCES `videos` (`Video_ID`),
  ADD CONSTRAINT `comments_vid_ibfk_2` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`Post_ID`) REFERENCES `posts` (`Post_ID`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `likes_events`
--
ALTER TABLE `likes_events`
  ADD CONSTRAINT `likes_events_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `events` (`Event_ID`),
  ADD CONSTRAINT `likes_events_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `likes_vid`
--
ALTER TABLE `likes_vid`
  ADD CONSTRAINT `likes_vid_ibfk_1` FOREIGN KEY (`Video_ID`) REFERENCES `videos` (`Video_ID`),
  ADD CONSTRAINT `likes_vid_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
