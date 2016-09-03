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

	@version		2.1.18
	@build			3rd September, 2016
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
jform_vvvvvzjvzd_required = false;
jform_vvvvvzkvze_required = false;
jform_vvvvvzlvzf_required = false;
jform_vvvvvzmvzg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvvzh = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzh(location_vvvvvzh);

	var location_vvvvvzi = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzi(location_vvvvvzi);

	var type_vvvvvzj = jQuery("#jform_type").val();
	vvvvvzj(type_vvvvvzj);

	var type_vvvvvzk = jQuery("#jform_type").val();
	vvvvvzk(type_vvvvvzk);

	var type_vvvvvzl = jQuery("#jform_type").val();
	vvvvvzl(type_vvvvvzl);

	var target_vvvvvzm = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzm(target_vvvvvzm);
});

// the vvvvvzh function
function vvvvvzh(location_vvvvvzh)
{
	// set the function logic
	if (location_vvvvvzh == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the vvvvvzi function
function vvvvvzi(location_vvvvvzi)
{
	// set the function logic
	if (location_vvvvvzi == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the vvvvvzj function
function vvvvvzj(type_vvvvvzj)
{
	if (isSet(type_vvvvvzj) && type_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = type_vvvvvzj;
		var type_vvvvvzj = [];
		type_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(type_vvvvvzj))
	{
		var type_vvvvvzj = [];
	}
	var type = type_vvvvvzj.some(type_vvvvvzj_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvvzjvzd_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvvzjvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvvzjvzd_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvvzjvzd_required = true;
		}
	}
}

// the vvvvvzj Some function
function type_vvvvvzj_SomeFunc(type_vvvvvzj)
{
	// set the function logic
	if (type_vvvvvzj == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzk function
function vvvvvzk(type_vvvvvzk)
{
	if (isSet(type_vvvvvzk) && type_vvvvvzk.constructor !== Array)
	{
		var temp_vvvvvzk = type_vvvvvzk;
		var type_vvvvvzk = [];
		type_vvvvvzk.push(temp_vvvvvzk);
	}
	else if (!isSet(type_vvvvvzk))
	{
		var type_vvvvvzk = [];
	}
	var type = type_vvvvvzk.some(type_vvvvvzk_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvvzkvze_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvvzkvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvvzkvze_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvvzkvze_required = true;
		}
	}
}

// the vvvvvzk Some function
function type_vvvvvzk_SomeFunc(type_vvvvvzk)
{
	// set the function logic
	if (type_vvvvvzk == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzl function
function vvvvvzl(type_vvvvvzl)
{
	if (isSet(type_vvvvvzl) && type_vvvvvzl.constructor !== Array)
	{
		var temp_vvvvvzl = type_vvvvvzl;
		var type_vvvvvzl = [];
		type_vvvvvzl.push(temp_vvvvvzl);
	}
	else if (!isSet(type_vvvvvzl))
	{
		var type_vvvvvzl = [];
	}
	var type = type_vvvvvzl.some(type_vvvvvzl_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvvzlvzf_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvvzlvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzlvzf_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvvzlvzf_required = true;
		}
	}
}

// the vvvvvzl Some function
function type_vvvvvzl_SomeFunc(type_vvvvvzl)
{
	// set the function logic
	if (type_vvvvvzl == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzm function
function vvvvvzm(target_vvvvvzm)
{
	// set the function logic
	if (target_vvvvvzm == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvvzmvzg_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvvzmvzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvvzmvzg_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvvzmvzg_required = true;
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
