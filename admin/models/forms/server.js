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
jform_vvvvwcpvxx_required = false;
jform_vvvvwcpvxy_required = false;
jform_vvvvwcpvxz_required = false;
jform_vvvvwcpvya_required = false;
jform_vvvvwcpvyb_required = false;
jform_vvvvwcqvyc_required = false;
jform_vvvvwcrvyd_required = false;
jform_vvvvwctvye_required = false;
jform_vvvvwcvvyf_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwcp = jQuery("#jform_protocol").val();
	vvvvwcp(protocol_vvvvwcp);

	var protocol_vvvvwcq = jQuery("#jform_protocol").val();
	vvvvwcq(protocol_vvvvwcq);

	var protocol_vvvvwcr = jQuery("#jform_protocol").val();
	var authentication_vvvvwcr = jQuery("#jform_authentication").val();
	vvvvwcr(protocol_vvvvwcr,authentication_vvvvwcr);

	var protocol_vvvvwct = jQuery("#jform_protocol").val();
	var authentication_vvvvwct = jQuery("#jform_authentication").val();
	vvvvwct(protocol_vvvvwct,authentication_vvvvwct);

	var protocol_vvvvwcv = jQuery("#jform_protocol").val();
	var authentication_vvvvwcv = jQuery("#jform_authentication").val();
	vvvvwcv(protocol_vvvvwcv,authentication_vvvvwcv);

	var protocol_vvvvwcx = jQuery("#jform_protocol").val();
	var authentication_vvvvwcx = jQuery("#jform_authentication").val();
	vvvvwcx(protocol_vvvvwcx,authentication_vvvvwcx);
});

// the vvvvwcp function
function vvvvwcp(protocol_vvvvwcp)
{
	if (isSet(protocol_vvvvwcp) && protocol_vvvvwcp.constructor !== Array)
	{
		var temp_vvvvwcp = protocol_vvvvwcp;
		var protocol_vvvvwcp = [];
		protocol_vvvvwcp.push(temp_vvvvwcp);
	}
	else if (!isSet(protocol_vvvvwcp))
	{
		var protocol_vvvvwcp = [];
	}
	var protocol = protocol_vvvvwcp.some(protocol_vvvvwcp_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwcpvxx_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwcpvxx_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwcpvxy_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwcpvxy_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwcpvxz_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwcpvxz_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwcpvya_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwcpvya_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwcpvyb_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwcpvyb_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwcpvxx_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwcpvxx_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwcpvxy_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwcpvxy_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwcpvxz_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwcpvxz_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwcpvya_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwcpvya_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwcpvyb_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwcpvyb_required = true;
		}
	}
}

// the vvvvwcp Some function
function protocol_vvvvwcp_SomeFunc(protocol_vvvvwcp)
{
	// set the function logic
	if (protocol_vvvvwcp == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcq function
function vvvvwcq(protocol_vvvvwcq)
{
	if (isSet(protocol_vvvvwcq) && protocol_vvvvwcq.constructor !== Array)
	{
		var temp_vvvvwcq = protocol_vvvvwcq;
		var protocol_vvvvwcq = [];
		protocol_vvvvwcq.push(temp_vvvvwcq);
	}
	else if (!isSet(protocol_vvvvwcq))
	{
		var protocol_vvvvwcq = [];
	}
	var protocol = protocol_vvvvwcq.some(protocol_vvvvwcq_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwcqvyc_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwcqvyc_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwcqvyc_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwcqvyc_required = true;
		}
	}
}

// the vvvvwcq Some function
function protocol_vvvvwcq_SomeFunc(protocol_vvvvwcq)
{
	// set the function logic
	if (protocol_vvvvwcq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcr function
function vvvvwcr(protocol_vvvvwcr,authentication_vvvvwcr)
{
	if (isSet(protocol_vvvvwcr) && protocol_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = protocol_vvvvwcr;
		var protocol_vvvvwcr = [];
		protocol_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(protocol_vvvvwcr))
	{
		var protocol_vvvvwcr = [];
	}
	var protocol = protocol_vvvvwcr.some(protocol_vvvvwcr_SomeFunc);

	if (isSet(authentication_vvvvwcr) && authentication_vvvvwcr.constructor !== Array)
	{
		var temp_vvvvwcr = authentication_vvvvwcr;
		var authentication_vvvvwcr = [];
		authentication_vvvvwcr.push(temp_vvvvwcr);
	}
	else if (!isSet(authentication_vvvvwcr))
	{
		var authentication_vvvvwcr = [];
	}
	var authentication = authentication_vvvvwcr.some(authentication_vvvvwcr_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwcrvyd_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwcrvyd_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwcrvyd_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwcrvyd_required = true;
		}
	}
}

// the vvvvwcr Some function
function protocol_vvvvwcr_SomeFunc(protocol_vvvvwcr)
{
	// set the function logic
	if (protocol_vvvvwcr == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcr Some function
function authentication_vvvvwcr_SomeFunc(authentication_vvvvwcr)
{
	// set the function logic
	if (authentication_vvvvwcr == 1 || authentication_vvvvwcr == 3 || authentication_vvvvwcr == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwct function
function vvvvwct(protocol_vvvvwct,authentication_vvvvwct)
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

	if (isSet(authentication_vvvvwct) && authentication_vvvvwct.constructor !== Array)
	{
		var temp_vvvvwct = authentication_vvvvwct;
		var authentication_vvvvwct = [];
		authentication_vvvvwct.push(temp_vvvvwct);
	}
	else if (!isSet(authentication_vvvvwct))
	{
		var authentication_vvvvwct = [];
	}
	var authentication = authentication_vvvvwct.some(authentication_vvvvwct_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwctvye_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwctvye_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwctvye_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwctvye_required = true;
		}
	}
}

// the vvvvwct Some function
function protocol_vvvvwct_SomeFunc(protocol_vvvvwct)
{
	// set the function logic
	if (protocol_vvvvwct == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwct Some function
function authentication_vvvvwct_SomeFunc(authentication_vvvvwct)
{
	// set the function logic
	if (authentication_vvvvwct == 2 || authentication_vvvvwct == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcv function
function vvvvwcv(protocol_vvvvwcv,authentication_vvvvwcv)
{
	if (isSet(protocol_vvvvwcv) && protocol_vvvvwcv.constructor !== Array)
	{
		var temp_vvvvwcv = protocol_vvvvwcv;
		var protocol_vvvvwcv = [];
		protocol_vvvvwcv.push(temp_vvvvwcv);
	}
	else if (!isSet(protocol_vvvvwcv))
	{
		var protocol_vvvvwcv = [];
	}
	var protocol = protocol_vvvvwcv.some(protocol_vvvvwcv_SomeFunc);

	if (isSet(authentication_vvvvwcv) && authentication_vvvvwcv.constructor !== Array)
	{
		var temp_vvvvwcv = authentication_vvvvwcv;
		var authentication_vvvvwcv = [];
		authentication_vvvvwcv.push(temp_vvvvwcv);
	}
	else if (!isSet(authentication_vvvvwcv))
	{
		var authentication_vvvvwcv = [];
	}
	var authentication = authentication_vvvvwcv.some(authentication_vvvvwcv_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwcvvyf_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwcvvyf_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwcvvyf_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwcvvyf_required = true;
		}
	}
}

// the vvvvwcv Some function
function protocol_vvvvwcv_SomeFunc(protocol_vvvvwcv)
{
	// set the function logic
	if (protocol_vvvvwcv == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcv Some function
function authentication_vvvvwcv_SomeFunc(authentication_vvvvwcv)
{
	// set the function logic
	if (authentication_vvvvwcv == 4 || authentication_vvvvwcv == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwcx function
function vvvvwcx(protocol_vvvvwcx,authentication_vvvvwcx)
{
	if (isSet(protocol_vvvvwcx) && protocol_vvvvwcx.constructor !== Array)
	{
		var temp_vvvvwcx = protocol_vvvvwcx;
		var protocol_vvvvwcx = [];
		protocol_vvvvwcx.push(temp_vvvvwcx);
	}
	else if (!isSet(protocol_vvvvwcx))
	{
		var protocol_vvvvwcx = [];
	}
	var protocol = protocol_vvvvwcx.some(protocol_vvvvwcx_SomeFunc);

	if (isSet(authentication_vvvvwcx) && authentication_vvvvwcx.constructor !== Array)
	{
		var temp_vvvvwcx = authentication_vvvvwcx;
		var authentication_vvvvwcx = [];
		authentication_vvvvwcx.push(temp_vvvvwcx);
	}
	else if (!isSet(authentication_vvvvwcx))
	{
		var authentication_vvvvwcx = [];
	}
	var authentication = authentication_vvvvwcx.some(authentication_vvvvwcx_SomeFunc);


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

// the vvvvwcx Some function
function protocol_vvvvwcx_SomeFunc(protocol_vvvvwcx)
{
	// set the function logic
	if (protocol_vvvvwcx == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcx Some function
function authentication_vvvvwcx_SomeFunc(authentication_vvvvwcx)
{
	// set the function logic
	if (authentication_vvvvwcx == 2 || authentication_vvvvwcx == 3 || authentication_vvvvwcx == 4 || authentication_vvvvwcx == 5)
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
