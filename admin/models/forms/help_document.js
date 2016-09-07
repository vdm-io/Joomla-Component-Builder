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

	@version		2.1.20
	@build			7th September, 2016
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
jform_vvvvvzlvzf_required = false;
jform_vvvvvzmvzg_required = false;
jform_vvvvvznvzh_required = false;
jform_vvvvvzovzi_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvvzj = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzj(location_vvvvvzj);

	var location_vvvvvzk = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzk(location_vvvvvzk);

	var type_vvvvvzl = jQuery("#jform_type").val();
	vvvvvzl(type_vvvvvzl);

	var type_vvvvvzm = jQuery("#jform_type").val();
	vvvvvzm(type_vvvvvzm);

	var type_vvvvvzn = jQuery("#jform_type").val();
	vvvvvzn(type_vvvvvzn);

	var target_vvvvvzo = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzo(target_vvvvvzo);
});

// the vvvvvzj function
function vvvvvzj(location_vvvvvzj)
{
	// set the function logic
	if (location_vvvvvzj == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the vvvvvzk function
function vvvvvzk(location_vvvvvzk)
{
	// set the function logic
	if (location_vvvvvzk == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
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
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvvzlvzf_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvvzlvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvvzlvzf_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvvzlvzf_required = true;
		}
	}
}

// the vvvvvzl Some function
function type_vvvvvzl_SomeFunc(type_vvvvvzl)
{
	// set the function logic
	if (type_vvvvvzl == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzm function
function vvvvvzm(type_vvvvvzm)
{
	if (isSet(type_vvvvvzm) && type_vvvvvzm.constructor !== Array)
	{
		var temp_vvvvvzm = type_vvvvvzm;
		var type_vvvvvzm = [];
		type_vvvvvzm.push(temp_vvvvvzm);
	}
	else if (!isSet(type_vvvvvzm))
	{
		var type_vvvvvzm = [];
	}
	var type = type_vvvvvzm.some(type_vvvvvzm_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvvzmvzg_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvvzmvzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvvzmvzg_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvvzmvzg_required = true;
		}
	}
}

// the vvvvvzm Some function
function type_vvvvvzm_SomeFunc(type_vvvvvzm)
{
	// set the function logic
	if (type_vvvvvzm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzn function
function vvvvvzn(type_vvvvvzn)
{
	if (isSet(type_vvvvvzn) && type_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = type_vvvvvzn;
		var type_vvvvvzn = [];
		type_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(type_vvvvvzn))
	{
		var type_vvvvvzn = [];
	}
	var type = type_vvvvvzn.some(type_vvvvvzn_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvvznvzh_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvvznvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvvznvzh_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvvznvzh_required = true;
		}
	}
}

// the vvvvvzn Some function
function type_vvvvvzn_SomeFunc(type_vvvvvzn)
{
	// set the function logic
	if (type_vvvvvzn == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(target_vvvvvzo)
{
	// set the function logic
	if (target_vvvvvzo == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvvzovzi_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvvzovzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvvzovzi_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvvzovzi_required = true;
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
