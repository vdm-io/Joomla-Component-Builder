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
jform_vvvvwbtvxt_required = false;
jform_vvvvwbtvxu_required = false;
jform_vvvvwbtvxv_required = false;
jform_vvvvwbtvxw_required = false;
jform_vvvvwbtvxx_required = false;
jform_vvvvwbuvxy_required = false;
jform_vvvvwbvvxz_required = false;
jform_vvvvwbxvya_required = false;
jform_vvvvwbzvyb_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwbt = jQuery("#jform_protocol").val();
	vvvvwbt(protocol_vvvvwbt);

	var protocol_vvvvwbu = jQuery("#jform_protocol").val();
	vvvvwbu(protocol_vvvvwbu);

	var protocol_vvvvwbv = jQuery("#jform_protocol").val();
	var authentication_vvvvwbv = jQuery("#jform_authentication").val();
	vvvvwbv(protocol_vvvvwbv,authentication_vvvvwbv);

	var protocol_vvvvwbx = jQuery("#jform_protocol").val();
	var authentication_vvvvwbx = jQuery("#jform_authentication").val();
	vvvvwbx(protocol_vvvvwbx,authentication_vvvvwbx);

	var protocol_vvvvwbz = jQuery("#jform_protocol").val();
	var authentication_vvvvwbz = jQuery("#jform_authentication").val();
	vvvvwbz(protocol_vvvvwbz,authentication_vvvvwbz);

	var protocol_vvvvwcb = jQuery("#jform_protocol").val();
	var authentication_vvvvwcb = jQuery("#jform_authentication").val();
	vvvvwcb(protocol_vvvvwcb,authentication_vvvvwcb);
});

// the vvvvwbt function
function vvvvwbt(protocol_vvvvwbt)
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


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwbtvxt_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwbtvxt_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwbtvxu_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwbtvxu_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwbtvxv_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwbtvxv_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwbtvxw_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwbtvxw_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwbtvxx_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwbtvxx_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwbtvxt_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwbtvxt_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwbtvxu_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwbtvxu_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwbtvxv_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwbtvxv_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwbtvxw_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwbtvxw_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwbtvxx_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwbtvxx_required = true;
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

// the vvvvwbu function
function vvvvwbu(protocol_vvvvwbu)
{
	if (isSet(protocol_vvvvwbu) && protocol_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = protocol_vvvvwbu;
		var protocol_vvvvwbu = [];
		protocol_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(protocol_vvvvwbu))
	{
		var protocol_vvvvwbu = [];
	}
	var protocol = protocol_vvvvwbu.some(protocol_vvvvwbu_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwbuvxy_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwbuvxy_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwbuvxy_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwbuvxy_required = true;
		}
	}
}

// the vvvvwbu Some function
function protocol_vvvvwbu_SomeFunc(protocol_vvvvwbu)
{
	// set the function logic
	if (protocol_vvvvwbu == 1)
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
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwbvvxz_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwbvvxz_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwbvvxz_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwbvvxz_required = true;
		}
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
	if (authentication_vvvvwbv == 1 || authentication_vvvvwbv == 3 || authentication_vvvvwbv == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwbx function
function vvvvwbx(protocol_vvvvwbx,authentication_vvvvwbx)
{
	if (isSet(protocol_vvvvwbx) && protocol_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = protocol_vvvvwbx;
		var protocol_vvvvwbx = [];
		protocol_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(protocol_vvvvwbx))
	{
		var protocol_vvvvwbx = [];
	}
	var protocol = protocol_vvvvwbx.some(protocol_vvvvwbx_SomeFunc);

	if (isSet(authentication_vvvvwbx) && authentication_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = authentication_vvvvwbx;
		var authentication_vvvvwbx = [];
		authentication_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(authentication_vvvvwbx))
	{
		var authentication_vvvvwbx = [];
	}
	var authentication = authentication_vvvvwbx.some(authentication_vvvvwbx_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwbxvya_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwbxvya_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwbxvya_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwbxvya_required = true;
		}
	}
}

// the vvvvwbx Some function
function protocol_vvvvwbx_SomeFunc(protocol_vvvvwbx)
{
	// set the function logic
	if (protocol_vvvvwbx == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbx Some function
function authentication_vvvvwbx_SomeFunc(authentication_vvvvwbx)
{
	// set the function logic
	if (authentication_vvvvwbx == 2 || authentication_vvvvwbx == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbz function
function vvvvwbz(protocol_vvvvwbz,authentication_vvvvwbz)
{
	if (isSet(protocol_vvvvwbz) && protocol_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = protocol_vvvvwbz;
		var protocol_vvvvwbz = [];
		protocol_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(protocol_vvvvwbz))
	{
		var protocol_vvvvwbz = [];
	}
	var protocol = protocol_vvvvwbz.some(protocol_vvvvwbz_SomeFunc);

	if (isSet(authentication_vvvvwbz) && authentication_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = authentication_vvvvwbz;
		var authentication_vvvvwbz = [];
		authentication_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(authentication_vvvvwbz))
	{
		var authentication_vvvvwbz = [];
	}
	var authentication = authentication_vvvvwbz.some(authentication_vvvvwbz_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwbzvyb_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwbzvyb_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwbzvyb_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwbzvyb_required = true;
		}
	}
}

// the vvvvwbz Some function
function protocol_vvvvwbz_SomeFunc(protocol_vvvvwbz)
{
	// set the function logic
	if (protocol_vvvvwbz == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbz Some function
function authentication_vvvvwbz_SomeFunc(authentication_vvvvwbz)
{
	// set the function logic
	if (authentication_vvvvwbz == 4 || authentication_vvvvwbz == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwcb function
function vvvvwcb(protocol_vvvvwcb,authentication_vvvvwcb)
{
	if (isSet(protocol_vvvvwcb) && protocol_vvvvwcb.constructor !== Array)
	{
		var temp_vvvvwcb = protocol_vvvvwcb;
		var protocol_vvvvwcb = [];
		protocol_vvvvwcb.push(temp_vvvvwcb);
	}
	else if (!isSet(protocol_vvvvwcb))
	{
		var protocol_vvvvwcb = [];
	}
	var protocol = protocol_vvvvwcb.some(protocol_vvvvwcb_SomeFunc);

	if (isSet(authentication_vvvvwcb) && authentication_vvvvwcb.constructor !== Array)
	{
		var temp_vvvvwcb = authentication_vvvvwcb;
		var authentication_vvvvwcb = [];
		authentication_vvvvwcb.push(temp_vvvvwcb);
	}
	else if (!isSet(authentication_vvvvwcb))
	{
		var authentication_vvvvwcb = [];
	}
	var authentication = authentication_vvvvwcb.some(authentication_vvvvwcb_SomeFunc);


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

// the vvvvwcb Some function
function protocol_vvvvwcb_SomeFunc(protocol_vvvvwcb)
{
	// set the function logic
	if (protocol_vvvvwcb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcb Some function
function authentication_vvvvwcb_SomeFunc(authentication_vvvvwcb)
{
	// set the function logic
	if (authentication_vvvvwcb == 2 || authentication_vvvvwcb == 3 || authentication_vvvvwcb == 4 || authentication_vvvvwcb == 5)
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
