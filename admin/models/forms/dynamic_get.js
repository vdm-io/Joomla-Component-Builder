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
	@build			18th February, 2016
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
jform_bSeMSaXKoH_required = false;
jform_KKWOFzRsoP_required = false;
jform_lLQgZeAaGJ_required = false;
jform_MIGOzrOpgZ_required = false;
jform_XVCVMmCwAO_required = false;
jform_sSBhZAkAuV_required = false;
jform_zQWGYymUGs_required = false;
jform_FGaqcjKMiH_required = false;
jform_whfxEUBeTZ_required = false;
jform_DTmXrXXFZf_required = false;
jform_DTmXrXXsHm_required = false;
jform_ekriOWejbZ_required = false;
jform_jtKKkdmGyi_required = false;
jform_XvyTBjVAII_required = false;
jform_aNkZZKNOSP_required = false;
jform_aNkZZKNcyp_required = false;
jform_aNkZZKNkDT_required = false;
jform_JzmWmUyUJl_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_bSeMSaX = jQuery("#jform_gettype").val();
	bSeMSaX(gettype_bSeMSaX);

	var main_source_KKWOFzR = jQuery("#jform_main_source").val();
	KKWOFzR(main_source_KKWOFzR);

	var main_source_lLQgZeA = jQuery("#jform_main_source").val();
	lLQgZeA(main_source_lLQgZeA);

	var main_source_MIGOzrO = jQuery("#jform_main_source").val();
	MIGOzrO(main_source_MIGOzrO);

	var main_source_XVCVMmC = jQuery("#jform_main_source").val();
	XVCVMmC(main_source_XVCVMmC);

	var addcalculation_sSBhZAk = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	sSBhZAk(addcalculation_sSBhZAk);

	var addcalculation_jiIMVbg = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_jiIMVbg = jQuery("#jform_gettype").val();
	jiIMVbg(addcalculation_jiIMVbg,gettype_jiIMVbg);

	var addcalculation_FylKwjr = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_FylKwjr = jQuery("#jform_gettype").val();
	FylKwjr(addcalculation_FylKwjr,gettype_FylKwjr);

	var main_source_zQWGYym = jQuery("#jform_main_source").val();
	zQWGYym(main_source_zQWGYym);

	var main_source_EYLinRu = jQuery("#jform_main_source").val();
	EYLinRu(main_source_EYLinRu);

	var add_php_before_getitem_FGaqcjK = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_FGaqcjK = jQuery("#jform_gettype").val();
	FGaqcjK(add_php_before_getitem_FGaqcjK,gettype_FGaqcjK);

	var add_php_after_getitem_whfxEUB = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_whfxEUB = jQuery("#jform_gettype").val();
	whfxEUB(add_php_after_getitem_whfxEUB,gettype_whfxEUB);

	var gettype_DTmXrXX = jQuery("#jform_gettype").val();
	DTmXrXX(gettype_DTmXrXX);

	var add_php_getlistquery_ekriOWe = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_ekriOWe = jQuery("#jform_gettype").val();
	ekriOWe(add_php_getlistquery_ekriOWe,gettype_ekriOWe);

	var add_php_before_getitems_jtKKkdm = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_jtKKkdm = jQuery("#jform_gettype").val();
	jtKKkdm(add_php_before_getitems_jtKKkdm,gettype_jtKKkdm);

	var add_php_after_getitems_XvyTBjV = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_XvyTBjV = jQuery("#jform_gettype").val();
	XvyTBjV(add_php_after_getitems_XvyTBjV,gettype_XvyTBjV);

	var gettype_aNkZZKN = jQuery("#jform_gettype").val();
	aNkZZKN(gettype_aNkZZKN);

	var gettype_JzmWmUy = jQuery("#jform_gettype").val();
	JzmWmUy(gettype_JzmWmUy);
});

// the bSeMSaX function
function bSeMSaX(gettype_bSeMSaX)
{
	if (isSet(gettype_bSeMSaX) && gettype_bSeMSaX.constructor !== Array)
	{
		var temp_bSeMSaX = gettype_bSeMSaX;
		var gettype_bSeMSaX = [];
		gettype_bSeMSaX.push(temp_bSeMSaX);
	}
	else if (!isSet(gettype_bSeMSaX))
	{
		var gettype_bSeMSaX = [];
	}
	var gettype = gettype_bSeMSaX.some(gettype_bSeMSaX_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_bSeMSaXKoH_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_bSeMSaXKoH_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_bSeMSaXKoH_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_bSeMSaXKoH_required = true;
		}
	}
}

// the bSeMSaX Some function
function gettype_bSeMSaX_SomeFunc(gettype_bSeMSaX)
{
	// set the function logic
	if (gettype_bSeMSaX == 3 || gettype_bSeMSaX == 4)
	{
		return true;
	}
	return false;
}

// the KKWOFzR function
function KKWOFzR(main_source_KKWOFzR)
{
	if (isSet(main_source_KKWOFzR) && main_source_KKWOFzR.constructor !== Array)
	{
		var temp_KKWOFzR = main_source_KKWOFzR;
		var main_source_KKWOFzR = [];
		main_source_KKWOFzR.push(temp_KKWOFzR);
	}
	else if (!isSet(main_source_KKWOFzR))
	{
		var main_source_KKWOFzR = [];
	}
	var main_source = main_source_KKWOFzR.some(main_source_KKWOFzR_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_KKWOFzRsoP_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_KKWOFzRsoP_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_KKWOFzRsoP_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_KKWOFzRsoP_required = true;
		}
	}
}

// the KKWOFzR Some function
function main_source_KKWOFzR_SomeFunc(main_source_KKWOFzR)
{
	// set the function logic
	if (main_source_KKWOFzR == 1)
	{
		return true;
	}
	return false;
}

// the lLQgZeA function
function lLQgZeA(main_source_lLQgZeA)
{
	if (isSet(main_source_lLQgZeA) && main_source_lLQgZeA.constructor !== Array)
	{
		var temp_lLQgZeA = main_source_lLQgZeA;
		var main_source_lLQgZeA = [];
		main_source_lLQgZeA.push(temp_lLQgZeA);
	}
	else if (!isSet(main_source_lLQgZeA))
	{
		var main_source_lLQgZeA = [];
	}
	var main_source = main_source_lLQgZeA.some(main_source_lLQgZeA_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_lLQgZeAaGJ_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_lLQgZeAaGJ_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_lLQgZeAaGJ_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_lLQgZeAaGJ_required = true;
		}
	}
}

// the lLQgZeA Some function
function main_source_lLQgZeA_SomeFunc(main_source_lLQgZeA)
{
	// set the function logic
	if (main_source_lLQgZeA == 1)
	{
		return true;
	}
	return false;
}

// the MIGOzrO function
function MIGOzrO(main_source_MIGOzrO)
{
	if (isSet(main_source_MIGOzrO) && main_source_MIGOzrO.constructor !== Array)
	{
		var temp_MIGOzrO = main_source_MIGOzrO;
		var main_source_MIGOzrO = [];
		main_source_MIGOzrO.push(temp_MIGOzrO);
	}
	else if (!isSet(main_source_MIGOzrO))
	{
		var main_source_MIGOzrO = [];
	}
	var main_source = main_source_MIGOzrO.some(main_source_MIGOzrO_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_MIGOzrOpgZ_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_MIGOzrOpgZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_MIGOzrOpgZ_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_MIGOzrOpgZ_required = true;
		}
	}
}

// the MIGOzrO Some function
function main_source_MIGOzrO_SomeFunc(main_source_MIGOzrO)
{
	// set the function logic
	if (main_source_MIGOzrO == 2)
	{
		return true;
	}
	return false;
}

// the XVCVMmC function
function XVCVMmC(main_source_XVCVMmC)
{
	if (isSet(main_source_XVCVMmC) && main_source_XVCVMmC.constructor !== Array)
	{
		var temp_XVCVMmC = main_source_XVCVMmC;
		var main_source_XVCVMmC = [];
		main_source_XVCVMmC.push(temp_XVCVMmC);
	}
	else if (!isSet(main_source_XVCVMmC))
	{
		var main_source_XVCVMmC = [];
	}
	var main_source = main_source_XVCVMmC.some(main_source_XVCVMmC_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_XVCVMmCwAO_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_XVCVMmCwAO_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_XVCVMmCwAO_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_XVCVMmCwAO_required = true;
		}
	}
}

// the XVCVMmC Some function
function main_source_XVCVMmC_SomeFunc(main_source_XVCVMmC)
{
	// set the function logic
	if (main_source_XVCVMmC == 2)
	{
		return true;
	}
	return false;
}

// the sSBhZAk function
function sSBhZAk(addcalculation_sSBhZAk)
{
	// set the function logic
	if (addcalculation_sSBhZAk == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_sSBhZAkAuV_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_sSBhZAkAuV_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_sSBhZAkAuV_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_sSBhZAkAuV_required = true;
		}
	}
}

// the jiIMVbg function
function jiIMVbg(addcalculation_jiIMVbg,gettype_jiIMVbg)
{
	if (isSet(addcalculation_jiIMVbg) && addcalculation_jiIMVbg.constructor !== Array)
	{
		var temp_jiIMVbg = addcalculation_jiIMVbg;
		var addcalculation_jiIMVbg = [];
		addcalculation_jiIMVbg.push(temp_jiIMVbg);
	}
	else if (!isSet(addcalculation_jiIMVbg))
	{
		var addcalculation_jiIMVbg = [];
	}
	var addcalculation = addcalculation_jiIMVbg.some(addcalculation_jiIMVbg_SomeFunc);

	if (isSet(gettype_jiIMVbg) && gettype_jiIMVbg.constructor !== Array)
	{
		var temp_jiIMVbg = gettype_jiIMVbg;
		var gettype_jiIMVbg = [];
		gettype_jiIMVbg.push(temp_jiIMVbg);
	}
	else if (!isSet(gettype_jiIMVbg))
	{
		var gettype_jiIMVbg = [];
	}
	var gettype = gettype_jiIMVbg.some(gettype_jiIMVbg_SomeFunc);


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

// the jiIMVbg Some function
function addcalculation_jiIMVbg_SomeFunc(addcalculation_jiIMVbg)
{
	// set the function logic
	if (addcalculation_jiIMVbg == 1)
	{
		return true;
	}
	return false;
}

// the jiIMVbg Some function
function gettype_jiIMVbg_SomeFunc(gettype_jiIMVbg)
{
	// set the function logic
	if (gettype_jiIMVbg == 1 || gettype_jiIMVbg == 3)
	{
		return true;
	}
	return false;
}

// the FylKwjr function
function FylKwjr(addcalculation_FylKwjr,gettype_FylKwjr)
{
	if (isSet(addcalculation_FylKwjr) && addcalculation_FylKwjr.constructor !== Array)
	{
		var temp_FylKwjr = addcalculation_FylKwjr;
		var addcalculation_FylKwjr = [];
		addcalculation_FylKwjr.push(temp_FylKwjr);
	}
	else if (!isSet(addcalculation_FylKwjr))
	{
		var addcalculation_FylKwjr = [];
	}
	var addcalculation = addcalculation_FylKwjr.some(addcalculation_FylKwjr_SomeFunc);

	if (isSet(gettype_FylKwjr) && gettype_FylKwjr.constructor !== Array)
	{
		var temp_FylKwjr = gettype_FylKwjr;
		var gettype_FylKwjr = [];
		gettype_FylKwjr.push(temp_FylKwjr);
	}
	else if (!isSet(gettype_FylKwjr))
	{
		var gettype_FylKwjr = [];
	}
	var gettype = gettype_FylKwjr.some(gettype_FylKwjr_SomeFunc);


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

// the FylKwjr Some function
function addcalculation_FylKwjr_SomeFunc(addcalculation_FylKwjr)
{
	// set the function logic
	if (addcalculation_FylKwjr == 1)
	{
		return true;
	}
	return false;
}

// the FylKwjr Some function
function gettype_FylKwjr_SomeFunc(gettype_FylKwjr)
{
	// set the function logic
	if (gettype_FylKwjr == 2 || gettype_FylKwjr == 4)
	{
		return true;
	}
	return false;
}

// the zQWGYym function
function zQWGYym(main_source_zQWGYym)
{
	if (isSet(main_source_zQWGYym) && main_source_zQWGYym.constructor !== Array)
	{
		var temp_zQWGYym = main_source_zQWGYym;
		var main_source_zQWGYym = [];
		main_source_zQWGYym.push(temp_zQWGYym);
	}
	else if (!isSet(main_source_zQWGYym))
	{
		var main_source_zQWGYym = [];
	}
	var main_source = main_source_zQWGYym.some(main_source_zQWGYym_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_zQWGYymUGs_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_zQWGYymUGs_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_zQWGYymUGs_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_zQWGYymUGs_required = true;
		}
	}
}

// the zQWGYym Some function
function main_source_zQWGYym_SomeFunc(main_source_zQWGYym)
{
	// set the function logic
	if (main_source_zQWGYym == 3)
	{
		return true;
	}
	return false;
}

// the EYLinRu function
function EYLinRu(main_source_EYLinRu)
{
	if (isSet(main_source_EYLinRu) && main_source_EYLinRu.constructor !== Array)
	{
		var temp_EYLinRu = main_source_EYLinRu;
		var main_source_EYLinRu = [];
		main_source_EYLinRu.push(temp_EYLinRu);
	}
	else if (!isSet(main_source_EYLinRu))
	{
		var main_source_EYLinRu = [];
	}
	var main_source = main_source_EYLinRu.some(main_source_EYLinRu_SomeFunc);


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

// the EYLinRu Some function
function main_source_EYLinRu_SomeFunc(main_source_EYLinRu)
{
	// set the function logic
	if (main_source_EYLinRu == 1 || main_source_EYLinRu == 2)
	{
		return true;
	}
	return false;
}

// the FGaqcjK function
function FGaqcjK(add_php_before_getitem_FGaqcjK,gettype_FGaqcjK)
{
	if (isSet(add_php_before_getitem_FGaqcjK) && add_php_before_getitem_FGaqcjK.constructor !== Array)
	{
		var temp_FGaqcjK = add_php_before_getitem_FGaqcjK;
		var add_php_before_getitem_FGaqcjK = [];
		add_php_before_getitem_FGaqcjK.push(temp_FGaqcjK);
	}
	else if (!isSet(add_php_before_getitem_FGaqcjK))
	{
		var add_php_before_getitem_FGaqcjK = [];
	}
	var add_php_before_getitem = add_php_before_getitem_FGaqcjK.some(add_php_before_getitem_FGaqcjK_SomeFunc);

	if (isSet(gettype_FGaqcjK) && gettype_FGaqcjK.constructor !== Array)
	{
		var temp_FGaqcjK = gettype_FGaqcjK;
		var gettype_FGaqcjK = [];
		gettype_FGaqcjK.push(temp_FGaqcjK);
	}
	else if (!isSet(gettype_FGaqcjK))
	{
		var gettype_FGaqcjK = [];
	}
	var gettype = gettype_FGaqcjK.some(gettype_FGaqcjK_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_FGaqcjKMiH_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_FGaqcjKMiH_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_FGaqcjKMiH_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_FGaqcjKMiH_required = true;
		}
	}
}

// the FGaqcjK Some function
function add_php_before_getitem_FGaqcjK_SomeFunc(add_php_before_getitem_FGaqcjK)
{
	// set the function logic
	if (add_php_before_getitem_FGaqcjK == 1)
	{
		return true;
	}
	return false;
}

// the FGaqcjK Some function
function gettype_FGaqcjK_SomeFunc(gettype_FGaqcjK)
{
	// set the function logic
	if (gettype_FGaqcjK == 1 || gettype_FGaqcjK == 3)
	{
		return true;
	}
	return false;
}

// the whfxEUB function
function whfxEUB(add_php_after_getitem_whfxEUB,gettype_whfxEUB)
{
	if (isSet(add_php_after_getitem_whfxEUB) && add_php_after_getitem_whfxEUB.constructor !== Array)
	{
		var temp_whfxEUB = add_php_after_getitem_whfxEUB;
		var add_php_after_getitem_whfxEUB = [];
		add_php_after_getitem_whfxEUB.push(temp_whfxEUB);
	}
	else if (!isSet(add_php_after_getitem_whfxEUB))
	{
		var add_php_after_getitem_whfxEUB = [];
	}
	var add_php_after_getitem = add_php_after_getitem_whfxEUB.some(add_php_after_getitem_whfxEUB_SomeFunc);

	if (isSet(gettype_whfxEUB) && gettype_whfxEUB.constructor !== Array)
	{
		var temp_whfxEUB = gettype_whfxEUB;
		var gettype_whfxEUB = [];
		gettype_whfxEUB.push(temp_whfxEUB);
	}
	else if (!isSet(gettype_whfxEUB))
	{
		var gettype_whfxEUB = [];
	}
	var gettype = gettype_whfxEUB.some(gettype_whfxEUB_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_whfxEUBeTZ_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_whfxEUBeTZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_whfxEUBeTZ_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_whfxEUBeTZ_required = true;
		}
	}
}

// the whfxEUB Some function
function add_php_after_getitem_whfxEUB_SomeFunc(add_php_after_getitem_whfxEUB)
{
	// set the function logic
	if (add_php_after_getitem_whfxEUB == 1)
	{
		return true;
	}
	return false;
}

// the whfxEUB Some function
function gettype_whfxEUB_SomeFunc(gettype_whfxEUB)
{
	// set the function logic
	if (gettype_whfxEUB == 1 || gettype_whfxEUB == 3)
	{
		return true;
	}
	return false;
}

// the DTmXrXX function
function DTmXrXX(gettype_DTmXrXX)
{
	if (isSet(gettype_DTmXrXX) && gettype_DTmXrXX.constructor !== Array)
	{
		var temp_DTmXrXX = gettype_DTmXrXX;
		var gettype_DTmXrXX = [];
		gettype_DTmXrXX.push(temp_DTmXrXX);
	}
	else if (!isSet(gettype_DTmXrXX))
	{
		var gettype_DTmXrXX = [];
	}
	var gettype = gettype_DTmXrXX.some(gettype_DTmXrXX_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_DTmXrXXFZf_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_DTmXrXXFZf_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_DTmXrXXsHm_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_DTmXrXXsHm_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_DTmXrXXFZf_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_DTmXrXXFZf_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_DTmXrXXsHm_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_DTmXrXXsHm_required = true;
		}
	}
}

// the DTmXrXX Some function
function gettype_DTmXrXX_SomeFunc(gettype_DTmXrXX)
{
	// set the function logic
	if (gettype_DTmXrXX == 1 || gettype_DTmXrXX == 3)
	{
		return true;
	}
	return false;
}

// the ekriOWe function
function ekriOWe(add_php_getlistquery_ekriOWe,gettype_ekriOWe)
{
	if (isSet(add_php_getlistquery_ekriOWe) && add_php_getlistquery_ekriOWe.constructor !== Array)
	{
		var temp_ekriOWe = add_php_getlistquery_ekriOWe;
		var add_php_getlistquery_ekriOWe = [];
		add_php_getlistquery_ekriOWe.push(temp_ekriOWe);
	}
	else if (!isSet(add_php_getlistquery_ekriOWe))
	{
		var add_php_getlistquery_ekriOWe = [];
	}
	var add_php_getlistquery = add_php_getlistquery_ekriOWe.some(add_php_getlistquery_ekriOWe_SomeFunc);

	if (isSet(gettype_ekriOWe) && gettype_ekriOWe.constructor !== Array)
	{
		var temp_ekriOWe = gettype_ekriOWe;
		var gettype_ekriOWe = [];
		gettype_ekriOWe.push(temp_ekriOWe);
	}
	else if (!isSet(gettype_ekriOWe))
	{
		var gettype_ekriOWe = [];
	}
	var gettype = gettype_ekriOWe.some(gettype_ekriOWe_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_ekriOWejbZ_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_ekriOWejbZ_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_ekriOWejbZ_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_ekriOWejbZ_required = true;
		}
	}
}

// the ekriOWe Some function
function add_php_getlistquery_ekriOWe_SomeFunc(add_php_getlistquery_ekriOWe)
{
	// set the function logic
	if (add_php_getlistquery_ekriOWe == 1)
	{
		return true;
	}
	return false;
}

// the ekriOWe Some function
function gettype_ekriOWe_SomeFunc(gettype_ekriOWe)
{
	// set the function logic
	if (gettype_ekriOWe == 2 || gettype_ekriOWe == 4)
	{
		return true;
	}
	return false;
}

// the jtKKkdm function
function jtKKkdm(add_php_before_getitems_jtKKkdm,gettype_jtKKkdm)
{
	if (isSet(add_php_before_getitems_jtKKkdm) && add_php_before_getitems_jtKKkdm.constructor !== Array)
	{
		var temp_jtKKkdm = add_php_before_getitems_jtKKkdm;
		var add_php_before_getitems_jtKKkdm = [];
		add_php_before_getitems_jtKKkdm.push(temp_jtKKkdm);
	}
	else if (!isSet(add_php_before_getitems_jtKKkdm))
	{
		var add_php_before_getitems_jtKKkdm = [];
	}
	var add_php_before_getitems = add_php_before_getitems_jtKKkdm.some(add_php_before_getitems_jtKKkdm_SomeFunc);

	if (isSet(gettype_jtKKkdm) && gettype_jtKKkdm.constructor !== Array)
	{
		var temp_jtKKkdm = gettype_jtKKkdm;
		var gettype_jtKKkdm = [];
		gettype_jtKKkdm.push(temp_jtKKkdm);
	}
	else if (!isSet(gettype_jtKKkdm))
	{
		var gettype_jtKKkdm = [];
	}
	var gettype = gettype_jtKKkdm.some(gettype_jtKKkdm_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_jtKKkdmGyi_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_jtKKkdmGyi_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_jtKKkdmGyi_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_jtKKkdmGyi_required = true;
		}
	}
}

// the jtKKkdm Some function
function add_php_before_getitems_jtKKkdm_SomeFunc(add_php_before_getitems_jtKKkdm)
{
	// set the function logic
	if (add_php_before_getitems_jtKKkdm == 1)
	{
		return true;
	}
	return false;
}

// the jtKKkdm Some function
function gettype_jtKKkdm_SomeFunc(gettype_jtKKkdm)
{
	// set the function logic
	if (gettype_jtKKkdm == 2 || gettype_jtKKkdm == 4)
	{
		return true;
	}
	return false;
}

// the XvyTBjV function
function XvyTBjV(add_php_after_getitems_XvyTBjV,gettype_XvyTBjV)
{
	if (isSet(add_php_after_getitems_XvyTBjV) && add_php_after_getitems_XvyTBjV.constructor !== Array)
	{
		var temp_XvyTBjV = add_php_after_getitems_XvyTBjV;
		var add_php_after_getitems_XvyTBjV = [];
		add_php_after_getitems_XvyTBjV.push(temp_XvyTBjV);
	}
	else if (!isSet(add_php_after_getitems_XvyTBjV))
	{
		var add_php_after_getitems_XvyTBjV = [];
	}
	var add_php_after_getitems = add_php_after_getitems_XvyTBjV.some(add_php_after_getitems_XvyTBjV_SomeFunc);

	if (isSet(gettype_XvyTBjV) && gettype_XvyTBjV.constructor !== Array)
	{
		var temp_XvyTBjV = gettype_XvyTBjV;
		var gettype_XvyTBjV = [];
		gettype_XvyTBjV.push(temp_XvyTBjV);
	}
	else if (!isSet(gettype_XvyTBjV))
	{
		var gettype_XvyTBjV = [];
	}
	var gettype = gettype_XvyTBjV.some(gettype_XvyTBjV_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_XvyTBjVAII_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_XvyTBjVAII_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_XvyTBjVAII_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_XvyTBjVAII_required = true;
		}
	}
}

// the XvyTBjV Some function
function add_php_after_getitems_XvyTBjV_SomeFunc(add_php_after_getitems_XvyTBjV)
{
	// set the function logic
	if (add_php_after_getitems_XvyTBjV == 1)
	{
		return true;
	}
	return false;
}

// the XvyTBjV Some function
function gettype_XvyTBjV_SomeFunc(gettype_XvyTBjV)
{
	// set the function logic
	if (gettype_XvyTBjV == 2 || gettype_XvyTBjV == 4)
	{
		return true;
	}
	return false;
}

// the aNkZZKN function
function aNkZZKN(gettype_aNkZZKN)
{
	if (isSet(gettype_aNkZZKN) && gettype_aNkZZKN.constructor !== Array)
	{
		var temp_aNkZZKN = gettype_aNkZZKN;
		var gettype_aNkZZKN = [];
		gettype_aNkZZKN.push(temp_aNkZZKN);
	}
	else if (!isSet(gettype_aNkZZKN))
	{
		var gettype_aNkZZKN = [];
	}
	var gettype = gettype_aNkZZKN.some(gettype_aNkZZKN_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_aNkZZKNOSP_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_aNkZZKNOSP_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_aNkZZKNcyp_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_aNkZZKNcyp_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_aNkZZKNkDT_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_aNkZZKNkDT_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_aNkZZKNOSP_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_aNkZZKNOSP_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_aNkZZKNcyp_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_aNkZZKNcyp_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_aNkZZKNkDT_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_aNkZZKNkDT_required = true;
		}
	}
}

// the aNkZZKN Some function
function gettype_aNkZZKN_SomeFunc(gettype_aNkZZKN)
{
	// set the function logic
	if (gettype_aNkZZKN == 2 || gettype_aNkZZKN == 4)
	{
		return true;
	}
	return false;
}

// the JzmWmUy function
function JzmWmUy(gettype_JzmWmUy)
{
	if (isSet(gettype_JzmWmUy) && gettype_JzmWmUy.constructor !== Array)
	{
		var temp_JzmWmUy = gettype_JzmWmUy;
		var gettype_JzmWmUy = [];
		gettype_JzmWmUy.push(temp_JzmWmUy);
	}
	else if (!isSet(gettype_JzmWmUy))
	{
		var gettype_JzmWmUy = [];
	}
	var gettype = gettype_JzmWmUy.some(gettype_JzmWmUy_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_JzmWmUyUJl_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_JzmWmUyUJl_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_JzmWmUyUJl_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_JzmWmUyUJl_required = true;
		}
	}
}

// the JzmWmUy Some function
function gettype_JzmWmUy_SomeFunc(gettype_JzmWmUy)
{
	// set the function logic
	if (gettype_JzmWmUy == 2)
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
