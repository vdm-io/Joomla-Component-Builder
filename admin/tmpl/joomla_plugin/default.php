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

// #jform_class_extends listeners for class_extends_vvvvvwq function
jQuery('#jform_class_extends').on('keyup',function()
{
	var class_extends_vvvvvwq = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvwq = jQuery("#jform_joomla_plugin_group").val();
	vvvvvwq(class_extends_vvvvvwq,joomla_plugin_group_vvvvvwq);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvwq = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvwq = jQuery("#jform_joomla_plugin_group").val();
	vvvvvwq(class_extends_vvvvvwq,joomla_plugin_group_vvvvvwq);

});

// #jform_joomla_plugin_group listeners for joomla_plugin_group_vvvvvwq function
jQuery('#jform_joomla_plugin_group').on('keyup',function()
{
	var class_extends_vvvvvwq = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvwq = jQuery("#jform_joomla_plugin_group").val();
	vvvvvwq(class_extends_vvvvvwq,joomla_plugin_group_vvvvvwq);

});
jQuery('#adminForm').on('change', '#jform_joomla_plugin_group',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvwq = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvwq = jQuery("#jform_joomla_plugin_group").val();
	vvvvvwq(class_extends_vvvvvwq,joomla_plugin_group_vvvvvwq);

});

// #jform_joomla_plugin_group listeners for joomla_plugin_group_vvvvvwr function
jQuery('#jform_joomla_plugin_group').on('keyup',function()
{
	var joomla_plugin_group_vvvvvwr = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvwr = jQuery("#jform_class_extends").val();
	vvvvvwr(joomla_plugin_group_vvvvvwr,class_extends_vvvvvwr);

});
jQuery('#adminForm').on('change', '#jform_joomla_plugin_group',function (e)
{
	e.preventDefault();
	var joomla_plugin_group_vvvvvwr = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvwr = jQuery("#jform_class_extends").val();
	vvvvvwr(joomla_plugin_group_vvvvvwr,class_extends_vvvvvwr);

});

// #jform_class_extends listeners for class_extends_vvvvvwr function
jQuery('#jform_class_extends').on('keyup',function()
{
	var joomla_plugin_group_vvvvvwr = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvwr = jQuery("#jform_class_extends").val();
	vvvvvwr(joomla_plugin_group_vvvvvwr,class_extends_vvvvvwr);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var joomla_plugin_group_vvvvvwr = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvwr = jQuery("#jform_class_extends").val();
	vvvvvwr(joomla_plugin_group_vvvvvwr,class_extends_vvvvvwr);

});

// #jform_class_extends listeners for class_extends_vvvvvws function
jQuery('#jform_class_extends').on('keyup',function()
{
	var class_extends_vvvvvws = jQuery("#jform_class_extends").val();
	vvvvvws(class_extends_vvvvvws);

});
jQuery('#adminForm').on('change', '#jform_class_extends',function (e)
{
	e.preventDefault();
	var class_extends_vvvvvws = jQuery("#jform_class_extends").val();
	vvvvvws(class_extends_vvvvvws);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwu function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvwu = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwu = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwu(update_server_target_vvvvvwu,add_update_server_vvvvvwu);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwu = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwu = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwu(update_server_target_vvvvvwu,add_update_server_vvvvvwu);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwu function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvwu = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwu = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwu(update_server_target_vvvvvwu,add_update_server_vvvvvwu);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwu = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwu = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwu(update_server_target_vvvvvwu,add_update_server_vvvvvwu);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwv function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvwv = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwv = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwv(add_update_server_vvvvvwv,update_server_target_vvvvvwv);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvwv = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwv = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwv(add_update_server_vvvvvwv,update_server_target_vvvvvwv);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwv function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var add_update_server_vvvvvwv = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwv = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwv(add_update_server_vvvvvwv,update_server_target_vvvvvwv);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvwv = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwv = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwv(add_update_server_vvvvvwv,update_server_target_vvvvvwv);

});

// #jform_update_server_target listeners for update_server_target_vvvvvww function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvww = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvww = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvww(update_server_target_vvvvvww,add_update_server_vvvvvww);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvww = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvww = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvww(update_server_target_vvvvvww,add_update_server_vvvvvww);

});

// #jform_add_update_server listeners for add_update_server_vvvvvww function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvww = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvww = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvww(update_server_target_vvvvvww,add_update_server_vvvvvww);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvww = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvww = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvww(update_server_target_vvvvvww,add_update_server_vvvvvww);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwy function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvwy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwy(update_server_target_vvvvvwy,add_update_server_vvvvvwy);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwy(update_server_target_vvvvvwy,add_update_server_vvvvvwy);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwy function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvwy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwy(update_server_target_vvvvvwy,add_update_server_vvvvvwy);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwy(update_server_target_vvvvvwy,add_update_server_vvvvvwy);

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
