ALTER TABLE `#__componentbuilder_admin_view` ADD `add_php_before_cancel` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_batchmove`;

ALTER TABLE `#__componentbuilder_admin_view` ADD `php_before_cancel` MEDIUMTEXT NOT NULL AFTER `php_batchmove`;
