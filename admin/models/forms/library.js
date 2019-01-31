/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwajvzv_required = false;
jform_vvvvwapvzw_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var how_vvvvwai = jQuery("#jform_how").val();
	vvvvwai(how_vvvvwai);

	var how_vvvvwaj = jQuery("#jform_how").val();
	vvvvwaj(how_vvvvwaj);

	var how_vvvvwak = jQuery("#jform_how").val();
	vvvvwak(how_vvvvwak);

	var how_vvvvwal = jQuery("#jform_how").val();
	vvvvwal(how_vvvvwal);

	var how_vvvvwam = jQuery("#jform_how").val();
	vvvvwam(how_vvvvwam);

	var how_vvvvwan = jQuery("#jform_how").val();
	vvvvwan(how_vvvvwan);

	var how_vvvvwao = jQuery("#jform_how").val();
	vvvvwao(how_vvvvwao);

	var type_vvvvwap = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwap(type_vvvvwap);
});

// the vvvvwai function
function vvvvwai(how_vvvvwai)
{
	if (isSet(how_vvvvwai) && how_vvvvwai.constructor !== Array)
	{
		var temp_vvvvwai = how_vvvvwai;
		var how_vvvvwai = [];
		how_vvvvwai.push(temp_vvvvwai);
	}
	else if (!isSet(how_vvvvwai))
	{
		var how_vvvvwai = [];
	}
	var how = how_vvvvwai.some(how_vvvvwai_SomeFunc);


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

// the vvvvwai Some function
function how_vvvvwai_SomeFunc(how_vvvvwai)
{
	// set the function logic
	if (how_vvvvwai == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwaj function
function vvvvwaj(how_vvvvwaj)
{
	if (isSet(how_vvvvwaj) && how_vvvvwaj.constructor !== Array)
	{
		var temp_vvvvwaj = how_vvvvwaj;
		var how_vvvvwaj = [];
		how_vvvvwaj.push(temp_vvvvwaj);
	}
	else if (!isSet(how_vvvvwaj))
	{
		var how_vvvvwaj = [];
	}
	var how = how_vvvvwaj.some(how_vvvvwaj_SomeFunc);


	// set this function logic
	if (how)
	{
		jQuery('#jform_php_setdocument').closest('.control-group').show();
		// add required attribute to php_setdocument field
		if (jform_vvvvwajvzv_required)
		{
			updateFieldRequired('php_setdocument',0);
			jQuery('#jform_php_setdocument').prop('required','required');
			jQuery('#jform_php_setdocument').attr('aria-required',true);
			jQuery('#jform_php_setdocument').addClass('required');
			jform_vvvvwajvzv_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_setdocument').closest('.control-group').hide();
		// remove required attribute from php_setdocument field
		if (!jform_vvvvwajvzv_required)
		{
			updateFieldRequired('php_setdocument',1);
			jQuery('#jform_php_setdocument').removeAttr('required');
			jQuery('#jform_php_setdocument').removeAttr('aria-required');
			jQuery('#jform_php_setdocument').removeClass('required');
			jform_vvvvwajvzv_required = true;
		}
	}
}

// the vvvvwaj Some function
function how_vvvvwaj_SomeFunc(how_vvvvwaj)
{
	// set the function logic
	if (how_vvvvwaj == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwak function
function vvvvwak(how_vvvvwak)
{
	if (isSet(how_vvvvwak) && how_vvvvwak.constructor !== Array)
	{
		var temp_vvvvwak = how_vvvvwak;
		var how_vvvvwak = [];
		how_vvvvwak.push(temp_vvvvwak);
	}
	else if (!isSet(how_vvvvwak))
	{
		var how_vvvvwak = [];
	}
	var how = how_vvvvwak.some(how_vvvvwak_SomeFunc);


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

// the vvvvwak Some function
function how_vvvvwak_SomeFunc(how_vvvvwak)
{
	// set the function logic
	if (how_vvvvwak == 2 || how_vvvvwak == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwal function
function vvvvwal(how_vvvvwal)
{
	if (isSet(how_vvvvwal) && how_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = how_vvvvwal;
		var how_vvvvwal = [];
		how_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(how_vvvvwal))
	{
		var how_vvvvwal = [];
	}
	var how = how_vvvvwal.some(how_vvvvwal_SomeFunc);


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

// the vvvvwal Some function
function how_vvvvwal_SomeFunc(how_vvvvwal)
{
	// set the function logic
	if (how_vvvvwal == 1 || how_vvvvwal == 2 || how_vvvvwal == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwam function
function vvvvwam(how_vvvvwam)
{
	if (isSet(how_vvvvwam) && how_vvvvwam.constructor !== Array)
	{
		var temp_vvvvwam = how_vvvvwam;
		var how_vvvvwam = [];
		how_vvvvwam.push(temp_vvvvwam);
	}
	else if (!isSet(how_vvvvwam))
	{
		var how_vvvvwam = [];
	}
	var how = how_vvvvwam.some(how_vvvvwam_SomeFunc);


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

// the vvvvwam Some function
function how_vvvvwam_SomeFunc(how_vvvvwam)
{
	// set the function logic
	if (how_vvvvwam == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwan function
function vvvvwan(how_vvvvwan)
{
	if (isSet(how_vvvvwan) && how_vvvvwan.constructor !== Array)
	{
		var temp_vvvvwan = how_vvvvwan;
		var how_vvvvwan = [];
		how_vvvvwan.push(temp_vvvvwan);
	}
	else if (!isSet(how_vvvvwan))
	{
		var how_vvvvwan = [];
	}
	var how = how_vvvvwan.some(how_vvvvwan_SomeFunc);


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

// the vvvvwan Some function
function how_vvvvwan_SomeFunc(how_vvvvwan)
{
	// set the function logic
	if (how_vvvvwan == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwao function
function vvvvwao(how_vvvvwao)
{
	if (isSet(how_vvvvwao) && how_vvvvwao.constructor !== Array)
	{
		var temp_vvvvwao = how_vvvvwao;
		var how_vvvvwao = [];
		how_vvvvwao.push(temp_vvvvwao);
	}
	else if (!isSet(how_vvvvwao))
	{
		var how_vvvvwao = [];
	}
	var how = how_vvvvwao.some(how_vvvvwao_SomeFunc);


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

// the vvvvwao Some function
function how_vvvvwao_SomeFunc(how_vvvvwao)
{
	// set the function logic
	if (how_vvvvwao == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(type_vvvvwap)
{
	// set the function logic
	if (type_vvvvwap == 2)
	{
		jQuery('#jform_libraries').closest('.control-group').show();
		// add required attribute to libraries field
		if (jform_vvvvwapvzw_required)
		{
			updateFieldRequired('libraries',0);
			jQuery('#jform_libraries').prop('required','required');
			jQuery('#jform_libraries').attr('aria-required',true);
			jQuery('#jform_libraries').addClass('required');
			jform_vvvvwapvzw_required = false;
		}
	}
	else
	{
		jQuery('#jform_libraries').closest('.control-group').hide();
		// remove required attribute from libraries field
		if (!jform_vvvvwapvzw_required)
		{
			updateFieldRequired('libraries',1);
			jQuery('#jform_libraries').removeAttr('required');
			jQuery('#jform_libraries').removeAttr('aria-required');
			jQuery('#jform_libraries').removeClass('required');
			jform_vvvvwapvzw_required = true;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&raw=true&vdm="+vastDevMod;
	if (token.length > 0 && type.length > 0) {
		var request = 'token='+token+'&type=' + type;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.fieldSelectOptions&format=json&raw=true";
	if (token.length > 0 && fieldId > 0) {
		var request = 'token='+token+'&id='+fieldId;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod;
	if(token.length > 0 && id > 0){
		var request = 'token='+token+'&id='+id+'&return_here='+return_here;
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
				jQuery('<div class="control-group"><div class="control-label"><label>Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
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
		var request = 'token='+token+'&type='+type+'&size='+size;
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
		var request = 'token='+token+'&type='+type+'&size='+size;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&raw=true&vdm="+vastDevMod;
	if(token.length > 0 && type > 0){
		var request = 'token='+token+'&type='+type;
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
