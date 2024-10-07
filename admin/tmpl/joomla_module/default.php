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

<?php echo LayoutHelper::render('joomla_module.html_above', $this); ?>
<div class="main-card">

	<?php echo Html::_('uitab.startTabSet', 'joomla_moduleTab', ['active' => 'html', 'recall' => true]); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'html', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_HTML', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_module.html_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_module.html_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_module.html_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'code', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_CODE', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_module.code_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_module.code_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_module.code_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'helper', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_HELPER', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_module.helper_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_module.helper_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_module.helper_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'forms_fields', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_FORMS_FIELDS', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_module.forms_fields_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'script_file', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_SCRIPT_FILE', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_module.script_file_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'mysql', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_MYSQL', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_module.mysql_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'readme', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_README', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_module.readme_left', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'dynamic_integration', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_DYNAMIC_INTEGRATION', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('joomla_module.dynamic_integration_left', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'joomla_moduleTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('joomla_module.edit.created_by') || $this->canDo->get('joomla_module.edit.created') || $this->canDo->get('joomla_module.edit.state') || ($this->canDo->get('joomla_module.delete') && $this->canDo->get('joomla_module.edit.state'))) : ?>
	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'publishing', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_PUBLISHING', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_module.publishing', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('joomla_module.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('uitab.addTab', 'joomla_moduleTab', 'permissions', Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_PERMISSION', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<fieldset id="fieldset-rules" class="options-form">
					<legend><?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_MODULE_PERMISSION'); ?></legend>
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
		<input type="hidden" name="task" value="joomla_module.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>
</form>
</div>

<script type="text/javascript">

// #jform_add_class_helper listeners for add_class_helper_vvvvvwh function
jQuery('#jform_add_class_helper').on('keyup',function()
{
	var add_class_helper_vvvvvwh = jQuery("#jform_add_class_helper").val();
	vvvvvwh(add_class_helper_vvvvvwh);

});
jQuery('#adminForm').on('change', '#jform_add_class_helper',function (e)
{
	e.preventDefault();
	var add_class_helper_vvvvvwh = jQuery("#jform_add_class_helper").val();
	vvvvvwh(add_class_helper_vvvvvwh);

});

// #jform_add_class_helper_header listeners for add_class_helper_header_vvvvvwi function
jQuery('#jform_add_class_helper_header').on('keyup',function()
{
	var add_class_helper_header_vvvvvwi = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvwi = jQuery("#jform_add_class_helper").val();
	vvvvvwi(add_class_helper_header_vvvvvwi,add_class_helper_vvvvvwi);

});
jQuery('#adminForm').on('change', '#jform_add_class_helper_header',function (e)
{
	e.preventDefault();
	var add_class_helper_header_vvvvvwi = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvwi = jQuery("#jform_add_class_helper").val();
	vvvvvwi(add_class_helper_header_vvvvvwi,add_class_helper_vvvvvwi);

});

// #jform_add_class_helper listeners for add_class_helper_vvvvvwi function
jQuery('#jform_add_class_helper').on('keyup',function()
{
	var add_class_helper_header_vvvvvwi = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvwi = jQuery("#jform_add_class_helper").val();
	vvvvvwi(add_class_helper_header_vvvvvwi,add_class_helper_vvvvvwi);

});
jQuery('#adminForm').on('change', '#jform_add_class_helper',function (e)
{
	e.preventDefault();
	var add_class_helper_header_vvvvvwi = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvwi = jQuery("#jform_add_class_helper").val();
	vvvvvwi(add_class_helper_header_vvvvvwi,add_class_helper_vvvvvwi);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwk function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvwk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwk(update_server_target_vvvvvwk,add_update_server_vvvvvwk);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwk(update_server_target_vvvvvwk,add_update_server_vvvvvwk);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwk function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvwk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwk(update_server_target_vvvvvwk,add_update_server_vvvvvwk);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwk(update_server_target_vvvvvwk,add_update_server_vvvvvwk);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwl function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var add_update_server_vvvvvwl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwl(add_update_server_vvvvvwl,update_server_target_vvvvvwl);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvwl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwl(add_update_server_vvvvvwl,update_server_target_vvvvvwl);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwl function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var add_update_server_vvvvvwl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwl(add_update_server_vvvvvwl,update_server_target_vvvvvwl);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var add_update_server_vvvvvwl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwl(add_update_server_vvvvvwl,update_server_target_vvvvvwl);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwm function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvwm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwm(update_server_target_vvvvvwm,add_update_server_vvvvvwm);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwm(update_server_target_vvvvvwm,add_update_server_vvvvvwm);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwm function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvwm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwm(update_server_target_vvvvvwm,add_update_server_vvvvvwm);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwm(update_server_target_vvvvvwm,add_update_server_vvvvvwm);

});

// #jform_update_server_target listeners for update_server_target_vvvvvwo function
jQuery('#jform_update_server_target').on('keyup',function()
{
	var update_server_target_vvvvvwo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwo(update_server_target_vvvvvwo,add_update_server_vvvvvwo);

});
jQuery('#adminForm').on('change', '#jform_update_server_target',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwo(update_server_target_vvvvvwo,add_update_server_vvvvvwo);

});

// #jform_add_update_server listeners for add_update_server_vvvvvwo function
jQuery('#jform_add_update_server').on('keyup',function()
{
	var update_server_target_vvvvvwo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwo(update_server_target_vvvvvwo,add_update_server_vvvvvwo);

});
jQuery('#adminForm').on('change', '#jform_add_update_server',function (e)
{
	e.preventDefault();
	var update_server_target_vvvvvwo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwo(update_server_target_vvvvvwo,add_update_server_vvvvvwo);

});



jQuery('#jform_snippet').closest('.input-append').addClass('jform_snippet_input_width');
jQuery(function() {
	// make sure the code bocks are active
	document.querySelectorAll("code").forEach(function(codeBlock) {
		codeBlock.addEventListener("click", function() {
			codeBlock.selText(); // Call the custom selText function
			codeBlock.classList.add("selected"); // Add the "selected" class
		});
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
var select_a_snippet = '<?php echo Text::_('COM_COMPONENTBUILDER_SELECT_A_SNIPPET'); ?>';
var create_a_snippet = '<?php echo Text::_('COM_COMPONENTBUILDER_CREATE_A_SNIPPET'); ?>';


HTMLElement.prototype.selText = function() {
    var obj = this;

    // For modern browsers, handle the selection
    var selection = window.getSelection();
    var range = document.createRange();

    // Select the content of the element
    range.selectNodeContents(obj);
    selection.removeAllRanges();  // Clear any previous selections
    selection.addRange(range);    // Add the new selection range

    return this;
};

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
