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
	`php_preparedocument` MEDIUMTEXT NOT NULL,
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

INSERT INTO `#__componentbuilder_library` (`id`, `addconditions`, `description`, `how`, `name`, `php_preparedocument`, `php_setdocument`, `params`, `published`, `created`, `modified`, `version`, `hits`, `ordering`) VALUES
(1, '', '', '', 'No Library', '', '', '', 1, '2017-11-11 22:08:33', '2017-11-30 11:23:20', 3, '', 1),
(2, '', '', 1, 'Bootstrap v4', '', '', '', 1, '2017-11-12 02:08:39', '2017-11-30 11:23:20', 13, '', 2),
(3, '', '', 1, 'Uikit v3', '', '', '', 1, '2017-11-11 22:08:45', '2017-11-30 11:23:20', 6, '', 3),
(4, '', '', 3, 'Uikit v2', 'Ly8gc3RpbGwgd29ya2luZyBvbiB0aGlzIA==', 'Ly8gc3RpbGwgd29ya2luZyBvbiB0aGlzIA==', '', 1, '2017-11-11 22:08:51', '2017-11-30 11:23:20', 4, '', 4),
(5, '', '', 3, 'FooTable v2', 'CQkvLyBBZGQgdGhlIENTUyBmb3IgRm9vdGFibGUuDQoJCSR0aGlzLT5kb2N1bWVudC0+YWRkU3R5bGVTaGVldChKVVJJOjpyb290KCkgLidtZWRpYS9jb21fW1tbY29tcG9uZW50XV1dL2Zvb3RhYmxlMi9jc3MvZm9vdGFibGUuY29yZS5taW4uY3NzJyk7DQoNCgkJLy8gVXNlIHRoZSBNZXRybyBTdHlsZQ0KCQlpZiAoIWlzc2V0KCR0aGlzLT5mb29UYWJsZVN0eWxlKSB8fCAwID09ICR0aGlzLT5mb29UYWJsZVN0eWxlKQ0KCQl7DQoJCQkkdGhpcy0+ZG9jdW1lbnQtPmFkZFN0eWxlU2hlZXQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTIvY3NzL2Zvb3RhYmxlLm1ldHJvLm1pbi5jc3MnKTsNCgkJfQ0KCQkvLyBVc2UgdGhlIExlZ2FjeSBTdHlsZS4NCgkJZWxzZWlmIChpc3NldCgkdGhpcy0+Zm9vVGFibGVTdHlsZSkgJiYgMSA9PSAkdGhpcy0+Zm9vVGFibGVTdHlsZSkNCgkJew0KCQkJJHRoaXMtPmRvY3VtZW50LT5hZGRTdHlsZVNoZWV0KEpVUkk6OnJvb3QoKSAuJ21lZGlhL2NvbV9bW1tjb21wb25lbnRdXV0vZm9vdGFibGUyL2Nzcy9mb290YWJsZS5zdGFuZGFsb25lLm1pbi5jc3MnKTsNCgkJfQ0KDQoJCS8vIEFkZCB0aGUgSmF2YVNjcmlwdCBmb3IgRm9vdGFibGUNCgkJJHRoaXMtPmRvY3VtZW50LT5hZGRTY3JpcHQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTIvanMvZm9vdGFibGUuanMnKTsNCgkJJHRoaXMtPmRvY3VtZW50LT5hZGRTY3JpcHQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTIvanMvZm9vdGFibGUuc29ydC5qcycpOw0KCQkkdGhpcy0+ZG9jdW1lbnQtPmFkZFNjcmlwdChKVVJJOjpyb290KCkgLidtZWRpYS9jb21fW1tbY29tcG9uZW50XV1dL2Zvb3RhYmxlMi9qcy9mb290YWJsZS5maWx0ZXIuanMnKTsNCgkJJHRoaXMtPmRvY3VtZW50LT5hZGRTY3JpcHQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTIvanMvZm9vdGFibGUucGFnaW5hdGUuanMnKTsNCg0KCQkvLyB0byBpbml0aWF0ZSB0aGUgdGFibGUNCgkJJGZvb3RhYmxlID0gImpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7IGpRdWVyeShmdW5jdGlvbiAoKSB7IGpRdWVyeSgnLmZvb3RhYmxlJykuZm9vdGFibGUoKTt9KTt9KTsiOw0KCQkkdGhpcy0+ZG9jdW1lbnQtPmFkZFNjcmlwdERlY2xhcmF0aW9uKCRmb290YWJsZSk7IC8vIG1ha2Ugc3VyZSB0byBhZGQgdGhlIC5mb290YWJsZSBjbGFzcyB0byB0aGUgdGFibGU=', 'CQkvLyBBZGQgdGhlIENTUyBmb3IgRm9vdGFibGUuDQoJCSRkb2N1bWVudC0+YWRkU3R5bGVTaGVldChKVVJJOjpyb290KCkgLidtZWRpYS9jb21fW1tbY29tcG9uZW50XV1dL2Zvb3RhYmxlMi9jc3MvZm9vdGFibGUuY29yZS5taW4uY3NzJyk7DQoNCgkJLy8gVXNlIHRoZSBNZXRybyBTdHlsZQ0KCQlpZiAoIWlzc2V0KCR0aGlzLT5mb29UYWJsZVN0eWxlKSB8fCAwID09ICR0aGlzLT5mb29UYWJsZVN0eWxlKQ0KCQl7DQoJCQkkZG9jdW1lbnQtPmFkZFN0eWxlU2hlZXQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTIvY3NzL2Zvb3RhYmxlLm1ldHJvLm1pbi5jc3MnKTsNCgkJfQ0KCQkvLyBVc2UgdGhlIExlZ2FjeSBTdHlsZS4NCgkJZWxzZWlmIChpc3NldCgkdGhpcy0+Zm9vVGFibGVTdHlsZSkgJiYgMSA9PSAkdGhpcy0+Zm9vVGFibGVTdHlsZSkNCgkJew0KCQkJJGRvY3VtZW50LT5hZGRTdHlsZVNoZWV0KEpVUkk6OnJvb3QoKSAuJ21lZGlhL2NvbV9bW1tjb21wb25lbnRdXV0vZm9vdGFibGUyL2Nzcy9mb290YWJsZS5zdGFuZGFsb25lLm1pbi5jc3MnKTsNCgkJfQ0KDQoJCS8vIEFkZCB0aGUgSmF2YVNjcmlwdCBmb3IgRm9vdGFibGUNCgkJJGRvY3VtZW50LT5hZGRTY3JpcHQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTIvanMvZm9vdGFibGUuanMnKTsNCgkJJGRvY3VtZW50LT5hZGRTY3JpcHQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTIvanMvZm9vdGFibGUuc29ydC5qcycpOw0KCQkkZG9jdW1lbnQtPmFkZFNjcmlwdChKVVJJOjpyb290KCkgLidtZWRpYS9jb21fW1tbY29tcG9uZW50XV1dL2Zvb3RhYmxlMi9qcy9mb290YWJsZS5maWx0ZXIuanMnKTsNCgkJJGRvY3VtZW50LT5hZGRTY3JpcHQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTIvanMvZm9vdGFibGUucGFnaW5hdGUuanMnKTsNCg0KCQkvLyB0byBpbml0aWF0ZSB0aGUgdGFibGUNCgkJJGZvb3RhYmxlID0gImpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7IGpRdWVyeShmdW5jdGlvbiAoKSB7IGpRdWVyeSgnLmZvb3RhYmxlJykuZm9vdGFibGUoKTt9KTt9KTsiOw0KCQkkZG9jdW1lbnQtPmFkZFNjcmlwdERlY2xhcmF0aW9uKCRmb290YWJsZSk7IC8vIG1ha2Ugc3VyZSB0byBhZGQgdGhlIC5mb290YWJsZSBjbGFzcyB0byB0aGUgdGFibGU=', '', 1, '2017-11-11 22:08:57', '2017-11-30 11:23:20', 7, '', 5),
(6, '', '', 3, 'FooTable v3', 'CQkvLyBBZGQgdGhlIENTUyBmb3IgRm9vdGFibGUNCgkJJHRoaXMtPmRvY3VtZW50LT5hZGRTdHlsZVNoZWV0KCdodHRwczovL21heGNkbi5ib290c3RyYXBjZG4uY29tL2ZvbnQtYXdlc29tZS80LjUuMC9jc3MvZm9udC1hd2Vzb21lLm1pbi5jc3MnKTsNCgkJJHRoaXMtPmRvY3VtZW50LT5hZGRTdHlsZVNoZWV0KEpVUkk6OnJvb3QoKSAuJ21lZGlhL2NvbV9bW1tjb21wb25lbnRdXV0vZm9vdGFibGUzL2Nzcy9mb290YWJsZS5zdGFuZGFsb25lLm1pbi5jc3MnKTsNCgkJLy8gQWRkIHRoZSBKYXZhU2NyaXB0IGZvciBGb290YWJsZSAoYWRkaW5nIGFsbCBmdW50aW9ucykNCgkJJHRoaXMtPmRvY3VtZW50LT5hZGRTY3JpcHQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTMvanMvZm9vdGFibGUubWluLmpzJyk7DQoJCS8vIHRvIGluaXRpYXRlIHRoZSB0YWJsZQ0KCQkkZm9vdGFibGUgPSAialF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHsgalF1ZXJ5KGZ1bmN0aW9uICgpIHsgalF1ZXJ5KCcuZm9vdGFibGUnKS5mb290YWJsZSgpO30pO30pOyI7DQoJCSR0aGlzLT5kb2N1bWVudC0+YWRkU2NyaXB0RGVjbGFyYXRpb24oJGZvb3RhYmxlKTsgLy8gbWFrZSBzdXJlIHRvIGFkZCB0aGUgLmZvb3RhYmxlIGNsYXNzIHRvIHRoZSB0YWJsZQ==', 'CQkvLyBBZGQgdGhlIENTUyBmb3IgRm9vdGFibGUNCgkJJGRvY3VtZW50LT5hZGRTdHlsZVNoZWV0KCdodHRwczovL21heGNkbi5ib290c3RyYXBjZG4uY29tL2ZvbnQtYXdlc29tZS80LjUuMC9jc3MvZm9udC1hd2Vzb21lLm1pbi5jc3MnKTsNCgkJJGRvY3VtZW50LT5hZGRTdHlsZVNoZWV0KEpVUkk6OnJvb3QoKSAuJ21lZGlhL2NvbV9bW1tjb21wb25lbnRdXV0vZm9vdGFibGUzL2Nzcy9mb290YWJsZS5zdGFuZGFsb25lLm1pbi5jc3MnKTsNCgkJLy8gQWRkIHRoZSBKYXZhU2NyaXB0IGZvciBGb290YWJsZSAoYWRkaW5nIGFsbCBmdW50aW9ucykNCgkJJGRvY3VtZW50LT5hZGRTY3JpcHQoSlVSSTo6cm9vdCgpIC4nbWVkaWEvY29tX1tbW2NvbXBvbmVudF1dXS9mb290YWJsZTMvanMvZm9vdGFibGUubWluLmpzJyk7DQoJCS8vIHRvIGluaXRpYXRlIHRoZSB0YWJsZQ0KCQkkZm9vdGFibGUgPSAialF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHsgalF1ZXJ5KGZ1bmN0aW9uICgpIHsgalF1ZXJ5KCcuZm9vdGFibGUnKS5mb290YWJsZSgpO30pO30pOyI7DQoJCSRkb2N1bWVudC0+YWRkU2NyaXB0RGVjbGFyYXRpb24oJGZvb3RhYmxlKTsgLy8gbWFrZSBzdXJlIHRvIGFkZCB0aGUgLmZvb3RhYmxlIGNsYXNzIHRvIHRoZSB0YWJsZQ==', '', 1, '2017-11-25 22:11:03', '2017-11-30 11:23:20', 11, '', 6);

INSERT INTO `#__componentbuilder_library_config` (`id`, `addconfig`, `library`, `params`, `published`, `created`, `modified`, `version`, `hits`, `ordering`) VALUES
(1, '', 2, '', 1, '2017-11-25 02:59:38', '2017-11-26 20:48:15', 10, '', 1),
(2, '', 3, '', 1, '2017-11-25 21:51:25', '2017-11-25 21:58:48', 2, '', 2);

INSERT INTO `#__componentbuilder_library_files_folders_urls` (`id`, `addfiles`, `addfolders`, `addurls`, `library`, `params`, `published`, `created`, `modified`, `version`, `hits`, `ordering`) VALUES
(1, '', '{\"addfolders2\":{\"folder\":\"uikit\",\"path\":\"\\/media\\/\"}}', '', 4, '', 1, '2017-11-25 00:09:15', '2017-11-25 21:59:43', 7, '', 1),
(2, '', '', '{\"addurls0\":{\"url\":\"https:\\/\\/maxcdn.bootstrapcdn.com\\/bootstrap\\/4.0.0-alpha.6\\/js\\/bootstrap.min.js\",\"type\":\"1\"},\"addurls1\":{\"url\":\"https:\\/\\/maxcdn.bootstrapcdn.com\\/bootstrap\\/4.0.0-alpha.6\\/css\\/bootstrap.min.css\",\"type\":\"1\"}}', 2, '', 1, '2017-11-25 16:17:36', '2017-11-26 20:48:33', 6, '', 2),
(3, '', '', '{\"addurls1\":{\"url\":\"https:\\/\\/cdnjs.cloudflare.com\\/ajax\\/libs\\/uikit\\/3.0.0-beta.35\\/css\\/uikit.min.css\",\"type\":\"1\"},\"addurls2\":{\"url\":\"https:\\/\\/cdnjs.cloudflare.com\\/ajax\\/libs\\/uikit\\/3.0.0-beta.35\\/js\\/uikit.min.js\",\"type\":\"1\"},\"addurls3\":{\"url\":\"https:\\/\\/cdnjs.cloudflare.com\\/ajax\\/libs\\/uikit\\/3.0.0-beta.35\\/js\\/uikit-icons.min.js\",\"type\":\"1\"}}', 3, '', 1, '2017-11-25 21:47:40', '0000-00-00 00:00:00', 1, '', 3),
(4, '', '{\"addfolders0\":{\"folder\":\"footable2\",\"path\":\"\\/media\\/\"}}', '', 5, '', 1, '2017-11-25 22:00:43', '2017-11-25 22:13:15', 2, '', 4),
(5, '', '{\"addfolders1\":{\"folder\":\"footable3\",\"path\":\"\\/media\\/\"}}', '', 6, '', 1, '2017-11-25 22:12:42', '0000-00-00 00:00:00', 1, '', 5);

UPDATE `#__componentbuilder_site_view` SET `snippet` = 0 WHERE 1
UPDATE `#__componentbuilder_template` SET `snippet` = 0 WHERE 1
UPDATE `#__componentbuilder_layout` SET `snippet` = 0 WHERE 1
UPDATE `#__componentbuilder_custom_admin_view` SET `snippet` = 0 WHERE 1
