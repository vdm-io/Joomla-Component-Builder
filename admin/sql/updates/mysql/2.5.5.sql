ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_javascript` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_email_helper`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `javascript` TEXT NOT NULL AFTER `image`;
