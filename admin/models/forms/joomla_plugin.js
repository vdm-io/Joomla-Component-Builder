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
jform_vvvvvxevwd_required = false;
jform_vvvvvxtvwe_required = false;
jform_vvvvvxuvwf_required = false;
jform_vvvvvxvvwg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var class_extends_vvvvvxb = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxb = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxb(class_extends_vvvvvxb,joomla_plugin_group_vvvvvxb);

	var joomla_plugin_group_vvvvvxc = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxc = jQuery("#jform_class_extends").val();
	vvvvvxc(joomla_plugin_group_vvvvvxc,class_extends_vvvvvxc);

	var class_extends_vvvvvxd = jQuery("#jform_class_extends").val();
	vvvvvxd(class_extends_vvvvvxd);

	var add_head_vvvvvxe = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvxe = jQuery("#jform_class_extends").val();
	vvvvvxe(add_head_vvvvvxe,class_extends_vvvvvxe);

	var add_php_script_construct_vvvvvxg = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvxg(add_php_script_construct_vvvvvxg);

	var add_php_preflight_install_vvvvvxh = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvxh(add_php_preflight_install_vvvvvxh);

	var add_php_preflight_update_vvvvvxi = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvxi(add_php_preflight_update_vvvvvxi);

	var add_php_preflight_uninstall_vvvvvxj = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvxj(add_php_preflight_uninstall_vvvvvxj);

	var add_php_postflight_install_vvvvvxk = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvxk(add_php_postflight_install_vvvvvxk);

	var add_php_postflight_update_vvvvvxl = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvxl(add_php_postflight_update_vvvvvxl);

	var add_php_method_uninstall_vvvvvxm = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvxm(add_php_method_uninstall_vvvvvxm);

	var update_server_target_vvvvvxn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxn(update_server_target_vvvvvxn,add_update_server_vvvvvxn);

	var add_update_server_vvvvvxo = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvxo = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvxo(add_update_server_vvvvvxo,update_server_target_vvvvvxo);

	var update_server_target_vvvvvxp = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxp(update_server_target_vvvvvxp,add_update_server_vvvvvxp);

	var update_server_target_vvvvvxr = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvxr = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxr(update_server_target_vvvvvxr,add_update_server_vvvvvxr);

	var add_update_server_vvvvvxt = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxt(add_update_server_vvvvvxt);

	var add_sql_vvvvvxu = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvxu(add_sql_vvvvvxu);

	var add_sql_uninstall_vvvvvxv = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvxv(add_sql_uninstall_vvvvvxv);

	var add_update_server_vvvvvxw = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvxw(add_update_server_vvvvvxw);

	var add_sales_server_vvvvvxx = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvxx(add_sales_server_vvvvvxx);

	var addreadme_vvvvvxy = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvxy(addreadme_vvvvvxy);
});

// the vvvvvxb function
function vvvvvxb(class_extends_vvvvvxb,joomla_plugin_group_vvvvvxb)
{
	if (isSet(class_extends_vvvvvxb) && class_extends_vvvvvxb.constructor !== Array)
	{
		var temp_vvvvvxb = class_extends_vvvvvxb;
		var class_extends_vvvvvxb = [];
		class_extends_vvvvvxb.push(temp_vvvvvxb);
	}
	else if (!isSet(class_extends_vvvvvxb))
	{
		var class_extends_vvvvvxb = [];
	}
	var class_extends = class_extends_vvvvvxb.some(class_extends_vvvvvxb_SomeFunc);

	if (isSet(joomla_plugin_group_vvvvvxb) && joomla_plugin_group_vvvvvxb.constructor !== Array)
	{
		var temp_vvvvvxb = joomla_plugin_group_vvvvvxb;
		var joomla_plugin_group_vvvvvxb = [];
		joomla_plugin_group_vvvvvxb.push(temp_vvvvvxb);
	}
	else if (!isSet(joomla_plugin_group_vvvvvxb))
	{
		var joomla_plugin_group_vvvvvxb = [];
	}
	var joomla_plugin_group = joomla_plugin_group_vvvvvxb.some(joomla_plugin_group_vvvvvxb_SomeFunc);


	// set this function logic
	if (class_extends && joomla_plugin_group)
	{
		jQuery('#jform_main_class_code-lbl').closest('.control-group').show();
		jQuery('#jform_method_selection-lbl').closest('.control-group').show();
		jQuery('#jform_property_selection-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_main_class_code-lbl').closest('.control-group').hide();
		jQuery('#jform_method_selection-lbl').closest('.control-group').hide();
		jQuery('#jform_property_selection-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxb Some function
function class_extends_vvvvvxb_SomeFunc(class_extends_vvvvvxb)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxb))
	{
		return true;
	}
	return false;
}

// the vvvvvxb Some function
function joomla_plugin_group_vvvvvxb_SomeFunc(joomla_plugin_group_vvvvvxb)
{
	// set the function logic
	if (isSet(joomla_plugin_group_vvvvvxb))
	{
		return true;
	}
	return false;
}

// the vvvvvxc function
function vvvvvxc(joomla_plugin_group_vvvvvxc,class_extends_vvvvvxc)
{
	if (isSet(joomla_plugin_group_vvvvvxc) && joomla_plugin_group_vvvvvxc.constructor !== Array)
	{
		var temp_vvvvvxc = joomla_plugin_group_vvvvvxc;
		var joomla_plugin_group_vvvvvxc = [];
		joomla_plugin_group_vvvvvxc.push(temp_vvvvvxc);
	}
	else if (!isSet(joomla_plugin_group_vvvvvxc))
	{
		var joomla_plugin_group_vvvvvxc = [];
	}
	var joomla_plugin_group = joomla_plugin_group_vvvvvxc.some(joomla_plugin_group_vvvvvxc_SomeFunc);

	if (isSet(class_extends_vvvvvxc) && class_extends_vvvvvxc.constructor !== Array)
	{
		var temp_vvvvvxc = class_extends_vvvvvxc;
		var class_extends_vvvvvxc = [];
		class_extends_vvvvvxc.push(temp_vvvvvxc);
	}
	else if (!isSet(class_extends_vvvvvxc))
	{
		var class_extends_vvvvvxc = [];
	}
	var class_extends = class_extends_vvvvvxc.some(class_extends_vvvvvxc_SomeFunc);


	// set this function logic
	if (joomla_plugin_group && class_extends)
	{
		jQuery('#jform_main_class_code-lbl').closest('.control-group').show();
		jQuery('#jform_method_selection-lbl').closest('.control-group').show();
		jQuery('#jform_property_selection-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_main_class_code-lbl').closest('.control-group').hide();
		jQuery('#jform_method_selection-lbl').closest('.control-group').hide();
		jQuery('#jform_property_selection-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxc Some function
function joomla_plugin_group_vvvvvxc_SomeFunc(joomla_plugin_group_vvvvvxc)
{
	// set the function logic
	if (isSet(joomla_plugin_group_vvvvvxc))
	{
		return true;
	}
	return false;
}

// the vvvvvxc Some function
function class_extends_vvvvvxc_SomeFunc(class_extends_vvvvvxc)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxc))
	{
		return true;
	}
	return false;
}

// the vvvvvxd function
function vvvvvxd(class_extends_vvvvvxd)
{
	if (isSet(class_extends_vvvvvxd) && class_extends_vvvvvxd.constructor !== Array)
	{
		var temp_vvvvvxd = class_extends_vvvvvxd;
		var class_extends_vvvvvxd = [];
		class_extends_vvvvvxd.push(temp_vvvvvxd);
	}
	else if (!isSet(class_extends_vvvvvxd))
	{
		var class_extends_vvvvvxd = [];
	}
	var class_extends = class_extends_vvvvvxd.some(class_extends_vvvvvxd_SomeFunc);


	// set this function logic
	if (class_extends)
	{
		jQuery('#jform_add_head').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_add_head').closest('.control-group').hide();
	}
}

// the vvvvvxd Some function
function class_extends_vvvvvxd_SomeFunc(class_extends_vvvvvxd)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxd))
	{
		return true;
	}
	return false;
}

// the vvvvvxe function
function vvvvvxe(add_head_vvvvvxe,class_extends_vvvvvxe)
{
	if (isSet(add_head_vvvvvxe) && add_head_vvvvvxe.constructor !== Array)
	{
		var temp_vvvvvxe = add_head_vvvvvxe;
		var add_head_vvvvvxe = [];
		add_head_vvvvvxe.push(temp_vvvvvxe);
	}
	else if (!isSet(add_head_vvvvvxe))
	{
		var add_head_vvvvvxe = [];
	}
	var add_head = add_head_vvvvvxe.some(add_head_vvvvvxe_SomeFunc);

	if (isSet(class_extends_vvvvvxe) && class_extends_vvvvvxe.constructor !== Array)
	{
		var temp_vvvvvxe = class_extends_vvvvvxe;
		var class_extends_vvvvvxe = [];
		class_extends_vvvvvxe.push(temp_vvvvvxe);
	}
	else if (!isSet(class_extends_vvvvvxe))
	{
		var class_extends_vvvvvxe = [];
	}
	var class_extends = class_extends_vvvvvxe.some(class_extends_vvvvvxe_SomeFunc);


	// set this function logic
	if (add_head && class_extends)
	{
		jQuery('#jform_head-lbl').closest('.control-group').show();
		// add required attribute to head field
		if (jform_vvvvvxevwd_required)
		{
			updateFieldRequired('head',0);
			jQuery('#jform_head').prop('required','required');
			jQuery('#jform_head').attr('aria-required',true);
			jQuery('#jform_head').addClass('required');
			jform_vvvvvxevwd_required = false;
		}
	}
	else
	{
		jQuery('#jform_head-lbl').closest('.control-group').hide();
		// remove required attribute from head field
		if (!jform_vvvvvxevwd_required)
		{
			updateFieldRequired('head',1);
			jQuery('#jform_head').removeAttr('required');
			jQuery('#jform_head').removeAttr('aria-required');
			jQuery('#jform_head').removeClass('required');
			jform_vvvvvxevwd_required = true;
		}
	}
}

// the vvvvvxe Some function
function add_head_vvvvvxe_SomeFunc(add_head_vvvvvxe)
{
	// set the function logic
	if (add_head_vvvvvxe == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvxe Some function
function class_extends_vvvvvxe_SomeFunc(class_extends_vvvvvxe)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxe))
	{
		return true;
	}
	return false;
}

// the vvvvvxg function
function vvvvvxg(add_php_script_construct_vvvvvxg)
{
	// set the function logic
	if (add_php_script_construct_vvvvvxg == 1)
	{
		jQuery('#jform_php_script_construct-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_script_construct-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxh function
function vvvvvxh(add_php_preflight_install_vvvvvxh)
{
	// set the function logic
	if (add_php_preflight_install_vvvvvxh == 1)
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxi function
function vvvvvxi(add_php_preflight_update_vvvvvxi)
{
	// set the function logic
	if (add_php_preflight_update_vvvvvxi == 1)
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxj function
function vvvvvxj(add_php_preflight_uninstall_vvvvvxj)
{
	// set the function logic
	if (add_php_preflight_uninstall_vvvvvxj == 1)
	{
		jQuery('#jform_php_preflight_uninstall-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_uninstall-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxk function
function vvvvvxk(add_php_postflight_install_vvvvvxk)
{
	// set the function logic
	if (add_php_postflight_install_vvvvvxk == 1)
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxl function
function vvvvvxl(add_php_postflight_update_vvvvvxl)
{
	// set the function logic
	if (add_php_postflight_update_vvvvvxl == 1)
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxm function
function vvvvvxm(add_php_method_uninstall_vvvvvxm)
{
	// set the function logic
	if (add_php_method_uninstall_vvvvvxm == 1)
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').hide();
	}
}

// the vvvvvxn function
function vvvvvxn(update_server_target_vvvvvxn,add_update_server_vvvvvxn)
{
	// set the function logic
	if (update_server_target_vvvvvxn == 1 && add_update_server_vvvvvxn == 1)
	{
		jQuery('#jform_update_server').closest('.control-group').show();
		jQuery('.note_update_server_note_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server').closest('.control-group').hide();
		jQuery('.note_update_server_note_ftp').closest('.control-group').hide();
	}
}

// the vvvvvxo function
function vvvvvxo(add_update_server_vvvvvxo,update_server_target_vvvvvxo)
{
	// set the function logic
	if (add_update_server_vvvvvxo == 1 && update_server_target_vvvvvxo == 1)
	{
		jQuery('#jform_update_server').closest('.control-group').show();
		jQuery('.note_update_server_note_ftp').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server').closest('.control-group').hide();
		jQuery('.note_update_server_note_ftp').closest('.control-group').hide();
	}
}

// the vvvvvxp function
function vvvvvxp(update_server_target_vvvvvxp,add_update_server_vvvvvxp)
{
	// set the function logic
	if (update_server_target_vvvvvxp == 2 && add_update_server_vvvvvxp == 1)
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').hide();
	}
}

// the vvvvvxr function
function vvvvvxr(update_server_target_vvvvvxr,add_update_server_vvvvvxr)
{
	// set the function logic
	if (update_server_target_vvvvvxr == 3 && add_update_server_vvvvvxr == 1)
	{
		jQuery('.note_update_server_note_other').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_other').closest('.control-group').hide();
	}
}

// the vvvvvxt function
function vvvvvxt(add_update_server_vvvvvxt)
{
	// set the function logic
	if (add_update_server_vvvvvxt == 1)
	{
		jQuery('#jform_update_server_target').closest('.control-group').show();
		// add required attribute to update_server_target field
		if (jform_vvvvvxtvwe_required)
		{
			updateFieldRequired('update_server_target',0);
			jQuery('#jform_update_server_target').prop('required','required');
			jQuery('#jform_update_server_target').attr('aria-required',true);
			jQuery('#jform_update_server_target').addClass('required');
			jform_vvvvvxtvwe_required = false;
		}
	}
	else
	{
		jQuery('#jform_update_server_target').closest('.control-group').hide();
		// remove required attribute from update_server_target field
		if (!jform_vvvvvxtvwe_required)
		{
			updateFieldRequired('update_server_target',1);
			jQuery('#jform_update_server_target').removeAttr('required');
			jQuery('#jform_update_server_target').removeAttr('aria-required');
			jQuery('#jform_update_server_target').removeClass('required');
			jform_vvvvvxtvwe_required = true;
		}
	}
}

// the vvvvvxu function
function vvvvvxu(add_sql_vvvvvxu)
{
	// set the function logic
	if (add_sql_vvvvvxu == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		// add required attribute to sql field
		if (jform_vvvvvxuvwf_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvxuvwf_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		// remove required attribute from sql field
		if (!jform_vvvvvxuvwf_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvxuvwf_required = true;
		}
	}
}

// the vvvvvxv function
function vvvvvxv(add_sql_uninstall_vvvvvxv)
{
	// set the function logic
	if (add_sql_uninstall_vvvvvxv == 1)
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').show();
		// add required attribute to sql_uninstall field
		if (jform_vvvvvxvvwg_required)
		{
			updateFieldRequired('sql_uninstall',0);
			jQuery('#jform_sql_uninstall').prop('required','required');
			jQuery('#jform_sql_uninstall').attr('aria-required',true);
			jQuery('#jform_sql_uninstall').addClass('required');
			jform_vvvvvxvvwg_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').hide();
		// remove required attribute from sql_uninstall field
		if (!jform_vvvvvxvvwg_required)
		{
			updateFieldRequired('sql_uninstall',1);
			jQuery('#jform_sql_uninstall').removeAttr('required');
			jQuery('#jform_sql_uninstall').removeAttr('aria-required');
			jQuery('#jform_sql_uninstall').removeClass('required');
			jform_vvvvvxvvwg_required = true;
		}
	}
}

// the vvvvvxw function
function vvvvvxw(add_update_server_vvvvvxw)
{
	// set the function logic
	if (add_update_server_vvvvvxw == 1)
	{
		jQuery('#jform_update_server_url').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server_url').closest('.control-group').hide();
	}
}

// the vvvvvxx function
function vvvvvxx(add_sales_server_vvvvvxx)
{
	// set the function logic
	if (add_sales_server_vvvvvxx == 1)
	{
		jQuery('#jform_sales_server').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_sales_server').closest('.control-group').hide();
	}
}

// the vvvvvxy function
function vvvvvxy(addreadme_vvvvvxy)
{
	// set the function logic
	if (addreadme_vvvvvxy == 1)
	{
		jQuery('#jform_readme-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_readme-lbl').closest('.control-group').hide();
	}
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


jQuery(document).ready(function()
{
	// get the linked details
	getLinked();
	// load the active array values
	buildSelectionMemory('property');
	buildSelectionMemory('method');
	// load the active selection array values
	getClassCodeIds('joomla_plugin_group', 'jform_class_extends', false);
	getClassCodeIds('property', 'jform_joomla_plugin_group', false);
	getClassCodeIds('method', 'jform_joomla_plugin_group', false);
	// check and load all the customcode edit buttons
	setTimeout(getEditCustomCodeButtons, 300);
	// trigger the row watcher
	rowWatcher();
});

// set selection the options
selectionMemory = {'property':{},'method':{}};
selectionActiveArray = {'property':{},'method':{}};
selectedIdRemoved = {'property':'not','method':'not'};

function buildSelectionMemory(type) {
	var i;
	for (i = 0; i < 70; i++) {
		// build ID
		var id_check = 'jform_'+type+'_selection'+'__'+type+'_selection'+i+'__'+type;
		// set memory
		if (jQuery("#"+id_check).length) {
			selectionMemory[type][id_check] = jQuery("#"+id_check+" option:selected").val();
		}
	}
}

function getClassStuff_server(id, type, callingName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax."+callingName+"&format=json&raw=true");
	if(token.length > 0 && id > 0 && type.length > 0){
		var request = token+'=1&type=' + type + '&id=' + id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getClassHeaderCode(){
	// now get the values
	var value = jQuery("#jform_class_extends  option:selected").val();
	var add_value = jQuery("#jform_add_head input[type='radio']:checked").val();
	if (add_value == 1 && value > 0){
		// we first check local memory
		var _result = jQuery.jStorage.get('extends_header_'+value, null);
		if (_result) {
				// now set the code
				addCodeToEditor(_result, "jform_head", false);
		} else {
			// now get the code
			getClassStuff_server(value, 'extends', 'getClassHeaderCode').done(function(result) {
				if(result){
					// now set the code
					addCodeToEditor(result, "jform_head", false);
					// add result to local memory
					jQuery.jStorage.set('extends_header_'+value, result, {TTL: expire});
				}
			});
		}
	}
}

function getClassCodeIds(type, target_field, reset_all){
	// now get the value
	var value = jQuery('#'+target_field).val();
	// now get the code
	getClassStuff_server(value, type, 'getClassCodeIds').done(function(result) {
		if(result){
			// reset the selection
			selectionActiveArray[type] = {};
			// update the active array
			jQuery.each(result, function(i, prop) {
				selectionActiveArray[type][prop] = selectionArray[type][prop];
			});
			// update the active field selection
			updateActiveFieldSelection(type, reset_all);
		}
	});
}

function updateActiveFieldSelection(type, reset_all){
	// update the selection options
	if ('joomla_plugin_group' === type) {
		// get value if not going to reset all
		if (!reset_all){
			// get the active values
			var activeValue =  jQuery("#jform_"+type+" option:selected").val();
			var activeText =  jQuery("#jform_"+type+" option:selected").text();
			// clear the options out
			jQuery("#jform_"+type).find('option').remove().end();
			// add the active selection back (must be what is available)
			jQuery("#jform_"+type).append('<option value="'+activeValue+'">'+activeText+'</option>');
			// now add the lists back
			jQuery.each( selectionActiveArray[type], function(aValue, aText ) {
				if (activeValue !== aValue) {
					jQuery("#jform_"+type).append('<option value="'+aValue+'">'+aText+'</option>');
				}
			});
			jQuery("#jform_"+type).val(activeValue);			
		} else {
			// clear the options out
			jQuery("#jform_"+type).find('option').remove().end();
			// now add the lists back
			jQuery.each( selectionActiveArray[type], function(aValue, aText ) {
				jQuery("#jform_"+type).append('<option value="'+aValue+'">'+aText+'</option>');
			});
			jQuery("#jform_"+type).val('');
		}
		jQuery("#jform_"+type).trigger('liszt:updated');
		// reset all when global update is made
		if (reset_all) {
			resetAll('method');
			resetAll('property');
		}
	} else {
		selectionDynamicUpdate(type);
		// reset all when global update is made
		if (reset_all) {
			resetAll(type);
		}
	}
}

function resetAll(type) {
	var i;
	for (i = 0; i < 10; i++) {
		// build ID
		var id_check = 'jform_'+type+'_selection'+'__'+type+'_selection'+i+'__'+type;
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length) {
			if (i == 0) {
				jQuery('#'+id_check).val('');
				jQuery('#'+id_check).trigger('liszt:updated');
			} else {
				// remove the row
				jQuery('#'+id_check).closest('tr').remove();
			}
		}
	}
	Joomla.editors.instances['jform_main_class_code'].setValue('');
	selectionMemory = {'property':{},'method':{}};
}

function getClassCode(field, type){
	// get the ID
	var id = jQuery(field).attr('id');
	// now get the value
	var value = jQuery('#' + id).val();
	// check if we have a memory for this field, if true remove code of old selection and clear memory
	if (selectionMemory[type].hasOwnProperty(id) && selectionMemory[type][id] > 0) {
		// the old id to remove
		var old_value = selectionMemory[type][id];
		// remove the code // we first check local memory
		var _result = jQuery.jStorage.get('code_4_'+type+'_'+old_value, null);
		if (_result) {
			// now remove the code
			if (removeCodeFromEditor(_result)) {
				selectionMemory[type][id] = 0;
			}
		} else {
			// now get the code
			getClassStuff_server(old_value, type, 'getClassCode').done(function(result) {
				if(result){
					// now remove the code
					if (removeCodeFromEditor(result)) {
						selectionMemory[type][id] = 0;
					}
					// add result to local memory
					jQuery.jStorage.set('code_4_'+type+'_'+old_value, result, {TTL: expire});
				}
			});
		}
	}
	if (propertyIsSet(value, id, type)) {
		// reset the selection
		jQuery('#'+id).val('');
		jQuery('#'+id).trigger("liszt:updated");
		// give out a notice
		jQuery.UIkit.notify({message: Joomla.JText._('COM_COMPONENTBUILDER_ALREADY_SELECTED_TRY_ANOTHER'), timeout: 5000, status: 'warning', pos: 'top-center'});
	} else {
		// set the active removed value
		selectedIdRemoved[type] = id;
		// do a dynamic update (to remove what was already used)
		selectionDynamicUpdate(type);
		// we first check local memory
		var _result = jQuery.jStorage.get('code_4_'+type+'_'+value, null);
		if (_result) {
			// now set the code
			if (addCodeToEditor(_result, "jform_main_class_code", true)) {
				selectionMemory[type][id] = value;
			}
		} else {
			// now get the code
			getClassStuff_server(value, type, 'getClassCode').done(function(result) {
				if(result){
					// now set the code
					if (addCodeToEditor(result, "jform_main_class_code", true)) {
						selectionMemory[type][id] = value;
					}
					// add result to local memory
					jQuery.jStorage.set('code_4_'+type+'_'+value, result, {TTL: expire});
				}
			});
		}
	}
}

function addCodeToEditor(code_string, editor_id, merge){
	if (Joomla.editors.instances.hasOwnProperty(editor_id)) {
		var old_code_string = Joomla.editors.instances[editor_id].getValue();
		if (merge && old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) == -1)  {
				Joomla.editors.instances[editor_id].setValue(old_code_string + "\n\n" + code_string);
				return true;
			}
		} else {
			Joomla.editors.instances[editor_id].setValue(code_string);
			return true;
		}
	} else {
		var old_code_string = jQuery('textarea#'+editor_id).val();
		if (merge && old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) == -1) {
				jQuery('textarea#'+editor_id).val(old_code_string + "\n\n" + code_string);
				return true;
			}
		} else {
			jQuery('textarea#'+editor_id).val(code_string);
			return true;
		}
	}
	return false;
}

function removeCodeFromEditor(code_string){
	if (Joomla.editors.instances.hasOwnProperty("jform_main_class_code")) {
		var old_code_string = Joomla.editors.instances['jform_main_class_code'].getValue();
		if (old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) !== -1) {
				// remove the code
				Joomla.editors.instances['jform_main_class_code'].setValue(old_code_string.replace(code_string+"\n\n",'').replace("\n\n"+code_string,'').replace(code_string,''));
				return true;
			}
		}
	} else {
		var old_code_string = jQuery('textarea#jform_main_class_code').val();
		if (old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) !== -1) {
				// remove the code
				jQuery('textarea#jform_main_class_code').val(old_code_string.replace(code_string+"\n\n",'').replace("\n\n"+code_string,'').replace(code_string,''));
				return true;
			}
		}
	}
	return false;
}

function selectionDynamicUpdate(type) {
	selectionAvailable = {};
	selectionSelectedArray = {};
	selectionTrackerArray = {};
	var i;
	for (i = 0; i < 70; i++) { // for now this is the number of field we should check
		// build ID
		var id_check = 'jform_'+type+'_selection'+'__'+type+'_selection'+i+'__'+type;
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length && selectedIdRemoved[type] !== id_check) {
			// build the selected array
			var key =  jQuery("#"+id_check+" option:selected").val();
			var text =  jQuery("#"+id_check+" option:selected").text();
			selectionSelectedArray[key] = text;
			// keep track of the value set
			selectionTrackerArray[id_check] = key;
			// clear the options out
			jQuery("#"+id_check).find('option').remove().end();
		}
	}
	// now build the list to keep
	jQuery.each( selectionActiveArray[type], function( prop, name ) {
		if (!selectionSelectedArray.hasOwnProperty(prop)) {
			selectionAvailable[prop] = name;
		}
	});
	// now add the lists back
	jQuery.each( selectionTrackerArray, function( tId, tKey ) {
		if (jQuery('#'+tId).length) {
			jQuery('#'+tId).append('<option value="'+tKey+'">'+selectionSelectedArray[tKey]+'</option>');
			jQuery.each( selectionAvailable, function( aKey, aValue ) {
				jQuery('#'+tId).append('<option value="'+aKey+'">'+aValue+'</option>');
			});
			jQuery('#'+tId).val(tKey);
			jQuery('#'+tId).trigger('liszt:updated');
		}
	});
}

function rowWatcher() {
	jQuery(document).on('subform-row-remove', function(event, row){
		// we first chck if this is a method call
       		var valid_call = jQuery(row.innerHTML).find('.method_selection_list').attr('id');
		var type_call = 'method';
		if (!isSet(valid_call)){
			// now lets see if this is a property call
			var valid_call = jQuery(row.innerHTML).find('.property_selection_list').attr('id');
			var type_call = 'property';
		}
		// so lets update selection if call valid
		if (isSet(valid_call)){
			selectedIdRemoved[type_call] = valid_call;
			selectionDynamicUpdate(type_call);
			// also remove from code
			var valid_value = jQuery(row.innerHTML).find('#' + valid_call + ' option:selected').val();
			if (valid_value === '') {
				valid_value = selectionMemory[type_call][valid_call];
			}
			// remove the code // we first check local memory
			var _result = jQuery.jStorage.get('code_4_'+type_call+'_'+valid_value, null);
			if (_result) {
				// now remove the code
				if (removeCodeFromEditor(_result)) {
					selectionMemory[type_call][valid_call] = 0;
				}
			} else {
				// now get the code
				getClassStuff_server(valid_value, type_call, 'getClassCode').done(function(result) {
					if(result){
						if (removeCodeFromEditor(result)) {
							selectionMemory[type_call][valid_call] = 0;;
						}
						// add result to local memory
						jQuery.jStorage.set('code_4_'+type_call+'_'+valid_value, result, {TTL: expire});
					}
				});
			}
		}
	});
	jQuery(document).on('subform-row-add', function(event, row){
		// we first chck if this is a method call
       		var valid_call = jQuery(row.innerHTML).find('.method_selection_list').attr('id');
		var type_call = 'method';
		if (!isSet(valid_call)){
			// now lets see if this is a property call
			var valid_call = jQuery(row.innerHTML).find('.property_selection_list').attr('id');
			var type_call = 'property';
		}
		// so lets update selection if call valid
		if (isSet(valid_call)){
			selectedIdRemoved[type_call] = 'not';
			selectionDynamicUpdate(type_call);
		}
	});
}

function propertyIsSet(prop, id, type) {
	var i;
	for (i = 0; i < 70; i++) { // for now this is the number of field we should check
		// build ID
		var id_check = 'jform_'+type+'_selection'+'__'+type+'_selection'+i+'__'+type;
		// first check if Id is on page as that not the same as the one currently calling
		if (jQuery("#"+id_check).length && id_check != id) {
			// get the property value
			var tmp = jQuery("#"+id_check+" option:selected").val();
			// now validate
			if (tmp === prop) {
				return true;
			}
		}
	}
	return false;
}

function getLinked_server(type){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && type > 0){
		var request = token+'=1&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
}

function getEditCustomCodeButtons_server(id){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0){
		var request = token+'=1&id='+id+'&return_here='+return_here;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getEditCustomCodeButtons(){
	// get the id
	id = jQuery("#jform_id").val();
	getEditCustomCodeButtons_server(id).done(function(result) {
		if(isObject(result)){
			jQuery.each(result, function( field, buttons ) {
				jQuery('<div class="control-group"><div class="control-label"><label>Add/Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
				jQuery.each(buttons, function( name, button ) {
					jQuery(".control-customcode-buttons-"+field).append(button);
				});
			});
		}
	})
}

// check object is not empty
function isObject(obj) {
	for(var prop in obj) {
		if (Object.prototype.hasOwnProperty.call(obj, prop)) {
			return true;
		}
	}
	return false;
} 
