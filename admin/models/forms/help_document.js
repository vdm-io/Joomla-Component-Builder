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

	@version		2.7.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvwbgwao_required = false;
jform_vvvvwbhwap_required = false;
jform_vvvvwbiwaq_required = false;
jform_vvvvwbjwar_required = false;
jform_vvvvwbkwas_required = false;
jform_vvvvwblwat_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwbg = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbg(location_vvvvwbg);

	var location_vvvvwbh = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbh(location_vvvvwbh);

	var type_vvvvwbi = jQuery("#jform_type").val();
	vvvvwbi(type_vvvvwbi);

	var type_vvvvwbj = jQuery("#jform_type").val();
	vvvvwbj(type_vvvvwbj);

	var type_vvvvwbk = jQuery("#jform_type").val();
	vvvvwbk(type_vvvvwbk);

	var target_vvvvwbl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbl(target_vvvvwbl);
});

// the vvvvwbg function
function vvvvwbg(location_vvvvwbg)
{
	// set the function logic
	if (location_vvvvwbg == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwbgwao_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwbgwao_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwbgwao_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwbgwao_required = true;
		}
	}
}

// the vvvvwbh function
function vvvvwbh(location_vvvvwbh)
{
	// set the function logic
	if (location_vvvvwbh == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwbhwap_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwbhwap_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwbhwap_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwbhwap_required = true;
		}
	}
}

// the vvvvwbi function
function vvvvwbi(type_vvvvwbi)
{
	if (isSet(type_vvvvwbi) && type_vvvvwbi.constructor !== Array)
	{
		var temp_vvvvwbi = type_vvvvwbi;
		var type_vvvvwbi = [];
		type_vvvvwbi.push(temp_vvvvwbi);
	}
	else if (!isSet(type_vvvvwbi))
	{
		var type_vvvvwbi = [];
	}
	var type = type_vvvvwbi.some(type_vvvvwbi_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwbiwaq_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwbiwaq_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwbiwaq_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwbiwaq_required = true;
		}
	}
}

// the vvvvwbi Some function
function type_vvvvwbi_SomeFunc(type_vvvvwbi)
{
	// set the function logic
	if (type_vvvvwbi == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbj function
function vvvvwbj(type_vvvvwbj)
{
	if (isSet(type_vvvvwbj) && type_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = type_vvvvwbj;
		var type_vvvvwbj = [];
		type_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(type_vvvvwbj))
	{
		var type_vvvvwbj = [];
	}
	var type = type_vvvvwbj.some(type_vvvvwbj_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwbjwar_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwbjwar_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwbjwar_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwbjwar_required = true;
		}
	}
}

// the vvvvwbj Some function
function type_vvvvwbj_SomeFunc(type_vvvvwbj)
{
	// set the function logic
	if (type_vvvvwbj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbk function
function vvvvwbk(type_vvvvwbk)
{
	if (isSet(type_vvvvwbk) && type_vvvvwbk.constructor !== Array)
	{
		var temp_vvvvwbk = type_vvvvwbk;
		var type_vvvvwbk = [];
		type_vvvvwbk.push(temp_vvvvwbk);
	}
	else if (!isSet(type_vvvvwbk))
	{
		var type_vvvvwbk = [];
	}
	var type = type_vvvvwbk.some(type_vvvvwbk_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwbkwas_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwbkwas_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwbkwas_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwbkwas_required = true;
		}
	}
}

// the vvvvwbk Some function
function type_vvvvwbk_SomeFunc(type_vvvvwbk)
{
	// set the function logic
	if (type_vvvvwbk == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbl function
function vvvvwbl(target_vvvvwbl)
{
	// set the function logic
	if (target_vvvvwbl == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwblwat_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwblwat_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwblwat_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwblwat_required = true;
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
