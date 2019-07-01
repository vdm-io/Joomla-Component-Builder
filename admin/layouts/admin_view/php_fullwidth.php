<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// get the form
$form = $displayData->getForm();

// get the layout fields override method name (from layout path/ID)
$layout_path_array = explode('.', $this->getLayoutId());
// Since we cannot pass the layout and tab names as parameters to the model method
// this name combination of tab and layout in the method name is the only work around
// seeing that JCB uses those two values (tab_name & layout_name) as the layout file name.
// example of layout name: details_left.php
// example of method name: getFields_details_left()
$fields_tab_layout = 'fields_' . $layout_path_array[1];

// get the fields
$fields = $displayData->get($fields_tab_layout) ?: array(
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
	'add_php_getform',
	'php_getform',
	'add_php_before_save',
	'php_before_save',
	'add_php_save',
	'php_save',
	'add_php_postsavehook',
	'php_postsavehook',
	'add_php_allowadd',
	'php_allowadd',
	'add_php_allowedit',
	'php_allowedit',
	'add_php_before_cancel',
	'php_before_cancel',
	'add_php_after_cancel',
	'php_after_cancel',
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

$hiddenFields = $displayData->get('hidden_fields') ?: array();

?>
<?php if ($fields && count((array) $fields)) :?>
<div class="form-vertical">
	<?php foreach($fields as $field): ?>
		<?php if (in_array($field, $hiddenFields)) : ?>
			<?php $form->setFieldAttribute($field, 'type', 'hidden'); ?>
		<?php endif; ?>
		<?php echo $form->renderField($field, null, null, array('class' => 'control-wrapper-' . $field)); ?>
	<?php endforeach; ?>
</div>
<?php endif; ?>
