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
jform_vvvvwckvxl_required = false;
jform_vvvvwcyvxm_required = false;
jform_vvvvwcyvxn_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var how_vvvvwci = jQuery("#jform_how").val();
	var target_vvvvwci = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwci(how_vvvvwci,target_vvvvwci);

	var how_vvvvwck = jQuery("#jform_how").val();
	var target_vvvvwck = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwck(how_vvvvwck,target_vvvvwck);

	var how_vvvvwcm = jQuery("#jform_how").val();
	var target_vvvvwcm = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcm(how_vvvvwcm,target_vvvvwcm);

	var how_vvvvwco = jQuery("#jform_how").val();
	var target_vvvvwco = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwco(how_vvvvwco,target_vvvvwco);

	var how_vvvvwcq = jQuery("#jform_how").val();
	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcq(how_vvvvwcq,target_vvvvwcq);

	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcr = jQuery("#jform_how").val();
	vvvvwcr(target_vvvvwcr,how_vvvvwcr);

	var how_vvvvwcs = jQuery("#jform_how").val();
	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcs(how_vvvvwcs,target_vvvvwcs);

	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwct = jQuery("#jform_how").val();
	vvvvwct(target_vvvvwct,how_vvvvwct);

	var how_vvvvwcu = jQuery("#jform_how").val();
	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcu(how_vvvvwcu,target_vvvvwcu);

	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcv = jQuery("#jform_how").val();
	vvvvwcv(target_vvvvwcv,how_vvvvwcv);

	var target_vvvvwcw = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcw = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcw(target_vvvvwcw,type_vvvvwcw);

	var target_vvvvwcy = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcy(target_vvvvwcy);

	var target_vvvvwcz = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcz(target_vvvvwcz);
});

// the vvvvwci function
function vvvvwci(how_vvvvwci,target_vvvvwci)
{
	if (isSet(how_vvvvwci) && how_vvvvwci.constructor !== Array)
	{
		var temp_vvvvwci = how_vvvvwci;
		var how_vvvvwci = [];
		how_vvvvwci.push(temp_vvvvwci);
	}
	else if (!isSet(how_vvvvwci))
	{
		var how_vvvvwci = [];
	}
	var how = how_vvvvwci.some(how_vvvvwci_SomeFunc);

	if (isSet(target_vvvvwci) && target_vvvvwci.constructor !== Array)
	{
		var temp_vvvvwci = target_vvvvwci;
		var target_vvvvwci = [];
		target_vvvvwci.push(temp_vvvvwci);
	}
	else if (!isSet(target_vvvvwci))
	{
		var target_vvvvwci = [];
	}
	var target = target_vvvvwci.some(target_vvvvwci_SomeFunc);


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

// the vvvvwci Some function
function how_vvvvwci_SomeFunc(how_vvvvwci)
{
	// set the function logic
	if (how_vvvvwci == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwci Some function
function target_vvvvwci_SomeFunc(target_vvvvwci)
{
	// set the function logic
	if (target_vvvvwci == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwck function
function vvvvwck(how_vvvvwck,target_vvvvwck)
{
	if (isSet(how_vvvvwck) && how_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = how_vvvvwck;
		var how_vvvvwck = [];
		how_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(how_vvvvwck))
	{
		var how_vvvvwck = [];
	}
	var how = how_vvvvwck.some(how_vvvvwck_SomeFunc);

	if (isSet(target_vvvvwck) && target_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = target_vvvvwck;
		var target_vvvvwck = [];
		target_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(target_vvvvwck))
	{
		var target_vvvvwck = [];
	}
	var target = target_vvvvwck.some(target_vvvvwck_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('#jform_php_setdocument').closest('.control-group').show();
		// add required attribute to php_setdocument field
		if (jform_vvvvwckvxl_required)
		{
			updateFieldRequired('php_setdocument',0);
			jQuery('#jform_php_setdocument').prop('required','required');
			jQuery('#jform_php_setdocument').attr('aria-required',true);
			jQuery('#jform_php_setdocument').addClass('required');
			jform_vvvvwckvxl_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_setdocument').closest('.control-group').hide();
		// remove required attribute from php_setdocument field
		if (!jform_vvvvwckvxl_required)
		{
			updateFieldRequired('php_setdocument',1);
			jQuery('#jform_php_setdocument').removeAttr('required');
			jQuery('#jform_php_setdocument').removeAttr('aria-required');
			jQuery('#jform_php_setdocument').removeClass('required');
			jform_vvvvwckvxl_required = true;
		}
	}
}

// the vvvvwck Some function
function how_vvvvwck_SomeFunc(how_vvvvwck)
{
	// set the function logic
	if (how_vvvvwck == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwck Some function
function target_vvvvwck_SomeFunc(target_vvvvwck)
{
	// set the function logic
	if (target_vvvvwck == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcm function
function vvvvwcm(how_vvvvwcm,target_vvvvwcm)
{
	if (isSet(how_vvvvwcm) && how_vvvvwcm.constructor !== Array)
	{
		var temp_vvvvwcm = how_vvvvwcm;
		var how_vvvvwcm = [];
		how_vvvvwcm.push(temp_vvvvwcm);
	}
	else if (!isSet(how_vvvvwcm))
	{
		var how_vvvvwcm = [];
	}
	var how = how_vvvvwcm.some(how_vvvvwcm_SomeFunc);

	if (isSet(target_vvvvwcm) && target_vvvvwcm.constructor !== Array)
	{
		var temp_vvvvwcm = target_vvvvwcm;
		var target_vvvvwcm = [];
		target_vvvvwcm.push(temp_vvvvwcm);
	}
	else if (!isSet(target_vvvvwcm))
	{
		var target_vvvvwcm = [];
	}
	var target = target_vvvvwcm.some(target_vvvvwcm_SomeFunc);


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

// the vvvvwcm Some function
function how_vvvvwcm_SomeFunc(how_vvvvwcm)
{
	// set the function logic
	if (how_vvvvwcm == 2 || how_vvvvwcm == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcm Some function
function target_vvvvwcm_SomeFunc(target_vvvvwcm)
{
	// set the function logic
	if (target_vvvvwcm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwco function
function vvvvwco(how_vvvvwco,target_vvvvwco)
{
	if (isSet(how_vvvvwco) && how_vvvvwco.constructor !== Array)
	{
		var temp_vvvvwco = how_vvvvwco;
		var how_vvvvwco = [];
		how_vvvvwco.push(temp_vvvvwco);
	}
	else if (!isSet(how_vvvvwco))
	{
		var how_vvvvwco = [];
	}
	var how = how_vvvvwco.some(how_vvvvwco_SomeFunc);

	if (isSet(target_vvvvwco) && target_vvvvwco.constructor !== Array)
	{
		var temp_vvvvwco = target_vvvvwco;
		var target_vvvvwco = [];
		target_vvvvwco.push(temp_vvvvwco);
	}
	else if (!isSet(target_vvvvwco))
	{
		var target_vvvvwco = [];
	}
	var target = target_vvvvwco.some(target_vvvvwco_SomeFunc);


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

// the vvvvwco Some function
function how_vvvvwco_SomeFunc(how_vvvvwco)
{
	// set the function logic
	if (how_vvvvwco == 1 || how_vvvvwco == 2 || how_vvvvwco == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwco Some function
function target_vvvvwco_SomeFunc(target_vvvvwco)
{
	// set the function logic
	if (target_vvvvwco == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcq function
function vvvvwcq(how_vvvvwcq,target_vvvvwcq)
{
	if (isSet(how_vvvvwcq) && how_vvvvwcq.constructor !== Array)
	{
		var temp_vvvvwcq = how_vvvvwcq;
		var how_vvvvwcq = [];
		how_vvvvwcq.push(temp_vvvvwcq);
	}
	else if (!isSet(how_vvvvwcq))
	{
		var how_vvvvwcq = [];
	}
	var how = how_vvvvwcq.some(how_vvvvwcq_SomeFunc);

	if (isSet(target_vvvvwcq) && target_vvvvwcq.constructor !== Array)
	{
		var temp_vvvvwcq = target_vvvvwcq;
		var target_vvvvwcq = [];
		target_vvvvwcq.push(temp_vvvvwcq);
	}
	else if (!isSet(target_vvvvwcq))
	{
		var target_vvvvwcq = [];
	}
	var target = target_vvvvwcq.some(target_vvvvwcq_SomeFunc);


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

// the vvvvwcq Some function
function how_vvvvwcq_SomeFunc(how_vvvvwcq)
{
	// set the function logic
	if (how_vvvvwcq == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwcq Some function
function target_vvvvwcq_SomeFunc(target_vvvvwcq)
{
	// set the function logic
	if (target_vvvvwcq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcr function
function vvvvwcr(target_vvvvwcr,how_vvvvwcr)
{
	if (isSet(target_vvvvwcr) && target_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = target_vvvvwcr;
		var target_vvvvwcr = [];
		target_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(target_vvvvwcr))
	{
		var target_vvvvwcr = [];
	}
	var target = target_vvvvwcr.some(target_vvvvwcr_SomeFunc);

	if (isSet(how_vvvvwcr) && how_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = how_vvvvwcr;
		var how_vvvvwcr = [];
		how_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(how_vvvvwcr))
	{
		var how_vvvvwcr = [];
	}
	var how = how_vvvvwcr.some(how_vvvvwcr_SomeFunc);


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

// the vvvvwcr Some function
function target_vvvvwcr_SomeFunc(target_vvvvwcr)
{
	// set the function logic
	if (target_vvvvwcr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcr Some function
function how_vvvvwcr_SomeFunc(how_vvvvwcr)
{
	// set the function logic
	if (how_vvvvwcr == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwcs function
function vvvvwcs(how_vvvvwcs,target_vvvvwcs)
{
	if (isSet(how_vvvvwcs) && how_vvvvwcs.constructor !== Array)
	{
		var temp_vvvvwcs = how_vvvvwcs;
		var how_vvvvwcs = [];
		how_vvvvwcs.push(temp_vvvvwcs);
	}
	else if (!isSet(how_vvvvwcs))
	{
		var how_vvvvwcs = [];
	}
	var how = how_vvvvwcs.some(how_vvvvwcs_SomeFunc);

	if (isSet(target_vvvvwcs) && target_vvvvwcs.constructor !== Array)
	{
		var temp_vvvvwcs = target_vvvvwcs;
		var target_vvvvwcs = [];
		target_vvvvwcs.push(temp_vvvvwcs);
	}
	else if (!isSet(target_vvvvwcs))
	{
		var target_vvvvwcs = [];
	}
	var target = target_vvvvwcs.some(target_vvvvwcs_SomeFunc);


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

// the vvvvwcs Some function
function how_vvvvwcs_SomeFunc(how_vvvvwcs)
{
	// set the function logic
	if (how_vvvvwcs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcs Some function
function target_vvvvwcs_SomeFunc(target_vvvvwcs)
{
	// set the function logic
	if (target_vvvvwcs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwct function
function vvvvwct(target_vvvvwct,how_vvvvwct)
{
	if (isSet(target_vvvvwct) && target_vvvvwct.constructor !== Array)
	{
		var temp_vvvvwct = target_vvvvwct;
		var target_vvvvwct = [];
		target_vvvvwct.push(temp_vvvvwct);
	}
	else if (!isSet(target_vvvvwct))
	{
		var target_vvvvwct = [];
	}
	var target = target_vvvvwct.some(target_vvvvwct_SomeFunc);

	if (isSet(how_vvvvwct) && how_vvvvwct.constructor !== Array)
	{
		var temp_vvvvwct = how_vvvvwct;
		var how_vvvvwct = [];
		how_vvvvwct.push(temp_vvvvwct);
	}
	else if (!isSet(how_vvvvwct))
	{
		var how_vvvvwct = [];
	}
	var how = how_vvvvwct.some(how_vvvvwct_SomeFunc);


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

// the vvvvwct Some function
function target_vvvvwct_SomeFunc(target_vvvvwct)
{
	// set the function logic
	if (target_vvvvwct == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwct Some function
function how_vvvvwct_SomeFunc(how_vvvvwct)
{
	// set the function logic
	if (how_vvvvwct == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcu function
function vvvvwcu(how_vvvvwcu,target_vvvvwcu)
{
	if (isSet(how_vvvvwcu) && how_vvvvwcu.constructor !== Array)
	{
		var temp_vvvvwcu = how_vvvvwcu;
		var how_vvvvwcu = [];
		how_vvvvwcu.push(temp_vvvvwcu);
	}
	else if (!isSet(how_vvvvwcu))
	{
		var how_vvvvwcu = [];
	}
	var how = how_vvvvwcu.some(how_vvvvwcu_SomeFunc);

	if (isSet(target_vvvvwcu) && target_vvvvwcu.constructor !== Array)
	{
		var temp_vvvvwcu = target_vvvvwcu;
		var target_vvvvwcu = [];
		target_vvvvwcu.push(temp_vvvvwcu);
	}
	else if (!isSet(target_vvvvwcu))
	{
		var target_vvvvwcu = [];
	}
	var target = target_vvvvwcu.some(target_vvvvwcu_SomeFunc);


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

// the vvvvwcu Some function
function how_vvvvwcu_SomeFunc(how_vvvvwcu)
{
	// set the function logic
	if (how_vvvvwcu == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcu Some function
function target_vvvvwcu_SomeFunc(target_vvvvwcu)
{
	// set the function logic
	if (target_vvvvwcu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcv function
function vvvvwcv(target_vvvvwcv,how_vvvvwcv)
{
	if (isSet(target_vvvvwcv) && target_vvvvwcv.constructor !== Array)
	{
		var temp_vvvvwcv = target_vvvvwcv;
		var target_vvvvwcv = [];
		target_vvvvwcv.push(temp_vvvvwcv);
	}
	else if (!isSet(target_vvvvwcv))
	{
		var target_vvvvwcv = [];
	}
	var target = target_vvvvwcv.some(target_vvvvwcv_SomeFunc);

	if (isSet(how_vvvvwcv) && how_vvvvwcv.constructor !== Array)
	{
		var temp_vvvvwcv = how_vvvvwcv;
		var how_vvvvwcv = [];
		how_vvvvwcv.push(temp_vvvvwcv);
	}
	else if (!isSet(how_vvvvwcv))
	{
		var how_vvvvwcv = [];
	}
	var how = how_vvvvwcv.some(how_vvvvwcv_SomeFunc);


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

// the vvvvwcv Some function
function target_vvvvwcv_SomeFunc(target_vvvvwcv)
{
	// set the function logic
	if (target_vvvvwcv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcv Some function
function how_vvvvwcv_SomeFunc(how_vvvvwcv)
{
	// set the function logic
	if (how_vvvvwcv == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwcw function
function vvvvwcw(target_vvvvwcw,type_vvvvwcw)
{
	// set the function logic
	if (target_vvvvwcw == 1 && type_vvvvwcw == 2)
	{
		jQuery('#jform_libraries').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_libraries').closest('.control-group').hide();
	}
}

// the vvvvwcy function
function vvvvwcy(target_vvvvwcy)
{
	// set the function logic
	if (target_vvvvwcy == 1)
	{
		jQuery('#jform_how').closest('.control-group').show();
		// add required attribute to how field
		if (jform_vvvvwcyvxm_required)
		{
			updateFieldRequired('how',0);
			jQuery('#jform_how').prop('required','required');
			jQuery('#jform_how').attr('aria-required',true);
			jQuery('#jform_how').addClass('required');
			jform_vvvvwcyvxm_required = false;
		}
		jQuery('#jform_type').closest('.control-group').show();
		// add required attribute to type field
		if (jform_vvvvwcyvxn_required)
		{
			updateFieldRequired('type',0);
			jQuery('#jform_type').prop('required','required');
			jQuery('#jform_type').attr('aria-required',true);
			jQuery('#jform_type').addClass('required');
			jform_vvvvwcyvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_how').closest('.control-group').hide();
		// remove required attribute from how field
		if (!jform_vvvvwcyvxm_required)
		{
			updateFieldRequired('how',1);
			jQuery('#jform_how').removeAttr('required');
			jQuery('#jform_how').removeAttr('aria-required');
			jQuery('#jform_how').removeClass('required');
			jform_vvvvwcyvxm_required = true;
		}
		jQuery('#jform_type').closest('.control-group').hide();
		// remove required attribute from type field
		if (!jform_vvvvwcyvxn_required)
		{
			updateFieldRequired('type',1);
			jQuery('#jform_type').removeAttr('required');
			jQuery('#jform_type').removeAttr('aria-required');
			jQuery('#jform_type').removeClass('required');
			jform_vvvvwcyvxn_required = true;
		}
	}
}

// the vvvvwcz function
function vvvvwcz(target_vvvvwcz)
{
	// set the function logic
	if (target_vvvvwcz == 2)
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
	if (jQuery('#jform_not_required').length > 0) {
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
	if (token.length > 0 && id > 0 && type.length > 0) {
		url += '&' + token + '=1&' + type_name + '=' + type + '&id=' + id;
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

function getLinked(){
	getCodeFrom_server(1, 'type', 'type', 'getLinked').then(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
} 
