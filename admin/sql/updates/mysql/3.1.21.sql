ALTER TABLE `#__componentbuilder_power` ADD `approved` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_licensing_template`;
ALTER TABLE `#__componentbuilder_power` ADD `approved_paths` TEXT NOT NULL AFTER `approved`;
