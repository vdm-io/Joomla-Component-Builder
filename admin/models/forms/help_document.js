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
jform_vvvvwbxwba_required = false;
jform_vvvvwbywbb_required = false;
jform_vvvvwbzwbc_required = false;
jform_vvvvwcawbd_required = false;
jform_vvvvwcbwbe_required = false;
jform_vvvvwccwbf_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwbx = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbx(location_vvvvwbx);

	var location_vvvvwby = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwby(location_vvvvwby);

	var type_vvvvwbz = jQuery("#jform_type").val();
	vvvvwbz(type_vvvvwbz);

	var type_vvvvwca = jQuery("#jform_type").val();
	vvvvwca(type_vvvvwca);

	var type_vvvvwcb = jQuery("#jform_type").val();
	vvvvwcb(type_vvvvwcb);

	var target_vvvvwcc = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcc(target_vvvvwcc);
});

// the vvvvwbx function
function vvvvwbx(location_vvvvwbx)
{
	// set the function logic
	if (location_vvvvwbx == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwbxwba_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwbxwba_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwbxwba_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwbxwba_required = true;
		}
	}
}

// the vvvvwby function
function vvvvwby(location_vvvvwby)
{
	// set the function logic
	if (location_vvvvwby == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwbywbb_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwbywbb_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwbywbb_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwbywbb_required = true;
		}
	}
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
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwbzwbc_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwbzwbc_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwbzwbc_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwbzwbc_required = true;
		}
	}
}

// the vvvvwbz Some function
function type_vvvvwbz_SomeFunc(type_vvvvwbz)
{
	// set the function logic
	if (type_vvvvwbz == 3)
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
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwcawbd_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwcawbd_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwcawbd_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwcawbd_required = true;
		}
	}
}

// the vvvvwca Some function
function type_vvvvwca_SomeFunc(type_vvvvwca)
{
	// set the function logic
	if (type_vvvvwca == 1)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_content-lbl').closest('.control-group').show();
		// add required attribute to content field
		if (jform_vvvvwcbwbe_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwcbwbe_required = false;
		}
	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		// remove required attribute from content field
		if (!jform_vvvvwcbwbe_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwcbwbe_required = true;
		}
	}
}

// the vvvvwcb Some function
function type_vvvvwcb_SomeFunc(type_vvvvwcb)
{
	// set the function logic
	if (type_vvvvwcb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcc function
function vvvvwcc(target_vvvvwcc)
{
	// set the function logic
	if (target_vvvvwcc == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwccwbf_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwccwbf_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwccwbf_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwccwbf_required = true;
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
