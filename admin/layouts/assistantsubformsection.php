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
defined('JPATH_BASE') or die('Restricted access');

/**
 * Make thing clear
 *
 * @var JForm   $form       The form instance for render the section
 * @var JForm   $fields       The fields in layout
 * @var string  $basegroup  The base group name
 * @var string  $group      Current group name
 * @var array   $buttons    Array of the buttons that will be rendered
 */
extract($displayData);

?>
<div
	class="subform-repeatable-group subform-repeatable-group-<?php echo $unique_subform_id; ?>"
	data-base-name="<?php echo $basegroup; ?>"
	data-group="<?php echo $group; ?>"
>
	<?php if (!empty($buttons)) : ?>
	<div class="btn-toolbar text-right">
		<div class="btn-group">
			<?php if (!empty($buttons['add'])) : ?>
				<a class="btn btn-mini button btn-success group-add group-add-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('COM_COMPONENTBUILDER_ADD'); ?>">
					<span class="icon-plus" aria-hidden="true"></span>
				</a>
			<?php endif; ?>
			<?php if (!empty($buttons['remove'])) : ?>
				<a class="btn btn-mini button btn-danger group-remove group-remove-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('COM_COMPONENTBUILDER_REMOVE'); ?>">
					<span class="icon-minus" aria-hidden="true"></span>
				</a>
			<?php endif; ?>
			<?php if (!empty($buttons['move'])) : ?>
				<a class="btn btn-mini button btn-primary group-move group-move-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('COM_COMPONENTBUILDER_MOVE'); ?>">
					<span class="icon-move" aria-hidden="true"></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if (isset($fields['top'])): ?>
	<div data-uk-grid-margin="" class="uk-grid">
		<div class="uk-width-medium-1-1">
			<div class="uk-panel">
			<?php foreach($fields['top'] as $field): ?>
				<?php echo str_replace('[[[VDM]]]', $vdm, $form->renderField($field)); ?>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if (isset($fields['left']) || isset($fields['right'])): ?>
	<div data-uk-grid-margin="" class="uk-grid">
	<?php foreach($fields as $pos => $_fields): ?>
		<?php if ('left' === $pos || 'right' === $pos): ?>
		<div class="uk-width-medium-1-2">
			<div class="uk-panel uk-panel-box">
			<?php foreach($_fields as $field): ?>
				<?php echo str_replace('[[[VDM]]]', $vdm, $form->renderField($field)); ?>
			<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
	<?php endforeach;?>
	</div>
	<?php endif; ?>

	<?php if (isset($fields['bottom'])): ?>
	<div data-uk-grid-margin="" class="uk-grid">
		<div class="uk-width-medium-1-1">
			<div class="uk-panel">
			<?php foreach($fields['bottom'] as $field): ?>
				<?php echo str_replace('[[[VDM]]]', $vdm, $form->renderField($field)); ?>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if (isset($fields['modal'])): ?>
	<?php foreach($fields['modal'] as $modal => $_fields): ?>
		<div id="modal-<?php echo $modal; ?>-<?php echo $vdm ?>" class="uk-modal">
			<div class="uk-modal-dialog uk-modal-dialog-large">
				<div class="uk-panel">
					<?php foreach($_fields as $field): ?>
						<?php echo str_replace('[[[VDM]]]', $vdm, $form->renderField($field)); ?>
					<?php endforeach; ?>
				</div>
				<div class="uk-modal-footer">
					<div class="uk-clearfix">
						<button class="uk-float-right uk-button uk-button-success uk-modal-close"><?php echo JText::_('COM_COMPONENTBUILDER_UPDATE'); ?></button>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<?php endif; ?>
</div>
