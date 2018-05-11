ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_sql_uninstall` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_sql`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `sql_uninstall` MEDIUMTEXT NOT NULL AFTER `sql`;
