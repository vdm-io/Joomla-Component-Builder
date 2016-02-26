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
jform_uAZCUXcsJo_required = false;
jform_IueMSvZXFu_required = false;
jform_GHPwgxywSJ_required = false;
jform_XrjWNfTNwE_required = false;
jform_WJrqjYjzfA_required = false;
jform_eBzTyLaute_required = false;
jform_pkIOkPBtKm_required = false;
jform_WGUjdeiqLl_required = false;
jform_CBwMLzotQg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_uAZCUXc = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	uAZCUXc(add_php_helper_admin_uAZCUXc);

	var add_php_helper_site_IueMSvZ = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	IueMSvZ(add_php_helper_site_IueMSvZ);

	var add_css_GHPwgxy = jQuery("#jform_add_css input[type='radio']:checked").val();
	GHPwgxy(add_css_GHPwgxy);

	var add_sql_XrjWNfT = jQuery("#jform_add_sql input[type='radio']:checked").val();
	XrjWNfT(add_sql_XrjWNfT);

	var emptycontributors_akTeWGI = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	akTeWGI(emptycontributors_akTeWGI);

	var add_license_WJrqjYj = jQuery("#jform_add_license input[type='radio']:checked").val();
	WJrqjYj(add_license_WJrqjYj);

	var add_admin_event_eBzTyLa = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	eBzTyLa(add_admin_event_eBzTyLa);

	var add_site_event_pkIOkPB = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	pkIOkPB(add_site_event_pkIOkPB);

	var addreadme_WGUjdei = jQuery("#jform_addreadme input[type='radio']:checked").val();
	WGUjdei(addreadme_WGUjdei);

	var add_license_QKHpIgW = jQuery("#jform_add_license input[type='radio']:checked").val();
	QKHpIgW(add_license_QKHpIgW);

	var add_php_dashboard_methods_CBwMLzo = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	CBwMLzo(add_php_dashboard_methods_CBwMLzo);
});

// the uAZCUXc function
function uAZCUXc(add_php_helper_admin_uAZCUXc)
{
	// set the function logic
	if (add_php_helper_admin_uAZCUXc == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_uAZCUXcsJo_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_uAZCUXcsJo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_uAZCUXcsJo_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_uAZCUXcsJo_required = true;
		}
	}
}

// the IueMSvZ function
function IueMSvZ(add_php_helper_site_IueMSvZ)
{
	// set the function logic
	if (add_php_helper_site_IueMSvZ == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_IueMSvZXFu_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_IueMSvZXFu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_IueMSvZXFu_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_IueMSvZXFu_required = true;
		}
	}
}

// the GHPwgxy function
function GHPwgxy(add_css_GHPwgxy)
{
	// set the function logic
	if (add_css_GHPwgxy == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_GHPwgxywSJ_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_GHPwgxywSJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_GHPwgxywSJ_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_GHPwgxywSJ_required = true;
		}
	}
}

// the XrjWNfT function
function XrjWNfT(add_sql_XrjWNfT)
{
	// set the function logic
	if (add_sql_XrjWNfT == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_XrjWNfTNwE_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_XrjWNfTNwE_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_XrjWNfTNwE_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_XrjWNfTNwE_required = true;
		}
	}
}

// the akTeWGI function
function akTeWGI(emptycontributors_akTeWGI)
{
	// set the function logic
	if (emptycontributors_akTeWGI == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the WJrqjYj function
function WJrqjYj(add_license_WJrqjYj)
{
	// set the function logic
	if (add_license_WJrqjYj == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_WJrqjYjzfA_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_WJrqjYjzfA_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_WJrqjYjzfA_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_WJrqjYjzfA_required = true;
		}
	}
}

// the eBzTyLa function
function eBzTyLa(add_admin_event_eBzTyLa)
{
	// set the function logic
	if (add_admin_event_eBzTyLa == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_eBzTyLaute_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_eBzTyLaute_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_eBzTyLaute_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_eBzTyLaute_required = true;
		}
	}
}

// the pkIOkPB function
function pkIOkPB(add_site_event_pkIOkPB)
{
	// set the function logic
	if (add_site_event_pkIOkPB == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_pkIOkPBtKm_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_pkIOkPBtKm_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_pkIOkPBtKm_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_pkIOkPBtKm_required = true;
		}
	}
}

// the WGUjdei function
function WGUjdei(addreadme_WGUjdei)
{
	// set the function logic
	if (addreadme_WGUjdei == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_WGUjdeiqLl_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_WGUjdeiqLl_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_WGUjdeiqLl_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_WGUjdeiqLl_required = true;
		}
	}
}

// the QKHpIgW function
function QKHpIgW(add_license_QKHpIgW)
{
	// set the function logic
	if (add_license_QKHpIgW == 1)
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

// the CBwMLzo function
function CBwMLzo(add_php_dashboard_methods_CBwMLzo)
{
	// set the function logic
	if (add_php_dashboard_methods_CBwMLzo == 1)
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').show();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').show();
		if (jform_CBwMLzotQg_required)
		{
			updateFieldRequired('php_dashboard_methods',0);
			jQuery('#jform_php_dashboard_methods').prop('required','required');
			jQuery('#jform_php_dashboard_methods').attr('aria-required',true);
			jQuery('#jform_php_dashboard_methods').addClass('required');
			jform_CBwMLzotQg_required = false;
		}

	}
	else
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').hide();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').hide();
		if (!jform_CBwMLzotQg_required)
		{
			updateFieldRequired('php_dashboard_methods',1);
			jQuery('#jform_php_dashboard_methods').removeAttr('required');
			jQuery('#jform_php_dashboard_methods').removeAttr('aria-required');
			jQuery('#jform_php_dashboard_methods').removeClass('required');
			jform_CBwMLzotQg_required = true;
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
