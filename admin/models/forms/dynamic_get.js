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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		dynamic_get.js
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvyyvyv_required = false;
jform_vvvvvyzvyw_required = false;
jform_vvvvvzavyx_required = false;
jform_vvvvvzbvyy_required = false;
jform_vvvvvzcvyz_required = false;
jform_vvvvvzdvza_required = false;
jform_vvvvvzivzb_required = false;
jform_vvvvvzkvzc_required = false;
jform_vvvvvzlvzd_required = false;
jform_vvvvvznvze_required = false;
jform_vvvvvznvzf_required = false;
jform_vvvvvzovzg_required = false;
jform_vvvvvzpvzh_required = false;
jform_vvvvvzqvzi_required = false;
jform_vvvvvzsvzj_required = false;
jform_vvvvvzsvzk_required = false;
jform_vvvvvzsvzl_required = false;
jform_vvvvvztvzm_required = false;
jform_vvvvvzuvzn_required = false;
jform_vvvvvzvvzo_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_vvvvvyy = jQuery("#jform_gettype").val();
	vvvvvyy(gettype_vvvvvyy);

	var main_source_vvvvvyz = jQuery("#jform_main_source").val();
	vvvvvyz(main_source_vvvvvyz);

	var main_source_vvvvvza = jQuery("#jform_main_source").val();
	vvvvvza(main_source_vvvvvza);

	var main_source_vvvvvzb = jQuery("#jform_main_source").val();
	vvvvvzb(main_source_vvvvvzb);

	var main_source_vvvvvzc = jQuery("#jform_main_source").val();
	vvvvvzc(main_source_vvvvvzc);

	var addcalculation_vvvvvzd = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	vvvvvzd(addcalculation_vvvvvzd);

	var addcalculation_vvvvvze = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvze = jQuery("#jform_gettype").val();
	vvvvvze(addcalculation_vvvvvze,gettype_vvvvvze);

	var addcalculation_vvvvvzf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vvvvvzf = jQuery("#jform_gettype").val();
	vvvvvzf(addcalculation_vvvvvzf,gettype_vvvvvzf);

	var main_source_vvvvvzi = jQuery("#jform_main_source").val();
	vvvvvzi(main_source_vvvvvzi);

	var main_source_vvvvvzj = jQuery("#jform_main_source").val();
	vvvvvzj(main_source_vvvvvzj);

	var add_php_before_getitem_vvvvvzk = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzk = jQuery("#jform_gettype").val();
	vvvvvzk(add_php_before_getitem_vvvvvzk,gettype_vvvvvzk);

	var add_php_after_getitem_vvvvvzl = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_vvvvvzl = jQuery("#jform_gettype").val();
	vvvvvzl(add_php_after_getitem_vvvvvzl,gettype_vvvvvzl);

	var gettype_vvvvvzn = jQuery("#jform_gettype").val();
	vvvvvzn(gettype_vvvvvzn);

	var add_php_getlistquery_vvvvvzo = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_vvvvvzo = jQuery("#jform_gettype").val();
	vvvvvzo(add_php_getlistquery_vvvvvzo,gettype_vvvvvzo);

	var add_php_before_getitems_vvvvvzp = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzp = jQuery("#jform_gettype").val();
	vvvvvzp(add_php_before_getitems_vvvvvzp,gettype_vvvvvzp);

	var add_php_after_getitems_vvvvvzq = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_vvvvvzq = jQuery("#jform_gettype").val();
	vvvvvzq(add_php_after_getitems_vvvvvzq,gettype_vvvvvzq);

	var gettype_vvvvvzs = jQuery("#jform_gettype").val();
	vvvvvzs(gettype_vvvvvzs);

	var gettype_vvvvvzt = jQuery("#jform_gettype").val();
	vvvvvzt(gettype_vvvvvzt);

	var gettype_vvvvvzu = jQuery("#jform_gettype").val();
	vvvvvzu(gettype_vvvvvzu);

	var gettype_vvvvvzv = jQuery("#jform_gettype").val();
	var add_php_router_parse_vvvvvzv = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	vvvvvzv(gettype_vvvvvzv,add_php_router_parse_vvvvvzv);
});

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
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_vvvvvyyvyv_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_vvvvvyyvyv_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_vvvvvyyvyv_required = true;
		}
	}
}

// the vvvvvyy Some function
function gettype_vvvvvyy_SomeFunc(gettype_vvvvvyy)
{
	// set the function logic
	if (gettype_vvvvvyy == 3 || gettype_vvvvvyy == 4)
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
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_vvvvvyzvyw_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_vvvvvyzvyw_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_vvvvvyzvyw_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_vvvvvyzvyw_required = true;
		}
	}
}

// the vvvvvyz Some function
function main_source_vvvvvyz_SomeFunc(main_source_vvvvvyz)
{
	// set the function logic
	if (main_source_vvvvvyz == 1)
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
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_vvvvvzavyx_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_vvvvvzavyx_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_vvvvvzavyx_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_vvvvvzavyx_required = true;
		}
	}
}

// the vvvvvza Some function
function main_source_vvvvvza_SomeFunc(main_source_vvvvvza)
{
	// set the function logic
	if (main_source_vvvvvza == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzb function
function vvvvvzb(main_source_vvvvvzb)
{
	if (isSet(main_source_vvvvvzb) && main_source_vvvvvzb.constructor !== Array)
	{
		var temp_vvvvvzb = main_source_vvvvvzb;
		var main_source_vvvvvzb = [];
		main_source_vvvvvzb.push(temp_vvvvvzb);
	}
	else if (!isSet(main_source_vvvvvzb))
	{
		var main_source_vvvvvzb = [];
	}
	var main_source = main_source_vvvvvzb.some(main_source_vvvvvzb_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vvvvvzbvyy_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vvvvvzbvyy_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vvvvvzbvyy_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vvvvvzbvyy_required = true;
		}
	}
}

// the vvvvvzb Some function
function main_source_vvvvvzb_SomeFunc(main_source_vvvvvzb)
{
	// set the function logic
	if (main_source_vvvvvzb == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzc function
function vvvvvzc(main_source_vvvvvzc)
{
	if (isSet(main_source_vvvvvzc) && main_source_vvvvvzc.constructor !== Array)
	{
		var temp_vvvvvzc = main_source_vvvvvzc;
		var main_source_vvvvvzc = [];
		main_source_vvvvvzc.push(temp_vvvvvzc);
	}
	else if (!isSet(main_source_vvvvvzc))
	{
		var main_source_vvvvvzc = [];
	}
	var main_source = main_source_vvvvvzc.some(main_source_vvvvvzc_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_vvvvvzcvyz_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_vvvvvzcvyz_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_vvvvvzcvyz_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_vvvvvzcvyz_required = true;
		}
	}
}

// the vvvvvzc Some function
function main_source_vvvvvzc_SomeFunc(main_source_vvvvvzc)
{
	// set the function logic
	if (main_source_vvvvvzc == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzd function
function vvvvvzd(addcalculation_vvvvvzd)
{
	// set the function logic
	if (addcalculation_vvvvvzd == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_vvvvvzdvza_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_vvvvvzdvza_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_vvvvvzdvza_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_vvvvvzdvza_required = true;
		}
	}
}

// the vvvvvze function
function vvvvvze(addcalculation_vvvvvze,gettype_vvvvvze)
{
	if (isSet(addcalculation_vvvvvze) && addcalculation_vvvvvze.constructor !== Array)
	{
		var temp_vvvvvze = addcalculation_vvvvvze;
		var addcalculation_vvvvvze = [];
		addcalculation_vvvvvze.push(temp_vvvvvze);
	}
	else if (!isSet(addcalculation_vvvvvze))
	{
		var addcalculation_vvvvvze = [];
	}
	var addcalculation = addcalculation_vvvvvze.some(addcalculation_vvvvvze_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_item').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_item').closest('.control-group').hide();
	}
}

// the vvvvvze Some function
function addcalculation_vvvvvze_SomeFunc(addcalculation_vvvvvze)
{
	// set the function logic
	if (addcalculation_vvvvvze == 1)
	{
		return true;
	}
	return false;
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
function vvvvvzf(addcalculation_vvvvvzf,gettype_vvvvvzf)
{
	if (isSet(addcalculation_vvvvvzf) && addcalculation_vvvvvzf.constructor !== Array)
	{
		var temp_vvvvvzf = addcalculation_vvvvvzf;
		var addcalculation_vvvvvzf = [];
		addcalculation_vvvvvzf.push(temp_vvvvvzf);
	}
	else if (!isSet(addcalculation_vvvvvzf))
	{
		var addcalculation_vvvvvzf = [];
	}
	var addcalculation = addcalculation_vvvvvzf.some(addcalculation_vvvvvzf_SomeFunc);

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
	if (addcalculation && gettype)
	{
		jQuery('.note_calculation_items').closest('.control-group').show();
	}
	else
	{
		jQuery('.note_calculation_items').closest('.control-group').hide();
	}
}

// the vvvvvzf Some function
function addcalculation_vvvvvzf_SomeFunc(addcalculation_vvvvvzf)
{
	// set the function logic
	if (addcalculation_vvvvvzf == 1)
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

// the vvvvvzi function
function vvvvvzi(main_source_vvvvvzi)
{
	if (isSet(main_source_vvvvvzi) && main_source_vvvvvzi.constructor !== Array)
	{
		var temp_vvvvvzi = main_source_vvvvvzi;
		var main_source_vvvvvzi = [];
		main_source_vvvvvzi.push(temp_vvvvvzi);
	}
	else if (!isSet(main_source_vvvvvzi))
	{
		var main_source_vvvvvzi = [];
	}
	var main_source = main_source_vvvvvzi.some(main_source_vvvvvzi_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vvvvvzivzb_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vvvvvzivzb_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vvvvvzivzb_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vvvvvzivzb_required = true;
		}
	}
}

// the vvvvvzi Some function
function main_source_vvvvvzi_SomeFunc(main_source_vvvvvzi)
{
	// set the function logic
	if (main_source_vvvvvzi == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzj function
function vvvvvzj(main_source_vvvvvzj)
{
	if (isSet(main_source_vvvvvzj) && main_source_vvvvvzj.constructor !== Array)
	{
		var temp_vvvvvzj = main_source_vvvvvzj;
		var main_source_vvvvvzj = [];
		main_source_vvvvvzj.push(temp_vvvvvzj);
	}
	else if (!isSet(main_source_vvvvvzj))
	{
		var main_source_vvvvvzj = [];
	}
	var main_source = main_source_vvvvvzj.some(main_source_vvvvvzj_SomeFunc);


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

// the vvvvvzj Some function
function main_source_vvvvvzj_SomeFunc(main_source_vvvvvzj)
{
	// set the function logic
	if (main_source_vvvvvzj == 1 || main_source_vvvvvzj == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzk function
function vvvvvzk(add_php_before_getitem_vvvvvzk,gettype_vvvvvzk)
{
	if (isSet(add_php_before_getitem_vvvvvzk) && add_php_before_getitem_vvvvvzk.constructor !== Array)
	{
		var temp_vvvvvzk = add_php_before_getitem_vvvvvzk;
		var add_php_before_getitem_vvvvvzk = [];
		add_php_before_getitem_vvvvvzk.push(temp_vvvvvzk);
	}
	else if (!isSet(add_php_before_getitem_vvvvvzk))
	{
		var add_php_before_getitem_vvvvvzk = [];
	}
	var add_php_before_getitem = add_php_before_getitem_vvvvvzk.some(add_php_before_getitem_vvvvvzk_SomeFunc);

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
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvzkvzc_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_vvvvvzkvzc_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzkvzc_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_vvvvvzkvzc_required = true;
		}
	}
}

// the vvvvvzk Some function
function add_php_before_getitem_vvvvvzk_SomeFunc(add_php_before_getitem_vvvvvzk)
{
	// set the function logic
	if (add_php_before_getitem_vvvvvzk == 1)
	{
		return true;
	}
	return false;
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
function vvvvvzl(add_php_after_getitem_vvvvvzl,gettype_vvvvvzl)
{
	if (isSet(add_php_after_getitem_vvvvvzl) && add_php_after_getitem_vvvvvzl.constructor !== Array)
	{
		var temp_vvvvvzl = add_php_after_getitem_vvvvvzl;
		var add_php_after_getitem_vvvvvzl = [];
		add_php_after_getitem_vvvvvzl.push(temp_vvvvvzl);
	}
	else if (!isSet(add_php_after_getitem_vvvvvzl))
	{
		var add_php_after_getitem_vvvvvzl = [];
	}
	var add_php_after_getitem = add_php_after_getitem_vvvvvzl.some(add_php_after_getitem_vvvvvzl_SomeFunc);

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
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvzlvzd_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_vvvvvzlvzd_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvzlvzd_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_vvvvvzlvzd_required = true;
		}
	}
}

// the vvvvvzl Some function
function add_php_after_getitem_vvvvvzl_SomeFunc(add_php_after_getitem_vvvvvzl)
{
	// set the function logic
	if (add_php_after_getitem_vvvvvzl == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzl Some function
function gettype_vvvvvzl_SomeFunc(gettype_vvvvvzl)
{
	// set the function logic
	if (gettype_vvvvvzl == 1 || gettype_vvvvvzl == 3)
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
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_vvvvvznvze_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_vvvvvznvze_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_vvvvvznvzf_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_vvvvvznvzf_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_vvvvvznvze_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_vvvvvznvze_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_vvvvvznvzf_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_vvvvvznvzf_required = true;
		}
	}
}

// the vvvvvzn Some function
function gettype_vvvvvzn_SomeFunc(gettype_vvvvvzn)
{
	// set the function logic
	if (gettype_vvvvvzn == 1 || gettype_vvvvvzn == 3)
	{
		return true;
	}
	return false;
}

// the vvvvvzo function
function vvvvvzo(add_php_getlistquery_vvvvvzo,gettype_vvvvvzo)
{
	if (isSet(add_php_getlistquery_vvvvvzo) && add_php_getlistquery_vvvvvzo.constructor !== Array)
	{
		var temp_vvvvvzo = add_php_getlistquery_vvvvvzo;
		var add_php_getlistquery_vvvvvzo = [];
		add_php_getlistquery_vvvvvzo.push(temp_vvvvvzo);
	}
	else if (!isSet(add_php_getlistquery_vvvvvzo))
	{
		var add_php_getlistquery_vvvvvzo = [];
	}
	var add_php_getlistquery = add_php_getlistquery_vvvvvzo.some(add_php_getlistquery_vvvvvzo_SomeFunc);

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
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzovzg_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_vvvvvzovzg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzovzg_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_vvvvvzovzg_required = true;
		}
	}
}

// the vvvvvzo Some function
function add_php_getlistquery_vvvvvzo_SomeFunc(add_php_getlistquery_vvvvvzo)
{
	// set the function logic
	if (add_php_getlistquery_vvvvvzo == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzo Some function
function gettype_vvvvvzo_SomeFunc(gettype_vvvvvzo)
{
	// set the function logic
	if (gettype_vvvvvzo == 2 || gettype_vvvvvzo == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzp function
function vvvvvzp(add_php_before_getitems_vvvvvzp,gettype_vvvvvzp)
{
	if (isSet(add_php_before_getitems_vvvvvzp) && add_php_before_getitems_vvvvvzp.constructor !== Array)
	{
		var temp_vvvvvzp = add_php_before_getitems_vvvvvzp;
		var add_php_before_getitems_vvvvvzp = [];
		add_php_before_getitems_vvvvvzp.push(temp_vvvvvzp);
	}
	else if (!isSet(add_php_before_getitems_vvvvvzp))
	{
		var add_php_before_getitems_vvvvvzp = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vvvvvzp.some(add_php_before_getitems_vvvvvzp_SomeFunc);

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
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzpvzh_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vvvvvzpvzh_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzpvzh_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vvvvvzpvzh_required = true;
		}
	}
}

// the vvvvvzp Some function
function add_php_before_getitems_vvvvvzp_SomeFunc(add_php_before_getitems_vvvvvzp)
{
	// set the function logic
	if (add_php_before_getitems_vvvvvzp == 1)
	{
		return true;
	}
	return false;
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
function vvvvvzq(add_php_after_getitems_vvvvvzq,gettype_vvvvvzq)
{
	if (isSet(add_php_after_getitems_vvvvvzq) && add_php_after_getitems_vvvvvzq.constructor !== Array)
	{
		var temp_vvvvvzq = add_php_after_getitems_vvvvvzq;
		var add_php_after_getitems_vvvvvzq = [];
		add_php_after_getitems_vvvvvzq.push(temp_vvvvvzq);
	}
	else if (!isSet(add_php_after_getitems_vvvvvzq))
	{
		var add_php_after_getitems_vvvvvzq = [];
	}
	var add_php_after_getitems = add_php_after_getitems_vvvvvzq.some(add_php_after_getitems_vvvvvzq_SomeFunc);

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
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzqvzi_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_vvvvvzqvzi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzqvzi_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_vvvvvzqvzi_required = true;
		}
	}
}

// the vvvvvzq Some function
function add_php_after_getitems_vvvvvzq_SomeFunc(add_php_after_getitems_vvvvvzq)
{
	// set the function logic
	if (add_php_after_getitems_vvvvvzq == 1)
	{
		return true;
	}
	return false;
}

// the vvvvvzq Some function
function gettype_vvvvvzq_SomeFunc(gettype_vvvvvzq)
{
	// set the function logic
	if (gettype_vvvvvzq == 2 || gettype_vvvvvzq == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzs function
function vvvvvzs(gettype_vvvvvzs)
{
	if (isSet(gettype_vvvvvzs) && gettype_vvvvvzs.constructor !== Array)
	{
		var temp_vvvvvzs = gettype_vvvvvzs;
		var gettype_vvvvvzs = [];
		gettype_vvvvvzs.push(temp_vvvvvzs);
	}
	else if (!isSet(gettype_vvvvvzs))
	{
		var gettype_vvvvvzs = [];
	}
	var gettype = gettype_vvvvvzs.some(gettype_vvvvvzs_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_vvvvvzsvzj_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_vvvvvzsvzj_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_vvvvvzsvzk_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_vvvvvzsvzk_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_vvvvvzsvzl_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_vvvvvzsvzl_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzsvzj_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_vvvvvzsvzj_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_vvvvvzsvzk_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_vvvvvzsvzk_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_vvvvvzsvzl_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_vvvvvzsvzl_required = true;
		}
	}
}

// the vvvvvzs Some function
function gettype_vvvvvzs_SomeFunc(gettype_vvvvvzs)
{
	// set the function logic
	if (gettype_vvvvvzs == 2 || gettype_vvvvvzs == 4)
	{
		return true;
	}
	return false;
}

// the vvvvvzt function
function vvvvvzt(gettype_vvvvvzt)
{
	if (isSet(gettype_vvvvvzt) && gettype_vvvvvzt.constructor !== Array)
	{
		var temp_vvvvvzt = gettype_vvvvvzt;
		var gettype_vvvvvzt = [];
		gettype_vvvvvzt.push(temp_vvvvvzt);
	}
	else if (!isSet(gettype_vvvvvzt))
	{
		var gettype_vvvvvzt = [];
	}
	var gettype = gettype_vvvvvzt.some(gettype_vvvvvzt_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_vvvvvztvzm_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_vvvvvztvzm_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_vvvvvztvzm_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_vvvvvztvzm_required = true;
		}
	}
}

// the vvvvvzt Some function
function gettype_vvvvvzt_SomeFunc(gettype_vvvvvzt)
{
	// set the function logic
	if (gettype_vvvvvzt == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzu function
function vvvvvzu(gettype_vvvvvzu)
{
	if (isSet(gettype_vvvvvzu) && gettype_vvvvvzu.constructor !== Array)
	{
		var temp_vvvvvzu = gettype_vvvvvzu;
		var gettype_vvvvvzu = [];
		gettype_vvvvvzu.push(temp_vvvvvzu);
	}
	else if (!isSet(gettype_vvvvvzu))
	{
		var gettype_vvvvvzu = [];
	}
	var gettype = gettype_vvvvvzu.some(gettype_vvvvvzu_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzuvzn_required)
		{
			updateFieldRequired('add_php_router_parse',0);
			jQuery('#jform_add_php_router_parse').prop('required','required');
			jQuery('#jform_add_php_router_parse').attr('aria-required',true);
			jQuery('#jform_add_php_router_parse').addClass('required');
			jform_vvvvvzuvzn_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzuvzn_required)
		{
			updateFieldRequired('add_php_router_parse',1);
			jQuery('#jform_add_php_router_parse').removeAttr('required');
			jQuery('#jform_add_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_add_php_router_parse').removeClass('required');
			jform_vvvvvzuvzn_required = true;
		}
	}
}

// the vvvvvzu Some function
function gettype_vvvvvzu_SomeFunc(gettype_vvvvvzu)
{
	// set the function logic
	if (gettype_vvvvvzu == 1 || gettype_vvvvvzu == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzv function
function vvvvvzv(gettype_vvvvvzv,add_php_router_parse_vvvvvzv)
{
	if (isSet(gettype_vvvvvzv) && gettype_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = gettype_vvvvvzv;
		var gettype_vvvvvzv = [];
		gettype_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(gettype_vvvvvzv))
	{
		var gettype_vvvvvzv = [];
	}
	var gettype = gettype_vvvvvzv.some(gettype_vvvvvzv_SomeFunc);

	if (isSet(add_php_router_parse_vvvvvzv) && add_php_router_parse_vvvvvzv.constructor !== Array)
	{
		var temp_vvvvvzv = add_php_router_parse_vvvvvzv;
		var add_php_router_parse_vvvvvzv = [];
		add_php_router_parse_vvvvvzv.push(temp_vvvvvzv);
	}
	else if (!isSet(add_php_router_parse_vvvvvzv))
	{
		var add_php_router_parse_vvvvvzv = [];
	}
	var add_php_router_parse = add_php_router_parse_vvvvvzv.some(add_php_router_parse_vvvvvzv_SomeFunc);


	// set this function logic
	if (gettype && add_php_router_parse)
	{
		jQuery('#jform_php_router_parse').closest('.control-group').show();
		if (jform_vvvvvzvvzo_required)
		{
			updateFieldRequired('php_router_parse',0);
			jQuery('#jform_php_router_parse').prop('required','required');
			jQuery('#jform_php_router_parse').attr('aria-required',true);
			jQuery('#jform_php_router_parse').addClass('required');
			jform_vvvvvzvvzo_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_router_parse').closest('.control-group').hide();
		if (!jform_vvvvvzvvzo_required)
		{
			updateFieldRequired('php_router_parse',1);
			jQuery('#jform_php_router_parse').removeAttr('required');
			jQuery('#jform_php_router_parse').removeAttr('aria-required');
			jQuery('#jform_php_router_parse').removeClass('required');
			jform_vvvvvzvvzo_required = true;
		}
	}
}

// the vvvvvzv Some function
function gettype_vvvvvzv_SomeFunc(gettype_vvvvvzv)
{
	// set the function logic
	if (gettype_vvvvvzv == 1 || gettype_vvvvvzv == 2)
	{
		return true;
	}
	return false;
}

// the vvvvvzv Some function
function add_php_router_parse_vvvvvzv_SomeFunc(add_php_router_parse_vvvvvzv)
{
	// set the function logic
	if (add_php_router_parse_vvvvvzv == 1)
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

jQuery(document).ready(function()
{
	// get the linked details
	getLinked();
	var valueSwitch = jQuery("#jform_add_php_router_parse input[type='radio']:checked").val();
	getDynamicScripts(valueSwitch);
});
			
function getLinked_server(type){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getLinked&format=json&vdm="+vastDevMod;
	if(token.length > 0 && type > 0){
		var request = 'token='+token+'&type='+type;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getLinked(){
	getLinked_server(1).done(function(result) {
		if(result){
			jQuery('#display_linked_to').html(result);
		}
	});
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

function getDynamicScripts_server(typpe){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getDynamicScripts&format=json&vdm="+vastDevMod;
	if(token.length > 0 && typpe.length > 0){
		var request = 'token='+token+'&type='+typpe;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

function getDynamicScripts(id){
	if (1 == id) {
		// get the current values
		var current_router_parse = jQuery('textarea#jform_php_router_parse').val();
		// set the router parse method script
		if(current_router_parse.length == 0){
			getDynamicScripts_server('routerparse').done(function(result) {
				if(result){
					jQuery('textarea#jform_php_router_parse').val(result);
				}
			});
		}
	}
} 
