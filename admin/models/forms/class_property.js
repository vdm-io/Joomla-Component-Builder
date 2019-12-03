/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwcfvxl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var extension_type_vvvvwcf = jQuery("#jform_extension_type").val();
	vvvvwcf(extension_type_vvvvwcf);
});

// the vvvvwcf function
function vvvvwcf(extension_type_vvvvwcf)
{
	if (isSet(extension_type_vvvvwcf) && extension_type_vvvvwcf.constructor !== Array)
	{
		var temp_vvvvwcf = extension_type_vvvvwcf;
		var extension_type_vvvvwcf = [];
		extension_type_vvvvwcf.push(temp_vvvvwcf);
	}
	else if (!isSet(extension_type_vvvvwcf))
	{
		var extension_type_vvvvwcf = [];
	}
	var extension_type = extension_type_vvvvwcf.some(extension_type_vvvvwcf_SomeFunc);


	// set this function logic
	if (extension_type)
	{
		jQuery('#jform_joomla_plugin_group').closest('.control-group').show();
		// add required attribute to joomla_plugin_group field
		if (jform_vvvvwcfvxl_required)
		{
			updateFieldRequired('joomla_plugin_group',0);
			jQuery('#jform_joomla_plugin_group').prop('required','required');
			jQuery('#jform_joomla_plugin_group').attr('aria-required',true);
			jQuery('#jform_joomla_plugin_group').addClass('required');
			jform_vvvvwcfvxl_required = false;
		}
	}
	else
	{
		jQuery('#jform_joomla_plugin_group').closest('.control-group').hide();
		// remove required attribute from joomla_plugin_group field
		if (!jform_vvvvwcfvxl_required)
		{
			updateFieldRequired('joomla_plugin_group',1);
			jQuery('#jform_joomla_plugin_group').removeAttr('required');
			jQuery('#jform_joomla_plugin_group').removeAttr('aria-required');
			jQuery('#jform_joomla_plugin_group').removeClass('required');
			jform_vvvvwcfvxl_required = true;
		}
	}
}

// the vvvvwcf Some function
function extension_type_vvvvwcf_SomeFunc(extension_type_vvvvwcf)
{
	// set the function logic
	if (extension_type_vvvvwcf == 'plugins' || extension_type_vvvvwcf == 'plugin')
	{
		return true;
	}
	return false;
}

// update required fields
function updateFieldRequired(name,status)
{
	var not_required = jQuery('#jform_not_required').val();

	if(status == 1)
	{
		if (isSet(not_required) && not_required != 0)
		{
			not_required = not_required+','+name;
		}
		else
		{
			not_required = ','+name;
		}
	}
	else
	{
		if (isSet(not_required) && not_required != 0)
		{
			not_required = not_required.replace(','+name,'');
		}
	}

	jQuery('#jform_not_required').val(not_required);
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
