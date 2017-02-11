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

	@version		@update number 35 of this MVC
	@build			10th February, 2017
	@created		11th October, 2016
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

	<?php echo JLayoutHelper::render('custom_code.details_above', $this); ?><div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'custom_codeTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'custom_codeTab', 'details', JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('custom_code.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('custom_code.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('custom_code.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('custom_code.delete') || $this->canDo->get('custom_code.edit.created_by') || $this->canDo->get('custom_code.edit.state') || $this->canDo->get('custom_code.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'custom_codeTab', 'publishing', JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('custom_code.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('custom_code.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'custom_codeTab', 'permissions', JText::_('COM_COMPONENTBUILDER_CUSTOM_CODE_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="custom_code.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('custom_code.details_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_target listeners for target_vvvvvzo function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvvzo = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzo(target_vvvvvzo);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvvzo = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzo(target_vvvvvzo);

});

// #jform_target listeners for target_vvvvvzp function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvvzp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzp(target_vvvvvzp);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvvzp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzp(target_vvvvvzp);

});

// #jform_target listeners for target_vvvvvzq function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvvzq = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvvzq = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvvzq(target_vvvvvzq,type_vvvvvzq);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvvzq = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvvzq = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvvzq(target_vvvvvzq,type_vvvvvzq);

});

// #jform_type listeners for type_vvvvvzq function
jQuery('#jform_type').on('keyup',function()
{
	var target_vvvvvzq = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvvzq = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvvzq(target_vvvvvzq,type_vvvvvzq);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var target_vvvvvzq = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvvzq = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvvzq(target_vvvvvzq,type_vvvvvzq);

});

// #jform_type listeners for type_vvvvvzr function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvvzr = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvvzr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzr(type_vvvvvzr,target_vvvvvzr);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvvzr = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvvzr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzr(type_vvvvvzr,target_vvvvvzr);

});

// #jform_target listeners for target_vvvvvzr function
jQuery('#jform_target').on('keyup',function()
{
	var type_vvvvvzr = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvvzr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzr(type_vvvvvzr,target_vvvvvzr);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var type_vvvvvzr = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvvzr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzr(type_vvvvvzr,target_vvvvvzr);

});


var ide = jQuery('#jform_id').val();
if (ide > 0) {
	jQuery('#jcb-placeholder').html('<code> [CUSTO'+'MCODE='+ide+'] </code>');
	jQuery('#jcb-placeholder-arg').html('<code> [CUSTO'+'MCODE='+ide+'&#43;value1,value2] </code>');
}
</script>
