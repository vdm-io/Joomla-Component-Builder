ALTER TABLE `#__componentbuilder_language_translation` ADD `modules` TEXT NOT NULL AFTER `components`;

ALTER TABLE `#__componentbuilder_language_translation` ADD `plugins` TEXT NOT NULL AFTER `modules`;
