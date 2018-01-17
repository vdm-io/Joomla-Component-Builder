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
jform_vvvvwaqwad_required = false;
jform_vvvvwarwae_required = false;
jform_vvvvwaswaf_required = false;
jform_vvvvwatwag_required = false;
jform_vvvvwauwah_required = false;
jform_vvvvwavwai_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwaq = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwaq(location_vvvvwaq);

	var location_vvvvwar = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwar(location_vvvvwar);

	var type_vvvvwas = jQuery("#jform_type").val();
	vvvvwas(type_vvvvwas);

	var type_vvvvwat = jQuery("#jform_type").val();
	vvvvwat(type_vvvvwat);

	var type_vvvvwau = jQuery("#jform_type").val();
	vvvvwau(type_vvvvwau);

	var target_vvvvwav = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwav(target_vvvvwav);
});

// the vvvvwaq function
function vvvvwaq(location_vvvvwaq)
{
	// set the function logic
	if (location_vvvvwaq == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwaqwad_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwaqwad_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwaqwad_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwaqwad_required = true;
		}
	}
}

// the vvvvwar function
function vvvvwar(location_vvvvwar)
{
	// set the function logic
	if (location_vvvvwar == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwarwae_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwarwae_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwarwae_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwarwae_required = true;
		}
	}
}

// the vvvvwas function
function vvvvwas(type_vvvvwas)
{
	if (isSet(type_vvvvwas) && type_vvvvwas.constructor !== Array)
	{
		var temp_vvvvwas = type_vvvvwas;
		var type_vvvvwas = [];
		type_vvvvwas.push(temp_vvvvwas);
	}
	else if (!isSet(type_vvvvwas))
	{
		var type_vvvvwas = [];
	}
	var type = type_vvvvwas.some(type_vvvvwas_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwaswaf_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwaswaf_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwaswaf_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwaswaf_required = true;
		}
	}
}

// the vvvvwas Some function
function type_vvvvwas_SomeFunc(type_vvvvwas)
{
	// set the function logic
	if (type_vvvvwas == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwat function
function vvvvwat(type_vvvvwat)
{
	if (isSet(type_vvvvwat) && type_vvvvwat.constructor !== Array)
	{
		var temp_vvvvwat = type_vvvvwat;
		var type_vvvvwat = [];
		type_vvvvwat.push(temp_vvvvwat);
	}
	else if (!isSet(type_vvvvwat))
	{
		var type_vvvvwat = [];
	}
	var type = type_vvvvwat.some(type_vvvvwat_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwatwag_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwatwag_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwatwag_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwatwag_required = true;
		}
	}
}

// the vvvvwat Some function
function type_vvvvwat_SomeFunc(type_vvvvwat)
{
	// set the function logic
	if (type_vvvvwat == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwau function
function vvvvwau(type_vvvvwau)
{
	if (isSet(type_vvvvwau) && type_vvvvwau.constructor !== Array)
	{
		var temp_vvvvwau = type_vvvvwau;
		var type_vvvvwau = [];
		type_vvvvwau.push(temp_vvvvwau);
	}
	else if (!isSet(type_vvvvwau))
	{
		var type_vvvvwau = [];
	}
	var type = type_vvvvwau.some(type_vvvvwau_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwauwah_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwauwah_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwauwah_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwauwah_required = true;
		}
	}
}

// the vvvvwau Some function
function type_vvvvwau_SomeFunc(type_vvvvwau)
{
	// set the function logic
	if (type_vvvvwau == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwav function
function vvvvwav(target_vvvvwav)
{
	// set the function logic
	if (target_vvvvwav == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwavwai_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwavwai_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwavwai_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwavwai_required = true;
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
