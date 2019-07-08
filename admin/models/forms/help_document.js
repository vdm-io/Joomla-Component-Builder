/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwbzvyb_required = false;
jform_vvvvwcavyc_required = false;
jform_vvvvwcbvyd_required = false;
jform_vvvvwccvye_required = false;
jform_vvvvwcevyf_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwbz = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbz(location_vvvvwbz);

	var location_vvvvwca = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwca(location_vvvvwca);

	var type_vvvvwcb = jQuery("#jform_type").val();
	vvvvwcb(type_vvvvwcb);

	var type_vvvvwcc = jQuery("#jform_type").val();
	vvvvwcc(type_vvvvwcc);

	var type_vvvvwcd = jQuery("#jform_type").val();
	vvvvwcd(type_vvvvwcd);

	var target_vvvvwce = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwce(target_vvvvwce);
});

// the vvvvwbz function
function vvvvwbz(location_vvvvwbz)
{
	// set the function logic
	if (location_vvvvwbz == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwbzvyb_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwbzvyb_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwbzvyb_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwbzvyb_required = true;
		}
	}
}

// the vvvvwca function
function vvvvwca(location_vvvvwca)
{
	// set the function logic
	if (location_vvvvwca == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwcavyc_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwcavyc_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwcavyc_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwcavyc_required = true;
		}
	}
}

// the vvvvwcb function
function vvvvwcb(type_vvvvwcb)
{
	if (isSet(type_vvvvwcb) && type_vvvvwcb.constructor !== Array)
	{
		var temp_vvvvwcb = type_vvvvwcb;
		var type_vvvvwcb = [];
		type_vvvvwcb.push(temp_vvvvwcb);
	}
	else if (!isSet(type_vvvvwcb))
	{
		var type_vvvvwcb = [];
	}
	var type = type_vvvvwcb.some(type_vvvvwcb_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwcbvyd_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwcbvyd_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwcbvyd_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwcbvyd_required = true;
		}
	}
}

// the vvvvwcb Some function
function type_vvvvwcb_SomeFunc(type_vvvvwcb)
{
	// set the function logic
	if (type_vvvvwcb == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcc function
function vvvvwcc(type_vvvvwcc)
{
	if (isSet(type_vvvvwcc) && type_vvvvwcc.constructor !== Array)
	{
		var temp_vvvvwcc = type_vvvvwcc;
		var type_vvvvwcc = [];
		type_vvvvwcc.push(temp_vvvvwcc);
	}
	else if (!isSet(type_vvvvwcc))
	{
		var type_vvvvwcc = [];
	}
	var type = type_vvvvwcc.some(type_vvvvwcc_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwccvye_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwccvye_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwccvye_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwccvye_required = true;
		}
	}
}

// the vvvvwcc Some function
function type_vvvvwcc_SomeFunc(type_vvvvwcc)
{
	// set the function logic
	if (type_vvvvwcc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcd function
function vvvvwcd(type_vvvvwcd)
{
	if (isSet(type_vvvvwcd) && type_vvvvwcd.constructor !== Array)
	{
		var temp_vvvvwcd = type_vvvvwcd;
		var type_vvvvwcd = [];
		type_vvvvwcd.push(temp_vvvvwcd);
	}
	else if (!isSet(type_vvvvwcd))
	{
		var type_vvvvwcd = [];
	}
	var type = type_vvvvwcd.some(type_vvvvwcd_SomeFunc);


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

// the vvvvwcd Some function
function type_vvvvwcd_SomeFunc(type_vvvvwcd)
{
	// set the function logic
	if (type_vvvvwcd == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwce function
function vvvvwce(target_vvvvwce)
{
	// set the function logic
	if (target_vvvvwce == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwcevyf_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwcevyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwcevyf_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwcevyf_required = true;
		}
	}
}

// update required fields
function updateFieldRequired(name,status)
{
	var not_required = jQuery('#jform_not_required').val();

	if(status == 1)
	{
		if (isSet(not_required) && not_required != 0)
		{
			not_required = not_required+','+name;
		}
		else
		{
			not_required = ','+name;
		}
	}
	else
	{
		if (isSet(not_required) && not_required != 0)
		{
			not_required = not_required.replace(','+name,'');
		}
	}

	jQuery('#jform_not_required').val(not_required);
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
} 
