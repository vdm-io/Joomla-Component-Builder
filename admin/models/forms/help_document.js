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
jform_vvvvwaewaf_required = false;
jform_vvvvwafwag_required = false;
jform_vvvvwagwah_required = false;
jform_vvvvwahwai_required = false;
jform_vvvvwaiwaj_required = false;
jform_vvvvwajwak_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwae = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwae(location_vvvvwae);

	var location_vvvvwaf = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwaf(location_vvvvwaf);

	var type_vvvvwag = jQuery("#jform_type").val();
	vvvvwag(type_vvvvwag);

	var type_vvvvwah = jQuery("#jform_type").val();
	vvvvwah(type_vvvvwah);

	var type_vvvvwai = jQuery("#jform_type").val();
	vvvvwai(type_vvvvwai);

	var target_vvvvwaj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwaj(target_vvvvwaj);
});

// the vvvvwae function
function vvvvwae(location_vvvvwae)
{
	// set the function logic
	if (location_vvvvwae == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwaewaf_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwaewaf_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwaewaf_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwaewaf_required = true;
		}
	}
}

// the vvvvwaf function
function vvvvwaf(location_vvvvwaf)
{
	// set the function logic
	if (location_vvvvwaf == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwafwag_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwafwag_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwafwag_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwafwag_required = true;
		}
	}
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
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwagwah_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwagwah_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwagwah_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwagwah_required = true;
		}
	}
}

// the vvvvwag Some function
function type_vvvvwag_SomeFunc(type_vvvvwag)
{
	// set the function logic
	if (type_vvvvwag == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwah function
function vvvvwah(type_vvvvwah)
{
	if (isSet(type_vvvvwah) && type_vvvvwah.constructor !== Array)
	{
		var temp_vvvvwah = type_vvvvwah;
		var type_vvvvwah = [];
		type_vvvvwah.push(temp_vvvvwah);
	}
	else if (!isSet(type_vvvvwah))
	{
		var type_vvvvwah = [];
	}
	var type = type_vvvvwah.some(type_vvvvwah_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwahwai_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwahwai_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwahwai_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwahwai_required = true;
		}
	}
}

// the vvvvwah Some function
function type_vvvvwah_SomeFunc(type_vvvvwah)
{
	// set the function logic
	if (type_vvvvwah == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwai function
function vvvvwai(type_vvvvwai)
{
	if (isSet(type_vvvvwai) && type_vvvvwai.constructor !== Array)
	{
		var temp_vvvvwai = type_vvvvwai;
		var type_vvvvwai = [];
		type_vvvvwai.push(temp_vvvvwai);
	}
	else if (!isSet(type_vvvvwai))
	{
		var type_vvvvwai = [];
	}
	var type = type_vvvvwai.some(type_vvvvwai_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwaiwaj_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwaiwaj_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwaiwaj_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwaiwaj_required = true;
		}
	}
}

// the vvvvwai Some function
function type_vvvvwai_SomeFunc(type_vvvvwai)
{
	// set the function logic
	if (type_vvvvwai == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwaj function
function vvvvwaj(target_vvvvwaj)
{
	// set the function logic
	if (target_vvvvwaj == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwajwak_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwajwak_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwajwak_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwajwak_required = true;
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
