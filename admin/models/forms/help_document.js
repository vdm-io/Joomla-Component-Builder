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
jform_vvvvwbhwap_required = false;
jform_vvvvwbiwaq_required = false;
jform_vvvvwbjwar_required = false;
jform_vvvvwbkwas_required = false;
jform_vvvvwblwat_required = false;
jform_vvvvwbmwau_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwbh = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbh(location_vvvvwbh);

	var location_vvvvwbi = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbi(location_vvvvwbi);

	var type_vvvvwbj = jQuery("#jform_type").val();
	vvvvwbj(type_vvvvwbj);

	var type_vvvvwbk = jQuery("#jform_type").val();
	vvvvwbk(type_vvvvwbk);

	var type_vvvvwbl = jQuery("#jform_type").val();
	vvvvwbl(type_vvvvwbl);

	var target_vvvvwbm = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbm(target_vvvvwbm);
});

// the vvvvwbh function
function vvvvwbh(location_vvvvwbh)
{
	// set the function logic
	if (location_vvvvwbh == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwbhwap_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwbhwap_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwbhwap_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwbhwap_required = true;
		}
	}
}

// the vvvvwbi function
function vvvvwbi(location_vvvvwbi)
{
	// set the function logic
	if (location_vvvvwbi == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwbiwaq_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwbiwaq_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwbiwaq_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwbiwaq_required = true;
		}
	}
}

// the vvvvwbj function
function vvvvwbj(type_vvvvwbj)
{
	if (isSet(type_vvvvwbj) && type_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = type_vvvvwbj;
		var type_vvvvwbj = [];
		type_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(type_vvvvwbj))
	{
		var type_vvvvwbj = [];
	}
	var type = type_vvvvwbj.some(type_vvvvwbj_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwbjwar_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwbjwar_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwbjwar_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwbjwar_required = true;
		}
	}
}

// the vvvvwbj Some function
function type_vvvvwbj_SomeFunc(type_vvvvwbj)
{
	// set the function logic
	if (type_vvvvwbj == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbk function
function vvvvwbk(type_vvvvwbk)
{
	if (isSet(type_vvvvwbk) && type_vvvvwbk.constructor !== Array)
	{
		var temp_vvvvwbk = type_vvvvwbk;
		var type_vvvvwbk = [];
		type_vvvvwbk.push(temp_vvvvwbk);
	}
	else if (!isSet(type_vvvvwbk))
	{
		var type_vvvvwbk = [];
	}
	var type = type_vvvvwbk.some(type_vvvvwbk_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwbkwas_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwbkwas_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwbkwas_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwbkwas_required = true;
		}
	}
}

// the vvvvwbk Some function
function type_vvvvwbk_SomeFunc(type_vvvvwbk)
{
	// set the function logic
	if (type_vvvvwbk == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbl function
function vvvvwbl(type_vvvvwbl)
{
	if (isSet(type_vvvvwbl) && type_vvvvwbl.constructor !== Array)
	{
		var temp_vvvvwbl = type_vvvvwbl;
		var type_vvvvwbl = [];
		type_vvvvwbl.push(temp_vvvvwbl);
	}
	else if (!isSet(type_vvvvwbl))
	{
		var type_vvvvwbl = [];
	}
	var type = type_vvvvwbl.some(type_vvvvwbl_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwblwat_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwblwat_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwblwat_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwblwat_required = true;
		}
	}
}

// the vvvvwbl Some function
function type_vvvvwbl_SomeFunc(type_vvvvwbl)
{
	// set the function logic
	if (type_vvvvwbl == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbm function
function vvvvwbm(target_vvvvwbm)
{
	// set the function logic
	if (target_vvvvwbm == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwbmwau_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwbmwau_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwbmwau_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwbmwau_required = true;
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
