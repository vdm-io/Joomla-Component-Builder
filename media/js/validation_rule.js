/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */




jQuery(document).ready(function()
{
	// get the rule name
	var ruleName = jQuery('#jform_name').val();
	// check if this rule name is taken
	checkRuleName(ruleName);

	// get type value
	var rulefilename = jQuery("#jform_inherit option:selected").val();
	if(jQuery('#jform_php').length == 0) {
		getExistingValidationRuleCode(rulefilename);
	}

	// load the used in div
	// jQuery('#usedin').show();

	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 300);
});

function getExistingValidationRuleCode_server(rulefilename){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getExistingValidationRuleCode&format=json&raw=true");
	if(token.length > 0 && rulefilename.length > 0){
		var request = token+'=1&name='+rulefilename;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getExistingValidationRuleCode(rulefilename,setValue){
	getExistingValidationRuleCode_server(rulefilename).done(function(result) {
		if(result.values){
			jQuery('textarea#jform_php').val(result.values);
		}
	})
}

function checkRuleName(ruleName) {
	if (ruleName.length > 2) {
		var ide = jQuery('#jform_id').val();
		if (ide == 0) {
			ide = -1;
		}
		checkRuleName_server(ruleName, ide).done(function(result) {
			if(result.name && result.message){
				// show notice that functioName is okay
				jQuery.UIkit.notify({message: result.message, timeout: result.timeout, status: result.status, pos: 'top-right'});
				jQuery('#jform_name').val(result.name);
				// now start search for where the function is used
				usedin(result.name, ide);
			} else if(result.message){
				// show notice that ruleName is not okay
				jQuery.UIkit.notify({message: result.message, timeout: result.timeout, status: result.status, pos: 'top-right'});
				jQuery('#jform_name').val('');
			} else {
				// set an error that message was not send
				jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_VALIDATION_RULE_NAME_ALREADY_TAKEN_PLEASE_TRY_AGAIN'), timeout: 7000, status: 'danger', pos: 'top-right'});
				jQuery('#jform_name').val('');
			}
		});
	} else {
		// set an error that message was not send
		jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_YOU_MUST_ADD_AN_UNIQUE_VALIDATION_RULE_NAME'), timeout: 5000, status: 'danger', pos: 'top-right'});
		jQuery('#jform_name').val('');
	}
}
// check Function Name
function checkRuleName_server(ruleName, ide){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.checkRuleName&format=json&raw=true");
	if(token.length > 0){
		var request = token+'=1&name='+ruleName+'&id='+ide;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
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
