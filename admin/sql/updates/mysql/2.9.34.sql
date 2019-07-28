ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_php_method_uninstall` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_head`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_php_postflight_install` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_method_uninstall`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_php_postflight_update` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_postflight_install`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_php_preflight_install` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_postflight_update`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_php_preflight_uninstall` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_preflight_install`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_php_preflight_update` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_preflight_uninstall`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_sales_server` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_preflight_update`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_sql` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_sales_server`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_sql_uninstall` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_sql`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_update_server` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_sql_uninstall`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `addreadme` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_update_server`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `php_method_uninstall` MEDIUMTEXT NOT NULL AFTER `name`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `php_postflight_install` MEDIUMTEXT NOT NULL AFTER `php_method_uninstall`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `php_postflight_update` MEDIUMTEXT NOT NULL AFTER `php_postflight_install`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `php_preflight_install` MEDIUMTEXT NOT NULL AFTER `php_postflight_update`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `php_preflight_uninstall` MEDIUMTEXT NOT NULL AFTER `php_preflight_install`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `php_preflight_update` MEDIUMTEXT NOT NULL AFTER `php_preflight_uninstall`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `readme` TEXT NOT NULL AFTER `property_selection`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `sales_server` INT(11) NOT NULL DEFAULT 0 AFTER `readme`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `sql` MEDIUMTEXT NOT NULL AFTER `sales_server`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `sql_uninstall` MEDIUMTEXT NOT NULL AFTER `sql`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `update_server` INT(11) NOT NULL DEFAULT 0 AFTER `system_name`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `update_server_target` TINYINT(1) NOT NULL DEFAULT 0 AFTER `update_server`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `update_server_url` VARCHAR(255) NOT NULL DEFAULT '' AFTER `update_server_target`;

CREATE TABLE IF NOT EXISTS `#__componentbuilder_joomla_plugin_files_folders_urls` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`addfiles` TEXT NOT NULL,
	`addfilesfullpath` TEXT NOT NULL,
	`addfolders` TEXT NOT NULL,
	`addfoldersfullpath` TEXT NOT NULL,
	`addurls` TEXT NOT NULL,
	`joomla_plugin` INT(11) NOT NULL DEFAULT 0,
	`params` text NOT NULL,
	`published` TINYINT(3) NOT NULL DEFAULT 1,
	`created_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`modified_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`checked_out` int(11) unsigned NOT NULL DEFAULT 0,
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`version` INT(10) unsigned NOT NULL DEFAULT 1,
	`hits` INT(10) unsigned NOT NULL DEFAULT 0,
	`access` INT(10) unsigned NOT NULL DEFAULT 0,
	`ordering` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`),
	KEY `idx_joomla_plugin` (`joomla_plugin`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
