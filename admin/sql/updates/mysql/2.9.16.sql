ALTER TABLE `#__componentbuilder_joomla_component` ADD `crowdin_account_api_key` TEXT NOT NULL AFTER `creatuserhelper`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `crowdin_project_api_key` TEXT NOT NULL AFTER `crowdin_account_api_key`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `crowdin_project_identifier` VARCHAR(255) NOT NULL DEFAULT '' AFTER `crowdin_project_api_key`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `crowdin_username` TEXT NOT NULL AFTER `crowdin_project_identifier`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `translation_tool` TINYINT(1) NOT NULL DEFAULT 0 AFTER `toignore`;
