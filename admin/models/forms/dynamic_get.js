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
jform_vvvvwbavwu_required = false;
jform_vvvvwbcvwv_required = false;
jform_vvvvwbdvww_required = false;
jform_vvvvwbevwx_required = false;
jform_vvvvwbfvwy_required = false;
jform_vvvvwbqvwz_required = false;
jform_vvvvwbqvxa_required = false;
jform_vvvvwbvvxb_required = false;
jform_vvvvwbvvxc_required = false;
jform_vvvvwbvvxd_required = false;
jform_vvvvwbwvxe_required = false;
jform_vvvvwbxvxf_required = false;
jform_vvvvwbyvxg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvwba = jQuery("#jform_gettype").val();
	vvvvwba(gettype_vvvvwba);

	var main_source_vvvvwbb = jQuery("#jform_main_source").val();
	vvvvwbb(main_source_vvvvwbb);

	var main_source_vvvvwbc = jQuery("#jform_main_source").val();
	vvvvwbc(main_source_vvvvwbc);

	var main_source_vvvvwbd = jQuery("#jform_main_source").val();
	vvvvwbd(main_source_vvvvwbd);

	var main_source_vvvvwbe = jQuery("#jform_main_source").val();
	vvvvwbe(main_source_vvvvwbe);

	var main_source_vvvvwbf = jQuery("#jform_main_source").val();
	vvvvwbf(main_source_vvvvwbf);

	var addcalculation_vvvvwbg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvwbg(addcalculation_vvvvwbg);

	var addcalculation_vvvvwbh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbh = jQuery("#jform_gettype").val();
	vvvvwbh(addcalculation_vvvvwbh,gettype_vvvvwbh);

	var addcalculation_vvvvwbi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbi = jQuery("#jform_gettype").val();
	vvvvwbi(addcalculation_vvvvwbi,gettype_vvvvwbi);

	var main_source_vvvvwbl = jQuery("#jform_main_source").val();
	vvvvwbl(main_source_vvvvwbl);

	var main_source_vvvvwbm = jQuery("#jform_main_source").val();
	vvvvwbm(main_source_vvvvwbm);

	var add_php_before_getitem_vvvvwbn = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbn = jQuery("#jform_gettype").val();
	vvvvwbn(add_php_before_getitem_vvvvwbn,gettype_vvvvwbn);

	var add_php_after_getitem_vvvvwbo = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbo = jQuery("#jform_gettype").val();
	vvvvwbo(add_php_after_getitem_vvvvwbo,gettype_vvvvwbo);

	var gettype_vvvvwbq = jQuery("#jform_gettype").val();
	vvvvwbq(gettype_vvvvwbq);

	var add_php_getlistquery_vvvvwbr = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwbr = jQuery("#jform_gettype").val();
	vvvvwbr(add_php_getlistquery_vvvvwbr,gettype_vvvvwbr);

	var add_php_before_getitems_vvvvwbs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbs = jQuery("#jform_gettype").val();
	vvvvwbs(add_php_before_getitems_vvvvwbs,gettype_vvvvwbs);

	var add_php_after_getitems_vvvvwbt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbt = jQuery("#jform_gettype").val();
	vvvvwbt(add_php_after_getitems_vvvvwbt,gettype_vvvvwbt);

	var gettype_vvvvwbv = jQuery("#jform_gettype").val();
	vvvvwbv(gettype_vvvvwbv);

	var gettype_vvvvwbw = jQuery("#jform_gettype").val();
	vvvvwbw(gettype_vvvvwbw);

	var gettype_vvvvwbx = jQuery("#jform_gettype").val();
	vvvvwbx(gettype_vvvvwbx);

	var gettype_vvvvwby = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwby = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwby(gettype_vvvvwby,add_php_router_parse_vvvvwby);

	var gettype_vvvvwca = jQuery("#jform_gettype").val();
	vvvvwca(gettype_vvvvwca);
});

// the vvvvwba function
function vvvvwba(gettype_vvvvwba)
{
	if (isSet(gettype_vvvvwba) && gettype_vvvvwba.constructor !== Array)
	{
		var temp_vvvvwba = gettype_vvvvwba;
		var gettype_vvvvwba = [];
		gettype_vvvvwba.push(temp_vvvvwba);
	}
	else if (!isSet(gettype_vvvvwba))
	{
		var gettype_vvvvwba = [];
	}
	var gettype = gettype_vvvvwba.some(gettype_vvvvwba_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		// add required attribute to getcustom field
		if (jform_vvvvwbavwu_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvwbavwu_required = false;
		}
	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		// remove required attribute from getcustom field
		if (!jform_vvvvwbavwu_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvwbavwu_required = true;
		}
	}
}

// the vvvvwba Some function
function gettype_vvvvwba_SomeFunc(gettype_vvvvwba)
{
	// set the function logic
	if (gettype_vvvvwba == 3 || gettype_vvvvwba == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbb function
function vvvvwbb(main_source_vvvvwbb)
{
	if (isSet(main_source_vvvvwbb) && main_source_vvvvwbb.constructor !== Array)
	{
		var temp_vvvvwbb = main_source_vvvvwbb;
		var main_source_vvvvwbb = [];
		main_source_vvvvwbb.push(temp_vvvvwbb);
	}
	else if (!isSet(main_source_vvvvwbb))
	{
		var main_source_vvvvwbb = [];
	}
	var main_source = main_source_vvvvwbb.some(main_source_vvvvwbb_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_select_all').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_select_all').closest('.control-group').hide();
	}
}

// the vvvvwbb Some function
function main_source_vvvvwbb_SomeFunc(main_source_vvvvwbb)
{
	// set the function logic
	if (main_source_vvvvwbb == 1 || main_source_vvvvwbb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbc function
function vvvvwbc(main_source_vvvvwbc)
{
	if (isSet(main_source_vvvvwbc) && main_source_vvvvwbc.constructor !== Array)
	{
		var temp_vvvvwbc = main_source_vvvvwbc;
		var main_source_vvvvwbc = [];
		main_source_vvvvwbc.push(temp_vvvvwbc);
	}
	else if (!isSet(main_source_vvvvwbc))
	{
		var main_source_vvvvwbc = [];
	}
	var main_source = main_source_vvvvwbc.some(main_source_vvvvwbc_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		// add required attribute to view_table_main field
		if (jform_vvvvwbcvwv_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvwbcvwv_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		// remove required attribute from view_table_main field
		if (!jform_vvvvwbcvwv_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvwbcvwv_required = true;
		}
	}
}

// the vvvvwbc Some function
function main_source_vvvvwbc_SomeFunc(main_source_vvvvwbc)
{
	// set the function logic
	if (main_source_vvvvwbc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbd function
function vvvvwbd(main_source_vvvvwbd)
{
	if (isSet(main_source_vvvvwbd) && main_source_vvvvwbd.constructor !== Array)
	{
		var temp_vvvvwbd = main_source_vvvvwbd;
		var main_source_vvvvwbd = [];
		main_source_vvvvwbd.push(temp_vvvvwbd);
	}
	else if (!isSet(main_source_vvvvwbd))
	{
		var main_source_vvvvwbd = [];
	}
	var main_source = main_source_vvvvwbd.some(main_source_vvvvwbd_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		// add required attribute to view_selection field
		if (jform_vvvvwbdvww_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvwbdvww_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		// remove required attribute from view_selection field
		if (!jform_vvvvwbdvww_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvwbdvww_required = true;
		}
	}
}

// the vvvvwbd Some function
function main_source_vvvvwbd_SomeFunc(main_source_vvvvwbd)
{
	// set the function logic
	if (main_source_vvvvwbd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbe function
function vvvvwbe(main_source_vvvvwbe)
{
	if (isSet(main_source_vvvvwbe) && main_source_vvvvwbe.constructor !== Array)
	{
		var temp_vvvvwbe = main_source_vvvvwbe;
		var main_source_vvvvwbe = [];
		main_source_vvvvwbe.push(temp_vvvvwbe);
	}
	else if (!isSet(main_source_vvvvwbe))
	{
		var main_source_vvvvwbe = [];
	}
	var main_source = main_source_vvvvwbe.some(main_source_vvvvwbe_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		// add required attribute to db_table_main field
		if (jform_vvvvwbevwx_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvwbevwx_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		// remove required attribute from db_table_main field
		if (!jform_vvvvwbevwx_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvwbevwx_required = true;
		}
	}
}

// the vvvvwbe Some function
function main_source_vvvvwbe_SomeFunc(main_source_vvvvwbe)
{
	// set the function logic
	if (main_source_vvvvwbe == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbf function
function vvvvwbf(main_source_vvvvwbf)
{
	if (isSet(main_source_vvvvwbf) && main_source_vvvvwbf.constructor !== Array)
	{
		var temp_vvvvwbf = main_source_vvvvwbf;
		var main_source_vvvvwbf = [];
		main_source_vvvvwbf.push(temp_vvvvwbf);
	}
	else if (!isSet(main_source_vvvvwbf))
	{
		var main_source_vvvvwbf = [];
	}
	var main_source = main_source_vvvvwbf.some(main_source_vvvvwbf_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		// add required attribute to db_selection field
		if (jform_vvvvwbfvwy_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvwbfvwy_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		// remove required attribute from db_selection field
		if (!jform_vvvvwbfvwy_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvwbfvwy_required = true;
		}
	}
}

// the vvvvwbf Some function
function main_source_vvvvwbf_SomeFunc(main_source_vvvvwbf)
{
	// set the function logic
	if (main_source_vvvvwbf == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbg function
function vvvvwbg(addcalculation_vvvvwbg)
{
	// set the function logic
	if (addcalculation_vvvvwbg == 1)
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbh function
function vvvvwbh(addcalculation_vvvvwbh,gettype_vvvvwbh)
{
	if (isSet(addcalculation_vvvvwbh) && addcalculation_vvvvwbh.constructor !== Array)
	{
		var temp_vvvvwbh = addcalculation_vvvvwbh;
		var addcalculation_vvvvwbh = [];
		addcalculation_vvvvwbh.push(temp_vvvvwbh);
	}
	else if (!isSet(addcalculation_vvvvwbh))
	{
		var addcalculation_vvvvwbh = [];
	}
	var addcalculation = addcalculation_vvvvwbh.some(addcalculation_vvvvwbh_SomeFunc);

	if (isSet(gettype_vvvvwbh) && gettype_vvvvwbh.constructor !== Array)
	{
		var temp_vvvvwbh = gettype_vvvvwbh;
		var gettype_vvvvwbh = [];
		gettype_vvvvwbh.push(temp_vvvvwbh);
	}
	else if (!isSet(gettype_vvvvwbh))
	{
		var gettype_vvvvwbh = [];
	}
	var gettype = gettype_vvvvwbh.some(gettype_vvvvwbh_SomeFunc);


	// set this function logic
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvwbh Some function
function addcalculation_vvvvwbh_SomeFunc(addcalculation_vvvvwbh)
{
	// set the function logic
	if (addcalculation_vvvvwbh == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbh Some function
function gettype_vvvvwbh_SomeFunc(gettype_vvvvwbh)
{
	// set the function logic
	if (gettype_vvvvwbh == 1 || gettype_vvvvwbh == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbi function
function vvvvwbi(addcalculation_vvvvwbi,gettype_vvvvwbi)
{
	if (isSet(addcalculation_vvvvwbi) && addcalculation_vvvvwbi.constructor !== Array)
	{
		var temp_vvvvwbi = addcalculation_vvvvwbi;
		var addcalculation_vvvvwbi = [];
		addcalculation_vvvvwbi.push(temp_vvvvwbi);
	}
	else if (!isSet(addcalculation_vvvvwbi))
	{
		var addcalculation_vvvvwbi = [];
	}
	var addcalculation = addcalculation_vvvvwbi.some(addcalculation_vvvvwbi_SomeFunc);

	if (isSet(gettype_vvvvwbi) && gettype_vvvvwbi.constructor !== Array)
	{
		var temp_vvvvwbi = gettype_vvvvwbi;
		var gettype_vvvvwbi = [];
		gettype_vvvvwbi.push(temp_vvvvwbi);
	}
	else if (!isSet(gettype_vvvvwbi))
	{
		var gettype_vvvvwbi = [];
	}
	var gettype = gettype_vvvvwbi.some(gettype_vvvvwbi_SomeFunc);


	// set this function logic
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
	}
}

// the vvvvwbi Some function
function addcalculation_vvvvwbi_SomeFunc(addcalculation_vvvvwbi)
{
	// set the function logic
	if (addcalculation_vvvvwbi == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbi Some function
function gettype_vvvvwbi_SomeFunc(gettype_vvvvwbi)
{
	// set the function logic
	if (gettype_vvvvwbi == 2 || gettype_vvvvwbi == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbl function
function vvvvwbl(main_source_vvvvwbl)
{
	if (isSet(main_source_vvvvwbl) && main_source_vvvvwbl.constructor !== Array)
	{
		var temp_vvvvwbl = main_source_vvvvwbl;
		var main_source_vvvvwbl = [];
		main_source_vvvvwbl.push(temp_vvvvwbl);
	}
	else if (!isSet(main_source_vvvvwbl))
	{
		var main_source_vvvvwbl = [];
	}
	var main_source = main_source_vvvvwbl.some(main_source_vvvvwbl_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbl Some function
function main_source_vvvvwbl_SomeFunc(main_source_vvvvwbl)
{
	// set the function logic
	if (main_source_vvvvwbl == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbm function
function vvvvwbm(main_source_vvvvwbm)
{
	if (isSet(main_source_vvvvwbm) && main_source_vvvvwbm.constructor !== Array)
	{
		var temp_vvvvwbm = main_source_vvvvwbm;
		var main_source_vvvvwbm = [];
		main_source_vvvvwbm.push(temp_vvvvwbm);
	}
	else if (!isSet(main_source_vvvvwbm))
	{
		var main_source_vvvvwbm = [];
	}
	var main_source = main_source_vvvvwbm.some(main_source_vvvvwbm_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_filter-lbl').closest('.control-group').show();
		jQuery('#jform_global-lbl').closest('.control-group').show();
		jQuery('#jform_group-lbl').closest('.control-group').show();
		jQuery('#jform_order-lbl').closest('.control-group').show();
		jQuery('#jform_where-lbl').closest('.control-group').show();
		jQuery('#jform_join_db_table-lbl').closest('.control-group').show();
		jQuery('#jform_join_view_table-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_filter-lbl').closest('.control-group').hide();
		jQuery('#jform_global-lbl').closest('.control-group').hide();
		jQuery('#jform_group-lbl').closest('.control-group').hide();
		jQuery('#jform_order-lbl').closest('.control-group').hide();
		jQuery('#jform_where-lbl').closest('.control-group').hide();
		jQuery('#jform_join_db_table-lbl').closest('.control-group').hide();
		jQuery('#jform_join_view_table-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbm Some function
function main_source_vvvvwbm_SomeFunc(main_source_vvvvwbm)
{
	// set the function logic
	if (main_source_vvvvwbm == 1 || main_source_vvvvwbm == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(add_php_before_getitem_vvvvwbn,gettype_vvvvwbn)
{
	if (isSet(add_php_before_getitem_vvvvwbn) && add_php_before_getitem_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = add_php_before_getitem_vvvvwbn;
		var add_php_before_getitem_vvvvwbn = [];
		add_php_before_getitem_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(add_php_before_getitem_vvvvwbn))
	{
		var add_php_before_getitem_vvvvwbn = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvwbn.some(add_php_before_getitem_vvvvwbn_SomeFunc);

	if (isSet(gettype_vvvvwbn) && gettype_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = gettype_vvvvwbn;
		var gettype_vvvvwbn = [];
		gettype_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(gettype_vvvvwbn))
	{
		var gettype_vvvvwbn = [];
	}
	var gettype = gettype_vvvvwbn.some(gettype_vvvvwbn_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbn Some function
function add_php_before_getitem_vvvvwbn_SomeFunc(add_php_before_getitem_vvvvwbn)
{
	// set the function logic
	if (add_php_before_getitem_vvvvwbn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbn Some function
function gettype_vvvvwbn_SomeFunc(gettype_vvvvwbn)
{
	// set the function logic
	if (gettype_vvvvwbn == 1 || gettype_vvvvwbn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbo function
function vvvvwbo(add_php_after_getitem_vvvvwbo,gettype_vvvvwbo)
{
	if (isSet(add_php_after_getitem_vvvvwbo) && add_php_after_getitem_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = add_php_after_getitem_vvvvwbo;
		var add_php_after_getitem_vvvvwbo = [];
		add_php_after_getitem_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(add_php_after_getitem_vvvvwbo))
	{
		var add_php_after_getitem_vvvvwbo = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvwbo.some(add_php_after_getitem_vvvvwbo_SomeFunc);

	if (isSet(gettype_vvvvwbo) && gettype_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = gettype_vvvvwbo;
		var gettype_vvvvwbo = [];
		gettype_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(gettype_vvvvwbo))
	{
		var gettype_vvvvwbo = [];
	}
	var gettype = gettype_vvvvwbo.some(gettype_vvvvwbo_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbo Some function
function add_php_after_getitem_vvvvwbo_SomeFunc(add_php_after_getitem_vvvvwbo)
{
	// set the function logic
	if (add_php_after_getitem_vvvvwbo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbo Some function
function gettype_vvvvwbo_SomeFunc(gettype_vvvvwbo)
{
	// set the function logic
	if (gettype_vvvvwbo == 1 || gettype_vvvvwbo == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbq function
function vvvvwbq(gettype_vvvvwbq)
{
	if (isSet(gettype_vvvvwbq) && gettype_vvvvwbq.constructor !== Array)
	{
		var temp_vvvvwbq = gettype_vvvvwbq;
		var gettype_vvvvwbq = [];
		gettype_vvvvwbq.push(temp_vvvvwbq);
	}
	else if (!isSet(gettype_vvvvwbq))
	{
		var gettype_vvvvwbq = [];
	}
	var gettype = gettype_vvvvwbq.some(gettype_vvvvwbq_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		// add required attribute to add_php_after_getitem field
		if (jform_vvvvwbqvwz_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvwbqvwz_required = false;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		// add required attribute to add_php_before_getitem field
		if (jform_vvvvwbqvxa_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvwbqvxa_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitem field
		if (!jform_vvvvwbqvwz_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvwbqvwz_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitem field
		if (!jform_vvvvwbqvxa_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvwbqvxa_required = true;
		}
	}
}

// the vvvvwbq Some function
function gettype_vvvvwbq_SomeFunc(gettype_vvvvwbq)
{
	// set the function logic
	if (gettype_vvvvwbq == 1 || gettype_vvvvwbq == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbr function
function vvvvwbr(add_php_getlistquery_vvvvwbr,gettype_vvvvwbr)
{
	if (isSet(add_php_getlistquery_vvvvwbr) && add_php_getlistquery_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = add_php_getlistquery_vvvvwbr;
		var add_php_getlistquery_vvvvwbr = [];
		add_php_getlistquery_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(add_php_getlistquery_vvvvwbr))
	{
		var add_php_getlistquery_vvvvwbr = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvwbr.some(add_php_getlistquery_vvvvwbr_SomeFunc);

	if (isSet(gettype_vvvvwbr) && gettype_vvvvwbr.constructor !== Array)
	{
		var temp_vvvvwbr = gettype_vvvvwbr;
		var gettype_vvvvwbr = [];
		gettype_vvvvwbr.push(temp_vvvvwbr);
	}
	else if (!isSet(gettype_vvvvwbr))
	{
		var gettype_vvvvwbr = [];
	}
	var gettype = gettype_vvvvwbr.some(gettype_vvvvwbr_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbr Some function
function add_php_getlistquery_vvvvwbr_SomeFunc(add_php_getlistquery_vvvvwbr)
{
	// set the function logic
	if (add_php_getlistquery_vvvvwbr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbr Some function
function gettype_vvvvwbr_SomeFunc(gettype_vvvvwbr)
{
	// set the function logic
	if (gettype_vvvvwbr == 2 || gettype_vvvvwbr == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbs function
function vvvvwbs(add_php_before_getitems_vvvvwbs,gettype_vvvvwbs)
{
	if (isSet(add_php_before_getitems_vvvvwbs) && add_php_before_getitems_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = add_php_before_getitems_vvvvwbs;
		var add_php_before_getitems_vvvvwbs = [];
		add_php_before_getitems_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(add_php_before_getitems_vvvvwbs))
	{
		var add_php_before_getitems_vvvvwbs = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvwbs.some(add_php_before_getitems_vvvvwbs_SomeFunc);

	if (isSet(gettype_vvvvwbs) && gettype_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = gettype_vvvvwbs;
		var gettype_vvvvwbs = [];
		gettype_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(gettype_vvvvwbs))
	{
		var gettype_vvvvwbs = [];
	}
	var gettype = gettype_vvvvwbs.some(gettype_vvvvwbs_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbs Some function
function add_php_before_getitems_vvvvwbs_SomeFunc(add_php_before_getitems_vvvvwbs)
{
	// set the function logic
	if (add_php_before_getitems_vvvvwbs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbs Some function
function gettype_vvvvwbs_SomeFunc(gettype_vvvvwbs)
{
	// set the function logic
	if (gettype_vvvvwbs == 2 || gettype_vvvvwbs == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbt function
function vvvvwbt(add_php_after_getitems_vvvvwbt,gettype_vvvvwbt)
{
	if (isSet(add_php_after_getitems_vvvvwbt) && add_php_after_getitems_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = add_php_after_getitems_vvvvwbt;
		var add_php_after_getitems_vvvvwbt = [];
		add_php_after_getitems_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(add_php_after_getitems_vvvvwbt))
	{
		var add_php_after_getitems_vvvvwbt = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvwbt.some(add_php_after_getitems_vvvvwbt_SomeFunc);

	if (isSet(gettype_vvvvwbt) && gettype_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = gettype_vvvvwbt;
		var gettype_vvvvwbt = [];
		gettype_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(gettype_vvvvwbt))
	{
		var gettype_vvvvwbt = [];
	}
	var gettype = gettype_vvvvwbt.some(gettype_vvvvwbt_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbt Some function
function add_php_after_getitems_vvvvwbt_SomeFunc(add_php_after_getitems_vvvvwbt)
{
	// set the function logic
	if (add_php_after_getitems_vvvvwbt == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbt Some function
function gettype_vvvvwbt_SomeFunc(gettype_vvvvwbt)
{
	// set the function logic
	if (gettype_vvvvwbt == 2 || gettype_vvvvwbt == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbv function
function vvvvwbv(gettype_vvvvwbv)
{
	if (isSet(gettype_vvvvwbv) && gettype_vvvvwbv.constructor !== Array)
	{
		var temp_vvvvwbv = gettype_vvvvwbv;
		var gettype_vvvvwbv = [];
		gettype_vvvvwbv.push(temp_vvvvwbv);
	}
	else if (!isSet(gettype_vvvvwbv))
	{
		var gettype_vvvvwbv = [];
	}
	var gettype = gettype_vvvvwbv.some(gettype_vvvvwbv_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		// add required attribute to add_php_after_getitems field
		if (jform_vvvvwbvvxb_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvwbvvxb_required = false;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		// add required attribute to add_php_before_getitems field
		if (jform_vvvvwbvvxc_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvwbvvxc_required = false;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		// add required attribute to add_php_getlistquery field
		if (jform_vvvvwbvvxd_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvwbvvxd_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitems field
		if (!jform_vvvvwbvvxb_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvwbvvxb_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitems field
		if (!jform_vvvvwbvvxc_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvwbvvxc_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		// remove required attribute from add_php_getlistquery field
		if (!jform_vvvvwbvvxd_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvwbvvxd_required = true;
		}
	}
}

// the vvvvwbv Some function
function gettype_vvvvwbv_SomeFunc(gettype_vvvvwbv)
{
	// set the function logic
	if (gettype_vvvvwbv == 2 || gettype_vvvvwbv == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwbw function
function vvvvwbw(gettype_vvvvwbw)
{
	if (isSet(gettype_vvvvwbw) && gettype_vvvvwbw.constructor !== Array)
	{
		var temp_vvvvwbw = gettype_vvvvwbw;
		var gettype_vvvvwbw = [];
		gettype_vvvvwbw.push(temp_vvvvwbw);
	}
	else if (!isSet(gettype_vvvvwbw))
	{
		var gettype_vvvvwbw = [];
	}
	var gettype = gettype_vvvvwbw.some(gettype_vvvvwbw_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		// add required attribute to pagination field
		if (jform_vvvvwbwvxe_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvwbwvxe_required = false;
		}
	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		// remove required attribute from pagination field
		if (!jform_vvvvwbwvxe_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvwbwvxe_required = true;
		}
	}
}

// the vvvvwbw Some function
function gettype_vvvvwbw_SomeFunc(gettype_vvvvwbw)
{
	// set the function logic
	if (gettype_vvvvwbw == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbx function
function vvvvwbx(gettype_vvvvwbx)
{
	if (isSet(gettype_vvvvwbx) && gettype_vvvvwbx.constructor !== Array)
	{
		var temp_vvvvwbx = gettype_vvvvwbx;
		var gettype_vvvvwbx = [];
		gettype_vvvvwbx.push(temp_vvvvwbx);
	}
	else if (!isSet(gettype_vvvvwbx))
	{
		var gettype_vvvvwbx = [];
	}
	var gettype = gettype_vvvvwbx.some(gettype_vvvvwbx_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		// add required attribute to add_php_router_parse field
		if (jform_vvvvwbxvxf_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvwbxvxf_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		// remove required attribute from add_php_router_parse field
		if (!jform_vvvvwbxvxf_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvwbxvxf_required = true;
		}
	}
}

// the vvvvwbx Some function
function gettype_vvvvwbx_SomeFunc(gettype_vvvvwbx)
{
	// set the function logic
	if (gettype_vvvvwbx == 1 || gettype_vvvvwbx == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwby function
function vvvvwby(gettype_vvvvwby,add_php_router_parse_vvvvwby)
{
	if (isSet(gettype_vvvvwby) && gettype_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = gettype_vvvvwby;
		var gettype_vvvvwby = [];
		gettype_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(gettype_vvvvwby))
	{
		var gettype_vvvvwby = [];
	}
	var gettype = gettype_vvvvwby.some(gettype_vvvvwby_SomeFunc);

	if (isSet(add_php_router_parse_vvvvwby) && add_php_router_parse_vvvvwby.constructor !== Array)
	{
		var temp_vvvvwby = add_php_router_parse_vvvvwby;
		var add_php_router_parse_vvvvwby = [];
		add_php_router_parse_vvvvwby.push(temp_vvvvwby);
	}
	else if (!isSet(add_php_router_parse_vvvvwby))
	{
		var add_php_router_parse_vvvvwby = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvwby.some(add_php_router_parse_vvvvwby_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		// add required attribute to php_router_parse field
		if (jform_vvvvwbyvxg_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvwbyvxg_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		// remove required attribute from php_router_parse field
		if (!jform_vvvvwbyvxg_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvwbyvxg_required = true;
		}
	}
}

// the vvvvwby Some function
function gettype_vvvvwby_SomeFunc(gettype_vvvvwby)
{
	// set the function logic
	if (gettype_vvvvwby == 1 || gettype_vvvvwby == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwby Some function
function add_php_router_parse_vvvvwby_SomeFunc(add_php_router_parse_vvvvwby)
{
	// set the function logic
	if (add_php_router_parse_vvvvwby == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwca function
function vvvvwca(gettype_vvvvwca)
{
	if (isSet(gettype_vvvvwca) && gettype_vvvvwca.constructor !== Array)
	{
		var temp_vvvvwca = gettype_vvvvwca;
		var gettype_vvvvwca = [];
		gettype_vvvvwca.push(temp_vvvvwca);
	}
	else if (!isSet(gettype_vvvvwca))
	{
		var gettype_vvvvwca = [];
	}
	var gettype = gettype_vvvvwca.some(gettype_vvvvwca_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_plugin_events').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_plugin_events').closest('.control-group').hide();
	}
}

// the vvvvwca Some function
function gettype_vvvvwca_SomeFunc(gettype_vvvvwca)
{
	// set the function logic
	if (gettype_vvvvwca == 1)
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


jQuery(document).ready(function()
{
	// get the linked details
	getLinked();
	var valueSwitch = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	getDynamicScripts(valueSwitch);
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});

function setSelectAll(select_all){
	// get source type
	var main_source =  jQuery("#jform_main_source").val();
	if (1 == main_source) {
		var key = 'view';
	} else if (2 == main_source) {
		var key = 'db';
	} else {
		return true;
	}
	// only continue if set
	if (select_all == 1) {
		// set default notice
		jQuery("#jform_"+key+"_selection").val('a.*');
		// set the selection text area to read only
		jQuery("#jform_"+key+"_selection").prop("readonly", true);
	} else {
		// remove the read only from selection text area
		jQuery("#jform_"+key+"_selection").prop("readonly", false);
		// get selected options
		var value_main =  jQuery("#jform_"+key+"_table_main option:selected").val();
		// make sure that all fields are set as selected
		if (key === 'view') {
			getViewTableColumns(value_main, 'a', key, 3, true, '', '');
		} else {
			getDbTableColumns(value_main, 'a', key, 3, true, '', '');
		}
	}
}

function getViewTableColumns_server(viewId,asKey,rowType){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.viewTableColumns&format=json&raw=true");
	if (token.length > 0 && viewId > 0 && asKey.length > 0)
	{
		var request = token+'=1&as='+asKey+'&type='+rowType+'&id='+viewId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getViewTableColumns(id, asKey, key, rowType, main, table_, nr_){
	// check if this is the main view
	if (main){
		var select_all =  jQuery("#jform_select_all input[type='radio']:checked").val();
		// do not continue if set
		if (select_all == 1){
			setSelectAll(select_all);
			return true;
		}
	}
	getViewTableColumns_server(id, asKey, rowType).done(function(result) {
		if (result) {
			loadSelectionData(result, 'view', key, main, table_, nr_);
		} else {
			loadSelectionData(false, 'view', key, main, table_, nr_);
		}
	})
}

function getDbTableColumns_server(name,asKey,rowType)
{
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.dbTableColumns&format=json&raw=true");
	if (token.length > 0 && name.length > 0 && asKey.length > 0) {
		var request = token+'=1&as='+asKey+'&type='+rowType+'&name='+name;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getDbTableColumns(name, asKey, key, rowType, main, table_, nr_){
	// check if this is the main view
	if (main){
		var select_all =  jQuery("#jform_select_all input[type='radio']:checked").val();
		// do not continue if set
		if (select_all == 1){
			setSelectAll(select_all);
			return true;
		}
	}
	getDbTableColumns_server(name,asKey,rowType).done(function(result) {
		if (result) {
			loadSelectionData(result, 'db', key, main, table_, nr_);
		} else {
			loadSelectionData(false, 'db', key, main, table_, nr_);
		}
	})
}

function loadSelectionData(result, type, key, main, table_, nr_)
{
	if (main)
	{
		var textArea = 'textarea#jform_'+key+'_selection';
	}
	else 
	{
		var textArea = 'textarea#jform_join_'+type+'_table'+table_+'_join_'+type+'_table'+key+nr_+'_selection';
	}
	// no update the text area
	if (result)
	{
		jQuery(textArea).val(result);
	}
	else
	{
		jQuery(textArea).val('');
	}
}
function updateSubItems(fieldName, fieldNr, table_, nr_) {
	if(jQuery('#jform_join_'+fieldName+'_table'+table_+'_join_'+fieldName+'_table'+fieldNr+nr_+'_'+fieldName+'_table').length) {
		jQuery('#adminForm').on('change', '#jform_join_'+fieldName+'_table'+table_+'_join_'+fieldName+'_table'+fieldNr+nr_+'_'+fieldName+'_table',function (e) {
			e.preventDefault();
			// get options
			var value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_"+fieldName+"_table option:selected").val();
			var as_value2 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_as option:selected").val();
			var row_value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_row_type option:selected").val();
			if (fieldName === 'view') {
				getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			} else {
				getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			}
		});
		jQuery('#adminForm').on('change', '#jform_join_'+fieldName+'_table'+table_+'_join_'+fieldName+'_table'+fieldNr+nr_+'_as',function (e) {
			e.preventDefault();
			// get options
			var value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_"+fieldName+"_table option:selected").val();
			var as_value2 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_as option:selected").val();
			var row_value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_row_type option:selected").val();
			if (fieldName === 'view') {
				getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			} else {
				getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			}
		});
		jQuery('#adminForm').on('change', '#jform_join_'+fieldName+'_table'+table_+'_join_'+fieldName+'_table'+fieldNr+nr_+'_row_type',function (e) {
			e.preventDefault();
			// get options
			var value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_"+fieldName+"_table option:selected").val();
			var as_value2 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_as option:selected").val();
			var row_value1 = jQuery("#jform_join_"+fieldName+"_table"+table_+"_join_"+fieldName+"_table"+fieldNr+nr_+"_row_type option:selected").val();
			if (fieldName === 'view') {
				getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			} else {
				getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
			}
		});
	}
}

function getDynamicScripts(id){
	if (1 == id) {
		// get the current values
		var current_router_parse = jQuery('textarea#jform_php_router_parse').val();
		// set the router parse method script
		if(current_router_parse.length == 0){
			getCodeFrom_server(1, 'routerparse', 'type', 'getDynamicScripts').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_router_parse').val(result);
				}
			});
		}
	}
}

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

function getLinked(){
	getCodeFrom_server(1, 'type', 'type', 'getLinked').done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
} 
