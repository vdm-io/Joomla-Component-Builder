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
jform_JlARhcdKIN_required = false;
jform_tKIaByInHZ_required = false;
jform_tGQDmQjqlT_required = false;
jform_iYgHOlJVUl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_HnladPk = jQuery("#jform_location input[type='radio']:checked").val();
	HnladPk(location_HnladPk);

	var location_CbGerIP = jQuery("#jform_location input[type='radio']:checked").val();
	CbGerIP(location_CbGerIP);

	var type_JlARhcd = jQuery("#jform_type").val();
	JlARhcd(type_JlARhcd);

	var type_tKIaByI = jQuery("#jform_type").val();
	tKIaByI(type_tKIaByI);

	var type_tGQDmQj = jQuery("#jform_type").val();
	tGQDmQj(type_tGQDmQj);

	var target_iYgHOlJ = jQuery("#jform_target input[type='radio']:checked").val();
	iYgHOlJ(target_iYgHOlJ);
});

// the HnladPk function
function HnladPk(location_HnladPk)
{
	// set the function logic
	if (location_HnladPk == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the CbGerIP function
function CbGerIP(location_CbGerIP)
{
	// set the function logic
	if (location_CbGerIP == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the JlARhcd function
function JlARhcd(type_JlARhcd)
{
	if (isSet(type_JlARhcd) && type_JlARhcd.constructor !== Array)
	{
		var temp_JlARhcd = type_JlARhcd;
		var type_JlARhcd = [];
		type_JlARhcd.push(temp_JlARhcd);
	}
	else if (!isSet(type_JlARhcd))
	{
		var type_JlARhcd = [];
	}
	var type = type_JlARhcd.some(type_JlARhcd_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_JlARhcdKIN_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_JlARhcdKIN_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_JlARhcdKIN_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_JlARhcdKIN_required = true;
		}
	}
}

// the JlARhcd Some function
function type_JlARhcd_SomeFunc(type_JlARhcd)
{
	// set the function logic
	if (type_JlARhcd == 3)
	{
		return true;
	}
	return false;
}

// the tKIaByI function
function tKIaByI(type_tKIaByI)
{
	if (isSet(type_tKIaByI) && type_tKIaByI.constructor !== Array)
	{
		var temp_tKIaByI = type_tKIaByI;
		var type_tKIaByI = [];
		type_tKIaByI.push(temp_tKIaByI);
	}
	else if (!isSet(type_tKIaByI))
	{
		var type_tKIaByI = [];
	}
	var type = type_tKIaByI.some(type_tKIaByI_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_tKIaByInHZ_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_tKIaByInHZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_tKIaByInHZ_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_tKIaByInHZ_required = true;
		}
	}
}

// the tKIaByI Some function
function type_tKIaByI_SomeFunc(type_tKIaByI)
{
	// set the function logic
	if (type_tKIaByI == 1)
	{
		return true;
	}
	return false;
}

// the tGQDmQj function
function tGQDmQj(type_tGQDmQj)
{
	if (isSet(type_tGQDmQj) && type_tGQDmQj.constructor !== Array)
	{
		var temp_tGQDmQj = type_tGQDmQj;
		var type_tGQDmQj = [];
		type_tGQDmQj.push(temp_tGQDmQj);
	}
	else if (!isSet(type_tGQDmQj))
	{
		var type_tGQDmQj = [];
	}
	var type = type_tGQDmQj.some(type_tGQDmQj_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_tGQDmQjqlT_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_tGQDmQjqlT_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_tGQDmQjqlT_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_tGQDmQjqlT_required = true;
		}
	}
}

// the tGQDmQj Some function
function type_tGQDmQj_SomeFunc(type_tGQDmQj)
{
	// set the function logic
	if (type_tGQDmQj == 2)
	{
		return true;
	}
	return false;
}

// the iYgHOlJ function
function iYgHOlJ(target_iYgHOlJ)
{
	// set the function logic
	if (target_iYgHOlJ == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_iYgHOlJVUl_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_iYgHOlJVUl_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_iYgHOlJVUl_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_iYgHOlJVUl_required = true;
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
