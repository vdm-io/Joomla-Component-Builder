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
jform_vvvvvzivwm_required = false;
jform_vvvvvzkvwn_required = false;
jform_vvvvvzlvwo_required = false;
jform_vvvvvzmvwp_required = false;
jform_vvvvvznvwq_required = false;
jform_vvvvvzyvwr_required = false;
jform_vvvvvzyvws_required = false;
jform_vvvvwadvwt_required = false;
jform_vvvvwadvwu_required = false;
jform_vvvvwadvwv_required = false;
jform_vvvvwaevww_required = false;
jform_vvvvwafvwx_required = false;
jform_vvvvwagvwy_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(gettype_vvvvvzi);

	var main_source_vvvvvzj = jQuery("#jform_main_source").val();
	vvvvvzj(main_source_vvvvvzj);

	var main_source_vvvvvzk = jQuery("#jform_main_source").val();
	vvvvvzk(main_source_vvvvvzk);

	var main_source_vvvvvzl = jQuery("#jform_main_source").val();
	vvvvvzl(main_source_vvvvvzl);

	var main_source_vvvvvzm = jQuery("#jform_main_source").val();
	vvvvvzm(main_source_vvvvvzm);

	var main_source_vvvvvzn = jQuery("#jform_main_source").val();
	vvvvvzn(main_source_vvvvvzn);

	var addcalculation_vvvvvzo = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzo(addcalculation_vvvvvzo);

	var addcalculation_vvvvvzp = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(addcalculation_vvvvvzp,gettype_vvvvvzp);

	var addcalculation_vvvvvzq = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(addcalculation_vvvvvzq,gettype_vvvvvzq);

	var main_source_vvvvvzt = jQuery("#jform_main_source").val();
	vvvvvzt(main_source_vvvvvzt);

	var main_source_vvvvvzu = jQuery("#jform_main_source").val();
	vvvvvzu(main_source_vvvvvzu);

	var add_php_before_getitem_vvvvvzv = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	vvvvvzv(add_php_before_getitem_vvvvvzv,gettype_vvvvvzv);

	var add_php_after_getitem_vvvvvzw = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzw = jQuery("#jform_gettype").val();
	vvvvvzw(add_php_after_getitem_vvvvvzw,gettype_vvvvvzw);

	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	vvvvvzy(gettype_vvvvvzy);

	var add_php_getlistquery_vvvvvzz = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	vvvvvzz(add_php_getlistquery_vvvvvzz,gettype_vvvvvzz);

	var add_php_before_getitems_vvvvwaa = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvwaa = jQuery("#jform_gettype").val();
	vvvvwaa(add_php_before_getitems_vvvvwaa,gettype_vvvvwaa);

	var add_php_after_getitems_vvvvwab = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvwab = jQuery("#jform_gettype").val();
	vvvvwab(add_php_after_getitems_vvvvwab,gettype_vvvvwab);

	var gettype_vvvvwad = jQuery("#jform_gettype").val();
	vvvvwad(gettype_vvvvwad);

	var gettype_vvvvwae = jQuery("#jform_gettype").val();
	vvvvwae(gettype_vvvvwae);

	var gettype_vvvvwaf = jQuery("#jform_gettype").val();
	vvvvwaf(gettype_vvvvwaf);

	var gettype_vvvvwag = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwag = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwag(gettype_vvvvwag,add_php_router_parse_vvvvwag);

	var gettype_vvvvwai = jQuery("#jform_gettype").val();
	vvvvwai(gettype_vvvvwai);
});

// the vvvvvzi function
function vvvvvzi(gettype_vvvvvzi)
{
	if (isSet(gettype_vvvvvzi) && gettype_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = gettype_vvvvvzi;
		var gettype_vvvvvzi = [];
		gettype_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(gettype_vvvvvzi))
	{
		var gettype_vvvvvzi = [];
	}
	var gettype = gettype_vvvvvzi.some(gettype_vvvvvzi_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		// add required attribute to getcustom field
		if (jform_vvvvvzivwm_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvzivwm_required = false;
		}
	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		// remove required attribute from getcustom field
		if (!jform_vvvvvzivwm_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvzivwm_required = true;
		}
	}
}

// the vvvvvzi Some function
function gettype_vvvvvzi_SomeFunc(gettype_vvvvvzi)
{
	// set the function logic
	if (gettype_vvvvvzi == 3 || gettype_vvvvvzi == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzj function
function vvvvvzj(main_source_vvvvvzj)
{
	if (isSet(main_source_vvvvvzj) && main_source_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = main_source_vvvvvzj;
		var main_source_vvvvvzj = [];
		main_source_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(main_source_vvvvvzj))
	{
		var main_source_vvvvvzj = [];
	}
	var main_source = main_source_vvvvvzj.some(main_source_vvvvvzj_SomeFunc);


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

// the vvvvvzj Some function
function main_source_vvvvvzj_SomeFunc(main_source_vvvvvzj)
{
	// set the function logic
	if (main_source_vvvvvzj == 1 || main_source_vvvvvzj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzk function
function vvvvvzk(main_source_vvvvvzk)
{
	if (isSet(main_source_vvvvvzk) && main_source_vvvvvzk.constructor !== Array)
	{
		var temp_vvvvvzk = main_source_vvvvvzk;
		var main_source_vvvvvzk = [];
		main_source_vvvvvzk.push(temp_vvvvvzk);
	}
	else if (!isSet(main_source_vvvvvzk))
	{
		var main_source_vvvvvzk = [];
	}
	var main_source = main_source_vvvvvzk.some(main_source_vvvvvzk_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		// add required attribute to view_table_main field
		if (jform_vvvvvzkvwn_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvzkvwn_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		// remove required attribute from view_table_main field
		if (!jform_vvvvvzkvwn_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvzkvwn_required = true;
		}
	}
}

// the vvvvvzk Some function
function main_source_vvvvvzk_SomeFunc(main_source_vvvvvzk)
{
	// set the function logic
	if (main_source_vvvvvzk == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzl function
function vvvvvzl(main_source_vvvvvzl)
{
	if (isSet(main_source_vvvvvzl) && main_source_vvvvvzl.constructor !== Array)
	{
		var temp_vvvvvzl = main_source_vvvvvzl;
		var main_source_vvvvvzl = [];
		main_source_vvvvvzl.push(temp_vvvvvzl);
	}
	else if (!isSet(main_source_vvvvvzl))
	{
		var main_source_vvvvvzl = [];
	}
	var main_source = main_source_vvvvvzl.some(main_source_vvvvvzl_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		// add required attribute to view_selection field
		if (jform_vvvvvzlvwo_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzlvwo_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		// remove required attribute from view_selection field
		if (!jform_vvvvvzlvwo_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzlvwo_required = true;
		}
	}
}

// the vvvvvzl Some function
function main_source_vvvvvzl_SomeFunc(main_source_vvvvvzl)
{
	// set the function logic
	if (main_source_vvvvvzl == 1)
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		// add required attribute to db_table_main field
		if (jform_vvvvvzmvwp_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzmvwp_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		// remove required attribute from db_table_main field
		if (!jform_vvvvvzmvwp_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvzmvwp_required = true;
		}
	}
}

// the vvvvvzm Some function
function main_source_vvvvvzm_SomeFunc(main_source_vvvvvzm)
{
	// set the function logic
	if (main_source_vvvvvzm == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		// add required attribute to db_selection field
		if (jform_vvvvvznvwq_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvznvwq_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		// remove required attribute from db_selection field
		if (!jform_vvvvvznvwq_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvznvwq_required = true;
		}
	}
}

// the vvvvvzn Some function
function main_source_vvvvvzn_SomeFunc(main_source_vvvvvzn)
{
	// set the function logic
	if (main_source_vvvvvzn == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(addcalculation_vvvvvzo)
{
	// set the function logic
	if (addcalculation_vvvvvzo == 1)
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzp function
function vvvvvzp(addcalculation_vvvvvzp,gettype_vvvvvzp)
{
	if (isSet(addcalculation_vvvvvzp) && addcalculation_vvvvvzp.constructor !== Array)
	{
		var temp_vvvvvzp = addcalculation_vvvvvzp;
		var addcalculation_vvvvvzp = [];
		addcalculation_vvvvvzp.push(temp_vvvvvzp);
	}
	else if (!isSet(addcalculation_vvvvvzp))
	{
		var addcalculation_vvvvvzp = [];
	}
	var addcalculation = addcalculation_vvvvvzp.some(addcalculation_vvvvvzp_SomeFunc);

	if (isSet(gettype_vvvvvzp) && gettype_vvvvvzp.constructor !== Array)
	{
		var temp_vvvvvzp = gettype_vvvvvzp;
		var gettype_vvvvvzp = [];
		gettype_vvvvvzp.push(temp_vvvvvzp);
	}
	else if (!isSet(gettype_vvvvvzp))
	{
		var gettype_vvvvvzp = [];
	}
	var gettype = gettype_vvvvvzp.some(gettype_vvvvvzp_SomeFunc);


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

// the vvvvvzp Some function
function addcalculation_vvvvvzp_SomeFunc(addcalculation_vvvvvzp)
{
	// set the function logic
	if (addcalculation_vvvvvzp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzp Some function
function gettype_vvvvvzp_SomeFunc(gettype_vvvvvzp)
{
	// set the function logic
	if (gettype_vvvvvzp == 1 || gettype_vvvvvzp == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzq function
function vvvvvzq(addcalculation_vvvvvzq,gettype_vvvvvzq)
{
	if (isSet(addcalculation_vvvvvzq) && addcalculation_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = addcalculation_vvvvvzq;
		var addcalculation_vvvvvzq = [];
		addcalculation_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(addcalculation_vvvvvzq))
	{
		var addcalculation_vvvvvzq = [];
	}
	var addcalculation = addcalculation_vvvvvzq.some(addcalculation_vvvvvzq_SomeFunc);

	if (isSet(gettype_vvvvvzq) && gettype_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = gettype_vvvvvzq;
		var gettype_vvvvvzq = [];
		gettype_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(gettype_vvvvvzq))
	{
		var gettype_vvvvvzq = [];
	}
	var gettype = gettype_vvvvvzq.some(gettype_vvvvvzq_SomeFunc);


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

// the vvvvvzq Some function
function addcalculation_vvvvvzq_SomeFunc(addcalculation_vvvvvzq)
{
	// set the function logic
	if (addcalculation_vvvvvzq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzq Some function
function gettype_vvvvvzq_SomeFunc(gettype_vvvvvzq)
{
	// set the function logic
	if (gettype_vvvvvzq == 2 || gettype_vvvvvzq == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzt function
function vvvvvzt(main_source_vvvvvzt)
{
	if (isSet(main_source_vvvvvzt) && main_source_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = main_source_vvvvvzt;
		var main_source_vvvvvzt = [];
		main_source_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(main_source_vvvvvzt))
	{
		var main_source_vvvvvzt = [];
	}
	var main_source = main_source_vvvvvzt.some(main_source_vvvvvzt_SomeFunc);


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

// the vvvvvzt Some function
function main_source_vvvvvzt_SomeFunc(main_source_vvvvvzt)
{
	// set the function logic
	if (main_source_vvvvvzt == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzu function
function vvvvvzu(main_source_vvvvvzu)
{
	if (isSet(main_source_vvvvvzu) && main_source_vvvvvzu.constructor !== Array)
	{
		var temp_vvvvvzu = main_source_vvvvvzu;
		var main_source_vvvvvzu = [];
		main_source_vvvvvzu.push(temp_vvvvvzu);
	}
	else if (!isSet(main_source_vvvvvzu))
	{
		var main_source_vvvvvzu = [];
	}
	var main_source = main_source_vvvvvzu.some(main_source_vvvvvzu_SomeFunc);


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

// the vvvvvzu Some function
function main_source_vvvvvzu_SomeFunc(main_source_vvvvvzu)
{
	// set the function logic
	if (main_source_vvvvvzu == 1 || main_source_vvvvvzu == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzv function
function vvvvvzv(add_php_before_getitem_vvvvvzv,gettype_vvvvvzv)
{
	if (isSet(add_php_before_getitem_vvvvvzv) && add_php_before_getitem_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = add_php_before_getitem_vvvvvzv;
		var add_php_before_getitem_vvvvvzv = [];
		add_php_before_getitem_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzv))
	{
		var add_php_before_getitem_vvvvvzv = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzv.some(add_php_before_getitem_vvvvvzv_SomeFunc);

	if (isSet(gettype_vvvvvzv) && gettype_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = gettype_vvvvvzv;
		var gettype_vvvvvzv = [];
		gettype_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(gettype_vvvvvzv))
	{
		var gettype_vvvvvzv = [];
	}
	var gettype = gettype_vvvvvzv.some(gettype_vvvvvzv_SomeFunc);


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

// the vvvvvzv Some function
function add_php_before_getitem_vvvvvzv_SomeFunc(add_php_before_getitem_vvvvvzv)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzv Some function
function gettype_vvvvvzv_SomeFunc(gettype_vvvvvzv)
{
	// set the function logic
	if (gettype_vvvvvzv == 1 || gettype_vvvvvzv == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzw function
function vvvvvzw(add_php_after_getitem_vvvvvzw,gettype_vvvvvzw)
{
	if (isSet(add_php_after_getitem_vvvvvzw) && add_php_after_getitem_vvvvvzw.constructor !== Array)
	{
		var temp_vvvvvzw = add_php_after_getitem_vvvvvzw;
		var add_php_after_getitem_vvvvvzw = [];
		add_php_after_getitem_vvvvvzw.push(temp_vvvvvzw);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzw))
	{
		var add_php_after_getitem_vvvvvzw = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzw.some(add_php_after_getitem_vvvvvzw_SomeFunc);

	if (isSet(gettype_vvvvvzw) && gettype_vvvvvzw.constructor !== Array)
	{
		var temp_vvvvvzw = gettype_vvvvvzw;
		var gettype_vvvvvzw = [];
		gettype_vvvvvzw.push(temp_vvvvvzw);
	}
	else if (!isSet(gettype_vvvvvzw))
	{
		var gettype_vvvvvzw = [];
	}
	var gettype = gettype_vvvvvzw.some(gettype_vvvvvzw_SomeFunc);


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

// the vvvvvzw Some function
function add_php_after_getitem_vvvvvzw_SomeFunc(add_php_after_getitem_vvvvvzw)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzw Some function
function gettype_vvvvvzw_SomeFunc(gettype_vvvvvzw)
{
	// set the function logic
	if (gettype_vvvvvzw == 1 || gettype_vvvvvzw == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzy function
function vvvvvzy(gettype_vvvvvzy)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		// add required attribute to add_php_after_getitem field
		if (jform_vvvvvzyvwr_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzyvwr_required = false;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		// add required attribute to add_php_before_getitem field
		if (jform_vvvvvzyvws_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzyvws_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitem field
		if (!jform_vvvvvzyvwr_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzyvwr_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitem field
		if (!jform_vvvvvzyvws_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzyvws_required = true;
		}
	}
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
function vvvvvzz(add_php_getlistquery_vvvvvzz,gettype_vvvvvzz)
{
	if (isSet(add_php_getlistquery_vvvvvzz) && add_php_getlistquery_vvvvvzz.constructor !== Array)
	{
		var temp_vvvvvzz = add_php_getlistquery_vvvvvzz;
		var add_php_getlistquery_vvvvvzz = [];
		add_php_getlistquery_vvvvvzz.push(temp_vvvvvzz);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzz))
	{
		var add_php_getlistquery_vvvvvzz = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzz.some(add_php_getlistquery_vvvvvzz_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
	}
}

// the vvvvvzz Some function
function add_php_getlistquery_vvvvvzz_SomeFunc(add_php_getlistquery_vvvvvzz)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzz Some function
function gettype_vvvvvzz_SomeFunc(gettype_vvvvvzz)
{
	// set the function logic
	if (gettype_vvvvvzz == 2 || gettype_vvvvvzz == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwaa function
function vvvvwaa(add_php_before_getitems_vvvvwaa,gettype_vvvvwaa)
{
	if (isSet(add_php_before_getitems_vvvvwaa) && add_php_before_getitems_vvvvwaa.constructor !== Array)
	{
		var temp_vvvvwaa = add_php_before_getitems_vvvvwaa;
		var add_php_before_getitems_vvvvwaa = [];
		add_php_before_getitems_vvvvwaa.push(temp_vvvvwaa);
	}
	else if (!isSet(add_php_before_getitems_vvvvwaa))
	{
		var add_php_before_getitems_vvvvwaa = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvwaa.some(add_php_before_getitems_vvvvwaa_SomeFunc);

	if (isSet(gettype_vvvvwaa) && gettype_vvvvwaa.constructor !== Array)
	{
		var temp_vvvvwaa = gettype_vvvvwaa;
		var gettype_vvvvwaa = [];
		gettype_vvvvwaa.push(temp_vvvvwaa);
	}
	else if (!isSet(gettype_vvvvwaa))
	{
		var gettype_vvvvwaa = [];
	}
	var gettype = gettype_vvvvwaa.some(gettype_vvvvwaa_SomeFunc);


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

// the vvvvwaa Some function
function add_php_before_getitems_vvvvwaa_SomeFunc(add_php_before_getitems_vvvvwaa)
{
	// set the function logic
	if (add_php_before_getitems_vvvvwaa == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwaa Some function
function gettype_vvvvwaa_SomeFunc(gettype_vvvvwaa)
{
	// set the function logic
	if (gettype_vvvvwaa == 2 || gettype_vvvvwaa == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwab function
function vvvvwab(add_php_after_getitems_vvvvwab,gettype_vvvvwab)
{
	if (isSet(add_php_after_getitems_vvvvwab) && add_php_after_getitems_vvvvwab.constructor !== Array)
	{
		var temp_vvvvwab = add_php_after_getitems_vvvvwab;
		var add_php_after_getitems_vvvvwab = [];
		add_php_after_getitems_vvvvwab.push(temp_vvvvwab);
	}
	else if (!isSet(add_php_after_getitems_vvvvwab))
	{
		var add_php_after_getitems_vvvvwab = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvwab.some(add_php_after_getitems_vvvvwab_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').hide();
	}
}

// the vvvvwab Some function
function add_php_after_getitems_vvvvwab_SomeFunc(add_php_after_getitems_vvvvwab)
{
	// set the function logic
	if (add_php_after_getitems_vvvvwab == 1)
	{
		return true;
	}
	return false;
}

// the vvvvwab Some function
function gettype_vvvvwab_SomeFunc(gettype_vvvvwab)
{
	// set the function logic
	if (gettype_vvvvwab == 2 || gettype_vvvvwab == 4)
	{
		return true;
	}
	return false;
}

// the vvvvwad function
function vvvvwad(gettype_vvvvwad)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		// add required attribute to add_php_after_getitems field
		if (jform_vvvvwadvwt_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvwadvwt_required = false;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		// add required attribute to add_php_before_getitems field
		if (jform_vvvvwadvwu_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvwadvwu_required = false;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		// add required attribute to add_php_getlistquery field
		if (jform_vvvvwadvwv_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvwadvwv_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitems field
		if (!jform_vvvvwadvwt_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvwadvwt_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitems field
		if (!jform_vvvvwadvwu_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvwadvwu_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		// remove required attribute from add_php_getlistquery field
		if (!jform_vvvvwadvwv_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvwadvwv_required = true;
		}
	}
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
function vvvvwae(gettype_vvvvwae)
{
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
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		// add required attribute to pagination field
		if (jform_vvvvwaevww_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvwaevww_required = false;
		}
	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		// remove required attribute from pagination field
		if (!jform_vvvvwaevww_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvwaevww_required = true;
		}
	}
}

// the vvvvwae Some function
function gettype_vvvvwae_SomeFunc(gettype_vvvvwae)
{
	// set the function logic
	if (gettype_vvvvwae == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwaf function
function vvvvwaf(gettype_vvvvwaf)
{
	if (isSet(gettype_vvvvwaf) && gettype_vvvvwaf.constructor !== Array)
	{
		var temp_vvvvwaf = gettype_vvvvwaf;
		var gettype_vvvvwaf = [];
		gettype_vvvvwaf.push(temp_vvvvwaf);
	}
	else if (!isSet(gettype_vvvvwaf))
	{
		var gettype_vvvvwaf = [];
	}
	var gettype = gettype_vvvvwaf.some(gettype_vvvvwaf_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		// add required attribute to add_php_router_parse field
		if (jform_vvvvwafvwx_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvwafvwx_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		// remove required attribute from add_php_router_parse field
		if (!jform_vvvvwafvwx_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvwafvwx_required = true;
		}
	}
}

// the vvvvwaf Some function
function gettype_vvvvwaf_SomeFunc(gettype_vvvvwaf)
{
	// set the function logic
	if (gettype_vvvvwaf == 1 || gettype_vvvvwaf == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwag function
function vvvvwag(gettype_vvvvwag,add_php_router_parse_vvvvwag)
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

	if (isSet(add_php_router_parse_vvvvwag) && add_php_router_parse_vvvvwag.constructor !== Array)
	{
		var temp_vvvvwag = add_php_router_parse_vvvvwag;
		var add_php_router_parse_vvvvwag = [];
		add_php_router_parse_vvvvwag.push(temp_vvvvwag);
	}
	else if (!isSet(add_php_router_parse_vvvvwag))
	{
		var add_php_router_parse_vvvvwag = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvwag.some(add_php_router_parse_vvvvwag_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		// add required attribute to php_router_parse field
		if (jform_vvvvwagvwy_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvwagvwy_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		// remove required attribute from php_router_parse field
		if (!jform_vvvvwagvwy_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvwagvwy_required = true;
		}
	}
}

// the vvvvwag Some function
function gettype_vvvvwag_SomeFunc(gettype_vvvvwag)
{
	// set the function logic
	if (gettype_vvvvwag == 1 || gettype_vvvvwag == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwag Some function
function add_php_router_parse_vvvvwag_SomeFunc(add_php_router_parse_vvvvwag)
{
	// set the function logic
	if (add_php_router_parse_vvvvwag == 1)
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
		jQuery('#jform_plugin_events').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_plugin_events').closest('.control-group').hide();
	}
}

// the vvvvwai Some function
function gettype_vvvvwai_SomeFunc(gettype_vvvvwai)
{
	// set the function logic
	if (gettype_vvvvwai == 1)
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
