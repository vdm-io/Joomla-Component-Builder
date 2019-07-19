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
jform_vvvvwbwvxu_required = false;
jform_vvvvwbwvxv_required = false;
jform_vvvvwbwvxw_required = false;
jform_vvvvwbwvxx_required = false;
jform_vvvvwbwvxy_required = false;
jform_vvvvwbxvxz_required = false;
jform_vvvvwbyvya_required = false;
jform_vvvvwcavyb_required = false;
jform_vvvvwccvyc_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwbw = jQuery("#jform_protocol").val();
	vvvvwbw(protocol_vvvvwbw);

	var protocol_vvvvwbx = jQuery("#jform_protocol").val();
	vvvvwbx(protocol_vvvvwbx);

	var protocol_vvvvwby = jQuery("#jform_protocol").val();
	var authentication_vvvvwby = jQuery("#jform_authentication").val();
	vvvvwby(protocol_vvvvwby,authentication_vvvvwby);

	var protocol_vvvvwca = jQuery("#jform_protocol").val();
	var authentication_vvvvwca = jQuery("#jform_authentication").val();
	vvvvwca(protocol_vvvvwca,authentication_vvvvwca);

	var protocol_vvvvwcc = jQuery("#jform_protocol").val();
	var authentication_vvvvwcc = jQuery("#jform_authentication").val();
	vvvvwcc(protocol_vvvvwcc,authentication_vvvvwcc);

	var protocol_vvvvwce = jQuery("#jform_protocol").val();
	var authentication_vvvvwce = jQuery("#jform_authentication").val();
	vvvvwce(protocol_vvvvwce,authentication_vvvvwce);
});

// the vvvvwbw function
function vvvvwbw(protocol_vvvvwbw)
{
	if (isSet(protocol_vvvvwbw) && protocol_vvvvwbw.constructor !== Array)
	{
		var temp_vvvvwbw = protocol_vvvvwbw;
		var protocol_vvvvwbw = [];
		protocol_vvvvwbw.push(temp_vvvvwbw);
	}
	else if (!isSet(protocol_vvvvwbw))
	{
		var protocol_vvvvwbw = [];
	}
	var protocol = protocol_vvvvwbw.some(protocol_vvvvwbw_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwbwvxu_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwbwvxu_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwbwvxv_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwbwvxv_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwbwvxw_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwbwvxw_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwbwvxx_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwbwvxx_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwbwvxy_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwbwvxy_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwbwvxu_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwbwvxu_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwbwvxv_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwbwvxv_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwbwvxw_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwbwvxw_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwbwvxx_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwbwvxx_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwbwvxy_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwbwvxy_required = true;
		}
	}
}

// the vvvvwbw Some function
function protocol_vvvvwbw_SomeFunc(protocol_vvvvwbw)
{
	// set the function logic
	if (protocol_vvvvwbw == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbx function
function vvvvwbx(protocol_vvvvwbx)
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


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwbxvxz_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwbxvxz_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwbxvxz_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwbxvxz_required = true;
		}
	}
}

// the vvvvwbx Some function
function protocol_vvvvwbx_SomeFunc(protocol_vvvvwbx)
{
	// set the function logic
	if (protocol_vvvvwbx == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwby function
function vvvvwby(protocol_vvvvwby,authentication_vvvvwby)
{
	if (isSet(protocol_vvvvwby) && protocol_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = protocol_vvvvwby;
		var protocol_vvvvwby = [];
		protocol_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(protocol_vvvvwby))
	{
		var protocol_vvvvwby = [];
	}
	var protocol = protocol_vvvvwby.some(protocol_vvvvwby_SomeFunc);

	if (isSet(authentication_vvvvwby) && authentication_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = authentication_vvvvwby;
		var authentication_vvvvwby = [];
		authentication_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(authentication_vvvvwby))
	{
		var authentication_vvvvwby = [];
	}
	var authentication = authentication_vvvvwby.some(authentication_vvvvwby_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwbyvya_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwbyvya_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwbyvya_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwbyvya_required = true;
		}
	}
}

// the vvvvwby Some function
function protocol_vvvvwby_SomeFunc(protocol_vvvvwby)
{
	// set the function logic
	if (protocol_vvvvwby == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwby Some function
function authentication_vvvvwby_SomeFunc(authentication_vvvvwby)
{
	// set the function logic
	if (authentication_vvvvwby == 1 || authentication_vvvvwby == 3 || authentication_vvvvwby == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwca function
function vvvvwca(protocol_vvvvwca,authentication_vvvvwca)
{
	if (isSet(protocol_vvvvwca) && protocol_vvvvwca.constructor !== Array)
	{
		var temp_vvvvwca = protocol_vvvvwca;
		var protocol_vvvvwca = [];
		protocol_vvvvwca.push(temp_vvvvwca);
	}
	else if (!isSet(protocol_vvvvwca))
	{
		var protocol_vvvvwca = [];
	}
	var protocol = protocol_vvvvwca.some(protocol_vvvvwca_SomeFunc);

	if (isSet(authentication_vvvvwca) && authentication_vvvvwca.constructor !== Array)
	{
		var temp_vvvvwca = authentication_vvvvwca;
		var authentication_vvvvwca = [];
		authentication_vvvvwca.push(temp_vvvvwca);
	}
	else if (!isSet(authentication_vvvvwca))
	{
		var authentication_vvvvwca = [];
	}
	var authentication = authentication_vvvvwca.some(authentication_vvvvwca_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwcavyb_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwcavyb_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwcavyb_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwcavyb_required = true;
		}
	}
}

// the vvvvwca Some function
function protocol_vvvvwca_SomeFunc(protocol_vvvvwca)
{
	// set the function logic
	if (protocol_vvvvwca == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwca Some function
function authentication_vvvvwca_SomeFunc(authentication_vvvvwca)
{
	// set the function logic
	if (authentication_vvvvwca == 2 || authentication_vvvvwca == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwcc function
function vvvvwcc(protocol_vvvvwcc,authentication_vvvvwcc)
{
	if (isSet(protocol_vvvvwcc) && protocol_vvvvwcc.constructor !== Array)
	{
		var temp_vvvvwcc = protocol_vvvvwcc;
		var protocol_vvvvwcc = [];
		protocol_vvvvwcc.push(temp_vvvvwcc);
	}
	else if (!isSet(protocol_vvvvwcc))
	{
		var protocol_vvvvwcc = [];
	}
	var protocol = protocol_vvvvwcc.some(protocol_vvvvwcc_SomeFunc);

	if (isSet(authentication_vvvvwcc) && authentication_vvvvwcc.constructor !== Array)
	{
		var temp_vvvvwcc = authentication_vvvvwcc;
		var authentication_vvvvwcc = [];
		authentication_vvvvwcc.push(temp_vvvvwcc);
	}
	else if (!isSet(authentication_vvvvwcc))
	{
		var authentication_vvvvwcc = [];
	}
	var authentication = authentication_vvvvwcc.some(authentication_vvvvwcc_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwccvyc_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwccvyc_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwccvyc_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwccvyc_required = true;
		}
	}
}

// the vvvvwcc Some function
function protocol_vvvvwcc_SomeFunc(protocol_vvvvwcc)
{
	// set the function logic
	if (protocol_vvvvwcc == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcc Some function
function authentication_vvvvwcc_SomeFunc(authentication_vvvvwcc)
{
	// set the function logic
	if (authentication_vvvvwcc == 4 || authentication_vvvvwcc == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwce function
function vvvvwce(protocol_vvvvwce,authentication_vvvvwce)
{
	if (isSet(protocol_vvvvwce) && protocol_vvvvwce.constructor !== Array)
	{
		var temp_vvvvwce = protocol_vvvvwce;
		var protocol_vvvvwce = [];
		protocol_vvvvwce.push(temp_vvvvwce);
	}
	else if (!isSet(protocol_vvvvwce))
	{
		var protocol_vvvvwce = [];
	}
	var protocol = protocol_vvvvwce.some(protocol_vvvvwce_SomeFunc);

	if (isSet(authentication_vvvvwce) && authentication_vvvvwce.constructor !== Array)
	{
		var temp_vvvvwce = authentication_vvvvwce;
		var authentication_vvvvwce = [];
		authentication_vvvvwce.push(temp_vvvvwce);
	}
	else if (!isSet(authentication_vvvvwce))
	{
		var authentication_vvvvwce = [];
	}
	var authentication = authentication_vvvvwce.some(authentication_vvvvwce_SomeFunc);


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

// the vvvvwce Some function
function protocol_vvvvwce_SomeFunc(protocol_vvvvwce)
{
	// set the function logic
	if (protocol_vvvvwce == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwce Some function
function authentication_vvvvwce_SomeFunc(authentication_vvvvwce)
{
	// set the function logic
	if (authentication_vvvvwce == 2 || authentication_vvvvwce == 3 || authentication_vvvvwce == 4 || authentication_vvvvwce == 5)
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
