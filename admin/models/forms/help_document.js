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
	@build			20th February, 2016
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
jform_LktRHjRudC_required = false;
jform_IKNpMXPzwX_required = false;
jform_nTcKIyHauT_required = false;
jform_ZabAQNCGdM_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_TriKDfz = jQuery("#jform_location input[type='radio']:checked").val();
	TriKDfz(location_TriKDfz);

	var location_JvRrQqZ = jQuery("#jform_location input[type='radio']:checked").val();
	JvRrQqZ(location_JvRrQqZ);

	var type_LktRHjR = jQuery("#jform_type").val();
	LktRHjR(type_LktRHjR);

	var type_IKNpMXP = jQuery("#jform_type").val();
	IKNpMXP(type_IKNpMXP);

	var type_nTcKIyH = jQuery("#jform_type").val();
	nTcKIyH(type_nTcKIyH);

	var target_ZabAQNC = jQuery("#jform_target input[type='radio']:checked").val();
	ZabAQNC(target_ZabAQNC);
});

// the TriKDfz function
function TriKDfz(location_TriKDfz)
{
	// set the function logic
	if (location_TriKDfz == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the JvRrQqZ function
function JvRrQqZ(location_JvRrQqZ)
{
	// set the function logic
	if (location_JvRrQqZ == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the LktRHjR function
function LktRHjR(type_LktRHjR)
{
	if (isSet(type_LktRHjR) && type_LktRHjR.constructor !== Array)
	{
		var temp_LktRHjR = type_LktRHjR;
		var type_LktRHjR = [];
		type_LktRHjR.push(temp_LktRHjR);
	}
	else if (!isSet(type_LktRHjR))
	{
		var type_LktRHjR = [];
	}
	var type = type_LktRHjR.some(type_LktRHjR_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_LktRHjRudC_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_LktRHjRudC_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_LktRHjRudC_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_LktRHjRudC_required = true;
		}
	}
}

// the LktRHjR Some function
function type_LktRHjR_SomeFunc(type_LktRHjR)
{
	// set the function logic
	if (type_LktRHjR == 3)
	{
		return true;
	}
	return false;
}

// the IKNpMXP function
function IKNpMXP(type_IKNpMXP)
{
	if (isSet(type_IKNpMXP) && type_IKNpMXP.constructor !== Array)
	{
		var temp_IKNpMXP = type_IKNpMXP;
		var type_IKNpMXP = [];
		type_IKNpMXP.push(temp_IKNpMXP);
	}
	else if (!isSet(type_IKNpMXP))
	{
		var type_IKNpMXP = [];
	}
	var type = type_IKNpMXP.some(type_IKNpMXP_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_IKNpMXPzwX_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_IKNpMXPzwX_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_IKNpMXPzwX_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_IKNpMXPzwX_required = true;
		}
	}
}

// the IKNpMXP Some function
function type_IKNpMXP_SomeFunc(type_IKNpMXP)
{
	// set the function logic
	if (type_IKNpMXP == 1)
	{
		return true;
	}
	return false;
}

// the nTcKIyH function
function nTcKIyH(type_nTcKIyH)
{
	if (isSet(type_nTcKIyH) && type_nTcKIyH.constructor !== Array)
	{
		var temp_nTcKIyH = type_nTcKIyH;
		var type_nTcKIyH = [];
		type_nTcKIyH.push(temp_nTcKIyH);
	}
	else if (!isSet(type_nTcKIyH))
	{
		var type_nTcKIyH = [];
	}
	var type = type_nTcKIyH.some(type_nTcKIyH_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_nTcKIyHauT_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_nTcKIyHauT_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_nTcKIyHauT_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_nTcKIyHauT_required = true;
		}
	}
}

// the nTcKIyH Some function
function type_nTcKIyH_SomeFunc(type_nTcKIyH)
{
	// set the function logic
	if (type_nTcKIyH == 2)
	{
		return true;
	}
	return false;
}

// the ZabAQNC function
function ZabAQNC(target_ZabAQNC)
{
	// set the function logic
	if (target_ZabAQNC == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_ZabAQNCGdM_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_ZabAQNCGdM_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_ZabAQNCGdM_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_ZabAQNCGdM_required = true;
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
