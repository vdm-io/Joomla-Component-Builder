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

<?php echo LayoutHelper::render('site_view.details_above', $this); ?>
<div class="form-horizontal">
	<div class="span9">

	<?php echo Html::_('bootstrap.startTabSet', 'site_viewTab', ['active' => 'details', 'recall' => true]); ?>

	<?php echo Html::_('bootstrap.addTab', 'site_viewTab', 'details', Text::_('COM_COMPONENTBUILDER_SITE_VIEW_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('site_view.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('site_view.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('site_view.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'site_viewTab', 'custom_buttons', Text::_('COM_COMPONENTBUILDER_SITE_VIEW_CUSTOM_BUTTONS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('site_view.custom_buttons_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('site_view.custom_buttons_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('site_view.custom_buttons_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'site_viewTab', 'javascript_css', Text::_('COM_COMPONENTBUILDER_SITE_VIEW_JAVASCRIPT_CSS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('site_view.javascript_css_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'site_viewTab', 'php', Text::_('COM_COMPONENTBUILDER_SITE_VIEW_PHP', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('site_view.php_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php echo Html::_('bootstrap.addTab', 'site_viewTab', 'linked_components', Text::_('COM_COMPONENTBUILDER_SITE_VIEW_LINKED_COMPONENTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo LayoutHelper::render('site_view.linked_components_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'site_viewTab'; ?>
	<?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('core.edit.state') || ($this->canDo->get('core.delete') && $this->canDo->get('core.edit.state'))) : ?>
	<?php echo Html::_('bootstrap.addTab', 'site_viewTab', 'publishing', Text::_('COM_COMPONENTBUILDER_SITE_VIEW_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo LayoutHelper::render('site_view.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo LayoutHelper::render('site_view.publlshing', $this); ?>
			</div>
		</div>
	<?php echo Html::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo Html::_('bootstrap.addTab', 'site_viewTab', 'permissions', Text::_('COM_COMPONENTBUILDER_SITE_VIEW_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="site_view.edit" />
		<?php echo Html::_('form.token'); ?>
	</div>
	</div>
</div>
	<div class="span3">
		<?php echo LayoutHelper::render('site_view.details_rightside', $this); ?>
	</div>

<div class="clearfix"></div>
<?php echo LayoutHelper::render('site_view.details_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_add_php_view listeners for add_php_view_vvvvvyv function
jQuery('#jform_add_php_view').on('keyup',function()
{
	var add_php_view_vvvvvyv = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvyv(add_php_view_vvvvvyv);

});
jQuery('#adminForm').on('change', '#jform_add_php_view',function (e)
{
	e.preventDefault();
	var add_php_view_vvvvvyv = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvyv(add_php_view_vvvvvyv);

});

// #jform_add_php_jview_display listeners for add_php_jview_display_vvvvvyw function
jQuery('#jform_add_php_jview_display').on('keyup',function()
{
	var add_php_jview_display_vvvvvyw = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvvyw(add_php_jview_display_vvvvvyw);

});
jQuery('#adminForm').on('change', '#jform_add_php_jview_display',function (e)
{
	e.preventDefault();
	var add_php_jview_display_vvvvvyw = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvvyw(add_php_jview_display_vvvvvyw);

});

// #jform_add_php_jview listeners for add_php_jview_vvvvvyx function
jQuery('#jform_add_php_jview').on('keyup',function()
{
	var add_php_jview_vvvvvyx = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvvyx(add_php_jview_vvvvvyx);

});
jQuery('#adminForm').on('change', '#jform_add_php_jview',function (e)
{
	e.preventDefault();
	var add_php_jview_vvvvvyx = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvvyx(add_php_jview_vvvvvyx);

});

// #jform_add_php_document listeners for add_php_document_vvvvvyy function
jQuery('#jform_add_php_document').on('keyup',function()
{
	var add_php_document_vvvvvyy = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvyy(add_php_document_vvvvvyy);

});
jQuery('#adminForm').on('change', '#jform_add_php_document',function (e)
{
	e.preventDefault();
	var add_php_document_vvvvvyy = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvyy(add_php_document_vvvvvyy);

});

// #jform_add_css_document listeners for add_css_document_vvvvvyz function
jQuery('#jform_add_css_document').on('keyup',function()
{
	var add_css_document_vvvvvyz = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvvyz(add_css_document_vvvvvyz);

});
jQuery('#adminForm').on('change', '#jform_add_css_document',function (e)
{
	e.preventDefault();
	var add_css_document_vvvvvyz = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvvyz(add_css_document_vvvvvyz);

});

// #jform_add_javascript_file listeners for add_javascript_file_vvvvvza function
jQuery('#jform_add_javascript_file').on('keyup',function()
{
	var add_javascript_file_vvvvvza = jQuery("#jform_add_javascript_file input[type='radio']:checked").val();
	vvvvvza(add_javascript_file_vvvvvza);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_file',function (e)
{
	e.preventDefault();
	var add_javascript_file_vvvvvza = jQuery("#jform_add_javascript_file input[type='radio']:checked").val();
	vvvvvza(add_javascript_file_vvvvvza);

});

// #jform_add_js_document listeners for add_js_document_vvvvvzb function
jQuery('#jform_add_js_document').on('keyup',function()
{
	var add_js_document_vvvvvzb = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvvzb(add_js_document_vvvvvzb);

});
jQuery('#adminForm').on('change', '#jform_add_js_document',function (e)
{
	e.preventDefault();
	var add_js_document_vvvvvzb = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvvzb(add_js_document_vvvvvzb);

});

// #jform_add_css listeners for add_css_vvvvvzc function
jQuery('#jform_add_css').on('keyup',function()
{
	var add_css_vvvvvzc = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvzc(add_css_vvvvvzc);

});
jQuery('#adminForm').on('change', '#jform_add_css',function (e)
{
	e.preventDefault();
	var add_css_vvvvvzc = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvzc(add_css_vvvvvzc);

});

// #jform_add_php_ajax listeners for add_php_ajax_vvvvvzd function
jQuery('#jform_add_php_ajax').on('keyup',function()
{
	var add_php_ajax_vvvvvzd = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvzd(add_php_ajax_vvvvvzd);

});
jQuery('#adminForm').on('change', '#jform_add_php_ajax',function (e)
{
	e.preventDefault();
	var add_php_ajax_vvvvvzd = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvzd(add_php_ajax_vvvvvzd);

});

// #jform_add_custom_button listeners for add_custom_button_vvvvvze function
jQuery('#jform_add_custom_button').on('keyup',function()
{
	var add_custom_button_vvvvvze = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvze(add_custom_button_vvvvvze);

});
jQuery('#adminForm').on('change', '#jform_add_custom_button',function (e)
{
	e.preventDefault();
	var add_custom_button_vvvvvze = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvze(add_custom_button_vvvvvze);

});

// #jform_button_position listeners for button_position_vvvvvzf function
jQuery('#jform_button_position').on('keyup',function()
{
	var button_position_vvvvvzf = jQuery("#jform_button_position").val();
	vvvvvzf(button_position_vvvvvzf);

});
jQuery('#adminForm').on('change', '#jform_button_position',function (e)
{
	e.preventDefault();
	var button_position_vvvvvzf = jQuery("#jform_button_position").val();
	vvvvvzf(button_position_vvvvvzf);

});



jQuery(function() {
	jQuery('#open-libraries').html('<a href="index.php?option=com_componentbuilder&view=libraries"><?php echo JText::_('COM_COMPONENTBUILDER_LIBRARIES'); ?></a>');
});
jQuery('#jform_snippet').closest('.input-append').addClass('jform_snippet_input_width');
jQuery('#jform_main_get').closest('.input-append').addClass('jform_main_get_input_width');
jQuery('#jform_dynamic_get').closest('.input-append').addClass('jform_dynamic_get_input_width');
jQuery(function() {
    jQuery("code").click(function() {
        jQuery(this).selText().addClass("selected");
    });
});
jQuery('#adminForm').on('change', '#jform_libraries',function (e) {
	e.preventDefault();
	getSnippets();
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

jQuery('#adminForm').on('change', '#jform_dynamic_get',function (e) {
	e.preventDefault();
	// get type value
	var dynamicId = jQuery("#jform_dynamic_get option:selected").val();
	getDynamicValues(dynamicId);
});

jQuery(document).ready(function() {
	// get type value
	var dynamicId = jQuery("#jform_dynamic_get option:selected").val();
	getDynamicValues(dynamicId);
});

jQuery(document).ready(function() {
	// get type value
	getLayoutDetails(9999);
	getTemplateDetails(9999);
});
// some lang strings
var select_a_snippet = '<?php echo Text::_('COM_COMPONENTBUILDER_SELECT_A_SNIPPET'); ?>';
var create_a_snippet = '<?php echo Text::_('COM_COMPONENTBUILDER_CREATE_A_SNIPPET'); ?>';

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
jQuery(document).ready(function(){
	jQuery(document).on('subform-row-add', function(event, row){
		getIconImage(jQuery(row).find('.icomoon342'));
	});
});

function getIconImage(field) {
	// get the ID
	var id = jQuery(field).attr('id');
	// remove old one 
	jQuery('#image_'+id).remove();
	// get value
	var value = jQuery('#'+id).val();
	// build new one
	var span = '<span id="image_'+id+'" class="icon-'+value+'" style="position: absolute; top: 8px; right: -20px;"></span>';
	// add the icon
	jQuery('#'+id+'_chzn').append(span);
}
</script>
