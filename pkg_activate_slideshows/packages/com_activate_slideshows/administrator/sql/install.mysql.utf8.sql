CREATE TABLE IF NOT EXISTS `#__activate_slideshows_slideshows` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL ,
`created_by` INT(11)  NOT NULL ,
`title` VARCHAR(100)  NOT NULL ,
`description` TEXT NOT NULL ,
`creation` DATETIME NOT NULL ,
`exluded` VARCHAR(255)  NOT NULL ,
`tags` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

