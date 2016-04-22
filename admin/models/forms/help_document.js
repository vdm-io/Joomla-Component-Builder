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

	@version		2.1.3
	@build			22nd April, 2016
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
jform_vvvvvzevyv_required = false;
jform_vvvvvzfvyw_required = false;
jform_vvvvvzgvyx_required = false;
jform_vvvvvzhvyy_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var location_vvvvvzc = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzc(location_vvvvvzc);

	var location_vvvvvzd = jQuery("#jform_location input[type='radio']:checked").val();
	vvvvvzd(location_vvvvvzd);

	var type_vvvvvze = jQuery("#jform_type").val();
	vvvvvze(type_vvvvvze);

	var type_vvvvvzf = jQuery("#jform_type").val();
	vvvvvzf(type_vvvvvzf);

	var type_vvvvvzg = jQuery("#jform_type").val();
	vvvvvzg(type_vvvvvzg);

	var target_vvvvvzh = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzh(target_vvvvvzh);
});

// the vvvvvzc function
function vvvvvzc(location_vvvvvzc)
{
	// set the function logic
	if (location_vvvvvzc == 1)
	{
		jQuery('#jform_admin_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_admin_view').closest('.control-group').hide();
	}
}

// the vvvvvzd function
function vvvvvzd(location_vvvvvzd)
{
	// set the function logic
	if (location_vvvvvzd == 2)
	{
		jQuery('#jform_site_view').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_site_view').closest('.control-group').hide();
	}
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
		jQuery('#jform_url').closest('.control-group').show();
		if (jform_vvvvvzevyv_required)
		{
			updateFieldRequired('url',0);
			jQuery('#jform_url').prop('required','required');
			jQuery('#jform_url').attr('aria-required',true);
			jQuery('#jform_url').addClass('required');
			jform_vvvvvzevyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_url').closest('.control-group').hide();
		if (!jform_vvvvvzevyv_required)
		{
			updateFieldRequired('url',1);
			jQuery('#jform_url').removeAttr('required');
			jQuery('#jform_url').removeAttr('aria-required');
			jQuery('#jform_url').removeClass('required');
			jform_vvvvvzevyv_required = true;
		}
	}
}

// the vvvvvze Some function
function type_vvvvvze_SomeFunc(type_vvvvvze)
{
	// set the function logic
	if (type_vvvvvze == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzf function
function vvvvvzf(type_vvvvvzf)
{
	if (isSet(type_vvvvvzf) && type_vvvvvzf.constructor !== Array)
	{
		var temp_vvvvvzf = type_vvvvvzf;
		var type_vvvvvzf = [];
		type_vvvvvzf.push(temp_vvvvvzf);
	}
	else if (!isSet(type_vvvvvzf))
	{
		var type_vvvvvzf = [];
	}
	var type = type_vvvvvzf.some(type_vvvvvzf_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_article').closest('.control-group').show();
		if (jform_vvvvvzfvyw_required)
		{
			updateFieldRequired('article',0);
			jQuery('#jform_article').prop('required','required');
			jQuery('#jform_article').attr('aria-required',true);
			jQuery('#jform_article').addClass('required');
			jform_vvvvvzfvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_article').closest('.control-group').hide();
		if (!jform_vvvvvzfvyw_required)
		{
			updateFieldRequired('article',1);
			jQuery('#jform_article').removeAttr('required');
			jQuery('#jform_article').removeAttr('aria-required');
			jQuery('#jform_article').removeClass('required');
			jform_vvvvvzfvyw_required = true;
		}
	}
}

// the vvvvvzf Some function
function type_vvvvvzf_SomeFunc(type_vvvvvzf)
{
	// set the function logic
	if (type_vvvvvzf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzg function
function vvvvvzg(type_vvvvvzg)
{
	if (isSet(type_vvvvvzg) && type_vvvvvzg.constructor !== Array)
	{
		var temp_vvvvvzg = type_vvvvvzg;
		var type_vvvvvzg = [];
		type_vvvvvzg.push(temp_vvvvvzg);
	}
	else if (!isSet(type_vvvvvzg))
	{
		var type_vvvvvzg = [];
	}
	var type = type_vvvvvzg.some(type_vvvvvzg_SomeFunc);


	// set this function logic
	if (type)
	{
		jQuery('#jform_content-lbl').closest('.control-group').show();
		if (jform_vvvvvzgvyx_required)
		{
			updateFieldRequired('content',0);
			jQuery('#jform_content').prop('required','required');
			jQuery('#jform_content').attr('aria-required',true);
			jQuery('#jform_content').addClass('required');
			jform_vvvvvzgvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_content-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzgvyx_required)
		{
			updateFieldRequired('content',1);
			jQuery('#jform_content').removeAttr('required');
			jQuery('#jform_content').removeAttr('aria-required');
			jQuery('#jform_content').removeClass('required');
			jform_vvvvvzgvyx_required = true;
		}
	}
}

// the vvvvvzg Some function
function type_vvvvvzg_SomeFunc(type_vvvvvzg)
{
	// set the function logic
	if (type_vvvvvzg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzh function
function vvvvvzh(target_vvvvvzh)
{
	// set the function logic
	if (target_vvvvvzh == 1)
	{
		jQuery('#jform_groups').closest('.control-group').show();
		if (jform_vvvvvzhvyy_required)
		{
			updateFieldRequired('groups',0);
			jQuery('#jform_groups').prop('required','required');
			jQuery('#jform_groups').attr('aria-required',true);
			jQuery('#jform_groups').addClass('required');
			jform_vvvvvzhvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_groups').closest('.control-group').hide();
		if (!jform_vvvvvzhvyy_required)
		{
			updateFieldRequired('groups',1);
			jQuery('#jform_groups').removeAttr('required');
			jQuery('#jform_groups').removeAttr('aria-required');
			jQuery('#jform_groups').removeClass('required');
			jform_vvvvvzhvyy_required = true;
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
