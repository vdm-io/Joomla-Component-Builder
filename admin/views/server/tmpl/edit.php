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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$componentParams = $this->params; // will be removed just use $this->params instead
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
<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('server.details_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'serverTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'serverTab', 'details', JText::_('COM_COMPONENTBUILDER_SERVER_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('server.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('server.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('server.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('joomla_component.access')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'serverTab', 'linked_components', JText::_('COM_COMPONENTBUILDER_SERVER_LINKED_COMPONENTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('server.linked_components_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'serverTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('server.delete') || $this->canDo->get('server.edit.created_by') || $this->canDo->get('server.edit.state') || $this->canDo->get('server.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'serverTab', 'publishing', JText::_('COM_COMPONENTBUILDER_SERVER_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('server.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('server.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'serverTab', 'permissions', JText::_('COM_COMPONENTBUILDER_SERVER_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="server.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_protocol listeners for protocol_vvvvwbp function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbp = jQuery("#jform_protocol").val();
	vvvvwbp(protocol_vvvvwbp);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbp = jQuery("#jform_protocol").val();
	vvvvwbp(protocol_vvvvwbp);

});

// #jform_protocol listeners for protocol_vvvvwbq function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbq = jQuery("#jform_protocol").val();
	vvvvwbq(protocol_vvvvwbq);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbq = jQuery("#jform_protocol").val();
	vvvvwbq(protocol_vvvvwbq);

});

// #jform_protocol listeners for protocol_vvvvwbr function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbr = jQuery("#jform_protocol").val();
	var authentication_vvvvwbr = jQuery("#jform_authentication").val();
	vvvvwbr(protocol_vvvvwbr,authentication_vvvvwbr);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbr = jQuery("#jform_protocol").val();
	var authentication_vvvvwbr = jQuery("#jform_authentication").val();
	vvvvwbr(protocol_vvvvwbr,authentication_vvvvwbr);

});

// #jform_authentication listeners for authentication_vvvvwbr function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwbr = jQuery("#jform_protocol").val();
	var authentication_vvvvwbr = jQuery("#jform_authentication").val();
	vvvvwbr(protocol_vvvvwbr,authentication_vvvvwbr);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbr = jQuery("#jform_protocol").val();
	var authentication_vvvvwbr = jQuery("#jform_authentication").val();
	vvvvwbr(protocol_vvvvwbr,authentication_vvvvwbr);

});

// #jform_protocol listeners for protocol_vvvvwbt function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbt = jQuery("#jform_protocol").val();
	var authentication_vvvvwbt = jQuery("#jform_authentication").val();
	vvvvwbt(protocol_vvvvwbt,authentication_vvvvwbt);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbt = jQuery("#jform_protocol").val();
	var authentication_vvvvwbt = jQuery("#jform_authentication").val();
	vvvvwbt(protocol_vvvvwbt,authentication_vvvvwbt);

});

// #jform_authentication listeners for authentication_vvvvwbt function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwbt = jQuery("#jform_protocol").val();
	var authentication_vvvvwbt = jQuery("#jform_authentication").val();
	vvvvwbt(protocol_vvvvwbt,authentication_vvvvwbt);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbt = jQuery("#jform_protocol").val();
	var authentication_vvvvwbt = jQuery("#jform_authentication").val();
	vvvvwbt(protocol_vvvvwbt,authentication_vvvvwbt);

});

// #jform_protocol listeners for protocol_vvvvwbv function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbv = jQuery("#jform_protocol").val();
	var authentication_vvvvwbv = jQuery("#jform_authentication").val();
	vvvvwbv(protocol_vvvvwbv,authentication_vvvvwbv);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbv = jQuery("#jform_protocol").val();
	var authentication_vvvvwbv = jQuery("#jform_authentication").val();
	vvvvwbv(protocol_vvvvwbv,authentication_vvvvwbv);

});

// #jform_authentication listeners for authentication_vvvvwbv function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwbv = jQuery("#jform_protocol").val();
	var authentication_vvvvwbv = jQuery("#jform_authentication").val();
	vvvvwbv(protocol_vvvvwbv,authentication_vvvvwbv);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbv = jQuery("#jform_protocol").val();
	var authentication_vvvvwbv = jQuery("#jform_authentication").val();
	vvvvwbv(protocol_vvvvwbv,authentication_vvvvwbv);

});

// #jform_protocol listeners for protocol_vvvvwbx function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbx = jQuery("#jform_protocol").val();
	var authentication_vvvvwbx = jQuery("#jform_authentication").val();
	vvvvwbx(protocol_vvvvwbx,authentication_vvvvwbx);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbx = jQuery("#jform_protocol").val();
	var authentication_vvvvwbx = jQuery("#jform_authentication").val();
	vvvvwbx(protocol_vvvvwbx,authentication_vvvvwbx);

});

// #jform_authentication listeners for authentication_vvvvwbx function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwbx = jQuery("#jform_protocol").val();
	var authentication_vvvvwbx = jQuery("#jform_authentication").val();
	vvvvwbx(protocol_vvvvwbx,authentication_vvvvwbx);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbx = jQuery("#jform_protocol").val();
	var authentication_vvvvwbx = jQuery("#jform_authentication").val();
	vvvvwbx(protocol_vvvvwbx,authentication_vvvvwbx);

});

</script>
