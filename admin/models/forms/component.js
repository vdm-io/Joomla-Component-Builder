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
	@build			26th February, 2016
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
jform_lCUEGWWHBJ_required = false;
jform_evsYmaVQXd_required = false;
jform_ZujyBCapPX_required = false;
jform_jdtfBfexHF_required = false;
jform_KrxHqRVOtq_required = false;
jform_RFiNKqjURu_required = false;
jform_XqbIKPKnyk_required = false;
jform_PnCsUNjRFD_required = false;
jform_wGvLJTMlwE_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_lCUEGWW = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	lCUEGWW(add_php_helper_admin_lCUEGWW);

	var add_php_helper_site_evsYmaV = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	evsYmaV(add_php_helper_site_evsYmaV);

	var add_css_ZujyBCa = jQuery("#jform_add_css input[type='radio']:checked").val();
	ZujyBCa(add_css_ZujyBCa);

	var add_sql_jdtfBfe = jQuery("#jform_add_sql input[type='radio']:checked").val();
	jdtfBfe(add_sql_jdtfBfe);

	var emptycontributors_lNgzJAG = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	lNgzJAG(emptycontributors_lNgzJAG);

	var add_license_KrxHqRV = jQuery("#jform_add_license input[type='radio']:checked").val();
	KrxHqRV(add_license_KrxHqRV);

	var add_admin_event_RFiNKqj = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	RFiNKqj(add_admin_event_RFiNKqj);

	var add_site_event_XqbIKPK = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	XqbIKPK(add_site_event_XqbIKPK);

	var addreadme_PnCsUNj = jQuery("#jform_addreadme input[type='radio']:checked").val();
	PnCsUNj(addreadme_PnCsUNj);

	var add_license_kpcqgQC = jQuery("#jform_add_license input[type='radio']:checked").val();
	kpcqgQC(add_license_kpcqgQC);

	var add_php_dashboard_methods_wGvLJTM = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	wGvLJTM(add_php_dashboard_methods_wGvLJTM);
});

// the lCUEGWW function
function lCUEGWW(add_php_helper_admin_lCUEGWW)
{
	// set the function logic
	if (add_php_helper_admin_lCUEGWW == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_lCUEGWWHBJ_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_lCUEGWWHBJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_lCUEGWWHBJ_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_lCUEGWWHBJ_required = true;
		}
	}
}

// the evsYmaV function
function evsYmaV(add_php_helper_site_evsYmaV)
{
	// set the function logic
	if (add_php_helper_site_evsYmaV == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_evsYmaVQXd_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_evsYmaVQXd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_evsYmaVQXd_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_evsYmaVQXd_required = true;
		}
	}
}

// the ZujyBCa function
function ZujyBCa(add_css_ZujyBCa)
{
	// set the function logic
	if (add_css_ZujyBCa == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_ZujyBCapPX_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_ZujyBCapPX_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_ZujyBCapPX_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_ZujyBCapPX_required = true;
		}
	}
}

// the jdtfBfe function
function jdtfBfe(add_sql_jdtfBfe)
{
	// set the function logic
	if (add_sql_jdtfBfe == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_jdtfBfexHF_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_jdtfBfexHF_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_jdtfBfexHF_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_jdtfBfexHF_required = true;
		}
	}
}

// the lNgzJAG function
function lNgzJAG(emptycontributors_lNgzJAG)
{
	// set the function logic
	if (emptycontributors_lNgzJAG == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the KrxHqRV function
function KrxHqRV(add_license_KrxHqRV)
{
	// set the function logic
	if (add_license_KrxHqRV == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_KrxHqRVOtq_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_KrxHqRVOtq_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_KrxHqRVOtq_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_KrxHqRVOtq_required = true;
		}
	}
}

// the RFiNKqj function
function RFiNKqj(add_admin_event_RFiNKqj)
{
	// set the function logic
	if (add_admin_event_RFiNKqj == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_RFiNKqjURu_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_RFiNKqjURu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_RFiNKqjURu_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_RFiNKqjURu_required = true;
		}
	}
}

// the XqbIKPK function
function XqbIKPK(add_site_event_XqbIKPK)
{
	// set the function logic
	if (add_site_event_XqbIKPK == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_XqbIKPKnyk_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_XqbIKPKnyk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_XqbIKPKnyk_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_XqbIKPKnyk_required = true;
		}
	}
}

// the PnCsUNj function
function PnCsUNj(addreadme_PnCsUNj)
{
	// set the function logic
	if (addreadme_PnCsUNj == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_PnCsUNjRFD_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_PnCsUNjRFD_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_PnCsUNjRFD_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_PnCsUNjRFD_required = true;
		}
	}
}

// the kpcqgQC function
function kpcqgQC(add_license_kpcqgQC)
{
	// set the function logic
	if (add_license_kpcqgQC == 1)
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

// the wGvLJTM function
function wGvLJTM(add_php_dashboard_methods_wGvLJTM)
{
	// set the function logic
	if (add_php_dashboard_methods_wGvLJTM == 1)
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').show();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').show();
		if (jform_wGvLJTMlwE_required)
		{
			updateFieldRequired('php_dashboard_methods',0);
			jQuery('#jform_php_dashboard_methods').prop('required','required');
			jQuery('#jform_php_dashboard_methods').attr('aria-required',true);
			jQuery('#jform_php_dashboard_methods').addClass('required');
			jform_wGvLJTMlwE_required = false;
		}

	}
	else
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').hide();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').hide();
		if (!jform_wGvLJTMlwE_required)
		{
			updateFieldRequired('php_dashboard_methods',1);
			jQuery('#jform_php_dashboard_methods').removeAttr('required');
			jQuery('#jform_php_dashboard_methods').removeAttr('aria-required');
			jQuery('#jform_php_dashboard_methods').removeClass('required');
			jform_wGvLJTMlwE_required = true;
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
