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

// set the defaults
$items = $displayData->vymfields;
$user = JFactory::getUser();
$id = $displayData->item->id;
// set the edit URL
$edit = "index.php?option=com_componentbuilder&view=fields&task=field.edit";
// set a return value
$return = ($id) ? "index.php?option=com_componentbuilder&view=fieldtype&layout=edit&id=" . $id : "";
// check for a return value
$jinput = JFactory::getApplication()->input;
if ($_return = $jinput->get('return', null, 'base64'))
{
	$return .= "&return=" . $_return;
}
// check if return value was set
if (ComponentbuilderHelper::checkString($return))
{
	// set the referral values
	$ref = ($id) ? "&ref=fieldtype&refid=" . $id . "&return=" . urlencode(base64_encode($return)) : "&return=" . urlencode(base64_encode($return));
}
else
{
	$ref = ($id) ? "&ref=fieldtype&refid=" . $id : "";
}
// set the create new URL
$new = "index.php?option=com_componentbuilder&view=fields&task=field.edit" . $ref;
// set the create new and close URL
$close_new = "index.php?option=com_componentbuilder&view=fields&task=field.edit";
// load the action object
$can = ComponentbuilderHelper::getActions('field');

?>
<div class="form-vertical">
<?php if ($can->get('field.create')): ?>
	<div class="btn-group">
		<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo JText::_('COM_COMPONENTBUILDER_NEW'); ?></a>
		<a class="btn btn-small" onclick="Joomla.submitbutton('fieldtype.cancel');" href="<?php echo $close_new; ?>"><span class="icon-new"></span> <?php echo JText::_('COM_COMPONENTBUILDER_CLOSE_NEW'); ?></a>
	</div><br /><br />
<?php endif; ?>
<?php if (ComponentbuilderHelper::checkArray($items)): ?>
<table class="footable table data fields" data-show-toggle="true" data-toggle-column="first" data-sorting="true" data-paging="true" data-paging-size="20" data-filtering="true">
<thead>
	<tr>
		<th data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_NAME_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_FIELDTYPE_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_DATATYPE_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm md" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_INDEXES_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm md" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_NULL_SWITCH_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm md" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_STORE_LABEL'); ?>
		</th>
		<th data-breakpoints="all" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_FIELDS_CATEGORIES'); ?>
		</th>
		<th width="10" data-breakpoints="xs sm md">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_STATUS'); ?>
		</th>
		<th width="5" data-type="number" data-breakpoints="xs sm md">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_ID'); ?>
		</th>
	</tr>
</thead>
<tbody>
<?php foreach ($items as $i => $item): ?>
	<?php
		$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('field',$item,'fields');
	?>
	<tr>
		<td>
			<?php if ($canDo->get('field.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?><?php echo $ref; ?>"><?php echo $displayData->escape($item->name); ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'fields.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $displayData->escape($item->name); ?>
			<?php endif; ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->fieldtype_name); ?>
		</td>
		<td>
			<?php echo JText::_($item->datatype); ?>
		</td>
		<td>
			<?php echo JText::_($item->indexes); ?>
		</td>
		<td>
			<?php echo JText::_($item->null_switch); ?>
		</td>
		<td>
			<?php echo JText::_($item->store); ?>
		</td>
		<td>
			<?php if ($user->authorise('core.edit', 'com_componentbuilder.fields.category.' . (int)$item->catid)): ?>
				<a href="index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->catid; ?>&extension=com_componentbuilder.fields"><?php echo $displayData->escape($item->category_title); ?></a>
			<?php else: ?>
				<?php echo $displayData->escape($item->category_title); ?>
			<?php endif; ?>
		</td>
		<?php if ($item->published == 1):?>
			<td class="center"  data-sort-value="1">
				<span class="status-metro status-published" title="<?php echo JText::_('COM_COMPONENTBUILDER_PUBLISHED');  ?>">
					<?php echo JText::_('COM_COMPONENTBUILDER_PUBLISHED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 0):?>
			<td class="center"  data-sort-value="2">
				<span class="status-metro status-inactive" title="<?php echo JText::_('COM_COMPONENTBUILDER_INACTIVE');  ?>">
					<?php echo JText::_('COM_COMPONENTBUILDER_INACTIVE'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 2):?>
			<td class="center"  data-sort-value="3">
				<span class="status-metro status-archived" title="<?php echo JText::_('COM_COMPONENTBUILDER_ARCHIVED');  ?>">
					<?php echo JText::_('COM_COMPONENTBUILDER_ARCHIVED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == -2):?>
			<td class="center"  data-sort-value="4">
				<span class="status-metro status-trashed" title="<?php echo JText::_('COM_COMPONENTBUILDER_TRASHED');  ?>">
					<?php echo JText::_('COM_COMPONENTBUILDER_TRASHED'); ?>
				</span>
			</td>
		<?php endif; ?>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
	<div class="alert alert-no-items">
		<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
	</div>
<?php endif; ?>
</div>
