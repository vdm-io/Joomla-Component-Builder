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

$edit = "index.php?option=com_componentbuilder&view=joomla_components&task=joomla_component.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('joomla_component',$item,'joomla_components');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('joomla_component.edit.state')): ?>
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
		<?php if ($canDo->get('joomla_component.edit')): ?>
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
			<div class="name">
				<?php if ($canDo->get('joomla_component.edit')): ?>
					<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->system_name); ?></a>
					<?php if ($item->checked_out): ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'joomla_components.', $canCheckin); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo $this->escape($item->system_name); ?>
				<?php endif; ?>
			</div>

			<div class="btn-group" style="margin: 5px 0 0 0;">
				<?php if ($canDo->get('component_admin_views.edit') && $component_admin_views_id = ComponentbuilderHelper::getVar('component_admin_views', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_admin_views&task=component_admin_views.edit&id=<?php echo $component_admin_views_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_ADMIN_VIEWS'); ?>" ><span class="icon-stack"></span></a>
				<?php endif; ?>
				<?php if ($canDo->get('component_custom_admin_views.edit') && $component_custom_admin_views_id = ComponentbuilderHelper::getVar('component_custom_admin_views', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_custom_admin_views&task=component_custom_admin_views.edit&id=<?php echo $component_custom_admin_views_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_CUSTOM_ADMIN_VIEWS'); ?>" ><span class="icon-screen"></span></a>
				<?php endif; ?>
				<?php if ($canDo->get('component_site_views.edit') && $component_site_views_id = ComponentbuilderHelper::getVar('component_site_views', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_site_views&task=component_site_views.edit&id=<?php echo $component_site_views_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_SITE_VIEWS'); ?>" ><span class="icon-palette"></span></a>
				<?php endif; ?>
				<?php if ($canDo->get('component_config.edit') && $component_config_id = ComponentbuilderHelper::getVar('component_config', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_config&task=component_config.edit&id=<?php echo $component_config_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_CONFIG'); ?>" ><span class="icon-options"></span></a>
				<?php endif; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<div><?php echo $this->escape($item->name_code); ?></div>
			<div class="btn-group" style="margin: 5px 0 0 0;">
				<?php if ($canDo->get('component_updates.edit') && $component_updates_id = ComponentbuilderHelper::getVar('component_updates', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_updates&task=component_updates.edit&id=<?php echo $component_updates_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_UPDATES'); ?>" ><span class="icon-database"></span></a>
				<?php endif; ?>
				<?php if ($canDo->get('component_mysql_tweaks.edit') && $component_mysql_tweaks_id = ComponentbuilderHelper::getVar('component_mysql_tweaks', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_mysql_tweaks&task=component_mysql_tweaks.edit&id=<?php echo $component_mysql_tweaks_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_MYSQL_TWEAKS'); ?>" ><span class="icon-screwdriver"></span></a>
				<?php endif; ?>
				<?php if ($canDo->get('component_files_folders.edit') && $component_files_folders_id = ComponentbuilderHelper::getVar('component_files_folders', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_files_folders&task=component_files_folders.edit&id=<?php echo $component_files_folders_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_FILES_FOLDERS'); ?>" ><span class="icon-briefcase"></span></a>
				<?php endif; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->component_version); ?>
		</td>
		<td class="hidden-phone">
			<div><?php echo $this->escape($item->short_description); ?></div>
			<div class="btn-group" style="margin: 5px 0 0 0;">
				<?php if ($canDo->get('component_custom_admin_menus.edit') && $component_custom_admin_menus_id = ComponentbuilderHelper::getVar('component_custom_admin_menus', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_custom_admin_menus&task=component_custom_admin_menus.edit&id=<?php echo $component_custom_admin_menus_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_CUSTOM_ADMIN_MENUS'); ?>" ><span class="icon-plus"></span></a>
				<?php endif; ?>
				<?php if ($canDo->get('component_dashboard.edit') && $component_dashboard_id = ComponentbuilderHelper::getVar('component_dashboard', $item->id, 'joomla_component', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=components_dashboard&task=component_dashboard.edit&id=<?php echo $component_dashboard_id; ?>&ref=joomla_components" title="<?php echo JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_DASHBOARD'); ?>" ><span class="icon-dashboard"></span></a>
				<?php endif; ?>
			</div>
		</td>

		<td class="hidden-phone">
			<?php echo $this->escape($item->companyname); ?>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->author); ?>
		</td>
		<td class="center">
		<?php if ($canDo->get('joomla_component.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'joomla_components.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'joomla_components.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'joomla_components.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'joomla_components.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>