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
jform_vvvvwcbvxh_required = false;
jform_vvvvwccvxi_required = false;
jform_vvvvwccvxj_required = false;
jform_vvvvwccvxk_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var target_vvvvwcb = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcb(target_vvvvwcb);

	var target_vvvvwcc = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcc(target_vvvvwcc);

	var target_vvvvwcd = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcd = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcd(target_vvvvwcd,type_vvvvwcd);

	var type_vvvvwce = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvwce = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwce(type_vvvvwce,target_vvvvwce);
});

// the vvvvwcb function
function vvvvwcb(target_vvvvwcb)
{
	// set the function logic
	if (target_vvvvwcb == 2)
	{
		jQuery('#jform_function_name').closest('.control-group').show();
		// add required attribute to function_name field
		if (jform_vvvvwcbvxh_required)
		{
			updateFieldRequired('function_name',0);
			jQuery('#jform_function_name').prop('required','required');
			jQuery('#jform_function_name').attr('aria-required',true);
			jQuery('#jform_function_name').addClass('required');
			jform_vvvvwcbvxh_required = false;
		}
		jQuery('.note_jcb_placeholder').closest('.control-group').show();
		jQuery('#jform_system_name').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_function_name').closest('.control-group').hide();
		// remove required attribute from function_name field
		if (!jform_vvvvwcbvxh_required)
		{
			updateFieldRequired('function_name',1);
			jQuery('#jform_function_name').removeAttr('required');
			jQuery('#jform_function_name').removeAttr('aria-required');
			jQuery('#jform_function_name').removeClass('required');
			jform_vvvvwcbvxh_required = true;
		}
		jQuery('.note_jcb_placeholder').closest('.control-group').hide();
		jQuery('#jform_system_name').closest('.control-group').hide();
	}
}

// the vvvvwcc function
function vvvvwcc(target_vvvvwcc)
{
	// set the function logic
	if (target_vvvvwcc == 1)
	{
		jQuery('#jform_component').closest('.control-group').show();
		// add required attribute to component field
		if (jform_vvvvwccvxi_required)
		{
			updateFieldRequired('component',0);
			jQuery('#jform_component').prop('required','required');
			jQuery('#jform_component').attr('aria-required',true);
			jQuery('#jform_component').addClass('required');
			jform_vvvvwccvxi_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwccvxj_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwccvxj_required = false;
		}
		jQuery('#jform_from_line').closest('.control-group').show();
		jQuery('#jform_hashtarget').closest('.control-group').show();
		jQuery('#jform_to_line').closest('.control-group').show();
		jQuery('#jform_type').closest('.control-group').show();
		// add required attribute to type field
		if (jform_vvvvwccvxk_required)
		{
			updateFieldRequired('type',0);
			jQuery('#jform_type').prop('required','required');
			jQuery('#jform_type').attr('aria-required',true);
			jQuery('#jform_type').addClass('required');
			jform_vvvvwccvxk_required = false;
		}
	}
	else
	{
		jQuery('#jform_component').closest('.control-group').hide();
		// remove required attribute from component field
		if (!jform_vvvvwccvxi_required)
		{
			updateFieldRequired('component',1);
			jQuery('#jform_component').removeAttr('required');
			jQuery('#jform_component').removeAttr('aria-required');
			jQuery('#jform_component').removeClass('required');
			jform_vvvvwccvxi_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwccvxj_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwccvxj_required = true;
		}
		jQuery('#jform_from_line').closest('.control-group').hide();
		jQuery('#jform_hashtarget').closest('.control-group').hide();
		jQuery('#jform_to_line').closest('.control-group').hide();
		jQuery('#jform_type').closest('.control-group').hide();
		// remove required attribute from type field
		if (!jform_vvvvwccvxk_required)
		{
			updateFieldRequired('type',1);
			jQuery('#jform_type').removeAttr('required');
			jQuery('#jform_type').removeAttr('aria-required');
			jQuery('#jform_type').removeClass('required');
			jform_vvvvwccvxk_required = true;
		}
	}
}

// the vvvvwcd function
function vvvvwcd(target_vvvvwcd,type_vvvvwcd)
{
	// set the function logic
	if (target_vvvvwcd == 1 && type_vvvvwcd == 1)
	{
		jQuery('#jform_hashendtarget').closest('.control-group').show();
		jQuery('#jform_to_line').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_hashendtarget').closest('.control-group').hide();
		jQuery('#jform_to_line').closest('.control-group').hide();
	}
}

// the vvvvwce function
function vvvvwce(type_vvvvwce,target_vvvvwce)
{
	// set the function logic
	if (type_vvvvwce == 1 && target_vvvvwce == 1)
	{
		jQuery('#jform_hashendtarget').closest('.control-group').show();
		jQuery('#jform_to_line').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_hashendtarget').closest('.control-group').hide();
		jQuery('#jform_to_line').closest('.control-group').hide();
	}
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
	var target = jQuery("#jform_target input[type='radio']:checked").val();
	if (target == 2) {
		jQuery('#usedin').show();
		var functioName = jQuery('#jform_function_name').val();
		// check if this function name is taken
		checkFunctionName(functioName);
	}
	var type = jQuery("#jform_comment_type input[type='radio']:checked").val();
	if (type == 2) {
		jQuery('#html-comment-info').show();
		jQuery('#phpjs-comment-info').hide();
	} else {
		jQuery('#html-comment-info').hide();
		jQuery('#phpjs-comment-info').show();
	}
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});
function setCustomCodePlaceholder() {
	var ide = jQuery('#jform_id').val();
	var functioName = jQuery('#jform_function_name').val();
	if (ide > 0 && functioName.length > 2) {
		jQuery('#jcb-placeholder').html('<code>[CUSTO'+'MCODE='+functioName+']</code>');
		jQuery('#jcb-placeholder-arg').html('<code>[CUSTO'+'MCODE='+functioName+'&#43;value1,value2]</code>');
	} else if (ide > 0){
		jQuery('#jcb-placeholder').html('<code>[not ready]</code>');
		jQuery('#jcb-placeholder-arg').html('<code>[not ready]</code>');
	} else if (functioName.length > 2) {
		jQuery('#jcb-placeholder').html('<code>[CUSTO'+'MCODE='+functioName+']</code>');
		jQuery('#jcb-placeholder-arg').html('<code>[CUSTO'+'MCODE='+functioName+'&#43;value1,value2]</code>');
	} else {
		jQuery('#jcb-placeholder').html('<code>[save to see]</code>');
		jQuery('#jcb-placeholder-arg').html('<code>[save to see]</code>');
	}
	// update the notes
	if (ide > 0) {
		jQuery('.placeholder-key-id').text(ide);
	}
}

function checkFunctionName(functioName) {
	if (functioName.length > 2) {
		var ide = jQuery('#jform_id').val();
		if (ide == 0) {
			ide = -1;
		}
		checkFunctionName_server(functioName, ide).done(function(result) {
			if(result.name && result.message){
				// show notice that functioName is okay
				jQuery.UIkit.notify({message: result.message, timeout: 5000, status: result.status, pos: 'top-right'});
				jQuery('#jform_function_name').val(result.name);
				// now start search for where the function is used
				usedin(result.name, ide);
			} else if(result.message){
				// show notice that functioName is not okay
				jQuery.UIkit.notify({message: result.message, timeout: 5000, status: result.status, pos: 'top-right'});
				jQuery('#jform_function_name').val('');
			} else {
				// set an error that message was not send
				jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_FUNCTION_NAME_ALREADY_TAKEN_PLEASE_TRY_AGAIN'), timeout: 5000, status: 'danger', pos: 'top-right'});
				jQuery('#jform_function_name').val('');
			}
			// set custom code placeholder
			setCustomCodePlaceholder();
		});
	} else {
		// set an error that message was not send
		jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_YOU_MUST_ADD_AN_UNIQUE_FUNCTION_NAME'), timeout: 5000, status: 'danger', pos: 'top-right'});
		jQuery('#jform_function_name').val('');
		// set custom code placeholder
		setCustomCodePlaceholder();
	}
}
// check Function name
function checkFunctionName_server(functioName, ide){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.checkFunctionName&raw=true&format=json";
	if(token.length > 0){
		var request = 'token='+token+'&functioName='+functioName+'&id='+ide;
	}
	return jQuery.ajax({
		type: 'POST',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}


// check where this Function is used
function usedin(functioName, ide) {
	var found = false;
	jQuery('#before-usedin').hide();
	jQuery('#note-usedin-not').hide();
	jQuery('#note-usedin-found').hide();
	jQuery('#loading-usedin').show();
	var targets = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u']; // if you update this, also update (below 20) & [customcode-codeUsedInHtmlNote]!
	var targetNumber = 20;
	var run = 0;
	var usedinChecker = setInterval(function(){ 
		var target = targets[run];
		usedin_server(functioName, ide, target).done(function(used) {
			if (used.in) {
				jQuery('#usedin-'+used.id).show();
				jQuery('#area-'+used.id).html(used.in);
				jQuery.UIkit.notify({message: used.in, timeout: 5000, status: 'success', pos: 'top-right'});
				found = true;
			} else {
				jQuery('#usedin-'+target).hide();
			}
			if (run == targetNumber) {
				jQuery('#loading-usedin').hide();
				if (found) {
					jQuery('#note-usedin-found').show();
				} else {
					jQuery('#note-usedin-not').show();
				}
			}
		});
		if (run == targetNumber) {
			clearInterval(usedinChecker);
		}
		run++;
	}, 800);
}
function usedin_server(functioName, ide, target){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.usedin&format=json";
	if(token.length > 0){
		var request = token+'=1&functioName='+functioName+'&id='+ide+'&target='+target+'&raw=true&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}


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
