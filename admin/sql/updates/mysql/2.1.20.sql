ALTER TABLE `#__componentbuilder_admin_view` ADD `add_custom_button` INT(1) NOT NULL DEFAULT '0' AFTER `add_css_views`,
ADD `custom_button` TEXT NOT NULL AFTER `css_views`,
ADD `php_controller` MEDIUMTEXT NOT NULL AFTER `php_before_publish`,
ADD `php_model` MEDIUMTEXT NOT NULL AFTER `php_import_setdata`;
