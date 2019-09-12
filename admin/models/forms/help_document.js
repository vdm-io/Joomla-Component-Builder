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
jform_vvvvwdcvyj_required = false;
jform_vvvvwddvyk_required = false;
jform_vvvvwdevyl_required = false;
jform_vvvvwdfvym_required = false;
jform_vvvvwdhvyn_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwdc = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwdc(location_vvvvwdc);

	var location_vvvvwdd = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwdd(location_vvvvwdd);

	var type_vvvvwde = jQuery("#jform_type").val();
	vvvvwde(type_vvvvwde);

	var type_vvvvwdf = jQuery("#jform_type").val();
	vvvvwdf(type_vvvvwdf);

	var type_vvvvwdg = jQuery("#jform_type").val();
	vvvvwdg(type_vvvvwdg);

	var target_vvvvwdh = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwdh(target_vvvvwdh);
});

// the vvvvwdc function
function vvvvwdc(location_vvvvwdc)
{
	// set the function logic
	if (location_vvvvwdc == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwdcvyj_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwdcvyj_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwdcvyj_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwdcvyj_required = true;
		}
	}
}

// the vvvvwdd function
function vvvvwdd(location_vvvvwdd)
{
	// set the function logic
	if (location_vvvvwdd == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwddvyk_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwddvyk_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwddvyk_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwddvyk_required = true;
		}
	}
}

// the vvvvwde function
function vvvvwde(type_vvvvwde)
{
	if (isSet(type_vvvvwde) && type_vvvvwde.constructor !== Array)
	{
		var temp_vvvvwde = type_vvvvwde;
		var type_vvvvwde = [];
		type_vvvvwde.push(temp_vvvvwde);
	}
	else if (!isSet(type_vvvvwde))
	{
		var type_vvvvwde = [];
	}
	var type = type_vvvvwde.some(type_vvvvwde_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwdevyl_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwdevyl_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwdevyl_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwdevyl_required = true;
		}
	}
}

// the vvvvwde Some function
function type_vvvvwde_SomeFunc(type_vvvvwde)
{
	// set the function logic
	if (type_vvvvwde == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwdf function
function vvvvwdf(type_vvvvwdf)
{
	if (isSet(type_vvvvwdf) && type_vvvvwdf.constructor !== Array)
	{
		var temp_vvvvwdf = type_vvvvwdf;
		var type_vvvvwdf = [];
		type_vvvvwdf.push(temp_vvvvwdf);
	}
	else if (!isSet(type_vvvvwdf))
	{
		var type_vvvvwdf = [];
	}
	var type = type_vvvvwdf.some(type_vvvvwdf_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwdfvym_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwdfvym_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwdfvym_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwdfvym_required = true;
		}
	}
}

// the vvvvwdf Some function
function type_vvvvwdf_SomeFunc(type_vvvvwdf)
{
	// set the function logic
	if (type_vvvvwdf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdg function
function vvvvwdg(type_vvvvwdg)
{
	if (isSet(type_vvvvwdg) && type_vvvvwdg.constructor !== Array)
	{
		var temp_vvvvwdg = type_vvvvwdg;
		var type_vvvvwdg = [];
		type_vvvvwdg.push(temp_vvvvwdg);
	}
	else if (!isSet(type_vvvvwdg))
	{
		var type_vvvvwdg = [];
	}
	var type = type_vvvvwdg.some(type_vvvvwdg_SomeFunc);


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

// the vvvvwdg Some function
function type_vvvvwdg_SomeFunc(type_vvvvwdg)
{
	// set the function logic
	if (type_vvvvwdg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdh function
function vvvvwdh(target_vvvvwdh)
{
	// set the function logic
	if (target_vvvvwdh == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwdhvyn_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwdhvyn_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwdhvyn_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwdhvyn_required = true;
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
