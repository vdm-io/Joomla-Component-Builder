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
jform_vvvvwdnvyt_required = false;
jform_vvvvwdovyu_required = false;
jform_vvvvwdpvyv_required = false;
jform_vvvvwdqvyw_required = false;
jform_vvvvwdsvyx_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwdn = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwdn(location_vvvvwdn);

	var location_vvvvwdo = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwdo(location_vvvvwdo);

	var type_vvvvwdp = jQuery("#jform_type").val();
	vvvvwdp(type_vvvvwdp);

	var type_vvvvwdq = jQuery("#jform_type").val();
	vvvvwdq(type_vvvvwdq);

	var type_vvvvwdr = jQuery("#jform_type").val();
	vvvvwdr(type_vvvvwdr);

	var target_vvvvwds = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwds(target_vvvvwds);
});

// the vvvvwdn function
function vvvvwdn(location_vvvvwdn)
{
	// set the function logic
	if (location_vvvvwdn == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwdnvyt_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwdnvyt_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwdnvyt_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwdnvyt_required = true;
		}
	}
}

// the vvvvwdo function
function vvvvwdo(location_vvvvwdo)
{
	// set the function logic
	if (location_vvvvwdo == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwdovyu_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwdovyu_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwdovyu_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwdovyu_required = true;
		}
	}
}

// the vvvvwdp function
function vvvvwdp(type_vvvvwdp)
{
	if (isSet(type_vvvvwdp) && type_vvvvwdp.constructor !== Array)
	{
		var temp_vvvvwdp = type_vvvvwdp;
		var type_vvvvwdp = [];
		type_vvvvwdp.push(temp_vvvvwdp);
	}
	else if (!isSet(type_vvvvwdp))
	{
		var type_vvvvwdp = [];
	}
	var type = type_vvvvwdp.some(type_vvvvwdp_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwdpvyv_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwdpvyv_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwdpvyv_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwdpvyv_required = true;
		}
	}
}

// the vvvvwdp Some function
function type_vvvvwdp_SomeFunc(type_vvvvwdp)
{
	// set the function logic
	if (type_vvvvwdp == 3)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwdqvyw_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwdqvyw_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwdqvyw_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwdqvyw_required = true;
		}
	}
}

// the vvvvwdq Some function
function type_vvvvwdq_SomeFunc(type_vvvvwdq)
{
	// set the function logic
	if (type_vvvvwdq == 1)
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
		jQuery('#jform_content-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
	}
}

// the vvvvwdr Some function
function type_vvvvwdr_SomeFunc(type_vvvvwdr)
{
	// set the function logic
	if (type_vvvvwdr == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwds function
function vvvvwds(target_vvvvwds)
{
	// set the function logic
	if (target_vvvvwds == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwdsvyx_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwdsvyx_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwdsvyx_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwdsvyx_required = true;
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
