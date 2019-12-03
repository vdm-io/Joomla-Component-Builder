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
jform_vvvvweavyn_required = false;
jform_vvvvweavyo_required = false;
jform_vvvvweavyp_required = false;
jform_vvvvweavyq_required = false;
jform_vvvvweavyr_required = false;
jform_vvvvwebvys_required = false;
jform_vvvvwecvyt_required = false;
jform_vvvvweevyu_required = false;
jform_vvvvwegvyv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwea = jQuery("#jform_protocol").val();
	vvvvwea(protocol_vvvvwea);

	var protocol_vvvvweb = jQuery("#jform_protocol").val();
	vvvvweb(protocol_vvvvweb);

	var protocol_vvvvwec = jQuery("#jform_protocol").val();
	var authentication_vvvvwec = jQuery("#jform_authentication").val();
	vvvvwec(protocol_vvvvwec,authentication_vvvvwec);

	var protocol_vvvvwee = jQuery("#jform_protocol").val();
	var authentication_vvvvwee = jQuery("#jform_authentication").val();
	vvvvwee(protocol_vvvvwee,authentication_vvvvwee);

	var protocol_vvvvweg = jQuery("#jform_protocol").val();
	var authentication_vvvvweg = jQuery("#jform_authentication").val();
	vvvvweg(protocol_vvvvweg,authentication_vvvvweg);

	var protocol_vvvvwei = jQuery("#jform_protocol").val();
	var authentication_vvvvwei = jQuery("#jform_authentication").val();
	vvvvwei(protocol_vvvvwei,authentication_vvvvwei);
});

// the vvvvwea function
function vvvvwea(protocol_vvvvwea)
{
	if (isSet(protocol_vvvvwea) && protocol_vvvvwea.constructor !== Array)
	{
		var temp_vvvvwea = protocol_vvvvwea;
		var protocol_vvvvwea = [];
		protocol_vvvvwea.push(temp_vvvvwea);
	}
	else if (!isSet(protocol_vvvvwea))
	{
		var protocol_vvvvwea = [];
	}
	var protocol = protocol_vvvvwea.some(protocol_vvvvwea_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvweavyn_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvweavyn_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvweavyo_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvweavyo_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvweavyp_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvweavyp_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvweavyq_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvweavyq_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvweavyr_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvweavyr_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvweavyn_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvweavyn_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvweavyo_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvweavyo_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvweavyp_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvweavyp_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvweavyq_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvweavyq_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvweavyr_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvweavyr_required = true;
		}
	}
}

// the vvvvwea Some function
function protocol_vvvvwea_SomeFunc(protocol_vvvvwea)
{
	// set the function logic
	if (protocol_vvvvwea == 2)
	{
		return true;
	}
	return false;
}

// the vvvvweb function
function vvvvweb(protocol_vvvvweb)
{
	if (isSet(protocol_vvvvweb) && protocol_vvvvweb.constructor !== Array)
	{
		var temp_vvvvweb = protocol_vvvvweb;
		var protocol_vvvvweb = [];
		protocol_vvvvweb.push(temp_vvvvweb);
	}
	else if (!isSet(protocol_vvvvweb))
	{
		var protocol_vvvvweb = [];
	}
	var protocol = protocol_vvvvweb.some(protocol_vvvvweb_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwebvys_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwebvys_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwebvys_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwebvys_required = true;
		}
	}
}

// the vvvvweb Some function
function protocol_vvvvweb_SomeFunc(protocol_vvvvweb)
{
	// set the function logic
	if (protocol_vvvvweb == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwec function
function vvvvwec(protocol_vvvvwec,authentication_vvvvwec)
{
	if (isSet(protocol_vvvvwec) && protocol_vvvvwec.constructor !== Array)
	{
		var temp_vvvvwec = protocol_vvvvwec;
		var protocol_vvvvwec = [];
		protocol_vvvvwec.push(temp_vvvvwec);
	}
	else if (!isSet(protocol_vvvvwec))
	{
		var protocol_vvvvwec = [];
	}
	var protocol = protocol_vvvvwec.some(protocol_vvvvwec_SomeFunc);

	if (isSet(authentication_vvvvwec) && authentication_vvvvwec.constructor !== Array)
	{
		var temp_vvvvwec = authentication_vvvvwec;
		var authentication_vvvvwec = [];
		authentication_vvvvwec.push(temp_vvvvwec);
	}
	else if (!isSet(authentication_vvvvwec))
	{
		var authentication_vvvvwec = [];
	}
	var authentication = authentication_vvvvwec.some(authentication_vvvvwec_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwecvyt_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwecvyt_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwecvyt_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwecvyt_required = true;
		}
	}
}

// the vvvvwec Some function
function protocol_vvvvwec_SomeFunc(protocol_vvvvwec)
{
	// set the function logic
	if (protocol_vvvvwec == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwec Some function
function authentication_vvvvwec_SomeFunc(authentication_vvvvwec)
{
	// set the function logic
	if (authentication_vvvvwec == 1 || authentication_vvvvwec == 3 || authentication_vvvvwec == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwee function
function vvvvwee(protocol_vvvvwee,authentication_vvvvwee)
{
	if (isSet(protocol_vvvvwee) && protocol_vvvvwee.constructor !== Array)
	{
		var temp_vvvvwee = protocol_vvvvwee;
		var protocol_vvvvwee = [];
		protocol_vvvvwee.push(temp_vvvvwee);
	}
	else if (!isSet(protocol_vvvvwee))
	{
		var protocol_vvvvwee = [];
	}
	var protocol = protocol_vvvvwee.some(protocol_vvvvwee_SomeFunc);

	if (isSet(authentication_vvvvwee) && authentication_vvvvwee.constructor !== Array)
	{
		var temp_vvvvwee = authentication_vvvvwee;
		var authentication_vvvvwee = [];
		authentication_vvvvwee.push(temp_vvvvwee);
	}
	else if (!isSet(authentication_vvvvwee))
	{
		var authentication_vvvvwee = [];
	}
	var authentication = authentication_vvvvwee.some(authentication_vvvvwee_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvweevyu_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvweevyu_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvweevyu_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvweevyu_required = true;
		}
	}
}

// the vvvvwee Some function
function protocol_vvvvwee_SomeFunc(protocol_vvvvwee)
{
	// set the function logic
	if (protocol_vvvvwee == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwee Some function
function authentication_vvvvwee_SomeFunc(authentication_vvvvwee)
{
	// set the function logic
	if (authentication_vvvvwee == 2 || authentication_vvvvwee == 3)
	{
		return true;
	}
	return false;
}

// the vvvvweg function
function vvvvweg(protocol_vvvvweg,authentication_vvvvweg)
{
	if (isSet(protocol_vvvvweg) && protocol_vvvvweg.constructor !== Array)
	{
		var temp_vvvvweg = protocol_vvvvweg;
		var protocol_vvvvweg = [];
		protocol_vvvvweg.push(temp_vvvvweg);
	}
	else if (!isSet(protocol_vvvvweg))
	{
		var protocol_vvvvweg = [];
	}
	var protocol = protocol_vvvvweg.some(protocol_vvvvweg_SomeFunc);

	if (isSet(authentication_vvvvweg) && authentication_vvvvweg.constructor !== Array)
	{
		var temp_vvvvweg = authentication_vvvvweg;
		var authentication_vvvvweg = [];
		authentication_vvvvweg.push(temp_vvvvweg);
	}
	else if (!isSet(authentication_vvvvweg))
	{
		var authentication_vvvvweg = [];
	}
	var authentication = authentication_vvvvweg.some(authentication_vvvvweg_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwegvyv_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwegvyv_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwegvyv_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwegvyv_required = true;
		}
	}
}

// the vvvvweg Some function
function protocol_vvvvweg_SomeFunc(protocol_vvvvweg)
{
	// set the function logic
	if (protocol_vvvvweg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvweg Some function
function authentication_vvvvweg_SomeFunc(authentication_vvvvweg)
{
	// set the function logic
	if (authentication_vvvvweg == 4 || authentication_vvvvweg == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwei function
function vvvvwei(protocol_vvvvwei,authentication_vvvvwei)
{
	if (isSet(protocol_vvvvwei) && protocol_vvvvwei.constructor !== Array)
	{
		var temp_vvvvwei = protocol_vvvvwei;
		var protocol_vvvvwei = [];
		protocol_vvvvwei.push(temp_vvvvwei);
	}
	else if (!isSet(protocol_vvvvwei))
	{
		var protocol_vvvvwei = [];
	}
	var protocol = protocol_vvvvwei.some(protocol_vvvvwei_SomeFunc);

	if (isSet(authentication_vvvvwei) && authentication_vvvvwei.constructor !== Array)
	{
		var temp_vvvvwei = authentication_vvvvwei;
		var authentication_vvvvwei = [];
		authentication_vvvvwei.push(temp_vvvvwei);
	}
	else if (!isSet(authentication_vvvvwei))
	{
		var authentication_vvvvwei = [];
	}
	var authentication = authentication_vvvvwei.some(authentication_vvvvwei_SomeFunc);


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

// the vvvvwei Some function
function protocol_vvvvwei_SomeFunc(protocol_vvvvwei)
{
	// set the function logic
	if (protocol_vvvvwei == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwei Some function
function authentication_vvvvwei_SomeFunc(authentication_vvvvwei)
{
	// set the function logic
	if (authentication_vvvvwei == 2 || authentication_vvvvwei == 3 || authentication_vvvvwei == 4 || authentication_vvvvwei == 5)
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
