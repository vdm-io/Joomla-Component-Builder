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

	@version		2.0.9
	@build			15th February, 2016
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
jform_ziCMfZGmmZ_required = false;
jform_EnWPFlGsyX_required = false;
jform_FRmRFoEGoi_required = false;
jform_SJsvpxCUFN_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_KgqqAok = jQuery("#jform_location input[type='radio']:checked").val();
	KgqqAok(location_KgqqAok);

	var location_IcLfUBn = jQuery("#jform_location input[type='radio']:checked").val();
	IcLfUBn(location_IcLfUBn);

	var type_ziCMfZG = jQuery("#jform_type").val();
	ziCMfZG(type_ziCMfZG);

	var type_EnWPFlG = jQuery("#jform_type").val();
	EnWPFlG(type_EnWPFlG);

	var type_FRmRFoE = jQuery("#jform_type").val();
	FRmRFoE(type_FRmRFoE);

	var target_SJsvpxC = jQuery("#jform_target input[type='radio']:checked").val();
	SJsvpxC(target_SJsvpxC);
});

// the KgqqAok function
function KgqqAok(location_KgqqAok)
{
	// set the function logic
	if (location_KgqqAok == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the IcLfUBn function
function IcLfUBn(location_IcLfUBn)
{
	// set the function logic
	if (location_IcLfUBn == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the ziCMfZG function
function ziCMfZG(type_ziCMfZG)
{
	if (isSet(type_ziCMfZG) && type_ziCMfZG.constructor !== Array)
	{
		var temp_ziCMfZG = type_ziCMfZG;
		var type_ziCMfZG = [];
		type_ziCMfZG.push(temp_ziCMfZG);
	}
	else if (!isSet(type_ziCMfZG))
	{
		var type_ziCMfZG = [];
	}
	var type = type_ziCMfZG.some(type_ziCMfZG_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_ziCMfZGmmZ_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_ziCMfZGmmZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_ziCMfZGmmZ_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_ziCMfZGmmZ_required = true;
		}
	}
}

// the ziCMfZG Some function
function type_ziCMfZG_SomeFunc(type_ziCMfZG)
{
	// set the function logic
	if (type_ziCMfZG == 3)
	{
		return true;
	}
	return false;
}

// the EnWPFlG function
function EnWPFlG(type_EnWPFlG)
{
	if (isSet(type_EnWPFlG) && type_EnWPFlG.constructor !== Array)
	{
		var temp_EnWPFlG = type_EnWPFlG;
		var type_EnWPFlG = [];
		type_EnWPFlG.push(temp_EnWPFlG);
	}
	else if (!isSet(type_EnWPFlG))
	{
		var type_EnWPFlG = [];
	}
	var type = type_EnWPFlG.some(type_EnWPFlG_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_EnWPFlGsyX_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_EnWPFlGsyX_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_EnWPFlGsyX_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_EnWPFlGsyX_required = true;
		}
	}
}

// the EnWPFlG Some function
function type_EnWPFlG_SomeFunc(type_EnWPFlG)
{
	// set the function logic
	if (type_EnWPFlG == 1)
	{
		return true;
	}
	return false;
}

// the FRmRFoE function
function FRmRFoE(type_FRmRFoE)
{
	if (isSet(type_FRmRFoE) && type_FRmRFoE.constructor !== Array)
	{
		var temp_FRmRFoE = type_FRmRFoE;
		var type_FRmRFoE = [];
		type_FRmRFoE.push(temp_FRmRFoE);
	}
	else if (!isSet(type_FRmRFoE))
	{
		var type_FRmRFoE = [];
	}
	var type = type_FRmRFoE.some(type_FRmRFoE_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_FRmRFoEGoi_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_FRmRFoEGoi_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_FRmRFoEGoi_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_FRmRFoEGoi_required = true;
		}
	}
}

// the FRmRFoE Some function
function type_FRmRFoE_SomeFunc(type_FRmRFoE)
{
	// set the function logic
	if (type_FRmRFoE == 2)
	{
		return true;
	}
	return false;
}

// the SJsvpxC function
function SJsvpxC(target_SJsvpxC)
{
	// set the function logic
	if (target_SJsvpxC == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_SJsvpxCUFN_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_SJsvpxCUFN_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_SJsvpxCUFN_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_SJsvpxCUFN_required = true;
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
