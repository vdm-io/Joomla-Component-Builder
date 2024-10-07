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

<?php echo LayoutHelper::render('field.set_properties_above', $this); ?>
<div class="main-card">

	<?php echo Html::_('uitab.startTabSet', 'fieldTab', ['active' => 'set_properties', 'recall' => true]); ?>

	<?php echo Html::_('uitab.addTab', 'fieldTab', 'set_properties', Text::_('COM_COMPONENTBUILDER_FIELD_SET_PROPERTIES', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('field.set_properties_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'fieldTab', 'database', Text::_('COM_COMPONENTBUILDER_FIELD_DATABASE', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('field.database_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('field.database_right', $this); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('field.database_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'fieldTab', 'scripts', Text::_('COM_COMPONENTBUILDER_FIELD_SCRIPTS', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('field.scripts_left', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('field.scripts_right', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.addTab', 'fieldTab', 'type_info', Text::_('COM_COMPONENTBUILDER_FIELD_TYPE_INFO', true)); ?>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo LayoutHelper::render('field.type_info_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'fieldTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('field.edit.state') || ($this->canDo->get('field.delete') && $this->canDo->get('field.edit.state'))) : ?>
	<?php echo Html::_('uitab.addTab', 'fieldTab', 'publishing', Text::_('COM_COMPONENTBUILDER_FIELD_PUBLISHING', true)); ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo LayoutHelper::render('field.publishing', $this); ?>
			</div>
			<div class="col-md-6">
				<?php echo LayoutHelper::render('field.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('uitab.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('uitab.addTab', 'fieldTab', 'permissions', Text::_('COM_COMPONENTBUILDER_FIELD_PERMISSION', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<fieldset id="fieldset-rules" class="options-form">
					<legend><?php echo Text::_('COM_COMPONENTBUILDER_FIELD_PERMISSION'); ?></legend>
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
		<input type="hidden" name="task" value="field.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo LayoutHelper::render('field.set_properties_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_datalenght listeners for datalenght_vvvvwbf function
jQuery('#jform_datalenght').on('keyup',function()
{
	var datalenght_vvvvwbf = jQuery("#jform_datalenght").val();
	vvvvwbf(datalenght_vvvvwbf);

});
jQuery('#adminForm').on('change', '#jform_datalenght',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwbf = jQuery("#jform_datalenght").val();
	vvvvwbf(datalenght_vvvvwbf);

});

// #jform_datadefault listeners for datadefault_vvvvwbg function
jQuery('#jform_datadefault').on('keyup',function()
{
	var datadefault_vvvvwbg = jQuery("#jform_datadefault").val();
	vvvvwbg(datadefault_vvvvwbg);

});
jQuery('#adminForm').on('change', '#jform_datadefault',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwbg = jQuery("#jform_datadefault").val();
	vvvvwbg(datadefault_vvvvwbg);

});

// #jform_datatype listeners for datatype_vvvvwbh function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbh = jQuery("#jform_datatype").val();
	vvvvwbh(datatype_vvvvwbh);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbh = jQuery("#jform_datatype").val();
	vvvvwbh(datatype_vvvvwbh);

});

// #jform_datatype listeners for datatype_vvvvwbi function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	vvvvwbi(datatype_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbi = jQuery("#jform_datatype").val();
	vvvvwbi(datatype_vvvvwbi);

});

// #jform_store listeners for store_vvvvwbl function
jQuery('#jform_store').on('keyup',function()
{
	var store_vvvvwbl = jQuery("#jform_store").val();
	vvvvwbl(store_vvvvwbl);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_vvvvwbl = jQuery("#jform_store").val();
	vvvvwbl(store_vvvvwbl);

});

// #jform_add_css_view listeners for add_css_view_vvvvwbm function
jQuery('#jform_add_css_view').on('keyup',function()
{
	var add_css_view_vvvvwbm = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwbm(add_css_view_vvvvwbm);

});
jQuery('#adminForm').on('change', '#jform_add_css_view',function (e)
{
	e.preventDefault();
	var add_css_view_vvvvwbm = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwbm(add_css_view_vvvvwbm);

});

// #jform_add_css_views listeners for add_css_views_vvvvwbn function
jQuery('#jform_add_css_views').on('keyup',function()
{
	var add_css_views_vvvvwbn = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwbn(add_css_views_vvvvwbn);

});
jQuery('#adminForm').on('change', '#jform_add_css_views',function (e)
{
	e.preventDefault();
	var add_css_views_vvvvwbn = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwbn(add_css_views_vvvvwbn);

});

// #jform_add_javascript_view_footer listeners for add_javascript_view_footer_vvvvwbo function
jQuery('#jform_add_javascript_view_footer').on('keyup',function()
{
	var add_javascript_view_footer_vvvvwbo = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwbo(add_javascript_view_footer_vvvvwbo);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_view_footer',function (e)
{
	e.preventDefault();
	var add_javascript_view_footer_vvvvwbo = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwbo(add_javascript_view_footer_vvvvwbo);

});

// #jform_add_javascript_views_footer listeners for add_javascript_views_footer_vvvvwbp function
jQuery('#jform_add_javascript_views_footer').on('keyup',function()
{
	var add_javascript_views_footer_vvvvwbp = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwbp(add_javascript_views_footer_vvvvwbp);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_views_footer',function (e)
{
	e.preventDefault();
	var add_javascript_views_footer_vvvvwbp = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwbp(add_javascript_views_footer_vvvvwbp);

});



jQuery(function() {
	setTimeout(
		function() {
			// make sure the code bocks are active
			document.querySelectorAll("code").forEach(function(codeBlock) {
				codeBlock.addEventListener("click", function() {
					codeBlock.selText(); // Call the custom selText function
					codeBlock.classList.add("selected"); // Add the "selected" class
				});
			});
		}, 2000);
});

jQuery('#adminForm').on('change', '#jform_fieldtype',function (e) {
	e.preventDefault();
	// get type value
	var fieldId = jQuery("#jform_fieldtype option:selected").val();
	getFieldTypeProperties(fieldId, true);
	// get the field type text
	var fieldText = jQuery("#jform_fieldtype option:selected").text().toLowerCase();
	// now check if database input is needed
	dbChecker(fieldText);
});


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
