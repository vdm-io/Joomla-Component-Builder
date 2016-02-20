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
jform_QJTRKZjFwf_required = false;
jform_SzcsqYRAEb_required = false;
jform_lqwvXLlfpw_required = false;
jform_XjiRdPOkBn_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_oLkFItp = jQuery("#jform_location input[type='radio']:checked").val();
	oLkFItp(location_oLkFItp);

	var location_GtKiMqS = jQuery("#jform_location input[type='radio']:checked").val();
	GtKiMqS(location_GtKiMqS);

	var type_QJTRKZj = jQuery("#jform_type").val();
	QJTRKZj(type_QJTRKZj);

	var type_SzcsqYR = jQuery("#jform_type").val();
	SzcsqYR(type_SzcsqYR);

	var type_lqwvXLl = jQuery("#jform_type").val();
	lqwvXLl(type_lqwvXLl);

	var target_XjiRdPO = jQuery("#jform_target input[type='radio']:checked").val();
	XjiRdPO(target_XjiRdPO);
});

// the oLkFItp function
function oLkFItp(location_oLkFItp)
{
	// set the function logic
	if (location_oLkFItp == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the GtKiMqS function
function GtKiMqS(location_GtKiMqS)
{
	// set the function logic
	if (location_GtKiMqS == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the QJTRKZj function
function QJTRKZj(type_QJTRKZj)
{
	if (isSet(type_QJTRKZj) && type_QJTRKZj.constructor !== Array)
	{
		var temp_QJTRKZj = type_QJTRKZj;
		var type_QJTRKZj = [];
		type_QJTRKZj.push(temp_QJTRKZj);
	}
	else if (!isSet(type_QJTRKZj))
	{
		var type_QJTRKZj = [];
	}
	var type = type_QJTRKZj.some(type_QJTRKZj_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_QJTRKZjFwf_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_QJTRKZjFwf_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_QJTRKZjFwf_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_QJTRKZjFwf_required = true;
		}
	}
}

// the QJTRKZj Some function
function type_QJTRKZj_SomeFunc(type_QJTRKZj)
{
	// set the function logic
	if (type_QJTRKZj == 3)
	{
		return true;
	}
	return false;
}

// the SzcsqYR function
function SzcsqYR(type_SzcsqYR)
{
	if (isSet(type_SzcsqYR) && type_SzcsqYR.constructor !== Array)
	{
		var temp_SzcsqYR = type_SzcsqYR;
		var type_SzcsqYR = [];
		type_SzcsqYR.push(temp_SzcsqYR);
	}
	else if (!isSet(type_SzcsqYR))
	{
		var type_SzcsqYR = [];
	}
	var type = type_SzcsqYR.some(type_SzcsqYR_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_SzcsqYRAEb_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_SzcsqYRAEb_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_SzcsqYRAEb_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_SzcsqYRAEb_required = true;
		}
	}
}

// the SzcsqYR Some function
function type_SzcsqYR_SomeFunc(type_SzcsqYR)
{
	// set the function logic
	if (type_SzcsqYR == 1)
	{
		return true;
	}
	return false;
}

// the lqwvXLl function
function lqwvXLl(type_lqwvXLl)
{
	if (isSet(type_lqwvXLl) && type_lqwvXLl.constructor !== Array)
	{
		var temp_lqwvXLl = type_lqwvXLl;
		var type_lqwvXLl = [];
		type_lqwvXLl.push(temp_lqwvXLl);
	}
	else if (!isSet(type_lqwvXLl))
	{
		var type_lqwvXLl = [];
	}
	var type = type_lqwvXLl.some(type_lqwvXLl_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_lqwvXLlfpw_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_lqwvXLlfpw_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_lqwvXLlfpw_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_lqwvXLlfpw_required = true;
		}
	}
}

// the lqwvXLl Some function
function type_lqwvXLl_SomeFunc(type_lqwvXLl)
{
	// set the function logic
	if (type_lqwvXLl == 2)
	{
		return true;
	}
	return false;
}

// the XjiRdPO function
function XjiRdPO(target_XjiRdPO)
{
	// set the function logic
	if (target_XjiRdPO == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_XjiRdPOkBn_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_XjiRdPOkBn_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_XjiRdPOkBn_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_XjiRdPOkBn_required = true;
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
