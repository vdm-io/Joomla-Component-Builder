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
jform_vvvvwawwae_required = false;
jform_vvvvwawwaf_required = false;
jform_vvvvwawwag_required = false;
jform_vvvvwawwah_required = false;
jform_vvvvwawwai_required = false;
jform_vvvvwaxwaj_required = false;
jform_vvvvwaywak_required = false;
jform_vvvvwbawal_required = false;
jform_vvvvwbcwam_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwaw = jQuery("#jform_protocol").val();
	vvvvwaw(protocol_vvvvwaw);

	var protocol_vvvvwax = jQuery("#jform_protocol").val();
	vvvvwax(protocol_vvvvwax);

	var protocol_vvvvway = jQuery("#jform_protocol").val();
	var authentication_vvvvway = jQuery("#jform_authentication").val();
	vvvvway(protocol_vvvvway,authentication_vvvvway);

	var protocol_vvvvwba = jQuery("#jform_protocol").val();
	var authentication_vvvvwba = jQuery("#jform_authentication").val();
	vvvvwba(protocol_vvvvwba,authentication_vvvvwba);

	var protocol_vvvvwbc = jQuery("#jform_protocol").val();
	var authentication_vvvvwbc = jQuery("#jform_authentication").val();
	vvvvwbc(protocol_vvvvwbc,authentication_vvvvwbc);

	var protocol_vvvvwbe = jQuery("#jform_protocol").val();
	var authentication_vvvvwbe = jQuery("#jform_authentication").val();
	vvvvwbe(protocol_vvvvwbe,authentication_vvvvwbe);
});

// the vvvvwaw function
function vvvvwaw(protocol_vvvvwaw)
{
	if (isSet(protocol_vvvvwaw) && protocol_vvvvwaw.constructor !== Array)
	{
		var temp_vvvvwaw = protocol_vvvvwaw;
		var protocol_vvvvwaw = [];
		protocol_vvvvwaw.push(temp_vvvvwaw);
	}
	else if (!isSet(protocol_vvvvwaw))
	{
		var protocol_vvvvwaw = [];
	}
	var protocol = protocol_vvvvwaw.some(protocol_vvvvwaw_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		if (jform_vvvvwawwae_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwawwae_required = false;
		}

		jQuery('#jform_host').closest('.control-group').show();
		if (jform_vvvvwawwaf_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwawwaf_required = false;
		}

		jQuery('#jform_port').closest('.control-group').show();
		if (jform_vvvvwawwag_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwawwag_required = false;
		}

		jQuery('#jform_path').closest('.control-group').show();
		if (jform_vvvvwawwah_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwawwah_required = false;
		}

		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		if (jform_vvvvwawwai_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwawwai_required = false;
		}

	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		if (!jform_vvvvwawwae_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwawwae_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		if (!jform_vvvvwawwaf_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwawwaf_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		if (!jform_vvvvwawwag_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwawwag_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		if (!jform_vvvvwawwah_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwawwah_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		if (!jform_vvvvwawwai_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwawwai_required = true;
		}
	}
}

// the vvvvwaw Some function
function protocol_vvvvwaw_SomeFunc(protocol_vvvvwaw)
{
	// set the function logic
	if (protocol_vvvvwaw == 2)
	{
		return true;
	}
	return false;
}

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
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		if (jform_vvvvwaxwaj_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwaxwaj_required = false;
		}

	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		if (!jform_vvvvwaxwaj_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwaxwaj_required = true;
		}
	}
}

// the vvvvwax Some function
function protocol_vvvvwax_SomeFunc(protocol_vvvvwax)
{
	// set the function logic
	if (protocol_vvvvwax == 1)
	{
		return true;
	}
	return false;
}

// the vvvvway function
function vvvvway(protocol_vvvvway,authentication_vvvvway)
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

	if (isSet(authentication_vvvvway) && authentication_vvvvway.constructor !== Array)
	{
		var temp_vvvvway = authentication_vvvvway;
		var authentication_vvvvway = [];
		authentication_vvvvway.push(temp_vvvvway);
	}
	else if (!isSet(authentication_vvvvway))
	{
		var authentication_vvvvway = [];
	}
	var authentication = authentication_vvvvway.some(authentication_vvvvway_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		if (jform_vvvvwaywak_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwaywak_required = false;
		}

	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		if (!jform_vvvvwaywak_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwaywak_required = true;
		}
	}
}

// the vvvvway Some function
function protocol_vvvvway_SomeFunc(protocol_vvvvway)
{
	// set the function logic
	if (protocol_vvvvway == 2)
	{
		return true;
	}
	return false;
}

// the vvvvway Some function
function authentication_vvvvway_SomeFunc(authentication_vvvvway)
{
	// set the function logic
	if (authentication_vvvvway == 1 || authentication_vvvvway == 3 || authentication_vvvvway == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwba function
function vvvvwba(protocol_vvvvwba,authentication_vvvvwba)
{
	if (isSet(protocol_vvvvwba) && protocol_vvvvwba.constructor !== Array)
	{
		var temp_vvvvwba = protocol_vvvvwba;
		var protocol_vvvvwba = [];
		protocol_vvvvwba.push(temp_vvvvwba);
	}
	else if (!isSet(protocol_vvvvwba))
	{
		var protocol_vvvvwba = [];
	}
	var protocol = protocol_vvvvwba.some(protocol_vvvvwba_SomeFunc);

	if (isSet(authentication_vvvvwba) && authentication_vvvvwba.constructor !== Array)
	{
		var temp_vvvvwba = authentication_vvvvwba;
		var authentication_vvvvwba = [];
		authentication_vvvvwba.push(temp_vvvvwba);
	}
	else if (!isSet(authentication_vvvvwba))
	{
		var authentication_vvvvwba = [];
	}
	var authentication = authentication_vvvvwba.some(authentication_vvvvwba_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		if (jform_vvvvwbawal_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwbawal_required = false;
		}

	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		if (!jform_vvvvwbawal_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwbawal_required = true;
		}
	}
}

// the vvvvwba Some function
function protocol_vvvvwba_SomeFunc(protocol_vvvvwba)
{
	// set the function logic
	if (protocol_vvvvwba == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwba Some function
function authentication_vvvvwba_SomeFunc(authentication_vvvvwba)
{
	// set the function logic
	if (authentication_vvvvwba == 2 || authentication_vvvvwba == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbc function
function vvvvwbc(protocol_vvvvwbc,authentication_vvvvwbc)
{
	if (isSet(protocol_vvvvwbc) && protocol_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = protocol_vvvvwbc;
		var protocol_vvvvwbc = [];
		protocol_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(protocol_vvvvwbc))
	{
		var protocol_vvvvwbc = [];
	}
	var protocol = protocol_vvvvwbc.some(protocol_vvvvwbc_SomeFunc);

	if (isSet(authentication_vvvvwbc) && authentication_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = authentication_vvvvwbc;
		var authentication_vvvvwbc = [];
		authentication_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(authentication_vvvvwbc))
	{
		var authentication_vvvvwbc = [];
	}
	var authentication = authentication_vvvvwbc.some(authentication_vvvvwbc_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		if (jform_vvvvwbcwam_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwbcwam_required = false;
		}

	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		if (!jform_vvvvwbcwam_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwbcwam_required = true;
		}
	}
}

// the vvvvwbc Some function
function protocol_vvvvwbc_SomeFunc(protocol_vvvvwbc)
{
	// set the function logic
	if (protocol_vvvvwbc == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbc Some function
function authentication_vvvvwbc_SomeFunc(authentication_vvvvwbc)
{
	// set the function logic
	if (authentication_vvvvwbc == 4 || authentication_vvvvwbc == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwbe function
function vvvvwbe(protocol_vvvvwbe,authentication_vvvvwbe)
{
	if (isSet(protocol_vvvvwbe) && protocol_vvvvwbe.constructor !== Array)
	{
		var temp_vvvvwbe = protocol_vvvvwbe;
		var protocol_vvvvwbe = [];
		protocol_vvvvwbe.push(temp_vvvvwbe);
	}
	else if (!isSet(protocol_vvvvwbe))
	{
		var protocol_vvvvwbe = [];
	}
	var protocol = protocol_vvvvwbe.some(protocol_vvvvwbe_SomeFunc);

	if (isSet(authentication_vvvvwbe) && authentication_vvvvwbe.constructor !== Array)
	{
		var temp_vvvvwbe = authentication_vvvvwbe;
		var authentication_vvvvwbe = [];
		authentication_vvvvwbe.push(temp_vvvvwbe);
	}
	else if (!isSet(authentication_vvvvwbe))
	{
		var authentication_vvvvwbe = [];
	}
	var authentication = authentication_vvvvwbe.some(authentication_vvvvwbe_SomeFunc);


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

// the vvvvwbe Some function
function protocol_vvvvwbe_SomeFunc(protocol_vvvvwbe)
{
	// set the function logic
	if (protocol_vvvvwbe == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbe Some function
function authentication_vvvvwbe_SomeFunc(authentication_vvvvwbe)
{
	// set the function logic
	if (authentication_vvvvwbe == 2 || authentication_vvvvwbe == 3 || authentication_vvvvwbe == 4 || authentication_vvvvwbe == 5)
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
