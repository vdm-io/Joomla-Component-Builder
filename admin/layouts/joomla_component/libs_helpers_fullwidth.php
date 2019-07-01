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
	'creatuserhelper',
	'adduikit',
	'addfootable',
	'add_email_helper',
	'add_php_helper_both',
	'php_helper_both',
	'add_php_helper_admin',
	'php_helper_admin',
	'add_admin_event',
	'php_admin_event',
	'add_php_helper_site',
	'php_helper_site',
	'add_site_event',
	'php_site_event',
	'add_javascript',
	'javascript',
	'add_css_admin',
	'css_admin',
	'add_css_site',
	'css_site'
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
