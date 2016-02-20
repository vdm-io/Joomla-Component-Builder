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
jform_smGPrVGWEh_required = false;
jform_LhFLVtjxYX_required = false;
jform_DRykWOmcva_required = false;
jform_HKmgEMceCH_required = false;
jform_kqngNhMYcv_required = false;
jform_ldWlGLFRjl_required = false;
jform_UsUHGhzCjf_required = false;
jform_Pwrgvhlnft_required = false;
jform_fUDxPQlppz_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_smGPrVG = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	smGPrVG(add_php_helper_admin_smGPrVG);

	var add_php_helper_site_LhFLVtj = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	LhFLVtj(add_php_helper_site_LhFLVtj);

	var add_css_DRykWOm = jQuery("#jform_add_css input[type='radio']:checked").val();
	DRykWOm(add_css_DRykWOm);

	var add_sql_HKmgEMc = jQuery("#jform_add_sql input[type='radio']:checked").val();
	HKmgEMc(add_sql_HKmgEMc);

	var emptycontributors_qsPUZMo = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	qsPUZMo(emptycontributors_qsPUZMo);

	var add_license_kqngNhM = jQuery("#jform_add_license input[type='radio']:checked").val();
	kqngNhM(add_license_kqngNhM);

	var add_admin_event_ldWlGLF = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	ldWlGLF(add_admin_event_ldWlGLF);

	var add_site_event_UsUHGhz = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	UsUHGhz(add_site_event_UsUHGhz);

	var addreadme_Pwrgvhl = jQuery("#jform_addreadme input[type='radio']:checked").val();
	Pwrgvhl(addreadme_Pwrgvhl);

	var add_license_FosHHdm = jQuery("#jform_add_license input[type='radio']:checked").val();
	FosHHdm(add_license_FosHHdm);

	var add_php_dashboard_methods_fUDxPQl = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	fUDxPQl(add_php_dashboard_methods_fUDxPQl);
});

// the smGPrVG function
function smGPrVG(add_php_helper_admin_smGPrVG)
{
	// set the function logic
	if (add_php_helper_admin_smGPrVG == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_smGPrVGWEh_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_smGPrVGWEh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_smGPrVGWEh_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_smGPrVGWEh_required = true;
		}
	}
}

// the LhFLVtj function
function LhFLVtj(add_php_helper_site_LhFLVtj)
{
	// set the function logic
	if (add_php_helper_site_LhFLVtj == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_LhFLVtjxYX_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_LhFLVtjxYX_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_LhFLVtjxYX_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_LhFLVtjxYX_required = true;
		}
	}
}

// the DRykWOm function
function DRykWOm(add_css_DRykWOm)
{
	// set the function logic
	if (add_css_DRykWOm == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_DRykWOmcva_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_DRykWOmcva_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_DRykWOmcva_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_DRykWOmcva_required = true;
		}
	}
}

// the HKmgEMc function
function HKmgEMc(add_sql_HKmgEMc)
{
	// set the function logic
	if (add_sql_HKmgEMc == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_HKmgEMceCH_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_HKmgEMceCH_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_HKmgEMceCH_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_HKmgEMceCH_required = true;
		}
	}
}

// the qsPUZMo function
function qsPUZMo(emptycontributors_qsPUZMo)
{
	// set the function logic
	if (emptycontributors_qsPUZMo == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the kqngNhM function
function kqngNhM(add_license_kqngNhM)
{
	// set the function logic
	if (add_license_kqngNhM == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_kqngNhMYcv_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_kqngNhMYcv_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_kqngNhMYcv_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_kqngNhMYcv_required = true;
		}
	}
}

// the ldWlGLF function
function ldWlGLF(add_admin_event_ldWlGLF)
{
	// set the function logic
	if (add_admin_event_ldWlGLF == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_ldWlGLFRjl_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_ldWlGLFRjl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_ldWlGLFRjl_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_ldWlGLFRjl_required = true;
		}
	}
}

// the UsUHGhz function
function UsUHGhz(add_site_event_UsUHGhz)
{
	// set the function logic
	if (add_site_event_UsUHGhz == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_UsUHGhzCjf_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_UsUHGhzCjf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_UsUHGhzCjf_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_UsUHGhzCjf_required = true;
		}
	}
}

// the Pwrgvhl function
function Pwrgvhl(addreadme_Pwrgvhl)
{
	// set the function logic
	if (addreadme_Pwrgvhl == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_Pwrgvhlnft_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_Pwrgvhlnft_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_Pwrgvhlnft_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_Pwrgvhlnft_required = true;
		}
	}
}

// the FosHHdm function
function FosHHdm(add_license_FosHHdm)
{
	// set the function logic
	if (add_license_FosHHdm == 1)
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

// the fUDxPQl function
function fUDxPQl(add_php_dashboard_methods_fUDxPQl)
{
	// set the function logic
	if (add_php_dashboard_methods_fUDxPQl == 1)
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').show();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').show();
		if (jform_fUDxPQlppz_required)
		{
			updateFieldRequired('php_dashboard_methods',0);
			jQuery('#jform_php_dashboard_methods').prop('required','required');
			jQuery('#jform_php_dashboard_methods').attr('aria-required',true);
			jQuery('#jform_php_dashboard_methods').addClass('required');
			jform_fUDxPQlppz_required = false;
		}

	}
	else
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').hide();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').hide();
		if (!jform_fUDxPQlppz_required)
		{
			updateFieldRequired('php_dashboard_methods',1);
			jQuery('#jform_php_dashboard_methods').removeAttr('required');
			jQuery('#jform_php_dashboard_methods').removeAttr('aria-required');
			jQuery('#jform_php_dashboard_methods').removeClass('required');
			jform_fUDxPQlppz_required = true;
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
