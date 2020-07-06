ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `add_head` TINYINT(1) NOT NULL DEFAULT 0 AFTER `asset_id`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `head` TEXT NOT NULL AFTER `fields`;

ALTER TABLE `#__componentbuilder_joomla_plugin` ADD `system_name` VARCHAR(255) NOT NULL DEFAULT '' AFTER `property_selection`;
