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

	@version		2.1.21
	@build			11th September, 2016
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
jform_vvvvvyevyg_required = false;
jform_vvvvvyfvyh_required = false;
jform_vvvvvygvyi_required = false;
jform_vvvvvyhvyj_required = false;
jform_vvvvvyivyk_required = false;
jform_vvvvvyjvyl_required = false;
jform_vvvvvyovym_required = false;
jform_vvvvvyqvyn_required = false;
jform_vvvvvyrvyo_required = false;
jform_vvvvvytvyp_required = false;
jform_vvvvvytvyq_required = false;
jform_vvvvvyuvyr_required = false;
jform_vvvvvyvvys_required = false;
jform_vvvvvywvyt_required = false;
jform_vvvvvyyvyu_required = false;
jform_vvvvvyyvyv_required = false;
jform_vvvvvyyvyw_required = false;
jform_vvvvvyzvyx_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvye = jQuery("#jform_gettype").val();
	vvvvvye(gettype_vvvvvye);

	var main_source_vvvvvyf = jQuery("#jform_main_source").val();
	vvvvvyf(main_source_vvvvvyf);

	var main_source_vvvvvyg = jQuery("#jform_main_source").val();
	vvvvvyg(main_source_vvvvvyg);

	var main_source_vvvvvyh = jQuery("#jform_main_source").val();
	vvvvvyh(main_source_vvvvvyh);

	var main_source_vvvvvyi = jQuery("#jform_main_source").val();
	vvvvvyi(main_source_vvvvvyi);

	var addcalculation_vvvvvyj = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyj(addcalculation_vvvvvyj);

	var addcalculation_vvvvvyk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(addcalculation_vvvvvyk,gettype_vvvvvyk);

	var addcalculation_vvvvvyl = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyl = jQuery("#jform_gettype").val();
	vvvvvyl(addcalculation_vvvvvyl,gettype_vvvvvyl);

	var main_source_vvvvvyo = jQuery("#jform_main_source").val();
	vvvvvyo(main_source_vvvvvyo);

	var main_source_vvvvvyp = jQuery("#jform_main_source").val();
	vvvvvyp(main_source_vvvvvyp);

	var add_php_before_getitem_vvvvvyq = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(add_php_before_getitem_vvvvvyq,gettype_vvvvvyq);

	var add_php_after_getitem_vvvvvyr = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyr = jQuery("#jform_gettype").val();
	vvvvvyr(add_php_after_getitem_vvvvvyr,gettype_vvvvvyr);

	var gettype_vvvvvyt = jQuery("#jform_gettype").val();
	vvvvvyt(gettype_vvvvvyt);

	var add_php_getlistquery_vvvvvyu = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyu = jQuery("#jform_gettype").val();
	vvvvvyu(add_php_getlistquery_vvvvvyu,gettype_vvvvvyu);

	var add_php_before_getitems_vvvvvyv = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(add_php_before_getitems_vvvvvyv,gettype_vvvvvyv);

	var add_php_after_getitems_vvvvvyw = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyw = jQuery("#jform_gettype").val();
	vvvvvyw(add_php_after_getitems_vvvvvyw,gettype_vvvvvyw);

	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(gettype_vvvvvyy);

	var gettype_vvvvvyz = jQuery("#jform_gettype").val();
	vvvvvyz(gettype_vvvvvyz);
});

// the vvvvvye function
function vvvvvye(gettype_vvvvvye)
{
	if (isSet(gettype_vvvvvye) && gettype_vvvvvye.constructor !== Array)
	{
		var temp_vvvvvye = gettype_vvvvvye;
		var gettype_vvvvvye = [];
		gettype_vvvvvye.push(temp_vvvvvye);
	}
	else if (!isSet(gettype_vvvvvye))
	{
		var gettype_vvvvvye = [];
	}
	var gettype = gettype_vvvvvye.some(gettype_vvvvvye_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvyevyg_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvyevyg_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvyevyg_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvyevyg_required = true;
		}
	}
}

// the vvvvvye Some function
function gettype_vvvvvye_SomeFunc(gettype_vvvvvye)
{
	// set the function logic
	if (gettype_vvvvvye == 3 || gettype_vvvvvye == 4)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvyfvyh_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvyfvyh_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyfvyh_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvyfvyh_required = true;
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvygvyi_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvygvyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvygvyi_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvygvyi_required = true;
		}
	}
}

// the vvvvvyg Some function
function main_source_vvvvvyg_SomeFunc(main_source_vvvvvyg)
{
	// set the function logic
	if (main_source_vvvvvyg == 1)
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvyhvyj_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvyhvyj_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyhvyj_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvyhvyj_required = true;
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
function vvvvvyi(main_source_vvvvvyi)
{
	if (isSet(main_source_vvvvvyi) && main_source_vvvvvyi.constructor !== Array)
	{
		var temp_vvvvvyi = main_source_vvvvvyi;
		var main_source_vvvvvyi = [];
		main_source_vvvvvyi.push(temp_vvvvvyi);
	}
	else if (!isSet(main_source_vvvvvyi))
	{
		var main_source_vvvvvyi = [];
	}
	var main_source = main_source_vvvvvyi.some(main_source_vvvvvyi_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvyivyk_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvyivyk_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvyivyk_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvyivyk_required = true;
		}
	}
}

// the vvvvvyi Some function
function main_source_vvvvvyi_SomeFunc(main_source_vvvvvyi)
{
	// set the function logic
	if (main_source_vvvvvyi == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyj function
function vvvvvyj(addcalculation_vvvvvyj)
{
	// set the function logic
	if (addcalculation_vvvvvyj == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyjvyl_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyjvyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyjvyl_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyjvyl_required = true;
		}
	}
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
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
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
	if (gettype_vvvvvyk == 1 || gettype_vvvvvyk == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyl function
function vvvvvyl(addcalculation_vvvvvyl,gettype_vvvvvyl)
{
	if (isSet(addcalculation_vvvvvyl) && addcalculation_vvvvvyl.constructor !== Array)
	{
		var temp_vvvvvyl = addcalculation_vvvvvyl;
		var addcalculation_vvvvvyl = [];
		addcalculation_vvvvvyl.push(temp_vvvvvyl);
	}
	else if (!isSet(addcalculation_vvvvvyl))
	{
		var addcalculation_vvvvvyl = [];
	}
	var addcalculation = addcalculation_vvvvvyl.some(addcalculation_vvvvvyl_SomeFunc);

	if (isSet(gettype_vvvvvyl) && gettype_vvvvvyl.constructor !== Array)
	{
		var temp_vvvvvyl = gettype_vvvvvyl;
		var gettype_vvvvvyl = [];
		gettype_vvvvvyl.push(temp_vvvvvyl);
	}
	else if (!isSet(gettype_vvvvvyl))
	{
		var gettype_vvvvvyl = [];
	}
	var gettype = gettype_vvvvvyl.some(gettype_vvvvvyl_SomeFunc);


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

// the vvvvvyl Some function
function addcalculation_vvvvvyl_SomeFunc(addcalculation_vvvvvyl)
{
	// set the function logic
	if (addcalculation_vvvvvyl == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyl Some function
function gettype_vvvvvyl_SomeFunc(gettype_vvvvvyl)
{
	// set the function logic
	if (gettype_vvvvvyl == 2 || gettype_vvvvvyl == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvyovym_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvyovym_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvyovym_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvyovym_required = true;
		}
	}
}

// the vvvvvyo Some function
function main_source_vvvvvyo_SomeFunc(main_source_vvvvvyo)
{
	// set the function logic
	if (main_source_vvvvvyo == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyp function
function vvvvvyp(main_source_vvvvvyp)
{
	if (isSet(main_source_vvvvvyp) && main_source_vvvvvyp.constructor !== Array)
	{
		var temp_vvvvvyp = main_source_vvvvvyp;
		var main_source_vvvvvyp = [];
		main_source_vvvvvyp.push(temp_vvvvvyp);
	}
	else if (!isSet(main_source_vvvvvyp))
	{
		var main_source_vvvvvyp = [];
	}
	var main_source = main_source_vvvvvyp.some(main_source_vvvvvyp_SomeFunc);


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

// the vvvvvyp Some function
function main_source_vvvvvyp_SomeFunc(main_source_vvvvvyp)
{
	// set the function logic
	if (main_source_vvvvvyp == 1 || main_source_vvvvvyp == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyq function
function vvvvvyq(add_php_before_getitem_vvvvvyq,gettype_vvvvvyq)
{
	if (isSet(add_php_before_getitem_vvvvvyq) && add_php_before_getitem_vvvvvyq.constructor !== Array)
	{
		var temp_vvvvvyq = add_php_before_getitem_vvvvvyq;
		var add_php_before_getitem_vvvvvyq = [];
		add_php_before_getitem_vvvvvyq.push(temp_vvvvvyq);
	}
	else if (!isSet(add_php_before_getitem_vvvvvyq))
	{
		var add_php_before_getitem_vvvvvyq = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvyq.some(add_php_before_getitem_vvvvvyq_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvyqvyn_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvyqvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyqvyn_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvyqvyn_required = true;
		}
	}
}

// the vvvvvyq Some function
function add_php_before_getitem_vvvvvyq_SomeFunc(add_php_before_getitem_vvvvvyq)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvyq == 1)
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

// the vvvvvyr function
function vvvvvyr(add_php_after_getitem_vvvvvyr,gettype_vvvvvyr)
{
	if (isSet(add_php_after_getitem_vvvvvyr) && add_php_after_getitem_vvvvvyr.constructor !== Array)
	{
		var temp_vvvvvyr = add_php_after_getitem_vvvvvyr;
		var add_php_after_getitem_vvvvvyr = [];
		add_php_after_getitem_vvvvvyr.push(temp_vvvvvyr);
	}
	else if (!isSet(add_php_after_getitem_vvvvvyr))
	{
		var add_php_after_getitem_vvvvvyr = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvyr.some(add_php_after_getitem_vvvvvyr_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvyrvyo_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvyrvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyrvyo_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvyrvyo_required = true;
		}
	}
}

// the vvvvvyr Some function
function add_php_after_getitem_vvvvvyr_SomeFunc(add_php_after_getitem_vvvvvyr)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvyr == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyr Some function
function gettype_vvvvvyr_SomeFunc(gettype_vvvvvyr)
{
	// set the function logic
	if (gettype_vvvvvyr == 1 || gettype_vvvvvyr == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyt function
function vvvvvyt(gettype_vvvvvyt)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvytvyp_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvytvyp_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvytvyq_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvytvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvytvyp_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvytvyp_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvytvyq_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvytvyq_required = true;
		}
	}
}

// the vvvvvyt Some function
function gettype_vvvvvyt_SomeFunc(gettype_vvvvvyt)
{
	// set the function logic
	if (gettype_vvvvvyt == 1 || gettype_vvvvvyt == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyu function
function vvvvvyu(add_php_getlistquery_vvvvvyu,gettype_vvvvvyu)
{
	if (isSet(add_php_getlistquery_vvvvvyu) && add_php_getlistquery_vvvvvyu.constructor !== Array)
	{
		var temp_vvvvvyu = add_php_getlistquery_vvvvvyu;
		var add_php_getlistquery_vvvvvyu = [];
		add_php_getlistquery_vvvvvyu.push(temp_vvvvvyu);
	}
	else if (!isSet(add_php_getlistquery_vvvvvyu))
	{
		var add_php_getlistquery_vvvvvyu = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvyu.some(add_php_getlistquery_vvvvvyu_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyuvyr_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvyuvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyuvyr_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvyuvyr_required = true;
		}
	}
}

// the vvvvvyu Some function
function add_php_getlistquery_vvvvvyu_SomeFunc(add_php_getlistquery_vvvvvyu)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvyu == 1)
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
function vvvvvyv(add_php_before_getitems_vvvvvyv,gettype_vvvvvyv)
{
	if (isSet(add_php_before_getitems_vvvvvyv) && add_php_before_getitems_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = add_php_before_getitems_vvvvvyv;
		var add_php_before_getitems_vvvvvyv = [];
		add_php_before_getitems_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(add_php_before_getitems_vvvvvyv))
	{
		var add_php_before_getitems_vvvvvyv = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvyv.some(add_php_before_getitems_vvvvvyv_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyvvys_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvyvvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyvvys_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvyvvys_required = true;
		}
	}
}

// the vvvvvyv Some function
function add_php_before_getitems_vvvvvyv_SomeFunc(add_php_before_getitems_vvvvvyv)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvyv == 1)
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

// the vvvvvyw function
function vvvvvyw(add_php_after_getitems_vvvvvyw,gettype_vvvvvyw)
{
	if (isSet(add_php_after_getitems_vvvvvyw) && add_php_after_getitems_vvvvvyw.constructor !== Array)
	{
		var temp_vvvvvyw = add_php_after_getitems_vvvvvyw;
		var add_php_after_getitems_vvvvvyw = [];
		add_php_after_getitems_vvvvvyw.push(temp_vvvvvyw);
	}
	else if (!isSet(add_php_after_getitems_vvvvvyw))
	{
		var add_php_after_getitems_vvvvvyw = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvyw.some(add_php_after_getitems_vvvvvyw_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvywvyt_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvywvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvywvyt_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvywvyt_required = true;
		}
	}
}

// the vvvvvyw Some function
function add_php_after_getitems_vvvvvyw_SomeFunc(add_php_after_getitems_vvvvvyw)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvyw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyw Some function
function gettype_vvvvvyw_SomeFunc(gettype_vvvvvyw)
{
	// set the function logic
	if (gettype_vvvvvyw == 2 || gettype_vvvvvyw == 4)
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvyyvyu_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvyyvyu_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvyyvyv_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyyvyw_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvyyvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyyvyu_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvyyvyu_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvyyvyv_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyyvyw_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvyyvyw_required = true;
		}
	}
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

// the vvvvvyz function
function vvvvvyz(gettype_vvvvvyz)
{
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
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvyzvyx_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvyzvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvyzvyx_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvyzvyx_required = true;
		}
	}
}

// the vvvvvyz Some function
function gettype_vvvvvyz_SomeFunc(gettype_vvvvvyz)
{
	// set the function logic
	if (gettype_vvvvvyz == 2)
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
