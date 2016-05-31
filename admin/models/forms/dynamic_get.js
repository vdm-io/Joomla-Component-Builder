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

	@version		2.1.10
	@build			31st May, 2016
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
jform_vvvvvyavyb_required = false;
jform_vvvvvybvyc_required = false;
jform_vvvvvycvyd_required = false;
jform_vvvvvydvye_required = false;
jform_vvvvvyevyf_required = false;
jform_vvvvvyfvyg_required = false;
jform_vvvvvykvyh_required = false;
jform_vvvvvymvyi_required = false;
jform_vvvvvynvyj_required = false;
jform_vvvvvypvyk_required = false;
jform_vvvvvypvyl_required = false;
jform_vvvvvyqvym_required = false;
jform_vvvvvyrvyn_required = false;
jform_vvvvvysvyo_required = false;
jform_vvvvvyuvyp_required = false;
jform_vvvvvyuvyq_required = false;
jform_vvvvvyuvyr_required = false;
jform_vvvvvyvvys_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvya = jQuery("#jform_gettype").val();
	vvvvvya(gettype_vvvvvya);

	var main_source_vvvvvyb = jQuery("#jform_main_source").val();
	vvvvvyb(main_source_vvvvvyb);

	var main_source_vvvvvyc = jQuery("#jform_main_source").val();
	vvvvvyc(main_source_vvvvvyc);

	var main_source_vvvvvyd = jQuery("#jform_main_source").val();
	vvvvvyd(main_source_vvvvvyd);

	var main_source_vvvvvye = jQuery("#jform_main_source").val();
	vvvvvye(main_source_vvvvvye);

	var addcalculation_vvvvvyf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyf(addcalculation_vvvvvyf);

	var addcalculation_vvvvvyg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyg = jQuery("#jform_gettype").val();
	vvvvvyg(addcalculation_vvvvvyg,gettype_vvvvvyg);

	var addcalculation_vvvvvyh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyh = jQuery("#jform_gettype").val();
	vvvvvyh(addcalculation_vvvvvyh,gettype_vvvvvyh);

	var main_source_vvvvvyk = jQuery("#jform_main_source").val();
	vvvvvyk(main_source_vvvvvyk);

	var main_source_vvvvvyl = jQuery("#jform_main_source").val();
	vvvvvyl(main_source_vvvvvyl);

	var add_php_before_getitem_vvvvvym = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvym = jQuery("#jform_gettype").val();
	vvvvvym(add_php_before_getitem_vvvvvym,gettype_vvvvvym);

	var add_php_after_getitem_vvvvvyn = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyn = jQuery("#jform_gettype").val();
	vvvvvyn(add_php_after_getitem_vvvvvyn,gettype_vvvvvyn);

	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(gettype_vvvvvyp);

	var add_php_getlistquery_vvvvvyq = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(add_php_getlistquery_vvvvvyq,gettype_vvvvvyq);

	var add_php_before_getitems_vvvvvyr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyr = jQuery("#jform_gettype").val();
	vvvvvyr(add_php_before_getitems_vvvvvyr,gettype_vvvvvyr);

	var add_php_after_getitems_vvvvvys = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvys = jQuery("#jform_gettype").val();
	vvvvvys(add_php_after_getitems_vvvvvys,gettype_vvvvvys);

	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(gettype_vvvvvyu);

	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(gettype_vvvvvyv);
});

// the vvvvvya function
function vvvvvya(gettype_vvvvvya)
{
	if (isSet(gettype_vvvvvya) && gettype_vvvvvya.constructor !== Array)
	{
		var temp_vvvvvya = gettype_vvvvvya;
		var gettype_vvvvvya = [];
		gettype_vvvvvya.push(temp_vvvvvya);
	}
	else if (!isSet(gettype_vvvvvya))
	{
		var gettype_vvvvvya = [];
	}
	var gettype = gettype_vvvvvya.some(gettype_vvvvvya_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvyavyb_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvyavyb_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvyavyb_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvyavyb_required = true;
		}
	}
}

// the vvvvvya Some function
function gettype_vvvvvya_SomeFunc(gettype_vvvvvya)
{
	// set the function logic
	if (gettype_vvvvvya == 3 || gettype_vvvvvya == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyb function
function vvvvvyb(main_source_vvvvvyb)
{
	if (isSet(main_source_vvvvvyb) && main_source_vvvvvyb.constructor !== Array)
	{
		var temp_vvvvvyb = main_source_vvvvvyb;
		var main_source_vvvvvyb = [];
		main_source_vvvvvyb.push(temp_vvvvvyb);
	}
	else if (!isSet(main_source_vvvvvyb))
	{
		var main_source_vvvvvyb = [];
	}
	var main_source = main_source_vvvvvyb.some(main_source_vvvvvyb_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvybvyc_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvybvyc_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvybvyc_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvybvyc_required = true;
		}
	}
}

// the vvvvvyb Some function
function main_source_vvvvvyb_SomeFunc(main_source_vvvvvyb)
{
	// set the function logic
	if (main_source_vvvvvyb == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvycvyd_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvycvyd_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvycvyd_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvydvye_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvydvye_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvydvye_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvydvye_required = true;
		}
	}
}

// the vvvvvyd Some function
function main_source_vvvvvyd_SomeFunc(main_source_vvvvvyd)
{
	// set the function logic
	if (main_source_vvvvvyd == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvyevyf_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvyevyf_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvyevyf_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
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
function vvvvvyf(addcalculation_vvvvvyf)
{
	// set the function logic
	if (addcalculation_vvvvvyf == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyfvyg_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyfvyg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyfvyg_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyfvyg_required = true;
		}
	}
}

// the vvvvvyg function
function vvvvvyg(addcalculation_vvvvvyg,gettype_vvvvvyg)
{
	if (isSet(addcalculation_vvvvvyg) && addcalculation_vvvvvyg.constructor !== Array)
	{
		var temp_vvvvvyg = addcalculation_vvvvvyg;
		var addcalculation_vvvvvyg = [];
		addcalculation_vvvvvyg.push(temp_vvvvvyg);
	}
	else if (!isSet(addcalculation_vvvvvyg))
	{
		var addcalculation_vvvvvyg = [];
	}
	var addcalculation = addcalculation_vvvvvyg.some(addcalculation_vvvvvyg_SomeFunc);

	if (isSet(gettype_vvvvvyg) && gettype_vvvvvyg.constructor !== Array)
	{
		var temp_vvvvvyg = gettype_vvvvvyg;
		var gettype_vvvvvyg = [];
		gettype_vvvvvyg.push(temp_vvvvvyg);
	}
	else if (!isSet(gettype_vvvvvyg))
	{
		var gettype_vvvvvyg = [];
	}
	var gettype = gettype_vvvvvyg.some(gettype_vvvvvyg_SomeFunc);


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

// the vvvvvyg Some function
function addcalculation_vvvvvyg_SomeFunc(addcalculation_vvvvvyg)
{
	// set the function logic
	if (addcalculation_vvvvvyg == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyg Some function
function gettype_vvvvvyg_SomeFunc(gettype_vvvvvyg)
{
	// set the function logic
	if (gettype_vvvvvyg == 1 || gettype_vvvvvyg == 3)
	{
		return true;
	}
	return false;
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
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
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
	if (gettype_vvvvvyh == 2 || gettype_vvvvvyh == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyk function
function vvvvvyk(main_source_vvvvvyk)
{
	if (isSet(main_source_vvvvvyk) && main_source_vvvvvyk.constructor !== Array)
	{
		var temp_vvvvvyk = main_source_vvvvvyk;
		var main_source_vvvvvyk = [];
		main_source_vvvvvyk.push(temp_vvvvvyk);
	}
	else if (!isSet(main_source_vvvvvyk))
	{
		var main_source_vvvvvyk = [];
	}
	var main_source = main_source_vvvvvyk.some(main_source_vvvvvyk_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvykvyh_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvykvyh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvykvyh_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvykvyh_required = true;
		}
	}
}

// the vvvvvyk Some function
function main_source_vvvvvyk_SomeFunc(main_source_vvvvvyk)
{
	// set the function logic
	if (main_source_vvvvvyk == 3)
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

// the vvvvvyl Some function
function main_source_vvvvvyl_SomeFunc(main_source_vvvvvyl)
{
	// set the function logic
	if (main_source_vvvvvyl == 1 || main_source_vvvvvyl == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvym function
function vvvvvym(add_php_before_getitem_vvvvvym,gettype_vvvvvym)
{
	if (isSet(add_php_before_getitem_vvvvvym) && add_php_before_getitem_vvvvvym.constructor !== Array)
	{
		var temp_vvvvvym = add_php_before_getitem_vvvvvym;
		var add_php_before_getitem_vvvvvym = [];
		add_php_before_getitem_vvvvvym.push(temp_vvvvvym);
	}
	else if (!isSet(add_php_before_getitem_vvvvvym))
	{
		var add_php_before_getitem_vvvvvym = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvym.some(add_php_before_getitem_vvvvvym_SomeFunc);

	if (isSet(gettype_vvvvvym) && gettype_vvvvvym.constructor !== Array)
	{
		var temp_vvvvvym = gettype_vvvvvym;
		var gettype_vvvvvym = [];
		gettype_vvvvvym.push(temp_vvvvvym);
	}
	else if (!isSet(gettype_vvvvvym))
	{
		var gettype_vvvvvym = [];
	}
	var gettype = gettype_vvvvvym.some(gettype_vvvvvym_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvymvyi_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvymvyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvymvyi_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvymvyi_required = true;
		}
	}
}

// the vvvvvym Some function
function add_php_before_getitem_vvvvvym_SomeFunc(add_php_before_getitem_vvvvvym)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvym == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvym Some function
function gettype_vvvvvym_SomeFunc(gettype_vvvvvym)
{
	// set the function logic
	if (gettype_vvvvvym == 1 || gettype_vvvvvym == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyn function
function vvvvvyn(add_php_after_getitem_vvvvvyn,gettype_vvvvvyn)
{
	if (isSet(add_php_after_getitem_vvvvvyn) && add_php_after_getitem_vvvvvyn.constructor !== Array)
	{
		var temp_vvvvvyn = add_php_after_getitem_vvvvvyn;
		var add_php_after_getitem_vvvvvyn = [];
		add_php_after_getitem_vvvvvyn.push(temp_vvvvvyn);
	}
	else if (!isSet(add_php_after_getitem_vvvvvyn))
	{
		var add_php_after_getitem_vvvvvyn = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvyn.some(add_php_after_getitem_vvvvvyn_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvynvyj_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvynvyj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvynvyj_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvynvyj_required = true;
		}
	}
}

// the vvvvvyn Some function
function add_php_after_getitem_vvvvvyn_SomeFunc(add_php_after_getitem_vvvvvyn)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvyn == 1)
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

// the vvvvvyp function
function vvvvvyp(gettype_vvvvvyp)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvypvyk_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvypvyk_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvypvyl_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvypvyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvypvyk_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvypvyk_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvypvyl_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvypvyl_required = true;
		}
	}
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
function vvvvvyq(add_php_getlistquery_vvvvvyq,gettype_vvvvvyq)
{
	if (isSet(add_php_getlistquery_vvvvvyq) && add_php_getlistquery_vvvvvyq.constructor !== Array)
	{
		var temp_vvvvvyq = add_php_getlistquery_vvvvvyq;
		var add_php_getlistquery_vvvvvyq = [];
		add_php_getlistquery_vvvvvyq.push(temp_vvvvvyq);
	}
	else if (!isSet(add_php_getlistquery_vvvvvyq))
	{
		var add_php_getlistquery_vvvvvyq = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvyq.some(add_php_getlistquery_vvvvvyq_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyqvym_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvyqvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyqvym_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvyqvym_required = true;
		}
	}
}

// the vvvvvyq Some function
function add_php_getlistquery_vvvvvyq_SomeFunc(add_php_getlistquery_vvvvvyq)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvyq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyq Some function
function gettype_vvvvvyq_SomeFunc(gettype_vvvvvyq)
{
	// set the function logic
	if (gettype_vvvvvyq == 2 || gettype_vvvvvyq == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyr function
function vvvvvyr(add_php_before_getitems_vvvvvyr,gettype_vvvvvyr)
{
	if (isSet(add_php_before_getitems_vvvvvyr) && add_php_before_getitems_vvvvvyr.constructor !== Array)
	{
		var temp_vvvvvyr = add_php_before_getitems_vvvvvyr;
		var add_php_before_getitems_vvvvvyr = [];
		add_php_before_getitems_vvvvvyr.push(temp_vvvvvyr);
	}
	else if (!isSet(add_php_before_getitems_vvvvvyr))
	{
		var add_php_before_getitems_vvvvvyr = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvyr.some(add_php_before_getitems_vvvvvyr_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvyrvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvyrvyn_required = true;
		}
	}
}

// the vvvvvyr Some function
function add_php_before_getitems_vvvvvyr_SomeFunc(add_php_before_getitems_vvvvvyr)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvyr == 1)
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
function vvvvvys(add_php_after_getitems_vvvvvys,gettype_vvvvvys)
{
	if (isSet(add_php_after_getitems_vvvvvys) && add_php_after_getitems_vvvvvys.constructor !== Array)
	{
		var temp_vvvvvys = add_php_after_getitems_vvvvvys;
		var add_php_after_getitems_vvvvvys = [];
		add_php_after_getitems_vvvvvys.push(temp_vvvvvys);
	}
	else if (!isSet(add_php_after_getitems_vvvvvys))
	{
		var add_php_after_getitems_vvvvvys = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvys.some(add_php_after_getitems_vvvvvys_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvysvyo_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvysvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvysvyo_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvysvyo_required = true;
		}
	}
}

// the vvvvvys Some function
function add_php_after_getitems_vvvvvys_SomeFunc(add_php_after_getitems_vvvvvys)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvys == 1)
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

// the vvvvvyu function
function vvvvvyu(gettype_vvvvvyu)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvyuvyp_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvyuvyp_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvyuvyq_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyuvyr_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvyuvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyuvyp_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvyuvyp_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvyuvyq_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyuvyr_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvyuvyr_required = true;
		}
	}
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvyvvys_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvyvvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvyvvys_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvyvvys_required = true;
		}
	}
}

// the vvvvvyv Some function
function gettype_vvvvvyv_SomeFunc(gettype_vvvvvyv)
{
	// set the function logic
	if (gettype_vvvvvyv == 2)
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
