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
jform_vvvvwatwae_required = false;
jform_vvvvwatwaf_required = false;
jform_vvvvwatwag_required = false;
jform_vvvvwatwah_required = false;
jform_vvvvwatwai_required = false;
jform_vvvvwauwaj_required = false;
jform_vvvvwavwak_required = false;
jform_vvvvwaxwal_required = false;
jform_vvvvwaywam_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwat = jQuery("#jform_protocol").val();
	vvvvwat(protocol_vvvvwat);

	var protocol_vvvvwau = jQuery("#jform_protocol").val();
	vvvvwau(protocol_vvvvwau);

	var protocol_vvvvwav = jQuery("#jform_protocol").val();
	var authentication_vvvvwav = jQuery("#jform_authentication").val();
	vvvvwav(protocol_vvvvwav,authentication_vvvvwav);

	var protocol_vvvvwax = jQuery("#jform_protocol").val();
	var authentication_vvvvwax = jQuery("#jform_authentication").val();
	vvvvwax(protocol_vvvvwax,authentication_vvvvwax);

	var authentication_vvvvway = jQuery("#jform_authentication").val();
	var protocol_vvvvway = jQuery("#jform_protocol").val();
	vvvvway(authentication_vvvvway,protocol_vvvvway);
});

// the vvvvwat function
function vvvvwat(protocol_vvvvwat)
{
	if (isSet(protocol_vvvvwat) && protocol_vvvvwat.constructor !== Array)
	{
		var temp_vvvvwat = protocol_vvvvwat;
		var protocol_vvvvwat = [];
		protocol_vvvvwat.push(temp_vvvvwat);
	}
	else if (!isSet(protocol_vvvvwat))
	{
		var protocol_vvvvwat = [];
	}
	var protocol = protocol_vvvvwat.some(protocol_vvvvwat_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		if (jform_vvvvwatwae_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwatwae_required = false;
		}

		jQuery('#jform_host').closest('.control-group').show();
		if (jform_vvvvwatwaf_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwatwaf_required = false;
		}

		jQuery('#jform_port').closest('.control-group').show();
		if (jform_vvvvwatwag_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwatwag_required = false;
		}

		jQuery('#jform_path').closest('.control-group').show();
		if (jform_vvvvwatwah_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwatwah_required = false;
		}

		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		if (jform_vvvvwatwai_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwatwai_required = false;
		}

	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		if (!jform_vvvvwatwae_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwatwae_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		if (!jform_vvvvwatwaf_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwatwaf_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		if (!jform_vvvvwatwag_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwatwag_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		if (!jform_vvvvwatwah_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwatwah_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		if (!jform_vvvvwatwai_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwatwai_required = true;
		}
	}
}

// the vvvvwat Some function
function protocol_vvvvwat_SomeFunc(protocol_vvvvwat)
{
	// set the function logic
	if (protocol_vvvvwat == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwau function
function vvvvwau(protocol_vvvvwau)
{
	if (isSet(protocol_vvvvwau) && protocol_vvvvwau.constructor !== Array)
	{
		var temp_vvvvwau = protocol_vvvvwau;
		var protocol_vvvvwau = [];
		protocol_vvvvwau.push(temp_vvvvwau);
	}
	else if (!isSet(protocol_vvvvwau))
	{
		var protocol_vvvvwau = [];
	}
	var protocol = protocol_vvvvwau.some(protocol_vvvvwau_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		if (jform_vvvvwauwaj_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwauwaj_required = false;
		}

	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		if (!jform_vvvvwauwaj_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwauwaj_required = true;
		}
	}
}

// the vvvvwau Some function
function protocol_vvvvwau_SomeFunc(protocol_vvvvwau)
{
	// set the function logic
	if (protocol_vvvvwau == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwav function
function vvvvwav(protocol_vvvvwav,authentication_vvvvwav)
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

	if (isSet(authentication_vvvvwav) && authentication_vvvvwav.constructor !== Array)
	{
		var temp_vvvvwav = authentication_vvvvwav;
		var authentication_vvvvwav = [];
		authentication_vvvvwav.push(temp_vvvvwav);
	}
	else if (!isSet(authentication_vvvvwav))
	{
		var authentication_vvvvwav = [];
	}
	var authentication = authentication_vvvvwav.some(authentication_vvvvwav_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		if (jform_vvvvwavwak_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwavwak_required = false;
		}

	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		if (!jform_vvvvwavwak_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwavwak_required = true;
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

// the vvvvwav Some function
function authentication_vvvvwav_SomeFunc(authentication_vvvvwav)
{
	// set the function logic
	if (authentication_vvvvwav == 1 || authentication_vvvvwav == 3)
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
		jQuery('#jform_private').closest('.control-group').show();
		if (jform_vvvvwaxwal_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwaxwal_required = false;
		}

		jQuery('#jform_secret').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		if (!jform_vvvvwaxwal_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwaxwal_required = true;
		}
		jQuery('#jform_secret').closest('.control-group').hide();
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
	if (authentication_vvvvwax == 2 || authentication_vvvvwax == 3)
	{
		return true;
	}
	return false;
}

// the vvvvway function
function vvvvway(authentication_vvvvway,protocol_vvvvway)
{
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
	if (authentication && protocol)
	{
		jQuery('#jform_private').closest('.control-group').show();
		if (jform_vvvvwaywam_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwaywam_required = false;
		}

		jQuery('#jform_secret').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		if (!jform_vvvvwaywam_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwaywam_required = true;
		}
		jQuery('#jform_secret').closest('.control-group').hide();
	}
}

// the vvvvway Some function
function authentication_vvvvway_SomeFunc(authentication_vvvvway)
{
	// set the function logic
	if (authentication_vvvvway == 2 || authentication_vvvvway == 3)
	{
		return true;
	}
	return false;
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
