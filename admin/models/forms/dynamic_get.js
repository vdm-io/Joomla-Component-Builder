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

	@version		@update number 97 of this MVC
	@build			12th October, 2017
	@created		21st May, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvyvvyx_required = false;
jform_vvvvvywvyy_required = false;
jform_vvvvvyxvyz_required = false;
jform_vvvvvyyvza_required = false;
jform_vvvvvyzvzb_required = false;
jform_vvvvvzavzc_required = false;
jform_vvvvvzfvzd_required = false;
jform_vvvvvzhvze_required = false;
jform_vvvvvzivzf_required = false;
jform_vvvvvzkvzg_required = false;
jform_vvvvvzkvzh_required = false;
jform_vvvvvzlvzi_required = false;
jform_vvvvvzmvzj_required = false;
jform_vvvvvznvzk_required = false;
jform_vvvvvzpvzl_required = false;
jform_vvvvvzpvzm_required = false;
jform_vvvvvzpvzn_required = false;
jform_vvvvvzqvzo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(gettype_vvvvvyv);

	var main_source_vvvvvyw = jQuery("#jform_main_source").val();
	vvvvvyw(main_source_vvvvvyw);

	var main_source_vvvvvyx = jQuery("#jform_main_source").val();
	vvvvvyx(main_source_vvvvvyx);

	var main_source_vvvvvyy = jQuery("#jform_main_source").val();
	vvvvvyy(main_source_vvvvvyy);

	var main_source_vvvvvyz = jQuery("#jform_main_source").val();
	vvvvvyz(main_source_vvvvvyz);

	var addcalculation_vvvvvza = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvza(addcalculation_vvvvvza);

	var addcalculation_vvvvvzb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzb = jQuery("#jform_gettype").val();
	vvvvvzb(addcalculation_vvvvvzb,gettype_vvvvvzb);

	var addcalculation_vvvvvzc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(addcalculation_vvvvvzc,gettype_vvvvvzc);

	var main_source_vvvvvzf = jQuery("#jform_main_source").val();
	vvvvvzf(main_source_vvvvvzf);

	var main_source_vvvvvzg = jQuery("#jform_main_source").val();
	vvvvvzg(main_source_vvvvvzg);

	var add_php_before_getitem_vvvvvzh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(add_php_before_getitem_vvvvvzh,gettype_vvvvvzh);

	var add_php_after_getitem_vvvvvzi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(add_php_after_getitem_vvvvvzi,gettype_vvvvvzi);

	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(gettype_vvvvvzk);

	var add_php_getlistquery_vvvvvzl = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_getlistquery_vvvvvzl,gettype_vvvvvzl);

	var add_php_before_getitems_vvvvvzm = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzm = jQuery("#jform_gettype").val();
	vvvvvzm(add_php_before_getitems_vvvvvzm,gettype_vvvvvzm);

	var add_php_after_getitems_vvvvvzn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(add_php_after_getitems_vvvvvzn,gettype_vvvvvzn);

	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(gettype_vvvvvzp);

	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(gettype_vvvvvzq);
});

// the vvvvvyv function
function vvvvvyv(gettype_vvvvvyv)
{
	if (isSet(gettype_vvvvvyv) && gettype_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = gettype_vvvvvyv;
		var gettype_vvvvvyv = [];
		gettype_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(gettype_vvvvvyv))
	{
		var gettype_vvvvvyv = [];
	}
	var gettype = gettype_vvvvvyv.some(gettype_vvvvvyv_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvyvvyx_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvyvvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvyvvyx_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvyvvyx_required = true;
		}
	}
}

// the vvvvvyv Some function
function gettype_vvvvvyv_SomeFunc(gettype_vvvvvyv)
{
	// set the function logic
	if (gettype_vvvvvyv == 3 || gettype_vvvvvyv == 4)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvywvyy_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvywvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvywvyy_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvywvyy_required = true;
		}
	}
}

// the vvvvvyw Some function
function main_source_vvvvvyw_SomeFunc(main_source_vvvvvyw)
{
	// set the function logic
	if (main_source_vvvvvyw == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvyxvyz_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvyxvyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvyxvyz_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvyxvyz_required = true;
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvyyvza_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvyyvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyyvza_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvyyvza_required = true;
		}
	}
}

// the vvvvvyy Some function
function main_source_vvvvvyy_SomeFunc(main_source_vvvvvyy)
{
	// set the function logic
	if (main_source_vvvvvyy == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvyzvzb_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvyzvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvyzvzb_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvyzvzb_required = true;
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
function vvvvvza(addcalculation_vvvvvza)
{
	// set the function logic
	if (addcalculation_vvvvvza == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvzavzc_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvzavzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvzavzc_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvzavzc_required = true;
		}
	}
}

// the vvvvvzb function
function vvvvvzb(addcalculation_vvvvvzb,gettype_vvvvvzb)
{
	if (isSet(addcalculation_vvvvvzb) && addcalculation_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = addcalculation_vvvvvzb;
		var addcalculation_vvvvvzb = [];
		addcalculation_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(addcalculation_vvvvvzb))
	{
		var addcalculation_vvvvvzb = [];
	}
	var addcalculation = addcalculation_vvvvvzb.some(addcalculation_vvvvvzb_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvzb Some function
function addcalculation_vvvvvzb_SomeFunc(addcalculation_vvvvvzb)
{
	// set the function logic
	if (addcalculation_vvvvvzb == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzb Some function
function gettype_vvvvvzb_SomeFunc(gettype_vvvvvzb)
{
	// set the function logic
	if (gettype_vvvvvzb == 1 || gettype_vvvvvzb == 3)
	{
		return true;
	}
	return false;
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
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
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
	if (gettype_vvvvvzc == 2 || gettype_vvvvvzc == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzfvzd_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzfvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzfvzd_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzfvzd_required = true;
		}
	}
}

// the vvvvvzf Some function
function main_source_vvvvvzf_SomeFunc(main_source_vvvvvzf)
{
	// set the function logic
	if (main_source_vvvvvzf == 3)
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

// the vvvvvzg Some function
function main_source_vvvvvzg_SomeFunc(main_source_vvvvvzg)
{
	// set the function logic
	if (main_source_vvvvvzg == 1 || main_source_vvvvvzg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzh function
function vvvvvzh(add_php_before_getitem_vvvvvzh,gettype_vvvvvzh)
{
	if (isSet(add_php_before_getitem_vvvvvzh) && add_php_before_getitem_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = add_php_before_getitem_vvvvvzh;
		var add_php_before_getitem_vvvvvzh = [];
		add_php_before_getitem_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzh))
	{
		var add_php_before_getitem_vvvvvzh = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzh.some(add_php_before_getitem_vvvvvzh_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzhvze_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzhvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzhvze_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzhvze_required = true;
		}
	}
}

// the vvvvvzh Some function
function add_php_before_getitem_vvvvvzh_SomeFunc(add_php_before_getitem_vvvvvzh)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzh == 1)
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
function vvvvvzi(add_php_after_getitem_vvvvvzi,gettype_vvvvvzi)
{
	if (isSet(add_php_after_getitem_vvvvvzi) && add_php_after_getitem_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = add_php_after_getitem_vvvvvzi;
		var add_php_after_getitem_vvvvvzi = [];
		add_php_after_getitem_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzi))
	{
		var add_php_after_getitem_vvvvvzi = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzi.some(add_php_after_getitem_vvvvvzi_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzivzf_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzivzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzivzf_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzivzf_required = true;
		}
	}
}

// the vvvvvzi Some function
function add_php_after_getitem_vvvvvzi_SomeFunc(add_php_after_getitem_vvvvvzi)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzi == 1)
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
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzkvzg_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzkvzg_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzkvzh_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzkvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzkvzg_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzkvzg_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzkvzh_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzkvzh_required = true;
		}
	}
}

// the vvvvvzk Some function
function gettype_vvvvvzk_SomeFunc(gettype_vvvvvzk)
{
	// set the function logic
	if (gettype_vvvvvzk == 1 || gettype_vvvvvzk == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzl function
function vvvvvzl(add_php_getlistquery_vvvvvzl,gettype_vvvvvzl)
{
	if (isSet(add_php_getlistquery_vvvvvzl) && add_php_getlistquery_vvvvvzl.constructor !== Array)
	{
		var temp_vvvvvzl = add_php_getlistquery_vvvvvzl;
		var add_php_getlistquery_vvvvvzl = [];
		add_php_getlistquery_vvvvvzl.push(temp_vvvvvzl);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzl))
	{
		var add_php_getlistquery_vvvvvzl = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzl.some(add_php_getlistquery_vvvvvzl_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzlvzi_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzlvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzlvzi_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzlvzi_required = true;
		}
	}
}

// the vvvvvzl Some function
function add_php_getlistquery_vvvvvzl_SomeFunc(add_php_getlistquery_vvvvvzl)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzl == 1)
	{
		return true;
	}
	return false;
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
function vvvvvzm(add_php_before_getitems_vvvvvzm,gettype_vvvvvzm)
{
	if (isSet(add_php_before_getitems_vvvvvzm) && add_php_before_getitems_vvvvvzm.constructor !== Array)
	{
		var temp_vvvvvzm = add_php_before_getitems_vvvvvzm;
		var add_php_before_getitems_vvvvvzm = [];
		add_php_before_getitems_vvvvvzm.push(temp_vvvvvzm);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzm))
	{
		var add_php_before_getitems_vvvvvzm = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzm.some(add_php_before_getitems_vvvvvzm_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzmvzj_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzmvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzmvzj_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzmvzj_required = true;
		}
	}
}

// the vvvvvzm Some function
function add_php_before_getitems_vvvvvzm_SomeFunc(add_php_before_getitems_vvvvvzm)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzm == 1)
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
function vvvvvzn(add_php_after_getitems_vvvvvzn,gettype_vvvvvzn)
{
	if (isSet(add_php_after_getitems_vvvvvzn) && add_php_after_getitems_vvvvvzn.constructor !== Array)
	{
		var temp_vvvvvzn = add_php_after_getitems_vvvvvzn;
		var add_php_after_getitems_vvvvvzn = [];
		add_php_after_getitems_vvvvvzn.push(temp_vvvvvzn);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzn))
	{
		var add_php_after_getitems_vvvvvzn = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzn.some(add_php_after_getitems_vvvvvzn_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvznvzk_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvznvzk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvznvzk_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvznvzk_required = true;
		}
	}
}

// the vvvvvzn Some function
function add_php_after_getitems_vvvvvzn_SomeFunc(add_php_after_getitems_vvvvvzn)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzn == 1)
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzpvzl_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzpvzl_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzpvzm_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzpvzm_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzpvzn_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzpvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzpvzl_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzpvzl_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzpvzm_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzpvzm_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzpvzn_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzpvzn_required = true;
		}
	}
}

// the vvvvvzp Some function
function gettype_vvvvvzp_SomeFunc(gettype_vvvvvzp)
{
	// set the function logic
	if (gettype_vvvvvzp == 2 || gettype_vvvvvzp == 4)
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzqvzo_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzqvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzqvzo_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzqvzo_required = true;
		}
	}
}

// the vvvvvzq Some function
function gettype_vvvvvzq_SomeFunc(gettype_vvvvvzq)
{
	// set the function logic
	if (gettype_vvvvvzq == 2)
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
