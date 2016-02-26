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
jform_LcgMIYvkKC_required = false;
jform_FkvroZodZK_required = false;
jform_rnwZwJcMmj_required = false;
jform_YXjeKPchcL_required = false;
jform_HBUeaddwjc_required = false;
jform_ZAlosBXBtl_required = false;
jform_vTigkwWFkA_required = false;
jform_lWZWBjFqNF_required = false;
jform_qRlnsgrznK_required = false;
jform_QMSOYPJVxU_required = false;
jform_QMSOYPJHKH_required = false;
jform_pVDveQIDjW_required = false;
jform_qyOnvHrIrZ_required = false;
jform_FjXnTSHPBu_required = false;
jform_OSbLeACndd_required = false;
jform_OSbLeACAPB_required = false;
jform_OSbLeACHoI_required = false;
jform_xLDrwuQMQE_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_LcgMIYv = jQuery("#jform_gettype").val();
	LcgMIYv(gettype_LcgMIYv);

	var main_source_FkvroZo = jQuery("#jform_main_source").val();
	FkvroZo(main_source_FkvroZo);

	var main_source_rnwZwJc = jQuery("#jform_main_source").val();
	rnwZwJc(main_source_rnwZwJc);

	var main_source_YXjeKPc = jQuery("#jform_main_source").val();
	YXjeKPc(main_source_YXjeKPc);

	var main_source_HBUeadd = jQuery("#jform_main_source").val();
	HBUeadd(main_source_HBUeadd);

	var addcalculation_ZAlosBX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	ZAlosBX(addcalculation_ZAlosBX);

	var addcalculation_JriQwPE = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_JriQwPE = jQuery("#jform_gettype").val();
	JriQwPE(addcalculation_JriQwPE,gettype_JriQwPE);

	var addcalculation_yWMdEtX = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_yWMdEtX = jQuery("#jform_gettype").val();
	yWMdEtX(addcalculation_yWMdEtX,gettype_yWMdEtX);

	var main_source_vTigkwW = jQuery("#jform_main_source").val();
	vTigkwW(main_source_vTigkwW);

	var main_source_WhsaKIX = jQuery("#jform_main_source").val();
	WhsaKIX(main_source_WhsaKIX);

	var add_php_before_getitem_lWZWBjF = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_lWZWBjF = jQuery("#jform_gettype").val();
	lWZWBjF(add_php_before_getitem_lWZWBjF,gettype_lWZWBjF);

	var add_php_after_getitem_qRlnsgr = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_qRlnsgr = jQuery("#jform_gettype").val();
	qRlnsgr(add_php_after_getitem_qRlnsgr,gettype_qRlnsgr);

	var gettype_QMSOYPJ = jQuery("#jform_gettype").val();
	QMSOYPJ(gettype_QMSOYPJ);

	var add_php_getlistquery_pVDveQI = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_pVDveQI = jQuery("#jform_gettype").val();
	pVDveQI(add_php_getlistquery_pVDveQI,gettype_pVDveQI);

	var add_php_before_getitems_qyOnvHr = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_qyOnvHr = jQuery("#jform_gettype").val();
	qyOnvHr(add_php_before_getitems_qyOnvHr,gettype_qyOnvHr);

	var add_php_after_getitems_FjXnTSH = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_FjXnTSH = jQuery("#jform_gettype").val();
	FjXnTSH(add_php_after_getitems_FjXnTSH,gettype_FjXnTSH);

	var gettype_OSbLeAC = jQuery("#jform_gettype").val();
	OSbLeAC(gettype_OSbLeAC);

	var gettype_xLDrwuQ = jQuery("#jform_gettype").val();
	xLDrwuQ(gettype_xLDrwuQ);
});

// the LcgMIYv function
function LcgMIYv(gettype_LcgMIYv)
{
	if (isSet(gettype_LcgMIYv) && gettype_LcgMIYv.constructor !== Array)
	{
		var temp_LcgMIYv = gettype_LcgMIYv;
		var gettype_LcgMIYv = [];
		gettype_LcgMIYv.push(temp_LcgMIYv);
	}
	else if (!isSet(gettype_LcgMIYv))
	{
		var gettype_LcgMIYv = [];
	}
	var gettype = gettype_LcgMIYv.some(gettype_LcgMIYv_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_LcgMIYvkKC_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_LcgMIYvkKC_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_LcgMIYvkKC_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_LcgMIYvkKC_required = true;
		}
	}
}

// the LcgMIYv Some function
function gettype_LcgMIYv_SomeFunc(gettype_LcgMIYv)
{
	// set the function logic
	if (gettype_LcgMIYv == 3 || gettype_LcgMIYv == 4)
	{
		return true;
	}
	return false;
}

// the FkvroZo function
function FkvroZo(main_source_FkvroZo)
{
	if (isSet(main_source_FkvroZo) && main_source_FkvroZo.constructor !== Array)
	{
		var temp_FkvroZo = main_source_FkvroZo;
		var main_source_FkvroZo = [];
		main_source_FkvroZo.push(temp_FkvroZo);
	}
	else if (!isSet(main_source_FkvroZo))
	{
		var main_source_FkvroZo = [];
	}
	var main_source = main_source_FkvroZo.some(main_source_FkvroZo_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_FkvroZodZK_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_FkvroZodZK_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_FkvroZodZK_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_FkvroZodZK_required = true;
		}
	}
}

// the FkvroZo Some function
function main_source_FkvroZo_SomeFunc(main_source_FkvroZo)
{
	// set the function logic
	if (main_source_FkvroZo == 1)
	{
		return true;
	}
	return false;
}

// the rnwZwJc function
function rnwZwJc(main_source_rnwZwJc)
{
	if (isSet(main_source_rnwZwJc) && main_source_rnwZwJc.constructor !== Array)
	{
		var temp_rnwZwJc = main_source_rnwZwJc;
		var main_source_rnwZwJc = [];
		main_source_rnwZwJc.push(temp_rnwZwJc);
	}
	else if (!isSet(main_source_rnwZwJc))
	{
		var main_source_rnwZwJc = [];
	}
	var main_source = main_source_rnwZwJc.some(main_source_rnwZwJc_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_rnwZwJcMmj_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_rnwZwJcMmj_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_rnwZwJcMmj_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_rnwZwJcMmj_required = true;
		}
	}
}

// the rnwZwJc Some function
function main_source_rnwZwJc_SomeFunc(main_source_rnwZwJc)
{
	// set the function logic
	if (main_source_rnwZwJc == 1)
	{
		return true;
	}
	return false;
}

// the YXjeKPc function
function YXjeKPc(main_source_YXjeKPc)
{
	if (isSet(main_source_YXjeKPc) && main_source_YXjeKPc.constructor !== Array)
	{
		var temp_YXjeKPc = main_source_YXjeKPc;
		var main_source_YXjeKPc = [];
		main_source_YXjeKPc.push(temp_YXjeKPc);
	}
	else if (!isSet(main_source_YXjeKPc))
	{
		var main_source_YXjeKPc = [];
	}
	var main_source = main_source_YXjeKPc.some(main_source_YXjeKPc_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_YXjeKPchcL_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_YXjeKPchcL_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_YXjeKPchcL_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_YXjeKPchcL_required = true;
		}
	}
}

// the YXjeKPc Some function
function main_source_YXjeKPc_SomeFunc(main_source_YXjeKPc)
{
	// set the function logic
	if (main_source_YXjeKPc == 2)
	{
		return true;
	}
	return false;
}

// the HBUeadd function
function HBUeadd(main_source_HBUeadd)
{
	if (isSet(main_source_HBUeadd) && main_source_HBUeadd.constructor !== Array)
	{
		var temp_HBUeadd = main_source_HBUeadd;
		var main_source_HBUeadd = [];
		main_source_HBUeadd.push(temp_HBUeadd);
	}
	else if (!isSet(main_source_HBUeadd))
	{
		var main_source_HBUeadd = [];
	}
	var main_source = main_source_HBUeadd.some(main_source_HBUeadd_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_HBUeaddwjc_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_HBUeaddwjc_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_HBUeaddwjc_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_HBUeaddwjc_required = true;
		}
	}
}

// the HBUeadd Some function
function main_source_HBUeadd_SomeFunc(main_source_HBUeadd)
{
	// set the function logic
	if (main_source_HBUeadd == 2)
	{
		return true;
	}
	return false;
}

// the ZAlosBX function
function ZAlosBX(addcalculation_ZAlosBX)
{
	// set the function logic
	if (addcalculation_ZAlosBX == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_ZAlosBXBtl_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_ZAlosBXBtl_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_ZAlosBXBtl_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_ZAlosBXBtl_required = true;
		}
	}
}

// the JriQwPE function
function JriQwPE(addcalculation_JriQwPE,gettype_JriQwPE)
{
	if (isSet(addcalculation_JriQwPE) && addcalculation_JriQwPE.constructor !== Array)
	{
		var temp_JriQwPE = addcalculation_JriQwPE;
		var addcalculation_JriQwPE = [];
		addcalculation_JriQwPE.push(temp_JriQwPE);
	}
	else if (!isSet(addcalculation_JriQwPE))
	{
		var addcalculation_JriQwPE = [];
	}
	var addcalculation = addcalculation_JriQwPE.some(addcalculation_JriQwPE_SomeFunc);

	if (isSet(gettype_JriQwPE) && gettype_JriQwPE.constructor !== Array)
	{
		var temp_JriQwPE = gettype_JriQwPE;
		var gettype_JriQwPE = [];
		gettype_JriQwPE.push(temp_JriQwPE);
	}
	else if (!isSet(gettype_JriQwPE))
	{
		var gettype_JriQwPE = [];
	}
	var gettype = gettype_JriQwPE.some(gettype_JriQwPE_SomeFunc);


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

// the JriQwPE Some function
function addcalculation_JriQwPE_SomeFunc(addcalculation_JriQwPE)
{
	// set the function logic
	if (addcalculation_JriQwPE == 1)
	{
		return true;
	}
	return false;
}

// the JriQwPE Some function
function gettype_JriQwPE_SomeFunc(gettype_JriQwPE)
{
	// set the function logic
	if (gettype_JriQwPE == 1 || gettype_JriQwPE == 3)
	{
		return true;
	}
	return false;
}

// the yWMdEtX function
function yWMdEtX(addcalculation_yWMdEtX,gettype_yWMdEtX)
{
	if (isSet(addcalculation_yWMdEtX) && addcalculation_yWMdEtX.constructor !== Array)
	{
		var temp_yWMdEtX = addcalculation_yWMdEtX;
		var addcalculation_yWMdEtX = [];
		addcalculation_yWMdEtX.push(temp_yWMdEtX);
	}
	else if (!isSet(addcalculation_yWMdEtX))
	{
		var addcalculation_yWMdEtX = [];
	}
	var addcalculation = addcalculation_yWMdEtX.some(addcalculation_yWMdEtX_SomeFunc);

	if (isSet(gettype_yWMdEtX) && gettype_yWMdEtX.constructor !== Array)
	{
		var temp_yWMdEtX = gettype_yWMdEtX;
		var gettype_yWMdEtX = [];
		gettype_yWMdEtX.push(temp_yWMdEtX);
	}
	else if (!isSet(gettype_yWMdEtX))
	{
		var gettype_yWMdEtX = [];
	}
	var gettype = gettype_yWMdEtX.some(gettype_yWMdEtX_SomeFunc);


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

// the yWMdEtX Some function
function addcalculation_yWMdEtX_SomeFunc(addcalculation_yWMdEtX)
{
	// set the function logic
	if (addcalculation_yWMdEtX == 1)
	{
		return true;
	}
	return false;
}

// the yWMdEtX Some function
function gettype_yWMdEtX_SomeFunc(gettype_yWMdEtX)
{
	// set the function logic
	if (gettype_yWMdEtX == 2 || gettype_yWMdEtX == 4)
	{
		return true;
	}
	return false;
}

// the vTigkwW function
function vTigkwW(main_source_vTigkwW)
{
	if (isSet(main_source_vTigkwW) && main_source_vTigkwW.constructor !== Array)
	{
		var temp_vTigkwW = main_source_vTigkwW;
		var main_source_vTigkwW = [];
		main_source_vTigkwW.push(temp_vTigkwW);
	}
	else if (!isSet(main_source_vTigkwW))
	{
		var main_source_vTigkwW = [];
	}
	var main_source = main_source_vTigkwW.some(main_source_vTigkwW_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_vTigkwWFkA_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_vTigkwWFkA_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_vTigkwWFkA_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_vTigkwWFkA_required = true;
		}
	}
}

// the vTigkwW Some function
function main_source_vTigkwW_SomeFunc(main_source_vTigkwW)
{
	// set the function logic
	if (main_source_vTigkwW == 3)
	{
		return true;
	}
	return false;
}

// the WhsaKIX function
function WhsaKIX(main_source_WhsaKIX)
{
	if (isSet(main_source_WhsaKIX) && main_source_WhsaKIX.constructor !== Array)
	{
		var temp_WhsaKIX = main_source_WhsaKIX;
		var main_source_WhsaKIX = [];
		main_source_WhsaKIX.push(temp_WhsaKIX);
	}
	else if (!isSet(main_source_WhsaKIX))
	{
		var main_source_WhsaKIX = [];
	}
	var main_source = main_source_WhsaKIX.some(main_source_WhsaKIX_SomeFunc);


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

// the WhsaKIX Some function
function main_source_WhsaKIX_SomeFunc(main_source_WhsaKIX)
{
	// set the function logic
	if (main_source_WhsaKIX == 1 || main_source_WhsaKIX == 2)
	{
		return true;
	}
	return false;
}

// the lWZWBjF function
function lWZWBjF(add_php_before_getitem_lWZWBjF,gettype_lWZWBjF)
{
	if (isSet(add_php_before_getitem_lWZWBjF) && add_php_before_getitem_lWZWBjF.constructor !== Array)
	{
		var temp_lWZWBjF = add_php_before_getitem_lWZWBjF;
		var add_php_before_getitem_lWZWBjF = [];
		add_php_before_getitem_lWZWBjF.push(temp_lWZWBjF);
	}
	else if (!isSet(add_php_before_getitem_lWZWBjF))
	{
		var add_php_before_getitem_lWZWBjF = [];
	}
	var add_php_before_getitem = add_php_before_getitem_lWZWBjF.some(add_php_before_getitem_lWZWBjF_SomeFunc);

	if (isSet(gettype_lWZWBjF) && gettype_lWZWBjF.constructor !== Array)
	{
		var temp_lWZWBjF = gettype_lWZWBjF;
		var gettype_lWZWBjF = [];
		gettype_lWZWBjF.push(temp_lWZWBjF);
	}
	else if (!isSet(gettype_lWZWBjF))
	{
		var gettype_lWZWBjF = [];
	}
	var gettype = gettype_lWZWBjF.some(gettype_lWZWBjF_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_lWZWBjFqNF_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_lWZWBjFqNF_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_lWZWBjFqNF_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_lWZWBjFqNF_required = true;
		}
	}
}

// the lWZWBjF Some function
function add_php_before_getitem_lWZWBjF_SomeFunc(add_php_before_getitem_lWZWBjF)
{
	// set the function logic
	if (add_php_before_getitem_lWZWBjF == 1)
	{
		return true;
	}
	return false;
}

// the lWZWBjF Some function
function gettype_lWZWBjF_SomeFunc(gettype_lWZWBjF)
{
	// set the function logic
	if (gettype_lWZWBjF == 1 || gettype_lWZWBjF == 3)
	{
		return true;
	}
	return false;
}

// the qRlnsgr function
function qRlnsgr(add_php_after_getitem_qRlnsgr,gettype_qRlnsgr)
{
	if (isSet(add_php_after_getitem_qRlnsgr) && add_php_after_getitem_qRlnsgr.constructor !== Array)
	{
		var temp_qRlnsgr = add_php_after_getitem_qRlnsgr;
		var add_php_after_getitem_qRlnsgr = [];
		add_php_after_getitem_qRlnsgr.push(temp_qRlnsgr);
	}
	else if (!isSet(add_php_after_getitem_qRlnsgr))
	{
		var add_php_after_getitem_qRlnsgr = [];
	}
	var add_php_after_getitem = add_php_after_getitem_qRlnsgr.some(add_php_after_getitem_qRlnsgr_SomeFunc);

	if (isSet(gettype_qRlnsgr) && gettype_qRlnsgr.constructor !== Array)
	{
		var temp_qRlnsgr = gettype_qRlnsgr;
		var gettype_qRlnsgr = [];
		gettype_qRlnsgr.push(temp_qRlnsgr);
	}
	else if (!isSet(gettype_qRlnsgr))
	{
		var gettype_qRlnsgr = [];
	}
	var gettype = gettype_qRlnsgr.some(gettype_qRlnsgr_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_qRlnsgrznK_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_qRlnsgrznK_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_qRlnsgrznK_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_qRlnsgrznK_required = true;
		}
	}
}

// the qRlnsgr Some function
function add_php_after_getitem_qRlnsgr_SomeFunc(add_php_after_getitem_qRlnsgr)
{
	// set the function logic
	if (add_php_after_getitem_qRlnsgr == 1)
	{
		return true;
	}
	return false;
}

// the qRlnsgr Some function
function gettype_qRlnsgr_SomeFunc(gettype_qRlnsgr)
{
	// set the function logic
	if (gettype_qRlnsgr == 1 || gettype_qRlnsgr == 3)
	{
		return true;
	}
	return false;
}

// the QMSOYPJ function
function QMSOYPJ(gettype_QMSOYPJ)
{
	if (isSet(gettype_QMSOYPJ) && gettype_QMSOYPJ.constructor !== Array)
	{
		var temp_QMSOYPJ = gettype_QMSOYPJ;
		var gettype_QMSOYPJ = [];
		gettype_QMSOYPJ.push(temp_QMSOYPJ);
	}
	else if (!isSet(gettype_QMSOYPJ))
	{
		var gettype_QMSOYPJ = [];
	}
	var gettype = gettype_QMSOYPJ.some(gettype_QMSOYPJ_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_QMSOYPJVxU_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_QMSOYPJVxU_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_QMSOYPJHKH_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_QMSOYPJHKH_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_QMSOYPJVxU_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_QMSOYPJVxU_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_QMSOYPJHKH_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_QMSOYPJHKH_required = true;
		}
	}
}

// the QMSOYPJ Some function
function gettype_QMSOYPJ_SomeFunc(gettype_QMSOYPJ)
{
	// set the function logic
	if (gettype_QMSOYPJ == 1 || gettype_QMSOYPJ == 3)
	{
		return true;
	}
	return false;
}

// the pVDveQI function
function pVDveQI(add_php_getlistquery_pVDveQI,gettype_pVDveQI)
{
	if (isSet(add_php_getlistquery_pVDveQI) && add_php_getlistquery_pVDveQI.constructor !== Array)
	{
		var temp_pVDveQI = add_php_getlistquery_pVDveQI;
		var add_php_getlistquery_pVDveQI = [];
		add_php_getlistquery_pVDveQI.push(temp_pVDveQI);
	}
	else if (!isSet(add_php_getlistquery_pVDveQI))
	{
		var add_php_getlistquery_pVDveQI = [];
	}
	var add_php_getlistquery = add_php_getlistquery_pVDveQI.some(add_php_getlistquery_pVDveQI_SomeFunc);

	if (isSet(gettype_pVDveQI) && gettype_pVDveQI.constructor !== Array)
	{
		var temp_pVDveQI = gettype_pVDveQI;
		var gettype_pVDveQI = [];
		gettype_pVDveQI.push(temp_pVDveQI);
	}
	else if (!isSet(gettype_pVDveQI))
	{
		var gettype_pVDveQI = [];
	}
	var gettype = gettype_pVDveQI.some(gettype_pVDveQI_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_pVDveQIDjW_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_pVDveQIDjW_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_pVDveQIDjW_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_pVDveQIDjW_required = true;
		}
	}
}

// the pVDveQI Some function
function add_php_getlistquery_pVDveQI_SomeFunc(add_php_getlistquery_pVDveQI)
{
	// set the function logic
	if (add_php_getlistquery_pVDveQI == 1)
	{
		return true;
	}
	return false;
}

// the pVDveQI Some function
function gettype_pVDveQI_SomeFunc(gettype_pVDveQI)
{
	// set the function logic
	if (gettype_pVDveQI == 2 || gettype_pVDveQI == 4)
	{
		return true;
	}
	return false;
}

// the qyOnvHr function
function qyOnvHr(add_php_before_getitems_qyOnvHr,gettype_qyOnvHr)
{
	if (isSet(add_php_before_getitems_qyOnvHr) && add_php_before_getitems_qyOnvHr.constructor !== Array)
	{
		var temp_qyOnvHr = add_php_before_getitems_qyOnvHr;
		var add_php_before_getitems_qyOnvHr = [];
		add_php_before_getitems_qyOnvHr.push(temp_qyOnvHr);
	}
	else if (!isSet(add_php_before_getitems_qyOnvHr))
	{
		var add_php_before_getitems_qyOnvHr = [];
	}
	var add_php_before_getitems = add_php_before_getitems_qyOnvHr.some(add_php_before_getitems_qyOnvHr_SomeFunc);

	if (isSet(gettype_qyOnvHr) && gettype_qyOnvHr.constructor !== Array)
	{
		var temp_qyOnvHr = gettype_qyOnvHr;
		var gettype_qyOnvHr = [];
		gettype_qyOnvHr.push(temp_qyOnvHr);
	}
	else if (!isSet(gettype_qyOnvHr))
	{
		var gettype_qyOnvHr = [];
	}
	var gettype = gettype_qyOnvHr.some(gettype_qyOnvHr_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_qyOnvHrIrZ_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_qyOnvHrIrZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_qyOnvHrIrZ_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_qyOnvHrIrZ_required = true;
		}
	}
}

// the qyOnvHr Some function
function add_php_before_getitems_qyOnvHr_SomeFunc(add_php_before_getitems_qyOnvHr)
{
	// set the function logic
	if (add_php_before_getitems_qyOnvHr == 1)
	{
		return true;
	}
	return false;
}

// the qyOnvHr Some function
function gettype_qyOnvHr_SomeFunc(gettype_qyOnvHr)
{
	// set the function logic
	if (gettype_qyOnvHr == 2 || gettype_qyOnvHr == 4)
	{
		return true;
	}
	return false;
}

// the FjXnTSH function
function FjXnTSH(add_php_after_getitems_FjXnTSH,gettype_FjXnTSH)
{
	if (isSet(add_php_after_getitems_FjXnTSH) && add_php_after_getitems_FjXnTSH.constructor !== Array)
	{
		var temp_FjXnTSH = add_php_after_getitems_FjXnTSH;
		var add_php_after_getitems_FjXnTSH = [];
		add_php_after_getitems_FjXnTSH.push(temp_FjXnTSH);
	}
	else if (!isSet(add_php_after_getitems_FjXnTSH))
	{
		var add_php_after_getitems_FjXnTSH = [];
	}
	var add_php_after_getitems = add_php_after_getitems_FjXnTSH.some(add_php_after_getitems_FjXnTSH_SomeFunc);

	if (isSet(gettype_FjXnTSH) && gettype_FjXnTSH.constructor !== Array)
	{
		var temp_FjXnTSH = gettype_FjXnTSH;
		var gettype_FjXnTSH = [];
		gettype_FjXnTSH.push(temp_FjXnTSH);
	}
	else if (!isSet(gettype_FjXnTSH))
	{
		var gettype_FjXnTSH = [];
	}
	var gettype = gettype_FjXnTSH.some(gettype_FjXnTSH_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_FjXnTSHPBu_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_FjXnTSHPBu_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_FjXnTSHPBu_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_FjXnTSHPBu_required = true;
		}
	}
}

// the FjXnTSH Some function
function add_php_after_getitems_FjXnTSH_SomeFunc(add_php_after_getitems_FjXnTSH)
{
	// set the function logic
	if (add_php_after_getitems_FjXnTSH == 1)
	{
		return true;
	}
	return false;
}

// the FjXnTSH Some function
function gettype_FjXnTSH_SomeFunc(gettype_FjXnTSH)
{
	// set the function logic
	if (gettype_FjXnTSH == 2 || gettype_FjXnTSH == 4)
	{
		return true;
	}
	return false;
}

// the OSbLeAC function
function OSbLeAC(gettype_OSbLeAC)
{
	if (isSet(gettype_OSbLeAC) && gettype_OSbLeAC.constructor !== Array)
	{
		var temp_OSbLeAC = gettype_OSbLeAC;
		var gettype_OSbLeAC = [];
		gettype_OSbLeAC.push(temp_OSbLeAC);
	}
	else if (!isSet(gettype_OSbLeAC))
	{
		var gettype_OSbLeAC = [];
	}
	var gettype = gettype_OSbLeAC.some(gettype_OSbLeAC_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_OSbLeACndd_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_OSbLeACndd_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_OSbLeACAPB_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_OSbLeACAPB_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_OSbLeACHoI_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_OSbLeACHoI_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_OSbLeACndd_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_OSbLeACndd_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_OSbLeACAPB_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_OSbLeACAPB_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_OSbLeACHoI_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_OSbLeACHoI_required = true;
		}
	}
}

// the OSbLeAC Some function
function gettype_OSbLeAC_SomeFunc(gettype_OSbLeAC)
{
	// set the function logic
	if (gettype_OSbLeAC == 2 || gettype_OSbLeAC == 4)
	{
		return true;
	}
	return false;
}

// the xLDrwuQ function
function xLDrwuQ(gettype_xLDrwuQ)
{
	if (isSet(gettype_xLDrwuQ) && gettype_xLDrwuQ.constructor !== Array)
	{
		var temp_xLDrwuQ = gettype_xLDrwuQ;
		var gettype_xLDrwuQ = [];
		gettype_xLDrwuQ.push(temp_xLDrwuQ);
	}
	else if (!isSet(gettype_xLDrwuQ))
	{
		var gettype_xLDrwuQ = [];
	}
	var gettype = gettype_xLDrwuQ.some(gettype_xLDrwuQ_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_xLDrwuQMQE_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_xLDrwuQMQE_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_xLDrwuQMQE_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_xLDrwuQMQE_required = true;
		}
	}
}

// the xLDrwuQ Some function
function gettype_xLDrwuQ_SomeFunc(gettype_xLDrwuQ)
{
	// set the function logic
	if (gettype_xLDrwuQ == 2)
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
