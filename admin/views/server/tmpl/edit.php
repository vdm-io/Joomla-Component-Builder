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
</div>
</form>
</div>

<script type="text/javascript">

// #jform_protocol listeners for protocol_vvvvwba function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwba = jQuery("#jform_protocol").val();
	vvvvwba(protocol_vvvvwba);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwba = jQuery("#jform_protocol").val();
	vvvvwba(protocol_vvvvwba);

});

// #jform_protocol listeners for protocol_vvvvwbb function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbb = jQuery("#jform_protocol").val();
	vvvvwbb(protocol_vvvvwbb);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbb = jQuery("#jform_protocol").val();
	vvvvwbb(protocol_vvvvwbb);

});

// #jform_protocol listeners for protocol_vvvvwbc function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbc = jQuery("#jform_protocol").val();
	var authentication_vvvvwbc = jQuery("#jform_authentication").val();
	vvvvwbc(protocol_vvvvwbc,authentication_vvvvwbc);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbc = jQuery("#jform_protocol").val();
	var authentication_vvvvwbc = jQuery("#jform_authentication").val();
	vvvvwbc(protocol_vvvvwbc,authentication_vvvvwbc);

});

// #jform_authentication listeners for authentication_vvvvwbc function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwbc = jQuery("#jform_protocol").val();
	var authentication_vvvvwbc = jQuery("#jform_authentication").val();
	vvvvwbc(protocol_vvvvwbc,authentication_vvvvwbc);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbc = jQuery("#jform_protocol").val();
	var authentication_vvvvwbc = jQuery("#jform_authentication").val();
	vvvvwbc(protocol_vvvvwbc,authentication_vvvvwbc);

});

// #jform_protocol listeners for protocol_vvvvwbe function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbe = jQuery("#jform_protocol").val();
	var authentication_vvvvwbe = jQuery("#jform_authentication").val();
	vvvvwbe(protocol_vvvvwbe,authentication_vvvvwbe);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbe = jQuery("#jform_protocol").val();
	var authentication_vvvvwbe = jQuery("#jform_authentication").val();
	vvvvwbe(protocol_vvvvwbe,authentication_vvvvwbe);

});

// #jform_authentication listeners for authentication_vvvvwbe function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwbe = jQuery("#jform_protocol").val();
	var authentication_vvvvwbe = jQuery("#jform_authentication").val();
	vvvvwbe(protocol_vvvvwbe,authentication_vvvvwbe);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbe = jQuery("#jform_protocol").val();
	var authentication_vvvvwbe = jQuery("#jform_authentication").val();
	vvvvwbe(protocol_vvvvwbe,authentication_vvvvwbe);

});

// #jform_protocol listeners for protocol_vvvvwbg function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbg = jQuery("#jform_protocol").val();
	var authentication_vvvvwbg = jQuery("#jform_authentication").val();
	vvvvwbg(protocol_vvvvwbg,authentication_vvvvwbg);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbg = jQuery("#jform_protocol").val();
	var authentication_vvvvwbg = jQuery("#jform_authentication").val();
	vvvvwbg(protocol_vvvvwbg,authentication_vvvvwbg);

});

// #jform_authentication listeners for authentication_vvvvwbg function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwbg = jQuery("#jform_protocol").val();
	var authentication_vvvvwbg = jQuery("#jform_authentication").val();
	vvvvwbg(protocol_vvvvwbg,authentication_vvvvwbg);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbg = jQuery("#jform_protocol").val();
	var authentication_vvvvwbg = jQuery("#jform_authentication").val();
	vvvvwbg(protocol_vvvvwbg,authentication_vvvvwbg);

});

// #jform_protocol listeners for protocol_vvvvwbi function
jQuery('#jform_protocol').on('keyup',function()
{
	var protocol_vvvvwbi = jQuery("#jform_protocol").val();
	var authentication_vvvvwbi = jQuery("#jform_authentication").val();
	vvvvwbi(protocol_vvvvwbi,authentication_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_protocol',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbi = jQuery("#jform_protocol").val();
	var authentication_vvvvwbi = jQuery("#jform_authentication").val();
	vvvvwbi(protocol_vvvvwbi,authentication_vvvvwbi);

});

// #jform_authentication listeners for authentication_vvvvwbi function
jQuery('#jform_authentication').on('keyup',function()
{
	var protocol_vvvvwbi = jQuery("#jform_protocol").val();
	var authentication_vvvvwbi = jQuery("#jform_authentication").val();
	vvvvwbi(protocol_vvvvwbi,authentication_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_authentication',function (e)
{
	e.preventDefault();
	var protocol_vvvvwbi = jQuery("#jform_protocol").val();
	var authentication_vvvvwbi = jQuery("#jform_authentication").val();
	vvvvwbi(protocol_vvvvwbi,authentication_vvvvwbi);

});

</script>
