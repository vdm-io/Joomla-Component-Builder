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
	@build			15th February, 2016
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
jform_WNMwSJhNfT_required = false;
jform_SqEIDzsUpI_required = false;
jform_rgQOSHRoWh_required = false;
jform_ZSXMpNBrEF_required = false;
jform_qtuTIyFptp_required = false;
jform_jOioNdrume_required = false;
jform_UMHBYXwKUN_required = false;
jform_XkczcEXMar_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_WNMwSJh = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	WNMwSJh(add_php_helper_admin_WNMwSJh);

	var add_php_helper_site_SqEIDzs = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	SqEIDzs(add_php_helper_site_SqEIDzs);

	var add_css_rgQOSHR = jQuery("#jform_add_css input[type='radio']:checked").val();
	rgQOSHR(add_css_rgQOSHR);

	var add_sql_ZSXMpNB = jQuery("#jform_add_sql input[type='radio']:checked").val();
	ZSXMpNB(add_sql_ZSXMpNB);

	var emptycontributors_qqUQYyj = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	qqUQYyj(emptycontributors_qqUQYyj);

	var add_license_qtuTIyF = jQuery("#jform_add_license input[type='radio']:checked").val();
	qtuTIyF(add_license_qtuTIyF);

	var add_admin_event_jOioNdr = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	jOioNdr(add_admin_event_jOioNdr);

	var add_site_event_UMHBYXw = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	UMHBYXw(add_site_event_UMHBYXw);

	var addreadme_XkczcEX = jQuery("#jform_addreadme input[type='radio']:checked").val();
	XkczcEX(addreadme_XkczcEX);

	var add_license_YiiiEVj = jQuery("#jform_add_license input[type='radio']:checked").val();
	YiiiEVj(add_license_YiiiEVj);
});

// the WNMwSJh function
function WNMwSJh(add_php_helper_admin_WNMwSJh)
{
	// set the function logic
	if (add_php_helper_admin_WNMwSJh == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_WNMwSJhNfT_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_WNMwSJhNfT_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_WNMwSJhNfT_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_WNMwSJhNfT_required = true;
		}
	}
}

// the SqEIDzs function
function SqEIDzs(add_php_helper_site_SqEIDzs)
{
	// set the function logic
	if (add_php_helper_site_SqEIDzs == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_SqEIDzsUpI_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_SqEIDzsUpI_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_SqEIDzsUpI_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_SqEIDzsUpI_required = true;
		}
	}
}

// the rgQOSHR function
function rgQOSHR(add_css_rgQOSHR)
{
	// set the function logic
	if (add_css_rgQOSHR == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_rgQOSHRoWh_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_rgQOSHRoWh_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_rgQOSHRoWh_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_rgQOSHRoWh_required = true;
		}
	}
}

// the ZSXMpNB function
function ZSXMpNB(add_sql_ZSXMpNB)
{
	// set the function logic
	if (add_sql_ZSXMpNB == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_ZSXMpNBrEF_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_ZSXMpNBrEF_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_ZSXMpNBrEF_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_ZSXMpNBrEF_required = true;
		}
	}
}

// the qqUQYyj function
function qqUQYyj(emptycontributors_qqUQYyj)
{
	// set the function logic
	if (emptycontributors_qqUQYyj == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the qtuTIyF function
function qtuTIyF(add_license_qtuTIyF)
{
	// set the function logic
	if (add_license_qtuTIyF == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_qtuTIyFptp_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_qtuTIyFptp_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_qtuTIyFptp_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_qtuTIyFptp_required = true;
		}
	}
}

// the jOioNdr function
function jOioNdr(add_admin_event_jOioNdr)
{
	// set the function logic
	if (add_admin_event_jOioNdr == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_jOioNdrume_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_jOioNdrume_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_jOioNdrume_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_jOioNdrume_required = true;
		}
	}
}

// the UMHBYXw function
function UMHBYXw(add_site_event_UMHBYXw)
{
	// set the function logic
	if (add_site_event_UMHBYXw == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_UMHBYXwKUN_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_UMHBYXwKUN_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_UMHBYXwKUN_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_UMHBYXwKUN_required = true;
		}
	}
}

// the XkczcEX function
function XkczcEX(addreadme_XkczcEX)
{
	// set the function logic
	if (addreadme_XkczcEX == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_XkczcEXMar_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_XkczcEXMar_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_XkczcEXMar_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_XkczcEXMar_required = true;
		}
	}
}

// the YiiiEVj function
function YiiiEVj(add_license_YiiiEVj)
{
	// set the function logic
	if (add_license_YiiiEVj == 1)
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
