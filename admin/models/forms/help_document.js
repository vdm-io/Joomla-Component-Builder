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
	@build			26th February, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		help_document.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzcvyv_required = false;
jform_vvvvvzdvyw_required = false;
jform_vvvvvzevyx_required = false;
jform_vvvvvzfvyy_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvvza = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvza(location_vvvvvza);

	var location_vvvvvzb = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzb(location_vvvvvzb);

	var type_vvvvvzc = jQuery("#jform_type").val();
	vvvvvzc(type_vvvvvzc);

	var type_vvvvvzd = jQuery("#jform_type").val();
	vvvvvzd(type_vvvvvzd);

	var type_vvvvvze = jQuery("#jform_type").val();
	vvvvvze(type_vvvvvze);

	var target_vvvvvzf = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzf(target_vvvvvzf);
});

// the vvvvvza function
function vvvvvza(location_vvvvvza)
{
	// set the function logic
	if (location_vvvvvza == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the vvvvvzb function
function vvvvvzb(location_vvvvvzb)
{
	// set the function logic
	if (location_vvvvvzb == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
}

// the vvvvvzc function
function vvvvvzc(type_vvvvvzc)
{
	if (isSet(type_vvvvvzc) && type_vvvvvzc.constructor !== Array)
	{
		var temp_vvvvvzc = type_vvvvvzc;
		var type_vvvvvzc = [];
		type_vvvvvzc.push(temp_vvvvvzc);
	}
	else if (!isSet(type_vvvvvzc))
	{
		var type_vvvvvzc = [];
	}
	var type = type_vvvvvzc.some(type_vvvvvzc_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvvzcvyv_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvvzcvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvvzcvyv_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvvzcvyv_required = true;
		}
	}
}

// the vvvvvzc Some function
function type_vvvvvzc_SomeFunc(type_vvvvvzc)
{
	// set the function logic
	if (type_vvvvvzc == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(type_vvvvvzd)
{
	if (isSet(type_vvvvvzd) && type_vvvvvzd.constructor !== Array)
	{
		var temp_vvvvvzd = type_vvvvvzd;
		var type_vvvvvzd = [];
		type_vvvvvzd.push(temp_vvvvvzd);
	}
	else if (!isSet(type_vvvvvzd))
	{
		var type_vvvvvzd = [];
	}
	var type = type_vvvvvzd.some(type_vvvvvzd_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvvzdvyw_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvvzdvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvvzdvyw_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvvzdvyw_required = true;
		}
	}
}

// the vvvvvzd Some function
function type_vvvvvzd_SomeFunc(type_vvvvvzd)
{
	// set the function logic
	if (type_vvvvvzd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvze function
function vvvvvze(type_vvvvvze)
{
	if (isSet(type_vvvvvze) && type_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = type_vvvvvze;
		var type_vvvvvze = [];
		type_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(type_vvvvvze))
	{
		var type_vvvvvze = [];
	}
	var type = type_vvvvvze.some(type_vvvvvze_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvvzevyx_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvvzevyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzevyx_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvvzevyx_required = true;
		}
	}
}

// the vvvvvze Some function
function type_vvvvvze_SomeFunc(type_vvvvvze)
{
	// set the function logic
	if (type_vvvvvze == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzf function
function vvvvvzf(target_vvvvvzf)
{
	// set the function logic
	if (target_vvvvvzf == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvvzfvyy_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvvzfvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvvzfvyy_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvvzfvyy_required = true;
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
