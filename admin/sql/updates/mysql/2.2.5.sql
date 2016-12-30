ALTER TABLE `#__componentbuilder_component` ADD `buildcomp` TINYINT(1) NOT NULL DEFAULT '0' AFTER `bom`,
ADD `buildcompsql` MEDIUMTEXT NOT NULL AFTER `buildcomp`;
