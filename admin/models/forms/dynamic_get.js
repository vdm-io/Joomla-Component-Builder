/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// Some Global Values
jform_vvvvvzbvyv_required = false;
jform_vvvvvzcvyw_required = false;
jform_vvvvvzdvyx_required = false;
jform_vvvvvzevyy_required = false;
jform_vvvvvzfvyz_required = false;
jform_vvvvvzgvza_required = false;
jform_vvvvvzlvzb_required = false;
jform_vvvvvznvzc_required = false;
jform_vvvvvzovzd_required = false;
jform_vvvvvzqvze_required = false;
jform_vvvvvzqvzf_required = false;
jform_vvvvvzrvzg_required = false;
jform_vvvvvzsvzh_required = false;
jform_vvvvvztvzi_required = false;
jform_vvvvvzvvzj_required = false;
jform_vvvvvzvvzk_required = false;
jform_vvvvvzvvzl_required = false;
jform_vvvvvzwvzm_required = false;
jform_vvvvvzxvzn_required = false;
jform_vvvvvzyvzo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvzb = jQuery("#jform_gettype").val();
	vvvvvzb(gettype_vvvvvzb);

	var main_source_vvvvvzc = jQuery("#jform_main_source").val();
	vvvvvzc(main_source_vvvvvzc);

	var main_source_vvvvvzd = jQuery("#jform_main_source").val();
	vvvvvzd(main_source_vvvvvzd);

	var main_source_vvvvvze = jQuery("#jform_main_source").val();
	vvvvvze(main_source_vvvvvze);

	var main_source_vvvvvzf = jQuery("#jform_main_source").val();
	vvvvvzf(main_source_vvvvvzf);

	var addcalculation_vvvvvzg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzg(addcalculation_vvvvvzg);

	var addcalculation_vvvvvzh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(addcalculation_vvvvvzh,gettype_vvvvvzh);

	var addcalculation_vvvvvzi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(addcalculation_vvvvvzi,gettype_vvvvvzi);

	var main_source_vvvvvzl = jQuery("#jform_main_source").val();
	vvvvvzl(main_source_vvvvvzl);

	var main_source_vvvvvzm = jQuery("#jform_main_source").val();
	vvvvvzm(main_source_vvvvvzm);

	var add_php_before_getitem_vvvvvzn = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(add_php_before_getitem_vvvvvzn,gettype_vvvvvzn);

	var add_php_after_getitem_vvvvvzo = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_after_getitem_vvvvvzo,gettype_vvvvvzo);

	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(gettype_vvvvvzq);

	var add_php_getlistquery_vvvvvzr = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzr = jQuery("#jform_gettype").val();
	vvvvvzr(add_php_getlistquery_vvvvvzr,gettype_vvvvvzr);

	var add_php_before_getitems_vvvvvzs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(add_php_before_getitems_vvvvvzs,gettype_vvvvvzs);

	var add_php_after_getitems_vvvvvzt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(add_php_after_getitems_vvvvvzt,gettype_vvvvvzt);

	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	vvvvvzv(gettype_vvvvvzv);

	var gettype_vvvvvzw = jQuery("#jform_gettype").val();
	vvvvvzw(gettype_vvvvvzw);

	var gettype_vvvvvzx = jQuery("#jform_gettype").val();
	vvvvvzx(gettype_vvvvvzx);

	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvvzy = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvvzy(gettype_vvvvvzy,add_php_router_parse_vvvvvzy);
});

// the vvvvvzb function
function vvvvvzb(gettype_vvvvvzb)
{
	if (isSet(gettype_vvvvvzb) && gettype_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = gettype_vvvvvzb;
		var gettype_vvvvvzb = [];
		gettype_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(gettype_vvvvvzb))
	{
		var gettype_vvvvvzb = [];
	}
	var gettype = gettype_vvvvvzb.some(gettype_vvvvvzb_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvzbvyv_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvzbvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvzbvyv_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvzbvyv_required = true;
		}
	}
}

// the vvvvvzb Some function
function gettype_vvvvvzb_SomeFunc(gettype_vvvvvzb)
{
	// set the function logic
	if (gettype_vvvvvzb == 3 || gettype_vvvvvzb == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzc function
function vvvvvzc(main_source_vvvvvzc)
{
	if (isSet(main_source_vvvvvzc) && main_source_vvvvvzc.constructor !== Array)
	{
		var temp_vvvvvzc = main_source_vvvvvzc;
		var main_source_vvvvvzc = [];
		main_source_vvvvvzc.push(temp_vvvvvzc);
	}
	else if (!isSet(main_source_vvvvvzc))
	{
		var main_source_vvvvvzc = [];
	}
	var main_source = main_source_vvvvvzc.some(main_source_vvvvvzc_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvzcvyw_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvzcvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzcvyw_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvzcvyw_required = true;
		}
	}
}

// the vvvvvzc Some function
function main_source_vvvvvzc_SomeFunc(main_source_vvvvvzc)
{
	// set the function logic
	if (main_source_vvvvvzc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(main_source_vvvvvzd)
{
	if (isSet(main_source_vvvvvzd) && main_source_vvvvvzd.constructor !== Array)
	{
		var temp_vvvvvzd = main_source_vvvvvzd;
		var main_source_vvvvvzd = [];
		main_source_vvvvvzd.push(temp_vvvvvzd);
	}
	else if (!isSet(main_source_vvvvvzd))
	{
		var main_source_vvvvvzd = [];
	}
	var main_source = main_source_vvvvvzd.some(main_source_vvvvvzd_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvzdvyx_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzdvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvzdvyx_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzdvyx_required = true;
		}
	}
}

// the vvvvvzd Some function
function main_source_vvvvvzd_SomeFunc(main_source_vvvvvzd)
{
	// set the function logic
	if (main_source_vvvvvzd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvze function
function vvvvvze(main_source_vvvvvze)
{
	if (isSet(main_source_vvvvvze) && main_source_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = main_source_vvvvvze;
		var main_source_vvvvvze = [];
		main_source_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(main_source_vvvvvze))
	{
		var main_source_vvvvvze = [];
	}
	var main_source = main_source_vvvvvze.some(main_source_vvvvvze_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvzevyy_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzevyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzevyy_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvzevyy_required = true;
		}
	}
}

// the vvvvvze Some function
function main_source_vvvvvze_SomeFunc(main_source_vvvvvze)
{
	// set the function logic
	if (main_source_vvvvvze == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzf function
function vvvvvzf(main_source_vvvvvzf)
{
	if (isSet(main_source_vvvvvzf) && main_source_vvvvvzf.constructor !== Array)
	{
		var temp_vvvvvzf = main_source_vvvvvzf;
		var main_source_vvvvvzf = [];
		main_source_vvvvvzf.push(temp_vvvvvzf);
	}
	else if (!isSet(main_source_vvvvvzf))
	{
		var main_source_vvvvvzf = [];
	}
	var main_source = main_source_vvvvvzf.some(main_source_vvvvvzf_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvzfvyz_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzfvyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvzfvyz_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzfvyz_required = true;
		}
	}
}

// the vvvvvzf Some function
function main_source_vvvvvzf_SomeFunc(main_source_vvvvvzf)
{
	// set the function logic
	if (main_source_vvvvvzf == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzg function
function vvvvvzg(addcalculation_vvvvvzg)
{
	// set the function logic
	if (addcalculation_vvvvvzg == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvzgvza_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvzgvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvzgvza_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvzgvza_required = true;
		}
	}
}

// the vvvvvzh function
function vvvvvzh(addcalculation_vvvvvzh,gettype_vvvvvzh)
{
	if (isSet(addcalculation_vvvvvzh) && addcalculation_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = addcalculation_vvvvvzh;
		var addcalculation_vvvvvzh = [];
		addcalculation_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(addcalculation_vvvvvzh))
	{
		var addcalculation_vvvvvzh = [];
	}
	var addcalculation = addcalculation_vvvvvzh.some(addcalculation_vvvvvzh_SomeFunc);

	if (isSet(gettype_vvvvvzh) && gettype_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = gettype_vvvvvzh;
		var gettype_vvvvvzh = [];
		gettype_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(gettype_vvvvvzh))
	{
		var gettype_vvvvvzh = [];
	}
	var gettype = gettype_vvvvvzh.some(gettype_vvvvvzh_SomeFunc);


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

// the vvvvvzh Some function
function addcalculation_vvvvvzh_SomeFunc(addcalculation_vvvvvzh)
{
	// set the function logic
	if (addcalculation_vvvvvzh == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzh Some function
function gettype_vvvvvzh_SomeFunc(gettype_vvvvvzh)
{
	// set the function logic
	if (gettype_vvvvvzh == 1 || gettype_vvvvvzh == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzi function
function vvvvvzi(addcalculation_vvvvvzi,gettype_vvvvvzi)
{
	if (isSet(addcalculation_vvvvvzi) && addcalculation_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = addcalculation_vvvvvzi;
		var addcalculation_vvvvvzi = [];
		addcalculation_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(addcalculation_vvvvvzi))
	{
		var addcalculation_vvvvvzi = [];
	}
	var addcalculation = addcalculation_vvvvvzi.some(addcalculation_vvvvvzi_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
	}
}

// the vvvvvzi Some function
function addcalculation_vvvvvzi_SomeFunc(addcalculation_vvvvvzi)
{
	// set the function logic
	if (addcalculation_vvvvvzi == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzi Some function
function gettype_vvvvvzi_SomeFunc(gettype_vvvvvzi)
{
	// set the function logic
	if (gettype_vvvvvzi == 2 || gettype_vvvvvzi == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzlvzb_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzlvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzlvzb_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzlvzb_required = true;
		}
	}
}

// the vvvvvzl Some function
function main_source_vvvvvzl_SomeFunc(main_source_vvvvvzl)
{
	// set the function logic
	if (main_source_vvvvvzl == 3)
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
		jQuery('#jform_filter-lbl').closest('.control-group').show();
		jQuery('#jform_global-lbl').closest('.control-group').show();
		jQuery('#jform_order-lbl').closest('.control-group').show();
		jQuery('#jform_where-lbl').closest('.control-group').show();
		jQuery('#jform_join_db_table-lbl').closest('.control-group').show();
		jQuery('#jform_join_view_table-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_filter-lbl').closest('.control-group').hide();
		jQuery('#jform_global-lbl').closest('.control-group').hide();
		jQuery('#jform_order-lbl').closest('.control-group').hide();
		jQuery('#jform_where-lbl').closest('.control-group').hide();
		jQuery('#jform_join_db_table-lbl').closest('.control-group').hide();
		jQuery('#jform_join_view_table-lbl').closest('.control-group').hide();
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
function vvvvvzn(add_php_before_getitem_vvvvvzn,gettype_vvvvvzn)
{
	if (isSet(add_php_before_getitem_vvvvvzn) && add_php_before_getitem_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = add_php_before_getitem_vvvvvzn;
		var add_php_before_getitem_vvvvvzn = [];
		add_php_before_getitem_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzn))
	{
		var add_php_before_getitem_vvvvvzn = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzn.some(add_php_before_getitem_vvvvvzn_SomeFunc);

	if (isSet(gettype_vvvvvzn) && gettype_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = gettype_vvvvvzn;
		var gettype_vvvvvzn = [];
		gettype_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(gettype_vvvvvzn))
	{
		var gettype_vvvvvzn = [];
	}
	var gettype = gettype_vvvvvzn.some(gettype_vvvvvzn_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvznvzc_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvznvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvznvzc_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvznvzc_required = true;
		}
	}
}

// the vvvvvzn Some function
function add_php_before_getitem_vvvvvzn_SomeFunc(add_php_before_getitem_vvvvvzn)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzn Some function
function gettype_vvvvvzn_SomeFunc(gettype_vvvvvzn)
{
	// set the function logic
	if (gettype_vvvvvzn == 1 || gettype_vvvvvzn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(add_php_after_getitem_vvvvvzo,gettype_vvvvvzo)
{
	if (isSet(add_php_after_getitem_vvvvvzo) && add_php_after_getitem_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = add_php_after_getitem_vvvvvzo;
		var add_php_after_getitem_vvvvvzo = [];
		add_php_after_getitem_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzo))
	{
		var add_php_after_getitem_vvvvvzo = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzo.some(add_php_after_getitem_vvvvvzo_SomeFunc);

	if (isSet(gettype_vvvvvzo) && gettype_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = gettype_vvvvvzo;
		var gettype_vvvvvzo = [];
		gettype_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(gettype_vvvvvzo))
	{
		var gettype_vvvvvzo = [];
	}
	var gettype = gettype_vvvvvzo.some(gettype_vvvvvzo_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzovzd_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzovzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzovzd_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzovzd_required = true;
		}
	}
}

// the vvvvvzo Some function
function add_php_after_getitem_vvvvvzo_SomeFunc(add_php_after_getitem_vvvvvzo)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzo Some function
function gettype_vvvvvzo_SomeFunc(gettype_vvvvvzo)
{
	// set the function logic
	if (gettype_vvvvvzo == 1 || gettype_vvvvvzo == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzq function
function vvvvvzq(gettype_vvvvvzq)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzqvze_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzqvze_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzqvzf_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzqvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzqvze_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzqvze_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzqvzf_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzqvzf_required = true;
		}
	}
}

// the vvvvvzq Some function
function gettype_vvvvvzq_SomeFunc(gettype_vvvvvzq)
{
	// set the function logic
	if (gettype_vvvvvzq == 1 || gettype_vvvvvzq == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzr function
function vvvvvzr(add_php_getlistquery_vvvvvzr,gettype_vvvvvzr)
{
	if (isSet(add_php_getlistquery_vvvvvzr) && add_php_getlistquery_vvvvvzr.constructor !== Array)
	{
		var temp_vvvvvzr = add_php_getlistquery_vvvvvzr;
		var add_php_getlistquery_vvvvvzr = [];
		add_php_getlistquery_vvvvvzr.push(temp_vvvvvzr);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzr))
	{
		var add_php_getlistquery_vvvvvzr = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzr.some(add_php_getlistquery_vvvvvzr_SomeFunc);

	if (isSet(gettype_vvvvvzr) && gettype_vvvvvzr.constructor !== Array)
	{
		var temp_vvvvvzr = gettype_vvvvvzr;
		var gettype_vvvvvzr = [];
		gettype_vvvvvzr.push(temp_vvvvvzr);
	}
	else if (!isSet(gettype_vvvvvzr))
	{
		var gettype_vvvvvzr = [];
	}
	var gettype = gettype_vvvvvzr.some(gettype_vvvvvzr_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzrvzg_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzrvzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzrvzg_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzrvzg_required = true;
		}
	}
}

// the vvvvvzr Some function
function add_php_getlistquery_vvvvvzr_SomeFunc(add_php_getlistquery_vvvvvzr)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzr Some function
function gettype_vvvvvzr_SomeFunc(gettype_vvvvvzr)
{
	// set the function logic
	if (gettype_vvvvvzr == 2 || gettype_vvvvvzr == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzs function
function vvvvvzs(add_php_before_getitems_vvvvvzs,gettype_vvvvvzs)
{
	if (isSet(add_php_before_getitems_vvvvvzs) && add_php_before_getitems_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = add_php_before_getitems_vvvvvzs;
		var add_php_before_getitems_vvvvvzs = [];
		add_php_before_getitems_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzs))
	{
		var add_php_before_getitems_vvvvvzs = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzs.some(add_php_before_getitems_vvvvvzs_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzsvzh_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzsvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzsvzh_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzsvzh_required = true;
		}
	}
}

// the vvvvvzs Some function
function add_php_before_getitems_vvvvvzs_SomeFunc(add_php_before_getitems_vvvvvzs)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzs == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzs Some function
function gettype_vvvvvzs_SomeFunc(gettype_vvvvvzs)
{
	// set the function logic
	if (gettype_vvvvvzs == 2 || gettype_vvvvvzs == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzt function
function vvvvvzt(add_php_after_getitems_vvvvvzt,gettype_vvvvvzt)
{
	if (isSet(add_php_after_getitems_vvvvvzt) && add_php_after_getitems_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = add_php_after_getitems_vvvvvzt;
		var add_php_after_getitems_vvvvvzt = [];
		add_php_after_getitems_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzt))
	{
		var add_php_after_getitems_vvvvvzt = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzt.some(add_php_after_getitems_vvvvvzt_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvztvzi_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvztvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvztvzi_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvztvzi_required = true;
		}
	}
}

// the vvvvvzt Some function
function add_php_after_getitems_vvvvvzt_SomeFunc(add_php_after_getitems_vvvvvzt)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzt == 1)
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

// the vvvvvzv function
function vvvvvzv(gettype_vvvvvzv)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzvvzj_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzvvzj_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzvvzk_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzvvzk_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzvvzl_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzvvzl_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzvvzj_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzvvzj_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzvvzk_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzvvzk_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzvvzl_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzvvzl_required = true;
		}
	}
}

// the vvvvvzv Some function
function gettype_vvvvvzv_SomeFunc(gettype_vvvvvzv)
{
	// set the function logic
	if (gettype_vvvvvzv == 2 || gettype_vvvvvzv == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzw function
function vvvvvzw(gettype_vvvvvzw)
{
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
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzwvzm_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzwvzm_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzwvzm_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzwvzm_required = true;
		}
	}
}

// the vvvvvzw Some function
function gettype_vvvvvzw_SomeFunc(gettype_vvvvvzw)
{
	// set the function logic
	if (gettype_vvvvvzw == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzx function
function vvvvvzx(gettype_vvvvvzx)
{
	if (isSet(gettype_vvvvvzx) && gettype_vvvvvzx.constructor !== Array)
	{
		var temp_vvvvvzx = gettype_vvvvvzx;
		var gettype_vvvvvzx = [];
		gettype_vvvvvzx.push(temp_vvvvvzx);
	}
	else if (!isSet(gettype_vvvvvzx))
	{
		var gettype_vvvvvzx = [];
	}
	var gettype = gettype_vvvvvzx.some(gettype_vvvvvzx_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzxvzn_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvvzxvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzxvzn_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvvzxvzn_required = true;
		}
	}
}

// the vvvvvzx Some function
function gettype_vvvvvzx_SomeFunc(gettype_vvvvvzx)
{
	// set the function logic
	if (gettype_vvvvvzx == 1 || gettype_vvvvvzx == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzy function
function vvvvvzy(gettype_vvvvvzy,add_php_router_parse_vvvvvzy)
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

	if (isSet(add_php_router_parse_vvvvvzy) && add_php_router_parse_vvvvvzy.constructor !== Array)
	{
		var temp_vvvvvzy = add_php_router_parse_vvvvvzy;
		var add_php_router_parse_vvvvvzy = [];
		add_php_router_parse_vvvvvzy.push(temp_vvvvvzy);
	}
	else if (!isSet(add_php_router_parse_vvvvvzy))
	{
		var add_php_router_parse_vvvvvzy = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvvzy.some(add_php_router_parse_vvvvvzy_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzyvzo_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvvzyvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzyvzo_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvvzyvzo_required = true;
		}
	}
}

// the vvvvvzy Some function
function gettype_vvvvvzy_SomeFunc(gettype_vvvvvzy)
{
	// set the function logic
	if (gettype_vvvvvzy == 1 || gettype_vvvvvzy == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzy Some function
function add_php_router_parse_vvvvvzy_SomeFunc(add_php_router_parse_vvvvvzy)
{
	// set the function logic
	if (add_php_router_parse_vvvvvzy == 1)
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
});

function getLinked_server(type){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&vdm="+vastDevMod;
	if(token.length > 0 && type > 0){
		var request = 'token='+token+'&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
}

function getViewTableColumns_server(viewId,asKey,rowType)
{
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.viewTableColumns&format=json";
	if (token.length > 0 && viewId > 0 && asKey.length > 0)
	{
		var request = 'token='+token+'&as='+asKey+'&type='+rowType+'&id='+viewId;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getViewTableColumns(id,asKey,key,rowType,main, table_, nr_)
{
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.dbTableColumns&format=json";
	if (token.length > 0 && name.length > 0 && asKey.length > 0)
	{
		var request = 'token='+token+'&as='+asKey+'&type='+rowType+'&name='+name;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getDbTableColumns(name, asKey, key, rowType, main, table_, nr_)
{
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
function updateSubItems(fieldName, fieldNr, table_, nr_){
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getDynamicScripts&format=json&vdm="+vastDevMod;
	if(token.length > 0 && typpe.length > 0){
		var request = 'token='+token+'&type='+typpe;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
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
