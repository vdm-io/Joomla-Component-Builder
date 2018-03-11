/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvzavyv_required = false;
jform_vvvvvzbvyw_required = false;
jform_vvvvvzcvyx_required = false;
jform_vvvvvzdvyy_required = false;
jform_vvvvvzevyz_required = false;
jform_vvvvvzfvza_required = false;
jform_vvvvvzkvzb_required = false;
jform_vvvvvzmvzc_required = false;
jform_vvvvvznvzd_required = false;
jform_vvvvvzpvze_required = false;
jform_vvvvvzpvzf_required = false;
jform_vvvvvzqvzg_required = false;
jform_vvvvvzrvzh_required = false;
jform_vvvvvzsvzi_required = false;
jform_vvvvvzuvzj_required = false;
jform_vvvvvzuvzk_required = false;
jform_vvvvvzuvzl_required = false;
jform_vvvvvzvvzm_required = false;
jform_vvvvvzwvzn_required = false;
jform_vvvvvzxvzo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvza = jQuery("#jform_gettype").val();
	vvvvvza(gettype_vvvvvza);

	var main_source_vvvvvzb = jQuery("#jform_main_source").val();
	vvvvvzb(main_source_vvvvvzb);

	var main_source_vvvvvzc = jQuery("#jform_main_source").val();
	vvvvvzc(main_source_vvvvvzc);

	var main_source_vvvvvzd = jQuery("#jform_main_source").val();
	vvvvvzd(main_source_vvvvvzd);

	var main_source_vvvvvze = jQuery("#jform_main_source").val();
	vvvvvze(main_source_vvvvvze);

	var addcalculation_vvvvvzf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzf(addcalculation_vvvvvzf);

	var addcalculation_vvvvvzg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(addcalculation_vvvvvzg,gettype_vvvvvzg);

	var addcalculation_vvvvvzh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(addcalculation_vvvvvzh,gettype_vvvvvzh);

	var main_source_vvvvvzk = jQuery("#jform_main_source").val();
	vvvvvzk(main_source_vvvvvzk);

	var main_source_vvvvvzl = jQuery("#jform_main_source").val();
	vvvvvzl(main_source_vvvvvzl);

	var add_php_before_getitem_vvvvvzm = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_before_getitem_vvvvvzm,gettype_vvvvvzm);

	var add_php_after_getitem_vvvvvzn = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(add_php_after_getitem_vvvvvzn,gettype_vvvvvzn);

	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(gettype_vvvvvzp);

	var add_php_getlistquery_vvvvvzq = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(add_php_getlistquery_vvvvvzq,gettype_vvvvvzq);

	var add_php_before_getitems_vvvvvzr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzr = jQuery("#jform_gettype").val();
	vvvvvzr(add_php_before_getitems_vvvvvzr,gettype_vvvvvzr);

	var add_php_after_getitems_vvvvvzs = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(add_php_after_getitems_vvvvvzs,gettype_vvvvvzs);

	var gettype_vvvvvzu = jQuery("#jform_gettype").val();
	vvvvvzu(gettype_vvvvvzu);

	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	vvvvvzv(gettype_vvvvvzv);

	var gettype_vvvvvzw = jQuery("#jform_gettype").val();
	vvvvvzw(gettype_vvvvvzw);

	var gettype_vvvvvzx = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvvzx = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvvzx(gettype_vvvvvzx,add_php_router_parse_vvvvvzx);
});

// the vvvvvza function
function vvvvvza(gettype_vvvvvza)
{
	if (isSet(gettype_vvvvvza) && gettype_vvvvvza.constructor !== Array)
	{
		var temp_vvvvvza = gettype_vvvvvza;
		var gettype_vvvvvza = [];
		gettype_vvvvvza.push(temp_vvvvvza);
	}
	else if (!isSet(gettype_vvvvvza))
	{
		var gettype_vvvvvza = [];
	}
	var gettype = gettype_vvvvvza.some(gettype_vvvvvza_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvzavyv_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvzavyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvzavyv_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvzavyv_required = true;
		}
	}
}

// the vvvvvza Some function
function gettype_vvvvvza_SomeFunc(gettype_vvvvvza)
{
	// set the function logic
	if (gettype_vvvvvza == 3 || gettype_vvvvvza == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzb function
function vvvvvzb(main_source_vvvvvzb)
{
	if (isSet(main_source_vvvvvzb) && main_source_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = main_source_vvvvvzb;
		var main_source_vvvvvzb = [];
		main_source_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(main_source_vvvvvzb))
	{
		var main_source_vvvvvzb = [];
	}
	var main_source = main_source_vvvvvzb.some(main_source_vvvvvzb_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvzbvyw_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvzbvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzbvyw_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvzbvyw_required = true;
		}
	}
}

// the vvvvvzb Some function
function main_source_vvvvvzb_SomeFunc(main_source_vvvvvzb)
{
	// set the function logic
	if (main_source_vvvvvzb == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvzcvyx_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzcvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvzcvyx_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzcvyx_required = true;
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvzdvyy_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzdvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzdvyy_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvzdvyy_required = true;
		}
	}
}

// the vvvvvzd Some function
function main_source_vvvvvzd_SomeFunc(main_source_vvvvvzd)
{
	// set the function logic
	if (main_source_vvvvvzd == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvzevyz_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzevyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvzevyz_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzevyz_required = true;
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
function vvvvvzf(addcalculation_vvvvvzf)
{
	// set the function logic
	if (addcalculation_vvvvvzf == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvzfvza_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvzfvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvzfvza_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvzfvza_required = true;
		}
	}
}

// the vvvvvzg function
function vvvvvzg(addcalculation_vvvvvzg,gettype_vvvvvzg)
{
	if (isSet(addcalculation_vvvvvzg) && addcalculation_vvvvvzg.constructor !== Array)
	{
		var temp_vvvvvzg = addcalculation_vvvvvzg;
		var addcalculation_vvvvvzg = [];
		addcalculation_vvvvvzg.push(temp_vvvvvzg);
	}
	else if (!isSet(addcalculation_vvvvvzg))
	{
		var addcalculation_vvvvvzg = [];
	}
	var addcalculation = addcalculation_vvvvvzg.some(addcalculation_vvvvvzg_SomeFunc);

	if (isSet(gettype_vvvvvzg) && gettype_vvvvvzg.constructor !== Array)
	{
		var temp_vvvvvzg = gettype_vvvvvzg;
		var gettype_vvvvvzg = [];
		gettype_vvvvvzg.push(temp_vvvvvzg);
	}
	else if (!isSet(gettype_vvvvvzg))
	{
		var gettype_vvvvvzg = [];
	}
	var gettype = gettype_vvvvvzg.some(gettype_vvvvvzg_SomeFunc);


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

// the vvvvvzg Some function
function addcalculation_vvvvvzg_SomeFunc(addcalculation_vvvvvzg)
{
	// set the function logic
	if (addcalculation_vvvvvzg == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzg Some function
function gettype_vvvvvzg_SomeFunc(gettype_vvvvvzg)
{
	// set the function logic
	if (gettype_vvvvvzg == 1 || gettype_vvvvvzg == 3)
	{
		return true;
	}
	return false;
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
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
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
	if (gettype_vvvvvzh == 2 || gettype_vvvvvzh == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzkvzb_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzkvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzkvzb_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzkvzb_required = true;
		}
	}
}

// the vvvvvzk Some function
function main_source_vvvvvzk_SomeFunc(main_source_vvvvvzk)
{
	// set the function logic
	if (main_source_vvvvvzk == 3)
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

// the vvvvvzl Some function
function main_source_vvvvvzl_SomeFunc(main_source_vvvvvzl)
{
	// set the function logic
	if (main_source_vvvvvzl == 1 || main_source_vvvvvzl == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzm function
function vvvvvzm(add_php_before_getitem_vvvvvzm,gettype_vvvvvzm)
{
	if (isSet(add_php_before_getitem_vvvvvzm) && add_php_before_getitem_vvvvvzm.constructor !== Array)
	{
		var temp_vvvvvzm = add_php_before_getitem_vvvvvzm;
		var add_php_before_getitem_vvvvvzm = [];
		add_php_before_getitem_vvvvvzm.push(temp_vvvvvzm);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzm))
	{
		var add_php_before_getitem_vvvvvzm = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzm.some(add_php_before_getitem_vvvvvzm_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzmvzc_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzmvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzmvzc_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzmvzc_required = true;
		}
	}
}

// the vvvvvzm Some function
function add_php_before_getitem_vvvvvzm_SomeFunc(add_php_before_getitem_vvvvvzm)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzm == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzm Some function
function gettype_vvvvvzm_SomeFunc(gettype_vvvvvzm)
{
	// set the function logic
	if (gettype_vvvvvzm == 1 || gettype_vvvvvzm == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzn function
function vvvvvzn(add_php_after_getitem_vvvvvzn,gettype_vvvvvzn)
{
	if (isSet(add_php_after_getitem_vvvvvzn) && add_php_after_getitem_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = add_php_after_getitem_vvvvvzn;
		var add_php_after_getitem_vvvvvzn = [];
		add_php_after_getitem_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzn))
	{
		var add_php_after_getitem_vvvvvzn = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzn.some(add_php_after_getitem_vvvvvzn_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvznvzd_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvznvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvznvzd_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvznvzd_required = true;
		}
	}
}

// the vvvvvzn Some function
function add_php_after_getitem_vvvvvzn_SomeFunc(add_php_after_getitem_vvvvvzn)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzn == 1)
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

// the vvvvvzp function
function vvvvvzp(gettype_vvvvvzp)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzpvze_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzpvze_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzpvzf_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzpvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzpvze_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzpvze_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzpvzf_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzpvzf_required = true;
		}
	}
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
function vvvvvzq(add_php_getlistquery_vvvvvzq,gettype_vvvvvzq)
{
	if (isSet(add_php_getlistquery_vvvvvzq) && add_php_getlistquery_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = add_php_getlistquery_vvvvvzq;
		var add_php_getlistquery_vvvvvzq = [];
		add_php_getlistquery_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzq))
	{
		var add_php_getlistquery_vvvvvzq = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzq.some(add_php_getlistquery_vvvvvzq_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzqvzg_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzqvzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzqvzg_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzqvzg_required = true;
		}
	}
}

// the vvvvvzq Some function
function add_php_getlistquery_vvvvvzq_SomeFunc(add_php_getlistquery_vvvvvzq)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzq == 1)
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

// the vvvvvzr function
function vvvvvzr(add_php_before_getitems_vvvvvzr,gettype_vvvvvzr)
{
	if (isSet(add_php_before_getitems_vvvvvzr) && add_php_before_getitems_vvvvvzr.constructor !== Array)
	{
		var temp_vvvvvzr = add_php_before_getitems_vvvvvzr;
		var add_php_before_getitems_vvvvvzr = [];
		add_php_before_getitems_vvvvvzr.push(temp_vvvvvzr);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzr))
	{
		var add_php_before_getitems_vvvvvzr = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzr.some(add_php_before_getitems_vvvvvzr_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzrvzh_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzrvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzrvzh_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzrvzh_required = true;
		}
	}
}

// the vvvvvzr Some function
function add_php_before_getitems_vvvvvzr_SomeFunc(add_php_before_getitems_vvvvvzr)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzr == 1)
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
function vvvvvzs(add_php_after_getitems_vvvvvzs,gettype_vvvvvzs)
{
	if (isSet(add_php_after_getitems_vvvvvzs) && add_php_after_getitems_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = add_php_after_getitems_vvvvvzs;
		var add_php_after_getitems_vvvvvzs = [];
		add_php_after_getitems_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzs))
	{
		var add_php_after_getitems_vvvvvzs = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzs.some(add_php_after_getitems_vvvvvzs_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzsvzi_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzsvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzsvzi_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzsvzi_required = true;
		}
	}
}

// the vvvvvzs Some function
function add_php_after_getitems_vvvvvzs_SomeFunc(add_php_after_getitems_vvvvvzs)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzs == 1)
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzuvzj_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzuvzj_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzuvzk_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzuvzk_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzuvzl_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzuvzl_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzuvzj_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzuvzj_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzuvzk_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzuvzk_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzuvzl_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzuvzl_required = true;
		}
	}
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzvvzm_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzvvzm_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzvvzm_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzvvzm_required = true;
		}
	}
}

// the vvvvvzv Some function
function gettype_vvvvvzv_SomeFunc(gettype_vvvvvzv)
{
	// set the function logic
	if (gettype_vvvvvzv == 2)
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
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzwvzn_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvvzwvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzwvzn_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvvzwvzn_required = true;
		}
	}
}

// the vvvvvzw Some function
function gettype_vvvvvzw_SomeFunc(gettype_vvvvvzw)
{
	// set the function logic
	if (gettype_vvvvvzw == 1 || gettype_vvvvvzw == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzx function
function vvvvvzx(gettype_vvvvvzx,add_php_router_parse_vvvvvzx)
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

	if (isSet(add_php_router_parse_vvvvvzx) && add_php_router_parse_vvvvvzx.constructor !== Array)
	{
		var temp_vvvvvzx = add_php_router_parse_vvvvvzx;
		var add_php_router_parse_vvvvvzx = [];
		add_php_router_parse_vvvvvzx.push(temp_vvvvvzx);
	}
	else if (!isSet(add_php_router_parse_vvvvvzx))
	{
		var add_php_router_parse_vvvvvzx = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvvzx.some(add_php_router_parse_vvvvvzx_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzxvzo_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvvzxvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzxvzo_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvvzxvzo_required = true;
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

// the vvvvvzx Some function
function add_php_router_parse_vvvvvzx_SomeFunc(add_php_router_parse_vvvvvzx)
{
	// set the function logic
	if (add_php_router_parse_vvvvvzx == 1)
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
