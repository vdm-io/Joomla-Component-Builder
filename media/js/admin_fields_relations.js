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

// the isSet function
function _isSet(value) {
	return value !== undefined && value !== null && value !== '';
}

// Function to set the value
function getCodeGlueOptions(field) {
	// Get the ID
	var id = field.id;
	var target = id.split('__');

	// Set the subID
	var subID = target[0] + '__' + target[1];

	// Get listfield value
	var listfield = document.getElementById(subID + '__listfield')?.value || '';
	// Get type value
	var type = document.getElementById(subID + '__join_type')?.value || '';
	// Get area value
	var area = document.getElementById(subID + '__area')?.value || '';

	// Check that values are set
	if (_isSet(listfield) && _isSet(type) && _isSet(area)) {
		// Get joinfields values
		var joinfields = document.getElementById(subID + '__joinfields')?.value || '';

		// Fetch CodeGlueOptions
		getCodeGlueOptions_server(listfield, joinfields, type, area)
			.then(result => {
				document.getElementById(subID + '__set').value = result || '';
			})
			.catch(() => {
				document.getElementById(subID + '__set').value = '';
			});
	} else {
		document.getElementById(subID + '__set').value = '';
	}
}

// Function to fetch data from the server
function getCodeGlueOptions_server(listfield, joinfields, type, area) {
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getCodeGlueOptions&format=json");

	// Ensure joinfields is set
	if (!_isSet(joinfields)) {
		joinfields = 'none';
	}

	if (typeof token !== 'undefined' && token.length > 0 && listfield.length > 0 && type > 0 && area > 0) {
		var params = new URLSearchParams({
			[token]: '1',
			listfield: listfield,
			type: type,
			area: area,
			joinfields: joinfields
		});

		return fetch(getUrl + '&' + params.toString(), {
			method: 'GET',
			headers: {
				'Accept': 'application/json'
			}
		})
			.then(response => response.json())
			.catch(() => null);
	}

	return Promise.resolve(null);
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

