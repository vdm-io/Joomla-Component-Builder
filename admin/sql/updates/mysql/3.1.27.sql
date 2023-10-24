ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_backup_folder_path` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_admin_event`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_git_folder_path` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_email_helper`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `backup_folder_path` VARCHAR(255) NOT NULL DEFAULT '' AFTER `author`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `git_folder_path` VARCHAR(255) NOT NULL DEFAULT '' AFTER `export_key`;
