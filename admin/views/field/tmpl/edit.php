<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$componentParams = JComponentHelper::getParams('com_componentbuilder');
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

	<?php echo JLayoutHelper::render('field.set_properties_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'fieldTab', array('active' => 'set_properties')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldTab', 'set_properties', JText::_('COM_COMPONENTBUILDER_FIELD_SET_PROPERTIES', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('field.set_properties_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'fieldTab', 'data_base', JText::_('COM_COMPONENTBUILDER_FIELD_DATA_BASE', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('field.data_base_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('field.data_base_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('field.data_base_fullwidth', $this); ?>
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

	<?php echo JHtml::_('bootstrap.addTab', 'fieldTab', 'type_info', JText::_('COM_COMPONENTBUILDER_FIELD_TYPE_INFO', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('field.type_info_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if ($this->canDo->get('field.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('field.edit.state') || $this->canDo->get('core.edit.created')) : ?>
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
	<?php endif; ?>

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
</div>

<div class="clearfix"></div>
<?php echo JLayoutHelper::render('field.set_properties_under', $this); ?>
</form>
</div>

<script type="text/javascript">

// #jform_datalenght listeners for datalenght_vvvvwap function
jQuery('#jform_datalenght').on('keyup',function()
{
	var datalenght_vvvvwap = jQuery("#jform_datalenght").val();
	vvvvwap(datalenght_vvvvwap);

});
jQuery('#adminForm').on('change', '#jform_datalenght',function (e)
{
	e.preventDefault();
	var datalenght_vvvvwap = jQuery("#jform_datalenght").val();
	vvvvwap(datalenght_vvvvwap);

});

// #jform_datadefault listeners for datadefault_vvvvwaq function
jQuery('#jform_datadefault').on('keyup',function()
{
	var datadefault_vvvvwaq = jQuery("#jform_datadefault").val();
	vvvvwaq(datadefault_vvvvwaq);

});
jQuery('#adminForm').on('change', '#jform_datadefault',function (e)
{
	e.preventDefault();
	var datadefault_vvvvwaq = jQuery("#jform_datadefault").val();
	vvvvwaq(datadefault_vvvvwaq);

});

// #jform_datatype listeners for datatype_vvvvwar function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwar = jQuery("#jform_datatype").val();
	vvvvwar(datatype_vvvvwar);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwar = jQuery("#jform_datatype").val();
	vvvvwar(datatype_vvvvwar);

});

// #jform_datatype listeners for datatype_vvvvwas function
jQuery('#jform_datatype').on('keyup',function()
{
	var datatype_vvvvwas = jQuery("#jform_datatype").val();
	vvvvwas(datatype_vvvvwas);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var datatype_vvvvwas = jQuery("#jform_datatype").val();
	vvvvwas(datatype_vvvvwas);

});

// #jform_store listeners for store_vvvvwat function
jQuery('#jform_store').on('keyup',function()
{
	var store_vvvvwat = jQuery("#jform_store").val();
	var datatype_vvvvwat = jQuery("#jform_datatype").val();
	vvvvwat(store_vvvvwat,datatype_vvvvwat);

});
jQuery('#adminForm').on('change', '#jform_store',function (e)
{
	e.preventDefault();
	var store_vvvvwat = jQuery("#jform_store").val();
	var datatype_vvvvwat = jQuery("#jform_datatype").val();
	vvvvwat(store_vvvvwat,datatype_vvvvwat);

});

// #jform_datatype listeners for datatype_vvvvwat function
jQuery('#jform_datatype').on('keyup',function()
{
	var store_vvvvwat = jQuery("#jform_store").val();
	var datatype_vvvvwat = jQuery("#jform_datatype").val();
	vvvvwat(store_vvvvwat,datatype_vvvvwat);

});
jQuery('#adminForm').on('change', '#jform_datatype',function (e)
{
	e.preventDefault();
	var store_vvvvwat = jQuery("#jform_store").val();
	var datatype_vvvvwat = jQuery("#jform_datatype").val();
	vvvvwat(store_vvvvwat,datatype_vvvvwat);

});

// #jform_add_css_view listeners for add_css_view_vvvvwav function
jQuery('#jform_add_css_view').on('keyup',function()
{
	var add_css_view_vvvvwav = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwav(add_css_view_vvvvwav);

});
jQuery('#adminForm').on('change', '#jform_add_css_view',function (e)
{
	e.preventDefault();
	var add_css_view_vvvvwav = jQuery("#jform_add_css_view input[type='radio']:checked").val();
	vvvvwav(add_css_view_vvvvwav);

});

// #jform_add_css_views listeners for add_css_views_vvvvwaw function
jQuery('#jform_add_css_views').on('keyup',function()
{
	var add_css_views_vvvvwaw = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwaw(add_css_views_vvvvwaw);

});
jQuery('#adminForm').on('change', '#jform_add_css_views',function (e)
{
	e.preventDefault();
	var add_css_views_vvvvwaw = jQuery("#jform_add_css_views input[type='radio']:checked").val();
	vvvvwaw(add_css_views_vvvvwaw);

});

// #jform_add_javascript_view_footer listeners for add_javascript_view_footer_vvvvwax function
jQuery('#jform_add_javascript_view_footer').on('keyup',function()
{
	var add_javascript_view_footer_vvvvwax = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwax(add_javascript_view_footer_vvvvwax);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_view_footer',function (e)
{
	e.preventDefault();
	var add_javascript_view_footer_vvvvwax = jQuery("#jform_add_javascript_view_footer input[type='radio']:checked").val();
	vvvvwax(add_javascript_view_footer_vvvvwax);

});

// #jform_add_javascript_views_footer listeners for add_javascript_views_footer_vvvvway function
jQuery('#jform_add_javascript_views_footer').on('keyup',function()
{
	var add_javascript_views_footer_vvvvway = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvway(add_javascript_views_footer_vvvvway);

});
jQuery('#adminForm').on('change', '#jform_add_javascript_views_footer',function (e)
{
	e.preventDefault();
	var add_javascript_views_footer_vvvvway = jQuery("#jform_add_javascript_views_footer input[type='radio']:checked").val();
	vvvvway(add_javascript_views_footer_vvvvway);

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
	getFieldOptions(fieldId);
	// get the field type text
	var fieldText = jQuery("#jform_fieldtype option:selected").text().toLowerCase();
	// now check if database input is needed
	dbChecker(fieldText);
});


<?php
	$app = JFactory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isSite())
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
</script>
