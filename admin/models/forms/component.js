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

	@version		2.0.9
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
jform_YqhzJSoQsl_required = false;
jform_vIWNpuAWwR_required = false;
jform_IfMyVdhHgw_required = false;
jform_mgNBEyuRjK_required = false;
jform_VyTIlaAFWv_required = false;
jform_NDJmONdqlv_required = false;
jform_HfLlopBpPn_required = false;
jform_JNKDCaxVLv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_YqhzJSo = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	YqhzJSo(add_php_helper_admin_YqhzJSo);

	var add_php_helper_site_vIWNpuA = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	vIWNpuA(add_php_helper_site_vIWNpuA);

	var add_css_IfMyVdh = jQuery("#jform_add_css input[type='radio']:checked").val();
	IfMyVdh(add_css_IfMyVdh);

	var add_sql_mgNBEyu = jQuery("#jform_add_sql input[type='radio']:checked").val();
	mgNBEyu(add_sql_mgNBEyu);

	var emptycontributors_eLwbCIx = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	eLwbCIx(emptycontributors_eLwbCIx);

	var add_license_VyTIlaA = jQuery("#jform_add_license input[type='radio']:checked").val();
	VyTIlaA(add_license_VyTIlaA);

	var add_admin_event_NDJmONd = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	NDJmONd(add_admin_event_NDJmONd);

	var add_site_event_HfLlopB = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	HfLlopB(add_site_event_HfLlopB);

	var addreadme_JNKDCax = jQuery("#jform_addreadme input[type='radio']:checked").val();
	JNKDCax(addreadme_JNKDCax);

	var add_license_yBYbJNK = jQuery("#jform_add_license input[type='radio']:checked").val();
	yBYbJNK(add_license_yBYbJNK);
});

// the YqhzJSo function
function YqhzJSo(add_php_helper_admin_YqhzJSo)
{
	// set the function logic
	if (add_php_helper_admin_YqhzJSo == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_YqhzJSoQsl_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_YqhzJSoQsl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_YqhzJSoQsl_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_YqhzJSoQsl_required = true;
		}
	}
}

// the vIWNpuA function
function vIWNpuA(add_php_helper_site_vIWNpuA)
{
	// set the function logic
	if (add_php_helper_site_vIWNpuA == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_vIWNpuAWwR_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_vIWNpuAWwR_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_vIWNpuAWwR_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_vIWNpuAWwR_required = true;
		}
	}
}

// the IfMyVdh function
function IfMyVdh(add_css_IfMyVdh)
{
	// set the function logic
	if (add_css_IfMyVdh == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_IfMyVdhHgw_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_IfMyVdhHgw_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_IfMyVdhHgw_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_IfMyVdhHgw_required = true;
		}
	}
}

// the mgNBEyu function
function mgNBEyu(add_sql_mgNBEyu)
{
	// set the function logic
	if (add_sql_mgNBEyu == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_mgNBEyuRjK_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_mgNBEyuRjK_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_mgNBEyuRjK_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_mgNBEyuRjK_required = true;
		}
	}
}

// the eLwbCIx function
function eLwbCIx(emptycontributors_eLwbCIx)
{
	// set the function logic
	if (emptycontributors_eLwbCIx == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the VyTIlaA function
function VyTIlaA(add_license_VyTIlaA)
{
	// set the function logic
	if (add_license_VyTIlaA == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_VyTIlaAFWv_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_VyTIlaAFWv_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_VyTIlaAFWv_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_VyTIlaAFWv_required = true;
		}
	}
}

// the NDJmONd function
function NDJmONd(add_admin_event_NDJmONd)
{
	// set the function logic
	if (add_admin_event_NDJmONd == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_NDJmONdqlv_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_NDJmONdqlv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_NDJmONdqlv_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_NDJmONdqlv_required = true;
		}
	}
}

// the HfLlopB function
function HfLlopB(add_site_event_HfLlopB)
{
	// set the function logic
	if (add_site_event_HfLlopB == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_HfLlopBpPn_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_HfLlopBpPn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_HfLlopBpPn_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_HfLlopBpPn_required = true;
		}
	}
}

// the JNKDCax function
function JNKDCax(addreadme_JNKDCax)
{
	// set the function logic
	if (addreadme_JNKDCax == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_JNKDCaxVLv_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_JNKDCaxVLv_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_JNKDCaxVLv_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_JNKDCaxVLv_required = true;
		}
	}
}

// the yBYbJNK function
function yBYbJNK(add_license_yBYbJNK)
{
	// set the function logic
	if (add_license_yBYbJNK == 1)
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
