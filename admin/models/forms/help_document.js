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
jform_vvvvwekvyx_required = false;
jform_vvvvwelvyy_required = false;
jform_vvvvwemvyz_required = false;
jform_vvvvwenvza_required = false;
jform_vvvvwepvzb_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwek = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwek(location_vvvvwek);

	var location_vvvvwel = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwel(location_vvvvwel);

	var type_vvvvwem = jQuery("#jform_type").val();
	vvvvwem(type_vvvvwem);

	var type_vvvvwen = jQuery("#jform_type").val();
	vvvvwen(type_vvvvwen);

	var type_vvvvweo = jQuery("#jform_type").val();
	vvvvweo(type_vvvvweo);

	var target_vvvvwep = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwep(target_vvvvwep);
});

// the vvvvwek function
function vvvvwek(location_vvvvwek)
{
	// set the function logic
	if (location_vvvvwek == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwekvyx_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwekvyx_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwekvyx_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwekvyx_required = true;
		}
	}
}

// the vvvvwel function
function vvvvwel(location_vvvvwel)
{
	// set the function logic
	if (location_vvvvwel == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwelvyy_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwelvyy_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwelvyy_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwelvyy_required = true;
		}
	}
}

// the vvvvwem function
function vvvvwem(type_vvvvwem)
{
	if (isSet(type_vvvvwem) && type_vvvvwem.constructor !== Array)
	{
		var temp_vvvvwem = type_vvvvwem;
		var type_vvvvwem = [];
		type_vvvvwem.push(temp_vvvvwem);
	}
	else if (!isSet(type_vvvvwem))
	{
		var type_vvvvwem = [];
	}
	var type = type_vvvvwem.some(type_vvvvwem_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwemvyz_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwemvyz_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwemvyz_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwemvyz_required = true;
		}
	}
}

// the vvvvwem Some function
function type_vvvvwem_SomeFunc(type_vvvvwem)
{
	// set the function logic
	if (type_vvvvwem == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwen function
function vvvvwen(type_vvvvwen)
{
	if (isSet(type_vvvvwen) && type_vvvvwen.constructor !== Array)
	{
		var temp_vvvvwen = type_vvvvwen;
		var type_vvvvwen = [];
		type_vvvvwen.push(temp_vvvvwen);
	}
	else if (!isSet(type_vvvvwen))
	{
		var type_vvvvwen = [];
	}
	var type = type_vvvvwen.some(type_vvvvwen_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwenvza_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwenvza_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwenvza_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwenvza_required = true;
		}
	}
}

// the vvvvwen Some function
function type_vvvvwen_SomeFunc(type_vvvvwen)
{
	// set the function logic
	if (type_vvvvwen == 1)
	{
		return true;
	}
	return false;
}

// the vvvvweo function
function vvvvweo(type_vvvvweo)
{
	if (isSet(type_vvvvweo) && type_vvvvweo.constructor !== Array)
	{
		var temp_vvvvweo = type_vvvvweo;
		var type_vvvvweo = [];
		type_vvvvweo.push(temp_vvvvweo);
	}
	else if (!isSet(type_vvvvweo))
	{
		var type_vvvvweo = [];
	}
	var type = type_vvvvweo.some(type_vvvvweo_SomeFunc);


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

// the vvvvweo Some function
function type_vvvvweo_SomeFunc(type_vvvvweo)
{
	// set the function logic
	if (type_vvvvweo == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwep function
function vvvvwep(target_vvvvwep)
{
	// set the function logic
	if (target_vvvvwep == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvwepvzb_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwepvzb_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvwepvzb_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwepvzb_required = true;
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
