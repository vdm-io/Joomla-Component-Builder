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

	@version		2.1.0
	@build			20th February, 2016
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

	<?php echo JLayoutHelper::render('site_view.details_above', $this); ?><div class="form-horizontal span9">

	<?php echo JHtml::_('bootstrap.startTabSet', 'site_viewTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'site_viewTab', 'details', JText::_('COM_COMPONENTBUILDER_SITE_VIEW_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('site_view.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('site_view.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('site_view.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'site_viewTab', 'custom_buttons', JText::_('COM_COMPONENTBUILDER_SITE_VIEW_CUSTOM_BUTTONS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('site_view.custom_buttons_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'site_viewTab', 'javascript_css', JText::_('COM_COMPONENTBUILDER_SITE_VIEW_JAVASCRIPT_CSS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('site_view.javascript_css_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'site_viewTab', 'php', JText::_('COM_COMPONENTBUILDER_SITE_VIEW_PHP', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('site_view.php_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('core.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.state') || $this->canDo->get('core.edit.created')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'site_viewTab', 'publishing', JText::_('COM_COMPONENTBUILDER_SITE_VIEW_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('site_view.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('site_view.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'site_viewTab', 'permissions', JText::_('COM_COMPONENTBUILDER_SITE_VIEW_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="site_view.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div><div class="span3">
	<?php echo JLayoutHelper::render('site_view.details_rightside', $this); ?>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('site_view.details_under', $this); ?>
</form>

<script type="text/javascript">

// #jform_add_php_view listeners for add_php_view_qYcIlrf function
jQuery('#jform_add_php_view').on('keyup',function()
{
	var add_php_view_qYcIlrf = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	qYcIlrf(add_php_view_qYcIlrf);

});
jQuery('#adminForm').on('change', '#jform_add_php_view',function (e)
{
	e.preventDefault();
	var add_php_view_qYcIlrf = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	qYcIlrf(add_php_view_qYcIlrf);

});

// #jform_add_php_jview_display listeners for add_php_jview_display_jiuJGGd function
jQuery('#jform_add_php_jview_display').on('keyup',function()
{
	var add_php_jview_display_jiuJGGd = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	jiuJGGd(add_php_jview_display_jiuJGGd);

});
jQuery('#adminForm').on('change', '#jform_add_php_jview_display',function (e)
{
	e.preventDefault();
	var add_php_jview_display_jiuJGGd = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	jiuJGGd(add_php_jview_display_jiuJGGd);

});

// #jform_add_php_jview listeners for add_php_jview_zijVOOJ function
jQuery('#jform_add_php_jview').on('keyup',function()
{
	var add_php_jview_zijVOOJ = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	zijVOOJ(add_php_jview_zijVOOJ);

});
jQuery('#adminForm').on('change', '#jform_add_php_jview',function (e)
{
	e.preventDefault();
	var add_php_jview_zijVOOJ = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	zijVOOJ(add_php_jview_zijVOOJ);

});

// #jform_add_php_document listeners for add_php_document_AAcKitW function
jQuery('#jform_add_php_document').on('keyup',function()
{
	var add_php_document_AAcKitW = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	AAcKitW(add_php_document_AAcKitW);

});
jQuery('#adminForm').on('change', '#jform_add_php_document',function (e)
{
	e.preventDefault();
	var add_php_document_AAcKitW = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	AAcKitW(add_php_document_AAcKitW);

});

// #jform_add_css_document listeners for add_css_document_qEQSrxD function
jQuery('#jform_add_css_document').on('keyup',function()
{
	var add_css_document_qEQSrxD = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	qEQSrxD(add_css_document_qEQSrxD);

});
jQuery('#adminForm').on('change', '#jform_add_css_document',function (e)
{
	e.preventDefault();
	var add_css_document_qEQSrxD = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	qEQSrxD(add_css_document_qEQSrxD);

});

// #jform_add_js_document listeners for add_js_document_hBGxDwg function
jQuery('#jform_add_js_document').on('keyup',function()
{
	var add_js_document_hBGxDwg = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	hBGxDwg(add_js_document_hBGxDwg);

});
jQuery('#adminForm').on('change', '#jform_add_js_document',function (e)
{
	e.preventDefault();
	var add_js_document_hBGxDwg = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	hBGxDwg(add_js_document_hBGxDwg);

});

// #jform_add_css listeners for add_css_kaIrLRI function
jQuery('#jform_add_css').on('keyup',function()
{
	var add_css_kaIrLRI = jQuery("#jform_add_css input[type='radio']:checked").val();
	kaIrLRI(add_css_kaIrLRI);

});
jQuery('#adminForm').on('change', '#jform_add_css',function (e)
{
	e.preventDefault();
	var add_css_kaIrLRI = jQuery("#jform_add_css input[type='radio']:checked").val();
	kaIrLRI(add_css_kaIrLRI);

});

// #jform_add_php_ajax listeners for add_php_ajax_mDLenfJ function
jQuery('#jform_add_php_ajax').on('keyup',function()
{
	var add_php_ajax_mDLenfJ = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	mDLenfJ(add_php_ajax_mDLenfJ);

});
jQuery('#adminForm').on('change', '#jform_add_php_ajax',function (e)
{
	e.preventDefault();
	var add_php_ajax_mDLenfJ = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	mDLenfJ(add_php_ajax_mDLenfJ);

});

// #jform_add_custom_button listeners for add_custom_button_pJsQgWh function
jQuery('#jform_add_custom_button').on('keyup',function()
{
	var add_custom_button_pJsQgWh = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	pJsQgWh(add_custom_button_pJsQgWh);

});
jQuery('#adminForm').on('change', '#jform_add_custom_button',function (e)
{
	e.preventDefault();
	var add_custom_button_pJsQgWh = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	pJsQgWh(add_custom_button_pJsQgWh);

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
<?php $fieldNrs = range(1,10,1); ?>
<?php foreach($fieldNrs as $nr): ?>jQuery('body').on('change', 'select[name="icomoon-<?php echo $nr; ?>"]',function (e) {
	// update the icon if changed
	var val_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"] option:selected').val();
	var key_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"]').attr('id').split('-');
	var target_<?php echo $nr; ?> = key_<?php echo $nr; ?>[0]+'_'+key_<?php echo $nr; ?>[1]+'_chzn';
	var div_<?php echo $nr; ?> = jQuery('#'+target_<?php echo $nr; ?>);
	// build new span
	var span = '<span id="icon_'+target_<?php echo $nr; ?>+'" class="icon-'+val_<?php echo $nr; ?>+'"></span>';
	// remove old one 
	jQuery('#icon_'+target_<?php echo $nr; ?>).remove();
	// add the new icon
	div_<?php echo $nr; ?>.closest("td").append(span);
});

jQuery(document).ready(function() {
	// get type value
	var val_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"] option:selected').val();
	var key_<?php echo $nr; ?> = jQuery('select[name="icomoon-<?php echo $nr; ?>"]').attr('id').split('-');
	var target_<?php echo $nr; ?> = key_<?php echo $nr; ?>[0]+'_'+key_<?php echo $nr; ?>[1]+'_chzn';
	var div_<?php echo $nr; ?> = jQuery('#'+target_<?php echo $nr; ?>);
	// build new span
	var span = '<span id="icon_'+target_<?php echo $nr; ?>+'" class="icon-'+val_<?php echo $nr; ?>+'"></span>';
	// remove old one 
	jQuery('#icon_'+target_<?php echo $nr; ?>).remove();
	// add the new icon
	div_<?php echo $nr; ?>.closest("td").append(span);
});
<?php endforeach; ?>
</script>
