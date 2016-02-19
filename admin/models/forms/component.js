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
	@build			18th February, 2016
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
jform_nMepiQXRzi_required = false;
jform_AbHamGXSEW_required = false;
jform_mHwywaiCzF_required = false;
jform_cVxhfzWfto_required = false;
jform_RwiJQRguqg_required = false;
jform_xRGiUGzbHf_required = false;
jform_XNGrazKXrq_required = false;
jform_CdNJRGDWVR_required = false;
jform_iEZtHOUUPm_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_nMepiQX = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	nMepiQX(add_php_helper_admin_nMepiQX);

	var add_php_helper_site_AbHamGX = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	AbHamGX(add_php_helper_site_AbHamGX);

	var add_css_mHwywai = jQuery("#jform_add_css input[type='radio']:checked").val();
	mHwywai(add_css_mHwywai);

	var add_sql_cVxhfzW = jQuery("#jform_add_sql input[type='radio']:checked").val();
	cVxhfzW(add_sql_cVxhfzW);

	var emptycontributors_pRwWRCD = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	pRwWRCD(emptycontributors_pRwWRCD);

	var add_license_RwiJQRg = jQuery("#jform_add_license input[type='radio']:checked").val();
	RwiJQRg(add_license_RwiJQRg);

	var add_admin_event_xRGiUGz = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	xRGiUGz(add_admin_event_xRGiUGz);

	var add_site_event_XNGrazK = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	XNGrazK(add_site_event_XNGrazK);

	var addreadme_CdNJRGD = jQuery("#jform_addreadme input[type='radio']:checked").val();
	CdNJRGD(addreadme_CdNJRGD);

	var add_license_bAIMCCm = jQuery("#jform_add_license input[type='radio']:checked").val();
	bAIMCCm(add_license_bAIMCCm);

	var add_php_dashboard_methods_iEZtHOU = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	iEZtHOU(add_php_dashboard_methods_iEZtHOU);
});

// the nMepiQX function
function nMepiQX(add_php_helper_admin_nMepiQX)
{
	// set the function logic
	if (add_php_helper_admin_nMepiQX == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_nMepiQXRzi_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_nMepiQXRzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_nMepiQXRzi_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_nMepiQXRzi_required = true;
		}
	}
}

// the AbHamGX function
function AbHamGX(add_php_helper_site_AbHamGX)
{
	// set the function logic
	if (add_php_helper_site_AbHamGX == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_AbHamGXSEW_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_AbHamGXSEW_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_AbHamGXSEW_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_AbHamGXSEW_required = true;
		}
	}
}

// the mHwywai function
function mHwywai(add_css_mHwywai)
{
	// set the function logic
	if (add_css_mHwywai == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_mHwywaiCzF_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_mHwywaiCzF_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_mHwywaiCzF_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_mHwywaiCzF_required = true;
		}
	}
}

// the cVxhfzW function
function cVxhfzW(add_sql_cVxhfzW)
{
	// set the function logic
	if (add_sql_cVxhfzW == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_cVxhfzWfto_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_cVxhfzWfto_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_cVxhfzWfto_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_cVxhfzWfto_required = true;
		}
	}
}

// the pRwWRCD function
function pRwWRCD(emptycontributors_pRwWRCD)
{
	// set the function logic
	if (emptycontributors_pRwWRCD == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the RwiJQRg function
function RwiJQRg(add_license_RwiJQRg)
{
	// set the function logic
	if (add_license_RwiJQRg == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_RwiJQRguqg_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_RwiJQRguqg_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_RwiJQRguqg_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_RwiJQRguqg_required = true;
		}
	}
}

// the xRGiUGz function
function xRGiUGz(add_admin_event_xRGiUGz)
{
	// set the function logic
	if (add_admin_event_xRGiUGz == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_xRGiUGzbHf_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_xRGiUGzbHf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_xRGiUGzbHf_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_xRGiUGzbHf_required = true;
		}
	}
}

// the XNGrazK function
function XNGrazK(add_site_event_XNGrazK)
{
	// set the function logic
	if (add_site_event_XNGrazK == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_XNGrazKXrq_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_XNGrazKXrq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_XNGrazKXrq_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_XNGrazKXrq_required = true;
		}
	}
}

// the CdNJRGD function
function CdNJRGD(addreadme_CdNJRGD)
{
	// set the function logic
	if (addreadme_CdNJRGD == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_CdNJRGDWVR_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_CdNJRGDWVR_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_CdNJRGDWVR_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_CdNJRGDWVR_required = true;
		}
	}
}

// the bAIMCCm function
function bAIMCCm(add_license_bAIMCCm)
{
	// set the function logic
	if (add_license_bAIMCCm == 1)
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

// the iEZtHOU function
function iEZtHOU(add_php_dashboard_methods_iEZtHOU)
{
	// set the function logic
	if (add_php_dashboard_methods_iEZtHOU == 1)
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').show();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').show();
		if (jform_iEZtHOUUPm_required)
		{
			updateFieldRequired('php_dashboard_methods',0);
			jQuery('#jform_php_dashboard_methods').prop('required','required');
			jQuery('#jform_php_dashboard_methods').attr('aria-required',true);
			jQuery('#jform_php_dashboard_methods').addClass('required');
			jform_iEZtHOUUPm_required = false;
		}

	}
	else
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').hide();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').hide();
		if (!jform_iEZtHOUUPm_required)
		{
			updateFieldRequired('php_dashboard_methods',1);
			jQuery('#jform_php_dashboard_methods').removeAttr('required');
			jQuery('#jform_php_dashboard_methods').removeAttr('aria-required');
			jQuery('#jform_php_dashboard_methods').removeClass('required');
			jform_iEZtHOUUPm_required = true;
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
