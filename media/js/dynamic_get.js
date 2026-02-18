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
jform_vvvvvzlvvz_required = false;
jform_vvvvvznvwa_required = false;
jform_vvvvvzovwb_required = false;
jform_vvvvvzpvwc_required = false;
jform_vvvvvzqvwd_required = false;
jform_vvvvwabvwe_required = false;
jform_vvvvwabvwf_required = false;
jform_vvvvwagvwg_required = false;
jform_vvvvwagvwh_required = false;
jform_vvvvwagvwi_required = false;
jform_vvvvwahvwj_required = false;
jform_vvvvwaivwk_required = false;
jform_vvvvwajvwl_required = false;

// Initial Script
document.addEventListener('DOMContentLoaded', function()
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
		if (jform_vvvvvzlvvz_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvzlvvz_required = false;
		}
	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		// remove required attribute from getcustom field
		if (!jform_vvvvvzlvvz_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvzlvvz_required = true;
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
		if (jform_vvvvvznvwa_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvznvwa_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		// remove required attribute from view_table_main field
		if (!jform_vvvvvznvwa_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvznvwa_required = true;
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
		if (jform_vvvvvzovwb_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzovwb_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		// remove required attribute from view_selection field
		if (!jform_vvvvvzovwb_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzovwb_required = true;
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
		if (jform_vvvvvzpvwc_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzpvwc_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		// remove required attribute from db_table_main field
		if (!jform_vvvvvzpvwc_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvzpvwc_required = true;
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
		if (jform_vvvvvzqvwd_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzqvwd_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		// remove required attribute from db_selection field
		if (!jform_vvvvvzqvwd_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzqvwd_required = true;
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
		jQuery('#jform_join_view_table-lbl').closest('.control-group').show();
		jQuery('#jform_join_db_table-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_filter-lbl').closest('.control-group').hide();
		jQuery('#jform_global-lbl').closest('.control-group').hide();
		jQuery('#jform_group-lbl').closest('.control-group').hide();
		jQuery('#jform_order-lbl').closest('.control-group').hide();
		jQuery('#jform_where-lbl').closest('.control-group').hide();
		jQuery('#jform_join_view_table-lbl').closest('.control-group').hide();
		jQuery('#jform_join_db_table-lbl').closest('.control-group').hide();
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
		if (jform_vvvvwabvwe_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvwabvwe_required = false;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		// add required attribute to add_php_before_getitem field
		if (jform_vvvvwabvwf_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvwabvwf_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitem field
		if (!jform_vvvvwabvwe_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvwabvwe_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitem field
		if (!jform_vvvvwabvwf_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvwabvwf_required = true;
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
		if (jform_vvvvwagvwg_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvwagvwg_required = false;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		// add required attribute to add_php_before_getitems field
		if (jform_vvvvwagvwh_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvwagvwh_required = false;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		// add required attribute to add_php_getlistquery field
		if (jform_vvvvwagvwi_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvwagvwi_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitems field
		if (!jform_vvvvwagvwg_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvwagvwg_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitems field
		if (!jform_vvvvwagvwh_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvwagvwh_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		// remove required attribute from add_php_getlistquery field
		if (!jform_vvvvwagvwi_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvwagvwi_required = true;
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
		if (jform_vvvvwahvwj_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvwahvwj_required = false;
		}
	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		// remove required attribute from pagination field
		if (!jform_vvvvwahvwj_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvwahvwj_required = true;
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
		if (jform_vvvvwaivwk_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvwaivwk_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		// remove required attribute from add_php_router_parse field
		if (!jform_vvvvwaivwk_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvwaivwk_required = true;
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
		if (jform_vvvvwajvwl_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvwajvwl_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		// remove required attribute from php_router_parse field
		if (!jform_vvvvwajvwl_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvwajvwl_required = true;
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

/**
 * Update the "not required" field list by adding or removing a field name.
 *
 * Mirrors the original jQuery logic exactly but uses pure JavaScript.
 *
 * @param  {string}  name    The field name to add or remove.
 * @param  {number}  status  1 to add as not required, 0 to remove.
 *
 * @return {void}
 * @since  3.1.3
 */
function updateFieldRequired(name, status) {
	// Check if #jform_not_required exists
	const notRequiredField = document.getElementById('jform_not_required');
	if (!notRequiredField) {
		return;
	}

	// Split the comma-separated list into an array
	let not_required = notRequiredField.value ? notRequiredField.value.split(',') : [];

	// Add or remove the field name from the list
	if (status == 1) {
		not_required.push(name);
	} else {
		not_required = removeFieldFromNotRequired(not_required, name);
	}

	// Clean and deduplicate the list
	const fixedList = fixNotRequiredArray(not_required);

	// Write back the updated comma-separated list
	notRequiredField.value = fixedList.toString();
}

/**
 * Remove a specific field name from the "not required" array.
 *
 * @param  {Array<string>} array  The list of not-required field names.
 * @param  {string}        what   The field name to remove.
 *
 * @return {Array<string>}        The updated array.
 * @since  3.1.3
 */
function removeFieldFromNotRequired(array, what) {
	return array.filter(function (element) {
		return element !== what;
	});
}

/**
 * Deduplicate and clean a "not required" array.
 *
 * @param  {Array<string>} array  The array to fix.
 *
 * @return {Array<string>}        A cleaned, unique array.
 * @since  3.1.3
 */
function fixNotRequiredArray(array) {
	const seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function (item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

/**
 * Remove empty or invalid entries from a "not required" array.
 *
 * Also removes the literal '一_一' token (legacy quirk preserved for compatibility).
 *
 * @param  {Array<string>} array  The array to process.
 *
 * @return {Array<string>}        The cleaned array.
 * @since  3.1.3
 */
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		return el && el.length > 0 && el !== '一_一';
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


document.addEventListener('DOMContentLoaded', function() {
	// get the linked details
	getLinked();
	let valueSwitch = document.querySelector("#jform_add_php_router_parse input[type='radio']:checked").value;
	getDynamicScripts(valueSwitch);
	// check and load all the custom code edit buttons
	getEditCustomCodeButtons();
});

function setSelectAll(select_all) {
	// get source type
	let main_source = document.getElementById("jform_main_source").value;
	let key;
	if (main_source == 1) {
		key = 'view';
	} else if (main_source == 2) {
		key = 'db';
	} else {
		return true;
	}
	// only continue if set
	if (select_all == 1) {
		// set default notice
		document.getElementById("jform_" + key + "_selection").value = 'a.*';
		// set the selection text area to read only
		document.getElementById("jform_" + key + "_selection").readOnly = true;
	} else {
		// remove the read only from selection text area
		document.getElementById("jform_" + key + "_selection").readOnly = false;
		// get selected options
		let value_main = document.getElementById("jform_" + key + "_table_main").selectedOptions[0].value;
		// make sure that all fields are set as selected
		if (key === 'view') {
			getViewTableColumns(value_main, 'a', key, 3, true, '', '');
		} else {
			getDbTableColumns(value_main, 'a', key, 3, true, '', '');
		}
	}
}

function getViewTableColumns_server(viewId, asKey, rowType) {
	let getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.viewTableColumns&format=json&raw=true");
	let request = '';
	if (token.length > 0 && viewId.length && asKey.length > 0) {
		request = token + '=1&as=' + asKey + '&type=' + rowType + '&id=' + viewId;
	}
	return fetch(getUrl + '&' + request, { method: 'GET' }).then(function(response) {
		return response.json();
	});
}

function getViewTableColumns(id, asKey, key, rowType, main, table_, nr_) {
	// check if this is the main view
	if (main) {
		let select_all = document.querySelector("#jform_select_all input[type='radio']:checked").value;
		// do not continue if set
		if (select_all == 1) {
			setSelectAll(select_all);
			return true;
		}
	}
	getViewTableColumns_server(id, asKey, rowType).then(function(result) {
		if (result.error) {
			console.error(result.error);
		} else if (result) {
			loadSelectionData(result, 'view', key, main, table_, nr_);
		} else {
			loadSelectionData(false, 'view', key, main, table_, nr_);
		}
	});
}

function getDbTableColumns_server(name, asKey, rowType) {
	let getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.dbTableColumns&format=json&raw=true");
	let request = '';
	if (token.length > 0 && name.length > 0 && asKey.length > 0) {
		request = token + '=1&as=' + asKey + '&type=' + rowType + '&name=' + name;
	}
	return fetch(getUrl + '&' + request, { method: 'GET' }).then(function(response) {
		return response.json();
	});
}

function getDbTableColumns(name, asKey, key, rowType, main, table_, nr_) {
	// check if this is the main view
	if (main) {
		let select_all = document.querySelector("#jform_select_all input[type='radio']:checked").value;
		// do not continue if set
		if (select_all === 1) {
			setSelectAll(select_all);
			return true;
		}
	}
	getDbTableColumns_server(name, asKey, rowType).then(function(result) {
		if (result.error) {
			console.error(result.error);
		} else if (result) {
			loadSelectionData(result, 'db', key, main, table_, nr_);
		} else {
			loadSelectionData(false, 'db', key, main, table_, nr_);
		}
	});
}

function loadSelectionData(result, type, key, main, table_, nr_) {
	var textArea;
	if (main) {
		textArea = document.querySelector('textarea#jform_' + key + '_selection');
	} else {
		textArea = document.querySelector('textarea#jform_join_' + type + '_table' + table_ + '_join_' + type + '_table' + key + nr_ + '_selection');
	}
	// update the text area
	if (result) {
		textArea.value = result;
	} else {
		textArea.value = '';
	}
}

function updateSubItems(fieldName, fieldNr, table_, nr_) {
	let selector = '#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_' + fieldName + '_table';
	if (document.querySelector(selector)) {
		document.getElementById('adminForm').addEventListener('change', function(e) {
			if (e.target.matches(selector)) {
				e.preventDefault();
				// get options
				let selectElement = document.querySelector(selector);
				let value1 = selectElement.options[selectElement.selectedIndex].value;
				let asSelectElement = document.querySelector('#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_as');
				let as_value2 = asSelectElement.options[asSelectElement.selectedIndex].value;
				let rowTypeElement = document.querySelector('#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_row_type');
				let row_value1 = rowTypeElement.options[rowTypeElement.selectedIndex].value;
				if (fieldName === 'view') {
					getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
				} else {
					getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
				}
			}
		});

		document.getElementById('adminForm').addEventListener('change', function(e) {
			if (e.target.matches('#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_as')) {
				e.preventDefault();
				// get options
				let selectElement = document.querySelector(selector);
				let value1 = selectElement.options[selectElement.selectedIndex].value;
				let asSelectElement = document.querySelector('#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_as');
				let as_value2 = asSelectElement.options[asSelectElement.selectedIndex].value;
				let rowTypeElement = document.querySelector('#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_row_type');
				let row_value1 = rowTypeElement.options[rowTypeElement.selectedIndex].value;
				if (fieldName === 'view') {
					getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
				} else {
					getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
				}
			}
		});

		document.getElementById('adminForm').addEventListener('change', function(e) {
			if (e.target.matches('#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_row_type')) {
				e.preventDefault();
				// get options
				let selectElement = document.querySelector(selector);
				let value1 = selectElement.options[selectElement.selectedIndex].value;
				let asSelectElement = document.querySelector('#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_as');
				let as_value2 = asSelectElement.options[asSelectElement.selectedIndex].value;
				let rowTypeElement = document.querySelector('#jform_join_' + fieldName + '_table' + table_ + '_join_' + fieldName + '_table' + fieldNr + nr_ + '_row_type');
				let row_value1 = rowTypeElement.options[rowTypeElement.selectedIndex].value;
				if (fieldName === 'view') {
					getViewTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
				} else {
					getDbTableColumns(value1, as_value2, fieldNr, row_value1, false, table_, nr_);
				}
			}
		});
	}
}

function getDynamicScripts(id) {
	if (id == 1) {
		// get the current values
		let current_router_parse = document.querySelector('textarea#jform_php_router_parse').value;
		// set the router parse method script
		if (current_router_parse.length == 0) {
			getCodeFrom_server(1, 'routerparse', 'type', 'getDynamicScripts').then(function(result) {
				if (result.error) {
					console.error(result.error);
				} else if (result) {
					document.querySelector('textarea#jform_php_router_parse').value = result;
				}
			});
		}
	}
}

/**
 * Fetch data from the server with validated parameters.
 *
 * @param  {number|string} id          The record ID (integer > 0 or string > 30 chars)
 * @param  {string}        type        The type value to send
 * @param  {string}        typeName    The type parameter name (e.g. "type" or "context")
 * @param  {string}        callingName The AJAX task name (e.g. "getCode")
 * @global   {string}        token       The CSRF token name or key
 * @global   {string}        vastDevMod  The developer key or mode flag (optional)
 *
 * @return {Promise<object|null>}      Returns parsed JSON data or null on failure
 * @since  3.1.2
 */
async function getCodeFrom_server(id, type, typeName, callingName) {
	try {
		// --- Validation ---
		if (!getCodeFrom_isValidId(id)) {
			console.debug('[getCodeFrom_server] Invalid ID provided:', id);
			return null;
		}
		if (typeof type !== 'string' || !type.trim()) {
			console.debug('[getCodeFrom_server] Invalid type provided:', type);
			return null;
		}
		if (typeof typeName !== 'string' || !typeName.trim()) {
			console.debug('[getCodeFrom_server] Invalid typeName provided:', typeName);
			return null;
		}
		if (typeof callingName !== 'string' || !callingName.trim()) {
			console.debug('[getCodeFrom_server] Invalid callingName provided:', callingName);
			return null;
		}
		if (typeof token !== 'string' || !token.trim()) {
			console.debug('[getCodeFrom_server] Missing security token.');
			return null;
		}

		// --- Construct URL safely ---
		const baseUrl = 'index.php';
		const params = new URLSearchParams({
			option: 'com_componentbuilder',
			task: `ajax.${callingName}`,
			format: 'json',
			raw: 'true',
			[token]: '1',
			[typeName]: type,
			id: id
		});
		if (vastDevMod) params.append('vdm', vastDevMod);

		const fullUrl = JRouter(`${baseUrl}?${params.toString()}`);

		// --- Execute request ---
		const response = await fetch(fullUrl, {
			method: 'GET',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			cache: 'no-store',
			credentials: 'same-origin'
		});

		// --- Validate HTTP response ---
		if (!response.ok) {
			console.error(`[getCodeFromServer] Server responded with status ${response.status}: ${response.statusText}`);
			return null;
		}

		// --- Parse JSON response ---
		const data = await response.json();
		return data ?? null;

	} catch (error) {
		console.error('[getCodeFromServer] Fetch operation failed:', error);
		return null;
	}
}

/**
 * Validate if the given ID is acceptable.
 *
 * @param  {number|string} id  The ID value to validate.
 * @return {boolean}           True if valid, false otherwise.
 * @since  3.1.2
 */
function getCodeFrom_isValidId(id) {
	if (typeof id === 'number') {
		return Number.isInteger(id) && id > 0;
	}
	if (typeof id === 'string') {
		return id.trim().length > 30;
	}
	return false;
}

/**
 * Retrieve the Edit Custom Code buttons from the server.
 *
 * @param  {number} id  The record ID to load custom code buttons for.
 *
 * @return {Promise<object|null>}  Returns JSON object of buttons or null on failure.
 * @since  3.1.3
 */
async function getEditCustomCodeButtons_server(id) {
	try {
		// --- Validation ---
		if (typeof token !== 'string' || !token.trim()) {
			console.error('[getEditCustomCodeButtons_server] Missing or invalid CSRF token.');
			return null;
		}
		if (typeof id !== 'number' || id <= 0) {
			console.error('[getEditCustomCodeButtons_server] Invalid ID provided:', id);
			return null;
		}
		if (typeof return_here !== 'string' || !return_here.trim()) {
			console.warn('[getEditCustomCodeButtons_server] "return_here" not set; continuing without it.');
		}

		// --- Build URL safely ---
		const baseUrl = 'index.php';
		const params = new URLSearchParams({
			option: 'com_componentbuilder',
			task: 'ajax.getEditCustomCodeButtons',
			format: 'json',
			raw: 'true',
			[token]: '1',
			id: id,
			return_here: return_here || ''
		});
		if (typeof vastDevMod === 'string' && vastDevMod.length > 0) {
			params.append('vdm', vastDevMod);
		}

		const urlWithParams = JRouter(`${baseUrl}?${params.toString()}`);

		// --- Execute request ---
		const response = await fetch(urlWithParams, {
			method: 'GET',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			cache: 'no-store',
			credentials: 'same-origin'
		});

		// --- Handle network errors ---
		if (!response.ok) {
			console.error(`[getEditCustomCodeButtons_server] HTTP ${response.status}: ${response.statusText}`);
			return null;
		}

		// --- Parse JSON result ---
		const data = await response.json();
		return data ?? null;

	} catch (error) {
		console.error('[getEditCustomCodeButtons_server] Fetch failed:', error);
		return null;
	}
}

/**
 * Load and inject Edit Custom Code buttons into the DOM.
 *
 * @return {Promise<void>}
 * @since  3.1.3
 */
async function getEditCustomCodeButtons() {
	try {
		// --- Get record ID from the form ---
		const idField = document.querySelector('#jform_id');
		if (!idField) {
			console.error('[getEditCustomCodeButtons] #jform_id not found.');
			return;
		}

		const idValue = parseInt(idField.value, 10);
		if (isNaN(idValue) || idValue <= 0) {
			console.warn('[getEditCustomCodeButtons] Invalid or empty ID; skipping button load.');
			return;
		}

		// --- Request data from server ---
		const result = await getEditCustomCodeButtons_server(idValue);
		if (!result || typeof result !== 'object') {
			console.warn('[getEditCustomCodeButtons] No result returned or invalid format.');
			return;
		}

		// --- Inject returned button groups ---
		Object.entries(result).forEach(([field, buttons]) => {
			// Create the container div
			const div = document.createElement('div');
			div.className = 'control-group';
			div.innerHTML = `
<div class="control-label">
	<label>Add/Edit Customcode</label>
</div>
<div class="controls control-customcode-buttons-${field}"></div>
			`;

			// Find where to insert (before .control-wrapper-{field})
			const insertBeforeElement = document.querySelector(`.control-wrapper-${field}`);
			if (insertBeforeElement && insertBeforeElement.parentNode) {
				insertBeforeElement.parentNode.insertBefore(div, insertBeforeElement);
			}

			// Append buttons to the new container
			const controlsDiv = div.querySelector(`.control-customcode-buttons-${field}`);
			if (controlsDiv && typeof buttons === 'object') {
				Object.entries(buttons).forEach(([name, buttonHtml]) => {
					if (typeof buttonHtml === 'string') {
						const wrapper = document.createElement('div');
						wrapper.innerHTML = buttonHtml.trim();
						const buttonNode = wrapper.firstElementChild;
						if (buttonNode) {
							controlsDiv.appendChild(buttonNode);
						}
					}
				});
			}
		});
	} catch (error) {
		console.error('[getEditCustomCodeButtons] Error rendering buttons:', error);
	}
}

function getLinked() {
	getCodeFrom_server(1, 'type', 'type', 'getLinked').then(function(result) {
		if (result.error) {
			console.error(result.error);
		} else if (result) {
			document.getElementById('display_linked_to').innerHTML = result;
		}
	});
}
