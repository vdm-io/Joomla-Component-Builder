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

	@version		2.2.0
	@build			31st October, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvyjvyl_required = false;
jform_vvvvvykvym_required = false;
jform_vvvvvylvyn_required = false;
jform_vvvvvymvyo_required = false;
jform_vvvvvynvyp_required = false;
jform_vvvvvyovyq_required = false;
jform_vvvvvytvyr_required = false;
jform_vvvvvyvvys_required = false;
jform_vvvvvywvyt_required = false;
jform_vvvvvyyvyu_required = false;
jform_vvvvvyyvyv_required = false;
jform_vvvvvyzvyw_required = false;
jform_vvvvvzavyx_required = false;
jform_vvvvvzbvyy_required = false;
jform_vvvvvzdvyz_required = false;
jform_vvvvvzdvza_required = false;
jform_vvvvvzdvzb_required = false;
jform_vvvvvzevzc_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyj = jQuery("#jform_gettype").val();
	vvvvvyj(gettype_vvvvvyj);

	var main_source_vvvvvyk = jQuery("#jform_main_source").val();
	vvvvvyk(main_source_vvvvvyk);

	var main_source_vvvvvyl = jQuery("#jform_main_source").val();
	vvvvvyl(main_source_vvvvvyl);

	var main_source_vvvvvym = jQuery("#jform_main_source").val();
	vvvvvym(main_source_vvvvvym);

	var main_source_vvvvvyn = jQuery("#jform_main_source").val();
	vvvvvyn(main_source_vvvvvyn);

	var addcalculation_vvvvvyo = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvyo(addcalculation_vvvvvyo);

	var addcalculation_vvvvvyp = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyp = jQuery("#jform_gettype").val();
	vvvvvyp(addcalculation_vvvvvyp,gettype_vvvvvyp);

	var addcalculation_vvvvvyq = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvyq = jQuery("#jform_gettype").val();
	vvvvvyq(addcalculation_vvvvvyq,gettype_vvvvvyq);

	var main_source_vvvvvyt = jQuery("#jform_main_source").val();
	vvvvvyt(main_source_vvvvvyt);

	var main_source_vvvvvyu = jQuery("#jform_main_source").val();
	vvvvvyu(main_source_vvvvvyu);

	var add_php_before_getitem_vvvvvyv = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyv = jQuery("#jform_gettype").val();
	vvvvvyv(add_php_before_getitem_vvvvvyv,gettype_vvvvvyv);

	var add_php_after_getitem_vvvvvyw = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvyw = jQuery("#jform_gettype").val();
	vvvvvyw(add_php_after_getitem_vvvvvyw,gettype_vvvvvyw);

	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(gettype_vvvvvyy);

	var add_php_getlistquery_vvvvvyz = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvyz = jQuery("#jform_gettype").val();
	vvvvvyz(add_php_getlistquery_vvvvvyz,gettype_vvvvvyz);

	var add_php_before_getitems_vvvvvza = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvza = jQuery("#jform_gettype").val();
	vvvvvza(add_php_before_getitems_vvvvvza,gettype_vvvvvza);

	var add_php_after_getitems_vvvvvzb = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzb = jQuery("#jform_gettype").val();
	vvvvvzb(add_php_after_getitems_vvvvvzb,gettype_vvvvvzb);

	var gettype_vvvvvzd = jQuery("#jform_gettype").val();
	vvvvvzd(gettype_vvvvvzd);

	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(gettype_vvvvvze);
});

// the vvvvvyj function
function vvvvvyj(gettype_vvvvvyj)
{
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
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvyjvyl_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvyjvyl_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvyjvyl_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvyjvyl_required = true;
		}
	}
}

// the vvvvvyj Some function
function gettype_vvvvvyj_SomeFunc(gettype_vvvvvyj)
{
	// set the function logic
	if (gettype_vvvvvyj == 3 || gettype_vvvvvyj == 4)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvykvym_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvykvym_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvykvym_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvykvym_required = true;
		}
	}
}

// the vvvvvyk Some function
function main_source_vvvvvyk_SomeFunc(main_source_vvvvvyk)
{
	// set the function logic
	if (main_source_vvvvvyk == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvylvyn_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvylvyn_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvylvyn_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvylvyn_required = true;
		}
	}
}

// the vvvvvyl Some function
function main_source_vvvvvyl_SomeFunc(main_source_vvvvvyl)
{
	// set the function logic
	if (main_source_vvvvvyl == 1)
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
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvymvyo_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvymvyo_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvymvyo_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvymvyo_required = true;
		}
	}
}

// the vvvvvym Some function
function main_source_vvvvvym_SomeFunc(main_source_vvvvvym)
{
	// set the function logic
	if (main_source_vvvvvym == 2)
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
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvynvyp_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvynvyp_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvynvyp_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvynvyp_required = true;
		}
	}
}

// the vvvvvyn Some function
function main_source_vvvvvyn_SomeFunc(main_source_vvvvvyn)
{
	// set the function logic
	if (main_source_vvvvvyn == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyo function
function vvvvvyo(addcalculation_vvvvvyo)
{
	// set the function logic
	if (addcalculation_vvvvvyo == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvyovyq_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvyovyq_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvyovyq_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvyovyq_required = true;
		}
	}
}

// the vvvvvyp function
function vvvvvyp(addcalculation_vvvvvyp,gettype_vvvvvyp)
{
	if (isSet(addcalculation_vvvvvyp) && addcalculation_vvvvvyp.constructor !== Array)
	{
		var temp_vvvvvyp = addcalculation_vvvvvyp;
		var addcalculation_vvvvvyp = [];
		addcalculation_vvvvvyp.push(temp_vvvvvyp);
	}
	else if (!isSet(addcalculation_vvvvvyp))
	{
		var addcalculation_vvvvvyp = [];
	}
	var addcalculation = addcalculation_vvvvvyp.some(addcalculation_vvvvvyp_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvyp Some function
function addcalculation_vvvvvyp_SomeFunc(addcalculation_vvvvvyp)
{
	// set the function logic
	if (addcalculation_vvvvvyp == 1)
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
function vvvvvyq(addcalculation_vvvvvyq,gettype_vvvvvyq)
{
	if (isSet(addcalculation_vvvvvyq) && addcalculation_vvvvvyq.constructor !== Array)
	{
		var temp_vvvvvyq = addcalculation_vvvvvyq;
		var addcalculation_vvvvvyq = [];
		addcalculation_vvvvvyq.push(temp_vvvvvyq);
	}
	else if (!isSet(addcalculation_vvvvvyq))
	{
		var addcalculation_vvvvvyq = [];
	}
	var addcalculation = addcalculation_vvvvvyq.some(addcalculation_vvvvvyq_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
	}
}

// the vvvvvyq Some function
function addcalculation_vvvvvyq_SomeFunc(addcalculation_vvvvvyq)
{
	// set the function logic
	if (addcalculation_vvvvvyq == 1)
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
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvytvyr_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvytvyr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvytvyr_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvytvyr_required = true;
		}
	}
}

// the vvvvvyt Some function
function main_source_vvvvvyt_SomeFunc(main_source_vvvvvyt)
{
	// set the function logic
	if (main_source_vvvvvyt == 3)
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

// the vvvvvyu Some function
function main_source_vvvvvyu_SomeFunc(main_source_vvvvvyu)
{
	// set the function logic
	if (main_source_vvvvvyu == 1 || main_source_vvvvvyu == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvyv function
function vvvvvyv(add_php_before_getitem_vvvvvyv,gettype_vvvvvyv)
{
	if (isSet(add_php_before_getitem_vvvvvyv) && add_php_before_getitem_vvvvvyv.constructor !== Array)
	{
		var temp_vvvvvyv = add_php_before_getitem_vvvvvyv;
		var add_php_before_getitem_vvvvvyv = [];
		add_php_before_getitem_vvvvvyv.push(temp_vvvvvyv);
	}
	else if (!isSet(add_php_before_getitem_vvvvvyv))
	{
		var add_php_before_getitem_vvvvvyv = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvyv.some(add_php_before_getitem_vvvvvyv_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvyvvys_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvyvvys_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyvvys_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvyvvys_required = true;
		}
	}
}

// the vvvvvyv Some function
function add_php_before_getitem_vvvvvyv_SomeFunc(add_php_before_getitem_vvvvvyv)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvyv == 1)
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
function vvvvvyw(add_php_after_getitem_vvvvvyw,gettype_vvvvvyw)
{
	if (isSet(add_php_after_getitem_vvvvvyw) && add_php_after_getitem_vvvvvyw.constructor !== Array)
	{
		var temp_vvvvvyw = add_php_after_getitem_vvvvvyw;
		var add_php_after_getitem_vvvvvyw = [];
		add_php_after_getitem_vvvvvyw.push(temp_vvvvvyw);
	}
	else if (!isSet(add_php_after_getitem_vvvvvyw))
	{
		var add_php_after_getitem_vvvvvyw = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvyw.some(add_php_after_getitem_vvvvvyw_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvywvyt_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvywvyt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvywvyt_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvywvyt_required = true;
		}
	}
}

// the vvvvvyw Some function
function add_php_after_getitem_vvvvvyw_SomeFunc(add_php_after_getitem_vvvvvyw)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvyw == 1)
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
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvyyvyu_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvyyvyu_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvyyvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyyvyu_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvyyvyu_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvyyvyv_required = true;
		}
	}
}

// the vvvvvyy Some function
function gettype_vvvvvyy_SomeFunc(gettype_vvvvvyy)
{
	// set the function logic
	if (gettype_vvvvvyy == 1 || gettype_vvvvvyy == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvyz function
function vvvvvyz(add_php_getlistquery_vvvvvyz,gettype_vvvvvyz)
{
	if (isSet(add_php_getlistquery_vvvvvyz) && add_php_getlistquery_vvvvvyz.constructor !== Array)
	{
		var temp_vvvvvyz = add_php_getlistquery_vvvvvyz;
		var add_php_getlistquery_vvvvvyz = [];
		add_php_getlistquery_vvvvvyz.push(temp_vvvvvyz);
	}
	else if (!isSet(add_php_getlistquery_vvvvvyz))
	{
		var add_php_getlistquery_vvvvvyz = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvyz.some(add_php_getlistquery_vvvvvyz_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvyzvyw_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvyzvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvyzvyw_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvyzvyw_required = true;
		}
	}
}

// the vvvvvyz Some function
function add_php_getlistquery_vvvvvyz_SomeFunc(add_php_getlistquery_vvvvvyz)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvyz == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvyz Some function
function gettype_vvvvvyz_SomeFunc(gettype_vvvvvyz)
{
	// set the function logic
	if (gettype_vvvvvyz == 2 || gettype_vvvvvyz == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvza function
function vvvvvza(add_php_before_getitems_vvvvvza,gettype_vvvvvza)
{
	if (isSet(add_php_before_getitems_vvvvvza) && add_php_before_getitems_vvvvvza.constructor !== Array)
	{
		var temp_vvvvvza = add_php_before_getitems_vvvvvza;
		var add_php_before_getitems_vvvvvza = [];
		add_php_before_getitems_vvvvvza.push(temp_vvvvvza);
	}
	else if (!isSet(add_php_before_getitems_vvvvvza))
	{
		var add_php_before_getitems_vvvvvza = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvza.some(add_php_before_getitems_vvvvvza_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzavyx_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzavyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzavyx_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzavyx_required = true;
		}
	}
}

// the vvvvvza Some function
function add_php_before_getitems_vvvvvza_SomeFunc(add_php_before_getitems_vvvvvza)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvza == 1)
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

// the vvvvvzb function
function vvvvvzb(add_php_after_getitems_vvvvvzb,gettype_vvvvvzb)
{
	if (isSet(add_php_after_getitems_vvvvvzb) && add_php_after_getitems_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = add_php_after_getitems_vvvvvzb;
		var add_php_after_getitems_vvvvvzb = [];
		add_php_after_getitems_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzb))
	{
		var add_php_after_getitems_vvvvvzb = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzb.some(add_php_after_getitems_vvvvvzb_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzbvyy_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzbvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzbvyy_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzbvyy_required = true;
		}
	}
}

// the vvvvvzb Some function
function add_php_after_getitems_vvvvvzb_SomeFunc(add_php_after_getitems_vvvvvzb)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzb == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzb Some function
function gettype_vvvvvzb_SomeFunc(gettype_vvvvvzb)
{
	// set the function logic
	if (gettype_vvvvvzb == 2 || gettype_vvvvvzb == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(gettype_vvvvvzd)
{
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
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzdvyz_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzdvyz_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzdvza_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzdvza_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzdvzb_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzdvzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzdvyz_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzdvyz_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzdvza_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzdvza_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzdvzb_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzdvzb_required = true;
		}
	}
}

// the vvvvvzd Some function
function gettype_vvvvvzd_SomeFunc(gettype_vvvvvzd)
{
	// set the function logic
	if (gettype_vvvvvzd == 2 || gettype_vvvvvzd == 4)
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
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvzevzc_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvzevzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvzevzc_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvzevzc_required = true;
		}
	}
}

// the vvvvvze Some function
function gettype_vvvvvze_SomeFunc(gettype_vvvvvze)
{
	// set the function logic
	if (gettype_vvvvvze == 2)
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
