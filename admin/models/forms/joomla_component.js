/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvvvvvvv_required = false;
jform_vvvvvvwvvw_required = false;
jform_vvvvvvxvvx_required = false;
jform_vvvvvvyvvy_required = false;
jform_vvvvvvzvvz_required = false;
jform_vvvvvwavwa_required = false;
jform_vvvvvwbvwb_required = false;
jform_vvvvvwcvwc_required = false;
jform_vvvvvwevwd_required = false;
jform_vvvvvwfvwe_required = false;
jform_vvvvvwgvwf_required = false;
jform_vvvvvwhvwg_required = false;
jform_vvvvvwlvwh_required = false;
jform_vvvvvwmvwi_required = false;
jform_vvvvvwnvwj_required = false;
jform_vvvvvwovwk_required = false;
jform_vvvvvwpvwl_required = false;
jform_vvvvvwwvwm_required = false;
jform_vvvvvwxvwn_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_vvvvvvv = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	vvvvvvv(add_php_helper_admin_vvvvvvv);

	var add_php_helper_site_vvvvvvw = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	vvvvvvw(add_php_helper_site_vvvvvvw);

	var add_php_helper_both_vvvvvvx = jQuery("#jform_add_php_helper_both input[type='radio']:checked").val();
	vvvvvvx(add_php_helper_both_vvvvvvx);

	var add_css_admin_vvvvvvy = jQuery("#jform_add_css_admin input[type='radio']:checked").val();
	vvvvvvy(add_css_admin_vvvvvvy);

	var add_css_site_vvvvvvz = jQuery("#jform_add_css_site input[type='radio']:checked").val();
	vvvvvvz(add_css_site_vvvvvvz);

	var add_javascript_vvvvvwa = jQuery("#jform_add_javascript input[type='radio']:checked").val();
	vvvvvwa(add_javascript_vvvvvwa);

	var add_sql_vvvvvwb = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvwb(add_sql_vvvvvwb);

	var add_sql_uninstall_vvvvvwc = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvwc(add_sql_uninstall_vvvvvwc);

	var emptycontributors_vvvvvwd = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	vvvvvwd(emptycontributors_vvvvvwd);

	var add_license_vvvvvwe = jQuery("#jform_add_license input[type='radio']:checked").val();
	vvvvvwe(add_license_vvvvvwe);

	var add_admin_event_vvvvvwf = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	vvvvvwf(add_admin_event_vvvvvwf);

	var add_site_event_vvvvvwg = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	vvvvvwg(add_site_event_vvvvvwg);

	var addreadme_vvvvvwh = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvwh(addreadme_vvvvvwh);

	var add_update_server_vvvvvwi = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwi(add_update_server_vvvvvwi);

	var add_sales_server_vvvvvwj = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvwj(add_sales_server_vvvvvwj);

	var add_license_vvvvvwk = jQuery("#jform_add_license input[type='radio']:checked").val();
	vvvvvwk(add_license_vvvvvwk);

	var add_php_postflight_install_vvvvvwl = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvwl(add_php_postflight_install_vvvvvwl);

	var add_php_postflight_update_vvvvvwm = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvwm(add_php_postflight_update_vvvvvwm);

	var add_php_method_uninstall_vvvvvwn = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvwn(add_php_method_uninstall_vvvvvwn);

	var add_php_preflight_install_vvvvvwo = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvwo(add_php_preflight_install_vvvvvwo);

	var add_php_preflight_update_vvvvvwp = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvwp(add_php_preflight_update_vvvvvwp);

	var update_server_target_vvvvvwq = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwq = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwq(update_server_target_vvvvvwq,add_update_server_vvvvvwq);

	var add_update_server_vvvvvwr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvwr = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvwr(add_update_server_vvvvvwr,update_server_target_vvvvvwr);

	var update_server_target_vvvvvws = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvws = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvws(update_server_target_vvvvvws,add_update_server_vvvvvws);

	var update_server_target_vvvvvwu = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvwu = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvwu(update_server_target_vvvvvwu,add_update_server_vvvvvwu);

	var add_update_server_vvvvvww = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvww(add_update_server_vvvvvww);

	var buildcomp_vvvvvwx = jQuery("#jform_buildcomp input[type='radio']:checked").val();
	vvvvvwx(buildcomp_vvvvvwx);

	var dashboard_type_vvvvvwy = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	vvvvvwy(dashboard_type_vvvvvwy);

	var dashboard_type_vvvvvwz = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	vvvvvwz(dashboard_type_vvvvvwz);
});

// the vvvvvvv function
function vvvvvvv(add_php_helper_admin_vvvvvvv)
{
	// set the function logic
	if (add_php_helper_admin_vvvvvvv == 1)
	{
		jQuery('#jform_php_helper_admin-lbl').closest('.control-group').show();
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
		jQuery('#jform_php_helper_admin-lbl').closest('.control-group').hide();
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
		jQuery('#jform_php_helper_site-lbl').closest('.control-group').show();
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
		jQuery('#jform_php_helper_site-lbl').closest('.control-group').hide();
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
function vvvvvvx(add_php_helper_both_vvvvvvx)
{
	// set the function logic
	if (add_php_helper_both_vvvvvvx == 1)
	{
		jQuery('#jform_php_helper_both-lbl').closest('.control-group').show();
		if (jform_vvvvvvxvvx_required)
		{
			updateFieldRequired('php_helper_both',0);
			jQuery('#jform_php_helper_both').prop('required','required');
			jQuery('#jform_php_helper_both').attr('aria-required',true);
			jQuery('#jform_php_helper_both').addClass('required');
			jform_vvvvvvxvvx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_both-lbl').closest('.control-group').hide();
		if (!jform_vvvvvvxvvx_required)
		{
			updateFieldRequired('php_helper_both',1);
			jQuery('#jform_php_helper_both').removeAttr('required');
			jQuery('#jform_php_helper_both').removeAttr('aria-required');
			jQuery('#jform_php_helper_both').removeClass('required');
			jform_vvvvvvxvvx_required = true;
		}
	}
}

// the vvvvvvy function
function vvvvvvy(add_css_admin_vvvvvvy)
{
	// set the function logic
	if (add_css_admin_vvvvvvy == 1)
	{
		jQuery('#jform_css_admin-lbl').closest('.control-group').show();
		if (jform_vvvvvvyvvy_required)
		{
			updateFieldRequired('css_admin',0);
			jQuery('#jform_css_admin').prop('required','required');
			jQuery('#jform_css_admin').attr('aria-required',true);
			jQuery('#jform_css_admin').addClass('required');
			jform_vvvvvvyvvy_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_admin-lbl').closest('.control-group').hide();
		if (!jform_vvvvvvyvvy_required)
		{
			updateFieldRequired('css_admin',1);
			jQuery('#jform_css_admin').removeAttr('required');
			jQuery('#jform_css_admin').removeAttr('aria-required');
			jQuery('#jform_css_admin').removeClass('required');
			jform_vvvvvvyvvy_required = true;
		}
	}
}

// the vvvvvvz function
function vvvvvvz(add_css_site_vvvvvvz)
{
	// set the function logic
	if (add_css_site_vvvvvvz == 1)
	{
		jQuery('#jform_css_site-lbl').closest('.control-group').show();
		if (jform_vvvvvvzvvz_required)
		{
			updateFieldRequired('css_site',0);
			jQuery('#jform_css_site').prop('required','required');
			jQuery('#jform_css_site').attr('aria-required',true);
			jQuery('#jform_css_site').addClass('required');
			jform_vvvvvvzvvz_required = false;
		}

	}
	else
	{
		jQuery('#jform_css_site-lbl').closest('.control-group').hide();
		if (!jform_vvvvvvzvvz_required)
		{
			updateFieldRequired('css_site',1);
			jQuery('#jform_css_site').removeAttr('required');
			jQuery('#jform_css_site').removeAttr('aria-required');
			jQuery('#jform_css_site').removeClass('required');
			jform_vvvvvvzvvz_required = true;
		}
	}
}

// the vvvvvwa function
function vvvvvwa(add_javascript_vvvvvwa)
{
	// set the function logic
	if (add_javascript_vvvvvwa == 1)
	{
		jQuery('#jform_javascript-lbl').closest('.control-group').show();
		if (jform_vvvvvwavwa_required)
		{
			updateFieldRequired('javascript',0);
			jQuery('#jform_javascript').prop('required','required');
			jQuery('#jform_javascript').attr('aria-required',true);
			jQuery('#jform_javascript').addClass('required');
			jform_vvvvvwavwa_required = false;
		}

	}
	else
	{
		jQuery('#jform_javascript-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwavwa_required)
		{
			updateFieldRequired('javascript',1);
			jQuery('#jform_javascript').removeAttr('required');
			jQuery('#jform_javascript').removeAttr('aria-required');
			jQuery('#jform_javascript').removeClass('required');
			jform_vvvvvwavwa_required = true;
		}
	}
}

// the vvvvvwb function
function vvvvvwb(add_sql_vvvvvwb)
{
	// set the function logic
	if (add_sql_vvvvvwb == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_vvvvvwbvwb_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvwbvwb_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_vvvvvwbvwb_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvwbvwb_required = true;
		}
	}
}

// the vvvvvwc function
function vvvvvwc(add_sql_uninstall_vvvvvwc)
{
	// set the function logic
	if (add_sql_uninstall_vvvvvwc == 1)
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').show();
		if (jform_vvvvvwcvwc_required)
		{
			updateFieldRequired('sql_uninstall',0);
			jQuery('#jform_sql_uninstall').prop('required','required');
			jQuery('#jform_sql_uninstall').attr('aria-required',true);
			jQuery('#jform_sql_uninstall').addClass('required');
			jform_vvvvvwcvwc_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').hide();
		if (!jform_vvvvvwcvwc_required)
		{
			updateFieldRequired('sql_uninstall',1);
			jQuery('#jform_sql_uninstall').removeAttr('required');
			jQuery('#jform_sql_uninstall').removeAttr('aria-required');
			jQuery('#jform_sql_uninstall').removeClass('required');
			jform_vvvvvwcvwc_required = true;
		}
	}
}

// the vvvvvwd function
function vvvvvwd(emptycontributors_vvvvvwd)
{
	// set the function logic
	if (emptycontributors_vvvvvwd == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the vvvvvwe function
function vvvvvwe(add_license_vvvvvwe)
{
	// set the function logic
	if (add_license_vvvvvwe == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_vvvvvwevwd_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_vvvvvwevwd_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_vvvvvwevwd_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_vvvvvwevwd_required = true;
		}
	}
}

// the vvvvvwf function
function vvvvvwf(add_admin_event_vvvvvwf)
{
	// set the function logic
	if (add_admin_event_vvvvvwf == 1)
	{
		jQuery('#jform_php_admin_event-lbl').closest('.control-group').show();
		if (jform_vvvvvwfvwe_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_vvvvvwfvwe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwfvwe_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_vvvvvwfvwe_required = true;
		}
	}
}

// the vvvvvwg function
function vvvvvwg(add_site_event_vvvvvwg)
{
	// set the function logic
	if (add_site_event_vvvvvwg == 1)
	{
		jQuery('#jform_php_site_event-lbl').closest('.control-group').show();
		if (jform_vvvvvwgvwf_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_vvvvvwgvwf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwgvwf_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_vvvvvwgvwf_required = true;
		}
	}
}

// the vvvvvwh function
function vvvvvwh(addreadme_vvvvvwh)
{
	// set the function logic
	if (addreadme_vvvvvwh == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_vvvvvwhvwg_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_vvvvvwhvwg_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwhvwg_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_vvvvvwhvwg_required = true;
		}
	}
}

// the vvvvvwi function
function vvvvvwi(add_update_server_vvvvvwi)
{
	// set the function logic
	if (add_update_server_vvvvvwi == 1)
	{
		jQuery('#jform_update_server_url').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server_url').closest('.control-group').hide();
	}
}

// the vvvvvwj function
function vvvvvwj(add_sales_server_vvvvvwj)
{
	// set the function logic
	if (add_sales_server_vvvvvwj == 1)
	{
		jQuery('#jform_sales_server').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_sales_server').closest('.control-group').hide();
	}
}

// the vvvvvwk function
function vvvvvwk(add_license_vvvvvwk)
{
	// set the function logic
	if (add_license_vvvvvwk == 1)
	{
		jQuery('.note_whmcs_lisencing_note').closest('.control-group').show();
		jQuery('#jform_whmcs_key').closest('.control-group').show();
		jQuery('#jform_whmcs_url').closest('.control-group').show();
		jQuery('#jform_whmcs_buy_link').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_whmcs_lisencing_note').closest('.control-group').hide();
		jQuery('#jform_whmcs_key').closest('.control-group').hide();
		jQuery('#jform_whmcs_url').closest('.control-group').hide();
		jQuery('#jform_whmcs_buy_link').closest('.control-group').hide();
	}
}

// the vvvvvwl function
function vvvvvwl(add_php_postflight_install_vvvvvwl)
{
	// set the function logic
	if (add_php_postflight_install_vvvvvwl == 1)
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').show();
		if (jform_vvvvvwlvwh_required)
		{
			updateFieldRequired('php_postflight_install',0);
			jQuery('#jform_php_postflight_install').prop('required','required');
			jQuery('#jform_php_postflight_install').attr('aria-required',true);
			jQuery('#jform_php_postflight_install').addClass('required');
			jform_vvvvvwlvwh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwlvwh_required)
		{
			updateFieldRequired('php_postflight_install',1);
			jQuery('#jform_php_postflight_install').removeAttr('required');
			jQuery('#jform_php_postflight_install').removeAttr('aria-required');
			jQuery('#jform_php_postflight_install').removeClass('required');
			jform_vvvvvwlvwh_required = true;
		}
	}
}

// the vvvvvwm function
function vvvvvwm(add_php_postflight_update_vvvvvwm)
{
	// set the function logic
	if (add_php_postflight_update_vvvvvwm == 1)
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').show();
		if (jform_vvvvvwmvwi_required)
		{
			updateFieldRequired('php_postflight_update',0);
			jQuery('#jform_php_postflight_update').prop('required','required');
			jQuery('#jform_php_postflight_update').attr('aria-required',true);
			jQuery('#jform_php_postflight_update').addClass('required');
			jform_vvvvvwmvwi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwmvwi_required)
		{
			updateFieldRequired('php_postflight_update',1);
			jQuery('#jform_php_postflight_update').removeAttr('required');
			jQuery('#jform_php_postflight_update').removeAttr('aria-required');
			jQuery('#jform_php_postflight_update').removeClass('required');
			jform_vvvvvwmvwi_required = true;
		}
	}
}

// the vvvvvwn function
function vvvvvwn(add_php_method_uninstall_vvvvvwn)
{
	// set the function logic
	if (add_php_method_uninstall_vvvvvwn == 1)
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').show();
		if (jform_vvvvvwnvwj_required)
		{
			updateFieldRequired('php_method_uninstall',0);
			jQuery('#jform_php_method_uninstall').prop('required','required');
			jQuery('#jform_php_method_uninstall').attr('aria-required',true);
			jQuery('#jform_php_method_uninstall').addClass('required');
			jform_vvvvvwnvwj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwnvwj_required)
		{
			updateFieldRequired('php_method_uninstall',1);
			jQuery('#jform_php_method_uninstall').removeAttr('required');
			jQuery('#jform_php_method_uninstall').removeAttr('aria-required');
			jQuery('#jform_php_method_uninstall').removeClass('required');
			jform_vvvvvwnvwj_required = true;
		}
	}
}

// the vvvvvwo function
function vvvvvwo(add_php_preflight_install_vvvvvwo)
{
	// set the function logic
	if (add_php_preflight_install_vvvvvwo == 1)
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').show();
		if (jform_vvvvvwovwk_required)
		{
			updateFieldRequired('php_preflight_install',0);
			jQuery('#jform_php_preflight_install').prop('required','required');
			jQuery('#jform_php_preflight_install').attr('aria-required',true);
			jQuery('#jform_php_preflight_install').addClass('required');
			jform_vvvvvwovwk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwovwk_required)
		{
			updateFieldRequired('php_preflight_install',1);
			jQuery('#jform_php_preflight_install').removeAttr('required');
			jQuery('#jform_php_preflight_install').removeAttr('aria-required');
			jQuery('#jform_php_preflight_install').removeClass('required');
			jform_vvvvvwovwk_required = true;
		}
	}
}

// the vvvvvwp function
function vvvvvwp(add_php_preflight_update_vvvvvwp)
{
	// set the function logic
	if (add_php_preflight_update_vvvvvwp == 1)
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').show();
		if (jform_vvvvvwpvwl_required)
		{
			updateFieldRequired('php_preflight_update',0);
			jQuery('#jform_php_preflight_update').prop('required','required');
			jQuery('#jform_php_preflight_update').attr('aria-required',true);
			jQuery('#jform_php_preflight_update').addClass('required');
			jform_vvvvvwpvwl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').hide();
		if (!jform_vvvvvwpvwl_required)
		{
			updateFieldRequired('php_preflight_update',1);
			jQuery('#jform_php_preflight_update').removeAttr('required');
			jQuery('#jform_php_preflight_update').removeAttr('aria-required');
			jQuery('#jform_php_preflight_update').removeClass('required');
			jform_vvvvvwpvwl_required = true;
		}
	}
}

// the vvvvvwq function
function vvvvvwq(update_server_target_vvvvvwq,add_update_server_vvvvvwq)
{
	// set the function logic
	if (update_server_target_vvvvvwq == 1 && add_update_server_vvvvvwq == 1)
	{
		jQuery('#jform_update_server').closest('.control-group').show();
		jQuery('.note_update_server_note_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server').closest('.control-group').hide();
		jQuery('.note_update_server_note_ftp').closest('.control-group').hide();
	}
}

// the vvvvvwr function
function vvvvvwr(add_update_server_vvvvvwr,update_server_target_vvvvvwr)
{
	// set the function logic
	if (add_update_server_vvvvvwr == 1 && update_server_target_vvvvvwr == 1)
	{
		jQuery('#jform_update_server').closest('.control-group').show();
		jQuery('.note_update_server_note_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server').closest('.control-group').hide();
		jQuery('.note_update_server_note_ftp').closest('.control-group').hide();
	}
}

// the vvvvvws function
function vvvvvws(update_server_target_vvvvvws,add_update_server_vvvvvws)
{
	// set the function logic
	if (update_server_target_vvvvvws == 2 && add_update_server_vvvvvws == 1)
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').hide();
	}
}

// the vvvvvwu function
function vvvvvwu(update_server_target_vvvvvwu,add_update_server_vvvvvwu)
{
	// set the function logic
	if (update_server_target_vvvvvwu == 3 && add_update_server_vvvvvwu == 1)
	{
		jQuery('.note_update_server_note_other').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_other').closest('.control-group').hide();
	}
}

// the vvvvvww function
function vvvvvww(add_update_server_vvvvvww)
{
	// set the function logic
	if (add_update_server_vvvvvww == 1)
	{
		jQuery('#jform_update_server_target').closest('.control-group').show();
		if (jform_vvvvvwwvwm_required)
		{
			updateFieldRequired('update_server_target',0);
			jQuery('#jform_update_server_target').prop('required','required');
			jQuery('#jform_update_server_target').attr('aria-required',true);
			jQuery('#jform_update_server_target').addClass('required');
			jform_vvvvvwwvwm_required = false;
		}

	}
	else
	{
		jQuery('#jform_update_server_target').closest('.control-group').hide();
		if (!jform_vvvvvwwvwm_required)
		{
			updateFieldRequired('update_server_target',1);
			jQuery('#jform_update_server_target').removeAttr('required');
			jQuery('#jform_update_server_target').removeAttr('aria-required');
			jQuery('#jform_update_server_target').removeClass('required');
			jform_vvvvvwwvwm_required = true;
		}
	}
}

// the vvvvvwx function
function vvvvvwx(buildcomp_vvvvvwx)
{
	// set the function logic
	if (buildcomp_vvvvvwx == 1)
	{
		jQuery('#jform_buildcompsql').closest('.control-group').show();
		if (jform_vvvvvwxvwn_required)
		{
			updateFieldRequired('buildcompsql',0);
			jQuery('#jform_buildcompsql').prop('required','required');
			jQuery('#jform_buildcompsql').attr('aria-required',true);
			jQuery('#jform_buildcompsql').addClass('required');
			jform_vvvvvwxvwn_required = false;
		}

	}
	else
	{
		jQuery('#jform_buildcompsql').closest('.control-group').hide();
		if (!jform_vvvvvwxvwn_required)
		{
			updateFieldRequired('buildcompsql',1);
			jQuery('#jform_buildcompsql').removeAttr('required');
			jQuery('#jform_buildcompsql').removeAttr('aria-required');
			jQuery('#jform_buildcompsql').removeClass('required');
			jform_vvvvvwxvwn_required = true;
		}
	}
}

// the vvvvvwy function
function vvvvvwy(dashboard_type_vvvvvwy)
{
	// set the function logic
	if (dashboard_type_vvvvvwy == 2)
	{
		jQuery('#jform_dashboard').closest('.control-group').show();
		jQuery('.note_dynamic_dashboard').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_dashboard').closest('.control-group').hide();
		jQuery('.note_dynamic_dashboard').closest('.control-group').hide();
	}
}

// the vvvvvwz function
function vvvvvwz(dashboard_type_vvvvvwz)
{
	// set the function logic
	if (dashboard_type_vvvvvwz == 1)
	{
		jQuery('.note_botton_component_dashboard').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_botton_component_dashboard').closest('.control-group').hide();
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


jQuery(document).ready(function()
{
	// check what is the dashboard switch
	var dasboard_type = jQuery("#jform_dashboard_type input[type='radio']:checked").val();
	dasboardSwitch(dasboard_type);
	// set buttons
	function setButtons1() {
		addButtonID('component_files_folders','button_component_files_folders', 1);
		addButtonID('component_site_views','button_create_edit_views', 1);
	 }
	function setButtons2() {
		addButtonID('component_updates','component_version', 1);
		addButtonID('component_mysql_tweaks','button_mysql_tweak_options', 1);
		addButtonID('component_custom_admin_views','button_create_edit_views', 1);
	 }
	function setButtons3() {
		addButtonID('component_custom_admin_menus','button_add_custom_menus', 1);
		addButtonID('component_config','button_add_config', 1);
		addButtonID('component_admin_views','button_create_edit_views', 1);
	 }

	 // use setTimeout() to execute
	 setTimeout(setButtons1, 1000);
	 setTimeout(setButtons2, 2000);
	 setTimeout(setButtons3, 3000);
	
	// now load the displays
	function setDisplays1() {
		getAjaxDisplay('component_admin_views');
	}
	function setDisplays2() {
		getAjaxDisplay('component_custom_admin_views');
	}
	function setDisplays3() {
		getAjaxDisplay('component_site_views');
	}

	 // use setTimeout() to execute
	 setTimeout(setDisplays1, 1500);
	 setTimeout(setDisplays2, 2500);
	 setTimeout(setDisplays3, 3500);

	// very basic I know... but it will have to do for now.
});

function getAjaxDisplay(type){
	getAjaxDisplay_server(type).done(function(result) {
		if(result){
			jQuery('#display_'+type).html(result);
		}
		// set button
		addButtonID(type,'header_'+type+'_buttons', 2); // <-- little edit button
	});
}

function getAjaxDisplay_server(type){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&vdm="+vastDevMod;
	if(token.length > 0 && type.length > 0){
		var request = 'token='+token+'&type=' + type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function addData(result, where){
	jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
}

function dasboardSwitch(value){
	// hide if default
	if (2 == value) {
		jQuery('.control-group-componentdashboard-one').hide();
	} else {
		// default behaviour
		if (jQuery('div.control-group-componentdashboard-one').length) {
			jQuery('.control-group-componentdashboard-one').show();
		} else {
			addButtonID('component_dashboard','button_component_dashboard', 1);
		}
	}
}


function addButtonID_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButtonID&format=json&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0 && size > 0){
		var request = 'token='+token+'&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}
function addButtonID(type, where, size){
	addButtonID_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	});
}

function addButton_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = 'token='+token+'&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}
function addButton(type, where, size){
	// just to insure that default behaviour still works
	size = typeof size !== 'undefined' ? size : 1;
	addButton_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	})
}
 
