/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvwatwaf_required = false;
jform_vvvvwauwag_required = false;
jform_vvvvwavwah_required = false;
jform_vvvvwawwai_required = false;
jform_vvvvwaxwaj_required = false;
jform_vvvvwaywak_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwat = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwat(location_vvvvwat);

	var location_vvvvwau = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwau(location_vvvvwau);

	var type_vvvvwav = jQuery("#jform_type").val();
	vvvvwav(type_vvvvwav);

	var type_vvvvwaw = jQuery("#jform_type").val();
	vvvvwaw(type_vvvvwaw);

	var type_vvvvwax = jQuery("#jform_type").val();
	vvvvwax(type_vvvvwax);

	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvway(target_vvvvway);
});

// the vvvvwat function
function vvvvwat(location_vvvvwat)
{
	// set the function logic
	if (location_vvvvwat == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwatwaf_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwatwaf_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwatwaf_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwatwaf_required = true;
		}
	}
}

// the vvvvwau function
function vvvvwau(location_vvvvwau)
{
	// set the function logic
	if (location_vvvvwau == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwauwag_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwauwag_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwauwag_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwauwag_required = true;
		}
	}
}

// the vvvvwav function
function vvvvwav(type_vvvvwav)
{
	if (isSet(type_vvvvwav) && type_vvvvwav.constructor !== Array)
	{
		var temp_vvvvwav = type_vvvvwav;
		var type_vvvvwav = [];
		type_vvvvwav.push(temp_vvvvwav);
	}
	else if (!isSet(type_vvvvwav))
	{
		var type_vvvvwav = [];
	}
	var type = type_vvvvwav.some(type_vvvvwav_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwavwah_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwavwah_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwavwah_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwavwah_required = true;
		}
	}
}

// the vvvvwav Some function
function type_vvvvwav_SomeFunc(type_vvvvwav)
{
	// set the function logic
	if (type_vvvvwav == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwaw function
function vvvvwaw(type_vvvvwaw)
{
	if (isSet(type_vvvvwaw) && type_vvvvwaw.constructor !== Array)
	{
		var temp_vvvvwaw = type_vvvvwaw;
		var type_vvvvwaw = [];
		type_vvvvwaw.push(temp_vvvvwaw);
	}
	else if (!isSet(type_vvvvwaw))
	{
		var type_vvvvwaw = [];
	}
	var type = type_vvvvwaw.some(type_vvvvwaw_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwawwai_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwawwai_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwawwai_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwawwai_required = true;
		}
	}
}

// the vvvvwaw Some function
function type_vvvvwaw_SomeFunc(type_vvvvwaw)
{
	// set the function logic
	if (type_vvvvwaw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwax function
function vvvvwax(type_vvvvwax)
{
	if (isSet(type_vvvvwax) && type_vvvvwax.constructor !== Array)
	{
		var temp_vvvvwax = type_vvvvwax;
		var type_vvvvwax = [];
		type_vvvvwax.push(temp_vvvvwax);
	}
	else if (!isSet(type_vvvvwax))
	{
		var type_vvvvwax = [];
	}
	var type = type_vvvvwax.some(type_vvvvwax_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwaxwaj_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwaxwaj_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwaxwaj_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwaxwaj_required = true;
		}
	}
}

// the vvvvwax Some function
function type_vvvvwax_SomeFunc(type_vvvvwax)
{
	// set the function logic
	if (type_vvvvwax == 2)
	{
		return true;
	}
	return false;
}

// the vvvvway function
function vvvvway(target_vvvvway)
{
	// set the function logic
	if (target_vvvvway == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwaywak_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwaywak_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwaywak_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwaywak_required = true;
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
