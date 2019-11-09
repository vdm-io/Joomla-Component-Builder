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
jform_vvvvwdevyj_required = false;
jform_vvvvwdevyk_required = false;
jform_vvvvwdevyl_required = false;
jform_vvvvwdevym_required = false;
jform_vvvvwdevyn_required = false;
jform_vvvvwdfvyo_required = false;
jform_vvvvwdgvyp_required = false;
jform_vvvvwdivyq_required = false;
jform_vvvvwdkvyr_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwde = jQuery("#jform_protocol").val();
	vvvvwde(protocol_vvvvwde);

	var protocol_vvvvwdf = jQuery("#jform_protocol").val();
	vvvvwdf(protocol_vvvvwdf);

	var protocol_vvvvwdg = jQuery("#jform_protocol").val();
	var authentication_vvvvwdg = jQuery("#jform_authentication").val();
	vvvvwdg(protocol_vvvvwdg,authentication_vvvvwdg);

	var protocol_vvvvwdi = jQuery("#jform_protocol").val();
	var authentication_vvvvwdi = jQuery("#jform_authentication").val();
	vvvvwdi(protocol_vvvvwdi,authentication_vvvvwdi);

	var protocol_vvvvwdk = jQuery("#jform_protocol").val();
	var authentication_vvvvwdk = jQuery("#jform_authentication").val();
	vvvvwdk(protocol_vvvvwdk,authentication_vvvvwdk);

	var protocol_vvvvwdm = jQuery("#jform_protocol").val();
	var authentication_vvvvwdm = jQuery("#jform_authentication").val();
	vvvvwdm(protocol_vvvvwdm,authentication_vvvvwdm);
});

// the vvvvwde function
function vvvvwde(protocol_vvvvwde)
{
	if (isSet(protocol_vvvvwde) && protocol_vvvvwde.constructor !== Array)
	{
		var temp_vvvvwde = protocol_vvvvwde;
		var protocol_vvvvwde = [];
		protocol_vvvvwde.push(temp_vvvvwde);
	}
	else if (!isSet(protocol_vvvvwde))
	{
		var protocol_vvvvwde = [];
	}
	var protocol = protocol_vvvvwde.some(protocol_vvvvwde_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwdevyj_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwdevyj_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwdevyk_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwdevyk_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwdevyl_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwdevyl_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwdevym_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwdevym_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwdevyn_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwdevyn_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwdevyj_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwdevyj_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwdevyk_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwdevyk_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwdevyl_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwdevyl_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwdevym_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwdevym_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwdevyn_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwdevyn_required = true;
		}
	}
}

// the vvvvwde Some function
function protocol_vvvvwde_SomeFunc(protocol_vvvvwde)
{
	// set the function logic
	if (protocol_vvvvwde == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdf function
function vvvvwdf(protocol_vvvvwdf)
{
	if (isSet(protocol_vvvvwdf) && protocol_vvvvwdf.constructor !== Array)
	{
		var temp_vvvvwdf = protocol_vvvvwdf;
		var protocol_vvvvwdf = [];
		protocol_vvvvwdf.push(temp_vvvvwdf);
	}
	else if (!isSet(protocol_vvvvwdf))
	{
		var protocol_vvvvwdf = [];
	}
	var protocol = protocol_vvvvwdf.some(protocol_vvvvwdf_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwdfvyo_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwdfvyo_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwdfvyo_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwdfvyo_required = true;
		}
	}
}

// the vvvvwdf Some function
function protocol_vvvvwdf_SomeFunc(protocol_vvvvwdf)
{
	// set the function logic
	if (protocol_vvvvwdf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdg function
function vvvvwdg(protocol_vvvvwdg,authentication_vvvvwdg)
{
	if (isSet(protocol_vvvvwdg) && protocol_vvvvwdg.constructor !== Array)
	{
		var temp_vvvvwdg = protocol_vvvvwdg;
		var protocol_vvvvwdg = [];
		protocol_vvvvwdg.push(temp_vvvvwdg);
	}
	else if (!isSet(protocol_vvvvwdg))
	{
		var protocol_vvvvwdg = [];
	}
	var protocol = protocol_vvvvwdg.some(protocol_vvvvwdg_SomeFunc);

	if (isSet(authentication_vvvvwdg) && authentication_vvvvwdg.constructor !== Array)
	{
		var temp_vvvvwdg = authentication_vvvvwdg;
		var authentication_vvvvwdg = [];
		authentication_vvvvwdg.push(temp_vvvvwdg);
	}
	else if (!isSet(authentication_vvvvwdg))
	{
		var authentication_vvvvwdg = [];
	}
	var authentication = authentication_vvvvwdg.some(authentication_vvvvwdg_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwdgvyp_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwdgvyp_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwdgvyp_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwdgvyp_required = true;
		}
	}
}

// the vvvvwdg Some function
function protocol_vvvvwdg_SomeFunc(protocol_vvvvwdg)
{
	// set the function logic
	if (protocol_vvvvwdg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdg Some function
function authentication_vvvvwdg_SomeFunc(authentication_vvvvwdg)
{
	// set the function logic
	if (authentication_vvvvwdg == 1 || authentication_vvvvwdg == 3 || authentication_vvvvwdg == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwdi function
function vvvvwdi(protocol_vvvvwdi,authentication_vvvvwdi)
{
	if (isSet(protocol_vvvvwdi) && protocol_vvvvwdi.constructor !== Array)
	{
		var temp_vvvvwdi = protocol_vvvvwdi;
		var protocol_vvvvwdi = [];
		protocol_vvvvwdi.push(temp_vvvvwdi);
	}
	else if (!isSet(protocol_vvvvwdi))
	{
		var protocol_vvvvwdi = [];
	}
	var protocol = protocol_vvvvwdi.some(protocol_vvvvwdi_SomeFunc);

	if (isSet(authentication_vvvvwdi) && authentication_vvvvwdi.constructor !== Array)
	{
		var temp_vvvvwdi = authentication_vvvvwdi;
		var authentication_vvvvwdi = [];
		authentication_vvvvwdi.push(temp_vvvvwdi);
	}
	else if (!isSet(authentication_vvvvwdi))
	{
		var authentication_vvvvwdi = [];
	}
	var authentication = authentication_vvvvwdi.some(authentication_vvvvwdi_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwdivyq_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwdivyq_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwdivyq_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwdivyq_required = true;
		}
	}
}

// the vvvvwdi Some function
function protocol_vvvvwdi_SomeFunc(protocol_vvvvwdi)
{
	// set the function logic
	if (protocol_vvvvwdi == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdi Some function
function authentication_vvvvwdi_SomeFunc(authentication_vvvvwdi)
{
	// set the function logic
	if (authentication_vvvvwdi == 2 || authentication_vvvvwdi == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwdk function
function vvvvwdk(protocol_vvvvwdk,authentication_vvvvwdk)
{
	if (isSet(protocol_vvvvwdk) && protocol_vvvvwdk.constructor !== Array)
	{
		var temp_vvvvwdk = protocol_vvvvwdk;
		var protocol_vvvvwdk = [];
		protocol_vvvvwdk.push(temp_vvvvwdk);
	}
	else if (!isSet(protocol_vvvvwdk))
	{
		var protocol_vvvvwdk = [];
	}
	var protocol = protocol_vvvvwdk.some(protocol_vvvvwdk_SomeFunc);

	if (isSet(authentication_vvvvwdk) && authentication_vvvvwdk.constructor !== Array)
	{
		var temp_vvvvwdk = authentication_vvvvwdk;
		var authentication_vvvvwdk = [];
		authentication_vvvvwdk.push(temp_vvvvwdk);
	}
	else if (!isSet(authentication_vvvvwdk))
	{
		var authentication_vvvvwdk = [];
	}
	var authentication = authentication_vvvvwdk.some(authentication_vvvvwdk_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwdkvyr_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwdkvyr_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwdkvyr_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwdkvyr_required = true;
		}
	}
}

// the vvvvwdk Some function
function protocol_vvvvwdk_SomeFunc(protocol_vvvvwdk)
{
	// set the function logic
	if (protocol_vvvvwdk == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdk Some function
function authentication_vvvvwdk_SomeFunc(authentication_vvvvwdk)
{
	// set the function logic
	if (authentication_vvvvwdk == 4 || authentication_vvvvwdk == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwdm function
function vvvvwdm(protocol_vvvvwdm,authentication_vvvvwdm)
{
	if (isSet(protocol_vvvvwdm) && protocol_vvvvwdm.constructor !== Array)
	{
		var temp_vvvvwdm = protocol_vvvvwdm;
		var protocol_vvvvwdm = [];
		protocol_vvvvwdm.push(temp_vvvvwdm);
	}
	else if (!isSet(protocol_vvvvwdm))
	{
		var protocol_vvvvwdm = [];
	}
	var protocol = protocol_vvvvwdm.some(protocol_vvvvwdm_SomeFunc);

	if (isSet(authentication_vvvvwdm) && authentication_vvvvwdm.constructor !== Array)
	{
		var temp_vvvvwdm = authentication_vvvvwdm;
		var authentication_vvvvwdm = [];
		authentication_vvvvwdm.push(temp_vvvvwdm);
	}
	else if (!isSet(authentication_vvvvwdm))
	{
		var authentication_vvvvwdm = [];
	}
	var authentication = authentication_vvvvwdm.some(authentication_vvvvwdm_SomeFunc);


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

// the vvvvwdm Some function
function protocol_vvvvwdm_SomeFunc(protocol_vvvvwdm)
{
	// set the function logic
	if (protocol_vvvvwdm == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdm Some function
function authentication_vvvvwdm_SomeFunc(authentication_vvvvwdm)
{
	// set the function logic
	if (authentication_vvvvwdm == 2 || authentication_vvvvwdm == 3 || authentication_vvvvwdm == 4 || authentication_vvvvwdm == 5)
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
