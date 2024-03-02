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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;

$edit = "index.php?option=com_componentbuilder&view=class_methods&task=class_method.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = Factory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('class_method',$item,'class_methods');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('class_method.edit.state')): ?>
			<?php
				$iconClass = '';
				if (!$this->saveOrder)
				{
					$iconClass = ' inactive tip-top" hasTooltip" title="' . Html::tooltipText('JORDERINGDISABLED');
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
		<?php if ($canDo->get('class_method.edit')): ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo Html::_('grid.id', $i, $item->id); ?>
					<?php else: ?>
						&#9633;
					<?php endif; ?>
				<?php else: ?>
					<?php echo Html::_('grid.id', $i, $item->id); ?>
				<?php endif; ?>
		<?php else: ?>
			&#9633;
		<?php endif; ?>
		</td>
		<td class="nowrap">
			<div>
			<?php if ($canDo->get('class_method.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->name); ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo Html::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'class_methods.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $this->escape($item->name); ?>
			<?php endif; ?>(
			<?php echo $this->escape($item->arguments); ?>)
			</div>
		</td>
		<td class="hidden-phone">
			<?php echo Text::_($item->visibility); ?>
		</td>
		<td class="hidden-phone">
			<div><?php if (isset($item->joomla_plugin_group) && $item->joomla_plugin_group > 0): ?>
	
			<?php echo Text::_($item->extension_type); ?> <?php echo Text::_('COM_COMPONENTBUILDER_GROUP'); ?>: <b>
			<?php echo $this->escape($item->joomla_plugin_group_name); ?></b>
<?php else: ?>
	
			<?php echo Text::_($item->extension_type); ?>
<?php endif; ?>
			</div>
		</td>
		<td class="center">
		<?php if ($canDo->get('class_method.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'class_methods.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'class_methods.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo Html::_('jgrid.published', $item->published, $i, 'class_methods.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo Html::_('jgrid.published', $item->published, $i, 'class_methods.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>