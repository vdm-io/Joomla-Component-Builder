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

	@version		2.1.20
	@build			7th September, 2016
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
jform_vvvvvydvye_required = false;
jform_vvvvvyevyf_required = false;
jform_vvvvvyfvyg_required = false;
jform_vvvvvygvyh_required = false;
jform_vvvvvyhvyi_required = false;
jform_vvvvvyivyj_required = false;
jform_vvvvvynvyk_required = false;
jform_vvvvvypvyl_required = false;
jform_vvvvvyqvym_required = false;
jform_vvvvvysvyn_required = false;
jform_vvvvvysvyo_required = false;
jform_vvvvvytvyp_required = false;
jform_vvvvvyuvyq_required = false;
jform_vvvvvyvvyr_required = false;
jform_vvvvvyxvys_required = false;
jform_vvvvvyxvyt_required = false;
jform_vvvvvyxvyu_required = false;
jform_vvvvvyyvyv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyd = jQuery("#jform_gettype").val();
	vvvvvyd(gettype_vvvvvyd);

	var main_source_vvvvvye = jQuery("#jform_main_source").val();
	vvvvvye(main_source_vvvvvye);

	var main_source_vvvvvyf = jQuery("#jform_main_source").val();
	vvvvvyf(main_source_vvvvvyf);

	var main_source_vvvvvyg = jQuery("#jform_main_source").val();
	vvvvvyg(main_source_vvvvvyg);

	var main_source_vvvvvyh = jQuery("#jform_main_source").val();
	vvvvvyh(main_source_vvvvvyh);

	var addcalculation_vvvvvyi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyi(addcalculation_vvvvvyi);

	var addcalculation_vvvvvyj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyj = jQuery("#jform_gettype").val();
	vvvvvyj(addcalculation_vvvvvyj,gettype_vvvvvyj);

	var addcalculation_vvvvvyk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(addcalculation_vvvvvyk,gettype_vvvvvyk);

	var main_source_vvvvvyn = jQuery("#jform_main_source").val();
	vvvvvyn(main_source_vvvvvyn);

	var main_source_vvvvvyo = jQuery("#jform_main_source").val();
	vvvvvyo(main_source_vvvvvyo);

	var add_php_before_getitem_vvvvvyp = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(add_php_before_getitem_vvvvvyp,gettype_vvvvvyp);

	var add_php_after_getitem_vvvvvyq = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(add_php_after_getitem_vvvvvyq,gettype_vvvvvyq);

	var gettype_vvvvvys = jQuery("#jform_gettype").val();
	vvvvvys(gettype_vvvvvys);

	var add_php_getlistquery_vvvvvyt = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyt = jQuery("#jform_gettype").val();
	vvvvvyt(add_php_getlistquery_vvvvvyt,gettype_vvvvvyt);

	var add_php_before_getitems_vvvvvyu = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(add_php_before_getitems_vvvvvyu,gettype_vvvvvyu);

	var add_php_after_getitems_vvvvvyv = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(add_php_after_getitems_vvvvvyv,gettype_vvvvvyv);

	var gettype_vvvvvyx = jQuery("#jform_gettype").val();
	vvvvvyx(gettype_vvvvvyx);

	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(gettype_vvvvvyy);
});

// the vvvvvyd function
function vvvvvyd(gettype_vvvvvyd)
{
	if (isSet(gettype_vvvvvyd) && gettype_vvvvvyd.constructor !== Array)
	{
		var temp_vvvvvyd = gettype_vvvvvyd;
		var gettype_vvvvvyd = [];
		gettype_vvvvvyd.push(temp_vvvvvyd);
	}
	else if (!isSet(gettype_vvvvvyd))
	{
		var gettype_vvvvvyd = [];
	}
	var gettype = gettype_vvvvvyd.some(gettype_vvvvvyd_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvydvye_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvydvye_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvydvye_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvydvye_required = true;
		}
	}
}

// the vvvvvyd Some function
function gettype_vvvvvyd_SomeFunc(gettype_vvvvvyd)
{
	// set the function logic
	if (gettype_vvvvvyd == 3 || gettype_vvvvvyd == 4)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvyevyf_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvyevyf_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyevyf_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvyevyf_required = true;
		}
	}
}

// the vvvvvye Some function
function main_source_vvvvvye_SomeFunc(main_source_vvvvvye)
{
	// set the function logic
	if (main_source_vvvvvye == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvyfvyg_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvyfvyg_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvyfvyg_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvyfvyg_required = true;
		}
	}
}

// the vvvvvyf Some function
function main_source_vvvvvyf_SomeFunc(main_source_vvvvvyf)
{
	// set the function logic
	if (main_source_vvvvvyf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyg function
function vvvvvyg(main_source_vvvvvyg)
{
	if (isSet(main_source_vvvvvyg) && main_source_vvvvvyg.constructor !== Array)
	{
		var temp_vvvvvyg = main_source_vvvvvyg;
		var main_source_vvvvvyg = [];
		main_source_vvvvvyg.push(temp_vvvvvyg);
	}
	else if (!isSet(main_source_vvvvvyg))
	{
		var main_source_vvvvvyg = [];
	}
	var main_source = main_source_vvvvvyg.some(main_source_vvvvvyg_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvygvyh_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvygvyh_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvygvyh_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvygvyh_required = true;
		}
	}
}

// the vvvvvyg Some function
function main_source_vvvvvyg_SomeFunc(main_source_vvvvvyg)
{
	// set the function logic
	if (main_source_vvvvvyg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyh function
function vvvvvyh(main_source_vvvvvyh)
{
	if (isSet(main_source_vvvvvyh) && main_source_vvvvvyh.constructor !== Array)
	{
		var temp_vvvvvyh = main_source_vvvvvyh;
		var main_source_vvvvvyh = [];
		main_source_vvvvvyh.push(temp_vvvvvyh);
	}
	else if (!isSet(main_source_vvvvvyh))
	{
		var main_source_vvvvvyh = [];
	}
	var main_source = main_source_vvvvvyh.some(main_source_vvvvvyh_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvyhvyi_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvyhvyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvyhvyi_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvyhvyi_required = true;
		}
	}
}

// the vvvvvyh Some function
function main_source_vvvvvyh_SomeFunc(main_source_vvvvvyh)
{
	// set the function logic
	if (main_source_vvvvvyh == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyi function
function vvvvvyi(addcalculation_vvvvvyi)
{
	// set the function logic
	if (addcalculation_vvvvvyi == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyivyj_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyivyj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyivyj_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyivyj_required = true;
		}
	}
}

// the vvvvvyj function
function vvvvvyj(addcalculation_vvvvvyj,gettype_vvvvvyj)
{
	if (isSet(addcalculation_vvvvvyj) && addcalculation_vvvvvyj.constructor !== Array)
	{
		var temp_vvvvvyj = addcalculation_vvvvvyj;
		var addcalculation_vvvvvyj = [];
		addcalculation_vvvvvyj.push(temp_vvvvvyj);
	}
	else if (!isSet(addcalculation_vvvvvyj))
	{
		var addcalculation_vvvvvyj = [];
	}
	var addcalculation = addcalculation_vvvvvyj.some(addcalculation_vvvvvyj_SomeFunc);

	if (isSet(gettype_vvvvvyj) && gettype_vvvvvyj.constructor !== Array)
	{
		var temp_vvvvvyj = gettype_vvvvvyj;
		var gettype_vvvvvyj = [];
		gettype_vvvvvyj.push(temp_vvvvvyj);
	}
	else if (!isSet(gettype_vvvvvyj))
	{
		var gettype_vvvvvyj = [];
	}
	var gettype = gettype_vvvvvyj.some(gettype_vvvvvyj_SomeFunc);


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

// the vvvvvyj Some function
function addcalculation_vvvvvyj_SomeFunc(addcalculation_vvvvvyj)
{
	// set the function logic
	if (addcalculation_vvvvvyj == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyj Some function
function gettype_vvvvvyj_SomeFunc(gettype_vvvvvyj)
{
	// set the function logic
	if (gettype_vvvvvyj == 1 || gettype_vvvvvyj == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyk function
function vvvvvyk(addcalculation_vvvvvyk,gettype_vvvvvyk)
{
	if (isSet(addcalculation_vvvvvyk) && addcalculation_vvvvvyk.constructor !== Array)
	{
		var temp_vvvvvyk = addcalculation_vvvvvyk;
		var addcalculation_vvvvvyk = [];
		addcalculation_vvvvvyk.push(temp_vvvvvyk);
	}
	else if (!isSet(addcalculation_vvvvvyk))
	{
		var addcalculation_vvvvvyk = [];
	}
	var addcalculation = addcalculation_vvvvvyk.some(addcalculation_vvvvvyk_SomeFunc);

	if (isSet(gettype_vvvvvyk) && gettype_vvvvvyk.constructor !== Array)
	{
		var temp_vvvvvyk = gettype_vvvvvyk;
		var gettype_vvvvvyk = [];
		gettype_vvvvvyk.push(temp_vvvvvyk);
	}
	else if (!isSet(gettype_vvvvvyk))
	{
		var gettype_vvvvvyk = [];
	}
	var gettype = gettype_vvvvvyk.some(gettype_vvvvvyk_SomeFunc);


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

// the vvvvvyk Some function
function addcalculation_vvvvvyk_SomeFunc(addcalculation_vvvvvyk)
{
	// set the function logic
	if (addcalculation_vvvvvyk == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyk Some function
function gettype_vvvvvyk_SomeFunc(gettype_vvvvvyk)
{
	// set the function logic
	if (gettype_vvvvvyk == 2 || gettype_vvvvvyk == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyn function
function vvvvvyn(main_source_vvvvvyn)
{
	if (isSet(main_source_vvvvvyn) && main_source_vvvvvyn.constructor !== Array)
	{
		var temp_vvvvvyn = main_source_vvvvvyn;
		var main_source_vvvvvyn = [];
		main_source_vvvvvyn.push(temp_vvvvvyn);
	}
	else if (!isSet(main_source_vvvvvyn))
	{
		var main_source_vvvvvyn = [];
	}
	var main_source = main_source_vvvvvyn.some(main_source_vvvvvyn_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvynvyk_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvynvyk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvynvyk_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvynvyk_required = true;
		}
	}
}

// the vvvvvyn Some function
function main_source_vvvvvyn_SomeFunc(main_source_vvvvvyn)
{
	// set the function logic
	if (main_source_vvvvvyn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyo function
function vvvvvyo(main_source_vvvvvyo)
{
	if (isSet(main_source_vvvvvyo) && main_source_vvvvvyo.constructor !== Array)
	{
		var temp_vvvvvyo = main_source_vvvvvyo;
		var main_source_vvvvvyo = [];
		main_source_vvvvvyo.push(temp_vvvvvyo);
	}
	else if (!isSet(main_source_vvvvvyo))
	{
		var main_source_vvvvvyo = [];
	}
	var main_source = main_source_vvvvvyo.some(main_source_vvvvvyo_SomeFunc);


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

// the vvvvvyo Some function
function main_source_vvvvvyo_SomeFunc(main_source_vvvvvyo)
{
	// set the function logic
	if (main_source_vvvvvyo == 1 || main_source_vvvvvyo == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyp function
function vvvvvyp(add_php_before_getitem_vvvvvyp,gettype_vvvvvyp)
{
	if (isSet(add_php_before_getitem_vvvvvyp) && add_php_before_getitem_vvvvvyp.constructor !== Array)
	{
		var temp_vvvvvyp = add_php_before_getitem_vvvvvyp;
		var add_php_before_getitem_vvvvvyp = [];
		add_php_before_getitem_vvvvvyp.push(temp_vvvvvyp);
	}
	else if (!isSet(add_php_before_getitem_vvvvvyp))
	{
		var add_php_before_getitem_vvvvvyp = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvyp.some(add_php_before_getitem_vvvvvyp_SomeFunc);

	if (isSet(gettype_vvvvvyp) && gettype_vvvvvyp.constructor !== Array)
	{
		var temp_vvvvvyp = gettype_vvvvvyp;
		var gettype_vvvvvyp = [];
		gettype_vvvvvyp.push(temp_vvvvvyp);
	}
	else if (!isSet(gettype_vvvvvyp))
	{
		var gettype_vvvvvyp = [];
	}
	var gettype = gettype_vvvvvyp.some(gettype_vvvvvyp_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvypvyl_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvypvyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvypvyl_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvypvyl_required = true;
		}
	}
}

// the vvvvvyp Some function
function add_php_before_getitem_vvvvvyp_SomeFunc(add_php_before_getitem_vvvvvyp)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvyp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyp Some function
function gettype_vvvvvyp_SomeFunc(gettype_vvvvvyp)
{
	// set the function logic
	if (gettype_vvvvvyp == 1 || gettype_vvvvvyp == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyq function
function vvvvvyq(add_php_after_getitem_vvvvvyq,gettype_vvvvvyq)
{
	if (isSet(add_php_after_getitem_vvvvvyq) && add_php_after_getitem_vvvvvyq.constructor !== Array)
	{
		var temp_vvvvvyq = add_php_after_getitem_vvvvvyq;
		var add_php_after_getitem_vvvvvyq = [];
		add_php_after_getitem_vvvvvyq.push(temp_vvvvvyq);
	}
	else if (!isSet(add_php_after_getitem_vvvvvyq))
	{
		var add_php_after_getitem_vvvvvyq = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvyq.some(add_php_after_getitem_vvvvvyq_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvyqvym_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvyqvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyqvym_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvyqvym_required = true;
		}
	}
}

// the vvvvvyq Some function
function add_php_after_getitem_vvvvvyq_SomeFunc(add_php_after_getitem_vvvvvyq)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvyq == 1)
	{
		return true;
	}
	return false;
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
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvysvyn_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvysvyn_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvysvyo_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvysvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvysvyn_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvysvyn_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvysvyo_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvysvyo_required = true;
		}
	}
}

// the vvvvvys Some function
function gettype_vvvvvys_SomeFunc(gettype_vvvvvys)
{
	// set the function logic
	if (gettype_vvvvvys == 1 || gettype_vvvvvys == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyt function
function vvvvvyt(add_php_getlistquery_vvvvvyt,gettype_vvvvvyt)
{
	if (isSet(add_php_getlistquery_vvvvvyt) && add_php_getlistquery_vvvvvyt.constructor !== Array)
	{
		var temp_vvvvvyt = add_php_getlistquery_vvvvvyt;
		var add_php_getlistquery_vvvvvyt = [];
		add_php_getlistquery_vvvvvyt.push(temp_vvvvvyt);
	}
	else if (!isSet(add_php_getlistquery_vvvvvyt))
	{
		var add_php_getlistquery_vvvvvyt = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvyt.some(add_php_getlistquery_vvvvvyt_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvytvyp_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvytvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvytvyp_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvytvyp_required = true;
		}
	}
}

// the vvvvvyt Some function
function add_php_getlistquery_vvvvvyt_SomeFunc(add_php_getlistquery_vvvvvyt)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvyt == 1)
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

// the vvvvvyu function
function vvvvvyu(add_php_before_getitems_vvvvvyu,gettype_vvvvvyu)
{
	if (isSet(add_php_before_getitems_vvvvvyu) && add_php_before_getitems_vvvvvyu.constructor !== Array)
	{
		var temp_vvvvvyu = add_php_before_getitems_vvvvvyu;
		var add_php_before_getitems_vvvvvyu = [];
		add_php_before_getitems_vvvvvyu.push(temp_vvvvvyu);
	}
	else if (!isSet(add_php_before_getitems_vvvvvyu))
	{
		var add_php_before_getitems_vvvvvyu = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvyu.some(add_php_before_getitems_vvvvvyu_SomeFunc);

	if (isSet(gettype_vvvvvyu) && gettype_vvvvvyu.constructor !== Array)
	{
		var temp_vvvvvyu = gettype_vvvvvyu;
		var gettype_vvvvvyu = [];
		gettype_vvvvvyu.push(temp_vvvvvyu);
	}
	else if (!isSet(gettype_vvvvvyu))
	{
		var gettype_vvvvvyu = [];
	}
	var gettype = gettype_vvvvvyu.some(gettype_vvvvvyu_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvyuvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvyuvyq_required = true;
		}
	}
}

// the vvvvvyu Some function
function add_php_before_getitems_vvvvvyu_SomeFunc(add_php_before_getitems_vvvvvyu)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvyu == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyu Some function
function gettype_vvvvvyu_SomeFunc(gettype_vvvvvyu)
{
	// set the function logic
	if (gettype_vvvvvyu == 2 || gettype_vvvvvyu == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyv function
function vvvvvyv(add_php_after_getitems_vvvvvyv,gettype_vvvvvyv)
{
	if (isSet(add_php_after_getitems_vvvvvyv) && add_php_after_getitems_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = add_php_after_getitems_vvvvvyv;
		var add_php_after_getitems_vvvvvyv = [];
		add_php_after_getitems_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(add_php_after_getitems_vvvvvyv))
	{
		var add_php_after_getitems_vvvvvyv = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvyv.some(add_php_after_getitems_vvvvvyv_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvyvvyr_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvyvvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyvvyr_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvyvvyr_required = true;
		}
	}
}

// the vvvvvyv Some function
function add_php_after_getitems_vvvvvyv_SomeFunc(add_php_after_getitems_vvvvvyv)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvyv == 1)
	{
		return true;
	}
	return false;
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

// the vvvvvyx function
function vvvvvyx(gettype_vvvvvyx)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvyxvys_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvyxvys_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyxvyt_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvyxvyt_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyxvyu_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvyxvyu_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyxvys_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvyxvys_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyxvyt_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvyxvyt_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyxvyu_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvyxvyu_required = true;
		}
	}
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

// the vvvvvyy function
function vvvvvyy(gettype_vvvvvyy)
{
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
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvyyvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvyyvyv_required = true;
		}
	}
}

// the vvvvvyy Some function
function gettype_vvvvvyy_SomeFunc(gettype_vvvvvyy)
{
	// set the function logic
	if (gettype_vvvvvyy == 2)
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
