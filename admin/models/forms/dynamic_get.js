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
jform_vvvvvzdvyx_required = false;
jform_vvvvvzevyy_required = false;
jform_vvvvvzfvyz_required = false;
jform_vvvvvzgvza_required = false;
jform_vvvvvzhvzb_required = false;
jform_vvvvvzivzc_required = false;
jform_vvvvvznvzd_required = false;
jform_vvvvvzpvze_required = false;
jform_vvvvvzqvzf_required = false;
jform_vvvvvzsvzg_required = false;
jform_vvvvvzsvzh_required = false;
jform_vvvvvztvzi_required = false;
jform_vvvvvzuvzj_required = false;
jform_vvvvvzvvzk_required = false;
jform_vvvvvzxvzl_required = false;
jform_vvvvvzxvzm_required = false;
jform_vvvvvzxvzn_required = false;
jform_vvvvvzyvzo_required = false;
jform_vvvvvzzvzp_required = false;
jform_vvvvwaavzq_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(gettype_vvvvvzd);

	var main_source_vvvvvze = jQuery("#jform_main_source").val();
	vvvvvze(main_source_vvvvvze);

	var main_source_vvvvvzf = jQuery("#jform_main_source").val();
	vvvvvzf(main_source_vvvvvzf);

	var main_source_vvvvvzg = jQuery("#jform_main_source").val();
	vvvvvzg(main_source_vvvvvzg);

	var main_source_vvvvvzh = jQuery("#jform_main_source").val();
	vvvvvzh(main_source_vvvvvzh);

	var addcalculation_vvvvvzi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzi(addcalculation_vvvvvzi);

	var addcalculation_vvvvvzj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(addcalculation_vvvvvzj,gettype_vvvvvzj);

	var addcalculation_vvvvvzk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(addcalculation_vvvvvzk,gettype_vvvvvzk);

	var main_source_vvvvvzn = jQuery("#jform_main_source").val();
	vvvvvzn(main_source_vvvvvzn);

	var main_source_vvvvvzo = jQuery("#jform_main_source").val();
	vvvvvzo(main_source_vvvvvzo);

	var add_php_before_getitem_vvvvvzp = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(add_php_before_getitem_vvvvvzp,gettype_vvvvvzp);

	var add_php_after_getitem_vvvvvzq = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(add_php_after_getitem_vvvvvzq,gettype_vvvvvzq);

	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(gettype_vvvvvzs);

	var add_php_getlistquery_vvvvvzt = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(add_php_getlistquery_vvvvvzt,gettype_vvvvvzt);

	var add_php_before_getitems_vvvvvzu = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzu = jQuery("#jform_gettype").val();
	vvvvvzu(add_php_before_getitems_vvvvvzu,gettype_vvvvvzu);

	var add_php_after_getitems_vvvvvzv = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	vvvvvzv(add_php_after_getitems_vvvvvzv,gettype_vvvvvzv);

	var gettype_vvvvvzx = jQuery("#jform_gettype").val();
	vvvvvzx(gettype_vvvvvzx);

	var gettype_vvvvvzy = jQuery("#jform_gettype").val();
	vvvvvzy(gettype_vvvvvzy);

	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	vvvvvzz(gettype_vvvvvzz);

	var gettype_vvvvwaa = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwaa = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwaa(gettype_vvvvwaa,add_php_router_parse_vvvvwaa);
});

// the vvvvvzd function
function vvvvvzd(gettype_vvvvvzd)
{
	if (isSet(gettype_vvvvvzd) && gettype_vvvvvzd.constructor !== Array)
	{
		var temp_vvvvvzd = gettype_vvvvvzd;
		var gettype_vvvvvzd = [];
		gettype_vvvvvzd.push(temp_vvvvvzd);
	}
	else if (!isSet(gettype_vvvvvzd))
	{
		var gettype_vvvvvzd = [];
	}
	var gettype = gettype_vvvvvzd.some(gettype_vvvvvzd_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvzdvyx_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvzdvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvzdvyx_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvzdvyx_required = true;
		}
	}
}

// the vvvvvzd Some function
function gettype_vvvvvzd_SomeFunc(gettype_vvvvvzd)
{
	// set the function logic
	if (gettype_vvvvvzd == 3 || gettype_vvvvvzd == 4)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvzevyy_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvzevyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzevyy_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvzfvyz_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzfvyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvzfvyz_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzfvyz_required = true;
		}
	}
}

// the vvvvvzf Some function
function main_source_vvvvvzf_SomeFunc(main_source_vvvvvzf)
{
	// set the function logic
	if (main_source_vvvvvzf == 1)
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvzgvza_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzgvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzgvza_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
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
function vvvvvzh(main_source_vvvvvzh)
{
	if (isSet(main_source_vvvvvzh) && main_source_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = main_source_vvvvvzh;
		var main_source_vvvvvzh = [];
		main_source_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(main_source_vvvvvzh))
	{
		var main_source_vvvvvzh = [];
	}
	var main_source = main_source_vvvvvzh.some(main_source_vvvvvzh_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvzhvzb_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzhvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvzhvzb_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzhvzb_required = true;
		}
	}
}

// the vvvvvzh Some function
function main_source_vvvvvzh_SomeFunc(main_source_vvvvvzh)
{
	// set the function logic
	if (main_source_vvvvvzh == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzi function
function vvvvvzi(addcalculation_vvvvvzi)
{
	// set the function logic
	if (addcalculation_vvvvvzi == 1)
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').show();
		if (jform_vvvvvzivzc_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvzivzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzivzc_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvzivzc_required = true;
		}
	}
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
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
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
	if (gettype_vvvvvzj == 1 || gettype_vvvvvzj == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzk function
function vvvvvzk(addcalculation_vvvvvzk,gettype_vvvvvzk)
{
	if (isSet(addcalculation_vvvvvzk) && addcalculation_vvvvvzk.constructor !== Array)
	{
		var temp_vvvvvzk = addcalculation_vvvvvzk;
		var addcalculation_vvvvvzk = [];
		addcalculation_vvvvvzk.push(temp_vvvvvzk);
	}
	else if (!isSet(addcalculation_vvvvvzk))
	{
		var addcalculation_vvvvvzk = [];
	}
	var addcalculation = addcalculation_vvvvvzk.some(addcalculation_vvvvvzk_SomeFunc);

	if (isSet(gettype_vvvvvzk) && gettype_vvvvvzk.constructor !== Array)
	{
		var temp_vvvvvzk = gettype_vvvvvzk;
		var gettype_vvvvvzk = [];
		gettype_vvvvvzk.push(temp_vvvvvzk);
	}
	else if (!isSet(gettype_vvvvvzk))
	{
		var gettype_vvvvvzk = [];
	}
	var gettype = gettype_vvvvvzk.some(gettype_vvvvvzk_SomeFunc);


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

// the vvvvvzk Some function
function addcalculation_vvvvvzk_SomeFunc(addcalculation_vvvvvzk)
{
	// set the function logic
	if (addcalculation_vvvvvzk == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzk Some function
function gettype_vvvvvzk_SomeFunc(gettype_vvvvvzk)
{
	// set the function logic
	if (gettype_vvvvvzk == 2 || gettype_vvvvvzk == 4)
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
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').show();
		if (jform_vvvvvznvzd_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvznvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').hide();
		if (!jform_vvvvvznvzd_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvznvzd_required = true;
		}
	}
}

// the vvvvvzn Some function
function main_source_vvvvvzn_SomeFunc(main_source_vvvvvzn)
{
	// set the function logic
	if (main_source_vvvvvzn == 3)
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

// the vvvvvzo Some function
function main_source_vvvvvzo_SomeFunc(main_source_vvvvvzo)
{
	// set the function logic
	if (main_source_vvvvvzo == 1 || main_source_vvvvvzo == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzp function
function vvvvvzp(add_php_before_getitem_vvvvvzp,gettype_vvvvvzp)
{
	if (isSet(add_php_before_getitem_vvvvvzp) && add_php_before_getitem_vvvvvzp.constructor !== Array)
	{
		var temp_vvvvvzp = add_php_before_getitem_vvvvvzp;
		var add_php_before_getitem_vvvvvzp = [];
		add_php_before_getitem_vvvvvzp.push(temp_vvvvvzp);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzp))
	{
		var add_php_before_getitem_vvvvvzp = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzp.some(add_php_before_getitem_vvvvvzp_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').show();
		if (jform_vvvvvzpvze_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzpvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzpvze_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzpvze_required = true;
		}
	}
}

// the vvvvvzp Some function
function add_php_before_getitem_vvvvvzp_SomeFunc(add_php_before_getitem_vvvvvzp)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzp == 1)
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
function vvvvvzq(add_php_after_getitem_vvvvvzq,gettype_vvvvvzq)
{
	if (isSet(add_php_after_getitem_vvvvvzq) && add_php_after_getitem_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = add_php_after_getitem_vvvvvzq;
		var add_php_after_getitem_vvvvvzq = [];
		add_php_after_getitem_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzq))
	{
		var add_php_after_getitem_vvvvvzq = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzq.some(add_php_after_getitem_vvvvvzq_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').show();
		if (jform_vvvvvzqvzf_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzqvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzqvzf_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzqvzf_required = true;
		}
	}
}

// the vvvvvzq Some function
function add_php_after_getitem_vvvvvzq_SomeFunc(add_php_after_getitem_vvvvvzq)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzq == 1)
	{
		return true;
	}
	return false;
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

// the vvvvvzs function
function vvvvvzs(gettype_vvvvvzs)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzsvzg_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzsvzg_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzsvzh_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzsvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzsvzg_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzsvzg_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzsvzh_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzsvzh_required = true;
		}
	}
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
function vvvvvzt(add_php_getlistquery_vvvvvzt,gettype_vvvvvzt)
{
	if (isSet(add_php_getlistquery_vvvvvzt) && add_php_getlistquery_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = add_php_getlistquery_vvvvvzt;
		var add_php_getlistquery_vvvvvzt = [];
		add_php_getlistquery_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzt))
	{
		var add_php_getlistquery_vvvvvzt = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzt.some(add_php_getlistquery_vvvvvzt_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
		if (jform_vvvvvztvzi_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvztvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
		if (!jform_vvvvvztvzi_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvztvzi_required = true;
		}
	}
}

// the vvvvvzt Some function
function add_php_getlistquery_vvvvvzt_SomeFunc(add_php_getlistquery_vvvvvzt)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzt == 1)
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
function vvvvvzu(add_php_before_getitems_vvvvvzu,gettype_vvvvvzu)
{
	if (isSet(add_php_before_getitems_vvvvvzu) && add_php_before_getitems_vvvvvzu.constructor !== Array)
	{
		var temp_vvvvvzu = add_php_before_getitems_vvvvvzu;
		var add_php_before_getitems_vvvvvzu = [];
		add_php_before_getitems_vvvvvzu.push(temp_vvvvvzu);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzu))
	{
		var add_php_before_getitems_vvvvvzu = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzu.some(add_php_before_getitems_vvvvvzu_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').show();
		if (jform_vvvvvzuvzj_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzuvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzuvzj_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzuvzj_required = true;
		}
	}
}

// the vvvvvzu Some function
function add_php_before_getitems_vvvvvzu_SomeFunc(add_php_before_getitems_vvvvvzu)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzu == 1)
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

// the vvvvvzv function
function vvvvvzv(add_php_after_getitems_vvvvvzv,gettype_vvvvvzv)
{
	if (isSet(add_php_after_getitems_vvvvvzv) && add_php_after_getitems_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = add_php_after_getitems_vvvvvzv;
		var add_php_after_getitems_vvvvvzv = [];
		add_php_after_getitems_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzv))
	{
		var add_php_after_getitems_vvvvvzv = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzv.some(add_php_after_getitems_vvvvvzv_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').show();
		if (jform_vvvvvzvvzk_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzvvzk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').hide();
		if (!jform_vvvvvzvvzk_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzvvzk_required = true;
		}
	}
}

// the vvvvvzv Some function
function add_php_after_getitems_vvvvvzv_SomeFunc(add_php_after_getitems_vvvvvzv)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzv == 1)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzxvzl_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzxvzl_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzxvzm_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzxvzm_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzxvzn_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzxvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzxvzl_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzxvzl_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzxvzm_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzxvzm_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzxvzn_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzxvzn_required = true;
		}
	}
}

// the vvvvvzx Some function
function gettype_vvvvvzx_SomeFunc(gettype_vvvvvzx)
{
	// set the function logic
	if (gettype_vvvvvzx == 2 || gettype_vvvvvzx == 4)
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzyvzo_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzyvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzyvzo_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzyvzo_required = true;
		}
	}
}

// the vvvvvzy Some function
function gettype_vvvvvzy_SomeFunc(gettype_vvvvvzy)
{
	// set the function logic
	if (gettype_vvvvvzy == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzz function
function vvvvvzz(gettype_vvvvvzz)
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


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzzvzp_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvvzzvzp_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzzvzp_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
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

// the vvvvwaa function
function vvvvwaa(gettype_vvvvwaa,add_php_router_parse_vvvvwaa)
{
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

	if (isSet(add_php_router_parse_vvvvwaa) && add_php_router_parse_vvvvwaa.constructor !== Array)
	{
		var temp_vvvvwaa = add_php_router_parse_vvvvwaa;
		var add_php_router_parse_vvvvwaa = [];
		add_php_router_parse_vvvvwaa.push(temp_vvvvwaa);
	}
	else if (!isSet(add_php_router_parse_vvvvwaa))
	{
		var add_php_router_parse_vvvvwaa = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvwaa.some(add_php_router_parse_vvvvwaa_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		if (jform_vvvvwaavzq_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvwaavzq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvwaavzq_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvwaavzq_required = true;
		}
	}
}

// the vvvvwaa Some function
function gettype_vvvvwaa_SomeFunc(gettype_vvvvwaa)
{
	// set the function logic
	if (gettype_vvvvwaa == 1 || gettype_vvvvwaa == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwaa Some function
function add_php_router_parse_vvvvwaa_SomeFunc(add_php_router_parse_vvvvwaa)
{
	// set the function logic
	if (add_php_router_parse_vvvvwaa == 1)
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
