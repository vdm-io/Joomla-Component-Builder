ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_php_script_construct` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_preflight_update`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `description` TEXT NOT NULL AFTER `class_extends`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `php_script_construct` MEDIUMTEXT NOT NULL AFTER `php_preflight_update`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `plugin_version` CHAR(64) NOT NULL DEFAULT '' AFTER `php_script_construct`;

CREATE TABLE IF NOT EXISTS `#__componentbuilder_joomla_plugin_updates` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`joomla_plugin` INT(11) NOT NULL DEFAULT 0,
	`version_update` TEXT NOT NULL,
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
