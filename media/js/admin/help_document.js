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
jform_vvvvwcpvxp_required = false;
jform_vvvvwcqvxq_required = false;
jform_vvvvwcrvxr_required = false;
jform_vvvvwcsvxs_required = false;
jform_vvvvwcuvxt_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var location_vvvvwcp = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcp(location_vvvvwcp);

	var location_vvvvwcq = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcq(location_vvvvwcq);

	var type_vvvvwcr = jQuery("#jform_type").val();
	vvvvwcr(type_vvvvwcr);

	var type_vvvvwcs = jQuery("#jform_type").val();
	vvvvwcs(type_vvvvwcs);

	var type_vvvvwct = jQuery("#jform_type").val();
	vvvvwct(type_vvvvwct);

	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcu(target_vvvvwcu);
});

// the vvvvwcp function
function vvvvwcp(location_vvvvwcp)
{
	// set the function logic
	if (location_vvvvwcp == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwcpvxp_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwcpvxp_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwcpvxp_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwcpvxp_required = true;
		}
	}
}

// the vvvvwcq function
function vvvvwcq(location_vvvvwcq)
{
	// set the function logic
	if (location_vvvvwcq == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwcqvxq_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwcqvxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwcqvxq_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwcqvxq_required = true;
		}
	}
}

// the vvvvwcr function
function vvvvwcr(type_vvvvwcr)
{
	if (isSet(type_vvvvwcr) && type_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = type_vvvvwcr;
		var type_vvvvwcr = [];
		type_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(type_vvvvwcr))
	{
		var type_vvvvwcr = [];
	}
	var type = type_vvvvwcr.some(type_vvvvwcr_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwcrvxr_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwcrvxr_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwcrvxr_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwcrvxr_required = true;
		}
	}
}

// the vvvvwcr Some function
function type_vvvvwcr_SomeFunc(type_vvvvwcr)
{
	// set the function logic
	if (type_vvvvwcr == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcs function
function vvvvwcs(type_vvvvwcs)
{
	if (isSet(type_vvvvwcs) && type_vvvvwcs.constructor !== Array)
	{
		var temp_vvvvwcs = type_vvvvwcs;
		var type_vvvvwcs = [];
		type_vvvvwcs.push(temp_vvvvwcs);
	}
	else if (!isSet(type_vvvvwcs))
	{
		var type_vvvvwcs = [];
	}
	var type = type_vvvvwcs.some(type_vvvvwcs_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwcsvxs_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwcsvxs_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwcsvxs_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwcsvxs_required = true;
		}
	}
}

// the vvvvwcs Some function
function type_vvvvwcs_SomeFunc(type_vvvvwcs)
{
	// set the function logic
	if (type_vvvvwcs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwct function
function vvvvwct(type_vvvvwct)
{
	if (isSet(type_vvvvwct) && type_vvvvwct.constructor !== Array)
	{
		var temp_vvvvwct = type_vvvvwct;
		var type_vvvvwct = [];
		type_vvvvwct.push(temp_vvvvwct);
	}
	else if (!isSet(type_vvvvwct))
	{
		var type_vvvvwct = [];
	}
	var type = type_vvvvwct.some(type_vvvvwct_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
	}
}

// the vvvvwct Some function
function type_vvvvwct_SomeFunc(type_vvvvwct)
{
	// set the function logic
	if (type_vvvvwct == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcu function
function vvvvwcu(target_vvvvwcu)
{
	// set the function logic
	if (target_vvvvwcu == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwcuvxt_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwcuvxt_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwcuvxt_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwcuvxt_required = true;
		}
	}
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
