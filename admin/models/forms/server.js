/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		server.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvwavwad_required = false;
jform_vvvvwavwae_required = false;
jform_vvvvwavwaf_required = false;
jform_vvvvwavwag_required = false;
jform_vvvvwavwah_required = false;
jform_vvvvwawwai_required = false;
jform_vvvvwaxwaj_required = false;
jform_vvvvwazwak_required = false;
jform_vvvvwbbwal_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwav = jQuery("#jform_protocol").val();
	vvvvwav(protocol_vvvvwav);

	var protocol_vvvvwaw = jQuery("#jform_protocol").val();
	vvvvwaw(protocol_vvvvwaw);

	var protocol_vvvvwax = jQuery("#jform_protocol").val();
	var authentication_vvvvwax = jQuery("#jform_authentication").val();
	vvvvwax(protocol_vvvvwax,authentication_vvvvwax);

	var protocol_vvvvwaz = jQuery("#jform_protocol").val();
	var authentication_vvvvwaz = jQuery("#jform_authentication").val();
	vvvvwaz(protocol_vvvvwaz,authentication_vvvvwaz);

	var protocol_vvvvwbb = jQuery("#jform_protocol").val();
	var authentication_vvvvwbb = jQuery("#jform_authentication").val();
	vvvvwbb(protocol_vvvvwbb,authentication_vvvvwbb);

	var protocol_vvvvwbd = jQuery("#jform_protocol").val();
	var authentication_vvvvwbd = jQuery("#jform_authentication").val();
	vvvvwbd(protocol_vvvvwbd,authentication_vvvvwbd);
});

// the vvvvwav function
function vvvvwav(protocol_vvvvwav)
{
	if (isSet(protocol_vvvvwav) && protocol_vvvvwav.constructor !== Array)
	{
		var temp_vvvvwav = protocol_vvvvwav;
		var protocol_vvvvwav = [];
		protocol_vvvvwav.push(temp_vvvvwav);
	}
	else if (!isSet(protocol_vvvvwav))
	{
		var protocol_vvvvwav = [];
	}
	var protocol = protocol_vvvvwav.some(protocol_vvvvwav_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		if (jform_vvvvwavwad_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwavwad_required = false;
		}

		jQuery('#jform_host').closest('.control-group').show();
		if (jform_vvvvwavwae_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwavwae_required = false;
		}

		jQuery('#jform_port').closest('.control-group').show();
		if (jform_vvvvwavwaf_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwavwaf_required = false;
		}

		jQuery('#jform_path').closest('.control-group').show();
		if (jform_vvvvwavwag_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwavwag_required = false;
		}

		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		if (jform_vvvvwavwah_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwavwah_required = false;
		}

	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		if (!jform_vvvvwavwad_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwavwad_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		if (!jform_vvvvwavwae_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwavwae_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		if (!jform_vvvvwavwaf_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwavwaf_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		if (!jform_vvvvwavwag_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwavwag_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		if (!jform_vvvvwavwah_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwavwah_required = true;
		}
	}
}

// the vvvvwav Some function
function protocol_vvvvwav_SomeFunc(protocol_vvvvwav)
{
	// set the function logic
	if (protocol_vvvvwav == 2)
	{
		return true;
	}
	return false;
}

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
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		if (jform_vvvvwawwai_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwawwai_required = false;
		}

	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		if (!jform_vvvvwawwai_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwawwai_required = true;
		}
	}
}

// the vvvvwaw Some function
function protocol_vvvvwaw_SomeFunc(protocol_vvvvwaw)
{
	// set the function logic
	if (protocol_vvvvwaw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwax function
function vvvvwax(protocol_vvvvwax,authentication_vvvvwax)
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

	if (isSet(authentication_vvvvwax) && authentication_vvvvwax.constructor !== Array)
	{
		var temp_vvvvwax = authentication_vvvvwax;
		var authentication_vvvvwax = [];
		authentication_vvvvwax.push(temp_vvvvwax);
	}
	else if (!isSet(authentication_vvvvwax))
	{
		var authentication_vvvvwax = [];
	}
	var authentication = authentication_vvvvwax.some(authentication_vvvvwax_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		if (jform_vvvvwaxwaj_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwaxwaj_required = false;
		}

	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		if (!jform_vvvvwaxwaj_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
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

// the vvvvwax Some function
function authentication_vvvvwax_SomeFunc(authentication_vvvvwax)
{
	// set the function logic
	if (authentication_vvvvwax == 1 || authentication_vvvvwax == 3 || authentication_vvvvwax == 5)
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
		jQuery('#jform_private').closest('.control-group').show();
		if (jform_vvvvwazwak_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwazwak_required = false;
		}

	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		if (!jform_vvvvwazwak_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwazwak_required = true;
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
	if (authentication_vvvvwaz == 2 || authentication_vvvvwaz == 3)
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
		jQuery('#jform_private_key').closest('.control-group').show();
		if (jform_vvvvwbbwal_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwbbwal_required = false;
		}

	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		if (!jform_vvvvwbbwal_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwbbwal_required = true;
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
	if (authentication_vvvvwbb == 4 || authentication_vvvvwbb == 5)
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
		jQuery('#jform_secret').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_secret').closest('.control-group').hide();
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
	if (authentication_vvvvwbd == 2 || authentication_vvvvwbd == 3 || authentication_vvvvwbd == 4 || authentication_vvvvwbd == 5)
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
