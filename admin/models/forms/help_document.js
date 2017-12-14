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
jform_vvvvwaowaa_required = false;
jform_vvvvwapwab_required = false;
jform_vvvvwaqwac_required = false;
jform_vvvvwarwad_required = false;
jform_vvvvwaswae_required = false;
jform_vvvvwatwaf_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvwao = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwao(location_vvvvwao);

	var location_vvvvwap = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvwap(location_vvvvwap);

	var type_vvvvwaq = jQuery("#jform_type").val();
	vvvvwaq(type_vvvvwaq);

	var type_vvvvwar = jQuery("#jform_type").val();
	vvvvwar(type_vvvvwar);

	var type_vvvvwas = jQuery("#jform_type").val();
	vvvvwas(type_vvvvwas);

	var target_vvvvwat = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwat(target_vvvvwat);
});

// the vvvvwao function
function vvvvwao(location_vvvvwao)
{
	// set the function logic
	if (location_vvvvwao == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
		if (jform_vvvvwaowaa_required)
		{
			updateFieldRequired('admin_view',0);
			jQuery('#jform_admin_view').prop('required','required');
			jQuery('#jform_admin_view').attr('aria-required',true);
			jQuery('#jform_admin_view').addClass('required');
			jform_vvvvwaowaa_required = false;
		}

	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
		if (!jform_vvvvwaowaa_required)
		{
			updateFieldRequired('admin_view',1);
			jQuery('#jform_admin_view').removeAttr('required');
			jQuery('#jform_admin_view').removeAttr('aria-required');
			jQuery('#jform_admin_view').removeClass('required');
			jform_vvvvwaowaa_required = true;
		}
	}
}

// the vvvvwap function
function vvvvwap(location_vvvvwap)
{
	// set the function logic
	if (location_vvvvwap == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
		if (jform_vvvvwapwab_required)
		{
			updateFieldRequired('site_view',0);
			jQuery('#jform_site_view').prop('required','required');
			jQuery('#jform_site_view').attr('aria-required',true);
			jQuery('#jform_site_view').addClass('required');
			jform_vvvvwapwab_required = false;
		}

	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
		if (!jform_vvvvwapwab_required)
		{
			updateFieldRequired('site_view',1);
			jQuery('#jform_site_view').removeAttr('required');
			jQuery('#jform_site_view').removeAttr('aria-required');
			jQuery('#jform_site_view').removeClass('required');
			jform_vvvvwapwab_required = true;
		}
	}
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
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvwaqwac_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvwaqwac_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvwaqwac_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvwaqwac_required = true;
		}
	}
}

// the vvvvwaq Some function
function type_vvvvwaq_SomeFunc(type_vvvvwaq)
{
	// set the function logic
	if (type_vvvvwaq == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwar function
function vvvvwar(type_vvvvwar)
{
	if (isSet(type_vvvvwar) && type_vvvvwar.constructor !== Array)
	{
		var temp_vvvvwar = type_vvvvwar;
		var type_vvvvwar = [];
		type_vvvvwar.push(temp_vvvvwar);
	}
	else if (!isSet(type_vvvvwar))
	{
		var type_vvvvwar = [];
	}
	var type = type_vvvvwar.some(type_vvvvwar_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvwarwad_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvwarwad_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvwarwad_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvwarwad_required = true;
		}
	}
}

// the vvvvwar Some function
function type_vvvvwar_SomeFunc(type_vvvvwar)
{
	// set the function logic
	if (type_vvvvwar == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwas function
function vvvvwas(type_vvvvwas)
{
	if (isSet(type_vvvvwas) && type_vvvvwas.constructor !== Array)
	{
		var temp_vvvvwas = type_vvvvwas;
		var type_vvvvwas = [];
		type_vvvvwas.push(temp_vvvvwas);
	}
	else if (!isSet(type_vvvvwas))
	{
		var type_vvvvwas = [];
	}
	var type = type_vvvvwas.some(type_vvvvwas_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvwaswae_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvwaswae_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvwaswae_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvwaswae_required = true;
		}
	}
}

// the vvvvwas Some function
function type_vvvvwas_SomeFunc(type_vvvvwas)
{
	// set the function logic
	if (type_vvvvwas == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwat function
function vvvvwat(target_vvvvwat)
{
	// set the function logic
	if (target_vvvvwat == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvwatwaf_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvwatwaf_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvwatwaf_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvwatwaf_required = true;
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
