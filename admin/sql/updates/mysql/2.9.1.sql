ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_menu_prefix` CHAR(1) NOT NULL DEFAULT '' AFTER `add_license`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `menu_prefix` VARCHAR(100) NOT NULL DEFAULT '' AFTER `license_type`;
