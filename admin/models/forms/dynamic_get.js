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

	@version		2.1.1
	@build			1st March, 2016
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
jform_vvvvvxvvxv_required = false;
jform_vvvvvxwvxw_required = false;
jform_vvvvvxxvxx_required = false;
jform_vvvvvxyvxy_required = false;
jform_vvvvvxzvxz_required = false;
jform_vvvvvyavya_required = false;
jform_vvvvvyfvyb_required = false;
jform_vvvvvyhvyc_required = false;
jform_vvvvvyivyd_required = false;
jform_vvvvvykvye_required = false;
jform_vvvvvykvyf_required = false;
jform_vvvvvylvyg_required = false;
jform_vvvvvymvyh_required = false;
jform_vvvvvynvyi_required = false;
jform_vvvvvypvyj_required = false;
jform_vvvvvypvyk_required = false;
jform_vvvvvypvyl_required = false;
jform_vvvvvyqvym_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvxv = jQuery("#jform_gettype").val();
	vvvvvxv(gettype_vvvvvxv);

	var main_source_vvvvvxw = jQuery("#jform_main_source").val();
	vvvvvxw(main_source_vvvvvxw);

	var main_source_vvvvvxx = jQuery("#jform_main_source").val();
	vvvvvxx(main_source_vvvvvxx);

	var main_source_vvvvvxy = jQuery("#jform_main_source").val();
	vvvvvxy(main_source_vvvvvxy);

	var main_source_vvvvvxz = jQuery("#jform_main_source").val();
	vvvvvxz(main_source_vvvvvxz);

	var addcalculation_vvvvvya = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvya(addcalculation_vvvvvya);

	var addcalculation_vvvvvyb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyb = jQuery("#jform_gettype").val();
	vvvvvyb(addcalculation_vvvvvyb,gettype_vvvvvyb);

	var addcalculation_vvvvvyc = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyc = jQuery("#jform_gettype").val();
	vvvvvyc(addcalculation_vvvvvyc,gettype_vvvvvyc);

	var main_source_vvvvvyf = jQuery("#jform_main_source").val();
	vvvvvyf(main_source_vvvvvyf);

	var main_source_vvvvvyg = jQuery("#jform_main_source").val();
	vvvvvyg(main_source_vvvvvyg);

	var add_php_before_getitem_vvvvvyh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyh = jQuery("#jform_gettype").val();
	vvvvvyh(add_php_before_getitem_vvvvvyh,gettype_vvvvvyh);

	var add_php_after_getitem_vvvvvyi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyi = jQuery("#jform_gettype").val();
	vvvvvyi(add_php_after_getitem_vvvvvyi,gettype_vvvvvyi);

	var gettype_vvvvvyk = jQuery("#jform_gettype").val();
	vvvvvyk(gettype_vvvvvyk);

	var add_php_getlistquery_vvvvvyl = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyl = jQuery("#jform_gettype").val();
	vvvvvyl(add_php_getlistquery_vvvvvyl,gettype_vvvvvyl);

	var add_php_before_getitems_vvvvvym = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvym = jQuery("#jform_gettype").val();
	vvvvvym(add_php_before_getitems_vvvvvym,gettype_vvvvvym);

	var add_php_after_getitems_vvvvvyn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvyn = jQuery("#jform_gettype").val();
	vvvvvyn(add_php_after_getitems_vvvvvyn,gettype_vvvvvyn);

	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(gettype_vvvvvyp);

	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(gettype_vvvvvyq);
});

// the vvvvvxv function
function vvvvvxv(gettype_vvvvvxv)
{
	if (isSet(gettype_vvvvvxv) && gettype_vvvvvxv.constructor !== Array)
	{
		var temp_vvvvvxv = gettype_vvvvvxv;
		var gettype_vvvvvxv = [];
		gettype_vvvvvxv.push(temp_vvvvvxv);
	}
	else if (!isSet(gettype_vvvvvxv))
	{
		var gettype_vvvvvxv = [];
	}
	var gettype = gettype_vvvvvxv.some(gettype_vvvvvxv_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvxvvxv_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvxvvxv_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvxvvxv_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvxvvxv_required = true;
		}
	}
}

// the vvvvvxv Some function
function gettype_vvvvvxv_SomeFunc(gettype_vvvvvxv)
{
	// set the function logic
	if (gettype_vvvvvxv == 3 || gettype_vvvvvxv == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvxw function
function vvvvvxw(main_source_vvvvvxw)
{
	if (isSet(main_source_vvvvvxw) && main_source_vvvvvxw.constructor !== Array)
	{
		var temp_vvvvvxw = main_source_vvvvvxw;
		var main_source_vvvvvxw = [];
		main_source_vvvvvxw.push(temp_vvvvvxw);
	}
	else if (!isSet(main_source_vvvvvxw))
	{
		var main_source_vvvvvxw = [];
	}
	var main_source = main_source_vvvvvxw.some(main_source_vvvvvxw_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvxwvxw_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvxwvxw_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvxwvxw_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvxwvxw_required = true;
		}
	}
}

// the vvvvvxw Some function
function main_source_vvvvvxw_SomeFunc(main_source_vvvvvxw)
{
	// set the function logic
	if (main_source_vvvvvxw == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvxx function
function vvvvvxx(main_source_vvvvvxx)
{
	if (isSet(main_source_vvvvvxx) && main_source_vvvvvxx.constructor !== Array)
	{
		var temp_vvvvvxx = main_source_vvvvvxx;
		var main_source_vvvvvxx = [];
		main_source_vvvvvxx.push(temp_vvvvvxx);
	}
	else if (!isSet(main_source_vvvvvxx))
	{
		var main_source_vvvvvxx = [];
	}
	var main_source = main_source_vvvvvxx.some(main_source_vvvvvxx_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvxxvxx_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvxxvxx_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvxxvxx_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvxxvxx_required = true;
		}
	}
}

// the vvvvvxx Some function
function main_source_vvvvvxx_SomeFunc(main_source_vvvvvxx)
{
	// set the function logic
	if (main_source_vvvvvxx == 1)
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvxyvxy_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvxyvxy_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvxyvxy_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvxyvxy_required = true;
		}
	}
}

// the vvvvvxy Some function
function main_source_vvvvvxy_SomeFunc(main_source_vvvvvxy)
{
	// set the function logic
	if (main_source_vvvvvxy == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvxzvxz_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvxzvxz_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvxzvxz_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvxzvxz_required = true;
		}
	}
}

// the vvvvvxz Some function
function main_source_vvvvvxz_SomeFunc(main_source_vvvvvxz)
{
	// set the function logic
	if (main_source_vvvvvxz == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvya function
function vvvvvya(addcalculation_vvvvvya)
{
	// set the function logic
	if (addcalculation_vvvvvya == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyavya_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyavya_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyavya_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyavya_required = true;
		}
	}
}

// the vvvvvyb function
function vvvvvyb(addcalculation_vvvvvyb,gettype_vvvvvyb)
{
	if (isSet(addcalculation_vvvvvyb) && addcalculation_vvvvvyb.constructor !== Array)
	{
		var temp_vvvvvyb = addcalculation_vvvvvyb;
		var addcalculation_vvvvvyb = [];
		addcalculation_vvvvvyb.push(temp_vvvvvyb);
	}
	else if (!isSet(addcalculation_vvvvvyb))
	{
		var addcalculation_vvvvvyb = [];
	}
	var addcalculation = addcalculation_vvvvvyb.some(addcalculation_vvvvvyb_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvyb Some function
function addcalculation_vvvvvyb_SomeFunc(addcalculation_vvvvvyb)
{
	// set the function logic
	if (addcalculation_vvvvvyb == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyb Some function
function gettype_vvvvvyb_SomeFunc(gettype_vvvvvyb)
{
	// set the function logic
	if (gettype_vvvvvyb == 1 || gettype_vvvvvyb == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyc function
function vvvvvyc(addcalculation_vvvvvyc,gettype_vvvvvyc)
{
	if (isSet(addcalculation_vvvvvyc) && addcalculation_vvvvvyc.constructor !== Array)
	{
		var temp_vvvvvyc = addcalculation_vvvvvyc;
		var addcalculation_vvvvvyc = [];
		addcalculation_vvvvvyc.push(temp_vvvvvyc);
	}
	else if (!isSet(addcalculation_vvvvvyc))
	{
		var addcalculation_vvvvvyc = [];
	}
	var addcalculation = addcalculation_vvvvvyc.some(addcalculation_vvvvvyc_SomeFunc);

	if (isSet(gettype_vvvvvyc) && gettype_vvvvvyc.constructor !== Array)
	{
		var temp_vvvvvyc = gettype_vvvvvyc;
		var gettype_vvvvvyc = [];
		gettype_vvvvvyc.push(temp_vvvvvyc);
	}
	else if (!isSet(gettype_vvvvvyc))
	{
		var gettype_vvvvvyc = [];
	}
	var gettype = gettype_vvvvvyc.some(gettype_vvvvvyc_SomeFunc);


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

// the vvvvvyc Some function
function addcalculation_vvvvvyc_SomeFunc(addcalculation_vvvvvyc)
{
	// set the function logic
	if (addcalculation_vvvvvyc == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyc Some function
function gettype_vvvvvyc_SomeFunc(gettype_vvvvvyc)
{
	// set the function logic
	if (gettype_vvvvvyc == 2 || gettype_vvvvvyc == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvyfvyb_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvyfvyb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvyfvyb_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvyfvyb_required = true;
		}
	}
}

// the vvvvvyf Some function
function main_source_vvvvvyf_SomeFunc(main_source_vvvvvyf)
{
	// set the function logic
	if (main_source_vvvvvyf == 3)
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

// the vvvvvyg Some function
function main_source_vvvvvyg_SomeFunc(main_source_vvvvvyg)
{
	// set the function logic
	if (main_source_vvvvvyg == 1 || main_source_vvvvvyg == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyh function
function vvvvvyh(add_php_before_getitem_vvvvvyh,gettype_vvvvvyh)
{
	if (isSet(add_php_before_getitem_vvvvvyh) && add_php_before_getitem_vvvvvyh.constructor !== Array)
	{
		var temp_vvvvvyh = add_php_before_getitem_vvvvvyh;
		var add_php_before_getitem_vvvvvyh = [];
		add_php_before_getitem_vvvvvyh.push(temp_vvvvvyh);
	}
	else if (!isSet(add_php_before_getitem_vvvvvyh))
	{
		var add_php_before_getitem_vvvvvyh = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvyh.some(add_php_before_getitem_vvvvvyh_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvyhvyc_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvyhvyc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyhvyc_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvyhvyc_required = true;
		}
	}
}

// the vvvvvyh Some function
function add_php_before_getitem_vvvvvyh_SomeFunc(add_php_before_getitem_vvvvvyh)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvyh == 1)
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
function vvvvvyi(add_php_after_getitem_vvvvvyi,gettype_vvvvvyi)
{
	if (isSet(add_php_after_getitem_vvvvvyi) && add_php_after_getitem_vvvvvyi.constructor !== Array)
	{
		var temp_vvvvvyi = add_php_after_getitem_vvvvvyi;
		var add_php_after_getitem_vvvvvyi = [];
		add_php_after_getitem_vvvvvyi.push(temp_vvvvvyi);
	}
	else if (!isSet(add_php_after_getitem_vvvvvyi))
	{
		var add_php_after_getitem_vvvvvyi = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvyi.some(add_php_after_getitem_vvvvvyi_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvyivyd_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvyivyd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyivyd_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvyivyd_required = true;
		}
	}
}

// the vvvvvyi Some function
function add_php_after_getitem_vvvvvyi_SomeFunc(add_php_after_getitem_vvvvvyi)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvyi == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyi Some function
function gettype_vvvvvyi_SomeFunc(gettype_vvvvvyi)
{
	// set the function logic
	if (gettype_vvvvvyi == 1 || gettype_vvvvvyi == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyk function
function vvvvvyk(gettype_vvvvvyk)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvykvye_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvykvye_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvykvyf_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvykvyf_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvykvye_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvykvye_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvykvyf_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvykvyf_required = true;
		}
	}
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
function vvvvvyl(add_php_getlistquery_vvvvvyl,gettype_vvvvvyl)
{
	if (isSet(add_php_getlistquery_vvvvvyl) && add_php_getlistquery_vvvvvyl.constructor !== Array)
	{
		var temp_vvvvvyl = add_php_getlistquery_vvvvvyl;
		var add_php_getlistquery_vvvvvyl = [];
		add_php_getlistquery_vvvvvyl.push(temp_vvvvvyl);
	}
	else if (!isSet(add_php_getlistquery_vvvvvyl))
	{
		var add_php_getlistquery_vvvvvyl = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvyl.some(add_php_getlistquery_vvvvvyl_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvylvyg_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvylvyg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvylvyg_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvylvyg_required = true;
		}
	}
}

// the vvvvvyl Some function
function add_php_getlistquery_vvvvvyl_SomeFunc(add_php_getlistquery_vvvvvyl)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvyl == 1)
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

// the vvvvvym function
function vvvvvym(add_php_before_getitems_vvvvvym,gettype_vvvvvym)
{
	if (isSet(add_php_before_getitems_vvvvvym) && add_php_before_getitems_vvvvvym.constructor !== Array)
	{
		var temp_vvvvvym = add_php_before_getitems_vvvvvym;
		var add_php_before_getitems_vvvvvym = [];
		add_php_before_getitems_vvvvvym.push(temp_vvvvvym);
	}
	else if (!isSet(add_php_before_getitems_vvvvvym))
	{
		var add_php_before_getitems_vvvvvym = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvym.some(add_php_before_getitems_vvvvvym_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvymvyh_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvymvyh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvymvyh_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvymvyh_required = true;
		}
	}
}

// the vvvvvym Some function
function add_php_before_getitems_vvvvvym_SomeFunc(add_php_before_getitems_vvvvvym)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvym == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvym Some function
function gettype_vvvvvym_SomeFunc(gettype_vvvvvym)
{
	// set the function logic
	if (gettype_vvvvvym == 2 || gettype_vvvvvym == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyn function
function vvvvvyn(add_php_after_getitems_vvvvvyn,gettype_vvvvvyn)
{
	if (isSet(add_php_after_getitems_vvvvvyn) && add_php_after_getitems_vvvvvyn.constructor !== Array)
	{
		var temp_vvvvvyn = add_php_after_getitems_vvvvvyn;
		var add_php_after_getitems_vvvvvyn = [];
		add_php_after_getitems_vvvvvyn.push(temp_vvvvvyn);
	}
	else if (!isSet(add_php_after_getitems_vvvvvyn))
	{
		var add_php_after_getitems_vvvvvyn = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvyn.some(add_php_after_getitems_vvvvvyn_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvynvyi_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvynvyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvynvyi_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvynvyi_required = true;
		}
	}
}

// the vvvvvyn Some function
function add_php_after_getitems_vvvvvyn_SomeFunc(add_php_after_getitems_vvvvvyn)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvyn == 1)
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
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvypvyj_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvypvyj_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvypvyk_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvypvyk_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvypvyl_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvypvyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvypvyj_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvypvyj_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvypvyk_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvypvyk_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvypvyl_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvypvyl_required = true;
		}
	}
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvyqvym_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvyqvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvyqvym_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvyqvym_required = true;
		}
	}
}

// the vvvvvyq Some function
function gettype_vvvvvyq_SomeFunc(gettype_vvvvvyq)
{
	// set the function logic
	if (gettype_vvvvvyq == 2)
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
