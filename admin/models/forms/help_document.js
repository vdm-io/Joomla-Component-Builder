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
jform_gCWDXUreVr_required = false;
jform_vKXBsxHDum_required = false;
jform_dsMWtEtXjI_required = false;
jform_FmdvObwidl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_oUMGYtR = jQuery("#jform_location input[type='radio']:checked").val();
	oUMGYtR(location_oUMGYtR);

	var location_bVDEziI = jQuery("#jform_location input[type='radio']:checked").val();
	bVDEziI(location_bVDEziI);

	var type_gCWDXUr = jQuery("#jform_type").val();
	gCWDXUr(type_gCWDXUr);

	var type_vKXBsxH = jQuery("#jform_type").val();
	vKXBsxH(type_vKXBsxH);

	var type_dsMWtEt = jQuery("#jform_type").val();
	dsMWtEt(type_dsMWtEt);

	var target_FmdvObw = jQuery("#jform_target input[type='radio']:checked").val();
	FmdvObw(target_FmdvObw);
});

// the oUMGYtR function
function oUMGYtR(location_oUMGYtR)
{
	// set the function logic
	if (location_oUMGYtR == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the bVDEziI function
function bVDEziI(location_bVDEziI)
{
	// set the function logic
	if (location_bVDEziI == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the gCWDXUr function
function gCWDXUr(type_gCWDXUr)
{
	if (isSet(type_gCWDXUr) && type_gCWDXUr.constructor !== Array)
	{
		var temp_gCWDXUr = type_gCWDXUr;
		var type_gCWDXUr = [];
		type_gCWDXUr.push(temp_gCWDXUr);
	}
	else if (!isSet(type_gCWDXUr))
	{
		var type_gCWDXUr = [];
	}
	var type = type_gCWDXUr.some(type_gCWDXUr_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_gCWDXUreVr_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_gCWDXUreVr_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_gCWDXUreVr_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_gCWDXUreVr_required = true;
		}
	}
}

// the gCWDXUr Some function
function type_gCWDXUr_SomeFunc(type_gCWDXUr)
{
	// set the function logic
	if (type_gCWDXUr == 3)
	{
		return true;
	}
	return false;
}

// the vKXBsxH function
function vKXBsxH(type_vKXBsxH)
{
	if (isSet(type_vKXBsxH) && type_vKXBsxH.constructor !== Array)
	{
		var temp_vKXBsxH = type_vKXBsxH;
		var type_vKXBsxH = [];
		type_vKXBsxH.push(temp_vKXBsxH);
	}
	else if (!isSet(type_vKXBsxH))
	{
		var type_vKXBsxH = [];
	}
	var type = type_vKXBsxH.some(type_vKXBsxH_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vKXBsxHDum_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vKXBsxHDum_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vKXBsxHDum_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vKXBsxHDum_required = true;
		}
	}
}

// the vKXBsxH Some function
function type_vKXBsxH_SomeFunc(type_vKXBsxH)
{
	// set the function logic
	if (type_vKXBsxH == 1)
	{
		return true;
	}
	return false;
}

// the dsMWtEt function
function dsMWtEt(type_dsMWtEt)
{
	if (isSet(type_dsMWtEt) && type_dsMWtEt.constructor !== Array)
	{
		var temp_dsMWtEt = type_dsMWtEt;
		var type_dsMWtEt = [];
		type_dsMWtEt.push(temp_dsMWtEt);
	}
	else if (!isSet(type_dsMWtEt))
	{
		var type_dsMWtEt = [];
	}
	var type = type_dsMWtEt.some(type_dsMWtEt_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_dsMWtEtXjI_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_dsMWtEtXjI_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_dsMWtEtXjI_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_dsMWtEtXjI_required = true;
		}
	}
}

// the dsMWtEt Some function
function type_dsMWtEt_SomeFunc(type_dsMWtEt)
{
	// set the function logic
	if (type_dsMWtEt == 2)
	{
		return true;
	}
	return false;
}

// the FmdvObw function
function FmdvObw(target_FmdvObw)
{
	// set the function logic
	if (target_FmdvObw == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_FmdvObwidl_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_FmdvObwidl_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_FmdvObwidl_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_FmdvObwidl_required = true;
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
