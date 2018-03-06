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
jform_vvvvwbdwao_required = false;
jform_vvvvwbewap_required = false;
jform_vvvvwbfwaq_required = false;
jform_vvvvwbgwar_required = false;
jform_vvvvwbhwas_required = false;
jform_vvvvwbiwat_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwbd = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbd(location_vvvvwbd);

	var location_vvvvwbe = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwbe(location_vvvvwbe);

	var type_vvvvwbf = jQuery("#jform_type").val();
	vvvvwbf(type_vvvvwbf);

	var type_vvvvwbg = jQuery("#jform_type").val();
	vvvvwbg(type_vvvvwbg);

	var type_vvvvwbh = jQuery("#jform_type").val();
	vvvvwbh(type_vvvvwbh);

	var target_vvvvwbi = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbi(target_vvvvwbi);
});

// the vvvvwbd function
function vvvvwbd(location_vvvvwbd)
{
	// set the function logic
	if (location_vvvvwbd == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwbdwao_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwbdwao_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwbdwao_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwbdwao_required = true;
		}
	}
}

// the vvvvwbe function
function vvvvwbe(location_vvvvwbe)
{
	// set the function logic
	if (location_vvvvwbe == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwbewap_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwbewap_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwbewap_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwbewap_required = true;
		}
	}
}

// the vvvvwbf function
function vvvvwbf(type_vvvvwbf)
{
	if (isSet(type_vvvvwbf) && type_vvvvwbf.constructor !== Array)
	{
		var temp_vvvvwbf = type_vvvvwbf;
		var type_vvvvwbf = [];
		type_vvvvwbf.push(temp_vvvvwbf);
	}
	else if (!isSet(type_vvvvwbf))
	{
		var type_vvvvwbf = [];
	}
	var type = type_vvvvwbf.some(type_vvvvwbf_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwbfwaq_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwbfwaq_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwbfwaq_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwbfwaq_required = true;
		}
	}
}

// the vvvvwbf Some function
function type_vvvvwbf_SomeFunc(type_vvvvwbf)
{
	// set the function logic
	if (type_vvvvwbf == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbg function
function vvvvwbg(type_vvvvwbg)
{
	if (isSet(type_vvvvwbg) && type_vvvvwbg.constructor !== Array)
	{
		var temp_vvvvwbg = type_vvvvwbg;
		var type_vvvvwbg = [];
		type_vvvvwbg.push(temp_vvvvwbg);
	}
	else if (!isSet(type_vvvvwbg))
	{
		var type_vvvvwbg = [];
	}
	var type = type_vvvvwbg.some(type_vvvvwbg_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwbgwar_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwbgwar_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwbgwar_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwbgwar_required = true;
		}
	}
}

// the vvvvwbg Some function
function type_vvvvwbg_SomeFunc(type_vvvvwbg)
{
	// set the function logic
	if (type_vvvvwbg == 1)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwbhwas_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwbhwas_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwbhwas_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwbhwas_required = true;
		}
	}
}

// the vvvvwbh Some function
function type_vvvvwbh_SomeFunc(type_vvvvwbh)
{
	// set the function logic
	if (type_vvvvwbh == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbi function
function vvvvwbi(target_vvvvwbi)
{
	// set the function logic
	if (target_vvvvwbi == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwbiwat_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwbiwat_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwbiwat_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwbiwat_required = true;
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
