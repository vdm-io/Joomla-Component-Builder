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
</form>
</div>

<script type="text/javascript">

// #jform_datalenght listeners for datalenght_vvvvwbk function
jQuery('#jform_datalenght').on('keyup',function()
{
	var datalenght_vvvvwbk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbk(datalenght_vvvvwbk,has_defaults_vvvvwbk);

});
jQuery('#adminForm').on('change', '#jform_datalenght',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwbk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbk(datalenght_vvvvwbk,has_defaults_vvvvwbk);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbk function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datalenght_vvvvwbk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbk(datalenght_vvvvwbk,has_defaults_vvvvwbk);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwbk = jQuery("#jform_datalenght").val();
	var has_defaults_vvvvwbk = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbk(datalenght_vvvvwbk,has_defaults_vvvvwbk);

});

// #jform_datadefault listeners for datadefault_vvvvwbm function
jQuery('#jform_datadefault').on('keyup',function()
{
	var datadefault_vvvvwbm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbm(datadefault_vvvvwbm,has_defaults_vvvvwbm);

});
jQuery('#adminForm').on('change', '#jform_datadefault',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwbm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbm(datadefault_vvvvwbm,has_defaults_vvvvwbm);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbm function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datadefault_vvvvwbm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbm(datadefault_vvvvwbm,has_defaults_vvvvwbm);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwbm = jQuery("#jform_datadefault").val();
	var has_defaults_vvvvwbm = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbm(datadefault_vvvvwbm,has_defaults_vvvvwbm);

});

// #jform_datatype listeners for datatype_vvvvwbo function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbo(datatype_vvvvwbo,has_defaults_vvvvwbo);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbo(datatype_vvvvwbo,has_defaults_vvvvwbo);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbo function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwbo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbo(datatype_vvvvwbo,has_defaults_vvvvwbo);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbo = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbo = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbo(datatype_vvvvwbo,has_defaults_vvvvwbo);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbp function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwbp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbp = jQuery("#jform_datatype").val();
	vvvvwbp(has_defaults_vvvvwbp,datatype_vvvvwbp);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbp = jQuery("#jform_datatype").val();
	vvvvwbp(has_defaults_vvvvwbp,datatype_vvvvwbp);

});

// #jform_datatype listeners for datatype_vvvvwbp function
jQuery('#jform_datatype').on('keyup',function()
{
	var has_defaults_vvvvwbp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbp = jQuery("#jform_datatype").val();
	vvvvwbp(has_defaults_vvvvwbp,datatype_vvvvwbp);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbp = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var datatype_vvvvwbp = jQuery("#jform_datatype").val();
	vvvvwbp(has_defaults_vvvvwbp,datatype_vvvvwbp);

});

// #jform_datatype listeners for datatype_vvvvwbq function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datatype_vvvvwbq,has_defaults_vvvvwbq);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datatype_vvvvwbq,has_defaults_vvvvwbq);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbq function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwbq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datatype_vvvvwbq,has_defaults_vvvvwbq);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbq = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbq = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbq(datatype_vvvvwbq,has_defaults_vvvvwbq);

});

// #jform_store listeners for store_vvvvwbs function
jQuery('#jform_store').on('keyup',function()
{
	var store_vvvvwbs = jQuery("#jform_store").val();
	var datatype_vvvvwbs = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(store_vvvvwbs,datatype_vvvvwbs,has_defaults_vvvvwbs);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_vvvvwbs = jQuery("#jform_store").val();
	var datatype_vvvvwbs = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(store_vvvvwbs,datatype_vvvvwbs,has_defaults_vvvvwbs);

});

// #jform_datatype listeners for datatype_vvvvwbs function
jQuery('#jform_datatype').on('keyup',function()
{
	var store_vvvvwbs = jQuery("#jform_store").val();
	var datatype_vvvvwbs = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(store_vvvvwbs,datatype_vvvvwbs,has_defaults_vvvvwbs);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var store_vvvvwbs = jQuery("#jform_store").val();
	var datatype_vvvvwbs = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(store_vvvvwbs,datatype_vvvvwbs,has_defaults_vvvvwbs);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbs function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var store_vvvvwbs = jQuery("#jform_store").val();
	var datatype_vvvvwbs = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(store_vvvvwbs,datatype_vvvvwbs,has_defaults_vvvvwbs);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var store_vvvvwbs = jQuery("#jform_store").val();
	var datatype_vvvvwbs = jQuery("#jform_datatype").val();
	var has_defaults_vvvvwbs = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbs(store_vvvvwbs,datatype_vvvvwbs,has_defaults_vvvvwbs);

});

// #jform_datatype listeners for datatype_vvvvwbt function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbt = jQuery("#jform_datatype").val();
	var store_vvvvwbt = jQuery("#jform_store").val();
	var has_defaults_vvvvwbt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbt(datatype_vvvvwbt,store_vvvvwbt,has_defaults_vvvvwbt);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbt = jQuery("#jform_datatype").val();
	var store_vvvvwbt = jQuery("#jform_store").val();
	var has_defaults_vvvvwbt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbt(datatype_vvvvwbt,store_vvvvwbt,has_defaults_vvvvwbt);

});

// #jform_store listeners for store_vvvvwbt function
jQuery('#jform_store').on('keyup',function()
{
	var datatype_vvvvwbt = jQuery("#jform_datatype").val();
	var store_vvvvwbt = jQuery("#jform_store").val();
	var has_defaults_vvvvwbt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbt(datatype_vvvvwbt,store_vvvvwbt,has_defaults_vvvvwbt);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbt = jQuery("#jform_datatype").val();
	var store_vvvvwbt = jQuery("#jform_store").val();
	var has_defaults_vvvvwbt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbt(datatype_vvvvwbt,store_vvvvwbt,has_defaults_vvvvwbt);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbt function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var datatype_vvvvwbt = jQuery("#jform_datatype").val();
	var store_vvvvwbt = jQuery("#jform_store").val();
	var has_defaults_vvvvwbt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbt(datatype_vvvvwbt,store_vvvvwbt,has_defaults_vvvvwbt);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbt = jQuery("#jform_datatype").val();
	var store_vvvvwbt = jQuery("#jform_store").val();
	var has_defaults_vvvvwbt = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbt(datatype_vvvvwbt,store_vvvvwbt,has_defaults_vvvvwbt);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbu function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbu = jQuery("#jform_store").val();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	vvvvwbu(has_defaults_vvvvwbu,store_vvvvwbu,datatype_vvvvwbu);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbu = jQuery("#jform_store").val();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	vvvvwbu(has_defaults_vvvvwbu,store_vvvvwbu,datatype_vvvvwbu);

});

// #jform_store listeners for store_vvvvwbu function
jQuery('#jform_store').on('keyup',function()
{
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbu = jQuery("#jform_store").val();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	vvvvwbu(has_defaults_vvvvwbu,store_vvvvwbu,datatype_vvvvwbu);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbu = jQuery("#jform_store").val();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	vvvvwbu(has_defaults_vvvvwbu,store_vvvvwbu,datatype_vvvvwbu);

});

// #jform_datatype listeners for datatype_vvvvwbu function
jQuery('#jform_datatype').on('keyup',function()
{
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbu = jQuery("#jform_store").val();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	vvvvwbu(has_defaults_vvvvwbu,store_vvvvwbu,datatype_vvvvwbu);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbu = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	var store_vvvvwbu = jQuery("#jform_store").val();
	var datatype_vvvvwbu = jQuery("#jform_datatype").val();
	vvvvwbu(has_defaults_vvvvwbu,store_vvvvwbu,datatype_vvvvwbu);

});

// #jform_has_defaults listeners for has_defaults_vvvvwbv function
jQuery('#jform_has_defaults').on('keyup',function()
{
	var has_defaults_vvvvwbv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbv(has_defaults_vvvvwbv);

});
jQuery('#adminForm').on('change', '#jform_has_defaults',function (e)
{
	e.preventDefault();
	var has_defaults_vvvvwbv = jQuery("#jform_has_defaults input[type='radio']:checked").val();
	vvvvwbv(has_defaults_vvvvwbv);

});




<?php
	$app = JFactory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isSite())
	{
		echo 'var url = "'.JURI::root().'";';
	}
	else
	{
		echo 'var url = "";';
	}
?>
	return url+link;
}
</script>
