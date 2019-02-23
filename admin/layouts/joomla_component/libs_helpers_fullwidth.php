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

$form = $displayData->getForm();

$fields = $displayData->get('fields') ?: array(
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
<div class="form-vertical">
	<?php foreach($fields as $field): ?>
		<?php if (in_array($field, $hiddenFields)) : ?>
			<?php $form->setFieldAttribute($field, 'type', 'hidden'); ?>
		<?php endif; ?>
		<?php echo $form->renderField($field, null, null, array('class' => 'control-wrapper-' . $field)); ?>
	<?php endforeach; ?>
</div>
