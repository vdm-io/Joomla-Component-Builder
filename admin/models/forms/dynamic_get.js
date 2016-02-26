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
	@build			26th February, 2016
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
jform_oIkUBwQlSJ_required = false;
jform_tagnhvNXXH_required = false;
jform_KAhRcCCPpP_required = false;
jform_vAxEBgasyS_required = false;
jform_VMTbbbDPZB_required = false;
jform_pCbDvfiYUx_required = false;
jform_SCPJZNXahA_required = false;
jform_nCtpSbYHrI_required = false;
jform_SpukdYZHYN_required = false;
jform_TnpAxMNUyP_required = false;
jform_TnpAxMNRhj_required = false;
jform_CXzQkvOkhI_required = false;
jform_VRMRVLIqyW_required = false;
jform_DYujMuNvkU_required = false;
jform_okMXdwKUyo_required = false;
jform_okMXdwKDLU_required = false;
jform_okMXdwKAgT_required = false;
jform_TwzodczXMd_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_oIkUBwQ = jQuery("#jform_gettype").val();
	oIkUBwQ(gettype_oIkUBwQ);

	var main_source_tagnhvN = jQuery("#jform_main_source").val();
	tagnhvN(main_source_tagnhvN);

	var main_source_KAhRcCC = jQuery("#jform_main_source").val();
	KAhRcCC(main_source_KAhRcCC);

	var main_source_vAxEBga = jQuery("#jform_main_source").val();
	vAxEBga(main_source_vAxEBga);

	var main_source_VMTbbbD = jQuery("#jform_main_source").val();
	VMTbbbD(main_source_VMTbbbD);

	var addcalculation_pCbDvfi = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	pCbDvfi(addcalculation_pCbDvfi);

	var addcalculation_OqYoaAC = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_OqYoaAC = jQuery("#jform_gettype").val();
	OqYoaAC(addcalculation_OqYoaAC,gettype_OqYoaAC);

	var addcalculation_aMTREzM = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_aMTREzM = jQuery("#jform_gettype").val();
	aMTREzM(addcalculation_aMTREzM,gettype_aMTREzM);

	var main_source_SCPJZNX = jQuery("#jform_main_source").val();
	SCPJZNX(main_source_SCPJZNX);

	var main_source_aTmUxUz = jQuery("#jform_main_source").val();
	aTmUxUz(main_source_aTmUxUz);

	var add_php_before_getitem_nCtpSbY = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_nCtpSbY = jQuery("#jform_gettype").val();
	nCtpSbY(add_php_before_getitem_nCtpSbY,gettype_nCtpSbY);

	var add_php_after_getitem_SpukdYZ = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_SpukdYZ = jQuery("#jform_gettype").val();
	SpukdYZ(add_php_after_getitem_SpukdYZ,gettype_SpukdYZ);

	var gettype_TnpAxMN = jQuery("#jform_gettype").val();
	TnpAxMN(gettype_TnpAxMN);

	var add_php_getlistquery_CXzQkvO = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_CXzQkvO = jQuery("#jform_gettype").val();
	CXzQkvO(add_php_getlistquery_CXzQkvO,gettype_CXzQkvO);

	var add_php_before_getitems_VRMRVLI = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_VRMRVLI = jQuery("#jform_gettype").val();
	VRMRVLI(add_php_before_getitems_VRMRVLI,gettype_VRMRVLI);

	var add_php_after_getitems_DYujMuN = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_DYujMuN = jQuery("#jform_gettype").val();
	DYujMuN(add_php_after_getitems_DYujMuN,gettype_DYujMuN);

	var gettype_okMXdwK = jQuery("#jform_gettype").val();
	okMXdwK(gettype_okMXdwK);

	var gettype_Twzodcz = jQuery("#jform_gettype").val();
	Twzodcz(gettype_Twzodcz);
});

// the oIkUBwQ function
function oIkUBwQ(gettype_oIkUBwQ)
{
	if (isSet(gettype_oIkUBwQ) && gettype_oIkUBwQ.constructor !== Array)
	{
		var temp_oIkUBwQ = gettype_oIkUBwQ;
		var gettype_oIkUBwQ = [];
		gettype_oIkUBwQ.push(temp_oIkUBwQ);
	}
	else if (!isSet(gettype_oIkUBwQ))
	{
		var gettype_oIkUBwQ = [];
	}
	var gettype = gettype_oIkUBwQ.some(gettype_oIkUBwQ_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_oIkUBwQlSJ_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_oIkUBwQlSJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_oIkUBwQlSJ_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_oIkUBwQlSJ_required = true;
		}
	}
}

// the oIkUBwQ Some function
function gettype_oIkUBwQ_SomeFunc(gettype_oIkUBwQ)
{
	// set the function logic
	if (gettype_oIkUBwQ == 3 || gettype_oIkUBwQ == 4)
	{
		return true;
	}
	return false;
}

// the tagnhvN function
function tagnhvN(main_source_tagnhvN)
{
	if (isSet(main_source_tagnhvN) && main_source_tagnhvN.constructor !== Array)
	{
		var temp_tagnhvN = main_source_tagnhvN;
		var main_source_tagnhvN = [];
		main_source_tagnhvN.push(temp_tagnhvN);
	}
	else if (!isSet(main_source_tagnhvN))
	{
		var main_source_tagnhvN = [];
	}
	var main_source = main_source_tagnhvN.some(main_source_tagnhvN_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_tagnhvNXXH_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_tagnhvNXXH_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_tagnhvNXXH_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_tagnhvNXXH_required = true;
		}
	}
}

// the tagnhvN Some function
function main_source_tagnhvN_SomeFunc(main_source_tagnhvN)
{
	// set the function logic
	if (main_source_tagnhvN == 1)
	{
		return true;
	}
	return false;
}

// the KAhRcCC function
function KAhRcCC(main_source_KAhRcCC)
{
	if (isSet(main_source_KAhRcCC) && main_source_KAhRcCC.constructor !== Array)
	{
		var temp_KAhRcCC = main_source_KAhRcCC;
		var main_source_KAhRcCC = [];
		main_source_KAhRcCC.push(temp_KAhRcCC);
	}
	else if (!isSet(main_source_KAhRcCC))
	{
		var main_source_KAhRcCC = [];
	}
	var main_source = main_source_KAhRcCC.some(main_source_KAhRcCC_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_KAhRcCCPpP_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_KAhRcCCPpP_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_KAhRcCCPpP_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_KAhRcCCPpP_required = true;
		}
	}
}

// the KAhRcCC Some function
function main_source_KAhRcCC_SomeFunc(main_source_KAhRcCC)
{
	// set the function logic
	if (main_source_KAhRcCC == 1)
	{
		return true;
	}
	return false;
}

// the vAxEBga function
function vAxEBga(main_source_vAxEBga)
{
	if (isSet(main_source_vAxEBga) && main_source_vAxEBga.constructor !== Array)
	{
		var temp_vAxEBga = main_source_vAxEBga;
		var main_source_vAxEBga = [];
		main_source_vAxEBga.push(temp_vAxEBga);
	}
	else if (!isSet(main_source_vAxEBga))
	{
		var main_source_vAxEBga = [];
	}
	var main_source = main_source_vAxEBga.some(main_source_vAxEBga_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_vAxEBgasyS_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_vAxEBgasyS_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_vAxEBgasyS_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_vAxEBgasyS_required = true;
		}
	}
}

// the vAxEBga Some function
function main_source_vAxEBga_SomeFunc(main_source_vAxEBga)
{
	// set the function logic
	if (main_source_vAxEBga == 2)
	{
		return true;
	}
	return false;
}

// the VMTbbbD function
function VMTbbbD(main_source_VMTbbbD)
{
	if (isSet(main_source_VMTbbbD) && main_source_VMTbbbD.constructor !== Array)
	{
		var temp_VMTbbbD = main_source_VMTbbbD;
		var main_source_VMTbbbD = [];
		main_source_VMTbbbD.push(temp_VMTbbbD);
	}
	else if (!isSet(main_source_VMTbbbD))
	{
		var main_source_VMTbbbD = [];
	}
	var main_source = main_source_VMTbbbD.some(main_source_VMTbbbD_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_VMTbbbDPZB_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_VMTbbbDPZB_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_VMTbbbDPZB_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_VMTbbbDPZB_required = true;
		}
	}
}

// the VMTbbbD Some function
function main_source_VMTbbbD_SomeFunc(main_source_VMTbbbD)
{
	// set the function logic
	if (main_source_VMTbbbD == 2)
	{
		return true;
	}
	return false;
}

// the pCbDvfi function
function pCbDvfi(addcalculation_pCbDvfi)
{
	// set the function logic
	if (addcalculation_pCbDvfi == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_pCbDvfiYUx_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_pCbDvfiYUx_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_pCbDvfiYUx_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_pCbDvfiYUx_required = true;
		}
	}
}

// the OqYoaAC function
function OqYoaAC(addcalculation_OqYoaAC,gettype_OqYoaAC)
{
	if (isSet(addcalculation_OqYoaAC) && addcalculation_OqYoaAC.constructor !== Array)
	{
		var temp_OqYoaAC = addcalculation_OqYoaAC;
		var addcalculation_OqYoaAC = [];
		addcalculation_OqYoaAC.push(temp_OqYoaAC);
	}
	else if (!isSet(addcalculation_OqYoaAC))
	{
		var addcalculation_OqYoaAC = [];
	}
	var addcalculation = addcalculation_OqYoaAC.some(addcalculation_OqYoaAC_SomeFunc);

	if (isSet(gettype_OqYoaAC) && gettype_OqYoaAC.constructor !== Array)
	{
		var temp_OqYoaAC = gettype_OqYoaAC;
		var gettype_OqYoaAC = [];
		gettype_OqYoaAC.push(temp_OqYoaAC);
	}
	else if (!isSet(gettype_OqYoaAC))
	{
		var gettype_OqYoaAC = [];
	}
	var gettype = gettype_OqYoaAC.some(gettype_OqYoaAC_SomeFunc);


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

// the OqYoaAC Some function
function addcalculation_OqYoaAC_SomeFunc(addcalculation_OqYoaAC)
{
	// set the function logic
	if (addcalculation_OqYoaAC == 1)
	{
		return true;
	}
	return false;
}

// the OqYoaAC Some function
function gettype_OqYoaAC_SomeFunc(gettype_OqYoaAC)
{
	// set the function logic
	if (gettype_OqYoaAC == 1 || gettype_OqYoaAC == 3)
	{
		return true;
	}
	return false;
}

// the aMTREzM function
function aMTREzM(addcalculation_aMTREzM,gettype_aMTREzM)
{
	if (isSet(addcalculation_aMTREzM) && addcalculation_aMTREzM.constructor !== Array)
	{
		var temp_aMTREzM = addcalculation_aMTREzM;
		var addcalculation_aMTREzM = [];
		addcalculation_aMTREzM.push(temp_aMTREzM);
	}
	else if (!isSet(addcalculation_aMTREzM))
	{
		var addcalculation_aMTREzM = [];
	}
	var addcalculation = addcalculation_aMTREzM.some(addcalculation_aMTREzM_SomeFunc);

	if (isSet(gettype_aMTREzM) && gettype_aMTREzM.constructor !== Array)
	{
		var temp_aMTREzM = gettype_aMTREzM;
		var gettype_aMTREzM = [];
		gettype_aMTREzM.push(temp_aMTREzM);
	}
	else if (!isSet(gettype_aMTREzM))
	{
		var gettype_aMTREzM = [];
	}
	var gettype = gettype_aMTREzM.some(gettype_aMTREzM_SomeFunc);


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

// the aMTREzM Some function
function addcalculation_aMTREzM_SomeFunc(addcalculation_aMTREzM)
{
	// set the function logic
	if (addcalculation_aMTREzM == 1)
	{
		return true;
	}
	return false;
}

// the aMTREzM Some function
function gettype_aMTREzM_SomeFunc(gettype_aMTREzM)
{
	// set the function logic
	if (gettype_aMTREzM == 2 || gettype_aMTREzM == 4)
	{
		return true;
	}
	return false;
}

// the SCPJZNX function
function SCPJZNX(main_source_SCPJZNX)
{
	if (isSet(main_source_SCPJZNX) && main_source_SCPJZNX.constructor !== Array)
	{
		var temp_SCPJZNX = main_source_SCPJZNX;
		var main_source_SCPJZNX = [];
		main_source_SCPJZNX.push(temp_SCPJZNX);
	}
	else if (!isSet(main_source_SCPJZNX))
	{
		var main_source_SCPJZNX = [];
	}
	var main_source = main_source_SCPJZNX.some(main_source_SCPJZNX_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_SCPJZNXahA_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_SCPJZNXahA_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_SCPJZNXahA_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_SCPJZNXahA_required = true;
		}
	}
}

// the SCPJZNX Some function
function main_source_SCPJZNX_SomeFunc(main_source_SCPJZNX)
{
	// set the function logic
	if (main_source_SCPJZNX == 3)
	{
		return true;
	}
	return false;
}

// the aTmUxUz function
function aTmUxUz(main_source_aTmUxUz)
{
	if (isSet(main_source_aTmUxUz) && main_source_aTmUxUz.constructor !== Array)
	{
		var temp_aTmUxUz = main_source_aTmUxUz;
		var main_source_aTmUxUz = [];
		main_source_aTmUxUz.push(temp_aTmUxUz);
	}
	else if (!isSet(main_source_aTmUxUz))
	{
		var main_source_aTmUxUz = [];
	}
	var main_source = main_source_aTmUxUz.some(main_source_aTmUxUz_SomeFunc);


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

// the aTmUxUz Some function
function main_source_aTmUxUz_SomeFunc(main_source_aTmUxUz)
{
	// set the function logic
	if (main_source_aTmUxUz == 1 || main_source_aTmUxUz == 2)
	{
		return true;
	}
	return false;
}

// the nCtpSbY function
function nCtpSbY(add_php_before_getitem_nCtpSbY,gettype_nCtpSbY)
{
	if (isSet(add_php_before_getitem_nCtpSbY) && add_php_before_getitem_nCtpSbY.constructor !== Array)
	{
		var temp_nCtpSbY = add_php_before_getitem_nCtpSbY;
		var add_php_before_getitem_nCtpSbY = [];
		add_php_before_getitem_nCtpSbY.push(temp_nCtpSbY);
	}
	else if (!isSet(add_php_before_getitem_nCtpSbY))
	{
		var add_php_before_getitem_nCtpSbY = [];
	}
	var add_php_before_getitem = add_php_before_getitem_nCtpSbY.some(add_php_before_getitem_nCtpSbY_SomeFunc);

	if (isSet(gettype_nCtpSbY) && gettype_nCtpSbY.constructor !== Array)
	{
		var temp_nCtpSbY = gettype_nCtpSbY;
		var gettype_nCtpSbY = [];
		gettype_nCtpSbY.push(temp_nCtpSbY);
	}
	else if (!isSet(gettype_nCtpSbY))
	{
		var gettype_nCtpSbY = [];
	}
	var gettype = gettype_nCtpSbY.some(gettype_nCtpSbY_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_nCtpSbYHrI_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_nCtpSbYHrI_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_nCtpSbYHrI_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_nCtpSbYHrI_required = true;
		}
	}
}

// the nCtpSbY Some function
function add_php_before_getitem_nCtpSbY_SomeFunc(add_php_before_getitem_nCtpSbY)
{
	// set the function logic
	if (add_php_before_getitem_nCtpSbY == 1)
	{
		return true;
	}
	return false;
}

// the nCtpSbY Some function
function gettype_nCtpSbY_SomeFunc(gettype_nCtpSbY)
{
	// set the function logic
	if (gettype_nCtpSbY == 1 || gettype_nCtpSbY == 3)
	{
		return true;
	}
	return false;
}

// the SpukdYZ function
function SpukdYZ(add_php_after_getitem_SpukdYZ,gettype_SpukdYZ)
{
	if (isSet(add_php_after_getitem_SpukdYZ) && add_php_after_getitem_SpukdYZ.constructor !== Array)
	{
		var temp_SpukdYZ = add_php_after_getitem_SpukdYZ;
		var add_php_after_getitem_SpukdYZ = [];
		add_php_after_getitem_SpukdYZ.push(temp_SpukdYZ);
	}
	else if (!isSet(add_php_after_getitem_SpukdYZ))
	{
		var add_php_after_getitem_SpukdYZ = [];
	}
	var add_php_after_getitem = add_php_after_getitem_SpukdYZ.some(add_php_after_getitem_SpukdYZ_SomeFunc);

	if (isSet(gettype_SpukdYZ) && gettype_SpukdYZ.constructor !== Array)
	{
		var temp_SpukdYZ = gettype_SpukdYZ;
		var gettype_SpukdYZ = [];
		gettype_SpukdYZ.push(temp_SpukdYZ);
	}
	else if (!isSet(gettype_SpukdYZ))
	{
		var gettype_SpukdYZ = [];
	}
	var gettype = gettype_SpukdYZ.some(gettype_SpukdYZ_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_SpukdYZHYN_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_SpukdYZHYN_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_SpukdYZHYN_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_SpukdYZHYN_required = true;
		}
	}
}

// the SpukdYZ Some function
function add_php_after_getitem_SpukdYZ_SomeFunc(add_php_after_getitem_SpukdYZ)
{
	// set the function logic
	if (add_php_after_getitem_SpukdYZ == 1)
	{
		return true;
	}
	return false;
}

// the SpukdYZ Some function
function gettype_SpukdYZ_SomeFunc(gettype_SpukdYZ)
{
	// set the function logic
	if (gettype_SpukdYZ == 1 || gettype_SpukdYZ == 3)
	{
		return true;
	}
	return false;
}

// the TnpAxMN function
function TnpAxMN(gettype_TnpAxMN)
{
	if (isSet(gettype_TnpAxMN) && gettype_TnpAxMN.constructor !== Array)
	{
		var temp_TnpAxMN = gettype_TnpAxMN;
		var gettype_TnpAxMN = [];
		gettype_TnpAxMN.push(temp_TnpAxMN);
	}
	else if (!isSet(gettype_TnpAxMN))
	{
		var gettype_TnpAxMN = [];
	}
	var gettype = gettype_TnpAxMN.some(gettype_TnpAxMN_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_TnpAxMNUyP_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_TnpAxMNUyP_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_TnpAxMNRhj_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_TnpAxMNRhj_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_TnpAxMNUyP_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_TnpAxMNUyP_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_TnpAxMNRhj_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_TnpAxMNRhj_required = true;
		}
	}
}

// the TnpAxMN Some function
function gettype_TnpAxMN_SomeFunc(gettype_TnpAxMN)
{
	// set the function logic
	if (gettype_TnpAxMN == 1 || gettype_TnpAxMN == 3)
	{
		return true;
	}
	return false;
}

// the CXzQkvO function
function CXzQkvO(add_php_getlistquery_CXzQkvO,gettype_CXzQkvO)
{
	if (isSet(add_php_getlistquery_CXzQkvO) && add_php_getlistquery_CXzQkvO.constructor !== Array)
	{
		var temp_CXzQkvO = add_php_getlistquery_CXzQkvO;
		var add_php_getlistquery_CXzQkvO = [];
		add_php_getlistquery_CXzQkvO.push(temp_CXzQkvO);
	}
	else if (!isSet(add_php_getlistquery_CXzQkvO))
	{
		var add_php_getlistquery_CXzQkvO = [];
	}
	var add_php_getlistquery = add_php_getlistquery_CXzQkvO.some(add_php_getlistquery_CXzQkvO_SomeFunc);

	if (isSet(gettype_CXzQkvO) && gettype_CXzQkvO.constructor !== Array)
	{
		var temp_CXzQkvO = gettype_CXzQkvO;
		var gettype_CXzQkvO = [];
		gettype_CXzQkvO.push(temp_CXzQkvO);
	}
	else if (!isSet(gettype_CXzQkvO))
	{
		var gettype_CXzQkvO = [];
	}
	var gettype = gettype_CXzQkvO.some(gettype_CXzQkvO_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_CXzQkvOkhI_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_CXzQkvOkhI_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_CXzQkvOkhI_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_CXzQkvOkhI_required = true;
		}
	}
}

// the CXzQkvO Some function
function add_php_getlistquery_CXzQkvO_SomeFunc(add_php_getlistquery_CXzQkvO)
{
	// set the function logic
	if (add_php_getlistquery_CXzQkvO == 1)
	{
		return true;
	}
	return false;
}

// the CXzQkvO Some function
function gettype_CXzQkvO_SomeFunc(gettype_CXzQkvO)
{
	// set the function logic
	if (gettype_CXzQkvO == 2 || gettype_CXzQkvO == 4)
	{
		return true;
	}
	return false;
}

// the VRMRVLI function
function VRMRVLI(add_php_before_getitems_VRMRVLI,gettype_VRMRVLI)
{
	if (isSet(add_php_before_getitems_VRMRVLI) && add_php_before_getitems_VRMRVLI.constructor !== Array)
	{
		var temp_VRMRVLI = add_php_before_getitems_VRMRVLI;
		var add_php_before_getitems_VRMRVLI = [];
		add_php_before_getitems_VRMRVLI.push(temp_VRMRVLI);
	}
	else if (!isSet(add_php_before_getitems_VRMRVLI))
	{
		var add_php_before_getitems_VRMRVLI = [];
	}
	var add_php_before_getitems = add_php_before_getitems_VRMRVLI.some(add_php_before_getitems_VRMRVLI_SomeFunc);

	if (isSet(gettype_VRMRVLI) && gettype_VRMRVLI.constructor !== Array)
	{
		var temp_VRMRVLI = gettype_VRMRVLI;
		var gettype_VRMRVLI = [];
		gettype_VRMRVLI.push(temp_VRMRVLI);
	}
	else if (!isSet(gettype_VRMRVLI))
	{
		var gettype_VRMRVLI = [];
	}
	var gettype = gettype_VRMRVLI.some(gettype_VRMRVLI_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_VRMRVLIqyW_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_VRMRVLIqyW_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_VRMRVLIqyW_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_VRMRVLIqyW_required = true;
		}
	}
}

// the VRMRVLI Some function
function add_php_before_getitems_VRMRVLI_SomeFunc(add_php_before_getitems_VRMRVLI)
{
	// set the function logic
	if (add_php_before_getitems_VRMRVLI == 1)
	{
		return true;
	}
	return false;
}

// the VRMRVLI Some function
function gettype_VRMRVLI_SomeFunc(gettype_VRMRVLI)
{
	// set the function logic
	if (gettype_VRMRVLI == 2 || gettype_VRMRVLI == 4)
	{
		return true;
	}
	return false;
}

// the DYujMuN function
function DYujMuN(add_php_after_getitems_DYujMuN,gettype_DYujMuN)
{
	if (isSet(add_php_after_getitems_DYujMuN) && add_php_after_getitems_DYujMuN.constructor !== Array)
	{
		var temp_DYujMuN = add_php_after_getitems_DYujMuN;
		var add_php_after_getitems_DYujMuN = [];
		add_php_after_getitems_DYujMuN.push(temp_DYujMuN);
	}
	else if (!isSet(add_php_after_getitems_DYujMuN))
	{
		var add_php_after_getitems_DYujMuN = [];
	}
	var add_php_after_getitems = add_php_after_getitems_DYujMuN.some(add_php_after_getitems_DYujMuN_SomeFunc);

	if (isSet(gettype_DYujMuN) && gettype_DYujMuN.constructor !== Array)
	{
		var temp_DYujMuN = gettype_DYujMuN;
		var gettype_DYujMuN = [];
		gettype_DYujMuN.push(temp_DYujMuN);
	}
	else if (!isSet(gettype_DYujMuN))
	{
		var gettype_DYujMuN = [];
	}
	var gettype = gettype_DYujMuN.some(gettype_DYujMuN_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_DYujMuNvkU_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_DYujMuNvkU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_DYujMuNvkU_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_DYujMuNvkU_required = true;
		}
	}
}

// the DYujMuN Some function
function add_php_after_getitems_DYujMuN_SomeFunc(add_php_after_getitems_DYujMuN)
{
	// set the function logic
	if (add_php_after_getitems_DYujMuN == 1)
	{
		return true;
	}
	return false;
}

// the DYujMuN Some function
function gettype_DYujMuN_SomeFunc(gettype_DYujMuN)
{
	// set the function logic
	if (gettype_DYujMuN == 2 || gettype_DYujMuN == 4)
	{
		return true;
	}
	return false;
}

// the okMXdwK function
function okMXdwK(gettype_okMXdwK)
{
	if (isSet(gettype_okMXdwK) && gettype_okMXdwK.constructor !== Array)
	{
		var temp_okMXdwK = gettype_okMXdwK;
		var gettype_okMXdwK = [];
		gettype_okMXdwK.push(temp_okMXdwK);
	}
	else if (!isSet(gettype_okMXdwK))
	{
		var gettype_okMXdwK = [];
	}
	var gettype = gettype_okMXdwK.some(gettype_okMXdwK_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_okMXdwKUyo_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_okMXdwKUyo_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_okMXdwKDLU_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_okMXdwKDLU_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_okMXdwKAgT_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_okMXdwKAgT_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_okMXdwKUyo_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_okMXdwKUyo_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_okMXdwKDLU_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_okMXdwKDLU_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_okMXdwKAgT_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_okMXdwKAgT_required = true;
		}
	}
}

// the okMXdwK Some function
function gettype_okMXdwK_SomeFunc(gettype_okMXdwK)
{
	// set the function logic
	if (gettype_okMXdwK == 2 || gettype_okMXdwK == 4)
	{
		return true;
	}
	return false;
}

// the Twzodcz function
function Twzodcz(gettype_Twzodcz)
{
	if (isSet(gettype_Twzodcz) && gettype_Twzodcz.constructor !== Array)
	{
		var temp_Twzodcz = gettype_Twzodcz;
		var gettype_Twzodcz = [];
		gettype_Twzodcz.push(temp_Twzodcz);
	}
	else if (!isSet(gettype_Twzodcz))
	{
		var gettype_Twzodcz = [];
	}
	var gettype = gettype_Twzodcz.some(gettype_Twzodcz_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_TwzodczXMd_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_TwzodczXMd_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_TwzodczXMd_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_TwzodczXMd_required = true;
		}
	}
}

// the Twzodcz Some function
function gettype_Twzodcz_SomeFunc(gettype_Twzodcz)
{
	// set the function logic
	if (gettype_Twzodcz == 2)
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
