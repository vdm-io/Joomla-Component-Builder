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
jform_LUPWBvLKAZ_required = false;
jform_NFBeQOxGYa_required = false;
jform_dGbDgfjprI_required = false;
jform_MeDEahZFPA_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_NoKDMbr = jQuery("#jform_location input[type='radio']:checked").val();
	NoKDMbr(location_NoKDMbr);

	var location_AdGhqBD = jQuery("#jform_location input[type='radio']:checked").val();
	AdGhqBD(location_AdGhqBD);

	var type_LUPWBvL = jQuery("#jform_type").val();
	LUPWBvL(type_LUPWBvL);

	var type_NFBeQOx = jQuery("#jform_type").val();
	NFBeQOx(type_NFBeQOx);

	var type_dGbDgfj = jQuery("#jform_type").val();
	dGbDgfj(type_dGbDgfj);

	var target_MeDEahZ = jQuery("#jform_target input[type='radio']:checked").val();
	MeDEahZ(target_MeDEahZ);
});

// the NoKDMbr function
function NoKDMbr(location_NoKDMbr)
{
	// set the function logic
	if (location_NoKDMbr == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the AdGhqBD function
function AdGhqBD(location_AdGhqBD)
{
	// set the function logic
	if (location_AdGhqBD == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the LUPWBvL function
function LUPWBvL(type_LUPWBvL)
{
	if (isSet(type_LUPWBvL) && type_LUPWBvL.constructor !== Array)
	{
		var temp_LUPWBvL = type_LUPWBvL;
		var type_LUPWBvL = [];
		type_LUPWBvL.push(temp_LUPWBvL);
	}
	else if (!isSet(type_LUPWBvL))
	{
		var type_LUPWBvL = [];
	}
	var type = type_LUPWBvL.some(type_LUPWBvL_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_LUPWBvLKAZ_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_LUPWBvLKAZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_LUPWBvLKAZ_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_LUPWBvLKAZ_required = true;
		}
	}
}

// the LUPWBvL Some function
function type_LUPWBvL_SomeFunc(type_LUPWBvL)
{
	// set the function logic
	if (type_LUPWBvL == 3)
	{
		return true;
	}
	return false;
}

// the NFBeQOx function
function NFBeQOx(type_NFBeQOx)
{
	if (isSet(type_NFBeQOx) && type_NFBeQOx.constructor !== Array)
	{
		var temp_NFBeQOx = type_NFBeQOx;
		var type_NFBeQOx = [];
		type_NFBeQOx.push(temp_NFBeQOx);
	}
	else if (!isSet(type_NFBeQOx))
	{
		var type_NFBeQOx = [];
	}
	var type = type_NFBeQOx.some(type_NFBeQOx_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_NFBeQOxGYa_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_NFBeQOxGYa_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_NFBeQOxGYa_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_NFBeQOxGYa_required = true;
		}
	}
}

// the NFBeQOx Some function
function type_NFBeQOx_SomeFunc(type_NFBeQOx)
{
	// set the function logic
	if (type_NFBeQOx == 1)
	{
		return true;
	}
	return false;
}

// the dGbDgfj function
function dGbDgfj(type_dGbDgfj)
{
	if (isSet(type_dGbDgfj) && type_dGbDgfj.constructor !== Array)
	{
		var temp_dGbDgfj = type_dGbDgfj;
		var type_dGbDgfj = [];
		type_dGbDgfj.push(temp_dGbDgfj);
	}
	else if (!isSet(type_dGbDgfj))
	{
		var type_dGbDgfj = [];
	}
	var type = type_dGbDgfj.some(type_dGbDgfj_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_dGbDgfjprI_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_dGbDgfjprI_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_dGbDgfjprI_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_dGbDgfjprI_required = true;
		}
	}
}

// the dGbDgfj Some function
function type_dGbDgfj_SomeFunc(type_dGbDgfj)
{
	// set the function logic
	if (type_dGbDgfj == 2)
	{
		return true;
	}
	return false;
}

// the MeDEahZ function
function MeDEahZ(target_MeDEahZ)
{
	// set the function logic
	if (target_MeDEahZ == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_MeDEahZFPA_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_MeDEahZFPA_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_MeDEahZFPA_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_MeDEahZFPA_required = true;
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
