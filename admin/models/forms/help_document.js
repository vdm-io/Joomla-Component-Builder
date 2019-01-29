/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwbkwaq_required = false;
jform_vvvvwblwar_required = false;
jform_vvvvwbmwas_required = false;
jform_vvvvwbnwat_required = false;
jform_vvvvwbowau_required = false;
jform_vvvvwbpwav_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwbk = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbk(location_vvvvwbk);

	var location_vvvvwbl = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbl(location_vvvvwbl);

	var type_vvvvwbm = jQuery("#jform_type").val();
	vvvvwbm(type_vvvvwbm);

	var type_vvvvwbn = jQuery("#jform_type").val();
	vvvvwbn(type_vvvvwbn);

	var type_vvvvwbo = jQuery("#jform_type").val();
	vvvvwbo(type_vvvvwbo);

	var target_vvvvwbp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbp(target_vvvvwbp);
});

// the vvvvwbk function
function vvvvwbk(location_vvvvwbk)
{
	// set the function logic
	if (location_vvvvwbk == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwbkwaq_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwbkwaq_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwbkwaq_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwbkwaq_required = true;
		}
	}
}

// the vvvvwbl function
function vvvvwbl(location_vvvvwbl)
{
	// set the function logic
	if (location_vvvvwbl == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwblwar_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwblwar_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwblwar_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwblwar_required = true;
		}
	}
}

// the vvvvwbm function
function vvvvwbm(type_vvvvwbm)
{
	if (isSet(type_vvvvwbm) && type_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = type_vvvvwbm;
		var type_vvvvwbm = [];
		type_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(type_vvvvwbm))
	{
		var type_vvvvwbm = [];
	}
	var type = type_vvvvwbm.some(type_vvvvwbm_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwbmwas_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwbmwas_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwbmwas_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwbmwas_required = true;
		}
	}
}

// the vvvvwbm Some function
function type_vvvvwbm_SomeFunc(type_vvvvwbm)
{
	// set the function logic
	if (type_vvvvwbm == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(type_vvvvwbn)
{
	if (isSet(type_vvvvwbn) && type_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = type_vvvvwbn;
		var type_vvvvwbn = [];
		type_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(type_vvvvwbn))
	{
		var type_vvvvwbn = [];
	}
	var type = type_vvvvwbn.some(type_vvvvwbn_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwbnwat_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwbnwat_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwbnwat_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwbnwat_required = true;
		}
	}
}

// the vvvvwbn Some function
function type_vvvvwbn_SomeFunc(type_vvvvwbn)
{
	// set the function logic
	if (type_vvvvwbn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbo function
function vvvvwbo(type_vvvvwbo)
{
	if (isSet(type_vvvvwbo) && type_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = type_vvvvwbo;
		var type_vvvvwbo = [];
		type_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(type_vvvvwbo))
	{
		var type_vvvvwbo = [];
	}
	var type = type_vvvvwbo.some(type_vvvvwbo_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		// add required attribute to content field
		if (jform_vvvvwbowau_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwbowau_required = false;
		}
	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		// remove required attribute from content field
		if (!jform_vvvvwbowau_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwbowau_required = true;
		}
	}
}

// the vvvvwbo Some function
function type_vvvvwbo_SomeFunc(type_vvvvwbo)
{
	// set the function logic
	if (type_vvvvwbo == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbp function
function vvvvwbp(target_vvvvwbp)
{
	// set the function logic
	if (target_vvvvwbp == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwbpwav_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwbpwav_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwbpwav_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwbpwav_required = true;
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
