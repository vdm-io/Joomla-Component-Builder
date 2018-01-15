ALTER TABLE `#__componentbuilder_custom_admin_view` ADD `add_php_ajax` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_js_document`;

ALTER TABLE `#__componentbuilder_custom_admin_view` ADD `ajax_input` TEXT NOT NULL AFTER `add_php_view`;

ALTER TABLE `#__componentbuilder_custom_admin_view` ADD `php_ajaxmethod` MEDIUMTEXT NOT NULL AFTER `not_required`;

ALTER TABLE `#__componentbuilder_joomla_component` CHANGE `css` `css_admin` TEXT NOT NULL;

ALTER TABLE `#__componentbuilder_joomla_component` CHANGE `add_css` `add_css_admin` TINYINT(1) NOT NULL DEFAULT 0 ;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `add_css_site` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_css_admin`;

ALTER TABLE `#__componentbuilder_joomla_component` ADD `css_site` TEXT NOT NULL AFTER `css_admin`;
