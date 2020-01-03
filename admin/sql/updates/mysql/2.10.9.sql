ALTER TABLE `#__componentbuilder_joomla_component` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `export_key`;

ALTER TABLE `#__componentbuilder_joomla_module` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `fields`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `fields`;

ALTER TABLE `#__componentbuilder_admin_view` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `description`;

ALTER TABLE `#__componentbuilder_custom_admin_view` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `dynamic_get`;

ALTER TABLE `#__componentbuilder_site_view` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `dynamic_get`;

ALTER TABLE `#__componentbuilder_dynamic_get` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `group`;

ALTER TABLE `#__componentbuilder_class_property` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `extension_type`;

ALTER TABLE `#__componentbuilder_class_method` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `extension_type`;

ALTER TABLE `#__componentbuilder_library` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `description`;

ALTER TABLE `#__componentbuilder_snippet` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `description`;

ALTER TABLE `#__componentbuilder_field` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `fieldtype`;

ALTER TABLE `#__componentbuilder_fieldtype` ADD `guid` VARCHAR(36) NOT NULL DEFAULT '' AFTER `description`;
