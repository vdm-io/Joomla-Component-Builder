ALTER TABLE `#__componentbuilder_power` ADD `add_licensing_template` TINYINT(1) NOT NULL DEFAULT 1 AFTER `add_head`;
ALTER TABLE `#__componentbuilder_power` ADD `licensing_template` TEXT NOT NULL AFTER `implements_custom`;
