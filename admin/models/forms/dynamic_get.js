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

	@version		2.2.4
	@build			25th November, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvyrvyn_required = false;
jform_vvvvvysvyo_required = false;
jform_vvvvvytvyp_required = false;
jform_vvvvvyuvyq_required = false;
jform_vvvvvyvvyr_required = false;
jform_vvvvvywvys_required = false;
jform_vvvvvzbvyt_required = false;
jform_vvvvvzdvyu_required = false;
jform_vvvvvzevyv_required = false;
jform_vvvvvzgvyw_required = false;
jform_vvvvvzgvyx_required = false;
jform_vvvvvzhvyy_required = false;
jform_vvvvvzivyz_required = false;
jform_vvvvvzjvza_required = false;
jform_vvvvvzlvzb_required = false;
jform_vvvvvzlvzc_required = false;
jform_vvvvvzlvzd_required = false;
jform_vvvvvzmvze_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyr = jQuery("#jform_gettype").val();
	vvvvvyr(gettype_vvvvvyr);

	var main_source_vvvvvys = jQuery("#jform_main_source").val();
	vvvvvys(main_source_vvvvvys);

	var main_source_vvvvvyt = jQuery("#jform_main_source").val();
	vvvvvyt(main_source_vvvvvyt);

	var main_source_vvvvvyu = jQuery("#jform_main_source").val();
	vvvvvyu(main_source_vvvvvyu);

	var main_source_vvvvvyv = jQuery("#jform_main_source").val();
	vvvvvyv(main_source_vvvvvyv);

	var addcalculation_vvvvvyw = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyw(addcalculation_vvvvvyw);

	var addcalculation_vvvvvyx = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyx = jQuery("#jform_gettype").val();
	vvvvvyx(addcalculation_vvvvvyx,gettype_vvvvvyx);

	var addcalculation_vvvvvyy = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(addcalculation_vvvvvyy,gettype_vvvvvyy);

	var main_source_vvvvvzb = jQuery("#jform_main_source").val();
	vvvvvzb(main_source_vvvvvzb);

	var main_source_vvvvvzc = jQuery("#jform_main_source").val();
	vvvvvzc(main_source_vvvvvzc);

	var add_php_before_getitem_vvvvvzd = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(add_php_before_getitem_vvvvvzd,gettype_vvvvvzd);

	var add_php_after_getitem_vvvvvze = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(add_php_after_getitem_vvvvvze,gettype_vvvvvze);

	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(gettype_vvvvvzg);

	var add_php_getlistquery_vvvvvzh = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(add_php_getlistquery_vvvvvzh,gettype_vvvvvzh);

	var add_php_before_getitems_vvvvvzi = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_before_getitems_vvvvvzi,gettype_vvvvvzi);

	var add_php_after_getitems_vvvvvzj = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_after_getitems_vvvvvzj,gettype_vvvvvzj);

	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(gettype_vvvvvzl);

	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(gettype_vvvvvzm);
});

// the vvvvvyr function
function vvvvvyr(gettype_vvvvvyr)
{
	if (isSet(gettype_vvvvvyr) && gettype_vvvvvyr.constructor !== Array)
	{
		var temp_vvvvvyr = gettype_vvvvvyr;
		var gettype_vvvvvyr = [];
		gettype_vvvvvyr.push(temp_vvvvvyr);
	}
	else if (!isSet(gettype_vvvvvyr))
	{
		var gettype_vvvvvyr = [];
	}
	var gettype = gettype_vvvvvyr.some(gettype_vvvvvyr_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvyrvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvyrvyn_required = true;
		}
	}
}

// the vvvvvyr Some function
function gettype_vvvvvyr_SomeFunc(gettype_vvvvvyr)
{
	// set the function logic
	if (gettype_vvvvvyr == 3 || gettype_vvvvvyr == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvys function
function vvvvvys(main_source_vvvvvys)
{
	if (isSet(main_source_vvvvvys) && main_source_vvvvvys.constructor !== Array)
	{
		var temp_vvvvvys = main_source_vvvvvys;
		var main_source_vvvvvys = [];
		main_source_vvvvvys.push(temp_vvvvvys);
	}
	else if (!isSet(main_source_vvvvvys))
	{
		var main_source_vvvvvys = [];
	}
	var main_source = main_source_vvvvvys.some(main_source_vvvvvys_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvysvyo_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvysvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvysvyo_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvysvyo_required = true;
		}
	}
}

// the vvvvvys Some function
function main_source_vvvvvys_SomeFunc(main_source_vvvvvys)
{
	// set the function logic
	if (main_source_vvvvvys == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvytvyp_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvytvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvytvyp_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvytvyp_required = true;
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvyuvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvyuvyq_required = true;
		}
	}
}

// the vvvvvyu Some function
function main_source_vvvvvyu_SomeFunc(main_source_vvvvvyu)
{
	// set the function logic
	if (main_source_vvvvvyu == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvyvvyr_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvyvvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvyvvyr_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvyvvyr_required = true;
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
function vvvvvyw(addcalculation_vvvvvyw)
{
	// set the function logic
	if (addcalculation_vvvvvyw == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvywvys_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvywvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvywvys_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvywvys_required = true;
		}
	}
}

// the vvvvvyx function
function vvvvvyx(addcalculation_vvvvvyx,gettype_vvvvvyx)
{
	if (isSet(addcalculation_vvvvvyx) && addcalculation_vvvvvyx.constructor !== Array)
	{
		var temp_vvvvvyx = addcalculation_vvvvvyx;
		var addcalculation_vvvvvyx = [];
		addcalculation_vvvvvyx.push(temp_vvvvvyx);
	}
	else if (!isSet(addcalculation_vvvvvyx))
	{
		var addcalculation_vvvvvyx = [];
	}
	var addcalculation = addcalculation_vvvvvyx.some(addcalculation_vvvvvyx_SomeFunc);

	if (isSet(gettype_vvvvvyx) && gettype_vvvvvyx.constructor !== Array)
	{
		var temp_vvvvvyx = gettype_vvvvvyx;
		var gettype_vvvvvyx = [];
		gettype_vvvvvyx.push(temp_vvvvvyx);
	}
	else if (!isSet(gettype_vvvvvyx))
	{
		var gettype_vvvvvyx = [];
	}
	var gettype = gettype_vvvvvyx.some(gettype_vvvvvyx_SomeFunc);


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

// the vvvvvyx Some function
function addcalculation_vvvvvyx_SomeFunc(addcalculation_vvvvvyx)
{
	// set the function logic
	if (addcalculation_vvvvvyx == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyx Some function
function gettype_vvvvvyx_SomeFunc(gettype_vvvvvyx)
{
	// set the function logic
	if (gettype_vvvvvyx == 1 || gettype_vvvvvyx == 3)
	{
		return true;
	}
	return false;
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
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
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
	if (gettype_vvvvvyy == 2 || gettype_vvvvvyy == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzbvyt_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzbvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzbvyt_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzbvyt_required = true;
		}
	}
}

// the vvvvvzb Some function
function main_source_vvvvvzb_SomeFunc(main_source_vvvvvzb)
{
	// set the function logic
	if (main_source_vvvvvzb == 3)
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

// the vvvvvzc Some function
function main_source_vvvvvzc_SomeFunc(main_source_vvvvvzc)
{
	// set the function logic
	if (main_source_vvvvvzc == 1 || main_source_vvvvvzc == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(add_php_before_getitem_vvvvvzd,gettype_vvvvvzd)
{
	if (isSet(add_php_before_getitem_vvvvvzd) && add_php_before_getitem_vvvvvzd.constructor !== Array)
	{
		var temp_vvvvvzd = add_php_before_getitem_vvvvvzd;
		var add_php_before_getitem_vvvvvzd = [];
		add_php_before_getitem_vvvvvzd.push(temp_vvvvvzd);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzd))
	{
		var add_php_before_getitem_vvvvvzd = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzd.some(add_php_before_getitem_vvvvvzd_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzdvyu_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzdvyu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzdvyu_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzdvyu_required = true;
		}
	}
}

// the vvvvvzd Some function
function add_php_before_getitem_vvvvvzd_SomeFunc(add_php_before_getitem_vvvvvzd)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzd Some function
function gettype_vvvvvzd_SomeFunc(gettype_vvvvvzd)
{
	// set the function logic
	if (gettype_vvvvvzd == 1 || gettype_vvvvvzd == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvze function
function vvvvvze(add_php_after_getitem_vvvvvze,gettype_vvvvvze)
{
	if (isSet(add_php_after_getitem_vvvvvze) && add_php_after_getitem_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = add_php_after_getitem_vvvvvze;
		var add_php_after_getitem_vvvvvze = [];
		add_php_after_getitem_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(add_php_after_getitem_vvvvvze))
	{
		var add_php_after_getitem_vvvvvze = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvze.some(add_php_after_getitem_vvvvvze_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzevyv_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzevyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzevyv_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzevyv_required = true;
		}
	}
}

// the vvvvvze Some function
function add_php_after_getitem_vvvvvze_SomeFunc(add_php_after_getitem_vvvvvze)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvze == 1)
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

// the vvvvvzg function
function vvvvvzg(gettype_vvvvvzg)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzgvyw_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzgvyw_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzgvyx_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzgvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzgvyw_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzgvyw_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzgvyx_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzgvyx_required = true;
		}
	}
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
function vvvvvzh(add_php_getlistquery_vvvvvzh,gettype_vvvvvzh)
{
	if (isSet(add_php_getlistquery_vvvvvzh) && add_php_getlistquery_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = add_php_getlistquery_vvvvvzh;
		var add_php_getlistquery_vvvvvzh = [];
		add_php_getlistquery_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzh))
	{
		var add_php_getlistquery_vvvvvzh = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzh.some(add_php_getlistquery_vvvvvzh_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzhvyy_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzhvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzhvyy_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzhvyy_required = true;
		}
	}
}

// the vvvvvzh Some function
function add_php_getlistquery_vvvvvzh_SomeFunc(add_php_getlistquery_vvvvvzh)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzh == 1)
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

// the vvvvvzi function
function vvvvvzi(add_php_before_getitems_vvvvvzi,gettype_vvvvvzi)
{
	if (isSet(add_php_before_getitems_vvvvvzi) && add_php_before_getitems_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = add_php_before_getitems_vvvvvzi;
		var add_php_before_getitems_vvvvvzi = [];
		add_php_before_getitems_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzi))
	{
		var add_php_before_getitems_vvvvvzi = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzi.some(add_php_before_getitems_vvvvvzi_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzivyz_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzivyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzivyz_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzivyz_required = true;
		}
	}
}

// the vvvvvzi Some function
function add_php_before_getitems_vvvvvzi_SomeFunc(add_php_before_getitems_vvvvvzi)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzi == 1)
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
function vvvvvzj(add_php_after_getitems_vvvvvzj,gettype_vvvvvzj)
{
	if (isSet(add_php_after_getitems_vvvvvzj) && add_php_after_getitems_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = add_php_after_getitems_vvvvvzj;
		var add_php_after_getitems_vvvvvzj = [];
		add_php_after_getitems_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzj))
	{
		var add_php_after_getitems_vvvvvzj = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzj.some(add_php_after_getitems_vvvvvzj_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzjvza_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzjvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzjvza_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzjvza_required = true;
		}
	}
}

// the vvvvvzj Some function
function add_php_after_getitems_vvvvvzj_SomeFunc(add_php_after_getitems_vvvvvzj)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzj == 1)
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzlvzb_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzlvzb_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzlvzc_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzlvzc_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzlvzd_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzlvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzlvzb_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzlvzb_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzlvzc_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzlvzc_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzlvzd_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzlvzd_required = true;
		}
	}
}

// the vvvvvzl Some function
function gettype_vvvvvzl_SomeFunc(gettype_vvvvvzl)
{
	// set the function logic
	if (gettype_vvvvvzl == 2 || gettype_vvvvvzl == 4)
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzmvze_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzmvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzmvze_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzmvze_required = true;
		}
	}
}

// the vvvvvzm Some function
function gettype_vvvvvzm_SomeFunc(gettype_vvvvvzm)
{
	// set the function logic
	if (gettype_vvvvvzm == 2)
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
