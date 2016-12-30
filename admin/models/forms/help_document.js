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

	@version		2.2.6
	@build			30th December, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzyvzq_required = false;
jform_vvvvvzzvzr_required = false;
jform_vvvvwaavzs_required = false;
jform_vvvvwabvzt_required = false;
jform_vvvvwacvzu_required = false;
jform_vvvvwadvzv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvvzy = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzy(location_vvvvvzy);

	var location_vvvvvzz = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzz(location_vvvvvzz);

	var type_vvvvwaa = jQuery("#jform_type").val();
	vvvvwaa(type_vvvvwaa);

	var type_vvvvwab = jQuery("#jform_type").val();
	vvvvwab(type_vvvvwab);

	var type_vvvvwac = jQuery("#jform_type").val();
	vvvvwac(type_vvvvwac);

	var target_vvvvwad = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwad(target_vvvvwad);
});

// the vvvvvzy function
function vvvvvzy(location_vvvvvzy)
{
	// set the function logic
	if (location_vvvvvzy == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvvzyvzq_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvvzyvzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvvzyvzq_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvvzyvzq_required = true;
		}
	}
}

// the vvvvvzz function
function vvvvvzz(location_vvvvvzz)
{
	// set the function logic
	if (location_vvvvvzz == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvvzzvzr_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvvzzvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvvzzvzr_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvvzzvzr_required = true;
		}
	}
}

// the vvvvwaa function
function vvvvwaa(type_vvvvwaa)
{
	if (isSet(type_vvvvwaa) && type_vvvvwaa.constructor !== Array)
	{
		var temp_vvvvwaa = type_vvvvwaa;
		var type_vvvvwaa = [];
		type_vvvvwaa.push(temp_vvvvwaa);
	}
	else if (!isSet(type_vvvvwaa))
	{
		var type_vvvvwaa = [];
	}
	var type = type_vvvvwaa.some(type_vvvvwaa_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwaavzs_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwaavzs_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwaavzs_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwaavzs_required = true;
		}
	}
}

// the vvvvwaa Some function
function type_vvvvwaa_SomeFunc(type_vvvvwaa)
{
	// set the function logic
	if (type_vvvvwaa == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwab function
function vvvvwab(type_vvvvwab)
{
	if (isSet(type_vvvvwab) && type_vvvvwab.constructor !== Array)
	{
		var temp_vvvvwab = type_vvvvwab;
		var type_vvvvwab = [];
		type_vvvvwab.push(temp_vvvvwab);
	}
	else if (!isSet(type_vvvvwab))
	{
		var type_vvvvwab = [];
	}
	var type = type_vvvvwab.some(type_vvvvwab_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwabvzt_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwabvzt_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwabvzt_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwabvzt_required = true;
		}
	}
}

// the vvvvwab Some function
function type_vvvvwab_SomeFunc(type_vvvvwab)
{
	// set the function logic
	if (type_vvvvwab == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwac function
function vvvvwac(type_vvvvwac)
{
	if (isSet(type_vvvvwac) && type_vvvvwac.constructor !== Array)
	{
		var temp_vvvvwac = type_vvvvwac;
		var type_vvvvwac = [];
		type_vvvvwac.push(temp_vvvvwac);
	}
	else if (!isSet(type_vvvvwac))
	{
		var type_vvvvwac = [];
	}
	var type = type_vvvvwac.some(type_vvvvwac_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwacvzu_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwacvzu_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwacvzu_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwacvzu_required = true;
		}
	}
}

// the vvvvwac Some function
function type_vvvvwac_SomeFunc(type_vvvvwac)
{
	// set the function logic
	if (type_vvvvwac == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwad function
function vvvvwad(target_vvvvwad)
{
	// set the function logic
	if (target_vvvvwad == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwadvzv_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwadvzv_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwadvzv_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwadvzv_required = true;
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
