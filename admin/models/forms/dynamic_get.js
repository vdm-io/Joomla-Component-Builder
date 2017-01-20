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

	@version		2.2.6
	@build			20th January, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvysvys_required = false;
jform_vvvvvytvyt_required = false;
jform_vvvvvyuvyu_required = false;
jform_vvvvvyvvyv_required = false;
jform_vvvvvywvyw_required = false;
jform_vvvvvyxvyx_required = false;
jform_vvvvvzcvyy_required = false;
jform_vvvvvzevyz_required = false;
jform_vvvvvzfvza_required = false;
jform_vvvvvzhvzb_required = false;
jform_vvvvvzhvzc_required = false;
jform_vvvvvzivzd_required = false;
jform_vvvvvzjvze_required = false;
jform_vvvvvzkvzf_required = false;
jform_vvvvvzmvzg_required = false;
jform_vvvvvzmvzh_required = false;
jform_vvvvvzmvzi_required = false;
jform_vvvvvznvzj_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvys = jQuery("#jform_gettype").val();
	vvvvvys(gettype_vvvvvys);

	var main_source_vvvvvyt = jQuery("#jform_main_source").val();
	vvvvvyt(main_source_vvvvvyt);

	var main_source_vvvvvyu = jQuery("#jform_main_source").val();
	vvvvvyu(main_source_vvvvvyu);

	var main_source_vvvvvyv = jQuery("#jform_main_source").val();
	vvvvvyv(main_source_vvvvvyv);

	var main_source_vvvvvyw = jQuery("#jform_main_source").val();
	vvvvvyw(main_source_vvvvvyw);

	var addcalculation_vvvvvyx = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyx(addcalculation_vvvvvyx);

	var addcalculation_vvvvvyy = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(addcalculation_vvvvvyy,gettype_vvvvvyy);

	var addcalculation_vvvvvyz = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyz = jQuery("#jform_gettype").val();
	vvvvvyz(addcalculation_vvvvvyz,gettype_vvvvvyz);

	var main_source_vvvvvzc = jQuery("#jform_main_source").val();
	vvvvvzc(main_source_vvvvvzc);

	var main_source_vvvvvzd = jQuery("#jform_main_source").val();
	vvvvvzd(main_source_vvvvvzd);

	var add_php_before_getitem_vvvvvze = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(add_php_before_getitem_vvvvvze,gettype_vvvvvze);

	var add_php_after_getitem_vvvvvzf = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(add_php_after_getitem_vvvvvzf,gettype_vvvvvzf);

	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(gettype_vvvvvzh);

	var add_php_getlistquery_vvvvvzi = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_getlistquery_vvvvvzi,gettype_vvvvvzi);

	var add_php_before_getitems_vvvvvzj = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_before_getitems_vvvvvzj,gettype_vvvvvzj);

	var add_php_after_getitems_vvvvvzk = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_after_getitems_vvvvvzk,gettype_vvvvvzk);

	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(gettype_vvvvvzm);

	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(gettype_vvvvvzn);
});

// the vvvvvys function
function vvvvvys(gettype_vvvvvys)
{
	if (isSet(gettype_vvvvvys) && gettype_vvvvvys.constructor !== Array)
	{
		var temp_vvvvvys = gettype_vvvvvys;
		var gettype_vvvvvys = [];
		gettype_vvvvvys.push(temp_vvvvvys);
	}
	else if (!isSet(gettype_vvvvvys))
	{
		var gettype_vvvvvys = [];
	}
	var gettype = gettype_vvvvvys.some(gettype_vvvvvys_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvysvys_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvysvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvysvys_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvysvys_required = true;
		}
	}
}

// the vvvvvys Some function
function gettype_vvvvvys_SomeFunc(gettype_vvvvvys)
{
	// set the function logic
	if (gettype_vvvvvys == 3 || gettype_vvvvvys == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyt function
function vvvvvyt(main_source_vvvvvyt)
{
	if (isSet(main_source_vvvvvyt) && main_source_vvvvvyt.constructor !== Array)
	{
		var temp_vvvvvyt = main_source_vvvvvyt;
		var main_source_vvvvvyt = [];
		main_source_vvvvvyt.push(temp_vvvvvyt);
	}
	else if (!isSet(main_source_vvvvvyt))
	{
		var main_source_vvvvvyt = [];
	}
	var main_source = main_source_vvvvvyt.some(main_source_vvvvvyt_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvytvyt_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvytvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvytvyt_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvytvyt_required = true;
		}
	}
}

// the vvvvvyt Some function
function main_source_vvvvvyt_SomeFunc(main_source_vvvvvyt)
{
	// set the function logic
	if (main_source_vvvvvyt == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyu function
function vvvvvyu(main_source_vvvvvyu)
{
	if (isSet(main_source_vvvvvyu) && main_source_vvvvvyu.constructor !== Array)
	{
		var temp_vvvvvyu = main_source_vvvvvyu;
		var main_source_vvvvvyu = [];
		main_source_vvvvvyu.push(temp_vvvvvyu);
	}
	else if (!isSet(main_source_vvvvvyu))
	{
		var main_source_vvvvvyu = [];
	}
	var main_source = main_source_vvvvvyu.some(main_source_vvvvvyu_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvyuvyu_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvyuvyu_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvyuvyu_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvyuvyu_required = true;
		}
	}
}

// the vvvvvyu Some function
function main_source_vvvvvyu_SomeFunc(main_source_vvvvvyu)
{
	// set the function logic
	if (main_source_vvvvvyu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyv function
function vvvvvyv(main_source_vvvvvyv)
{
	if (isSet(main_source_vvvvvyv) && main_source_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = main_source_vvvvvyv;
		var main_source_vvvvvyv = [];
		main_source_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(main_source_vvvvvyv))
	{
		var main_source_vvvvvyv = [];
	}
	var main_source = main_source_vvvvvyv.some(main_source_vvvvvyv_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvyvvyv_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvyvvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyvvyv_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvyvvyv_required = true;
		}
	}
}

// the vvvvvyv Some function
function main_source_vvvvvyv_SomeFunc(main_source_vvvvvyv)
{
	// set the function logic
	if (main_source_vvvvvyv == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyw function
function vvvvvyw(main_source_vvvvvyw)
{
	if (isSet(main_source_vvvvvyw) && main_source_vvvvvyw.constructor !== Array)
	{
		var temp_vvvvvyw = main_source_vvvvvyw;
		var main_source_vvvvvyw = [];
		main_source_vvvvvyw.push(temp_vvvvvyw);
	}
	else if (!isSet(main_source_vvvvvyw))
	{
		var main_source_vvvvvyw = [];
	}
	var main_source = main_source_vvvvvyw.some(main_source_vvvvvyw_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvywvyw_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvywvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvywvyw_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvywvyw_required = true;
		}
	}
}

// the vvvvvyw Some function
function main_source_vvvvvyw_SomeFunc(main_source_vvvvvyw)
{
	// set the function logic
	if (main_source_vvvvvyw == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyx function
function vvvvvyx(addcalculation_vvvvvyx)
{
	// set the function logic
	if (addcalculation_vvvvvyx == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyxvyx_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyxvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyxvyx_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyxvyx_required = true;
		}
	}
}

// the vvvvvyy function
function vvvvvyy(addcalculation_vvvvvyy,gettype_vvvvvyy)
{
	if (isSet(addcalculation_vvvvvyy) && addcalculation_vvvvvyy.constructor !== Array)
	{
		var temp_vvvvvyy = addcalculation_vvvvvyy;
		var addcalculation_vvvvvyy = [];
		addcalculation_vvvvvyy.push(temp_vvvvvyy);
	}
	else if (!isSet(addcalculation_vvvvvyy))
	{
		var addcalculation_vvvvvyy = [];
	}
	var addcalculation = addcalculation_vvvvvyy.some(addcalculation_vvvvvyy_SomeFunc);

	if (isSet(gettype_vvvvvyy) && gettype_vvvvvyy.constructor !== Array)
	{
		var temp_vvvvvyy = gettype_vvvvvyy;
		var gettype_vvvvvyy = [];
		gettype_vvvvvyy.push(temp_vvvvvyy);
	}
	else if (!isSet(gettype_vvvvvyy))
	{
		var gettype_vvvvvyy = [];
	}
	var gettype = gettype_vvvvvyy.some(gettype_vvvvvyy_SomeFunc);


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

// the vvvvvyy Some function
function addcalculation_vvvvvyy_SomeFunc(addcalculation_vvvvvyy)
{
	// set the function logic
	if (addcalculation_vvvvvyy == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyy Some function
function gettype_vvvvvyy_SomeFunc(gettype_vvvvvyy)
{
	// set the function logic
	if (gettype_vvvvvyy == 1 || gettype_vvvvvyy == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyz function
function vvvvvyz(addcalculation_vvvvvyz,gettype_vvvvvyz)
{
	if (isSet(addcalculation_vvvvvyz) && addcalculation_vvvvvyz.constructor !== Array)
	{
		var temp_vvvvvyz = addcalculation_vvvvvyz;
		var addcalculation_vvvvvyz = [];
		addcalculation_vvvvvyz.push(temp_vvvvvyz);
	}
	else if (!isSet(addcalculation_vvvvvyz))
	{
		var addcalculation_vvvvvyz = [];
	}
	var addcalculation = addcalculation_vvvvvyz.some(addcalculation_vvvvvyz_SomeFunc);

	if (isSet(gettype_vvvvvyz) && gettype_vvvvvyz.constructor !== Array)
	{
		var temp_vvvvvyz = gettype_vvvvvyz;
		var gettype_vvvvvyz = [];
		gettype_vvvvvyz.push(temp_vvvvvyz);
	}
	else if (!isSet(gettype_vvvvvyz))
	{
		var gettype_vvvvvyz = [];
	}
	var gettype = gettype_vvvvvyz.some(gettype_vvvvvyz_SomeFunc);


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

// the vvvvvyz Some function
function addcalculation_vvvvvyz_SomeFunc(addcalculation_vvvvvyz)
{
	// set the function logic
	if (addcalculation_vvvvvyz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyz Some function
function gettype_vvvvvyz_SomeFunc(gettype_vvvvvyz)
{
	// set the function logic
	if (gettype_vvvvvyz == 2 || gettype_vvvvvyz == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzcvyy_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzcvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzcvyy_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzcvyy_required = true;
		}
	}
}

// the vvvvvzc Some function
function main_source_vvvvvzc_SomeFunc(main_source_vvvvvzc)
{
	// set the function logic
	if (main_source_vvvvvzc == 3)
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
		jQuery('#jform_filter').closest('.control-group').show();
		jQuery('#jform_global').closest('.control-group').show();
		jQuery('#jform_where').closest('.control-group').show();
		jQuery('#jform_join_db_table').closest('.control-group').show();
		jQuery('#jform_join_view_table').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_filter').closest('.control-group').hide();
		jQuery('#jform_global').closest('.control-group').hide();
		jQuery('#jform_where').closest('.control-group').hide();
		jQuery('#jform_join_db_table').closest('.control-group').hide();
		jQuery('#jform_join_view_table').closest('.control-group').hide();
	}
}

// the vvvvvzd Some function
function main_source_vvvvvzd_SomeFunc(main_source_vvvvvzd)
{
	// set the function logic
	if (main_source_vvvvvzd == 1 || main_source_vvvvvzd == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvze function
function vvvvvze(add_php_before_getitem_vvvvvze,gettype_vvvvvze)
{
	if (isSet(add_php_before_getitem_vvvvvze) && add_php_before_getitem_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = add_php_before_getitem_vvvvvze;
		var add_php_before_getitem_vvvvvze = [];
		add_php_before_getitem_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(add_php_before_getitem_vvvvvze))
	{
		var add_php_before_getitem_vvvvvze = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvze.some(add_php_before_getitem_vvvvvze_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzevyz_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzevyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzevyz_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzevyz_required = true;
		}
	}
}

// the vvvvvze Some function
function add_php_before_getitem_vvvvvze_SomeFunc(add_php_before_getitem_vvvvvze)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvze == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvze Some function
function gettype_vvvvvze_SomeFunc(gettype_vvvvvze)
{
	// set the function logic
	if (gettype_vvvvvze == 1 || gettype_vvvvvze == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzf function
function vvvvvzf(add_php_after_getitem_vvvvvzf,gettype_vvvvvzf)
{
	if (isSet(add_php_after_getitem_vvvvvzf) && add_php_after_getitem_vvvvvzf.constructor !== Array)
	{
		var temp_vvvvvzf = add_php_after_getitem_vvvvvzf;
		var add_php_after_getitem_vvvvvzf = [];
		add_php_after_getitem_vvvvvzf.push(temp_vvvvvzf);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzf))
	{
		var add_php_after_getitem_vvvvvzf = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzf.some(add_php_after_getitem_vvvvvzf_SomeFunc);

	if (isSet(gettype_vvvvvzf) && gettype_vvvvvzf.constructor !== Array)
	{
		var temp_vvvvvzf = gettype_vvvvvzf;
		var gettype_vvvvvzf = [];
		gettype_vvvvvzf.push(temp_vvvvvzf);
	}
	else if (!isSet(gettype_vvvvvzf))
	{
		var gettype_vvvvvzf = [];
	}
	var gettype = gettype_vvvvvzf.some(gettype_vvvvvzf_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzfvza_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzfvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzfvza_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzfvza_required = true;
		}
	}
}

// the vvvvvzf Some function
function add_php_after_getitem_vvvvvzf_SomeFunc(add_php_after_getitem_vvvvvzf)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzf Some function
function gettype_vvvvvzf_SomeFunc(gettype_vvvvvzf)
{
	// set the function logic
	if (gettype_vvvvvzf == 1 || gettype_vvvvvzf == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzh function
function vvvvvzh(gettype_vvvvvzh)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzhvzb_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzhvzb_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzhvzc_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzhvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzhvzb_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzhvzb_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzhvzc_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzhvzc_required = true;
		}
	}
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
function vvvvvzi(add_php_getlistquery_vvvvvzi,gettype_vvvvvzi)
{
	if (isSet(add_php_getlistquery_vvvvvzi) && add_php_getlistquery_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = add_php_getlistquery_vvvvvzi;
		var add_php_getlistquery_vvvvvzi = [];
		add_php_getlistquery_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzi))
	{
		var add_php_getlistquery_vvvvvzi = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzi.some(add_php_getlistquery_vvvvvzi_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzivzd_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzivzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzivzd_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzivzd_required = true;
		}
	}
}

// the vvvvvzi Some function
function add_php_getlistquery_vvvvvzi_SomeFunc(add_php_getlistquery_vvvvvzi)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzi == 1)
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

// the vvvvvzj function
function vvvvvzj(add_php_before_getitems_vvvvvzj,gettype_vvvvvzj)
{
	if (isSet(add_php_before_getitems_vvvvvzj) && add_php_before_getitems_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = add_php_before_getitems_vvvvvzj;
		var add_php_before_getitems_vvvvvzj = [];
		add_php_before_getitems_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzj))
	{
		var add_php_before_getitems_vvvvvzj = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzj.some(add_php_before_getitems_vvvvvzj_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzjvze_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzjvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzjvze_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzjvze_required = true;
		}
	}
}

// the vvvvvzj Some function
function add_php_before_getitems_vvvvvzj_SomeFunc(add_php_before_getitems_vvvvvzj)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzj == 1)
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

// the vvvvvzk function
function vvvvvzk(add_php_after_getitems_vvvvvzk,gettype_vvvvvzk)
{
	if (isSet(add_php_after_getitems_vvvvvzk) && add_php_after_getitems_vvvvvzk.constructor !== Array)
	{
		var temp_vvvvvzk = add_php_after_getitems_vvvvvzk;
		var add_php_after_getitems_vvvvvzk = [];
		add_php_after_getitems_vvvvvzk.push(temp_vvvvvzk);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzk))
	{
		var add_php_after_getitems_vvvvvzk = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzk.some(add_php_after_getitems_vvvvvzk_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzkvzf_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzkvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzkvzf_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzkvzf_required = true;
		}
	}
}

// the vvvvvzk Some function
function add_php_after_getitems_vvvvvzk_SomeFunc(add_php_after_getitems_vvvvvzk)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzk == 1)
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

// the vvvvvzm function
function vvvvvzm(gettype_vvvvvzm)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzmvzg_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzmvzg_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzmvzh_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzmvzh_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzmvzi_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzmvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzmvzg_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzmvzg_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzmvzh_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzmvzh_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzmvzi_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzmvzi_required = true;
		}
	}
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
function vvvvvzn(gettype_vvvvvzn)
{
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
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvznvzj_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvznvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvznvzj_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvznvzj_required = true;
		}
	}
}

// the vvvvvzn Some function
function gettype_vvvvvzn_SomeFunc(gettype_vvvvvzn)
{
	// set the function logic
	if (gettype_vvvvvzn == 2)
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

function getViewTableColumns(id,asKey,key,rowType,main)
{
	getViewTableColumns_server(id,asKey,rowType).done(function(result) {
		if (result)
		{
			loadSelectionData(result,'view',key,main);
		}
		else
		{
			loadSelectionData(false,'view',key,main);
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

function getDbTableColumns(name,asKey,key,rowType,main)
{
	getDbTableColumns_server(name,asKey,rowType).done(function(result) {
		if (result)
		{
			loadSelectionData(result,'db',key,main);
		}
		else
		{
			loadSelectionData(false,'db',key,main);
		}
	})
}

function loadSelectionData(result,type,key,main)
{
	if (main)
	{
		var textArea = 'textarea#jform_'+key+'_selection';
	}
	else 
	{
		var textArea = 'textarea#jform_join_'+type+'_table_fields_selection-'+key;
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
