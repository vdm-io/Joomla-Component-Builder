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

	@version		2.0.8
	@build			31st January, 2016
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
jform_ZhZIWnSwVC_required = false;
jform_iokjahLWMP_required = false;
jform_CyxSokBVXL_required = false;
jform_vXQvzNRzmI_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_VHfHGOq = jQuery("#jform_location input[type='radio']:checked").val();
	VHfHGOq(location_VHfHGOq);

	var location_QGGLNoI = jQuery("#jform_location input[type='radio']:checked").val();
	QGGLNoI(location_QGGLNoI);

	var type_ZhZIWnS = jQuery("#jform_type").val();
	ZhZIWnS(type_ZhZIWnS);

	var type_iokjahL = jQuery("#jform_type").val();
	iokjahL(type_iokjahL);

	var type_CyxSokB = jQuery("#jform_type").val();
	CyxSokB(type_CyxSokB);

	var target_vXQvzNR = jQuery("#jform_target input[type='radio']:checked").val();
	vXQvzNR(target_vXQvzNR);
});

// the VHfHGOq function
function VHfHGOq(location_VHfHGOq)
{
	// set the function logic
	if (location_VHfHGOq == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the QGGLNoI function
function QGGLNoI(location_QGGLNoI)
{
	// set the function logic
	if (location_QGGLNoI == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the ZhZIWnS function
function ZhZIWnS(type_ZhZIWnS)
{
	if (isSet(type_ZhZIWnS) && type_ZhZIWnS.constructor !== Array)
	{
		var temp_ZhZIWnS = type_ZhZIWnS;
		var type_ZhZIWnS = [];
		type_ZhZIWnS.push(temp_ZhZIWnS);
	}
	else if (!isSet(type_ZhZIWnS))
	{
		var type_ZhZIWnS = [];
	}
	var type = type_ZhZIWnS.some(type_ZhZIWnS_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_ZhZIWnSwVC_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_ZhZIWnSwVC_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_ZhZIWnSwVC_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_ZhZIWnSwVC_required = true;
		}
	}
}

// the ZhZIWnS Some function
function type_ZhZIWnS_SomeFunc(type_ZhZIWnS)
{
	// set the function logic
	if (type_ZhZIWnS == 3)
	{
		return true;
	}
	return false;
}

// the iokjahL function
function iokjahL(type_iokjahL)
{
	if (isSet(type_iokjahL) && type_iokjahL.constructor !== Array)
	{
		var temp_iokjahL = type_iokjahL;
		var type_iokjahL = [];
		type_iokjahL.push(temp_iokjahL);
	}
	else if (!isSet(type_iokjahL))
	{
		var type_iokjahL = [];
	}
	var type = type_iokjahL.some(type_iokjahL_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_iokjahLWMP_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_iokjahLWMP_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_iokjahLWMP_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_iokjahLWMP_required = true;
		}
	}
}

// the iokjahL Some function
function type_iokjahL_SomeFunc(type_iokjahL)
{
	// set the function logic
	if (type_iokjahL == 1)
	{
		return true;
	}
	return false;
}

// the CyxSokB function
function CyxSokB(type_CyxSokB)
{
	if (isSet(type_CyxSokB) && type_CyxSokB.constructor !== Array)
	{
		var temp_CyxSokB = type_CyxSokB;
		var type_CyxSokB = [];
		type_CyxSokB.push(temp_CyxSokB);
	}
	else if (!isSet(type_CyxSokB))
	{
		var type_CyxSokB = [];
	}
	var type = type_CyxSokB.some(type_CyxSokB_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_CyxSokBVXL_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_CyxSokBVXL_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_CyxSokBVXL_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_CyxSokBVXL_required = true;
		}
	}
}

// the CyxSokB Some function
function type_CyxSokB_SomeFunc(type_CyxSokB)
{
	// set the function logic
	if (type_CyxSokB == 2)
	{
		return true;
	}
	return false;
}

// the vXQvzNR function
function vXQvzNR(target_vXQvzNR)
{
	// set the function logic
	if (target_vXQvzNR == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vXQvzNRzmI_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vXQvzNRzmI_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vXQvzNRzmI_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vXQvzNRzmI_required = true;
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
