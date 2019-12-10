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
jform_vvvvwcjvxn_required = false;
jform_vvvvwcvvxo_required = false;
jform_vvvvwcxvxp_required = false;
jform_vvvvwcxvxq_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var how_vvvvwch = jQuery("#jform_how").val();
	var target_vvvvwch = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwch(how_vvvvwch,target_vvvvwch);

	var how_vvvvwcj = jQuery("#jform_how").val();
	var target_vvvvwcj = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcj(how_vvvvwcj,target_vvvvwcj);

	var how_vvvvwcl = jQuery("#jform_how").val();
	var target_vvvvwcl = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcl(how_vvvvwcl,target_vvvvwcl);

	var how_vvvvwcn = jQuery("#jform_how").val();
	var target_vvvvwcn = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcn(how_vvvvwcn,target_vvvvwcn);

	var how_vvvvwcp = jQuery("#jform_how").val();
	var target_vvvvwcp = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcp(how_vvvvwcp,target_vvvvwcp);

	var target_vvvvwcq = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcq = jQuery("#jform_how").val();
	vvvvwcq(target_vvvvwcq,how_vvvvwcq);

	var how_vvvvwcr = jQuery("#jform_how").val();
	var target_vvvvwcr = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcr(how_vvvvwcr,target_vvvvwcr);

	var target_vvvvwcs = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcs = jQuery("#jform_how").val();
	vvvvwcs(target_vvvvwcs,how_vvvvwcs);

	var how_vvvvwct = jQuery("#jform_how").val();
	var target_vvvvwct = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwct(how_vvvvwct,target_vvvvwct);

	var target_vvvvwcu = jQuery("#jform_target input[type='radio']:checked").val();
	var how_vvvvwcu = jQuery("#jform_how").val();
	vvvvwcu(target_vvvvwcu,how_vvvvwcu);

	var target_vvvvwcv = jQuery("#jform_target input[type='radio']:checked").val();
	var type_vvvvwcv = jQuery("#jform_type input[type='radio']:checked").val();
	vvvvwcv(target_vvvvwcv,type_vvvvwcv);

	var target_vvvvwcx = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcx(target_vvvvwcx);

	var target_vvvvwcy = jQuery("#jform_target input[type='radio']:checked").val();
	vvvvwcy(target_vvvvwcy);
});

// the vvvvwch function
function vvvvwch(how_vvvvwch,target_vvvvwch)
{
	if (isSet(how_vvvvwch) && how_vvvvwch.constructor !== Array)
	{
		var temp_vvvvwch = how_vvvvwch;
		var how_vvvvwch = [];
		how_vvvvwch.push(temp_vvvvwch);
	}
	else if (!isSet(how_vvvvwch))
	{
		var how_vvvvwch = [];
	}
	var how = how_vvvvwch.some(how_vvvvwch_SomeFunc);

	if (isSet(target_vvvvwch) && target_vvvvwch.constructor !== Array)
	{
		var temp_vvvvwch = target_vvvvwch;
		var target_vvvvwch = [];
		target_vvvvwch.push(temp_vvvvwch);
	}
	else if (!isSet(target_vvvvwch))
	{
		var target_vvvvwch = [];
	}
	var target = target_vvvvwch.some(target_vvvvwch_SomeFunc);


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

// the vvvvwch Some function
function how_vvvvwch_SomeFunc(how_vvvvwch)
{
	// set the function logic
	if (how_vvvvwch == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwch Some function
function target_vvvvwch_SomeFunc(target_vvvvwch)
{
	// set the function logic
	if (target_vvvvwch == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcj function
function vvvvwcj(how_vvvvwcj,target_vvvvwcj)
{
	if (isSet(how_vvvvwcj) && how_vvvvwcj.constructor !== Array)
	{
		var temp_vvvvwcj = how_vvvvwcj;
		var how_vvvvwcj = [];
		how_vvvvwcj.push(temp_vvvvwcj);
	}
	else if (!isSet(how_vvvvwcj))
	{
		var how_vvvvwcj = [];
	}
	var how = how_vvvvwcj.some(how_vvvvwcj_SomeFunc);

	if (isSet(target_vvvvwcj) && target_vvvvwcj.constructor !== Array)
	{
		var temp_vvvvwcj = target_vvvvwcj;
		var target_vvvvwcj = [];
		target_vvvvwcj.push(temp_vvvvwcj);
	}
	else if (!isSet(target_vvvvwcj))
	{
		var target_vvvvwcj = [];
	}
	var target = target_vvvvwcj.some(target_vvvvwcj_SomeFunc);


	// set this function logic
	if (how && target)
	{
		jQuery('#jform_php_setdocument').closest('.control-group').show();
		// add required attribute to php_setdocument field
		if (jform_vvvvwcjvxn_required)
		{
			updateFieldRequired('php_setdocument',0);
			jQuery('#jform_php_setdocument').prop('required','required');
			jQuery('#jform_php_setdocument').attr('aria-required',true);
			jQuery('#jform_php_setdocument').addClass('required');
			jform_vvvvwcjvxn_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_setdocument').closest('.control-group').hide();
		// remove required attribute from php_setdocument field
		if (!jform_vvvvwcjvxn_required)
		{
			updateFieldRequired('php_setdocument',1);
			jQuery('#jform_php_setdocument').removeAttr('required');
			jQuery('#jform_php_setdocument').removeAttr('aria-required');
			jQuery('#jform_php_setdocument').removeClass('required');
			jform_vvvvwcjvxn_required = true;
		}
	}
}

// the vvvvwcj Some function
function how_vvvvwcj_SomeFunc(how_vvvvwcj)
{
	// set the function logic
	if (how_vvvvwcj == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcj Some function
function target_vvvvwcj_SomeFunc(target_vvvvwcj)
{
	// set the function logic
	if (target_vvvvwcj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcl function
function vvvvwcl(how_vvvvwcl,target_vvvvwcl)
{
	if (isSet(how_vvvvwcl) && how_vvvvwcl.constructor !== Array)
	{
		var temp_vvvvwcl = how_vvvvwcl;
		var how_vvvvwcl = [];
		how_vvvvwcl.push(temp_vvvvwcl);
	}
	else if (!isSet(how_vvvvwcl))
	{
		var how_vvvvwcl = [];
	}
	var how = how_vvvvwcl.some(how_vvvvwcl_SomeFunc);

	if (isSet(target_vvvvwcl) && target_vvvvwcl.constructor !== Array)
	{
		var temp_vvvvwcl = target_vvvvwcl;
		var target_vvvvwcl = [];
		target_vvvvwcl.push(temp_vvvvwcl);
	}
	else if (!isSet(target_vvvvwcl))
	{
		var target_vvvvwcl = [];
	}
	var target = target_vvvvwcl.some(target_vvvvwcl_SomeFunc);


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

// the vvvvwcl Some function
function how_vvvvwcl_SomeFunc(how_vvvvwcl)
{
	// set the function logic
	if (how_vvvvwcl == 2 || how_vvvvwcl == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcl Some function
function target_vvvvwcl_SomeFunc(target_vvvvwcl)
{
	// set the function logic
	if (target_vvvvwcl == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcn function
function vvvvwcn(how_vvvvwcn,target_vvvvwcn)
{
	if (isSet(how_vvvvwcn) && how_vvvvwcn.constructor !== Array)
	{
		var temp_vvvvwcn = how_vvvvwcn;
		var how_vvvvwcn = [];
		how_vvvvwcn.push(temp_vvvvwcn);
	}
	else if (!isSet(how_vvvvwcn))
	{
		var how_vvvvwcn = [];
	}
	var how = how_vvvvwcn.some(how_vvvvwcn_SomeFunc);

	if (isSet(target_vvvvwcn) && target_vvvvwcn.constructor !== Array)
	{
		var temp_vvvvwcn = target_vvvvwcn;
		var target_vvvvwcn = [];
		target_vvvvwcn.push(temp_vvvvwcn);
	}
	else if (!isSet(target_vvvvwcn))
	{
		var target_vvvvwcn = [];
	}
	var target = target_vvvvwcn.some(target_vvvvwcn_SomeFunc);


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

// the vvvvwcn Some function
function how_vvvvwcn_SomeFunc(how_vvvvwcn)
{
	// set the function logic
	if (how_vvvvwcn == 1 || how_vvvvwcn == 2 || how_vvvvwcn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcn Some function
function target_vvvvwcn_SomeFunc(target_vvvvwcn)
{
	// set the function logic
	if (target_vvvvwcn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcp function
function vvvvwcp(how_vvvvwcp,target_vvvvwcp)
{
	if (isSet(how_vvvvwcp) && how_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = how_vvvvwcp;
		var how_vvvvwcp = [];
		how_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(how_vvvvwcp))
	{
		var how_vvvvwcp = [];
	}
	var how = how_vvvvwcp.some(how_vvvvwcp_SomeFunc);

	if (isSet(target_vvvvwcp) && target_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = target_vvvvwcp;
		var target_vvvvwcp = [];
		target_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(target_vvvvwcp))
	{
		var target_vvvvwcp = [];
	}
	var target = target_vvvvwcp.some(target_vvvvwcp_SomeFunc);


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

// the vvvvwcp Some function
function how_vvvvwcp_SomeFunc(how_vvvvwcp)
{
	// set the function logic
	if (how_vvvvwcp == 0)
	{
		return true;
	}
	return false;
}

// the vvvvwcp Some function
function target_vvvvwcp_SomeFunc(target_vvvvwcp)
{
	// set the function logic
	if (target_vvvvwcp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcq function
function vvvvwcq(target_vvvvwcq,how_vvvvwcq)
{
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

// the vvvvwcr function
function vvvvwcr(how_vvvvwcr,target_vvvvwcr)
{
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

// the vvvvwcr Some function
function how_vvvvwcr_SomeFunc(how_vvvvwcr)
{
	// set the function logic
	if (how_vvvvwcr == 1)
	{
		return true;
	}
	return false;
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

// the vvvvwcs function
function vvvvwcs(target_vvvvwcs,how_vvvvwcs)
{
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

// the vvvvwct function
function vvvvwct(how_vvvvwct,target_vvvvwct)
{
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

// the vvvvwct Some function
function how_vvvvwct_SomeFunc(how_vvvvwct)
{
	// set the function logic
	if (how_vvvvwct == 4)
	{
		return true;
	}
	return false;
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

// the vvvvwcu function
function vvvvwcu(target_vvvvwcu,how_vvvvwcu)
{
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

// the vvvvwcv function
function vvvvwcv(target_vvvvwcv,type_vvvvwcv)
{
	// set the function logic
	if (target_vvvvwcv == 1 && type_vvvvwcv == 2)
	{
		jQuery('#jform_libraries').closest('.control-group').show();
		// add required attribute to libraries field
		if (jform_vvvvwcvvxo_required)
		{
			updateFieldRequired('libraries',0);
			jQuery('#jform_libraries').prop('required','required');
			jQuery('#jform_libraries').attr('aria-required',true);
			jQuery('#jform_libraries').addClass('required');
			jform_vvvvwcvvxo_required = false;
		}
	}
	else
	{
		jQuery('#jform_libraries').closest('.control-group').hide();
		// remove required attribute from libraries field
		if (!jform_vvvvwcvvxo_required)
		{
			updateFieldRequired('libraries',1);
			jQuery('#jform_libraries').removeAttr('required');
			jQuery('#jform_libraries').removeAttr('aria-required');
			jQuery('#jform_libraries').removeClass('required');
			jform_vvvvwcvvxo_required = true;
		}
	}
}

// the vvvvwcx function
function vvvvwcx(target_vvvvwcx)
{
	// set the function logic
	if (target_vvvvwcx == 1)
	{
		jQuery('#jform_how').closest('.control-group').show();
		// add required attribute to how field
		if (jform_vvvvwcxvxp_required)
		{
			updateFieldRequired('how',0);
			jQuery('#jform_how').prop('required','required');
			jQuery('#jform_how').attr('aria-required',true);
			jQuery('#jform_how').addClass('required');
			jform_vvvvwcxvxp_required = false;
		}
		jQuery('#jform_type').closest('.control-group').show();
		// add required attribute to type field
		if (jform_vvvvwcxvxq_required)
		{
			updateFieldRequired('type',0);
			jQuery('#jform_type').prop('required','required');
			jQuery('#jform_type').attr('aria-required',true);
			jQuery('#jform_type').addClass('required');
			jform_vvvvwcxvxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_how').closest('.control-group').hide();
		// remove required attribute from how field
		if (!jform_vvvvwcxvxp_required)
		{
			updateFieldRequired('how',1);
			jQuery('#jform_how').removeAttr('required');
			jQuery('#jform_how').removeAttr('aria-required');
			jQuery('#jform_how').removeClass('required');
			jform_vvvvwcxvxp_required = true;
		}
		jQuery('#jform_type').closest('.control-group').hide();
		// remove required attribute from type field
		if (!jform_vvvvwcxvxq_required)
		{
			updateFieldRequired('type',1);
			jQuery('#jform_type').removeAttr('required');
			jQuery('#jform_type').removeAttr('aria-required');
			jQuery('#jform_type').removeClass('required');
			jform_vvvvwcxvxq_required = true;
		}
	}
}

// the vvvvwcy function
function vvvvwcy(target_vvvvwcy)
{
	// set the function logic
	if (target_vvvvwcy == 2)
	{
		jQuery('.note_yes_behaviour_library').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_yes_behaviour_library').closest('.control-group').hide();
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
	getCodeFrom_server(1, type, 'type', 'getAjaxDisplay').done(function(result) {
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
		getCodeFrom_server(fieldId, 'type', 'type', 'fieldSelectOptions').done(function(result) {
			if(result) {
				jQuery('textarea#jform_addconditions__addconditions'+fieldKey+'__field_options').val(result);
			} else {
				jQuery('textarea#jform_addconditions__addconditions'+fieldKey+'__field_options').val('');
			}
		});
	}
}

function getCodeFrom_server(id, type, type_name, callingName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax." + callingName + "&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0 && type.length > 0) {
		var request = token + '=1&' + type_name + '=' + type + '&id=' + id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
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
	getCodeFrom_server(1, 'type', 'type', 'getLinked').done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
} 
