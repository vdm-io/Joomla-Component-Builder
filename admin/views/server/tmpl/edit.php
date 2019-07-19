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

// #jform_protocol listeners for protocol_vvvvwbw function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbw = jQuery("#jform_protocol").val();
	vvvvwbw(protocol_vvvvwbw);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbw = jQuery("#jform_protocol").val();
	vvvvwbw(protocol_vvvvwbw);

});

// #jform_protocol listeners for protocol_vvvvwbx function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbx = jQuery("#jform_protocol").val();
	vvvvwbx(protocol_vvvvwbx);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbx = jQuery("#jform_protocol").val();
	vvvvwbx(protocol_vvvvwbx);

});

// #jform_protocol listeners for protocol_vvvvwby function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwby = jQuery("#jform_protocol").val();
	var authentication_vvvvwby = jQuery("#jform_authentication").val();
	vvvvwby(protocol_vvvvwby,authentication_vvvvwby);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwby = jQuery("#jform_protocol").val();
	var authentication_vvvvwby = jQuery("#jform_authentication").val();
	vvvvwby(protocol_vvvvwby,authentication_vvvvwby);

});

// #jform_authentication listeners for authentication_vvvvwby function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwby = jQuery("#jform_protocol").val();
	var authentication_vvvvwby = jQuery("#jform_authentication").val();
	vvvvwby(protocol_vvvvwby,authentication_vvvvwby);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwby = jQuery("#jform_protocol").val();
	var authentication_vvvvwby = jQuery("#jform_authentication").val();
	vvvvwby(protocol_vvvvwby,authentication_vvvvwby);

});

// #jform_protocol listeners for protocol_vvvvwca function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwca = jQuery("#jform_protocol").val();
	var authentication_vvvvwca = jQuery("#jform_authentication").val();
	vvvvwca(protocol_vvvvwca,authentication_vvvvwca);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwca = jQuery("#jform_protocol").val();
	var authentication_vvvvwca = jQuery("#jform_authentication").val();
	vvvvwca(protocol_vvvvwca,authentication_vvvvwca);

});

// #jform_authentication listeners for authentication_vvvvwca function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwca = jQuery("#jform_protocol").val();
	var authentication_vvvvwca = jQuery("#jform_authentication").val();
	vvvvwca(protocol_vvvvwca,authentication_vvvvwca);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwca = jQuery("#jform_protocol").val();
	var authentication_vvvvwca = jQuery("#jform_authentication").val();
	vvvvwca(protocol_vvvvwca,authentication_vvvvwca);

});

// #jform_protocol listeners for protocol_vvvvwcc function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwcc = jQuery("#jform_protocol").val();
	var authentication_vvvvwcc = jQuery("#jform_authentication").val();
	vvvvwcc(protocol_vvvvwcc,authentication_vvvvwcc);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcc = jQuery("#jform_protocol").val();
	var authentication_vvvvwcc = jQuery("#jform_authentication").val();
	vvvvwcc(protocol_vvvvwcc,authentication_vvvvwcc);

});

// #jform_authentication listeners for authentication_vvvvwcc function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwcc = jQuery("#jform_protocol").val();
	var authentication_vvvvwcc = jQuery("#jform_authentication").val();
	vvvvwcc(protocol_vvvvwcc,authentication_vvvvwcc);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwcc = jQuery("#jform_protocol").val();
	var authentication_vvvvwcc = jQuery("#jform_authentication").val();
	vvvvwcc(protocol_vvvvwcc,authentication_vvvvwcc);

});

// #jform_protocol listeners for protocol_vvvvwce function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwce = jQuery("#jform_protocol").val();
	var authentication_vvvvwce = jQuery("#jform_authentication").val();
	vvvvwce(protocol_vvvvwce,authentication_vvvvwce);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwce = jQuery("#jform_protocol").val();
	var authentication_vvvvwce = jQuery("#jform_authentication").val();
	vvvvwce(protocol_vvvvwce,authentication_vvvvwce);

});

// #jform_authentication listeners for authentication_vvvvwce function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwce = jQuery("#jform_protocol").val();
	var authentication_vvvvwce = jQuery("#jform_authentication").val();
	vvvvwce(protocol_vvvvwce,authentication_vvvvwce);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwce = jQuery("#jform_protocol").val();
	var authentication_vvvvwce = jQuery("#jform_authentication").val();
	vvvvwce(protocol_vvvvwce,authentication_vvvvwce);

});

</script>
