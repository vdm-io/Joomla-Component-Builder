ALTER TABLE `#__componentbuilder_snippet` ADD `contributor_company` VARCHAR(255) NOT NULL DEFAULT '' AFTER `asset_id`;

ALTER TABLE `#__componentbuilder_snippet` ADD `contributor_email` VARCHAR(255) NOT NULL DEFAULT '' AFTER `contributor_company`;

ALTER TABLE `#__componentbuilder_snippet` ADD `contributor_name` VARCHAR(255) NOT NULL DEFAULT '' AFTER `contributor_email`;

ALTER TABLE `#__componentbuilder_snippet` ADD `contributor_website` VARCHAR(255) NOT NULL DEFAULT '' AFTER `contributor_name`;
