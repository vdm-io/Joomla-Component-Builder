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
jform_vvvvwbmwan_required = false;
jform_vvvvwbmwao_required = false;
jform_vvvvwbmwap_required = false;
jform_vvvvwbmwaq_required = false;
jform_vvvvwbmwar_required = false;
jform_vvvvwbnwas_required = false;
jform_vvvvwbowat_required = false;
jform_vvvvwbqwau_required = false;
jform_vvvvwbswav_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwbm = jQuery("#jform_protocol").val();
	vvvvwbm(protocol_vvvvwbm);

	var protocol_vvvvwbn = jQuery("#jform_protocol").val();
	vvvvwbn(protocol_vvvvwbn);

	var protocol_vvvvwbo = jQuery("#jform_protocol").val();
	var authentication_vvvvwbo = jQuery("#jform_authentication").val();
	vvvvwbo(protocol_vvvvwbo,authentication_vvvvwbo);

	var protocol_vvvvwbq = jQuery("#jform_protocol").val();
	var authentication_vvvvwbq = jQuery("#jform_authentication").val();
	vvvvwbq(protocol_vvvvwbq,authentication_vvvvwbq);

	var protocol_vvvvwbs = jQuery("#jform_protocol").val();
	var authentication_vvvvwbs = jQuery("#jform_authentication").val();
	vvvvwbs(protocol_vvvvwbs,authentication_vvvvwbs);

	var protocol_vvvvwbu = jQuery("#jform_protocol").val();
	var authentication_vvvvwbu = jQuery("#jform_authentication").val();
	vvvvwbu(protocol_vvvvwbu,authentication_vvvvwbu);
});

// the vvvvwbm function
function vvvvwbm(protocol_vvvvwbm)
{
	if (isSet(protocol_vvvvwbm) && protocol_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = protocol_vvvvwbm;
		var protocol_vvvvwbm = [];
		protocol_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(protocol_vvvvwbm))
	{
		var protocol_vvvvwbm = [];
	}
	var protocol = protocol_vvvvwbm.some(protocol_vvvvwbm_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwbmwan_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwbmwan_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwbmwao_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwbmwao_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwbmwap_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwbmwap_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwbmwaq_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwbmwaq_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwbmwar_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwbmwar_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwbmwan_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwbmwan_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwbmwao_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwbmwao_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwbmwap_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwbmwap_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwbmwaq_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwbmwaq_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwbmwar_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwbmwar_required = true;
		}
	}
}

// the vvvvwbm Some function
function protocol_vvvvwbm_SomeFunc(protocol_vvvvwbm)
{
	// set the function logic
	if (protocol_vvvvwbm == 2)
	{
		return true;
	}
	return false;
}

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
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwbnwas_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwbnwas_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwbnwas_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwbnwas_required = true;
		}
	}
}

// the vvvvwbn Some function
function protocol_vvvvwbn_SomeFunc(protocol_vvvvwbn)
{
	// set the function logic
	if (protocol_vvvvwbn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbo function
function vvvvwbo(protocol_vvvvwbo,authentication_vvvvwbo)
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

	if (isSet(authentication_vvvvwbo) && authentication_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = authentication_vvvvwbo;
		var authentication_vvvvwbo = [];
		authentication_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(authentication_vvvvwbo))
	{
		var authentication_vvvvwbo = [];
	}
	var authentication = authentication_vvvvwbo.some(authentication_vvvvwbo_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwbowat_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwbowat_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwbowat_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwbowat_required = true;
		}
	}
}

// the vvvvwbo Some function
function protocol_vvvvwbo_SomeFunc(protocol_vvvvwbo)
{
	// set the function logic
	if (protocol_vvvvwbo == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbo Some function
function authentication_vvvvwbo_SomeFunc(authentication_vvvvwbo)
{
	// set the function logic
	if (authentication_vvvvwbo == 1 || authentication_vvvvwbo == 3 || authentication_vvvvwbo == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwbq function
function vvvvwbq(protocol_vvvvwbq,authentication_vvvvwbq)
{
	if (isSet(protocol_vvvvwbq) && protocol_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = protocol_vvvvwbq;
		var protocol_vvvvwbq = [];
		protocol_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(protocol_vvvvwbq))
	{
		var protocol_vvvvwbq = [];
	}
	var protocol = protocol_vvvvwbq.some(protocol_vvvvwbq_SomeFunc);

	if (isSet(authentication_vvvvwbq) && authentication_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = authentication_vvvvwbq;
		var authentication_vvvvwbq = [];
		authentication_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(authentication_vvvvwbq))
	{
		var authentication_vvvvwbq = [];
	}
	var authentication = authentication_vvvvwbq.some(authentication_vvvvwbq_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwbqwau_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwbqwau_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwbqwau_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwbqwau_required = true;
		}
	}
}

// the vvvvwbq Some function
function protocol_vvvvwbq_SomeFunc(protocol_vvvvwbq)
{
	// set the function logic
	if (protocol_vvvvwbq == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbq Some function
function authentication_vvvvwbq_SomeFunc(authentication_vvvvwbq)
{
	// set the function logic
	if (authentication_vvvvwbq == 2 || authentication_vvvvwbq == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbs function
function vvvvwbs(protocol_vvvvwbs,authentication_vvvvwbs)
{
	if (isSet(protocol_vvvvwbs) && protocol_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = protocol_vvvvwbs;
		var protocol_vvvvwbs = [];
		protocol_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(protocol_vvvvwbs))
	{
		var protocol_vvvvwbs = [];
	}
	var protocol = protocol_vvvvwbs.some(protocol_vvvvwbs_SomeFunc);

	if (isSet(authentication_vvvvwbs) && authentication_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = authentication_vvvvwbs;
		var authentication_vvvvwbs = [];
		authentication_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(authentication_vvvvwbs))
	{
		var authentication_vvvvwbs = [];
	}
	var authentication = authentication_vvvvwbs.some(authentication_vvvvwbs_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwbswav_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwbswav_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwbswav_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwbswav_required = true;
		}
	}
}

// the vvvvwbs Some function
function protocol_vvvvwbs_SomeFunc(protocol_vvvvwbs)
{
	// set the function logic
	if (protocol_vvvvwbs == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbs Some function
function authentication_vvvvwbs_SomeFunc(authentication_vvvvwbs)
{
	// set the function logic
	if (authentication_vvvvwbs == 4 || authentication_vvvvwbs == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwbu function
function vvvvwbu(protocol_vvvvwbu,authentication_vvvvwbu)
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

	if (isSet(authentication_vvvvwbu) && authentication_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = authentication_vvvvwbu;
		var authentication_vvvvwbu = [];
		authentication_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(authentication_vvvvwbu))
	{
		var authentication_vvvvwbu = [];
	}
	var authentication = authentication_vvvvwbu.some(authentication_vvvvwbu_SomeFunc);


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

// the vvvvwbu Some function
function protocol_vvvvwbu_SomeFunc(protocol_vvvvwbu)
{
	// set the function logic
	if (protocol_vvvvwbu == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbu Some function
function authentication_vvvvwbu_SomeFunc(authentication_vvvvwbu)
{
	// set the function logic
	if (authentication_vvvvwbu == 2 || authentication_vvvvwbu == 3 || authentication_vvvvwbu == 4 || authentication_vvvvwbu == 5)
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
