CREATE TABLE IF NOT EXISTS `#__componentbuilder_component_modules` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`addjoomla_modules` TEXT NOT NULL,
	`joomla_component` INT(11) NOT NULL DEFAULT 0,
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
	KEY `idx_joomla_component` (`joomla_component`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

ALTER TABLE `#__componentbuilder_joomla_module` CHANGE `add_abstract_class_helper` `add_class_helper` TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE `#__componentbuilder_joomla_module` CHANGE `add_custom_abstract_class_helper_header` `add_class_helper_header` TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE `#__componentbuilder_joomla_module` CHANGE `abstract_class_helper_code` `class_helper_code` MEDIUMTEXT NOT NULL;

ALTER TABLE `#__componentbuilder_joomla_module` CHANGE `abstract_class_helper_header` `class_helper_header` TEXT NOT NULL;
