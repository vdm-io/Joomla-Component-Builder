ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_jcb_powers_path` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_javascript`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `jcb_powers_path` VARCHAR(255) NOT NULL DEFAULT '' AFTER `javascript`;
