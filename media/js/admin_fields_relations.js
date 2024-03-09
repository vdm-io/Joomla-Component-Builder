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
	// check and load all the customcode edit buttons
	getEditCustomCodeButtons();
});
// little script to set the value
function getCodeGlueOptions(field) {
	// get the ID
	var id = jQuery(field).attr('id');
	var target = id.split('__');
	//set the subID
	var subID = target[0]+'__'+target[1];
	// get listfield value
	var listfield = jQuery('#'+subID+'__listfield').val();
	// get type value
	var type = jQuery('#'+subID+'__join_type').val();
	// get area value
	var area = jQuery('#'+subID+'__area').val();
	// check that values are set
	if (_isSet(listfield) && _isSet(type) && _isSet(area)) {
		// get joinfields values
		var joinfields = jQuery('#'+subID+'__joinfields').val();
		// get codeGlueOptions
		getCodeGlueOptions_server(listfield, joinfields, type, area).done(function(result) {
			if(result){
				jQuery('#'+subID+'__set').val(result);
			} else {
				jQuery('#'+subID+'__set').val('');
			}
		});
	} else {
		jQuery('#'+subID+'__set').val('');
	}
}

function getCodeGlueOptions_server(listfield, joinfields, type, area){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getCodeGlueOptions&format=json");
	// make sure the joinfields are set
	if (!_isSet(joinfields)) {
		joinfields = 'none';
	}
	if(token.length > 0 && listfield > 0 && type > 0 && area > 0) {
		var request = token+'=1&listfield='+listfield+'&type='+type+'&area='+area+'&joinfields='+joinfields;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

// the isSet function
function _isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
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

