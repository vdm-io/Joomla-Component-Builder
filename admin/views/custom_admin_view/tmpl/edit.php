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

	<?php echo JLayoutHelper::render('custom_admin_view.details_above', $this); ?>
<div class="form-horizontal">
	<div class="span9">

	<?php echo JHtml::_('bootstrap.startTabSet', 'custom_admin_viewTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'custom_admin_viewTab', 'details', JText::_('COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('custom_admin_view.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('custom_admin_view.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('custom_admin_view.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'custom_admin_viewTab', 'custom_buttons', JText::_('COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_CUSTOM_BUTTONS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('custom_admin_view.custom_buttons_left', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('custom_admin_view.custom_buttons_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'custom_admin_viewTab', 'javascript_css', JText::_('COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_JAVASCRIPT_CSS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('custom_admin_view.javascript_css_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'custom_admin_viewTab', 'php', JText::_('COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_PHP', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('custom_admin_view.php_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'custom_admin_viewTab', 'linked_components', JText::_('COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_LINKED_COMPONENTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('custom_admin_view.linked_components_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'custom_admin_viewTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'custom_admin_viewTab', 'publishing', JText::_('COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('custom_admin_view.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('custom_admin_view.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'custom_admin_viewTab', 'permissions', JText::_('COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="custom_admin_view.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	</div>
</div><div class="span3">
	<?php echo JLayoutHelper::render('custom_admin_view.details_rightside', $this); ?>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('custom_admin_view.details_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_add_php_view listeners for add_php_view_vvvvwad function
jQuery('#jform_add_php_view').on('keyup',function()
{
	var add_php_view_vvvvwad = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvwad(add_php_view_vvvvwad);

});
jQuery('#adminForm').on('change', '#jform_add_php_view',function (e)
{
	e.preventDefault();
	var add_php_view_vvvvwad = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvwad(add_php_view_vvvvwad);

});

// #jform_add_php_jview_display listeners for add_php_jview_display_vvvvwae function
jQuery('#jform_add_php_jview_display').on('keyup',function()
{
	var add_php_jview_display_vvvvwae = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvwae(add_php_jview_display_vvvvwae);

});
jQuery('#adminForm').on('change', '#jform_add_php_jview_display',function (e)
{
	e.preventDefault();
	var add_php_jview_display_vvvvwae = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvwae(add_php_jview_display_vvvvwae);

});

// #jform_add_php_jview listeners for add_php_jview_vvvvwaf function
jQuery('#jform_add_php_jview').on('keyup',function()
{
	var add_php_jview_vvvvwaf = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvwaf(add_php_jview_vvvvwaf);

});
jQuery('#adminForm').on('change', '#jform_add_php_jview',function (e)
{
	e.preventDefault();
	var add_php_jview_vvvvwaf = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvwaf(add_php_jview_vvvvwaf);

});

// #jform_add_php_document listeners for add_php_document_vvvvwag function
jQuery('#jform_add_php_document').on('keyup',function()
{
	var add_php_document_vvvvwag = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvwag(add_php_document_vvvvwag);

});
jQuery('#adminForm').on('change', '#jform_add_php_document',function (e)
{
	e.preventDefault();
	var add_php_document_vvvvwag = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvwag(add_php_document_vvvvwag);

});

// #jform_add_css_document listeners for add_css_document_vvvvwah function
jQuery('#jform_add_css_document').on('keyup',function()
{
	var add_css_document_vvvvwah = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvwah(add_css_document_vvvvwah);

});
jQuery('#adminForm').on('change', '#jform_add_css_document',function (e)
{
	e.preventDefault();
	var add_css_document_vvvvwah = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvwah(add_css_document_vvvvwah);

});

// #jform_add_javascript_file listeners for add_javascript_file_vvvvwai function
jQuery('#jform_add_javascript_file').on('keyup',function()
{
	var add_javascript_file_vvvvwai = jQuery("#jform_add_javascript_file input[type='radio']:checked").val();
	vvvvwai(add_javascript_file_vvvvwai);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_file',function (e)
{
	e.preventDefault();
	var add_javascript_file_vvvvwai = jQuery("#jform_add_javascript_file input[type='radio']:checked").val();
	vvvvwai(add_javascript_file_vvvvwai);

});

// #jform_add_js_document listeners for add_js_document_vvvvwaj function
jQuery('#jform_add_js_document').on('keyup',function()
{
	var add_js_document_vvvvwaj = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvwaj(add_js_document_vvvvwaj);

});
jQuery('#adminForm').on('change', '#jform_add_js_document',function (e)
{
	e.preventDefault();
	var add_js_document_vvvvwaj = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvwaj(add_js_document_vvvvwaj);

});

// #jform_add_custom_button listeners for add_custom_button_vvvvwak function
jQuery('#jform_add_custom_button').on('keyup',function()
{
	var add_custom_button_vvvvwak = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvwak(add_custom_button_vvvvwak);

});
jQuery('#adminForm').on('change', '#jform_add_custom_button',function (e)
{
	e.preventDefault();
	var add_custom_button_vvvvwak = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvwak(add_custom_button_vvvvwak);

});

// #jform_add_css listeners for add_css_vvvvwal function
jQuery('#jform_add_css').on('keyup',function()
{
	var add_css_vvvvwal = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvwal(add_css_vvvvwal);

});
jQuery('#adminForm').on('change', '#jform_add_css',function (e)
{
	e.preventDefault();
	var add_css_vvvvwal = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvwal(add_css_vvvvwal);

});

// #jform_add_php_ajax listeners for add_php_ajax_vvvvwam function
jQuery('#jform_add_php_ajax').on('keyup',function()
{
	var add_php_ajax_vvvvwam = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvwam(add_php_ajax_vvvvwam);

});
jQuery('#adminForm').on('change', '#jform_add_php_ajax',function (e)
{
	e.preventDefault();
	var add_php_ajax_vvvvwam = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvwam(add_php_ajax_vvvvwam);

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
var select_a_snippet = '<?php echo JText::_('COM_COMPONENTBUILDER_SELECT_A_SNIPPET'); ?>';
var create_a_snippet = '<?php echo JText::_('COM_COMPONENTBUILDER_CREATE_A_SNIPPET'); ?>';

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
