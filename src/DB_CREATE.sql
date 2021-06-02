-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE =
        'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema product_rating
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `product_rating`;
-- -----------------------------------------------------
-- Schema product_rating
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `product_rating`;
USE `product_rating`;

-- -----------------------------------------------------
-- Table `product_rating`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product_rating`.`users`;

CREATE TABLE IF NOT EXISTS `product_rating`.`users`
(
    `u_id`     INT          NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45)  NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`u_id`),
    UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE
)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `product_rating`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product_rating`.`products`;

CREATE TABLE IF NOT EXISTS `product_rating`.`products`
(
    `p_id`         INT           NOT NULL AUTO_INCREMENT,
    `u_id`         INT           NOT NULL,
    `name`         VARCHAR(255)  NOT NULL,
    `manufacturer` VARCHAR(255)  NOT NULL,
    `description`  VARCHAR(1000) NOT NULL,
    PRIMARY KEY (`p_id`),
    INDEX `fk_products_users_idx` (`u_id` ASC) VISIBLE,
    CONSTRAINT `fk_products_users`
        FOREIGN KEY (`u_id`)
            REFERENCES `product_rating`.`users` (`u_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `product_rating`.`ratings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product_rating`.`ratings`;

CREATE TABLE IF NOT EXISTS `product_rating`.`ratings`
(
    `r_id`    INT           NOT NULL AUTO_INCREMENT,
    `p_id`    INT           NOT NULL,
    `u_id`    INT           NOT NULL,
    `score`   FLOAT         NOT NULL,
    `title`   VARCHAR(255)  NULL,
    `content` VARCHAR(1000) NULL,
    PRIMARY KEY (`r_id`),
    INDEX `fk_ratings_products1_idx` (`p_id` ASC) VISIBLE,
    INDEX `fk_ratings_users1_idx` (`u_id` ASC) VISIBLE,
    CONSTRAINT `fk_ratings_products1`
        FOREIGN KEY (`p_id`)
            REFERENCES `product_rating`.`products` (`p_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_ratings_users1`
        FOREIGN KEY (`u_id`)
            REFERENCES `product_rating`.`users` (`u_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB;


SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
