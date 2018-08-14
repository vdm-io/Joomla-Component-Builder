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

// set the defaults
$items	= $displayData->waplinked_components;
$user	= JFactory::getUser();
$id	= $displayData->item->id;
$edit = "index.php?option=com_componentbuilder&view=joomla_components&task=joomla_component.edit";

?>
<div class="form-vertical">
<?php if (ComponentbuilderHelper::checkArray($items)): ?>
<table class="footable table data joomla_components" data-show-toggle="true" data-toggle-column="first" data-sorting="true" data-paging="true" data-paging-size="20" data-filtering="true">
<thead>
	<tr>
		<th data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SYSTEM_NAME_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_NAME_CODE_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPONENT_VERSION_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm md" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SHORT_DESCRIPTION_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm md" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_COMPANYNAME_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm md" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_AUTHOR_LABEL'); ?>
		</th>
		<th width="10" data-breakpoints="xs sm md">
			<?php echo JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_STATUS'); ?>
		</th>
		<th width="5" data-type="number" data-breakpoints="xs sm md">
			<?php echo JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_ID'); ?>
		</th>
	</tr>
</thead>
<tbody>
<?php foreach ($items as $i => $item): ?>
	<?php
		$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('joomla_component',$item,'joomla_components');
	?>
	<tr>
		<td>
			<?php if ($canDo->get('joomla_component.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>&ref=server&refid=<?php echo $id; ?>"><?php echo $displayData->escape($item->system_name); ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'joomla_components.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $displayData->escape($item->system_name); ?>
			<?php endif; ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->name_code); ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->component_version); ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->short_description); ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->companyname); ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->author); ?>
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
