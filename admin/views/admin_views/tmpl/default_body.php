<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		@update number 202 of this MVC
	@build			21st October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		default_body.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access'); 

$edit = "index.php?option=com_componentbuilder&view=admin_views&task=admin_view.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('admin_view',$item,'admin_views');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('admin_view.edit.state')): ?>
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
		<?php if ($canDo->get('admin_view.edit')): ?>
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
			<?php if ($canDo->get('admin_view.edit')): ?>
				<div class="name">
					<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>"><?php echo $this->escape($item->system_name); ?></a>
					<?php if ($item->checked_out): ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'admin_views.', $canCheckin); ?>
					<?php endif; ?>
				</div>
			<?php else: ?>
				<div class="name"><?php echo $this->escape($item->system_name); ?></div>
			<?php endif; ?>
			
			<div class="btn-group" style="margin: 5px 0 0 0;">
				<?php if ($canDo->get('admin_view.edit') && $admin_field_id = ComponentbuilderHelper::getVar('admin_fields', $item->id, 'admin_view', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=admins_fields&task=admin_fields.edit&id=<?php echo $admin_field_id; ?>&ref=admin_views" title="<?php echo JText::_('COM_COMPONENTBUILDER_EDIT_THE_ADMIN_FIELDS'); ?>" ><span class="icon-list"></span></a>
				<?php endif; ?>
				<?php if ($canDo->get('admin_view.edit') && $admin_condition_id = ComponentbuilderHelper::getVar('admin_fields_conditions', $item->id, 'admin_view', 'id')): ?>
					<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=admins_fields_conditions&task=admin_fields_conditions.edit&id=<?php echo $admin_condition_id; ?>&ref=admin_views" title="<?php echo JText::_('COM_COMPONENTBUILDER_EDIT_THE_ADMIN_FIELDS_CONDITIONS'); ?>" ><span class="icon-shuffle"></span></a>
				<?php endif; ?>
			</div>
			
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->name_single); ?>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->name_list); ?>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->short_description); ?>
		</td>
		<td class="center">
		<?php if ($canDo->get('admin_view.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'admin_views.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'admin_views.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'admin_views.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'admin_views.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>