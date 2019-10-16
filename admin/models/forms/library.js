/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwbnvxj_required = false;
jform_vvvvwbzvxk_required = false;
jform_vvvvwcbvxl_required = false;
jform_vvvvwcbvxm_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var how_vvvvwbl = jQuery("#jform_how").val();
	var target_vvvvwbl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbl(how_vvvvwbl,target_vvvvwbl);

	var how_vvvvwbn = jQuery("#jform_how").val();
	var target_vvvvwbn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbn(how_vvvvwbn,target_vvvvwbn);

	var how_vvvvwbp = jQuery("#jform_how").val();
	var target_vvvvwbp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbp(how_vvvvwbp,target_vvvvwbp);

	var how_vvvvwbr = jQuery("#jform_how").val();
	var target_vvvvwbr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbr(how_vvvvwbr,target_vvvvwbr);

	var how_vvvvwbt = jQuery("#jform_how").val();
	var target_vvvvwbt = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbt(how_vvvvwbt,target_vvvvwbt);

	var target_vvvvwbu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbu = jQuery("#jform_how").val();
	vvvvwbu(target_vvvvwbu,how_vvvvwbu);

	var how_vvvvwbv = jQuery("#jform_how").val();
	var target_vvvvwbv = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbv(how_vvvvwbv,target_vvvvwbv);

	var target_vvvvwbw = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwbw = jQuery("#jform_how").val();
	vvvvwbw(target_vvvvwbw,how_vvvvwbw);

	var how_vvvvwbx = jQuery("#jform_how").val();
	var target_vvvvwbx = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwbx(how_vvvvwbx,target_vvvvwbx);

	var target_vvvvwby = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwby = jQuery("#jform_how").val();
	vvvvwby(target_vvvvwby,how_vvvvwby);

	var target_vvvvwbz = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwbz = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwbz(target_vvvvwbz,type_vvvvwbz);

	var target_vvvvwcb = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcb(target_vvvvwcb);
});

// the vvvvwbl function
function vvvvwbl(how_vvvvwbl,target_vvvvwbl)
{
	if (isSet(how_vvvvwbl) && how_vvvvwbl.constructor !== Array)
	{
		var temp_vvvvwbl = how_vvvvwbl;
		var how_vvvvwbl = [];
		how_vvvvwbl.push(temp_vvvvwbl);
	}
	else if (!isSet(how_vvvvwbl))
	{
		var how_vvvvwbl = [];
	}
	var how = how_vvvvwbl.some(how_vvvvwbl_SomeFunc);

	if (isSet(target_vvvvwbl) && target_vvvvwbl.constructor !== Array)
	{
		var temp_vvvvwbl = target_vvvvwbl;
		var target_vvvvwbl = [];
		target_vvvvwbl.push(temp_vvvvwbl);
	}
	else if (!isSet(target_vvvvwbl))
	{
		var target_vvvvwbl = [];
	}
	var target = target_vvvvwbl.some(target_vvvvwbl_SomeFunc);


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

// the vvvvwbl Some function
function how_vvvvwbl_SomeFunc(how_vvvvwbl)
{
	// set the function logic
	if (how_vvvvwbl == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbl Some function
function target_vvvvwbl_SomeFunc(target_vvvvwbl)
{
	// set the function logic
	if (target_vvvvwbl == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(how_vvvvwbn,target_vvvvwbn)
{
	if (isSet(how_vvvvwbn) && how_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = how_vvvvwbn;
		var how_vvvvwbn = [];
		how_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(how_vvvvwbn))
	{
		var how_vvvvwbn = [];
	}
	var how = how_vvvvwbn.some(how_vvvvwbn_SomeFunc);

	if (isSet(target_vvvvwbn) && target_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = target_vvvvwbn;
		var target_vvvvwbn = [];
		target_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(target_vvvvwbn))
	{
		var target_vvvvwbn = [];
	}
	var target = target_vvvvwbn.some(target_vvvvwbn_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('#jform_php_setdocument').closest('.control-group').show();
		// add required attribute to php_setdocument field
		if (jform_vvvvwbnvxj_required)
		{
			updateFieldRequired('php_setdocument',0);
			jQuery('#jform_php_setdocument').prop('required','required');
			jQuery('#jform_php_setdocument').attr('aria-required',true);
			jQuery('#jform_php_setdocument').addClass('required');
			jform_vvvvwbnvxj_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_setdocument').closest('.control-group').hide();
		// remove required attribute from php_setdocument field
		if (!jform_vvvvwbnvxj_required)
		{
			updateFieldRequired('php_setdocument',1);
			jQuery('#jform_php_setdocument').removeAttr('required');
			jQuery('#jform_php_setdocument').removeAttr('aria-required');
			jQuery('#jform_php_setdocument').removeClass('required');
			jform_vvvvwbnvxj_required = true;
		}
	}
}

// the vvvvwbn Some function
function how_vvvvwbn_SomeFunc(how_vvvvwbn)
{
	// set the function logic
	if (how_vvvvwbn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbn Some function
function target_vvvvwbn_SomeFunc(target_vvvvwbn)
{
	// set the function logic
	if (target_vvvvwbn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbp function
function vvvvwbp(how_vvvvwbp,target_vvvvwbp)
{
	if (isSet(how_vvvvwbp) && how_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = how_vvvvwbp;
		var how_vvvvwbp = [];
		how_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(how_vvvvwbp))
	{
		var how_vvvvwbp = [];
	}
	var how = how_vvvvwbp.some(how_vvvvwbp_SomeFunc);

	if (isSet(target_vvvvwbp) && target_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = target_vvvvwbp;
		var target_vvvvwbp = [];
		target_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(target_vvvvwbp))
	{
		var target_vvvvwbp = [];
	}
	var target = target_vvvvwbp.some(target_vvvvwbp_SomeFunc);


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

// the vvvvwbp Some function
function how_vvvvwbp_SomeFunc(how_vvvvwbp)
{
	// set the function logic
	if (how_vvvvwbp == 2 || how_vvvvwbp == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbp Some function
function target_vvvvwbp_SomeFunc(target_vvvvwbp)
{
	// set the function logic
	if (target_vvvvwbp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbr function
function vvvvwbr(how_vvvvwbr,target_vvvvwbr)
{
	if (isSet(how_vvvvwbr) && how_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = how_vvvvwbr;
		var how_vvvvwbr = [];
		how_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(how_vvvvwbr))
	{
		var how_vvvvwbr = [];
	}
	var how = how_vvvvwbr.some(how_vvvvwbr_SomeFunc);

	if (isSet(target_vvvvwbr) && target_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = target_vvvvwbr;
		var target_vvvvwbr = [];
		target_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(target_vvvvwbr))
	{
		var target_vvvvwbr = [];
	}
	var target = target_vvvvwbr.some(target_vvvvwbr_SomeFunc);


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

// the vvvvwbr Some function
function how_vvvvwbr_SomeFunc(how_vvvvwbr)
{
	// set the function logic
	if (how_vvvvwbr == 1 || how_vvvvwbr == 2 || how_vvvvwbr == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbr Some function
function target_vvvvwbr_SomeFunc(target_vvvvwbr)
{
	// set the function logic
	if (target_vvvvwbr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbt function
function vvvvwbt(how_vvvvwbt,target_vvvvwbt)
{
	if (isSet(how_vvvvwbt) && how_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = how_vvvvwbt;
		var how_vvvvwbt = [];
		how_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(how_vvvvwbt))
	{
		var how_vvvvwbt = [];
	}
	var how = how_vvvvwbt.some(how_vvvvwbt_SomeFunc);

	if (isSet(target_vvvvwbt) && target_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = target_vvvvwbt;
		var target_vvvvwbt = [];
		target_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(target_vvvvwbt))
	{
		var target_vvvvwbt = [];
	}
	var target = target_vvvvwbt.some(target_vvvvwbt_SomeFunc);


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

// the vvvvwbt Some function
function how_vvvvwbt_SomeFunc(how_vvvvwbt)
{
	// set the function logic
	if (how_vvvvwbt == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwbt Some function
function target_vvvvwbt_SomeFunc(target_vvvvwbt)
{
	// set the function logic
	if (target_vvvvwbt == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbu function
function vvvvwbu(target_vvvvwbu,how_vvvvwbu)
{
	if (isSet(target_vvvvwbu) && target_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = target_vvvvwbu;
		var target_vvvvwbu = [];
		target_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(target_vvvvwbu))
	{
		var target_vvvvwbu = [];
	}
	var target = target_vvvvwbu.some(target_vvvvwbu_SomeFunc);

	if (isSet(how_vvvvwbu) && how_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = how_vvvvwbu;
		var how_vvvvwbu = [];
		how_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(how_vvvvwbu))
	{
		var how_vvvvwbu = [];
	}
	var how = how_vvvvwbu.some(how_vvvvwbu_SomeFunc);


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

// the vvvvwbu Some function
function target_vvvvwbu_SomeFunc(target_vvvvwbu)
{
	// set the function logic
	if (target_vvvvwbu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbu Some function
function how_vvvvwbu_SomeFunc(how_vvvvwbu)
{
	// set the function logic
	if (how_vvvvwbu == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwbv function
function vvvvwbv(how_vvvvwbv,target_vvvvwbv)
{
	if (isSet(how_vvvvwbv) && how_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = how_vvvvwbv;
		var how_vvvvwbv = [];
		how_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(how_vvvvwbv))
	{
		var how_vvvvwbv = [];
	}
	var how = how_vvvvwbv.some(how_vvvvwbv_SomeFunc);

	if (isSet(target_vvvvwbv) && target_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = target_vvvvwbv;
		var target_vvvvwbv = [];
		target_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(target_vvvvwbv))
	{
		var target_vvvvwbv = [];
	}
	var target = target_vvvvwbv.some(target_vvvvwbv_SomeFunc);


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

// the vvvvwbv Some function
function how_vvvvwbv_SomeFunc(how_vvvvwbv)
{
	// set the function logic
	if (how_vvvvwbv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbv Some function
function target_vvvvwbv_SomeFunc(target_vvvvwbv)
{
	// set the function logic
	if (target_vvvvwbv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbw function
function vvvvwbw(target_vvvvwbw,how_vvvvwbw)
{
	if (isSet(target_vvvvwbw) && target_vvvvwbw.constructor !== Array)
	{
		var temp_vvvvwbw = target_vvvvwbw;
		var target_vvvvwbw = [];
		target_vvvvwbw.push(temp_vvvvwbw);
	}
	else if (!isSet(target_vvvvwbw))
	{
		var target_vvvvwbw = [];
	}
	var target = target_vvvvwbw.some(target_vvvvwbw_SomeFunc);

	if (isSet(how_vvvvwbw) && how_vvvvwbw.constructor !== Array)
	{
		var temp_vvvvwbw = how_vvvvwbw;
		var how_vvvvwbw = [];
		how_vvvvwbw.push(temp_vvvvwbw);
	}
	else if (!isSet(how_vvvvwbw))
	{
		var how_vvvvwbw = [];
	}
	var how = how_vvvvwbw.some(how_vvvvwbw_SomeFunc);


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

// the vvvvwbw Some function
function target_vvvvwbw_SomeFunc(target_vvvvwbw)
{
	// set the function logic
	if (target_vvvvwbw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbw Some function
function how_vvvvwbw_SomeFunc(how_vvvvwbw)
{
	// set the function logic
	if (how_vvvvwbw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbx function
function vvvvwbx(how_vvvvwbx,target_vvvvwbx)
{
	if (isSet(how_vvvvwbx) && how_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = how_vvvvwbx;
		var how_vvvvwbx = [];
		how_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(how_vvvvwbx))
	{
		var how_vvvvwbx = [];
	}
	var how = how_vvvvwbx.some(how_vvvvwbx_SomeFunc);

	if (isSet(target_vvvvwbx) && target_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = target_vvvvwbx;
		var target_vvvvwbx = [];
		target_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(target_vvvvwbx))
	{
		var target_vvvvwbx = [];
	}
	var target = target_vvvvwbx.some(target_vvvvwbx_SomeFunc);


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

// the vvvvwbx Some function
function how_vvvvwbx_SomeFunc(how_vvvvwbx)
{
	// set the function logic
	if (how_vvvvwbx == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbx Some function
function target_vvvvwbx_SomeFunc(target_vvvvwbx)
{
	// set the function logic
	if (target_vvvvwbx == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwby function
function vvvvwby(target_vvvvwby,how_vvvvwby)
{
	if (isSet(target_vvvvwby) && target_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = target_vvvvwby;
		var target_vvvvwby = [];
		target_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(target_vvvvwby))
	{
		var target_vvvvwby = [];
	}
	var target = target_vvvvwby.some(target_vvvvwby_SomeFunc);

	if (isSet(how_vvvvwby) && how_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = how_vvvvwby;
		var how_vvvvwby = [];
		how_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(how_vvvvwby))
	{
		var how_vvvvwby = [];
	}
	var how = how_vvvvwby.some(how_vvvvwby_SomeFunc);


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

// the vvvvwby Some function
function target_vvvvwby_SomeFunc(target_vvvvwby)
{
	// set the function logic
	if (target_vvvvwby == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwby Some function
function how_vvvvwby_SomeFunc(how_vvvvwby)
{
	// set the function logic
	if (how_vvvvwby == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbz function
function vvvvwbz(target_vvvvwbz,type_vvvvwbz)
{
	// set the function logic
	if (target_vvvvwbz == 1 && type_vvvvwbz == 2)
	{
		jQuery('#jform_libraries').closest('.control-group').show();
		// add required attribute to libraries field
		if (jform_vvvvwbzvxk_required)
		{
			updateFieldRequired('libraries',0);
			jQuery('#jform_libraries').prop('required','required');
			jQuery('#jform_libraries').attr('aria-required',true);
			jQuery('#jform_libraries').addClass('required');
			jform_vvvvwbzvxk_required = false;
		}
	}
	else
	{
		jQuery('#jform_libraries').closest('.control-group').hide();
		// remove required attribute from libraries field
		if (!jform_vvvvwbzvxk_required)
		{
			updateFieldRequired('libraries',1);
			jQuery('#jform_libraries').removeAttr('required');
			jQuery('#jform_libraries').removeAttr('aria-required');
			jQuery('#jform_libraries').removeClass('required');
			jform_vvvvwbzvxk_required = true;
		}
	}
}

// the vvvvwcb function
function vvvvwcb(target_vvvvwcb)
{
	// set the function logic
	if (target_vvvvwcb == 1)
	{
		jQuery('#jform_how').closest('.control-group').show();
		// add required attribute to how field
		if (jform_vvvvwcbvxl_required)
		{
			updateFieldRequired('how',0);
			jQuery('#jform_how').prop('required','required');
			jQuery('#jform_how').attr('aria-required',true);
			jQuery('#jform_how').addClass('required');
			jform_vvvvwcbvxl_required = false;
		}
		jQuery('#jform_type').closest('.control-group').show();
		// add required attribute to type field
		if (jform_vvvvwcbvxm_required)
		{
			updateFieldRequired('type',0);
			jQuery('#jform_type').prop('required','required');
			jQuery('#jform_type').attr('aria-required',true);
			jQuery('#jform_type').addClass('required');
			jform_vvvvwcbvxm_required = false;
		}
	}
	else
	{
		jQuery('#jform_how').closest('.control-group').hide();
		// remove required attribute from how field
		if (!jform_vvvvwcbvxl_required)
		{
			updateFieldRequired('how',1);
			jQuery('#jform_how').removeAttr('required');
			jQuery('#jform_how').removeAttr('aria-required');
			jQuery('#jform_how').removeClass('required');
			jform_vvvvwcbvxl_required = true;
		}
		jQuery('#jform_type').closest('.control-group').hide();
		// remove required attribute from type field
		if (!jform_vvvvwcbvxm_required)
		{
			updateFieldRequired('type',1);
			jQuery('#jform_type').removeAttr('required');
			jQuery('#jform_type').removeAttr('aria-required');
			jQuery('#jform_type').removeClass('required');
			jform_vvvvwcbvxm_required = true;
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
	getAjaxDisplay_server(type).done(function(result) {
		if (result) {
			jQuery('#display_'+type).html(result);
		}
		// set button
		addButtonID(type,'header_'+type+'_buttons', 2); // <-- little edit button
	});
}

function getAjaxDisplay_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getAjaxDisplay&format=json&raw=true&vdm="+vastDevMod);
	if (token.length > 0 && type.length > 0) {
		var request = token+'=1&type=' + type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getFieldSelectOptions_server(fieldId){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.fieldSelectOptions&format=json&raw=true");
	if (token.length > 0 && fieldId > 0) {
		var request = token+'=1&id='+fieldId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getFieldSelectOptions(fieldKey){
	// first check if the field is set
	if(jQuery("#jform_addconditions__addconditions"+fieldKey+"__option_field").length) {
		var fieldId = jQuery("#jform_addconditions__addconditions"+fieldKey+"__option_field option:selected").val();
		getFieldSelectOptions_server(fieldId).done(function(result) {
			if(result) {
				jQuery('textarea#jform_addconditions__addconditions'+fieldKey+'__field_options').val(result);
			} else {
				jQuery('textarea#jform_addconditions__addconditions'+fieldKey+'__field_options').val('');
			}
		});
	}
}

function getEditCustomCodeButtons_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id+'&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getEditCustomCodeButtons(){
	// get the id
	id = jQuery("#jform_id").val();
	getEditCustomCodeButtons_server(id).done(function(result) {
		if(isObject(result)){
			jQuery.each(result, function( field, buttons ) {
				jQuery('<div class="control-group"><div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
				jQuery.each(buttons, function( name, button ) {
					jQuery(".control-customcode-buttons-"+field).append(button);
				});
			});
		}
	})
}

// check object is not empty
function isObject(obj) {
	for(var prop in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, prop)) {
			return true;
		}
	}
	return false;
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

function getLinked_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type > 0){
		var request = token+'=1&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
} 
