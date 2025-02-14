/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvvwcvvv_required = false;
jform_vvvvvwdvvw_required = false;
jform_vvvvvwgvvx_required = false;
jform_vvvvvwgvvy_required = false;
jform_vvvvvwgvvz_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var emptycontributors_vvvvvvv = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	vvvvvvv(emptycontributors_vvvvvvv);

	var update_server_target_vvvvvvw = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvw = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvw(update_server_target_vvvvvvw,add_update_server_vvvvvvw);

	var add_update_server_vvvvvvx = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvvx = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvvx(add_update_server_vvvvvvx,update_server_target_vvvvvvx);

	var update_server_target_vvvvvvy = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvvy = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvvy(update_server_target_vvvvvvy,add_update_server_vvvvvvy);

	var update_server_target_vvvvvwa = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwa = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwa(update_server_target_vvvvvwa,add_update_server_vvvvvwa);

	var add_update_server_vvvvvwc = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwc(add_update_server_vvvvvwc);

	var buildcomp_vvvvvwd = jQuery("#jform_buildcomp input[type='radio']:checked").val();
	vvvvvwd(buildcomp_vvvvvwd);

	var dashboard_type_vvvvvwe = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	vvvvvwe(dashboard_type_vvvvvwe);

	var dashboard_type_vvvvvwf = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	vvvvvwf(dashboard_type_vvvvvwf);

	var translation_tool_vvvvvwg = jQuery("#jform_translation_tool").val();
	vvvvvwg(translation_tool_vvvvvwg);
});

// the vvvvvvv function
function vvvvvvv(emptycontributors_vvvvvvv)
{
	// set the function logic
	if (emptycontributors_vvvvvvv == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the vvvvvvw function
function vvvvvvw(update_server_target_vvvvvvw,add_update_server_vvvvvvw)
{
	// set the function logic
	if (update_server_target_vvvvvvw == 1 && add_update_server_vvvvvvw == 1)
	{
		jQuery('#jform_update_server').closest('.control-group').show();
		jQuery('.note_update_server_note_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server').closest('.control-group').hide();
		jQuery('.note_update_server_note_ftp').closest('.control-group').hide();
	}
}

// the vvvvvvx function
function vvvvvvx(add_update_server_vvvvvvx,update_server_target_vvvvvvx)
{
	// set the function logic
	if (add_update_server_vvvvvvx == 1 && update_server_target_vvvvvvx == 1)
	{
		jQuery('#jform_update_server').closest('.control-group').show();
		jQuery('.note_update_server_note_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server').closest('.control-group').hide();
		jQuery('.note_update_server_note_ftp').closest('.control-group').hide();
	}
}

// the vvvvvvy function
function vvvvvvy(update_server_target_vvvvvvy,add_update_server_vvvvvvy)
{
	// set the function logic
	if (update_server_target_vvvvvvy == 2 && add_update_server_vvvvvvy == 1)
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').hide();
	}
}

// the vvvvvwa function
function vvvvvwa(update_server_target_vvvvvwa,add_update_server_vvvvvwa)
{
	// set the function logic
	if (update_server_target_vvvvvwa == 3 && add_update_server_vvvvvwa == 1)
	{
		jQuery('.note_update_server_note_other').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_other').closest('.control-group').hide();
	}
}

// the vvvvvwc function
function vvvvvwc(add_update_server_vvvvvwc)
{
	// set the function logic
	if (add_update_server_vvvvvwc == 1)
	{
		jQuery('#jform_update_server_target').closest('.control-group').show();
		// add required attribute to update_server_target field
		if (jform_vvvvvwcvvv_required)
		{
			updateFieldRequired('update_server_target',0);
			jQuery('#jform_update_server_target').prop('required','required');
			jQuery('#jform_update_server_target').attr('aria-required',true);
			jQuery('#jform_update_server_target').addClass('required');
			jform_vvvvvwcvvv_required = false;
		}
	}
	else
	{
		jQuery('#jform_update_server_target').closest('.control-group').hide();
		// remove required attribute from update_server_target field
		if (!jform_vvvvvwcvvv_required)
		{
			updateFieldRequired('update_server_target',1);
			jQuery('#jform_update_server_target').removeAttr('required');
			jQuery('#jform_update_server_target').removeAttr('aria-required');
			jQuery('#jform_update_server_target').removeClass('required');
			jform_vvvvvwcvvv_required = true;
		}
	}
}

// the vvvvvwd function
function vvvvvwd(buildcomp_vvvvvwd)
{
	// set the function logic
	if (buildcomp_vvvvvwd == 1)
	{
		jQuery('#jform_buildcompsql').closest('.control-group').show();
		// add required attribute to buildcompsql field
		if (jform_vvvvvwdvvw_required)
		{
			updateFieldRequired('buildcompsql',0);
			jQuery('#jform_buildcompsql').prop('required','required');
			jQuery('#jform_buildcompsql').attr('aria-required',true);
			jQuery('#jform_buildcompsql').addClass('required');
			jform_vvvvvwdvvw_required = false;
		}
	}
	else
	{
		jQuery('#jform_buildcompsql').closest('.control-group').hide();
		// remove required attribute from buildcompsql field
		if (!jform_vvvvvwdvvw_required)
		{
			updateFieldRequired('buildcompsql',1);
			jQuery('#jform_buildcompsql').removeAttr('required');
			jQuery('#jform_buildcompsql').removeAttr('aria-required');
			jQuery('#jform_buildcompsql').removeClass('required');
			jform_vvvvvwdvvw_required = true;
		}
	}
}

// the vvvvvwe function
function vvvvvwe(dashboard_type_vvvvvwe)
{
	// set the function logic
	if (dashboard_type_vvvvvwe == 2)
	{
		jQuery('#jform_dashboard').closest('.control-group').show();
		jQuery('.note_dynamic_dashboard').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_dashboard').closest('.control-group').hide();
		jQuery('.note_dynamic_dashboard').closest('.control-group').hide();
	}
}

// the vvvvvwf function
function vvvvvwf(dashboard_type_vvvvvwf)
{
	// set the function logic
	if (dashboard_type_vvvvvwf == 1)
	{
		jQuery('.note_botton_component_dashboard').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_botton_component_dashboard').closest('.control-group').hide();
	}
}

// the vvvvvwg function
function vvvvvwg(translation_tool_vvvvvwg)
{
	if (isSet(translation_tool_vvvvvwg) && translation_tool_vvvvvwg.constructor !== Array)
	{
		var temp_vvvvvwg = translation_tool_vvvvvwg;
		var translation_tool_vvvvvwg = [];
		translation_tool_vvvvvwg.push(temp_vvvvvwg);
	}
	else if (!isSet(translation_tool_vvvvvwg))
	{
		var translation_tool_vvvvvwg = [];
	}
	var translation_tool = translation_tool_vvvvvwg.some(translation_tool_vvvvvwg_SomeFunc);


	// set this function logic
	if (translation_tool)
	{
		jQuery('#jform_crowdin_account_api_key').closest('.control-group').show();
		jQuery('.note_crowdin').closest('.control-group').show();
		jQuery('#jform_crowdin_project_api_key').closest('.control-group').show();
		// add required attribute to crowdin_project_api_key field
		if (jform_vvvvvwgvvx_required)
		{
			updateFieldRequired('crowdin_project_api_key',0);
			jQuery('#jform_crowdin_project_api_key').prop('required','required');
			jQuery('#jform_crowdin_project_api_key').attr('aria-required',true);
			jQuery('#jform_crowdin_project_api_key').addClass('required');
			jform_vvvvvwgvvx_required = false;
		}
		jQuery('#jform_crowdin_project_identifier').closest('.control-group').show();
		// add required attribute to crowdin_project_identifier field
		if (jform_vvvvvwgvvy_required)
		{
			updateFieldRequired('crowdin_project_identifier',0);
			jQuery('#jform_crowdin_project_identifier').prop('required','required');
			jQuery('#jform_crowdin_project_identifier').attr('aria-required',true);
			jQuery('#jform_crowdin_project_identifier').addClass('required');
			jform_vvvvvwgvvy_required = false;
		}
		jQuery('#jform_crowdin_username').closest('.control-group').show();
		// add required attribute to crowdin_username field
		if (jform_vvvvvwgvvz_required)
		{
			updateFieldRequired('crowdin_username',0);
			jQuery('#jform_crowdin_username').prop('required','required');
			jQuery('#jform_crowdin_username').attr('aria-required',true);
			jQuery('#jform_crowdin_username').addClass('required');
			jform_vvvvvwgvvz_required = false;
		}
	}
	else
	{
		jQuery('#jform_crowdin_account_api_key').closest('.control-group').hide();
		jQuery('.note_crowdin').closest('.control-group').hide();
		jQuery('#jform_crowdin_project_api_key').closest('.control-group').hide();
		// remove required attribute from crowdin_project_api_key field
		if (!jform_vvvvvwgvvx_required)
		{
			updateFieldRequired('crowdin_project_api_key',1);
			jQuery('#jform_crowdin_project_api_key').removeAttr('required');
			jQuery('#jform_crowdin_project_api_key').removeAttr('aria-required');
			jQuery('#jform_crowdin_project_api_key').removeClass('required');
			jform_vvvvvwgvvx_required = true;
		}
		jQuery('#jform_crowdin_project_identifier').closest('.control-group').hide();
		// remove required attribute from crowdin_project_identifier field
		if (!jform_vvvvvwgvvy_required)
		{
			updateFieldRequired('crowdin_project_identifier',1);
			jQuery('#jform_crowdin_project_identifier').removeAttr('required');
			jQuery('#jform_crowdin_project_identifier').removeAttr('aria-required');
			jQuery('#jform_crowdin_project_identifier').removeClass('required');
			jform_vvvvvwgvvy_required = true;
		}
		jQuery('#jform_crowdin_username').closest('.control-group').hide();
		// remove required attribute from crowdin_username field
		if (!jform_vvvvvwgvvz_required)
		{
			updateFieldRequired('crowdin_username',1);
			jQuery('#jform_crowdin_username').removeAttr('required');
			jQuery('#jform_crowdin_username').removeAttr('aria-required');
			jQuery('#jform_crowdin_username').removeClass('required');
			jform_vvvvvwgvvz_required = true;
		}
	}
}

// the vvvvvwg Some function
function translation_tool_vvvvvwg_SomeFunc(translation_tool_vvvvvwg)
{
	// set the function logic
	if (translation_tool_vvvvvwg == 1)
	{
		return true;
	}
	return false;
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (document.getElementById('jform_not_required')) {
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
	// check what is the dashboard switch
	var dasboard_type = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	dasboardSwitch(dasboard_type);
	// set buttons
	function setButtons1() {
		addButtonID('component_files_folders','button_component_files_folders', 1);
		addButtonID('component_site_views','button_create_edit_views', 1);
	 }
	function setButtons2() {
		addButtonID('component_updates','component_version', 1);
		addButtonID('component_mysql_tweaks','button_mysql_tweak_options', 1);
		addButtonID('component_custom_admin_views','button_create_edit_views', 1);
	 }
	function setButtons3() {
		addButtonID('component_custom_admin_menus','button_add_custom_menus', 1);
		addButtonID('component_config','button_add_config', 1);
		addButtonID('component_admin_views','button_create_edit_views', 1);
	 }

	 // use setTimeout() to execute
	 setTimeout(setButtons1, 1000);
	 setTimeout(setButtons2, 2000);
	 setTimeout(setButtons3, 3000);
	
	// now load the displays
	function setDisplays1() {
		getAjaxDisplay('component_admin_views');
	}
	function setDisplays2() {
		getAjaxDisplay('component_custom_admin_views');
	}
	function setDisplays3() {
		getAjaxDisplay('component_site_views');
	}

	 // use setTimeout() to execute
	 setTimeout(setDisplays1, 1500);
	 setTimeout(setDisplays2, 2500);
	 setTimeout(setDisplays3, 3500);

	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 400);

	// get crowdin detail if set
	setTimeout(getTranslationToolDetails, 600);
});

function getTranslationToolDetails(){
	// get the translation tool selection
	var tool = jQuery("#jform_translation_tool").val();
	// trigger Crowdin
	if (tool == 1) {
		// get the identifier
		var identifier = jQuery("#jform_crowdin_project_identifier").val();
		// get the key
		var key = jQuery("#jform_crowdin_project_api_key").val();
		// query server for details
		getCrowdinDetails_server(identifier, key).done(function(result) {
			if (result.error){
				jQuery('#crowdin_information_box').show();
				jQuery('#crowdin_error_box').show();
				jQuery('#crowdin_error_box').html(result.error);
				jQuery('#crowdin_success_box').hide();
			} else if(result.html) {
				jQuery('#crowdin_success_box').show();
				jQuery('#crowdin_success_box').html(result.html);
				jQuery('#crowdin_error_box').hide();
				jQuery('#crowdin_information_box').hide();
			} else {
				jQuery('#crowdin_information_box').show();
				jQuery('#crowdin_success_box').hide();
			}
		});
	}
}

function getCrowdinDetails_server(identifier, key){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getCrowdinDetails&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && identifier.length > 0 && key.length > 0){
		var request = token+'=1&identifier='+identifier+'&key='+key;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getAjaxDisplay(type){
	getAjaxDisplay_server(type).done(function(result) {
		if(result){
			jQuery('#display_'+type).html(result);
		}
		// set button
		addButtonID(type,'header_'+type+'_buttons', 2); // <-- little edit button
	});
}

function getAjaxDisplay_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
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

function addData(result, where){
	jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
}

function dasboardSwitch(value){
	// hide if default
	if (2 == value) {
		jQuery('.control-group-componentdashboard-one').hide();
	} else {
		// default behaviour
		if (jQuery('div.control-group-componentdashboard-one').length) {
			jQuery('.control-group-componentdashboard-one').show();
		} else {
			addButtonID('component_dashboard','button_component_dashboard', 1);
		}
	}
}


function getEditCustomCodeButtons_server(id) {
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	let requestParams = '';
	if (token.length > 0 && id > 0) {
		requestParams = token+'=1&id='+id+'&return_here='+return_here;
	}
	// Construct URL with parameters for GET request
	const urlWithParams = getUrl + '&' + requestParams;

	// Using the Fetch API for the GET request
	return fetch(urlWithParams, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		return response.json();
	});
}

function getEditCustomCodeButtons() {
	// Get the id using pure JavaScript
	const id = document.querySelector("#jform_id").value;
	getEditCustomCodeButtons_server(id).then(function(result) {
		if (typeof result === 'object') {
			Object.entries(result).forEach(([field, buttons]) => {
				// Creating the div element for buttons
				const div = document.createElement('div');
				div.className = 'control-group';
				div.innerHTML = '<div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div>';

				// Insert the div before .control-wrapper-{field}
				const insertBeforeElement = document.querySelector(".control-wrapper-"+field);
				if (insertBeforeElement) {
					insertBeforeElement.parentNode.insertBefore(div, insertBeforeElement);
				}

				// Adding buttons to the div
				Object.entries(buttons).forEach(([name, button]) => {
					const controlsDiv = document.querySelector(".control-customcode-buttons-"+field);
					if (controlsDiv) {
						controlsDiv.innerHTML += button;
					}
				});
			});
		}
	}).catch(error => {
		console.error('Error:', error);
	});
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
