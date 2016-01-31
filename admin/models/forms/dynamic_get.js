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
jform_FZGVCVByFj_required = false;
jform_GFZLiKCmGN_required = false;
jform_ygJcdolgWv_required = false;
jform_aBvLDXAgwl_required = false;
jform_nWWtBgefsK_required = false;
jform_SORuSWQgcM_required = false;
jform_QpPysiubZD_required = false;
jform_QfgugiSXZi_required = false;
jform_lLptvBiRTr_required = false;
jform_ltPMoURGaX_required = false;
jform_ltPMoURzXW_required = false;
jform_HnBdEdLLWH_required = false;
jform_XpwobPtGcU_required = false;
jform_wKesGPtxuy_required = false;
jform_ONeyMtTXuH_required = false;
jform_ONeyMtTyaO_required = false;
jform_ONeyMtTlwD_required = false;
jform_wWdgwIvNdx_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_FZGVCVB = jQuery("#jform_gettype").val();
	FZGVCVB(gettype_FZGVCVB);

	var main_source_GFZLiKC = jQuery("#jform_main_source").val();
	GFZLiKC(main_source_GFZLiKC);

	var main_source_ygJcdol = jQuery("#jform_main_source").val();
	ygJcdol(main_source_ygJcdol);

	var main_source_aBvLDXA = jQuery("#jform_main_source").val();
	aBvLDXA(main_source_aBvLDXA);

	var main_source_nWWtBge = jQuery("#jform_main_source").val();
	nWWtBge(main_source_nWWtBge);

	var addcalculation_SORuSWQ = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	SORuSWQ(addcalculation_SORuSWQ);

	var addcalculation_AcudNSb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_AcudNSb = jQuery("#jform_gettype").val();
	AcudNSb(addcalculation_AcudNSb,gettype_AcudNSb);

	var addcalculation_uXqArsE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_uXqArsE = jQuery("#jform_gettype").val();
	uXqArsE(addcalculation_uXqArsE,gettype_uXqArsE);

	var main_source_QpPysiu = jQuery("#jform_main_source").val();
	QpPysiu(main_source_QpPysiu);

	var main_source_pXRXojv = jQuery("#jform_main_source").val();
	pXRXojv(main_source_pXRXojv);

	var add_php_before_getitem_QfgugiS = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_QfgugiS = jQuery("#jform_gettype").val();
	QfgugiS(add_php_before_getitem_QfgugiS,gettype_QfgugiS);

	var add_php_after_getitem_lLptvBi = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_lLptvBi = jQuery("#jform_gettype").val();
	lLptvBi(add_php_after_getitem_lLptvBi,gettype_lLptvBi);

	var gettype_ltPMoUR = jQuery("#jform_gettype").val();
	ltPMoUR(gettype_ltPMoUR);

	var add_php_getlistquery_HnBdEdL = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_HnBdEdL = jQuery("#jform_gettype").val();
	HnBdEdL(add_php_getlistquery_HnBdEdL,gettype_HnBdEdL);

	var add_php_before_getitems_XpwobPt = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_XpwobPt = jQuery("#jform_gettype").val();
	XpwobPt(add_php_before_getitems_XpwobPt,gettype_XpwobPt);

	var add_php_after_getitems_wKesGPt = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wKesGPt = jQuery("#jform_gettype").val();
	wKesGPt(add_php_after_getitems_wKesGPt,gettype_wKesGPt);

	var gettype_ONeyMtT = jQuery("#jform_gettype").val();
	ONeyMtT(gettype_ONeyMtT);

	var gettype_wWdgwIv = jQuery("#jform_gettype").val();
	wWdgwIv(gettype_wWdgwIv);
});

// the FZGVCVB function
function FZGVCVB(gettype_FZGVCVB)
{
	if (isSet(gettype_FZGVCVB) && gettype_FZGVCVB.constructor !== Array)
	{
		var temp_FZGVCVB = gettype_FZGVCVB;
		var gettype_FZGVCVB = [];
		gettype_FZGVCVB.push(temp_FZGVCVB);
	}
	else if (!isSet(gettype_FZGVCVB))
	{
		var gettype_FZGVCVB = [];
	}
	var gettype = gettype_FZGVCVB.some(gettype_FZGVCVB_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_FZGVCVByFj_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_FZGVCVByFj_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_FZGVCVByFj_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_FZGVCVByFj_required = true;
		}
	}
}

// the FZGVCVB Some function
function gettype_FZGVCVB_SomeFunc(gettype_FZGVCVB)
{
	// set the function logic
	if (gettype_FZGVCVB == 3 || gettype_FZGVCVB == 4)
	{
		return true;
	}
	return false;
}

// the GFZLiKC function
function GFZLiKC(main_source_GFZLiKC)
{
	if (isSet(main_source_GFZLiKC) && main_source_GFZLiKC.constructor !== Array)
	{
		var temp_GFZLiKC = main_source_GFZLiKC;
		var main_source_GFZLiKC = [];
		main_source_GFZLiKC.push(temp_GFZLiKC);
	}
	else if (!isSet(main_source_GFZLiKC))
	{
		var main_source_GFZLiKC = [];
	}
	var main_source = main_source_GFZLiKC.some(main_source_GFZLiKC_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_GFZLiKCmGN_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_GFZLiKCmGN_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_GFZLiKCmGN_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_GFZLiKCmGN_required = true;
		}
	}
}

// the GFZLiKC Some function
function main_source_GFZLiKC_SomeFunc(main_source_GFZLiKC)
{
	// set the function logic
	if (main_source_GFZLiKC == 1)
	{
		return true;
	}
	return false;
}

// the ygJcdol function
function ygJcdol(main_source_ygJcdol)
{
	if (isSet(main_source_ygJcdol) && main_source_ygJcdol.constructor !== Array)
	{
		var temp_ygJcdol = main_source_ygJcdol;
		var main_source_ygJcdol = [];
		main_source_ygJcdol.push(temp_ygJcdol);
	}
	else if (!isSet(main_source_ygJcdol))
	{
		var main_source_ygJcdol = [];
	}
	var main_source = main_source_ygJcdol.some(main_source_ygJcdol_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_ygJcdolgWv_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_ygJcdolgWv_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_ygJcdolgWv_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_ygJcdolgWv_required = true;
		}
	}
}

// the ygJcdol Some function
function main_source_ygJcdol_SomeFunc(main_source_ygJcdol)
{
	// set the function logic
	if (main_source_ygJcdol == 1)
	{
		return true;
	}
	return false;
}

// the aBvLDXA function
function aBvLDXA(main_source_aBvLDXA)
{
	if (isSet(main_source_aBvLDXA) && main_source_aBvLDXA.constructor !== Array)
	{
		var temp_aBvLDXA = main_source_aBvLDXA;
		var main_source_aBvLDXA = [];
		main_source_aBvLDXA.push(temp_aBvLDXA);
	}
	else if (!isSet(main_source_aBvLDXA))
	{
		var main_source_aBvLDXA = [];
	}
	var main_source = main_source_aBvLDXA.some(main_source_aBvLDXA_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_aBvLDXAgwl_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_aBvLDXAgwl_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_aBvLDXAgwl_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_aBvLDXAgwl_required = true;
		}
	}
}

// the aBvLDXA Some function
function main_source_aBvLDXA_SomeFunc(main_source_aBvLDXA)
{
	// set the function logic
	if (main_source_aBvLDXA == 2)
	{
		return true;
	}
	return false;
}

// the nWWtBge function
function nWWtBge(main_source_nWWtBge)
{
	if (isSet(main_source_nWWtBge) && main_source_nWWtBge.constructor !== Array)
	{
		var temp_nWWtBge = main_source_nWWtBge;
		var main_source_nWWtBge = [];
		main_source_nWWtBge.push(temp_nWWtBge);
	}
	else if (!isSet(main_source_nWWtBge))
	{
		var main_source_nWWtBge = [];
	}
	var main_source = main_source_nWWtBge.some(main_source_nWWtBge_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_nWWtBgefsK_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_nWWtBgefsK_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_nWWtBgefsK_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_nWWtBgefsK_required = true;
		}
	}
}

// the nWWtBge Some function
function main_source_nWWtBge_SomeFunc(main_source_nWWtBge)
{
	// set the function logic
	if (main_source_nWWtBge == 2)
	{
		return true;
	}
	return false;
}

// the SORuSWQ function
function SORuSWQ(addcalculation_SORuSWQ)
{
	// set the function logic
	if (addcalculation_SORuSWQ == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_SORuSWQgcM_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_SORuSWQgcM_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_SORuSWQgcM_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_SORuSWQgcM_required = true;
		}
	}
}

// the AcudNSb function
function AcudNSb(addcalculation_AcudNSb,gettype_AcudNSb)
{
	if (isSet(addcalculation_AcudNSb) && addcalculation_AcudNSb.constructor !== Array)
	{
		var temp_AcudNSb = addcalculation_AcudNSb;
		var addcalculation_AcudNSb = [];
		addcalculation_AcudNSb.push(temp_AcudNSb);
	}
	else if (!isSet(addcalculation_AcudNSb))
	{
		var addcalculation_AcudNSb = [];
	}
	var addcalculation = addcalculation_AcudNSb.some(addcalculation_AcudNSb_SomeFunc);

	if (isSet(gettype_AcudNSb) && gettype_AcudNSb.constructor !== Array)
	{
		var temp_AcudNSb = gettype_AcudNSb;
		var gettype_AcudNSb = [];
		gettype_AcudNSb.push(temp_AcudNSb);
	}
	else if (!isSet(gettype_AcudNSb))
	{
		var gettype_AcudNSb = [];
	}
	var gettype = gettype_AcudNSb.some(gettype_AcudNSb_SomeFunc);


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

// the AcudNSb Some function
function addcalculation_AcudNSb_SomeFunc(addcalculation_AcudNSb)
{
	// set the function logic
	if (addcalculation_AcudNSb == 1)
	{
		return true;
	}
	return false;
}

// the AcudNSb Some function
function gettype_AcudNSb_SomeFunc(gettype_AcudNSb)
{
	// set the function logic
	if (gettype_AcudNSb == 1 || gettype_AcudNSb == 3)
	{
		return true;
	}
	return false;
}

// the uXqArsE function
function uXqArsE(addcalculation_uXqArsE,gettype_uXqArsE)
{
	if (isSet(addcalculation_uXqArsE) && addcalculation_uXqArsE.constructor !== Array)
	{
		var temp_uXqArsE = addcalculation_uXqArsE;
		var addcalculation_uXqArsE = [];
		addcalculation_uXqArsE.push(temp_uXqArsE);
	}
	else if (!isSet(addcalculation_uXqArsE))
	{
		var addcalculation_uXqArsE = [];
	}
	var addcalculation = addcalculation_uXqArsE.some(addcalculation_uXqArsE_SomeFunc);

	if (isSet(gettype_uXqArsE) && gettype_uXqArsE.constructor !== Array)
	{
		var temp_uXqArsE = gettype_uXqArsE;
		var gettype_uXqArsE = [];
		gettype_uXqArsE.push(temp_uXqArsE);
	}
	else if (!isSet(gettype_uXqArsE))
	{
		var gettype_uXqArsE = [];
	}
	var gettype = gettype_uXqArsE.some(gettype_uXqArsE_SomeFunc);


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

// the uXqArsE Some function
function addcalculation_uXqArsE_SomeFunc(addcalculation_uXqArsE)
{
	// set the function logic
	if (addcalculation_uXqArsE == 1)
	{
		return true;
	}
	return false;
}

// the uXqArsE Some function
function gettype_uXqArsE_SomeFunc(gettype_uXqArsE)
{
	// set the function logic
	if (gettype_uXqArsE == 2 || gettype_uXqArsE == 4)
	{
		return true;
	}
	return false;
}

// the QpPysiu function
function QpPysiu(main_source_QpPysiu)
{
	if (isSet(main_source_QpPysiu) && main_source_QpPysiu.constructor !== Array)
	{
		var temp_QpPysiu = main_source_QpPysiu;
		var main_source_QpPysiu = [];
		main_source_QpPysiu.push(temp_QpPysiu);
	}
	else if (!isSet(main_source_QpPysiu))
	{
		var main_source_QpPysiu = [];
	}
	var main_source = main_source_QpPysiu.some(main_source_QpPysiu_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_QpPysiubZD_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_QpPysiubZD_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_QpPysiubZD_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_QpPysiubZD_required = true;
		}
	}
}

// the QpPysiu Some function
function main_source_QpPysiu_SomeFunc(main_source_QpPysiu)
{
	// set the function logic
	if (main_source_QpPysiu == 3)
	{
		return true;
	}
	return false;
}

// the pXRXojv function
function pXRXojv(main_source_pXRXojv)
{
	if (isSet(main_source_pXRXojv) && main_source_pXRXojv.constructor !== Array)
	{
		var temp_pXRXojv = main_source_pXRXojv;
		var main_source_pXRXojv = [];
		main_source_pXRXojv.push(temp_pXRXojv);
	}
	else if (!isSet(main_source_pXRXojv))
	{
		var main_source_pXRXojv = [];
	}
	var main_source = main_source_pXRXojv.some(main_source_pXRXojv_SomeFunc);


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

// the pXRXojv Some function
function main_source_pXRXojv_SomeFunc(main_source_pXRXojv)
{
	// set the function logic
	if (main_source_pXRXojv == 1 || main_source_pXRXojv == 2)
	{
		return true;
	}
	return false;
}

// the QfgugiS function
function QfgugiS(add_php_before_getitem_QfgugiS,gettype_QfgugiS)
{
	if (isSet(add_php_before_getitem_QfgugiS) && add_php_before_getitem_QfgugiS.constructor !== Array)
	{
		var temp_QfgugiS = add_php_before_getitem_QfgugiS;
		var add_php_before_getitem_QfgugiS = [];
		add_php_before_getitem_QfgugiS.push(temp_QfgugiS);
	}
	else if (!isSet(add_php_before_getitem_QfgugiS))
	{
		var add_php_before_getitem_QfgugiS = [];
	}
	var add_php_before_getitem = add_php_before_getitem_QfgugiS.some(add_php_before_getitem_QfgugiS_SomeFunc);

	if (isSet(gettype_QfgugiS) && gettype_QfgugiS.constructor !== Array)
	{
		var temp_QfgugiS = gettype_QfgugiS;
		var gettype_QfgugiS = [];
		gettype_QfgugiS.push(temp_QfgugiS);
	}
	else if (!isSet(gettype_QfgugiS))
	{
		var gettype_QfgugiS = [];
	}
	var gettype = gettype_QfgugiS.some(gettype_QfgugiS_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_QfgugiSXZi_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_QfgugiSXZi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_QfgugiSXZi_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_QfgugiSXZi_required = true;
		}
	}
}

// the QfgugiS Some function
function add_php_before_getitem_QfgugiS_SomeFunc(add_php_before_getitem_QfgugiS)
{
	// set the function logic
	if (add_php_before_getitem_QfgugiS == 1)
	{
		return true;
	}
	return false;
}

// the QfgugiS Some function
function gettype_QfgugiS_SomeFunc(gettype_QfgugiS)
{
	// set the function logic
	if (gettype_QfgugiS == 1 || gettype_QfgugiS == 3)
	{
		return true;
	}
	return false;
}

// the lLptvBi function
function lLptvBi(add_php_after_getitem_lLptvBi,gettype_lLptvBi)
{
	if (isSet(add_php_after_getitem_lLptvBi) && add_php_after_getitem_lLptvBi.constructor !== Array)
	{
		var temp_lLptvBi = add_php_after_getitem_lLptvBi;
		var add_php_after_getitem_lLptvBi = [];
		add_php_after_getitem_lLptvBi.push(temp_lLptvBi);
	}
	else if (!isSet(add_php_after_getitem_lLptvBi))
	{
		var add_php_after_getitem_lLptvBi = [];
	}
	var add_php_after_getitem = add_php_after_getitem_lLptvBi.some(add_php_after_getitem_lLptvBi_SomeFunc);

	if (isSet(gettype_lLptvBi) && gettype_lLptvBi.constructor !== Array)
	{
		var temp_lLptvBi = gettype_lLptvBi;
		var gettype_lLptvBi = [];
		gettype_lLptvBi.push(temp_lLptvBi);
	}
	else if (!isSet(gettype_lLptvBi))
	{
		var gettype_lLptvBi = [];
	}
	var gettype = gettype_lLptvBi.some(gettype_lLptvBi_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_lLptvBiRTr_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_lLptvBiRTr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_lLptvBiRTr_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_lLptvBiRTr_required = true;
		}
	}
}

// the lLptvBi Some function
function add_php_after_getitem_lLptvBi_SomeFunc(add_php_after_getitem_lLptvBi)
{
	// set the function logic
	if (add_php_after_getitem_lLptvBi == 1)
	{
		return true;
	}
	return false;
}

// the lLptvBi Some function
function gettype_lLptvBi_SomeFunc(gettype_lLptvBi)
{
	// set the function logic
	if (gettype_lLptvBi == 1 || gettype_lLptvBi == 3)
	{
		return true;
	}
	return false;
}

// the ltPMoUR function
function ltPMoUR(gettype_ltPMoUR)
{
	if (isSet(gettype_ltPMoUR) && gettype_ltPMoUR.constructor !== Array)
	{
		var temp_ltPMoUR = gettype_ltPMoUR;
		var gettype_ltPMoUR = [];
		gettype_ltPMoUR.push(temp_ltPMoUR);
	}
	else if (!isSet(gettype_ltPMoUR))
	{
		var gettype_ltPMoUR = [];
	}
	var gettype = gettype_ltPMoUR.some(gettype_ltPMoUR_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_ltPMoURGaX_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_ltPMoURGaX_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_ltPMoURzXW_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_ltPMoURzXW_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_ltPMoURGaX_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_ltPMoURGaX_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_ltPMoURzXW_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_ltPMoURzXW_required = true;
		}
	}
}

// the ltPMoUR Some function
function gettype_ltPMoUR_SomeFunc(gettype_ltPMoUR)
{
	// set the function logic
	if (gettype_ltPMoUR == 1 || gettype_ltPMoUR == 3)
	{
		return true;
	}
	return false;
}

// the HnBdEdL function
function HnBdEdL(add_php_getlistquery_HnBdEdL,gettype_HnBdEdL)
{
	if (isSet(add_php_getlistquery_HnBdEdL) && add_php_getlistquery_HnBdEdL.constructor !== Array)
	{
		var temp_HnBdEdL = add_php_getlistquery_HnBdEdL;
		var add_php_getlistquery_HnBdEdL = [];
		add_php_getlistquery_HnBdEdL.push(temp_HnBdEdL);
	}
	else if (!isSet(add_php_getlistquery_HnBdEdL))
	{
		var add_php_getlistquery_HnBdEdL = [];
	}
	var add_php_getlistquery = add_php_getlistquery_HnBdEdL.some(add_php_getlistquery_HnBdEdL_SomeFunc);

	if (isSet(gettype_HnBdEdL) && gettype_HnBdEdL.constructor !== Array)
	{
		var temp_HnBdEdL = gettype_HnBdEdL;
		var gettype_HnBdEdL = [];
		gettype_HnBdEdL.push(temp_HnBdEdL);
	}
	else if (!isSet(gettype_HnBdEdL))
	{
		var gettype_HnBdEdL = [];
	}
	var gettype = gettype_HnBdEdL.some(gettype_HnBdEdL_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_HnBdEdLLWH_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_HnBdEdLLWH_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_HnBdEdLLWH_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_HnBdEdLLWH_required = true;
		}
	}
}

// the HnBdEdL Some function
function add_php_getlistquery_HnBdEdL_SomeFunc(add_php_getlistquery_HnBdEdL)
{
	// set the function logic
	if (add_php_getlistquery_HnBdEdL == 1)
	{
		return true;
	}
	return false;
}

// the HnBdEdL Some function
function gettype_HnBdEdL_SomeFunc(gettype_HnBdEdL)
{
	// set the function logic
	if (gettype_HnBdEdL == 2 || gettype_HnBdEdL == 4)
	{
		return true;
	}
	return false;
}

// the XpwobPt function
function XpwobPt(add_php_before_getitems_XpwobPt,gettype_XpwobPt)
{
	if (isSet(add_php_before_getitems_XpwobPt) && add_php_before_getitems_XpwobPt.constructor !== Array)
	{
		var temp_XpwobPt = add_php_before_getitems_XpwobPt;
		var add_php_before_getitems_XpwobPt = [];
		add_php_before_getitems_XpwobPt.push(temp_XpwobPt);
	}
	else if (!isSet(add_php_before_getitems_XpwobPt))
	{
		var add_php_before_getitems_XpwobPt = [];
	}
	var add_php_before_getitems = add_php_before_getitems_XpwobPt.some(add_php_before_getitems_XpwobPt_SomeFunc);

	if (isSet(gettype_XpwobPt) && gettype_XpwobPt.constructor !== Array)
	{
		var temp_XpwobPt = gettype_XpwobPt;
		var gettype_XpwobPt = [];
		gettype_XpwobPt.push(temp_XpwobPt);
	}
	else if (!isSet(gettype_XpwobPt))
	{
		var gettype_XpwobPt = [];
	}
	var gettype = gettype_XpwobPt.some(gettype_XpwobPt_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_XpwobPtGcU_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_XpwobPtGcU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_XpwobPtGcU_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_XpwobPtGcU_required = true;
		}
	}
}

// the XpwobPt Some function
function add_php_before_getitems_XpwobPt_SomeFunc(add_php_before_getitems_XpwobPt)
{
	// set the function logic
	if (add_php_before_getitems_XpwobPt == 1)
	{
		return true;
	}
	return false;
}

// the XpwobPt Some function
function gettype_XpwobPt_SomeFunc(gettype_XpwobPt)
{
	// set the function logic
	if (gettype_XpwobPt == 2 || gettype_XpwobPt == 4)
	{
		return true;
	}
	return false;
}

// the wKesGPt function
function wKesGPt(add_php_after_getitems_wKesGPt,gettype_wKesGPt)
{
	if (isSet(add_php_after_getitems_wKesGPt) && add_php_after_getitems_wKesGPt.constructor !== Array)
	{
		var temp_wKesGPt = add_php_after_getitems_wKesGPt;
		var add_php_after_getitems_wKesGPt = [];
		add_php_after_getitems_wKesGPt.push(temp_wKesGPt);
	}
	else if (!isSet(add_php_after_getitems_wKesGPt))
	{
		var add_php_after_getitems_wKesGPt = [];
	}
	var add_php_after_getitems = add_php_after_getitems_wKesGPt.some(add_php_after_getitems_wKesGPt_SomeFunc);

	if (isSet(gettype_wKesGPt) && gettype_wKesGPt.constructor !== Array)
	{
		var temp_wKesGPt = gettype_wKesGPt;
		var gettype_wKesGPt = [];
		gettype_wKesGPt.push(temp_wKesGPt);
	}
	else if (!isSet(gettype_wKesGPt))
	{
		var gettype_wKesGPt = [];
	}
	var gettype = gettype_wKesGPt.some(gettype_wKesGPt_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_wKesGPtxuy_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_wKesGPtxuy_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_wKesGPtxuy_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_wKesGPtxuy_required = true;
		}
	}
}

// the wKesGPt Some function
function add_php_after_getitems_wKesGPt_SomeFunc(add_php_after_getitems_wKesGPt)
{
	// set the function logic
	if (add_php_after_getitems_wKesGPt == 1)
	{
		return true;
	}
	return false;
}

// the wKesGPt Some function
function gettype_wKesGPt_SomeFunc(gettype_wKesGPt)
{
	// set the function logic
	if (gettype_wKesGPt == 2 || gettype_wKesGPt == 4)
	{
		return true;
	}
	return false;
}

// the ONeyMtT function
function ONeyMtT(gettype_ONeyMtT)
{
	if (isSet(gettype_ONeyMtT) && gettype_ONeyMtT.constructor !== Array)
	{
		var temp_ONeyMtT = gettype_ONeyMtT;
		var gettype_ONeyMtT = [];
		gettype_ONeyMtT.push(temp_ONeyMtT);
	}
	else if (!isSet(gettype_ONeyMtT))
	{
		var gettype_ONeyMtT = [];
	}
	var gettype = gettype_ONeyMtT.some(gettype_ONeyMtT_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_ONeyMtTXuH_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_ONeyMtTXuH_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_ONeyMtTyaO_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_ONeyMtTyaO_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_ONeyMtTlwD_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_ONeyMtTlwD_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_ONeyMtTXuH_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_ONeyMtTXuH_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_ONeyMtTyaO_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_ONeyMtTyaO_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_ONeyMtTlwD_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_ONeyMtTlwD_required = true;
		}
	}
}

// the ONeyMtT Some function
function gettype_ONeyMtT_SomeFunc(gettype_ONeyMtT)
{
	// set the function logic
	if (gettype_ONeyMtT == 2 || gettype_ONeyMtT == 4)
	{
		return true;
	}
	return false;
}

// the wWdgwIv function
function wWdgwIv(gettype_wWdgwIv)
{
	if (isSet(gettype_wWdgwIv) && gettype_wWdgwIv.constructor !== Array)
	{
		var temp_wWdgwIv = gettype_wWdgwIv;
		var gettype_wWdgwIv = [];
		gettype_wWdgwIv.push(temp_wWdgwIv);
	}
	else if (!isSet(gettype_wWdgwIv))
	{
		var gettype_wWdgwIv = [];
	}
	var gettype = gettype_wWdgwIv.some(gettype_wWdgwIv_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_wWdgwIvNdx_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_wWdgwIvNdx_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_wWdgwIvNdx_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_wWdgwIvNdx_required = true;
		}
	}
}

// the wWdgwIv Some function
function gettype_wWdgwIv_SomeFunc(gettype_wWdgwIv)
{
	// set the function logic
	if (gettype_wWdgwIv == 2)
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
