ALTER TABLE `#__componentbuilder_component` ADD `add_php_dashboard_methods` TINYINT( 1 ) NOT NULL AFTER `add_sales_server` ,
ADD `php_dashboard_methods` MEDIUMTEXT NOT NULL AFTER `add_php_dashboard_methods` ,
ADD `dashboard_tab` TEXT NOT NULL AFTER `php_dashboard_methods` ;
