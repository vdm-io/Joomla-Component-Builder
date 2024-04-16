CREATE TABLE IF NOT EXISTS `#__componentbuilder_joomla_power` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`description` TEXT NULL,
	`guid` VARCHAR(36) NOT NULL DEFAULT '',
	`settings` TEXT NOT NULL,
	`system_name` VARCHAR(255) NOT NULL DEFAULT '',
	`params` text NULL,
	`published` TINYINT(3) NOT NULL DEFAULT 1,
	`created_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`modified_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`modified` DATETIME DEFAULT NULL,
	`checked_out` int(11) unsigned NOT NULL DEFAULT 0,
	`checked_out_time` DATETIME DEFAULT NULL,
	`version` INT(10) unsigned NOT NULL DEFAULT 1,
	`hits` INT(10) unsigned NOT NULL DEFAULT 0,
	`access` INT(10) unsigned NOT NULL DEFAULT 0,
	`ordering` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`),
	KEY `idx_system_name` (`system_name`),
	KEY `idx_guid` (`guid`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
