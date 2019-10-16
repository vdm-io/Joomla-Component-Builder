ALTER TABLE `#__componentbuilder_field` ADD `on_get_model_field` TEXT NOT NULL AFTER `datatype`;

ALTER TABLE `#__componentbuilder_field` ADD `on_save_model_field` TEXT NOT NULL AFTER `on_get_model_field`;

ALTER TABLE `#__componentbuilder_field` ADD `initiator_on_save_model` TEXT NOT NULL AFTER `indexes`;

ALTER TABLE `#__componentbuilder_field` ADD `initiator_on_get_model` TEXT NOT NULL AFTER `indexes`;
