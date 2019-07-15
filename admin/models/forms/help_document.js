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
jform_vvvvwcdvyd_required = false;
jform_vvvvwcevye_required = false;
jform_vvvvwcfvyf_required = false;
jform_vvvvwcgvyg_required = false;
jform_vvvvwcivyh_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwcd = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcd(location_vvvvwcd);

	var location_vvvvwce = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwce(location_vvvvwce);

	var type_vvvvwcf = jQuery("#jform_type").val();
	vvvvwcf(type_vvvvwcf);

	var type_vvvvwcg = jQuery("#jform_type").val();
	vvvvwcg(type_vvvvwcg);

	var type_vvvvwch = jQuery("#jform_type").val();
	vvvvwch(type_vvvvwch);

	var target_vvvvwci = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwci(target_vvvvwci);
});

// the vvvvwcd function
function vvvvwcd(location_vvvvwcd)
{
	// set the function logic
	if (location_vvvvwcd == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwcdvyd_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwcdvyd_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwcdvyd_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwcdvyd_required = true;
		}
	}
}

// the vvvvwce function
function vvvvwce(location_vvvvwce)
{
	// set the function logic
	if (location_vvvvwce == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwcevye_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwcevye_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwcevye_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwcevye_required = true;
		}
	}
}

// the vvvvwcf function
function vvvvwcf(type_vvvvwcf)
{
	if (isSet(type_vvvvwcf) && type_vvvvwcf.constructor !== Array)
	{
		var temp_vvvvwcf = type_vvvvwcf;
		var type_vvvvwcf = [];
		type_vvvvwcf.push(temp_vvvvwcf);
	}
	else if (!isSet(type_vvvvwcf))
	{
		var type_vvvvwcf = [];
	}
	var type = type_vvvvwcf.some(type_vvvvwcf_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwcfvyf_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwcfvyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwcfvyf_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwcfvyf_required = true;
		}
	}
}

// the vvvvwcf Some function
function type_vvvvwcf_SomeFunc(type_vvvvwcf)
{
	// set the function logic
	if (type_vvvvwcf == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcg function
function vvvvwcg(type_vvvvwcg)
{
	if (isSet(type_vvvvwcg) && type_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = type_vvvvwcg;
		var type_vvvvwcg = [];
		type_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(type_vvvvwcg))
	{
		var type_vvvvwcg = [];
	}
	var type = type_vvvvwcg.some(type_vvvvwcg_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwcgvyg_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwcgvyg_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwcgvyg_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwcgvyg_required = true;
		}
	}
}

// the vvvvwcg Some function
function type_vvvvwcg_SomeFunc(type_vvvvwcg)
{
	// set the function logic
	if (type_vvvvwcg == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwch function
function vvvvwch(type_vvvvwch)
{
	if (isSet(type_vvvvwch) && type_vvvvwch.constructor !== Array)
	{
		var temp_vvvvwch = type_vvvvwch;
		var type_vvvvwch = [];
		type_vvvvwch.push(temp_vvvvwch);
	}
	else if (!isSet(type_vvvvwch))
	{
		var type_vvvvwch = [];
	}
	var type = type_vvvvwch.some(type_vvvvwch_SomeFunc);


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

// the vvvvwch Some function
function type_vvvvwch_SomeFunc(type_vvvvwch)
{
	// set the function logic
	if (type_vvvvwch == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwci function
function vvvvwci(target_vvvvwci)
{
	// set the function logic
	if (target_vvvvwci == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwcivyh_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwcivyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwcivyh_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwcivyh_required = true;
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
