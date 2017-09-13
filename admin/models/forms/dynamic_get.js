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

	@version		@update number 84 of this MVC
	@build			4th May, 2017
	@created		21st May, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvytvyx_required = false;
jform_vvvvvyuvyy_required = false;
jform_vvvvvyvvyz_required = false;
jform_vvvvvywvza_required = false;
jform_vvvvvyxvzb_required = false;
jform_vvvvvyyvzc_required = false;
jform_vvvvvzdvzd_required = false;
jform_vvvvvzfvze_required = false;
jform_vvvvvzgvzf_required = false;
jform_vvvvvzivzg_required = false;
jform_vvvvvzivzh_required = false;
jform_vvvvvzjvzi_required = false;
jform_vvvvvzkvzj_required = false;
jform_vvvvvzlvzk_required = false;
jform_vvvvvznvzl_required = false;
jform_vvvvvznvzm_required = false;
jform_vvvvvznvzn_required = false;
jform_vvvvvzovzo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyt = jQuery("#jform_gettype").val();
	vvvvvyt(gettype_vvvvvyt);

	var main_source_vvvvvyu = jQuery("#jform_main_source").val();
	vvvvvyu(main_source_vvvvvyu);

	var main_source_vvvvvyv = jQuery("#jform_main_source").val();
	vvvvvyv(main_source_vvvvvyv);

	var main_source_vvvvvyw = jQuery("#jform_main_source").val();
	vvvvvyw(main_source_vvvvvyw);

	var main_source_vvvvvyx = jQuery("#jform_main_source").val();
	vvvvvyx(main_source_vvvvvyx);

	var addcalculation_vvvvvyy = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyy(addcalculation_vvvvvyy);

	var addcalculation_vvvvvyz = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyz = jQuery("#jform_gettype").val();
	vvvvvyz(addcalculation_vvvvvyz,gettype_vvvvvyz);

	var addcalculation_vvvvvza = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvza = jQuery("#jform_gettype").val();
	vvvvvza(addcalculation_vvvvvza,gettype_vvvvvza);

	var main_source_vvvvvzd = jQuery("#jform_main_source").val();
	vvvvvzd(main_source_vvvvvzd);

	var main_source_vvvvvze = jQuery("#jform_main_source").val();
	vvvvvze(main_source_vvvvvze);

	var add_php_before_getitem_vvvvvzf = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(add_php_before_getitem_vvvvvzf,gettype_vvvvvzf);

	var add_php_after_getitem_vvvvvzg = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzg = jQuery("#jform_gettype").val();
	vvvvvzg(add_php_after_getitem_vvvvvzg,gettype_vvvvvzg);

	var gettype_vvvvvzi = jQuery("#jform_gettype").val();
	vvvvvzi(gettype_vvvvvzi);

	var add_php_getlistquery_vvvvvzj = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzj = jQuery("#jform_gettype").val();
	vvvvvzj(add_php_getlistquery_vvvvvzj,gettype_vvvvvzj);

	var add_php_before_getitems_vvvvvzk = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_before_getitems_vvvvvzk,gettype_vvvvvzk);

	var add_php_after_getitems_vvvvvzl = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_after_getitems_vvvvvzl,gettype_vvvvvzl);

	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(gettype_vvvvvzn);

	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(gettype_vvvvvzo);
});

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
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvytvyx_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvytvyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvytvyx_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvytvyx_required = true;
		}
	}
}

// the vvvvvyt Some function
function gettype_vvvvvyt_SomeFunc(gettype_vvvvvyt)
{
	// set the function logic
	if (gettype_vvvvvyt == 3 || gettype_vvvvvyt == 4)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvyuvyy_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvyuvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyuvyy_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvyuvyy_required = true;
		}
	}
}

// the vvvvvyu Some function
function main_source_vvvvvyu_SomeFunc(main_source_vvvvvyu)
{
	// set the function logic
	if (main_source_vvvvvyu == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvyvvyz_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvyvvyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvyvvyz_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvyvvyz_required = true;
		}
	}
}

// the vvvvvyv Some function
function main_source_vvvvvyv_SomeFunc(main_source_vvvvvyv)
{
	// set the function logic
	if (main_source_vvvvvyv == 1)
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvywvza_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvywvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvywvza_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvywvza_required = true;
		}
	}
}

// the vvvvvyw Some function
function main_source_vvvvvyw_SomeFunc(main_source_vvvvvyw)
{
	// set the function logic
	if (main_source_vvvvvyw == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvyxvzb_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvyxvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvyxvzb_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvyxvzb_required = true;
		}
	}
}

// the vvvvvyx Some function
function main_source_vvvvvyx_SomeFunc(main_source_vvvvvyx)
{
	// set the function logic
	if (main_source_vvvvvyx == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyy function
function vvvvvyy(addcalculation_vvvvvyy)
{
	// set the function logic
	if (addcalculation_vvvvvyy == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyyvzc_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyyvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyyvzc_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyyvzc_required = true;
		}
	}
}

// the vvvvvyz function
function vvvvvyz(addcalculation_vvvvvyz,gettype_vvvvvyz)
{
	if (isSet(addcalculation_vvvvvyz) && addcalculation_vvvvvyz.constructor !== Array)
	{
		var temp_vvvvvyz = addcalculation_vvvvvyz;
		var addcalculation_vvvvvyz = [];
		addcalculation_vvvvvyz.push(temp_vvvvvyz);
	}
	else if (!isSet(addcalculation_vvvvvyz))
	{
		var addcalculation_vvvvvyz = [];
	}
	var addcalculation = addcalculation_vvvvvyz.some(addcalculation_vvvvvyz_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvyz Some function
function addcalculation_vvvvvyz_SomeFunc(addcalculation_vvvvvyz)
{
	// set the function logic
	if (addcalculation_vvvvvyz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyz Some function
function gettype_vvvvvyz_SomeFunc(gettype_vvvvvyz)
{
	// set the function logic
	if (gettype_vvvvvyz == 1 || gettype_vvvvvyz == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvza function
function vvvvvza(addcalculation_vvvvvza,gettype_vvvvvza)
{
	if (isSet(addcalculation_vvvvvza) && addcalculation_vvvvvza.constructor !== Array)
	{
		var temp_vvvvvza = addcalculation_vvvvvza;
		var addcalculation_vvvvvza = [];
		addcalculation_vvvvvza.push(temp_vvvvvza);
	}
	else if (!isSet(addcalculation_vvvvvza))
	{
		var addcalculation_vvvvvza = [];
	}
	var addcalculation = addcalculation_vvvvvza.some(addcalculation_vvvvvza_SomeFunc);

	if (isSet(gettype_vvvvvza) && gettype_vvvvvza.constructor !== Array)
	{
		var temp_vvvvvza = gettype_vvvvvza;
		var gettype_vvvvvza = [];
		gettype_vvvvvza.push(temp_vvvvvza);
	}
	else if (!isSet(gettype_vvvvvza))
	{
		var gettype_vvvvvza = [];
	}
	var gettype = gettype_vvvvvza.some(gettype_vvvvvza_SomeFunc);


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

// the vvvvvza Some function
function addcalculation_vvvvvza_SomeFunc(addcalculation_vvvvvza)
{
	// set the function logic
	if (addcalculation_vvvvvza == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvza Some function
function gettype_vvvvvza_SomeFunc(gettype_vvvvvza)
{
	// set the function logic
	if (gettype_vvvvvza == 2 || gettype_vvvvvza == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(main_source_vvvvvzd)
{
	if (isSet(main_source_vvvvvzd) && main_source_vvvvvzd.constructor !== Array)
	{
		var temp_vvvvvzd = main_source_vvvvvzd;
		var main_source_vvvvvzd = [];
		main_source_vvvvvzd.push(temp_vvvvvzd);
	}
	else if (!isSet(main_source_vvvvvzd))
	{
		var main_source_vvvvvzd = [];
	}
	var main_source = main_source_vvvvvzd.some(main_source_vvvvvzd_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzdvzd_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzdvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzdvzd_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzdvzd_required = true;
		}
	}
}

// the vvvvvzd Some function
function main_source_vvvvvzd_SomeFunc(main_source_vvvvvzd)
{
	// set the function logic
	if (main_source_vvvvvzd == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvze function
function vvvvvze(main_source_vvvvvze)
{
	if (isSet(main_source_vvvvvze) && main_source_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = main_source_vvvvvze;
		var main_source_vvvvvze = [];
		main_source_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(main_source_vvvvvze))
	{
		var main_source_vvvvvze = [];
	}
	var main_source = main_source_vvvvvze.some(main_source_vvvvvze_SomeFunc);


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

// the vvvvvze Some function
function main_source_vvvvvze_SomeFunc(main_source_vvvvvze)
{
	// set the function logic
	if (main_source_vvvvvze == 1 || main_source_vvvvvze == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzf function
function vvvvvzf(add_php_before_getitem_vvvvvzf,gettype_vvvvvzf)
{
	if (isSet(add_php_before_getitem_vvvvvzf) && add_php_before_getitem_vvvvvzf.constructor !== Array)
	{
		var temp_vvvvvzf = add_php_before_getitem_vvvvvzf;
		var add_php_before_getitem_vvvvvzf = [];
		add_php_before_getitem_vvvvvzf.push(temp_vvvvvzf);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzf))
	{
		var add_php_before_getitem_vvvvvzf = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzf.some(add_php_before_getitem_vvvvvzf_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzfvze_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzfvze_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzfvze_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzfvze_required = true;
		}
	}
}

// the vvvvvzf Some function
function add_php_before_getitem_vvvvvzf_SomeFunc(add_php_before_getitem_vvvvvzf)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzf == 1)
	{
		return true;
	}
	return false;
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
function vvvvvzg(add_php_after_getitem_vvvvvzg,gettype_vvvvvzg)
{
	if (isSet(add_php_after_getitem_vvvvvzg) && add_php_after_getitem_vvvvvzg.constructor !== Array)
	{
		var temp_vvvvvzg = add_php_after_getitem_vvvvvzg;
		var add_php_after_getitem_vvvvvzg = [];
		add_php_after_getitem_vvvvvzg.push(temp_vvvvvzg);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzg))
	{
		var add_php_after_getitem_vvvvvzg = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzg.some(add_php_after_getitem_vvvvvzg_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzgvzf_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzgvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzgvzf_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzgvzf_required = true;
		}
	}
}

// the vvvvvzg Some function
function add_php_after_getitem_vvvvvzg_SomeFunc(add_php_after_getitem_vvvvvzg)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzg == 1)
	{
		return true;
	}
	return false;
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

// the vvvvvzi function
function vvvvvzi(gettype_vvvvvzi)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzivzg_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvzivzg_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzivzh_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvzivzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzivzg_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvzivzg_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzivzh_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvzivzh_required = true;
		}
	}
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

// the vvvvvzj function
function vvvvvzj(add_php_getlistquery_vvvvvzj,gettype_vvvvvzj)
{
	if (isSet(add_php_getlistquery_vvvvvzj) && add_php_getlistquery_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = add_php_getlistquery_vvvvvzj;
		var add_php_getlistquery_vvvvvzj = [];
		add_php_getlistquery_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzj))
	{
		var add_php_getlistquery_vvvvvzj = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzj.some(add_php_getlistquery_vvvvvzj_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzjvzi_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzjvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzjvzi_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzjvzi_required = true;
		}
	}
}

// the vvvvvzj Some function
function add_php_getlistquery_vvvvvzj_SomeFunc(add_php_getlistquery_vvvvvzj)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzj == 1)
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

// the vvvvvzk function
function vvvvvzk(add_php_before_getitems_vvvvvzk,gettype_vvvvvzk)
{
	if (isSet(add_php_before_getitems_vvvvvzk) && add_php_before_getitems_vvvvvzk.constructor !== Array)
	{
		var temp_vvvvvzk = add_php_before_getitems_vvvvvzk;
		var add_php_before_getitems_vvvvvzk = [];
		add_php_before_getitems_vvvvvzk.push(temp_vvvvvzk);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzk))
	{
		var add_php_before_getitems_vvvvvzk = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzk.some(add_php_before_getitems_vvvvvzk_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzkvzj_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzkvzj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzkvzj_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzkvzj_required = true;
		}
	}
}

// the vvvvvzk Some function
function add_php_before_getitems_vvvvvzk_SomeFunc(add_php_before_getitems_vvvvvzk)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzk == 1)
	{
		return true;
	}
	return false;
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
function vvvvvzl(add_php_after_getitems_vvvvvzl,gettype_vvvvvzl)
{
	if (isSet(add_php_after_getitems_vvvvvzl) && add_php_after_getitems_vvvvvzl.constructor !== Array)
	{
		var temp_vvvvvzl = add_php_after_getitems_vvvvvzl;
		var add_php_after_getitems_vvvvvzl = [];
		add_php_after_getitems_vvvvvzl.push(temp_vvvvvzl);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzl))
	{
		var add_php_after_getitems_vvvvvzl = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzl.some(add_php_after_getitems_vvvvvzl_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzlvzk_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzlvzk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzlvzk_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzlvzk_required = true;
		}
	}
}

// the vvvvvzl Some function
function add_php_after_getitems_vvvvvzl_SomeFunc(add_php_after_getitems_vvvvvzl)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzl == 1)
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

// the vvvvvzn function
function vvvvvzn(gettype_vvvvvzn)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvznvzl_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvznvzl_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvznvzm_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvznvzm_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvznvzn_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvznvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvznvzl_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvznvzl_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvznvzm_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvznvzm_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvznvzn_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvznvzn_required = true;
		}
	}
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

// the vvvvvzo function
function vvvvvzo(gettype_vvvvvzo)
{
	if (isSet(gettype_vvvvvzo) && gettype_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = gettype_vvvvvzo;
		var gettype_vvvvvzo = [];
		gettype_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(gettype_vvvvvzo))
	{
		var gettype_vvvvvzo = [];
	}
	var gettype = gettype_vvvvvzo.some(gettype_vvvvvzo_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzovzo_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzovzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzovzo_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzovzo_required = true;
		}
	}
}

// the vvvvvzo Some function
function gettype_vvvvvzo_SomeFunc(gettype_vvvvvzo)
{
	// set the function logic
	if (gettype_vvvvvzo == 2)
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
		var textArea = 'textarea#'+key+'-jform_join_'+type+'_table_fields_selection';
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
