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
jform_vvvvwcsvxz_required = false;
jform_vvvvwcsvya_required = false;
jform_vvvvwcsvyb_required = false;
jform_vvvvwcsvyc_required = false;
jform_vvvvwcsvyd_required = false;
jform_vvvvwctvye_required = false;
jform_vvvvwcuvyf_required = false;
jform_vvvvwcwvyg_required = false;
jform_vvvvwcyvyh_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwcs = jQuery("#jform_protocol").val();
	vvvvwcs(protocol_vvvvwcs);

	var protocol_vvvvwct = jQuery("#jform_protocol").val();
	vvvvwct(protocol_vvvvwct);

	var protocol_vvvvwcu = jQuery("#jform_protocol").val();
	var authentication_vvvvwcu = jQuery("#jform_authentication").val();
	vvvvwcu(protocol_vvvvwcu,authentication_vvvvwcu);

	var protocol_vvvvwcw = jQuery("#jform_protocol").val();
	var authentication_vvvvwcw = jQuery("#jform_authentication").val();
	vvvvwcw(protocol_vvvvwcw,authentication_vvvvwcw);

	var protocol_vvvvwcy = jQuery("#jform_protocol").val();
	var authentication_vvvvwcy = jQuery("#jform_authentication").val();
	vvvvwcy(protocol_vvvvwcy,authentication_vvvvwcy);

	var protocol_vvvvwda = jQuery("#jform_protocol").val();
	var authentication_vvvvwda = jQuery("#jform_authentication").val();
	vvvvwda(protocol_vvvvwda,authentication_vvvvwda);
});

// the vvvvwcs function
function vvvvwcs(protocol_vvvvwcs)
{
	if (isSet(protocol_vvvvwcs) && protocol_vvvvwcs.constructor !== Array)
	{
		var temp_vvvvwcs = protocol_vvvvwcs;
		var protocol_vvvvwcs = [];
		protocol_vvvvwcs.push(temp_vvvvwcs);
	}
	else if (!isSet(protocol_vvvvwcs))
	{
		var protocol_vvvvwcs = [];
	}
	var protocol = protocol_vvvvwcs.some(protocol_vvvvwcs_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwcsvxz_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwcsvxz_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwcsvya_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwcsvya_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwcsvyb_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwcsvyb_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwcsvyc_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwcsvyc_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwcsvyd_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwcsvyd_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwcsvxz_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwcsvxz_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwcsvya_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwcsvya_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwcsvyb_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwcsvyb_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwcsvyc_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwcsvyc_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwcsvyd_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwcsvyd_required = true;
		}
	}
}

// the vvvvwcs Some function
function protocol_vvvvwcs_SomeFunc(protocol_vvvvwcs)
{
	// set the function logic
	if (protocol_vvvvwcs == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwct function
function vvvvwct(protocol_vvvvwct)
{
	if (isSet(protocol_vvvvwct) && protocol_vvvvwct.constructor !== Array)
	{
		var temp_vvvvwct = protocol_vvvvwct;
		var protocol_vvvvwct = [];
		protocol_vvvvwct.push(temp_vvvvwct);
	}
	else if (!isSet(protocol_vvvvwct))
	{
		var protocol_vvvvwct = [];
	}
	var protocol = protocol_vvvvwct.some(protocol_vvvvwct_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwctvye_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwctvye_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwctvye_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwctvye_required = true;
		}
	}
}

// the vvvvwct Some function
function protocol_vvvvwct_SomeFunc(protocol_vvvvwct)
{
	// set the function logic
	if (protocol_vvvvwct == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcu function
function vvvvwcu(protocol_vvvvwcu,authentication_vvvvwcu)
{
	if (isSet(protocol_vvvvwcu) && protocol_vvvvwcu.constructor !== Array)
	{
		var temp_vvvvwcu = protocol_vvvvwcu;
		var protocol_vvvvwcu = [];
		protocol_vvvvwcu.push(temp_vvvvwcu);
	}
	else if (!isSet(protocol_vvvvwcu))
	{
		var protocol_vvvvwcu = [];
	}
	var protocol = protocol_vvvvwcu.some(protocol_vvvvwcu_SomeFunc);

	if (isSet(authentication_vvvvwcu) && authentication_vvvvwcu.constructor !== Array)
	{
		var temp_vvvvwcu = authentication_vvvvwcu;
		var authentication_vvvvwcu = [];
		authentication_vvvvwcu.push(temp_vvvvwcu);
	}
	else if (!isSet(authentication_vvvvwcu))
	{
		var authentication_vvvvwcu = [];
	}
	var authentication = authentication_vvvvwcu.some(authentication_vvvvwcu_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwcuvyf_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwcuvyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwcuvyf_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwcuvyf_required = true;
		}
	}
}

// the vvvvwcu Some function
function protocol_vvvvwcu_SomeFunc(protocol_vvvvwcu)
{
	// set the function logic
	if (protocol_vvvvwcu == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcu Some function
function authentication_vvvvwcu_SomeFunc(authentication_vvvvwcu)
{
	// set the function logic
	if (authentication_vvvvwcu == 1 || authentication_vvvvwcu == 3 || authentication_vvvvwcu == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwcw function
function vvvvwcw(protocol_vvvvwcw,authentication_vvvvwcw)
{
	if (isSet(protocol_vvvvwcw) && protocol_vvvvwcw.constructor !== Array)
	{
		var temp_vvvvwcw = protocol_vvvvwcw;
		var protocol_vvvvwcw = [];
		protocol_vvvvwcw.push(temp_vvvvwcw);
	}
	else if (!isSet(protocol_vvvvwcw))
	{
		var protocol_vvvvwcw = [];
	}
	var protocol = protocol_vvvvwcw.some(protocol_vvvvwcw_SomeFunc);

	if (isSet(authentication_vvvvwcw) && authentication_vvvvwcw.constructor !== Array)
	{
		var temp_vvvvwcw = authentication_vvvvwcw;
		var authentication_vvvvwcw = [];
		authentication_vvvvwcw.push(temp_vvvvwcw);
	}
	else if (!isSet(authentication_vvvvwcw))
	{
		var authentication_vvvvwcw = [];
	}
	var authentication = authentication_vvvvwcw.some(authentication_vvvvwcw_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwcwvyg_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwcwvyg_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwcwvyg_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwcwvyg_required = true;
		}
	}
}

// the vvvvwcw Some function
function protocol_vvvvwcw_SomeFunc(protocol_vvvvwcw)
{
	// set the function logic
	if (protocol_vvvvwcw == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcw Some function
function authentication_vvvvwcw_SomeFunc(authentication_vvvvwcw)
{
	// set the function logic
	if (authentication_vvvvwcw == 2 || authentication_vvvvwcw == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcy function
function vvvvwcy(protocol_vvvvwcy,authentication_vvvvwcy)
{
	if (isSet(protocol_vvvvwcy) && protocol_vvvvwcy.constructor !== Array)
	{
		var temp_vvvvwcy = protocol_vvvvwcy;
		var protocol_vvvvwcy = [];
		protocol_vvvvwcy.push(temp_vvvvwcy);
	}
	else if (!isSet(protocol_vvvvwcy))
	{
		var protocol_vvvvwcy = [];
	}
	var protocol = protocol_vvvvwcy.some(protocol_vvvvwcy_SomeFunc);

	if (isSet(authentication_vvvvwcy) && authentication_vvvvwcy.constructor !== Array)
	{
		var temp_vvvvwcy = authentication_vvvvwcy;
		var authentication_vvvvwcy = [];
		authentication_vvvvwcy.push(temp_vvvvwcy);
	}
	else if (!isSet(authentication_vvvvwcy))
	{
		var authentication_vvvvwcy = [];
	}
	var authentication = authentication_vvvvwcy.some(authentication_vvvvwcy_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwcyvyh_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwcyvyh_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwcyvyh_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwcyvyh_required = true;
		}
	}
}

// the vvvvwcy Some function
function protocol_vvvvwcy_SomeFunc(protocol_vvvvwcy)
{
	// set the function logic
	if (protocol_vvvvwcy == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcy Some function
function authentication_vvvvwcy_SomeFunc(authentication_vvvvwcy)
{
	// set the function logic
	if (authentication_vvvvwcy == 4 || authentication_vvvvwcy == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwda function
function vvvvwda(protocol_vvvvwda,authentication_vvvvwda)
{
	if (isSet(protocol_vvvvwda) && protocol_vvvvwda.constructor !== Array)
	{
		var temp_vvvvwda = protocol_vvvvwda;
		var protocol_vvvvwda = [];
		protocol_vvvvwda.push(temp_vvvvwda);
	}
	else if (!isSet(protocol_vvvvwda))
	{
		var protocol_vvvvwda = [];
	}
	var protocol = protocol_vvvvwda.some(protocol_vvvvwda_SomeFunc);

	if (isSet(authentication_vvvvwda) && authentication_vvvvwda.constructor !== Array)
	{
		var temp_vvvvwda = authentication_vvvvwda;
		var authentication_vvvvwda = [];
		authentication_vvvvwda.push(temp_vvvvwda);
	}
	else if (!isSet(authentication_vvvvwda))
	{
		var authentication_vvvvwda = [];
	}
	var authentication = authentication_vvvvwda.some(authentication_vvvvwda_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_secret').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_secret').closest('.control-group').hide();
	}
}

// the vvvvwda Some function
function protocol_vvvvwda_SomeFunc(protocol_vvvvwda)
{
	// set the function logic
	if (protocol_vvvvwda == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwda Some function
function authentication_vvvvwda_SomeFunc(authentication_vvvvwda)
{
	// set the function logic
	if (authentication_vvvvwda == 2 || authentication_vvvvwda == 3 || authentication_vvvvwda == 4 || authentication_vvvvwda == 5)
	{
		return true;
	}
	return false;
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
