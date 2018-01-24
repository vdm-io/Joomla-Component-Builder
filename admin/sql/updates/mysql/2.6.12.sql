ALTER TABLE `#__componentbuilder_dynamic_get` ADD `add_php_router_parse` TINYINT(1) NOT NULL DEFAULT 0 AFTER `add_php_getlistquery`;

ALTER TABLE `#__componentbuilder_dynamic_get` ADD `php_router_parse` MEDIUMTEXT NOT NULL AFTER `php_getlistquery`;
