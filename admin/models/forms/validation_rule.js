/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.7.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		validation_rule.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/




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
});

function getExistingValidationRuleCode_server(rulefilename){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getExistingValidationRuleCode&format=json";
	if(token.length > 0 && rulefilename.length > 0){
		var request = 'token='+token+'&name='+rulefilename;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.checkRuleName&format=json";
	if(token.length > 0){
		var request = 'token='+token+'&name='+ruleName+'&id='+ide;
	}
	return jQuery.ajax({
		type: 'POST',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
} 
