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
	@build			30th January, 2016
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
jform_yFtNPtFIwT_required = false;
jform_gIDlqEybXp_required = false;
jform_nJukvrTsmK_required = false;
jform_hGjAuYOaHr_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_LsMmLfT = jQuery("#jform_location input[type='radio']:checked").val();
	LsMmLfT(location_LsMmLfT);

	var location_TWLSbOQ = jQuery("#jform_location input[type='radio']:checked").val();
	TWLSbOQ(location_TWLSbOQ);

	var type_yFtNPtF = jQuery("#jform_type").val();
	yFtNPtF(type_yFtNPtF);

	var type_gIDlqEy = jQuery("#jform_type").val();
	gIDlqEy(type_gIDlqEy);

	var type_nJukvrT = jQuery("#jform_type").val();
	nJukvrT(type_nJukvrT);

	var target_hGjAuYO = jQuery("#jform_target input[type='radio']:checked").val();
	hGjAuYO(target_hGjAuYO);
});

// the LsMmLfT function
function LsMmLfT(location_LsMmLfT)
{
	// set the function logic
	if (location_LsMmLfT == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the TWLSbOQ function
function TWLSbOQ(location_TWLSbOQ)
{
	// set the function logic
	if (location_TWLSbOQ == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the yFtNPtF function
function yFtNPtF(type_yFtNPtF)
{
	if (isSet(type_yFtNPtF) && type_yFtNPtF.constructor !== Array)
	{
		var temp_yFtNPtF = type_yFtNPtF;
		var type_yFtNPtF = [];
		type_yFtNPtF.push(temp_yFtNPtF);
	}
	else if (!isSet(type_yFtNPtF))
	{
		var type_yFtNPtF = [];
	}
	var type = type_yFtNPtF.some(type_yFtNPtF_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_yFtNPtFIwT_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_yFtNPtFIwT_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_yFtNPtFIwT_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_yFtNPtFIwT_required = true;
		}
	}
}

// the yFtNPtF Some function
function type_yFtNPtF_SomeFunc(type_yFtNPtF)
{
	// set the function logic
	if (type_yFtNPtF == 3)
	{
		return true;
	}
	return false;
}

// the gIDlqEy function
function gIDlqEy(type_gIDlqEy)
{
	if (isSet(type_gIDlqEy) && type_gIDlqEy.constructor !== Array)
	{
		var temp_gIDlqEy = type_gIDlqEy;
		var type_gIDlqEy = [];
		type_gIDlqEy.push(temp_gIDlqEy);
	}
	else if (!isSet(type_gIDlqEy))
	{
		var type_gIDlqEy = [];
	}
	var type = type_gIDlqEy.some(type_gIDlqEy_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_gIDlqEybXp_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_gIDlqEybXp_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_gIDlqEybXp_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_gIDlqEybXp_required = true;
		}
	}
}

// the gIDlqEy Some function
function type_gIDlqEy_SomeFunc(type_gIDlqEy)
{
	// set the function logic
	if (type_gIDlqEy == 1)
	{
		return true;
	}
	return false;
}

// the nJukvrT function
function nJukvrT(type_nJukvrT)
{
	if (isSet(type_nJukvrT) && type_nJukvrT.constructor !== Array)
	{
		var temp_nJukvrT = type_nJukvrT;
		var type_nJukvrT = [];
		type_nJukvrT.push(temp_nJukvrT);
	}
	else if (!isSet(type_nJukvrT))
	{
		var type_nJukvrT = [];
	}
	var type = type_nJukvrT.some(type_nJukvrT_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_nJukvrTsmK_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_nJukvrTsmK_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_nJukvrTsmK_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_nJukvrTsmK_required = true;
		}
	}
}

// the nJukvrT Some function
function type_nJukvrT_SomeFunc(type_nJukvrT)
{
	// set the function logic
	if (type_nJukvrT == 2)
	{
		return true;
	}
	return false;
}

// the hGjAuYO function
function hGjAuYO(target_hGjAuYO)
{
	// set the function logic
	if (target_hGjAuYO == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_hGjAuYOaHr_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_hGjAuYOaHr_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_hGjAuYOaHr_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_hGjAuYOaHr_required = true;
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
