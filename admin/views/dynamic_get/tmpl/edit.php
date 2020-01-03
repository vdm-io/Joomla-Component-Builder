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

	<?php echo JLayoutHelper::render('dynamic_get.main_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'dynamic_getTab', array('active' => 'main')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'main', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_MAIN', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.main_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.main_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.main_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'tweak', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_TWEAK', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.tweak_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'joint', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_JOINT', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.joint_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'custom_script', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_CUSTOM_SCRIPT', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.custom_script_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'abacus', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_ABACUS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.abacus_left', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('dynamic_get.abacus_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'dynamic_getTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('dynamic_get.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('dynamic_get.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'publishing', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('dynamic_get.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'dynamic_getTab', 'permissions', JText::_('COM_COMPONENTBUILDER_DYNAMIC_GET_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="dynamic_get.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('dynamic_get.main_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_gettype listeners for gettype_vvvvwba function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwba = jQuery("#jform_gettype").val();
	vvvvwba(gettype_vvvvwba);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwba = jQuery("#jform_gettype").val();
	vvvvwba(gettype_vvvvwba);

});

// #jform_main_source listeners for main_source_vvvvwbb function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvwbb = jQuery("#jform_main_source").val();
	vvvvwbb(main_source_vvvvwbb);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvwbb = jQuery("#jform_main_source").val();
	vvvvwbb(main_source_vvvvwbb);

});

// #jform_main_source listeners for main_source_vvvvwbc function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvwbc = jQuery("#jform_main_source").val();
	vvvvwbc(main_source_vvvvwbc);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvwbc = jQuery("#jform_main_source").val();
	vvvvwbc(main_source_vvvvwbc);

});

// #jform_main_source listeners for main_source_vvvvwbd function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvwbd = jQuery("#jform_main_source").val();
	vvvvwbd(main_source_vvvvwbd);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvwbd = jQuery("#jform_main_source").val();
	vvvvwbd(main_source_vvvvwbd);

});

// #jform_main_source listeners for main_source_vvvvwbe function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvwbe = jQuery("#jform_main_source").val();
	vvvvwbe(main_source_vvvvwbe);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvwbe = jQuery("#jform_main_source").val();
	vvvvwbe(main_source_vvvvwbe);

});

// #jform_main_source listeners for main_source_vvvvwbf function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvwbf = jQuery("#jform_main_source").val();
	vvvvwbf(main_source_vvvvwbf);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvwbf = jQuery("#jform_main_source").val();
	vvvvwbf(main_source_vvvvwbf);

});

// #jform_addcalculation listeners for addcalculation_vvvvwbg function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvwbg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvwbg(addcalculation_vvvvwbg);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvwbg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvwbg(addcalculation_vvvvwbg);

});

// #jform_addcalculation listeners for addcalculation_vvvvwbh function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvwbh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbh = jQuery("#jform_gettype").val();
	vvvvwbh(addcalculation_vvvvwbh,gettype_vvvvwbh);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvwbh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbh = jQuery("#jform_gettype").val();
	vvvvwbh(addcalculation_vvvvwbh,gettype_vvvvwbh);

});

// #jform_gettype listeners for gettype_vvvvwbh function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvwbh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbh = jQuery("#jform_gettype").val();
	vvvvwbh(addcalculation_vvvvwbh,gettype_vvvvwbh);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvwbh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbh = jQuery("#jform_gettype").val();
	vvvvwbh(addcalculation_vvvvwbh,gettype_vvvvwbh);

});

// #jform_addcalculation listeners for addcalculation_vvvvwbi function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvwbi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbi = jQuery("#jform_gettype").val();
	vvvvwbi(addcalculation_vvvvwbi,gettype_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvwbi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbi = jQuery("#jform_gettype").val();
	vvvvwbi(addcalculation_vvvvwbi,gettype_vvvvwbi);

});

// #jform_gettype listeners for gettype_vvvvwbi function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvwbi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbi = jQuery("#jform_gettype").val();
	vvvvwbi(addcalculation_vvvvwbi,gettype_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvwbi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbi = jQuery("#jform_gettype").val();
	vvvvwbi(addcalculation_vvvvwbi,gettype_vvvvwbi);

});

// #jform_main_source listeners for main_source_vvvvwbl function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvwbl = jQuery("#jform_main_source").val();
	vvvvwbl(main_source_vvvvwbl);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvwbl = jQuery("#jform_main_source").val();
	vvvvwbl(main_source_vvvvwbl);

});

// #jform_main_source listeners for main_source_vvvvwbm function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvwbm = jQuery("#jform_main_source").val();
	vvvvwbm(main_source_vvvvwbm);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvwbm = jQuery("#jform_main_source").val();
	vvvvwbm(main_source_vvvvwbm);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_vvvvwbn function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_vvvvwbn = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbn = jQuery("#jform_gettype").val();
	vvvvwbn(add_php_before_getitem_vvvvwbn,gettype_vvvvwbn);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvwbn = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbn = jQuery("#jform_gettype").val();
	vvvvwbn(add_php_before_getitem_vvvvwbn,gettype_vvvvwbn);

});

// #jform_gettype listeners for gettype_vvvvwbn function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_vvvvwbn = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbn = jQuery("#jform_gettype").val();
	vvvvwbn(add_php_before_getitem_vvvvwbn,gettype_vvvvwbn);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvwbn = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbn = jQuery("#jform_gettype").val();
	vvvvwbn(add_php_before_getitem_vvvvwbn,gettype_vvvvwbn);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_vvvvwbo function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_vvvvwbo = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbo = jQuery("#jform_gettype").val();
	vvvvwbo(add_php_after_getitem_vvvvwbo,gettype_vvvvwbo);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvwbo = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbo = jQuery("#jform_gettype").val();
	vvvvwbo(add_php_after_getitem_vvvvwbo,gettype_vvvvwbo);

});

// #jform_gettype listeners for gettype_vvvvwbo function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_vvvvwbo = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbo = jQuery("#jform_gettype").val();
	vvvvwbo(add_php_after_getitem_vvvvwbo,gettype_vvvvwbo);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvwbo = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbo = jQuery("#jform_gettype").val();
	vvvvwbo(add_php_after_getitem_vvvvwbo,gettype_vvvvwbo);

});

// #jform_gettype listeners for gettype_vvvvwbq function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwbq = jQuery("#jform_gettype").val();
	vvvvwbq(gettype_vvvvwbq);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwbq = jQuery("#jform_gettype").val();
	vvvvwbq(gettype_vvvvwbq);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_vvvvwbr function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_vvvvwbr = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwbr = jQuery("#jform_gettype").val();
	vvvvwbr(add_php_getlistquery_vvvvwbr,gettype_vvvvwbr);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvwbr = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwbr = jQuery("#jform_gettype").val();
	vvvvwbr(add_php_getlistquery_vvvvwbr,gettype_vvvvwbr);

});

// #jform_gettype listeners for gettype_vvvvwbr function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_vvvvwbr = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwbr = jQuery("#jform_gettype").val();
	vvvvwbr(add_php_getlistquery_vvvvwbr,gettype_vvvvwbr);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvwbr = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwbr = jQuery("#jform_gettype").val();
	vvvvwbr(add_php_getlistquery_vvvvwbr,gettype_vvvvwbr);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vvvvwbs function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vvvvwbs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbs = jQuery("#jform_gettype").val();
	vvvvwbs(add_php_before_getitems_vvvvwbs,gettype_vvvvwbs);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvwbs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbs = jQuery("#jform_gettype").val();
	vvvvwbs(add_php_before_getitems_vvvvwbs,gettype_vvvvwbs);

});

// #jform_gettype listeners for gettype_vvvvwbs function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vvvvwbs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbs = jQuery("#jform_gettype").val();
	vvvvwbs(add_php_before_getitems_vvvvwbs,gettype_vvvvwbs);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvwbs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbs = jQuery("#jform_gettype").val();
	vvvvwbs(add_php_before_getitems_vvvvwbs,gettype_vvvvwbs);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_vvvvwbt function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_vvvvwbt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbt = jQuery("#jform_gettype").val();
	vvvvwbt(add_php_after_getitems_vvvvwbt,gettype_vvvvwbt);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvwbt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbt = jQuery("#jform_gettype").val();
	vvvvwbt(add_php_after_getitems_vvvvwbt,gettype_vvvvwbt);

});

// #jform_gettype listeners for gettype_vvvvwbt function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_vvvvwbt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbt = jQuery("#jform_gettype").val();
	vvvvwbt(add_php_after_getitems_vvvvwbt,gettype_vvvvwbt);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvwbt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbt = jQuery("#jform_gettype").val();
	vvvvwbt(add_php_after_getitems_vvvvwbt,gettype_vvvvwbt);

});

// #jform_gettype listeners for gettype_vvvvwbv function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwbv = jQuery("#jform_gettype").val();
	vvvvwbv(gettype_vvvvwbv);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwbv = jQuery("#jform_gettype").val();
	vvvvwbv(gettype_vvvvwbv);

});

// #jform_gettype listeners for gettype_vvvvwbw function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwbw = jQuery("#jform_gettype").val();
	vvvvwbw(gettype_vvvvwbw);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwbw = jQuery("#jform_gettype").val();
	vvvvwbw(gettype_vvvvwbw);

});

// #jform_gettype listeners for gettype_vvvvwbx function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwbx = jQuery("#jform_gettype").val();
	vvvvwbx(gettype_vvvvwbx);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwbx = jQuery("#jform_gettype").val();
	vvvvwbx(gettype_vvvvwbx);

});

// #jform_gettype listeners for gettype_vvvvwby function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwby = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwby = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwby(gettype_vvvvwby,add_php_router_parse_vvvvwby);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwby = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwby = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwby(gettype_vvvvwby,add_php_router_parse_vvvvwby);

});

// #jform_add_php_router_parse listeners for add_php_router_parse_vvvvwby function
jQuery('#jform_add_php_router_parse').on('keyup',function()
{
	var gettype_vvvvwby = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwby = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwby(gettype_vvvvwby,add_php_router_parse_vvvvwby);

});
jQuery('#adminForm').on('change', '#jform_add_php_router_parse',function (e)
{
	e.preventDefault();
	var gettype_vvvvwby = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwby = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwby(gettype_vvvvwby,add_php_router_parse_vvvvwby);

});

// #jform_gettype listeners for gettype_vvvvwca function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwca = jQuery("#jform_gettype").val();
	vvvvwca(gettype_vvvvwca);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwca = jQuery("#jform_gettype").val();
	vvvvwca(gettype_vvvvwca);

});



<?php $fieldNrs = range(0,50,1); ?>
<?php $fieldNames = array('db' => 'Db','view' => 'View'); ?>
// for the vlaues already set
jQuery(document).ready(function(){
<?php foreach($fieldNames as $fieldName => $funcName): ?>
 	<?php foreach($fieldNrs as $fieldNr): ?>
		updateSubItems('<?php echo $fieldName ?>', <?php echo $fieldNr ?>, '_', '_');
	<?php endforeach; ?>
<?php endforeach; ?>
});
// for the values the will still be set
jQuery(document).ready(function(){
	jQuery(document).on('subform-row-add', function(event, row){
		var groupName = jQuery(row).data('group');
		var fieldName = groupName.replace('join_', '').replace('_table', '').replace(/([0-9])/g, '');
		var fieldNr = groupName.replace(/([A-z_])/g, '');
		updateSubItems(fieldName, fieldNr, '_', '_');
	});

});
<?php foreach($fieldNames as $fieldName => $funcName): ?>jQuery('#adminForm').on('change', '#jform_<?php echo $fieldName ?>_table_main',function (e) {
	// get options
	var value_<?php echo $fieldName ?> = jQuery("#jform_<?php echo $fieldName ?>_table_main option:selected").val();
	get<?php echo $funcName; ?>TableColumns(value_<?php echo $fieldName ?>, 'a', '<?php echo $fieldName ?>', 3, true, '', '');
});
<?php endforeach; ?>
// #jform_add_php_router_parse listeners
jQuery('#jform_add_php_router_parse').on('change',function() {
	var valueSwitch = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	getDynamicScripts(valueSwitch);
});
jQuery('#adminForm').on('change', '#jform_select_all',function (e)
{
	e.preventDefault();
	// get the selected value
	var select_all =  jQuery("#jform_select_all input[type='radio']:checked").val();
	setSelectAll(select_all);

});

<?php
	$app = JFactory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
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

// nice little dot trick :)
jQuery(document).ready( function($) {
  var x=0;
  setInterval(function() {
	var dots = "";
	x++;
	for (var y=0; y < x%8; y++) {
		dots+=".";
	}
	$(".loading-dots").text(dots);
  } , 500);
}); 
</script>
