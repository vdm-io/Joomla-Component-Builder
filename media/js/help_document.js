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
jform_vvvvwcqvyd_required = false;
jform_vvvvwcrvye_required = false;
jform_vvvvwcsvyf_required = false;
jform_vvvvwctvyg_required = false;
jform_vvvvwcvvyh_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var location_vvvvwcq = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcq(location_vvvvwcq);

	var location_vvvvwcr = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcr(location_vvvvwcr);

	var type_vvvvwcs = jQuery("#jform_type").val();
	vvvvwcs(type_vvvvwcs);

	var type_vvvvwct = jQuery("#jform_type").val();
	vvvvwct(type_vvvvwct);

	var type_vvvvwcu = jQuery("#jform_type").val();
	vvvvwcu(type_vvvvwcu);

	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv);
});

// the vvvvwcq function
function vvvvwcq(location_vvvvwcq)
{
	// set the function logic
	if (location_vvvvwcq == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwcqvyd_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwcqvyd_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwcqvyd_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwcqvyd_required = true;
		}
	}
}

// the vvvvwcr function
function vvvvwcr(location_vvvvwcr)
{
	// set the function logic
	if (location_vvvvwcr == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwcrvye_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwcrvye_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwcrvye_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwcrvye_required = true;
		}
	}
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
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwcsvyf_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwcsvyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwcsvyf_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwcsvyf_required = true;
		}
	}
}

// the vvvvwcs Some function
function type_vvvvwcs_SomeFunc(type_vvvvwcs)
{
	// set the function logic
	if (type_vvvvwcs == 3)
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
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwctvyg_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwctvyg_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwctvyg_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwctvyg_required = true;
		}
	}
}

// the vvvvwct Some function
function type_vvvvwct_SomeFunc(type_vvvvwct)
{
	// set the function logic
	if (type_vvvvwct == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcu function
function vvvvwcu(type_vvvvwcu)
{
	if (isSet(type_vvvvwcu) && type_vvvvwcu.constructor !== Array)
	{
		var temp_vvvvwcu = type_vvvvwcu;
		var type_vvvvwcu = [];
		type_vvvvwcu.push(temp_vvvvwcu);
	}
	else if (!isSet(type_vvvvwcu))
	{
		var type_vvvvwcu = [];
	}
	var type = type_vvvvwcu.some(type_vvvvwcu_SomeFunc);


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

// the vvvvwcu Some function
function type_vvvvwcu_SomeFunc(type_vvvvwcu)
{
	// set the function logic
	if (type_vvvvwcu == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcv function
function vvvvwcv(target_vvvvwcv)
{
	// set the function logic
	if (target_vvvvwcv == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwcvvyh_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwcvvyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwcvvyh_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwcvvyh_required = true;
		}
	}
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (document.getElementById('jform_not_required')) {
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
