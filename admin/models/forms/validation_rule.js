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

function getEditCustomCodeButtons_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id+'&return_here='+return_here;
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
				jQuery('<div class="control-group"><div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
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
