/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var add_class_helper_vvvvvwh = jQuery("#jform_add_class_helper").val();
	vvvvvwh(add_class_helper_vvvvvwh);

	var add_class_helper_header_vvvvvwi = jQuery("#jform_add_class_helper_header input[type='radio']:checked").val();
	var add_class_helper_vvvvvwi = jQuery("#jform_add_class_helper").val();
	vvvvvwi(add_class_helper_header_vvvvvwi,add_class_helper_vvvvvwi);

	var update_server_target_vvvvvwk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwk(update_server_target_vvvvvwk,add_update_server_vvvvvwk);

	var add_update_server_vvvvvwl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwl(add_update_server_vvvvvwl,update_server_target_vvvvvwl);

	var update_server_target_vvvvvwm = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwm = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwm(update_server_target_vvvvvwm,add_update_server_vvvvvwm);

	var update_server_target_vvvvvwo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwo(update_server_target_vvvvvwo,add_update_server_vvvvvwo);
});

// the vvvvvwh function
function vvvvvwh(add_class_helper_vvvvvwh)
{
	if (isSet(add_class_helper_vvvvvwh) && add_class_helper_vvvvvwh.constructor !== Array)
	{
		var temp_vvvvvwh = add_class_helper_vvvvvwh;
		var add_class_helper_vvvvvwh = [];
		add_class_helper_vvvvvwh.push(temp_vvvvvwh);
	}
	else if (!isSet(add_class_helper_vvvvvwh))
	{
		var add_class_helper_vvvvvwh = [];
	}
	var add_class_helper = add_class_helper_vvvvvwh.some(add_class_helper_vvvvvwh_SomeFunc);


	// set this function logic
	if (add_class_helper)
	{
		jQuery('#jform_add_class_helper_header').closest('.control-group').show();
		jQuery('#jform_class_helper_code-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_add_class_helper_header').closest('.control-group').hide();
		jQuery('#jform_class_helper_code-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwh Some function
function add_class_helper_vvvvvwh_SomeFunc(add_class_helper_vvvvvwh)
{
	// set the function logic
	if (add_class_helper_vvvvvwh == 1 || add_class_helper_vvvvvwh == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvwi function
function vvvvvwi(add_class_helper_header_vvvvvwi,add_class_helper_vvvvvwi)
{
	if (isSet(add_class_helper_header_vvvvvwi) && add_class_helper_header_vvvvvwi.constructor !== Array)
	{
		var temp_vvvvvwi = add_class_helper_header_vvvvvwi;
		var add_class_helper_header_vvvvvwi = [];
		add_class_helper_header_vvvvvwi.push(temp_vvvvvwi);
	}
	else if (!isSet(add_class_helper_header_vvvvvwi))
	{
		var add_class_helper_header_vvvvvwi = [];
	}
	var add_class_helper_header = add_class_helper_header_vvvvvwi.some(add_class_helper_header_vvvvvwi_SomeFunc);

	if (isSet(add_class_helper_vvvvvwi) && add_class_helper_vvvvvwi.constructor !== Array)
	{
		var temp_vvvvvwi = add_class_helper_vvvvvwi;
		var add_class_helper_vvvvvwi = [];
		add_class_helper_vvvvvwi.push(temp_vvvvvwi);
	}
	else if (!isSet(add_class_helper_vvvvvwi))
	{
		var add_class_helper_vvvvvwi = [];
	}
	var add_class_helper = add_class_helper_vvvvvwi.some(add_class_helper_vvvvvwi_SomeFunc);


	// set this function logic
	if (add_class_helper_header && add_class_helper)
	{
		jQuery('#jform_class_helper_header-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_class_helper_header-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwi Some function
function add_class_helper_header_vvvvvwi_SomeFunc(add_class_helper_header_vvvvvwi)
{
	// set the function logic
	if (add_class_helper_header_vvvvvwi == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvwi Some function
function add_class_helper_vvvvvwi_SomeFunc(add_class_helper_vvvvvwi)
{
	// set the function logic
	if (add_class_helper_vvvvvwi == 1 || add_class_helper_vvvvvwi == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvwk function
function vvvvvwk(update_server_target_vvvvvwk,add_update_server_vvvvvwk)
{
	// set the function logic
	if (update_server_target_vvvvvwk == 1 && add_update_server_vvvvvwk == 1)
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

// the vvvvvwl function
function vvvvvwl(add_update_server_vvvvvwl,update_server_target_vvvvvwl)
{
	// set the function logic
	if (add_update_server_vvvvvwl == 1 && update_server_target_vvvvvwl == 1)
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

// the vvvvvwm function
function vvvvvwm(update_server_target_vvvvvwm,add_update_server_vvvvvwm)
{
	// set the function logic
	if (update_server_target_vvvvvwm == 2 && add_update_server_vvvvvwm == 1)
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').hide();
	}
}

// the vvvvvwo function
function vvvvvwo(update_server_target_vvvvvwo,add_update_server_vvvvvwo)
{
	// set the function logic
	if (update_server_target_vvvvvwo == 3 && add_update_server_vvvvvwo == 1)
	{
		jQuery('.note_update_server_note_other').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_other').closest('.control-group').hide();
	}
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
}


jQuery(document).ready(function() {
	// get the linked details
	getLinked();
	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 300);
});

function setModuleCode() {
	var selected_get =  jQuery("#jform_add_class_helper  option:selected").val();
	var custom_gets =  jQuery("#jform_custom_get").val();
	var libraries =  jQuery("#jform_libraries").val();
	var values = {'class': selected_get, 'get': custom_gets, 'lib': libraries};
	var editor_id = 'jform_mod_code';
	getCodeFrom_server(1, JSON.stringify(values), 'data', 'getModuleCode').then(function(result) {
		if(result.tmpl){
			 addCodeToEditor(result.tmpl.code, editor_id, result.tmpl.merge, result.tmpl.merge_target);
		}
		if(result.css){
			 addCodeToEditor(result.css.code, editor_id, result.css.merge, result.css.merge_target);
		}
		if(result.class){
			 addCodeToEditor(result.class.code, editor_id, result.class.merge, result.class.merge_target);
		}
		if(result.get){
			 addCodeToEditor(result.get.code, editor_id, result.get.merge, result.get.merge_target);
		}
		if(result.lib){
			 addCodeToEditor(result.lib.code, editor_id, result.lib.merge, result.lib.merge_target);
		}
	});
}

function getLinked() {
	getCodeFrom_server(1, 'type', 'type', 'getLinked').then(function(result) {
		if (result.error) {
			console.error(result.error);
		} else if (result) {
			document.getElementById('display_linked_to').innerHTML = result;
		}
	});
}

function getCodeFrom_server(id, type, type_name, callingName) {
	var url = "index.php?option=com_componentbuilder&task=ajax." + callingName + "&format=json&raw=true&vdm="+vastDevMod;
	if (token.length > 0 && id > 0 && type.length > 0) {
		url += '&' + token + '=1&' + type_name + '=' + type + '&id=' + id;
	}
	var getUrl = JRouter(url);
	return fetch(getUrl, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function(response) {
		if (response.ok) {
			return response.json();
		} else {
			throw new Error('Network response was not ok');
		}
	}).then(function(data) {
		return data;
	}).catch(function(error) {
		console.error('There was a problem with the fetch operation:', error);
	});
}

function addCodeToEditor(code_string, editor_id, merge, merge_target){
	if (Joomla.editors.instances.hasOwnProperty(editor_id)) {
		var old_code_string = Joomla.editors.instances[editor_id].getValue();
		if (merge && old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) == -1)  {
				if ('prepend' === merge_target) {
					var _string = code_string + "\n\n" + old_code_string;
				} else if (merge_target && 'append' !== merge_target) {
					var old_code_array = old_code_string.split(merge_target);
					if (old_code_array.length > 1) {
						var _string = old_code_array.shift() + "\n\n" + code_string + "\n\n" + merge_target + old_code_array.join(merge_target);
					} else {
						var _string = code_string + "\n\n" + merge_target + old_code_array.join('');
					}
				} else {
					var _string = old_code_string + "\n\n" + code_string;
				}
				Joomla.editors.instances[editor_id].setValue(_string.trim());
				return true;
			}
		} else {
			Joomla.editors.instances[editor_id].setValue(code_string.trim());
			return true;
		}
	} else {
		var old_code_string = jQuery('textarea#'+editor_id).val();
		if (merge && old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) == -1) {
				if ('prepend' === merge_target) {
					var _string = code_string + "\n\n" + old_code_string;
				} else if (merge_target && 'append' !== merge_target) {
					var old_code_array = old_code_string.split(merge_target);
					if (old_code_array.length > 1) {
						var _string = old_code_array.shift() + "\n\n" + code_string + "\n\n" + merge_target + old_code_array.join(merge_target);
					} else {
						var _string = code_string + "\n\n" + merge_target + old_code_array.join('');
					}
				} else {
					var _string = old_code_string + "\n\n" + code_string;
				}
				jQuery('textarea#'+editor_id).val(_string.trim());
				return true;
			}
		} else {
			jQuery('textarea#'+editor_id).val(code_string.trim());
			return true;
		}
	}
	return false;
}


function removeCodeFromEditor(code_string, editor_id){
	if (Joomla.editors.instances.hasOwnProperty(editor_id)) {
		var old_code_string = Joomla.editors.instances[editor_id].getValue();
		if (old_code_string.length > 0) {
			// make sure string is found
			if (old_code_string.indexOf(code_string) !== -1) {
				// remove the code
				Joomla.editors.instances[editor_id].setValue(old_code_string.replace(code_string+"\n\n",'').replace("\n\n"+code_string,'').replace(code_string,''));
				return true;
			}
		}
	} else {
		var old_code_string = jQuery('textarea#'+editor_id).val();
		if (old_code_string.length > 0) {
			// make sure string is found
			if (old_code_string.indexOf(code_string) !== -1) {
				// remove the code
				jQuery('textarea#'+editor_id).val(old_code_string.replace(code_string+"\n\n",'').replace("\n\n"+code_string,'').replace(code_string,''));
				return true;
			}
		}
	}
	return false;
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

function getSnippetDetails(id){
	getCodeFrom_server(id, '_type', '_type', 'snippetDetails').then(function(result) {
		if(result.snippet){
			var description = '';
			if (result.description.length > 0) {
				description = '<p>'+result.description+'</p>';
			}
			var library = '';
			if (result.library.length > 0) {
				library = ' <b>('+result.library+')</b>';
			}
			var code = '<div id="snippet-code"><b>'+result.name+' ('+result.type+')</b> <a href="'+result.url+'" target="_blank" >see more details'+library+'</a><br /><em>'+result.heading+'</em><br /><textarea  id="snippet" class="span12" rows="11">'+result.snippet+'</textarea></div>';
			jQuery('#snippet-code').remove();
			jQuery('.snippet-code').append(code);
			// make sure the code block is active
			jQuery("#snippet").focus(function() {
				var jQuerythis = jQuery(this);
				jQuerythis.select();
			
				// Work around Chrome's little problem
				jQuerythis.mouseup(function() {
					// Prevent further mouseup intervention
					jQuerythis.unbind("mouseup");
					return false;
				});
			});
		}
		if(result.usage){
			var usage = '<div id="snippet-usage"><p>'+result.usage+'</p></div>';
			jQuery('#snippet-usage').remove();
			jQuery('.snippet-usage').append(usage);
		}
	})
}

// set snippets that are on the page
var snippetIds = [];
var snippets = {};
var snippet = 0;
jQuery(document).ready(function($)
{
	jQuery("#jform_snippet option").each(function()
	{
		var key =  jQuery(this).val();
		var text =  jQuery(this).text();
		snippets[key] = text;
		snippetIds.push(key);
	});
	snippet = jQuery("#jform_snippet").val();
	getSnippets();
});

function getSnippets(){
	jQuery("#loading").show();
	// clear the selection
	jQuery('#jform_snippet').find('option').remove().end();
	jQuery('#jform_snippet').trigger('liszt:updated');
	// get libraries value if set
	var libraries = jQuery("#jform_libraries").val();
	if (libraries) {
		getCodeFrom_server(1, JSON.stringify(libraries), 'libraries', 'getSnippets').then(function(result) {
			setSnippets(result);
			jQuery("#loading").hide();
			if (typeof snippetButton !== 'undefined') {
				// ensure button is correct
				var snippet = jQuery('#jform_snippet').val();
				snippetButton(snippet);
			}
		});
	}
	else
	{
		// load all snippets in none is selected
		setSnippets(snippetIds);
		jQuery("#loading").hide();
	}
}
function setSnippets(array){
	if (array) {
		jQuery('#jform_snippet').append('<option value="">'+select_a_snippet+'</option>');
		jQuery.each( array, function( i, id ) {
			if (id in snippets) {
				jQuery('#jform_snippet').append('<option value="'+id+'">'+snippets[id]+'</option>');
			}
			if (id == snippet) {
				jQuery('#jform_snippet').val(id);
			}
		});
	} else {
		jQuery('#jform_snippet').append('<option value="">'+create_a_snippet+'</option>');
	}
	jQuery('#jform_snippet').trigger('liszt:updated');
}
