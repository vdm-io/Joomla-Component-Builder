/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvwccvxm_required = false;
jform_vvvvwccvxn_required = false;
jform_vvvvwccvxo_required = false;
jform_vvvvwccvxp_required = false;
jform_vvvvwccvxq_required = false;
jform_vvvvwcdvxr_required = false;
jform_vvvvwcevxs_required = false;
jform_vvvvwcgvxt_required = false;
jform_vvvvwcivxu_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
{
	var protocol_vvvvwcc = jQuery("#jform_protocol").val();
	vvvvwcc(protocol_vvvvwcc);

	var protocol_vvvvwcd = jQuery("#jform_protocol").val();
	vvvvwcd(protocol_vvvvwcd);

	var protocol_vvvvwce = jQuery("#jform_protocol").val();
	var authentication_vvvvwce = jQuery("#jform_authentication").val();
	vvvvwce(protocol_vvvvwce,authentication_vvvvwce);

	var protocol_vvvvwcg = jQuery("#jform_protocol").val();
	var authentication_vvvvwcg = jQuery("#jform_authentication").val();
	vvvvwcg(protocol_vvvvwcg,authentication_vvvvwcg);

	var protocol_vvvvwci = jQuery("#jform_protocol").val();
	var authentication_vvvvwci = jQuery("#jform_authentication").val();
	vvvvwci(protocol_vvvvwci,authentication_vvvvwci);

	var protocol_vvvvwck = jQuery("#jform_protocol").val();
	var authentication_vvvvwck = jQuery("#jform_authentication").val();
	vvvvwck(protocol_vvvvwck,authentication_vvvvwck);
});

// the vvvvwcc function
function vvvvwcc(protocol_vvvvwcc)
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


	// set this function logic
	if (protocol)
	{
		jQuery('#jform_authentication').closest('.control-group').show();
		// add required attribute to authentication field
		if (jform_vvvvwccvxm_required)
		{
			updateFieldRequired('authentication',0);
			jQuery('#jform_authentication').prop('required','required');
			jQuery('#jform_authentication').attr('aria-required',true);
			jQuery('#jform_authentication').addClass('required');
			jform_vvvvwccvxm_required = false;
		}
		jQuery('#jform_host').closest('.control-group').show();
		// add required attribute to host field
		if (jform_vvvvwccvxn_required)
		{
			updateFieldRequired('host',0);
			jQuery('#jform_host').prop('required','required');
			jQuery('#jform_host').attr('aria-required',true);
			jQuery('#jform_host').addClass('required');
			jform_vvvvwccvxn_required = false;
		}
		jQuery('#jform_port').closest('.control-group').show();
		// add required attribute to port field
		if (jform_vvvvwccvxo_required)
		{
			updateFieldRequired('port',0);
			jQuery('#jform_port').prop('required','required');
			jQuery('#jform_port').attr('aria-required',true);
			jQuery('#jform_port').addClass('required');
			jform_vvvvwccvxo_required = false;
		}
		jQuery('#jform_path').closest('.control-group').show();
		// add required attribute to path field
		if (jform_vvvvwccvxp_required)
		{
			updateFieldRequired('path',0);
			jQuery('#jform_path').prop('required','required');
			jQuery('#jform_path').attr('aria-required',true);
			jQuery('#jform_path').addClass('required');
			jform_vvvvwccvxp_required = false;
		}
		jQuery('.note_ssh_security').closest('.control-group').show();
		jQuery('#jform_username').closest('.control-group').show();
		// add required attribute to username field
		if (jform_vvvvwccvxq_required)
		{
			updateFieldRequired('username',0);
			jQuery('#jform_username').prop('required','required');
			jQuery('#jform_username').attr('aria-required',true);
			jQuery('#jform_username').addClass('required');
			jform_vvvvwccvxq_required = false;
		}
	}
	else
	{
		jQuery('#jform_authentication').closest('.control-group').hide();
		// remove required attribute from authentication field
		if (!jform_vvvvwccvxm_required)
		{
			updateFieldRequired('authentication',1);
			jQuery('#jform_authentication').removeAttr('required');
			jQuery('#jform_authentication').removeAttr('aria-required');
			jQuery('#jform_authentication').removeClass('required');
			jform_vvvvwccvxm_required = true;
		}
		jQuery('#jform_host').closest('.control-group').hide();
		// remove required attribute from host field
		if (!jform_vvvvwccvxn_required)
		{
			updateFieldRequired('host',1);
			jQuery('#jform_host').removeAttr('required');
			jQuery('#jform_host').removeAttr('aria-required');
			jQuery('#jform_host').removeClass('required');
			jform_vvvvwccvxn_required = true;
		}
		jQuery('#jform_port').closest('.control-group').hide();
		// remove required attribute from port field
		if (!jform_vvvvwccvxo_required)
		{
			updateFieldRequired('port',1);
			jQuery('#jform_port').removeAttr('required');
			jQuery('#jform_port').removeAttr('aria-required');
			jQuery('#jform_port').removeClass('required');
			jform_vvvvwccvxo_required = true;
		}
		jQuery('#jform_path').closest('.control-group').hide();
		// remove required attribute from path field
		if (!jform_vvvvwccvxp_required)
		{
			updateFieldRequired('path',1);
			jQuery('#jform_path').removeAttr('required');
			jQuery('#jform_path').removeAttr('aria-required');
			jQuery('#jform_path').removeClass('required');
			jform_vvvvwccvxp_required = true;
		}
		jQuery('.note_ssh_security').closest('.control-group').hide();
		jQuery('#jform_username').closest('.control-group').hide();
		// remove required attribute from username field
		if (!jform_vvvvwccvxq_required)
		{
			updateFieldRequired('username',1);
			jQuery('#jform_username').removeAttr('required');
			jQuery('#jform_username').removeAttr('aria-required');
			jQuery('#jform_username').removeClass('required');
			jform_vvvvwccvxq_required = true;
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

// the vvvvwcd function
function vvvvwcd(protocol_vvvvwcd)
{
	if (isSet(protocol_vvvvwcd) && protocol_vvvvwcd.constructor !== Array)
	{
		var temp_vvvvwcd = protocol_vvvvwcd;
		var protocol_vvvvwcd = [];
		protocol_vvvvwcd.push(temp_vvvvwcd);
	}
	else if (!isSet(protocol_vvvvwcd))
	{
		var protocol_vvvvwcd = [];
	}
	var protocol = protocol_vvvvwcd.some(protocol_vvvvwcd_SomeFunc);


	// set this function logic
	if (protocol)
	{
		jQuery('.note_ftp_signature').closest('.control-group').show();
		jQuery('#jform_signature').closest('.control-group').show();
		// add required attribute to signature field
		if (jform_vvvvwcdvxr_required)
		{
			updateFieldRequired('signature',0);
			jQuery('#jform_signature').prop('required','required');
			jQuery('#jform_signature').attr('aria-required',true);
			jQuery('#jform_signature').addClass('required');
			jform_vvvvwcdvxr_required = false;
		}
	}
	else
	{
		jQuery('.note_ftp_signature').closest('.control-group').hide();
		jQuery('#jform_signature').closest('.control-group').hide();
		// remove required attribute from signature field
		if (!jform_vvvvwcdvxr_required)
		{
			updateFieldRequired('signature',1);
			jQuery('#jform_signature').removeAttr('required');
			jQuery('#jform_signature').removeAttr('aria-required');
			jQuery('#jform_signature').removeClass('required');
			jform_vvvvwcdvxr_required = true;
		}
	}
}

// the vvvvwcd Some function
function protocol_vvvvwcd_SomeFunc(protocol_vvvvwcd)
{
	// set the function logic
	if (protocol_vvvvwcd == 1)
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
		jQuery('#jform_password').closest('.control-group').show();
		// add required attribute to password field
		if (jform_vvvvwcevxs_required)
		{
			updateFieldRequired('password',0);
			jQuery('#jform_password').prop('required','required');
			jQuery('#jform_password').attr('aria-required',true);
			jQuery('#jform_password').addClass('required');
			jform_vvvvwcevxs_required = false;
		}
	}
	else
	{
		jQuery('#jform_password').closest('.control-group').hide();
		// remove required attribute from password field
		if (!jform_vvvvwcevxs_required)
		{
			updateFieldRequired('password',1);
			jQuery('#jform_password').removeAttr('required');
			jQuery('#jform_password').removeAttr('aria-required');
			jQuery('#jform_password').removeClass('required');
			jform_vvvvwcevxs_required = true;
		}
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
	if (authentication_vvvvwce == 1 || authentication_vvvvwce == 3 || authentication_vvvvwce == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwcg function
function vvvvwcg(protocol_vvvvwcg,authentication_vvvvwcg)
{
	if (isSet(protocol_vvvvwcg) && protocol_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = protocol_vvvvwcg;
		var protocol_vvvvwcg = [];
		protocol_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(protocol_vvvvwcg))
	{
		var protocol_vvvvwcg = [];
	}
	var protocol = protocol_vvvvwcg.some(protocol_vvvvwcg_SomeFunc);

	if (isSet(authentication_vvvvwcg) && authentication_vvvvwcg.constructor !== Array)
	{
		var temp_vvvvwcg = authentication_vvvvwcg;
		var authentication_vvvvwcg = [];
		authentication_vvvvwcg.push(temp_vvvvwcg);
	}
	else if (!isSet(authentication_vvvvwcg))
	{
		var authentication_vvvvwcg = [];
	}
	var authentication = authentication_vvvvwcg.some(authentication_vvvvwcg_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private').closest('.control-group').show();
		// add required attribute to private field
		if (jform_vvvvwcgvxt_required)
		{
			updateFieldRequired('private',0);
			jQuery('#jform_private').prop('required','required');
			jQuery('#jform_private').attr('aria-required',true);
			jQuery('#jform_private').addClass('required');
			jform_vvvvwcgvxt_required = false;
		}
	}
	else
	{
		jQuery('#jform_private').closest('.control-group').hide();
		// remove required attribute from private field
		if (!jform_vvvvwcgvxt_required)
		{
			updateFieldRequired('private',1);
			jQuery('#jform_private').removeAttr('required');
			jQuery('#jform_private').removeAttr('aria-required');
			jQuery('#jform_private').removeClass('required');
			jform_vvvvwcgvxt_required = true;
		}
	}
}

// the vvvvwcg Some function
function protocol_vvvvwcg_SomeFunc(protocol_vvvvwcg)
{
	// set the function logic
	if (protocol_vvvvwcg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwcg Some function
function authentication_vvvvwcg_SomeFunc(authentication_vvvvwcg)
{
	// set the function logic
	if (authentication_vvvvwcg == 2 || authentication_vvvvwcg == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwci function
function vvvvwci(protocol_vvvvwci,authentication_vvvvwci)
{
	if (isSet(protocol_vvvvwci) && protocol_vvvvwci.constructor !== Array)
	{
		var temp_vvvvwci = protocol_vvvvwci;
		var protocol_vvvvwci = [];
		protocol_vvvvwci.push(temp_vvvvwci);
	}
	else if (!isSet(protocol_vvvvwci))
	{
		var protocol_vvvvwci = [];
	}
	var protocol = protocol_vvvvwci.some(protocol_vvvvwci_SomeFunc);

	if (isSet(authentication_vvvvwci) && authentication_vvvvwci.constructor !== Array)
	{
		var temp_vvvvwci = authentication_vvvvwci;
		var authentication_vvvvwci = [];
		authentication_vvvvwci.push(temp_vvvvwci);
	}
	else if (!isSet(authentication_vvvvwci))
	{
		var authentication_vvvvwci = [];
	}
	var authentication = authentication_vvvvwci.some(authentication_vvvvwci_SomeFunc);


	// set this function logic
	if (protocol && authentication)
	{
		jQuery('#jform_private_key').closest('.control-group').show();
		// add required attribute to private_key field
		if (jform_vvvvwcivxu_required)
		{
			updateFieldRequired('private_key',0);
			jQuery('#jform_private_key').prop('required','required');
			jQuery('#jform_private_key').attr('aria-required',true);
			jQuery('#jform_private_key').addClass('required');
			jform_vvvvwcivxu_required = false;
		}
	}
	else
	{
		jQuery('#jform_private_key').closest('.control-group').hide();
		// remove required attribute from private_key field
		if (!jform_vvvvwcivxu_required)
		{
			updateFieldRequired('private_key',1);
			jQuery('#jform_private_key').removeAttr('required');
			jQuery('#jform_private_key').removeAttr('aria-required');
			jQuery('#jform_private_key').removeClass('required');
			jform_vvvvwcivxu_required = true;
		}
	}
}

// the vvvvwci Some function
function protocol_vvvvwci_SomeFunc(protocol_vvvvwci)
{
	// set the function logic
	if (protocol_vvvvwci == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwci Some function
function authentication_vvvvwci_SomeFunc(authentication_vvvvwci)
{
	// set the function logic
	if (authentication_vvvvwci == 4 || authentication_vvvvwci == 5)
	{
		return true;
	}
	return false;
}

// the vvvvwck function
function vvvvwck(protocol_vvvvwck,authentication_vvvvwck)
{
	if (isSet(protocol_vvvvwck) && protocol_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = protocol_vvvvwck;
		var protocol_vvvvwck = [];
		protocol_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(protocol_vvvvwck))
	{
		var protocol_vvvvwck = [];
	}
	var protocol = protocol_vvvvwck.some(protocol_vvvvwck_SomeFunc);

	if (isSet(authentication_vvvvwck) && authentication_vvvvwck.constructor !== Array)
	{
		var temp_vvvvwck = authentication_vvvvwck;
		var authentication_vvvvwck = [];
		authentication_vvvvwck.push(temp_vvvvwck);
	}
	else if (!isSet(authentication_vvvvwck))
	{
		var authentication_vvvvwck = [];
	}
	var authentication = authentication_vvvvwck.some(authentication_vvvvwck_SomeFunc);


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

// the vvvvwck Some function
function protocol_vvvvwck_SomeFunc(protocol_vvvvwck)
{
	// set the function logic
	if (protocol_vvvvwck == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwck Some function
function authentication_vvvvwck_SomeFunc(authentication_vvvvwck)
{
	// set the function logic
	if (authentication_vvvvwck == 2 || authentication_vvvvwck == 3 || authentication_vvvvwck == 4 || authentication_vvvvwck == 5)
	{
		return true;
	}
	return false;
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (document.getElementById('jform_not_required')) {
		var not_required = jQuery('#jform_not_required').val().split(",");

		if(status == 1)
		{
			not_required.push(name);
		}
		else
		{
			not_required = removeFieldFromNotRequired(not_required, name);
		}

		jQuery('#jform_not_required').val(fixNotRequiredArray(not_required).toString());
	}
}

// remove field from not_required
function removeFieldFromNotRequired(array, what) {
	return array.filter(function(element){
		return element !== what;
	});
}

// fix not required array
function fixNotRequiredArray(array) {
	var seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function(item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

// remove empty from not_required array
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		// remove ( 一_一) as well - lol
		return (el.length > 0 && '一_一' !== el);
	});
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
}
