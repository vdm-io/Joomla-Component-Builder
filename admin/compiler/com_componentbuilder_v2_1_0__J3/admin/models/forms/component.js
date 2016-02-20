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

	@version		2.1.0
	@build			20th February, 2016
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
jform_yZoKbtNIRJ_required = false;
jform_LrnMZHaREL_required = false;
jform_RWqVUxBLwo_required = false;
jform_rTuBFxbzfV_required = false;
jform_DfGhWDETze_required = false;
jform_BdzNovgXfC_required = false;
jform_ZxGUGnhbRA_required = false;
jform_fnEKCCganz_required = false;
jform_HiUlIxxBHW_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_yZoKbtN = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	yZoKbtN(add_php_helper_admin_yZoKbtN);

	var add_php_helper_site_LrnMZHa = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	LrnMZHa(add_php_helper_site_LrnMZHa);

	var add_css_RWqVUxB = jQuery("#jform_add_css input[type='radio']:checked").val();
	RWqVUxB(add_css_RWqVUxB);

	var add_sql_rTuBFxb = jQuery("#jform_add_sql input[type='radio']:checked").val();
	rTuBFxb(add_sql_rTuBFxb);

	var emptycontributors_jOrwvlc = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	jOrwvlc(emptycontributors_jOrwvlc);

	var add_license_DfGhWDE = jQuery("#jform_add_license input[type='radio']:checked").val();
	DfGhWDE(add_license_DfGhWDE);

	var add_admin_event_BdzNovg = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	BdzNovg(add_admin_event_BdzNovg);

	var add_site_event_ZxGUGnh = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	ZxGUGnh(add_site_event_ZxGUGnh);

	var addreadme_fnEKCCg = jQuery("#jform_addreadme input[type='radio']:checked").val();
	fnEKCCg(addreadme_fnEKCCg);

	var add_update_server_dKJKyYg = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	dKJKyYg(add_update_server_dKJKyYg);

	var add_sales_server_FWlhVPM = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	FWlhVPM(add_sales_server_FWlhVPM);

	var add_license_OCbXDSr = jQuery("#jform_add_license input[type='radio']:checked").val();
	OCbXDSr(add_license_OCbXDSr);

	var add_php_dashboard_methods_HiUlIxx = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	HiUlIxx(add_php_dashboard_methods_HiUlIxx);
});

// the yZoKbtN function
function yZoKbtN(add_php_helper_admin_yZoKbtN)
{
	// set the function logic
	if (add_php_helper_admin_yZoKbtN == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_yZoKbtNIRJ_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_yZoKbtNIRJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_yZoKbtNIRJ_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_yZoKbtNIRJ_required = true;
		}
	}
}

// the LrnMZHa function
function LrnMZHa(add_php_helper_site_LrnMZHa)
{
	// set the function logic
	if (add_php_helper_site_LrnMZHa == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_LrnMZHaREL_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_LrnMZHaREL_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_LrnMZHaREL_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_LrnMZHaREL_required = true;
		}
	}
}

// the RWqVUxB function
function RWqVUxB(add_css_RWqVUxB)
{
	// set the function logic
	if (add_css_RWqVUxB == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_RWqVUxBLwo_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_RWqVUxBLwo_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_RWqVUxBLwo_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_RWqVUxBLwo_required = true;
		}
	}
}

// the rTuBFxb function
function rTuBFxb(add_sql_rTuBFxb)
{
	// set the function logic
	if (add_sql_rTuBFxb == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_rTuBFxbzfV_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_rTuBFxbzfV_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_rTuBFxbzfV_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_rTuBFxbzfV_required = true;
		}
	}
}

// the jOrwvlc function
function jOrwvlc(emptycontributors_jOrwvlc)
{
	// set the function logic
	if (emptycontributors_jOrwvlc == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the DfGhWDE function
function DfGhWDE(add_license_DfGhWDE)
{
	// set the function logic
	if (add_license_DfGhWDE == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_DfGhWDETze_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_DfGhWDETze_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_DfGhWDETze_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_DfGhWDETze_required = true;
		}
	}
}

// the BdzNovg function
function BdzNovg(add_admin_event_BdzNovg)
{
	// set the function logic
	if (add_admin_event_BdzNovg == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_BdzNovgXfC_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_BdzNovgXfC_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_BdzNovgXfC_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_BdzNovgXfC_required = true;
		}
	}
}

// the ZxGUGnh function
function ZxGUGnh(add_site_event_ZxGUGnh)
{
	// set the function logic
	if (add_site_event_ZxGUGnh == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_ZxGUGnhbRA_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_ZxGUGnhbRA_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_ZxGUGnhbRA_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_ZxGUGnhbRA_required = true;
		}
	}
}

// the fnEKCCg function
function fnEKCCg(addreadme_fnEKCCg)
{
	// set the function logic
	if (addreadme_fnEKCCg == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_fnEKCCganz_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_fnEKCCganz_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_fnEKCCganz_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_fnEKCCganz_required = true;
		}
	}
}

// the dKJKyYg function
function dKJKyYg(add_update_server_dKJKyYg)
{
	// set the function logic
	if (add_update_server_dKJKyYg == 1)
	{
		jQuery('#jform_update_server_ftp').closest('.control-group').show();
		jQuery('#jform_update_server').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server_ftp').closest('.control-group').hide();
		jQuery('#jform_update_server').closest('.control-group').hide();
	}
}

// the FWlhVPM function
function FWlhVPM(add_sales_server_FWlhVPM)
{
	// set the function logic
	if (add_sales_server_FWlhVPM == 1)
	{
		jQuery('#jform_sales_server_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_sales_server_ftp').closest('.control-group').hide();
	}
}

// the OCbXDSr function
function OCbXDSr(add_license_OCbXDSr)
{
	// set the function logic
	if (add_license_OCbXDSr == 1)
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

// the HiUlIxx function
function HiUlIxx(add_php_dashboard_methods_HiUlIxx)
{
	// set the function logic
	if (add_php_dashboard_methods_HiUlIxx == 1)
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').show();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').show();
		if (jform_HiUlIxxBHW_required)
		{
			updateFieldRequired('php_dashboard_methods',0);
			jQuery('#jform_php_dashboard_methods').prop('required','required');
			jQuery('#jform_php_dashboard_methods').attr('aria-required',true);
			jQuery('#jform_php_dashboard_methods').addClass('required');
			jform_HiUlIxxBHW_required = false;
		}

	}
	else
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').hide();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').hide();
		if (!jform_HiUlIxxBHW_required)
		{
			updateFieldRequired('php_dashboard_methods',1);
			jQuery('#jform_php_dashboard_methods').removeAttr('required');
			jQuery('#jform_php_dashboard_methods').removeAttr('aria-required');
			jQuery('#jform_php_dashboard_methods').removeClass('required');
			jform_HiUlIxxBHW_required = true;
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
