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
jform_vvvvwczvyh_required = false;
jform_vvvvwdavyi_required = false;
jform_vvvvwdbvyj_required = false;
jform_vvvvwdcvyk_required = false;
jform_vvvvwdevyl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwcz = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcz(location_vvvvwcz);

	var location_vvvvwda = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwda(location_vvvvwda);

	var type_vvvvwdb = jQuery("#jform_type").val();
	vvvvwdb(type_vvvvwdb);

	var type_vvvvwdc = jQuery("#jform_type").val();
	vvvvwdc(type_vvvvwdc);

	var type_vvvvwdd = jQuery("#jform_type").val();
	vvvvwdd(type_vvvvwdd);

	var target_vvvvwde = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwde(target_vvvvwde);
});

// the vvvvwcz function
function vvvvwcz(location_vvvvwcz)
{
	// set the function logic
	if (location_vvvvwcz == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwczvyh_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwczvyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwczvyh_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwczvyh_required = true;
		}
	}
}

// the vvvvwda function
function vvvvwda(location_vvvvwda)
{
	// set the function logic
	if (location_vvvvwda == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwdavyi_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwdavyi_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwdavyi_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwdavyi_required = true;
		}
	}
}

// the vvvvwdb function
function vvvvwdb(type_vvvvwdb)
{
	if (isSet(type_vvvvwdb) && type_vvvvwdb.constructor !== Array)
	{
		var temp_vvvvwdb = type_vvvvwdb;
		var type_vvvvwdb = [];
		type_vvvvwdb.push(temp_vvvvwdb);
	}
	else if (!isSet(type_vvvvwdb))
	{
		var type_vvvvwdb = [];
	}
	var type = type_vvvvwdb.some(type_vvvvwdb_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwdbvyj_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwdbvyj_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwdbvyj_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwdbvyj_required = true;
		}
	}
}

// the vvvvwdb Some function
function type_vvvvwdb_SomeFunc(type_vvvvwdb)
{
	// set the function logic
	if (type_vvvvwdb == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwdc function
function vvvvwdc(type_vvvvwdc)
{
	if (isSet(type_vvvvwdc) && type_vvvvwdc.constructor !== Array)
	{
		var temp_vvvvwdc = type_vvvvwdc;
		var type_vvvvwdc = [];
		type_vvvvwdc.push(temp_vvvvwdc);
	}
	else if (!isSet(type_vvvvwdc))
	{
		var type_vvvvwdc = [];
	}
	var type = type_vvvvwdc.some(type_vvvvwdc_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwdcvyk_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwdcvyk_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwdcvyk_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwdcvyk_required = true;
		}
	}
}

// the vvvvwdc Some function
function type_vvvvwdc_SomeFunc(type_vvvvwdc)
{
	// set the function logic
	if (type_vvvvwdc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdd function
function vvvvwdd(type_vvvvwdd)
{
	if (isSet(type_vvvvwdd) && type_vvvvwdd.constructor !== Array)
	{
		var temp_vvvvwdd = type_vvvvwdd;
		var type_vvvvwdd = [];
		type_vvvvwdd.push(temp_vvvvwdd);
	}
	else if (!isSet(type_vvvvwdd))
	{
		var type_vvvvwdd = [];
	}
	var type = type_vvvvwdd.some(type_vvvvwdd_SomeFunc);


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

// the vvvvwdd Some function
function type_vvvvwdd_SomeFunc(type_vvvvwdd)
{
	// set the function logic
	if (type_vvvvwdd == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwde function
function vvvvwde(target_vvvvwde)
{
	// set the function logic
	if (target_vvvvwde == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwdevyl_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwdevyl_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwdevyl_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwdevyl_required = true;
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
