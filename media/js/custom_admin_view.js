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
	var add_php_view_vvvvvyj = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvyj(add_php_view_vvvvvyj);

	var add_php_jview_display_vvvvvyk = jQuery("#jform_add_php_jview_display input[type='radio']:checked").val();
	vvvvvyk(add_php_jview_display_vvvvvyk);

	var add_php_jview_vvvvvyl = jQuery("#jform_add_php_jview input[type='radio']:checked").val();
	vvvvvyl(add_php_jview_vvvvvyl);

	var add_php_document_vvvvvym = jQuery("#jform_add_php_document input[type='radio']:checked").val();
	vvvvvym(add_php_document_vvvvvym);

	var add_css_document_vvvvvyn = jQuery("#jform_add_css_document input[type='radio']:checked").val();
	vvvvvyn(add_css_document_vvvvvyn);

	var add_javascript_file_vvvvvyo = jQuery("#jform_add_javascript_file input[type='radio']:checked").val();
	vvvvvyo(add_javascript_file_vvvvvyo);

	var add_js_document_vvvvvyp = jQuery("#jform_add_js_document input[type='radio']:checked").val();
	vvvvvyp(add_js_document_vvvvvyp);

	var add_custom_button_vvvvvyq = jQuery("#jform_add_custom_button input[type='radio']:checked").val();
	vvvvvyq(add_custom_button_vvvvvyq);

	var add_css_vvvvvyr = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvyr(add_css_vvvvvyr);

	var add_php_ajax_vvvvvys = jQuery("#jform_add_php_ajax input[type='radio']:checked").val();
	vvvvvys(add_php_ajax_vvvvvys);
});

// the vvvvvyj function
function vvvvvyj(add_php_view_vvvvvyj)
{
	// set the function logic
	if (add_php_view_vvvvvyj == 1)
	{
		jQuery('#jform_php_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_view-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyk function
function vvvvvyk(add_php_jview_display_vvvvvyk)
{
	// set the function logic
	if (add_php_jview_display_vvvvvyk == 1)
	{
		jQuery('#jform_php_jview_display-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_jview_display-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyl function
function vvvvvyl(add_php_jview_vvvvvyl)
{
	// set the function logic
	if (add_php_jview_vvvvvyl == 1)
	{
		jQuery('#jform_php_jview-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_jview-lbl').closest('.control-group').hide();
	}
}

// the vvvvvym function
function vvvvvym(add_php_document_vvvvvym)
{
	// set the function logic
	if (add_php_document_vvvvvym == 1)
	{
		jQuery('#jform_php_document-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_document-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyn function
function vvvvvyn(add_css_document_vvvvvyn)
{
	// set the function logic
	if (add_css_document_vvvvvyn == 1)
	{
		jQuery('#jform_css_document-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_document-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyo function
function vvvvvyo(add_javascript_file_vvvvvyo)
{
	// set the function logic
	if (add_javascript_file_vvvvvyo == 1)
	{
		jQuery('#jform_javascript_file-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript_file-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyp function
function vvvvvyp(add_js_document_vvvvvyp)
{
	// set the function logic
	if (add_js_document_vvvvvyp == 1)
	{
		jQuery('#jform_js_document-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_js_document-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyq function
function vvvvvyq(add_custom_button_vvvvvyq)
{
	// set the function logic
	if (add_custom_button_vvvvvyq == 1)
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').show();
		jQuery('#jform_php_controller-lbl').closest('.control-group').show();
		jQuery('#jform_php_model-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_custom_button-lbl').closest('.control-group').hide();
		jQuery('#jform_php_controller-lbl').closest('.control-group').hide();
		jQuery('#jform_php_model-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyr function
function vvvvvyr(add_css_vvvvvyr)
{
	// set the function logic
	if (add_css_vvvvvyr == 1)
	{
		jQuery('#jform_css-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css-lbl').closest('.control-group').hide();
	}
}

// the vvvvvys function
function vvvvvys(add_php_ajax_vvvvvys)
{
	// set the function logic
	if (add_php_ajax_vvvvvys == 1)
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').show();
		jQuery('#jform_php_ajaxmethod-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_ajax_input-lbl').closest('.control-group').hide();
		jQuery('#jform_php_ajaxmethod-lbl').closest('.control-group').hide();
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


jQuery(document).ready(function()
{
	// get the linked details
	getLinked();
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});

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

function getLinked(){
	getCodeFrom_server(1, 'type', 'type', 'getLinked').then(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
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

function getDynamicValues_server(dynamicId){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getDynamicValues&format=json");
	if(token.length > 0 && dynamicId > 0){
		var request = token+'=1&view=custom_admin_view&id='+dynamicId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getDynamicValues(id){
	getDynamicValues_server(id).done(function(result) {
		if(result){
			jQuery('#dynamic_values').remove();
			jQuery('.dynamic_values').append('<div id="dynamic_values">'+result+'</div>');
			// make sure the code bocks are active
			jQuery("code").click(function() {
				jQuery(this).selText().addClass("selected");
			});
		}
	})
}

function getLayoutDetails_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLayoutDetails&format=json&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getLayoutDetails(id){
	getLayoutDetails_server(id).done(function(result) {
		if(result){
			jQuery('#details').append(result);
			// make sure the code bocks are active
			jQuery("code").click(function() {
				jQuery(this).selText().addClass("selected");
			});
		}
	})
}

function getTemplateDetails(id){
	getCodeFrom_server(id, 'type', 'type', 'templateDetails').then(function(result) {
		if(result){
			jQuery('#details').append(result);
			// make sure the code bocks are active
			jQuery("code").click(function() {
				jQuery(this).selText().addClass("selected");
			});
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
				insertBeforeElement.parentNode.insertBefore(div, insertBeforeElement);

				// Adding buttons to the div
				Object.entries(buttons).forEach(([name, button]) => {
					const controlsDiv = document.querySelector(".control-customcode-buttons-"+field);
					controlsDiv.innerHTML += button;
				});
			});
		}
	}).catch(error => {
		console.error('Error:', error);
	});
}
