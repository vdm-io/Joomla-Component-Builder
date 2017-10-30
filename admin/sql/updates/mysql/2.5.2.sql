ALTER TABLE `#__componentbuilder_admin_view` ADD `add_php_before_save` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_before_publish`;

ALTER TABLE `#__componentbuilder_admin_view` ADD `php_before_save` MEDIUMTEXT NOT NULL AFTER `php_before_publish`;
