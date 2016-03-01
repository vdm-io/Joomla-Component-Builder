<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.1.1
	@build			1st March, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		edit.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$componentParams = JComponentHelper::getParams('com_componentbuilder');
?>

<form action="<?php echo JRoute::_('index.php?option=com_componentbuilder&layout=edit&id='.(int) $this->item->id.$this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('custom_admin_view.details_above', $this); ?><div class="form-horizontal span9">

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

	<?php echo JHtml::_('bootstrap.addTab', 'custom_admin_viewTab', 'custom_script', JText::_('COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW_CUSTOM_SCRIPT', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('custom_admin_view.custom_script_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

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
</div><div class="span3">
	<?php echo JLayoutHelper::render('custom_admin_view.details_rightside', $this); ?>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('custom_admin_view.details_under', $this); ?>
</form>

<script type="text/javascript">

// #jform_add_php_view listeners for add_php_view_vvvvvxc function
jQuery('#jform_add_php_view').on('keyup',function()
{
	var add_php_view_vvvvvxc = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvxc(add_php_view_vvvvvxc);

});
jQuery('#adminForm').on('change', '#jform_add_php_view',function (e)
{
	e.preventDefault();
	var add_php_view_vvvvvxc = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvxc(add_php_view_vvvvvxc);

});

// #jform_add_php_jview_display listeners for add_php_jview_display_vvvvvxd function
jQuery('#jform_add_php_jview_display').on('keyup',function()
{
	var add_php_jview_display_vvvvvxd = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvvxd(add_php_jview_display_vvvvvxd);

});
jQuery('#adminForm').on('change', '#jform_add_php_jview_display',function (e)
{
	e.preventDefault();
	var add_php_jview_display_vvvvvxd = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvvxd(add_php_jview_display_vvvvvxd);

});

// #jform_add_php_jview listeners for add_php_jview_vvvvvxe function
jQuery('#jform_add_php_jview').on('keyup',function()
{
	var add_php_jview_vvvvvxe = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvvxe(add_php_jview_vvvvvxe);

});
jQuery('#adminForm').on('change', '#jform_add_php_jview',function (e)
{
	e.preventDefault();
	var add_php_jview_vvvvvxe = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvvxe(add_php_jview_vvvvvxe);

});

// #jform_add_php_document listeners for add_php_document_vvvvvxf function
jQuery('#jform_add_php_document').on('keyup',function()
{
	var add_php_document_vvvvvxf = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvxf(add_php_document_vvvvvxf);

});
jQuery('#adminForm').on('change', '#jform_add_php_document',function (e)
{
	e.preventDefault();
	var add_php_document_vvvvvxf = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvxf(add_php_document_vvvvvxf);

});

// #jform_add_css_document listeners for add_css_document_vvvvvxg function
jQuery('#jform_add_css_document').on('keyup',function()
{
	var add_css_document_vvvvvxg = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvvxg(add_css_document_vvvvvxg);

});
jQuery('#adminForm').on('change', '#jform_add_css_document',function (e)
{
	e.preventDefault();
	var add_css_document_vvvvvxg = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvvxg(add_css_document_vvvvvxg);

});

// #jform_add_js_document listeners for add_js_document_vvvvvxh function
jQuery('#jform_add_js_document').on('keyup',function()
{
	var add_js_document_vvvvvxh = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvvxh(add_js_document_vvvvvxh);

});
jQuery('#adminForm').on('change', '#jform_add_js_document',function (e)
{
	e.preventDefault();
	var add_js_document_vvvvvxh = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvvxh(add_js_document_vvvvvxh);

});

// #jform_add_custom_button listeners for add_custom_button_vvvvvxi function
jQuery('#jform_add_custom_button').on('keyup',function()
{
	var add_custom_button_vvvvvxi = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvxi(add_custom_button_vvvvvxi);

});
jQuery('#adminForm').on('change', '#jform_add_custom_button',function (e)
{
	e.preventDefault();
	var add_custom_button_vvvvvxi = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvxi(add_custom_button_vvvvvxi);

});

// #jform_add_css listeners for add_css_vvvvvxj function
jQuery('#jform_add_css').on('keyup',function()
{
	var add_css_vvvvvxj = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvxj(add_css_vvvvvxj);

});
jQuery('#adminForm').on('change', '#jform_add_css',function (e)
{
	e.preventDefault();
	var add_css_vvvvvxj = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvxj(add_css_vvvvvxj);

});


jQuery(function() {
    jQuery("code").click(function() {
        jQuery(this).selText().addClass("selected");
    });
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
	getDynamicFormDetails(9999);
});
</script>
