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
jform_vvvvwdzvyd_required = false;
jform_vvvvwdzvye_required = false;
jform_vvvvwdzvyf_required = false;
jform_vvvvwdzvyg_required = false;
jform_vvvvwdzvyh_required = false;
jform_vvvvweavyi_required = false;
jform_vvvvwebvyj_required = false;
jform_vvvvwedvyk_required = false;
jform_vvvvwefvyl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwdz = jQuery("#jform_protocol").val();
	vvvvwdz(protocol_vvvvwdz);

	var protocol_vvvvwea = jQuery("#jform_protocol").val();
	vvvvwea(protocol_vvvvwea);

	var protocol_vvvvweb = jQuery("#jform_protocol").val();
	var authentication_vvvvweb = jQuery("#jform_authentication").val();
	vvvvweb(protocol_vvvvweb,authentication_vvvvweb);

	var protocol_vvvvwed = jQuery("#jform_protocol").val();
	var authentication_vvvvwed = jQuery("#jform_authentication").val();
	vvvvwed(protocol_vvvvwed,authentication_vvvvwed);

	var protocol_vvvvwef = jQuery("#jform_protocol").val();
	var authentication_vvvvwef = jQuery("#jform_authentication").val();
	vvvvwef(protocol_vvvvwef,authentication_vvvvwef);

	var protocol_vvvvweh = jQuery("#jform_protocol").val();
	var authentication_vvvvweh = jQuery("#jform_authentication").val();
	vvvvweh(protocol_vvvvweh,authentication_vvvvweh);
});

// the vvvvwdz function
function vvvvwdz(protocol_vvvvwdz)
{
	if (isSet(protocol_vvvvwdz) && protocol_vvvvwdz.constructor !== Array)
	{
		var temp_vvvvwdz = protocol_vvvvwdz;
		var protocol_vvvvwdz = [];
		protocol_vvvvwdz.push(temp_vvvvwdz);
	}
	else if (!isSet(protocol_vvvvwdz))
	{
		var protocol_vvvvwdz = [];
	}
	var protocol = protocol_vvvvwdz.some(protocol_vvvvwdz_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwdzvyd_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwdzvyd_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwdzvye_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwdzvye_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwdzvyf_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwdzvyf_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwdzvyg_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwdzvyg_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwdzvyh_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwdzvyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwdzvyd_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwdzvyd_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwdzvye_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwdzvye_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwdzvyf_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwdzvyf_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwdzvyg_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwdzvyg_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwdzvyh_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwdzvyh_required = true;
		}
	}
}

// the vvvvwdz Some function
function protocol_vvvvwdz_SomeFunc(protocol_vvvvwdz)
{
	// set the function logic
	if (protocol_vvvvwdz == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwea function
function vvvvwea(protocol_vvvvwea)
{
	if (isSet(protocol_vvvvwea) && protocol_vvvvwea.constructor !== Array)
	{
		var temp_vvvvwea = protocol_vvvvwea;
		var protocol_vvvvwea = [];
		protocol_vvvvwea.push(temp_vvvvwea);
	}
	else if (!isSet(protocol_vvvvwea))
	{
		var protocol_vvvvwea = [];
	}
	var protocol = protocol_vvvvwea.some(protocol_vvvvwea_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvweavyi_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvweavyi_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvweavyi_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvweavyi_required = true;
		}
	}
}

// the vvvvwea Some function
function protocol_vvvvwea_SomeFunc(protocol_vvvvwea)
{
	// set the function logic
	if (protocol_vvvvwea == 1)
	{
		return true;
	}
	return false;
}

// the vvvvweb function
function vvvvweb(protocol_vvvvweb,authentication_vvvvweb)
{
	if (isSet(protocol_vvvvweb) && protocol_vvvvweb.constructor !== Array)
	{
		var temp_vvvvweb = protocol_vvvvweb;
		var protocol_vvvvweb = [];
		protocol_vvvvweb.push(temp_vvvvweb);
	}
	else if (!isSet(protocol_vvvvweb))
	{
		var protocol_vvvvweb = [];
	}
	var protocol = protocol_vvvvweb.some(protocol_vvvvweb_SomeFunc);

	if (isSet(authentication_vvvvweb) && authentication_vvvvweb.constructor !== Array)
	{
		var temp_vvvvweb = authentication_vvvvweb;
		var authentication_vvvvweb = [];
		authentication_vvvvweb.push(temp_vvvvweb);
	}
	else if (!isSet(authentication_vvvvweb))
	{
		var authentication_vvvvweb = [];
	}
	var authentication = authentication_vvvvweb.some(authentication_vvvvweb_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwebvyj_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwebvyj_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwebvyj_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwebvyj_required = true;
		}
	}
}

// the vvvvweb Some function
function protocol_vvvvweb_SomeFunc(protocol_vvvvweb)
{
	// set the function logic
	if (protocol_vvvvweb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvweb Some function
function authentication_vvvvweb_SomeFunc(authentication_vvvvweb)
{
	// set the function logic
	if (authentication_vvvvweb == 1 || authentication_vvvvweb == 3 || authentication_vvvvweb == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwed function
function vvvvwed(protocol_vvvvwed,authentication_vvvvwed)
{
	if (isSet(protocol_vvvvwed) && protocol_vvvvwed.constructor !== Array)
	{
		var temp_vvvvwed = protocol_vvvvwed;
		var protocol_vvvvwed = [];
		protocol_vvvvwed.push(temp_vvvvwed);
	}
	else if (!isSet(protocol_vvvvwed))
	{
		var protocol_vvvvwed = [];
	}
	var protocol = protocol_vvvvwed.some(protocol_vvvvwed_SomeFunc);

	if (isSet(authentication_vvvvwed) && authentication_vvvvwed.constructor !== Array)
	{
		var temp_vvvvwed = authentication_vvvvwed;
		var authentication_vvvvwed = [];
		authentication_vvvvwed.push(temp_vvvvwed);
	}
	else if (!isSet(authentication_vvvvwed))
	{
		var authentication_vvvvwed = [];
	}
	var authentication = authentication_vvvvwed.some(authentication_vvvvwed_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwedvyk_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwedvyk_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwedvyk_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwedvyk_required = true;
		}
	}
}

// the vvvvwed Some function
function protocol_vvvvwed_SomeFunc(protocol_vvvvwed)
{
	// set the function logic
	if (protocol_vvvvwed == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwed Some function
function authentication_vvvvwed_SomeFunc(authentication_vvvvwed)
{
	// set the function logic
	if (authentication_vvvvwed == 2 || authentication_vvvvwed == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwef function
function vvvvwef(protocol_vvvvwef,authentication_vvvvwef)
{
	if (isSet(protocol_vvvvwef) && protocol_vvvvwef.constructor !== Array)
	{
		var temp_vvvvwef = protocol_vvvvwef;
		var protocol_vvvvwef = [];
		protocol_vvvvwef.push(temp_vvvvwef);
	}
	else if (!isSet(protocol_vvvvwef))
	{
		var protocol_vvvvwef = [];
	}
	var protocol = protocol_vvvvwef.some(protocol_vvvvwef_SomeFunc);

	if (isSet(authentication_vvvvwef) && authentication_vvvvwef.constructor !== Array)
	{
		var temp_vvvvwef = authentication_vvvvwef;
		var authentication_vvvvwef = [];
		authentication_vvvvwef.push(temp_vvvvwef);
	}
	else if (!isSet(authentication_vvvvwef))
	{
		var authentication_vvvvwef = [];
	}
	var authentication = authentication_vvvvwef.some(authentication_vvvvwef_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwefvyl_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwefvyl_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwefvyl_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwefvyl_required = true;
		}
	}
}

// the vvvvwef Some function
function protocol_vvvvwef_SomeFunc(protocol_vvvvwef)
{
	// set the function logic
	if (protocol_vvvvwef == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwef Some function
function authentication_vvvvwef_SomeFunc(authentication_vvvvwef)
{
	// set the function logic
	if (authentication_vvvvwef == 4 || authentication_vvvvwef == 5)
	{
		return true;
	}
	return false;
}

// the vvvvweh function
function vvvvweh(protocol_vvvvweh,authentication_vvvvweh)
{
	if (isSet(protocol_vvvvweh) && protocol_vvvvweh.constructor !== Array)
	{
		var temp_vvvvweh = protocol_vvvvweh;
		var protocol_vvvvweh = [];
		protocol_vvvvweh.push(temp_vvvvweh);
	}
	else if (!isSet(protocol_vvvvweh))
	{
		var protocol_vvvvweh = [];
	}
	var protocol = protocol_vvvvweh.some(protocol_vvvvweh_SomeFunc);

	if (isSet(authentication_vvvvweh) && authentication_vvvvweh.constructor !== Array)
	{
		var temp_vvvvweh = authentication_vvvvweh;
		var authentication_vvvvweh = [];
		authentication_vvvvweh.push(temp_vvvvweh);
	}
	else if (!isSet(authentication_vvvvweh))
	{
		var authentication_vvvvweh = [];
	}
	var authentication = authentication_vvvvweh.some(authentication_vvvvweh_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_secret').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_secret').closest('.control-group').hide();
	}
}

// the vvvvweh Some function
function protocol_vvvvweh_SomeFunc(protocol_vvvvweh)
{
	// set the function logic
	if (protocol_vvvvweh == 2)
	{
		return true;
	}
	return false;
}

// the vvvvweh Some function
function authentication_vvvvweh_SomeFunc(authentication_vvvvweh)
{
	// set the function logic
	if (authentication_vvvvweh == 2 || authentication_vvvvweh == 3 || authentication_vvvvweh == 4 || authentication_vvvvweh == 5)
	{
		return true;
	}
	return false;
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (jQuery('#jform_not_required').length > 0) {
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
