ALTER TABLE `#__componentbuilder_admin_view` ADD `mysql_table_charset` VARCHAR(64) NOT NULL DEFAULT 1 AFTER `javascript_views_footer`;

ALTER TABLE `#__componentbuilder_admin_view` ADD `mysql_table_collate` VARCHAR(64) NOT NULL DEFAULT 1 AFTER `mysql_table_charset`;

ALTER TABLE `#__componentbuilder_admin_view` ADD `mysql_table_engine` VARCHAR(64) NOT NULL DEFAULT 1 AFTER `mysql_table_collate`;
