RENAME TABLE `#__componentbuilder_ftp` to `#__componentbuilder_server`;

ALTER TABLE `#__componentbuilder_server` ADD `host` TEXT NOT NULL AFTER `asset_id`;
ALTER TABLE `#__componentbuilder_server` ADD `authentication` TINYINT(1) NOT NULL DEFAULT 0 AFTER `asset_id`;
ALTER TABLE `#__componentbuilder_server` ADD `password` TEXT NOT NULL AFTER `name`;
ALTER TABLE `#__componentbuilder_server` ADD `path` TEXT NOT NULL AFTER `password`;
ALTER TABLE `#__componentbuilder_server` ADD `port` TEXT NOT NULL AFTER `path`;
ALTER TABLE `#__componentbuilder_server` ADD `private` TEXT NOT NULL AFTER `port`;
ALTER TABLE `#__componentbuilder_server` ADD `protocol` TINYINT(1) NOT NULL DEFAULT 0 AFTER `private`;
ALTER TABLE `#__componentbuilder_server` ADD `secret` TEXT NOT NULL AFTER `protocol`;
ALTER TABLE `#__componentbuilder_server` ADD `username` TEXT NOT NULL AFTER `signature`;

ALTER TABLE `#__componentbuilder_component_files_folders` ADD `addfilesfullpath` TEXT NOT NULL AFTER `addfiles`;
ALTER TABLE `#__componentbuilder_component_files_folders` ADD `addfoldersfullpath` TEXT NOT NULL AFTER `addfolders`;
ALTER TABLE `#__componentbuilder_library_files_folders_urls` ADD `addfilesfullpath` TEXT NOT NULL AFTER `addfiles`;
ALTER TABLE `#__componentbuilder_library_files_folders_urls` ADD `addfoldersfullpath` TEXT NOT NULL AFTER `addfolders`;

ALTER TABLE `#__componentbuilder_joomla_component` CHANGE `update_server` `update_server_url` VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `#__componentbuilder_joomla_component` CHANGE `sales_server_ftp` `sales_server` INT(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__componentbuilder_joomla_component` CHANGE `update_server_ftp` `update_server` INT(11) NOT NULL DEFAULT 0;

UPDATE `#__componentbuilder_server` SET `protocol` = 1;
