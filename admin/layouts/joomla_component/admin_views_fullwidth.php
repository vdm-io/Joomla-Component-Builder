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

	@version		2.5.5
	@build			18th September, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		admin_views_fullwidth.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file

defined('_JEXEC') or die('Restricted access');

// set the defaults
$items	= $displayData->vwmadmin_views;
$user	= JFactory::getUser();
$id	= $displayData->item->id;
$edit	= "index.php?option=com_componentbuilder&view=admin_views&task=admin_view.edit";
$ref	= ($id) ? "&ref=joomla_component&refid=".$id : "";
$new	= "index.php?option=com_componentbuilder&view=admin_view&layout=edit".$ref;
$can	= ComponentbuilderHelper::getActions('admin_view');

?>
<div class="form-vertical">
<?php if ($can->get('core.create')): ?>
	<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo JText::_('COM_COMPONENTBUILDER_NEW'); ?></a><br /><br />
<?php endif; ?>
<?php if (ComponentbuilderHelper::checkArray($items)): ?>
<table class="footable table data admin_views" data-show-toggle="true" data-toggle-column="first" data-sorting="true" data-paging="true" data-paging-size="20" data-filtering="true">
<thead>
	<tr>
		<th data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_SYSTEM_NAME_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_NAME_SINGLE_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_NAME_LIST_LABEL'); ?>
		</th>
		<th data-breakpoints="xs sm md" data-type="html" data-sort-use="text">
			<?php echo JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_SHORT_DESCRIPTION_LABEL'); ?>
		</th>
		<th width="10" data-breakpoints="xs sm md">
			<?php echo JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_STATUS'); ?>
		</th>
		<th width="5" data-type="number" data-breakpoints="xs sm md">
			<?php echo JText::_('COM_COMPONENTBUILDER_ADMIN_VIEW_ID'); ?>
		</th>
	</tr>
</thead>
<tbody>
<?php foreach ($items as $i => $item): ?>
	<?php
		$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = ComponentbuilderHelper::getActions('admin_view',$item,'admin_views');
	?>
	<tr>
		<td class="nowrap">
			<?php if ($canDo->get('core.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>&ref=joomla_component&refid=<?php echo $id; ?>"><?php echo $displayData->escape($item->system_name); ?></a>
					<?php if ($item->checked_out): ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'admin_views.', $canCheckin); ?>
					<?php endif; ?>
			<?php else: ?>
				<div class="name"><?php echo $displayData->escape($item->system_name); ?></div>
			<?php endif; ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->name_single); ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->name_list); ?>
		</td>
		<td>
			<?php echo $displayData->escape($item->short_description); ?>
		</td>
		<?php if ($item->published == 1):?>
			<td class="center"  data-sort-value="1">
				<span class="status-metro status-published" title="<?php echo JText::_('PUBLISHED');  ?>">
					<?php echo JText::_('PUBLISHED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 0):?>
			<td class="center"  data-sort-value="2">
				<span class="status-metro status-inactive" title="<?php echo JText::_('INACTIVE');  ?>">
					<?php echo JText::_('INACTIVE'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 2):?>
			<td class="center"  data-sort-value="3">
				<span class="status-metro status-archived" title="<?php echo JText::_('ARCHIVED');  ?>">
					<?php echo JText::_('ARCHIVED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == -2):?>
			<td class="center"  data-sort-value="4">
				<span class="status-metro status-trashed" title="<?php echo JText::_('ARCHIVED');  ?>">
					<?php echo JText::_('ARCHIVED'); ?>
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
