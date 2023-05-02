<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$edit = "index.php?option=com_componentbuilder&view=powers&task=power.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('power',$item,'powers');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('power.edit.state')): ?>
			<?php
				$iconClass = '';
				if (!$this->saveOrder)
				{
					$iconClass = ' inactive tip-top" hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
				}
			?>
			<span class="sortable-handler<?php echo $iconClass; ?>">
				<i class="icon-menu"></i>
			</span>
			<?php if ($this->saveOrder) : ?>
				<input type="text" style="display:none" name="order[]" size="5"
				value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
			<?php endif; ?>
		<?php else: ?>
			&#8942;
		<?php endif; ?>
		</td>
		<td class="nowrap center">
		<?php if ($canDo->get('power.edit')): ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					<?php else: ?>
						&#9633;
					<?php endif; ?>
				<?php else: ?>
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				<?php endif; ?>
		<?php else: ?>
			&#9633;
		<?php endif; ?>
		</td>
		<td class="nowrap">
			<div>
			<?php if ($canDo->get('power.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->system_name); ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'powers.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $this->escape($item->system_name); ?>
			<?php endif; ?><br /><small>GUID: 
			<?php echo $this->escape($item->guid); ?><?php if(isset($item->super_power_key)): ?><br />SPK: <?php echo $item->super_power_key; ?><?php endif; ?></small>
			</div>
		</td>
		<td class="hidden-phone">
			<?php echo $item->namespace; ?>
		</td>
		<td class="hidden-phone">
			<div><?php echo JText::_('COM_COMPONENTBUILDER_TYPE'); ?>: 
			<?php echo JText::_($item->type); ?><?php if (ComponentbuilderHelper::validGUID($item->extends)) : ?><br /><?php echo JText::_('COM_COMPONENTBUILDER_EXTENDS'); ?>: 
			<?php if ($this->user->authorise('power.edit', 'com_componentbuilder.power.' . (int) $item->extends_id)): ?>
				<a href="index.php?option=com_componentbuilder&view=powers&task=power.edit&id=<?php echo $item->extends_id; ?>&return=<?php echo $this->return_here; ?>"><?php echo $this->escape($item->extends_name); ?></a>
			<?php else: ?>
				<?php echo $this->escape($item->extends_name); ?>
			<?php endif; ?><?php elseif ($item->extends === '-1') : ?><br /><?php echo JText::_('COM_COMPONENTBUILDER_EXTENDS'); ?>: 
			<?php echo $this->escape($item->extends_custom); ?><?php endif; ?><br /><?php echo JText::_('COM_COMPONENTBUILDER_SUPER_POWER'); ?>: 
			<?php echo JText::_($item->approved); ?>
			</div>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->power_version); ?>
		</td>
		<td class="center">
		<?php if ($canDo->get('power.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'powers.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'powers.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'powers.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'powers.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>