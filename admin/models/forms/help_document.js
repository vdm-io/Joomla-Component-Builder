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

	@version		2.2.0
	@build			23rd October, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzpvzm_required = false;
jform_vvvvvzqvzn_required = false;
jform_vvvvvzrvzo_required = false;
jform_vvvvvzsvzp_required = false;
jform_vvvvvztvzq_required = false;
jform_vvvvvzuvzr_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvvzp = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzp(location_vvvvvzp);

	var location_vvvvvzq = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzq(location_vvvvvzq);

	var type_vvvvvzr = jQuery("#jform_type").val();
	vvvvvzr(type_vvvvvzr);

	var type_vvvvvzs = jQuery("#jform_type").val();
	vvvvvzs(type_vvvvvzs);

	var type_vvvvvzt = jQuery("#jform_type").val();
	vvvvvzt(type_vvvvvzt);

	var target_vvvvvzu = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzu(target_vvvvvzu);
});

// the vvvvvzp function
function vvvvvzp(location_vvvvvzp)
{
	// set the function logic
	if (location_vvvvvzp == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvvzpvzm_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvvzpvzm_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvvzpvzm_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvvzpvzm_required = true;
		}
	}
}

// the vvvvvzq function
function vvvvvzq(location_vvvvvzq)
{
	// set the function logic
	if (location_vvvvvzq == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvvzqvzn_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvvzqvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvvzqvzn_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvvzqvzn_required = true;
		}
	}
}

// the vvvvvzr function
function vvvvvzr(type_vvvvvzr)
{
	if (isSet(type_vvvvvzr) && type_vvvvvzr.constructor !== Array)
	{
		var temp_vvvvvzr = type_vvvvvzr;
		var type_vvvvvzr = [];
		type_vvvvvzr.push(temp_vvvvvzr);
	}
	else if (!isSet(type_vvvvvzr))
	{
		var type_vvvvvzr = [];
	}
	var type = type_vvvvvzr.some(type_vvvvvzr_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvvzrvzo_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvvzrvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvvzrvzo_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvvzrvzo_required = true;
		}
	}
}

// the vvvvvzr Some function
function type_vvvvvzr_SomeFunc(type_vvvvvzr)
{
	// set the function logic
	if (type_vvvvvzr == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzs function
function vvvvvzs(type_vvvvvzs)
{
	if (isSet(type_vvvvvzs) && type_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = type_vvvvvzs;
		var type_vvvvvzs = [];
		type_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(type_vvvvvzs))
	{
		var type_vvvvvzs = [];
	}
	var type = type_vvvvvzs.some(type_vvvvvzs_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvvzsvzp_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvvzsvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvvzsvzp_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvvzsvzp_required = true;
		}
	}
}

// the vvvvvzs Some function
function type_vvvvvzs_SomeFunc(type_vvvvvzs)
{
	// set the function logic
	if (type_vvvvvzs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzt function
function vvvvvzt(type_vvvvvzt)
{
	if (isSet(type_vvvvvzt) && type_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = type_vvvvvzt;
		var type_vvvvvzt = [];
		type_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(type_vvvvvzt))
	{
		var type_vvvvvzt = [];
	}
	var type = type_vvvvvzt.some(type_vvvvvzt_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvvztvzq_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvvztvzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvvztvzq_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvvztvzq_required = true;
		}
	}
}

// the vvvvvzt Some function
function type_vvvvvzt_SomeFunc(type_vvvvvzt)
{
	// set the function logic
	if (type_vvvvvzt == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzu function
function vvvvvzu(target_vvvvvzu)
{
	// set the function logic
	if (target_vvvvvzu == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvvzuvzr_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvvzuvzr_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvvzuvzr_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvvzuvzr_required = true;
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
