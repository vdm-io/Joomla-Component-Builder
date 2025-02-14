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
jform_vvvvwcmvxv_required = false;
jform_vvvvwcnvxw_required = false;
jform_vvvvwcovxx_required = false;
jform_vvvvwcpvxy_required = false;
jform_vvvvwcrvxz_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var location_vvvvwcm = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcm(location_vvvvwcm);

	var location_vvvvwcn = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcn(location_vvvvwcn);

	var type_vvvvwco = jQuery("#jform_type").val();
	vvvvwco(type_vvvvwco);

	var type_vvvvwcp = jQuery("#jform_type").val();
	vvvvwcp(type_vvvvwcp);

	var type_vvvvwcq = jQuery("#jform_type").val();
	vvvvwcq(type_vvvvwcq);

	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(target_vvvvwcr);
});

// the vvvvwcm function
function vvvvwcm(location_vvvvwcm)
{
	// set the function logic
	if (location_vvvvwcm == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwcmvxv_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwcmvxv_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwcmvxv_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwcmvxv_required = true;
		}
	}
}

// the vvvvwcn function
function vvvvwcn(location_vvvvwcn)
{
	// set the function logic
	if (location_vvvvwcn == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwcnvxw_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwcnvxw_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwcnvxw_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwcnvxw_required = true;
		}
	}
}

// the vvvvwco function
function vvvvwco(type_vvvvwco)
{
	if (isSet(type_vvvvwco) && type_vvvvwco.constructor !== Array)
	{
		var temp_vvvvwco = type_vvvvwco;
		var type_vvvvwco = [];
		type_vvvvwco.push(temp_vvvvwco);
	}
	else if (!isSet(type_vvvvwco))
	{
		var type_vvvvwco = [];
	}
	var type = type_vvvvwco.some(type_vvvvwco_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwcovxx_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwcovxx_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwcovxx_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwcovxx_required = true;
		}
	}
}

// the vvvvwco Some function
function type_vvvvwco_SomeFunc(type_vvvvwco)
{
	// set the function logic
	if (type_vvvvwco == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcp function
function vvvvwcp(type_vvvvwcp)
{
	if (isSet(type_vvvvwcp) && type_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = type_vvvvwcp;
		var type_vvvvwcp = [];
		type_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(type_vvvvwcp))
	{
		var type_vvvvwcp = [];
	}
	var type = type_vvvvwcp.some(type_vvvvwcp_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwcpvxy_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwcpvxy_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwcpvxy_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwcpvxy_required = true;
		}
	}
}

// the vvvvwcp Some function
function type_vvvvwcp_SomeFunc(type_vvvvwcp)
{
	// set the function logic
	if (type_vvvvwcp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcq function
function vvvvwcq(type_vvvvwcq)
{
	if (isSet(type_vvvvwcq) && type_vvvvwcq.constructor !== Array)
	{
		var temp_vvvvwcq = type_vvvvwcq;
		var type_vvvvwcq = [];
		type_vvvvwcq.push(temp_vvvvwcq);
	}
	else if (!isSet(type_vvvvwcq))
	{
		var type_vvvvwcq = [];
	}
	var type = type_vvvvwcq.some(type_vvvvwcq_SomeFunc);


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

// the vvvvwcq Some function
function type_vvvvwcq_SomeFunc(type_vvvvwcq)
{
	// set the function logic
	if (type_vvvvwcq == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcr function
function vvvvwcr(target_vvvvwcr)
{
	// set the function logic
	if (target_vvvvwcr == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwcrvxz_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwcrvxz_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwcrvxz_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwcrvxz_required = true;
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
