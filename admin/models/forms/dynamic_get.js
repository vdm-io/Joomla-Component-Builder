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
jform_vvvvvywvys_required = false;
jform_vvvvvyxvyt_required = false;
jform_vvvvvyyvyu_required = false;
jform_vvvvvyzvyv_required = false;
jform_vvvvvzavyw_required = false;
jform_vvvvvzbvyx_required = false;
jform_vvvvvzgvyy_required = false;
jform_vvvvvzivyz_required = false;
jform_vvvvvzjvza_required = false;
jform_vvvvvzlvzb_required = false;
jform_vvvvvzlvzc_required = false;
jform_vvvvvzmvzd_required = false;
jform_vvvvvznvze_required = false;
jform_vvvvvzovzf_required = false;
jform_vvvvvzqvzg_required = false;
jform_vvvvvzqvzh_required = false;
jform_vvvvvzqvzi_required = false;
jform_vvvvvzrvzj_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyw = jQuery("#jform_gettype").val();
	vvvvvyw(gettype_vvvvvyw);

	var main_source_vvvvvyx = jQuery("#jform_main_source").val();
	vvvvvyx(main_source_vvvvvyx);

	var main_source_vvvvvyy = jQuery("#jform_main_source").val();
	vvvvvyy(main_source_vvvvvyy);

	var main_source_vvvvvyz = jQuery("#jform_main_source").val();
	vvvvvyz(main_source_vvvvvyz);

	var main_source_vvvvvza = jQuery("#jform_main_source").val();
	vvvvvza(main_source_vvvvvza);

	var addcalculation_vvvvvzb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzb(addcalculation_vvvvvzb);

	var addcalculation_vvvvvzc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(addcalculation_vvvvvzc,gettype_vvvvvzc);

	var addcalculation_vvvvvzd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(addcalculation_vvvvvzd,gettype_vvvvvzd);

	var main_source_vvvvvzg = jQuery("#jform_main_source").val();
	vvvvvzg(main_source_vvvvvzg);

	var main_source_vvvvvzh = jQuery("#jform_main_source").val();
	vvvvvzh(main_source_vvvvvzh);

	var add_php_before_getitem_vvvvvzi = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_before_getitem_vvvvvzi,gettype_vvvvvzi);

	var add_php_after_getitem_vvvvvzj = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_after_getitem_vvvvvzj,gettype_vvvvvzj);

	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(gettype_vvvvvzl);

	var add_php_getlistquery_vvvvvzm = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_getlistquery_vvvvvzm,gettype_vvvvvzm);

	var add_php_before_getitems_vvvvvzn = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(add_php_before_getitems_vvvvvzn,gettype_vvvvvzn);

	var add_php_after_getitems_vvvvvzo = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_after_getitems_vvvvvzo,gettype_vvvvvzo);

	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(gettype_vvvvvzq);

	var gettype_vvvvvzr = jQuery("#jform_gettype").val();
	vvvvvzr(gettype_vvvvvzr);
});

// the vvvvvyw function
function vvvvvyw(gettype_vvvvvyw)
{
	if (isSet(gettype_vvvvvyw) && gettype_vvvvvyw.constructor !== Array)
	{
		var temp_vvvvvyw = gettype_vvvvvyw;
		var gettype_vvvvvyw = [];
		gettype_vvvvvyw.push(temp_vvvvvyw);
	}
	else if (!isSet(gettype_vvvvvyw))
	{
		var gettype_vvvvvyw = [];
	}
	var gettype = gettype_vvvvvyw.some(gettype_vvvvvyw_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvywvys_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvywvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvywvys_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvywvys_required = true;
		}
	}
}

// the vvvvvyw Some function
function gettype_vvvvvyw_SomeFunc(gettype_vvvvvyw)
{
	// set the function logic
	if (gettype_vvvvvyw == 3 || gettype_vvvvvyw == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyx function
function vvvvvyx(main_source_vvvvvyx)
{
	if (isSet(main_source_vvvvvyx) && main_source_vvvvvyx.constructor !== Array)
	{
		var temp_vvvvvyx = main_source_vvvvvyx;
		var main_source_vvvvvyx = [];
		main_source_vvvvvyx.push(temp_vvvvvyx);
	}
	else if (!isSet(main_source_vvvvvyx))
	{
		var main_source_vvvvvyx = [];
	}
	var main_source = main_source_vvvvvyx.some(main_source_vvvvvyx_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvyxvyt_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvyxvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyxvyt_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvyxvyt_required = true;
		}
	}
}

// the vvvvvyx Some function
function main_source_vvvvvyx_SomeFunc(main_source_vvvvvyx)
{
	// set the function logic
	if (main_source_vvvvvyx == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyy function
function vvvvvyy(main_source_vvvvvyy)
{
	if (isSet(main_source_vvvvvyy) && main_source_vvvvvyy.constructor !== Array)
	{
		var temp_vvvvvyy = main_source_vvvvvyy;
		var main_source_vvvvvyy = [];
		main_source_vvvvvyy.push(temp_vvvvvyy);
	}
	else if (!isSet(main_source_vvvvvyy))
	{
		var main_source_vvvvvyy = [];
	}
	var main_source = main_source_vvvvvyy.some(main_source_vvvvvyy_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvyyvyu_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvyyvyu_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvyyvyu_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvyyvyu_required = true;
		}
	}
}

// the vvvvvyy Some function
function main_source_vvvvvyy_SomeFunc(main_source_vvvvvyy)
{
	// set the function logic
	if (main_source_vvvvvyy == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyz function
function vvvvvyz(main_source_vvvvvyz)
{
	if (isSet(main_source_vvvvvyz) && main_source_vvvvvyz.constructor !== Array)
	{
		var temp_vvvvvyz = main_source_vvvvvyz;
		var main_source_vvvvvyz = [];
		main_source_vvvvvyz.push(temp_vvvvvyz);
	}
	else if (!isSet(main_source_vvvvvyz))
	{
		var main_source_vvvvvyz = [];
	}
	var main_source = main_source_vvvvvyz.some(main_source_vvvvvyz_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvyzvyv_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvyzvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyzvyv_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvyzvyv_required = true;
		}
	}
}

// the vvvvvyz Some function
function main_source_vvvvvyz_SomeFunc(main_source_vvvvvyz)
{
	// set the function logic
	if (main_source_vvvvvyz == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvza function
function vvvvvza(main_source_vvvvvza)
{
	if (isSet(main_source_vvvvvza) && main_source_vvvvvza.constructor !== Array)
	{
		var temp_vvvvvza = main_source_vvvvvza;
		var main_source_vvvvvza = [];
		main_source_vvvvvza.push(temp_vvvvvza);
	}
	else if (!isSet(main_source_vvvvvza))
	{
		var main_source_vvvvvza = [];
	}
	var main_source = main_source_vvvvvza.some(main_source_vvvvvza_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvzavyw_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzavyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvzavyw_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzavyw_required = true;
		}
	}
}

// the vvvvvza Some function
function main_source_vvvvvza_SomeFunc(main_source_vvvvvza)
{
	// set the function logic
	if (main_source_vvvvvza == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzb function
function vvvvvzb(addcalculation_vvvvvzb)
{
	// set the function logic
	if (addcalculation_vvvvvzb == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvzbvyx_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvzbvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvzbvyx_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvzbvyx_required = true;
		}
	}
}

// the vvvvvzc function
function vvvvvzc(addcalculation_vvvvvzc,gettype_vvvvvzc)
{
	if (isSet(addcalculation_vvvvvzc) && addcalculation_vvvvvzc.constructor !== Array)
	{
		var temp_vvvvvzc = addcalculation_vvvvvzc;
		var addcalculation_vvvvvzc = [];
		addcalculation_vvvvvzc.push(temp_vvvvvzc);
	}
	else if (!isSet(addcalculation_vvvvvzc))
	{
		var addcalculation_vvvvvzc = [];
	}
	var addcalculation = addcalculation_vvvvvzc.some(addcalculation_vvvvvzc_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvzc Some function
function addcalculation_vvvvvzc_SomeFunc(addcalculation_vvvvvzc)
{
	// set the function logic
	if (addcalculation_vvvvvzc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzc Some function
function gettype_vvvvvzc_SomeFunc(gettype_vvvvvzc)
{
	// set the function logic
	if (gettype_vvvvvzc == 1 || gettype_vvvvvzc == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(addcalculation_vvvvvzd,gettype_vvvvvzd)
{
	if (isSet(addcalculation_vvvvvzd) && addcalculation_vvvvvzd.constructor !== Array)
	{
		var temp_vvvvvzd = addcalculation_vvvvvzd;
		var addcalculation_vvvvvzd = [];
		addcalculation_vvvvvzd.push(temp_vvvvvzd);
	}
	else if (!isSet(addcalculation_vvvvvzd))
	{
		var addcalculation_vvvvvzd = [];
	}
	var addcalculation = addcalculation_vvvvvzd.some(addcalculation_vvvvvzd_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
	}
}

// the vvvvvzd Some function
function addcalculation_vvvvvzd_SomeFunc(addcalculation_vvvvvzd)
{
	// set the function logic
	if (addcalculation_vvvvvzd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzd Some function
function gettype_vvvvvzd_SomeFunc(gettype_vvvvvzd)
{
	// set the function logic
	if (gettype_vvvvvzd == 2 || gettype_vvvvvzd == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzgvyy_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzgvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzgvyy_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzgvyy_required = true;
		}
	}
}

// the vvvvvzg Some function
function main_source_vvvvvzg_SomeFunc(main_source_vvvvvzg)
{
	// set the function logic
	if (main_source_vvvvvzg == 3)
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

// the vvvvvzh Some function
function main_source_vvvvvzh_SomeFunc(main_source_vvvvvzh)
{
	// set the function logic
	if (main_source_vvvvvzh == 1 || main_source_vvvvvzh == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzi function
function vvvvvzi(add_php_before_getitem_vvvvvzi,gettype_vvvvvzi)
{
	if (isSet(add_php_before_getitem_vvvvvzi) && add_php_before_getitem_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = add_php_before_getitem_vvvvvzi;
		var add_php_before_getitem_vvvvvzi = [];
		add_php_before_getitem_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzi))
	{
		var add_php_before_getitem_vvvvvzi = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzi.some(add_php_before_getitem_vvvvvzi_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzivyz_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzivyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzivyz_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzivyz_required = true;
		}
	}
}

// the vvvvvzi Some function
function add_php_before_getitem_vvvvvzi_SomeFunc(add_php_before_getitem_vvvvvzi)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzi == 1)
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
function vvvvvzj(add_php_after_getitem_vvvvvzj,gettype_vvvvvzj)
{
	if (isSet(add_php_after_getitem_vvvvvzj) && add_php_after_getitem_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = add_php_after_getitem_vvvvvzj;
		var add_php_after_getitem_vvvvvzj = [];
		add_php_after_getitem_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzj))
	{
		var add_php_after_getitem_vvvvvzj = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzj.some(add_php_after_getitem_vvvvvzj_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzjvza_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzjvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzjvza_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzjvza_required = true;
		}
	}
}

// the vvvvvzj Some function
function add_php_after_getitem_vvvvvzj_SomeFunc(add_php_after_getitem_vvvvvzj)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzj == 1)
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
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzlvzb_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzlvzb_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzlvzc_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzlvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzlvzb_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzlvzb_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzlvzc_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzlvzc_required = true;
		}
	}
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
function vvvvvzm(add_php_getlistquery_vvvvvzm,gettype_vvvvvzm)
{
	if (isSet(add_php_getlistquery_vvvvvzm) && add_php_getlistquery_vvvvvzm.constructor !== Array)
	{
		var temp_vvvvvzm = add_php_getlistquery_vvvvvzm;
		var add_php_getlistquery_vvvvvzm = [];
		add_php_getlistquery_vvvvvzm.push(temp_vvvvvzm);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzm))
	{
		var add_php_getlistquery_vvvvvzm = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzm.some(add_php_getlistquery_vvvvvzm_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzmvzd_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzmvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzmvzd_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzmvzd_required = true;
		}
	}
}

// the vvvvvzm Some function
function add_php_getlistquery_vvvvvzm_SomeFunc(add_php_getlistquery_vvvvvzm)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzm == 1)
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

// the vvvvvzn function
function vvvvvzn(add_php_before_getitems_vvvvvzn,gettype_vvvvvzn)
{
	if (isSet(add_php_before_getitems_vvvvvzn) && add_php_before_getitems_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = add_php_before_getitems_vvvvvzn;
		var add_php_before_getitems_vvvvvzn = [];
		add_php_before_getitems_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzn))
	{
		var add_php_before_getitems_vvvvvzn = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzn.some(add_php_before_getitems_vvvvvzn_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvznvze_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvznvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvznvze_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvznvze_required = true;
		}
	}
}

// the vvvvvzn Some function
function add_php_before_getitems_vvvvvzn_SomeFunc(add_php_before_getitems_vvvvvzn)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzn Some function
function gettype_vvvvvzn_SomeFunc(gettype_vvvvvzn)
{
	// set the function logic
	if (gettype_vvvvvzn == 2 || gettype_vvvvvzn == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(add_php_after_getitems_vvvvvzo,gettype_vvvvvzo)
{
	if (isSet(add_php_after_getitems_vvvvvzo) && add_php_after_getitems_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = add_php_after_getitems_vvvvvzo;
		var add_php_after_getitems_vvvvvzo = [];
		add_php_after_getitems_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzo))
	{
		var add_php_after_getitems_vvvvvzo = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzo.some(add_php_after_getitems_vvvvvzo_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzovzf_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzovzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzovzf_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzovzf_required = true;
		}
	}
}

// the vvvvvzo Some function
function add_php_after_getitems_vvvvvzo_SomeFunc(add_php_after_getitems_vvvvvzo)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzo Some function
function gettype_vvvvvzo_SomeFunc(gettype_vvvvvzo)
{
	// set the function logic
	if (gettype_vvvvvzo == 2 || gettype_vvvvvzo == 4)
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzqvzg_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzqvzg_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzqvzh_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzqvzh_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzqvzi_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzqvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzqvzg_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzqvzg_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzqvzh_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzqvzh_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzqvzi_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzqvzi_required = true;
		}
	}
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzrvzj_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzrvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzrvzj_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzrvzj_required = true;
		}
	}
}

// the vvvvvzr Some function
function gettype_vvvvvzr_SomeFunc(gettype_vvvvvzr)
{
	// set the function logic
	if (gettype_vvvvvzr == 2)
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
