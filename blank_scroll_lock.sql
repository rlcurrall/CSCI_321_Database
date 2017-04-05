-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema scroll_lock
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema scroll_lock
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `scroll_lock` DEFAULT CHARACTER SET utf8 ;
USE `scroll_lock` ;

-- -----------------------------------------------------
-- Table `scroll_lock`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `scroll_lock`.`users` (
  `userID` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`userID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scroll_lock`.`games`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `scroll_lock`.`games` (
  `gameID` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `descritpion` VARCHAR(255) NULL,
  `dm_userID` INT NOT NULL,
  PRIMARY KEY (`gameID`),
  INDEX `fk_games_users1_idx` (`dm_userID` ASC),
  CONSTRAINT `fk_games_users1`
    FOREIGN KEY (`dm_userID`)
    REFERENCES `scroll_lock`.`users` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scroll_lock`.`characters`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `scroll_lock`.`characters` (
  `characterID` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `userID` INT NOT NULL,
  `gameID` INT NOT NULL,
  PRIMARY KEY (`characterID`),
  INDEX `fk_characters_users1_idx` (`userID` ASC),
  INDEX `fk_characters_games1_idx` (`gameID` ASC),
  CONSTRAINT `fk_characters_users1`
    FOREIGN KEY (`userID`)
    REFERENCES `scroll_lock`.`users` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_characters_games1`
    FOREIGN KEY (`gameID`)
    REFERENCES `scroll_lock`.`games` (`gameID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scroll_lock`.`game_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `scroll_lock`.`game_log` (
  `logID` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `descritpion` VARCHAR(255) NULL,
  `gameID` INT NOT NULL,
  PRIMARY KEY (`logID`),
  INDEX `fk_game_log_games1_idx` (`gameID` ASC),
  CONSTRAINT `fk_game_log_games1`
    FOREIGN KEY (`gameID`)
    REFERENCES `scroll_lock`.`games` (`gameID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scroll_lock`.`loot_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `scroll_lock`.`loot_log` (
  `lootID` INT NOT NULL AUTO_INCREMENT,
  `item_name` VARCHAR(45) NOT NULL,
  `descritpion` VARCHAR(255) NULL,
  `characters_userID` INT NOT NULL,
  `logID` INT NOT NULL,
  `characterID` INT NOT NULL,
  PRIMARY KEY (`lootID`),
  INDEX `fk_loot_log_game_log1_idx` (`logID` ASC),
  INDEX `fk_loot_log_characters1_idx` (`characterID` ASC),
  CONSTRAINT `fk_loot_log_game_log1`
    FOREIGN KEY (`logID`)
    REFERENCES `scroll_lock`.`game_log` (`logID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_loot_log_characters1`
    FOREIGN KEY (`characterID`)
    REFERENCES `scroll_lock`.`characters` (`characterID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `scroll_lock`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `scroll_lock`.`posts` (
  `postID` INT NOT NULL AUTO_INCREMENT,
  `content` TEXT(140) NOT NULL,
  `gameID` INT NOT NULL,
  `userID` INT NOT NULL,
  PRIMARY KEY (`postID`),
  INDEX `fk_posts_games1_idx` (`gameID` ASC),
  INDEX `fk_posts_users1_idx` (`userID` ASC),
  CONSTRAINT `fk_posts_games1`
    FOREIGN KEY (`gameID`)
    REFERENCES `scroll_lock`.`games` (`gameID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_posts_users1`
    FOREIGN KEY (`userID`)
    REFERENCES `scroll_lock`.`users` (`userID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
