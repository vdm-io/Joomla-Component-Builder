ALTER TABLE `#__componentbuilder_admin_view` ADD `add_php_document` TINYINT( 1 ) NOT NULL AFTER `add_php_before_delete` ,
ADD `php_document` MEDIUMTEXT NOT NULL AFTER `php_before_delete` ;
