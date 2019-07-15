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
jform_vvvvwaovxe_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var extension_type_vvvvwao = jQuery("#jform_extension_type").val();
	vvvvwao(extension_type_vvvvwao);
});

// the vvvvwao function
function vvvvwao(extension_type_vvvvwao)
{
	if (isSet(extension_type_vvvvwao) && extension_type_vvvvwao.constructor !== Array)
	{
		var temp_vvvvwao = extension_type_vvvvwao;
		var extension_type_vvvvwao = [];
		extension_type_vvvvwao.push(temp_vvvvwao);
	}
	else if (!isSet(extension_type_vvvvwao))
	{
		var extension_type_vvvvwao = [];
	}
	var extension_type = extension_type_vvvvwao.some(extension_type_vvvvwao_SomeFunc);


	// set this function logic
	if (extension_type)
	{
		jQuery('#jform_joomla_plugin_group').closest('.control-group').show();
		// add required attribute to joomla_plugin_group field
		if (jform_vvvvwaovxe_required)
		{
			updateFieldRequired('joomla_plugin_group',0);
			jQuery('#jform_joomla_plugin_group').prop('required','required');
			jQuery('#jform_joomla_plugin_group').attr('aria-required',true);
			jQuery('#jform_joomla_plugin_group').addClass('required');
			jform_vvvvwaovxe_required = false;
		}
	}
	else
	{
		jQuery('#jform_joomla_plugin_group').closest('.control-group').hide();
		// remove required attribute from joomla_plugin_group field
		if (!jform_vvvvwaovxe_required)
		{
			updateFieldRequired('joomla_plugin_group',1);
			jQuery('#jform_joomla_plugin_group').removeAttr('required');
			jQuery('#jform_joomla_plugin_group').removeAttr('aria-required');
			jQuery('#jform_joomla_plugin_group').removeClass('required');
			jform_vvvvwaovxe_required = true;
		}
	}
}

// the vvvvwao Some function
function extension_type_vvvvwao_SomeFunc(extension_type_vvvvwao)
{
	// set the function logic
	if (extension_type_vvvvwao == 'plugins' || extension_type_vvvvwao == 'plugin')
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
