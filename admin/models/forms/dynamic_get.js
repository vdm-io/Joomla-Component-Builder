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
jform_vvvvvzevza_required = false;
jform_vvvvvzgvzb_required = false;
jform_vvvvvzhvzc_required = false;
jform_vvvvvzivzd_required = false;
jform_vvvvvzjvze_required = false;
jform_vvvvvzkvzf_required = false;
jform_vvvvvzpvzg_required = false;
jform_vvvvvzrvzh_required = false;
jform_vvvvvzsvzi_required = false;
jform_vvvvvzuvzj_required = false;
jform_vvvvvzuvzk_required = false;
jform_vvvvvzvvzl_required = false;
jform_vvvvvzwvzm_required = false;
jform_vvvvvzxvzn_required = false;
jform_vvvvvzzvzo_required = false;
jform_vvvvvzzvzp_required = false;
jform_vvvvvzzvzq_required = false;
jform_vvvvwaavzr_required = false;
jform_vvvvwabvzs_required = false;
jform_vvvvwacvzt_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(gettype_vvvvvze);

	var main_source_vvvvvzf = jQuery("#jform_main_source").val();
	vvvvvzf(main_source_vvvvvzf);

	var main_source_vvvvvzg = jQuery("#jform_main_source").val();
	vvvvvzg(main_source_vvvvvzg);

	var main_source_vvvvvzh = jQuery("#jform_main_source").val();
	vvvvvzh(main_source_vvvvvzh);

	var main_source_vvvvvzi = jQuery("#jform_main_source").val();
	vvvvvzi(main_source_vvvvvzi);

	var main_source_vvvvvzj = jQuery("#jform_main_source").val();
	vvvvvzj(main_source_vvvvvzj);

	var addcalculation_vvvvvzk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzk(addcalculation_vvvvvzk);

	var addcalculation_vvvvvzl = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(addcalculation_vvvvvzl,gettype_vvvvvzl);

	var addcalculation_vvvvvzm = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(addcalculation_vvvvvzm,gettype_vvvvvzm);

	var main_source_vvvvvzp = jQuery("#jform_main_source").val();
	vvvvvzp(main_source_vvvvvzp);

	var main_source_vvvvvzq = jQuery("#jform_main_source").val();
	vvvvvzq(main_source_vvvvvzq);

	var add_php_before_getitem_vvvvvzr = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzr = jQuery("#jform_gettype").val();
	vvvvvzr(add_php_before_getitem_vvvvvzr,gettype_vvvvvzr);

	var add_php_after_getitem_vvvvvzs = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(add_php_after_getitem_vvvvvzs,gettype_vvvvvzs);

	var gettype_vvvvvzu = jQuery("#jform_gettype").val();
	vvvvvzu(gettype_vvvvvzu);

	var add_php_getlistquery_vvvvvzv = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	vvvvvzv(add_php_getlistquery_vvvvvzv,gettype_vvvvvzv);

	var add_php_before_getitems_vvvvvzw = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzw = jQuery("#jform_gettype").val();
	vvvvvzw(add_php_before_getitems_vvvvvzw,gettype_vvvvvzw);

	var add_php_after_getitems_vvvvvzx = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzx = jQuery("#jform_gettype").val();
	vvvvvzx(add_php_after_getitems_vvvvvzx,gettype_vvvvvzx);

	var gettype_vvvvvzz = jQuery("#jform_gettype").val();
	vvvvvzz(gettype_vvvvvzz);

	var gettype_vvvvwaa = jQuery("#jform_gettype").val();
	vvvvwaa(gettype_vvvvwaa);

	var gettype_vvvvwab = jQuery("#jform_gettype").val();
	vvvvwab(gettype_vvvvwab);

	var gettype_vvvvwac = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvwac = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvwac(gettype_vvvvwac,add_php_router_parse_vvvvwac);

	var gettype_vvvvwae = jQuery("#jform_gettype").val();
	vvvvwae(gettype_vvvvwae);
});

// the vvvvvze function
function vvvvvze(gettype_vvvvvze)
{
	if (isSet(gettype_vvvvvze) && gettype_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = gettype_vvvvvze;
		var gettype_vvvvvze = [];
		gettype_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(gettype_vvvvvze))
	{
		var gettype_vvvvvze = [];
	}
	var gettype = gettype_vvvvvze.some(gettype_vvvvvze_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		// add required attribute to getcustom field
		if (jform_vvvvvzevza_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvzevza_required = false;
		}
	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		// remove required attribute from getcustom field
		if (!jform_vvvvvzevza_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvzevza_required = true;
		}
	}
}

// the vvvvvze Some function
function gettype_vvvvvze_SomeFunc(gettype_vvvvvze)
{
	// set the function logic
	if (gettype_vvvvvze == 3 || gettype_vvvvvze == 4)
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
		jQuery('#jform_select_all').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_select_all').closest('.control-group').hide();
	}
}

// the vvvvvzf Some function
function main_source_vvvvvzf_SomeFunc(main_source_vvvvvzf)
{
	// set the function logic
	if (main_source_vvvvvzf == 1 || main_source_vvvvvzf == 2)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		// add required attribute to view_table_main field
		if (jform_vvvvvzgvzb_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvzgvzb_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		// remove required attribute from view_table_main field
		if (!jform_vvvvvzgvzb_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvzgvzb_required = true;
		}
	}
}

// the vvvvvzg Some function
function main_source_vvvvvzg_SomeFunc(main_source_vvvvvzg)
{
	// set the function logic
	if (main_source_vvvvvzg == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		// add required attribute to view_selection field
		if (jform_vvvvvzhvzc_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzhvzc_required = false;
		}
	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		// remove required attribute from view_selection field
		if (!jform_vvvvvzhvzc_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzhvzc_required = true;
		}
	}
}

// the vvvvvzh Some function
function main_source_vvvvvzh_SomeFunc(main_source_vvvvvzh)
{
	// set the function logic
	if (main_source_vvvvvzh == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzi function
function vvvvvzi(main_source_vvvvvzi)
{
	if (isSet(main_source_vvvvvzi) && main_source_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = main_source_vvvvvzi;
		var main_source_vvvvvzi = [];
		main_source_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(main_source_vvvvvzi))
	{
		var main_source_vvvvvzi = [];
	}
	var main_source = main_source_vvvvvzi.some(main_source_vvvvvzi_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		// add required attribute to db_table_main field
		if (jform_vvvvvzivzd_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzivzd_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		// remove required attribute from db_table_main field
		if (!jform_vvvvvzivzd_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvzivzd_required = true;
		}
	}
}

// the vvvvvzi Some function
function main_source_vvvvvzi_SomeFunc(main_source_vvvvvzi)
{
	// set the function logic
	if (main_source_vvvvvzi == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		// add required attribute to db_selection field
		if (jform_vvvvvzjvze_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzjvze_required = false;
		}
	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		// remove required attribute from db_selection field
		if (!jform_vvvvvzjvze_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzjvze_required = true;
		}
	}
}

// the vvvvvzj Some function
function main_source_vvvvvzj_SomeFunc(main_source_vvvvvzj)
{
	// set the function logic
	if (main_source_vvvvvzj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzk function
function vvvvvzk(addcalculation_vvvvvzk)
{
	// set the function logic
	if (addcalculation_vvvvvzk == 1)
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').show();
		// add required attribute to php_calculation field
		if (jform_vvvvvzkvzf_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvzkvzf_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_calculation-lbl').closest('.control-group').hide();
		// remove required attribute from php_calculation field
		if (!jform_vvvvvzkvzf_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvzkvzf_required = true;
		}
	}
}

// the vvvvvzl function
function vvvvvzl(addcalculation_vvvvvzl,gettype_vvvvvzl)
{
	if (isSet(addcalculation_vvvvvzl) && addcalculation_vvvvvzl.constructor !== Array)
	{
		var temp_vvvvvzl = addcalculation_vvvvvzl;
		var addcalculation_vvvvvzl = [];
		addcalculation_vvvvvzl.push(temp_vvvvvzl);
	}
	else if (!isSet(addcalculation_vvvvvzl))
	{
		var addcalculation_vvvvvzl = [];
	}
	var addcalculation = addcalculation_vvvvvzl.some(addcalculation_vvvvvzl_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvzl Some function
function addcalculation_vvvvvzl_SomeFunc(addcalculation_vvvvvzl)
{
	// set the function logic
	if (addcalculation_vvvvvzl == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzl Some function
function gettype_vvvvvzl_SomeFunc(gettype_vvvvvzl)
{
	// set the function logic
	if (gettype_vvvvvzl == 1 || gettype_vvvvvzl == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzm function
function vvvvvzm(addcalculation_vvvvvzm,gettype_vvvvvzm)
{
	if (isSet(addcalculation_vvvvvzm) && addcalculation_vvvvvzm.constructor !== Array)
	{
		var temp_vvvvvzm = addcalculation_vvvvvzm;
		var addcalculation_vvvvvzm = [];
		addcalculation_vvvvvzm.push(temp_vvvvvzm);
	}
	else if (!isSet(addcalculation_vvvvvzm))
	{
		var addcalculation_vvvvvzm = [];
	}
	var addcalculation = addcalculation_vvvvvzm.some(addcalculation_vvvvvzm_SomeFunc);

	if (isSet(gettype_vvvvvzm) && gettype_vvvvvzm.constructor !== Array)
	{
		var temp_vvvvvzm = gettype_vvvvvzm;
		var gettype_vvvvvzm = [];
		gettype_vvvvvzm.push(temp_vvvvvzm);
	}
	else if (!isSet(gettype_vvvvvzm))
	{
		var gettype_vvvvvzm = [];
	}
	var gettype = gettype_vvvvvzm.some(gettype_vvvvvzm_SomeFunc);


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

// the vvvvvzm Some function
function addcalculation_vvvvvzm_SomeFunc(addcalculation_vvvvvzm)
{
	// set the function logic
	if (addcalculation_vvvvvzm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzm Some function
function gettype_vvvvvzm_SomeFunc(gettype_vvvvvzm)
{
	// set the function logic
	if (gettype_vvvvvzm == 2 || gettype_vvvvvzm == 4)
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
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').show();
		// add required attribute to php_custom_get field
		if (jform_vvvvvzpvzg_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzpvzg_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_custom_get-lbl').closest('.control-group').hide();
		// remove required attribute from php_custom_get field
		if (!jform_vvvvvzpvzg_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzpvzg_required = true;
		}
	}
}

// the vvvvvzp Some function
function main_source_vvvvvzp_SomeFunc(main_source_vvvvvzp)
{
	// set the function logic
	if (main_source_vvvvvzp == 3)
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

// the vvvvvzq Some function
function main_source_vvvvvzq_SomeFunc(main_source_vvvvvzq)
{
	// set the function logic
	if (main_source_vvvvvzq == 1 || main_source_vvvvvzq == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzr function
function vvvvvzr(add_php_before_getitem_vvvvvzr,gettype_vvvvvzr)
{
	if (isSet(add_php_before_getitem_vvvvvzr) && add_php_before_getitem_vvvvvzr.constructor !== Array)
	{
		var temp_vvvvvzr = add_php_before_getitem_vvvvvzr;
		var add_php_before_getitem_vvvvvzr = [];
		add_php_before_getitem_vvvvvzr.push(temp_vvvvvzr);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzr))
	{
		var add_php_before_getitem_vvvvvzr = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzr.some(add_php_before_getitem_vvvvvzr_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').show();
		// add required attribute to php_before_getitem field
		if (jform_vvvvvzrvzh_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzrvzh_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_before_getitem-lbl').closest('.control-group').hide();
		// remove required attribute from php_before_getitem field
		if (!jform_vvvvvzrvzh_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzrvzh_required = true;
		}
	}
}

// the vvvvvzr Some function
function add_php_before_getitem_vvvvvzr_SomeFunc(add_php_before_getitem_vvvvvzr)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzr == 1)
	{
		return true;
	}
	return false;
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
function vvvvvzs(add_php_after_getitem_vvvvvzs,gettype_vvvvvzs)
{
	if (isSet(add_php_after_getitem_vvvvvzs) && add_php_after_getitem_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = add_php_after_getitem_vvvvvzs;
		var add_php_after_getitem_vvvvvzs = [];
		add_php_after_getitem_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzs))
	{
		var add_php_after_getitem_vvvvvzs = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzs.some(add_php_after_getitem_vvvvvzs_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').show();
		// add required attribute to php_after_getitem field
		if (jform_vvvvvzsvzi_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzsvzi_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_after_getitem-lbl').closest('.control-group').hide();
		// remove required attribute from php_after_getitem field
		if (!jform_vvvvvzsvzi_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzsvzi_required = true;
		}
	}
}

// the vvvvvzs Some function
function add_php_after_getitem_vvvvvzs_SomeFunc(add_php_after_getitem_vvvvvzs)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzs == 1)
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

// the vvvvvzu function
function vvvvvzu(gettype_vvvvvzu)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		// add required attribute to add_php_after_getitem field
		if (jform_vvvvvzuvzj_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzuvzj_required = false;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		// add required attribute to add_php_before_getitem field
		if (jform_vvvvvzuvzk_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzuvzk_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitem field
		if (!jform_vvvvvzuvzj_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzuvzj_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitem field
		if (!jform_vvvvvzuvzk_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzuvzk_required = true;
		}
	}
}

// the vvvvvzu Some function
function gettype_vvvvvzu_SomeFunc(gettype_vvvvvzu)
{
	// set the function logic
	if (gettype_vvvvvzu == 1 || gettype_vvvvvzu == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzv function
function vvvvvzv(add_php_getlistquery_vvvvvzv,gettype_vvvvvzv)
{
	if (isSet(add_php_getlistquery_vvvvvzv) && add_php_getlistquery_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = add_php_getlistquery_vvvvvzv;
		var add_php_getlistquery_vvvvvzv = [];
		add_php_getlistquery_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzv))
	{
		var add_php_getlistquery_vvvvvzv = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzv.some(add_php_getlistquery_vvvvvzv_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').show();
		// add required attribute to php_getlistquery field
		if (jform_vvvvvzvvzl_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzvvzl_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_getlistquery-lbl').closest('.control-group').hide();
		// remove required attribute from php_getlistquery field
		if (!jform_vvvvvzvvzl_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzvvzl_required = true;
		}
	}
}

// the vvvvvzv Some function
function add_php_getlistquery_vvvvvzv_SomeFunc(add_php_getlistquery_vvvvvzv)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzv == 1)
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

// the vvvvvzw function
function vvvvvzw(add_php_before_getitems_vvvvvzw,gettype_vvvvvzw)
{
	if (isSet(add_php_before_getitems_vvvvvzw) && add_php_before_getitems_vvvvvzw.constructor !== Array)
	{
		var temp_vvvvvzw = add_php_before_getitems_vvvvvzw;
		var add_php_before_getitems_vvvvvzw = [];
		add_php_before_getitems_vvvvvzw.push(temp_vvvvvzw);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzw))
	{
		var add_php_before_getitems_vvvvvzw = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzw.some(add_php_before_getitems_vvvvvzw_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').show();
		// add required attribute to php_before_getitems field
		if (jform_vvvvvzwvzm_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzwvzm_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_before_getitems-lbl').closest('.control-group').hide();
		// remove required attribute from php_before_getitems field
		if (!jform_vvvvvzwvzm_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzwvzm_required = true;
		}
	}
}

// the vvvvvzw Some function
function add_php_before_getitems_vvvvvzw_SomeFunc(add_php_before_getitems_vvvvvzw)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzw == 1)
	{
		return true;
	}
	return false;
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
function vvvvvzx(add_php_after_getitems_vvvvvzx,gettype_vvvvvzx)
{
	if (isSet(add_php_after_getitems_vvvvvzx) && add_php_after_getitems_vvvvvzx.constructor !== Array)
	{
		var temp_vvvvvzx = add_php_after_getitems_vvvvvzx;
		var add_php_after_getitems_vvvvvzx = [];
		add_php_after_getitems_vvvvvzx.push(temp_vvvvvzx);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzx))
	{
		var add_php_after_getitems_vvvvvzx = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzx.some(add_php_after_getitems_vvvvvzx_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').show();
		// add required attribute to php_after_getitems field
		if (jform_vvvvvzxvzn_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzxvzn_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_after_getitems-lbl').closest('.control-group').hide();
		// remove required attribute from php_after_getitems field
		if (!jform_vvvvvzxvzn_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzxvzn_required = true;
		}
	}
}

// the vvvvvzx Some function
function add_php_after_getitems_vvvvvzx_SomeFunc(add_php_after_getitems_vvvvvzx)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzx == 1)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		// add required attribute to add_php_after_getitems field
		if (jform_vvvvvzzvzo_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzzvzo_required = false;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		// add required attribute to add_php_before_getitems field
		if (jform_vvvvvzzvzp_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzzvzp_required = false;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		// add required attribute to add_php_getlistquery field
		if (jform_vvvvvzzvzq_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzzvzq_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_after_getitems field
		if (!jform_vvvvvzzvzo_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzzvzo_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		// remove required attribute from add_php_before_getitems field
		if (!jform_vvvvvzzvzp_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzzvzp_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		// remove required attribute from add_php_getlistquery field
		if (!jform_vvvvvzzvzq_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzzvzq_required = true;
		}
	}
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
function vvvvwaa(gettype_vvvvwaa)
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


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		// add required attribute to pagination field
		if (jform_vvvvwaavzr_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvwaavzr_required = false;
		}
	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		// remove required attribute from pagination field
		if (!jform_vvvvwaavzr_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvwaavzr_required = true;
		}
	}
}

// the vvvvwaa Some function
function gettype_vvvvwaa_SomeFunc(gettype_vvvvwaa)
{
	// set the function logic
	if (gettype_vvvvwaa == 2)
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
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		// add required attribute to add_php_router_parse field
		if (jform_vvvvwabvzs_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvwabvzs_required = false;
		}
	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		// remove required attribute from add_php_router_parse field
		if (!jform_vvvvwabvzs_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvwabvzs_required = true;
		}
	}
}

// the vvvvwab Some function
function gettype_vvvvwab_SomeFunc(gettype_vvvvwab)
{
	// set the function logic
	if (gettype_vvvvwab == 1 || gettype_vvvvwab == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwac function
function vvvvwac(gettype_vvvvwac,add_php_router_parse_vvvvwac)
{
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

	if (isSet(add_php_router_parse_vvvvwac) && add_php_router_parse_vvvvwac.constructor !== Array)
	{
		var temp_vvvvwac = add_php_router_parse_vvvvwac;
		var add_php_router_parse_vvvvwac = [];
		add_php_router_parse_vvvvwac.push(temp_vvvvwac);
	}
	else if (!isSet(add_php_router_parse_vvvvwac))
	{
		var add_php_router_parse_vvvvwac = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvwac.some(add_php_router_parse_vvvvwac_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		// add required attribute to php_router_parse field
		if (jform_vvvvwacvzt_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvwacvzt_required = false;
		}
	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		// remove required attribute from php_router_parse field
		if (!jform_vvvvwacvzt_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvwacvzt_required = true;
		}
	}
}

// the vvvvwac Some function
function gettype_vvvvwac_SomeFunc(gettype_vvvvwac)
{
	// set the function logic
	if (gettype_vvvvwac == 1 || gettype_vvvvwac == 2)
	{
		return true;
	}
	return false;
}

// the vvvvwac Some function
function add_php_router_parse_vvvvwac_SomeFunc(add_php_router_parse_vvvvwac)
{
	// set the function logic
	if (add_php_router_parse_vvvvwac == 1)
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
		jQuery('#jform_plugin_events').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_plugin_events').closest('.control-group').hide();
	}
}

// the vvvvwae Some function
function gettype_vvvvwae_SomeFunc(gettype_vvvvwae)
{
	// set the function logic
	if (gettype_vvvvwae == 1)
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.viewTableColumns&format=json&raw=true";
	if (token.length > 0 && viewId > 0 && asKey.length > 0)
	{
		var request = 'token='+token+'&as='+asKey+'&type='+rowType+'&id='+viewId;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.dbTableColumns&format=json&raw=true";
	if (token.length > 0 && name.length > 0 && asKey.length > 0)
	{
		var request = 'token='+token+'&as='+asKey+'&type='+rowType+'&name='+name;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getDynamicScripts&format=json&raw=true&vdm="+vastDevMod;
	if(token.length > 0 && typpe.length > 0){
		var request = 'token='+token+'&type='+typpe;
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getEditCustomCodeButtons&format=json&raw=true&vdm="+vastDevMod;
	if(token.length > 0 && id > 0){
		var request = 'token='+token+'&id='+id+'&return_here='+return_here;
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
				jQuery('<div class="control-group"><div class="control-label"><label>Edit Customcode</label></div><div class="controls control-customcode-buttons-'+field+'"></div></div>').insertBefore(".control-wrapper-"+ field);
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
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&raw=true&vdm="+vastDevMod;
	if(token.length > 0 && type > 0){
		var request = 'token='+token+'&type='+type;
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
