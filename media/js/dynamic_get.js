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
jform_vvvvwbbvws_required = false;
jform_vvvvwbdvwt_required = false;
jform_vvvvwbevwu_required = false;
jform_vvvvwbfvwv_required = false;
jform_vvvvwbgvww_required = false;
jform_vvvvwbrvwx_required = false;
jform_vvvvwbrvwy_required = false;
jform_vvvvwbwvwz_required = false;
jform_vvvvwbwvxa_required = false;
jform_vvvvwbwvxb_required = false;
jform_vvvvwbxvxc_required = false;
jform_vvvvwbyvxd_required = false;
jform_vvvvwbzvxe_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvwbb = jQuery("#jform_gettype").val();
	vvvvwbb(gettype_vvvvwbb);

	var main_source_vvvvwbc = jQuery("#jform_main_source").val();
	vvvvwbc(main_source_vvvvwbc);

	var main_source_vvvvwbd = jQuery("#jform_main_source").val();
	vvvvwbd(main_source_vvvvwbd);

	var main_source_vvvvwbe = jQuery("#jform_main_source").val();
	vvvvwbe(main_source_vvvvwbe);

	var main_source_vvvvwbf = jQuery("#jform_main_source").val();
	vvvvwbf(main_source_vvvvwbf);

	var main_source_vvvvwbg = jQuery("#jform_main_source").val();
	vvvvwbg(main_source_vvvvwbg);

	var addcalculation_vvvvwbh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvwbh(addcalculation_vvvvwbh);

	var addcalculation_vvvvwbi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbi = jQuery("#jform_gettype").val();
	vvvvwbi(addcalculation_vvvvwbi,gettype_vvvvwbi);

	var addcalculation_vvvvwbj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvwbj = jQuery("#jform_gettype").val();
	vvvvwbj(addcalculation_vvvvwbj,gettype_vvvvwbj);

	var main_source_vvvvwbm = jQuery("#jform_main_source").val();
	vvvvwbm(main_source_vvvvwbm);

	var main_source_vvvvwbn = jQuery("#jform_main_source").val();
	vvvvwbn(main_source_vvvvwbn);

	var add_php_before_getitem_vvvvwbo = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbo = jQuery("#jform_gettype").val();
	vvvvwbo(add_php_before_getitem_vvvvwbo,gettype_vvvvwbo);

	var add_php_after_getitem_vvvvwbp = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvwbp = jQuery("#jform_gettype").val();
	vvvvwbp(add_php_after_getitem_vvvvwbp,gettype_vvvvwbp);

	var gettype_vvvvwbr = jQuery("#jform_gettype").val();
	vvvvwbr(gettype_vvvvwbr);

	var add_php_getlistquery_vvvvwbs = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwbs = jQuery("#jform_gettype").val();
	vvvvwbs(add_php_getlistquery_vvvvwbs,gettype_vvvvwbs);

	var add_php_before_getitems_vvvvwbt = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbt = jQuery("#jform_gettype").val();
	vvvvwbt(add_php_before_getitems_vvvvwbt,gettype_vvvvwbt);

	var add_php_after_getitems_vvvvwbu = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwbu = jQuery("#jform_gettype").val();
	vvvvwbu(add_php_after_getitems_vvvvwbu,gettype_vvvvwbu);

	var gettype_vvvvwbw = jQuery("#jform_gettype").val();
	vvvvwbw(gettype_vvvvwbw);

	var gettype_vvvvwbx = jQuery("#jform_gettype").val();
	vvvvwbx(gettype_vvvvwbx);

	var gettype_vvvvwby = jQuery("#jform_gettype").val();
	vvvvwby(gettype_vvvvwby);

	var gettype_vvvvwbz = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwbz = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwbz(gettype_vvvvwbz,add_php_router_parse_vvvvwbz);

	var gettype_vvvvwcb = jQuery("#jform_gettype").val();
	vvvvwcb(gettype_vvvvwcb);
});

// the vvvvwbb function
function vvvvwbb(gettype_vvvvwbb)
{
	if (isSet(gettype_vvvvwbb) && gettype_vvvvwbb.constructor !== Array)
	{
		var temp_vvvvwbb = gettype_vvvvwbb;
		var gettype_vvvvwbb = [];
		gettype_vvvvwbb.push(temp_vvvvwbb);
	}
	else if (!isSet(gettype_vvvvwbb))
	{
		var gettype_vvvvwbb = [];
	}
	var gettype = gettype_vvvvwbb.some(gettype_vvvvwbb_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		// add required attribute to getcustom field
		if (jform_vvvvwbbvws_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvwbbvws_required = false;
		}
	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		// remove required attribute from getcustom field
		if (!jform_vvvvwbbvws_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvwbbvws_required = true;
		}
	}
}

// the vvvvwbb Some function
function gettype_vvvvwbb_SomeFunc(gettype_vvvvwbb)
{
	// set the function logic
	if (gettype_vvvvwbb == 3 || gettype_vvvvwbb == 4)
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
		jQuery('#jform_select_all').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_select_all').closest('.control-group').hide();
	}
}

// the vvvvwbc Some function
function main_source_vvvvwbc_SomeFunc(main_source_vvvvwbc)
{
	// set the function logic
	if (main_source_vvvvwbc == 1 || main_source_vvvvwbc == 2)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		// add required attribute to view_table_main field
		if (jform_vvvvwbdvwt_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvwbdvwt_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		// remove required attribute from view_table_main field
		if (!jform_vvvvwbdvwt_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvwbdvwt_required = true;
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		// add required attribute to view_selection field
		if (jform_vvvvwbevwu_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvwbevwu_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		// remove required attribute from view_selection field
		if (!jform_vvvvwbevwu_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvwbevwu_required = true;
		}
	}
}

// the vvvvwbe Some function
function main_source_vvvvwbe_SomeFunc(main_source_vvvvwbe)
{
	// set the function logic
	if (main_source_vvvvwbe == 1)
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		// add required attribute to db_table_main field
		if (jform_vvvvwbfvwv_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvwbfvwv_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		// remove required attribute from db_table_main field
		if (!jform_vvvvwbfvwv_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvwbfvwv_required = true;
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
function vvvvwbg(main_source_vvvvwbg)
{
	if (isSet(main_source_vvvvwbg) && main_source_vvvvwbg.constructor !== Array)
	{
		var temp_vvvvwbg = main_source_vvvvwbg;
		var main_source_vvvvwbg = [];
		main_source_vvvvwbg.push(temp_vvvvwbg);
	}
	else if (!isSet(main_source_vvvvwbg))
	{
		var main_source_vvvvwbg = [];
	}
	var main_source = main_source_vvvvwbg.some(main_source_vvvvwbg_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		// add required attribute to db_selection field
		if (jform_vvvvwbgvww_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvwbgvww_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		// remove required attribute from db_selection field
		if (!jform_vvvvwbgvww_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvwbgvww_required = true;
		}
	}
}

// the vvvvwbg Some function
function main_source_vvvvwbg_SomeFunc(main_source_vvvvwbg)
{
	// set the function logic
	if (main_source_vvvvwbg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbh function
function vvvvwbh(addcalculation_vvvvwbh)
{
	// set the function logic
	if (addcalculation_vvvvwbh == 1)
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').hide();
	}
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
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
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
	if (gettype_vvvvwbi == 1 || gettype_vvvvwbi == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbj function
function vvvvwbj(addcalculation_vvvvwbj,gettype_vvvvwbj)
{
	if (isSet(addcalculation_vvvvwbj) && addcalculation_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = addcalculation_vvvvwbj;
		var addcalculation_vvvvwbj = [];
		addcalculation_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(addcalculation_vvvvwbj))
	{
		var addcalculation_vvvvwbj = [];
	}
	var addcalculation = addcalculation_vvvvwbj.some(addcalculation_vvvvwbj_SomeFunc);

	if (isSet(gettype_vvvvwbj) && gettype_vvvvwbj.constructor !== Array)
	{
		var temp_vvvvwbj = gettype_vvvvwbj;
		var gettype_vvvvwbj = [];
		gettype_vvvvwbj.push(temp_vvvvwbj);
	}
	else if (!isSet(gettype_vvvvwbj))
	{
		var gettype_vvvvwbj = [];
	}
	var gettype = gettype_vvvvwbj.some(gettype_vvvvwbj_SomeFunc);


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

// the vvvvwbj Some function
function addcalculation_vvvvwbj_SomeFunc(addcalculation_vvvvwbj)
{
	// set the function logic
	if (addcalculation_vvvvwbj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbj Some function
function gettype_vvvvwbj_SomeFunc(gettype_vvvvwbj)
{
	// set the function logic
	if (gettype_vvvvwbj == 2 || gettype_vvvvwbj == 4)
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
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbm Some function
function main_source_vvvvwbm_SomeFunc(main_source_vvvvwbm)
{
	// set the function logic
	if (main_source_vvvvwbm == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbn function
function vvvvwbn(main_source_vvvvwbn)
{
	if (isSet(main_source_vvvvwbn) && main_source_vvvvwbn.constructor !== Array)
	{
		var temp_vvvvwbn = main_source_vvvvwbn;
		var main_source_vvvvwbn = [];
		main_source_vvvvwbn.push(temp_vvvvwbn);
	}
	else if (!isSet(main_source_vvvvwbn))
	{
		var main_source_vvvvwbn = [];
	}
	var main_source = main_source_vvvvwbn.some(main_source_vvvvwbn_SomeFunc);


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

// the vvvvwbn Some function
function main_source_vvvvwbn_SomeFunc(main_source_vvvvwbn)
{
	// set the function logic
	if (main_source_vvvvwbn == 1 || main_source_vvvvwbn == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbo function
function vvvvwbo(add_php_before_getitem_vvvvwbo,gettype_vvvvwbo)
{
	if (isSet(add_php_before_getitem_vvvvwbo) && add_php_before_getitem_vvvvwbo.constructor !== Array)
	{
		var temp_vvvvwbo = add_php_before_getitem_vvvvwbo;
		var add_php_before_getitem_vvvvwbo = [];
		add_php_before_getitem_vvvvwbo.push(temp_vvvvwbo);
	}
	else if (!isSet(add_php_before_getitem_vvvvwbo))
	{
		var add_php_before_getitem_vvvvwbo = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvwbo.some(add_php_before_getitem_vvvvwbo_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbo Some function
function add_php_before_getitem_vvvvwbo_SomeFunc(add_php_before_getitem_vvvvwbo)
{
	// set the function logic
	if (add_php_before_getitem_vvvvwbo == 1)
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

// the vvvvwbp function
function vvvvwbp(add_php_after_getitem_vvvvwbp,gettype_vvvvwbp)
{
	if (isSet(add_php_after_getitem_vvvvwbp) && add_php_after_getitem_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = add_php_after_getitem_vvvvwbp;
		var add_php_after_getitem_vvvvwbp = [];
		add_php_after_getitem_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(add_php_after_getitem_vvvvwbp))
	{
		var add_php_after_getitem_vvvvwbp = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvwbp.some(add_php_after_getitem_vvvvwbp_SomeFunc);

	if (isSet(gettype_vvvvwbp) && gettype_vvvvwbp.constructor !== Array)
	{
		var temp_vvvvwbp = gettype_vvvvwbp;
		var gettype_vvvvwbp = [];
		gettype_vvvvwbp.push(temp_vvvvwbp);
	}
	else if (!isSet(gettype_vvvvwbp))
	{
		var gettype_vvvvwbp = [];
	}
	var gettype = gettype_vvvvwbp.some(gettype_vvvvwbp_SomeFunc);


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

// the vvvvwbp Some function
function add_php_after_getitem_vvvvwbp_SomeFunc(add_php_after_getitem_vvvvwbp)
{
	// set the function logic
	if (add_php_after_getitem_vvvvwbp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbp Some function
function gettype_vvvvwbp_SomeFunc(gettype_vvvvwbp)
{
	// set the function logic
	if (gettype_vvvvwbp == 1 || gettype_vvvvwbp == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbr function
function vvvvwbr(gettype_vvvvwbr)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		// add required attribute to add_php_after_getitem field
		if (jform_vvvvwbrvwx_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvwbrvwx_required = false;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		// add required attribute to add_php_before_getitem field
		if (jform_vvvvwbrvwy_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvwbrvwy_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitem field
		if (!jform_vvvvwbrvwx_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvwbrvwx_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitem field
		if (!jform_vvvvwbrvwy_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvwbrvwy_required = true;
		}
	}
}

// the vvvvwbr Some function
function gettype_vvvvwbr_SomeFunc(gettype_vvvvwbr)
{
	// set the function logic
	if (gettype_vvvvwbr == 1 || gettype_vvvvwbr == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwbs function
function vvvvwbs(add_php_getlistquery_vvvvwbs,gettype_vvvvwbs)
{
	if (isSet(add_php_getlistquery_vvvvwbs) && add_php_getlistquery_vvvvwbs.constructor !== Array)
	{
		var temp_vvvvwbs = add_php_getlistquery_vvvvwbs;
		var add_php_getlistquery_vvvvwbs = [];
		add_php_getlistquery_vvvvwbs.push(temp_vvvvwbs);
	}
	else if (!isSet(add_php_getlistquery_vvvvwbs))
	{
		var add_php_getlistquery_vvvvwbs = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvwbs.some(add_php_getlistquery_vvvvwbs_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbs Some function
function add_php_getlistquery_vvvvwbs_SomeFunc(add_php_getlistquery_vvvvwbs)
{
	// set the function logic
	if (add_php_getlistquery_vvvvwbs == 1)
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
function vvvvwbt(add_php_before_getitems_vvvvwbt,gettype_vvvvwbt)
{
	if (isSet(add_php_before_getitems_vvvvwbt) && add_php_before_getitems_vvvvwbt.constructor !== Array)
	{
		var temp_vvvvwbt = add_php_before_getitems_vvvvwbt;
		var add_php_before_getitems_vvvvwbt = [];
		add_php_before_getitems_vvvvwbt.push(temp_vvvvwbt);
	}
	else if (!isSet(add_php_before_getitems_vvvvwbt))
	{
		var add_php_before_getitems_vvvvwbt = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvwbt.some(add_php_before_getitems_vvvvwbt_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').hide();
	}
}

// the vvvvwbt Some function
function add_php_before_getitems_vvvvwbt_SomeFunc(add_php_before_getitems_vvvvwbt)
{
	// set the function logic
	if (add_php_before_getitems_vvvvwbt == 1)
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

// the vvvvwbu function
function vvvvwbu(add_php_after_getitems_vvvvwbu,gettype_vvvvwbu)
{
	if (isSet(add_php_after_getitems_vvvvwbu) && add_php_after_getitems_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = add_php_after_getitems_vvvvwbu;
		var add_php_after_getitems_vvvvwbu = [];
		add_php_after_getitems_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(add_php_after_getitems_vvvvwbu))
	{
		var add_php_after_getitems_vvvvwbu = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvwbu.some(add_php_after_getitems_vvvvwbu_SomeFunc);

	if (isSet(gettype_vvvvwbu) && gettype_vvvvwbu.constructor !== Array)
	{
		var temp_vvvvwbu = gettype_vvvvwbu;
		var gettype_vvvvwbu = [];
		gettype_vvvvwbu.push(temp_vvvvwbu);
	}
	else if (!isSet(gettype_vvvvwbu))
	{
		var gettype_vvvvwbu = [];
	}
	var gettype = gettype_vvvvwbu.some(gettype_vvvvwbu_SomeFunc);


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

// the vvvvwbu Some function
function add_php_after_getitems_vvvvwbu_SomeFunc(add_php_after_getitems_vvvvwbu)
{
	// set the function logic
	if (add_php_after_getitems_vvvvwbu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwbu Some function
function gettype_vvvvwbu_SomeFunc(gettype_vvvvwbu)
{
	// set the function logic
	if (gettype_vvvvwbu == 2 || gettype_vvvvwbu == 4)
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		// add required attribute to add_php_after_getitems field
		if (jform_vvvvwbwvwz_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvwbwvwz_required = false;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		// add required attribute to add_php_before_getitems field
		if (jform_vvvvwbwvxa_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvwbwvxa_required = false;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		// add required attribute to add_php_getlistquery field
		if (jform_vvvvwbwvxb_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvwbwvxb_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitems field
		if (!jform_vvvvwbwvwz_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvwbwvwz_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitems field
		if (!jform_vvvvwbwvxa_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvwbwvxa_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		// remove required attribute from add_php_getlistquery field
		if (!jform_vvvvwbwvxb_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvwbwvxb_required = true;
		}
	}
}

// the vvvvwbw Some function
function gettype_vvvvwbw_SomeFunc(gettype_vvvvwbw)
{
	// set the function logic
	if (gettype_vvvvwbw == 2 || gettype_vvvvwbw == 4)
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
		jQuery('#jform_pagination').closest('.control-group').show();
		// add required attribute to pagination field
		if (jform_vvvvwbxvxc_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvwbxvxc_required = false;
		}
	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		// remove required attribute from pagination field
		if (!jform_vvvvwbxvxc_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvwbxvxc_required = true;
		}
	}
}

// the vvvvwbx Some function
function gettype_vvvvwbx_SomeFunc(gettype_vvvvwbx)
{
	// set the function logic
	if (gettype_vvvvwbx == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwby function
function vvvvwby(gettype_vvvvwby)
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


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		// add required attribute to add_php_router_parse field
		if (jform_vvvvwbyvxd_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvwbyvxd_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		// remove required attribute from add_php_router_parse field
		if (!jform_vvvvwbyvxd_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvwbyvxd_required = true;
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

// the vvvvwbz function
function vvvvwbz(gettype_vvvvwbz,add_php_router_parse_vvvvwbz)
{
	if (isSet(gettype_vvvvwbz) && gettype_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = gettype_vvvvwbz;
		var gettype_vvvvwbz = [];
		gettype_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(gettype_vvvvwbz))
	{
		var gettype_vvvvwbz = [];
	}
	var gettype = gettype_vvvvwbz.some(gettype_vvvvwbz_SomeFunc);

	if (isSet(add_php_router_parse_vvvvwbz) && add_php_router_parse_vvvvwbz.constructor !== Array)
	{
		var temp_vvvvwbz = add_php_router_parse_vvvvwbz;
		var add_php_router_parse_vvvvwbz = [];
		add_php_router_parse_vvvvwbz.push(temp_vvvvwbz);
	}
	else if (!isSet(add_php_router_parse_vvvvwbz))
	{
		var add_php_router_parse_vvvvwbz = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvwbz.some(add_php_router_parse_vvvvwbz_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		// add required attribute to php_router_parse field
		if (jform_vvvvwbzvxe_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvwbzvxe_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		// remove required attribute from php_router_parse field
		if (!jform_vvvvwbzvxe_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvwbzvxe_required = true;
		}
	}
}

// the vvvvwbz Some function
function gettype_vvvvwbz_SomeFunc(gettype_vvvvwbz)
{
	// set the function logic
	if (gettype_vvvvwbz == 1 || gettype_vvvvwbz == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwbz Some function
function add_php_router_parse_vvvvwbz_SomeFunc(add_php_router_parse_vvvvwbz)
{
	// set the function logic
	if (add_php_router_parse_vvvvwbz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwcb function
function vvvvwcb(gettype_vvvvwcb)
{
	if (isSet(gettype_vvvvwcb) && gettype_vvvvwcb.constructor !== Array)
	{
		var temp_vvvvwcb = gettype_vvvvwcb;
		var gettype_vvvvwcb = [];
		gettype_vvvvwcb.push(temp_vvvvwcb);
	}
	else if (!isSet(gettype_vvvvwcb))
	{
		var gettype_vvvvwcb = [];
	}
	var gettype = gettype_vvvvwcb.some(gettype_vvvvwcb_SomeFunc);


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

// the vvvvwcb Some function
function gettype_vvvvwcb_SomeFunc(gettype_vvvvwcb)
{
	// set the function logic
	if (gettype_vvvvwcb == 1)
	{
		return true;
	}
	return false;
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (jQuery('#jform_not_required').length > 0) {
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
