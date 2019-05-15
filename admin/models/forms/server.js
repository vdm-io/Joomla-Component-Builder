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
jform_vvvvwbnwaq_required = false;
jform_vvvvwbnwar_required = false;
jform_vvvvwbnwas_required = false;
jform_vvvvwbnwat_required = false;
jform_vvvvwbnwau_required = false;
jform_vvvvwbowav_required = false;
jform_vvvvwbpwaw_required = false;
jform_vvvvwbrwax_required = false;
jform_vvvvwbtway_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwbn = jQuery("#jform_protocol").val();
	vvvvwbn(protocol_vvvvwbn);

	var protocol_vvvvwbo = jQuery("#jform_protocol").val();
	vvvvwbo(protocol_vvvvwbo);

	var protocol_vvvvwbp = jQuery("#jform_protocol").val();
	var authentication_vvvvwbp = jQuery("#jform_authentication").val();
	vvvvwbp(protocol_vvvvwbp,authentication_vvvvwbp);

	var protocol_vvvvwbr = jQuery("#jform_protocol").val();
	var authentication_vvvvwbr = jQuery("#jform_authentication").val();
	vvvvwbr(protocol_vvvvwbr,authentication_vvvvwbr);

	var protocol_vvvvwbt = jQuery("#jform_protocol").val();
	var authentication_vvvvwbt = jQuery("#jform_authentication").val();
	vvvvwbt(protocol_vvvvwbt,authentication_vvvvwbt);

	var protocol_vvvvwbv = jQuery("#jform_protocol").val();
	var authentication_vvvvwbv = jQuery("#jform_authentication").val();
	vvvvwbv(protocol_vvvvwbv,authentication_vvvvwbv);
});

// the vvvvwbn function
function vvvvwbn(protocol_vvvvwbn)
{
	if (isSet(protocol_vvvvwbn) && protocol_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = protocol_vvvvwbn;
		var protocol_vvvvwbn = [];
		protocol_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(protocol_vvvvwbn))
	{
		var protocol_vvvvwbn = [];
	}
	var protocol = protocol_vvvvwbn.some(protocol_vvvvwbn_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwbnwaq_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwbnwaq_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwbnwar_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwbnwar_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwbnwas_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwbnwas_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwbnwat_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwbnwat_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwbnwau_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwbnwau_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwbnwaq_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwbnwaq_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwbnwar_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwbnwar_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwbnwas_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwbnwas_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwbnwat_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwbnwat_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwbnwau_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwbnwau_required = true;
		}
	}
}

// the vvvvwbn Some function
function protocol_vvvvwbn_SomeFunc(protocol_vvvvwbn)
{
	// set the function logic
	if (protocol_vvvvwbn == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbo function
function vvvvwbo(protocol_vvvvwbo)
{
	if (isSet(protocol_vvvvwbo) && protocol_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = protocol_vvvvwbo;
		var protocol_vvvvwbo = [];
		protocol_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(protocol_vvvvwbo))
	{
		var protocol_vvvvwbo = [];
	}
	var protocol = protocol_vvvvwbo.some(protocol_vvvvwbo_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwbowav_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwbowav_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwbowav_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwbowav_required = true;
		}
	}
}

// the vvvvwbo Some function
function protocol_vvvvwbo_SomeFunc(protocol_vvvvwbo)
{
	// set the function logic
	if (protocol_vvvvwbo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbp function
function vvvvwbp(protocol_vvvvwbp,authentication_vvvvwbp)
{
	if (isSet(protocol_vvvvwbp) && protocol_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = protocol_vvvvwbp;
		var protocol_vvvvwbp = [];
		protocol_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(protocol_vvvvwbp))
	{
		var protocol_vvvvwbp = [];
	}
	var protocol = protocol_vvvvwbp.some(protocol_vvvvwbp_SomeFunc);

	if (isSet(authentication_vvvvwbp) && authentication_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = authentication_vvvvwbp;
		var authentication_vvvvwbp = [];
		authentication_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(authentication_vvvvwbp))
	{
		var authentication_vvvvwbp = [];
	}
	var authentication = authentication_vvvvwbp.some(authentication_vvvvwbp_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwbpwaw_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwbpwaw_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwbpwaw_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwbpwaw_required = true;
		}
	}
}

// the vvvvwbp Some function
function protocol_vvvvwbp_SomeFunc(protocol_vvvvwbp)
{
	// set the function logic
	if (protocol_vvvvwbp == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbp Some function
function authentication_vvvvwbp_SomeFunc(authentication_vvvvwbp)
{
	// set the function logic
	if (authentication_vvvvwbp == 1 || authentication_vvvvwbp == 3 || authentication_vvvvwbp == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwbr function
function vvvvwbr(protocol_vvvvwbr,authentication_vvvvwbr)
{
	if (isSet(protocol_vvvvwbr) && protocol_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = protocol_vvvvwbr;
		var protocol_vvvvwbr = [];
		protocol_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(protocol_vvvvwbr))
	{
		var protocol_vvvvwbr = [];
	}
	var protocol = protocol_vvvvwbr.some(protocol_vvvvwbr_SomeFunc);

	if (isSet(authentication_vvvvwbr) && authentication_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = authentication_vvvvwbr;
		var authentication_vvvvwbr = [];
		authentication_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(authentication_vvvvwbr))
	{
		var authentication_vvvvwbr = [];
	}
	var authentication = authentication_vvvvwbr.some(authentication_vvvvwbr_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwbrwax_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwbrwax_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwbrwax_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwbrwax_required = true;
		}
	}
}

// the vvvvwbr Some function
function protocol_vvvvwbr_SomeFunc(protocol_vvvvwbr)
{
	// set the function logic
	if (protocol_vvvvwbr == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbr Some function
function authentication_vvvvwbr_SomeFunc(authentication_vvvvwbr)
{
	// set the function logic
	if (authentication_vvvvwbr == 2 || authentication_vvvvwbr == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbt function
function vvvvwbt(protocol_vvvvwbt,authentication_vvvvwbt)
{
	if (isSet(protocol_vvvvwbt) && protocol_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = protocol_vvvvwbt;
		var protocol_vvvvwbt = [];
		protocol_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(protocol_vvvvwbt))
	{
		var protocol_vvvvwbt = [];
	}
	var protocol = protocol_vvvvwbt.some(protocol_vvvvwbt_SomeFunc);

	if (isSet(authentication_vvvvwbt) && authentication_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = authentication_vvvvwbt;
		var authentication_vvvvwbt = [];
		authentication_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(authentication_vvvvwbt))
	{
		var authentication_vvvvwbt = [];
	}
	var authentication = authentication_vvvvwbt.some(authentication_vvvvwbt_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwbtway_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwbtway_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwbtway_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwbtway_required = true;
		}
	}
}

// the vvvvwbt Some function
function protocol_vvvvwbt_SomeFunc(protocol_vvvvwbt)
{
	// set the function logic
	if (protocol_vvvvwbt == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbt Some function
function authentication_vvvvwbt_SomeFunc(authentication_vvvvwbt)
{
	// set the function logic
	if (authentication_vvvvwbt == 4 || authentication_vvvvwbt == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwbv function
function vvvvwbv(protocol_vvvvwbv,authentication_vvvvwbv)
{
	if (isSet(protocol_vvvvwbv) && protocol_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = protocol_vvvvwbv;
		var protocol_vvvvwbv = [];
		protocol_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(protocol_vvvvwbv))
	{
		var protocol_vvvvwbv = [];
	}
	var protocol = protocol_vvvvwbv.some(protocol_vvvvwbv_SomeFunc);

	if (isSet(authentication_vvvvwbv) && authentication_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = authentication_vvvvwbv;
		var authentication_vvvvwbv = [];
		authentication_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(authentication_vvvvwbv))
	{
		var authentication_vvvvwbv = [];
	}
	var authentication = authentication_vvvvwbv.some(authentication_vvvvwbv_SomeFunc);


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

// the vvvvwbv Some function
function protocol_vvvvwbv_SomeFunc(protocol_vvvvwbv)
{
	// set the function logic
	if (protocol_vvvvwbv == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbv Some function
function authentication_vvvvwbv_SomeFunc(authentication_vvvvwbv)
{
	// set the function logic
	if (authentication_vvvvwbv == 2 || authentication_vvvvwbv == 3 || authentication_vvvvwbv == 4 || authentication_vvvvwbv == 5)
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
