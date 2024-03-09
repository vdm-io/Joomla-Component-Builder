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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
defined('_JEXEC') or die;

$edit = "index.php?option=com_componentbuilder&view=custom_admin_views&task=custom_admin_view.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = Factory::getContainer()->
			get(\Joomla\CMS\User\UserFactoryInterface::class)->
				loadUserById($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('custom_admin_view',$item,'custom_admin_views');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('core.edit.state')): ?>
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
		<?php if ($canDo->get('core.edit')): ?>
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
			<div class="name">
				<?php if ($canDo->get('core.edit')): ?>
					<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->system_name); ?></a>
					<?php if ($item->checked_out): ?>
						<?php echo Html::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'custom_admin_views.', $canCheckin); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo $this->escape($item->system_name); ?>
				<?php endif; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<div><?php echo Text::_('COM_COMPONENTBUILDER_NAME'); ?>: <b>
			<?php echo $this->escape($item->name); ?></b><br />
	<?php echo Text::_('COM_COMPONENTBUILDER_CODE'); ?>: <b>
			<?php echo $this->escape($item->codename); ?></b><br />
	<?php if (StringHelper::check($item->context)): ?>
	<?php echo Text::_('COM_COMPONENTBUILDER_CONTEXT'); ?>: <b>
			<?php echo $this->escape($item->context); ?></b>
	<?php endif; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<div><em>
			<?php echo $this->escape($item->description); ?></em>
			<ul style="list-style: none">
				<li><?php echo Text::_("COM_COMPONENTBUILDER_CUSTOM_BUTTON"); ?>: <b>
			<?php echo Text::_($item->add_custom_button); ?></b></li>
				<li><?php echo Text::_("COM_COMPONENTBUILDER_AJAX"); ?>: <b>
			<?php echo Text::_($item->add_php_ajax); ?></b></li>
			</ul>
			</div>
		</td>
		<td class="nowrap">
			<div class="name">
				<?php if ($this->user->authorise('dynamic_get.edit', 'com_componentbuilder.dynamic_get.' . (int) $item->main_get)): ?>
					<a href="index.php?option=com_componentbuilder&view=dynamic_gets&task=dynamic_get.edit&id=<?php echo $item->main_get; ?>&return=<?php echo $this->return_here; ?>"><?php echo $this->escape($item->main_get_name); ?></a>
				<?php else: ?>
					<?php echo $this->escape($item->main_get_name); ?>
				<?php endif; ?>
			</div>
		</td>
		<td class="center">
		<?php if ($canDo->get('core.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'custom_admin_views.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo Html::_('jgrid.published', $item->published, $i, 'custom_admin_views.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo Html::_('jgrid.published', $item->published, $i, 'custom_admin_views.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo Html::_('jgrid.published', $item->published, $i, 'custom_admin_views.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>