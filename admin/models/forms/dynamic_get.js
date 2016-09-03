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

	@version		2.1.18
	@build			3rd September, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvybvyc_required = false;
jform_vvvvvycvyd_required = false;
jform_vvvvvydvye_required = false;
jform_vvvvvyevyf_required = false;
jform_vvvvvyfvyg_required = false;
jform_vvvvvygvyh_required = false;
jform_vvvvvylvyi_required = false;
jform_vvvvvynvyj_required = false;
jform_vvvvvyovyk_required = false;
jform_vvvvvyqvyl_required = false;
jform_vvvvvyqvym_required = false;
jform_vvvvvyrvyn_required = false;
jform_vvvvvysvyo_required = false;
jform_vvvvvytvyp_required = false;
jform_vvvvvyvvyq_required = false;
jform_vvvvvyvvyr_required = false;
jform_vvvvvyvvys_required = false;
jform_vvvvvywvyt_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyb = jQuery("#jform_gettype").val();
	vvvvvyb(gettype_vvvvvyb);

	var main_source_vvvvvyc = jQuery("#jform_main_source").val();
	vvvvvyc(main_source_vvvvvyc);

	var main_source_vvvvvyd = jQuery("#jform_main_source").val();
	vvvvvyd(main_source_vvvvvyd);

	var main_source_vvvvvye = jQuery("#jform_main_source").val();
	vvvvvye(main_source_vvvvvye);

	var main_source_vvvvvyf = jQuery("#jform_main_source").val();
	vvvvvyf(main_source_vvvvvyf);

	var addcalculation_vvvvvyg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyg(addcalculation_vvvvvyg);

	var addcalculation_vvvvvyh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyh = jQuery("#jform_gettype").val();
	vvvvvyh(addcalculation_vvvvvyh,gettype_vvvvvyh);

	var addcalculation_vvvvvyi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyi = jQuery("#jform_gettype").val();
	vvvvvyi(addcalculation_vvvvvyi,gettype_vvvvvyi);

	var main_source_vvvvvyl = jQuery("#jform_main_source").val();
	vvvvvyl(main_source_vvvvvyl);

	var main_source_vvvvvym = jQuery("#jform_main_source").val();
	vvvvvym(main_source_vvvvvym);

	var add_php_before_getitem_vvvvvyn = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyn = jQuery("#jform_gettype").val();
	vvvvvyn(add_php_before_getitem_vvvvvyn,gettype_vvvvvyn);

	var add_php_after_getitem_vvvvvyo = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyo = jQuery("#jform_gettype").val();
	vvvvvyo(add_php_after_getitem_vvvvvyo,gettype_vvvvvyo);

	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(gettype_vvvvvyq);

	var add_php_getlistquery_vvvvvyr = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyr = jQuery("#jform_gettype").val();
	vvvvvyr(add_php_getlistquery_vvvvvyr,gettype_vvvvvyr);

	var add_php_before_getitems_vvvvvys = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvys = jQuery("#jform_gettype").val();
	vvvvvys(add_php_before_getitems_vvvvvys,gettype_vvvvvys);

	var add_php_after_getitems_vvvvvyt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyt = jQuery("#jform_gettype").val();
	vvvvvyt(add_php_after_getitems_vvvvvyt,gettype_vvvvvyt);

	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(gettype_vvvvvyv);

	var gettype_vvvvvyw = jQuery("#jform_gettype").val();
	vvvvvyw(gettype_vvvvvyw);
});

// the vvvvvyb function
function vvvvvyb(gettype_vvvvvyb)
{
	if (isSet(gettype_vvvvvyb) && gettype_vvvvvyb.constructor !== Array)
	{
		var temp_vvvvvyb = gettype_vvvvvyb;
		var gettype_vvvvvyb = [];
		gettype_vvvvvyb.push(temp_vvvvvyb);
	}
	else if (!isSet(gettype_vvvvvyb))
	{
		var gettype_vvvvvyb = [];
	}
	var gettype = gettype_vvvvvyb.some(gettype_vvvvvyb_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvybvyc_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvybvyc_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvybvyc_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvybvyc_required = true;
		}
	}
}

// the vvvvvyb Some function
function gettype_vvvvvyb_SomeFunc(gettype_vvvvvyb)
{
	// set the function logic
	if (gettype_vvvvvyb == 3 || gettype_vvvvvyb == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyc function
function vvvvvyc(main_source_vvvvvyc)
{
	if (isSet(main_source_vvvvvyc) && main_source_vvvvvyc.constructor !== Array)
	{
		var temp_vvvvvyc = main_source_vvvvvyc;
		var main_source_vvvvvyc = [];
		main_source_vvvvvyc.push(temp_vvvvvyc);
	}
	else if (!isSet(main_source_vvvvvyc))
	{
		var main_source_vvvvvyc = [];
	}
	var main_source = main_source_vvvvvyc.some(main_source_vvvvvyc_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvycvyd_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvycvyd_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvycvyd_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvycvyd_required = true;
		}
	}
}

// the vvvvvyc Some function
function main_source_vvvvvyc_SomeFunc(main_source_vvvvvyc)
{
	// set the function logic
	if (main_source_vvvvvyc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyd function
function vvvvvyd(main_source_vvvvvyd)
{
	if (isSet(main_source_vvvvvyd) && main_source_vvvvvyd.constructor !== Array)
	{
		var temp_vvvvvyd = main_source_vvvvvyd;
		var main_source_vvvvvyd = [];
		main_source_vvvvvyd.push(temp_vvvvvyd);
	}
	else if (!isSet(main_source_vvvvvyd))
	{
		var main_source_vvvvvyd = [];
	}
	var main_source = main_source_vvvvvyd.some(main_source_vvvvvyd_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvydvye_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvydvye_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvydvye_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvydvye_required = true;
		}
	}
}

// the vvvvvyd Some function
function main_source_vvvvvyd_SomeFunc(main_source_vvvvvyd)
{
	// set the function logic
	if (main_source_vvvvvyd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvye function
function vvvvvye(main_source_vvvvvye)
{
	if (isSet(main_source_vvvvvye) && main_source_vvvvvye.constructor !== Array)
	{
		var temp_vvvvvye = main_source_vvvvvye;
		var main_source_vvvvvye = [];
		main_source_vvvvvye.push(temp_vvvvvye);
	}
	else if (!isSet(main_source_vvvvvye))
	{
		var main_source_vvvvvye = [];
	}
	var main_source = main_source_vvvvvye.some(main_source_vvvvvye_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvyevyf_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvyevyf_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyevyf_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvyevyf_required = true;
		}
	}
}

// the vvvvvye Some function
function main_source_vvvvvye_SomeFunc(main_source_vvvvvye)
{
	// set the function logic
	if (main_source_vvvvvye == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyf function
function vvvvvyf(main_source_vvvvvyf)
{
	if (isSet(main_source_vvvvvyf) && main_source_vvvvvyf.constructor !== Array)
	{
		var temp_vvvvvyf = main_source_vvvvvyf;
		var main_source_vvvvvyf = [];
		main_source_vvvvvyf.push(temp_vvvvvyf);
	}
	else if (!isSet(main_source_vvvvvyf))
	{
		var main_source_vvvvvyf = [];
	}
	var main_source = main_source_vvvvvyf.some(main_source_vvvvvyf_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvyfvyg_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvyfvyg_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvyfvyg_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvyfvyg_required = true;
		}
	}
}

// the vvvvvyf Some function
function main_source_vvvvvyf_SomeFunc(main_source_vvvvvyf)
{
	// set the function logic
	if (main_source_vvvvvyf == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyg function
function vvvvvyg(addcalculation_vvvvvyg)
{
	// set the function logic
	if (addcalculation_vvvvvyg == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvygvyh_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvygvyh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvygvyh_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvygvyh_required = true;
		}
	}
}

// the vvvvvyh function
function vvvvvyh(addcalculation_vvvvvyh,gettype_vvvvvyh)
{
	if (isSet(addcalculation_vvvvvyh) && addcalculation_vvvvvyh.constructor !== Array)
	{
		var temp_vvvvvyh = addcalculation_vvvvvyh;
		var addcalculation_vvvvvyh = [];
		addcalculation_vvvvvyh.push(temp_vvvvvyh);
	}
	else if (!isSet(addcalculation_vvvvvyh))
	{
		var addcalculation_vvvvvyh = [];
	}
	var addcalculation = addcalculation_vvvvvyh.some(addcalculation_vvvvvyh_SomeFunc);

	if (isSet(gettype_vvvvvyh) && gettype_vvvvvyh.constructor !== Array)
	{
		var temp_vvvvvyh = gettype_vvvvvyh;
		var gettype_vvvvvyh = [];
		gettype_vvvvvyh.push(temp_vvvvvyh);
	}
	else if (!isSet(gettype_vvvvvyh))
	{
		var gettype_vvvvvyh = [];
	}
	var gettype = gettype_vvvvvyh.some(gettype_vvvvvyh_SomeFunc);


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

// the vvvvvyh Some function
function addcalculation_vvvvvyh_SomeFunc(addcalculation_vvvvvyh)
{
	// set the function logic
	if (addcalculation_vvvvvyh == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyh Some function
function gettype_vvvvvyh_SomeFunc(gettype_vvvvvyh)
{
	// set the function logic
	if (gettype_vvvvvyh == 1 || gettype_vvvvvyh == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyi function
function vvvvvyi(addcalculation_vvvvvyi,gettype_vvvvvyi)
{
	if (isSet(addcalculation_vvvvvyi) && addcalculation_vvvvvyi.constructor !== Array)
	{
		var temp_vvvvvyi = addcalculation_vvvvvyi;
		var addcalculation_vvvvvyi = [];
		addcalculation_vvvvvyi.push(temp_vvvvvyi);
	}
	else if (!isSet(addcalculation_vvvvvyi))
	{
		var addcalculation_vvvvvyi = [];
	}
	var addcalculation = addcalculation_vvvvvyi.some(addcalculation_vvvvvyi_SomeFunc);

	if (isSet(gettype_vvvvvyi) && gettype_vvvvvyi.constructor !== Array)
	{
		var temp_vvvvvyi = gettype_vvvvvyi;
		var gettype_vvvvvyi = [];
		gettype_vvvvvyi.push(temp_vvvvvyi);
	}
	else if (!isSet(gettype_vvvvvyi))
	{
		var gettype_vvvvvyi = [];
	}
	var gettype = gettype_vvvvvyi.some(gettype_vvvvvyi_SomeFunc);


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

// the vvvvvyi Some function
function addcalculation_vvvvvyi_SomeFunc(addcalculation_vvvvvyi)
{
	// set the function logic
	if (addcalculation_vvvvvyi == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyi Some function
function gettype_vvvvvyi_SomeFunc(gettype_vvvvvyi)
{
	// set the function logic
	if (gettype_vvvvvyi == 2 || gettype_vvvvvyi == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyl function
function vvvvvyl(main_source_vvvvvyl)
{
	if (isSet(main_source_vvvvvyl) && main_source_vvvvvyl.constructor !== Array)
	{
		var temp_vvvvvyl = main_source_vvvvvyl;
		var main_source_vvvvvyl = [];
		main_source_vvvvvyl.push(temp_vvvvvyl);
	}
	else if (!isSet(main_source_vvvvvyl))
	{
		var main_source_vvvvvyl = [];
	}
	var main_source = main_source_vvvvvyl.some(main_source_vvvvvyl_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvylvyi_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvylvyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvylvyi_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvylvyi_required = true;
		}
	}
}

// the vvvvvyl Some function
function main_source_vvvvvyl_SomeFunc(main_source_vvvvvyl)
{
	// set the function logic
	if (main_source_vvvvvyl == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvym function
function vvvvvym(main_source_vvvvvym)
{
	if (isSet(main_source_vvvvvym) && main_source_vvvvvym.constructor !== Array)
	{
		var temp_vvvvvym = main_source_vvvvvym;
		var main_source_vvvvvym = [];
		main_source_vvvvvym.push(temp_vvvvvym);
	}
	else if (!isSet(main_source_vvvvvym))
	{
		var main_source_vvvvvym = [];
	}
	var main_source = main_source_vvvvvym.some(main_source_vvvvvym_SomeFunc);


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

// the vvvvvym Some function
function main_source_vvvvvym_SomeFunc(main_source_vvvvvym)
{
	// set the function logic
	if (main_source_vvvvvym == 1 || main_source_vvvvvym == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyn function
function vvvvvyn(add_php_before_getitem_vvvvvyn,gettype_vvvvvyn)
{
	if (isSet(add_php_before_getitem_vvvvvyn) && add_php_before_getitem_vvvvvyn.constructor !== Array)
	{
		var temp_vvvvvyn = add_php_before_getitem_vvvvvyn;
		var add_php_before_getitem_vvvvvyn = [];
		add_php_before_getitem_vvvvvyn.push(temp_vvvvvyn);
	}
	else if (!isSet(add_php_before_getitem_vvvvvyn))
	{
		var add_php_before_getitem_vvvvvyn = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvyn.some(add_php_before_getitem_vvvvvyn_SomeFunc);

	if (isSet(gettype_vvvvvyn) && gettype_vvvvvyn.constructor !== Array)
	{
		var temp_vvvvvyn = gettype_vvvvvyn;
		var gettype_vvvvvyn = [];
		gettype_vvvvvyn.push(temp_vvvvvyn);
	}
	else if (!isSet(gettype_vvvvvyn))
	{
		var gettype_vvvvvyn = [];
	}
	var gettype = gettype_vvvvvyn.some(gettype_vvvvvyn_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvynvyj_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvynvyj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvynvyj_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvynvyj_required = true;
		}
	}
}

// the vvvvvyn Some function
function add_php_before_getitem_vvvvvyn_SomeFunc(add_php_before_getitem_vvvvvyn)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvyn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyn Some function
function gettype_vvvvvyn_SomeFunc(gettype_vvvvvyn)
{
	// set the function logic
	if (gettype_vvvvvyn == 1 || gettype_vvvvvyn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyo function
function vvvvvyo(add_php_after_getitem_vvvvvyo,gettype_vvvvvyo)
{
	if (isSet(add_php_after_getitem_vvvvvyo) && add_php_after_getitem_vvvvvyo.constructor !== Array)
	{
		var temp_vvvvvyo = add_php_after_getitem_vvvvvyo;
		var add_php_after_getitem_vvvvvyo = [];
		add_php_after_getitem_vvvvvyo.push(temp_vvvvvyo);
	}
	else if (!isSet(add_php_after_getitem_vvvvvyo))
	{
		var add_php_after_getitem_vvvvvyo = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvyo.some(add_php_after_getitem_vvvvvyo_SomeFunc);

	if (isSet(gettype_vvvvvyo) && gettype_vvvvvyo.constructor !== Array)
	{
		var temp_vvvvvyo = gettype_vvvvvyo;
		var gettype_vvvvvyo = [];
		gettype_vvvvvyo.push(temp_vvvvvyo);
	}
	else if (!isSet(gettype_vvvvvyo))
	{
		var gettype_vvvvvyo = [];
	}
	var gettype = gettype_vvvvvyo.some(gettype_vvvvvyo_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvyovyk_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvyovyk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyovyk_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvyovyk_required = true;
		}
	}
}

// the vvvvvyo Some function
function add_php_after_getitem_vvvvvyo_SomeFunc(add_php_after_getitem_vvvvvyo)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvyo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyo Some function
function gettype_vvvvvyo_SomeFunc(gettype_vvvvvyo)
{
	// set the function logic
	if (gettype_vvvvvyo == 1 || gettype_vvvvvyo == 3)
	{
		return true;
	}
	return false;
}

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
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvyqvyl_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvyqvyl_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvyqvym_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvyqvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyqvyl_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvyqvyl_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyqvym_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvyqvym_required = true;
		}
	}
}

// the vvvvvyq Some function
function gettype_vvvvvyq_SomeFunc(gettype_vvvvvyq)
{
	// set the function logic
	if (gettype_vvvvvyq == 1 || gettype_vvvvvyq == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyr function
function vvvvvyr(add_php_getlistquery_vvvvvyr,gettype_vvvvvyr)
{
	if (isSet(add_php_getlistquery_vvvvvyr) && add_php_getlistquery_vvvvvyr.constructor !== Array)
	{
		var temp_vvvvvyr = add_php_getlistquery_vvvvvyr;
		var add_php_getlistquery_vvvvvyr = [];
		add_php_getlistquery_vvvvvyr.push(temp_vvvvvyr);
	}
	else if (!isSet(add_php_getlistquery_vvvvvyr))
	{
		var add_php_getlistquery_vvvvvyr = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvyr.some(add_php_getlistquery_vvvvvyr_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvyrvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvyrvyn_required = true;
		}
	}
}

// the vvvvvyr Some function
function add_php_getlistquery_vvvvvyr_SomeFunc(add_php_getlistquery_vvvvvyr)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvyr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyr Some function
function gettype_vvvvvyr_SomeFunc(gettype_vvvvvyr)
{
	// set the function logic
	if (gettype_vvvvvyr == 2 || gettype_vvvvvyr == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvys function
function vvvvvys(add_php_before_getitems_vvvvvys,gettype_vvvvvys)
{
	if (isSet(add_php_before_getitems_vvvvvys) && add_php_before_getitems_vvvvvys.constructor !== Array)
	{
		var temp_vvvvvys = add_php_before_getitems_vvvvvys;
		var add_php_before_getitems_vvvvvys = [];
		add_php_before_getitems_vvvvvys.push(temp_vvvvvys);
	}
	else if (!isSet(add_php_before_getitems_vvvvvys))
	{
		var add_php_before_getitems_vvvvvys = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvys.some(add_php_before_getitems_vvvvvys_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvysvyo_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvysvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvysvyo_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvysvyo_required = true;
		}
	}
}

// the vvvvvys Some function
function add_php_before_getitems_vvvvvys_SomeFunc(add_php_before_getitems_vvvvvys)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvys == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvys Some function
function gettype_vvvvvys_SomeFunc(gettype_vvvvvys)
{
	// set the function logic
	if (gettype_vvvvvys == 2 || gettype_vvvvvys == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyt function
function vvvvvyt(add_php_after_getitems_vvvvvyt,gettype_vvvvvyt)
{
	if (isSet(add_php_after_getitems_vvvvvyt) && add_php_after_getitems_vvvvvyt.constructor !== Array)
	{
		var temp_vvvvvyt = add_php_after_getitems_vvvvvyt;
		var add_php_after_getitems_vvvvvyt = [];
		add_php_after_getitems_vvvvvyt.push(temp_vvvvvyt);
	}
	else if (!isSet(add_php_after_getitems_vvvvvyt))
	{
		var add_php_after_getitems_vvvvvyt = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvyt.some(add_php_after_getitems_vvvvvyt_SomeFunc);

	if (isSet(gettype_vvvvvyt) && gettype_vvvvvyt.constructor !== Array)
	{
		var temp_vvvvvyt = gettype_vvvvvyt;
		var gettype_vvvvvyt = [];
		gettype_vvvvvyt.push(temp_vvvvvyt);
	}
	else if (!isSet(gettype_vvvvvyt))
	{
		var gettype_vvvvvyt = [];
	}
	var gettype = gettype_vvvvvyt.some(gettype_vvvvvyt_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvytvyp_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvytvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvytvyp_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvytvyp_required = true;
		}
	}
}

// the vvvvvyt Some function
function add_php_after_getitems_vvvvvyt_SomeFunc(add_php_after_getitems_vvvvvyt)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvyt == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyt Some function
function gettype_vvvvvyt_SomeFunc(gettype_vvvvvyt)
{
	// set the function logic
	if (gettype_vvvvvyt == 2 || gettype_vvvvvyt == 4)
	{
		return true;
	}
	return false;
}

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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvyvvyq_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvyvvyq_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyvvyr_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvyvvyr_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyvvys_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvyvvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyvvyq_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvyvvyq_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyvvyr_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvyvvyr_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyvvys_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvyvvys_required = true;
		}
	}
}

// the vvvvvyv Some function
function gettype_vvvvvyv_SomeFunc(gettype_vvvvvyv)
{
	// set the function logic
	if (gettype_vvvvvyv == 2 || gettype_vvvvvyv == 4)
	{
		return true;
	}
	return false;
}

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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvywvyt_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvywvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvywvyt_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvywvyt_required = true;
		}
	}
}

// the vvvvvyw Some function
function gettype_vvvvvyw_SomeFunc(gettype_vvvvvyw)
{
	// set the function logic
	if (gettype_vvvvvyw == 2)
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
