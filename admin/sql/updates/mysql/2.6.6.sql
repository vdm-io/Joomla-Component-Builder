ALTER TABLE `#__componentbuilder_custom_admin_view` ADD `add_javascript_file` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_custom_button`;

ALTER TABLE `#__componentbuilder_custom_admin_view` ADD `javascript_file` TEXT NOT NULL AFTER `icon`;

ALTER TABLE `#__componentbuilder_site_view` ADD `add_javascript_file` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_custom_button`;

ALTER TABLE `#__componentbuilder_site_view` ADD `javascript_file` TEXT NOT NULL AFTER `dynamic_get`;
