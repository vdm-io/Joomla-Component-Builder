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

	@version		2.1.0
	@build			18th February, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_wQQEDCwGYL_required = false;
jform_ttDwXdLEBi_required = false;
jform_EAELSyjEIZ_required = false;
jform_pgRfKoFgbD_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_HqDfZpa = jQuery("#jform_location input[type='radio']:checked").val();
	HqDfZpa(location_HqDfZpa);

	var location_zSERnNI = jQuery("#jform_location input[type='radio']:checked").val();
	zSERnNI(location_zSERnNI);

	var type_wQQEDCw = jQuery("#jform_type").val();
	wQQEDCw(type_wQQEDCw);

	var type_ttDwXdL = jQuery("#jform_type").val();
	ttDwXdL(type_ttDwXdL);

	var type_EAELSyj = jQuery("#jform_type").val();
	EAELSyj(type_EAELSyj);

	var target_pgRfKoF = jQuery("#jform_target input[type='radio']:checked").val();
	pgRfKoF(target_pgRfKoF);
});

// the HqDfZpa function
function HqDfZpa(location_HqDfZpa)
{
	// set the function logic
	if (location_HqDfZpa == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the zSERnNI function
function zSERnNI(location_zSERnNI)
{
	// set the function logic
	if (location_zSERnNI == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the wQQEDCw function
function wQQEDCw(type_wQQEDCw)
{
	if (isSet(type_wQQEDCw) && type_wQQEDCw.constructor !== Array)
	{
		var temp_wQQEDCw = type_wQQEDCw;
		var type_wQQEDCw = [];
		type_wQQEDCw.push(temp_wQQEDCw);
	}
	else if (!isSet(type_wQQEDCw))
	{
		var type_wQQEDCw = [];
	}
	var type = type_wQQEDCw.some(type_wQQEDCw_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_wQQEDCwGYL_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_wQQEDCwGYL_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_wQQEDCwGYL_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_wQQEDCwGYL_required = true;
		}
	}
}

// the wQQEDCw Some function
function type_wQQEDCw_SomeFunc(type_wQQEDCw)
{
	// set the function logic
	if (type_wQQEDCw == 3)
	{
		return true;
	}
	return false;
}

// the ttDwXdL function
function ttDwXdL(type_ttDwXdL)
{
	if (isSet(type_ttDwXdL) && type_ttDwXdL.constructor !== Array)
	{
		var temp_ttDwXdL = type_ttDwXdL;
		var type_ttDwXdL = [];
		type_ttDwXdL.push(temp_ttDwXdL);
	}
	else if (!isSet(type_ttDwXdL))
	{
		var type_ttDwXdL = [];
	}
	var type = type_ttDwXdL.some(type_ttDwXdL_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_ttDwXdLEBi_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_ttDwXdLEBi_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_ttDwXdLEBi_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_ttDwXdLEBi_required = true;
		}
	}
}

// the ttDwXdL Some function
function type_ttDwXdL_SomeFunc(type_ttDwXdL)
{
	// set the function logic
	if (type_ttDwXdL == 1)
	{
		return true;
	}
	return false;
}

// the EAELSyj function
function EAELSyj(type_EAELSyj)
{
	if (isSet(type_EAELSyj) && type_EAELSyj.constructor !== Array)
	{
		var temp_EAELSyj = type_EAELSyj;
		var type_EAELSyj = [];
		type_EAELSyj.push(temp_EAELSyj);
	}
	else if (!isSet(type_EAELSyj))
	{
		var type_EAELSyj = [];
	}
	var type = type_EAELSyj.some(type_EAELSyj_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_EAELSyjEIZ_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_EAELSyjEIZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_EAELSyjEIZ_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_EAELSyjEIZ_required = true;
		}
	}
}

// the EAELSyj Some function
function type_EAELSyj_SomeFunc(type_EAELSyj)
{
	// set the function logic
	if (type_EAELSyj == 2)
	{
		return true;
	}
	return false;
}

// the pgRfKoF function
function pgRfKoF(target_pgRfKoF)
{
	// set the function logic
	if (target_pgRfKoF == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_pgRfKoFgbD_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_pgRfKoFgbD_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_pgRfKoFgbD_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_pgRfKoFgbD_required = true;
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
