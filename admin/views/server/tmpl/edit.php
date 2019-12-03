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

// #jform_protocol listeners for protocol_vvvvwea function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwea = jQuery("#jform_protocol").val();
	vvvvwea(protocol_vvvvwea);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwea = jQuery("#jform_protocol").val();
	vvvvwea(protocol_vvvvwea);

});

// #jform_protocol listeners for protocol_vvvvweb function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvweb = jQuery("#jform_protocol").val();
	vvvvweb(protocol_vvvvweb);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvweb = jQuery("#jform_protocol").val();
	vvvvweb(protocol_vvvvweb);

});

// #jform_protocol listeners for protocol_vvvvwec function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

});

// #jform_authentication listeners for authentication_vvvvwec function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

});

// #jform_protocol listeners for protocol_vvvvwee function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

});

// #jform_authentication listeners for authentication_vvvvwee function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

});

// #jform_protocol listeners for protocol_vvvvweg function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

});

// #jform_authentication listeners for authentication_vvvvweg function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

});

// #jform_protocol listeners for protocol_vvvvwei function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwei = jQuery("#jform_protocol").val();
	var authentication_vvvvwei = jQuery("#jform_authentication").val();
	vvvvwei(protocol_vvvvwei,authentication_vvvvwei);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwei = jQuery("#jform_protocol").val();
	var authentication_vvvvwei = jQuery("#jform_authentication").val();
	vvvvwei(protocol_vvvvwei,authentication_vvvvwei);

});

// #jform_authentication listeners for authentication_vvvvwei function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwei = jQuery("#jform_protocol").val();
	var authentication_vvvvwei = jQuery("#jform_authentication").val();
	vvvvwei(protocol_vvvvwei,authentication_vvvvwei);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwei = jQuery("#jform_protocol").val();
	var authentication_vvvvwei = jQuery("#jform_authentication").val();
	vvvvwei(protocol_vvvvwei,authentication_vvvvwei);

});

</script>
