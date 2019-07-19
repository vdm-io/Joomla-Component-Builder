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
jform_vvvvvzlvwn_required = false;
jform_vvvvvznvwo_required = false;
jform_vvvvvzovwp_required = false;
jform_vvvvvzpvwq_required = false;
jform_vvvvvzqvwr_required = false;
jform_vvvvwabvws_required = false;
jform_vvvvwabvwt_required = false;
jform_vvvvwagvwu_required = false;
jform_vvvvwagvwv_required = false;
jform_vvvvwagvww_required = false;
jform_vvvvwahvwx_required = false;
jform_vvvvwaivwy_required = false;
jform_vvvvwajvwz_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(gettype_vvvvvzl);

	var main_source_vvvvvzm = jQuery("#jform_main_source").val();
	vvvvvzm(main_source_vvvvvzm);

	var main_source_vvvvvzn = jQuery("#jform_main_source").val();
	vvvvvzn(main_source_vvvvvzn);

	var main_source_vvvvvzo = jQuery("#jform_main_source").val();
	vvvvvzo(main_source_vvvvvzo);

	var main_source_vvvvvzp = jQuery("#jform_main_source").val();
	vvvvvzp(main_source_vvvvvzp);

	var main_source_vvvvvzq = jQuery("#jform_main_source").val();
	vvvvvzq(main_source_vvvvvzq);

	var addcalculation_vvvvvzr = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzr(addcalculation_vvvvvzr);

	var addcalculation_vvvvvzs = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(addcalculation_vvvvvzs,gettype_vvvvvzs);

	var addcalculation_vvvvvzt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(addcalculation_vvvvvzt,gettype_vvvvvzt);

	var main_source_vvvvvzw = jQuery("#jform_main_source").val();
	vvvvvzw(main_source_vvvvvzw);

	var main_source_vvvvvzx = jQuery("#jform_main_source").val();
	vvvvvzx(main_source_vvvvvzx);

	var add_php_before_getitem_vvvvvzy = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	vvvvvzy(add_php_before_getitem_vvvvvzy,gettype_vvvvvzy);

	var add_php_after_getitem_vvvvvzz = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	vvvvvzz(add_php_after_getitem_vvvvvzz,gettype_vvvvvzz);

	var gettype_vvvvwab = jQuery("#jform_gettype").val();
	vvvvwab(gettype_vvvvwab);

	var add_php_getlistquery_vvvvwac = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvwac = jQuery("#jform_gettype").val();
	vvvvwac(add_php_getlistquery_vvvvwac,gettype_vvvvwac);

	var add_php_before_getitems_vvvvwad = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwad = jQuery("#jform_gettype").val();
	vvvvwad(add_php_before_getitems_vvvvwad,gettype_vvvvwad);

	var add_php_after_getitems_vvvvwae = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwae = jQuery("#jform_gettype").val();
	vvvvwae(add_php_after_getitems_vvvvwae,gettype_vvvvwae);

	var gettype_vvvvwag = jQuery("#jform_gettype").val();
	vvvvwag(gettype_vvvvwag);

	var gettype_vvvvwah = jQuery("#jform_gettype").val();
	vvvvwah(gettype_vvvvwah);

	var gettype_vvvvwai = jQuery("#jform_gettype").val();
	vvvvwai(gettype_vvvvwai);

	var gettype_vvvvwaj = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwaj = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwaj(gettype_vvvvwaj,add_php_router_parse_vvvvwaj);

	var gettype_vvvvwal = jQuery("#jform_gettype").val();
	vvvvwal(gettype_vvvvwal);
});

// the vvvvvzl function
function vvvvvzl(gettype_vvvvvzl)
{
	if (isSet(gettype_vvvvvzl) && gettype_vvvvvzl.constructor !== Array)
	{
		var temp_vvvvvzl = gettype_vvvvvzl;
		var gettype_vvvvvzl = [];
		gettype_vvvvvzl.push(temp_vvvvvzl);
	}
	else if (!isSet(gettype_vvvvvzl))
	{
		var gettype_vvvvvzl = [];
	}
	var gettype = gettype_vvvvvzl.some(gettype_vvvvvzl_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		// add required attribute to getcustom field
		if (jform_vvvvvzlvwn_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvzlvwn_required = false;
		}
	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		// remove required attribute from getcustom field
		if (!jform_vvvvvzlvwn_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvzlvwn_required = true;
		}
	}
}

// the vvvvvzl Some function
function gettype_vvvvvzl_SomeFunc(gettype_vvvvvzl)
{
	// set the function logic
	if (gettype_vvvvvzl == 3 || gettype_vvvvvzl == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzm function
function vvvvvzm(main_source_vvvvvzm)
{
	if (isSet(main_source_vvvvvzm) && main_source_vvvvvzm.constructor !== Array)
	{
		var temp_vvvvvzm = main_source_vvvvvzm;
		var main_source_vvvvvzm = [];
		main_source_vvvvvzm.push(temp_vvvvvzm);
	}
	else if (!isSet(main_source_vvvvvzm))
	{
		var main_source_vvvvvzm = [];
	}
	var main_source = main_source_vvvvvzm.some(main_source_vvvvvzm_SomeFunc);


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

// the vvvvvzm Some function
function main_source_vvvvvzm_SomeFunc(main_source_vvvvvzm)
{
	// set the function logic
	if (main_source_vvvvvzm == 1 || main_source_vvvvvzm == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzn function
function vvvvvzn(main_source_vvvvvzn)
{
	if (isSet(main_source_vvvvvzn) && main_source_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = main_source_vvvvvzn;
		var main_source_vvvvvzn = [];
		main_source_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(main_source_vvvvvzn))
	{
		var main_source_vvvvvzn = [];
	}
	var main_source = main_source_vvvvvzn.some(main_source_vvvvvzn_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		// add required attribute to view_table_main field
		if (jform_vvvvvznvwo_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvznvwo_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		// remove required attribute from view_table_main field
		if (!jform_vvvvvznvwo_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvznvwo_required = true;
		}
	}
}

// the vvvvvzn Some function
function main_source_vvvvvzn_SomeFunc(main_source_vvvvvzn)
{
	// set the function logic
	if (main_source_vvvvvzn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(main_source_vvvvvzo)
{
	if (isSet(main_source_vvvvvzo) && main_source_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = main_source_vvvvvzo;
		var main_source_vvvvvzo = [];
		main_source_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(main_source_vvvvvzo))
	{
		var main_source_vvvvvzo = [];
	}
	var main_source = main_source_vvvvvzo.some(main_source_vvvvvzo_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		// add required attribute to view_selection field
		if (jform_vvvvvzovwp_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzovwp_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		// remove required attribute from view_selection field
		if (!jform_vvvvvzovwp_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzovwp_required = true;
		}
	}
}

// the vvvvvzo Some function
function main_source_vvvvvzo_SomeFunc(main_source_vvvvvzo)
{
	// set the function logic
	if (main_source_vvvvvzo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzp function
function vvvvvzp(main_source_vvvvvzp)
{
	if (isSet(main_source_vvvvvzp) && main_source_vvvvvzp.constructor !== Array)
	{
		var temp_vvvvvzp = main_source_vvvvvzp;
		var main_source_vvvvvzp = [];
		main_source_vvvvvzp.push(temp_vvvvvzp);
	}
	else if (!isSet(main_source_vvvvvzp))
	{
		var main_source_vvvvvzp = [];
	}
	var main_source = main_source_vvvvvzp.some(main_source_vvvvvzp_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		// add required attribute to db_table_main field
		if (jform_vvvvvzpvwq_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzpvwq_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		// remove required attribute from db_table_main field
		if (!jform_vvvvvzpvwq_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvzpvwq_required = true;
		}
	}
}

// the vvvvvzp Some function
function main_source_vvvvvzp_SomeFunc(main_source_vvvvvzp)
{
	// set the function logic
	if (main_source_vvvvvzp == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzq function
function vvvvvzq(main_source_vvvvvzq)
{
	if (isSet(main_source_vvvvvzq) && main_source_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = main_source_vvvvvzq;
		var main_source_vvvvvzq = [];
		main_source_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(main_source_vvvvvzq))
	{
		var main_source_vvvvvzq = [];
	}
	var main_source = main_source_vvvvvzq.some(main_source_vvvvvzq_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		// add required attribute to db_selection field
		if (jform_vvvvvzqvwr_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzqvwr_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		// remove required attribute from db_selection field
		if (!jform_vvvvvzqvwr_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzqvwr_required = true;
		}
	}
}

// the vvvvvzq Some function
function main_source_vvvvvzq_SomeFunc(main_source_vvvvvzq)
{
	// set the function logic
	if (main_source_vvvvvzq == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzr function
function vvvvvzr(addcalculation_vvvvvzr)
{
	// set the function logic
	if (addcalculation_vvvvvzr == 1)
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzs function
function vvvvvzs(addcalculation_vvvvvzs,gettype_vvvvvzs)
{
	if (isSet(addcalculation_vvvvvzs) && addcalculation_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = addcalculation_vvvvvzs;
		var addcalculation_vvvvvzs = [];
		addcalculation_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(addcalculation_vvvvvzs))
	{
		var addcalculation_vvvvvzs = [];
	}
	var addcalculation = addcalculation_vvvvvzs.some(addcalculation_vvvvvzs_SomeFunc);

	if (isSet(gettype_vvvvvzs) && gettype_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = gettype_vvvvvzs;
		var gettype_vvvvvzs = [];
		gettype_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(gettype_vvvvvzs))
	{
		var gettype_vvvvvzs = [];
	}
	var gettype = gettype_vvvvvzs.some(gettype_vvvvvzs_SomeFunc);


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

// the vvvvvzs Some function
function addcalculation_vvvvvzs_SomeFunc(addcalculation_vvvvvzs)
{
	// set the function logic
	if (addcalculation_vvvvvzs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzs Some function
function gettype_vvvvvzs_SomeFunc(gettype_vvvvvzs)
{
	// set the function logic
	if (gettype_vvvvvzs == 1 || gettype_vvvvvzs == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzt function
function vvvvvzt(addcalculation_vvvvvzt,gettype_vvvvvzt)
{
	if (isSet(addcalculation_vvvvvzt) && addcalculation_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = addcalculation_vvvvvzt;
		var addcalculation_vvvvvzt = [];
		addcalculation_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(addcalculation_vvvvvzt))
	{
		var addcalculation_vvvvvzt = [];
	}
	var addcalculation = addcalculation_vvvvvzt.some(addcalculation_vvvvvzt_SomeFunc);

	if (isSet(gettype_vvvvvzt) && gettype_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = gettype_vvvvvzt;
		var gettype_vvvvvzt = [];
		gettype_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(gettype_vvvvvzt))
	{
		var gettype_vvvvvzt = [];
	}
	var gettype = gettype_vvvvvzt.some(gettype_vvvvvzt_SomeFunc);


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

// the vvvvvzt Some function
function addcalculation_vvvvvzt_SomeFunc(addcalculation_vvvvvzt)
{
	// set the function logic
	if (addcalculation_vvvvvzt == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzt Some function
function gettype_vvvvvzt_SomeFunc(gettype_vvvvvzt)
{
	// set the function logic
	if (gettype_vvvvvzt == 2 || gettype_vvvvvzt == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzw function
function vvvvvzw(main_source_vvvvvzw)
{
	if (isSet(main_source_vvvvvzw) && main_source_vvvvvzw.constructor !== Array)
	{
		var temp_vvvvvzw = main_source_vvvvvzw;
		var main_source_vvvvvzw = [];
		main_source_vvvvvzw.push(temp_vvvvvzw);
	}
	else if (!isSet(main_source_vvvvvzw))
	{
		var main_source_vvvvvzw = [];
	}
	var main_source = main_source_vvvvvzw.some(main_source_vvvvvzw_SomeFunc);


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

// the vvvvvzw Some function
function main_source_vvvvvzw_SomeFunc(main_source_vvvvvzw)
{
	// set the function logic
	if (main_source_vvvvvzw == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzx function
function vvvvvzx(main_source_vvvvvzx)
{
	if (isSet(main_source_vvvvvzx) && main_source_vvvvvzx.constructor !== Array)
	{
		var temp_vvvvvzx = main_source_vvvvvzx;
		var main_source_vvvvvzx = [];
		main_source_vvvvvzx.push(temp_vvvvvzx);
	}
	else if (!isSet(main_source_vvvvvzx))
	{
		var main_source_vvvvvzx = [];
	}
	var main_source = main_source_vvvvvzx.some(main_source_vvvvvzx_SomeFunc);


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

// the vvvvvzx Some function
function main_source_vvvvvzx_SomeFunc(main_source_vvvvvzx)
{
	// set the function logic
	if (main_source_vvvvvzx == 1 || main_source_vvvvvzx == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzy function
function vvvvvzy(add_php_before_getitem_vvvvvzy,gettype_vvvvvzy)
{
	if (isSet(add_php_before_getitem_vvvvvzy) && add_php_before_getitem_vvvvvzy.constructor !== Array)
	{
		var temp_vvvvvzy = add_php_before_getitem_vvvvvzy;
		var add_php_before_getitem_vvvvvzy = [];
		add_php_before_getitem_vvvvvzy.push(temp_vvvvvzy);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzy))
	{
		var add_php_before_getitem_vvvvvzy = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzy.some(add_php_before_getitem_vvvvvzy_SomeFunc);

	if (isSet(gettype_vvvvvzy) && gettype_vvvvvzy.constructor !== Array)
	{
		var temp_vvvvvzy = gettype_vvvvvzy;
		var gettype_vvvvvzy = [];
		gettype_vvvvvzy.push(temp_vvvvvzy);
	}
	else if (!isSet(gettype_vvvvvzy))
	{
		var gettype_vvvvvzy = [];
	}
	var gettype = gettype_vvvvvzy.some(gettype_vvvvvzy_SomeFunc);


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

// the vvvvvzy Some function
function add_php_before_getitem_vvvvvzy_SomeFunc(add_php_before_getitem_vvvvvzy)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzy == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzy Some function
function gettype_vvvvvzy_SomeFunc(gettype_vvvvvzy)
{
	// set the function logic
	if (gettype_vvvvvzy == 1 || gettype_vvvvvzy == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzz function
function vvvvvzz(add_php_after_getitem_vvvvvzz,gettype_vvvvvzz)
{
	if (isSet(add_php_after_getitem_vvvvvzz) && add_php_after_getitem_vvvvvzz.constructor !== Array)
	{
		var temp_vvvvvzz = add_php_after_getitem_vvvvvzz;
		var add_php_after_getitem_vvvvvzz = [];
		add_php_after_getitem_vvvvvzz.push(temp_vvvvvzz);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzz))
	{
		var add_php_after_getitem_vvvvvzz = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzz.some(add_php_after_getitem_vvvvvzz_SomeFunc);

	if (isSet(gettype_vvvvvzz) && gettype_vvvvvzz.constructor !== Array)
	{
		var temp_vvvvvzz = gettype_vvvvvzz;
		var gettype_vvvvvzz = [];
		gettype_vvvvvzz.push(temp_vvvvvzz);
	}
	else if (!isSet(gettype_vvvvvzz))
	{
		var gettype_vvvvvzz = [];
	}
	var gettype = gettype_vvvvvzz.some(gettype_vvvvvzz_SomeFunc);


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

// the vvvvvzz Some function
function add_php_after_getitem_vvvvvzz_SomeFunc(add_php_after_getitem_vvvvvzz)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzz Some function
function gettype_vvvvvzz_SomeFunc(gettype_vvvvvzz)
{
	// set the function logic
	if (gettype_vvvvvzz == 1 || gettype_vvvvvzz == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwab function
function vvvvwab(gettype_vvvvwab)
{
	if (isSet(gettype_vvvvwab) && gettype_vvvvwab.constructor !== Array)
	{
		var temp_vvvvwab = gettype_vvvvwab;
		var gettype_vvvvwab = [];
		gettype_vvvvwab.push(temp_vvvvwab);
	}
	else if (!isSet(gettype_vvvvwab))
	{
		var gettype_vvvvwab = [];
	}
	var gettype = gettype_vvvvwab.some(gettype_vvvvwab_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		// add required attribute to add_php_after_getitem field
		if (jform_vvvvwabvws_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvwabvws_required = false;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		// add required attribute to add_php_before_getitem field
		if (jform_vvvvwabvwt_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvwabvwt_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitem field
		if (!jform_vvvvwabvws_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvwabvws_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitem field
		if (!jform_vvvvwabvwt_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvwabvwt_required = true;
		}
	}
}

// the vvvvwab Some function
function gettype_vvvvwab_SomeFunc(gettype_vvvvwab)
{
	// set the function logic
	if (gettype_vvvvwab == 1 || gettype_vvvvwab == 3)
	{
		return true;
	}
	return false;
}

// the vvvvwac function
function vvvvwac(add_php_getlistquery_vvvvwac,gettype_vvvvwac)
{
	if (isSet(add_php_getlistquery_vvvvwac) && add_php_getlistquery_vvvvwac.constructor !== Array)
	{
		var temp_vvvvwac = add_php_getlistquery_vvvvwac;
		var add_php_getlistquery_vvvvwac = [];
		add_php_getlistquery_vvvvwac.push(temp_vvvvwac);
	}
	else if (!isSet(add_php_getlistquery_vvvvwac))
	{
		var add_php_getlistquery_vvvvwac = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvwac.some(add_php_getlistquery_vvvvwac_SomeFunc);

	if (isSet(gettype_vvvvwac) && gettype_vvvvwac.constructor !== Array)
	{
		var temp_vvvvwac = gettype_vvvvwac;
		var gettype_vvvvwac = [];
		gettype_vvvvwac.push(temp_vvvvwac);
	}
	else if (!isSet(gettype_vvvvwac))
	{
		var gettype_vvvvwac = [];
	}
	var gettype = gettype_vvvvwac.some(gettype_vvvvwac_SomeFunc);


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

// the vvvvwac Some function
function add_php_getlistquery_vvvvwac_SomeFunc(add_php_getlistquery_vvvvwac)
{
	// set the function logic
	if (add_php_getlistquery_vvvvwac == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwac Some function
function gettype_vvvvwac_SomeFunc(gettype_vvvvwac)
{
	// set the function logic
	if (gettype_vvvvwac == 2 || gettype_vvvvwac == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwad function
function vvvvwad(add_php_before_getitems_vvvvwad,gettype_vvvvwad)
{
	if (isSet(add_php_before_getitems_vvvvwad) && add_php_before_getitems_vvvvwad.constructor !== Array)
	{
		var temp_vvvvwad = add_php_before_getitems_vvvvwad;
		var add_php_before_getitems_vvvvwad = [];
		add_php_before_getitems_vvvvwad.push(temp_vvvvwad);
	}
	else if (!isSet(add_php_before_getitems_vvvvwad))
	{
		var add_php_before_getitems_vvvvwad = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvwad.some(add_php_before_getitems_vvvvwad_SomeFunc);

	if (isSet(gettype_vvvvwad) && gettype_vvvvwad.constructor !== Array)
	{
		var temp_vvvvwad = gettype_vvvvwad;
		var gettype_vvvvwad = [];
		gettype_vvvvwad.push(temp_vvvvwad);
	}
	else if (!isSet(gettype_vvvvwad))
	{
		var gettype_vvvvwad = [];
	}
	var gettype = gettype_vvvvwad.some(gettype_vvvvwad_SomeFunc);


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

// the vvvvwad Some function
function add_php_before_getitems_vvvvwad_SomeFunc(add_php_before_getitems_vvvvwad)
{
	// set the function logic
	if (add_php_before_getitems_vvvvwad == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwad Some function
function gettype_vvvvwad_SomeFunc(gettype_vvvvwad)
{
	// set the function logic
	if (gettype_vvvvwad == 2 || gettype_vvvvwad == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwae function
function vvvvwae(add_php_after_getitems_vvvvwae,gettype_vvvvwae)
{
	if (isSet(add_php_after_getitems_vvvvwae) && add_php_after_getitems_vvvvwae.constructor !== Array)
	{
		var temp_vvvvwae = add_php_after_getitems_vvvvwae;
		var add_php_after_getitems_vvvvwae = [];
		add_php_after_getitems_vvvvwae.push(temp_vvvvwae);
	}
	else if (!isSet(add_php_after_getitems_vvvvwae))
	{
		var add_php_after_getitems_vvvvwae = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvwae.some(add_php_after_getitems_vvvvwae_SomeFunc);

	if (isSet(gettype_vvvvwae) && gettype_vvvvwae.constructor !== Array)
	{
		var temp_vvvvwae = gettype_vvvvwae;
		var gettype_vvvvwae = [];
		gettype_vvvvwae.push(temp_vvvvwae);
	}
	else if (!isSet(gettype_vvvvwae))
	{
		var gettype_vvvvwae = [];
	}
	var gettype = gettype_vvvvwae.some(gettype_vvvvwae_SomeFunc);


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

// the vvvvwae Some function
function add_php_after_getitems_vvvvwae_SomeFunc(add_php_after_getitems_vvvvwae)
{
	// set the function logic
	if (add_php_after_getitems_vvvvwae == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwae Some function
function gettype_vvvvwae_SomeFunc(gettype_vvvvwae)
{
	// set the function logic
	if (gettype_vvvvwae == 2 || gettype_vvvvwae == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwag function
function vvvvwag(gettype_vvvvwag)
{
	if (isSet(gettype_vvvvwag) && gettype_vvvvwag.constructor !== Array)
	{
		var temp_vvvvwag = gettype_vvvvwag;
		var gettype_vvvvwag = [];
		gettype_vvvvwag.push(temp_vvvvwag);
	}
	else if (!isSet(gettype_vvvvwag))
	{
		var gettype_vvvvwag = [];
	}
	var gettype = gettype_vvvvwag.some(gettype_vvvvwag_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		// add required attribute to add_php_after_getitems field
		if (jform_vvvvwagvwu_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvwagvwu_required = false;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		// add required attribute to add_php_before_getitems field
		if (jform_vvvvwagvwv_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvwagvwv_required = false;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		// add required attribute to add_php_getlistquery field
		if (jform_vvvvwagvww_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvwagvww_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitems field
		if (!jform_vvvvwagvwu_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvwagvwu_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitems field
		if (!jform_vvvvwagvwv_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvwagvwv_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		// remove required attribute from add_php_getlistquery field
		if (!jform_vvvvwagvww_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvwagvww_required = true;
		}
	}
}

// the vvvvwag Some function
function gettype_vvvvwag_SomeFunc(gettype_vvvvwag)
{
	// set the function logic
	if (gettype_vvvvwag == 2 || gettype_vvvvwag == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwah function
function vvvvwah(gettype_vvvvwah)
{
	if (isSet(gettype_vvvvwah) && gettype_vvvvwah.constructor !== Array)
	{
		var temp_vvvvwah = gettype_vvvvwah;
		var gettype_vvvvwah = [];
		gettype_vvvvwah.push(temp_vvvvwah);
	}
	else if (!isSet(gettype_vvvvwah))
	{
		var gettype_vvvvwah = [];
	}
	var gettype = gettype_vvvvwah.some(gettype_vvvvwah_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		// add required attribute to pagination field
		if (jform_vvvvwahvwx_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvwahvwx_required = false;
		}
	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		// remove required attribute from pagination field
		if (!jform_vvvvwahvwx_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvwahvwx_required = true;
		}
	}
}

// the vvvvwah Some function
function gettype_vvvvwah_SomeFunc(gettype_vvvvwah)
{
	// set the function logic
	if (gettype_vvvvwah == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwai function
function vvvvwai(gettype_vvvvwai)
{
	if (isSet(gettype_vvvvwai) && gettype_vvvvwai.constructor !== Array)
	{
		var temp_vvvvwai = gettype_vvvvwai;
		var gettype_vvvvwai = [];
		gettype_vvvvwai.push(temp_vvvvwai);
	}
	else if (!isSet(gettype_vvvvwai))
	{
		var gettype_vvvvwai = [];
	}
	var gettype = gettype_vvvvwai.some(gettype_vvvvwai_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		// add required attribute to add_php_router_parse field
		if (jform_vvvvwaivwy_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvwaivwy_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		// remove required attribute from add_php_router_parse field
		if (!jform_vvvvwaivwy_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvwaivwy_required = true;
		}
	}
}

// the vvvvwai Some function
function gettype_vvvvwai_SomeFunc(gettype_vvvvwai)
{
	// set the function logic
	if (gettype_vvvvwai == 1 || gettype_vvvvwai == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwaj function
function vvvvwaj(gettype_vvvvwaj,add_php_router_parse_vvvvwaj)
{
	if (isSet(gettype_vvvvwaj) && gettype_vvvvwaj.constructor !== Array)
	{
		var temp_vvvvwaj = gettype_vvvvwaj;
		var gettype_vvvvwaj = [];
		gettype_vvvvwaj.push(temp_vvvvwaj);
	}
	else if (!isSet(gettype_vvvvwaj))
	{
		var gettype_vvvvwaj = [];
	}
	var gettype = gettype_vvvvwaj.some(gettype_vvvvwaj_SomeFunc);

	if (isSet(add_php_router_parse_vvvvwaj) && add_php_router_parse_vvvvwaj.constructor !== Array)
	{
		var temp_vvvvwaj = add_php_router_parse_vvvvwaj;
		var add_php_router_parse_vvvvwaj = [];
		add_php_router_parse_vvvvwaj.push(temp_vvvvwaj);
	}
	else if (!isSet(add_php_router_parse_vvvvwaj))
	{
		var add_php_router_parse_vvvvwaj = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvwaj.some(add_php_router_parse_vvvvwaj_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		// add required attribute to php_router_parse field
		if (jform_vvvvwajvwz_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvwajvwz_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		// remove required attribute from php_router_parse field
		if (!jform_vvvvwajvwz_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvwajvwz_required = true;
		}
	}
}

// the vvvvwaj Some function
function gettype_vvvvwaj_SomeFunc(gettype_vvvvwaj)
{
	// set the function logic
	if (gettype_vvvvwaj == 1 || gettype_vvvvwaj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwaj Some function
function add_php_router_parse_vvvvwaj_SomeFunc(add_php_router_parse_vvvvwaj)
{
	// set the function logic
	if (add_php_router_parse_vvvvwaj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwal function
function vvvvwal(gettype_vvvvwal)
{
	if (isSet(gettype_vvvvwal) && gettype_vvvvwal.constructor !== Array)
	{
		var temp_vvvvwal = gettype_vvvvwal;
		var gettype_vvvvwal = [];
		gettype_vvvvwal.push(temp_vvvvwal);
	}
	else if (!isSet(gettype_vvvvwal))
	{
		var gettype_vvvvwal = [];
	}
	var gettype = gettype_vvvvwal.some(gettype_vvvvwal_SomeFunc);


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

// the vvvvwal Some function
function gettype_vvvvwal_SomeFunc(gettype_vvvvwal)
{
	// set the function logic
	if (gettype_vvvvwal == 1)
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
	getViewTableColumns_server(id,asKey,rowType).done(function(result) {
		if (result)
		{
			loadSelectionData(result, 'view', key, main, table_, nr_);
		}
		else
		{
			loadSelectionData(false, 'view', key, main, table_, nr_);
		}
	})
}

function getDbTableColumns_server(name,asKey,rowType)
{
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.dbTableColumns&format=json&raw=true");
	if (token.length > 0 && name.length > 0 && asKey.length > 0)
	{
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
		if (result)
		{
			loadSelectionData(result, 'db', key, main, table_, nr_);
		}
		else
		{
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

function getDynamicScripts_server(typpe){
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.getDynamicScripts&format=json&raw=true&vdm="+vastDevMod);
	if(token.length > 0 && typpe.length > 0){
		var request = token+'=1&type='+typpe;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

function getDynamicScripts(id){
	if (1 == id) {
		// get the current values
		var current_router_parse = jQuery('textarea#jform_php_router_parse').val();
		// set the router parse method script
		if(current_router_parse.length == 0){
			getDynamicScripts_server('routerparse').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_router_parse').val(result);
				}
			});
		}
	}
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
