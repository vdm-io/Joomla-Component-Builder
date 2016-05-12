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

	@version		2.1.8
	@build			12th May, 2016
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
jform_vvvvvvvvvv_required = false;
jform_vvvvvvwvvw_required = false;
jform_vvvvvvxvvx_required = false;
jform_vvvvvvyvvy_required = false;
jform_vvvvvwavvz_required = false;
jform_vvvvvwbvwa_required = false;
jform_vvvvvwcvwb_required = false;
jform_vvvvvwdvwc_required = false;
jform_vvvvvwhvwd_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_vvvvvvv = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	vvvvvvv(add_php_helper_admin_vvvvvvv);

	var add_php_helper_site_vvvvvvw = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	vvvvvvw(add_php_helper_site_vvvvvvw);

	var add_css_vvvvvvx = jQuery("#jform_add_css input[type='radio']:checked").val();
	vvvvvvx(add_css_vvvvvvx);

	var add_sql_vvvvvvy = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvvy(add_sql_vvvvvvy);

	var emptycontributors_vvvvvvz = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	vvvvvvz(emptycontributors_vvvvvvz);

	var add_license_vvvvvwa = jQuery("#jform_add_license input[type='radio']:checked").val();
	vvvvvwa(add_license_vvvvvwa);

	var add_admin_event_vvvvvwb = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	vvvvvwb(add_admin_event_vvvvvwb);

	var add_site_event_vvvvvwc = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	vvvvvwc(add_site_event_vvvvvwc);

	var addreadme_vvvvvwd = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvwd(addreadme_vvvvvwd);

	var add_update_server_vvvvvwe = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwe(add_update_server_vvvvvwe);

	var add_sales_server_vvvvvwf = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvwf(add_sales_server_vvvvvwf);

	var add_license_vvvvvwg = jQuery("#jform_add_license input[type='radio']:checked").val();
	vvvvvwg(add_license_vvvvvwg);

	var add_php_dashboard_methods_vvvvvwh = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	vvvvvwh(add_php_dashboard_methods_vvvvvwh);
});

// the vvvvvvv function
function vvvvvvv(add_php_helper_admin_vvvvvvv)
{
	// set the function logic
	if (add_php_helper_admin_vvvvvvv == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_vvvvvvvvvv_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_vvvvvvvvvv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_vvvvvvvvvv_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_vvvvvvvvvv_required = true;
		}
	}
}

// the vvvvvvw function
function vvvvvvw(add_php_helper_site_vvvvvvw)
{
	// set the function logic
	if (add_php_helper_site_vvvvvvw == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_vvvvvvwvvw_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_vvvvvvwvvw_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_vvvvvvwvvw_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_vvvvvvwvvw_required = true;
		}
	}
}

// the vvvvvvx function
function vvvvvvx(add_css_vvvvvvx)
{
	// set the function logic
	if (add_css_vvvvvvx == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_vvvvvvxvvx_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_vvvvvvxvvx_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_vvvvvvxvvx_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_vvvvvvxvvx_required = true;
		}
	}
}

// the vvvvvvy function
function vvvvvvy(add_sql_vvvvvvy)
{
	// set the function logic
	if (add_sql_vvvvvvy == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_vvvvvvyvvy_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvvyvvy_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_vvvvvvyvvy_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvvyvvy_required = true;
		}
	}
}

// the vvvvvvz function
function vvvvvvz(emptycontributors_vvvvvvz)
{
	// set the function logic
	if (emptycontributors_vvvvvvz == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the vvvvvwa function
function vvvvvwa(add_license_vvvvvwa)
{
	// set the function logic
	if (add_license_vvvvvwa == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_vvvvvwavvz_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_vvvvvwavvz_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_vvvvvwavvz_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_vvvvvwavvz_required = true;
		}
	}
}

// the vvvvvwb function
function vvvvvwb(add_admin_event_vvvvvwb)
{
	// set the function logic
	if (add_admin_event_vvvvvwb == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_vvvvvwbvwa_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_vvvvvwbvwa_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_vvvvvwbvwa_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_vvvvvwbvwa_required = true;
		}
	}
}

// the vvvvvwc function
function vvvvvwc(add_site_event_vvvvvwc)
{
	// set the function logic
	if (add_site_event_vvvvvwc == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_vvvvvwcvwb_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_vvvvvwcvwb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_vvvvvwcvwb_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_vvvvvwcvwb_required = true;
		}
	}
}

// the vvvvvwd function
function vvvvvwd(addreadme_vvvvvwd)
{
	// set the function logic
	if (addreadme_vvvvvwd == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_vvvvvwdvwc_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_vvvvvwdvwc_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwdvwc_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_vvvvvwdvwc_required = true;
		}
	}
}

// the vvvvvwe function
function vvvvvwe(add_update_server_vvvvvwe)
{
	// set the function logic
	if (add_update_server_vvvvvwe == 1)
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

// the vvvvvwf function
function vvvvvwf(add_sales_server_vvvvvwf)
{
	// set the function logic
	if (add_sales_server_vvvvvwf == 1)
	{
		jQuery('#jform_sales_server_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_sales_server_ftp').closest('.control-group').hide();
	}
}

// the vvvvvwg function
function vvvvvwg(add_license_vvvvvwg)
{
	// set the function logic
	if (add_license_vvvvvwg == 1)
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

// the vvvvvwh function
function vvvvvwh(add_php_dashboard_methods_vvvvvwh)
{
	// set the function logic
	if (add_php_dashboard_methods_vvvvvwh == 1)
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').show();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').show();
		if (jform_vvvvvwhvwd_required)
		{
			updateFieldRequired('php_dashboard_methods',0);
			jQuery('#jform_php_dashboard_methods').prop('required','required');
			jQuery('#jform_php_dashboard_methods').attr('aria-required',true);
			jQuery('#jform_php_dashboard_methods').addClass('required');
			jform_vvvvvwhvwd_required = false;
		}

	}
	else
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').hide();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').hide();
		if (!jform_vvvvvwhvwd_required)
		{
			updateFieldRequired('php_dashboard_methods',1);
			jQuery('#jform_php_dashboard_methods').removeAttr('required');
			jQuery('#jform_php_dashboard_methods').removeAttr('aria-required');
			jQuery('#jform_php_dashboard_methods').removeClass('required');
			jform_vvvvvwhvwd_required = true;
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
