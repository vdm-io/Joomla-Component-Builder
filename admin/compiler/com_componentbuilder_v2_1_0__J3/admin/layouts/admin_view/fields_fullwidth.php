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

	@version		2.1.0
	@build			20th February, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		fields_fullwidth.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file

defined('_JEXEC') or die('Restricted access');

// set the defaults
$items	= $displayData->bbhfields;
$user	= JFactory::getUser();
$id	= $displayData->item->id;
$edit	= "index.php?option=com_componentbuilder&view=fields&task=field.edit";
$ref	= ($id) ? "&ref=admin_view&refid=".$id : "";
$new	= "index.php?option=com_componentbuilder&view=field&layout=edit".$ref;
$can	= ComponentbuilderHelper::getActions('field');

?>
<div class="form-vertical">
<?php if ($can->get('field.create')): ?>
	<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo JText::_('COM_COMPONENTBUILDER_NEW'); ?></a><br /><br />
<?php endif; ?>
<?php if (ComponentbuilderHelper::checkArray($items)): ?>
<table class="footable table data fields metro-blue" data-filter="#filter_fields" data-page-size="20">
<thead>
	<tr>
		<th data-toggle="true">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_NAME_LABEL'); ?>
		</th>
		<th data-hide="phone">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_TYPE_LABEL'); ?>
		</th>
		<th data-hide="phone">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_DATATYPE_LABEL'); ?>
		</th>
		<th data-hide="phone,tablet">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_INDEXES_LABEL'); ?>
		</th>
		<th data-hide="phone,tablet">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_NULL_SWITCH_LABEL'); ?>
		</th>
		<th data-hide="phone,tablet">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_FIELD_CATEGORY'); ?>
		</th>
		<th data-hide="all">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_STORE_LABEL'); ?>
		</th>
		<th width="10" data-hide="phone,tablet">
			<?php echo JText::_('COM_COMPONENTBUILDER_FIELD_STATUS'); ?>
		</th>
		<th width="5" data-type="numeric" data-hide="phone,tablet">
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
		<td class="nowrap">
			<?php if ($canDo->get('field.edit')): ?>
				<a href="<?php echo $edit; ?>&id=<?php echo $item->id; ?>&ref=admin_view&refid=<?php echo $id; ?>"><?php echo $displayData->escape($item->name); ?></a>
					<?php if ($item->checked_out): ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $userChkOut->name, $item->checked_out_time, 'fields.', $canCheckin); ?>
					<?php endif; ?>
			<?php else: ?>
				<div class="name"><?php echo $displayData->escape($item->name); ?></div>
			<?php endif; ?>
		</td>
		<td class="nowrap">
			<?php if ($user->authorise('fieldtype.edit', 'com_componentbuilder.fieldtype.' . (int)$item->type)): ?>
				<a href="index.php?option=com_componentbuilder&view=fieldtypes&task=fieldtype.edit&id=<?php echo $item->type; ?>&ref=admin_view&refid=<?php echo $id; ?>"><?php echo $displayData->escape($item->type_name); ?></a>
			<?php else: ?>
				<div class="name"><?php echo $displayData->escape($item->type_name); ?></div>
			<?php endif; ?>
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
		<td class="nowrap">
			<?php if ($user->authorise('core.edit', 'com_componentbuilder.fields.category.' . (int)$item->catid)): ?>
				<a href="index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->catid; ?>&extension=com_componentbuilder.fields"><?php echo $displayData->escape($item->category_title); ?></a>
			<?php else: ?>
				<?php echo $displayData->escape($item->category_title); ?>
			<?php endif; ?>
		</td>
		<td>
			<?php echo JText::_($item->store); ?>
		</td>
		<?php if ($item->published == 1):?>
			<td class="center"  data-value="1">
				<span class="status-metro status-published" title="<?php echo JText::_('PUBLISHED');  ?>">
					<?php echo JText::_('PUBLISHED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 0):?>
			<td class="center"  data-value="2">
				<span class="status-metro status-inactive" title="<?php echo JText::_('INACTIVE');  ?>">
					<?php echo JText::_('INACTIVE'); ?>
				</span>
			</td>
		<?php elseif ($item->published == 2):?>
			<td class="center"  data-value="3">
				<span class="status-metro status-archived" title="<?php echo JText::_('ARCHIVED');  ?>">
					<?php echo JText::_('ARCHIVED'); ?>
				</span>
			</td>
		<?php elseif ($item->published == -2):?>
			<td class="center"  data-value="4">
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
<tfoot class="hide-if-no-paging">
	<tr>
		<td colspan="9">
			<div class="pagination pagination-centered"></div>
		</td>
	</tr>
</tfoot>
</table>
<?php else: ?>
	<div class="alert alert-no-items">
		<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
	</div>
<?php endif; ?>
</div>
