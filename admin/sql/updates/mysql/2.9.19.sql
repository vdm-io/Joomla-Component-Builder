ALTER TABLE `#__componentbuilder_admin_view` ADD `add_php_after_cancel` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_javascript_views_footer`;

ALTER TABLE `#__componentbuilder_admin_view` ADD `php_after_cancel` MEDIUMTEXT NOT NULL AFTER `name_single`;
