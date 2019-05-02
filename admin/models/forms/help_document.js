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
jform_vvvvwbwwax_required = false;
jform_vvvvwbxway_required = false;
jform_vvvvwbywaz_required = false;
jform_vvvvwbzwba_required = false;
jform_vvvvwcawbb_required = false;
jform_vvvvwcbwbc_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwbw = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbw(location_vvvvwbw);

	var location_vvvvwbx = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbx(location_vvvvwbx);

	var type_vvvvwby = jQuery("#jform_type").val();
	vvvvwby(type_vvvvwby);

	var type_vvvvwbz = jQuery("#jform_type").val();
	vvvvwbz(type_vvvvwbz);

	var type_vvvvwca = jQuery("#jform_type").val();
	vvvvwca(type_vvvvwca);

	var target_vvvvwcb = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcb(target_vvvvwcb);
});

// the vvvvwbw function
function vvvvwbw(location_vvvvwbw)
{
	// set the function logic
	if (location_vvvvwbw == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwbwwax_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwbwwax_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwbwwax_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwbwwax_required = true;
		}
	}
}

// the vvvvwbx function
function vvvvwbx(location_vvvvwbx)
{
	// set the function logic
	if (location_vvvvwbx == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwbxway_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwbxway_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwbxway_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwbxway_required = true;
		}
	}
}

// the vvvvwby function
function vvvvwby(type_vvvvwby)
{
	if (isSet(type_vvvvwby) && type_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = type_vvvvwby;
		var type_vvvvwby = [];
		type_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(type_vvvvwby))
	{
		var type_vvvvwby = [];
	}
	var type = type_vvvvwby.some(type_vvvvwby_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwbywaz_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwbywaz_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwbywaz_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwbywaz_required = true;
		}
	}
}

// the vvvvwby Some function
function type_vvvvwby_SomeFunc(type_vvvvwby)
{
	// set the function logic
	if (type_vvvvwby == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbz function
function vvvvwbz(type_vvvvwbz)
{
	if (isSet(type_vvvvwbz) && type_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = type_vvvvwbz;
		var type_vvvvwbz = [];
		type_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(type_vvvvwbz))
	{
		var type_vvvvwbz = [];
	}
	var type = type_vvvvwbz.some(type_vvvvwbz_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwbzwba_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwbzwba_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwbzwba_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwbzwba_required = true;
		}
	}
}

// the vvvvwbz Some function
function type_vvvvwbz_SomeFunc(type_vvvvwbz)
{
	// set the function logic
	if (type_vvvvwbz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwca function
function vvvvwca(type_vvvvwca)
{
	if (isSet(type_vvvvwca) && type_vvvvwca.constructor !== Array)
	{
		var temp_vvvvwca = type_vvvvwca;
		var type_vvvvwca = [];
		type_vvvvwca.push(temp_vvvvwca);
	}
	else if (!isSet(type_vvvvwca))
	{
		var type_vvvvwca = [];
	}
	var type = type_vvvvwca.some(type_vvvvwca_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		// add required attribute to content field
		if (jform_vvvvwcawbb_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwcawbb_required = false;
		}
	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		// remove required attribute from content field
		if (!jform_vvvvwcawbb_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwcawbb_required = true;
		}
	}
}

// the vvvvwca Some function
function type_vvvvwca_SomeFunc(type_vvvvwca)
{
	// set the function logic
	if (type_vvvvwca == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcb function
function vvvvwcb(target_vvvvwcb)
{
	// set the function logic
	if (target_vvvvwcb == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwcbwbc_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwcbwbc_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwcbwbc_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwcbwbc_required = true;
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
