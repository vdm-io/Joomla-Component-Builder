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

	@version		2.2.2
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
jform_vvvvvypvyl_required = false;
jform_vvvvvyqvym_required = false;
jform_vvvvvyrvyn_required = false;
jform_vvvvvysvyo_required = false;
jform_vvvvvytvyp_required = false;
jform_vvvvvyuvyq_required = false;
jform_vvvvvyzvyr_required = false;
jform_vvvvvzbvys_required = false;
jform_vvvvvzcvyt_required = false;
jform_vvvvvzevyu_required = false;
jform_vvvvvzevyv_required = false;
jform_vvvvvzfvyw_required = false;
jform_vvvvvzgvyx_required = false;
jform_vvvvvzhvyy_required = false;
jform_vvvvvzjvyz_required = false;
jform_vvvvvzjvza_required = false;
jform_vvvvvzjvzb_required = false;
jform_vvvvvzkvzc_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(gettype_vvvvvyp);

	var main_source_vvvvvyq = jQuery("#jform_main_source").val();
	vvvvvyq(main_source_vvvvvyq);

	var main_source_vvvvvyr = jQuery("#jform_main_source").val();
	vvvvvyr(main_source_vvvvvyr);

	var main_source_vvvvvys = jQuery("#jform_main_source").val();
	vvvvvys(main_source_vvvvvys);

	var main_source_vvvvvyt = jQuery("#jform_main_source").val();
	vvvvvyt(main_source_vvvvvyt);

	var addcalculation_vvvvvyu = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyu(addcalculation_vvvvvyu);

	var addcalculation_vvvvvyv = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(addcalculation_vvvvvyv,gettype_vvvvvyv);

	var addcalculation_vvvvvyw = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyw = jQuery("#jform_gettype").val();
	vvvvvyw(addcalculation_vvvvvyw,gettype_vvvvvyw);

	var main_source_vvvvvyz = jQuery("#jform_main_source").val();
	vvvvvyz(main_source_vvvvvyz);

	var main_source_vvvvvza = jQuery("#jform_main_source").val();
	vvvvvza(main_source_vvvvvza);

	var add_php_before_getitem_vvvvvzb = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzb = jQuery("#jform_gettype").val();
	vvvvvzb(add_php_before_getitem_vvvvvzb,gettype_vvvvvzb);

	var add_php_after_getitem_vvvvvzc = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzc = jQuery("#jform_gettype").val();
	vvvvvzc(add_php_after_getitem_vvvvvzc,gettype_vvvvvzc);

	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(gettype_vvvvvze);

	var add_php_getlistquery_vvvvvzf = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(add_php_getlistquery_vvvvvzf,gettype_vvvvvzf);

	var add_php_before_getitems_vvvvvzg = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(add_php_before_getitems_vvvvvzg,gettype_vvvvvzg);

	var add_php_after_getitems_vvvvvzh = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzh = jQuery("#jform_gettype").val();
	vvvvvzh(add_php_after_getitems_vvvvvzh,gettype_vvvvvzh);

	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(gettype_vvvvvzj);

	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(gettype_vvvvvzk);
});

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
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvypvyl_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvypvyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvypvyl_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvypvyl_required = true;
		}
	}
}

// the vvvvvyp Some function
function gettype_vvvvvyp_SomeFunc(gettype_vvvvvyp)
{
	// set the function logic
	if (gettype_vvvvvyp == 3 || gettype_vvvvvyp == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvyq function
function vvvvvyq(main_source_vvvvvyq)
{
	if (isSet(main_source_vvvvvyq) && main_source_vvvvvyq.constructor !== Array)
	{
		var temp_vvvvvyq = main_source_vvvvvyq;
		var main_source_vvvvvyq = [];
		main_source_vvvvvyq.push(temp_vvvvvyq);
	}
	else if (!isSet(main_source_vvvvvyq))
	{
		var main_source_vvvvvyq = [];
	}
	var main_source = main_source_vvvvvyq.some(main_source_vvvvvyq_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvyqvym_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvyqvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyqvym_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvyqvym_required = true;
		}
	}
}

// the vvvvvyq Some function
function main_source_vvvvvyq_SomeFunc(main_source_vvvvvyq)
{
	// set the function logic
	if (main_source_vvvvvyq == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvyrvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvyrvyn_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvysvyo_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvysvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvysvyo_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvysvyo_required = true;
		}
	}
}

// the vvvvvys Some function
function main_source_vvvvvys_SomeFunc(main_source_vvvvvys)
{
	// set the function logic
	if (main_source_vvvvvys == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvytvyp_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvytvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvytvyp_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
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
function vvvvvyu(addcalculation_vvvvvyu)
{
	// set the function logic
	if (addcalculation_vvvvvyu == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyuvyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyuvyq_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyuvyq_required = true;
		}
	}
}

// the vvvvvyv function
function vvvvvyv(addcalculation_vvvvvyv,gettype_vvvvvyv)
{
	if (isSet(addcalculation_vvvvvyv) && addcalculation_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = addcalculation_vvvvvyv;
		var addcalculation_vvvvvyv = [];
		addcalculation_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(addcalculation_vvvvvyv))
	{
		var addcalculation_vvvvvyv = [];
	}
	var addcalculation = addcalculation_vvvvvyv.some(addcalculation_vvvvvyv_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvyv Some function
function addcalculation_vvvvvyv_SomeFunc(addcalculation_vvvvvyv)
{
	// set the function logic
	if (addcalculation_vvvvvyv == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyv Some function
function gettype_vvvvvyv_SomeFunc(gettype_vvvvvyv)
{
	// set the function logic
	if (gettype_vvvvvyv == 1 || gettype_vvvvvyv == 3)
	{
		return true;
	}
	return false;
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
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
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
	if (gettype_vvvvvyw == 2 || gettype_vvvvvyw == 4)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvyzvyr_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvyzvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvyzvyr_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvyzvyr_required = true;
		}
	}
}

// the vvvvvyz Some function
function main_source_vvvvvyz_SomeFunc(main_source_vvvvvyz)
{
	// set the function logic
	if (main_source_vvvvvyz == 3)
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

// the vvvvvza Some function
function main_source_vvvvvza_SomeFunc(main_source_vvvvvza)
{
	// set the function logic
	if (main_source_vvvvvza == 1 || main_source_vvvvvza == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzb function
function vvvvvzb(add_php_before_getitem_vvvvvzb,gettype_vvvvvzb)
{
	if (isSet(add_php_before_getitem_vvvvvzb) && add_php_before_getitem_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = add_php_before_getitem_vvvvvzb;
		var add_php_before_getitem_vvvvvzb = [];
		add_php_before_getitem_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzb))
	{
		var add_php_before_getitem_vvvvvzb = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzb.some(add_php_before_getitem_vvvvvzb_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzbvys_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzbvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzbvys_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzbvys_required = true;
		}
	}
}

// the vvvvvzb Some function
function add_php_before_getitem_vvvvvzb_SomeFunc(add_php_before_getitem_vvvvvzb)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzb == 1)
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
function vvvvvzc(add_php_after_getitem_vvvvvzc,gettype_vvvvvzc)
{
	if (isSet(add_php_after_getitem_vvvvvzc) && add_php_after_getitem_vvvvvzc.constructor !== Array)
	{
		var temp_vvvvvzc = add_php_after_getitem_vvvvvzc;
		var add_php_after_getitem_vvvvvzc = [];
		add_php_after_getitem_vvvvvzc.push(temp_vvvvvzc);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzc))
	{
		var add_php_after_getitem_vvvvvzc = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzc.some(add_php_after_getitem_vvvvvzc_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzcvyt_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzcvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzcvyt_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzcvyt_required = true;
		}
	}
}

// the vvvvvzc Some function
function add_php_after_getitem_vvvvvzc_SomeFunc(add_php_after_getitem_vvvvvzc)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzc == 1)
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

// the vvvvvze function
function vvvvvze(gettype_vvvvvze)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzevyu_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzevyu_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzevyv_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzevyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzevyu_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzevyu_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzevyv_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzevyv_required = true;
		}
	}
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
function vvvvvzf(add_php_getlistquery_vvvvvzf,gettype_vvvvvzf)
{
	if (isSet(add_php_getlistquery_vvvvvzf) && add_php_getlistquery_vvvvvzf.constructor !== Array)
	{
		var temp_vvvvvzf = add_php_getlistquery_vvvvvzf;
		var add_php_getlistquery_vvvvvzf = [];
		add_php_getlistquery_vvvvvzf.push(temp_vvvvvzf);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzf))
	{
		var add_php_getlistquery_vvvvvzf = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzf.some(add_php_getlistquery_vvvvvzf_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzfvyw_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzfvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzfvyw_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzfvyw_required = true;
		}
	}
}

// the vvvvvzf Some function
function add_php_getlistquery_vvvvvzf_SomeFunc(add_php_getlistquery_vvvvvzf)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzf == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzf Some function
function gettype_vvvvvzf_SomeFunc(gettype_vvvvvzf)
{
	// set the function logic
	if (gettype_vvvvvzf == 2 || gettype_vvvvvzf == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzg function
function vvvvvzg(add_php_before_getitems_vvvvvzg,gettype_vvvvvzg)
{
	if (isSet(add_php_before_getitems_vvvvvzg) && add_php_before_getitems_vvvvvzg.constructor !== Array)
	{
		var temp_vvvvvzg = add_php_before_getitems_vvvvvzg;
		var add_php_before_getitems_vvvvvzg = [];
		add_php_before_getitems_vvvvvzg.push(temp_vvvvvzg);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzg))
	{
		var add_php_before_getitems_vvvvvzg = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzg.some(add_php_before_getitems_vvvvvzg_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzgvyx_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzgvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzgvyx_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzgvyx_required = true;
		}
	}
}

// the vvvvvzg Some function
function add_php_before_getitems_vvvvvzg_SomeFunc(add_php_before_getitems_vvvvvzg)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzg == 1)
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
function vvvvvzh(add_php_after_getitems_vvvvvzh,gettype_vvvvvzh)
{
	if (isSet(add_php_after_getitems_vvvvvzh) && add_php_after_getitems_vvvvvzh.constructor !== Array)
	{
		var temp_vvvvvzh = add_php_after_getitems_vvvvvzh;
		var add_php_after_getitems_vvvvvzh = [];
		add_php_after_getitems_vvvvvzh.push(temp_vvvvvzh);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzh))
	{
		var add_php_after_getitems_vvvvvzh = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzh.some(add_php_after_getitems_vvvvvzh_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzhvyy_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzhvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzhvyy_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzhvyy_required = true;
		}
	}
}

// the vvvvvzh Some function
function add_php_after_getitems_vvvvvzh_SomeFunc(add_php_after_getitems_vvvvvzh)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzh == 1)
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

// the vvvvvzj function
function vvvvvzj(gettype_vvvvvzj)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzjvyz_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzjvyz_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzjvza_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzjvza_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzjvzb_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzjvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzjvyz_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzjvyz_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzjvza_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzjvza_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzjvzb_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzjvzb_required = true;
		}
	}
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzkvzc_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzkvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzkvzc_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzkvzc_required = true;
		}
	}
}

// the vvvvvzk Some function
function gettype_vvvvvzk_SomeFunc(gettype_vvvvvzk)
{
	// set the function logic
	if (gettype_vvvvvzk == 2)
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
