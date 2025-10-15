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
jform_vvvvwcjvxj_required = false;
jform_vvvvwcjvxk_required = false;
jform_vvvvwcjvxl_required = false;
jform_vvvvwcjvxm_required = false;
jform_vvvvwcjvxn_required = false;
jform_vvvvwckvxo_required = false;
jform_vvvvwclvxp_required = false;
jform_vvvvwcnvxq_required = false;
jform_vvvvwcpvxr_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var protocol_vvvvwcj = jQuery("#jform_protocol").val();
	vvvvwcj(protocol_vvvvwcj);

	var protocol_vvvvwck = jQuery("#jform_protocol").val();
	vvvvwck(protocol_vvvvwck);

	var protocol_vvvvwcl = jQuery("#jform_protocol").val();
	var authentication_vvvvwcl = jQuery("#jform_authentication").val();
	vvvvwcl(protocol_vvvvwcl,authentication_vvvvwcl);

	var protocol_vvvvwcn = jQuery("#jform_protocol").val();
	var authentication_vvvvwcn = jQuery("#jform_authentication").val();
	vvvvwcn(protocol_vvvvwcn,authentication_vvvvwcn);

	var protocol_vvvvwcp = jQuery("#jform_protocol").val();
	var authentication_vvvvwcp = jQuery("#jform_authentication").val();
	vvvvwcp(protocol_vvvvwcp,authentication_vvvvwcp);

	var protocol_vvvvwcr = jQuery("#jform_protocol").val();
	var authentication_vvvvwcr = jQuery("#jform_authentication").val();
	vvvvwcr(protocol_vvvvwcr,authentication_vvvvwcr);
});

// the vvvvwcj function
function vvvvwcj(protocol_vvvvwcj)
{
	if (isSet(protocol_vvvvwcj) && protocol_vvvvwcj.constructor !== Array)
	{
		var temp_vvvvwcj = protocol_vvvvwcj;
		var protocol_vvvvwcj = [];
		protocol_vvvvwcj.push(temp_vvvvwcj);
	}
	else if (!isSet(protocol_vvvvwcj))
	{
		var protocol_vvvvwcj = [];
	}
	var protocol = protocol_vvvvwcj.some(protocol_vvvvwcj_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwcjvxj_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwcjvxj_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwcjvxk_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwcjvxk_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwcjvxl_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwcjvxl_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwcjvxm_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwcjvxm_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwcjvxn_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwcjvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwcjvxj_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwcjvxj_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwcjvxk_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwcjvxk_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwcjvxl_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwcjvxl_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwcjvxm_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwcjvxm_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwcjvxn_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwcjvxn_required = true;
		}
	}
}

// the vvvvwcj Some function
function protocol_vvvvwcj_SomeFunc(protocol_vvvvwcj)
{
	// set the function logic
	if (protocol_vvvvwcj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwck function
function vvvvwck(protocol_vvvvwck)
{
	if (isSet(protocol_vvvvwck) && protocol_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = protocol_vvvvwck;
		var protocol_vvvvwck = [];
		protocol_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(protocol_vvvvwck))
	{
		var protocol_vvvvwck = [];
	}
	var protocol = protocol_vvvvwck.some(protocol_vvvvwck_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwckvxo_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwckvxo_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwckvxo_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwckvxo_required = true;
		}
	}
}

// the vvvvwck Some function
function protocol_vvvvwck_SomeFunc(protocol_vvvvwck)
{
	// set the function logic
	if (protocol_vvvvwck == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcl function
function vvvvwcl(protocol_vvvvwcl,authentication_vvvvwcl)
{
	if (isSet(protocol_vvvvwcl) && protocol_vvvvwcl.constructor !== Array)
	{
		var temp_vvvvwcl = protocol_vvvvwcl;
		var protocol_vvvvwcl = [];
		protocol_vvvvwcl.push(temp_vvvvwcl);
	}
	else if (!isSet(protocol_vvvvwcl))
	{
		var protocol_vvvvwcl = [];
	}
	var protocol = protocol_vvvvwcl.some(protocol_vvvvwcl_SomeFunc);

	if (isSet(authentication_vvvvwcl) && authentication_vvvvwcl.constructor !== Array)
	{
		var temp_vvvvwcl = authentication_vvvvwcl;
		var authentication_vvvvwcl = [];
		authentication_vvvvwcl.push(temp_vvvvwcl);
	}
	else if (!isSet(authentication_vvvvwcl))
	{
		var authentication_vvvvwcl = [];
	}
	var authentication = authentication_vvvvwcl.some(authentication_vvvvwcl_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwclvxp_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwclvxp_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwclvxp_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwclvxp_required = true;
		}
	}
}

// the vvvvwcl Some function
function protocol_vvvvwcl_SomeFunc(protocol_vvvvwcl)
{
	// set the function logic
	if (protocol_vvvvwcl == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcl Some function
function authentication_vvvvwcl_SomeFunc(authentication_vvvvwcl)
{
	// set the function logic
	if (authentication_vvvvwcl == 1 || authentication_vvvvwcl == 3 || authentication_vvvvwcl == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwcn function
function vvvvwcn(protocol_vvvvwcn,authentication_vvvvwcn)
{
	if (isSet(protocol_vvvvwcn) && protocol_vvvvwcn.constructor !== Array)
	{
		var temp_vvvvwcn = protocol_vvvvwcn;
		var protocol_vvvvwcn = [];
		protocol_vvvvwcn.push(temp_vvvvwcn);
	}
	else if (!isSet(protocol_vvvvwcn))
	{
		var protocol_vvvvwcn = [];
	}
	var protocol = protocol_vvvvwcn.some(protocol_vvvvwcn_SomeFunc);

	if (isSet(authentication_vvvvwcn) && authentication_vvvvwcn.constructor !== Array)
	{
		var temp_vvvvwcn = authentication_vvvvwcn;
		var authentication_vvvvwcn = [];
		authentication_vvvvwcn.push(temp_vvvvwcn);
	}
	else if (!isSet(authentication_vvvvwcn))
	{
		var authentication_vvvvwcn = [];
	}
	var authentication = authentication_vvvvwcn.some(authentication_vvvvwcn_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwcnvxq_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwcnvxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwcnvxq_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwcnvxq_required = true;
		}
	}
}

// the vvvvwcn Some function
function protocol_vvvvwcn_SomeFunc(protocol_vvvvwcn)
{
	// set the function logic
	if (protocol_vvvvwcn == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcn Some function
function authentication_vvvvwcn_SomeFunc(authentication_vvvvwcn)
{
	// set the function logic
	if (authentication_vvvvwcn == 2 || authentication_vvvvwcn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcp function
function vvvvwcp(protocol_vvvvwcp,authentication_vvvvwcp)
{
	if (isSet(protocol_vvvvwcp) && protocol_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = protocol_vvvvwcp;
		var protocol_vvvvwcp = [];
		protocol_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(protocol_vvvvwcp))
	{
		var protocol_vvvvwcp = [];
	}
	var protocol = protocol_vvvvwcp.some(protocol_vvvvwcp_SomeFunc);

	if (isSet(authentication_vvvvwcp) && authentication_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = authentication_vvvvwcp;
		var authentication_vvvvwcp = [];
		authentication_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(authentication_vvvvwcp))
	{
		var authentication_vvvvwcp = [];
	}
	var authentication = authentication_vvvvwcp.some(authentication_vvvvwcp_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwcpvxr_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwcpvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwcpvxr_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwcpvxr_required = true;
		}
	}
}

// the vvvvwcp Some function
function protocol_vvvvwcp_SomeFunc(protocol_vvvvwcp)
{
	// set the function logic
	if (protocol_vvvvwcp == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcp Some function
function authentication_vvvvwcp_SomeFunc(authentication_vvvvwcp)
{
	// set the function logic
	if (authentication_vvvvwcp == 4 || authentication_vvvvwcp == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwcr function
function vvvvwcr(protocol_vvvvwcr,authentication_vvvvwcr)
{
	if (isSet(protocol_vvvvwcr) && protocol_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = protocol_vvvvwcr;
		var protocol_vvvvwcr = [];
		protocol_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(protocol_vvvvwcr))
	{
		var protocol_vvvvwcr = [];
	}
	var protocol = protocol_vvvvwcr.some(protocol_vvvvwcr_SomeFunc);

	if (isSet(authentication_vvvvwcr) && authentication_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = authentication_vvvvwcr;
		var authentication_vvvvwcr = [];
		authentication_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(authentication_vvvvwcr))
	{
		var authentication_vvvvwcr = [];
	}
	var authentication = authentication_vvvvwcr.some(authentication_vvvvwcr_SomeFunc);


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

// the vvvvwcr Some function
function protocol_vvvvwcr_SomeFunc(protocol_vvvvwcr)
{
	// set the function logic
	if (protocol_vvvvwcr == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcr Some function
function authentication_vvvvwcr_SomeFunc(authentication_vvvvwcr)
{
	// set the function logic
	if (authentication_vvvvwcr == 2 || authentication_vvvvwcr == 3 || authentication_vvvvwcr == 4 || authentication_vvvvwcr == 5)
	{
		return true;
	}
	return false;
}

/**
 * Update the "not required" field list by adding or removing a field name.
 *
 * Mirrors the original jQuery logic exactly but uses pure JavaScript.
 *
 * @param  {string}  name    The field name to add or remove.
 * @param  {number}  status  1 to add as not required, 0 to remove.
 *
 * @return {void}
 * @since  3.1.3
 */
function updateFieldRequired(name, status) {
	// Check if #jform_not_required exists
	const notRequiredField = document.getElementById('jform_not_required');
	if (!notRequiredField) {
		return;
	}

	// Split the comma-separated list into an array
	let not_required = notRequiredField.value ? notRequiredField.value.split(',') : [];

	// Add or remove the field name from the list
	if (status == 1) {
		not_required.push(name);
	} else {
		not_required = removeFieldFromNotRequired(not_required, name);
	}

	// Clean and deduplicate the list
	const fixedList = fixNotRequiredArray(not_required);

	// Write back the updated comma-separated list
	notRequiredField.value = fixedList.toString();
}

/**
 * Remove a specific field name from the "not required" array.
 *
 * @param  {Array<string>} array  The list of not-required field names.
 * @param  {string}        what   The field name to remove.
 *
 * @return {Array<string>}        The updated array.
 * @since  3.1.3
 */
function removeFieldFromNotRequired(array, what) {
	return array.filter(function (element) {
		return element !== what;
	});
}

/**
 * Deduplicate and clean a "not required" array.
 *
 * @param  {Array<string>} array  The array to fix.
 *
 * @return {Array<string>}        A cleaned, unique array.
 * @since  3.1.3
 */
function fixNotRequiredArray(array) {
	const seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function (item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

/**
 * Remove empty or invalid entries from a "not required" array.
 *
 * Also removes the literal '一_一' token (legacy quirk preserved for compatibility).
 *
 * @param  {Array<string>} array  The array to process.
 *
 * @return {Array<string>}        The cleaned array.
 * @since  3.1.3
 */
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		return el && el.length > 0 && el !== '一_一';
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
