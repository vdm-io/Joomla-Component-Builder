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

	@version		@update number 6 of this MVC
	@build			17th October, 2016
	@created		4th March, 2016
	@package		Component Builder
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvwacvzx_required = false;
jform_vvvvwadvzy_required = false;
jform_vvvvwaevzz_required = false;
jform_vvvvwafwaa_required = false;
jform_vvvvwagwab_required = false;
jform_vvvvwahwac_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwac = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwac(location_vvvvwac);

	var location_vvvvwad = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwad(location_vvvvwad);

	var type_vvvvwae = jQuery("#jform_type").val();
	vvvvwae(type_vvvvwae);

	var type_vvvvwaf = jQuery("#jform_type").val();
	vvvvwaf(type_vvvvwaf);

	var type_vvvvwag = jQuery("#jform_type").val();
	vvvvwag(type_vvvvwag);

	var target_vvvvwah = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwah(target_vvvvwah);
});

// the vvvvwac function
function vvvvwac(location_vvvvwac)
{
	// set the function logic
	if (location_vvvvwac == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwacvzx_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwacvzx_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwacvzx_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwacvzx_required = true;
		}
	}
}

// the vvvvwad function
function vvvvwad(location_vvvvwad)
{
	// set the function logic
	if (location_vvvvwad == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwadvzy_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwadvzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwadvzy_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwadvzy_required = true;
		}
	}
}

// the vvvvwae function
function vvvvwae(type_vvvvwae)
{
	if (isSet(type_vvvvwae) && type_vvvvwae.constructor !== Array)
	{
		var temp_vvvvwae = type_vvvvwae;
		var type_vvvvwae = [];
		type_vvvvwae.push(temp_vvvvwae);
	}
	else if (!isSet(type_vvvvwae))
	{
		var type_vvvvwae = [];
	}
	var type = type_vvvvwae.some(type_vvvvwae_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwaevzz_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwaevzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwaevzz_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwaevzz_required = true;
		}
	}
}

// the vvvvwae Some function
function type_vvvvwae_SomeFunc(type_vvvvwae)
{
	// set the function logic
	if (type_vvvvwae == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwaf function
function vvvvwaf(type_vvvvwaf)
{
	if (isSet(type_vvvvwaf) && type_vvvvwaf.constructor !== Array)
	{
		var temp_vvvvwaf = type_vvvvwaf;
		var type_vvvvwaf = [];
		type_vvvvwaf.push(temp_vvvvwaf);
	}
	else if (!isSet(type_vvvvwaf))
	{
		var type_vvvvwaf = [];
	}
	var type = type_vvvvwaf.some(type_vvvvwaf_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwafwaa_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwafwaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwafwaa_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwafwaa_required = true;
		}
	}
}

// the vvvvwaf Some function
function type_vvvvwaf_SomeFunc(type_vvvvwaf)
{
	// set the function logic
	if (type_vvvvwaf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwag function
function vvvvwag(type_vvvvwag)
{
	if (isSet(type_vvvvwag) && type_vvvvwag.constructor !== Array)
	{
		var temp_vvvvwag = type_vvvvwag;
		var type_vvvvwag = [];
		type_vvvvwag.push(temp_vvvvwag);
	}
	else if (!isSet(type_vvvvwag))
	{
		var type_vvvvwag = [];
	}
	var type = type_vvvvwag.some(type_vvvvwag_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwagwab_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwagwab_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwagwab_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwagwab_required = true;
		}
	}
}

// the vvvvwag Some function
function type_vvvvwag_SomeFunc(type_vvvvwag)
{
	// set the function logic
	if (type_vvvvwag == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwah function
function vvvvwah(target_vvvvwah)
{
	// set the function logic
	if (target_vvvvwah == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwahwac_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwahwac_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwahwac_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwahwac_required = true;
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
