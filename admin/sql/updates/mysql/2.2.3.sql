ALTER TABLE `#__componentbuilder_component` ADD `add_php_helper_both` TINYINT(1) NOT NULL DEFAULT '0' AFTER `add_php_helper_admin`,
ADD `php_helper_both` MEDIUMTEXT NOT NULL AFTER `php_helper_admin`;
