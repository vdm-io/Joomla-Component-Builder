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
jform_kIxqawNjBO_required = false;
jform_KOzpbDURdq_required = false;
jform_XHdfPdMheZ_required = false;
jform_CqBhCBwxNY_required = false;
jform_gxMyNJbKBf_required = false;
jform_aFHdKxkqMp_required = false;
jform_AtRXJnWgtw_required = false;
jform_RxeeGhAZHE_required = false;
jform_rUiYvBPudf_required = false;
jform_tdubUQfYwl_required = false;
jform_tdubUQfzDX_required = false;
jform_WUTdSwwLPI_required = false;
jform_OjNsfeNPyU_required = false;
jform_mzPeyNJQgg_required = false;
jform_LAQluZcJef_required = false;
jform_LAQluZczSw_required = false;
jform_LAQluZcmgU_required = false;
jform_eqvQVqXbbb_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_kIxqawN = jQuery("#jform_gettype").val();
	kIxqawN(gettype_kIxqawN);

	var main_source_KOzpbDU = jQuery("#jform_main_source").val();
	KOzpbDU(main_source_KOzpbDU);

	var main_source_XHdfPdM = jQuery("#jform_main_source").val();
	XHdfPdM(main_source_XHdfPdM);

	var main_source_CqBhCBw = jQuery("#jform_main_source").val();
	CqBhCBw(main_source_CqBhCBw);

	var main_source_gxMyNJb = jQuery("#jform_main_source").val();
	gxMyNJb(main_source_gxMyNJb);

	var addcalculation_aFHdKxk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	aFHdKxk(addcalculation_aFHdKxk);

	var addcalculation_xtDYvhA = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_xtDYvhA = jQuery("#jform_gettype").val();
	xtDYvhA(addcalculation_xtDYvhA,gettype_xtDYvhA);

	var addcalculation_ZDpXEUF = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_ZDpXEUF = jQuery("#jform_gettype").val();
	ZDpXEUF(addcalculation_ZDpXEUF,gettype_ZDpXEUF);

	var main_source_AtRXJnW = jQuery("#jform_main_source").val();
	AtRXJnW(main_source_AtRXJnW);

	var main_source_dXTbBIH = jQuery("#jform_main_source").val();
	dXTbBIH(main_source_dXTbBIH);

	var add_php_before_getitem_RxeeGhA = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_RxeeGhA = jQuery("#jform_gettype").val();
	RxeeGhA(add_php_before_getitem_RxeeGhA,gettype_RxeeGhA);

	var add_php_after_getitem_rUiYvBP = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_rUiYvBP = jQuery("#jform_gettype").val();
	rUiYvBP(add_php_after_getitem_rUiYvBP,gettype_rUiYvBP);

	var gettype_tdubUQf = jQuery("#jform_gettype").val();
	tdubUQf(gettype_tdubUQf);

	var add_php_getlistquery_WUTdSww = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_WUTdSww = jQuery("#jform_gettype").val();
	WUTdSww(add_php_getlistquery_WUTdSww,gettype_WUTdSww);

	var add_php_before_getitems_OjNsfeN = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_OjNsfeN = jQuery("#jform_gettype").val();
	OjNsfeN(add_php_before_getitems_OjNsfeN,gettype_OjNsfeN);

	var add_php_after_getitems_mzPeyNJ = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_mzPeyNJ = jQuery("#jform_gettype").val();
	mzPeyNJ(add_php_after_getitems_mzPeyNJ,gettype_mzPeyNJ);

	var gettype_LAQluZc = jQuery("#jform_gettype").val();
	LAQluZc(gettype_LAQluZc);

	var gettype_eqvQVqX = jQuery("#jform_gettype").val();
	eqvQVqX(gettype_eqvQVqX);
});

// the kIxqawN function
function kIxqawN(gettype_kIxqawN)
{
	if (isSet(gettype_kIxqawN) && gettype_kIxqawN.constructor !== Array)
	{
		var temp_kIxqawN = gettype_kIxqawN;
		var gettype_kIxqawN = [];
		gettype_kIxqawN.push(temp_kIxqawN);
	}
	else if (!isSet(gettype_kIxqawN))
	{
		var gettype_kIxqawN = [];
	}
	var gettype = gettype_kIxqawN.some(gettype_kIxqawN_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_kIxqawNjBO_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_kIxqawNjBO_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_kIxqawNjBO_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_kIxqawNjBO_required = true;
		}
	}
}

// the kIxqawN Some function
function gettype_kIxqawN_SomeFunc(gettype_kIxqawN)
{
	// set the function logic
	if (gettype_kIxqawN == 3 || gettype_kIxqawN == 4)
	{
		return true;
	}
	return false;
}

// the KOzpbDU function
function KOzpbDU(main_source_KOzpbDU)
{
	if (isSet(main_source_KOzpbDU) && main_source_KOzpbDU.constructor !== Array)
	{
		var temp_KOzpbDU = main_source_KOzpbDU;
		var main_source_KOzpbDU = [];
		main_source_KOzpbDU.push(temp_KOzpbDU);
	}
	else if (!isSet(main_source_KOzpbDU))
	{
		var main_source_KOzpbDU = [];
	}
	var main_source = main_source_KOzpbDU.some(main_source_KOzpbDU_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_KOzpbDURdq_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_KOzpbDURdq_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_KOzpbDURdq_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_KOzpbDURdq_required = true;
		}
	}
}

// the KOzpbDU Some function
function main_source_KOzpbDU_SomeFunc(main_source_KOzpbDU)
{
	// set the function logic
	if (main_source_KOzpbDU == 1)
	{
		return true;
	}
	return false;
}

// the XHdfPdM function
function XHdfPdM(main_source_XHdfPdM)
{
	if (isSet(main_source_XHdfPdM) && main_source_XHdfPdM.constructor !== Array)
	{
		var temp_XHdfPdM = main_source_XHdfPdM;
		var main_source_XHdfPdM = [];
		main_source_XHdfPdM.push(temp_XHdfPdM);
	}
	else if (!isSet(main_source_XHdfPdM))
	{
		var main_source_XHdfPdM = [];
	}
	var main_source = main_source_XHdfPdM.some(main_source_XHdfPdM_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_XHdfPdMheZ_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_XHdfPdMheZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_XHdfPdMheZ_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_XHdfPdMheZ_required = true;
		}
	}
}

// the XHdfPdM Some function
function main_source_XHdfPdM_SomeFunc(main_source_XHdfPdM)
{
	// set the function logic
	if (main_source_XHdfPdM == 1)
	{
		return true;
	}
	return false;
}

// the CqBhCBw function
function CqBhCBw(main_source_CqBhCBw)
{
	if (isSet(main_source_CqBhCBw) && main_source_CqBhCBw.constructor !== Array)
	{
		var temp_CqBhCBw = main_source_CqBhCBw;
		var main_source_CqBhCBw = [];
		main_source_CqBhCBw.push(temp_CqBhCBw);
	}
	else if (!isSet(main_source_CqBhCBw))
	{
		var main_source_CqBhCBw = [];
	}
	var main_source = main_source_CqBhCBw.some(main_source_CqBhCBw_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_CqBhCBwxNY_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_CqBhCBwxNY_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_CqBhCBwxNY_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_CqBhCBwxNY_required = true;
		}
	}
}

// the CqBhCBw Some function
function main_source_CqBhCBw_SomeFunc(main_source_CqBhCBw)
{
	// set the function logic
	if (main_source_CqBhCBw == 2)
	{
		return true;
	}
	return false;
}

// the gxMyNJb function
function gxMyNJb(main_source_gxMyNJb)
{
	if (isSet(main_source_gxMyNJb) && main_source_gxMyNJb.constructor !== Array)
	{
		var temp_gxMyNJb = main_source_gxMyNJb;
		var main_source_gxMyNJb = [];
		main_source_gxMyNJb.push(temp_gxMyNJb);
	}
	else if (!isSet(main_source_gxMyNJb))
	{
		var main_source_gxMyNJb = [];
	}
	var main_source = main_source_gxMyNJb.some(main_source_gxMyNJb_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_gxMyNJbKBf_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_gxMyNJbKBf_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_gxMyNJbKBf_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_gxMyNJbKBf_required = true;
		}
	}
}

// the gxMyNJb Some function
function main_source_gxMyNJb_SomeFunc(main_source_gxMyNJb)
{
	// set the function logic
	if (main_source_gxMyNJb == 2)
	{
		return true;
	}
	return false;
}

// the aFHdKxk function
function aFHdKxk(addcalculation_aFHdKxk)
{
	// set the function logic
	if (addcalculation_aFHdKxk == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_aFHdKxkqMp_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_aFHdKxkqMp_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_aFHdKxkqMp_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_aFHdKxkqMp_required = true;
		}
	}
}

// the xtDYvhA function
function xtDYvhA(addcalculation_xtDYvhA,gettype_xtDYvhA)
{
	if (isSet(addcalculation_xtDYvhA) && addcalculation_xtDYvhA.constructor !== Array)
	{
		var temp_xtDYvhA = addcalculation_xtDYvhA;
		var addcalculation_xtDYvhA = [];
		addcalculation_xtDYvhA.push(temp_xtDYvhA);
	}
	else if (!isSet(addcalculation_xtDYvhA))
	{
		var addcalculation_xtDYvhA = [];
	}
	var addcalculation = addcalculation_xtDYvhA.some(addcalculation_xtDYvhA_SomeFunc);

	if (isSet(gettype_xtDYvhA) && gettype_xtDYvhA.constructor !== Array)
	{
		var temp_xtDYvhA = gettype_xtDYvhA;
		var gettype_xtDYvhA = [];
		gettype_xtDYvhA.push(temp_xtDYvhA);
	}
	else if (!isSet(gettype_xtDYvhA))
	{
		var gettype_xtDYvhA = [];
	}
	var gettype = gettype_xtDYvhA.some(gettype_xtDYvhA_SomeFunc);


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

// the xtDYvhA Some function
function addcalculation_xtDYvhA_SomeFunc(addcalculation_xtDYvhA)
{
	// set the function logic
	if (addcalculation_xtDYvhA == 1)
	{
		return true;
	}
	return false;
}

// the xtDYvhA Some function
function gettype_xtDYvhA_SomeFunc(gettype_xtDYvhA)
{
	// set the function logic
	if (gettype_xtDYvhA == 1 || gettype_xtDYvhA == 3)
	{
		return true;
	}
	return false;
}

// the ZDpXEUF function
function ZDpXEUF(addcalculation_ZDpXEUF,gettype_ZDpXEUF)
{
	if (isSet(addcalculation_ZDpXEUF) && addcalculation_ZDpXEUF.constructor !== Array)
	{
		var temp_ZDpXEUF = addcalculation_ZDpXEUF;
		var addcalculation_ZDpXEUF = [];
		addcalculation_ZDpXEUF.push(temp_ZDpXEUF);
	}
	else if (!isSet(addcalculation_ZDpXEUF))
	{
		var addcalculation_ZDpXEUF = [];
	}
	var addcalculation = addcalculation_ZDpXEUF.some(addcalculation_ZDpXEUF_SomeFunc);

	if (isSet(gettype_ZDpXEUF) && gettype_ZDpXEUF.constructor !== Array)
	{
		var temp_ZDpXEUF = gettype_ZDpXEUF;
		var gettype_ZDpXEUF = [];
		gettype_ZDpXEUF.push(temp_ZDpXEUF);
	}
	else if (!isSet(gettype_ZDpXEUF))
	{
		var gettype_ZDpXEUF = [];
	}
	var gettype = gettype_ZDpXEUF.some(gettype_ZDpXEUF_SomeFunc);


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

// the ZDpXEUF Some function
function addcalculation_ZDpXEUF_SomeFunc(addcalculation_ZDpXEUF)
{
	// set the function logic
	if (addcalculation_ZDpXEUF == 1)
	{
		return true;
	}
	return false;
}

// the ZDpXEUF Some function
function gettype_ZDpXEUF_SomeFunc(gettype_ZDpXEUF)
{
	// set the function logic
	if (gettype_ZDpXEUF == 2 || gettype_ZDpXEUF == 4)
	{
		return true;
	}
	return false;
}

// the AtRXJnW function
function AtRXJnW(main_source_AtRXJnW)
{
	if (isSet(main_source_AtRXJnW) && main_source_AtRXJnW.constructor !== Array)
	{
		var temp_AtRXJnW = main_source_AtRXJnW;
		var main_source_AtRXJnW = [];
		main_source_AtRXJnW.push(temp_AtRXJnW);
	}
	else if (!isSet(main_source_AtRXJnW))
	{
		var main_source_AtRXJnW = [];
	}
	var main_source = main_source_AtRXJnW.some(main_source_AtRXJnW_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_AtRXJnWgtw_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_AtRXJnWgtw_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_AtRXJnWgtw_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_AtRXJnWgtw_required = true;
		}
	}
}

// the AtRXJnW Some function
function main_source_AtRXJnW_SomeFunc(main_source_AtRXJnW)
{
	// set the function logic
	if (main_source_AtRXJnW == 3)
	{
		return true;
	}
	return false;
}

// the dXTbBIH function
function dXTbBIH(main_source_dXTbBIH)
{
	if (isSet(main_source_dXTbBIH) && main_source_dXTbBIH.constructor !== Array)
	{
		var temp_dXTbBIH = main_source_dXTbBIH;
		var main_source_dXTbBIH = [];
		main_source_dXTbBIH.push(temp_dXTbBIH);
	}
	else if (!isSet(main_source_dXTbBIH))
	{
		var main_source_dXTbBIH = [];
	}
	var main_source = main_source_dXTbBIH.some(main_source_dXTbBIH_SomeFunc);


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

// the dXTbBIH Some function
function main_source_dXTbBIH_SomeFunc(main_source_dXTbBIH)
{
	// set the function logic
	if (main_source_dXTbBIH == 1 || main_source_dXTbBIH == 2)
	{
		return true;
	}
	return false;
}

// the RxeeGhA function
function RxeeGhA(add_php_before_getitem_RxeeGhA,gettype_RxeeGhA)
{
	if (isSet(add_php_before_getitem_RxeeGhA) && add_php_before_getitem_RxeeGhA.constructor !== Array)
	{
		var temp_RxeeGhA = add_php_before_getitem_RxeeGhA;
		var add_php_before_getitem_RxeeGhA = [];
		add_php_before_getitem_RxeeGhA.push(temp_RxeeGhA);
	}
	else if (!isSet(add_php_before_getitem_RxeeGhA))
	{
		var add_php_before_getitem_RxeeGhA = [];
	}
	var add_php_before_getitem = add_php_before_getitem_RxeeGhA.some(add_php_before_getitem_RxeeGhA_SomeFunc);

	if (isSet(gettype_RxeeGhA) && gettype_RxeeGhA.constructor !== Array)
	{
		var temp_RxeeGhA = gettype_RxeeGhA;
		var gettype_RxeeGhA = [];
		gettype_RxeeGhA.push(temp_RxeeGhA);
	}
	else if (!isSet(gettype_RxeeGhA))
	{
		var gettype_RxeeGhA = [];
	}
	var gettype = gettype_RxeeGhA.some(gettype_RxeeGhA_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_RxeeGhAZHE_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_RxeeGhAZHE_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_RxeeGhAZHE_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_RxeeGhAZHE_required = true;
		}
	}
}

// the RxeeGhA Some function
function add_php_before_getitem_RxeeGhA_SomeFunc(add_php_before_getitem_RxeeGhA)
{
	// set the function logic
	if (add_php_before_getitem_RxeeGhA == 1)
	{
		return true;
	}
	return false;
}

// the RxeeGhA Some function
function gettype_RxeeGhA_SomeFunc(gettype_RxeeGhA)
{
	// set the function logic
	if (gettype_RxeeGhA == 1 || gettype_RxeeGhA == 3)
	{
		return true;
	}
	return false;
}

// the rUiYvBP function
function rUiYvBP(add_php_after_getitem_rUiYvBP,gettype_rUiYvBP)
{
	if (isSet(add_php_after_getitem_rUiYvBP) && add_php_after_getitem_rUiYvBP.constructor !== Array)
	{
		var temp_rUiYvBP = add_php_after_getitem_rUiYvBP;
		var add_php_after_getitem_rUiYvBP = [];
		add_php_after_getitem_rUiYvBP.push(temp_rUiYvBP);
	}
	else if (!isSet(add_php_after_getitem_rUiYvBP))
	{
		var add_php_after_getitem_rUiYvBP = [];
	}
	var add_php_after_getitem = add_php_after_getitem_rUiYvBP.some(add_php_after_getitem_rUiYvBP_SomeFunc);

	if (isSet(gettype_rUiYvBP) && gettype_rUiYvBP.constructor !== Array)
	{
		var temp_rUiYvBP = gettype_rUiYvBP;
		var gettype_rUiYvBP = [];
		gettype_rUiYvBP.push(temp_rUiYvBP);
	}
	else if (!isSet(gettype_rUiYvBP))
	{
		var gettype_rUiYvBP = [];
	}
	var gettype = gettype_rUiYvBP.some(gettype_rUiYvBP_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_rUiYvBPudf_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_rUiYvBPudf_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_rUiYvBPudf_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_rUiYvBPudf_required = true;
		}
	}
}

// the rUiYvBP Some function
function add_php_after_getitem_rUiYvBP_SomeFunc(add_php_after_getitem_rUiYvBP)
{
	// set the function logic
	if (add_php_after_getitem_rUiYvBP == 1)
	{
		return true;
	}
	return false;
}

// the rUiYvBP Some function
function gettype_rUiYvBP_SomeFunc(gettype_rUiYvBP)
{
	// set the function logic
	if (gettype_rUiYvBP == 1 || gettype_rUiYvBP == 3)
	{
		return true;
	}
	return false;
}

// the tdubUQf function
function tdubUQf(gettype_tdubUQf)
{
	if (isSet(gettype_tdubUQf) && gettype_tdubUQf.constructor !== Array)
	{
		var temp_tdubUQf = gettype_tdubUQf;
		var gettype_tdubUQf = [];
		gettype_tdubUQf.push(temp_tdubUQf);
	}
	else if (!isSet(gettype_tdubUQf))
	{
		var gettype_tdubUQf = [];
	}
	var gettype = gettype_tdubUQf.some(gettype_tdubUQf_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_tdubUQfYwl_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_tdubUQfYwl_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_tdubUQfzDX_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_tdubUQfzDX_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_tdubUQfYwl_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_tdubUQfYwl_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_tdubUQfzDX_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_tdubUQfzDX_required = true;
		}
	}
}

// the tdubUQf Some function
function gettype_tdubUQf_SomeFunc(gettype_tdubUQf)
{
	// set the function logic
	if (gettype_tdubUQf == 1 || gettype_tdubUQf == 3)
	{
		return true;
	}
	return false;
}

// the WUTdSww function
function WUTdSww(add_php_getlistquery_WUTdSww,gettype_WUTdSww)
{
	if (isSet(add_php_getlistquery_WUTdSww) && add_php_getlistquery_WUTdSww.constructor !== Array)
	{
		var temp_WUTdSww = add_php_getlistquery_WUTdSww;
		var add_php_getlistquery_WUTdSww = [];
		add_php_getlistquery_WUTdSww.push(temp_WUTdSww);
	}
	else if (!isSet(add_php_getlistquery_WUTdSww))
	{
		var add_php_getlistquery_WUTdSww = [];
	}
	var add_php_getlistquery = add_php_getlistquery_WUTdSww.some(add_php_getlistquery_WUTdSww_SomeFunc);

	if (isSet(gettype_WUTdSww) && gettype_WUTdSww.constructor !== Array)
	{
		var temp_WUTdSww = gettype_WUTdSww;
		var gettype_WUTdSww = [];
		gettype_WUTdSww.push(temp_WUTdSww);
	}
	else if (!isSet(gettype_WUTdSww))
	{
		var gettype_WUTdSww = [];
	}
	var gettype = gettype_WUTdSww.some(gettype_WUTdSww_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_WUTdSwwLPI_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_WUTdSwwLPI_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_WUTdSwwLPI_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_WUTdSwwLPI_required = true;
		}
	}
}

// the WUTdSww Some function
function add_php_getlistquery_WUTdSww_SomeFunc(add_php_getlistquery_WUTdSww)
{
	// set the function logic
	if (add_php_getlistquery_WUTdSww == 1)
	{
		return true;
	}
	return false;
}

// the WUTdSww Some function
function gettype_WUTdSww_SomeFunc(gettype_WUTdSww)
{
	// set the function logic
	if (gettype_WUTdSww == 2 || gettype_WUTdSww == 4)
	{
		return true;
	}
	return false;
}

// the OjNsfeN function
function OjNsfeN(add_php_before_getitems_OjNsfeN,gettype_OjNsfeN)
{
	if (isSet(add_php_before_getitems_OjNsfeN) && add_php_before_getitems_OjNsfeN.constructor !== Array)
	{
		var temp_OjNsfeN = add_php_before_getitems_OjNsfeN;
		var add_php_before_getitems_OjNsfeN = [];
		add_php_before_getitems_OjNsfeN.push(temp_OjNsfeN);
	}
	else if (!isSet(add_php_before_getitems_OjNsfeN))
	{
		var add_php_before_getitems_OjNsfeN = [];
	}
	var add_php_before_getitems = add_php_before_getitems_OjNsfeN.some(add_php_before_getitems_OjNsfeN_SomeFunc);

	if (isSet(gettype_OjNsfeN) && gettype_OjNsfeN.constructor !== Array)
	{
		var temp_OjNsfeN = gettype_OjNsfeN;
		var gettype_OjNsfeN = [];
		gettype_OjNsfeN.push(temp_OjNsfeN);
	}
	else if (!isSet(gettype_OjNsfeN))
	{
		var gettype_OjNsfeN = [];
	}
	var gettype = gettype_OjNsfeN.some(gettype_OjNsfeN_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_OjNsfeNPyU_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_OjNsfeNPyU_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_OjNsfeNPyU_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_OjNsfeNPyU_required = true;
		}
	}
}

// the OjNsfeN Some function
function add_php_before_getitems_OjNsfeN_SomeFunc(add_php_before_getitems_OjNsfeN)
{
	// set the function logic
	if (add_php_before_getitems_OjNsfeN == 1)
	{
		return true;
	}
	return false;
}

// the OjNsfeN Some function
function gettype_OjNsfeN_SomeFunc(gettype_OjNsfeN)
{
	// set the function logic
	if (gettype_OjNsfeN == 2 || gettype_OjNsfeN == 4)
	{
		return true;
	}
	return false;
}

// the mzPeyNJ function
function mzPeyNJ(add_php_after_getitems_mzPeyNJ,gettype_mzPeyNJ)
{
	if (isSet(add_php_after_getitems_mzPeyNJ) && add_php_after_getitems_mzPeyNJ.constructor !== Array)
	{
		var temp_mzPeyNJ = add_php_after_getitems_mzPeyNJ;
		var add_php_after_getitems_mzPeyNJ = [];
		add_php_after_getitems_mzPeyNJ.push(temp_mzPeyNJ);
	}
	else if (!isSet(add_php_after_getitems_mzPeyNJ))
	{
		var add_php_after_getitems_mzPeyNJ = [];
	}
	var add_php_after_getitems = add_php_after_getitems_mzPeyNJ.some(add_php_after_getitems_mzPeyNJ_SomeFunc);

	if (isSet(gettype_mzPeyNJ) && gettype_mzPeyNJ.constructor !== Array)
	{
		var temp_mzPeyNJ = gettype_mzPeyNJ;
		var gettype_mzPeyNJ = [];
		gettype_mzPeyNJ.push(temp_mzPeyNJ);
	}
	else if (!isSet(gettype_mzPeyNJ))
	{
		var gettype_mzPeyNJ = [];
	}
	var gettype = gettype_mzPeyNJ.some(gettype_mzPeyNJ_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_mzPeyNJQgg_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_mzPeyNJQgg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_mzPeyNJQgg_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_mzPeyNJQgg_required = true;
		}
	}
}

// the mzPeyNJ Some function
function add_php_after_getitems_mzPeyNJ_SomeFunc(add_php_after_getitems_mzPeyNJ)
{
	// set the function logic
	if (add_php_after_getitems_mzPeyNJ == 1)
	{
		return true;
	}
	return false;
}

// the mzPeyNJ Some function
function gettype_mzPeyNJ_SomeFunc(gettype_mzPeyNJ)
{
	// set the function logic
	if (gettype_mzPeyNJ == 2 || gettype_mzPeyNJ == 4)
	{
		return true;
	}
	return false;
}

// the LAQluZc function
function LAQluZc(gettype_LAQluZc)
{
	if (isSet(gettype_LAQluZc) && gettype_LAQluZc.constructor !== Array)
	{
		var temp_LAQluZc = gettype_LAQluZc;
		var gettype_LAQluZc = [];
		gettype_LAQluZc.push(temp_LAQluZc);
	}
	else if (!isSet(gettype_LAQluZc))
	{
		var gettype_LAQluZc = [];
	}
	var gettype = gettype_LAQluZc.some(gettype_LAQluZc_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_LAQluZcJef_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_LAQluZcJef_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_LAQluZczSw_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_LAQluZczSw_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_LAQluZcmgU_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_LAQluZcmgU_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_LAQluZcJef_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_LAQluZcJef_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_LAQluZczSw_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_LAQluZczSw_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_LAQluZcmgU_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_LAQluZcmgU_required = true;
		}
	}
}

// the LAQluZc Some function
function gettype_LAQluZc_SomeFunc(gettype_LAQluZc)
{
	// set the function logic
	if (gettype_LAQluZc == 2 || gettype_LAQluZc == 4)
	{
		return true;
	}
	return false;
}

// the eqvQVqX function
function eqvQVqX(gettype_eqvQVqX)
{
	if (isSet(gettype_eqvQVqX) && gettype_eqvQVqX.constructor !== Array)
	{
		var temp_eqvQVqX = gettype_eqvQVqX;
		var gettype_eqvQVqX = [];
		gettype_eqvQVqX.push(temp_eqvQVqX);
	}
	else if (!isSet(gettype_eqvQVqX))
	{
		var gettype_eqvQVqX = [];
	}
	var gettype = gettype_eqvQVqX.some(gettype_eqvQVqX_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_eqvQVqXbbb_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_eqvQVqXbbb_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_eqvQVqXbbb_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_eqvQVqXbbb_required = true;
		}
	}
}

// the eqvQVqX Some function
function gettype_eqvQVqX_SomeFunc(gettype_eqvQVqX)
{
	// set the function logic
	if (gettype_eqvQVqX == 2)
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
