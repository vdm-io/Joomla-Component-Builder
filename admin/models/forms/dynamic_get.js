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

	@version		2.0.8
	@build			30th January, 2016
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
jform_TTozUNEwhV_required = false;
jform_OabpNGmTtz_required = false;
jform_aZEjPkezth_required = false;
jform_liYHBQwlpC_required = false;
jform_ihvkrmNMid_required = false;
jform_qgcUmUfqmz_required = false;
jform_LKzirhHquV_required = false;
jform_fyWzBNhCKI_required = false;
jform_McnRHXsQoG_required = false;
jform_lajvdOyLkk_required = false;
jform_lajvdOyPSW_required = false;
jform_DxYMqLKQDU_required = false;
jform_qXDrqWYhkY_required = false;
jform_oEefcMmowi_required = false;
jform_pQuokmMvyE_required = false;
jform_pQuokmMvFP_required = false;
jform_pQuokmMBav_required = false;
jform_DexlzKNFUO_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_TTozUNE = jQuery("#jform_gettype").val();
	TTozUNE(gettype_TTozUNE);

	var main_source_OabpNGm = jQuery("#jform_main_source").val();
	OabpNGm(main_source_OabpNGm);

	var main_source_aZEjPke = jQuery("#jform_main_source").val();
	aZEjPke(main_source_aZEjPke);

	var main_source_liYHBQw = jQuery("#jform_main_source").val();
	liYHBQw(main_source_liYHBQw);

	var main_source_ihvkrmN = jQuery("#jform_main_source").val();
	ihvkrmN(main_source_ihvkrmN);

	var addcalculation_qgcUmUf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	qgcUmUf(addcalculation_qgcUmUf);

	var addcalculation_vEABeis = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vEABeis = jQuery("#jform_gettype").val();
	vEABeis(addcalculation_vEABeis,gettype_vEABeis);

	var addcalculation_vzEXGQt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_vzEXGQt = jQuery("#jform_gettype").val();
	vzEXGQt(addcalculation_vzEXGQt,gettype_vzEXGQt);

	var main_source_LKzirhH = jQuery("#jform_main_source").val();
	LKzirhH(main_source_LKzirhH);

	var main_source_TOFQooo = jQuery("#jform_main_source").val();
	TOFQooo(main_source_TOFQooo);

	var add_php_before_getitem_fyWzBNh = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_fyWzBNh = jQuery("#jform_gettype").val();
	fyWzBNh(add_php_before_getitem_fyWzBNh,gettype_fyWzBNh);

	var add_php_after_getitem_McnRHXs = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_McnRHXs = jQuery("#jform_gettype").val();
	McnRHXs(add_php_after_getitem_McnRHXs,gettype_McnRHXs);

	var gettype_lajvdOy = jQuery("#jform_gettype").val();
	lajvdOy(gettype_lajvdOy);

	var add_php_getlistquery_DxYMqLK = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_DxYMqLK = jQuery("#jform_gettype").val();
	DxYMqLK(add_php_getlistquery_DxYMqLK,gettype_DxYMqLK);

	var add_php_before_getitems_qXDrqWY = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qXDrqWY = jQuery("#jform_gettype").val();
	qXDrqWY(add_php_before_getitems_qXDrqWY,gettype_qXDrqWY);

	var add_php_after_getitems_oEefcMm = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_oEefcMm = jQuery("#jform_gettype").val();
	oEefcMm(add_php_after_getitems_oEefcMm,gettype_oEefcMm);

	var gettype_pQuokmM = jQuery("#jform_gettype").val();
	pQuokmM(gettype_pQuokmM);

	var gettype_DexlzKN = jQuery("#jform_gettype").val();
	DexlzKN(gettype_DexlzKN);
});

// the TTozUNE function
function TTozUNE(gettype_TTozUNE)
{
	if (isSet(gettype_TTozUNE) && gettype_TTozUNE.constructor !== Array)
	{
		var temp_TTozUNE = gettype_TTozUNE;
		var gettype_TTozUNE = [];
		gettype_TTozUNE.push(temp_TTozUNE);
	}
	else if (!isSet(gettype_TTozUNE))
	{
		var gettype_TTozUNE = [];
	}
	var gettype = gettype_TTozUNE.some(gettype_TTozUNE_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_TTozUNEwhV_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_TTozUNEwhV_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_TTozUNEwhV_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_TTozUNEwhV_required = true;
		}
	}
}

// the TTozUNE Some function
function gettype_TTozUNE_SomeFunc(gettype_TTozUNE)
{
	// set the function logic
	if (gettype_TTozUNE == 3 || gettype_TTozUNE == 4)
	{
		return true;
	}
	return false;
}

// the OabpNGm function
function OabpNGm(main_source_OabpNGm)
{
	if (isSet(main_source_OabpNGm) && main_source_OabpNGm.constructor !== Array)
	{
		var temp_OabpNGm = main_source_OabpNGm;
		var main_source_OabpNGm = [];
		main_source_OabpNGm.push(temp_OabpNGm);
	}
	else if (!isSet(main_source_OabpNGm))
	{
		var main_source_OabpNGm = [];
	}
	var main_source = main_source_OabpNGm.some(main_source_OabpNGm_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_OabpNGmTtz_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_OabpNGmTtz_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_OabpNGmTtz_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_OabpNGmTtz_required = true;
		}
	}
}

// the OabpNGm Some function
function main_source_OabpNGm_SomeFunc(main_source_OabpNGm)
{
	// set the function logic
	if (main_source_OabpNGm == 1)
	{
		return true;
	}
	return false;
}

// the aZEjPke function
function aZEjPke(main_source_aZEjPke)
{
	if (isSet(main_source_aZEjPke) && main_source_aZEjPke.constructor !== Array)
	{
		var temp_aZEjPke = main_source_aZEjPke;
		var main_source_aZEjPke = [];
		main_source_aZEjPke.push(temp_aZEjPke);
	}
	else if (!isSet(main_source_aZEjPke))
	{
		var main_source_aZEjPke = [];
	}
	var main_source = main_source_aZEjPke.some(main_source_aZEjPke_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_aZEjPkezth_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_aZEjPkezth_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_aZEjPkezth_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_aZEjPkezth_required = true;
		}
	}
}

// the aZEjPke Some function
function main_source_aZEjPke_SomeFunc(main_source_aZEjPke)
{
	// set the function logic
	if (main_source_aZEjPke == 1)
	{
		return true;
	}
	return false;
}

// the liYHBQw function
function liYHBQw(main_source_liYHBQw)
{
	if (isSet(main_source_liYHBQw) && main_source_liYHBQw.constructor !== Array)
	{
		var temp_liYHBQw = main_source_liYHBQw;
		var main_source_liYHBQw = [];
		main_source_liYHBQw.push(temp_liYHBQw);
	}
	else if (!isSet(main_source_liYHBQw))
	{
		var main_source_liYHBQw = [];
	}
	var main_source = main_source_liYHBQw.some(main_source_liYHBQw_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_liYHBQwlpC_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_liYHBQwlpC_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_liYHBQwlpC_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_liYHBQwlpC_required = true;
		}
	}
}

// the liYHBQw Some function
function main_source_liYHBQw_SomeFunc(main_source_liYHBQw)
{
	// set the function logic
	if (main_source_liYHBQw == 2)
	{
		return true;
	}
	return false;
}

// the ihvkrmN function
function ihvkrmN(main_source_ihvkrmN)
{
	if (isSet(main_source_ihvkrmN) && main_source_ihvkrmN.constructor !== Array)
	{
		var temp_ihvkrmN = main_source_ihvkrmN;
		var main_source_ihvkrmN = [];
		main_source_ihvkrmN.push(temp_ihvkrmN);
	}
	else if (!isSet(main_source_ihvkrmN))
	{
		var main_source_ihvkrmN = [];
	}
	var main_source = main_source_ihvkrmN.some(main_source_ihvkrmN_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_ihvkrmNMid_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_ihvkrmNMid_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_ihvkrmNMid_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_ihvkrmNMid_required = true;
		}
	}
}

// the ihvkrmN Some function
function main_source_ihvkrmN_SomeFunc(main_source_ihvkrmN)
{
	// set the function logic
	if (main_source_ihvkrmN == 2)
	{
		return true;
	}
	return false;
}

// the qgcUmUf function
function qgcUmUf(addcalculation_qgcUmUf)
{
	// set the function logic
	if (addcalculation_qgcUmUf == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_qgcUmUfqmz_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_qgcUmUfqmz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_qgcUmUfqmz_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_qgcUmUfqmz_required = true;
		}
	}
}

// the vEABeis function
function vEABeis(addcalculation_vEABeis,gettype_vEABeis)
{
	if (isSet(addcalculation_vEABeis) && addcalculation_vEABeis.constructor !== Array)
	{
		var temp_vEABeis = addcalculation_vEABeis;
		var addcalculation_vEABeis = [];
		addcalculation_vEABeis.push(temp_vEABeis);
	}
	else if (!isSet(addcalculation_vEABeis))
	{
		var addcalculation_vEABeis = [];
	}
	var addcalculation = addcalculation_vEABeis.some(addcalculation_vEABeis_SomeFunc);

	if (isSet(gettype_vEABeis) && gettype_vEABeis.constructor !== Array)
	{
		var temp_vEABeis = gettype_vEABeis;
		var gettype_vEABeis = [];
		gettype_vEABeis.push(temp_vEABeis);
	}
	else if (!isSet(gettype_vEABeis))
	{
		var gettype_vEABeis = [];
	}
	var gettype = gettype_vEABeis.some(gettype_vEABeis_SomeFunc);


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

// the vEABeis Some function
function addcalculation_vEABeis_SomeFunc(addcalculation_vEABeis)
{
	// set the function logic
	if (addcalculation_vEABeis == 1)
	{
		return true;
	}
	return false;
}

// the vEABeis Some function
function gettype_vEABeis_SomeFunc(gettype_vEABeis)
{
	// set the function logic
	if (gettype_vEABeis == 1 || gettype_vEABeis == 3)
	{
		return true;
	}
	return false;
}

// the vzEXGQt function
function vzEXGQt(addcalculation_vzEXGQt,gettype_vzEXGQt)
{
	if (isSet(addcalculation_vzEXGQt) && addcalculation_vzEXGQt.constructor !== Array)
	{
		var temp_vzEXGQt = addcalculation_vzEXGQt;
		var addcalculation_vzEXGQt = [];
		addcalculation_vzEXGQt.push(temp_vzEXGQt);
	}
	else if (!isSet(addcalculation_vzEXGQt))
	{
		var addcalculation_vzEXGQt = [];
	}
	var addcalculation = addcalculation_vzEXGQt.some(addcalculation_vzEXGQt_SomeFunc);

	if (isSet(gettype_vzEXGQt) && gettype_vzEXGQt.constructor !== Array)
	{
		var temp_vzEXGQt = gettype_vzEXGQt;
		var gettype_vzEXGQt = [];
		gettype_vzEXGQt.push(temp_vzEXGQt);
	}
	else if (!isSet(gettype_vzEXGQt))
	{
		var gettype_vzEXGQt = [];
	}
	var gettype = gettype_vzEXGQt.some(gettype_vzEXGQt_SomeFunc);


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

// the vzEXGQt Some function
function addcalculation_vzEXGQt_SomeFunc(addcalculation_vzEXGQt)
{
	// set the function logic
	if (addcalculation_vzEXGQt == 1)
	{
		return true;
	}
	return false;
}

// the vzEXGQt Some function
function gettype_vzEXGQt_SomeFunc(gettype_vzEXGQt)
{
	// set the function logic
	if (gettype_vzEXGQt == 2 || gettype_vzEXGQt == 4)
	{
		return true;
	}
	return false;
}

// the LKzirhH function
function LKzirhH(main_source_LKzirhH)
{
	if (isSet(main_source_LKzirhH) && main_source_LKzirhH.constructor !== Array)
	{
		var temp_LKzirhH = main_source_LKzirhH;
		var main_source_LKzirhH = [];
		main_source_LKzirhH.push(temp_LKzirhH);
	}
	else if (!isSet(main_source_LKzirhH))
	{
		var main_source_LKzirhH = [];
	}
	var main_source = main_source_LKzirhH.some(main_source_LKzirhH_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_LKzirhHquV_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_LKzirhHquV_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_LKzirhHquV_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_LKzirhHquV_required = true;
		}
	}
}

// the LKzirhH Some function
function main_source_LKzirhH_SomeFunc(main_source_LKzirhH)
{
	// set the function logic
	if (main_source_LKzirhH == 3)
	{
		return true;
	}
	return false;
}

// the TOFQooo function
function TOFQooo(main_source_TOFQooo)
{
	if (isSet(main_source_TOFQooo) && main_source_TOFQooo.constructor !== Array)
	{
		var temp_TOFQooo = main_source_TOFQooo;
		var main_source_TOFQooo = [];
		main_source_TOFQooo.push(temp_TOFQooo);
	}
	else if (!isSet(main_source_TOFQooo))
	{
		var main_source_TOFQooo = [];
	}
	var main_source = main_source_TOFQooo.some(main_source_TOFQooo_SomeFunc);


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

// the TOFQooo Some function
function main_source_TOFQooo_SomeFunc(main_source_TOFQooo)
{
	// set the function logic
	if (main_source_TOFQooo == 1 || main_source_TOFQooo == 2)
	{
		return true;
	}
	return false;
}

// the fyWzBNh function
function fyWzBNh(add_php_before_getitem_fyWzBNh,gettype_fyWzBNh)
{
	if (isSet(add_php_before_getitem_fyWzBNh) && add_php_before_getitem_fyWzBNh.constructor !== Array)
	{
		var temp_fyWzBNh = add_php_before_getitem_fyWzBNh;
		var add_php_before_getitem_fyWzBNh = [];
		add_php_before_getitem_fyWzBNh.push(temp_fyWzBNh);
	}
	else if (!isSet(add_php_before_getitem_fyWzBNh))
	{
		var add_php_before_getitem_fyWzBNh = [];
	}
	var add_php_before_getitem = add_php_before_getitem_fyWzBNh.some(add_php_before_getitem_fyWzBNh_SomeFunc);

	if (isSet(gettype_fyWzBNh) && gettype_fyWzBNh.constructor !== Array)
	{
		var temp_fyWzBNh = gettype_fyWzBNh;
		var gettype_fyWzBNh = [];
		gettype_fyWzBNh.push(temp_fyWzBNh);
	}
	else if (!isSet(gettype_fyWzBNh))
	{
		var gettype_fyWzBNh = [];
	}
	var gettype = gettype_fyWzBNh.some(gettype_fyWzBNh_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_fyWzBNhCKI_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_fyWzBNhCKI_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_fyWzBNhCKI_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_fyWzBNhCKI_required = true;
		}
	}
}

// the fyWzBNh Some function
function add_php_before_getitem_fyWzBNh_SomeFunc(add_php_before_getitem_fyWzBNh)
{
	// set the function logic
	if (add_php_before_getitem_fyWzBNh == 1)
	{
		return true;
	}
	return false;
}

// the fyWzBNh Some function
function gettype_fyWzBNh_SomeFunc(gettype_fyWzBNh)
{
	// set the function logic
	if (gettype_fyWzBNh == 1 || gettype_fyWzBNh == 3)
	{
		return true;
	}
	return false;
}

// the McnRHXs function
function McnRHXs(add_php_after_getitem_McnRHXs,gettype_McnRHXs)
{
	if (isSet(add_php_after_getitem_McnRHXs) && add_php_after_getitem_McnRHXs.constructor !== Array)
	{
		var temp_McnRHXs = add_php_after_getitem_McnRHXs;
		var add_php_after_getitem_McnRHXs = [];
		add_php_after_getitem_McnRHXs.push(temp_McnRHXs);
	}
	else if (!isSet(add_php_after_getitem_McnRHXs))
	{
		var add_php_after_getitem_McnRHXs = [];
	}
	var add_php_after_getitem = add_php_after_getitem_McnRHXs.some(add_php_after_getitem_McnRHXs_SomeFunc);

	if (isSet(gettype_McnRHXs) && gettype_McnRHXs.constructor !== Array)
	{
		var temp_McnRHXs = gettype_McnRHXs;
		var gettype_McnRHXs = [];
		gettype_McnRHXs.push(temp_McnRHXs);
	}
	else if (!isSet(gettype_McnRHXs))
	{
		var gettype_McnRHXs = [];
	}
	var gettype = gettype_McnRHXs.some(gettype_McnRHXs_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_McnRHXsQoG_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_McnRHXsQoG_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_McnRHXsQoG_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_McnRHXsQoG_required = true;
		}
	}
}

// the McnRHXs Some function
function add_php_after_getitem_McnRHXs_SomeFunc(add_php_after_getitem_McnRHXs)
{
	// set the function logic
	if (add_php_after_getitem_McnRHXs == 1)
	{
		return true;
	}
	return false;
}

// the McnRHXs Some function
function gettype_McnRHXs_SomeFunc(gettype_McnRHXs)
{
	// set the function logic
	if (gettype_McnRHXs == 1 || gettype_McnRHXs == 3)
	{
		return true;
	}
	return false;
}

// the lajvdOy function
function lajvdOy(gettype_lajvdOy)
{
	if (isSet(gettype_lajvdOy) && gettype_lajvdOy.constructor !== Array)
	{
		var temp_lajvdOy = gettype_lajvdOy;
		var gettype_lajvdOy = [];
		gettype_lajvdOy.push(temp_lajvdOy);
	}
	else if (!isSet(gettype_lajvdOy))
	{
		var gettype_lajvdOy = [];
	}
	var gettype = gettype_lajvdOy.some(gettype_lajvdOy_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_lajvdOyLkk_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_lajvdOyLkk_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_lajvdOyPSW_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_lajvdOyPSW_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_lajvdOyLkk_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_lajvdOyLkk_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_lajvdOyPSW_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_lajvdOyPSW_required = true;
		}
	}
}

// the lajvdOy Some function
function gettype_lajvdOy_SomeFunc(gettype_lajvdOy)
{
	// set the function logic
	if (gettype_lajvdOy == 1 || gettype_lajvdOy == 3)
	{
		return true;
	}
	return false;
}

// the DxYMqLK function
function DxYMqLK(add_php_getlistquery_DxYMqLK,gettype_DxYMqLK)
{
	if (isSet(add_php_getlistquery_DxYMqLK) && add_php_getlistquery_DxYMqLK.constructor !== Array)
	{
		var temp_DxYMqLK = add_php_getlistquery_DxYMqLK;
		var add_php_getlistquery_DxYMqLK = [];
		add_php_getlistquery_DxYMqLK.push(temp_DxYMqLK);
	}
	else if (!isSet(add_php_getlistquery_DxYMqLK))
	{
		var add_php_getlistquery_DxYMqLK = [];
	}
	var add_php_getlistquery = add_php_getlistquery_DxYMqLK.some(add_php_getlistquery_DxYMqLK_SomeFunc);

	if (isSet(gettype_DxYMqLK) && gettype_DxYMqLK.constructor !== Array)
	{
		var temp_DxYMqLK = gettype_DxYMqLK;
		var gettype_DxYMqLK = [];
		gettype_DxYMqLK.push(temp_DxYMqLK);
	}
	else if (!isSet(gettype_DxYMqLK))
	{
		var gettype_DxYMqLK = [];
	}
	var gettype = gettype_DxYMqLK.some(gettype_DxYMqLK_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_DxYMqLKQDU_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_DxYMqLKQDU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_DxYMqLKQDU_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_DxYMqLKQDU_required = true;
		}
	}
}

// the DxYMqLK Some function
function add_php_getlistquery_DxYMqLK_SomeFunc(add_php_getlistquery_DxYMqLK)
{
	// set the function logic
	if (add_php_getlistquery_DxYMqLK == 1)
	{
		return true;
	}
	return false;
}

// the DxYMqLK Some function
function gettype_DxYMqLK_SomeFunc(gettype_DxYMqLK)
{
	// set the function logic
	if (gettype_DxYMqLK == 2 || gettype_DxYMqLK == 4)
	{
		return true;
	}
	return false;
}

// the qXDrqWY function
function qXDrqWY(add_php_before_getitems_qXDrqWY,gettype_qXDrqWY)
{
	if (isSet(add_php_before_getitems_qXDrqWY) && add_php_before_getitems_qXDrqWY.constructor !== Array)
	{
		var temp_qXDrqWY = add_php_before_getitems_qXDrqWY;
		var add_php_before_getitems_qXDrqWY = [];
		add_php_before_getitems_qXDrqWY.push(temp_qXDrqWY);
	}
	else if (!isSet(add_php_before_getitems_qXDrqWY))
	{
		var add_php_before_getitems_qXDrqWY = [];
	}
	var add_php_before_getitems = add_php_before_getitems_qXDrqWY.some(add_php_before_getitems_qXDrqWY_SomeFunc);

	if (isSet(gettype_qXDrqWY) && gettype_qXDrqWY.constructor !== Array)
	{
		var temp_qXDrqWY = gettype_qXDrqWY;
		var gettype_qXDrqWY = [];
		gettype_qXDrqWY.push(temp_qXDrqWY);
	}
	else if (!isSet(gettype_qXDrqWY))
	{
		var gettype_qXDrqWY = [];
	}
	var gettype = gettype_qXDrqWY.some(gettype_qXDrqWY_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_qXDrqWYhkY_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_qXDrqWYhkY_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_qXDrqWYhkY_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_qXDrqWYhkY_required = true;
		}
	}
}

// the qXDrqWY Some function
function add_php_before_getitems_qXDrqWY_SomeFunc(add_php_before_getitems_qXDrqWY)
{
	// set the function logic
	if (add_php_before_getitems_qXDrqWY == 1)
	{
		return true;
	}
	return false;
}

// the qXDrqWY Some function
function gettype_qXDrqWY_SomeFunc(gettype_qXDrqWY)
{
	// set the function logic
	if (gettype_qXDrqWY == 2 || gettype_qXDrqWY == 4)
	{
		return true;
	}
	return false;
}

// the oEefcMm function
function oEefcMm(add_php_after_getitems_oEefcMm,gettype_oEefcMm)
{
	if (isSet(add_php_after_getitems_oEefcMm) && add_php_after_getitems_oEefcMm.constructor !== Array)
	{
		var temp_oEefcMm = add_php_after_getitems_oEefcMm;
		var add_php_after_getitems_oEefcMm = [];
		add_php_after_getitems_oEefcMm.push(temp_oEefcMm);
	}
	else if (!isSet(add_php_after_getitems_oEefcMm))
	{
		var add_php_after_getitems_oEefcMm = [];
	}
	var add_php_after_getitems = add_php_after_getitems_oEefcMm.some(add_php_after_getitems_oEefcMm_SomeFunc);

	if (isSet(gettype_oEefcMm) && gettype_oEefcMm.constructor !== Array)
	{
		var temp_oEefcMm = gettype_oEefcMm;
		var gettype_oEefcMm = [];
		gettype_oEefcMm.push(temp_oEefcMm);
	}
	else if (!isSet(gettype_oEefcMm))
	{
		var gettype_oEefcMm = [];
	}
	var gettype = gettype_oEefcMm.some(gettype_oEefcMm_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_oEefcMmowi_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_oEefcMmowi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_oEefcMmowi_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_oEefcMmowi_required = true;
		}
	}
}

// the oEefcMm Some function
function add_php_after_getitems_oEefcMm_SomeFunc(add_php_after_getitems_oEefcMm)
{
	// set the function logic
	if (add_php_after_getitems_oEefcMm == 1)
	{
		return true;
	}
	return false;
}

// the oEefcMm Some function
function gettype_oEefcMm_SomeFunc(gettype_oEefcMm)
{
	// set the function logic
	if (gettype_oEefcMm == 2 || gettype_oEefcMm == 4)
	{
		return true;
	}
	return false;
}

// the pQuokmM function
function pQuokmM(gettype_pQuokmM)
{
	if (isSet(gettype_pQuokmM) && gettype_pQuokmM.constructor !== Array)
	{
		var temp_pQuokmM = gettype_pQuokmM;
		var gettype_pQuokmM = [];
		gettype_pQuokmM.push(temp_pQuokmM);
	}
	else if (!isSet(gettype_pQuokmM))
	{
		var gettype_pQuokmM = [];
	}
	var gettype = gettype_pQuokmM.some(gettype_pQuokmM_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_pQuokmMvyE_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_pQuokmMvyE_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_pQuokmMvFP_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_pQuokmMvFP_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_pQuokmMBav_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_pQuokmMBav_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_pQuokmMvyE_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_pQuokmMvyE_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_pQuokmMvFP_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_pQuokmMvFP_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_pQuokmMBav_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_pQuokmMBav_required = true;
		}
	}
}

// the pQuokmM Some function
function gettype_pQuokmM_SomeFunc(gettype_pQuokmM)
{
	// set the function logic
	if (gettype_pQuokmM == 2 || gettype_pQuokmM == 4)
	{
		return true;
	}
	return false;
}

// the DexlzKN function
function DexlzKN(gettype_DexlzKN)
{
	if (isSet(gettype_DexlzKN) && gettype_DexlzKN.constructor !== Array)
	{
		var temp_DexlzKN = gettype_DexlzKN;
		var gettype_DexlzKN = [];
		gettype_DexlzKN.push(temp_DexlzKN);
	}
	else if (!isSet(gettype_DexlzKN))
	{
		var gettype_DexlzKN = [];
	}
	var gettype = gettype_DexlzKN.some(gettype_DexlzKN_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_DexlzKNFUO_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_DexlzKNFUO_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_DexlzKNFUO_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_DexlzKNFUO_required = true;
		}
	}
}

// the DexlzKN Some function
function gettype_DexlzKN_SomeFunc(gettype_DexlzKN)
{
	// set the function logic
	if (gettype_DexlzKN == 2)
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
