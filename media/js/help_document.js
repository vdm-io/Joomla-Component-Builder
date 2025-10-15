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
jform_vvvvwctvxs_required = false;
jform_vvvvwcuvxt_required = false;
jform_vvvvwcvvxu_required = false;
jform_vvvvwcwvxv_required = false;
jform_vvvvwcyvxw_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var location_vvvvwct = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwct(location_vvvvwct);

	var location_vvvvwcu = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcu(location_vvvvwcu);

	var type_vvvvwcv = jQuery("#jform_type").val();
	vvvvwcv(type_vvvvwcv);

	var type_vvvvwcw = jQuery("#jform_type").val();
	vvvvwcw(type_vvvvwcw);

	var type_vvvvwcx = jQuery("#jform_type").val();
	vvvvwcx(type_vvvvwcx);

	var target_vvvvwcy = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcy(target_vvvvwcy);
});

// the vvvvwct function
function vvvvwct(location_vvvvwct)
{
	// set the function logic
	if (location_vvvvwct == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwctvxs_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwctvxs_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwctvxs_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwctvxs_required = true;
		}
	}
}

// the vvvvwcu function
function vvvvwcu(location_vvvvwcu)
{
	// set the function logic
	if (location_vvvvwcu == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwcuvxt_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwcuvxt_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwcuvxt_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwcuvxt_required = true;
		}
	}
}

// the vvvvwcv function
function vvvvwcv(type_vvvvwcv)
{
	if (isSet(type_vvvvwcv) && type_vvvvwcv.constructor !== Array)
	{
		var temp_vvvvwcv = type_vvvvwcv;
		var type_vvvvwcv = [];
		type_vvvvwcv.push(temp_vvvvwcv);
	}
	else if (!isSet(type_vvvvwcv))
	{
		var type_vvvvwcv = [];
	}
	var type = type_vvvvwcv.some(type_vvvvwcv_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwcvvxu_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwcvvxu_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwcvvxu_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwcvvxu_required = true;
		}
	}
}

// the vvvvwcv Some function
function type_vvvvwcv_SomeFunc(type_vvvvwcv)
{
	// set the function logic
	if (type_vvvvwcv == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcw function
function vvvvwcw(type_vvvvwcw)
{
	if (isSet(type_vvvvwcw) && type_vvvvwcw.constructor !== Array)
	{
		var temp_vvvvwcw = type_vvvvwcw;
		var type_vvvvwcw = [];
		type_vvvvwcw.push(temp_vvvvwcw);
	}
	else if (!isSet(type_vvvvwcw))
	{
		var type_vvvvwcw = [];
	}
	var type = type_vvvvwcw.some(type_vvvvwcw_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwcwvxv_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwcwvxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwcwvxv_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwcwvxv_required = true;
		}
	}
}

// the vvvvwcw Some function
function type_vvvvwcw_SomeFunc(type_vvvvwcw)
{
	// set the function logic
	if (type_vvvvwcw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcx function
function vvvvwcx(type_vvvvwcx)
{
	if (isSet(type_vvvvwcx) && type_vvvvwcx.constructor !== Array)
	{
		var temp_vvvvwcx = type_vvvvwcx;
		var type_vvvvwcx = [];
		type_vvvvwcx.push(temp_vvvvwcx);
	}
	else if (!isSet(type_vvvvwcx))
	{
		var type_vvvvwcx = [];
	}
	var type = type_vvvvwcx.some(type_vvvvwcx_SomeFunc);


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

// the vvvvwcx Some function
function type_vvvvwcx_SomeFunc(type_vvvvwcx)
{
	// set the function logic
	if (type_vvvvwcx == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcy function
function vvvvwcy(target_vvvvwcy)
{
	// set the function logic
	if (target_vvvvwcy == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwcyvxw_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwcyvxw_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwcyvxw_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwcyvxw_required = true;
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
