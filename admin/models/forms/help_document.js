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

	@version		2.6.x
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
jform_vvvvwbfwao_required = false;
jform_vvvvwbgwap_required = false;
jform_vvvvwbhwaq_required = false;
jform_vvvvwbiwar_required = false;
jform_vvvvwbjwas_required = false;
jform_vvvvwbkwat_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwbf = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbf(location_vvvvwbf);

	var location_vvvvwbg = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbg(location_vvvvwbg);

	var type_vvvvwbh = jQuery("#jform_type").val();
	vvvvwbh(type_vvvvwbh);

	var type_vvvvwbi = jQuery("#jform_type").val();
	vvvvwbi(type_vvvvwbi);

	var type_vvvvwbj = jQuery("#jform_type").val();
	vvvvwbj(type_vvvvwbj);

	var target_vvvvwbk = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbk(target_vvvvwbk);
});

// the vvvvwbf function
function vvvvwbf(location_vvvvwbf)
{
	// set the function logic
	if (location_vvvvwbf == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwbfwao_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwbfwao_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwbfwao_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwbfwao_required = true;
		}
	}
}

// the vvvvwbg function
function vvvvwbg(location_vvvvwbg)
{
	// set the function logic
	if (location_vvvvwbg == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwbgwap_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwbgwap_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwbgwap_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwbgwap_required = true;
		}
	}
}

// the vvvvwbh function
function vvvvwbh(type_vvvvwbh)
{
	if (isSet(type_vvvvwbh) && type_vvvvwbh.constructor !== Array)
	{
		var temp_vvvvwbh = type_vvvvwbh;
		var type_vvvvwbh = [];
		type_vvvvwbh.push(temp_vvvvwbh);
	}
	else if (!isSet(type_vvvvwbh))
	{
		var type_vvvvwbh = [];
	}
	var type = type_vvvvwbh.some(type_vvvvwbh_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwbhwaq_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwbhwaq_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwbhwaq_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwbhwaq_required = true;
		}
	}
}

// the vvvvwbh Some function
function type_vvvvwbh_SomeFunc(type_vvvvwbh)
{
	// set the function logic
	if (type_vvvvwbh == 3)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwbiwar_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwbiwar_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwbiwar_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwbiwar_required = true;
		}
	}
}

// the vvvvwbi Some function
function type_vvvvwbi_SomeFunc(type_vvvvwbi)
{
	// set the function logic
	if (type_vvvvwbi == 1)
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
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwbjwas_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwbjwas_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwbjwas_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwbjwas_required = true;
		}
	}
}

// the vvvvwbj Some function
function type_vvvvwbj_SomeFunc(type_vvvvwbj)
{
	// set the function logic
	if (type_vvvvwbj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbk function
function vvvvwbk(target_vvvvwbk)
{
	// set the function logic
	if (target_vvvvwbk == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwbkwat_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwbkwat_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwbkwat_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwbkwat_required = true;
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
