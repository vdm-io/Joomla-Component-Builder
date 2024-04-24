UPDATE `#__componentbuilder_admin_view`
SET `alias_builder_type` = 0
WHERE `alias_builder_type` = '';

UPDATE `#__componentbuilder_dynamic_get`
SET `addcalculation` = 0
WHERE `addcalculation` = '';

ALTER TABLE `#__componentbuilder_joomla_component` CHANGE `image` `image` VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `#__componentbuilder_admin_view` CHANGE `alias_builder_type` `alias_builder_type` TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE `#__componentbuilder_admin_view` CHANGE `icon` `icon` VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `#__componentbuilder_admin_view` CHANGE `icon_add` `icon_add` VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `#__componentbuilder_admin_view` CHANGE `icon_category` `icon_category` VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `#__componentbuilder_custom_admin_view` CHANGE `icon` `icon` VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE `#__componentbuilder_dynamic_get` CHANGE `addcalculation` `addcalculation` TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE `#__componentbuilder_component_updates` CHANGE `version_update` `version_update` MEDIUMTEXT NOT NULL;
ALTER TABLE `#__componentbuilder_joomla_module_updates` CHANGE `version_update` `version_update` MEDIUMTEXT NOT NULL;
ALTER TABLE `#__componentbuilder_joomla_plugin_updates` CHANGE `version_update` `version_update` MEDIUMTEXT NOT NULL;
