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
jform_vvvvwazwao_required = false;
jform_vvvvwbawap_required = false;
jform_vvvvwbbwaq_required = false;
jform_vvvvwbcwar_required = false;
jform_vvvvwbdwas_required = false;
jform_vvvvwbewat_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwaz = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwaz(location_vvvvwaz);

	var location_vvvvwba = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwba(location_vvvvwba);

	var type_vvvvwbb = jQuery("#jform_type").val();
	vvvvwbb(type_vvvvwbb);

	var type_vvvvwbc = jQuery("#jform_type").val();
	vvvvwbc(type_vvvvwbc);

	var type_vvvvwbd = jQuery("#jform_type").val();
	vvvvwbd(type_vvvvwbd);

	var target_vvvvwbe = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbe(target_vvvvwbe);
});

// the vvvvwaz function
function vvvvwaz(location_vvvvwaz)
{
	// set the function logic
	if (location_vvvvwaz == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwazwao_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwazwao_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwazwao_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwazwao_required = true;
		}
	}
}

// the vvvvwba function
function vvvvwba(location_vvvvwba)
{
	// set the function logic
	if (location_vvvvwba == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwbawap_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwbawap_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwbawap_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwbawap_required = true;
		}
	}
}

// the vvvvwbb function
function vvvvwbb(type_vvvvwbb)
{
	if (isSet(type_vvvvwbb) && type_vvvvwbb.constructor !== Array)
	{
		var temp_vvvvwbb = type_vvvvwbb;
		var type_vvvvwbb = [];
		type_vvvvwbb.push(temp_vvvvwbb);
	}
	else if (!isSet(type_vvvvwbb))
	{
		var type_vvvvwbb = [];
	}
	var type = type_vvvvwbb.some(type_vvvvwbb_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwbbwaq_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwbbwaq_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwbbwaq_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwbbwaq_required = true;
		}
	}
}

// the vvvvwbb Some function
function type_vvvvwbb_SomeFunc(type_vvvvwbb)
{
	// set the function logic
	if (type_vvvvwbb == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbc function
function vvvvwbc(type_vvvvwbc)
{
	if (isSet(type_vvvvwbc) && type_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = type_vvvvwbc;
		var type_vvvvwbc = [];
		type_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(type_vvvvwbc))
	{
		var type_vvvvwbc = [];
	}
	var type = type_vvvvwbc.some(type_vvvvwbc_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwbcwar_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwbcwar_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwbcwar_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwbcwar_required = true;
		}
	}
}

// the vvvvwbc Some function
function type_vvvvwbc_SomeFunc(type_vvvvwbc)
{
	// set the function logic
	if (type_vvvvwbc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbd function
function vvvvwbd(type_vvvvwbd)
{
	if (isSet(type_vvvvwbd) && type_vvvvwbd.constructor !== Array)
	{
		var temp_vvvvwbd = type_vvvvwbd;
		var type_vvvvwbd = [];
		type_vvvvwbd.push(temp_vvvvwbd);
	}
	else if (!isSet(type_vvvvwbd))
	{
		var type_vvvvwbd = [];
	}
	var type = type_vvvvwbd.some(type_vvvvwbd_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwbdwas_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwbdwas_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwbdwas_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwbdwas_required = true;
		}
	}
}

// the vvvvwbd Some function
function type_vvvvwbd_SomeFunc(type_vvvvwbd)
{
	// set the function logic
	if (type_vvvvwbd == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbe function
function vvvvwbe(target_vvvvwbe)
{
	// set the function logic
	if (target_vvvvwbe == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwbewat_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwbewat_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwbewat_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwbewat_required = true;
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
