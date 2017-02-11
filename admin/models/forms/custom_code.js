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

	@version		@update number 35 of this MVC
	@build			10th February, 2017
	@created		11th October, 2016
	@package		Component Builder
	@subpackage		custom_code.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzpvzk_required = false;
jform_vvvvvzpvzl_required = false;
jform_vvvvvzpvzm_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var target_vvvvvzo = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzo(target_vvvvvzo);

	var target_vvvvvzp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzp(target_vvvvvzp);

	var target_vvvvvzq = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvvzq = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvvzq(target_vvvvvzq,type_vvvvvzq);

	var type_vvvvvzr = jQuery("#jform_type input[type='radio']:checked").val();
	var target_vvvvvzr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvvzr(type_vvvvvzr,target_vvvvvzr);
});

// the vvvvvzo function
function vvvvvzo(target_vvvvvzo)
{
	// set the function logic
	if (target_vvvvvzo == 2)
	{
		jQuery('.note_jcb_placeholder').closest('.control-group').show();
		jQuery('#jform_system_name').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_jcb_placeholder').closest('.control-group').hide();
		jQuery('#jform_system_name').closest('.control-group').hide();
	}
}

// the vvvvvzp function
function vvvvvzp(target_vvvvvzp)
{
	// set the function logic
	if (target_vvvvvzp == 1)
	{
		jQuery('#jform_component').closest('.control-group').show();
		if (jform_vvvvvzpvzk_required)
		{
			updateFieldRequired('component',0);
			jQuery('#jform_component').prop('required','required');
			jQuery('#jform_component').attr('aria-required',true);
			jQuery('#jform_component').addClass('required');
			jform_vvvvvzpvzk_required = false;
		}

		jQuery('#jform_path').closest('.control-group').show();
		if (jform_vvvvvzpvzl_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvvzpvzl_required = false;
		}

		jQuery('#jform_from_line').closest('.control-group').show();
		jQuery('#jform_hashtarget').closest('.control-group').show();
		jQuery('#jform_to_line').closest('.control-group').show();
		jQuery('#jform_type').closest('.control-group').show();
		if (jform_vvvvvzpvzm_required)
		{
			updateFieldRequired('type',0);
			jQuery('#jform_type').prop('required','required');
			jQuery('#jform_type').attr('aria-required',true);
			jQuery('#jform_type').addClass('required');
			jform_vvvvvzpvzm_required = false;
		}

	}
	else
	{
		jQuery('#jform_component').closest('.control-group').hide();
		if (!jform_vvvvvzpvzk_required)
		{
			updateFieldRequired('component',1);
			jQuery('#jform_component').removeAttr('required');
			jQuery('#jform_component').removeAttr('aria-required');
			jQuery('#jform_component').removeClass('required');
			jform_vvvvvzpvzk_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		if (!jform_vvvvvzpvzl_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvvzpvzl_required = true;
		}
		jQuery('#jform_from_line').closest('.control-group').hide();
		jQuery('#jform_hashtarget').closest('.control-group').hide();
		jQuery('#jform_to_line').closest('.control-group').hide();
		jQuery('#jform_type').closest('.control-group').hide();
		if (!jform_vvvvvzpvzm_required)
		{
			updateFieldRequired('type',1);
			jQuery('#jform_type').removeAttr('required');
			jQuery('#jform_type').removeAttr('aria-required');
			jQuery('#jform_type').removeClass('required');
			jform_vvvvvzpvzm_required = true;
		}
	}
}

// the vvvvvzq function
function vvvvvzq(target_vvvvvzq,type_vvvvvzq)
{
	// set the function logic
	if (target_vvvvvzq == 1 && type_vvvvvzq == 1)
	{
		jQuery('#jform_hashendtarget').closest('.control-group').show();
		jQuery('#jform_to_line').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_hashendtarget').closest('.control-group').hide();
		jQuery('#jform_to_line').closest('.control-group').hide();
	}
}

// the vvvvvzr function
function vvvvvzr(type_vvvvvzr,target_vvvvvzr)
{
	// set the function logic
	if (type_vvvvvzr == 1 && target_vvvvvzr == 1)
	{
		jQuery('#jform_hashendtarget').closest('.control-group').show();
		jQuery('#jform_to_line').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_hashendtarget').closest('.control-group').hide();
		jQuery('#jform_to_line').closest('.control-group').hide();
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
