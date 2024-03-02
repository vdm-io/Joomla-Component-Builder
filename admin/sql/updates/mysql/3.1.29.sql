ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_namespace_prefix` CHAR(1) NOT NULL DEFAULT '' AFTER `add_menu_prefix`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `namespace_prefix` VARCHAR(255) NOT NULL DEFAULT '' AFTER `name_code`;
