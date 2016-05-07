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

	@version		2.1.8
	@build			7th May, 2016
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
jform_vvvvvzhvza_required = false;
jform_vvvvvzivzb_required = false;
jform_vvvvvzjvzc_required = false;
jform_vvvvvzkvzd_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvvzf = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzf(location_vvvvvzf);

	var location_vvvvvzg = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzg(location_vvvvvzg);

	var type_vvvvvzh = jQuery("#jform_type").val();
	vvvvvzh(type_vvvvvzh);

	var type_vvvvvzi = jQuery("#jform_type").val();
	vvvvvzi(type_vvvvvzi);

	var type_vvvvvzj = jQuery("#jform_type").val();
	vvvvvzj(type_vvvvvzj);

	var target_vvvvvzk = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzk(target_vvvvvzk);
});

// the vvvvvzf function
function vvvvvzf(location_vvvvvzf)
{
	// set the function logic
	if (location_vvvvvzf == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the vvvvvzg function
function vvvvvzg(location_vvvvvzg)
{
	// set the function logic
	if (location_vvvvvzg == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the vvvvvzh function
function vvvvvzh(type_vvvvvzh)
{
	if (isSet(type_vvvvvzh) && type_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = type_vvvvvzh;
		var type_vvvvvzh = [];
		type_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(type_vvvvvzh))
	{
		var type_vvvvvzh = [];
	}
	var type = type_vvvvvzh.some(type_vvvvvzh_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvvzhvza_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvvzhvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvvzhvza_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvvzhvza_required = true;
		}
	}
}

// the vvvvvzh Some function
function type_vvvvvzh_SomeFunc(type_vvvvvzh)
{
	// set the function logic
	if (type_vvvvvzh == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzi function
function vvvvvzi(type_vvvvvzi)
{
	if (isSet(type_vvvvvzi) && type_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = type_vvvvvzi;
		var type_vvvvvzi = [];
		type_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(type_vvvvvzi))
	{
		var type_vvvvvzi = [];
	}
	var type = type_vvvvvzi.some(type_vvvvvzi_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvvzivzb_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvvzivzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvvzivzb_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvvzivzb_required = true;
		}
	}
}

// the vvvvvzi Some function
function type_vvvvvzi_SomeFunc(type_vvvvvzi)
{
	// set the function logic
	if (type_vvvvvzi == 1)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvvzjvzc_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvvzjvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzjvzc_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvvzjvzc_required = true;
		}
	}
}

// the vvvvvzj Some function
function type_vvvvvzj_SomeFunc(type_vvvvvzj)
{
	// set the function logic
	if (type_vvvvvzj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzk function
function vvvvvzk(target_vvvvvzk)
{
	// set the function logic
	if (target_vvvvvzk == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvvzkvzd_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvvzkvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvvzkvzd_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvvzkvzd_required = true;
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
