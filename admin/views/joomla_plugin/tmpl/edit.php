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

	<?php echo JLayoutHelper::render('joomla_plugin.code_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'joomla_pluginTab', array('active' => 'code')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'code', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_CODE', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_plugin.code_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_plugin.code_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_plugin.code_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'configparams', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_CONFIGPARAMS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_plugin.configparams_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'script_file', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_SCRIPT_FILE', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_plugin.script_file_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'mysql', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_MYSQL', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_plugin.mysql_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'readme', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_README', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_plugin.readme_left', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'dynamic_integration', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_DYNAMIC_INTEGRATION', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_plugin.dynamic_integration_left', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'joomla_pluginTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('joomla_plugin.delete') || $this->canDo->get('joomla_plugin.edit.created_by') || $this->canDo->get('joomla_plugin.edit.state') || $this->canDo->get('joomla_plugin.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'publishing', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_plugin.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_plugin.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'permissions', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="joomla_plugin.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_class_extends listeners for class_extends_vvvvvxb function
jQuery('#jform_class_extends').on('keyup',function()
{
	var class_extends_vvvvvxb = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxb = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxb(class_extends_vvvvvxb,joomla_plugin_group_vvvvvxb);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvxb = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxb = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxb(class_extends_vvvvvxb,joomla_plugin_group_vvvvvxb);

});

// #jform_joomla_plugin_group listeners for joomla_plugin_group_vvvvvxb function
jQuery('#jform_joomla_plugin_group').on('keyup',function()
{
	var class_extends_vvvvvxb = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxb = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxb(class_extends_vvvvvxb,joomla_plugin_group_vvvvvxb);

});
jQuery('#adminForm').on('change', '#jform_joomla_plugin_group',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvxb = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxb = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxb(class_extends_vvvvvxb,joomla_plugin_group_vvvvvxb);

});

// #jform_joomla_plugin_group listeners for joomla_plugin_group_vvvvvxc function
jQuery('#jform_joomla_plugin_group').on('keyup',function()
{
	var joomla_plugin_group_vvvvvxc = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxc = jQuery("#jform_class_extends").val();
	vvvvvxc(joomla_plugin_group_vvvvvxc,class_extends_vvvvvxc);

});
jQuery('#adminForm').on('change', '#jform_joomla_plugin_group',function (e)
{
	e.preventDefault();
	var joomla_plugin_group_vvvvvxc = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxc = jQuery("#jform_class_extends").val();
	vvvvvxc(joomla_plugin_group_vvvvvxc,class_extends_vvvvvxc);

});

// #jform_class_extends listeners for class_extends_vvvvvxc function
jQuery('#jform_class_extends').on('keyup',function()
{
	var joomla_plugin_group_vvvvvxc = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxc = jQuery("#jform_class_extends").val();
	vvvvvxc(joomla_plugin_group_vvvvvxc,class_extends_vvvvvxc);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var joomla_plugin_group_vvvvvxc = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxc = jQuery("#jform_class_extends").val();
	vvvvvxc(joomla_plugin_group_vvvvvxc,class_extends_vvvvvxc);

});

// #jform_class_extends listeners for class_extends_vvvvvxd function
jQuery('#jform_class_extends').on('keyup',function()
{
	var class_extends_vvvvvxd = jQuery("#jform_class_extends").val();
	vvvvvxd(class_extends_vvvvvxd);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvxd = jQuery("#jform_class_extends").val();
	vvvvvxd(class_extends_vvvvvxd);

});

// #jform_add_head listeners for add_head_vvvvvxe function
jQuery('#jform_add_head').on('keyup',function()
{
	var add_head_vvvvvxe = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvxe = jQuery("#jform_class_extends").val();
	vvvvvxe(add_head_vvvvvxe,class_extends_vvvvvxe);

});
jQuery('#adminForm').on('change', '#jform_add_head',function (e)
{
	e.preventDefault();
	var add_head_vvvvvxe = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvxe = jQuery("#jform_class_extends").val();
	vvvvvxe(add_head_vvvvvxe,class_extends_vvvvvxe);

});

// #jform_class_extends listeners for class_extends_vvvvvxe function
jQuery('#jform_class_extends').on('keyup',function()
{
	var add_head_vvvvvxe = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvxe = jQuery("#jform_class_extends").val();
	vvvvvxe(add_head_vvvvvxe,class_extends_vvvvvxe);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var add_head_vvvvvxe = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvxe = jQuery("#jform_class_extends").val();
	vvvvvxe(add_head_vvvvvxe,class_extends_vvvvvxe);

});

// #jform_add_php_script_construct listeners for add_php_script_construct_vvvvvxg function
jQuery('#jform_add_php_script_construct').on('keyup',function()
{
	var add_php_script_construct_vvvvvxg = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvxg(add_php_script_construct_vvvvvxg);

});
jQuery('#adminForm').on('change', '#jform_add_php_script_construct',function (e)
{
	e.preventDefault();
	var add_php_script_construct_vvvvvxg = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvxg(add_php_script_construct_vvvvvxg);

});

// #jform_add_php_preflight_install listeners for add_php_preflight_install_vvvvvxh function
jQuery('#jform_add_php_preflight_install').on('keyup',function()
{
	var add_php_preflight_install_vvvvvxh = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvxh(add_php_preflight_install_vvvvvxh);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_install',function (e)
{
	e.preventDefault();
	var add_php_preflight_install_vvvvvxh = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvxh(add_php_preflight_install_vvvvvxh);

});

// #jform_add_php_preflight_update listeners for add_php_preflight_update_vvvvvxi function
jQuery('#jform_add_php_preflight_update').on('keyup',function()
{
	var add_php_preflight_update_vvvvvxi = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvxi(add_php_preflight_update_vvvvvxi);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_update',function (e)
{
	e.preventDefault();
	var add_php_preflight_update_vvvvvxi = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvxi(add_php_preflight_update_vvvvvxi);

});

// #jform_add_php_preflight_uninstall listeners for add_php_preflight_uninstall_vvvvvxj function
jQuery('#jform_add_php_preflight_uninstall').on('keyup',function()
{
	var add_php_preflight_uninstall_vvvvvxj = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvxj(add_php_preflight_uninstall_vvvvvxj);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_uninstall',function (e)
{
	e.preventDefault();
	var add_php_preflight_uninstall_vvvvvxj = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvxj(add_php_preflight_uninstall_vvvvvxj);

});

// #jform_add_php_postflight_install listeners for add_php_postflight_install_vvvvvxk function
jQuery('#jform_add_php_postflight_install').on('keyup',function()
{
	var add_php_postflight_install_vvvvvxk = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvxk(add_php_postflight_install_vvvvvxk);

});
jQuery('#adminForm').on('change', '#jform_add_php_postflight_install',function (e)
{
	e.preventDefault();
	var add_php_postflight_install_vvvvvxk = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvxk(add_php_postflight_install_vvvvvxk);

});

// #jform_add_php_postflight_update listeners for add_php_postflight_update_vvvvvxl function
jQuery('#jform_add_php_postflight_update').on('keyup',function()
{
	var add_php_postflight_update_vvvvvxl = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvxl(add_php_postflight_update_vvvvvxl);

});
jQuery('#adminForm').on('change', '#jform_add_php_postflight_update',function (e)
{
	e.preventDefault();
	var add_php_postflight_update_vvvvvxl = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvxl(add_php_postflight_update_vvvvvxl);

});

// #jform_add_php_method_uninstall listeners for add_php_method_uninstall_vvvvvxm function
jQuery('#jform_add_php_method_uninstall').on('keyup',function()
{
	var add_php_method_uninstall_vvvvvxm = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvxm(add_php_method_uninstall_vvvvvxm);

});
jQuery('#adminForm').on('change', '#jform_add_php_method_uninstall',function (e)
{
	e.preventDefault();
	var add_php_method_uninstall_vvvvvxm = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvxm(add_php_method_uninstall_vvvvvxm);

});

// #jform_update_server_target listeners for update_server_target_vvvvvxn function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvxn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxn(update_server_target_vvvvvxn,add_update_server_vvvvvxn);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxn(update_server_target_vvvvvxn,add_update_server_vvvvvxn);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxn function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvxn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxn(update_server_target_vvvvvxn,add_update_server_vvvvvxn);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxn(update_server_target_vvvvvxn,add_update_server_vvvvvxn);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxo function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvxo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxo(add_update_server_vvvvvxo,update_server_target_vvvvvxo);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvxo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxo(add_update_server_vvvvvxo,update_server_target_vvvvvxo);

});

// #jform_update_server_target listeners for update_server_target_vvvvvxo function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var add_update_server_vvvvvxo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxo(add_update_server_vvvvvxo,update_server_target_vvvvvxo);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvxo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxo(add_update_server_vvvvvxo,update_server_target_vvvvvxo);

});

// #jform_update_server_target listeners for update_server_target_vvvvvxp function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvxp = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxp(update_server_target_vvvvvxp,add_update_server_vvvvvxp);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxp = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxp(update_server_target_vvvvvxp,add_update_server_vvvvvxp);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxp function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvxp = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxp(update_server_target_vvvvvxp,add_update_server_vvvvvxp);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxp = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxp(update_server_target_vvvvvxp,add_update_server_vvvvvxp);

});

// #jform_update_server_target listeners for update_server_target_vvvvvxr function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvxr = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxr(update_server_target_vvvvvxr,add_update_server_vvvvvxr);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxr = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxr(update_server_target_vvvvvxr,add_update_server_vvvvvxr);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxr function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvxr = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxr(update_server_target_vvvvvxr,add_update_server_vvvvvxr);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxr = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxr(update_server_target_vvvvvxr,add_update_server_vvvvvxr);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxt function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvxt = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxt(add_update_server_vvvvvxt);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvxt = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxt(add_update_server_vvvvvxt);

});

// #jform_add_sql listeners for add_sql_vvvvvxu function
jQuery('#jform_add_sql').on('keyup',function()
{
	var add_sql_vvvvvxu = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxu(add_sql_vvvvvxu);

});
jQuery('#adminForm').on('change', '#jform_add_sql',function (e)
{
	e.preventDefault();
	var add_sql_vvvvvxu = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxu(add_sql_vvvvvxu);

});

// #jform_add_sql_uninstall listeners for add_sql_uninstall_vvvvvxv function
jQuery('#jform_add_sql_uninstall').on('keyup',function()
{
	var add_sql_uninstall_vvvvvxv = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvxv(add_sql_uninstall_vvvvvxv);

});
jQuery('#adminForm').on('change', '#jform_add_sql_uninstall',function (e)
{
	e.preventDefault();
	var add_sql_uninstall_vvvvvxv = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvxv(add_sql_uninstall_vvvvvxv);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxw function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvxw = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxw(add_update_server_vvvvvxw);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvxw = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxw(add_update_server_vvvvvxw);

});

// #jform_add_sales_server listeners for add_sales_server_vvvvvxx function
jQuery('#jform_add_sales_server').on('keyup',function()
{
	var add_sales_server_vvvvvxx = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvxx(add_sales_server_vvvvvxx);

});
jQuery('#adminForm').on('change', '#jform_add_sales_server',function (e)
{
	e.preventDefault();
	var add_sales_server_vvvvvxx = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvxx(add_sales_server_vvvvvxx);

});

// #jform_addreadme listeners for addreadme_vvvvvxy function
jQuery('#jform_addreadme').on('keyup',function()
{
	var addreadme_vvvvvxy = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvxy(addreadme_vvvvvxy);

});
jQuery('#adminForm').on('change', '#jform_addreadme',function (e)
{
	e.preventDefault();
	var addreadme_vvvvvxy = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvxy(addreadme_vvvvvxy);

});



jQuery('#adminForm').on('change', '#jform_joomla_plugin_group',function (e)
{
	// load the active array values
	getClassCodeIds('property', 'jform_joomla_plugin_group', true);
	getClassCodeIds('method', 'jform_joomla_plugin_group', true);
});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	// load the active array values
	getClassCodeIds('joomla_plugin_group', 'jform_class_extends', true);
	getClassHeaderCode();
});
jQuery('#adminForm').on('change', '#jform_add_head',function (e)
{
	getClassHeaderCode();
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
