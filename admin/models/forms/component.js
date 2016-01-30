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
	@build			30th January, 2016
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
jform_YKWupwWEeG_required = false;
jform_IRJfnCWWtY_required = false;
jform_lVqqJOvuJD_required = false;
jform_OIgJWDfSbi_required = false;
jform_KqbIvUZTFO_required = false;
jform_tVqRLZXzVB_required = false;
jform_DQvHlnHtba_required = false;
jform_aQmcEOYDBD_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var add_php_helper_admin_YKWupwW = jQuery("#jform_add_php_helper_admin input[type='radio']:checked").val();
	YKWupwW(add_php_helper_admin_YKWupwW);

	var add_php_helper_site_IRJfnCW = jQuery("#jform_add_php_helper_site input[type='radio']:checked").val();
	IRJfnCW(add_php_helper_site_IRJfnCW);

	var add_css_lVqqJOv = jQuery("#jform_add_css input[type='radio']:checked").val();
	lVqqJOv(add_css_lVqqJOv);

	var add_sql_OIgJWDf = jQuery("#jform_add_sql input[type='radio']:checked").val();
	OIgJWDf(add_sql_OIgJWDf);

	var emptycontributors_BNadRnM = jQuery("#jform_emptycontributors input[type='radio']:checked").val();
	BNadRnM(emptycontributors_BNadRnM);

	var add_license_KqbIvUZ = jQuery("#jform_add_license input[type='radio']:checked").val();
	KqbIvUZ(add_license_KqbIvUZ);

	var add_admin_event_tVqRLZX = jQuery("#jform_add_admin_event input[type='radio']:checked").val();
	tVqRLZX(add_admin_event_tVqRLZX);

	var add_site_event_DQvHlnH = jQuery("#jform_add_site_event input[type='radio']:checked").val();
	DQvHlnH(add_site_event_DQvHlnH);

	var addreadme_aQmcEOY = jQuery("#jform_addreadme input[type='radio']:checked").val();
	aQmcEOY(addreadme_aQmcEOY);

	var add_license_lWrKOfJ = jQuery("#jform_add_license input[type='radio']:checked").val();
	lWrKOfJ(add_license_lWrKOfJ);
});

// the YKWupwW function
function YKWupwW(add_php_helper_admin_YKWupwW)
{
	// set the function logic
	if (add_php_helper_admin_YKWupwW == 1)
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').show();
		if (jform_YKWupwWEeG_required)
		{
			updateFieldRequired('php_helper_admin',0);
			jQuery('#jform_php_helper_admin').prop('required','required');
			jQuery('#jform_php_helper_admin').attr('aria-required',true);
			jQuery('#jform_php_helper_admin').addClass('required');
			jform_YKWupwWEeG_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_admin').closest('.control-group').hide();
		if (!jform_YKWupwWEeG_required)
		{
			updateFieldRequired('php_helper_admin',1);
			jQuery('#jform_php_helper_admin').removeAttr('required');
			jQuery('#jform_php_helper_admin').removeAttr('aria-required');
			jQuery('#jform_php_helper_admin').removeClass('required');
			jform_YKWupwWEeG_required = true;
		}
	}
}

// the IRJfnCW function
function IRJfnCW(add_php_helper_site_IRJfnCW)
{
	// set the function logic
	if (add_php_helper_site_IRJfnCW == 1)
	{
		jQuery('#jform_php_helper_site').closest('.control-group').show();
		if (jform_IRJfnCWWtY_required)
		{
			updateFieldRequired('php_helper_site',0);
			jQuery('#jform_php_helper_site').prop('required','required');
			jQuery('#jform_php_helper_site').attr('aria-required',true);
			jQuery('#jform_php_helper_site').addClass('required');
			jform_IRJfnCWWtY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_helper_site').closest('.control-group').hide();
		if (!jform_IRJfnCWWtY_required)
		{
			updateFieldRequired('php_helper_site',1);
			jQuery('#jform_php_helper_site').removeAttr('required');
			jQuery('#jform_php_helper_site').removeAttr('aria-required');
			jQuery('#jform_php_helper_site').removeClass('required');
			jform_IRJfnCWWtY_required = true;
		}
	}
}

// the lVqqJOv function
function lVqqJOv(add_css_lVqqJOv)
{
	// set the function logic
	if (add_css_lVqqJOv == 1)
	{
		jQuery('#jform_css').closest('.control-group').show();
		if (jform_lVqqJOvuJD_required)
		{
			updateFieldRequired('css',0);
			jQuery('#jform_css').prop('required','required');
			jQuery('#jform_css').attr('aria-required',true);
			jQuery('#jform_css').addClass('required');
			jform_lVqqJOvuJD_required = false;
		}

	}
	else
	{
		jQuery('#jform_css').closest('.control-group').hide();
		if (!jform_lVqqJOvuJD_required)
		{
			updateFieldRequired('css',1);
			jQuery('#jform_css').removeAttr('required');
			jQuery('#jform_css').removeAttr('aria-required');
			jQuery('#jform_css').removeClass('required');
			jform_lVqqJOvuJD_required = true;
		}
	}
}

// the OIgJWDf function
function OIgJWDf(add_sql_OIgJWDf)
{
	// set the function logic
	if (add_sql_OIgJWDf == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		if (jform_OIgJWDfSbi_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_OIgJWDfSbi_required = false;
		}

	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		if (!jform_OIgJWDfSbi_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_OIgJWDfSbi_required = true;
		}
	}
}

// the BNadRnM function
function BNadRnM(emptycontributors_BNadRnM)
{
	// set the function logic
	if (emptycontributors_BNadRnM == 1)
	{
		jQuery('#jform_number').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_number').closest('.control-group').hide();
	}
}

// the KqbIvUZ function
function KqbIvUZ(add_license_KqbIvUZ)
{
	// set the function logic
	if (add_license_KqbIvUZ == 1)
	{
		jQuery('#jform_license_type').closest('.control-group').show();
		if (jform_KqbIvUZTFO_required)
		{
			updateFieldRequired('license_type',0);
			jQuery('#jform_license_type').prop('required','required');
			jQuery('#jform_license_type').attr('aria-required',true);
			jQuery('#jform_license_type').addClass('required');
			jform_KqbIvUZTFO_required = false;
		}

	}
	else
	{
		jQuery('#jform_license_type').closest('.control-group').hide();
		if (!jform_KqbIvUZTFO_required)
		{
			updateFieldRequired('license_type',1);
			jQuery('#jform_license_type').removeAttr('required');
			jQuery('#jform_license_type').removeAttr('aria-required');
			jQuery('#jform_license_type').removeClass('required');
			jform_KqbIvUZTFO_required = true;
		}
	}
}

// the tVqRLZX function
function tVqRLZX(add_admin_event_tVqRLZX)
{
	// set the function logic
	if (add_admin_event_tVqRLZX == 1)
	{
		jQuery('#jform_php_admin_event').closest('.control-group').show();
		if (jform_tVqRLZXzVB_required)
		{
			updateFieldRequired('php_admin_event',0);
			jQuery('#jform_php_admin_event').prop('required','required');
			jQuery('#jform_php_admin_event').attr('aria-required',true);
			jQuery('#jform_php_admin_event').addClass('required');
			jform_tVqRLZXzVB_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_admin_event').closest('.control-group').hide();
		if (!jform_tVqRLZXzVB_required)
		{
			updateFieldRequired('php_admin_event',1);
			jQuery('#jform_php_admin_event').removeAttr('required');
			jQuery('#jform_php_admin_event').removeAttr('aria-required');
			jQuery('#jform_php_admin_event').removeClass('required');
			jform_tVqRLZXzVB_required = true;
		}
	}
}

// the DQvHlnH function
function DQvHlnH(add_site_event_DQvHlnH)
{
	// set the function logic
	if (add_site_event_DQvHlnH == 1)
	{
		jQuery('#jform_php_site_event').closest('.control-group').show();
		if (jform_DQvHlnHtba_required)
		{
			updateFieldRequired('php_site_event',0);
			jQuery('#jform_php_site_event').prop('required','required');
			jQuery('#jform_php_site_event').attr('aria-required',true);
			jQuery('#jform_php_site_event').addClass('required');
			jform_DQvHlnHtba_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_site_event').closest('.control-group').hide();
		if (!jform_DQvHlnHtba_required)
		{
			updateFieldRequired('php_site_event',1);
			jQuery('#jform_php_site_event').removeAttr('required');
			jQuery('#jform_php_site_event').removeAttr('aria-required');
			jQuery('#jform_php_site_event').removeClass('required');
			jform_DQvHlnHtba_required = true;
		}
	}
}

// the aQmcEOY function
function aQmcEOY(addreadme_aQmcEOY)
{
	// set the function logic
	if (addreadme_aQmcEOY == 1)
	{
		jQuery('.note_readme').closest('.control-group').show();
		jQuery('#jform_readme-lbl').closest('.control-group').show();
		if (jform_aQmcEOYDBD_required)
		{
			updateFieldRequired('readme',0);
			jQuery('#jform_readme').prop('required','required');
			jQuery('#jform_readme').attr('aria-required',true);
			jQuery('#jform_readme').addClass('required');
			jform_aQmcEOYDBD_required = false;
		}

	}
	else
	{
		jQuery('.note_readme').closest('.control-group').hide();
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
		if (!jform_aQmcEOYDBD_required)
		{
			updateFieldRequired('readme',1);
			jQuery('#jform_readme').removeAttr('required');
			jQuery('#jform_readme').removeAttr('aria-required');
			jQuery('#jform_readme').removeClass('required');
			jform_aQmcEOYDBD_required = true;
		}
	}
}

// the lWrKOfJ function
function lWrKOfJ(add_license_lWrKOfJ)
{
	// set the function logic
	if (add_license_lWrKOfJ == 1)
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
