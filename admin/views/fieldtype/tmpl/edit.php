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

	<?php echo JLayoutHelper::render('fieldtype.details_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'fieldtypeTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'details', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('fieldtype.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'database_defaults', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_DATABASE_DEFAULTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.database_defaults_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.database_defaults_right', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('field.access')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'fields', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_FIELDS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('fieldtype.fields_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'fieldtypeTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('fieldtype.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('fieldtype.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'publishing', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('fieldtype.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'fieldtypeTab', 'permissions', JText::_('COM_COMPONENTBUILDER_FIELDTYPE_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="fieldtype.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_datalenght listeners for datalenght_vvvvwba function
jQuery('#jform_datalenght').on('keyup',function()
{
	var datalenght_vvvvwba = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwba = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwba(datalenght_vvvvwba,has_defaults_vvvvwba);

});
jQuery('#adminForm').on('change', '#jform_datalenght',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwba = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwba = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwba(datalenght_vvvvwba,has_defaults_vvvvwba);

});

// #jform_has_defaults listeners for has_defaults_vvvvwba function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datalenght_vvvvwba = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwba = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwba(datalenght_vvvvwba,has_defaults_vvvvwba);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwba = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwba = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwba(datalenght_vvvvwba,has_defaults_vvvvwba);

});

// #jform_datadefault listeners for datadefault_vvvvwbc function
jQuery('#jform_datadefault').on('keyup',function()
{
	var datadefault_vvvvwbc = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbc(datadefault_vvvvwbc,has_defaults_vvvvwbc);

});
jQuery('#adminForm').on('change', '#jform_datadefault',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwbc = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbc(datadefault_vvvvwbc,has_defaults_vvvvwbc);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbc function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datadefault_vvvvwbc = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbc(datadefault_vvvvwbc,has_defaults_vvvvwbc);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwbc = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbc = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbc(datadefault_vvvvwbc,has_defaults_vvvvwbc);

});

// #jform_datatype listeners for datatype_vvvvwbe function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbe = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbe = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbe(datatype_vvvvwbe,has_defaults_vvvvwbe);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbe = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbe = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbe(datatype_vvvvwbe,has_defaults_vvvvwbe);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbe function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwbe = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbe = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbe(datatype_vvvvwbe,has_defaults_vvvvwbe);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbe = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbe = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbe(datatype_vvvvwbe,has_defaults_vvvvwbe);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbf function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwbf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbf = jQuery("#jform_datatype").val();
	vvvvwbf(has_defaults_vvvvwbf,datatype_vvvvwbf);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbf = jQuery("#jform_datatype").val();
	vvvvwbf(has_defaults_vvvvwbf,datatype_vvvvwbf);

});

// #jform_datatype listeners for datatype_vvvvwbf function
jQuery('#jform_datatype').on('keyup',function()
{
	var has_defaults_vvvvwbf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbf = jQuery("#jform_datatype").val();
	vvvvwbf(has_defaults_vvvvwbf,datatype_vvvvwbf);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbf = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbf = jQuery("#jform_datatype").val();
	vvvvwbf(has_defaults_vvvvwbf,datatype_vvvvwbf);

});

// #jform_datatype listeners for datatype_vvvvwbg function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbg = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbg(datatype_vvvvwbg,has_defaults_vvvvwbg);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbg = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbg(datatype_vvvvwbg,has_defaults_vvvvwbg);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbg function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwbg = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbg(datatype_vvvvwbg,has_defaults_vvvvwbg);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbg = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbg = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbg(datatype_vvvvwbg,has_defaults_vvvvwbg);

});

// #jform_store listeners for store_vvvvwbi function
jQuery('#jform_store').on('keyup',function()
{
	var store_vvvvwbi = jQuery("#jform_store").val();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbi(store_vvvvwbi,datatype_vvvvwbi,has_defaults_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_vvvvwbi = jQuery("#jform_store").val();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbi(store_vvvvwbi,datatype_vvvvwbi,has_defaults_vvvvwbi);

});

// #jform_datatype listeners for datatype_vvvvwbi function
jQuery('#jform_datatype').on('keyup',function()
{
	var store_vvvvwbi = jQuery("#jform_store").val();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbi(store_vvvvwbi,datatype_vvvvwbi,has_defaults_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var store_vvvvwbi = jQuery("#jform_store").val();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbi(store_vvvvwbi,datatype_vvvvwbi,has_defaults_vvvvwbi);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbi function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var store_vvvvwbi = jQuery("#jform_store").val();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbi(store_vvvvwbi,datatype_vvvvwbi,has_defaults_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var store_vvvvwbi = jQuery("#jform_store").val();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbi = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbi(store_vvvvwbi,datatype_vvvvwbi,has_defaults_vvvvwbi);

});

// #jform_datatype listeners for datatype_vvvvwbj function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var store_vvvvwbj = jQuery("#jform_store").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datatype_vvvvwbj,store_vvvvwbj,has_defaults_vvvvwbj);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var store_vvvvwbj = jQuery("#jform_store").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datatype_vvvvwbj,store_vvvvwbj,has_defaults_vvvvwbj);

});

// #jform_store listeners for store_vvvvwbj function
jQuery('#jform_store').on('keyup',function()
{
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var store_vvvvwbj = jQuery("#jform_store").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datatype_vvvvwbj,store_vvvvwbj,has_defaults_vvvvwbj);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var store_vvvvwbj = jQuery("#jform_store").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datatype_vvvvwbj,store_vvvvwbj,has_defaults_vvvvwbj);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbj function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var store_vvvvwbj = jQuery("#jform_store").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datatype_vvvvwbj,store_vvvvwbj,has_defaults_vvvvwbj);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	var store_vvvvwbj = jQuery("#jform_store").val();
	var has_defaults_vvvvwbj = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbj(datatype_vvvvwbj,store_vvvvwbj,has_defaults_vvvvwbj);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbk function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbk = jQuery("#jform_store").val();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(has_defaults_vvvvwbk,store_vvvvwbk,datatype_vvvvwbk);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbk = jQuery("#jform_store").val();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(has_defaults_vvvvwbk,store_vvvvwbk,datatype_vvvvwbk);

});

// #jform_store listeners for store_vvvvwbk function
jQuery('#jform_store').on('keyup',function()
{
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbk = jQuery("#jform_store").val();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(has_defaults_vvvvwbk,store_vvvvwbk,datatype_vvvvwbk);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbk = jQuery("#jform_store").val();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(has_defaults_vvvvwbk,store_vvvvwbk,datatype_vvvvwbk);

});

// #jform_datatype listeners for datatype_vvvvwbk function
jQuery('#jform_datatype').on('keyup',function()
{
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbk = jQuery("#jform_store").val();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(has_defaults_vvvvwbk,store_vvvvwbk,datatype_vvvvwbk);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbk = jQuery("#jform_store").val();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(has_defaults_vvvvwbk,store_vvvvwbk,datatype_vvvvwbk);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbl function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwbl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbl(has_defaults_vvvvwbl);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbl = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbl(has_defaults_vvvvwbl);

});

</script>
