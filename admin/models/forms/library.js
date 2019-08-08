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
jform_vvvvwbmvxj_required = false;
jform_vvvvwbsvxk_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var how_vvvvwbl = jQuery("#jform_how").val();
	vvvvwbl(how_vvvvwbl);

	var how_vvvvwbm = jQuery("#jform_how").val();
	vvvvwbm(how_vvvvwbm);

	var how_vvvvwbn = jQuery("#jform_how").val();
	vvvvwbn(how_vvvvwbn);

	var how_vvvvwbo = jQuery("#jform_how").val();
	vvvvwbo(how_vvvvwbo);

	var how_vvvvwbp = jQuery("#jform_how").val();
	vvvvwbp(how_vvvvwbp);

	var how_vvvvwbq = jQuery("#jform_how").val();
	vvvvwbq(how_vvvvwbq);

	var how_vvvvwbr = jQuery("#jform_how").val();
	vvvvwbr(how_vvvvwbr);

	var type_vvvvwbs = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbs(type_vvvvwbs);
});

// the vvvvwbl function
function vvvvwbl(how_vvvvwbl)
{
	if (isSet(how_vvvvwbl) && how_vvvvwbl.constructor !== Array)
	{
		var temp_vvvvwbl = how_vvvvwbl;
		var how_vvvvwbl = [];
		how_vvvvwbl.push(temp_vvvvwbl);
	}
	else if (!isSet(how_vvvvwbl))
	{
		var how_vvvvwbl = [];
	}
	var how = how_vvvvwbl.some(how_vvvvwbl_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('#jform_addconditions-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addconditions-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbl Some function
function how_vvvvwbl_SomeFunc(how_vvvvwbl)
{
	// set the function logic
	if (how_vvvvwbl == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbm function
function vvvvwbm(how_vvvvwbm)
{
	if (isSet(how_vvvvwbm) && how_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = how_vvvvwbm;
		var how_vvvvwbm = [];
		how_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(how_vvvvwbm))
	{
		var how_vvvvwbm = [];
	}
	var how = how_vvvvwbm.some(how_vvvvwbm_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('#jform_php_setdocument').closest('.control-group').show();
		// add required attribute to php_setdocument field
		if (jform_vvvvwbmvxj_required)
		{
			updateFieldRequired('php_setdocument',0);
			jQuery('#jform_php_setdocument').prop('required','required');
			jQuery('#jform_php_setdocument').attr('aria-required',true);
			jQuery('#jform_php_setdocument').addClass('required');
			jform_vvvvwbmvxj_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_setdocument').closest('.control-group').hide();
		// remove required attribute from php_setdocument field
		if (!jform_vvvvwbmvxj_required)
		{
			updateFieldRequired('php_setdocument',1);
			jQuery('#jform_php_setdocument').removeAttr('required');
			jQuery('#jform_php_setdocument').removeAttr('aria-required');
			jQuery('#jform_php_setdocument').removeClass('required');
			jform_vvvvwbmvxj_required = true;
		}
	}
}

// the vvvvwbm Some function
function how_vvvvwbm_SomeFunc(how_vvvvwbm)
{
	// set the function logic
	if (how_vvvvwbm == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(how_vvvvwbn)
{
	if (isSet(how_vvvvwbn) && how_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = how_vvvvwbn;
		var how_vvvvwbn = [];
		how_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(how_vvvvwbn))
	{
		var how_vvvvwbn = [];
	}
	var how = how_vvvvwbn.some(how_vvvvwbn_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('.note_display_library_config').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_display_library_config').closest('.control-group').hide();
	}
}

// the vvvvwbn Some function
function how_vvvvwbn_SomeFunc(how_vvvvwbn)
{
	// set the function logic
	if (how_vvvvwbn == 2 || how_vvvvwbn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbo function
function vvvvwbo(how_vvvvwbo)
{
	if (isSet(how_vvvvwbo) && how_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = how_vvvvwbo;
		var how_vvvvwbo = [];
		how_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(how_vvvvwbo))
	{
		var how_vvvvwbo = [];
	}
	var how = how_vvvvwbo.some(how_vvvvwbo_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('.note_display_library_files_folders_urls').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_display_library_files_folders_urls').closest('.control-group').hide();
	}
}

// the vvvvwbo Some function
function how_vvvvwbo_SomeFunc(how_vvvvwbo)
{
	// set the function logic
	if (how_vvvvwbo == 1 || how_vvvvwbo == 2 || how_vvvvwbo == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbp function
function vvvvwbp(how_vvvvwbp)
{
	if (isSet(how_vvvvwbp) && how_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = how_vvvvwbp;
		var how_vvvvwbp = [];
		how_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(how_vvvvwbp))
	{
		var how_vvvvwbp = [];
	}
	var how = how_vvvvwbp.some(how_vvvvwbp_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('.note_no_behaviour_one').closest('.control-group').show();
		jQuery('.note_no_behaviour_three').closest('.control-group').show();
		jQuery('.note_no_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_no_behaviour_one').closest('.control-group').hide();
		jQuery('.note_no_behaviour_three').closest('.control-group').hide();
		jQuery('.note_no_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvwbp Some function
function how_vvvvwbp_SomeFunc(how_vvvvwbp)
{
	// set the function logic
	if (how_vvvvwbp == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwbq function
function vvvvwbq(how_vvvvwbq)
{
	if (isSet(how_vvvvwbq) && how_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = how_vvvvwbq;
		var how_vvvvwbq = [];
		how_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(how_vvvvwbq))
	{
		var how_vvvvwbq = [];
	}
	var how = how_vvvvwbq.some(how_vvvvwbq_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('.note_yes_behaviour_one').closest('.control-group').show();
		jQuery('.note_yes_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_yes_behaviour_one').closest('.control-group').hide();
		jQuery('.note_yes_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvwbq Some function
function how_vvvvwbq_SomeFunc(how_vvvvwbq)
{
	// set the function logic
	if (how_vvvvwbq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbr function
function vvvvwbr(how_vvvvwbr)
{
	if (isSet(how_vvvvwbr) && how_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = how_vvvvwbr;
		var how_vvvvwbr = [];
		how_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(how_vvvvwbr))
	{
		var how_vvvvwbr = [];
	}
	var how = how_vvvvwbr.some(how_vvvvwbr_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('.note_build_in_behaviour_one').closest('.control-group').show();
		jQuery('.note_build_in_behaviour_three').closest('.control-group').show();
		jQuery('.note_build_in_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_build_in_behaviour_one').closest('.control-group').hide();
		jQuery('.note_build_in_behaviour_three').closest('.control-group').hide();
		jQuery('.note_build_in_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvwbr Some function
function how_vvvvwbr_SomeFunc(how_vvvvwbr)
{
	// set the function logic
	if (how_vvvvwbr == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbs function
function vvvvwbs(type_vvvvwbs)
{
	// set the function logic
	if (type_vvvvwbs == 2)
	{
		jQuery('#jform_libraries').closest('.control-group').show();
		// add required attribute to libraries field
		if (jform_vvvvwbsvxk_required)
		{
			updateFieldRequired('libraries',0);
			jQuery('#jform_libraries').prop('required','required');
			jQuery('#jform_libraries').attr('aria-required',true);
			jQuery('#jform_libraries').addClass('required');
			jform_vvvvwbsvxk_required = false;
		}
	}
	else
	{
		jQuery('#jform_libraries').closest('.control-group').hide();
		// remove required attribute from libraries field
		if (!jform_vvvvwbsvxk_required)
		{
			updateFieldRequired('libraries',1);
			jQuery('#jform_libraries').removeAttr('required');
			jQuery('#jform_libraries').removeAttr('aria-required');
			jQuery('#jform_libraries').removeClass('required');
			jform_vvvvwbsvxk_required = true;
		}
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
	// get the linked details
	getLinked();
	// now load the displays
	getAjaxDisplay('library_config');
	getAjaxDisplay('library_files_folders_urls');

	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 300);
});

function addData(result,where){
	jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
}

function getAjaxDisplay(type){
	getAjaxDisplay_server(type).done(function(result) {
		if (result) {
			jQuery('#display_'+type).html(result);
		}
		// set button
		addButtonID(type,'header_'+type+'_buttons', 2); // <-- little edit button
	});
}

function getAjaxDisplay_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&raw=true&vdm="+vastDevMod);
	if (token.length > 0 && type.length > 0) {
		var request = token+'=1&type=' + type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getFieldSelectOptions_server(fieldId){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.fieldSelectOptions&format=json&raw=true");
	if (token.length > 0 && fieldId > 0) {
		var request = token+'=1&id='+fieldId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getFieldSelectOptions(fieldKey){
	// first check if the field is set
	if(jQuery("#jform_addconditions__addconditions"+fieldKey+"__option_field").length) {
		var fieldId = jQuery("#jform_addconditions__addconditions"+fieldKey+"__option_field option:selected").val();
		getFieldSelectOptions_server(fieldId).done(function(result) {
			if(result) {
				jQuery('textarea#jform_addconditions__addconditions'+fieldKey+'__field_options').val(result);
			} else {
				jQuery('textarea#jform_addconditions__addconditions'+fieldKey+'__field_options').val('');
			}
		});
	}
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

function addButtonID_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButtonID&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0 && size > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
function addButtonID(type, where, size){
	addButtonID_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	});
}

function addButton_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
function addButton(type, where, size){
	// just to insure that default behaviour still works
	size = typeof size !== 'undefined' ? size : 1;
	addButton_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	})
}

function getLinked_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type > 0){
		var request = token+'=1&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
} 
