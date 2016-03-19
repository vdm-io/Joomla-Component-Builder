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

	@version		2.1.2
	@build			19th March, 2016
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
jform_vvvvvxxvxv_required = false;
jform_vvvvvxyvxw_required = false;
jform_vvvvvxzvxx_required = false;
jform_vvvvvyavxy_required = false;
jform_vvvvvybvxz_required = false;
jform_vvvvvycvya_required = false;
jform_vvvvvyhvyb_required = false;
jform_vvvvvyjvyc_required = false;
jform_vvvvvykvyd_required = false;
jform_vvvvvymvye_required = false;
jform_vvvvvymvyf_required = false;
jform_vvvvvynvyg_required = false;
jform_vvvvvyovyh_required = false;
jform_vvvvvypvyi_required = false;
jform_vvvvvyrvyj_required = false;
jform_vvvvvyrvyk_required = false;
jform_vvvvvyrvyl_required = false;
jform_vvvvvysvym_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvxx = jQuery("#jform_gettype").val();
	vvvvvxx(gettype_vvvvvxx);

	var main_source_vvvvvxy = jQuery("#jform_main_source").val();
	vvvvvxy(main_source_vvvvvxy);

	var main_source_vvvvvxz = jQuery("#jform_main_source").val();
	vvvvvxz(main_source_vvvvvxz);

	var main_source_vvvvvya = jQuery("#jform_main_source").val();
	vvvvvya(main_source_vvvvvya);

	var main_source_vvvvvyb = jQuery("#jform_main_source").val();
	vvvvvyb(main_source_vvvvvyb);

	var addcalculation_vvvvvyc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyc(addcalculation_vvvvvyc);

	var addcalculation_vvvvvyd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyd = jQuery("#jform_gettype").val();
	vvvvvyd(addcalculation_vvvvvyd,gettype_vvvvvyd);

	var addcalculation_vvvvvye = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvye = jQuery("#jform_gettype").val();
	vvvvvye(addcalculation_vvvvvye,gettype_vvvvvye);

	var main_source_vvvvvyh = jQuery("#jform_main_source").val();
	vvvvvyh(main_source_vvvvvyh);

	var main_source_vvvvvyi = jQuery("#jform_main_source").val();
	vvvvvyi(main_source_vvvvvyi);

	var add_php_before_getitem_vvvvvyj = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyj = jQuery("#jform_gettype").val();
	vvvvvyj(add_php_before_getitem_vvvvvyj,gettype_vvvvvyj);

	var add_php_after_getitem_vvvvvyk = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(add_php_after_getitem_vvvvvyk,gettype_vvvvvyk);

	var gettype_vvvvvym = jQuery("#jform_gettype").val();
	vvvvvym(gettype_vvvvvym);

	var add_php_getlistquery_vvvvvyn = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyn = jQuery("#jform_gettype").val();
	vvvvvyn(add_php_getlistquery_vvvvvyn,gettype_vvvvvyn);

	var add_php_before_getitems_vvvvvyo = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyo = jQuery("#jform_gettype").val();
	vvvvvyo(add_php_before_getitems_vvvvvyo,gettype_vvvvvyo);

	var add_php_after_getitems_vvvvvyp = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(add_php_after_getitems_vvvvvyp,gettype_vvvvvyp);

	var gettype_vvvvvyr = jQuery("#jform_gettype").val();
	vvvvvyr(gettype_vvvvvyr);

	var gettype_vvvvvys = jQuery("#jform_gettype").val();
	vvvvvys(gettype_vvvvvys);
});

// the vvvvvxx function
function vvvvvxx(gettype_vvvvvxx)
{
	if (isSet(gettype_vvvvvxx) && gettype_vvvvvxx.constructor !== Array)
	{
		var temp_vvvvvxx = gettype_vvvvvxx;
		var gettype_vvvvvxx = [];
		gettype_vvvvvxx.push(temp_vvvvvxx);
	}
	else if (!isSet(gettype_vvvvvxx))
	{
		var gettype_vvvvvxx = [];
	}
	var gettype = gettype_vvvvvxx.some(gettype_vvvvvxx_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvxxvxv_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvxxvxv_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvxxvxv_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvxxvxv_required = true;
		}
	}
}

// the vvvvvxx Some function
function gettype_vvvvvxx_SomeFunc(gettype_vvvvvxx)
{
	// set the function logic
	if (gettype_vvvvvxx == 3 || gettype_vvvvvxx == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvxy function
function vvvvvxy(main_source_vvvvvxy)
{
	if (isSet(main_source_vvvvvxy) && main_source_vvvvvxy.constructor !== Array)
	{
		var temp_vvvvvxy = main_source_vvvvvxy;
		var main_source_vvvvvxy = [];
		main_source_vvvvvxy.push(temp_vvvvvxy);
	}
	else if (!isSet(main_source_vvvvvxy))
	{
		var main_source_vvvvvxy = [];
	}
	var main_source = main_source_vvvvvxy.some(main_source_vvvvvxy_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvxyvxw_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvxyvxw_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvxyvxw_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvxyvxw_required = true;
		}
	}
}

// the vvvvvxy Some function
function main_source_vvvvvxy_SomeFunc(main_source_vvvvvxy)
{
	// set the function logic
	if (main_source_vvvvvxy == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvxz function
function vvvvvxz(main_source_vvvvvxz)
{
	if (isSet(main_source_vvvvvxz) && main_source_vvvvvxz.constructor !== Array)
	{
		var temp_vvvvvxz = main_source_vvvvvxz;
		var main_source_vvvvvxz = [];
		main_source_vvvvvxz.push(temp_vvvvvxz);
	}
	else if (!isSet(main_source_vvvvvxz))
	{
		var main_source_vvvvvxz = [];
	}
	var main_source = main_source_vvvvvxz.some(main_source_vvvvvxz_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvxzvxx_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvxzvxx_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvxzvxx_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvxzvxx_required = true;
		}
	}
}

// the vvvvvxz Some function
function main_source_vvvvvxz_SomeFunc(main_source_vvvvvxz)
{
	// set the function logic
	if (main_source_vvvvvxz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvya function
function vvvvvya(main_source_vvvvvya)
{
	if (isSet(main_source_vvvvvya) && main_source_vvvvvya.constructor !== Array)
	{
		var temp_vvvvvya = main_source_vvvvvya;
		var main_source_vvvvvya = [];
		main_source_vvvvvya.push(temp_vvvvvya);
	}
	else if (!isSet(main_source_vvvvvya))
	{
		var main_source_vvvvvya = [];
	}
	var main_source = main_source_vvvvvya.some(main_source_vvvvvya_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvyavxy_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvyavxy_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyavxy_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvyavxy_required = true;
		}
	}
}

// the vvvvvya Some function
function main_source_vvvvvya_SomeFunc(main_source_vvvvvya)
{
	// set the function logic
	if (main_source_vvvvvya == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvybvxz_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvybvxz_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvybvxz_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvybvxz_required = true;
		}
	}
}

// the vvvvvyb Some function
function main_source_vvvvvyb_SomeFunc(main_source_vvvvvyb)
{
	// set the function logic
	if (main_source_vvvvvyb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyc function
function vvvvvyc(addcalculation_vvvvvyc)
{
	// set the function logic
	if (addcalculation_vvvvvyc == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvycvya_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvycvya_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvycvya_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvycvya_required = true;
		}
	}
}

// the vvvvvyd function
function vvvvvyd(addcalculation_vvvvvyd,gettype_vvvvvyd)
{
	if (isSet(addcalculation_vvvvvyd) && addcalculation_vvvvvyd.constructor !== Array)
	{
		var temp_vvvvvyd = addcalculation_vvvvvyd;
		var addcalculation_vvvvvyd = [];
		addcalculation_vvvvvyd.push(temp_vvvvvyd);
	}
	else if (!isSet(addcalculation_vvvvvyd))
	{
		var addcalculation_vvvvvyd = [];
	}
	var addcalculation = addcalculation_vvvvvyd.some(addcalculation_vvvvvyd_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvyd Some function
function addcalculation_vvvvvyd_SomeFunc(addcalculation_vvvvvyd)
{
	// set the function logic
	if (addcalculation_vvvvvyd == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyd Some function
function gettype_vvvvvyd_SomeFunc(gettype_vvvvvyd)
{
	// set the function logic
	if (gettype_vvvvvyd == 1 || gettype_vvvvvyd == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvye function
function vvvvvye(addcalculation_vvvvvye,gettype_vvvvvye)
{
	if (isSet(addcalculation_vvvvvye) && addcalculation_vvvvvye.constructor !== Array)
	{
		var temp_vvvvvye = addcalculation_vvvvvye;
		var addcalculation_vvvvvye = [];
		addcalculation_vvvvvye.push(temp_vvvvvye);
	}
	else if (!isSet(addcalculation_vvvvvye))
	{
		var addcalculation_vvvvvye = [];
	}
	var addcalculation = addcalculation_vvvvvye.some(addcalculation_vvvvvye_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
	}
}

// the vvvvvye Some function
function addcalculation_vvvvvye_SomeFunc(addcalculation_vvvvvye)
{
	// set the function logic
	if (addcalculation_vvvvvye == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvye Some function
function gettype_vvvvvye_SomeFunc(gettype_vvvvvye)
{
	// set the function logic
	if (gettype_vvvvvye == 2 || gettype_vvvvvye == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvyhvyb_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvyhvyb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvyhvyb_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvyhvyb_required = true;
		}
	}
}

// the vvvvvyh Some function
function main_source_vvvvvyh_SomeFunc(main_source_vvvvvyh)
{
	// set the function logic
	if (main_source_vvvvvyh == 3)
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

// the vvvvvyi Some function
function main_source_vvvvvyi_SomeFunc(main_source_vvvvvyi)
{
	// set the function logic
	if (main_source_vvvvvyi == 1 || main_source_vvvvvyi == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyj function
function vvvvvyj(add_php_before_getitem_vvvvvyj,gettype_vvvvvyj)
{
	if (isSet(add_php_before_getitem_vvvvvyj) && add_php_before_getitem_vvvvvyj.constructor !== Array)
	{
		var temp_vvvvvyj = add_php_before_getitem_vvvvvyj;
		var add_php_before_getitem_vvvvvyj = [];
		add_php_before_getitem_vvvvvyj.push(temp_vvvvvyj);
	}
	else if (!isSet(add_php_before_getitem_vvvvvyj))
	{
		var add_php_before_getitem_vvvvvyj = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvyj.some(add_php_before_getitem_vvvvvyj_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvyjvyc_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvyjvyc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyjvyc_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvyjvyc_required = true;
		}
	}
}

// the vvvvvyj Some function
function add_php_before_getitem_vvvvvyj_SomeFunc(add_php_before_getitem_vvvvvyj)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvyj == 1)
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
function vvvvvyk(add_php_after_getitem_vvvvvyk,gettype_vvvvvyk)
{
	if (isSet(add_php_after_getitem_vvvvvyk) && add_php_after_getitem_vvvvvyk.constructor !== Array)
	{
		var temp_vvvvvyk = add_php_after_getitem_vvvvvyk;
		var add_php_after_getitem_vvvvvyk = [];
		add_php_after_getitem_vvvvvyk.push(temp_vvvvvyk);
	}
	else if (!isSet(add_php_after_getitem_vvvvvyk))
	{
		var add_php_after_getitem_vvvvvyk = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvyk.some(add_php_after_getitem_vvvvvyk_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvykvyd_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvykvyd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvykvyd_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvykvyd_required = true;
		}
	}
}

// the vvvvvyk Some function
function add_php_after_getitem_vvvvvyk_SomeFunc(add_php_after_getitem_vvvvvyk)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvyk == 1)
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

// the vvvvvym function
function vvvvvym(gettype_vvvvvym)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvymvye_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvymvye_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvymvyf_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvymvyf_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvymvye_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvymvye_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvymvyf_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvymvyf_required = true;
		}
	}
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
function vvvvvyn(add_php_getlistquery_vvvvvyn,gettype_vvvvvyn)
{
	if (isSet(add_php_getlistquery_vvvvvyn) && add_php_getlistquery_vvvvvyn.constructor !== Array)
	{
		var temp_vvvvvyn = add_php_getlistquery_vvvvvyn;
		var add_php_getlistquery_vvvvvyn = [];
		add_php_getlistquery_vvvvvyn.push(temp_vvvvvyn);
	}
	else if (!isSet(add_php_getlistquery_vvvvvyn))
	{
		var add_php_getlistquery_vvvvvyn = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvyn.some(add_php_getlistquery_vvvvvyn_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvynvyg_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvynvyg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvynvyg_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvynvyg_required = true;
		}
	}
}

// the vvvvvyn Some function
function add_php_getlistquery_vvvvvyn_SomeFunc(add_php_getlistquery_vvvvvyn)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvyn == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyn Some function
function gettype_vvvvvyn_SomeFunc(gettype_vvvvvyn)
{
	// set the function logic
	if (gettype_vvvvvyn == 2 || gettype_vvvvvyn == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyo function
function vvvvvyo(add_php_before_getitems_vvvvvyo,gettype_vvvvvyo)
{
	if (isSet(add_php_before_getitems_vvvvvyo) && add_php_before_getitems_vvvvvyo.constructor !== Array)
	{
		var temp_vvvvvyo = add_php_before_getitems_vvvvvyo;
		var add_php_before_getitems_vvvvvyo = [];
		add_php_before_getitems_vvvvvyo.push(temp_vvvvvyo);
	}
	else if (!isSet(add_php_before_getitems_vvvvvyo))
	{
		var add_php_before_getitems_vvvvvyo = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvyo.some(add_php_before_getitems_vvvvvyo_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyovyh_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvyovyh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyovyh_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvyovyh_required = true;
		}
	}
}

// the vvvvvyo Some function
function add_php_before_getitems_vvvvvyo_SomeFunc(add_php_before_getitems_vvvvvyo)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvyo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyo Some function
function gettype_vvvvvyo_SomeFunc(gettype_vvvvvyo)
{
	// set the function logic
	if (gettype_vvvvvyo == 2 || gettype_vvvvvyo == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyp function
function vvvvvyp(add_php_after_getitems_vvvvvyp,gettype_vvvvvyp)
{
	if (isSet(add_php_after_getitems_vvvvvyp) && add_php_after_getitems_vvvvvyp.constructor !== Array)
	{
		var temp_vvvvvyp = add_php_after_getitems_vvvvvyp;
		var add_php_after_getitems_vvvvvyp = [];
		add_php_after_getitems_vvvvvyp.push(temp_vvvvvyp);
	}
	else if (!isSet(add_php_after_getitems_vvvvvyp))
	{
		var add_php_after_getitems_vvvvvyp = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvyp.some(add_php_after_getitems_vvvvvyp_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvypvyi_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvypvyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvypvyi_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvypvyi_required = true;
		}
	}
}

// the vvvvvyp Some function
function add_php_after_getitems_vvvvvyp_SomeFunc(add_php_after_getitems_vvvvvyp)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvyp == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyp Some function
function gettype_vvvvvyp_SomeFunc(gettype_vvvvvyp)
{
	// set the function logic
	if (gettype_vvvvvyp == 2 || gettype_vvvvvyp == 4)
	{
		return true;
	}
	return false;
}

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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvyrvyj_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvyrvyj_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvyrvyk_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvyrvyk_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyrvyl_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvyrvyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyrvyj_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvyrvyj_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvyrvyk_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvyrvyk_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyrvyl_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvyrvyl_required = true;
		}
	}
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvysvym_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvysvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvysvym_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvysvym_required = true;
		}
	}
}

// the vvvvvys Some function
function gettype_vvvvvys_SomeFunc(gettype_vvvvvys)
{
	// set the function logic
	if (gettype_vvvvvys == 2)
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
