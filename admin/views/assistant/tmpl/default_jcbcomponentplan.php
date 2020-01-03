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

// get the model
$model = ComponentbuilderHelper::getModel('joomla_component', JPATH_ADMINISTRATOR . '/components/com_componentbuilder');
// get the form
$form = $model->getForm(array(), true, array('control' => 'jcbform'));
// get the form
$fields = $model->assistantForm;

?>
<h2><?php echo JText::_('COM_COMPONENTBUILDER_COMPONENT_DETAILS'); ?></h2>
<div data-uk-grid-margin="" class="uk-grid">
<?php foreach($fields as $pos => $fields): ?>
	<div class="uk-width-medium-1-2">
		<div class="uk-panel uk-panel-box">
		<?php foreach($fields as $field): ?>
			<?php echo $form->renderField($field); ?>
		<?php endforeach; ?>
		</div>
	</div>
<?php endforeach; ?>
</div>
