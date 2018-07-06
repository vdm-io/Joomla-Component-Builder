/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwaxwaf_required = false;
jform_vvvvwaxwag_required = false;
jform_vvvvwaxwah_required = false;
jform_vvvvwaxwai_required = false;
jform_vvvvwaxwaj_required = false;
jform_vvvvwaywak_required = false;
jform_vvvvwazwal_required = false;
jform_vvvvwbbwam_required = false;
jform_vvvvwbdwan_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwax = jQuery("#jform_protocol").val();
	vvvvwax(protocol_vvvvwax);

	var protocol_vvvvway = jQuery("#jform_protocol").val();
	vvvvway(protocol_vvvvway);

	var protocol_vvvvwaz = jQuery("#jform_protocol").val();
	var authentication_vvvvwaz = jQuery("#jform_authentication").val();
	vvvvwaz(protocol_vvvvwaz,authentication_vvvvwaz);

	var protocol_vvvvwbb = jQuery("#jform_protocol").val();
	var authentication_vvvvwbb = jQuery("#jform_authentication").val();
	vvvvwbb(protocol_vvvvwbb,authentication_vvvvwbb);

	var protocol_vvvvwbd = jQuery("#jform_protocol").val();
	var authentication_vvvvwbd = jQuery("#jform_authentication").val();
	vvvvwbd(protocol_vvvvwbd,authentication_vvvvwbd);

	var protocol_vvvvwbf = jQuery("#jform_protocol").val();
	var authentication_vvvvwbf = jQuery("#jform_authentication").val();
	vvvvwbf(protocol_vvvvwbf,authentication_vvvvwbf);
});

// the vvvvwax function
function vvvvwax(protocol_vvvvwax)
{
	if (isSet(protocol_vvvvwax) && protocol_vvvvwax.constructor !== Array)
	{
		var temp_vvvvwax = protocol_vvvvwax;
		var protocol_vvvvwax = [];
		protocol_vvvvwax.push(temp_vvvvwax);
	}
	else if (!isSet(protocol_vvvvwax))
	{
		var protocol_vvvvwax = [];
	}
	var protocol = protocol_vvvvwax.some(protocol_vvvvwax_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		if (jform_vvvvwaxwaf_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwaxwaf_required = false;
		}

		jQuery('#jform_host').closest('.control-group').show();
		if (jform_vvvvwaxwag_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwaxwag_required = false;
		}

		jQuery('#jform_port').closest('.control-group').show();
		if (jform_vvvvwaxwah_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwaxwah_required = false;
		}

		jQuery('#jform_path').closest('.control-group').show();
		if (jform_vvvvwaxwai_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwaxwai_required = false;
		}

		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		if (jform_vvvvwaxwaj_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwaxwaj_required = false;
		}

	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		if (!jform_vvvvwaxwaf_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwaxwaf_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		if (!jform_vvvvwaxwag_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwaxwag_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		if (!jform_vvvvwaxwah_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwaxwah_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		if (!jform_vvvvwaxwai_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwaxwai_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		if (!jform_vvvvwaxwaj_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwaxwaj_required = true;
		}
	}
}

// the vvvvwax Some function
function protocol_vvvvwax_SomeFunc(protocol_vvvvwax)
{
	// set the function logic
	if (protocol_vvvvwax == 2)
	{
		return true;
	}
	return false;
}

// the vvvvway function
function vvvvway(protocol_vvvvway)
{
	if (isSet(protocol_vvvvway) && protocol_vvvvway.constructor !== Array)
	{
		var temp_vvvvway = protocol_vvvvway;
		var protocol_vvvvway = [];
		protocol_vvvvway.push(temp_vvvvway);
	}
	else if (!isSet(protocol_vvvvway))
	{
		var protocol_vvvvway = [];
	}
	var protocol = protocol_vvvvway.some(protocol_vvvvway_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		if (jform_vvvvwaywak_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwaywak_required = false;
		}

	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		if (!jform_vvvvwaywak_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwaywak_required = true;
		}
	}
}

// the vvvvway Some function
function protocol_vvvvway_SomeFunc(protocol_vvvvway)
{
	// set the function logic
	if (protocol_vvvvway == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwaz function
function vvvvwaz(protocol_vvvvwaz,authentication_vvvvwaz)
{
	if (isSet(protocol_vvvvwaz) && protocol_vvvvwaz.constructor !== Array)
	{
		var temp_vvvvwaz = protocol_vvvvwaz;
		var protocol_vvvvwaz = [];
		protocol_vvvvwaz.push(temp_vvvvwaz);
	}
	else if (!isSet(protocol_vvvvwaz))
	{
		var protocol_vvvvwaz = [];
	}
	var protocol = protocol_vvvvwaz.some(protocol_vvvvwaz_SomeFunc);

	if (isSet(authentication_vvvvwaz) && authentication_vvvvwaz.constructor !== Array)
	{
		var temp_vvvvwaz = authentication_vvvvwaz;
		var authentication_vvvvwaz = [];
		authentication_vvvvwaz.push(temp_vvvvwaz);
	}
	else if (!isSet(authentication_vvvvwaz))
	{
		var authentication_vvvvwaz = [];
	}
	var authentication = authentication_vvvvwaz.some(authentication_vvvvwaz_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		if (jform_vvvvwazwal_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwazwal_required = false;
		}

	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		if (!jform_vvvvwazwal_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwazwal_required = true;
		}
	}
}

// the vvvvwaz Some function
function protocol_vvvvwaz_SomeFunc(protocol_vvvvwaz)
{
	// set the function logic
	if (protocol_vvvvwaz == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwaz Some function
function authentication_vvvvwaz_SomeFunc(authentication_vvvvwaz)
{
	// set the function logic
	if (authentication_vvvvwaz == 1 || authentication_vvvvwaz == 3 || authentication_vvvvwaz == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwbb function
function vvvvwbb(protocol_vvvvwbb,authentication_vvvvwbb)
{
	if (isSet(protocol_vvvvwbb) && protocol_vvvvwbb.constructor !== Array)
	{
		var temp_vvvvwbb = protocol_vvvvwbb;
		var protocol_vvvvwbb = [];
		protocol_vvvvwbb.push(temp_vvvvwbb);
	}
	else if (!isSet(protocol_vvvvwbb))
	{
		var protocol_vvvvwbb = [];
	}
	var protocol = protocol_vvvvwbb.some(protocol_vvvvwbb_SomeFunc);

	if (isSet(authentication_vvvvwbb) && authentication_vvvvwbb.constructor !== Array)
	{
		var temp_vvvvwbb = authentication_vvvvwbb;
		var authentication_vvvvwbb = [];
		authentication_vvvvwbb.push(temp_vvvvwbb);
	}
	else if (!isSet(authentication_vvvvwbb))
	{
		var authentication_vvvvwbb = [];
	}
	var authentication = authentication_vvvvwbb.some(authentication_vvvvwbb_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		if (jform_vvvvwbbwam_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwbbwam_required = false;
		}

	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		if (!jform_vvvvwbbwam_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwbbwam_required = true;
		}
	}
}

// the vvvvwbb Some function
function protocol_vvvvwbb_SomeFunc(protocol_vvvvwbb)
{
	// set the function logic
	if (protocol_vvvvwbb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbb Some function
function authentication_vvvvwbb_SomeFunc(authentication_vvvvwbb)
{
	// set the function logic
	if (authentication_vvvvwbb == 2 || authentication_vvvvwbb == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbd function
function vvvvwbd(protocol_vvvvwbd,authentication_vvvvwbd)
{
	if (isSet(protocol_vvvvwbd) && protocol_vvvvwbd.constructor !== Array)
	{
		var temp_vvvvwbd = protocol_vvvvwbd;
		var protocol_vvvvwbd = [];
		protocol_vvvvwbd.push(temp_vvvvwbd);
	}
	else if (!isSet(protocol_vvvvwbd))
	{
		var protocol_vvvvwbd = [];
	}
	var protocol = protocol_vvvvwbd.some(protocol_vvvvwbd_SomeFunc);

	if (isSet(authentication_vvvvwbd) && authentication_vvvvwbd.constructor !== Array)
	{
		var temp_vvvvwbd = authentication_vvvvwbd;
		var authentication_vvvvwbd = [];
		authentication_vvvvwbd.push(temp_vvvvwbd);
	}
	else if (!isSet(authentication_vvvvwbd))
	{
		var authentication_vvvvwbd = [];
	}
	var authentication = authentication_vvvvwbd.some(authentication_vvvvwbd_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		if (jform_vvvvwbdwan_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwbdwan_required = false;
		}

	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		if (!jform_vvvvwbdwan_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwbdwan_required = true;
		}
	}
}

// the vvvvwbd Some function
function protocol_vvvvwbd_SomeFunc(protocol_vvvvwbd)
{
	// set the function logic
	if (protocol_vvvvwbd == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbd Some function
function authentication_vvvvwbd_SomeFunc(authentication_vvvvwbd)
{
	// set the function logic
	if (authentication_vvvvwbd == 4 || authentication_vvvvwbd == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwbf function
function vvvvwbf(protocol_vvvvwbf,authentication_vvvvwbf)
{
	if (isSet(protocol_vvvvwbf) && protocol_vvvvwbf.constructor !== Array)
	{
		var temp_vvvvwbf = protocol_vvvvwbf;
		var protocol_vvvvwbf = [];
		protocol_vvvvwbf.push(temp_vvvvwbf);
	}
	else if (!isSet(protocol_vvvvwbf))
	{
		var protocol_vvvvwbf = [];
	}
	var protocol = protocol_vvvvwbf.some(protocol_vvvvwbf_SomeFunc);

	if (isSet(authentication_vvvvwbf) && authentication_vvvvwbf.constructor !== Array)
	{
		var temp_vvvvwbf = authentication_vvvvwbf;
		var authentication_vvvvwbf = [];
		authentication_vvvvwbf.push(temp_vvvvwbf);
	}
	else if (!isSet(authentication_vvvvwbf))
	{
		var authentication_vvvvwbf = [];
	}
	var authentication = authentication_vvvvwbf.some(authentication_vvvvwbf_SomeFunc);


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

// the vvvvwbf Some function
function protocol_vvvvwbf_SomeFunc(protocol_vvvvwbf)
{
	// set the function logic
	if (protocol_vvvvwbf == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbf Some function
function authentication_vvvvwbf_SomeFunc(authentication_vvvvwbf)
{
	// set the function logic
	if (authentication_vvvvwbf == 2 || authentication_vvvvwbf == 3 || authentication_vvvvwbf == 4 || authentication_vvvvwbf == 5)
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
