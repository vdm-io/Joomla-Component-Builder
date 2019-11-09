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
jform_vvvvwdovyt_required = false;
jform_vvvvwdpvyu_required = false;
jform_vvvvwdqvyv_required = false;
jform_vvvvwdrvyw_required = false;
jform_vvvvwdtvyx_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwdo = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwdo(location_vvvvwdo);

	var location_vvvvwdp = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwdp(location_vvvvwdp);

	var type_vvvvwdq = jQuery("#jform_type").val();
	vvvvwdq(type_vvvvwdq);

	var type_vvvvwdr = jQuery("#jform_type").val();
	vvvvwdr(type_vvvvwdr);

	var type_vvvvwds = jQuery("#jform_type").val();
	vvvvwds(type_vvvvwds);

	var target_vvvvwdt = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwdt(target_vvvvwdt);
});

// the vvvvwdo function
function vvvvwdo(location_vvvvwdo)
{
	// set the function logic
	if (location_vvvvwdo == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwdovyt_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwdovyt_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwdovyt_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwdovyt_required = true;
		}
	}
}

// the vvvvwdp function
function vvvvwdp(location_vvvvwdp)
{
	// set the function logic
	if (location_vvvvwdp == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwdpvyu_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwdpvyu_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwdpvyu_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwdpvyu_required = true;
		}
	}
}

// the vvvvwdq function
function vvvvwdq(type_vvvvwdq)
{
	if (isSet(type_vvvvwdq) && type_vvvvwdq.constructor !== Array)
	{
		var temp_vvvvwdq = type_vvvvwdq;
		var type_vvvvwdq = [];
		type_vvvvwdq.push(temp_vvvvwdq);
	}
	else if (!isSet(type_vvvvwdq))
	{
		var type_vvvvwdq = [];
	}
	var type = type_vvvvwdq.some(type_vvvvwdq_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwdqvyv_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwdqvyv_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwdqvyv_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwdqvyv_required = true;
		}
	}
}

// the vvvvwdq Some function
function type_vvvvwdq_SomeFunc(type_vvvvwdq)
{
	// set the function logic
	if (type_vvvvwdq == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwdr function
function vvvvwdr(type_vvvvwdr)
{
	if (isSet(type_vvvvwdr) && type_vvvvwdr.constructor !== Array)
	{
		var temp_vvvvwdr = type_vvvvwdr;
		var type_vvvvwdr = [];
		type_vvvvwdr.push(temp_vvvvwdr);
	}
	else if (!isSet(type_vvvvwdr))
	{
		var type_vvvvwdr = [];
	}
	var type = type_vvvvwdr.some(type_vvvvwdr_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwdrvyw_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwdrvyw_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwdrvyw_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwdrvyw_required = true;
		}
	}
}

// the vvvvwdr Some function
function type_vvvvwdr_SomeFunc(type_vvvvwdr)
{
	// set the function logic
	if (type_vvvvwdr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwds function
function vvvvwds(type_vvvvwds)
{
	if (isSet(type_vvvvwds) && type_vvvvwds.constructor !== Array)
	{
		var temp_vvvvwds = type_vvvvwds;
		var type_vvvvwds = [];
		type_vvvvwds.push(temp_vvvvwds);
	}
	else if (!isSet(type_vvvvwds))
	{
		var type_vvvvwds = [];
	}
	var type = type_vvvvwds.some(type_vvvvwds_SomeFunc);


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

// the vvvvwds Some function
function type_vvvvwds_SomeFunc(type_vvvvwds)
{
	// set the function logic
	if (type_vvvvwds == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdt function
function vvvvwdt(target_vvvvwdt)
{
	// set the function logic
	if (target_vvvvwdt == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwdtvyx_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwdtvyx_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwdtvyx_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwdtvyx_required = true;
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
