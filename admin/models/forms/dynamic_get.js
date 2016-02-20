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

	@version		2.1.0
	@build			20th February, 2016
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
jform_eXrZeKdLiq_required = false;
jform_quYDAguRpt_required = false;
jform_GrCCmCESeF_required = false;
jform_hiCxhMkprp_required = false;
jform_CFRAjyMDkf_required = false;
jform_WNxzsEbXCg_required = false;
jform_lpwUTLgZje_required = false;
jform_nExSoDCYyK_required = false;
jform_iHxqXNJQJz_required = false;
jform_UJUsWyNOVr_required = false;
jform_UJUsWyNtRL_required = false;
jform_iawMqnCehe_required = false;
jform_xeNggFHIAt_required = false;
jform_DZqePcXcvR_required = false;
jform_QnEXSEGWPo_required = false;
jform_QnEXSEGxqW_required = false;
jform_QnEXSEGQTW_required = false;
jform_fXMiVKBHvq_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_eXrZeKd = jQuery("#jform_gettype").val();
	eXrZeKd(gettype_eXrZeKd);

	var main_source_quYDAgu = jQuery("#jform_main_source").val();
	quYDAgu(main_source_quYDAgu);

	var main_source_GrCCmCE = jQuery("#jform_main_source").val();
	GrCCmCE(main_source_GrCCmCE);

	var main_source_hiCxhMk = jQuery("#jform_main_source").val();
	hiCxhMk(main_source_hiCxhMk);

	var main_source_CFRAjyM = jQuery("#jform_main_source").val();
	CFRAjyM(main_source_CFRAjyM);

	var addcalculation_WNxzsEb = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	WNxzsEb(addcalculation_WNxzsEb);

	var addcalculation_CItlivX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_CItlivX = jQuery("#jform_gettype").val();
	CItlivX(addcalculation_CItlivX,gettype_CItlivX);

	var addcalculation_tJpGpbD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_tJpGpbD = jQuery("#jform_gettype").val();
	tJpGpbD(addcalculation_tJpGpbD,gettype_tJpGpbD);

	var main_source_lpwUTLg = jQuery("#jform_main_source").val();
	lpwUTLg(main_source_lpwUTLg);

	var main_source_nTtZlBv = jQuery("#jform_main_source").val();
	nTtZlBv(main_source_nTtZlBv);

	var add_php_before_getitem_nExSoDC = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nExSoDC = jQuery("#jform_gettype").val();
	nExSoDC(add_php_before_getitem_nExSoDC,gettype_nExSoDC);

	var add_php_after_getitem_iHxqXNJ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_iHxqXNJ = jQuery("#jform_gettype").val();
	iHxqXNJ(add_php_after_getitem_iHxqXNJ,gettype_iHxqXNJ);

	var gettype_UJUsWyN = jQuery("#jform_gettype").val();
	UJUsWyN(gettype_UJUsWyN);

	var add_php_getlistquery_iawMqnC = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_iawMqnC = jQuery("#jform_gettype").val();
	iawMqnC(add_php_getlistquery_iawMqnC,gettype_iawMqnC);

	var add_php_before_getitems_xeNggFH = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_xeNggFH = jQuery("#jform_gettype").val();
	xeNggFH(add_php_before_getitems_xeNggFH,gettype_xeNggFH);

	var add_php_after_getitems_DZqePcX = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DZqePcX = jQuery("#jform_gettype").val();
	DZqePcX(add_php_after_getitems_DZqePcX,gettype_DZqePcX);

	var gettype_QnEXSEG = jQuery("#jform_gettype").val();
	QnEXSEG(gettype_QnEXSEG);

	var gettype_fXMiVKB = jQuery("#jform_gettype").val();
	fXMiVKB(gettype_fXMiVKB);
});

// the eXrZeKd function
function eXrZeKd(gettype_eXrZeKd)
{
	if (isSet(gettype_eXrZeKd) && gettype_eXrZeKd.constructor !== Array)
	{
		var temp_eXrZeKd = gettype_eXrZeKd;
		var gettype_eXrZeKd = [];
		gettype_eXrZeKd.push(temp_eXrZeKd);
	}
	else if (!isSet(gettype_eXrZeKd))
	{
		var gettype_eXrZeKd = [];
	}
	var gettype = gettype_eXrZeKd.some(gettype_eXrZeKd_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_eXrZeKdLiq_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_eXrZeKdLiq_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_eXrZeKdLiq_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_eXrZeKdLiq_required = true;
		}
	}
}

// the eXrZeKd Some function
function gettype_eXrZeKd_SomeFunc(gettype_eXrZeKd)
{
	// set the function logic
	if (gettype_eXrZeKd == 3 || gettype_eXrZeKd == 4)
	{
		return true;
	}
	return false;
}

// the quYDAgu function
function quYDAgu(main_source_quYDAgu)
{
	if (isSet(main_source_quYDAgu) && main_source_quYDAgu.constructor !== Array)
	{
		var temp_quYDAgu = main_source_quYDAgu;
		var main_source_quYDAgu = [];
		main_source_quYDAgu.push(temp_quYDAgu);
	}
	else if (!isSet(main_source_quYDAgu))
	{
		var main_source_quYDAgu = [];
	}
	var main_source = main_source_quYDAgu.some(main_source_quYDAgu_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_quYDAguRpt_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_quYDAguRpt_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_quYDAguRpt_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_quYDAguRpt_required = true;
		}
	}
}

// the quYDAgu Some function
function main_source_quYDAgu_SomeFunc(main_source_quYDAgu)
{
	// set the function logic
	if (main_source_quYDAgu == 1)
	{
		return true;
	}
	return false;
}

// the GrCCmCE function
function GrCCmCE(main_source_GrCCmCE)
{
	if (isSet(main_source_GrCCmCE) && main_source_GrCCmCE.constructor !== Array)
	{
		var temp_GrCCmCE = main_source_GrCCmCE;
		var main_source_GrCCmCE = [];
		main_source_GrCCmCE.push(temp_GrCCmCE);
	}
	else if (!isSet(main_source_GrCCmCE))
	{
		var main_source_GrCCmCE = [];
	}
	var main_source = main_source_GrCCmCE.some(main_source_GrCCmCE_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_GrCCmCESeF_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_GrCCmCESeF_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_GrCCmCESeF_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_GrCCmCESeF_required = true;
		}
	}
}

// the GrCCmCE Some function
function main_source_GrCCmCE_SomeFunc(main_source_GrCCmCE)
{
	// set the function logic
	if (main_source_GrCCmCE == 1)
	{
		return true;
	}
	return false;
}

// the hiCxhMk function
function hiCxhMk(main_source_hiCxhMk)
{
	if (isSet(main_source_hiCxhMk) && main_source_hiCxhMk.constructor !== Array)
	{
		var temp_hiCxhMk = main_source_hiCxhMk;
		var main_source_hiCxhMk = [];
		main_source_hiCxhMk.push(temp_hiCxhMk);
	}
	else if (!isSet(main_source_hiCxhMk))
	{
		var main_source_hiCxhMk = [];
	}
	var main_source = main_source_hiCxhMk.some(main_source_hiCxhMk_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_hiCxhMkprp_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_hiCxhMkprp_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_hiCxhMkprp_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_hiCxhMkprp_required = true;
		}
	}
}

// the hiCxhMk Some function
function main_source_hiCxhMk_SomeFunc(main_source_hiCxhMk)
{
	// set the function logic
	if (main_source_hiCxhMk == 2)
	{
		return true;
	}
	return false;
}

// the CFRAjyM function
function CFRAjyM(main_source_CFRAjyM)
{
	if (isSet(main_source_CFRAjyM) && main_source_CFRAjyM.constructor !== Array)
	{
		var temp_CFRAjyM = main_source_CFRAjyM;
		var main_source_CFRAjyM = [];
		main_source_CFRAjyM.push(temp_CFRAjyM);
	}
	else if (!isSet(main_source_CFRAjyM))
	{
		var main_source_CFRAjyM = [];
	}
	var main_source = main_source_CFRAjyM.some(main_source_CFRAjyM_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_CFRAjyMDkf_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_CFRAjyMDkf_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_CFRAjyMDkf_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_CFRAjyMDkf_required = true;
		}
	}
}

// the CFRAjyM Some function
function main_source_CFRAjyM_SomeFunc(main_source_CFRAjyM)
{
	// set the function logic
	if (main_source_CFRAjyM == 2)
	{
		return true;
	}
	return false;
}

// the WNxzsEb function
function WNxzsEb(addcalculation_WNxzsEb)
{
	// set the function logic
	if (addcalculation_WNxzsEb == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_WNxzsEbXCg_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_WNxzsEbXCg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_WNxzsEbXCg_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_WNxzsEbXCg_required = true;
		}
	}
}

// the CItlivX function
function CItlivX(addcalculation_CItlivX,gettype_CItlivX)
{
	if (isSet(addcalculation_CItlivX) && addcalculation_CItlivX.constructor !== Array)
	{
		var temp_CItlivX = addcalculation_CItlivX;
		var addcalculation_CItlivX = [];
		addcalculation_CItlivX.push(temp_CItlivX);
	}
	else if (!isSet(addcalculation_CItlivX))
	{
		var addcalculation_CItlivX = [];
	}
	var addcalculation = addcalculation_CItlivX.some(addcalculation_CItlivX_SomeFunc);

	if (isSet(gettype_CItlivX) && gettype_CItlivX.constructor !== Array)
	{
		var temp_CItlivX = gettype_CItlivX;
		var gettype_CItlivX = [];
		gettype_CItlivX.push(temp_CItlivX);
	}
	else if (!isSet(gettype_CItlivX))
	{
		var gettype_CItlivX = [];
	}
	var gettype = gettype_CItlivX.some(gettype_CItlivX_SomeFunc);


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

// the CItlivX Some function
function addcalculation_CItlivX_SomeFunc(addcalculation_CItlivX)
{
	// set the function logic
	if (addcalculation_CItlivX == 1)
	{
		return true;
	}
	return false;
}

// the CItlivX Some function
function gettype_CItlivX_SomeFunc(gettype_CItlivX)
{
	// set the function logic
	if (gettype_CItlivX == 1 || gettype_CItlivX == 3)
	{
		return true;
	}
	return false;
}

// the tJpGpbD function
function tJpGpbD(addcalculation_tJpGpbD,gettype_tJpGpbD)
{
	if (isSet(addcalculation_tJpGpbD) && addcalculation_tJpGpbD.constructor !== Array)
	{
		var temp_tJpGpbD = addcalculation_tJpGpbD;
		var addcalculation_tJpGpbD = [];
		addcalculation_tJpGpbD.push(temp_tJpGpbD);
	}
	else if (!isSet(addcalculation_tJpGpbD))
	{
		var addcalculation_tJpGpbD = [];
	}
	var addcalculation = addcalculation_tJpGpbD.some(addcalculation_tJpGpbD_SomeFunc);

	if (isSet(gettype_tJpGpbD) && gettype_tJpGpbD.constructor !== Array)
	{
		var temp_tJpGpbD = gettype_tJpGpbD;
		var gettype_tJpGpbD = [];
		gettype_tJpGpbD.push(temp_tJpGpbD);
	}
	else if (!isSet(gettype_tJpGpbD))
	{
		var gettype_tJpGpbD = [];
	}
	var gettype = gettype_tJpGpbD.some(gettype_tJpGpbD_SomeFunc);


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

// the tJpGpbD Some function
function addcalculation_tJpGpbD_SomeFunc(addcalculation_tJpGpbD)
{
	// set the function logic
	if (addcalculation_tJpGpbD == 1)
	{
		return true;
	}
	return false;
}

// the tJpGpbD Some function
function gettype_tJpGpbD_SomeFunc(gettype_tJpGpbD)
{
	// set the function logic
	if (gettype_tJpGpbD == 2 || gettype_tJpGpbD == 4)
	{
		return true;
	}
	return false;
}

// the lpwUTLg function
function lpwUTLg(main_source_lpwUTLg)
{
	if (isSet(main_source_lpwUTLg) && main_source_lpwUTLg.constructor !== Array)
	{
		var temp_lpwUTLg = main_source_lpwUTLg;
		var main_source_lpwUTLg = [];
		main_source_lpwUTLg.push(temp_lpwUTLg);
	}
	else if (!isSet(main_source_lpwUTLg))
	{
		var main_source_lpwUTLg = [];
	}
	var main_source = main_source_lpwUTLg.some(main_source_lpwUTLg_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_lpwUTLgZje_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_lpwUTLgZje_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_lpwUTLgZje_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_lpwUTLgZje_required = true;
		}
	}
}

// the lpwUTLg Some function
function main_source_lpwUTLg_SomeFunc(main_source_lpwUTLg)
{
	// set the function logic
	if (main_source_lpwUTLg == 3)
	{
		return true;
	}
	return false;
}

// the nTtZlBv function
function nTtZlBv(main_source_nTtZlBv)
{
	if (isSet(main_source_nTtZlBv) && main_source_nTtZlBv.constructor !== Array)
	{
		var temp_nTtZlBv = main_source_nTtZlBv;
		var main_source_nTtZlBv = [];
		main_source_nTtZlBv.push(temp_nTtZlBv);
	}
	else if (!isSet(main_source_nTtZlBv))
	{
		var main_source_nTtZlBv = [];
	}
	var main_source = main_source_nTtZlBv.some(main_source_nTtZlBv_SomeFunc);


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

// the nTtZlBv Some function
function main_source_nTtZlBv_SomeFunc(main_source_nTtZlBv)
{
	// set the function logic
	if (main_source_nTtZlBv == 1 || main_source_nTtZlBv == 2)
	{
		return true;
	}
	return false;
}

// the nExSoDC function
function nExSoDC(add_php_before_getitem_nExSoDC,gettype_nExSoDC)
{
	if (isSet(add_php_before_getitem_nExSoDC) && add_php_before_getitem_nExSoDC.constructor !== Array)
	{
		var temp_nExSoDC = add_php_before_getitem_nExSoDC;
		var add_php_before_getitem_nExSoDC = [];
		add_php_before_getitem_nExSoDC.push(temp_nExSoDC);
	}
	else if (!isSet(add_php_before_getitem_nExSoDC))
	{
		var add_php_before_getitem_nExSoDC = [];
	}
	var add_php_before_getitem = add_php_before_getitem_nExSoDC.some(add_php_before_getitem_nExSoDC_SomeFunc);

	if (isSet(gettype_nExSoDC) && gettype_nExSoDC.constructor !== Array)
	{
		var temp_nExSoDC = gettype_nExSoDC;
		var gettype_nExSoDC = [];
		gettype_nExSoDC.push(temp_nExSoDC);
	}
	else if (!isSet(gettype_nExSoDC))
	{
		var gettype_nExSoDC = [];
	}
	var gettype = gettype_nExSoDC.some(gettype_nExSoDC_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_nExSoDCYyK_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_nExSoDCYyK_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_nExSoDCYyK_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_nExSoDCYyK_required = true;
		}
	}
}

// the nExSoDC Some function
function add_php_before_getitem_nExSoDC_SomeFunc(add_php_before_getitem_nExSoDC)
{
	// set the function logic
	if (add_php_before_getitem_nExSoDC == 1)
	{
		return true;
	}
	return false;
}

// the nExSoDC Some function
function gettype_nExSoDC_SomeFunc(gettype_nExSoDC)
{
	// set the function logic
	if (gettype_nExSoDC == 1 || gettype_nExSoDC == 3)
	{
		return true;
	}
	return false;
}

// the iHxqXNJ function
function iHxqXNJ(add_php_after_getitem_iHxqXNJ,gettype_iHxqXNJ)
{
	if (isSet(add_php_after_getitem_iHxqXNJ) && add_php_after_getitem_iHxqXNJ.constructor !== Array)
	{
		var temp_iHxqXNJ = add_php_after_getitem_iHxqXNJ;
		var add_php_after_getitem_iHxqXNJ = [];
		add_php_after_getitem_iHxqXNJ.push(temp_iHxqXNJ);
	}
	else if (!isSet(add_php_after_getitem_iHxqXNJ))
	{
		var add_php_after_getitem_iHxqXNJ = [];
	}
	var add_php_after_getitem = add_php_after_getitem_iHxqXNJ.some(add_php_after_getitem_iHxqXNJ_SomeFunc);

	if (isSet(gettype_iHxqXNJ) && gettype_iHxqXNJ.constructor !== Array)
	{
		var temp_iHxqXNJ = gettype_iHxqXNJ;
		var gettype_iHxqXNJ = [];
		gettype_iHxqXNJ.push(temp_iHxqXNJ);
	}
	else if (!isSet(gettype_iHxqXNJ))
	{
		var gettype_iHxqXNJ = [];
	}
	var gettype = gettype_iHxqXNJ.some(gettype_iHxqXNJ_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_iHxqXNJQJz_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_iHxqXNJQJz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_iHxqXNJQJz_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_iHxqXNJQJz_required = true;
		}
	}
}

// the iHxqXNJ Some function
function add_php_after_getitem_iHxqXNJ_SomeFunc(add_php_after_getitem_iHxqXNJ)
{
	// set the function logic
	if (add_php_after_getitem_iHxqXNJ == 1)
	{
		return true;
	}
	return false;
}

// the iHxqXNJ Some function
function gettype_iHxqXNJ_SomeFunc(gettype_iHxqXNJ)
{
	// set the function logic
	if (gettype_iHxqXNJ == 1 || gettype_iHxqXNJ == 3)
	{
		return true;
	}
	return false;
}

// the UJUsWyN function
function UJUsWyN(gettype_UJUsWyN)
{
	if (isSet(gettype_UJUsWyN) && gettype_UJUsWyN.constructor !== Array)
	{
		var temp_UJUsWyN = gettype_UJUsWyN;
		var gettype_UJUsWyN = [];
		gettype_UJUsWyN.push(temp_UJUsWyN);
	}
	else if (!isSet(gettype_UJUsWyN))
	{
		var gettype_UJUsWyN = [];
	}
	var gettype = gettype_UJUsWyN.some(gettype_UJUsWyN_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_UJUsWyNOVr_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_UJUsWyNOVr_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_UJUsWyNtRL_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_UJUsWyNtRL_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_UJUsWyNOVr_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_UJUsWyNOVr_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_UJUsWyNtRL_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_UJUsWyNtRL_required = true;
		}
	}
}

// the UJUsWyN Some function
function gettype_UJUsWyN_SomeFunc(gettype_UJUsWyN)
{
	// set the function logic
	if (gettype_UJUsWyN == 1 || gettype_UJUsWyN == 3)
	{
		return true;
	}
	return false;
}

// the iawMqnC function
function iawMqnC(add_php_getlistquery_iawMqnC,gettype_iawMqnC)
{
	if (isSet(add_php_getlistquery_iawMqnC) && add_php_getlistquery_iawMqnC.constructor !== Array)
	{
		var temp_iawMqnC = add_php_getlistquery_iawMqnC;
		var add_php_getlistquery_iawMqnC = [];
		add_php_getlistquery_iawMqnC.push(temp_iawMqnC);
	}
	else if (!isSet(add_php_getlistquery_iawMqnC))
	{
		var add_php_getlistquery_iawMqnC = [];
	}
	var add_php_getlistquery = add_php_getlistquery_iawMqnC.some(add_php_getlistquery_iawMqnC_SomeFunc);

	if (isSet(gettype_iawMqnC) && gettype_iawMqnC.constructor !== Array)
	{
		var temp_iawMqnC = gettype_iawMqnC;
		var gettype_iawMqnC = [];
		gettype_iawMqnC.push(temp_iawMqnC);
	}
	else if (!isSet(gettype_iawMqnC))
	{
		var gettype_iawMqnC = [];
	}
	var gettype = gettype_iawMqnC.some(gettype_iawMqnC_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_iawMqnCehe_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_iawMqnCehe_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_iawMqnCehe_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_iawMqnCehe_required = true;
		}
	}
}

// the iawMqnC Some function
function add_php_getlistquery_iawMqnC_SomeFunc(add_php_getlistquery_iawMqnC)
{
	// set the function logic
	if (add_php_getlistquery_iawMqnC == 1)
	{
		return true;
	}
	return false;
}

// the iawMqnC Some function
function gettype_iawMqnC_SomeFunc(gettype_iawMqnC)
{
	// set the function logic
	if (gettype_iawMqnC == 2 || gettype_iawMqnC == 4)
	{
		return true;
	}
	return false;
}

// the xeNggFH function
function xeNggFH(add_php_before_getitems_xeNggFH,gettype_xeNggFH)
{
	if (isSet(add_php_before_getitems_xeNggFH) && add_php_before_getitems_xeNggFH.constructor !== Array)
	{
		var temp_xeNggFH = add_php_before_getitems_xeNggFH;
		var add_php_before_getitems_xeNggFH = [];
		add_php_before_getitems_xeNggFH.push(temp_xeNggFH);
	}
	else if (!isSet(add_php_before_getitems_xeNggFH))
	{
		var add_php_before_getitems_xeNggFH = [];
	}
	var add_php_before_getitems = add_php_before_getitems_xeNggFH.some(add_php_before_getitems_xeNggFH_SomeFunc);

	if (isSet(gettype_xeNggFH) && gettype_xeNggFH.constructor !== Array)
	{
		var temp_xeNggFH = gettype_xeNggFH;
		var gettype_xeNggFH = [];
		gettype_xeNggFH.push(temp_xeNggFH);
	}
	else if (!isSet(gettype_xeNggFH))
	{
		var gettype_xeNggFH = [];
	}
	var gettype = gettype_xeNggFH.some(gettype_xeNggFH_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_xeNggFHIAt_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_xeNggFHIAt_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_xeNggFHIAt_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_xeNggFHIAt_required = true;
		}
	}
}

// the xeNggFH Some function
function add_php_before_getitems_xeNggFH_SomeFunc(add_php_before_getitems_xeNggFH)
{
	// set the function logic
	if (add_php_before_getitems_xeNggFH == 1)
	{
		return true;
	}
	return false;
}

// the xeNggFH Some function
function gettype_xeNggFH_SomeFunc(gettype_xeNggFH)
{
	// set the function logic
	if (gettype_xeNggFH == 2 || gettype_xeNggFH == 4)
	{
		return true;
	}
	return false;
}

// the DZqePcX function
function DZqePcX(add_php_after_getitems_DZqePcX,gettype_DZqePcX)
{
	if (isSet(add_php_after_getitems_DZqePcX) && add_php_after_getitems_DZqePcX.constructor !== Array)
	{
		var temp_DZqePcX = add_php_after_getitems_DZqePcX;
		var add_php_after_getitems_DZqePcX = [];
		add_php_after_getitems_DZqePcX.push(temp_DZqePcX);
	}
	else if (!isSet(add_php_after_getitems_DZqePcX))
	{
		var add_php_after_getitems_DZqePcX = [];
	}
	var add_php_after_getitems = add_php_after_getitems_DZqePcX.some(add_php_after_getitems_DZqePcX_SomeFunc);

	if (isSet(gettype_DZqePcX) && gettype_DZqePcX.constructor !== Array)
	{
		var temp_DZqePcX = gettype_DZqePcX;
		var gettype_DZqePcX = [];
		gettype_DZqePcX.push(temp_DZqePcX);
	}
	else if (!isSet(gettype_DZqePcX))
	{
		var gettype_DZqePcX = [];
	}
	var gettype = gettype_DZqePcX.some(gettype_DZqePcX_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_DZqePcXcvR_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_DZqePcXcvR_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_DZqePcXcvR_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_DZqePcXcvR_required = true;
		}
	}
}

// the DZqePcX Some function
function add_php_after_getitems_DZqePcX_SomeFunc(add_php_after_getitems_DZqePcX)
{
	// set the function logic
	if (add_php_after_getitems_DZqePcX == 1)
	{
		return true;
	}
	return false;
}

// the DZqePcX Some function
function gettype_DZqePcX_SomeFunc(gettype_DZqePcX)
{
	// set the function logic
	if (gettype_DZqePcX == 2 || gettype_DZqePcX == 4)
	{
		return true;
	}
	return false;
}

// the QnEXSEG function
function QnEXSEG(gettype_QnEXSEG)
{
	if (isSet(gettype_QnEXSEG) && gettype_QnEXSEG.constructor !== Array)
	{
		var temp_QnEXSEG = gettype_QnEXSEG;
		var gettype_QnEXSEG = [];
		gettype_QnEXSEG.push(temp_QnEXSEG);
	}
	else if (!isSet(gettype_QnEXSEG))
	{
		var gettype_QnEXSEG = [];
	}
	var gettype = gettype_QnEXSEG.some(gettype_QnEXSEG_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_QnEXSEGWPo_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_QnEXSEGWPo_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_QnEXSEGxqW_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_QnEXSEGxqW_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_QnEXSEGQTW_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_QnEXSEGQTW_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_QnEXSEGWPo_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_QnEXSEGWPo_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_QnEXSEGxqW_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_QnEXSEGxqW_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_QnEXSEGQTW_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_QnEXSEGQTW_required = true;
		}
	}
}

// the QnEXSEG Some function
function gettype_QnEXSEG_SomeFunc(gettype_QnEXSEG)
{
	// set the function logic
	if (gettype_QnEXSEG == 2 || gettype_QnEXSEG == 4)
	{
		return true;
	}
	return false;
}

// the fXMiVKB function
function fXMiVKB(gettype_fXMiVKB)
{
	if (isSet(gettype_fXMiVKB) && gettype_fXMiVKB.constructor !== Array)
	{
		var temp_fXMiVKB = gettype_fXMiVKB;
		var gettype_fXMiVKB = [];
		gettype_fXMiVKB.push(temp_fXMiVKB);
	}
	else if (!isSet(gettype_fXMiVKB))
	{
		var gettype_fXMiVKB = [];
	}
	var gettype = gettype_fXMiVKB.some(gettype_fXMiVKB_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_fXMiVKBHvq_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_fXMiVKBHvq_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_fXMiVKBHvq_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_fXMiVKBHvq_required = true;
		}
	}
}

// the fXMiVKB Some function
function gettype_fXMiVKB_SomeFunc(gettype_fXMiVKB)
{
	// set the function logic
	if (gettype_fXMiVKB == 2)
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
