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
jform_vvvvvzcvyw_required = false;
jform_vvvvvzdvyx_required = false;
jform_vvvvvzevyy_required = false;
jform_vvvvvzfvyz_required = false;
jform_vvvvvzgvza_required = false;
jform_vvvvvzhvzb_required = false;
jform_vvvvvzmvzc_required = false;
jform_vvvvvzovzd_required = false;
jform_vvvvvzpvze_required = false;
jform_vvvvvzrvzf_required = false;
jform_vvvvvzrvzg_required = false;
jform_vvvvvzsvzh_required = false;
jform_vvvvvztvzi_required = false;
jform_vvvvvzuvzj_required = false;
jform_vvvvvzwvzk_required = false;
jform_vvvvvzwvzl_required = false;
jform_vvvvvzwvzm_required = false;
jform_vvvvvzxvzn_required = false;
jform_vvvvvzyvzo_required = false;
jform_vvvvvzzvzp_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(gettype_vvvvvzc);

	var main_source_vvvvvzd = jQuery("#jform_main_source").val();
	vvvvvzd(main_source_vvvvvzd);

	var main_source_vvvvvze = jQuery("#jform_main_source").val();
	vvvvvze(main_source_vvvvvze);

	var main_source_vvvvvzf = jQuery("#jform_main_source").val();
	vvvvvzf(main_source_vvvvvzf);

	var main_source_vvvvvzg = jQuery("#jform_main_source").val();
	vvvvvzg(main_source_vvvvvzg);

	var addcalculation_vvvvvzh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzh(addcalculation_vvvvvzh);

	var addcalculation_vvvvvzi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(addcalculation_vvvvvzi,gettype_vvvvvzi);

	var addcalculation_vvvvvzj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(addcalculation_vvvvvzj,gettype_vvvvvzj);

	var main_source_vvvvvzm = jQuery("#jform_main_source").val();
	vvvvvzm(main_source_vvvvvzm);

	var main_source_vvvvvzn = jQuery("#jform_main_source").val();
	vvvvvzn(main_source_vvvvvzn);

	var add_php_before_getitem_vvvvvzo = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_before_getitem_vvvvvzo,gettype_vvvvvzo);

	var add_php_after_getitem_vvvvvzp = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(add_php_after_getitem_vvvvvzp,gettype_vvvvvzp);

	var gettype_vvvvvzr = jQuery("#jform_gettype").val();
	vvvvvzr(gettype_vvvvvzr);

	var add_php_getlistquery_vvvvvzs = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(add_php_getlistquery_vvvvvzs,gettype_vvvvvzs);

	var add_php_before_getitems_vvvvvzt = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(add_php_before_getitems_vvvvvzt,gettype_vvvvvzt);

	var add_php_after_getitems_vvvvvzu = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzu = jQuery("#jform_gettype").val();
	vvvvvzu(add_php_after_getitems_vvvvvzu,gettype_vvvvvzu);

	var gettype_vvvvvzw = jQuery("#jform_gettype").val();
	vvvvvzw(gettype_vvvvvzw);

	var gettype_vvvvvzx = jQuery("#jform_gettype").val();
	vvvvvzx(gettype_vvvvvzx);

	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	vvvvvzy(gettype_vvvvvzy);

	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvvzz = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvvzz(gettype_vvvvvzz,add_php_router_parse_vvvvvzz);
});

// the vvvvvzc function
function vvvvvzc(gettype_vvvvvzc)
{
	if (isSet(gettype_vvvvvzc) && gettype_vvvvvzc.constructor !== Array)
	{
		var temp_vvvvvzc = gettype_vvvvvzc;
		var gettype_vvvvvzc = [];
		gettype_vvvvvzc.push(temp_vvvvvzc);
	}
	else if (!isSet(gettype_vvvvvzc))
	{
		var gettype_vvvvvzc = [];
	}
	var gettype = gettype_vvvvvzc.some(gettype_vvvvvzc_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvzcvyw_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvzcvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvzcvyw_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvzcvyw_required = true;
		}
	}
}

// the vvvvvzc Some function
function gettype_vvvvvzc_SomeFunc(gettype_vvvvvzc)
{
	// set the function logic
	if (gettype_vvvvvzc == 3 || gettype_vvvvvzc == 4)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvzdvyx_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvzdvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzdvyx_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvzevyy_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzevyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvzevyy_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzevyy_required = true;
		}
	}
}

// the vvvvvze Some function
function main_source_vvvvvze_SomeFunc(main_source_vvvvvze)
{
	// set the function logic
	if (main_source_vvvvvze == 1)
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvzfvyz_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzfvyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzfvyz_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
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
function vvvvvzg(main_source_vvvvvzg)
{
	if (isSet(main_source_vvvvvzg) && main_source_vvvvvzg.constructor !== Array)
	{
		var temp_vvvvvzg = main_source_vvvvvzg;
		var main_source_vvvvvzg = [];
		main_source_vvvvvzg.push(temp_vvvvvzg);
	}
	else if (!isSet(main_source_vvvvvzg))
	{
		var main_source_vvvvvzg = [];
	}
	var main_source = main_source_vvvvvzg.some(main_source_vvvvvzg_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvzgvza_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzgvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvzgvza_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzgvza_required = true;
		}
	}
}

// the vvvvvzg Some function
function main_source_vvvvvzg_SomeFunc(main_source_vvvvvzg)
{
	// set the function logic
	if (main_source_vvvvvzg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzh function
function vvvvvzh(addcalculation_vvvvvzh)
{
	// set the function logic
	if (addcalculation_vvvvvzh == 1)
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').show();
		if (jform_vvvvvzhvzb_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvzhvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzhvzb_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvzhvzb_required = true;
		}
	}
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
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
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
	if (gettype_vvvvvzi == 1 || gettype_vvvvvzi == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzj function
function vvvvvzj(addcalculation_vvvvvzj,gettype_vvvvvzj)
{
	if (isSet(addcalculation_vvvvvzj) && addcalculation_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = addcalculation_vvvvvzj;
		var addcalculation_vvvvvzj = [];
		addcalculation_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(addcalculation_vvvvvzj))
	{
		var addcalculation_vvvvvzj = [];
	}
	var addcalculation = addcalculation_vvvvvzj.some(addcalculation_vvvvvzj_SomeFunc);

	if (isSet(gettype_vvvvvzj) && gettype_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = gettype_vvvvvzj;
		var gettype_vvvvvzj = [];
		gettype_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(gettype_vvvvvzj))
	{
		var gettype_vvvvvzj = [];
	}
	var gettype = gettype_vvvvvzj.some(gettype_vvvvvzj_SomeFunc);


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

// the vvvvvzj Some function
function addcalculation_vvvvvzj_SomeFunc(addcalculation_vvvvvzj)
{
	// set the function logic
	if (addcalculation_vvvvvzj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzj Some function
function gettype_vvvvvzj_SomeFunc(gettype_vvvvvzj)
{
	// set the function logic
	if (gettype_vvvvvzj == 2 || gettype_vvvvvzj == 4)
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
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').show();
		if (jform_vvvvvzmvzc_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzmvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzmvzc_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzmvzc_required = true;
		}
	}
}

// the vvvvvzm Some function
function main_source_vvvvvzm_SomeFunc(main_source_vvvvvzm)
{
	// set the function logic
	if (main_source_vvvvvzm == 3)
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

// the vvvvvzn Some function
function main_source_vvvvvzn_SomeFunc(main_source_vvvvvzn)
{
	// set the function logic
	if (main_source_vvvvvzn == 1 || main_source_vvvvvzn == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(add_php_before_getitem_vvvvvzo,gettype_vvvvvzo)
{
	if (isSet(add_php_before_getitem_vvvvvzo) && add_php_before_getitem_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = add_php_before_getitem_vvvvvzo;
		var add_php_before_getitem_vvvvvzo = [];
		add_php_before_getitem_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzo))
	{
		var add_php_before_getitem_vvvvvzo = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzo.some(add_php_before_getitem_vvvvvzo_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').show();
		if (jform_vvvvvzovzd_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzovzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzovzd_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzovzd_required = true;
		}
	}
}

// the vvvvvzo Some function
function add_php_before_getitem_vvvvvzo_SomeFunc(add_php_before_getitem_vvvvvzo)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzo == 1)
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

// the vvvvvzp function
function vvvvvzp(add_php_after_getitem_vvvvvzp,gettype_vvvvvzp)
{
	if (isSet(add_php_after_getitem_vvvvvzp) && add_php_after_getitem_vvvvvzp.constructor !== Array)
	{
		var temp_vvvvvzp = add_php_after_getitem_vvvvvzp;
		var add_php_after_getitem_vvvvvzp = [];
		add_php_after_getitem_vvvvvzp.push(temp_vvvvvzp);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzp))
	{
		var add_php_after_getitem_vvvvvzp = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzp.some(add_php_after_getitem_vvvvvzp_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').show();
		if (jform_vvvvvzpvze_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzpvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzpvze_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzpvze_required = true;
		}
	}
}

// the vvvvvzp Some function
function add_php_after_getitem_vvvvvzp_SomeFunc(add_php_after_getitem_vvvvvzp)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzp == 1)
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

// the vvvvvzr function
function vvvvvzr(gettype_vvvvvzr)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzrvzf_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzrvzf_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzrvzg_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzrvzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzrvzf_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzrvzf_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzrvzg_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzrvzg_required = true;
		}
	}
}

// the vvvvvzr Some function
function gettype_vvvvvzr_SomeFunc(gettype_vvvvvzr)
{
	// set the function logic
	if (gettype_vvvvvzr == 1 || gettype_vvvvvzr == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzs function
function vvvvvzs(add_php_getlistquery_vvvvvzs,gettype_vvvvvzs)
{
	if (isSet(add_php_getlistquery_vvvvvzs) && add_php_getlistquery_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = add_php_getlistquery_vvvvvzs;
		var add_php_getlistquery_vvvvvzs = [];
		add_php_getlistquery_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzs))
	{
		var add_php_getlistquery_vvvvvzs = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzs.some(add_php_getlistquery_vvvvvzs_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
		if (jform_vvvvvzsvzh_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzsvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzsvzh_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzsvzh_required = true;
		}
	}
}

// the vvvvvzs Some function
function add_php_getlistquery_vvvvvzs_SomeFunc(add_php_getlistquery_vvvvvzs)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzs == 1)
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
function vvvvvzt(add_php_before_getitems_vvvvvzt,gettype_vvvvvzt)
{
	if (isSet(add_php_before_getitems_vvvvvzt) && add_php_before_getitems_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = add_php_before_getitems_vvvvvzt;
		var add_php_before_getitems_vvvvvzt = [];
		add_php_before_getitems_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzt))
	{
		var add_php_before_getitems_vvvvvzt = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzt.some(add_php_before_getitems_vvvvvzt_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').show();
		if (jform_vvvvvztvzi_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvztvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').hide();
		if (!jform_vvvvvztvzi_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvztvzi_required = true;
		}
	}
}

// the vvvvvzt Some function
function add_php_before_getitems_vvvvvzt_SomeFunc(add_php_before_getitems_vvvvvzt)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzt == 1)
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

// the vvvvvzu function
function vvvvvzu(add_php_after_getitems_vvvvvzu,gettype_vvvvvzu)
{
	if (isSet(add_php_after_getitems_vvvvvzu) && add_php_after_getitems_vvvvvzu.constructor !== Array)
	{
		var temp_vvvvvzu = add_php_after_getitems_vvvvvzu;
		var add_php_after_getitems_vvvvvzu = [];
		add_php_after_getitems_vvvvvzu.push(temp_vvvvvzu);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzu))
	{
		var add_php_after_getitems_vvvvvzu = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzu.some(add_php_after_getitems_vvvvvzu_SomeFunc);

	if (isSet(gettype_vvvvvzu) && gettype_vvvvvzu.constructor !== Array)
	{
		var temp_vvvvvzu = gettype_vvvvvzu;
		var gettype_vvvvvzu = [];
		gettype_vvvvvzu.push(temp_vvvvvzu);
	}
	else if (!isSet(gettype_vvvvvzu))
	{
		var gettype_vvvvvzu = [];
	}
	var gettype = gettype_vvvvvzu.some(gettype_vvvvvzu_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').show();
		if (jform_vvvvvzuvzj_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzuvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzuvzj_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzuvzj_required = true;
		}
	}
}

// the vvvvvzu Some function
function add_php_after_getitems_vvvvvzu_SomeFunc(add_php_after_getitems_vvvvvzu)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzu Some function
function gettype_vvvvvzu_SomeFunc(gettype_vvvvvzu)
{
	// set the function logic
	if (gettype_vvvvvzu == 2 || gettype_vvvvvzu == 4)
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzwvzk_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzwvzk_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzwvzl_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzwvzl_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzwvzm_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzwvzm_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzwvzk_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzwvzk_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzwvzl_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzwvzl_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzwvzm_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzwvzm_required = true;
		}
	}
}

// the vvvvvzw Some function
function gettype_vvvvvzw_SomeFunc(gettype_vvvvvzw)
{
	// set the function logic
	if (gettype_vvvvvzw == 2 || gettype_vvvvvzw == 4)
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzxvzn_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzxvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzxvzn_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzxvzn_required = true;
		}
	}
}

// the vvvvvzx Some function
function gettype_vvvvvzx_SomeFunc(gettype_vvvvvzx)
{
	// set the function logic
	if (gettype_vvvvvzx == 2)
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
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzyvzo_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvvzyvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzyvzo_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
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

// the vvvvvzz function
function vvvvvzz(gettype_vvvvvzz,add_php_router_parse_vvvvvzz)
{
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

	if (isSet(add_php_router_parse_vvvvvzz) && add_php_router_parse_vvvvvzz.constructor !== Array)
	{
		var temp_vvvvvzz = add_php_router_parse_vvvvvzz;
		var add_php_router_parse_vvvvvzz = [];
		add_php_router_parse_vvvvvzz.push(temp_vvvvvzz);
	}
	else if (!isSet(add_php_router_parse_vvvvvzz))
	{
		var add_php_router_parse_vvvvvzz = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvvzz.some(add_php_router_parse_vvvvvzz_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzzvzp_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvvzzvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzzvzp_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvvzzvzp_required = true;
		}
	}
}

// the vvvvvzz Some function
function gettype_vvvvvzz_SomeFunc(gettype_vvvvvzz)
{
	// set the function logic
	if (gettype_vvvvvzz == 1 || gettype_vvvvvzz == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzz Some function
function add_php_router_parse_vvvvvzz_SomeFunc(add_php_router_parse_vvvvvzz)
{
	// set the function logic
	if (add_php_router_parse_vvvvvzz == 1)
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
