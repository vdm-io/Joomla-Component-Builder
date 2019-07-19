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
jform_vvvvwatvxg_required = false;
jform_vvvvwazvxh_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var how_vvvvwas = jQuery("#jform_how").val();
	vvvvwas(how_vvvvwas);

	var how_vvvvwat = jQuery("#jform_how").val();
	vvvvwat(how_vvvvwat);

	var how_vvvvwau = jQuery("#jform_how").val();
	vvvvwau(how_vvvvwau);

	var how_vvvvwav = jQuery("#jform_how").val();
	vvvvwav(how_vvvvwav);

	var how_vvvvwaw = jQuery("#jform_how").val();
	vvvvwaw(how_vvvvwaw);

	var how_vvvvwax = jQuery("#jform_how").val();
	vvvvwax(how_vvvvwax);

	var how_vvvvway = jQuery("#jform_how").val();
	vvvvway(how_vvvvway);

	var type_vvvvwaz = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwaz(type_vvvvwaz);
});

// the vvvvwas function
function vvvvwas(how_vvvvwas)
{
	if (isSet(how_vvvvwas) && how_vvvvwas.constructor !== Array)
	{
		var temp_vvvvwas = how_vvvvwas;
		var how_vvvvwas = [];
		how_vvvvwas.push(temp_vvvvwas);
	}
	else if (!isSet(how_vvvvwas))
	{
		var how_vvvvwas = [];
	}
	var how = how_vvvvwas.some(how_vvvvwas_SomeFunc);


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

// the vvvvwas Some function
function how_vvvvwas_SomeFunc(how_vvvvwas)
{
	// set the function logic
	if (how_vvvvwas == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwat function
function vvvvwat(how_vvvvwat)
{
	if (isSet(how_vvvvwat) && how_vvvvwat.constructor !== Array)
	{
		var temp_vvvvwat = how_vvvvwat;
		var how_vvvvwat = [];
		how_vvvvwat.push(temp_vvvvwat);
	}
	else if (!isSet(how_vvvvwat))
	{
		var how_vvvvwat = [];
	}
	var how = how_vvvvwat.some(how_vvvvwat_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('#jform_php_setdocument').closest('.control-group').show();
		// add required attribute to php_setdocument field
		if (jform_vvvvwatvxg_required)
		{
			updateFieldRequired('php_setdocument',0);
			jQuery('#jform_php_setdocument').prop('required','required');
			jQuery('#jform_php_setdocument').attr('aria-required',true);
			jQuery('#jform_php_setdocument').addClass('required');
			jform_vvvvwatvxg_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_setdocument').closest('.control-group').hide();
		// remove required attribute from php_setdocument field
		if (!jform_vvvvwatvxg_required)
		{
			updateFieldRequired('php_setdocument',1);
			jQuery('#jform_php_setdocument').removeAttr('required');
			jQuery('#jform_php_setdocument').removeAttr('aria-required');
			jQuery('#jform_php_setdocument').removeClass('required');
			jform_vvvvwatvxg_required = true;
		}
	}
}

// the vvvvwat Some function
function how_vvvvwat_SomeFunc(how_vvvvwat)
{
	// set the function logic
	if (how_vvvvwat == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwau function
function vvvvwau(how_vvvvwau)
{
	if (isSet(how_vvvvwau) && how_vvvvwau.constructor !== Array)
	{
		var temp_vvvvwau = how_vvvvwau;
		var how_vvvvwau = [];
		how_vvvvwau.push(temp_vvvvwau);
	}
	else if (!isSet(how_vvvvwau))
	{
		var how_vvvvwau = [];
	}
	var how = how_vvvvwau.some(how_vvvvwau_SomeFunc);


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

// the vvvvwau Some function
function how_vvvvwau_SomeFunc(how_vvvvwau)
{
	// set the function logic
	if (how_vvvvwau == 2 || how_vvvvwau == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwav function
function vvvvwav(how_vvvvwav)
{
	if (isSet(how_vvvvwav) && how_vvvvwav.constructor !== Array)
	{
		var temp_vvvvwav = how_vvvvwav;
		var how_vvvvwav = [];
		how_vvvvwav.push(temp_vvvvwav);
	}
	else if (!isSet(how_vvvvwav))
	{
		var how_vvvvwav = [];
	}
	var how = how_vvvvwav.some(how_vvvvwav_SomeFunc);


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

// the vvvvwav Some function
function how_vvvvwav_SomeFunc(how_vvvvwav)
{
	// set the function logic
	if (how_vvvvwav == 1 || how_vvvvwav == 2 || how_vvvvwav == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwaw function
function vvvvwaw(how_vvvvwaw)
{
	if (isSet(how_vvvvwaw) && how_vvvvwaw.constructor !== Array)
	{
		var temp_vvvvwaw = how_vvvvwaw;
		var how_vvvvwaw = [];
		how_vvvvwaw.push(temp_vvvvwaw);
	}
	else if (!isSet(how_vvvvwaw))
	{
		var how_vvvvwaw = [];
	}
	var how = how_vvvvwaw.some(how_vvvvwaw_SomeFunc);


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

// the vvvvwaw Some function
function how_vvvvwaw_SomeFunc(how_vvvvwaw)
{
	// set the function logic
	if (how_vvvvwaw == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwax function
function vvvvwax(how_vvvvwax)
{
	if (isSet(how_vvvvwax) && how_vvvvwax.constructor !== Array)
	{
		var temp_vvvvwax = how_vvvvwax;
		var how_vvvvwax = [];
		how_vvvvwax.push(temp_vvvvwax);
	}
	else if (!isSet(how_vvvvwax))
	{
		var how_vvvvwax = [];
	}
	var how = how_vvvvwax.some(how_vvvvwax_SomeFunc);


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

// the vvvvwax Some function
function how_vvvvwax_SomeFunc(how_vvvvwax)
{
	// set the function logic
	if (how_vvvvwax == 1)
	{
		return true;
	}
	return false;
}

// the vvvvway function
function vvvvway(how_vvvvway)
{
	if (isSet(how_vvvvway) && how_vvvvway.constructor !== Array)
	{
		var temp_vvvvway = how_vvvvway;
		var how_vvvvway = [];
		how_vvvvway.push(temp_vvvvway);
	}
	else if (!isSet(how_vvvvway))
	{
		var how_vvvvway = [];
	}
	var how = how_vvvvway.some(how_vvvvway_SomeFunc);


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

// the vvvvway Some function
function how_vvvvway_SomeFunc(how_vvvvway)
{
	// set the function logic
	if (how_vvvvway == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwaz function
function vvvvwaz(type_vvvvwaz)
{
	// set the function logic
	if (type_vvvvwaz == 2)
	{
		jQuery('#jform_libraries').closest('.control-group').show();
		// add required attribute to libraries field
		if (jform_vvvvwazvxh_required)
		{
			updateFieldRequired('libraries',0);
			jQuery('#jform_libraries').prop('required','required');
			jQuery('#jform_libraries').attr('aria-required',true);
			jQuery('#jform_libraries').addClass('required');
			jform_vvvvwazvxh_required = false;
		}
	}
	else
	{
		jQuery('#jform_libraries').closest('.control-group').hide();
		// remove required attribute from libraries field
		if (!jform_vvvvwazvxh_required)
		{
			updateFieldRequired('libraries',1);
			jQuery('#jform_libraries').removeAttr('required');
			jQuery('#jform_libraries').removeAttr('aria-required');
			jQuery('#jform_libraries').removeClass('required');
			jform_vvvvwazvxh_required = true;
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
