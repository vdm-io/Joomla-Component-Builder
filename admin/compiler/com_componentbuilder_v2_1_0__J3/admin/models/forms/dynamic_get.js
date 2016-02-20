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
jform_FgGYZgQnXK_required = false;
jform_sfdMRPFhzU_required = false;
jform_CkHaVTIATr_required = false;
jform_ODFnDxCtSs_required = false;
jform_XgvcRpSxvy_required = false;
jform_zeHggvaMdT_required = false;
jform_lwVqorbDin_required = false;
jform_IqvJWRbUla_required = false;
jform_WOCZdYTAnk_required = false;
jform_aelJLJgmyW_required = false;
jform_aelJLJgsAk_required = false;
jform_tpZPucOpve_required = false;
jform_AXROJKrDOu_required = false;
jform_JrgxvrWAGw_required = false;
jform_xrgAMeuuIj_required = false;
jform_xrgAMeuToY_required = false;
jform_xrgAMeusYp_required = false;
jform_yuTNrmvJSv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_FgGYZgQ = jQuery("#jform_gettype").val();
	FgGYZgQ(gettype_FgGYZgQ);

	var main_source_sfdMRPF = jQuery("#jform_main_source").val();
	sfdMRPF(main_source_sfdMRPF);

	var main_source_CkHaVTI = jQuery("#jform_main_source").val();
	CkHaVTI(main_source_CkHaVTI);

	var main_source_ODFnDxC = jQuery("#jform_main_source").val();
	ODFnDxC(main_source_ODFnDxC);

	var main_source_XgvcRpS = jQuery("#jform_main_source").val();
	XgvcRpS(main_source_XgvcRpS);

	var addcalculation_zeHggva = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	zeHggva(addcalculation_zeHggva);

	var addcalculation_gPqKgRk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_gPqKgRk = jQuery("#jform_gettype").val();
	gPqKgRk(addcalculation_gPqKgRk,gettype_gPqKgRk);

	var addcalculation_BjabfiD = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_BjabfiD = jQuery("#jform_gettype").val();
	BjabfiD(addcalculation_BjabfiD,gettype_BjabfiD);

	var main_source_lwVqorb = jQuery("#jform_main_source").val();
	lwVqorb(main_source_lwVqorb);

	var main_source_fsketqC = jQuery("#jform_main_source").val();
	fsketqC(main_source_fsketqC);

	var add_php_before_getitem_IqvJWRb = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_IqvJWRb = jQuery("#jform_gettype").val();
	IqvJWRb(add_php_before_getitem_IqvJWRb,gettype_IqvJWRb);

	var add_php_after_getitem_WOCZdYT = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_WOCZdYT = jQuery("#jform_gettype").val();
	WOCZdYT(add_php_after_getitem_WOCZdYT,gettype_WOCZdYT);

	var gettype_aelJLJg = jQuery("#jform_gettype").val();
	aelJLJg(gettype_aelJLJg);

	var add_php_getlistquery_tpZPucO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_tpZPucO = jQuery("#jform_gettype").val();
	tpZPucO(add_php_getlistquery_tpZPucO,gettype_tpZPucO);

	var add_php_before_getitems_AXROJKr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_AXROJKr = jQuery("#jform_gettype").val();
	AXROJKr(add_php_before_getitems_AXROJKr,gettype_AXROJKr);

	var add_php_after_getitems_JrgxvrW = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_JrgxvrW = jQuery("#jform_gettype").val();
	JrgxvrW(add_php_after_getitems_JrgxvrW,gettype_JrgxvrW);

	var gettype_xrgAMeu = jQuery("#jform_gettype").val();
	xrgAMeu(gettype_xrgAMeu);

	var gettype_yuTNrmv = jQuery("#jform_gettype").val();
	yuTNrmv(gettype_yuTNrmv);
});

// the FgGYZgQ function
function FgGYZgQ(gettype_FgGYZgQ)
{
	if (isSet(gettype_FgGYZgQ) && gettype_FgGYZgQ.constructor !== Array)
	{
		var temp_FgGYZgQ = gettype_FgGYZgQ;
		var gettype_FgGYZgQ = [];
		gettype_FgGYZgQ.push(temp_FgGYZgQ);
	}
	else if (!isSet(gettype_FgGYZgQ))
	{
		var gettype_FgGYZgQ = [];
	}
	var gettype = gettype_FgGYZgQ.some(gettype_FgGYZgQ_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_FgGYZgQnXK_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_FgGYZgQnXK_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_FgGYZgQnXK_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_FgGYZgQnXK_required = true;
		}
	}
}

// the FgGYZgQ Some function
function gettype_FgGYZgQ_SomeFunc(gettype_FgGYZgQ)
{
	// set the function logic
	if (gettype_FgGYZgQ == 3 || gettype_FgGYZgQ == 4)
	{
		return true;
	}
	return false;
}

// the sfdMRPF function
function sfdMRPF(main_source_sfdMRPF)
{
	if (isSet(main_source_sfdMRPF) && main_source_sfdMRPF.constructor !== Array)
	{
		var temp_sfdMRPF = main_source_sfdMRPF;
		var main_source_sfdMRPF = [];
		main_source_sfdMRPF.push(temp_sfdMRPF);
	}
	else if (!isSet(main_source_sfdMRPF))
	{
		var main_source_sfdMRPF = [];
	}
	var main_source = main_source_sfdMRPF.some(main_source_sfdMRPF_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_sfdMRPFhzU_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_sfdMRPFhzU_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_sfdMRPFhzU_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_sfdMRPFhzU_required = true;
		}
	}
}

// the sfdMRPF Some function
function main_source_sfdMRPF_SomeFunc(main_source_sfdMRPF)
{
	// set the function logic
	if (main_source_sfdMRPF == 1)
	{
		return true;
	}
	return false;
}

// the CkHaVTI function
function CkHaVTI(main_source_CkHaVTI)
{
	if (isSet(main_source_CkHaVTI) && main_source_CkHaVTI.constructor !== Array)
	{
		var temp_CkHaVTI = main_source_CkHaVTI;
		var main_source_CkHaVTI = [];
		main_source_CkHaVTI.push(temp_CkHaVTI);
	}
	else if (!isSet(main_source_CkHaVTI))
	{
		var main_source_CkHaVTI = [];
	}
	var main_source = main_source_CkHaVTI.some(main_source_CkHaVTI_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_CkHaVTIATr_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_CkHaVTIATr_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_CkHaVTIATr_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_CkHaVTIATr_required = true;
		}
	}
}

// the CkHaVTI Some function
function main_source_CkHaVTI_SomeFunc(main_source_CkHaVTI)
{
	// set the function logic
	if (main_source_CkHaVTI == 1)
	{
		return true;
	}
	return false;
}

// the ODFnDxC function
function ODFnDxC(main_source_ODFnDxC)
{
	if (isSet(main_source_ODFnDxC) && main_source_ODFnDxC.constructor !== Array)
	{
		var temp_ODFnDxC = main_source_ODFnDxC;
		var main_source_ODFnDxC = [];
		main_source_ODFnDxC.push(temp_ODFnDxC);
	}
	else if (!isSet(main_source_ODFnDxC))
	{
		var main_source_ODFnDxC = [];
	}
	var main_source = main_source_ODFnDxC.some(main_source_ODFnDxC_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_ODFnDxCtSs_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_ODFnDxCtSs_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_ODFnDxCtSs_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_ODFnDxCtSs_required = true;
		}
	}
}

// the ODFnDxC Some function
function main_source_ODFnDxC_SomeFunc(main_source_ODFnDxC)
{
	// set the function logic
	if (main_source_ODFnDxC == 2)
	{
		return true;
	}
	return false;
}

// the XgvcRpS function
function XgvcRpS(main_source_XgvcRpS)
{
	if (isSet(main_source_XgvcRpS) && main_source_XgvcRpS.constructor !== Array)
	{
		var temp_XgvcRpS = main_source_XgvcRpS;
		var main_source_XgvcRpS = [];
		main_source_XgvcRpS.push(temp_XgvcRpS);
	}
	else if (!isSet(main_source_XgvcRpS))
	{
		var main_source_XgvcRpS = [];
	}
	var main_source = main_source_XgvcRpS.some(main_source_XgvcRpS_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_XgvcRpSxvy_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_XgvcRpSxvy_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_XgvcRpSxvy_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_XgvcRpSxvy_required = true;
		}
	}
}

// the XgvcRpS Some function
function main_source_XgvcRpS_SomeFunc(main_source_XgvcRpS)
{
	// set the function logic
	if (main_source_XgvcRpS == 2)
	{
		return true;
	}
	return false;
}

// the zeHggva function
function zeHggva(addcalculation_zeHggva)
{
	// set the function logic
	if (addcalculation_zeHggva == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_zeHggvaMdT_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_zeHggvaMdT_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_zeHggvaMdT_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_zeHggvaMdT_required = true;
		}
	}
}

// the gPqKgRk function
function gPqKgRk(addcalculation_gPqKgRk,gettype_gPqKgRk)
{
	if (isSet(addcalculation_gPqKgRk) && addcalculation_gPqKgRk.constructor !== Array)
	{
		var temp_gPqKgRk = addcalculation_gPqKgRk;
		var addcalculation_gPqKgRk = [];
		addcalculation_gPqKgRk.push(temp_gPqKgRk);
	}
	else if (!isSet(addcalculation_gPqKgRk))
	{
		var addcalculation_gPqKgRk = [];
	}
	var addcalculation = addcalculation_gPqKgRk.some(addcalculation_gPqKgRk_SomeFunc);

	if (isSet(gettype_gPqKgRk) && gettype_gPqKgRk.constructor !== Array)
	{
		var temp_gPqKgRk = gettype_gPqKgRk;
		var gettype_gPqKgRk = [];
		gettype_gPqKgRk.push(temp_gPqKgRk);
	}
	else if (!isSet(gettype_gPqKgRk))
	{
		var gettype_gPqKgRk = [];
	}
	var gettype = gettype_gPqKgRk.some(gettype_gPqKgRk_SomeFunc);


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

// the gPqKgRk Some function
function addcalculation_gPqKgRk_SomeFunc(addcalculation_gPqKgRk)
{
	// set the function logic
	if (addcalculation_gPqKgRk == 1)
	{
		return true;
	}
	return false;
}

// the gPqKgRk Some function
function gettype_gPqKgRk_SomeFunc(gettype_gPqKgRk)
{
	// set the function logic
	if (gettype_gPqKgRk == 1 || gettype_gPqKgRk == 3)
	{
		return true;
	}
	return false;
}

// the BjabfiD function
function BjabfiD(addcalculation_BjabfiD,gettype_BjabfiD)
{
	if (isSet(addcalculation_BjabfiD) && addcalculation_BjabfiD.constructor !== Array)
	{
		var temp_BjabfiD = addcalculation_BjabfiD;
		var addcalculation_BjabfiD = [];
		addcalculation_BjabfiD.push(temp_BjabfiD);
	}
	else if (!isSet(addcalculation_BjabfiD))
	{
		var addcalculation_BjabfiD = [];
	}
	var addcalculation = addcalculation_BjabfiD.some(addcalculation_BjabfiD_SomeFunc);

	if (isSet(gettype_BjabfiD) && gettype_BjabfiD.constructor !== Array)
	{
		var temp_BjabfiD = gettype_BjabfiD;
		var gettype_BjabfiD = [];
		gettype_BjabfiD.push(temp_BjabfiD);
	}
	else if (!isSet(gettype_BjabfiD))
	{
		var gettype_BjabfiD = [];
	}
	var gettype = gettype_BjabfiD.some(gettype_BjabfiD_SomeFunc);


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

// the BjabfiD Some function
function addcalculation_BjabfiD_SomeFunc(addcalculation_BjabfiD)
{
	// set the function logic
	if (addcalculation_BjabfiD == 1)
	{
		return true;
	}
	return false;
}

// the BjabfiD Some function
function gettype_BjabfiD_SomeFunc(gettype_BjabfiD)
{
	// set the function logic
	if (gettype_BjabfiD == 2 || gettype_BjabfiD == 4)
	{
		return true;
	}
	return false;
}

// the lwVqorb function
function lwVqorb(main_source_lwVqorb)
{
	if (isSet(main_source_lwVqorb) && main_source_lwVqorb.constructor !== Array)
	{
		var temp_lwVqorb = main_source_lwVqorb;
		var main_source_lwVqorb = [];
		main_source_lwVqorb.push(temp_lwVqorb);
	}
	else if (!isSet(main_source_lwVqorb))
	{
		var main_source_lwVqorb = [];
	}
	var main_source = main_source_lwVqorb.some(main_source_lwVqorb_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_lwVqorbDin_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_lwVqorbDin_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_lwVqorbDin_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_lwVqorbDin_required = true;
		}
	}
}

// the lwVqorb Some function
function main_source_lwVqorb_SomeFunc(main_source_lwVqorb)
{
	// set the function logic
	if (main_source_lwVqorb == 3)
	{
		return true;
	}
	return false;
}

// the fsketqC function
function fsketqC(main_source_fsketqC)
{
	if (isSet(main_source_fsketqC) && main_source_fsketqC.constructor !== Array)
	{
		var temp_fsketqC = main_source_fsketqC;
		var main_source_fsketqC = [];
		main_source_fsketqC.push(temp_fsketqC);
	}
	else if (!isSet(main_source_fsketqC))
	{
		var main_source_fsketqC = [];
	}
	var main_source = main_source_fsketqC.some(main_source_fsketqC_SomeFunc);


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

// the fsketqC Some function
function main_source_fsketqC_SomeFunc(main_source_fsketqC)
{
	// set the function logic
	if (main_source_fsketqC == 1 || main_source_fsketqC == 2)
	{
		return true;
	}
	return false;
}

// the IqvJWRb function
function IqvJWRb(add_php_before_getitem_IqvJWRb,gettype_IqvJWRb)
{
	if (isSet(add_php_before_getitem_IqvJWRb) && add_php_before_getitem_IqvJWRb.constructor !== Array)
	{
		var temp_IqvJWRb = add_php_before_getitem_IqvJWRb;
		var add_php_before_getitem_IqvJWRb = [];
		add_php_before_getitem_IqvJWRb.push(temp_IqvJWRb);
	}
	else if (!isSet(add_php_before_getitem_IqvJWRb))
	{
		var add_php_before_getitem_IqvJWRb = [];
	}
	var add_php_before_getitem = add_php_before_getitem_IqvJWRb.some(add_php_before_getitem_IqvJWRb_SomeFunc);

	if (isSet(gettype_IqvJWRb) && gettype_IqvJWRb.constructor !== Array)
	{
		var temp_IqvJWRb = gettype_IqvJWRb;
		var gettype_IqvJWRb = [];
		gettype_IqvJWRb.push(temp_IqvJWRb);
	}
	else if (!isSet(gettype_IqvJWRb))
	{
		var gettype_IqvJWRb = [];
	}
	var gettype = gettype_IqvJWRb.some(gettype_IqvJWRb_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_IqvJWRbUla_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_IqvJWRbUla_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_IqvJWRbUla_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_IqvJWRbUla_required = true;
		}
	}
}

// the IqvJWRb Some function
function add_php_before_getitem_IqvJWRb_SomeFunc(add_php_before_getitem_IqvJWRb)
{
	// set the function logic
	if (add_php_before_getitem_IqvJWRb == 1)
	{
		return true;
	}
	return false;
}

// the IqvJWRb Some function
function gettype_IqvJWRb_SomeFunc(gettype_IqvJWRb)
{
	// set the function logic
	if (gettype_IqvJWRb == 1 || gettype_IqvJWRb == 3)
	{
		return true;
	}
	return false;
}

// the WOCZdYT function
function WOCZdYT(add_php_after_getitem_WOCZdYT,gettype_WOCZdYT)
{
	if (isSet(add_php_after_getitem_WOCZdYT) && add_php_after_getitem_WOCZdYT.constructor !== Array)
	{
		var temp_WOCZdYT = add_php_after_getitem_WOCZdYT;
		var add_php_after_getitem_WOCZdYT = [];
		add_php_after_getitem_WOCZdYT.push(temp_WOCZdYT);
	}
	else if (!isSet(add_php_after_getitem_WOCZdYT))
	{
		var add_php_after_getitem_WOCZdYT = [];
	}
	var add_php_after_getitem = add_php_after_getitem_WOCZdYT.some(add_php_after_getitem_WOCZdYT_SomeFunc);

	if (isSet(gettype_WOCZdYT) && gettype_WOCZdYT.constructor !== Array)
	{
		var temp_WOCZdYT = gettype_WOCZdYT;
		var gettype_WOCZdYT = [];
		gettype_WOCZdYT.push(temp_WOCZdYT);
	}
	else if (!isSet(gettype_WOCZdYT))
	{
		var gettype_WOCZdYT = [];
	}
	var gettype = gettype_WOCZdYT.some(gettype_WOCZdYT_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_WOCZdYTAnk_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_WOCZdYTAnk_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_WOCZdYTAnk_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_WOCZdYTAnk_required = true;
		}
	}
}

// the WOCZdYT Some function
function add_php_after_getitem_WOCZdYT_SomeFunc(add_php_after_getitem_WOCZdYT)
{
	// set the function logic
	if (add_php_after_getitem_WOCZdYT == 1)
	{
		return true;
	}
	return false;
}

// the WOCZdYT Some function
function gettype_WOCZdYT_SomeFunc(gettype_WOCZdYT)
{
	// set the function logic
	if (gettype_WOCZdYT == 1 || gettype_WOCZdYT == 3)
	{
		return true;
	}
	return false;
}

// the aelJLJg function
function aelJLJg(gettype_aelJLJg)
{
	if (isSet(gettype_aelJLJg) && gettype_aelJLJg.constructor !== Array)
	{
		var temp_aelJLJg = gettype_aelJLJg;
		var gettype_aelJLJg = [];
		gettype_aelJLJg.push(temp_aelJLJg);
	}
	else if (!isSet(gettype_aelJLJg))
	{
		var gettype_aelJLJg = [];
	}
	var gettype = gettype_aelJLJg.some(gettype_aelJLJg_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_aelJLJgmyW_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_aelJLJgmyW_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_aelJLJgsAk_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_aelJLJgsAk_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_aelJLJgmyW_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_aelJLJgmyW_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_aelJLJgsAk_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_aelJLJgsAk_required = true;
		}
	}
}

// the aelJLJg Some function
function gettype_aelJLJg_SomeFunc(gettype_aelJLJg)
{
	// set the function logic
	if (gettype_aelJLJg == 1 || gettype_aelJLJg == 3)
	{
		return true;
	}
	return false;
}

// the tpZPucO function
function tpZPucO(add_php_getlistquery_tpZPucO,gettype_tpZPucO)
{
	if (isSet(add_php_getlistquery_tpZPucO) && add_php_getlistquery_tpZPucO.constructor !== Array)
	{
		var temp_tpZPucO = add_php_getlistquery_tpZPucO;
		var add_php_getlistquery_tpZPucO = [];
		add_php_getlistquery_tpZPucO.push(temp_tpZPucO);
	}
	else if (!isSet(add_php_getlistquery_tpZPucO))
	{
		var add_php_getlistquery_tpZPucO = [];
	}
	var add_php_getlistquery = add_php_getlistquery_tpZPucO.some(add_php_getlistquery_tpZPucO_SomeFunc);

	if (isSet(gettype_tpZPucO) && gettype_tpZPucO.constructor !== Array)
	{
		var temp_tpZPucO = gettype_tpZPucO;
		var gettype_tpZPucO = [];
		gettype_tpZPucO.push(temp_tpZPucO);
	}
	else if (!isSet(gettype_tpZPucO))
	{
		var gettype_tpZPucO = [];
	}
	var gettype = gettype_tpZPucO.some(gettype_tpZPucO_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_tpZPucOpve_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_tpZPucOpve_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_tpZPucOpve_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_tpZPucOpve_required = true;
		}
	}
}

// the tpZPucO Some function
function add_php_getlistquery_tpZPucO_SomeFunc(add_php_getlistquery_tpZPucO)
{
	// set the function logic
	if (add_php_getlistquery_tpZPucO == 1)
	{
		return true;
	}
	return false;
}

// the tpZPucO Some function
function gettype_tpZPucO_SomeFunc(gettype_tpZPucO)
{
	// set the function logic
	if (gettype_tpZPucO == 2 || gettype_tpZPucO == 4)
	{
		return true;
	}
	return false;
}

// the AXROJKr function
function AXROJKr(add_php_before_getitems_AXROJKr,gettype_AXROJKr)
{
	if (isSet(add_php_before_getitems_AXROJKr) && add_php_before_getitems_AXROJKr.constructor !== Array)
	{
		var temp_AXROJKr = add_php_before_getitems_AXROJKr;
		var add_php_before_getitems_AXROJKr = [];
		add_php_before_getitems_AXROJKr.push(temp_AXROJKr);
	}
	else if (!isSet(add_php_before_getitems_AXROJKr))
	{
		var add_php_before_getitems_AXROJKr = [];
	}
	var add_php_before_getitems = add_php_before_getitems_AXROJKr.some(add_php_before_getitems_AXROJKr_SomeFunc);

	if (isSet(gettype_AXROJKr) && gettype_AXROJKr.constructor !== Array)
	{
		var temp_AXROJKr = gettype_AXROJKr;
		var gettype_AXROJKr = [];
		gettype_AXROJKr.push(temp_AXROJKr);
	}
	else if (!isSet(gettype_AXROJKr))
	{
		var gettype_AXROJKr = [];
	}
	var gettype = gettype_AXROJKr.some(gettype_AXROJKr_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_AXROJKrDOu_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_AXROJKrDOu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_AXROJKrDOu_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_AXROJKrDOu_required = true;
		}
	}
}

// the AXROJKr Some function
function add_php_before_getitems_AXROJKr_SomeFunc(add_php_before_getitems_AXROJKr)
{
	// set the function logic
	if (add_php_before_getitems_AXROJKr == 1)
	{
		return true;
	}
	return false;
}

// the AXROJKr Some function
function gettype_AXROJKr_SomeFunc(gettype_AXROJKr)
{
	// set the function logic
	if (gettype_AXROJKr == 2 || gettype_AXROJKr == 4)
	{
		return true;
	}
	return false;
}

// the JrgxvrW function
function JrgxvrW(add_php_after_getitems_JrgxvrW,gettype_JrgxvrW)
{
	if (isSet(add_php_after_getitems_JrgxvrW) && add_php_after_getitems_JrgxvrW.constructor !== Array)
	{
		var temp_JrgxvrW = add_php_after_getitems_JrgxvrW;
		var add_php_after_getitems_JrgxvrW = [];
		add_php_after_getitems_JrgxvrW.push(temp_JrgxvrW);
	}
	else if (!isSet(add_php_after_getitems_JrgxvrW))
	{
		var add_php_after_getitems_JrgxvrW = [];
	}
	var add_php_after_getitems = add_php_after_getitems_JrgxvrW.some(add_php_after_getitems_JrgxvrW_SomeFunc);

	if (isSet(gettype_JrgxvrW) && gettype_JrgxvrW.constructor !== Array)
	{
		var temp_JrgxvrW = gettype_JrgxvrW;
		var gettype_JrgxvrW = [];
		gettype_JrgxvrW.push(temp_JrgxvrW);
	}
	else if (!isSet(gettype_JrgxvrW))
	{
		var gettype_JrgxvrW = [];
	}
	var gettype = gettype_JrgxvrW.some(gettype_JrgxvrW_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_JrgxvrWAGw_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_JrgxvrWAGw_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_JrgxvrWAGw_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_JrgxvrWAGw_required = true;
		}
	}
}

// the JrgxvrW Some function
function add_php_after_getitems_JrgxvrW_SomeFunc(add_php_after_getitems_JrgxvrW)
{
	// set the function logic
	if (add_php_after_getitems_JrgxvrW == 1)
	{
		return true;
	}
	return false;
}

// the JrgxvrW Some function
function gettype_JrgxvrW_SomeFunc(gettype_JrgxvrW)
{
	// set the function logic
	if (gettype_JrgxvrW == 2 || gettype_JrgxvrW == 4)
	{
		return true;
	}
	return false;
}

// the xrgAMeu function
function xrgAMeu(gettype_xrgAMeu)
{
	if (isSet(gettype_xrgAMeu) && gettype_xrgAMeu.constructor !== Array)
	{
		var temp_xrgAMeu = gettype_xrgAMeu;
		var gettype_xrgAMeu = [];
		gettype_xrgAMeu.push(temp_xrgAMeu);
	}
	else if (!isSet(gettype_xrgAMeu))
	{
		var gettype_xrgAMeu = [];
	}
	var gettype = gettype_xrgAMeu.some(gettype_xrgAMeu_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_xrgAMeuuIj_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_xrgAMeuuIj_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_xrgAMeuToY_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_xrgAMeuToY_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_xrgAMeusYp_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_xrgAMeusYp_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_xrgAMeuuIj_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_xrgAMeuuIj_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_xrgAMeuToY_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_xrgAMeuToY_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_xrgAMeusYp_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_xrgAMeusYp_required = true;
		}
	}
}

// the xrgAMeu Some function
function gettype_xrgAMeu_SomeFunc(gettype_xrgAMeu)
{
	// set the function logic
	if (gettype_xrgAMeu == 2 || gettype_xrgAMeu == 4)
	{
		return true;
	}
	return false;
}

// the yuTNrmv function
function yuTNrmv(gettype_yuTNrmv)
{
	if (isSet(gettype_yuTNrmv) && gettype_yuTNrmv.constructor !== Array)
	{
		var temp_yuTNrmv = gettype_yuTNrmv;
		var gettype_yuTNrmv = [];
		gettype_yuTNrmv.push(temp_yuTNrmv);
	}
	else if (!isSet(gettype_yuTNrmv))
	{
		var gettype_yuTNrmv = [];
	}
	var gettype = gettype_yuTNrmv.some(gettype_yuTNrmv_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_yuTNrmvJSv_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_yuTNrmvJSv_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_yuTNrmvJSv_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_yuTNrmvJSv_required = true;
		}
	}
}

// the yuTNrmv Some function
function gettype_yuTNrmv_SomeFunc(gettype_yuTNrmv)
{
	// set the function logic
	if (gettype_yuTNrmv == 2)
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
