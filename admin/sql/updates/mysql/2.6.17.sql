ALTER TABLE `#__componentbuilder_joomla_component` ADD `dashboard` VARCHAR(64) NOT NULL DEFAULT '' AFTER `css_site`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `dashboard_type` TINYINT(1) NOT NULL DEFAULT 1 AFTER `dashboard`;

UPDATE `#__componentbuilder_joomla_component` SET `dashboard_type`=1;
