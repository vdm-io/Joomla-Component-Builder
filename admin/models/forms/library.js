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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		library.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzzvzr_required = false;
jform_vvvvwafvzs_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var how_vvvvvzy = jQuery("#jform_how").val();
	vvvvvzy(how_vvvvvzy);

	var how_vvvvvzz = jQuery("#jform_how").val();
	vvvvvzz(how_vvvvvzz);

	var how_vvvvwaa = jQuery("#jform_how").val();
	vvvvwaa(how_vvvvwaa);

	var how_vvvvwab = jQuery("#jform_how").val();
	vvvvwab(how_vvvvwab);

	var how_vvvvwac = jQuery("#jform_how").val();
	vvvvwac(how_vvvvwac);

	var how_vvvvwad = jQuery("#jform_how").val();
	vvvvwad(how_vvvvwad);

	var how_vvvvwae = jQuery("#jform_how").val();
	vvvvwae(how_vvvvwae);

	var type_vvvvwaf = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwaf(type_vvvvwaf);
});

// the vvvvvzy function
function vvvvvzy(how_vvvvvzy)
{
	if (isSet(how_vvvvvzy) && how_vvvvvzy.constructor !== Array)
	{
		var temp_vvvvvzy = how_vvvvvzy;
		var how_vvvvvzy = [];
		how_vvvvvzy.push(temp_vvvvvzy);
	}
	else if (!isSet(how_vvvvvzy))
	{
		var how_vvvvvzy = [];
	}
	var how = how_vvvvvzy.some(how_vvvvvzy_SomeFunc);


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

// the vvvvvzy Some function
function how_vvvvvzy_SomeFunc(how_vvvvvzy)
{
	// set the function logic
	if (how_vvvvvzy == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzz function
function vvvvvzz(how_vvvvvzz)
{
	if (isSet(how_vvvvvzz) && how_vvvvvzz.constructor !== Array)
	{
		var temp_vvvvvzz = how_vvvvvzz;
		var how_vvvvvzz = [];
		how_vvvvvzz.push(temp_vvvvvzz);
	}
	else if (!isSet(how_vvvvvzz))
	{
		var how_vvvvvzz = [];
	}
	var how = how_vvvvvzz.some(how_vvvvvzz_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('#jform_php_setdocument').closest('.control-group').show();
		if (jform_vvvvvzzvzr_required)
		{
			updateFieldRequired('php_setdocument',0);
			jQuery('#jform_php_setdocument').prop('required','required');
			jQuery('#jform_php_setdocument').attr('aria-required',true);
			jQuery('#jform_php_setdocument').addClass('required');
			jform_vvvvvzzvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_setdocument').closest('.control-group').hide();
		if (!jform_vvvvvzzvzr_required)
		{
			updateFieldRequired('php_setdocument',1);
			jQuery('#jform_php_setdocument').removeAttr('required');
			jQuery('#jform_php_setdocument').removeAttr('aria-required');
			jQuery('#jform_php_setdocument').removeClass('required');
			jform_vvvvvzzvzr_required = true;
		}
	}
}

// the vvvvvzz Some function
function how_vvvvvzz_SomeFunc(how_vvvvvzz)
{
	// set the function logic
	if (how_vvvvvzz == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwaa function
function vvvvwaa(how_vvvvwaa)
{
	if (isSet(how_vvvvwaa) && how_vvvvwaa.constructor !== Array)
	{
		var temp_vvvvwaa = how_vvvvwaa;
		var how_vvvvwaa = [];
		how_vvvvwaa.push(temp_vvvvwaa);
	}
	else if (!isSet(how_vvvvwaa))
	{
		var how_vvvvwaa = [];
	}
	var how = how_vvvvwaa.some(how_vvvvwaa_SomeFunc);


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

// the vvvvwaa Some function
function how_vvvvwaa_SomeFunc(how_vvvvwaa)
{
	// set the function logic
	if (how_vvvvwaa == 2 || how_vvvvwaa == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwab function
function vvvvwab(how_vvvvwab)
{
	if (isSet(how_vvvvwab) && how_vvvvwab.constructor !== Array)
	{
		var temp_vvvvwab = how_vvvvwab;
		var how_vvvvwab = [];
		how_vvvvwab.push(temp_vvvvwab);
	}
	else if (!isSet(how_vvvvwab))
	{
		var how_vvvvwab = [];
	}
	var how = how_vvvvwab.some(how_vvvvwab_SomeFunc);


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

// the vvvvwab Some function
function how_vvvvwab_SomeFunc(how_vvvvwab)
{
	// set the function logic
	if (how_vvvvwab == 1 || how_vvvvwab == 2 || how_vvvvwab == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwac function
function vvvvwac(how_vvvvwac)
{
	if (isSet(how_vvvvwac) && how_vvvvwac.constructor !== Array)
	{
		var temp_vvvvwac = how_vvvvwac;
		var how_vvvvwac = [];
		how_vvvvwac.push(temp_vvvvwac);
	}
	else if (!isSet(how_vvvvwac))
	{
		var how_vvvvwac = [];
	}
	var how = how_vvvvwac.some(how_vvvvwac_SomeFunc);


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

// the vvvvwac Some function
function how_vvvvwac_SomeFunc(how_vvvvwac)
{
	// set the function logic
	if (how_vvvvwac == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwad function
function vvvvwad(how_vvvvwad)
{
	if (isSet(how_vvvvwad) && how_vvvvwad.constructor !== Array)
	{
		var temp_vvvvwad = how_vvvvwad;
		var how_vvvvwad = [];
		how_vvvvwad.push(temp_vvvvwad);
	}
	else if (!isSet(how_vvvvwad))
	{
		var how_vvvvwad = [];
	}
	var how = how_vvvvwad.some(how_vvvvwad_SomeFunc);


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

// the vvvvwad Some function
function how_vvvvwad_SomeFunc(how_vvvvwad)
{
	// set the function logic
	if (how_vvvvwad == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwae function
function vvvvwae(how_vvvvwae)
{
	if (isSet(how_vvvvwae) && how_vvvvwae.constructor !== Array)
	{
		var temp_vvvvwae = how_vvvvwae;
		var how_vvvvwae = [];
		how_vvvvwae.push(temp_vvvvwae);
	}
	else if (!isSet(how_vvvvwae))
	{
		var how_vvvvwae = [];
	}
	var how = how_vvvvwae.some(how_vvvvwae_SomeFunc);


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

// the vvvvwae Some function
function how_vvvvwae_SomeFunc(how_vvvvwae)
{
	// set the function logic
	if (how_vvvvwae == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwaf function
function vvvvwaf(type_vvvvwaf)
{
	// set the function logic
	if (type_vvvvwaf == 2)
	{
		jQuery('#jform_libraries').closest('.control-group').show();
		if (jform_vvvvwafvzs_required)
		{
			updateFieldRequired('libraries',0);
			jQuery('#jform_libraries').prop('required','required');
			jQuery('#jform_libraries').attr('aria-required',true);
			jQuery('#jform_libraries').addClass('required');
			jform_vvvvwafvzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_libraries').closest('.control-group').hide();
		if (!jform_vvvvwafvzs_required)
		{
			updateFieldRequired('libraries',1);
			jQuery('#jform_libraries').removeAttr('required');
			jQuery('#jform_libraries').removeAttr('aria-required');
			jQuery('#jform_libraries').removeClass('required');
			jform_vvvvwafvzs_required = true;
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
});

function addData(result,where){
	jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
}
			
function addButtonID_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButtonID&format=json&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0 && size > 0){
		var request = 'token='+token+'&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
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
			
function addButton_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = 'token='+token+'&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}
function addButton(type,where){
	addButton_server(type).done(function(result) {
		if(result){
			addData(result,'#jform_'+where);
		}
	})
}			
			
function getLinked_server(type){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&vdm="+vastDevMod;
	if(token.length > 0 && type > 0){
		var request = 'token='+token+'&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&vdm="+vastDevMod;
	if (token.length > 0 && type.length > 0) {
		var request = 'token='+token+'&type=' + type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getFieldSelectOptions_server(fieldId){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.fieldSelectOptions&format=json";
	if (token.length > 0 && fieldId > 0) {
		var request = 'token='+token+'&id='+fieldId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
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
