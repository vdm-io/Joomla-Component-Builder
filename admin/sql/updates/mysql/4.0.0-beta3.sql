ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_php_method_install` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_helper_site`;
ALTER TABLE `#__componentbuilder_joomla_component` ADD `php_method_install` MEDIUMTEXT NOT NULL AFTER `php_helper_site`;
