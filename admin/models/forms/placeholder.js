/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */




jQuery(document).ready(function()
{
	jQuery('#placedin').show();
	var placeholderName = jQuery('#jform_target').val();
	// check if this function name is taken
	checkPlaceholderName(placeholderName);
});
function setPlaceholderName(){
	// noting for now (we may add more functionality later)
}

function checkPlaceholderName(placeholderName) {
	if (placeholderName.length > 2) {
		var ide = jQuery('#jform_id').val();
		if (ide == 0) {
			ide = -1;
		}
		checkPlaceholderName_server(placeholderName, ide).done(function(result) {
			if(result.name && result.message){
				// show notice that placeholderName is okay
				jQuery.UIkit.notify({message: result.message, timeout: 5000, status: result.status, pos: 'top-right'});
				jQuery('#jform_target').val(result.name);
				// now start search for where the function is used
				placedin(result.name, ide);
			} else if(result.message){
				// show notice that placeholderName is not okay
				jQuery.UIkit.notify({message: result.message, timeout: 5000, status: result.status, pos: 'top-right'});
				jQuery('#jform_target').val('');
			} else {
				// set an error that message was not send
				jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_PLACEHOLDER_ALREADY_TAKEN_PLEASE_TRY_AGAIN'), timeout: 5000, status: 'danger', pos: 'top-right'});
				jQuery('#jform_target').val('');
			}
			// set custom code placeholder
			setPlaceholderName();
		});
	} else {
		// set an error that message was not send
		jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_YOU_MUST_ADD_AN_UNIQUE_PLACEHOLDER'), timeout: 5000, status: 'danger', pos: 'top-right'});
		jQuery('#jform_target').val('');
		// set custom code placeholder
		setPlaceholderName();
	}
}
// check Placeholder
function checkPlaceholderName_server(placeholderName, ide){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.checkPlaceholderName&raw=true&format=json";
	if(token.length > 0){
		var request = 'token='+token+'&placeholderName='+placeholderName+'&id='+ide;
	}
	return jQuery.ajax({
		type: 'POST',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}


// check where this Function is used
function placedin(placeholder, ide) {
	var found = false;
	jQuery('#before-placedin').hide();
	jQuery('#note-placedin-not').hide();
	jQuery('#note-placedin-found').hide();
	jQuery('#loading-placedin').show();
	var targets = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u']; // if you update this, also update (below 20) & [customcode-codeUsedInHtmlNote]!
	var targetNumber = 20;
	var run = 0;
	var placedinChecker = setInterval(function(){ 
		var target = targets[run];
		placedin_server(placeholder, ide, target).done(function(used) {
			if (used.in) {
				jQuery('#placedin-'+used.id).show();
				jQuery('#area-'+used.id).html(used.in);
				jQuery.UIkit.notify({message: used.in, timeout: 5000, status: 'success', pos: 'top-right'});
				found = true;
			} else {
				jQuery('#placedin-'+target).hide();
			}
			if (run == targetNumber) {
				jQuery('#loading-placedin').hide();
				if (found) {
					jQuery('#note-placedin-found').show();
				} else {
					jQuery('#note-placedin-not').show();
				}
			}
		});
		if (run == targetNumber) {
			clearInterval(placedinChecker);
		}
		run++;
	}, 800);
}
function placedin_server(placeholder, ide, target){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.placedin&format=json";
	if(token.length > 0){
		var request = token+'=1&placeholder='+placeholder+'&id='+ide+'&target='+target+'&raw=true&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
 
