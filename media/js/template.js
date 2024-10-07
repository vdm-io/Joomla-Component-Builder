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
	var add_php_view_vvvvvze = jQuery("#jform_add_php_view input[type='radio']:checked").val();
	vvvvvze(add_php_view_vvvvvze);
});

// the vvvvvze function
function vvvvvze(add_php_view_vvvvvze)
{
	// set the function logic
	if (add_php_view_vvvvvze == 1)
	{
		jQuery('#jform_php_view-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_view-lbl').closest('.control-group').hide();
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


document.addEventListener("DOMContentLoaded", function() {
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

function getDynamicValuesServer(dynamicId) {
    var getUrl = 'index.php?option=com_componentbuilder&task=ajax.getDynamicValues&raw=true&format=json';
    if (token.length > 0 && dynamicId > 0) {
        var request = token + '=1&view=template&id=' + dynamicId;
    }

    return fetch(getUrl + '&' + request, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json());
}

function getDynamicValues(id) {
    getDynamicValuesServer(id).then(function(result) {
        if (result) {
            var dynamicValuesElement = document.getElementById('dynamic_values');
            if (dynamicValuesElement) {
                dynamicValuesElement.remove();
            }
            document.querySelector('.dynamic_values').insertAdjacentHTML('beforeend', '<div id="dynamic_values">' + result + '</div>');

            // Event listener for code blocks
            document.querySelectorAll("code").forEach(function(codeBlock) {
                codeBlock.addEventListener("click", function() {
                    codeBlock.selText(); // Call the custom selText function
                    codeBlock.classList.add("selected");  // Add the "selected" class
                });
            });
        }
    }).catch(function(error) {
        console.error('Error fetching dynamic values:', error);
    });
}

function getLayoutDetails_server(id) {
    var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLayoutDetails&format=json&raw=true&vdm=" + vastDevMod);
    var request = '';

    // Ensure token and id are present
    if (token.length > 0 && id > 0) {
        request = token + '=1&id=' + id;
    }

    // Return a fetch promise (fetch does not support JSONP, so I assume the server can return JSON)
    return fetch(getUrl + '&' + request, {
        method: 'GET'
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.json();  // Assuming the server returns JSON
    });
}

function getLayoutDetails(id) {
    getLayoutDetails_server(id)
        .then(function(result) {
            if (result) {
                document.querySelector('#details').insertAdjacentHTML('beforeend', result);

                // Re-enable code block text selection functionality
                document.querySelectorAll("code").forEach(function(codeBlock) {
                    codeBlock.addEventListener("click", function() {
                        codeBlock.selText();
                        codeBlock.classList.add("selected");
                    });
                });
            }
        })
        .catch(function(error) {
            console.error('There was a problem with the fetch operation:', error);
        });
}


function getTemplateDetails(id) {
    getCodeFrom_server(id, 'type', 'type', 'templateDetails').then(function(result) {
        if (result) {
            document.querySelector('#details').insertAdjacentHTML('beforeend', result);

            // Re-enable code block text selection functionality
            document.querySelectorAll("code").forEach(function(codeBlock) {
                codeBlock.addEventListener("click", function() {
                    codeBlock.selText();
                    codeBlock.classList.add("selected");
                });
            });
        }
    });
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
