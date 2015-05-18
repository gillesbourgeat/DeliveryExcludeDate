
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- delivery_exclude_date
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `delivery_exclude_date`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `date` DATE NOT NULL,
    `active` TINYINT DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- delivery_exclude_date_i18n
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `delivery_exclude_date_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` VARCHAR(255),
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `delivery_exclude_date_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `delivery_exclude_date` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
