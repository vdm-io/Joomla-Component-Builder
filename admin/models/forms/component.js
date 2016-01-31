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

	@version		2.0.8
	@build			31st January, 2016
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
jform_rNqIMxKYKT_required = false;
jform_lLxdlLPLZJ_required = false;
jform_OVrrrlsGFm_required = false;
jform_cSdmGNFtOt_required = false;
jform_VWpKNgVbti_required = false;
jform_naMIcxFwft_required = false;
jform_bzkuBnohmA_required = false;
jform_rnECSmOKsn_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_rNqIMxK = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	rNqIMxK(add_php_helper_admin_rNqIMxK);

	var add_php_helper_site_lLxdlLP = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	lLxdlLP(add_php_helper_site_lLxdlLP);

	var add_css_OVrrrls = jQuery("#jform_add_css input[type='radio']:checked").val();
	OVrrrls(add_css_OVrrrls);

	var add_sql_cSdmGNF = jQuery("#jform_add_sql input[type='radio']:checked").val();
	cSdmGNF(add_sql_cSdmGNF);

	var emptycontributors_ibZzdqp = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	ibZzdqp(emptycontributors_ibZzdqp);

	var add_license_VWpKNgV = jQuery("#jform_add_license input[type='radio']:checked").val();
	VWpKNgV(add_license_VWpKNgV);

	var add_admin_event_naMIcxF = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	naMIcxF(add_admin_event_naMIcxF);

	var add_site_event_bzkuBno = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	bzkuBno(add_site_event_bzkuBno);

	var addreadme_rnECSmO = jQuery("#jform_addreadme input[type='radio']:checked").val();
	rnECSmO(addreadme_rnECSmO);

	var add_license_TBnHnlh = jQuery("#jform_add_license input[type='radio']:checked").val();
	TBnHnlh(add_license_TBnHnlh);
});

// the rNqIMxK function
function rNqIMxK(add_php_helper_admin_rNqIMxK)
{
	// set the function logic
	if (add_php_helper_admin_rNqIMxK == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_rNqIMxKYKT_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_rNqIMxKYKT_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_rNqIMxKYKT_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_rNqIMxKYKT_required = true;
		}
	}
}

// the lLxdlLP function
function lLxdlLP(add_php_helper_site_lLxdlLP)
{
	// set the function logic
	if (add_php_helper_site_lLxdlLP == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_lLxdlLPLZJ_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_lLxdlLPLZJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_lLxdlLPLZJ_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_lLxdlLPLZJ_required = true;
		}
	}
}

// the OVrrrls function
function OVrrrls(add_css_OVrrrls)
{
	// set the function logic
	if (add_css_OVrrrls == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_OVrrrlsGFm_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_OVrrrlsGFm_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_OVrrrlsGFm_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_OVrrrlsGFm_required = true;
		}
	}
}

// the cSdmGNF function
function cSdmGNF(add_sql_cSdmGNF)
{
	// set the function logic
	if (add_sql_cSdmGNF == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_cSdmGNFtOt_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_cSdmGNFtOt_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_cSdmGNFtOt_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_cSdmGNFtOt_required = true;
		}
	}
}

// the ibZzdqp function
function ibZzdqp(emptycontributors_ibZzdqp)
{
	// set the function logic
	if (emptycontributors_ibZzdqp == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the VWpKNgV function
function VWpKNgV(add_license_VWpKNgV)
{
	// set the function logic
	if (add_license_VWpKNgV == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_VWpKNgVbti_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_VWpKNgVbti_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_VWpKNgVbti_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_VWpKNgVbti_required = true;
		}
	}
}

// the naMIcxF function
function naMIcxF(add_admin_event_naMIcxF)
{
	// set the function logic
	if (add_admin_event_naMIcxF == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_naMIcxFwft_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_naMIcxFwft_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_naMIcxFwft_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_naMIcxFwft_required = true;
		}
	}
}

// the bzkuBno function
function bzkuBno(add_site_event_bzkuBno)
{
	// set the function logic
	if (add_site_event_bzkuBno == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_bzkuBnohmA_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_bzkuBnohmA_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_bzkuBnohmA_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_bzkuBnohmA_required = true;
		}
	}
}

// the rnECSmO function
function rnECSmO(addreadme_rnECSmO)
{
	// set the function logic
	if (addreadme_rnECSmO == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_rnECSmOKsn_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_rnECSmOKsn_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_rnECSmOKsn_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_rnECSmOKsn_required = true;
		}
	}
}

// the TBnHnlh function
function TBnHnlh(add_license_TBnHnlh)
{
	// set the function logic
	if (add_license_TBnHnlh == 1)
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
