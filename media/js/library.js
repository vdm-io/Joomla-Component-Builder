/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwanvwu_required = false;
jform_vvvvwbbvwv_required = false;
jform_vvvvwbbvww_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var how_vvvvwal = jQuery("#jform_how").val();
	var target_vvvvwal = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwal(how_vvvvwal,target_vvvvwal);

	var how_vvvvwan = jQuery("#jform_how").val();
	var target_vvvvwan = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwan(how_vvvvwan,target_vvvvwan);

	var how_vvvvwap = jQuery("#jform_how").val();
	var target_vvvvwap = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwap(how_vvvvwap,target_vvvvwap);

	var how_vvvvwar = jQuery("#jform_how").val();
	var target_vvvvwar = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwar(how_vvvvwar,target_vvvvwar);

	var how_vvvvwat = jQuery("#jform_how").val();
	var target_vvvvwat = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwat(how_vvvvwat,target_vvvvwat);

	var target_vvvvwau = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwau = jQuery("#jform_how").val();
	vvvvwau(target_vvvvwau,how_vvvvwau);

	var how_vvvvwav = jQuery("#jform_how").val();
	var target_vvvvwav = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwav(how_vvvvwav,target_vvvvwav);

	var target_vvvvwaw = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwaw = jQuery("#jform_how").val();
	vvvvwaw(target_vvvvwaw,how_vvvvwaw);

	var how_vvvvwax = jQuery("#jform_how").val();
	var target_vvvvwax = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwax(how_vvvvwax,target_vvvvwax);

	var target_vvvvway = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvway = jQuery("#jform_how").val();
	vvvvway(target_vvvvway,how_vvvvway);

	var target_vvvvwaz = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwaz = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwaz(target_vvvvwaz,type_vvvvwaz);

	var target_vvvvwbb = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbb(target_vvvvwbb);

	var target_vvvvwbc = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbc(target_vvvvwbc);
});

// the vvvvwal function
function vvvvwal(how_vvvvwal,target_vvvvwal)
{
	if (isSet(how_vvvvwal) && how_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = how_vvvvwal;
		var how_vvvvwal = [];
		how_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(how_vvvvwal))
	{
		var how_vvvvwal = [];
	}
	var how = how_vvvvwal.some(how_vvvvwal_SomeFunc);

	if (isSet(target_vvvvwal) && target_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = target_vvvvwal;
		var target_vvvvwal = [];
		target_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(target_vvvvwal))
	{
		var target_vvvvwal = [];
	}
	var target = target_vvvvwal.some(target_vvvvwal_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('#jform_addconditions-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_addconditions-lbl').closest('.control-group').hide();
	}
}

// the vvvvwal Some function
function how_vvvvwal_SomeFunc(how_vvvvwal)
{
	// set the function logic
	if (how_vvvvwal == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwal Some function
function target_vvvvwal_SomeFunc(target_vvvvwal)
{
	// set the function logic
	if (target_vvvvwal == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwan function
function vvvvwan(how_vvvvwan,target_vvvvwan)
{
	if (isSet(how_vvvvwan) && how_vvvvwan.constructor !== Array)
	{
		var temp_vvvvwan = how_vvvvwan;
		var how_vvvvwan = [];
		how_vvvvwan.push(temp_vvvvwan);
	}
	else if (!isSet(how_vvvvwan))
	{
		var how_vvvvwan = [];
	}
	var how = how_vvvvwan.some(how_vvvvwan_SomeFunc);

	if (isSet(target_vvvvwan) && target_vvvvwan.constructor !== Array)
	{
		var temp_vvvvwan = target_vvvvwan;
		var target_vvvvwan = [];
		target_vvvvwan.push(temp_vvvvwan);
	}
	else if (!isSet(target_vvvvwan))
	{
		var target_vvvvwan = [];
	}
	var target = target_vvvvwan.some(target_vvvvwan_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('#jform_php_setdocument').closest('.control-group').show();
		// add required attribute to php_setdocument field
		if (jform_vvvvwanvwu_required)
		{
			updateFieldRequired('php_setdocument',0);
			jQuery('#jform_php_setdocument').prop('required','required');
			jQuery('#jform_php_setdocument').attr('aria-required',true);
			jQuery('#jform_php_setdocument').addClass('required');
			jform_vvvvwanvwu_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_setdocument').closest('.control-group').hide();
		// remove required attribute from php_setdocument field
		if (!jform_vvvvwanvwu_required)
		{
			updateFieldRequired('php_setdocument',1);
			jQuery('#jform_php_setdocument').removeAttr('required');
			jQuery('#jform_php_setdocument').removeAttr('aria-required');
			jQuery('#jform_php_setdocument').removeClass('required');
			jform_vvvvwanvwu_required = true;
		}
	}
}

// the vvvvwan Some function
function how_vvvvwan_SomeFunc(how_vvvvwan)
{
	// set the function logic
	if (how_vvvvwan == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwan Some function
function target_vvvvwan_SomeFunc(target_vvvvwan)
{
	// set the function logic
	if (target_vvvvwan == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwap function
function vvvvwap(how_vvvvwap,target_vvvvwap)
{
	if (isSet(how_vvvvwap) && how_vvvvwap.constructor !== Array)
	{
		var temp_vvvvwap = how_vvvvwap;
		var how_vvvvwap = [];
		how_vvvvwap.push(temp_vvvvwap);
	}
	else if (!isSet(how_vvvvwap))
	{
		var how_vvvvwap = [];
	}
	var how = how_vvvvwap.some(how_vvvvwap_SomeFunc);

	if (isSet(target_vvvvwap) && target_vvvvwap.constructor !== Array)
	{
		var temp_vvvvwap = target_vvvvwap;
		var target_vvvvwap = [];
		target_vvvvwap.push(temp_vvvvwap);
	}
	else if (!isSet(target_vvvvwap))
	{
		var target_vvvvwap = [];
	}
	var target = target_vvvvwap.some(target_vvvvwap_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('.note_display_library_config').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_display_library_config').closest('.control-group').hide();
	}
}

// the vvvvwap Some function
function how_vvvvwap_SomeFunc(how_vvvvwap)
{
	// set the function logic
	if (how_vvvvwap == 2 || how_vvvvwap == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwap Some function
function target_vvvvwap_SomeFunc(target_vvvvwap)
{
	// set the function logic
	if (target_vvvvwap == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwar function
function vvvvwar(how_vvvvwar,target_vvvvwar)
{
	if (isSet(how_vvvvwar) && how_vvvvwar.constructor !== Array)
	{
		var temp_vvvvwar = how_vvvvwar;
		var how_vvvvwar = [];
		how_vvvvwar.push(temp_vvvvwar);
	}
	else if (!isSet(how_vvvvwar))
	{
		var how_vvvvwar = [];
	}
	var how = how_vvvvwar.some(how_vvvvwar_SomeFunc);

	if (isSet(target_vvvvwar) && target_vvvvwar.constructor !== Array)
	{
		var temp_vvvvwar = target_vvvvwar;
		var target_vvvvwar = [];
		target_vvvvwar.push(temp_vvvvwar);
	}
	else if (!isSet(target_vvvvwar))
	{
		var target_vvvvwar = [];
	}
	var target = target_vvvvwar.some(target_vvvvwar_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('.note_display_library_files_folders_urls').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_display_library_files_folders_urls').closest('.control-group').hide();
	}
}

// the vvvvwar Some function
function how_vvvvwar_SomeFunc(how_vvvvwar)
{
	// set the function logic
	if (how_vvvvwar == 1 || how_vvvvwar == 2 || how_vvvvwar == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwar Some function
function target_vvvvwar_SomeFunc(target_vvvvwar)
{
	// set the function logic
	if (target_vvvvwar == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwat function
function vvvvwat(how_vvvvwat,target_vvvvwat)
{
	if (isSet(how_vvvvwat) && how_vvvvwat.constructor !== Array)
	{
		var temp_vvvvwat = how_vvvvwat;
		var how_vvvvwat = [];
		how_vvvvwat.push(temp_vvvvwat);
	}
	else if (!isSet(how_vvvvwat))
	{
		var how_vvvvwat = [];
	}
	var how = how_vvvvwat.some(how_vvvvwat_SomeFunc);

	if (isSet(target_vvvvwat) && target_vvvvwat.constructor !== Array)
	{
		var temp_vvvvwat = target_vvvvwat;
		var target_vvvvwat = [];
		target_vvvvwat.push(temp_vvvvwat);
	}
	else if (!isSet(target_vvvvwat))
	{
		var target_vvvvwat = [];
	}
	var target = target_vvvvwat.some(target_vvvvwat_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('.note_no_behaviour_one').closest('.control-group').show();
		jQuery('.note_no_behaviour_three').closest('.control-group').show();
		jQuery('.note_no_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_no_behaviour_one').closest('.control-group').hide();
		jQuery('.note_no_behaviour_three').closest('.control-group').hide();
		jQuery('.note_no_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvwat Some function
function how_vvvvwat_SomeFunc(how_vvvvwat)
{
	// set the function logic
	if (how_vvvvwat == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwat Some function
function target_vvvvwat_SomeFunc(target_vvvvwat)
{
	// set the function logic
	if (target_vvvvwat == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwau function
function vvvvwau(target_vvvvwau,how_vvvvwau)
{
	if (isSet(target_vvvvwau) && target_vvvvwau.constructor !== Array)
	{
		var temp_vvvvwau = target_vvvvwau;
		var target_vvvvwau = [];
		target_vvvvwau.push(temp_vvvvwau);
	}
	else if (!isSet(target_vvvvwau))
	{
		var target_vvvvwau = [];
	}
	var target = target_vvvvwau.some(target_vvvvwau_SomeFunc);

	if (isSet(how_vvvvwau) && how_vvvvwau.constructor !== Array)
	{
		var temp_vvvvwau = how_vvvvwau;
		var how_vvvvwau = [];
		how_vvvvwau.push(temp_vvvvwau);
	}
	else if (!isSet(how_vvvvwau))
	{
		var how_vvvvwau = [];
	}
	var how = how_vvvvwau.some(how_vvvvwau_SomeFunc);


	// set this function logic
	if (target && how)
	{
		jQuery('.note_no_behaviour_one').closest('.control-group').show();
		jQuery('.note_no_behaviour_three').closest('.control-group').show();
		jQuery('.note_no_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_no_behaviour_one').closest('.control-group').hide();
		jQuery('.note_no_behaviour_three').closest('.control-group').hide();
		jQuery('.note_no_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvwau Some function
function target_vvvvwau_SomeFunc(target_vvvvwau)
{
	// set the function logic
	if (target_vvvvwau == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwau Some function
function how_vvvvwau_SomeFunc(how_vvvvwau)
{
	// set the function logic
	if (how_vvvvwau == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwav function
function vvvvwav(how_vvvvwav,target_vvvvwav)
{
	if (isSet(how_vvvvwav) && how_vvvvwav.constructor !== Array)
	{
		var temp_vvvvwav = how_vvvvwav;
		var how_vvvvwav = [];
		how_vvvvwav.push(temp_vvvvwav);
	}
	else if (!isSet(how_vvvvwav))
	{
		var how_vvvvwav = [];
	}
	var how = how_vvvvwav.some(how_vvvvwav_SomeFunc);

	if (isSet(target_vvvvwav) && target_vvvvwav.constructor !== Array)
	{
		var temp_vvvvwav = target_vvvvwav;
		var target_vvvvwav = [];
		target_vvvvwav.push(temp_vvvvwav);
	}
	else if (!isSet(target_vvvvwav))
	{
		var target_vvvvwav = [];
	}
	var target = target_vvvvwav.some(target_vvvvwav_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('.note_yes_behaviour_one').closest('.control-group').show();
		jQuery('.note_yes_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_yes_behaviour_one').closest('.control-group').hide();
		jQuery('.note_yes_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvwav Some function
function how_vvvvwav_SomeFunc(how_vvvvwav)
{
	// set the function logic
	if (how_vvvvwav == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwav Some function
function target_vvvvwav_SomeFunc(target_vvvvwav)
{
	// set the function logic
	if (target_vvvvwav == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwaw function
function vvvvwaw(target_vvvvwaw,how_vvvvwaw)
{
	if (isSet(target_vvvvwaw) && target_vvvvwaw.constructor !== Array)
	{
		var temp_vvvvwaw = target_vvvvwaw;
		var target_vvvvwaw = [];
		target_vvvvwaw.push(temp_vvvvwaw);
	}
	else if (!isSet(target_vvvvwaw))
	{
		var target_vvvvwaw = [];
	}
	var target = target_vvvvwaw.some(target_vvvvwaw_SomeFunc);

	if (isSet(how_vvvvwaw) && how_vvvvwaw.constructor !== Array)
	{
		var temp_vvvvwaw = how_vvvvwaw;
		var how_vvvvwaw = [];
		how_vvvvwaw.push(temp_vvvvwaw);
	}
	else if (!isSet(how_vvvvwaw))
	{
		var how_vvvvwaw = [];
	}
	var how = how_vvvvwaw.some(how_vvvvwaw_SomeFunc);


	// set this function logic
	if (target && how)
	{
		jQuery('.note_yes_behaviour_one').closest('.control-group').show();
		jQuery('.note_yes_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_yes_behaviour_one').closest('.control-group').hide();
		jQuery('.note_yes_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvwaw Some function
function target_vvvvwaw_SomeFunc(target_vvvvwaw)
{
	// set the function logic
	if (target_vvvvwaw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwaw Some function
function how_vvvvwaw_SomeFunc(how_vvvvwaw)
{
	// set the function logic
	if (how_vvvvwaw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwax function
function vvvvwax(how_vvvvwax,target_vvvvwax)
{
	if (isSet(how_vvvvwax) && how_vvvvwax.constructor !== Array)
	{
		var temp_vvvvwax = how_vvvvwax;
		var how_vvvvwax = [];
		how_vvvvwax.push(temp_vvvvwax);
	}
	else if (!isSet(how_vvvvwax))
	{
		var how_vvvvwax = [];
	}
	var how = how_vvvvwax.some(how_vvvvwax_SomeFunc);

	if (isSet(target_vvvvwax) && target_vvvvwax.constructor !== Array)
	{
		var temp_vvvvwax = target_vvvvwax;
		var target_vvvvwax = [];
		target_vvvvwax.push(temp_vvvvwax);
	}
	else if (!isSet(target_vvvvwax))
	{
		var target_vvvvwax = [];
	}
	var target = target_vvvvwax.some(target_vvvvwax_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('.note_build_in_behaviour_one').closest('.control-group').show();
		jQuery('.note_build_in_behaviour_three').closest('.control-group').show();
		jQuery('.note_build_in_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_build_in_behaviour_one').closest('.control-group').hide();
		jQuery('.note_build_in_behaviour_three').closest('.control-group').hide();
		jQuery('.note_build_in_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvwax Some function
function how_vvvvwax_SomeFunc(how_vvvvwax)
{
	// set the function logic
	if (how_vvvvwax == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwax Some function
function target_vvvvwax_SomeFunc(target_vvvvwax)
{
	// set the function logic
	if (target_vvvvwax == 1)
	{
		return true;
	}
	return false;
}

// the vvvvway function
function vvvvway(target_vvvvway,how_vvvvway)
{
	if (isSet(target_vvvvway) && target_vvvvway.constructor !== Array)
	{
		var temp_vvvvway = target_vvvvway;
		var target_vvvvway = [];
		target_vvvvway.push(temp_vvvvway);
	}
	else if (!isSet(target_vvvvway))
	{
		var target_vvvvway = [];
	}
	var target = target_vvvvway.some(target_vvvvway_SomeFunc);

	if (isSet(how_vvvvway) && how_vvvvway.constructor !== Array)
	{
		var temp_vvvvway = how_vvvvway;
		var how_vvvvway = [];
		how_vvvvway.push(temp_vvvvway);
	}
	else if (!isSet(how_vvvvway))
	{
		var how_vvvvway = [];
	}
	var how = how_vvvvway.some(how_vvvvway_SomeFunc);


	// set this function logic
	if (target && how)
	{
		jQuery('.note_build_in_behaviour_one').closest('.control-group').show();
		jQuery('.note_build_in_behaviour_three').closest('.control-group').show();
		jQuery('.note_build_in_behaviour_two').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_build_in_behaviour_one').closest('.control-group').hide();
		jQuery('.note_build_in_behaviour_three').closest('.control-group').hide();
		jQuery('.note_build_in_behaviour_two').closest('.control-group').hide();
	}
}

// the vvvvway Some function
function target_vvvvway_SomeFunc(target_vvvvway)
{
	// set the function logic
	if (target_vvvvway == 1)
	{
		return true;
	}
	return false;
}

// the vvvvway Some function
function how_vvvvway_SomeFunc(how_vvvvway)
{
	// set the function logic
	if (how_vvvvway == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwaz function
function vvvvwaz(target_vvvvwaz,type_vvvvwaz)
{
	// set the function logic
	if (target_vvvvwaz == 1 && type_vvvvwaz == 2)
	{
		jQuery('#jform_libraries').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_libraries').closest('.control-group').hide();
	}
}

// the vvvvwbb function
function vvvvwbb(target_vvvvwbb)
{
	// set the function logic
	if (target_vvvvwbb == 1)
	{
		jQuery('#jform_how').closest('.control-group').show();
		// add required attribute to how field
		if (jform_vvvvwbbvwv_required)
		{
			updateFieldRequired('how',0);
			jQuery('#jform_how').prop('required','required');
			jQuery('#jform_how').attr('aria-required',true);
			jQuery('#jform_how').addClass('required');
			jform_vvvvwbbvwv_required = false;
		}
		jQuery('#jform_type').closest('.control-group').show();
		// add required attribute to type field
		if (jform_vvvvwbbvww_required)
		{
			updateFieldRequired('type',0);
			jQuery('#jform_type').prop('required','required');
			jQuery('#jform_type').attr('aria-required',true);
			jQuery('#jform_type').addClass('required');
			jform_vvvvwbbvww_required = false;
		}
	}
	else
	{
		jQuery('#jform_how').closest('.control-group').hide();
		// remove required attribute from how field
		if (!jform_vvvvwbbvwv_required)
		{
			updateFieldRequired('how',1);
			jQuery('#jform_how').removeAttr('required');
			jQuery('#jform_how').removeAttr('aria-required');
			jQuery('#jform_how').removeClass('required');
			jform_vvvvwbbvwv_required = true;
		}
		jQuery('#jform_type').closest('.control-group').hide();
		// remove required attribute from type field
		if (!jform_vvvvwbbvww_required)
		{
			updateFieldRequired('type',1);
			jQuery('#jform_type').removeAttr('required');
			jQuery('#jform_type').removeAttr('aria-required');
			jQuery('#jform_type').removeClass('required');
			jform_vvvvwbbvww_required = true;
		}
	}
}

// the vvvvwbc function
function vvvvwbc(target_vvvvwbc)
{
	// set the function logic
	if (target_vvvvwbc == 2)
	{
		jQuery('.note_yes_behaviour_library').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_yes_behaviour_library').closest('.control-group').hide();
	}
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (document.getElementById('jform_not_required')) {
		var not_required = jQuery('#jform_not_required').val().split(",");

		if(status == 1)
		{
			not_required.push(name);
		}
		else
		{
			not_required = removeFieldFromNotRequired(not_required, name);
		}

		jQuery('#jform_not_required').val(fixNotRequiredArray(not_required).toString());
	}
}

// remove field from not_required
function removeFieldFromNotRequired(array, what) {
	return array.filter(function(element){
		return element !== what;
	});
}

// fix not required array
function fixNotRequiredArray(array) {
	var seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function(item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

// remove empty from not_required array
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		// remove ( 一_一) as well - lol
		return (el.length > 0 && '一_一' !== el);
	});
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
}


jQuery(document).ready(function()
{
	// get the linked details
	getLinked();
	// now load the displays
	getAjaxDisplay('library_config');
	getAjaxDisplay('library_files_folders_urls');

	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 300);
});

function addData(result,where){
	jQuery(result).insertAfter(jQuery(where).closest('.control-group'));
}

function getAjaxDisplay(type){
	getCodeFrom_server(1, type, 'type', 'getAjaxDisplay').then(function(result) {
		if (result) {
			jQuery('#display_'+type).html(result);
		}
		// set button
		addButtonID(type,'header_'+type+'_buttons', 2); // <-- little edit button
	});
}

function getFieldSelectOptions(fieldKey){
	// first check if the field is set
	if(jQuery("#jform_addconditions__addconditions"+fieldKey+"__option_field").length) {
		var fieldId = jQuery("#jform_addconditions__addconditions"+fieldKey+"__option_field option:selected").val();
		getCodeFrom_server(fieldId, 'type', 'type', 'fieldSelectOptions').then(function(result) {
			if(result) {
				jQuery('textarea#jform_addconditions__addconditions'+fieldKey+'__field_options').val(result);
			} else {
				jQuery('textarea#jform_addconditions__addconditions'+fieldKey+'__field_options').val('');
			}
		});
	}
}

function getCodeFrom_server(id, type, type_name, callingName) {
	var url = "index.php?option=com_componentbuilder&task=ajax." + callingName + "&format=json&raw=true&vdm="+vastDevMod;
	if (token.length > 0 && getCodeFrom_isValidId(id) && type.length > 0) {
		url += '&' + token + '=1&' + type_name + '=' + type + '&id=' + id;
	} else {
		console.error('There was a issue with the values passed to the [getCodeFrom_server] method and we could not make the Ajax call.');
		return;
	}
	var getUrl = JRouter(url);
	return fetch(getUrl, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function(response) {
		if (response.ok) {
			return response.json();
		} else {
			throw new Error('Network response was not ok');
		}
	}).then(function(data) {
		return data;
	}).catch(function(error) {
		console.error('There was a problem with the fetch operation:', error);
	});
}
function getCodeFrom_isValidId(id) {
    if (typeof id === 'number') {
        // Check if it's a positive integer
        return Number.isInteger(id) && id > 0;
    } else if (typeof id === 'string') {
        // Check if it's a string of length > 30
        return id.length > 30;
    }
    // If neither a number nor a string, return false
    return false;
}

function getEditCustomCodeButtons_server(id) {
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	let requestParams = '';
	if (token.length > 0 && id > 0) {
		requestParams = token+'=1&id='+id+'&return_here='+return_here;
	}
	// Construct URL with parameters for GET request
	const urlWithParams = getUrl + '&' + requestParams;

	// Using the Fetch API for the GET request
	return fetch(urlWithParams, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(response => {
		if (!response.ok) {
			throw new Error('Network response was not ok');
		}
		return response.json();
	});
}

function getEditCustomCodeButtons() {
	// Get the id using pure JavaScript
	const id = document.querySelector("#jform_id").value;
	getEditCustomCodeButtons_server(id).then(function(result) {
		if (typeof result === 'object') {
			Object.entries(result).forEach(([field, buttons]) => {
				// Creating the div element for buttons
				const div = document.createElement('div');
				div.className = 'control-group';
				div.innerHTML = '<div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div>';

				// Insert the div before .control-wrapper-{field}
				const insertBeforeElement = document.querySelector(".control-wrapper-"+field);
				if (insertBeforeElement) {
					insertBeforeElement.parentNode.insertBefore(div, insertBeforeElement);
				}

				// Adding buttons to the div
				Object.entries(buttons).forEach(([name, button]) => {
					const controlsDiv = document.querySelector(".control-customcode-buttons-"+field);
					if (controlsDiv) {
						controlsDiv.innerHTML += button;
					}
				});
			});
		}
	}).catch(error => {
		console.error('Error:', error);
	});
}

function addButtonID_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButtonID&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0 && size > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
function addButtonID(type, where, size){
	addButtonID_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	});
}

function addButton_server(type, size){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getButton&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type.length > 0){
		var request = token+'=1&type='+type+'&size='+size;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}
function addButton(type, where, size){
	// just to insure that default behaviour still works
	size = typeof size !== 'undefined' ? size : 1;
	addButton_server(type, size).done(function(result) {
		if(result){
			if (2 == size) {
				jQuery('#'+where).html(result);
			} else {
				addData(result, '#jform_'+where);
			}
		}
	})
}

function getLinked() {
	getCodeFrom_server(1, 'type', 'type', 'getLinked').then(function(result) {
		if (result.error) {
			console.error(result.error);
		} else if (result) {
			document.getElementById('display_linked_to').innerHTML = result;
		}
	});
}
