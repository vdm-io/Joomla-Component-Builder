/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvvwbvvv_required = false;
jform_vvvvvwcvvw_required = false;
jform_vvvvvwevvx_required = false;
jform_vvvvvwwvvy_required = false;
jform_vvvvvwxvvz_required = false;
jform_vvvvvxavwa_required = false;
jform_vvvvvxavwb_required = false;
jform_vvvvvxavwc_required = false;

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

	var translation_tool_vvvvvxa = jQuery("#jform_translation_tool").val();
	vvvvvxa(translation_tool_vvvvvxa);
});

// the vvvvvvv function
function vvvvvvv(add_php_helper_admin_vvvvvvv)
{
	// set the function logic
	if (add_php_helper_admin_vvvvvvv == 1)
	{
		jQuery('#jform_php_helper_admin-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_helper_admin-lbl').closest('.control-group').hide();
	}
}

// the vvvvvvw function
function vvvvvvw(add_php_helper_site_vvvvvvw)
{
	// set the function logic
	if (add_php_helper_site_vvvvvvw == 1)
	{
		jQuery('#jform_php_helper_site-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_helper_site-lbl').closest('.control-group').hide();
	}
}

// the vvvvvvx function
function vvvvvvx(add_php_helper_both_vvvvvvx)
{
	// set the function logic
	if (add_php_helper_both_vvvvvvx == 1)
	{
		jQuery('#jform_php_helper_both-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_helper_both-lbl').closest('.control-group').hide();
	}
}

// the vvvvvvy function
function vvvvvvy(add_css_admin_vvvvvvy)
{
	// set the function logic
	if (add_css_admin_vvvvvvy == 1)
	{
		jQuery('#jform_css_admin-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_admin-lbl').closest('.control-group').hide();
	}
}

// the vvvvvvz function
function vvvvvvz(add_css_site_vvvvvvz)
{
	// set the function logic
	if (add_css_site_vvvvvvz == 1)
	{
		jQuery('#jform_css_site-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_css_site-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwa function
function vvvvvwa(add_javascript_vvvvvwa)
{
	// set the function logic
	if (add_javascript_vvvvvwa == 1)
	{
		jQuery('#jform_javascript-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_javascript-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwb function
function vvvvvwb(add_sql_vvvvvwb)
{
	// set the function logic
	if (add_sql_vvvvvwb == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		// add required attribute to sql field
		if (jform_vvvvvwbvvv_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvwbvvv_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		// remove required attribute from sql field
		if (!jform_vvvvvwbvvv_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvwbvvv_required = true;
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
		// add required attribute to sql_uninstall field
		if (jform_vvvvvwcvvw_required)
		{
			updateFieldRequired('sql_uninstall',0);
			jQuery('#jform_sql_uninstall').prop('required','required');
			jQuery('#jform_sql_uninstall').attr('aria-required',true);
			jQuery('#jform_sql_uninstall').addClass('required');
			jform_vvvvvwcvvw_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').hide();
		// remove required attribute from sql_uninstall field
		if (!jform_vvvvvwcvvw_required)
		{
			updateFieldRequired('sql_uninstall',1);
			jQuery('#jform_sql_uninstall').removeAttr('required');
			jQuery('#jform_sql_uninstall').removeAttr('aria-required');
			jQuery('#jform_sql_uninstall').removeClass('required');
			jform_vvvvvwcvvw_required = true;
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
		// add required attribute to license_type field
		if (jform_vvvvvwevvx_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_vvvvvwevvx_required = false;
		}
	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		// remove required attribute from license_type field
		if (!jform_vvvvvwevvx_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_vvvvvwevvx_required = true;
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
	}
	else
	{
		jQuery('#jform_php_admin_event-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwg function
function vvvvvwg(add_site_event_vvvvvwg)
{
	// set the function logic
	if (add_site_event_vvvvvwg == 1)
	{
		jQuery('#jform_php_site_event-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_site_event-lbl').closest('.control-group').hide();
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
	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
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
	}
	else
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwm function
function vvvvvwm(add_php_postflight_update_vvvvvwm)
{
	// set the function logic
	if (add_php_postflight_update_vvvvvwm == 1)
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwn function
function vvvvvwn(add_php_method_uninstall_vvvvvwn)
{
	// set the function logic
	if (add_php_method_uninstall_vvvvvwn == 1)
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwo function
function vvvvvwo(add_php_preflight_install_vvvvvwo)
{
	// set the function logic
	if (add_php_preflight_install_vvvvvwo == 1)
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').hide();
	}
}

// the vvvvvwp function
function vvvvvwp(add_php_preflight_update_vvvvvwp)
{
	// set the function logic
	if (add_php_preflight_update_vvvvvwp == 1)
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').hide();
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
		// add required attribute to update_server_target field
		if (jform_vvvvvwwvvy_required)
		{
			updateFieldRequired('update_server_target',0);
			jQuery('#jform_update_server_target').prop('required','required');
			jQuery('#jform_update_server_target').attr('aria-required',true);
			jQuery('#jform_update_server_target').addClass('required');
			jform_vvvvvwwvvy_required = false;
		}
	}
	else
	{
		jQuery('#jform_update_server_target').closest('.control-group').hide();
		// remove required attribute from update_server_target field
		if (!jform_vvvvvwwvvy_required)
		{
			updateFieldRequired('update_server_target',1);
			jQuery('#jform_update_server_target').removeAttr('required');
			jQuery('#jform_update_server_target').removeAttr('aria-required');
			jQuery('#jform_update_server_target').removeClass('required');
			jform_vvvvvwwvvy_required = true;
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
		// add required attribute to buildcompsql field
		if (jform_vvvvvwxvvz_required)
		{
			updateFieldRequired('buildcompsql',0);
			jQuery('#jform_buildcompsql').prop('required','required');
			jQuery('#jform_buildcompsql').attr('aria-required',true);
			jQuery('#jform_buildcompsql').addClass('required');
			jform_vvvvvwxvvz_required = false;
		}
	}
	else
	{
		jQuery('#jform_buildcompsql').closest('.control-group').hide();
		// remove required attribute from buildcompsql field
		if (!jform_vvvvvwxvvz_required)
		{
			updateFieldRequired('buildcompsql',1);
			jQuery('#jform_buildcompsql').removeAttr('required');
			jQuery('#jform_buildcompsql').removeAttr('aria-required');
			jQuery('#jform_buildcompsql').removeClass('required');
			jform_vvvvvwxvvz_required = true;
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

// the vvvvvxa function
function vvvvvxa(translation_tool_vvvvvxa)
{
	if (isSet(translation_tool_vvvvvxa) && translation_tool_vvvvvxa.constructor !== Array)
	{
		var temp_vvvvvxa = translation_tool_vvvvvxa;
		var translation_tool_vvvvvxa = [];
		translation_tool_vvvvvxa.push(temp_vvvvvxa);
	}
	else if (!isSet(translation_tool_vvvvvxa))
	{
		var translation_tool_vvvvvxa = [];
	}
	var translation_tool = translation_tool_vvvvvxa.some(translation_tool_vvvvvxa_SomeFunc);


	// set this function logic
	if (translation_tool)
	{
		jQuery('#jform_crowdin_account_api_key').closest('.control-group').show();
		jQuery('.note_crowdin').closest('.control-group').show();
		jQuery('#jform_crowdin_project_api_key').closest('.control-group').show();
		// add required attribute to crowdin_project_api_key field
		if (jform_vvvvvxavwa_required)
		{
			updateFieldRequired('crowdin_project_api_key',0);
			jQuery('#jform_crowdin_project_api_key').prop('required','required');
			jQuery('#jform_crowdin_project_api_key').attr('aria-required',true);
			jQuery('#jform_crowdin_project_api_key').addClass('required');
			jform_vvvvvxavwa_required = false;
		}
		jQuery('#jform_crowdin_project_identifier').closest('.control-group').show();
		// add required attribute to crowdin_project_identifier field
		if (jform_vvvvvxavwb_required)
		{
			updateFieldRequired('crowdin_project_identifier',0);
			jQuery('#jform_crowdin_project_identifier').prop('required','required');
			jQuery('#jform_crowdin_project_identifier').attr('aria-required',true);
			jQuery('#jform_crowdin_project_identifier').addClass('required');
			jform_vvvvvxavwb_required = false;
		}
		jQuery('#jform_crowdin_username').closest('.control-group').show();
		// add required attribute to crowdin_username field
		if (jform_vvvvvxavwc_required)
		{
			updateFieldRequired('crowdin_username',0);
			jQuery('#jform_crowdin_username').prop('required','required');
			jQuery('#jform_crowdin_username').attr('aria-required',true);
			jQuery('#jform_crowdin_username').addClass('required');
			jform_vvvvvxavwc_required = false;
		}
	}
	else
	{
		jQuery('#jform_crowdin_account_api_key').closest('.control-group').hide();
		jQuery('.note_crowdin').closest('.control-group').hide();
		jQuery('#jform_crowdin_project_api_key').closest('.control-group').hide();
		// remove required attribute from crowdin_project_api_key field
		if (!jform_vvvvvxavwa_required)
		{
			updateFieldRequired('crowdin_project_api_key',1);
			jQuery('#jform_crowdin_project_api_key').removeAttr('required');
			jQuery('#jform_crowdin_project_api_key').removeAttr('aria-required');
			jQuery('#jform_crowdin_project_api_key').removeClass('required');
			jform_vvvvvxavwa_required = true;
		}
		jQuery('#jform_crowdin_project_identifier').closest('.control-group').hide();
		// remove required attribute from crowdin_project_identifier field
		if (!jform_vvvvvxavwb_required)
		{
			updateFieldRequired('crowdin_project_identifier',1);
			jQuery('#jform_crowdin_project_identifier').removeAttr('required');
			jQuery('#jform_crowdin_project_identifier').removeAttr('aria-required');
			jQuery('#jform_crowdin_project_identifier').removeClass('required');
			jform_vvvvvxavwb_required = true;
		}
		jQuery('#jform_crowdin_username').closest('.control-group').hide();
		// remove required attribute from crowdin_username field
		if (!jform_vvvvvxavwc_required)
		{
			updateFieldRequired('crowdin_username',1);
			jQuery('#jform_crowdin_username').removeAttr('required');
			jQuery('#jform_crowdin_username').removeAttr('aria-required');
			jQuery('#jform_crowdin_username').removeClass('required');
			jform_vvvvvxavwc_required = true;
		}
	}
}

// the vvvvvxa Some function
function translation_tool_vvvvvxa_SomeFunc(translation_tool_vvvvvxa)
{
	// set the function logic
	if (translation_tool_vvvvvxa == 1)
	{
		return true;
	}
	return false;
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

	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 400);

	// get crowdin detail if set
	setTimeout(getTranslationToolDetails, 600);
});

function getTranslationToolDetails(){
	// get the translation tool selection
	var tool = jQuery("#jform_translation_tool").val();
	// trigger Crowdin
	if (tool == 1) {
		// get the identifier
		var identifier = jQuery("#jform_crowdin_project_identifier").val();
		// get the key
		var key = jQuery("#jform_crowdin_project_api_key").val();
		// query server for details
		getCrowdinDetails_server(identifier, key).done(function(result) {
			if (result.error){
				jQuery('#crowdin_information_box').show();
				jQuery('#crowdin_error_box').show();
				jQuery('#crowdin_error_box').html(result.error);
				jQuery('#crowdin_success_box').hide();
			} else if(result.html) {
				jQuery('#crowdin_success_box').show();
				jQuery('#crowdin_success_box').html(result.html);
				jQuery('#crowdin_error_box').hide();
				jQuery('#crowdin_information_box').hide();
			} else {
				jQuery('#crowdin_information_box').show();
				jQuery('#crowdin_success_box').hide();
			}
		});
	}
}

function getCrowdinDetails_server(identifier, key){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getCrowdinDetails&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && identifier.length > 0 && key.length > 0){
		var request = token+'=1&identifier='+identifier+'&key='+key;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

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
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = token+'=1&type=' + type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
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


function getEditCustomCodeButtons_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id+'&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getEditCustomCodeButtons(){
	// get the id
	id = jQuery("#jform_id").val();
	getEditCustomCodeButtons_server(id).done(function(result) {
		if(isObject(result)){
			jQuery.each(result, function( field, buttons ) {
				jQuery('<div class="control-group"><div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
				jQuery.each(buttons, function( name, button ) {
					jQuery(".control-customcode-buttons-"+field).append(button);
				});
			});
		}
	})
}

// check object is not empty
function isObject(obj) {
	for(var prop in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, prop)) {
			return true;
		}
	}
	return false;
}

function addButtonID_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButtonID&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0 && size > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
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
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
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
