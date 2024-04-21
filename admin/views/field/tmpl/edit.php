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

<?php echo LayoutHelper::render('field.set_properties_above', $this); ?>
<div class="form-horizontal">

	<?php echo Html::_('bootstrap.startTabSet', 'fieldTab', ['active' => 'set_properties', 'recall' => true]); ?>

	<?php echo Html::_('bootstrap.addTab', 'fieldTab', 'set_properties', Text::_('COM_COMPONENTBUILDER_FIELD_SET_PROPERTIES', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('field.set_properties_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'fieldTab', 'database', Text::_('COM_COMPONENTBUILDER_FIELD_DATABASE', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('field.database_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('field.database_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('field.database_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'fieldTab', 'scripts', Text::_('COM_COMPONENTBUILDER_FIELD_SCRIPTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('field.scripts_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('field.scripts_right', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'fieldTab', 'type_info', Text::_('COM_COMPONENTBUILDER_FIELD_TYPE_INFO', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('field.type_info_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'fieldTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('field.edit.state') || ($this->canDo->get('field.delete') && $this->canDo->get('field.edit.state'))) : ?>
	<?php echo Html::_('bootstrap.addTab', 'fieldTab', 'publishing', Text::_('COM_COMPONENTBUILDER_FIELD_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('field.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('field.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('bootstrap.addTab', 'fieldTab', 'permissions', Text::_('COM_COMPONENTBUILDER_FIELD_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="field.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo LayoutHelper::render('field.set_properties_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_datalenght listeners for datalenght_vvvvwbh function
jQuery('#jform_datalenght').on('keyup',function()
{
	var datalenght_vvvvwbh = jQuery("#jform_datalenght").val();
	vvvvwbh(datalenght_vvvvwbh);

});
jQuery('#adminForm').on('change', '#jform_datalenght',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwbh = jQuery("#jform_datalenght").val();
	vvvvwbh(datalenght_vvvvwbh);

});

// #jform_datadefault listeners for datadefault_vvvvwbi function
jQuery('#jform_datadefault').on('keyup',function()
{
	var datadefault_vvvvwbi = jQuery("#jform_datadefault").val();
	vvvvwbi(datadefault_vvvvwbi);

});
jQuery('#adminForm').on('change', '#jform_datadefault',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwbi = jQuery("#jform_datadefault").val();
	vvvvwbi(datadefault_vvvvwbi);

});

// #jform_datatype listeners for datatype_vvvvwbj function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	vvvvwbj(datatype_vvvvwbj);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbj = jQuery("#jform_datatype").val();
	vvvvwbj(datatype_vvvvwbj);

});

// #jform_datatype listeners for datatype_vvvvwbk function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(datatype_vvvvwbk);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwbk = jQuery("#jform_datatype").val();
	vvvvwbk(datatype_vvvvwbk);

});

// #jform_store listeners for store_vvvvwbl function
jQuery('#jform_store').on('keyup',function()
{
	var store_vvvvwbl = jQuery("#jform_store").val();
	var datatype_vvvvwbl = jQuery("#jform_datatype").val();
	vvvvwbl(store_vvvvwbl,datatype_vvvvwbl);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_vvvvwbl = jQuery("#jform_store").val();
	var datatype_vvvvwbl = jQuery("#jform_datatype").val();
	vvvvwbl(store_vvvvwbl,datatype_vvvvwbl);

});

// #jform_datatype listeners for datatype_vvvvwbl function
jQuery('#jform_datatype').on('keyup',function()
{
	var store_vvvvwbl = jQuery("#jform_store").val();
	var datatype_vvvvwbl = jQuery("#jform_datatype").val();
	vvvvwbl(store_vvvvwbl,datatype_vvvvwbl);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var store_vvvvwbl = jQuery("#jform_store").val();
	var datatype_vvvvwbl = jQuery("#jform_datatype").val();
	vvvvwbl(store_vvvvwbl,datatype_vvvvwbl);

});

// #jform_store listeners for store_vvvvwbn function
jQuery('#jform_store').on('keyup',function()
{
	var store_vvvvwbn = jQuery("#jform_store").val();
	vvvvwbn(store_vvvvwbn);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_vvvvwbn = jQuery("#jform_store").val();
	vvvvwbn(store_vvvvwbn);

});

// #jform_add_css_view listeners for add_css_view_vvvvwbo function
jQuery('#jform_add_css_view').on('keyup',function()
{
	var add_css_view_vvvvwbo = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwbo(add_css_view_vvvvwbo);

});
jQuery('#adminForm').on('change', '#jform_add_css_view',function (e)
{
	e.preventDefault();
	var add_css_view_vvvvwbo = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwbo(add_css_view_vvvvwbo);

});

// #jform_add_css_views listeners for add_css_views_vvvvwbp function
jQuery('#jform_add_css_views').on('keyup',function()
{
	var add_css_views_vvvvwbp = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwbp(add_css_views_vvvvwbp);

});
jQuery('#adminForm').on('change', '#jform_add_css_views',function (e)
{
	e.preventDefault();
	var add_css_views_vvvvwbp = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwbp(add_css_views_vvvvwbp);

});

// #jform_add_javascript_view_footer listeners for add_javascript_view_footer_vvvvwbq function
jQuery('#jform_add_javascript_view_footer').on('keyup',function()
{
	var add_javascript_view_footer_vvvvwbq = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwbq(add_javascript_view_footer_vvvvwbq);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_view_footer',function (e)
{
	e.preventDefault();
	var add_javascript_view_footer_vvvvwbq = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwbq(add_javascript_view_footer_vvvvwbq);

});

// #jform_add_javascript_views_footer listeners for add_javascript_views_footer_vvvvwbr function
jQuery('#jform_add_javascript_views_footer').on('keyup',function()
{
	var add_javascript_views_footer_vvvvwbr = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwbr(add_javascript_views_footer_vvvvwbr);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_views_footer',function (e)
{
	e.preventDefault();
	var add_javascript_views_footer_vvvvwbr = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvwbr(add_javascript_views_footer_vvvvwbr);

});



jQuery(function() {
	setTimeout(
		function() {
			// load the on click event
			jQuery("code").click(function() {
				jQuery(this).selText().addClass("selected");
			});
		}, 2000);
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
