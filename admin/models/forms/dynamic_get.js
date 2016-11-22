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

	@version		2.2.3
	@build			22nd November, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvyqvym_required = false;
jform_vvvvvyrvyn_required = false;
jform_vvvvvysvyo_required = false;
jform_vvvvvytvyp_required = false;
jform_vvvvvyuvyq_required = false;
jform_vvvvvyvvyr_required = false;
jform_vvvvvzavys_required = false;
jform_vvvvvzcvyt_required = false;
jform_vvvvvzdvyu_required = false;
jform_vvvvvzfvyv_required = false;
jform_vvvvvzfvyw_required = false;
jform_vvvvvzgvyx_required = false;
jform_vvvvvzhvyy_required = false;
jform_vvvvvzivyz_required = false;
jform_vvvvvzkvza_required = false;
jform_vvvvvzkvzb_required = false;
jform_vvvvvzkvzc_required = false;
jform_vvvvvzlvzd_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(gettype_vvvvvyq);

	var main_source_vvvvvyr = jQuery("#jform_main_source").val();
	vvvvvyr(main_source_vvvvvyr);

	var main_source_vvvvvys = jQuery("#jform_main_source").val();
	vvvvvys(main_source_vvvvvys);

	var main_source_vvvvvyt = jQuery("#jform_main_source").val();
	vvvvvyt(main_source_vvvvvyt);

	var main_source_vvvvvyu = jQuery("#jform_main_source").val();
	vvvvvyu(main_source_vvvvvyu);

	var addcalculation_vvvvvyv = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyv(addcalculation_vvvvvyv);

	var addcalculation_vvvvvyw = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyw = jQuery("#jform_gettype").val();
	vvvvvyw(addcalculation_vvvvvyw,gettype_vvvvvyw);

	var addcalculation_vvvvvyx = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyx = jQuery("#jform_gettype").val();
	vvvvvyx(addcalculation_vvvvvyx,gettype_vvvvvyx);

	var main_source_vvvvvza = jQuery("#jform_main_source").val();
	vvvvvza(main_source_vvvvvza);

	var main_source_vvvvvzb = jQuery("#jform_main_source").val();
	vvvvvzb(main_source_vvvvvzb);

	var add_php_before_getitem_vvvvvzc = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(add_php_before_getitem_vvvvvzc,gettype_vvvvvzc);

	var add_php_after_getitem_vvvvvzd = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(add_php_after_getitem_vvvvvzd,gettype_vvvvvzd);

	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(gettype_vvvvvzf);

	var add_php_getlistquery_vvvvvzg = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(add_php_getlistquery_vvvvvzg,gettype_vvvvvzg);

	var add_php_before_getitems_vvvvvzh = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(add_php_before_getitems_vvvvvzh,gettype_vvvvvzh);

	var add_php_after_getitems_vvvvvzi = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_after_getitems_vvvvvzi,gettype_vvvvvzi);

	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(gettype_vvvvvzk);

	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(gettype_vvvvvzl);
});

// the vvvvvyq function
function vvvvvyq(gettype_vvvvvyq)
{
	if (isSet(gettype_vvvvvyq) && gettype_vvvvvyq.constructor !== Array)
	{
		var temp_vvvvvyq = gettype_vvvvvyq;
		var gettype_vvvvvyq = [];
		gettype_vvvvvyq.push(temp_vvvvvyq);
	}
	else if (!isSet(gettype_vvvvvyq))
	{
		var gettype_vvvvvyq = [];
	}
	var gettype = gettype_vvvvvyq.some(gettype_vvvvvyq_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvyqvym_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvyqvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvyqvym_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvyqvym_required = true;
		}
	}
}

// the vvvvvyq Some function
function gettype_vvvvvyq_SomeFunc(gettype_vvvvvyq)
{
	// set the function logic
	if (gettype_vvvvvyq == 3 || gettype_vvvvvyq == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyr function
function vvvvvyr(main_source_vvvvvyr)
{
	if (isSet(main_source_vvvvvyr) && main_source_vvvvvyr.constructor !== Array)
	{
		var temp_vvvvvyr = main_source_vvvvvyr;
		var main_source_vvvvvyr = [];
		main_source_vvvvvyr.push(temp_vvvvvyr);
	}
	else if (!isSet(main_source_vvvvvyr))
	{
		var main_source_vvvvvyr = [];
	}
	var main_source = main_source_vvvvvyr.some(main_source_vvvvvyr_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvyrvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvyrvyn_required = true;
		}
	}
}

// the vvvvvyr Some function
function main_source_vvvvvyr_SomeFunc(main_source_vvvvvyr)
{
	// set the function logic
	if (main_source_vvvvvyr == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvysvyo_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvysvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvysvyo_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvytvyp_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvytvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvytvyp_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvytvyp_required = true;
		}
	}
}

// the vvvvvyt Some function
function main_source_vvvvvyt_SomeFunc(main_source_vvvvvyt)
{
	// set the function logic
	if (main_source_vvvvvyt == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvyuvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
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
function vvvvvyv(addcalculation_vvvvvyv)
{
	// set the function logic
	if (addcalculation_vvvvvyv == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyvvyr_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyvvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyvvyr_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyvvyr_required = true;
		}
	}
}

// the vvvvvyw function
function vvvvvyw(addcalculation_vvvvvyw,gettype_vvvvvyw)
{
	if (isSet(addcalculation_vvvvvyw) && addcalculation_vvvvvyw.constructor !== Array)
	{
		var temp_vvvvvyw = addcalculation_vvvvvyw;
		var addcalculation_vvvvvyw = [];
		addcalculation_vvvvvyw.push(temp_vvvvvyw);
	}
	else if (!isSet(addcalculation_vvvvvyw))
	{
		var addcalculation_vvvvvyw = [];
	}
	var addcalculation = addcalculation_vvvvvyw.some(addcalculation_vvvvvyw_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvyw Some function
function addcalculation_vvvvvyw_SomeFunc(addcalculation_vvvvvyw)
{
	// set the function logic
	if (addcalculation_vvvvvyw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyw Some function
function gettype_vvvvvyw_SomeFunc(gettype_vvvvvyw)
{
	// set the function logic
	if (gettype_vvvvvyw == 1 || gettype_vvvvvyw == 3)
	{
		return true;
	}
	return false;
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
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
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
	if (gettype_vvvvvyx == 2 || gettype_vvvvvyx == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzavys_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzavys_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzavys_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzavys_required = true;
		}
	}
}

// the vvvvvza Some function
function main_source_vvvvvza_SomeFunc(main_source_vvvvvza)
{
	// set the function logic
	if (main_source_vvvvvza == 3)
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

// the vvvvvzb Some function
function main_source_vvvvvzb_SomeFunc(main_source_vvvvvzb)
{
	// set the function logic
	if (main_source_vvvvvzb == 1 || main_source_vvvvvzb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzc function
function vvvvvzc(add_php_before_getitem_vvvvvzc,gettype_vvvvvzc)
{
	if (isSet(add_php_before_getitem_vvvvvzc) && add_php_before_getitem_vvvvvzc.constructor !== Array)
	{
		var temp_vvvvvzc = add_php_before_getitem_vvvvvzc;
		var add_php_before_getitem_vvvvvzc = [];
		add_php_before_getitem_vvvvvzc.push(temp_vvvvvzc);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzc))
	{
		var add_php_before_getitem_vvvvvzc = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzc.some(add_php_before_getitem_vvvvvzc_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzcvyt_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzcvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzcvyt_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzcvyt_required = true;
		}
	}
}

// the vvvvvzc Some function
function add_php_before_getitem_vvvvvzc_SomeFunc(add_php_before_getitem_vvvvvzc)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzc == 1)
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
function vvvvvzd(add_php_after_getitem_vvvvvzd,gettype_vvvvvzd)
{
	if (isSet(add_php_after_getitem_vvvvvzd) && add_php_after_getitem_vvvvvzd.constructor !== Array)
	{
		var temp_vvvvvzd = add_php_after_getitem_vvvvvzd;
		var add_php_after_getitem_vvvvvzd = [];
		add_php_after_getitem_vvvvvzd.push(temp_vvvvvzd);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzd))
	{
		var add_php_after_getitem_vvvvvzd = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzd.some(add_php_after_getitem_vvvvvzd_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzdvyu_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzdvyu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzdvyu_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzdvyu_required = true;
		}
	}
}

// the vvvvvzd Some function
function add_php_after_getitem_vvvvvzd_SomeFunc(add_php_after_getitem_vvvvvzd)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzd == 1)
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

// the vvvvvzf function
function vvvvvzf(gettype_vvvvvzf)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzfvyv_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzfvyv_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzfvyw_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzfvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzfvyv_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzfvyv_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzfvyw_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzfvyw_required = true;
		}
	}
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

// the vvvvvzg function
function vvvvvzg(add_php_getlistquery_vvvvvzg,gettype_vvvvvzg)
{
	if (isSet(add_php_getlistquery_vvvvvzg) && add_php_getlistquery_vvvvvzg.constructor !== Array)
	{
		var temp_vvvvvzg = add_php_getlistquery_vvvvvzg;
		var add_php_getlistquery_vvvvvzg = [];
		add_php_getlistquery_vvvvvzg.push(temp_vvvvvzg);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzg))
	{
		var add_php_getlistquery_vvvvvzg = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzg.some(add_php_getlistquery_vvvvvzg_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzgvyx_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzgvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzgvyx_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzgvyx_required = true;
		}
	}
}

// the vvvvvzg Some function
function add_php_getlistquery_vvvvvzg_SomeFunc(add_php_getlistquery_vvvvvzg)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzg == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzg Some function
function gettype_vvvvvzg_SomeFunc(gettype_vvvvvzg)
{
	// set the function logic
	if (gettype_vvvvvzg == 2 || gettype_vvvvvzg == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzh function
function vvvvvzh(add_php_before_getitems_vvvvvzh,gettype_vvvvvzh)
{
	if (isSet(add_php_before_getitems_vvvvvzh) && add_php_before_getitems_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = add_php_before_getitems_vvvvvzh;
		var add_php_before_getitems_vvvvvzh = [];
		add_php_before_getitems_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzh))
	{
		var add_php_before_getitems_vvvvvzh = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzh.some(add_php_before_getitems_vvvvvzh_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzhvyy_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzhvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzhvyy_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzhvyy_required = true;
		}
	}
}

// the vvvvvzh Some function
function add_php_before_getitems_vvvvvzh_SomeFunc(add_php_before_getitems_vvvvvzh)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzh == 1)
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
function vvvvvzi(add_php_after_getitems_vvvvvzi,gettype_vvvvvzi)
{
	if (isSet(add_php_after_getitems_vvvvvzi) && add_php_after_getitems_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = add_php_after_getitems_vvvvvzi;
		var add_php_after_getitems_vvvvvzi = [];
		add_php_after_getitems_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzi))
	{
		var add_php_after_getitems_vvvvvzi = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzi.some(add_php_after_getitems_vvvvvzi_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzivyz_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzivyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzivyz_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzivyz_required = true;
		}
	}
}

// the vvvvvzi Some function
function add_php_after_getitems_vvvvvzi_SomeFunc(add_php_after_getitems_vvvvvzi)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzi == 1)
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

// the vvvvvzk function
function vvvvvzk(gettype_vvvvvzk)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzkvza_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzkvza_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzkvzb_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzkvzb_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzkvzc_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzkvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzkvza_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzkvza_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzkvzb_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzkvzb_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzkvzc_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzkvzc_required = true;
		}
	}
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzlvzd_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzlvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzlvzd_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzlvzd_required = true;
		}
	}
}

// the vvvvvzl Some function
function gettype_vvvvvzl_SomeFunc(gettype_vvvvvzl)
{
	// set the function logic
	if (gettype_vvvvvzl == 2)
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
