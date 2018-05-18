<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file

defined('_JEXEC') or die('Restricted access');

$form = $displayData->getForm();

$fields = $displayData->get('fields') ?: array(
	'add_php_ajax',
	'php_ajaxmethod',
	'ajax_input',
	'add_php_getitem',
	'php_getitem',
	'add_php_getitems',
	'php_getitems',
	'add_php_getitems_after_all',
	'php_getitems_after_all',
	'add_php_getlistquery',
	'php_getlistquery',
	'add_php_before_save',
	'php_before_save',
	'add_php_save',
	'php_save',
	'add_php_postsavehook',
	'php_postsavehook',
	'add_php_allowedit',
	'php_allowedit',
	'add_php_batchcopy',
	'php_batchcopy',
	'add_php_batchmove',
	'php_batchmove',
	'add_php_before_publish',
	'php_before_publish',
	'add_php_after_publish',
	'php_after_publish',
	'add_php_before_delete',
	'php_before_delete',
	'add_php_after_delete',
	'php_after_delete',
	'add_php_document',
	'php_document'
);

?>
<div class="form-vertical">
<?php foreach($fields as $field): ?>
    <div class="control-group">
        <div class="control-label">
            <?php echo $form->getLabel($field); ?>
        </div>
        <div class="controls">
            <?php echo $form->getInput($field); ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
