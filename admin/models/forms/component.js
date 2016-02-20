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
jform_TrtGyXEwzJ_required = false;
jform_glKLttxZlX_required = false;
jform_UoyMAgexhJ_required = false;
jform_uafUHLSfnl_required = false;
jform_oPksIyQAZW_required = false;
jform_yxemPfyLHd_required = false;
jform_wSmOGAlfGf_required = false;
jform_aTTjkCBbeB_required = false;
jform_mCTxZMEOml_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_TrtGyXE = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	TrtGyXE(add_php_helper_admin_TrtGyXE);

	var add_php_helper_site_glKLttx = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	glKLttx(add_php_helper_site_glKLttx);

	var add_css_UoyMAge = jQuery("#jform_add_css input[type='radio']:checked").val();
	UoyMAge(add_css_UoyMAge);

	var add_sql_uafUHLS = jQuery("#jform_add_sql input[type='radio']:checked").val();
	uafUHLS(add_sql_uafUHLS);

	var emptycontributors_JsDwYRW = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	JsDwYRW(emptycontributors_JsDwYRW);

	var add_license_oPksIyQ = jQuery("#jform_add_license input[type='radio']:checked").val();
	oPksIyQ(add_license_oPksIyQ);

	var add_admin_event_yxemPfy = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	yxemPfy(add_admin_event_yxemPfy);

	var add_site_event_wSmOGAl = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	wSmOGAl(add_site_event_wSmOGAl);

	var addreadme_aTTjkCB = jQuery("#jform_addreadme input[type='radio']:checked").val();
	aTTjkCB(addreadme_aTTjkCB);

	var add_license_YBYdUNk = jQuery("#jform_add_license input[type='radio']:checked").val();
	YBYdUNk(add_license_YBYdUNk);

	var add_php_dashboard_methods_mCTxZME = jQuery("#jform_add_php_dashboard_methods input[type='radio']:checked").val();
	mCTxZME(add_php_dashboard_methods_mCTxZME);
});

// the TrtGyXE function
function TrtGyXE(add_php_helper_admin_TrtGyXE)
{
	// set the function logic
	if (add_php_helper_admin_TrtGyXE == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_TrtGyXEwzJ_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_TrtGyXEwzJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_TrtGyXEwzJ_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_TrtGyXEwzJ_required = true;
		}
	}
}

// the glKLttx function
function glKLttx(add_php_helper_site_glKLttx)
{
	// set the function logic
	if (add_php_helper_site_glKLttx == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_glKLttxZlX_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_glKLttxZlX_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_glKLttxZlX_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_glKLttxZlX_required = true;
		}
	}
}

// the UoyMAge function
function UoyMAge(add_css_UoyMAge)
{
	// set the function logic
	if (add_css_UoyMAge == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_UoyMAgexhJ_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_UoyMAgexhJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_UoyMAgexhJ_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_UoyMAgexhJ_required = true;
		}
	}
}

// the uafUHLS function
function uafUHLS(add_sql_uafUHLS)
{
	// set the function logic
	if (add_sql_uafUHLS == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_uafUHLSfnl_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_uafUHLSfnl_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_uafUHLSfnl_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_uafUHLSfnl_required = true;
		}
	}
}

// the JsDwYRW function
function JsDwYRW(emptycontributors_JsDwYRW)
{
	// set the function logic
	if (emptycontributors_JsDwYRW == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the oPksIyQ function
function oPksIyQ(add_license_oPksIyQ)
{
	// set the function logic
	if (add_license_oPksIyQ == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_oPksIyQAZW_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_oPksIyQAZW_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_oPksIyQAZW_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_oPksIyQAZW_required = true;
		}
	}
}

// the yxemPfy function
function yxemPfy(add_admin_event_yxemPfy)
{
	// set the function logic
	if (add_admin_event_yxemPfy == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_yxemPfyLHd_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_yxemPfyLHd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_yxemPfyLHd_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_yxemPfyLHd_required = true;
		}
	}
}

// the wSmOGAl function
function wSmOGAl(add_site_event_wSmOGAl)
{
	// set the function logic
	if (add_site_event_wSmOGAl == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_wSmOGAlfGf_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_wSmOGAlfGf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_wSmOGAlfGf_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_wSmOGAlfGf_required = true;
		}
	}
}

// the aTTjkCB function
function aTTjkCB(addreadme_aTTjkCB)
{
	// set the function logic
	if (addreadme_aTTjkCB == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_aTTjkCBbeB_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_aTTjkCBbeB_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_aTTjkCBbeB_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_aTTjkCBbeB_required = true;
		}
	}
}

// the YBYdUNk function
function YBYdUNk(add_license_YBYdUNk)
{
	// set the function logic
	if (add_license_YBYdUNk == 1)
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

// the mCTxZME function
function mCTxZME(add_php_dashboard_methods_mCTxZME)
{
	// set the function logic
	if (add_php_dashboard_methods_mCTxZME == 1)
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').show();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').show();
		if (jform_mCTxZMEOml_required)
		{
			updateFieldRequired('php_dashboard_methods',0);
			jQuery('#jform_php_dashboard_methods').prop('required','required');
			jQuery('#jform_php_dashboard_methods').attr('aria-required',true);
			jQuery('#jform_php_dashboard_methods').addClass('required');
			jform_mCTxZMEOml_required = false;
		}

	}
	else
	{
		jQuery('#jform_dashboard_tab').closest('.control-group').hide();
		jQuery('#jform_php_dashboard_methods').closest('.control-group').hide();
		if (!jform_mCTxZMEOml_required)
		{
			updateFieldRequired('php_dashboard_methods',1);
			jQuery('#jform_php_dashboard_methods').removeAttr('required');
			jQuery('#jform_php_dashboard_methods').removeAttr('aria-required');
			jQuery('#jform_php_dashboard_methods').removeClass('required');
			jform_mCTxZMEOml_required = true;
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
