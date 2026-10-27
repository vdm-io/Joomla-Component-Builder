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
jform_vvvvwcfvxg_required = false;
jform_vvvvwcfvxh_required = false;
jform_vvvvwcfvxi_required = false;
jform_vvvvwcfvxj_required = false;
jform_vvvvwcfvxk_required = false;
jform_vvvvwcgvxl_required = false;
jform_vvvvwchvxm_required = false;
jform_vvvvwcjvxn_required = false;
jform_vvvvwclvxo_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var protocol_vvvvwcf = jQuery("#jform_protocol").val();
	vvvvwcf(protocol_vvvvwcf);

	var protocol_vvvvwcg = jQuery("#jform_protocol").val();
	vvvvwcg(protocol_vvvvwcg);

	var protocol_vvvvwch = jQuery("#jform_protocol").val();
	var authentication_vvvvwch = jQuery("#jform_authentication").val();
	vvvvwch(protocol_vvvvwch,authentication_vvvvwch);

	var protocol_vvvvwcj = jQuery("#jform_protocol").val();
	var authentication_vvvvwcj = jQuery("#jform_authentication").val();
	vvvvwcj(protocol_vvvvwcj,authentication_vvvvwcj);

	var protocol_vvvvwcl = jQuery("#jform_protocol").val();
	var authentication_vvvvwcl = jQuery("#jform_authentication").val();
	vvvvwcl(protocol_vvvvwcl,authentication_vvvvwcl);

	var protocol_vvvvwcn = jQuery("#jform_protocol").val();
	var authentication_vvvvwcn = jQuery("#jform_authentication").val();
	vvvvwcn(protocol_vvvvwcn,authentication_vvvvwcn);
});

// the vvvvwcf function
function vvvvwcf(protocol_vvvvwcf)
{
	if (isSet(protocol_vvvvwcf) && protocol_vvvvwcf.constructor !== Array)
	{
		var temp_vvvvwcf = protocol_vvvvwcf;
		var protocol_vvvvwcf = [];
		protocol_vvvvwcf.push(temp_vvvvwcf);
	}
	else if (!isSet(protocol_vvvvwcf))
	{
		var protocol_vvvvwcf = [];
	}
	var protocol = protocol_vvvvwcf.some(protocol_vvvvwcf_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwcfvxg_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwcfvxg_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwcfvxh_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwcfvxh_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwcfvxi_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwcfvxi_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwcfvxj_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwcfvxj_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwcfvxk_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwcfvxk_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwcfvxg_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwcfvxg_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwcfvxh_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwcfvxh_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwcfvxi_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwcfvxi_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwcfvxj_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwcfvxj_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwcfvxk_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwcfvxk_required = true;
		}
	}
}

// the vvvvwcf Some function
function protocol_vvvvwcf_SomeFunc(protocol_vvvvwcf)
{
	// set the function logic
	if (protocol_vvvvwcf == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcg function
function vvvvwcg(protocol_vvvvwcg)
{
	if (isSet(protocol_vvvvwcg) && protocol_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = protocol_vvvvwcg;
		var protocol_vvvvwcg = [];
		protocol_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(protocol_vvvvwcg))
	{
		var protocol_vvvvwcg = [];
	}
	var protocol = protocol_vvvvwcg.some(protocol_vvvvwcg_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwcgvxl_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwcgvxl_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwcgvxl_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwcgvxl_required = true;
		}
	}
}

// the vvvvwcg Some function
function protocol_vvvvwcg_SomeFunc(protocol_vvvvwcg)
{
	// set the function logic
	if (protocol_vvvvwcg == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwch function
function vvvvwch(protocol_vvvvwch,authentication_vvvvwch)
{
	if (isSet(protocol_vvvvwch) && protocol_vvvvwch.constructor !== Array)
	{
		var temp_vvvvwch = protocol_vvvvwch;
		var protocol_vvvvwch = [];
		protocol_vvvvwch.push(temp_vvvvwch);
	}
	else if (!isSet(protocol_vvvvwch))
	{
		var protocol_vvvvwch = [];
	}
	var protocol = protocol_vvvvwch.some(protocol_vvvvwch_SomeFunc);

	if (isSet(authentication_vvvvwch) && authentication_vvvvwch.constructor !== Array)
	{
		var temp_vvvvwch = authentication_vvvvwch;
		var authentication_vvvvwch = [];
		authentication_vvvvwch.push(temp_vvvvwch);
	}
	else if (!isSet(authentication_vvvvwch))
	{
		var authentication_vvvvwch = [];
	}
	var authentication = authentication_vvvvwch.some(authentication_vvvvwch_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwchvxm_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwchvxm_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwchvxm_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwchvxm_required = true;
		}
	}
}

// the vvvvwch Some function
function protocol_vvvvwch_SomeFunc(protocol_vvvvwch)
{
	// set the function logic
	if (protocol_vvvvwch == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwch Some function
function authentication_vvvvwch_SomeFunc(authentication_vvvvwch)
{
	// set the function logic
	if (authentication_vvvvwch == 1 || authentication_vvvvwch == 3 || authentication_vvvvwch == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwcj function
function vvvvwcj(protocol_vvvvwcj,authentication_vvvvwcj)
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

	if (isSet(authentication_vvvvwcj) && authentication_vvvvwcj.constructor !== Array)
	{
		var temp_vvvvwcj = authentication_vvvvwcj;
		var authentication_vvvvwcj = [];
		authentication_vvvvwcj.push(temp_vvvvwcj);
	}
	else if (!isSet(authentication_vvvvwcj))
	{
		var authentication_vvvvwcj = [];
	}
	var authentication = authentication_vvvvwcj.some(authentication_vvvvwcj_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwcjvxn_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwcjvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwcjvxn_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
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

// the vvvvwcj Some function
function authentication_vvvvwcj_SomeFunc(authentication_vvvvwcj)
{
	// set the function logic
	if (authentication_vvvvwcj == 2 || authentication_vvvvwcj == 3)
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
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwclvxo_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwclvxo_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwclvxo_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwclvxo_required = true;
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
	if (authentication_vvvvwcl == 4 || authentication_vvvvwcl == 5)
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
		jQuery('#jform_secret').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_secret').closest('.control-group').hide();
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
	if (authentication_vvvvwcn == 2 || authentication_vvvvwcn == 3 || authentication_vvvvwcn == 4 || authentication_vvvvwcn == 5)
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
