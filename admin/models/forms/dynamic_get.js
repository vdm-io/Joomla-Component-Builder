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

	@version		2.0.9
	@build			15th February, 2016
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
jform_GtJWYHVEUB_required = false;
jform_qUEIIzHfQZ_required = false;
jform_aXSPZKGFwP_required = false;
jform_McooZiUUIQ_required = false;
jform_xZJeHvCsys_required = false;
jform_zylrqpVWUm_required = false;
jform_obQcKhZIwe_required = false;
jform_qsHGldsHdk_required = false;
jform_nDrOPtHSYK_required = false;
jform_rFFXUXFBiB_required = false;
jform_rFFXUXFUNM_required = false;
jform_fZixNaLoUF_required = false;
jform_dJlwHnqHAW_required = false;
jform_qyQnfurGqi_required = false;
jform_EltkuhsLTM_required = false;
jform_Eltkuhscut_required = false;
jform_EltkuhsYHR_required = false;
jform_PUWmnBKDZg_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_GtJWYHV = jQuery("#jform_gettype").val();
	GtJWYHV(gettype_GtJWYHV);

	var main_source_qUEIIzH = jQuery("#jform_main_source").val();
	qUEIIzH(main_source_qUEIIzH);

	var main_source_aXSPZKG = jQuery("#jform_main_source").val();
	aXSPZKG(main_source_aXSPZKG);

	var main_source_McooZiU = jQuery("#jform_main_source").val();
	McooZiU(main_source_McooZiU);

	var main_source_xZJeHvC = jQuery("#jform_main_source").val();
	xZJeHvC(main_source_xZJeHvC);

	var addcalculation_zylrqpV = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	zylrqpV(addcalculation_zylrqpV);

	var addcalculation_MJoWXuh = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_MJoWXuh = jQuery("#jform_gettype").val();
	MJoWXuh(addcalculation_MJoWXuh,gettype_MJoWXuh);

	var addcalculation_SpQINPu = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_SpQINPu = jQuery("#jform_gettype").val();
	SpQINPu(addcalculation_SpQINPu,gettype_SpQINPu);

	var main_source_obQcKhZ = jQuery("#jform_main_source").val();
	obQcKhZ(main_source_obQcKhZ);

	var main_source_DKWnxOF = jQuery("#jform_main_source").val();
	DKWnxOF(main_source_DKWnxOF);

	var add_php_before_getitem_qsHGlds = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_qsHGlds = jQuery("#jform_gettype").val();
	qsHGlds(add_php_before_getitem_qsHGlds,gettype_qsHGlds);

	var add_php_after_getitem_nDrOPtH = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_nDrOPtH = jQuery("#jform_gettype").val();
	nDrOPtH(add_php_after_getitem_nDrOPtH,gettype_nDrOPtH);

	var gettype_rFFXUXF = jQuery("#jform_gettype").val();
	rFFXUXF(gettype_rFFXUXF);

	var add_php_getlistquery_fZixNaL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_fZixNaL = jQuery("#jform_gettype").val();
	fZixNaL(add_php_getlistquery_fZixNaL,gettype_fZixNaL);

	var add_php_before_getitems_dJlwHnq = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_dJlwHnq = jQuery("#jform_gettype").val();
	dJlwHnq(add_php_before_getitems_dJlwHnq,gettype_dJlwHnq);

	var add_php_after_getitems_qyQnfur = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_qyQnfur = jQuery("#jform_gettype").val();
	qyQnfur(add_php_after_getitems_qyQnfur,gettype_qyQnfur);

	var gettype_Eltkuhs = jQuery("#jform_gettype").val();
	Eltkuhs(gettype_Eltkuhs);

	var gettype_PUWmnBK = jQuery("#jform_gettype").val();
	PUWmnBK(gettype_PUWmnBK);
});

// the GtJWYHV function
function GtJWYHV(gettype_GtJWYHV)
{
	if (isSet(gettype_GtJWYHV) && gettype_GtJWYHV.constructor !== Array)
	{
		var temp_GtJWYHV = gettype_GtJWYHV;
		var gettype_GtJWYHV = [];
		gettype_GtJWYHV.push(temp_GtJWYHV);
	}
	else if (!isSet(gettype_GtJWYHV))
	{
		var gettype_GtJWYHV = [];
	}
	var gettype = gettype_GtJWYHV.some(gettype_GtJWYHV_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_GtJWYHVEUB_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_GtJWYHVEUB_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_GtJWYHVEUB_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_GtJWYHVEUB_required = true;
		}
	}
}

// the GtJWYHV Some function
function gettype_GtJWYHV_SomeFunc(gettype_GtJWYHV)
{
	// set the function logic
	if (gettype_GtJWYHV == 3 || gettype_GtJWYHV == 4)
	{
		return true;
	}
	return false;
}

// the qUEIIzH function
function qUEIIzH(main_source_qUEIIzH)
{
	if (isSet(main_source_qUEIIzH) && main_source_qUEIIzH.constructor !== Array)
	{
		var temp_qUEIIzH = main_source_qUEIIzH;
		var main_source_qUEIIzH = [];
		main_source_qUEIIzH.push(temp_qUEIIzH);
	}
	else if (!isSet(main_source_qUEIIzH))
	{
		var main_source_qUEIIzH = [];
	}
	var main_source = main_source_qUEIIzH.some(main_source_qUEIIzH_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_qUEIIzHfQZ_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_qUEIIzHfQZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_qUEIIzHfQZ_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_qUEIIzHfQZ_required = true;
		}
	}
}

// the qUEIIzH Some function
function main_source_qUEIIzH_SomeFunc(main_source_qUEIIzH)
{
	// set the function logic
	if (main_source_qUEIIzH == 1)
	{
		return true;
	}
	return false;
}

// the aXSPZKG function
function aXSPZKG(main_source_aXSPZKG)
{
	if (isSet(main_source_aXSPZKG) && main_source_aXSPZKG.constructor !== Array)
	{
		var temp_aXSPZKG = main_source_aXSPZKG;
		var main_source_aXSPZKG = [];
		main_source_aXSPZKG.push(temp_aXSPZKG);
	}
	else if (!isSet(main_source_aXSPZKG))
	{
		var main_source_aXSPZKG = [];
	}
	var main_source = main_source_aXSPZKG.some(main_source_aXSPZKG_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_aXSPZKGFwP_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_aXSPZKGFwP_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_aXSPZKGFwP_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_aXSPZKGFwP_required = true;
		}
	}
}

// the aXSPZKG Some function
function main_source_aXSPZKG_SomeFunc(main_source_aXSPZKG)
{
	// set the function logic
	if (main_source_aXSPZKG == 1)
	{
		return true;
	}
	return false;
}

// the McooZiU function
function McooZiU(main_source_McooZiU)
{
	if (isSet(main_source_McooZiU) && main_source_McooZiU.constructor !== Array)
	{
		var temp_McooZiU = main_source_McooZiU;
		var main_source_McooZiU = [];
		main_source_McooZiU.push(temp_McooZiU);
	}
	else if (!isSet(main_source_McooZiU))
	{
		var main_source_McooZiU = [];
	}
	var main_source = main_source_McooZiU.some(main_source_McooZiU_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_McooZiUUIQ_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_McooZiUUIQ_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_McooZiUUIQ_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_McooZiUUIQ_required = true;
		}
	}
}

// the McooZiU Some function
function main_source_McooZiU_SomeFunc(main_source_McooZiU)
{
	// set the function logic
	if (main_source_McooZiU == 2)
	{
		return true;
	}
	return false;
}

// the xZJeHvC function
function xZJeHvC(main_source_xZJeHvC)
{
	if (isSet(main_source_xZJeHvC) && main_source_xZJeHvC.constructor !== Array)
	{
		var temp_xZJeHvC = main_source_xZJeHvC;
		var main_source_xZJeHvC = [];
		main_source_xZJeHvC.push(temp_xZJeHvC);
	}
	else if (!isSet(main_source_xZJeHvC))
	{
		var main_source_xZJeHvC = [];
	}
	var main_source = main_source_xZJeHvC.some(main_source_xZJeHvC_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_xZJeHvCsys_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_xZJeHvCsys_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_xZJeHvCsys_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_xZJeHvCsys_required = true;
		}
	}
}

// the xZJeHvC Some function
function main_source_xZJeHvC_SomeFunc(main_source_xZJeHvC)
{
	// set the function logic
	if (main_source_xZJeHvC == 2)
	{
		return true;
	}
	return false;
}

// the zylrqpV function
function zylrqpV(addcalculation_zylrqpV)
{
	// set the function logic
	if (addcalculation_zylrqpV == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_zylrqpVWUm_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_zylrqpVWUm_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_zylrqpVWUm_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_zylrqpVWUm_required = true;
		}
	}
}

// the MJoWXuh function
function MJoWXuh(addcalculation_MJoWXuh,gettype_MJoWXuh)
{
	if (isSet(addcalculation_MJoWXuh) && addcalculation_MJoWXuh.constructor !== Array)
	{
		var temp_MJoWXuh = addcalculation_MJoWXuh;
		var addcalculation_MJoWXuh = [];
		addcalculation_MJoWXuh.push(temp_MJoWXuh);
	}
	else if (!isSet(addcalculation_MJoWXuh))
	{
		var addcalculation_MJoWXuh = [];
	}
	var addcalculation = addcalculation_MJoWXuh.some(addcalculation_MJoWXuh_SomeFunc);

	if (isSet(gettype_MJoWXuh) && gettype_MJoWXuh.constructor !== Array)
	{
		var temp_MJoWXuh = gettype_MJoWXuh;
		var gettype_MJoWXuh = [];
		gettype_MJoWXuh.push(temp_MJoWXuh);
	}
	else if (!isSet(gettype_MJoWXuh))
	{
		var gettype_MJoWXuh = [];
	}
	var gettype = gettype_MJoWXuh.some(gettype_MJoWXuh_SomeFunc);


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

// the MJoWXuh Some function
function addcalculation_MJoWXuh_SomeFunc(addcalculation_MJoWXuh)
{
	// set the function logic
	if (addcalculation_MJoWXuh == 1)
	{
		return true;
	}
	return false;
}

// the MJoWXuh Some function
function gettype_MJoWXuh_SomeFunc(gettype_MJoWXuh)
{
	// set the function logic
	if (gettype_MJoWXuh == 1 || gettype_MJoWXuh == 3)
	{
		return true;
	}
	return false;
}

// the SpQINPu function
function SpQINPu(addcalculation_SpQINPu,gettype_SpQINPu)
{
	if (isSet(addcalculation_SpQINPu) && addcalculation_SpQINPu.constructor !== Array)
	{
		var temp_SpQINPu = addcalculation_SpQINPu;
		var addcalculation_SpQINPu = [];
		addcalculation_SpQINPu.push(temp_SpQINPu);
	}
	else if (!isSet(addcalculation_SpQINPu))
	{
		var addcalculation_SpQINPu = [];
	}
	var addcalculation = addcalculation_SpQINPu.some(addcalculation_SpQINPu_SomeFunc);

	if (isSet(gettype_SpQINPu) && gettype_SpQINPu.constructor !== Array)
	{
		var temp_SpQINPu = gettype_SpQINPu;
		var gettype_SpQINPu = [];
		gettype_SpQINPu.push(temp_SpQINPu);
	}
	else if (!isSet(gettype_SpQINPu))
	{
		var gettype_SpQINPu = [];
	}
	var gettype = gettype_SpQINPu.some(gettype_SpQINPu_SomeFunc);


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

// the SpQINPu Some function
function addcalculation_SpQINPu_SomeFunc(addcalculation_SpQINPu)
{
	// set the function logic
	if (addcalculation_SpQINPu == 1)
	{
		return true;
	}
	return false;
}

// the SpQINPu Some function
function gettype_SpQINPu_SomeFunc(gettype_SpQINPu)
{
	// set the function logic
	if (gettype_SpQINPu == 2 || gettype_SpQINPu == 4)
	{
		return true;
	}
	return false;
}

// the obQcKhZ function
function obQcKhZ(main_source_obQcKhZ)
{
	if (isSet(main_source_obQcKhZ) && main_source_obQcKhZ.constructor !== Array)
	{
		var temp_obQcKhZ = main_source_obQcKhZ;
		var main_source_obQcKhZ = [];
		main_source_obQcKhZ.push(temp_obQcKhZ);
	}
	else if (!isSet(main_source_obQcKhZ))
	{
		var main_source_obQcKhZ = [];
	}
	var main_source = main_source_obQcKhZ.some(main_source_obQcKhZ_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_obQcKhZIwe_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_obQcKhZIwe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_obQcKhZIwe_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_obQcKhZIwe_required = true;
		}
	}
}

// the obQcKhZ Some function
function main_source_obQcKhZ_SomeFunc(main_source_obQcKhZ)
{
	// set the function logic
	if (main_source_obQcKhZ == 3)
	{
		return true;
	}
	return false;
}

// the DKWnxOF function
function DKWnxOF(main_source_DKWnxOF)
{
	if (isSet(main_source_DKWnxOF) && main_source_DKWnxOF.constructor !== Array)
	{
		var temp_DKWnxOF = main_source_DKWnxOF;
		var main_source_DKWnxOF = [];
		main_source_DKWnxOF.push(temp_DKWnxOF);
	}
	else if (!isSet(main_source_DKWnxOF))
	{
		var main_source_DKWnxOF = [];
	}
	var main_source = main_source_DKWnxOF.some(main_source_DKWnxOF_SomeFunc);


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

// the DKWnxOF Some function
function main_source_DKWnxOF_SomeFunc(main_source_DKWnxOF)
{
	// set the function logic
	if (main_source_DKWnxOF == 1 || main_source_DKWnxOF == 2)
	{
		return true;
	}
	return false;
}

// the qsHGlds function
function qsHGlds(add_php_before_getitem_qsHGlds,gettype_qsHGlds)
{
	if (isSet(add_php_before_getitem_qsHGlds) && add_php_before_getitem_qsHGlds.constructor !== Array)
	{
		var temp_qsHGlds = add_php_before_getitem_qsHGlds;
		var add_php_before_getitem_qsHGlds = [];
		add_php_before_getitem_qsHGlds.push(temp_qsHGlds);
	}
	else if (!isSet(add_php_before_getitem_qsHGlds))
	{
		var add_php_before_getitem_qsHGlds = [];
	}
	var add_php_before_getitem = add_php_before_getitem_qsHGlds.some(add_php_before_getitem_qsHGlds_SomeFunc);

	if (isSet(gettype_qsHGlds) && gettype_qsHGlds.constructor !== Array)
	{
		var temp_qsHGlds = gettype_qsHGlds;
		var gettype_qsHGlds = [];
		gettype_qsHGlds.push(temp_qsHGlds);
	}
	else if (!isSet(gettype_qsHGlds))
	{
		var gettype_qsHGlds = [];
	}
	var gettype = gettype_qsHGlds.some(gettype_qsHGlds_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_qsHGldsHdk_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_qsHGldsHdk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_qsHGldsHdk_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_qsHGldsHdk_required = true;
		}
	}
}

// the qsHGlds Some function
function add_php_before_getitem_qsHGlds_SomeFunc(add_php_before_getitem_qsHGlds)
{
	// set the function logic
	if (add_php_before_getitem_qsHGlds == 1)
	{
		return true;
	}
	return false;
}

// the qsHGlds Some function
function gettype_qsHGlds_SomeFunc(gettype_qsHGlds)
{
	// set the function logic
	if (gettype_qsHGlds == 1 || gettype_qsHGlds == 3)
	{
		return true;
	}
	return false;
}

// the nDrOPtH function
function nDrOPtH(add_php_after_getitem_nDrOPtH,gettype_nDrOPtH)
{
	if (isSet(add_php_after_getitem_nDrOPtH) && add_php_after_getitem_nDrOPtH.constructor !== Array)
	{
		var temp_nDrOPtH = add_php_after_getitem_nDrOPtH;
		var add_php_after_getitem_nDrOPtH = [];
		add_php_after_getitem_nDrOPtH.push(temp_nDrOPtH);
	}
	else if (!isSet(add_php_after_getitem_nDrOPtH))
	{
		var add_php_after_getitem_nDrOPtH = [];
	}
	var add_php_after_getitem = add_php_after_getitem_nDrOPtH.some(add_php_after_getitem_nDrOPtH_SomeFunc);

	if (isSet(gettype_nDrOPtH) && gettype_nDrOPtH.constructor !== Array)
	{
		var temp_nDrOPtH = gettype_nDrOPtH;
		var gettype_nDrOPtH = [];
		gettype_nDrOPtH.push(temp_nDrOPtH);
	}
	else if (!isSet(gettype_nDrOPtH))
	{
		var gettype_nDrOPtH = [];
	}
	var gettype = gettype_nDrOPtH.some(gettype_nDrOPtH_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_nDrOPtHSYK_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_nDrOPtHSYK_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_nDrOPtHSYK_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_nDrOPtHSYK_required = true;
		}
	}
}

// the nDrOPtH Some function
function add_php_after_getitem_nDrOPtH_SomeFunc(add_php_after_getitem_nDrOPtH)
{
	// set the function logic
	if (add_php_after_getitem_nDrOPtH == 1)
	{
		return true;
	}
	return false;
}

// the nDrOPtH Some function
function gettype_nDrOPtH_SomeFunc(gettype_nDrOPtH)
{
	// set the function logic
	if (gettype_nDrOPtH == 1 || gettype_nDrOPtH == 3)
	{
		return true;
	}
	return false;
}

// the rFFXUXF function
function rFFXUXF(gettype_rFFXUXF)
{
	if (isSet(gettype_rFFXUXF) && gettype_rFFXUXF.constructor !== Array)
	{
		var temp_rFFXUXF = gettype_rFFXUXF;
		var gettype_rFFXUXF = [];
		gettype_rFFXUXF.push(temp_rFFXUXF);
	}
	else if (!isSet(gettype_rFFXUXF))
	{
		var gettype_rFFXUXF = [];
	}
	var gettype = gettype_rFFXUXF.some(gettype_rFFXUXF_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_rFFXUXFBiB_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_rFFXUXFBiB_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_rFFXUXFUNM_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_rFFXUXFUNM_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_rFFXUXFBiB_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_rFFXUXFBiB_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_rFFXUXFUNM_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_rFFXUXFUNM_required = true;
		}
	}
}

// the rFFXUXF Some function
function gettype_rFFXUXF_SomeFunc(gettype_rFFXUXF)
{
	// set the function logic
	if (gettype_rFFXUXF == 1 || gettype_rFFXUXF == 3)
	{
		return true;
	}
	return false;
}

// the fZixNaL function
function fZixNaL(add_php_getlistquery_fZixNaL,gettype_fZixNaL)
{
	if (isSet(add_php_getlistquery_fZixNaL) && add_php_getlistquery_fZixNaL.constructor !== Array)
	{
		var temp_fZixNaL = add_php_getlistquery_fZixNaL;
		var add_php_getlistquery_fZixNaL = [];
		add_php_getlistquery_fZixNaL.push(temp_fZixNaL);
	}
	else if (!isSet(add_php_getlistquery_fZixNaL))
	{
		var add_php_getlistquery_fZixNaL = [];
	}
	var add_php_getlistquery = add_php_getlistquery_fZixNaL.some(add_php_getlistquery_fZixNaL_SomeFunc);

	if (isSet(gettype_fZixNaL) && gettype_fZixNaL.constructor !== Array)
	{
		var temp_fZixNaL = gettype_fZixNaL;
		var gettype_fZixNaL = [];
		gettype_fZixNaL.push(temp_fZixNaL);
	}
	else if (!isSet(gettype_fZixNaL))
	{
		var gettype_fZixNaL = [];
	}
	var gettype = gettype_fZixNaL.some(gettype_fZixNaL_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_fZixNaLoUF_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_fZixNaLoUF_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_fZixNaLoUF_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_fZixNaLoUF_required = true;
		}
	}
}

// the fZixNaL Some function
function add_php_getlistquery_fZixNaL_SomeFunc(add_php_getlistquery_fZixNaL)
{
	// set the function logic
	if (add_php_getlistquery_fZixNaL == 1)
	{
		return true;
	}
	return false;
}

// the fZixNaL Some function
function gettype_fZixNaL_SomeFunc(gettype_fZixNaL)
{
	// set the function logic
	if (gettype_fZixNaL == 2 || gettype_fZixNaL == 4)
	{
		return true;
	}
	return false;
}

// the dJlwHnq function
function dJlwHnq(add_php_before_getitems_dJlwHnq,gettype_dJlwHnq)
{
	if (isSet(add_php_before_getitems_dJlwHnq) && add_php_before_getitems_dJlwHnq.constructor !== Array)
	{
		var temp_dJlwHnq = add_php_before_getitems_dJlwHnq;
		var add_php_before_getitems_dJlwHnq = [];
		add_php_before_getitems_dJlwHnq.push(temp_dJlwHnq);
	}
	else if (!isSet(add_php_before_getitems_dJlwHnq))
	{
		var add_php_before_getitems_dJlwHnq = [];
	}
	var add_php_before_getitems = add_php_before_getitems_dJlwHnq.some(add_php_before_getitems_dJlwHnq_SomeFunc);

	if (isSet(gettype_dJlwHnq) && gettype_dJlwHnq.constructor !== Array)
	{
		var temp_dJlwHnq = gettype_dJlwHnq;
		var gettype_dJlwHnq = [];
		gettype_dJlwHnq.push(temp_dJlwHnq);
	}
	else if (!isSet(gettype_dJlwHnq))
	{
		var gettype_dJlwHnq = [];
	}
	var gettype = gettype_dJlwHnq.some(gettype_dJlwHnq_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_dJlwHnqHAW_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_dJlwHnqHAW_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_dJlwHnqHAW_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_dJlwHnqHAW_required = true;
		}
	}
}

// the dJlwHnq Some function
function add_php_before_getitems_dJlwHnq_SomeFunc(add_php_before_getitems_dJlwHnq)
{
	// set the function logic
	if (add_php_before_getitems_dJlwHnq == 1)
	{
		return true;
	}
	return false;
}

// the dJlwHnq Some function
function gettype_dJlwHnq_SomeFunc(gettype_dJlwHnq)
{
	// set the function logic
	if (gettype_dJlwHnq == 2 || gettype_dJlwHnq == 4)
	{
		return true;
	}
	return false;
}

// the qyQnfur function
function qyQnfur(add_php_after_getitems_qyQnfur,gettype_qyQnfur)
{
	if (isSet(add_php_after_getitems_qyQnfur) && add_php_after_getitems_qyQnfur.constructor !== Array)
	{
		var temp_qyQnfur = add_php_after_getitems_qyQnfur;
		var add_php_after_getitems_qyQnfur = [];
		add_php_after_getitems_qyQnfur.push(temp_qyQnfur);
	}
	else if (!isSet(add_php_after_getitems_qyQnfur))
	{
		var add_php_after_getitems_qyQnfur = [];
	}
	var add_php_after_getitems = add_php_after_getitems_qyQnfur.some(add_php_after_getitems_qyQnfur_SomeFunc);

	if (isSet(gettype_qyQnfur) && gettype_qyQnfur.constructor !== Array)
	{
		var temp_qyQnfur = gettype_qyQnfur;
		var gettype_qyQnfur = [];
		gettype_qyQnfur.push(temp_qyQnfur);
	}
	else if (!isSet(gettype_qyQnfur))
	{
		var gettype_qyQnfur = [];
	}
	var gettype = gettype_qyQnfur.some(gettype_qyQnfur_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_qyQnfurGqi_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_qyQnfurGqi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_qyQnfurGqi_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_qyQnfurGqi_required = true;
		}
	}
}

// the qyQnfur Some function
function add_php_after_getitems_qyQnfur_SomeFunc(add_php_after_getitems_qyQnfur)
{
	// set the function logic
	if (add_php_after_getitems_qyQnfur == 1)
	{
		return true;
	}
	return false;
}

// the qyQnfur Some function
function gettype_qyQnfur_SomeFunc(gettype_qyQnfur)
{
	// set the function logic
	if (gettype_qyQnfur == 2 || gettype_qyQnfur == 4)
	{
		return true;
	}
	return false;
}

// the Eltkuhs function
function Eltkuhs(gettype_Eltkuhs)
{
	if (isSet(gettype_Eltkuhs) && gettype_Eltkuhs.constructor !== Array)
	{
		var temp_Eltkuhs = gettype_Eltkuhs;
		var gettype_Eltkuhs = [];
		gettype_Eltkuhs.push(temp_Eltkuhs);
	}
	else if (!isSet(gettype_Eltkuhs))
	{
		var gettype_Eltkuhs = [];
	}
	var gettype = gettype_Eltkuhs.some(gettype_Eltkuhs_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_EltkuhsLTM_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_EltkuhsLTM_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_Eltkuhscut_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_Eltkuhscut_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_EltkuhsYHR_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_EltkuhsYHR_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_EltkuhsLTM_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_EltkuhsLTM_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_Eltkuhscut_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_Eltkuhscut_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_EltkuhsYHR_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_EltkuhsYHR_required = true;
		}
	}
}

// the Eltkuhs Some function
function gettype_Eltkuhs_SomeFunc(gettype_Eltkuhs)
{
	// set the function logic
	if (gettype_Eltkuhs == 2 || gettype_Eltkuhs == 4)
	{
		return true;
	}
	return false;
}

// the PUWmnBK function
function PUWmnBK(gettype_PUWmnBK)
{
	if (isSet(gettype_PUWmnBK) && gettype_PUWmnBK.constructor !== Array)
	{
		var temp_PUWmnBK = gettype_PUWmnBK;
		var gettype_PUWmnBK = [];
		gettype_PUWmnBK.push(temp_PUWmnBK);
	}
	else if (!isSet(gettype_PUWmnBK))
	{
		var gettype_PUWmnBK = [];
	}
	var gettype = gettype_PUWmnBK.some(gettype_PUWmnBK_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_PUWmnBKDZg_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_PUWmnBKDZg_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_PUWmnBKDZg_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_PUWmnBKDZg_required = true;
		}
	}
}

// the PUWmnBK Some function
function gettype_PUWmnBK_SomeFunc(gettype_PUWmnBK)
{
	// set the function logic
	if (gettype_PUWmnBK == 2)
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
