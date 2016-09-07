ALTER TABLE `#__componentbuilder_admin_view` ADD `add_php_before_publish` TINYINT(1) NOT NULL DEFAULT '0' AFTER `add_php_before_delete`;
ALTER TABLE `#__componentbuilder_admin_view` ADD `php_before_publish` MEDIUMTEXT NOT NULL AFTER `php_before_delete`;
ALTER TABLE `#__componentbuilder_admin_view` ADD `add_php_after_publish` TINYINT(1) NOT NULL DEFAULT '0' AFTER `add_php_after_delete`;
ALTER TABLE `#__componentbuilder_admin_view` ADD `php_after_publish` MEDIUMTEXT NOT NULL AFTER `php_after_delete`;
