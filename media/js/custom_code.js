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
jform_vvvvwafvwo_required = false;
jform_vvvvwagvwp_required = false;
jform_vvvvwagvwq_required = false;
jform_vvvvwagvwr_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var target_vvvvwaf = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaf(target_vvvvwaf);

	var target_vvvvwag = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwag(target_vvvvwag);

	var target_vvvvwah = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwah = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwah(target_vvvvwah,type_vvvvwah);

	var type_vvvvwai = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvwai = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwai(type_vvvvwai,target_vvvvwai);
});

// the vvvvwaf function
function vvvvwaf(target_vvvvwaf)
{
	// set the function logic
	if (target_vvvvwaf == 2)
	{
		jQuery('#jform_function_name').closest('.control-group').show();
		// add required attribute to function_name field
		if (jform_vvvvwafvwo_required)
		{
			updateFieldRequired('function_name',0);
			jQuery('#jform_function_name').prop('required','required');
			jQuery('#jform_function_name').attr('aria-required',true);
			jQuery('#jform_function_name').addClass('required');
			jform_vvvvwafvwo_required = false;
		}
		jQuery('.note_jcb_placeholder').closest('.control-group').show();
		jQuery('#jform_system_name').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_function_name').closest('.control-group').hide();
		// remove required attribute from function_name field
		if (!jform_vvvvwafvwo_required)
		{
			updateFieldRequired('function_name',1);
			jQuery('#jform_function_name').removeAttr('required');
			jQuery('#jform_function_name').removeAttr('aria-required');
			jQuery('#jform_function_name').removeClass('required');
			jform_vvvvwafvwo_required = true;
		}
		jQuery('.note_jcb_placeholder').closest('.control-group').hide();
		jQuery('#jform_system_name').closest('.control-group').hide();
	}
}

// the vvvvwag function
function vvvvwag(target_vvvvwag)
{
	// set the function logic
	if (target_vvvvwag == 1)
	{
		jQuery('#jform_component').closest('.control-group').show();
		// add required attribute to component field
		if (jform_vvvvwagvwp_required)
		{
			updateFieldRequired('component',0);
			jQuery('#jform_component').prop('required','required');
			jQuery('#jform_component').attr('aria-required',true);
			jQuery('#jform_component').addClass('required');
			jform_vvvvwagvwp_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwagvwq_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwagvwq_required = false;
		}
		jQuery('#jform_from_line').closest('.control-group').show();
		jQuery('#jform_hashtarget').closest('.control-group').show();
		jQuery('#jform_to_line').closest('.control-group').show();
		jQuery('#jform_type').closest('.control-group').show();
		// add required attribute to type field
		if (jform_vvvvwagvwr_required)
		{
			updateFieldRequired('type',0);
			jQuery('#jform_type').prop('required','required');
			jQuery('#jform_type').attr('aria-required',true);
			jQuery('#jform_type').addClass('required');
			jform_vvvvwagvwr_required = false;
		}
	}
	else
	{
		jQuery('#jform_component').closest('.control-group').hide();
		// remove required attribute from component field
		if (!jform_vvvvwagvwp_required)
		{
			updateFieldRequired('component',1);
			jQuery('#jform_component').removeAttr('required');
			jQuery('#jform_component').removeAttr('aria-required');
			jQuery('#jform_component').removeClass('required');
			jform_vvvvwagvwp_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwagvwq_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwagvwq_required = true;
		}
		jQuery('#jform_from_line').closest('.control-group').hide();
		jQuery('#jform_hashtarget').closest('.control-group').hide();
		jQuery('#jform_to_line').closest('.control-group').hide();
		jQuery('#jform_type').closest('.control-group').hide();
		// remove required attribute from type field
		if (!jform_vvvvwagvwr_required)
		{
			updateFieldRequired('type',1);
			jQuery('#jform_type').removeAttr('required');
			jQuery('#jform_type').removeAttr('aria-required');
			jQuery('#jform_type').removeClass('required');
			jform_vvvvwagvwr_required = true;
		}
	}
}

// the vvvvwah function
function vvvvwah(target_vvvvwah,type_vvvvwah)
{
	// set the function logic
	if (target_vvvvwah == 1 && type_vvvvwah == 1)
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

// the vvvvwai function
function vvvvwai(type_vvvvwai,target_vvvvwai)
{
	// set the function logic
	if (type_vvvvwai == 1 && target_vvvvwai == 1)
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


/**
 * Checks where a given function is used by iterating through a list of numeric targets (0–29).
 * For each target, it calls usedin_server() concurrently and updates the UI based on the responses.
 *
 * @param {string} functioName - The functioName parameter to send to the server.
 * @param {string|number} ide - The identifier to send.
 */
function usedin(functioName, ide) {
	let found = false;

	// Helper functions to show/hide elements by ID.
	const hideElement = (id) => {
		const el = document.getElementById(id);
		if (el) {
			el.style.display = 'none';
		}
	};

	const showElement = (id) => {
		const el = document.getElementById(id);
		if (el) {
			el.style.display = 'block';
		}
	};

	// Hide initial UI elements.
	hideElement('before-usedin');
	hideElement('note-usedin-not');
	hideElement('note-usedin-found');
	showElement('loading-usedin');

	// Create a targets array of 30 integers (0 to 29).
	const targets = Array.from({ length: 30 }, (_, i) => i);

	// Map each target to a promise that makes an AJAX call.
	const promises = targets.map((target) => {
		return usedin_server(functioName, ide, target)
			.then((used) => {
				if (used && used.in) {
					// Check if the element with id "usedin-{used.id}" exists.
					let funcElement = document.getElementById('usedin-' + used.id);
					if (!funcElement) {
						// Create the main container div.
						funcElement = document.createElement('div');
						funcElement.id = 'usedin-' + used.id;

						// Create the header element with the area name.
						const header = document.createElement('h2');
						header.textContent = used.area_name;

						// Create the inner div element that will contain the result.
						const innerDiv = document.createElement('div');
						innerDiv.id = 'area-' + used.id;

						// Append the header and inner div to the main element.
						funcElement.appendChild(header);
						funcElement.appendChild(innerDiv);

						// Append this element to the container with id "usedin-targets".
						const container = document.getElementById('usedin-targets');
						if (container) {
							container.appendChild(funcElement);
						} else {
							console.error(
								"Container with id 'usedin-targets' not found. Appending to document.body instead."
							);
						}
					}

					// Ensure the element is visible.
					showElement('usedin-' + used.id);

					// Update the inner div's content with the response.
					const areaEl = document.getElementById('area-' + used.id);
					if (areaEl) {
						areaEl.innerHTML = used.in;
					}

					// Notify the user using UIkit.notification if available, otherwise log to the console.
					if (typeof UIkit !== 'undefined' && UIkit.notify) {
						UIkit.notify({
							message: used.in,
							timeout: 5000,
							status: 'success',
							pos: 'top-right'
						});
					} else {
						console.log('Notification:', used.in);
					}
					found = true;
				} else {
					// If no valid response, hide the element with id "usedin-{target}".
					hideElement('usedin-' + target);
				}
			})
			.catch((error) => {
				console.error('Error in usedin_server for target ' + target + ':', error);
			});
	});

	// Once all Ajax calls are completed, update the UI accordingly.
	Promise.all(promises).then(() => {
		hideElement('loading-usedin');
		if (found) {
			showElement('note-usedin-found');
		} else {
			showElement('note-usedin-not');
		}
	});
}

/**
 * Sends an AJAX GET request to the server with the specified parameters.
 * The function builds a URL with query parameters and returns a promise
 * that resolves with the JSON response.
 *
 * @param {string} functioName - The functioName to send with the request.
 * @param {string|number} ide - The identifier to send.
 * @param {string|number} target - The target functioName to send.
 *
 * @returns {Promise<Object>} - A promise that resolves to the JSON response.
 */
function usedin_server(functioName, ide, target) {
	// Check if the global variable 'token' exists and has a non-empty functioName.
	// 'token', 'functioName', and 'return_here' are assumed to be defined elsewhere in your code.
	if (token && token.length > 0) {
		var request =
			token +
			'=1&functioName=' +
			functioName +
			'&id=' +
			ide +
			'&target=' +
			target +
			'&raw=true&return_here=' +
			return_here;
	} else {
		console.error(
			'There was a issue with the functioNames passed to the [usedin_server] method and we could not make the Ajax call.'
		);
		return Promise.reject(new Error('Invalid token or parameters.'));
	}

	// Base URL for the AJAX request.
	const baseUrl = `index.php?option=com_componentbuilder&task=ajax.usedin&format=json&${request}`;

	// Use the Fetch API to perform a GET request.
	return fetch(baseUrl, {
		method: "GET",
		headers: {
			"Accept": "application/json"
		}
	}).then(response => {
		if (!response.ok) {
			throw new Error(`HTTP error! Status: ${response.status}`);
		}
		return response.json();
	});
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
