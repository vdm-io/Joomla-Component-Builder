/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwejvyn_required = false;
jform_vvvvwekvyo_required = false;
jform_vvvvwelvyp_required = false;
jform_vvvvwemvyq_required = false;
jform_vvvvweovyr_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwej = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwej(location_vvvvwej);

	var location_vvvvwek = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwek(location_vvvvwek);

	var type_vvvvwel = jQuery("#jform_type").val();
	vvvvwel(type_vvvvwel);

	var type_vvvvwem = jQuery("#jform_type").val();
	vvvvwem(type_vvvvwem);

	var type_vvvvwen = jQuery("#jform_type").val();
	vvvvwen(type_vvvvwen);

	var target_vvvvweo = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvweo(target_vvvvweo);
});

// the vvvvwej function
function vvvvwej(location_vvvvwej)
{
	// set the function logic
	if (location_vvvvwej == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		// add required attribute to admin_view field
		if (jform_vvvvwejvyn_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwejvyn_required = false;
		}
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		// remove required attribute from admin_view field
		if (!jform_vvvvwejvyn_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwejvyn_required = true;
		}
	}
}

// the vvvvwek function
function vvvvwek(location_vvvvwek)
{
	// set the function logic
	if (location_vvvvwek == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		// add required attribute to site_view field
		if (jform_vvvvwekvyo_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwekvyo_required = false;
		}
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		// remove required attribute from site_view field
		if (!jform_vvvvwekvyo_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwekvyo_required = true;
		}
	}
}

// the vvvvwel function
function vvvvwel(type_vvvvwel)
{
	if (isSet(type_vvvvwel) && type_vvvvwel.constructor !== Array)
	{
		var temp_vvvvwel = type_vvvvwel;
		var type_vvvvwel = [];
		type_vvvvwel.push(temp_vvvvwel);
	}
	else if (!isSet(type_vvvvwel))
	{
		var type_vvvvwel = [];
	}
	var type = type_vvvvwel.some(type_vvvvwel_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		// add required attribute to url field
		if (jform_vvvvwelvyp_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwelvyp_required = false;
		}
	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		// remove required attribute from url field
		if (!jform_vvvvwelvyp_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwelvyp_required = true;
		}
	}
}

// the vvvvwel Some function
function type_vvvvwel_SomeFunc(type_vvvvwel)
{
	// set the function logic
	if (type_vvvvwel == 3)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_article').closest('.control-group').show();
		// add required attribute to article field
		if (jform_vvvvwemvyq_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwemvyq_required = false;
		}
	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		// remove required attribute from article field
		if (!jform_vvvvwemvyq_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwemvyq_required = true;
		}
	}
}

// the vvvvwem Some function
function type_vvvvwem_SomeFunc(type_vvvvwem)
{
	// set the function logic
	if (type_vvvvwem == 1)
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
		jQuery('#jform_content-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
	}
}

// the vvvvwen Some function
function type_vvvvwen_SomeFunc(type_vvvvwen)
{
	// set the function logic
	if (type_vvvvwen == 2)
	{
		return true;
	}
	return false;
}

// the vvvvweo function
function vvvvweo(target_vvvvweo)
{
	// set the function logic
	if (target_vvvvweo == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		// add required attribute to groups field
		if (jform_vvvvweovyr_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvweovyr_required = false;
		}
	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		// remove required attribute from groups field
		if (!jform_vvvvweovyr_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvweovyr_required = true;
		}
	}
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (jQuery('#jform_not_required').length > 0) {
		var not_required = jQuery('#jform_not_required').val().split(",");

		if(status == 1)
		{
			not_required.push(name);
		}
		else
		{
			not_required = removeFieldFromNotRequired(not_required, name);
		}

		jQuery('#jform_not_required').val(fixNotRequiredArray(not_required).toString());
	}
}

// remove field from not_required
function removeFieldFromNotRequired(array, what) {
	return array.filter(function(element){
		return element !== what;
	});
}

// fix not required array
function fixNotRequiredArray(array) {
	var seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function(item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

// remove empty from not_required array
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		// remove ( 一_一) as well - lol
		return (el.length > 0 && '一_一' !== el);
	});
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
} 
