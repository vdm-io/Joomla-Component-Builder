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

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_pluginTab', 'forms_fields', JText::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_FORMS_FIELDS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_plugin.forms_fields_fullwidth', $this); ?>
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

// #jform_class_extends listeners for class_extends_vvvvvxx function
jQuery('#jform_class_extends').on('keyup',function()
{
	var class_extends_vvvvvxx = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxx = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxx(class_extends_vvvvvxx,joomla_plugin_group_vvvvvxx);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvxx = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxx = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxx(class_extends_vvvvvxx,joomla_plugin_group_vvvvvxx);

});

// #jform_joomla_plugin_group listeners for joomla_plugin_group_vvvvvxx function
jQuery('#jform_joomla_plugin_group').on('keyup',function()
{
	var class_extends_vvvvvxx = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxx = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxx(class_extends_vvvvvxx,joomla_plugin_group_vvvvvxx);

});
jQuery('#adminForm').on('change', '#jform_joomla_plugin_group',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvxx = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxx = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxx(class_extends_vvvvvxx,joomla_plugin_group_vvvvvxx);

});

// #jform_joomla_plugin_group listeners for joomla_plugin_group_vvvvvxy function
jQuery('#jform_joomla_plugin_group').on('keyup',function()
{
	var joomla_plugin_group_vvvvvxy = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxy = jQuery("#jform_class_extends").val();
	vvvvvxy(joomla_plugin_group_vvvvvxy,class_extends_vvvvvxy);

});
jQuery('#adminForm').on('change', '#jform_joomla_plugin_group',function (e)
{
	e.preventDefault();
	var joomla_plugin_group_vvvvvxy = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxy = jQuery("#jform_class_extends").val();
	vvvvvxy(joomla_plugin_group_vvvvvxy,class_extends_vvvvvxy);

});

// #jform_class_extends listeners for class_extends_vvvvvxy function
jQuery('#jform_class_extends').on('keyup',function()
{
	var joomla_plugin_group_vvvvvxy = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxy = jQuery("#jform_class_extends").val();
	vvvvvxy(joomla_plugin_group_vvvvvxy,class_extends_vvvvvxy);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var joomla_plugin_group_vvvvvxy = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxy = jQuery("#jform_class_extends").val();
	vvvvvxy(joomla_plugin_group_vvvvvxy,class_extends_vvvvvxy);

});

// #jform_class_extends listeners for class_extends_vvvvvxz function
jQuery('#jform_class_extends').on('keyup',function()
{
	var class_extends_vvvvvxz = jQuery("#jform_class_extends").val();
	vvvvvxz(class_extends_vvvvvxz);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvxz = jQuery("#jform_class_extends").val();
	vvvvvxz(class_extends_vvvvvxz);

});

// #jform_add_head listeners for add_head_vvvvvya function
jQuery('#jform_add_head').on('keyup',function()
{
	var add_head_vvvvvya = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvya = jQuery("#jform_class_extends").val();
	vvvvvya(add_head_vvvvvya,class_extends_vvvvvya);

});
jQuery('#adminForm').on('change', '#jform_add_head',function (e)
{
	e.preventDefault();
	var add_head_vvvvvya = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvya = jQuery("#jform_class_extends").val();
	vvvvvya(add_head_vvvvvya,class_extends_vvvvvya);

});

// #jform_class_extends listeners for class_extends_vvvvvya function
jQuery('#jform_class_extends').on('keyup',function()
{
	var add_head_vvvvvya = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvya = jQuery("#jform_class_extends").val();
	vvvvvya(add_head_vvvvvya,class_extends_vvvvvya);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var add_head_vvvvvya = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvya = jQuery("#jform_class_extends").val();
	vvvvvya(add_head_vvvvvya,class_extends_vvvvvya);

});

// #jform_add_php_script_construct listeners for add_php_script_construct_vvvvvyc function
jQuery('#jform_add_php_script_construct').on('keyup',function()
{
	var add_php_script_construct_vvvvvyc = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvyc(add_php_script_construct_vvvvvyc);

});
jQuery('#adminForm').on('change', '#jform_add_php_script_construct',function (e)
{
	e.preventDefault();
	var add_php_script_construct_vvvvvyc = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvyc(add_php_script_construct_vvvvvyc);

});

// #jform_add_php_preflight_install listeners for add_php_preflight_install_vvvvvyd function
jQuery('#jform_add_php_preflight_install').on('keyup',function()
{
	var add_php_preflight_install_vvvvvyd = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvyd(add_php_preflight_install_vvvvvyd);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_install',function (e)
{
	e.preventDefault();
	var add_php_preflight_install_vvvvvyd = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvyd(add_php_preflight_install_vvvvvyd);

});

// #jform_add_php_preflight_update listeners for add_php_preflight_update_vvvvvye function
jQuery('#jform_add_php_preflight_update').on('keyup',function()
{
	var add_php_preflight_update_vvvvvye = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvye(add_php_preflight_update_vvvvvye);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_update',function (e)
{
	e.preventDefault();
	var add_php_preflight_update_vvvvvye = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvye(add_php_preflight_update_vvvvvye);

});

// #jform_add_php_preflight_uninstall listeners for add_php_preflight_uninstall_vvvvvyf function
jQuery('#jform_add_php_preflight_uninstall').on('keyup',function()
{
	var add_php_preflight_uninstall_vvvvvyf = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvyf(add_php_preflight_uninstall_vvvvvyf);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_uninstall',function (e)
{
	e.preventDefault();
	var add_php_preflight_uninstall_vvvvvyf = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvyf(add_php_preflight_uninstall_vvvvvyf);

});

// #jform_add_php_postflight_install listeners for add_php_postflight_install_vvvvvyg function
jQuery('#jform_add_php_postflight_install').on('keyup',function()
{
	var add_php_postflight_install_vvvvvyg = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvyg(add_php_postflight_install_vvvvvyg);

});
jQuery('#adminForm').on('change', '#jform_add_php_postflight_install',function (e)
{
	e.preventDefault();
	var add_php_postflight_install_vvvvvyg = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvyg(add_php_postflight_install_vvvvvyg);

});

// #jform_add_php_postflight_update listeners for add_php_postflight_update_vvvvvyh function
jQuery('#jform_add_php_postflight_update').on('keyup',function()
{
	var add_php_postflight_update_vvvvvyh = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvyh(add_php_postflight_update_vvvvvyh);

});
jQuery('#adminForm').on('change', '#jform_add_php_postflight_update',function (e)
{
	e.preventDefault();
	var add_php_postflight_update_vvvvvyh = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvyh(add_php_postflight_update_vvvvvyh);

});

// #jform_add_php_method_uninstall listeners for add_php_method_uninstall_vvvvvyi function
jQuery('#jform_add_php_method_uninstall').on('keyup',function()
{
	var add_php_method_uninstall_vvvvvyi = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvyi(add_php_method_uninstall_vvvvvyi);

});
jQuery('#adminForm').on('change', '#jform_add_php_method_uninstall',function (e)
{
	e.preventDefault();
	var add_php_method_uninstall_vvvvvyi = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvyi(add_php_method_uninstall_vvvvvyi);

});

// #jform_update_server_target listeners for update_server_target_vvvvvyj function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvyj = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyj = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyj(update_server_target_vvvvvyj,add_update_server_vvvvvyj);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvyj = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyj = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyj(update_server_target_vvvvvyj,add_update_server_vvvvvyj);

});

// #jform_add_update_server listeners for add_update_server_vvvvvyj function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvyj = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyj = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyj(update_server_target_vvvvvyj,add_update_server_vvvvvyj);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvyj = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyj = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyj(update_server_target_vvvvvyj,add_update_server_vvvvvyj);

});

// #jform_add_update_server listeners for add_update_server_vvvvvyk function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvyk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvyk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvyk(add_update_server_vvvvvyk,update_server_target_vvvvvyk);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvyk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvyk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvyk(add_update_server_vvvvvyk,update_server_target_vvvvvyk);

});

// #jform_update_server_target listeners for update_server_target_vvvvvyk function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var add_update_server_vvvvvyk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvyk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvyk(add_update_server_vvvvvyk,update_server_target_vvvvvyk);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvyk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvyk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvyk(add_update_server_vvvvvyk,update_server_target_vvvvvyk);

});

// #jform_update_server_target listeners for update_server_target_vvvvvyl function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvyl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyl(update_server_target_vvvvvyl,add_update_server_vvvvvyl);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvyl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyl(update_server_target_vvvvvyl,add_update_server_vvvvvyl);

});

// #jform_add_update_server listeners for add_update_server_vvvvvyl function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvyl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyl(update_server_target_vvvvvyl,add_update_server_vvvvvyl);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvyl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyl(update_server_target_vvvvvyl,add_update_server_vvvvvyl);

});

// #jform_update_server_target listeners for update_server_target_vvvvvyn function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvyn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyn(update_server_target_vvvvvyn,add_update_server_vvvvvyn);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvyn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyn(update_server_target_vvvvvyn,add_update_server_vvvvvyn);

});

// #jform_add_update_server listeners for add_update_server_vvvvvyn function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvyn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyn(update_server_target_vvvvvyn,add_update_server_vvvvvyn);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvyn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyn(update_server_target_vvvvvyn,add_update_server_vvvvvyn);

});

// #jform_add_update_server listeners for add_update_server_vvvvvyp function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvyp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyp(add_update_server_vvvvvyp);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvyp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyp(add_update_server_vvvvvyp);

});

// #jform_add_sql listeners for add_sql_vvvvvyq function
jQuery('#jform_add_sql').on('keyup',function()
{
	var add_sql_vvvvvyq = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvyq(add_sql_vvvvvyq);

});
jQuery('#adminForm').on('change', '#jform_add_sql',function (e)
{
	e.preventDefault();
	var add_sql_vvvvvyq = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvyq(add_sql_vvvvvyq);

});

// #jform_add_sql_uninstall listeners for add_sql_uninstall_vvvvvyr function
jQuery('#jform_add_sql_uninstall').on('keyup',function()
{
	var add_sql_uninstall_vvvvvyr = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvyr(add_sql_uninstall_vvvvvyr);

});
jQuery('#adminForm').on('change', '#jform_add_sql_uninstall',function (e)
{
	e.preventDefault();
	var add_sql_uninstall_vvvvvyr = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvyr(add_sql_uninstall_vvvvvyr);

});

// #jform_add_update_server listeners for add_update_server_vvvvvys function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvys = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvys(add_update_server_vvvvvys);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvys = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvys(add_update_server_vvvvvys);

});

// #jform_add_sales_server listeners for add_sales_server_vvvvvyt function
jQuery('#jform_add_sales_server').on('keyup',function()
{
	var add_sales_server_vvvvvyt = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvyt(add_sales_server_vvvvvyt);

});
jQuery('#adminForm').on('change', '#jform_add_sales_server',function (e)
{
	e.preventDefault();
	var add_sales_server_vvvvvyt = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvyt(add_sales_server_vvvvvyt);

});

// #jform_addreadme listeners for addreadme_vvvvvyu function
jQuery('#jform_addreadme').on('keyup',function()
{
	var addreadme_vvvvvyu = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvyu(addreadme_vvvvvyu);

});
jQuery('#adminForm').on('change', '#jform_addreadme',function (e)
{
	e.preventDefault();
	var addreadme_vvvvvyu = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvyu(addreadme_vvvvvyu);

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
