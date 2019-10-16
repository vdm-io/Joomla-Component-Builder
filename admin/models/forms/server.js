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
jform_vvvvwddvyj_required = false;
jform_vvvvwddvyk_required = false;
jform_vvvvwddvyl_required = false;
jform_vvvvwddvym_required = false;
jform_vvvvwddvyn_required = false;
jform_vvvvwdevyo_required = false;
jform_vvvvwdfvyp_required = false;
jform_vvvvwdhvyq_required = false;
jform_vvvvwdjvyr_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var protocol_vvvvwdd = jQuery("#jform_protocol").val();
	vvvvwdd(protocol_vvvvwdd);

	var protocol_vvvvwde = jQuery("#jform_protocol").val();
	vvvvwde(protocol_vvvvwde);

	var protocol_vvvvwdf = jQuery("#jform_protocol").val();
	var authentication_vvvvwdf = jQuery("#jform_authentication").val();
	vvvvwdf(protocol_vvvvwdf,authentication_vvvvwdf);

	var protocol_vvvvwdh = jQuery("#jform_protocol").val();
	var authentication_vvvvwdh = jQuery("#jform_authentication").val();
	vvvvwdh(protocol_vvvvwdh,authentication_vvvvwdh);

	var protocol_vvvvwdj = jQuery("#jform_protocol").val();
	var authentication_vvvvwdj = jQuery("#jform_authentication").val();
	vvvvwdj(protocol_vvvvwdj,authentication_vvvvwdj);

	var protocol_vvvvwdl = jQuery("#jform_protocol").val();
	var authentication_vvvvwdl = jQuery("#jform_authentication").val();
	vvvvwdl(protocol_vvvvwdl,authentication_vvvvwdl);
});

// the vvvvwdd function
function vvvvwdd(protocol_vvvvwdd)
{
	if (isSet(protocol_vvvvwdd) && protocol_vvvvwdd.constructor !== Array)
	{
		var temp_vvvvwdd = protocol_vvvvwdd;
		var protocol_vvvvwdd = [];
		protocol_vvvvwdd.push(temp_vvvvwdd);
	}
	else if (!isSet(protocol_vvvvwdd))
	{
		var protocol_vvvvwdd = [];
	}
	var protocol = protocol_vvvvwdd.some(protocol_vvvvwdd_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwddvyj_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwddvyj_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwddvyk_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwddvyk_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwddvyl_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwddvyl_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwddvym_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwddvym_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwddvyn_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwddvyn_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwddvyj_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwddvyj_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwddvyk_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwddvyk_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwddvyl_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwddvyl_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwddvym_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwddvym_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwddvyn_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwddvyn_required = true;
		}
	}
}

// the vvvvwdd Some function
function protocol_vvvvwdd_SomeFunc(protocol_vvvvwdd)
{
	// set the function logic
	if (protocol_vvvvwdd == 2)
	{
		return true;
	}
	return false;
}

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
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwdevyo_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwdevyo_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwdevyo_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwdevyo_required = true;
		}
	}
}

// the vvvvwde Some function
function protocol_vvvvwde_SomeFunc(protocol_vvvvwde)
{
	// set the function logic
	if (protocol_vvvvwde == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwdf function
function vvvvwdf(protocol_vvvvwdf,authentication_vvvvwdf)
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

	if (isSet(authentication_vvvvwdf) && authentication_vvvvwdf.constructor !== Array)
	{
		var temp_vvvvwdf = authentication_vvvvwdf;
		var authentication_vvvvwdf = [];
		authentication_vvvvwdf.push(temp_vvvvwdf);
	}
	else if (!isSet(authentication_vvvvwdf))
	{
		var authentication_vvvvwdf = [];
	}
	var authentication = authentication_vvvvwdf.some(authentication_vvvvwdf_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwdfvyp_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwdfvyp_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwdfvyp_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwdfvyp_required = true;
		}
	}
}

// the vvvvwdf Some function
function protocol_vvvvwdf_SomeFunc(protocol_vvvvwdf)
{
	// set the function logic
	if (protocol_vvvvwdf == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdf Some function
function authentication_vvvvwdf_SomeFunc(authentication_vvvvwdf)
{
	// set the function logic
	if (authentication_vvvvwdf == 1 || authentication_vvvvwdf == 3 || authentication_vvvvwdf == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwdh function
function vvvvwdh(protocol_vvvvwdh,authentication_vvvvwdh)
{
	if (isSet(protocol_vvvvwdh) && protocol_vvvvwdh.constructor !== Array)
	{
		var temp_vvvvwdh = protocol_vvvvwdh;
		var protocol_vvvvwdh = [];
		protocol_vvvvwdh.push(temp_vvvvwdh);
	}
	else if (!isSet(protocol_vvvvwdh))
	{
		var protocol_vvvvwdh = [];
	}
	var protocol = protocol_vvvvwdh.some(protocol_vvvvwdh_SomeFunc);

	if (isSet(authentication_vvvvwdh) && authentication_vvvvwdh.constructor !== Array)
	{
		var temp_vvvvwdh = authentication_vvvvwdh;
		var authentication_vvvvwdh = [];
		authentication_vvvvwdh.push(temp_vvvvwdh);
	}
	else if (!isSet(authentication_vvvvwdh))
	{
		var authentication_vvvvwdh = [];
	}
	var authentication = authentication_vvvvwdh.some(authentication_vvvvwdh_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwdhvyq_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwdhvyq_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwdhvyq_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwdhvyq_required = true;
		}
	}
}

// the vvvvwdh Some function
function protocol_vvvvwdh_SomeFunc(protocol_vvvvwdh)
{
	// set the function logic
	if (protocol_vvvvwdh == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdh Some function
function authentication_vvvvwdh_SomeFunc(authentication_vvvvwdh)
{
	// set the function logic
	if (authentication_vvvvwdh == 2 || authentication_vvvvwdh == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwdj function
function vvvvwdj(protocol_vvvvwdj,authentication_vvvvwdj)
{
	if (isSet(protocol_vvvvwdj) && protocol_vvvvwdj.constructor !== Array)
	{
		var temp_vvvvwdj = protocol_vvvvwdj;
		var protocol_vvvvwdj = [];
		protocol_vvvvwdj.push(temp_vvvvwdj);
	}
	else if (!isSet(protocol_vvvvwdj))
	{
		var protocol_vvvvwdj = [];
	}
	var protocol = protocol_vvvvwdj.some(protocol_vvvvwdj_SomeFunc);

	if (isSet(authentication_vvvvwdj) && authentication_vvvvwdj.constructor !== Array)
	{
		var temp_vvvvwdj = authentication_vvvvwdj;
		var authentication_vvvvwdj = [];
		authentication_vvvvwdj.push(temp_vvvvwdj);
	}
	else if (!isSet(authentication_vvvvwdj))
	{
		var authentication_vvvvwdj = [];
	}
	var authentication = authentication_vvvvwdj.some(authentication_vvvvwdj_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwdjvyr_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwdjvyr_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwdjvyr_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwdjvyr_required = true;
		}
	}
}

// the vvvvwdj Some function
function protocol_vvvvwdj_SomeFunc(protocol_vvvvwdj)
{
	// set the function logic
	if (protocol_vvvvwdj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdj Some function
function authentication_vvvvwdj_SomeFunc(authentication_vvvvwdj)
{
	// set the function logic
	if (authentication_vvvvwdj == 4 || authentication_vvvvwdj == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwdl function
function vvvvwdl(protocol_vvvvwdl,authentication_vvvvwdl)
{
	if (isSet(protocol_vvvvwdl) && protocol_vvvvwdl.constructor !== Array)
	{
		var temp_vvvvwdl = protocol_vvvvwdl;
		var protocol_vvvvwdl = [];
		protocol_vvvvwdl.push(temp_vvvvwdl);
	}
	else if (!isSet(protocol_vvvvwdl))
	{
		var protocol_vvvvwdl = [];
	}
	var protocol = protocol_vvvvwdl.some(protocol_vvvvwdl_SomeFunc);

	if (isSet(authentication_vvvvwdl) && authentication_vvvvwdl.constructor !== Array)
	{
		var temp_vvvvwdl = authentication_vvvvwdl;
		var authentication_vvvvwdl = [];
		authentication_vvvvwdl.push(temp_vvvvwdl);
	}
	else if (!isSet(authentication_vvvvwdl))
	{
		var authentication_vvvvwdl = [];
	}
	var authentication = authentication_vvvvwdl.some(authentication_vvvvwdl_SomeFunc);


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

// the vvvvwdl Some function
function protocol_vvvvwdl_SomeFunc(protocol_vvvvwdl)
{
	// set the function logic
	if (protocol_vvvvwdl == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwdl Some function
function authentication_vvvvwdl_SomeFunc(authentication_vvvvwdl)
{
	// set the function logic
	if (authentication_vvvvwdl == 2 || authentication_vvvvwdl == 3 || authentication_vvvvwdl == 4 || authentication_vvvvwdl == 5)
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
