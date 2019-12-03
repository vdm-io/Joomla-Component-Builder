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

	<?php echo JLayoutHelper::render('help_document.details_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'help_documentTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'help_documentTab', 'details', JText::_('COM_COMPONENTBUILDER_HELP_DOCUMENT_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('help_document.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('help_document.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('help_document.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'help_documentTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('help_document.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('help_document.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'help_documentTab', 'publishing', JText::_('COM_COMPONENTBUILDER_HELP_DOCUMENT_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('help_document.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('help_document.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'help_documentTab', 'permissions', JText::_('COM_COMPONENTBUILDER_HELP_DOCUMENT_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="help_document.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('help_document.details_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_location listeners for location_vvvvwek function
jQuery('#jform_location').on('keyup',function()
{
	var location_vvvvwek = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwek(location_vvvvwek);

});
jQuery('#adminForm').on('change', '#jform_location',function (e)
{
	e.preventDefault();
	var location_vvvvwek = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwek(location_vvvvwek);

});

// #jform_location listeners for location_vvvvwel function
jQuery('#jform_location').on('keyup',function()
{
	var location_vvvvwel = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwel(location_vvvvwel);

});
jQuery('#adminForm').on('change', '#jform_location',function (e)
{
	e.preventDefault();
	var location_vvvvwel = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwel(location_vvvvwel);

});

// #jform_type listeners for type_vvvvwem function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvwem = jQuery("#jform_type").val();
	vvvvwem(type_vvvvwem);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvwem = jQuery("#jform_type").val();
	vvvvwem(type_vvvvwem);

});

// #jform_type listeners for type_vvvvwen function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvwen = jQuery("#jform_type").val();
	vvvvwen(type_vvvvwen);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvwen = jQuery("#jform_type").val();
	vvvvwen(type_vvvvwen);

});

// #jform_type listeners for type_vvvvweo function
jQuery('#jform_type').on('keyup',function()
{
	var type_vvvvweo = jQuery("#jform_type").val();
	vvvvweo(type_vvvvweo);

});
jQuery('#adminForm').on('change', '#jform_type',function (e)
{
	e.preventDefault();
	var type_vvvvweo = jQuery("#jform_type").val();
	vvvvweo(type_vvvvweo);

});

// #jform_target listeners for target_vvvvwep function
jQuery('#jform_target').on('keyup',function()
{
	var target_vvvvwep = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwep(target_vvvvwep);

});
jQuery('#adminForm').on('change', '#jform_target',function (e)
{
	e.preventDefault();
	var target_vvvvwep = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwep(target_vvvvwep);

});

</script>
