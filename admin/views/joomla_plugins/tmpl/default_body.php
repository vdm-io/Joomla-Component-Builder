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

$edit = "index.php?option=com_componentbuilder&view=joomla_plugins&task=joomla_plugin.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('joomla_plugin',$item,'joomla_plugins');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('joomla_plugin.edit.state')): ?>
			<?php
				if ($this->saveOrder)
				{
					$iconClass = ' inactive';
				}
				else
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
		<?php if ($canDo->get('joomla_plugin.edit')): ?>
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
			<?php if ($canDo->get('joomla_plugin.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->system_name); ?></a>
				<?php if ($item->checked_out): ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'joomla_plugins.', $canCheckin); ?>
				<?php endif; ?>
			<?php else: ?>
				<?php echo $this->escape($item->system_name); ?>
			<?php endif; ?> - <b>
			<?php echo $this->escape($item->plugin_version); ?></b>
			</div>
			<?php
				// setup the buttons
				if (!isset($_buttons) || !ComponentbuilderHelper::checkArray($_buttons))
				{
					$_buttons = array();
					$_buttons[0] = array(
						array(
							'view' => 'joomla_plugin_updates',
							'views' => 'joomla_plugins_updates',
							'title' => JText::_('COM_COMPONENTBUILDER_THE_PLUGIN_UPDATES'),
							'icon' => 'database'),
						array(
							'view' => 'joomla_plugin_files_folders_urls',
							'views' => 'joomla_plugins_files_folders_urls',
							'title' => JText::_('COM_COMPONENTBUILDER_THE_PLUGIN_FILES_FOLDERS'),
							'icon' => 'briefcase')
						);
				}
			?>
			<div class="btn-group" style="margin: 5px 0 0 0;">
			<?php foreach ($_buttons[0] as $_button): ?>
				<?php if ($canDo->get($_button['view'].'.edit') && ($id = ComponentbuilderHelper::getVar($_button['view'], $item->id, 'joomla_plugin', 'id')) !== false): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&id=<?php echo $id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php elseif ($canDo->get($_button['view'].'.create')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=<?php echo $_button['views'] ?>&task=<?php echo $_button['view'] ?>.edit&ref=joomla_plugin&refid=<?php echo $item->id; ?>&return=<?php echo $this->return_here; ?>" title="<?php echo $_button['title']; ?>" ><span class="icon-<?php echo $_button['icon']; ?>"></span></a>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</td>
		<td class="nowrap">
			<div class="name">
				<?php if ($this->user->authorise('class_extends.edit', 'com_componentbuilder.class_extends.' . (int)$item->class_extends)): ?>
					<a href="index.php?option=com_componentbuilder&view=class_extendings&task=class_extends.edit&id=<?php echo $item->class_extends; ?>&return=<?php echo $this->return_here; ?>"><?php echo $this->escape($item->class_extends_name); ?></a>
				<?php else: ?>
					<?php echo $this->escape($item->class_extends_name); ?>
				<?php endif; ?>
			</div>
		</td>
		<td class="nowrap">
			<div class="name">
				<?php if ($this->user->authorise('core.edit', 'com_componentbuilder.joomla_plugin_group.' . (int)$item->joomla_plugin_group)): ?>
					<a href="index.php?option=com_componentbuilder&view=joomla_plugin_groups&task=joomla_plugin_group.edit&id=<?php echo $item->joomla_plugin_group; ?>&return=<?php echo $this->return_here; ?>"><?php echo $this->escape($item->joomla_plugin_group_name); ?></a>
				<?php else: ?>
					<?php echo $this->escape($item->joomla_plugin_group_name); ?>
				<?php endif; ?>
			</div>
		</td>
		<td class="center">
		<?php if ($canDo->get('joomla_plugin.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'joomla_plugins.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'joomla_plugins.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'joomla_plugins.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'joomla_plugins.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>