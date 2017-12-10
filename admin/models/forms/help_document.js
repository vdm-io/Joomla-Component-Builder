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
jform_vvvvwamvzy_required = false;
jform_vvvvwanvzz_required = false;
jform_vvvvwaowaa_required = false;
jform_vvvvwapwab_required = false;
jform_vvvvwaqwac_required = false;
jform_vvvvwarwad_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwam = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwam(location_vvvvwam);

	var location_vvvvwan = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwan(location_vvvvwan);

	var type_vvvvwao = jQuery("#jform_type").val();
	vvvvwao(type_vvvvwao);

	var type_vvvvwap = jQuery("#jform_type").val();
	vvvvwap(type_vvvvwap);

	var type_vvvvwaq = jQuery("#jform_type").val();
	vvvvwaq(type_vvvvwaq);

	var target_vvvvwar = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwar(target_vvvvwar);
});

// the vvvvwam function
function vvvvwam(location_vvvvwam)
{
	// set the function logic
	if (location_vvvvwam == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwamvzy_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwamvzy_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwamvzy_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwamvzy_required = true;
		}
	}
}

// the vvvvwan function
function vvvvwan(location_vvvvwan)
{
	// set the function logic
	if (location_vvvvwan == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwanvzz_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwanvzz_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwanvzz_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwanvzz_required = true;
		}
	}
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
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwaowaa_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwaowaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwaowaa_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwaowaa_required = true;
		}
	}
}

// the vvvvwao Some function
function type_vvvvwao_SomeFunc(type_vvvvwao)
{
	// set the function logic
	if (type_vvvvwao == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(type_vvvvwap)
{
	if (isSet(type_vvvvwap) && type_vvvvwap.constructor !== Array)
	{
		var temp_vvvvwap = type_vvvvwap;
		var type_vvvvwap = [];
		type_vvvvwap.push(temp_vvvvwap);
	}
	else if (!isSet(type_vvvvwap))
	{
		var type_vvvvwap = [];
	}
	var type = type_vvvvwap.some(type_vvvvwap_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwapwab_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwapwab_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwapwab_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwapwab_required = true;
		}
	}
}

// the vvvvwap Some function
function type_vvvvwap_SomeFunc(type_vvvvwap)
{
	// set the function logic
	if (type_vvvvwap == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwaq function
function vvvvwaq(type_vvvvwaq)
{
	if (isSet(type_vvvvwaq) && type_vvvvwaq.constructor !== Array)
	{
		var temp_vvvvwaq = type_vvvvwaq;
		var type_vvvvwaq = [];
		type_vvvvwaq.push(temp_vvvvwaq);
	}
	else if (!isSet(type_vvvvwaq))
	{
		var type_vvvvwaq = [];
	}
	var type = type_vvvvwaq.some(type_vvvvwaq_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwaqwac_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwaqwac_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwaqwac_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwaqwac_required = true;
		}
	}
}

// the vvvvwaq Some function
function type_vvvvwaq_SomeFunc(type_vvvvwaq)
{
	// set the function logic
	if (type_vvvvwaq == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwar function
function vvvvwar(target_vvvvwar)
{
	// set the function logic
	if (target_vvvvwar == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwarwad_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwarwad_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwarwad_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwarwad_required = true;
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
