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
	@subpackage		component.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_FlhlaAqsLU_required = false;
jform_bfuBfTzxoz_required = false;
jform_NFDDzCgZTZ_required = false;
jform_lBlpHlXYLC_required = false;
jform_GkphXPJCiq_required = false;
jform_HkjGsIPPsd_required = false;
jform_JrJqeudrBW_required = false;
jform_sjgEsemWAD_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_FlhlaAq = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	FlhlaAq(add_php_helper_admin_FlhlaAq);

	var add_php_helper_site_bfuBfTz = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	bfuBfTz(add_php_helper_site_bfuBfTz);

	var add_css_NFDDzCg = jQuery("#jform_add_css input[type='radio']:checked").val();
	NFDDzCg(add_css_NFDDzCg);

	var add_sql_lBlpHlX = jQuery("#jform_add_sql input[type='radio']:checked").val();
	lBlpHlX(add_sql_lBlpHlX);

	var emptycontributors_SHIhiSb = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	SHIhiSb(emptycontributors_SHIhiSb);

	var add_license_GkphXPJ = jQuery("#jform_add_license input[type='radio']:checked").val();
	GkphXPJ(add_license_GkphXPJ);

	var add_admin_event_HkjGsIP = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	HkjGsIP(add_admin_event_HkjGsIP);

	var add_site_event_JrJqeud = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	JrJqeud(add_site_event_JrJqeud);

	var addreadme_sjgEsem = jQuery("#jform_addreadme input[type='radio']:checked").val();
	sjgEsem(addreadme_sjgEsem);

	var add_license_ikLpOfX = jQuery("#jform_add_license input[type='radio']:checked").val();
	ikLpOfX(add_license_ikLpOfX);
});

// the FlhlaAq function
function FlhlaAq(add_php_helper_admin_FlhlaAq)
{
	// set the function logic
	if (add_php_helper_admin_FlhlaAq == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_FlhlaAqsLU_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_FlhlaAqsLU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_FlhlaAqsLU_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_FlhlaAqsLU_required = true;
		}
	}
}

// the bfuBfTz function
function bfuBfTz(add_php_helper_site_bfuBfTz)
{
	// set the function logic
	if (add_php_helper_site_bfuBfTz == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_bfuBfTzxoz_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_bfuBfTzxoz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_bfuBfTzxoz_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_bfuBfTzxoz_required = true;
		}
	}
}

// the NFDDzCg function
function NFDDzCg(add_css_NFDDzCg)
{
	// set the function logic
	if (add_css_NFDDzCg == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_NFDDzCgZTZ_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_NFDDzCgZTZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_NFDDzCgZTZ_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_NFDDzCgZTZ_required = true;
		}
	}
}

// the lBlpHlX function
function lBlpHlX(add_sql_lBlpHlX)
{
	// set the function logic
	if (add_sql_lBlpHlX == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_lBlpHlXYLC_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_lBlpHlXYLC_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_lBlpHlXYLC_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_lBlpHlXYLC_required = true;
		}
	}
}

// the SHIhiSb function
function SHIhiSb(emptycontributors_SHIhiSb)
{
	// set the function logic
	if (emptycontributors_SHIhiSb == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the GkphXPJ function
function GkphXPJ(add_license_GkphXPJ)
{
	// set the function logic
	if (add_license_GkphXPJ == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_GkphXPJCiq_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_GkphXPJCiq_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_GkphXPJCiq_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_GkphXPJCiq_required = true;
		}
	}
}

// the HkjGsIP function
function HkjGsIP(add_admin_event_HkjGsIP)
{
	// set the function logic
	if (add_admin_event_HkjGsIP == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_HkjGsIPPsd_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_HkjGsIPPsd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_HkjGsIPPsd_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_HkjGsIPPsd_required = true;
		}
	}
}

// the JrJqeud function
function JrJqeud(add_site_event_JrJqeud)
{
	// set the function logic
	if (add_site_event_JrJqeud == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_JrJqeudrBW_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_JrJqeudrBW_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_JrJqeudrBW_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_JrJqeudrBW_required = true;
		}
	}
}

// the sjgEsem function
function sjgEsem(addreadme_sjgEsem)
{
	// set the function logic
	if (addreadme_sjgEsem == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_sjgEsemWAD_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_sjgEsemWAD_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_sjgEsemWAD_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_sjgEsemWAD_required = true;
		}
	}
}

// the ikLpOfX function
function ikLpOfX(add_license_ikLpOfX)
{
	// set the function logic
	if (add_license_ikLpOfX == 1)
	{
		jQuery('.note_whmcs_lisencing_note').closest('.control-group').show();
		jQuery('#jform_whmcs_key').closest('.control-group').show();
		jQuery('#jform_whmcs_url').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_lisencing_note').closest('.control-group').hide();
		jQuery('#jform_whmcs_key').closest('.control-group').hide();
		jQuery('#jform_whmcs_url').closest('.control-group').hide();
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
