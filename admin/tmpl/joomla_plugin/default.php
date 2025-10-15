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
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('keepalive')->useScript('form.validate');
Html::_('bootstrap.tooltip');

// No direct access to this file
defined('_JEXEC') or die;

$layout  = $this->isModal ? 'modal' : 'edit';
$tmpl    = $this->input->get('tmpl');
$tmpl    = $tmpl ? '&tmpl=' . $tmpl : '';
?>
<script type="text/javascript">
	// waiting spinner
	var outerDiv = document.querySelector('body');
	var loadingDiv = document.createElement('div');
	loadingDiv.id = 'loading';
	loadingDiv.style.cssText = "background: rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/ajax.gif') 50% 35% no-repeat; top: " + (outerDiv.getBoundingClientRect().top + window.pageYOffset) + "px; left: " + (outerDiv.getBoundingClientRect().left + window.pageXOffset) + "px; width: " + outerDiv.offsetWidth + "px; height: " + outerDiv.offsetHeight + "px; position: fixed; opacity: 0.80; -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80); filter: alpha(opacity=80); display: none;";
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
<form action="<?php echo Route::_('index.php?option=com_componentbuilder&&layout=' . $layout . $tmpl . '&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

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
				<fieldset id="fieldset-rules" class="options-form">
					<legend><?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_PLUGIN_PERMISSION'); ?></legend>
					<div>
						<?php echo $this->form->getInput('rules'); ?>
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

// #jform_update_server_target listeners for update_server_target_vvvvvwx function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvwx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwx(update_server_target_vvvvvwx,add_update_server_vvvvvwx);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwx(update_server_target_vvvvvwx,add_update_server_vvvvvwx);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwx function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvwx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwx(update_server_target_vvvvvwx,add_update_server_vvvvvwx);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwx(update_server_target_vvvvvwx,add_update_server_vvvvvwx);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwy function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvwy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwy(add_update_server_vvvvvwy,update_server_target_vvvvvwy);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvwy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwy(add_update_server_vvvvvwy,update_server_target_vvvvvwy);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwy function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var add_update_server_vvvvvwy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwy(add_update_server_vvvvvwy,update_server_target_vvvvvwy);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvwy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwy(add_update_server_vvvvvwy,update_server_target_vvvvvwy);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwz function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvwz = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwz = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwz(update_server_target_vvvvvwz,add_update_server_vvvvvwz);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwz = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwz = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwz(update_server_target_vvvvvwz,add_update_server_vvvvvwz);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwz function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvwz = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwz = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwz(update_server_target_vvvvvwz,add_update_server_vvvvvwz);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwz = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwz = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwz(update_server_target_vvvvvwz,add_update_server_vvvvvwz);

});

// #jform_update_server_target listeners for update_server_target_vvvvvxb function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvxb = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxb = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxb(update_server_target_vvvvvxb,add_update_server_vvvvvxb);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxb = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxb = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxb(update_server_target_vvvvvxb,add_update_server_vvvvvxb);

});

// #jform_add_update_server listeners for add_update_server_vvvvvxb function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvxb = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxb = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxb(update_server_target_vvvvvxb,add_update_server_vvvvvxb);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvxb = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxb = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxb(update_server_target_vvvvvxb,add_update_server_vvvvvxb);

});

// #jform_add_head listeners for add_head_vvvvvxd function
jQuery('#jform_add_head').on('keyup',function()
{
	var add_head_vvvvvxd = jQuery("#jform_add_head input[type='radio']:checked").val();
	vvvvvxd(add_head_vvvvvxd);

});
jQuery('#adminForm').on('change', '#jform_add_head',function (e)
{
	e.preventDefault();
	var add_head_vvvvvxd = jQuery("#jform_add_head input[type='radio']:checked").val();
	vvvvvxd(add_head_vvvvvxd);

});




<?php
	$app = Factory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
	{
		echo 'var url = "'. Uri::root() . '";';
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
