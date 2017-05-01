-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2017 at 05:03 PM
-- Server version: 5.7.18-0ubuntu0.16.10.1
-- PHP Version: 7.0.15-0ubuntu0.16.10.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rcurrall`
--
CREATE DATABASE IF NOT EXISTS `rcurrall` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `rcurrall`;

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

DROP TABLE IF EXISTS `characters`;
CREATE TABLE `characters` (
  `characterID` int(11) NOT NULL,
  `characterName` varchar(45) NOT NULL,
  `background` text,
  `userID` int(11) NOT NULL,
  `gameID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`characterID`, `characterName`, `background`, `userID`, `gameID`) VALUES
(1, 'Gieve', 'Born in the small town of Egnapon, Geive grew up as the son of an architect but dreamed of being a traveling musician.', 1, 1),
(2, 'Brix', 'A Drunken dwarf from the Iron Hills, Brix hates goblin\'s and wants to defeat the goblin king.', 3, 1),
(3, 'Osbourn', 'Osbourn is short.', 4, 1),
(9, 'Daniel Craig', 'Shoots guns,  gets the ladies. You wish you were him.', 1, 1),
(21, 'Tester', 'Making a test character to add to a game to test the remove button', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `gameID` int(11) NOT NULL,
  `gameName` varchar(45) NOT NULL,
  `description` text,
  `adminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`gameID`, `gameName`, `description`, `adminID`) VALUES
(1, 'Jeremy\'s Boogaloo', 'A world where the elements have turned against humanity, a group of adventurers seek to restore the balance.', 2),
(2, 'The Doom of Rivendell', 'A new threat has risen and destroyed Rivendell.', 2),
(8, 'Langnour', 'A quiet town, near the ocean where nothing happens. Edited.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `game_log`
--

DROP TABLE IF EXISTS `game_log`;
CREATE TABLE `game_log` (
  `logID` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `game_log`
--

INSERT INTO `game_log` (`logID`, `date`, `description`, `gameID`) VALUES
(1, '2017-04-05', 'Brix was turned into a giant and drank all the whiskey at the local distillery! Gieve learned how to play the flute, and Osbourn bought a new knife.', 1),
(2, '2017-04-12', 'Brix and Osbourn fought over a pint of beer while Gieve bartered with the merchant for a painting.', 1),
(4, '2017-04-19', 'Nothing happened this week, the session was cancelled.\r\n', 1),
(8, '2017-04-27', 'Edit successful', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) DEFAULT 'Anonymous'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `password`, `name`) VALUES
(1, 'rlcurrall', 'rlcurrall@gmail.com', 'pqyc9ILg', 'Robert Currall'),
(2, 'jsuarez', 'jsuarez@email.uscb.edu', 'ranDom', 'Jeremy Suarez'),
(3, 'lnichols', 'lnichols@email.uscb.edu', 'briX', 'Logan Nichols'),
(4, 'cgriffin', 'cgriffin@email.uscb.edu', 'cgriffin', 'Anonymous'),
(5, 'test', 'test@test.com', 'test', 'test user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`characterID`),
  ADD KEY `fk_characters_users1_idx` (`userID`),
  ADD KEY `fk_characters_game1_idx` (`gameID`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`gameID`),
  ADD UNIQUE KEY `gameID` (`gameID`),
  ADD UNIQUE KEY `name` (`gameName`),
  ADD KEY `fk_games_users1_idx` (`adminID`);

--
-- Indexes for table `game_log`
--
ALTER TABLE `game_log`
  ADD PRIMARY KEY (`logID`),
  ADD KEY `fk_gameLog_game1_idx` (`gameID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userID` (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `characterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `gameID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `game_log`
--
ALTER TABLE `game_log`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `fk_characters_game1` FOREIGN KEY (`gameID`) REFERENCES `games` (`gameID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_characters_users1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `fk_users_game1` FOREIGN KEY (`adminID`) REFERENCES `users` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `game_log`
--
ALTER TABLE `game_log`
  ADD CONSTRAINT `fk_gameLog_game1` FOREIGN KEY (`gameID`) REFERENCES `games` (`gameID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

GRANT SELECT, INSERT, DELETE, UPDATE
ON rcurrall.*
TO mgs_user@localhost
IDENTIFIED BY 'pa55word';
