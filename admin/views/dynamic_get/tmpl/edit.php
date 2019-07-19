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

// #jform_gettype listeners for gettype_vvvvvzl function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(gettype_vvvvvzl);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(gettype_vvvvvzl);

});

// #jform_main_source listeners for main_source_vvvvvzm function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzm = jQuery("#jform_main_source").val();
	vvvvvzm(main_source_vvvvvzm);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzm = jQuery("#jform_main_source").val();
	vvvvvzm(main_source_vvvvvzm);

});

// #jform_main_source listeners for main_source_vvvvvzn function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzn = jQuery("#jform_main_source").val();
	vvvvvzn(main_source_vvvvvzn);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzn = jQuery("#jform_main_source").val();
	vvvvvzn(main_source_vvvvvzn);

});

// #jform_main_source listeners for main_source_vvvvvzo function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzo = jQuery("#jform_main_source").val();
	vvvvvzo(main_source_vvvvvzo);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzo = jQuery("#jform_main_source").val();
	vvvvvzo(main_source_vvvvvzo);

});

// #jform_main_source listeners for main_source_vvvvvzp function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzp = jQuery("#jform_main_source").val();
	vvvvvzp(main_source_vvvvvzp);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzp = jQuery("#jform_main_source").val();
	vvvvvzp(main_source_vvvvvzp);

});

// #jform_main_source listeners for main_source_vvvvvzq function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzq = jQuery("#jform_main_source").val();
	vvvvvzq(main_source_vvvvvzq);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzq = jQuery("#jform_main_source").val();
	vvvvvzq(main_source_vvvvvzq);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzr function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzr = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzr(addcalculation_vvvvvzr);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzr = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzr(addcalculation_vvvvvzr);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzs function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzs = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(addcalculation_vvvvvzs,gettype_vvvvvzs);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzs = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(addcalculation_vvvvvzs,gettype_vvvvvzs);

});

// #jform_gettype listeners for gettype_vvvvvzs function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvzs = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(addcalculation_vvvvvzs,gettype_vvvvvzs);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzs = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(addcalculation_vvvvvzs,gettype_vvvvvzs);

});

// #jform_addcalculation listeners for addcalculation_vvvvvzt function
jQuery('#jform_addcalculation').on('keyup',function()
{
	var addcalculation_vvvvvzt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(addcalculation_vvvvvzt,gettype_vvvvvzt);

});
jQuery('#adminForm').on('change', '#jform_addcalculation',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(addcalculation_vvvvvzt,gettype_vvvvvzt);

});

// #jform_gettype listeners for gettype_vvvvvzt function
jQuery('#jform_gettype').on('keyup',function()
{
	var addcalculation_vvvvvzt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(addcalculation_vvvvvzt,gettype_vvvvvzt);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var addcalculation_vvvvvzt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(addcalculation_vvvvvzt,gettype_vvvvvzt);

});

// #jform_main_source listeners for main_source_vvvvvzw function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzw = jQuery("#jform_main_source").val();
	vvvvvzw(main_source_vvvvvzw);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzw = jQuery("#jform_main_source").val();
	vvvvvzw(main_source_vvvvvzw);

});

// #jform_main_source listeners for main_source_vvvvvzx function
jQuery('#jform_main_source').on('keyup',function()
{
	var main_source_vvvvvzx = jQuery("#jform_main_source").val();
	vvvvvzx(main_source_vvvvvzx);

});
jQuery('#adminForm').on('change', '#jform_main_source',function (e)
{
	e.preventDefault();
	var main_source_vvvvvzx = jQuery("#jform_main_source").val();
	vvvvvzx(main_source_vvvvvzx);

});

// #jform_add_php_before_getitem listeners for add_php_before_getitem_vvvvvzy function
jQuery('#jform_add_php_before_getitem').on('keyup',function()
{
	var add_php_before_getitem_vvvvvzy = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	vvvvvzy(add_php_before_getitem_vvvvvzy,gettype_vvvvvzy);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitem',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvzy = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	vvvvvzy(add_php_before_getitem_vvvvvzy,gettype_vvvvvzy);

});

// #jform_gettype listeners for gettype_vvvvvzy function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitem_vvvvvzy = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	vvvvvzy(add_php_before_getitem_vvvvvzy,gettype_vvvvvzy);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitem_vvvvvzy = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	vvvvvzy(add_php_before_getitem_vvvvvzy,gettype_vvvvvzy);

});

// #jform_add_php_after_getitem listeners for add_php_after_getitem_vvvvvzz function
jQuery('#jform_add_php_after_getitem').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzz = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	vvvvvzz(add_php_after_getitem_vvvvvzz,gettype_vvvvvzz);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitem',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzz = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	vvvvvzz(add_php_after_getitem_vvvvvzz,gettype_vvvvvzz);

});

// #jform_gettype listeners for gettype_vvvvvzz function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitem_vvvvvzz = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	vvvvvzz(add_php_after_getitem_vvvvvzz,gettype_vvvvvzz);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitem_vvvvvzz = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	vvvvvzz(add_php_after_getitem_vvvvvzz,gettype_vvvvvzz);

});

// #jform_gettype listeners for gettype_vvvvwab function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwab = jQuery("#jform_gettype").val();
	vvvvwab(gettype_vvvvwab);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwab = jQuery("#jform_gettype").val();
	vvvvwab(gettype_vvvvwab);

});

// #jform_add_php_getlistquery listeners for add_php_getlistquery_vvvvwac function
jQuery('#jform_add_php_getlistquery').on('keyup',function()
{
	var add_php_getlistquery_vvvvwac = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwac = jQuery("#jform_gettype").val();
	vvvvwac(add_php_getlistquery_vvvvwac,gettype_vvvvwac);

});
jQuery('#adminForm').on('change', '#jform_add_php_getlistquery',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvwac = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwac = jQuery("#jform_gettype").val();
	vvvvwac(add_php_getlistquery_vvvvwac,gettype_vvvvwac);

});

// #jform_gettype listeners for gettype_vvvvwac function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_getlistquery_vvvvwac = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwac = jQuery("#jform_gettype").val();
	vvvvwac(add_php_getlistquery_vvvvwac,gettype_vvvvwac);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_getlistquery_vvvvwac = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwac = jQuery("#jform_gettype").val();
	vvvvwac(add_php_getlistquery_vvvvwac,gettype_vvvvwac);

});

// #jform_add_php_before_getitems listeners for add_php_before_getitems_vvvvwad function
jQuery('#jform_add_php_before_getitems').on('keyup',function()
{
	var add_php_before_getitems_vvvvwad = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwad = jQuery("#jform_gettype").val();
	vvvvwad(add_php_before_getitems_vvvvwad,gettype_vvvvwad);

});
jQuery('#adminForm').on('change', '#jform_add_php_before_getitems',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvwad = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwad = jQuery("#jform_gettype").val();
	vvvvwad(add_php_before_getitems_vvvvwad,gettype_vvvvwad);

});

// #jform_gettype listeners for gettype_vvvvwad function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_before_getitems_vvvvwad = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwad = jQuery("#jform_gettype").val();
	vvvvwad(add_php_before_getitems_vvvvwad,gettype_vvvvwad);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_before_getitems_vvvvwad = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwad = jQuery("#jform_gettype").val();
	vvvvwad(add_php_before_getitems_vvvvwad,gettype_vvvvwad);

});

// #jform_add_php_after_getitems listeners for add_php_after_getitems_vvvvwae function
jQuery('#jform_add_php_after_getitems').on('keyup',function()
{
	var add_php_after_getitems_vvvvwae = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwae = jQuery("#jform_gettype").val();
	vvvvwae(add_php_after_getitems_vvvvwae,gettype_vvvvwae);

});
jQuery('#adminForm').on('change', '#jform_add_php_after_getitems',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvwae = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwae = jQuery("#jform_gettype").val();
	vvvvwae(add_php_after_getitems_vvvvwae,gettype_vvvvwae);

});

// #jform_gettype listeners for gettype_vvvvwae function
jQuery('#jform_gettype').on('keyup',function()
{
	var add_php_after_getitems_vvvvwae = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwae = jQuery("#jform_gettype").val();
	vvvvwae(add_php_after_getitems_vvvvwae,gettype_vvvvwae);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var add_php_after_getitems_vvvvwae = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwae = jQuery("#jform_gettype").val();
	vvvvwae(add_php_after_getitems_vvvvwae,gettype_vvvvwae);

});

// #jform_gettype listeners for gettype_vvvvwag function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwag = jQuery("#jform_gettype").val();
	vvvvwag(gettype_vvvvwag);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwag = jQuery("#jform_gettype").val();
	vvvvwag(gettype_vvvvwag);

});

// #jform_gettype listeners for gettype_vvvvwah function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwah = jQuery("#jform_gettype").val();
	vvvvwah(gettype_vvvvwah);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwah = jQuery("#jform_gettype").val();
	vvvvwah(gettype_vvvvwah);

});

// #jform_gettype listeners for gettype_vvvvwai function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwai = jQuery("#jform_gettype").val();
	vvvvwai(gettype_vvvvwai);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwai = jQuery("#jform_gettype").val();
	vvvvwai(gettype_vvvvwai);

});

// #jform_gettype listeners for gettype_vvvvwaj function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwaj = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwaj = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwaj(gettype_vvvvwaj,add_php_router_parse_vvvvwaj);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwaj = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwaj = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwaj(gettype_vvvvwaj,add_php_router_parse_vvvvwaj);

});

// #jform_add_php_router_parse listeners for add_php_router_parse_vvvvwaj function
jQuery('#jform_add_php_router_parse').on('keyup',function()
{
	var gettype_vvvvwaj = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwaj = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwaj(gettype_vvvvwaj,add_php_router_parse_vvvvwaj);

});
jQuery('#adminForm').on('change', '#jform_add_php_router_parse',function (e)
{
	e.preventDefault();
	var gettype_vvvvwaj = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwaj = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwaj(gettype_vvvvwaj,add_php_router_parse_vvvvwaj);

});

// #jform_gettype listeners for gettype_vvvvwal function
jQuery('#jform_gettype').on('keyup',function()
{
	var gettype_vvvvwal = jQuery("#jform_gettype").val();
	vvvvwal(gettype_vvvvwal);

});
jQuery('#adminForm').on('change', '#jform_gettype',function (e)
{
	e.preventDefault();
	var gettype_vvvvwal = jQuery("#jform_gettype").val();
	vvvvwal(gettype_vvvvwal);

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
