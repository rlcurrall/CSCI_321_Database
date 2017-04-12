-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2017 at 05:26 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scroll_lock`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `characterID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `userID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `gameID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `descritpion` varchar(255) DEFAULT NULL,
  `dm_userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`gameID`, `name`, `descritpion`, `dm_userID`) VALUES
(1, 'Jeremy''s Boogaloo', 'A world where the elements have turned against humanity. A group of brave adventurers quest to restore balance to the world.', 2),
(2, 'The Doom of Rivendell', 'A new threat has risen and destroyed Rivendell.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `game_log`
--

CREATE TABLE `game_log` (
  `logID` int(11) NOT NULL,
  `date` date NOT NULL,
  `descritpion` varchar(255) DEFAULT NULL,
  `gameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `password`) VALUES
(1, 'rlcurrall', 'rlcurrall@gmail.com', 'pqyc9ILg'),
(2, 'jsuarez', 'jsuarez@email.uscb.edu', 'ranDom'),
(3, 'lnichols', 'lnichols@email.uscb.edu', 'briX'),
(4, 'cgriffin', 'cgriffin@email.uscb.edu', 'cgriffin');

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
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `fk_games_users1_idx` (`dm_userID`);

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
  MODIFY `characterID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `gameID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `game_log`
--
ALTER TABLE `game_log`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  ADD CONSTRAINT `fk_users_game1` FOREIGN KEY (`dm_userID`) REFERENCES `users` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `game_log`
--
ALTER TABLE `game_log`
  ADD CONSTRAINT `fk_gameLog_game1` FOREIGN KEY (`gameID`) REFERENCES `games` (`gameID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
