-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
-- -----------------------------------------------------
-- Schema bookverse
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bookverse` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `bookverse` ;

-- -----------------------------------------------------
-- Table `bookverse`.`customers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookverse`.`customers` (
  `customer_id` INT NOT NULL AUTO_INCREMENT,
  `customer_lname` VARCHAR(50) NOT NULL,
  `customer_fname` VARCHAR(50) NULL DEFAULT NULL,
  `customer_number` VARCHAR(50) NOT NULL,
  `customer_email` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `registration_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`),
  UNIQUE INDEX `customer_email` (`customer_email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `bookverse`.`purchases`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookverse`.`purchases` (
  `purchases_id` INT NOT NULL AUTO_INCREMENT,
  `customer_id` INT NULL DEFAULT NULL,
  `book_id` VARCHAR(24) NULL DEFAULT NULL,
  `purchase_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`purchases_id`),
  INDEX `customer_id` (`customer_id` ASC) VISIBLE,
  CONSTRAINT `purchases_ibfk_1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `bookverse`.`customers` (`customer_id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `bookverse`.`bookmark`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookverse`.`bookmark` (
  `customer_id` INT NOT NULL,
  `book_id` VARCHAR(24) NOT NULL,
  PRIMARY KEY (`customer_id`, `book_id`),
  INDEX `customer_id` (`customer_id` ASC) VISIBLE,
  INDEX `book_id` (`book_id` ASC) VISIBLE,
  CONSTRAINT `preferences_ibfk_1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `bookverse`.`customers` (`customer_id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
