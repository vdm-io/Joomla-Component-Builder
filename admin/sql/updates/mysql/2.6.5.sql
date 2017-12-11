ALTER TABLE `#__componentbuilder_site_view` ADD `libraries` TEXT NOT NULL AFTER `js_document`;

ALTER TABLE `#__componentbuilder_template` ADD `libraries` TEXT NOT NULL AFTER `dynamic_get`;

ALTER TABLE `#__componentbuilder_layout` ADD `libraries` TEXT NOT NULL AFTER `layout`;

ALTER TABLE `#__componentbuilder_custom_admin_view` ADD `libraries` TEXT NOT NULL AFTER `js_document`;

DROP TABLE IF EXISTS `#__componentbuilder_library`;

CREATE TABLE IF NOT EXISTS `#__componentbuilder_library_config` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`addconfig` TEXT NOT NULL,
	`library` INT(11) NOT NULL DEFAULT 0,
	`params` text NOT NULL DEFAULT '',
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
	KEY `idx_library` (`library`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__componentbuilder_library_files_folders_urls` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`addfiles` TEXT NOT NULL,
	`addfolders` TEXT NOT NULL,
	`addurls` TEXT NOT NULL,
	`library` INT(11) NOT NULL DEFAULT 0,
	`params` text NOT NULL DEFAULT '',
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
	KEY `idx_library` (`library`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__componentbuilder_library` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`addconditions` MEDIUMTEXT NOT NULL,
	`description` VARCHAR(255) NOT NULL DEFAULT '',
	`how` TINYINT(1) NOT NULL DEFAULT 1,
	`libraries` TEXT NOT NULL,
	`name` VARCHAR(255) NOT NULL DEFAULT '',
	`not_required` INT(1) NOT NULL DEFAULT 0,
	`php_setdocument` MEDIUMTEXT NOT NULL,
	`type` TINYINT(1) NOT NULL DEFAULT 0,
	`params` text NOT NULL DEFAULT '',
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
	KEY `idx_name` (`name`),
	KEY `idx_how` (`how`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__componentbuilder_library` (`id`, `addconditions`, `description`, `type`, `how`, `name`, `php_setdocument`, `published`, `created`, `modified`, `version`, `hits`, `ordering`) VALUES
(1, '', '', 1, '', 'No Library', '', 1, '2017-11-11 22:08:33', '2017-12-08 15:51:34', 4, '', 1),
(2, '', '', 1, 1, 'Bootstrap v4', '', 1, '2017-11-12 02:08:39', '2017-12-10 15:09:48', 14, '', 2),
(3, '', '', 1, 1, 'Uikit v3', '', 1, '2017-11-11 22:08:45', '2017-12-10 15:55:35', 18, '', 3),
(4, '', '', 1, 4, 'Uikit v2', '', 1, '2017-11-11 22:08:51', '2017-12-10 15:53:17', 5, '', 4),
(5, '', '', 1, 4, 'FooTable v2', '', 1, '2017-11-11 22:08:57', '2017-12-11 20:07:32', 9, '', 5),
(6, '', '', 1, 4, 'FooTable v3', '', 1, '2017-11-25 22:11:03', '2017-12-10 15:54:45', 12, '', 6);

INSERT INTO `#__componentbuilder_library_files_folders_urls` (`id`, `addfiles`, `addfolders`, `addurls`, `library`, `params`, `published`, `created`, `modified`, `version`, `hits`, `ordering`) VALUES
(2, '', '', '{\"addurls0\":{\"url\":\"https:\\/\\/maxcdn.bootstrapcdn.com\\/bootstrap\\/4.0.0-alpha.6\\/js\\/bootstrap.min.js\",\"type\":\"1\"},\"addurls1\":{\"url\":\"https:\\/\\/maxcdn.bootstrapcdn.com\\/bootstrap\\/4.0.0-alpha.6\\/css\\/bootstrap.min.css\",\"type\":\"1\"}}', 2, '', 1, '2017-11-25 16:17:36', '2017-11-26 20:48:33', 6, '', 2),
(3, '', '', '{\"addurls0\":{\"url\":\"https:\\/\\/cdnjs.cloudflare.com\\/ajax\\/libs\\/uikit\\/3.0.0-beta.35\\/js\\/uikit.min.js\",\"type\":\"2\"},\"addurls1\":{\"url\":\"https:\\/\\/cdnjs.cloudflare.com\\/ajax\\/libs\\/uikit\\/3.0.0-beta.35\\/js\\/uikit-icons.min.js\",\"type\":\"2\"},\"addurls2\":{\"url\":\"https:\\/\\/cdnjs.cloudflare.com\\/ajax\\/libs\\/uikit\\/3.0.0-beta.35\\/css\\/uikit.min.css\",\"type\":\"2\"}}', 3, '', 1, '2017-11-25 21:47:40', '2017-12-10 15:09:17', 7, '', 3);

UPDATE `#__componentbuilder_site_view` SET `snippet` = 0;
UPDATE `#__componentbuilder_template` SET `snippet` = 0;
UPDATE `#__componentbuilder_layout` SET `snippet` = 0;
UPDATE `#__componentbuilder_custom_admin_view` SET `snippet` = 0;
