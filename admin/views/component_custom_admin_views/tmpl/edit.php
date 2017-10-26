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

	@version		@update number 4 of this MVC
	@build			26th October, 2017
	@created		22nd October, 2017
	@package		Component Builder
	@subpackage		edit.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$componentParams = JComponentHelper::getParams('com_componentbuilder');
?>
<script type="text/javascript">
	// waiting spinner
	var outerDiv = jQuery('body');
	jQuery('<div id="loading"></div>')
		.css("background", "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat")
		.css("top", outerDiv.position().top - jQuery(window).scrollTop())
		.css("left", outerDiv.position().left - jQuery(window).scrollLeft())
		.css("width", outerDiv.width())
		.css("height", outerDiv.height())
		.css("position", "fixed")
		.css("opacity", "0.80")
		.css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)")
		.css("filter", "alpha(opacity = 80)")
		.css("display", "none")
		.appendTo(outerDiv);
	jQuery('#loading').show();
	// when page is ready remove and show
	jQuery(window).load(function() {
		jQuery('#componentbuilder_loader').fadeIn('fast');
		jQuery('#loading').hide();
	});
</script>
<div id="componentbuilder_loader" style="display: none;">
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&layout=edit&id='.(int) $this->item->id.$this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('component_custom_admin_views.views_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'component_custom_admin_viewsTab', array('active' => 'views')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'component_custom_admin_viewsTab', 'views', JText::_('COM_COMPONENTBUILDER_COMPONENT_CUSTOM_ADMIN_VIEWS_VIEWS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('component_custom_admin_views.views_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('component_custom_admin_views.delete') || $this->canDo->get('component_custom_admin_views.edit.created_by') || $this->canDo->get('component_custom_admin_views.edit.state') || $this->canDo->get('component_custom_admin_views.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'component_custom_admin_viewsTab', 'publishing', JText::_('COM_COMPONENTBUILDER_COMPONENT_CUSTOM_ADMIN_VIEWS_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('component_custom_admin_views.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('component_custom_admin_views.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'component_custom_admin_viewsTab', 'permissions', JText::_('COM_COMPONENTBUILDER_COMPONENT_CUSTOM_ADMIN_VIEWS_PERMISSION', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<fieldset class="adminform">
					<div class="adminformlist">
					<?php foreach ($this->form->getFieldset('accesscontrol') as $field): ?>
						<div>
							<?php echo $field->label; echo $field->input;?>
						</div>
						<div class="clearfix"></div>
					<?php endforeach; ?>
					</div>
				</fieldset>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="component_custom_admin_views.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	</div>
</div>
</form>
</div>

<script type="text/javascript">



<?php $fieldNrs = range(1,50,1); ?>
<?php foreach($fieldNrs as $nr): ?>jQuery('#jform_addcustom_admin_views_modal').on('change', 'select[name="icomoon-<?php echo $nr; ?>"]',function (e) {
	// update the icon if changed
	var val_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"] option:selected').val();
	// build new span
	var span = '<span id="icon_addcustom_admin_views_fields_icomoon_<?php echo $nr; ?>" class="icon-'+val_<?php echo $nr; ?>+'"></span>';
	// remove old one 
	jQuery('#icon_addcustom_admin_views_fields_icomoon_<?php echo $nr; ?>').remove();
	// add the new icon
	jQuery('#jform_addcustom_admin_views_fields_icomoon_<?php echo $nr; ?>_chzn').closest("td").append(span);
});

jQuery(document).ready(function() {
jQuery('input.form-field-repeatable').on('row-add', function (e) {
	// show the icon if set
	var val_<?php echo $nr; ?> = jQuery('#jform_addcustom_admin_views_fields_icomoon-<?php echo $nr; ?>').val();
	// build new span
	var span = '<span id="icon_addcustom_admin_views_fields_icomoon_<?php echo $nr; ?>" class="icon-'+val_<?php echo $nr; ?>+'"></span>';
	// remove old one 
	jQuery('#icon_addcustom_admin_views_fields_icomoon_<?php echo $nr; ?>').remove();
	// add the new icon
	jQuery('#jform_addcustom_admin_views_fields_icomoon_<?php echo $nr; ?>_chzn').closest("td").append(span);
});
});
<?php endforeach; ?>
</script>
