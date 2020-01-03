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

	<?php echo JLayoutHelper::render('joomla_module.html_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'joomla_moduleTab', array('active' => 'html')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'html', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_HTML', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_module.html_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_module.html_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_module.html_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'code', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_CODE', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_module.code_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_module.code_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_module.code_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'helper', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_HELPER', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_module.helper_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_module.helper_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_module.helper_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'forms_fields', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_FORMS_FIELDS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_module.forms_fields_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'script_file', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_SCRIPT_FILE', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_module.script_file_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'mysql', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_MYSQL', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_module.mysql_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'readme', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_README', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_module.readme_left', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'dynamic_integration', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_DYNAMIC_INTEGRATION', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('joomla_module.dynamic_integration_left', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'joomla_moduleTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('joomla_module.delete') || $this->canDo->get('joomla_module.edit.created_by') || $this->canDo->get('joomla_module.edit.state') || $this->canDo->get('joomla_module.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'publishing', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_module.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla_module.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'joomla_moduleTab', 'permissions', JText::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="joomla_module.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_add_class_helper listeners for add_class_helper_vvvvvxb function
jQuery('#jform_add_class_helper').on('keyup',function()
{
	var add_class_helper_vvvvvxb = jQuery("#jform_add_class_helper").val();
	vvvvvxb(add_class_helper_vvvvvxb);

});
jQuery('#adminForm').on('change', '#jform_add_class_helper',function (e)
{
	e.preventDefault();
	var add_class_helper_vvvvvxb = jQuery("#jform_add_class_helper").val();
	vvvvvxb(add_class_helper_vvvvvxb);

});

// #jform_add_class_helper_header listeners for add_class_helper_header_vvvvvxc function
jQuery('#jform_add_class_helper_header').on('keyup',function()
{
	var add_class_helper_header_vvvvvxc = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvxc = jQuery("#jform_add_class_helper").val();
	vvvvvxc(add_class_helper_header_vvvvvxc,add_class_helper_vvvvvxc);

});
jQuery('#adminForm').on('change', '#jform_add_class_helper_header',function (e)
{
	e.preventDefault();
	var add_class_helper_header_vvvvvxc = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvxc = jQuery("#jform_add_class_helper").val();
	vvvvvxc(add_class_helper_header_vvvvvxc,add_class_helper_vvvvvxc);

});

// #jform_add_class_helper listeners for add_class_helper_vvvvvxc function
jQuery('#jform_add_class_helper').on('keyup',function()
{
	var add_class_helper_header_vvvvvxc = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvxc = jQuery("#jform_add_class_helper").val();
	vvvvvxc(add_class_helper_header_vvvvvxc,add_class_helper_vvvvvxc);

});
jQuery('#adminForm').on('change', '#jform_add_class_helper',function (e)
{
	e.preventDefault();
	var add_class_helper_header_vvvvvxc = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvxc = jQuery("#jform_add_class_helper").val();
	vvvvvxc(add_class_helper_header_vvvvvxc,add_class_helper_vvvvvxc);

});

// #jform_add_php_script_construct listeners for add_php_script_construct_vvvvvxe function
jQuery('#jform_add_php_script_construct').on('keyup',function()
{
	var add_php_script_construct_vvvvvxe = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvxe(add_php_script_construct_vvvvvxe);

});
jQuery('#adminForm').on('change', '#jform_add_php_script_construct',function (e)
{
	e.preventDefault();
	var add_php_script_construct_vvvvvxe = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvxe(add_php_script_construct_vvvvvxe);

});

// #jform_add_php_preflight_install listeners for add_php_preflight_install_vvvvvxf function
jQuery('#jform_add_php_preflight_install').on('keyup',function()
{
	var add_php_preflight_install_vvvvvxf = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvxf(add_php_preflight_install_vvvvvxf);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_install',function (e)
{
	e.preventDefault();
	var add_php_preflight_install_vvvvvxf = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvxf(add_php_preflight_install_vvvvvxf);

});

// #jform_add_php_preflight_update listeners for add_php_preflight_update_vvvvvxg function
jQuery('#jform_add_php_preflight_update').on('keyup',function()
{
	var add_php_preflight_update_vvvvvxg = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvxg(add_php_preflight_update_vvvvvxg);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_update',function (e)
{
	e.preventDefault();
	var add_php_preflight_update_vvvvvxg = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvxg(add_php_preflight_update_vvvvvxg);

});

// #jform_add_php_preflight_uninstall listeners for add_php_preflight_uninstall_vvvvvxh function
jQuery('#jform_add_php_preflight_uninstall').on('keyup',function()
{
	var add_php_preflight_uninstall_vvvvvxh = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvxh(add_php_preflight_uninstall_vvvvvxh);

});
jQuery('#adminForm').on('change', '#jform_add_php_preflight_uninstall',function (e)
{
	e.preventDefault();
	var add_php_preflight_uninstall_vvvvvxh = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvxh(add_php_preflight_uninstall_vvvvvxh);

});

// #jform_add_php_postflight_install listeners for add_php_postflight_install_vvvvvxi function
jQuery('#jform_add_php_postflight_install').on('keyup',function()
{
	var add_php_postflight_install_vvvvvxi = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvxi(add_php_postflight_install_vvvvvxi);

});
jQuery('#adminForm').on('change', '#jform_add_php_postflight_install',function (e)
{
	e.preventDefault();
	var add_php_postflight_install_vvvvvxi = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvxi(add_php_postflight_install_vvvvvxi);

});

// #jform_add_php_postflight_update listeners for add_php_postflight_update_vvvvvxj function
jQuery('#jform_add_php_postflight_update').on('keyup',function()
{
	var add_php_postflight_update_vvvvvxj = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvxj(add_php_postflight_update_vvvvvxj);

});
jQuery('#adminForm').on('change', '#jform_add_php_postflight_update',function (e)
{
	e.preventDefault();
	var add_php_postflight_update_vvvvvxj = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvxj(add_php_postflight_update_vvvvvxj);

});

// #jform_add_php_method_uninstall listeners for add_php_method_uninstall_vvvvvxk function
jQuery('#jform_add_php_method_uninstall').on('keyup',function()
{
	var add_php_method_uninstall_vvvvvxk = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvxk(add_php_method_uninstall_vvvvvxk);

});
jQuery('#adminForm').on('change', '#jform_add_php_method_uninstall',function (e)
{
	e.preventDefault();
	var add_php_method_uninstall_vvvvvxk = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvxk(add_php_method_uninstall_vvvvvxk);

});

// #jform_update_server_target listeners for update_server_target_vvvvvxl function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvxl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxl(update_server_target_vvvvvxl,add_update_server_vvvvvxl);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxl(update_server_target_vvvvvxl,add_update_server_vvvvvxl);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxl function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvxl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxl(update_server_target_vvvvvxl,add_update_server_vvvvvxl);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxl(update_server_target_vvvvvxl,add_update_server_vvvvvxl);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxm function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvxm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxm(add_update_server_vvvvvxm,update_server_target_vvvvvxm);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvxm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxm(add_update_server_vvvvvxm,update_server_target_vvvvvxm);

});

// #jform_update_server_target listeners for update_server_target_vvvvvxm function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var add_update_server_vvvvvxm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxm(add_update_server_vvvvvxm,update_server_target_vvvvvxm);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvxm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxm(add_update_server_vvvvvxm,update_server_target_vvvvvxm);

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

// #jform_add_update_server listeners for add_update_server_vvvvvxr function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvxr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxr(add_update_server_vvvvvxr);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvxr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxr(add_update_server_vvvvvxr);

});

// #jform_add_sql listeners for add_sql_vvvvvxs function
jQuery('#jform_add_sql').on('keyup',function()
{
	var add_sql_vvvvvxs = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxs(add_sql_vvvvvxs);

});
jQuery('#adminForm').on('change', '#jform_add_sql',function (e)
{
	e.preventDefault();
	var add_sql_vvvvvxs = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxs(add_sql_vvvvvxs);

});

// #jform_add_sql_uninstall listeners for add_sql_uninstall_vvvvvxt function
jQuery('#jform_add_sql_uninstall').on('keyup',function()
{
	var add_sql_uninstall_vvvvvxt = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvxt(add_sql_uninstall_vvvvvxt);

});
jQuery('#adminForm').on('change', '#jform_add_sql_uninstall',function (e)
{
	e.preventDefault();
	var add_sql_uninstall_vvvvvxt = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvxt(add_sql_uninstall_vvvvvxt);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxu function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvxu = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxu(add_update_server_vvvvvxu);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvxu = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxu(add_update_server_vvvvvxu);

});

// #jform_add_sales_server listeners for add_sales_server_vvvvvxv function
jQuery('#jform_add_sales_server').on('keyup',function()
{
	var add_sales_server_vvvvvxv = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvxv(add_sales_server_vvvvvxv);

});
jQuery('#adminForm').on('change', '#jform_add_sales_server',function (e)
{
	e.preventDefault();
	var add_sales_server_vvvvvxv = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvxv(add_sales_server_vvvvvxv);

});

// #jform_addreadme listeners for addreadme_vvvvvxw function
jQuery('#jform_addreadme').on('keyup',function()
{
	var addreadme_vvvvvxw = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvxw(addreadme_vvvvvxw);

});
jQuery('#adminForm').on('change', '#jform_addreadme',function (e)
{
	e.preventDefault();
	var addreadme_vvvvvxw = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvxw(addreadme_vvvvvxw);

});



jQuery('#jform_snippet').closest('.input-append').addClass('jform_snippet_input_width');
jQuery(function() {
    jQuery("code").click(function() {
        jQuery(this).selText().addClass("selected");
    });
});
jQuery('#adminForm').on('change', '#jform_custom_get',function (e) {
	e.preventDefault();
	// load the dynamic get include with the needed initiation
	setModuleCode();
});
jQuery('#adminForm').on('change', '#jform_add_class_helper',function (e) {
	e.preventDefault();
	// load the dynamic helper include with the needed initiation
	setModuleCode();
});
jQuery('#adminForm').on('change', '#jform_libraries',function (e) {
	e.preventDefault();
	// get the snippets of the selected libraries
	getSnippets();
	// load the dynamic media placeholders if needed
	setModuleCode();
});

jQuery.fn.selText = function() {
    var obj = this[0];
    if (jQuery.browser.msie) {
        var range = obj.offsetParent.createTextRange();
        range.moveToElementText(obj);
        range.select();
    } else if (jQuery.browser.mozilla || $.browser.opera) {
        var selection = obj.ownerDocument.defaultView.getSelection();
        var range = obj.ownerDocument.createRange();
        range.selectNodeContents(obj);
        selection.removeAllRanges();
        selection.addRange(range);
    } else if (jQuery.browser.safari) {
        var selection = obj.ownerDocument.defaultView.getSelection();
        selection.setBaseAndExtent(obj, 0, obj, 1);
    }
    return this;
}

jQuery('#adminForm').on('change', '#jform_snippet',function (e) {
	e.preventDefault();
	// get type value
	var snippetId = jQuery("#jform_snippet option:selected").val();
	getSnippetDetails(snippetId);
});

jQuery(document).ready(function() {
	// get type value
	var snippetId = jQuery("#jform_snippet option:selected").val();
	getSnippetDetails(snippetId);
});
// some lang strings
var select_a_snippet = '<?php echo JText::_('COM_COMPONENTBUILDER_SELECT_A_SNIPPET'); ?>';
var create_a_snippet = '<?php echo JText::_('COM_COMPONENTBUILDER_CREATE_A_SNIPPET'); ?>';

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
