ALTER TABLE `#__componentbuilder_custom_admin_view` ADD `icon` CHAR(64) NOT NULL DEFAULT '' AFTER `dynamic_get`;
ALTER TABLE `#__componentbuilder_component` CHANGE `version_update` `version_update` MEDIUMTEXT NOT NULL;
