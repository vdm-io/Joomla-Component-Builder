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
jform_vvvvwcgvye_required = false;
jform_vvvvwchvyf_required = false;
jform_vvvvwcivyg_required = false;
jform_vvvvwcjvyh_required = false;
jform_vvvvwclvyi_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwcg = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwcg(location_vvvvwcg);

	var location_vvvvwch = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwch(location_vvvvwch);

	var type_vvvvwci = jQuery("#jform_type").val();
	vvvvwci(type_vvvvwci);

	var type_vvvvwcj = jQuery("#jform_type").val();
	vvvvwcj(type_vvvvwcj);

	var type_vvvvwck = jQuery("#jform_type").val();
	vvvvwck(type_vvvvwck);

	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(target_vvvvwcl);
});

// the vvvvwcg function
function vvvvwcg(location_vvvvwcg)
{
	// set the function logic
	if (location_vvvvwcg == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwcgvye_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwcgvye_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwcgvye_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwcgvye_required = true;
		}
	}
}

// the vvvvwch function
function vvvvwch(location_vvvvwch)
{
	// set the function logic
	if (location_vvvvwch == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwchvyf_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwchvyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwchvyf_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwchvyf_required = true;
		}
	}
}

// the vvvvwci function
function vvvvwci(type_vvvvwci)
{
	if (isSet(type_vvvvwci) && type_vvvvwci.constructor !== Array)
	{
		var temp_vvvvwci = type_vvvvwci;
		var type_vvvvwci = [];
		type_vvvvwci.push(temp_vvvvwci);
	}
	else if (!isSet(type_vvvvwci))
	{
		var type_vvvvwci = [];
	}
	var type = type_vvvvwci.some(type_vvvvwci_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwcivyg_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwcivyg_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwcivyg_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwcivyg_required = true;
		}
	}
}

// the vvvvwci Some function
function type_vvvvwci_SomeFunc(type_vvvvwci)
{
	// set the function logic
	if (type_vvvvwci == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcj function
function vvvvwcj(type_vvvvwcj)
{
	if (isSet(type_vvvvwcj) && type_vvvvwcj.constructor !== Array)
	{
		var temp_vvvvwcj = type_vvvvwcj;
		var type_vvvvwcj = [];
		type_vvvvwcj.push(temp_vvvvwcj);
	}
	else if (!isSet(type_vvvvwcj))
	{
		var type_vvvvwcj = [];
	}
	var type = type_vvvvwcj.some(type_vvvvwcj_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwcjvyh_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwcjvyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwcjvyh_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwcjvyh_required = true;
		}
	}
}

// the vvvvwcj Some function
function type_vvvvwcj_SomeFunc(type_vvvvwcj)
{
	// set the function logic
	if (type_vvvvwcj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwck function
function vvvvwck(type_vvvvwck)
{
	if (isSet(type_vvvvwck) && type_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = type_vvvvwck;
		var type_vvvvwck = [];
		type_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(type_vvvvwck))
	{
		var type_vvvvwck = [];
	}
	var type = type_vvvvwck.some(type_vvvvwck_SomeFunc);


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

// the vvvvwck Some function
function type_vvvvwck_SomeFunc(type_vvvvwck)
{
	// set the function logic
	if (type_vvvvwck == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcl function
function vvvvwcl(target_vvvvwcl)
{
	// set the function logic
	if (target_vvvvwcl == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwclvyi_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwclvyi_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwclvyi_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwclvyi_required = true;
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
