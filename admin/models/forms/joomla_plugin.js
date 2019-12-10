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
jform_vvvvvyavwh_required = false;
jform_vvvvvypvwi_required = false;
jform_vvvvvyqvwj_required = false;
jform_vvvvvyrvwk_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var class_extends_vvvvvxx = jQuery("#jform_class_extends").val();
	var joomla_plugin_group_vvvvvxx = jQuery("#jform_joomla_plugin_group").val();
	vvvvvxx(class_extends_vvvvvxx,joomla_plugin_group_vvvvvxx);

	var joomla_plugin_group_vvvvvxy = jQuery("#jform_joomla_plugin_group").val();
	var class_extends_vvvvvxy = jQuery("#jform_class_extends").val();
	vvvvvxy(joomla_plugin_group_vvvvvxy,class_extends_vvvvvxy);

	var class_extends_vvvvvxz = jQuery("#jform_class_extends").val();
	vvvvvxz(class_extends_vvvvvxz);

	var add_head_vvvvvya = jQuery("#jform_add_head input[type='radio']:checked").val();
	var class_extends_vvvvvya = jQuery("#jform_class_extends").val();
	vvvvvya(add_head_vvvvvya,class_extends_vvvvvya);

	var add_php_script_construct_vvvvvyc = jQuery("#jform_add_php_script_construct input[type='radio']:checked").val();
	vvvvvyc(add_php_script_construct_vvvvvyc);

	var add_php_preflight_install_vvvvvyd = jQuery("#jform_add_php_preflight_install input[type='radio']:checked").val();
	vvvvvyd(add_php_preflight_install_vvvvvyd);

	var add_php_preflight_update_vvvvvye = jQuery("#jform_add_php_preflight_update input[type='radio']:checked").val();
	vvvvvye(add_php_preflight_update_vvvvvye);

	var add_php_preflight_uninstall_vvvvvyf = jQuery("#jform_add_php_preflight_uninstall input[type='radio']:checked").val();
	vvvvvyf(add_php_preflight_uninstall_vvvvvyf);

	var add_php_postflight_install_vvvvvyg = jQuery("#jform_add_php_postflight_install input[type='radio']:checked").val();
	vvvvvyg(add_php_postflight_install_vvvvvyg);

	var add_php_postflight_update_vvvvvyh = jQuery("#jform_add_php_postflight_update input[type='radio']:checked").val();
	vvvvvyh(add_php_postflight_update_vvvvvyh);

	var add_php_method_uninstall_vvvvvyi = jQuery("#jform_add_php_method_uninstall input[type='radio']:checked").val();
	vvvvvyi(add_php_method_uninstall_vvvvvyi);

	var update_server_target_vvvvvyj = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyj = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyj(update_server_target_vvvvvyj,add_update_server_vvvvvyj);

	var add_update_server_vvvvvyk = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	var update_server_target_vvvvvyk = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	vvvvvyk(add_update_server_vvvvvyk,update_server_target_vvvvvyk);

	var update_server_target_vvvvvyl = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyl = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyl(update_server_target_vvvvvyl,add_update_server_vvvvvyl);

	var update_server_target_vvvvvyn = jQuery("#jform_update_server_target input[type='radio']:checked").val();
	var add_update_server_vvvvvyn = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyn(update_server_target_vvvvvyn,add_update_server_vvvvvyn);

	var add_update_server_vvvvvyp = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvyp(add_update_server_vvvvvyp);

	var add_sql_vvvvvyq = jQuery("#jform_add_sql input[type='radio']:checked").val();
	vvvvvyq(add_sql_vvvvvyq);

	var add_sql_uninstall_vvvvvyr = jQuery("#jform_add_sql_uninstall input[type='radio']:checked").val();
	vvvvvyr(add_sql_uninstall_vvvvvyr);

	var add_update_server_vvvvvys = jQuery("#jform_add_update_server input[type='radio']:checked").val();
	vvvvvys(add_update_server_vvvvvys);

	var add_sales_server_vvvvvyt = jQuery("#jform_add_sales_server input[type='radio']:checked").val();
	vvvvvyt(add_sales_server_vvvvvyt);

	var addreadme_vvvvvyu = jQuery("#jform_addreadme input[type='radio']:checked").val();
	vvvvvyu(addreadme_vvvvvyu);
});

// the vvvvvxx function
function vvvvvxx(class_extends_vvvvvxx,joomla_plugin_group_vvvvvxx)
{
	if (isSet(class_extends_vvvvvxx) && class_extends_vvvvvxx.constructor !== Array)
	{
		var temp_vvvvvxx = class_extends_vvvvvxx;
		var class_extends_vvvvvxx = [];
		class_extends_vvvvvxx.push(temp_vvvvvxx);
	}
	else if (!isSet(class_extends_vvvvvxx))
	{
		var class_extends_vvvvvxx = [];
	}
	var class_extends = class_extends_vvvvvxx.some(class_extends_vvvvvxx_SomeFunc);

	if (isSet(joomla_plugin_group_vvvvvxx) && joomla_plugin_group_vvvvvxx.constructor !== Array)
	{
		var temp_vvvvvxx = joomla_plugin_group_vvvvvxx;
		var joomla_plugin_group_vvvvvxx = [];
		joomla_plugin_group_vvvvvxx.push(temp_vvvvvxx);
	}
	else if (!isSet(joomla_plugin_group_vvvvvxx))
	{
		var joomla_plugin_group_vvvvvxx = [];
	}
	var joomla_plugin_group = joomla_plugin_group_vvvvvxx.some(joomla_plugin_group_vvvvvxx_SomeFunc);


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

// the vvvvvxx Some function
function class_extends_vvvvvxx_SomeFunc(class_extends_vvvvvxx)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxx))
	{
		return true;
	}
	return false;
}

// the vvvvvxx Some function
function joomla_plugin_group_vvvvvxx_SomeFunc(joomla_plugin_group_vvvvvxx)
{
	// set the function logic
	if (isSet(joomla_plugin_group_vvvvvxx))
	{
		return true;
	}
	return false;
}

// the vvvvvxy function
function vvvvvxy(joomla_plugin_group_vvvvvxy,class_extends_vvvvvxy)
{
	if (isSet(joomla_plugin_group_vvvvvxy) && joomla_plugin_group_vvvvvxy.constructor !== Array)
	{
		var temp_vvvvvxy = joomla_plugin_group_vvvvvxy;
		var joomla_plugin_group_vvvvvxy = [];
		joomla_plugin_group_vvvvvxy.push(temp_vvvvvxy);
	}
	else if (!isSet(joomla_plugin_group_vvvvvxy))
	{
		var joomla_plugin_group_vvvvvxy = [];
	}
	var joomla_plugin_group = joomla_plugin_group_vvvvvxy.some(joomla_plugin_group_vvvvvxy_SomeFunc);

	if (isSet(class_extends_vvvvvxy) && class_extends_vvvvvxy.constructor !== Array)
	{
		var temp_vvvvvxy = class_extends_vvvvvxy;
		var class_extends_vvvvvxy = [];
		class_extends_vvvvvxy.push(temp_vvvvvxy);
	}
	else if (!isSet(class_extends_vvvvvxy))
	{
		var class_extends_vvvvvxy = [];
	}
	var class_extends = class_extends_vvvvvxy.some(class_extends_vvvvvxy_SomeFunc);


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

// the vvvvvxy Some function
function joomla_plugin_group_vvvvvxy_SomeFunc(joomla_plugin_group_vvvvvxy)
{
	// set the function logic
	if (isSet(joomla_plugin_group_vvvvvxy))
	{
		return true;
	}
	return false;
}

// the vvvvvxy Some function
function class_extends_vvvvvxy_SomeFunc(class_extends_vvvvvxy)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxy))
	{
		return true;
	}
	return false;
}

// the vvvvvxz function
function vvvvvxz(class_extends_vvvvvxz)
{
	if (isSet(class_extends_vvvvvxz) && class_extends_vvvvvxz.constructor !== Array)
	{
		var temp_vvvvvxz = class_extends_vvvvvxz;
		var class_extends_vvvvvxz = [];
		class_extends_vvvvvxz.push(temp_vvvvvxz);
	}
	else if (!isSet(class_extends_vvvvvxz))
	{
		var class_extends_vvvvvxz = [];
	}
	var class_extends = class_extends_vvvvvxz.some(class_extends_vvvvvxz_SomeFunc);


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

// the vvvvvxz Some function
function class_extends_vvvvvxz_SomeFunc(class_extends_vvvvvxz)
{
	// set the function logic
	if (isSet(class_extends_vvvvvxz))
	{
		return true;
	}
	return false;
}

// the vvvvvya function
function vvvvvya(add_head_vvvvvya,class_extends_vvvvvya)
{
	if (isSet(add_head_vvvvvya) && add_head_vvvvvya.constructor !== Array)
	{
		var temp_vvvvvya = add_head_vvvvvya;
		var add_head_vvvvvya = [];
		add_head_vvvvvya.push(temp_vvvvvya);
	}
	else if (!isSet(add_head_vvvvvya))
	{
		var add_head_vvvvvya = [];
	}
	var add_head = add_head_vvvvvya.some(add_head_vvvvvya_SomeFunc);

	if (isSet(class_extends_vvvvvya) && class_extends_vvvvvya.constructor !== Array)
	{
		var temp_vvvvvya = class_extends_vvvvvya;
		var class_extends_vvvvvya = [];
		class_extends_vvvvvya.push(temp_vvvvvya);
	}
	else if (!isSet(class_extends_vvvvvya))
	{
		var class_extends_vvvvvya = [];
	}
	var class_extends = class_extends_vvvvvya.some(class_extends_vvvvvya_SomeFunc);


	// set this function logic
	if (add_head && class_extends)
	{
		jQuery('#jform_head-lbl').closest('.control-group').show();
		// add required attribute to head field
		if (jform_vvvvvyavwh_required)
		{
			updateFieldRequired('head',0);
			jQuery('#jform_head').prop('required','required');
			jQuery('#jform_head').attr('aria-required',true);
			jQuery('#jform_head').addClass('required');
			jform_vvvvvyavwh_required = false;
		}
	}
	else
	{
		jQuery('#jform_head-lbl').closest('.control-group').hide();
		// remove required attribute from head field
		if (!jform_vvvvvyavwh_required)
		{
			updateFieldRequired('head',1);
			jQuery('#jform_head').removeAttr('required');
			jQuery('#jform_head').removeAttr('aria-required');
			jQuery('#jform_head').removeClass('required');
			jform_vvvvvyavwh_required = true;
		}
	}
}

// the vvvvvya Some function
function add_head_vvvvvya_SomeFunc(add_head_vvvvvya)
{
	// set the function logic
	if (add_head_vvvvvya == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvya Some function
function class_extends_vvvvvya_SomeFunc(class_extends_vvvvvya)
{
	// set the function logic
	if (isSet(class_extends_vvvvvya))
	{
		return true;
	}
	return false;
}

// the vvvvvyc function
function vvvvvyc(add_php_script_construct_vvvvvyc)
{
	// set the function logic
	if (add_php_script_construct_vvvvvyc == 1)
	{
		jQuery('#jform_php_script_construct-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_script_construct-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyd function
function vvvvvyd(add_php_preflight_install_vvvvvyd)
{
	// set the function logic
	if (add_php_preflight_install_vvvvvyd == 1)
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_install-lbl').closest('.control-group').hide();
	}
}

// the vvvvvye function
function vvvvvye(add_php_preflight_update_vvvvvye)
{
	// set the function logic
	if (add_php_preflight_update_vvvvvye == 1)
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_update-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyf function
function vvvvvyf(add_php_preflight_uninstall_vvvvvyf)
{
	// set the function logic
	if (add_php_preflight_uninstall_vvvvvyf == 1)
	{
		jQuery('#jform_php_preflight_uninstall-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_preflight_uninstall-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyg function
function vvvvvyg(add_php_postflight_install_vvvvvyg)
{
	// set the function logic
	if (add_php_postflight_install_vvvvvyg == 1)
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postflight_install-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyh function
function vvvvvyh(add_php_postflight_update_vvvvvyh)
{
	// set the function logic
	if (add_php_postflight_update_vvvvvyh == 1)
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_postflight_update-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyi function
function vvvvvyi(add_php_method_uninstall_vvvvvyi)
{
	// set the function logic
	if (add_php_method_uninstall_vvvvvyi == 1)
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_method_uninstall-lbl').closest('.control-group').hide();
	}
}

// the vvvvvyj function
function vvvvvyj(update_server_target_vvvvvyj,add_update_server_vvvvvyj)
{
	// set the function logic
	if (update_server_target_vvvvvyj == 1 && add_update_server_vvvvvyj == 1)
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

// the vvvvvyk function
function vvvvvyk(add_update_server_vvvvvyk,update_server_target_vvvvvyk)
{
	// set the function logic
	if (add_update_server_vvvvvyk == 1 && update_server_target_vvvvvyk == 1)
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

// the vvvvvyl function
function vvvvvyl(update_server_target_vvvvvyl,add_update_server_vvvvvyl)
{
	// set the function logic
	if (update_server_target_vvvvvyl == 2 && add_update_server_vvvvvyl == 1)
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_zip').closest('.control-group').hide();
	}
}

// the vvvvvyn function
function vvvvvyn(update_server_target_vvvvvyn,add_update_server_vvvvvyn)
{
	// set the function logic
	if (update_server_target_vvvvvyn == 3 && add_update_server_vvvvvyn == 1)
	{
		jQuery('.note_update_server_note_other').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_update_server_note_other').closest('.control-group').hide();
	}
}

// the vvvvvyp function
function vvvvvyp(add_update_server_vvvvvyp)
{
	// set the function logic
	if (add_update_server_vvvvvyp == 1)
	{
		jQuery('#jform_update_server_target').closest('.control-group').show();
		// add required attribute to update_server_target field
		if (jform_vvvvvypvwi_required)
		{
			updateFieldRequired('update_server_target',0);
			jQuery('#jform_update_server_target').prop('required','required');
			jQuery('#jform_update_server_target').attr('aria-required',true);
			jQuery('#jform_update_server_target').addClass('required');
			jform_vvvvvypvwi_required = false;
		}
	}
	else
	{
		jQuery('#jform_update_server_target').closest('.control-group').hide();
		// remove required attribute from update_server_target field
		if (!jform_vvvvvypvwi_required)
		{
			updateFieldRequired('update_server_target',1);
			jQuery('#jform_update_server_target').removeAttr('required');
			jQuery('#jform_update_server_target').removeAttr('aria-required');
			jQuery('#jform_update_server_target').removeClass('required');
			jform_vvvvvypvwi_required = true;
		}
	}
}

// the vvvvvyq function
function vvvvvyq(add_sql_vvvvvyq)
{
	// set the function logic
	if (add_sql_vvvvvyq == 1)
	{
		jQuery('#jform_sql').closest('.control-group').show();
		// add required attribute to sql field
		if (jform_vvvvvyqvwj_required)
		{
			updateFieldRequired('sql',0);
			jQuery('#jform_sql').prop('required','required');
			jQuery('#jform_sql').attr('aria-required',true);
			jQuery('#jform_sql').addClass('required');
			jform_vvvvvyqvwj_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql').closest('.control-group').hide();
		// remove required attribute from sql field
		if (!jform_vvvvvyqvwj_required)
		{
			updateFieldRequired('sql',1);
			jQuery('#jform_sql').removeAttr('required');
			jQuery('#jform_sql').removeAttr('aria-required');
			jQuery('#jform_sql').removeClass('required');
			jform_vvvvvyqvwj_required = true;
		}
	}
}

// the vvvvvyr function
function vvvvvyr(add_sql_uninstall_vvvvvyr)
{
	// set the function logic
	if (add_sql_uninstall_vvvvvyr == 1)
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').show();
		// add required attribute to sql_uninstall field
		if (jform_vvvvvyrvwk_required)
		{
			updateFieldRequired('sql_uninstall',0);
			jQuery('#jform_sql_uninstall').prop('required','required');
			jQuery('#jform_sql_uninstall').attr('aria-required',true);
			jQuery('#jform_sql_uninstall').addClass('required');
			jform_vvvvvyrvwk_required = false;
		}
	}
	else
	{
		jQuery('#jform_sql_uninstall').closest('.control-group').hide();
		// remove required attribute from sql_uninstall field
		if (!jform_vvvvvyrvwk_required)
		{
			updateFieldRequired('sql_uninstall',1);
			jQuery('#jform_sql_uninstall').removeAttr('required');
			jQuery('#jform_sql_uninstall').removeAttr('aria-required');
			jQuery('#jform_sql_uninstall').removeClass('required');
			jform_vvvvvyrvwk_required = true;
		}
	}
}

// the vvvvvys function
function vvvvvys(add_update_server_vvvvvys)
{
	// set the function logic
	if (add_update_server_vvvvvys == 1)
	{
		jQuery('#jform_update_server_url').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_update_server_url').closest('.control-group').hide();
	}
}

// the vvvvvyt function
function vvvvvyt(add_sales_server_vvvvvyt)
{
	// set the function logic
	if (add_sales_server_vvvvvyt == 1)
	{
		jQuery('#jform_sales_server').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_sales_server').closest('.control-group').hide();
	}
}

// the vvvvvyu function
function vvvvvyu(addreadme_vvvvvyu)
{
	// set the function logic
	if (addreadme_vvvvvyu == 1)
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

function getCodeFrom_server(id, type, type_name, callingName){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax." + callingName + "&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && id > 0 && type.length > 0) {
		var request = token + '=1&' + type_name + '=' + type + '&id=' + id;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}


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

function getClassHeaderCode(){
	// now get the values
	var value = jQuery("#jform_class_extends  option:selected").val();
	var add_value = jQuery("#jform_add_head input[type='radio']:checked").val();
	if (add_value == 1 && value > 0){
		// we first check local memory
		var _result = jQuery.jStorage.get('extends_header_'+value, null);
		if (_result) {
				// now set the code
				addCodeToEditor(_result, "jform_head", false, null);
		} else {
			// now get the code
			getCodeFrom_server(value, 'extends', 'type', 'getClassHeaderCode').done(function(result) {
				if(result){
					// now set the code
					addCodeToEditor(result, "jform_head", false, null);
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
	getCodeFrom_server(value, type, 'type', 'getClassCodeIds').done(function(result) {
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
			if (removeCodeFromEditor(_result, 'jform_main_class_code')) {
				selectionMemory[type][id] = 0;
			}
		} else {
			// now get the code
			getCodeFrom_server(old_value, type, 'type', 'getClassCode').done(function(result) {
				if(result){
					// now remove the code
					if (removeCodeFromEditor(result, 'jform_main_class_code')) {
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
		// set the add action
		if (type === 'property') {
			var _action_add = 'prepend';
		} else {
			var _action_add = 'append';
		}
		// we first check local memory
		var _result = jQuery.jStorage.get('code_4_'+type+'_'+value, null);
		if (_result) {
			// now set the code
			if (addCodeToEditor(_result, "jform_main_class_code", true, _action_add)) {
				selectionMemory[type][id] = value;
			}
		} else {
			// now get the code
			getCodeFrom_server(value, type, 'type', 'getClassCode').done(function(result) {
				if(result){
					// now set the code
					if (addCodeToEditor(result, "jform_main_class_code", true, _action_add)) {
						selectionMemory[type][id] = value;
					}
					// add result to local memory
					jQuery.jStorage.set('code_4_'+type+'_'+value, result, {TTL: expire});
				}
			});
		}
	}
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
				if (removeCodeFromEditor(_result, 'jform_main_class_code')) {
					selectionMemory[type_call][valid_call] = 0;
				}
			} else {
				// now get the code
				getCodeFrom_server(valid_value, type_call, 'type', 'getClassCode').done(function(result) {
					if(result){
						if (removeCodeFromEditor(result, 'jform_main_class_code')) {
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


function addCodeToEditor(code_string, editor_id, merge, merge_target){
	if (Joomla.editors.instances.hasOwnProperty(editor_id)) {
		var old_code_string = Joomla.editors.instances[editor_id].getValue();
		if (merge && old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) == -1)  {
				if ('prepend' === merge_target) {
					var _string = code_string + "\n\n" + old_code_string;
				} else if (merge_target && 'append' !== merge_target) {
					var old_code_array = old_code_string.split(merge_target);
					if (old_code_array.length > 1) {
						var _string = old_code_array.shift() + "\n\n" + code_string + "\n\n" + merge_target + old_code_array.join(merge_target);
					} else {
						var _string = code_string + "\n\n" + merge_target + old_code_array.join('');
					}
				} else {
					var _string = old_code_string + "\n\n" + code_string;
				}
				Joomla.editors.instances[editor_id].setValue(_string.trim());
				return true;
			}
		} else {
			Joomla.editors.instances[editor_id].setValue(code_string.trim());
			return true;
		}
	} else {
		var old_code_string = jQuery('textarea#'+editor_id).val();
		if (merge && old_code_string.length > 0) {
			// make sure not to load the same string twice
			if (old_code_string.indexOf(code_string) == -1) {
				if ('prepend' === merge_target) {
					var _string = code_string + "\n\n" + old_code_string;
				} else if (merge_target && 'append' !== merge_target) {
					var old_code_array = old_code_string.split(merge_target);
					if (old_code_array.length > 1) {
						var _string = old_code_array.shift() + "\n\n" + code_string + "\n\n" + merge_target + old_code_array.join(merge_target);
					} else {
						var _string = code_string + "\n\n" + merge_target + old_code_array.join('');
					}
				} else {
					var _string = old_code_string + "\n\n" + code_string;
				}
				jQuery('textarea#'+editor_id).val(_string.trim());
				return true;
			}
		} else {
			jQuery('textarea#'+editor_id).val(code_string.trim());
			return true;
		}
	}
	return false;
}


function removeCodeFromEditor(code_string, editor_id){
	if (Joomla.editors.instances.hasOwnProperty(editor_id)) {
		var old_code_string = Joomla.editors.instances[editor_id].getValue();
		if (old_code_string.length > 0) {
			// make sure string is found
			if (old_code_string.indexOf(code_string) !== -1) {
				// remove the code
				Joomla.editors.instances[editor_id].setValue(old_code_string.replace(code_string+"\n\n",'').replace("\n\n"+code_string,'').replace(code_string,''));
				return true;
			}
		}
	} else {
		var old_code_string = jQuery('textarea#'+editor_id).val();
		if (old_code_string.length > 0) {
			// make sure string is found
			if (old_code_string.indexOf(code_string) !== -1) {
				// remove the code
				jQuery('textarea#'+editor_id).val(old_code_string.replace(code_string+"\n\n",'').replace("\n\n"+code_string,'').replace(code_string,''));
				return true;
			}
		}
	}
	return false;
}


function getLinked(){
	getCodeFrom_server(1, 'type', 'type', 'getLinked').done(function(result) {
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
