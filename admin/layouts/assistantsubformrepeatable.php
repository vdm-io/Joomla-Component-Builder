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
 * @var JForm   $tmpl             The Empty form for template
 * @var array   $forms            Array of JForm instances for render the rows
 * @var bool    $multiple         The multiple state for the form field
 * @var int     $min              Count of minimum repeating in multiple mode
 * @var int     $max              Count of maximum repeating in multiple mode
 * @var string  $fieldname        The field name
 * @var string  $control          The forms control
 * @var string  $label            The field label
 * @var string  $description      The field description
 * @var array   $buttons          Array of the buttons that will be rendered
 * @var bool    $groupByFieldset  Whether group the subform fields by it`s fieldset
 */
extract($displayData);

// the subform field layout
$subform_fields = array(
	'left' => array('name'),
	'right' => array('list_name'),
	'bottom' => array('builder'),
	'modal' => array('fields' => array('fields'), 'listview' => array('columns'), 'display' => array('display'))
);

?>
<div class="row-fluid">
	<div class="subform-repeatable-wrapper subform-layout">
		<div class="subform-repeatable-vdm"
			data-bt-add="a.group-add-<?php echo $unique_subform_id; ?>"
			data-bt-remove="a.group-remove-<?php echo $unique_subform_id; ?>"
			data-bt-move="a.group-move-<?php echo $unique_subform_id; ?>"
			data-repeatable-element="div.subform-repeatable-group-<?php echo $unique_subform_id; ?>"
			data-minimum="<?php echo $min; ?>" data-maximum="<?php echo $max; ?>"
		>

			<?php if (!empty($buttons['add'])) : ?>
			<div class="btn-toolbar">
				<div class="btn-group">
					<a class="btn btn-mini button btn-success group-add group-add-<?php echo $unique_subform_id; ?>" aria-label="<?php echo JText::_('JGLOBAL_FIELD_ADD'); ?>">
						<span class="icon-plus" aria-hidden="true"></span>
					</a>
				</div>
			</div>
			<?php endif; ?>
		<?php foreach ($forms as $k => $form) : ?>
			<?php echo JLayoutHelper::render('assistantsubformsection', array(
				'form' => $form,
				'fields' => $subform_fields,
				'basegroup' => $fieldname,
				'group' => $fieldname . $k,
				'vdm' => $fieldname . $k,
				'buttons' => $buttons,
				'unique_subform_id' => $unique_subform_id,
				));
			?>
		<?php endforeach; ?>
		<?php if ($multiple) : ?>
			<template class="subform-repeatable-template-section" style="display: none;"><?php
				// Use str_replace to escape HTML in a simple way, it need for IE compatibility, and should be removed later
				echo str_replace(
						array('<', '>'),
						array('SUBFORMLT', 'SUBFORMGT'),
						trim(
							JLayoutHelper::render('assistantsubformsection', array(
								'form' => $tmpl,
								'fields' => $subform_fields,
								'basegroup' => $fieldname,
								'group' => $fieldname . 'X',
								'vdm' => $fieldname . 'VDM-XX',
								'buttons' => $buttons,
								'unique_subform_id' => $unique_subform_id
							))
						)
				);
				?></template>
		<?php endif; ?>
		</div>
	</div>
</div>
