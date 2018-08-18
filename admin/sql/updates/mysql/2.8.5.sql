ALTER TABLE `#__componentbuilder_admin_view` ADD `add_php_allowadd` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_ajax`;

ALTER TABLE `#__componentbuilder_admin_view` ADD `php_allowadd` MEDIUMTEXT NOT NULL AFTER `php_ajaxmethod`;
