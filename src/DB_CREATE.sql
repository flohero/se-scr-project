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
    `id`       INT          NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45)  NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE
)
    ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `product_rating`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product_rating`.`categories`;

CREATE TABLE IF NOT EXISTS `product_rating`.`categories`
(
    `id`   INT         NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE
)
    ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `product_rating`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product_rating`.`products`;

CREATE TABLE IF NOT EXISTS `product_rating`.`products`
(
    `id`           INT           NOT NULL AUTO_INCREMENT,
    `userId`       INT           NOT NULL,
    `categoryId`     INT           NOT NULL,
    `name`         VARCHAR(255)  NOT NULL,
    `manufacturer` VARCHAR(255)  NOT NULL,
    `description`  VARCHAR(1000) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_products_users_idx` (`userId` ASC) VISIBLE,
    CONSTRAINT `fk_products_users`
        FOREIGN KEY (`userId`)
            REFERENCES `product_rating`.`users` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_products_categories`
            FOREIGN KEY (`categoryId`)
            REFERENCES `product_rating`.`categories` (`id`)
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
    `id`        INT           NOT NULL AUTO_INCREMENT,
    `productId` INT           NOT NULL,
    `userId`    INT           NOT NULL,
    `score`     INT           NOT NULL,
    `created`   DATETIME      NOT NULL DEFAULT NOW(),
    `title`     VARCHAR(255)  NULL,
    `content`   VARCHAR(1000) NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_ratings_products1_idx` (`productId` ASC) VISIBLE,
    INDEX `fk_ratings_users1_idx` (`userId` ASC) VISIBLE,
    CONSTRAINT `fk_ratings_products1`
        FOREIGN KEY (`productId`)
            REFERENCES `product_rating`.`products` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_ratings_users1`
        FOREIGN KEY (`userId`)
            REFERENCES `product_rating`.`users` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB;


SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
