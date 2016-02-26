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
	@build			26th February, 2016
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
jform_CJOvFjPMfb_required = false;
jform_OrLFYFuYbG_required = false;
jform_DDFwHtoaXH_required = false;
jform_EzutdeDQOB_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_aqfwvYS = jQuery("#jform_location input[type='radio']:checked").val();
	aqfwvYS(location_aqfwvYS);

	var location_eUStEvD = jQuery("#jform_location input[type='radio']:checked").val();
	eUStEvD(location_eUStEvD);

	var type_CJOvFjP = jQuery("#jform_type").val();
	CJOvFjP(type_CJOvFjP);

	var type_OrLFYFu = jQuery("#jform_type").val();
	OrLFYFu(type_OrLFYFu);

	var type_DDFwHto = jQuery("#jform_type").val();
	DDFwHto(type_DDFwHto);

	var target_EzutdeD = jQuery("#jform_target input[type='radio']:checked").val();
	EzutdeD(target_EzutdeD);
});

// the aqfwvYS function
function aqfwvYS(location_aqfwvYS)
{
	// set the function logic
	if (location_aqfwvYS == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the eUStEvD function
function eUStEvD(location_eUStEvD)
{
	// set the function logic
	if (location_eUStEvD == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the CJOvFjP function
function CJOvFjP(type_CJOvFjP)
{
	if (isSet(type_CJOvFjP) && type_CJOvFjP.constructor !== Array)
	{
		var temp_CJOvFjP = type_CJOvFjP;
		var type_CJOvFjP = [];
		type_CJOvFjP.push(temp_CJOvFjP);
	}
	else if (!isSet(type_CJOvFjP))
	{
		var type_CJOvFjP = [];
	}
	var type = type_CJOvFjP.some(type_CJOvFjP_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_CJOvFjPMfb_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_CJOvFjPMfb_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_CJOvFjPMfb_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_CJOvFjPMfb_required = true;
		}
	}
}

// the CJOvFjP Some function
function type_CJOvFjP_SomeFunc(type_CJOvFjP)
{
	// set the function logic
	if (type_CJOvFjP == 3)
	{
		return true;
	}
	return false;
}

// the OrLFYFu function
function OrLFYFu(type_OrLFYFu)
{
	if (isSet(type_OrLFYFu) && type_OrLFYFu.constructor !== Array)
	{
		var temp_OrLFYFu = type_OrLFYFu;
		var type_OrLFYFu = [];
		type_OrLFYFu.push(temp_OrLFYFu);
	}
	else if (!isSet(type_OrLFYFu))
	{
		var type_OrLFYFu = [];
	}
	var type = type_OrLFYFu.some(type_OrLFYFu_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_OrLFYFuYbG_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_OrLFYFuYbG_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_OrLFYFuYbG_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_OrLFYFuYbG_required = true;
		}
	}
}

// the OrLFYFu Some function
function type_OrLFYFu_SomeFunc(type_OrLFYFu)
{
	// set the function logic
	if (type_OrLFYFu == 1)
	{
		return true;
	}
	return false;
}

// the DDFwHto function
function DDFwHto(type_DDFwHto)
{
	if (isSet(type_DDFwHto) && type_DDFwHto.constructor !== Array)
	{
		var temp_DDFwHto = type_DDFwHto;
		var type_DDFwHto = [];
		type_DDFwHto.push(temp_DDFwHto);
	}
	else if (!isSet(type_DDFwHto))
	{
		var type_DDFwHto = [];
	}
	var type = type_DDFwHto.some(type_DDFwHto_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_DDFwHtoaXH_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_DDFwHtoaXH_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_DDFwHtoaXH_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_DDFwHtoaXH_required = true;
		}
	}
}

// the DDFwHto Some function
function type_DDFwHto_SomeFunc(type_DDFwHto)
{
	// set the function logic
	if (type_DDFwHto == 2)
	{
		return true;
	}
	return false;
}

// the EzutdeD function
function EzutdeD(target_EzutdeD)
{
	// set the function logic
	if (target_EzutdeD == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_EzutdeDQOB_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_EzutdeDQOB_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_EzutdeDQOB_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_EzutdeDQOB_required = true;
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
