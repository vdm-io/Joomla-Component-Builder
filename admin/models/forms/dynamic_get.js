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
	@build			31st January, 2016
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
jform_uhmpvFRsln_required = false;
jform_viJPqmXSJW_required = false;
jform_FFEwuyqlci_required = false;
jform_LvuYTPEFkV_required = false;
jform_ZMeCvuVBhK_required = false;
jform_qHjbkLGHTI_required = false;
jform_jGrXfveFAa_required = false;
jform_TyycokTrEU_required = false;
jform_BgxxqfKnkl_required = false;
jform_FrDJmVmoev_required = false;
jform_FrDJmVmnDa_required = false;
jform_dggICwLpFT_required = false;
jform_vRPhexTFjm_required = false;
jform_bWGUoUaHhw_required = false;
jform_DuMzQyjaKM_required = false;
jform_DuMzQyjViU_required = false;
jform_DuMzQyjkoT_required = false;
jform_OhdLgORLCb_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_uhmpvFR = jQuery("#jform_gettype").val();
	uhmpvFR(gettype_uhmpvFR);

	var main_source_viJPqmX = jQuery("#jform_main_source").val();
	viJPqmX(main_source_viJPqmX);

	var main_source_FFEwuyq = jQuery("#jform_main_source").val();
	FFEwuyq(main_source_FFEwuyq);

	var main_source_LvuYTPE = jQuery("#jform_main_source").val();
	LvuYTPE(main_source_LvuYTPE);

	var main_source_ZMeCvuV = jQuery("#jform_main_source").val();
	ZMeCvuV(main_source_ZMeCvuV);

	var addcalculation_qHjbkLG = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	qHjbkLG(addcalculation_qHjbkLG);

	var addcalculation_NGghFXW = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_NGghFXW = jQuery("#jform_gettype").val();
	NGghFXW(addcalculation_NGghFXW,gettype_NGghFXW);

	var addcalculation_kJhdBSg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_kJhdBSg = jQuery("#jform_gettype").val();
	kJhdBSg(addcalculation_kJhdBSg,gettype_kJhdBSg);

	var main_source_jGrXfve = jQuery("#jform_main_source").val();
	jGrXfve(main_source_jGrXfve);

	var main_source_RchWLce = jQuery("#jform_main_source").val();
	RchWLce(main_source_RchWLce);

	var add_php_before_getitem_TyycokT = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_TyycokT = jQuery("#jform_gettype").val();
	TyycokT(add_php_before_getitem_TyycokT,gettype_TyycokT);

	var add_php_after_getitem_BgxxqfK = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_BgxxqfK = jQuery("#jform_gettype").val();
	BgxxqfK(add_php_after_getitem_BgxxqfK,gettype_BgxxqfK);

	var gettype_FrDJmVm = jQuery("#jform_gettype").val();
	FrDJmVm(gettype_FrDJmVm);

	var add_php_getlistquery_dggICwL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_dggICwL = jQuery("#jform_gettype").val();
	dggICwL(add_php_getlistquery_dggICwL,gettype_dggICwL);

	var add_php_before_getitems_vRPhexT = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_vRPhexT = jQuery("#jform_gettype").val();
	vRPhexT(add_php_before_getitems_vRPhexT,gettype_vRPhexT);

	var add_php_after_getitems_bWGUoUa = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_bWGUoUa = jQuery("#jform_gettype").val();
	bWGUoUa(add_php_after_getitems_bWGUoUa,gettype_bWGUoUa);

	var gettype_DuMzQyj = jQuery("#jform_gettype").val();
	DuMzQyj(gettype_DuMzQyj);

	var gettype_OhdLgOR = jQuery("#jform_gettype").val();
	OhdLgOR(gettype_OhdLgOR);
});

// the uhmpvFR function
function uhmpvFR(gettype_uhmpvFR)
{
	if (isSet(gettype_uhmpvFR) && gettype_uhmpvFR.constructor !== Array)
	{
		var temp_uhmpvFR = gettype_uhmpvFR;
		var gettype_uhmpvFR = [];
		gettype_uhmpvFR.push(temp_uhmpvFR);
	}
	else if (!isSet(gettype_uhmpvFR))
	{
		var gettype_uhmpvFR = [];
	}
	var gettype = gettype_uhmpvFR.some(gettype_uhmpvFR_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_uhmpvFRsln_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_uhmpvFRsln_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_uhmpvFRsln_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_uhmpvFRsln_required = true;
		}
	}
}

// the uhmpvFR Some function
function gettype_uhmpvFR_SomeFunc(gettype_uhmpvFR)
{
	// set the function logic
	if (gettype_uhmpvFR == 3 || gettype_uhmpvFR == 4)
	{
		return true;
	}
	return false;
}

// the viJPqmX function
function viJPqmX(main_source_viJPqmX)
{
	if (isSet(main_source_viJPqmX) && main_source_viJPqmX.constructor !== Array)
	{
		var temp_viJPqmX = main_source_viJPqmX;
		var main_source_viJPqmX = [];
		main_source_viJPqmX.push(temp_viJPqmX);
	}
	else if (!isSet(main_source_viJPqmX))
	{
		var main_source_viJPqmX = [];
	}
	var main_source = main_source_viJPqmX.some(main_source_viJPqmX_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_viJPqmXSJW_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_viJPqmXSJW_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_viJPqmXSJW_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_viJPqmXSJW_required = true;
		}
	}
}

// the viJPqmX Some function
function main_source_viJPqmX_SomeFunc(main_source_viJPqmX)
{
	// set the function logic
	if (main_source_viJPqmX == 1)
	{
		return true;
	}
	return false;
}

// the FFEwuyq function
function FFEwuyq(main_source_FFEwuyq)
{
	if (isSet(main_source_FFEwuyq) && main_source_FFEwuyq.constructor !== Array)
	{
		var temp_FFEwuyq = main_source_FFEwuyq;
		var main_source_FFEwuyq = [];
		main_source_FFEwuyq.push(temp_FFEwuyq);
	}
	else if (!isSet(main_source_FFEwuyq))
	{
		var main_source_FFEwuyq = [];
	}
	var main_source = main_source_FFEwuyq.some(main_source_FFEwuyq_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_FFEwuyqlci_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_FFEwuyqlci_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_FFEwuyqlci_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_FFEwuyqlci_required = true;
		}
	}
}

// the FFEwuyq Some function
function main_source_FFEwuyq_SomeFunc(main_source_FFEwuyq)
{
	// set the function logic
	if (main_source_FFEwuyq == 1)
	{
		return true;
	}
	return false;
}

// the LvuYTPE function
function LvuYTPE(main_source_LvuYTPE)
{
	if (isSet(main_source_LvuYTPE) && main_source_LvuYTPE.constructor !== Array)
	{
		var temp_LvuYTPE = main_source_LvuYTPE;
		var main_source_LvuYTPE = [];
		main_source_LvuYTPE.push(temp_LvuYTPE);
	}
	else if (!isSet(main_source_LvuYTPE))
	{
		var main_source_LvuYTPE = [];
	}
	var main_source = main_source_LvuYTPE.some(main_source_LvuYTPE_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_LvuYTPEFkV_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_LvuYTPEFkV_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_LvuYTPEFkV_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_LvuYTPEFkV_required = true;
		}
	}
}

// the LvuYTPE Some function
function main_source_LvuYTPE_SomeFunc(main_source_LvuYTPE)
{
	// set the function logic
	if (main_source_LvuYTPE == 2)
	{
		return true;
	}
	return false;
}

// the ZMeCvuV function
function ZMeCvuV(main_source_ZMeCvuV)
{
	if (isSet(main_source_ZMeCvuV) && main_source_ZMeCvuV.constructor !== Array)
	{
		var temp_ZMeCvuV = main_source_ZMeCvuV;
		var main_source_ZMeCvuV = [];
		main_source_ZMeCvuV.push(temp_ZMeCvuV);
	}
	else if (!isSet(main_source_ZMeCvuV))
	{
		var main_source_ZMeCvuV = [];
	}
	var main_source = main_source_ZMeCvuV.some(main_source_ZMeCvuV_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_ZMeCvuVBhK_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_ZMeCvuVBhK_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_ZMeCvuVBhK_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_ZMeCvuVBhK_required = true;
		}
	}
}

// the ZMeCvuV Some function
function main_source_ZMeCvuV_SomeFunc(main_source_ZMeCvuV)
{
	// set the function logic
	if (main_source_ZMeCvuV == 2)
	{
		return true;
	}
	return false;
}

// the qHjbkLG function
function qHjbkLG(addcalculation_qHjbkLG)
{
	// set the function logic
	if (addcalculation_qHjbkLG == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_qHjbkLGHTI_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_qHjbkLGHTI_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_qHjbkLGHTI_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_qHjbkLGHTI_required = true;
		}
	}
}

// the NGghFXW function
function NGghFXW(addcalculation_NGghFXW,gettype_NGghFXW)
{
	if (isSet(addcalculation_NGghFXW) && addcalculation_NGghFXW.constructor !== Array)
	{
		var temp_NGghFXW = addcalculation_NGghFXW;
		var addcalculation_NGghFXW = [];
		addcalculation_NGghFXW.push(temp_NGghFXW);
	}
	else if (!isSet(addcalculation_NGghFXW))
	{
		var addcalculation_NGghFXW = [];
	}
	var addcalculation = addcalculation_NGghFXW.some(addcalculation_NGghFXW_SomeFunc);

	if (isSet(gettype_NGghFXW) && gettype_NGghFXW.constructor !== Array)
	{
		var temp_NGghFXW = gettype_NGghFXW;
		var gettype_NGghFXW = [];
		gettype_NGghFXW.push(temp_NGghFXW);
	}
	else if (!isSet(gettype_NGghFXW))
	{
		var gettype_NGghFXW = [];
	}
	var gettype = gettype_NGghFXW.some(gettype_NGghFXW_SomeFunc);


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

// the NGghFXW Some function
function addcalculation_NGghFXW_SomeFunc(addcalculation_NGghFXW)
{
	// set the function logic
	if (addcalculation_NGghFXW == 1)
	{
		return true;
	}
	return false;
}

// the NGghFXW Some function
function gettype_NGghFXW_SomeFunc(gettype_NGghFXW)
{
	// set the function logic
	if (gettype_NGghFXW == 1 || gettype_NGghFXW == 3)
	{
		return true;
	}
	return false;
}

// the kJhdBSg function
function kJhdBSg(addcalculation_kJhdBSg,gettype_kJhdBSg)
{
	if (isSet(addcalculation_kJhdBSg) && addcalculation_kJhdBSg.constructor !== Array)
	{
		var temp_kJhdBSg = addcalculation_kJhdBSg;
		var addcalculation_kJhdBSg = [];
		addcalculation_kJhdBSg.push(temp_kJhdBSg);
	}
	else if (!isSet(addcalculation_kJhdBSg))
	{
		var addcalculation_kJhdBSg = [];
	}
	var addcalculation = addcalculation_kJhdBSg.some(addcalculation_kJhdBSg_SomeFunc);

	if (isSet(gettype_kJhdBSg) && gettype_kJhdBSg.constructor !== Array)
	{
		var temp_kJhdBSg = gettype_kJhdBSg;
		var gettype_kJhdBSg = [];
		gettype_kJhdBSg.push(temp_kJhdBSg);
	}
	else if (!isSet(gettype_kJhdBSg))
	{
		var gettype_kJhdBSg = [];
	}
	var gettype = gettype_kJhdBSg.some(gettype_kJhdBSg_SomeFunc);


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

// the kJhdBSg Some function
function addcalculation_kJhdBSg_SomeFunc(addcalculation_kJhdBSg)
{
	// set the function logic
	if (addcalculation_kJhdBSg == 1)
	{
		return true;
	}
	return false;
}

// the kJhdBSg Some function
function gettype_kJhdBSg_SomeFunc(gettype_kJhdBSg)
{
	// set the function logic
	if (gettype_kJhdBSg == 2 || gettype_kJhdBSg == 4)
	{
		return true;
	}
	return false;
}

// the jGrXfve function
function jGrXfve(main_source_jGrXfve)
{
	if (isSet(main_source_jGrXfve) && main_source_jGrXfve.constructor !== Array)
	{
		var temp_jGrXfve = main_source_jGrXfve;
		var main_source_jGrXfve = [];
		main_source_jGrXfve.push(temp_jGrXfve);
	}
	else if (!isSet(main_source_jGrXfve))
	{
		var main_source_jGrXfve = [];
	}
	var main_source = main_source_jGrXfve.some(main_source_jGrXfve_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_jGrXfveFAa_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_jGrXfveFAa_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_jGrXfveFAa_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_jGrXfveFAa_required = true;
		}
	}
}

// the jGrXfve Some function
function main_source_jGrXfve_SomeFunc(main_source_jGrXfve)
{
	// set the function logic
	if (main_source_jGrXfve == 3)
	{
		return true;
	}
	return false;
}

// the RchWLce function
function RchWLce(main_source_RchWLce)
{
	if (isSet(main_source_RchWLce) && main_source_RchWLce.constructor !== Array)
	{
		var temp_RchWLce = main_source_RchWLce;
		var main_source_RchWLce = [];
		main_source_RchWLce.push(temp_RchWLce);
	}
	else if (!isSet(main_source_RchWLce))
	{
		var main_source_RchWLce = [];
	}
	var main_source = main_source_RchWLce.some(main_source_RchWLce_SomeFunc);


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

// the RchWLce Some function
function main_source_RchWLce_SomeFunc(main_source_RchWLce)
{
	// set the function logic
	if (main_source_RchWLce == 1 || main_source_RchWLce == 2)
	{
		return true;
	}
	return false;
}

// the TyycokT function
function TyycokT(add_php_before_getitem_TyycokT,gettype_TyycokT)
{
	if (isSet(add_php_before_getitem_TyycokT) && add_php_before_getitem_TyycokT.constructor !== Array)
	{
		var temp_TyycokT = add_php_before_getitem_TyycokT;
		var add_php_before_getitem_TyycokT = [];
		add_php_before_getitem_TyycokT.push(temp_TyycokT);
	}
	else if (!isSet(add_php_before_getitem_TyycokT))
	{
		var add_php_before_getitem_TyycokT = [];
	}
	var add_php_before_getitem = add_php_before_getitem_TyycokT.some(add_php_before_getitem_TyycokT_SomeFunc);

	if (isSet(gettype_TyycokT) && gettype_TyycokT.constructor !== Array)
	{
		var temp_TyycokT = gettype_TyycokT;
		var gettype_TyycokT = [];
		gettype_TyycokT.push(temp_TyycokT);
	}
	else if (!isSet(gettype_TyycokT))
	{
		var gettype_TyycokT = [];
	}
	var gettype = gettype_TyycokT.some(gettype_TyycokT_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_TyycokTrEU_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_TyycokTrEU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_TyycokTrEU_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_TyycokTrEU_required = true;
		}
	}
}

// the TyycokT Some function
function add_php_before_getitem_TyycokT_SomeFunc(add_php_before_getitem_TyycokT)
{
	// set the function logic
	if (add_php_before_getitem_TyycokT == 1)
	{
		return true;
	}
	return false;
}

// the TyycokT Some function
function gettype_TyycokT_SomeFunc(gettype_TyycokT)
{
	// set the function logic
	if (gettype_TyycokT == 1 || gettype_TyycokT == 3)
	{
		return true;
	}
	return false;
}

// the BgxxqfK function
function BgxxqfK(add_php_after_getitem_BgxxqfK,gettype_BgxxqfK)
{
	if (isSet(add_php_after_getitem_BgxxqfK) && add_php_after_getitem_BgxxqfK.constructor !== Array)
	{
		var temp_BgxxqfK = add_php_after_getitem_BgxxqfK;
		var add_php_after_getitem_BgxxqfK = [];
		add_php_after_getitem_BgxxqfK.push(temp_BgxxqfK);
	}
	else if (!isSet(add_php_after_getitem_BgxxqfK))
	{
		var add_php_after_getitem_BgxxqfK = [];
	}
	var add_php_after_getitem = add_php_after_getitem_BgxxqfK.some(add_php_after_getitem_BgxxqfK_SomeFunc);

	if (isSet(gettype_BgxxqfK) && gettype_BgxxqfK.constructor !== Array)
	{
		var temp_BgxxqfK = gettype_BgxxqfK;
		var gettype_BgxxqfK = [];
		gettype_BgxxqfK.push(temp_BgxxqfK);
	}
	else if (!isSet(gettype_BgxxqfK))
	{
		var gettype_BgxxqfK = [];
	}
	var gettype = gettype_BgxxqfK.some(gettype_BgxxqfK_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_BgxxqfKnkl_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_BgxxqfKnkl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_BgxxqfKnkl_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_BgxxqfKnkl_required = true;
		}
	}
}

// the BgxxqfK Some function
function add_php_after_getitem_BgxxqfK_SomeFunc(add_php_after_getitem_BgxxqfK)
{
	// set the function logic
	if (add_php_after_getitem_BgxxqfK == 1)
	{
		return true;
	}
	return false;
}

// the BgxxqfK Some function
function gettype_BgxxqfK_SomeFunc(gettype_BgxxqfK)
{
	// set the function logic
	if (gettype_BgxxqfK == 1 || gettype_BgxxqfK == 3)
	{
		return true;
	}
	return false;
}

// the FrDJmVm function
function FrDJmVm(gettype_FrDJmVm)
{
	if (isSet(gettype_FrDJmVm) && gettype_FrDJmVm.constructor !== Array)
	{
		var temp_FrDJmVm = gettype_FrDJmVm;
		var gettype_FrDJmVm = [];
		gettype_FrDJmVm.push(temp_FrDJmVm);
	}
	else if (!isSet(gettype_FrDJmVm))
	{
		var gettype_FrDJmVm = [];
	}
	var gettype = gettype_FrDJmVm.some(gettype_FrDJmVm_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_FrDJmVmoev_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_FrDJmVmoev_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_FrDJmVmnDa_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_FrDJmVmnDa_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_FrDJmVmoev_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_FrDJmVmoev_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_FrDJmVmnDa_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_FrDJmVmnDa_required = true;
		}
	}
}

// the FrDJmVm Some function
function gettype_FrDJmVm_SomeFunc(gettype_FrDJmVm)
{
	// set the function logic
	if (gettype_FrDJmVm == 1 || gettype_FrDJmVm == 3)
	{
		return true;
	}
	return false;
}

// the dggICwL function
function dggICwL(add_php_getlistquery_dggICwL,gettype_dggICwL)
{
	if (isSet(add_php_getlistquery_dggICwL) && add_php_getlistquery_dggICwL.constructor !== Array)
	{
		var temp_dggICwL = add_php_getlistquery_dggICwL;
		var add_php_getlistquery_dggICwL = [];
		add_php_getlistquery_dggICwL.push(temp_dggICwL);
	}
	else if (!isSet(add_php_getlistquery_dggICwL))
	{
		var add_php_getlistquery_dggICwL = [];
	}
	var add_php_getlistquery = add_php_getlistquery_dggICwL.some(add_php_getlistquery_dggICwL_SomeFunc);

	if (isSet(gettype_dggICwL) && gettype_dggICwL.constructor !== Array)
	{
		var temp_dggICwL = gettype_dggICwL;
		var gettype_dggICwL = [];
		gettype_dggICwL.push(temp_dggICwL);
	}
	else if (!isSet(gettype_dggICwL))
	{
		var gettype_dggICwL = [];
	}
	var gettype = gettype_dggICwL.some(gettype_dggICwL_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_dggICwLpFT_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_dggICwLpFT_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_dggICwLpFT_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_dggICwLpFT_required = true;
		}
	}
}

// the dggICwL Some function
function add_php_getlistquery_dggICwL_SomeFunc(add_php_getlistquery_dggICwL)
{
	// set the function logic
	if (add_php_getlistquery_dggICwL == 1)
	{
		return true;
	}
	return false;
}

// the dggICwL Some function
function gettype_dggICwL_SomeFunc(gettype_dggICwL)
{
	// set the function logic
	if (gettype_dggICwL == 2 || gettype_dggICwL == 4)
	{
		return true;
	}
	return false;
}

// the vRPhexT function
function vRPhexT(add_php_before_getitems_vRPhexT,gettype_vRPhexT)
{
	if (isSet(add_php_before_getitems_vRPhexT) && add_php_before_getitems_vRPhexT.constructor !== Array)
	{
		var temp_vRPhexT = add_php_before_getitems_vRPhexT;
		var add_php_before_getitems_vRPhexT = [];
		add_php_before_getitems_vRPhexT.push(temp_vRPhexT);
	}
	else if (!isSet(add_php_before_getitems_vRPhexT))
	{
		var add_php_before_getitems_vRPhexT = [];
	}
	var add_php_before_getitems = add_php_before_getitems_vRPhexT.some(add_php_before_getitems_vRPhexT_SomeFunc);

	if (isSet(gettype_vRPhexT) && gettype_vRPhexT.constructor !== Array)
	{
		var temp_vRPhexT = gettype_vRPhexT;
		var gettype_vRPhexT = [];
		gettype_vRPhexT.push(temp_vRPhexT);
	}
	else if (!isSet(gettype_vRPhexT))
	{
		var gettype_vRPhexT = [];
	}
	var gettype = gettype_vRPhexT.some(gettype_vRPhexT_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_vRPhexTFjm_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_vRPhexTFjm_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_vRPhexTFjm_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_vRPhexTFjm_required = true;
		}
	}
}

// the vRPhexT Some function
function add_php_before_getitems_vRPhexT_SomeFunc(add_php_before_getitems_vRPhexT)
{
	// set the function logic
	if (add_php_before_getitems_vRPhexT == 1)
	{
		return true;
	}
	return false;
}

// the vRPhexT Some function
function gettype_vRPhexT_SomeFunc(gettype_vRPhexT)
{
	// set the function logic
	if (gettype_vRPhexT == 2 || gettype_vRPhexT == 4)
	{
		return true;
	}
	return false;
}

// the bWGUoUa function
function bWGUoUa(add_php_after_getitems_bWGUoUa,gettype_bWGUoUa)
{
	if (isSet(add_php_after_getitems_bWGUoUa) && add_php_after_getitems_bWGUoUa.constructor !== Array)
	{
		var temp_bWGUoUa = add_php_after_getitems_bWGUoUa;
		var add_php_after_getitems_bWGUoUa = [];
		add_php_after_getitems_bWGUoUa.push(temp_bWGUoUa);
	}
	else if (!isSet(add_php_after_getitems_bWGUoUa))
	{
		var add_php_after_getitems_bWGUoUa = [];
	}
	var add_php_after_getitems = add_php_after_getitems_bWGUoUa.some(add_php_after_getitems_bWGUoUa_SomeFunc);

	if (isSet(gettype_bWGUoUa) && gettype_bWGUoUa.constructor !== Array)
	{
		var temp_bWGUoUa = gettype_bWGUoUa;
		var gettype_bWGUoUa = [];
		gettype_bWGUoUa.push(temp_bWGUoUa);
	}
	else if (!isSet(gettype_bWGUoUa))
	{
		var gettype_bWGUoUa = [];
	}
	var gettype = gettype_bWGUoUa.some(gettype_bWGUoUa_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_bWGUoUaHhw_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_bWGUoUaHhw_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_bWGUoUaHhw_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_bWGUoUaHhw_required = true;
		}
	}
}

// the bWGUoUa Some function
function add_php_after_getitems_bWGUoUa_SomeFunc(add_php_after_getitems_bWGUoUa)
{
	// set the function logic
	if (add_php_after_getitems_bWGUoUa == 1)
	{
		return true;
	}
	return false;
}

// the bWGUoUa Some function
function gettype_bWGUoUa_SomeFunc(gettype_bWGUoUa)
{
	// set the function logic
	if (gettype_bWGUoUa == 2 || gettype_bWGUoUa == 4)
	{
		return true;
	}
	return false;
}

// the DuMzQyj function
function DuMzQyj(gettype_DuMzQyj)
{
	if (isSet(gettype_DuMzQyj) && gettype_DuMzQyj.constructor !== Array)
	{
		var temp_DuMzQyj = gettype_DuMzQyj;
		var gettype_DuMzQyj = [];
		gettype_DuMzQyj.push(temp_DuMzQyj);
	}
	else if (!isSet(gettype_DuMzQyj))
	{
		var gettype_DuMzQyj = [];
	}
	var gettype = gettype_DuMzQyj.some(gettype_DuMzQyj_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_DuMzQyjaKM_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_DuMzQyjaKM_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_DuMzQyjViU_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_DuMzQyjViU_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_DuMzQyjkoT_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_DuMzQyjkoT_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_DuMzQyjaKM_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_DuMzQyjaKM_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_DuMzQyjViU_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_DuMzQyjViU_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_DuMzQyjkoT_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_DuMzQyjkoT_required = true;
		}
	}
}

// the DuMzQyj Some function
function gettype_DuMzQyj_SomeFunc(gettype_DuMzQyj)
{
	// set the function logic
	if (gettype_DuMzQyj == 2 || gettype_DuMzQyj == 4)
	{
		return true;
	}
	return false;
}

// the OhdLgOR function
function OhdLgOR(gettype_OhdLgOR)
{
	if (isSet(gettype_OhdLgOR) && gettype_OhdLgOR.constructor !== Array)
	{
		var temp_OhdLgOR = gettype_OhdLgOR;
		var gettype_OhdLgOR = [];
		gettype_OhdLgOR.push(temp_OhdLgOR);
	}
	else if (!isSet(gettype_OhdLgOR))
	{
		var gettype_OhdLgOR = [];
	}
	var gettype = gettype_OhdLgOR.some(gettype_OhdLgOR_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_OhdLgORLCb_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_OhdLgORLCb_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_OhdLgORLCb_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_OhdLgORLCb_required = true;
		}
	}
}

// the OhdLgOR Some function
function gettype_OhdLgOR_SomeFunc(gettype_OhdLgOR)
{
	// set the function logic
	if (gettype_OhdLgOR == 2)
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
