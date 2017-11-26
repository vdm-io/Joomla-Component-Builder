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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvwakvzy_required = false;
jform_vvvvwalvzz_required = false;
jform_vvvvwamwaa_required = false;
jform_vvvvwanwab_required = false;
jform_vvvvwaowac_required = false;
jform_vvvvwapwad_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwak = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwak(location_vvvvwak);

	var location_vvvvwal = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwal(location_vvvvwal);

	var type_vvvvwam = jQuery("#jform_type").val();
	vvvvwam(type_vvvvwam);

	var type_vvvvwan = jQuery("#jform_type").val();
	vvvvwan(type_vvvvwan);

	var type_vvvvwao = jQuery("#jform_type").val();
	vvvvwao(type_vvvvwao);

	var target_vvvvwap = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwap(target_vvvvwap);
});

// the vvvvwak function
function vvvvwak(location_vvvvwak)
{
	// set the function logic
	if (location_vvvvwak == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwakvzy_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwakvzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwakvzy_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwakvzy_required = true;
		}
	}
}

// the vvvvwal function
function vvvvwal(location_vvvvwal)
{
	// set the function logic
	if (location_vvvvwal == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwalvzz_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwalvzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwalvzz_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwalvzz_required = true;
		}
	}
}

// the vvvvwam function
function vvvvwam(type_vvvvwam)
{
	if (isSet(type_vvvvwam) && type_vvvvwam.constructor !== Array)
	{
		var temp_vvvvwam = type_vvvvwam;
		var type_vvvvwam = [];
		type_vvvvwam.push(temp_vvvvwam);
	}
	else if (!isSet(type_vvvvwam))
	{
		var type_vvvvwam = [];
	}
	var type = type_vvvvwam.some(type_vvvvwam_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwamwaa_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwamwaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwamwaa_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwamwaa_required = true;
		}
	}
}

// the vvvvwam Some function
function type_vvvvwam_SomeFunc(type_vvvvwam)
{
	// set the function logic
	if (type_vvvvwam == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwan function
function vvvvwan(type_vvvvwan)
{
	if (isSet(type_vvvvwan) && type_vvvvwan.constructor !== Array)
	{
		var temp_vvvvwan = type_vvvvwan;
		var type_vvvvwan = [];
		type_vvvvwan.push(temp_vvvvwan);
	}
	else if (!isSet(type_vvvvwan))
	{
		var type_vvvvwan = [];
	}
	var type = type_vvvvwan.some(type_vvvvwan_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwanwab_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwanwab_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwanwab_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwanwab_required = true;
		}
	}
}

// the vvvvwan Some function
function type_vvvvwan_SomeFunc(type_vvvvwan)
{
	// set the function logic
	if (type_vvvvwan == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwao function
function vvvvwao(type_vvvvwao)
{
	if (isSet(type_vvvvwao) && type_vvvvwao.constructor !== Array)
	{
		var temp_vvvvwao = type_vvvvwao;
		var type_vvvvwao = [];
		type_vvvvwao.push(temp_vvvvwao);
	}
	else if (!isSet(type_vvvvwao))
	{
		var type_vvvvwao = [];
	}
	var type = type_vvvvwao.some(type_vvvvwao_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwaowac_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwaowac_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwaowac_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwaowac_required = true;
		}
	}
}

// the vvvvwao Some function
function type_vvvvwao_SomeFunc(type_vvvvwao)
{
	// set the function logic
	if (type_vvvvwao == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(target_vvvvwap)
{
	// set the function logic
	if (target_vvvvwap == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwapwad_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwapwad_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwapwad_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwapwad_required = true;
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
