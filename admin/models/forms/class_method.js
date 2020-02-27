/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2020 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwcgvxk_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var extension_type_vvvvwcg = jQuery("#jform_extension_type").val();
	vvvvwcg(extension_type_vvvvwcg);
});

// the vvvvwcg function
function vvvvwcg(extension_type_vvvvwcg)
{
	if (isSet(extension_type_vvvvwcg) && extension_type_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = extension_type_vvvvwcg;
		var extension_type_vvvvwcg = [];
		extension_type_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(extension_type_vvvvwcg))
	{
		var extension_type_vvvvwcg = [];
	}
	var extension_type = extension_type_vvvvwcg.some(extension_type_vvvvwcg_SomeFunc);


	// set this function logic
	if (extension_type)
	{
		jQuery('#jform_joomla_plugin_group').closest('.control-group').show();
		// add required attribute to joomla_plugin_group field
		if (jform_vvvvwcgvxk_required)
		{
			updateFieldRequired('joomla_plugin_group',0);
			jQuery('#jform_joomla_plugin_group').prop('required','required');
			jQuery('#jform_joomla_plugin_group').attr('aria-required',true);
			jQuery('#jform_joomla_plugin_group').addClass('required');
			jform_vvvvwcgvxk_required = false;
		}
	}
	else
	{
		jQuery('#jform_joomla_plugin_group').closest('.control-group').hide();
		// remove required attribute from joomla_plugin_group field
		if (!jform_vvvvwcgvxk_required)
		{
			updateFieldRequired('joomla_plugin_group',1);
			jQuery('#jform_joomla_plugin_group').removeAttr('required');
			jQuery('#jform_joomla_plugin_group').removeAttr('aria-required');
			jQuery('#jform_joomla_plugin_group').removeClass('required');
			jform_vvvvwcgvxk_required = true;
		}
	}
}

// the vvvvwcg Some function
function extension_type_vvvvwcg_SomeFunc(extension_type_vvvvwcg)
{
	// set the function logic
	if (extension_type_vvvvwcg == 'plugins' || extension_type_vvvvwcg == 'plugin')
	{
		return true;
	}
	return false;
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (jQuery('#jform_not_required').length > 0) {
		var not_required = jQuery('#jform_not_required').val().split(",");

		if(status == 1)
		{
			not_required.push(name);
		}
		else
		{
			not_required = removeFieldFromNotRequired(not_required, name);
		}

		jQuery('#jform_not_required').val(fixNotRequiredArray(not_required).toString());
	}
}

// remove field from not_required
function removeFieldFromNotRequired(array, what) {
	return array.filter(function(element){
		return element !== what;
	});
}

// fix not required array
function fixNotRequiredArray(array) {
	var seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function(item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

// remove empty from not_required array
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		// remove ( 一_一) as well - lol
		return (el.length > 0 && '一_一' !== el);
	});
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
}


jQuery(document).ready(function()
{
	// load the used in div
	// jQuery('#usedin').show();
	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 300);
});

function getEditCustomCodeButtons_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id+'&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getEditCustomCodeButtons(){
	// get the id
	id = jQuery("#jform_id").val();
	getEditCustomCodeButtons_server(id).done(function(result) {
		if(isObject(result)){
			jQuery.each(result, function( field, buttons ) {
				jQuery('<div class="control-group"><div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
				jQuery.each(buttons, function( name, button ) {
					jQuery(".control-customcode-buttons-"+field).append(button);
				});
			});
		}
	})
}

// check object is not empty
function isObject(obj) {
	for(var prop in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, prop)) {
			return true;
		}
	}
	return false;
} 
