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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
Html::addIncludePath(JPATH_COMPONENT.'/helpers/html');
Html::_('behavior.formvalidator');
Html::_('formbehavior.chosen', 'select');
Html::_('behavior.keepalive');

$componentParams = $this->params; // will be removed just use $this->params instead
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

<?php echo LayoutHelper::render('joomla_component.details_above', $this); ?>
<div class="form-horizontal">

	<?php echo Html::_('bootstrap.startTabSet', 'joomla_componentTab', ['active' => 'details', 'recall' => true]); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'details', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.details_right', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'settings', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SETTINGS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.settings_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.settings_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('joomla_component.settings_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'admin_views', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_ADMIN_VIEWS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('joomla_component.admin_views_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'site_views', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_SITE_VIEWS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('joomla_component.site_views_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'custom_admin_views', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_CUSTOM_ADMIN_VIEWS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('joomla_component.custom_admin_views_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'libs_helpers', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_LIBS_HELPERS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('joomla_component.libs_helpers_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'dash_install', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_DASH_INSTALL', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.dash_install_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.dash_install_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('joomla_component.dash_install_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'mysql', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_MYSQL', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('joomla_component.mysql_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'readme', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_README', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.readme_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.readme_right', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'dynamic_integration', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_DYNAMIC_INTEGRATION', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.dynamic_integration_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.dynamic_integration_right', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'dynamic_build', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_DYNAMIC_BUILD', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('joomla_component.dynamic_build_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'joomla_componentTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('joomla_component.edit.created_by') || $this->canDo->get('joomla_component.edit.created') || $this->canDo->get('joomla_component.edit.state') || ($this->canDo->get('joomla_component.delete') && $this->canDo->get('joomla_component.edit.state'))) : ?>
	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'publishing', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('joomla_component.metadata', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('bootstrap.addTab', 'joomla_componentTab', 'permissions', Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_PERMISSION', true)); ?>
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
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php echo Html::_('bootstrap.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="joomla_component.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo LayoutHelper::render('joomla_component.details_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_emptycontributors listeners for emptycontributors_vvvvvvv function
jQuery('#jform_emptycontributors').on('keyup',function()
{
	var emptycontributors_vvvvvvv = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	vvvvvvv(emptycontributors_vvvvvvv);

});
jQuery('#adminForm').on('change', '#jform_emptycontributors',function (e)
{
	e.preventDefault();
	var emptycontributors_vvvvvvv = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	vvvvvvv(emptycontributors_vvvvvvv);

});

// #jform_update_server_target listeners for update_server_target_vvvvvvw function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvvw = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvw = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvw(update_server_target_vvvvvvw,add_update_server_vvvvvvw);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvvw = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvw = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvw(update_server_target_vvvvvvw,add_update_server_vvvvvvw);

});

// #jform_add_update_server listeners for add_update_server_vvvvvvw function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvvw = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvw = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvw(update_server_target_vvvvvvw,add_update_server_vvvvvvw);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvvw = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvw = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvw(update_server_target_vvvvvvw,add_update_server_vvvvvvw);

});

// #jform_add_update_server listeners for add_update_server_vvvvvvx function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvvx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvvx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvvx(add_update_server_vvvvvvx,update_server_target_vvvvvvx);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvvx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvvx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvvx(add_update_server_vvvvvvx,update_server_target_vvvvvvx);

});

// #jform_update_server_target listeners for update_server_target_vvvvvvx function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var add_update_server_vvvvvvx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvvx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvvx(add_update_server_vvvvvvx,update_server_target_vvvvvvx);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvvx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvvx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvvx(add_update_server_vvvvvvx,update_server_target_vvvvvvx);

});

// #jform_update_server_target listeners for update_server_target_vvvvvvy function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvvy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvy(update_server_target_vvvvvvy,add_update_server_vvvvvvy);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvvy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvy(update_server_target_vvvvvvy,add_update_server_vvvvvvy);

});

// #jform_add_update_server listeners for add_update_server_vvvvvvy function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvvy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvy(update_server_target_vvvvvvy,add_update_server_vvvvvvy);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvvy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvy(update_server_target_vvvvvvy,add_update_server_vvvvvvy);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwa function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvwa = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwa = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwa(update_server_target_vvvvvwa,add_update_server_vvvvvwa);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwa = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwa = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwa(update_server_target_vvvvvwa,add_update_server_vvvvvwa);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwa function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvwa = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwa = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwa(update_server_target_vvvvvwa,add_update_server_vvvvvwa);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwa = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwa = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwa(update_server_target_vvvvvwa,add_update_server_vvvvvwa);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwc function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvwc = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwc(add_update_server_vvvvvwc);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvwc = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwc(add_update_server_vvvvvwc);

});

// #jform_buildcomp listeners for buildcomp_vvvvvwd function
jQuery('#jform_buildcomp').on('keyup',function()
{
	var buildcomp_vvvvvwd = jQuery("#jform_buildcomp input[type='radio']:checked").val();
	vvvvvwd(buildcomp_vvvvvwd);

});
jQuery('#adminForm').on('change', '#jform_buildcomp',function (e)
{
	e.preventDefault();
	var buildcomp_vvvvvwd = jQuery("#jform_buildcomp input[type='radio']:checked").val();
	vvvvvwd(buildcomp_vvvvvwd);

});

// #jform_dashboard_type listeners for dashboard_type_vvvvvwe function
jQuery('#jform_dashboard_type').on('keyup',function()
{
	var dashboard_type_vvvvvwe = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	vvvvvwe(dashboard_type_vvvvvwe);

});
jQuery('#adminForm').on('change', '#jform_dashboard_type',function (e)
{
	e.preventDefault();
	var dashboard_type_vvvvvwe = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	vvvvvwe(dashboard_type_vvvvvwe);

});

// #jform_dashboard_type listeners for dashboard_type_vvvvvwf function
jQuery('#jform_dashboard_type').on('keyup',function()
{
	var dashboard_type_vvvvvwf = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	vvvvvwf(dashboard_type_vvvvvwf);

});
jQuery('#adminForm').on('change', '#jform_dashboard_type',function (e)
{
	e.preventDefault();
	var dashboard_type_vvvvvwf = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	vvvvvwf(dashboard_type_vvvvvwf);

});

// #jform_translation_tool listeners for translation_tool_vvvvvwg function
jQuery('#jform_translation_tool').on('keyup',function()
{
	var translation_tool_vvvvvwg = jQuery("#jform_translation_tool").val();
	vvvvvwg(translation_tool_vvvvvwg);

});
jQuery('#adminForm').on('change', '#jform_translation_tool',function (e)
{
	e.preventDefault();
	var translation_tool_vvvvvwg = jQuery("#jform_translation_tool").val();
	vvvvvwg(translation_tool_vvvvvwg);

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
// check when dashboard switch changes
jQuery('#adminForm').on('change', '#jform_dashboard_type',function (e)
{
	e.preventDefault();
	var dasboard_type = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	dasboardSwitch(dasboard_type);
});
</script>
