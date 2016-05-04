ALTER TABLE `#__componentbuilder_admin_view` ADD `add_custom_import` TINYINT( 1 ) NOT NULL AFTER `add_css_views`,
ADD `php_import_save` MEDIUMTEXT NOT NULL AFTER `php_getlistquery`,
ADD `php_import_setdata` MEDIUMTEXT NOT NULL AFTER `php_import_save`,
ADD `html_import_view` MEDIUMTEXT NOT NULL AFTER `description` ;
