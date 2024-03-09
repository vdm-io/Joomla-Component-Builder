<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')->useScript('form.validate');
Html::_('bootstrap.tooltip');

// No direct access to this file
defined('_JEXEC') or die;

?>
<script type="text/javascript">
	// waiting spinner
	var outerDiv = document.querySelector('body');
	var loadingDiv = document.createElement('div');
	loadingDiv.id = 'loading';
	loadingDiv.style.cssText = "background: rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat; top: " + (outerDiv.getBoundingClientRect().top + window.pageYOffset) + "px; left: " + (outerDiv.getBoundingClientRect().left + window.pageXOffset) + "px; width: " + outerDiv.offsetWidth + "px; height: " + outerDiv.offsetHeight + "px; position: fixed; opacity: 0.80; -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80); filter: alpha(opacity=80); display: none;";
	outerDiv.appendChild(loadingDiv);
	loadingDiv.style.display = 'block';
	// when page is ready remove and show
	window.addEventListener('load', function() {
		var componentLoader = document.getElementById('componentbuilder_loader');
		if (componentLoader) componentLoader.style.display = 'block';
		loadingDiv.style.display = 'none';
	});
</script>
<div id="componentbuilder_loader" style="display: none;">
<form action="<?php echo Route::_('index.php?option=com_componentbuilder&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

<?php echo LayoutHelper::render('joomla_plugin.code_above', $this); ?>
<div class="main-card">

	<?php echo Html::_('uitab.startTabSet', 'joomla_pluginTab', ['active' => 'code', 'recall' => true]); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_pluginTab', 'code', Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_CODE', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_plugin.code_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_plugin.code_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_plugin.code_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_pluginTab', 'forms_fields', Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_FORMS_FIELDS', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_plugin.forms_fields_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_pluginTab', 'script_file', Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_SCRIPT_FILE', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_plugin.script_file_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_pluginTab', 'mysql', Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_MYSQL', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_plugin.mysql_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_pluginTab', 'readme', Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_README', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_plugin.readme_left', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_pluginTab', 'dynamic_integration', Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_DYNAMIC_INTEGRATION', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_plugin.dynamic_integration_left', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'joomla_pluginTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('joomla_plugin.edit.created_by') || $this->canDo->get('joomla_plugin.edit.created') || $this->canDo->get('joomla_plugin.edit.state') || ($this->canDo->get('joomla_plugin.delete') && $this->canDo->get('joomla_plugin.edit.state'))) : ?>
	<?php echo Html::_('uitab.addTab', 'joomla_pluginTab', 'publishing', Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_PUBLISHING', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_plugin.publishing', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_plugin.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('uitab.addTab', 'joomla_pluginTab', 'permissions', Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_PERMISSION', true)); ?>
		<div class="row">
			<div class="col-md-12">
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
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php echo Html::_('uitab.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="joomla_plugin.edit" />
		<?php echo Html::_('form.token'); ?>
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
	$app = Factory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
	{
		echo 'var url = "'. \Joomla\CMS\Uri\Uri::root() . '";';
	}
	else
	{
		echo 'var url = "";';
	}
?>
	return url+link;
}

document.addEventListener("DOMContentLoaded", function() {
	document.querySelectorAll(".loading-dots").forEach(function(loading_dots) {
		let x = 0;
		let intervalId = setInterval(function() {
			if (!loading_dots.classList.contains("loading-dots")) {
				clearInterval(intervalId);
				return;
			}
			let dots = ".".repeat(x % 8);
			loading_dots.textContent = dots;
			x++;
		}, 500);
	});
});
</script>
