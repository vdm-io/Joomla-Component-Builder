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

	@version		2.0.8
	@build			31st January, 2016
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
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'fieldTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldTab', 'details', JText::_('COM_COMPONENTBUILDER_FIELD_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('field.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('field.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('field.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldTab', 'scripts', JText::_('COM_COMPONENTBUILDER_FIELD_SCRIPTS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('field.scripts_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('field.scripts_right', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldTab', 'publishing', JText::_('COM_COMPONENTBUILDER_FIELD_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('field.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('field.publlshing', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'fieldTab', 'permissions', JText::_('COM_COMPONENTBUILDER_FIELD_PERMISSION', true)); ?>
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
		<input type="hidden" name="task" value="field.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('field.details_under', $this); ?>
</form>

<script type="text/javascript">

// #jform_datalenght listeners for datalenght_dKiaBQA function
jQuery('#jform_datalenght').on('keyup',function()
{
	var datalenght_dKiaBQA = jQuery("#jform_datalenght").val();
	dKiaBQA(datalenght_dKiaBQA);

});
jQuery('#adminForm').on('change', '#jform_datalenght',function (e)
{
	e.preventDefault();
	var datalenght_dKiaBQA = jQuery("#jform_datalenght").val();
	dKiaBQA(datalenght_dKiaBQA);

});

// #jform_datadefault listeners for datadefault_yiGBlYu function
jQuery('#jform_datadefault').on('keyup',function()
{
	var datadefault_yiGBlYu = jQuery("#jform_datadefault").val();
	yiGBlYu(datadefault_yiGBlYu);

});
jQuery('#adminForm').on('change', '#jform_datadefault',function (e)
{
	e.preventDefault();
	var datadefault_yiGBlYu = jQuery("#jform_datadefault").val();
	yiGBlYu(datadefault_yiGBlYu);

});

// #jform_datatype listeners for datatype_LtJifKz function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_LtJifKz = jQuery("#jform_datatype").val();
	LtJifKz(datatype_LtJifKz);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_LtJifKz = jQuery("#jform_datatype").val();
	LtJifKz(datatype_LtJifKz);

});

// #jform_store listeners for store_eKdrKLg function
jQuery('#jform_store').on('keyup',function()
{
	var store_eKdrKLg = jQuery("#jform_store").val();
	var datatype_eKdrKLg = jQuery("#jform_datatype").val();
	eKdrKLg(store_eKdrKLg,datatype_eKdrKLg);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_eKdrKLg = jQuery("#jform_store").val();
	var datatype_eKdrKLg = jQuery("#jform_datatype").val();
	eKdrKLg(store_eKdrKLg,datatype_eKdrKLg);

});

// #jform_datatype listeners for datatype_eKdrKLg function
jQuery('#jform_datatype').on('keyup',function()
{
	var store_eKdrKLg = jQuery("#jform_store").val();
	var datatype_eKdrKLg = jQuery("#jform_datatype").val();
	eKdrKLg(store_eKdrKLg,datatype_eKdrKLg);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var store_eKdrKLg = jQuery("#jform_store").val();
	var datatype_eKdrKLg = jQuery("#jform_datatype").val();
	eKdrKLg(store_eKdrKLg,datatype_eKdrKLg);

});

// #jform_add_css_view listeners for add_css_view_WJQqrdJ function
jQuery('#jform_add_css_view').on('keyup',function()
{
	var add_css_view_WJQqrdJ = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	WJQqrdJ(add_css_view_WJQqrdJ);

});
jQuery('#adminForm').on('change', '#jform_add_css_view',function (e)
{
	e.preventDefault();
	var add_css_view_WJQqrdJ = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	WJQqrdJ(add_css_view_WJQqrdJ);

});

// #jform_add_css_views listeners for add_css_views_pDhKzQd function
jQuery('#jform_add_css_views').on('keyup',function()
{
	var add_css_views_pDhKzQd = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	pDhKzQd(add_css_views_pDhKzQd);

});
jQuery('#adminForm').on('change', '#jform_add_css_views',function (e)
{
	e.preventDefault();
	var add_css_views_pDhKzQd = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	pDhKzQd(add_css_views_pDhKzQd);

});

// #jform_add_javascript_view_footer listeners for add_javascript_view_footer_WtScFWq function
jQuery('#jform_add_javascript_view_footer').on('keyup',function()
{
	var add_javascript_view_footer_WtScFWq = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	WtScFWq(add_javascript_view_footer_WtScFWq);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_view_footer',function (e)
{
	e.preventDefault();
	var add_javascript_view_footer_WtScFWq = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	WtScFWq(add_javascript_view_footer_WtScFWq);

});

// #jform_add_javascript_views_footer listeners for add_javascript_views_footer_OnpzACK function
jQuery('#jform_add_javascript_views_footer').on('keyup',function()
{
	var add_javascript_views_footer_OnpzACK = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	OnpzACK(add_javascript_views_footer_OnpzACK);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_views_footer',function (e)
{
	e.preventDefault();
	var add_javascript_views_footer_OnpzACK = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	OnpzACK(add_javascript_views_footer_OnpzACK);

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

jQuery('#details').on('change', '#jform_type',function (e) {
	e.preventDefault();
	// get type value
	var fieldId = jQuery("#jform_type option:selected").val();
	getFieldOptions(fieldId,true);
});

jQuery(document).ready(function() {
	// get type value
	var fieldId = jQuery("#jform_type option:selected").val();
	if(jQuery('#jform_xml').length == 0) {
		getFieldOptions(fieldId,true);
	} else {
		getFieldOptions(fieldId,false);
	}
});
</script>
