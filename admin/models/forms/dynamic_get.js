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
jform_kMOrrziZUi_required = false;
jform_rzqACdNVBb_required = false;
jform_mVMUMnJtlU_required = false;
jform_IBBCRTcbUX_required = false;
jform_ihwGAYEqUl_required = false;
jform_sjihbTtOsz_required = false;
jform_PTyAUzGqtR_required = false;
jform_cOupVhVAjI_required = false;
jform_gkhfYbErVj_required = false;
jform_GqMVAulNwz_required = false;
jform_GqMVAulMPH_required = false;
jform_mVOBZIDJfr_required = false;
jform_PoGBgSsRAP_required = false;
jform_wpkYIZnaGg_required = false;
jform_WIkoAtaVxU_required = false;
jform_WIkoAtasum_required = false;
jform_WIkoAtadRL_required = false;
jform_sSlmiqZpRY_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var gettype_kMOrrzi = jQuery("#jform_gettype").val();
	kMOrrzi(gettype_kMOrrzi);

	var main_source_rzqACdN = jQuery("#jform_main_source").val();
	rzqACdN(main_source_rzqACdN);

	var main_source_mVMUMnJ = jQuery("#jform_main_source").val();
	mVMUMnJ(main_source_mVMUMnJ);

	var main_source_IBBCRTc = jQuery("#jform_main_source").val();
	IBBCRTc(main_source_IBBCRTc);

	var main_source_ihwGAYE = jQuery("#jform_main_source").val();
	ihwGAYE(main_source_ihwGAYE);

	var addcalculation_sjihbTt = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	sjihbTt(addcalculation_sjihbTt);

	var addcalculation_EaalDSf = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EaalDSf = jQuery("#jform_gettype").val();
	EaalDSf(addcalculation_EaalDSf,gettype_EaalDSf);

	var addcalculation_EVaCfhZ = jQuery("#jform_addcalculation input[type='radio']:checked").val();
	var gettype_EVaCfhZ = jQuery("#jform_gettype").val();
	EVaCfhZ(addcalculation_EVaCfhZ,gettype_EVaCfhZ);

	var main_source_PTyAUzG = jQuery("#jform_main_source").val();
	PTyAUzG(main_source_PTyAUzG);

	var main_source_TuRxzZw = jQuery("#jform_main_source").val();
	TuRxzZw(main_source_TuRxzZw);

	var add_php_before_getitem_cOupVhV = jQuery("#jform_add_php_before_getitem input[type='radio']:checked").val();
	var gettype_cOupVhV = jQuery("#jform_gettype").val();
	cOupVhV(add_php_before_getitem_cOupVhV,gettype_cOupVhV);

	var add_php_after_getitem_gkhfYbE = jQuery("#jform_add_php_after_getitem input[type='radio']:checked").val();
	var gettype_gkhfYbE = jQuery("#jform_gettype").val();
	gkhfYbE(add_php_after_getitem_gkhfYbE,gettype_gkhfYbE);

	var gettype_GqMVAul = jQuery("#jform_gettype").val();
	GqMVAul(gettype_GqMVAul);

	var add_php_getlistquery_mVOBZID = jQuery("#jform_add_php_getlistquery input[type='radio']:checked").val();
	var gettype_mVOBZID = jQuery("#jform_gettype").val();
	mVOBZID(add_php_getlistquery_mVOBZID,gettype_mVOBZID);

	var add_php_before_getitems_PoGBgSs = jQuery("#jform_add_php_before_getitems input[type='radio']:checked").val();
	var gettype_PoGBgSs = jQuery("#jform_gettype").val();
	PoGBgSs(add_php_before_getitems_PoGBgSs,gettype_PoGBgSs);

	var add_php_after_getitems_wpkYIZn = jQuery("#jform_add_php_after_getitems input[type='radio']:checked").val();
	var gettype_wpkYIZn = jQuery("#jform_gettype").val();
	wpkYIZn(add_php_after_getitems_wpkYIZn,gettype_wpkYIZn);

	var gettype_WIkoAta = jQuery("#jform_gettype").val();
	WIkoAta(gettype_WIkoAta);

	var gettype_sSlmiqZ = jQuery("#jform_gettype").val();
	sSlmiqZ(gettype_sSlmiqZ);
});

// the kMOrrzi function
function kMOrrzi(gettype_kMOrrzi)
{
	if (isSet(gettype_kMOrrzi) && gettype_kMOrrzi.constructor !== Array)
	{
		var temp_kMOrrzi = gettype_kMOrrzi;
		var gettype_kMOrrzi = [];
		gettype_kMOrrzi.push(temp_kMOrrzi);
	}
	else if (!isSet(gettype_kMOrrzi))
	{
		var gettype_kMOrrzi = [];
	}
	var gettype = gettype_kMOrrzi.some(gettype_kMOrrzi_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_getcustom').closest('.control-group').show();
		if (jform_kMOrrziZUi_required)
		{
			updateFieldRequired('getcustom',0);
			jQuery('#jform_getcustom').prop('required','required');
			jQuery('#jform_getcustom').attr('aria-required',true);
			jQuery('#jform_getcustom').addClass('required');
			jform_kMOrrziZUi_required = false;
		}

	}
	else
	{
		jQuery('#jform_getcustom').closest('.control-group').hide();
		if (!jform_kMOrrziZUi_required)
		{
			updateFieldRequired('getcustom',1);
			jQuery('#jform_getcustom').removeAttr('required');
			jQuery('#jform_getcustom').removeAttr('aria-required');
			jQuery('#jform_getcustom').removeClass('required');
			jform_kMOrrziZUi_required = true;
		}
	}
}

// the kMOrrzi Some function
function gettype_kMOrrzi_SomeFunc(gettype_kMOrrzi)
{
	// set the function logic
	if (gettype_kMOrrzi == 3 || gettype_kMOrrzi == 4)
	{
		return true;
	}
	return false;
}

// the rzqACdN function
function rzqACdN(main_source_rzqACdN)
{
	if (isSet(main_source_rzqACdN) && main_source_rzqACdN.constructor !== Array)
	{
		var temp_rzqACdN = main_source_rzqACdN;
		var main_source_rzqACdN = [];
		main_source_rzqACdN.push(temp_rzqACdN);
	}
	else if (!isSet(main_source_rzqACdN))
	{
		var main_source_rzqACdN = [];
	}
	var main_source = main_source_rzqACdN.some(main_source_rzqACdN_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_table_main').closest('.control-group').show();
		if (jform_rzqACdNVBb_required)
		{
			updateFieldRequired('view_table_main',0);
			jQuery('#jform_view_table_main').prop('required','required');
			jQuery('#jform_view_table_main').attr('aria-required',true);
			jQuery('#jform_view_table_main').addClass('required');
			jform_rzqACdNVBb_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_table_main').closest('.control-group').hide();
		if (!jform_rzqACdNVBb_required)
		{
			updateFieldRequired('view_table_main',1);
			jQuery('#jform_view_table_main').removeAttr('required');
			jQuery('#jform_view_table_main').removeAttr('aria-required');
			jQuery('#jform_view_table_main').removeClass('required');
			jform_rzqACdNVBb_required = true;
		}
	}
}

// the rzqACdN Some function
function main_source_rzqACdN_SomeFunc(main_source_rzqACdN)
{
	// set the function logic
	if (main_source_rzqACdN == 1)
	{
		return true;
	}
	return false;
}

// the mVMUMnJ function
function mVMUMnJ(main_source_mVMUMnJ)
{
	if (isSet(main_source_mVMUMnJ) && main_source_mVMUMnJ.constructor !== Array)
	{
		var temp_mVMUMnJ = main_source_mVMUMnJ;
		var main_source_mVMUMnJ = [];
		main_source_mVMUMnJ.push(temp_mVMUMnJ);
	}
	else if (!isSet(main_source_mVMUMnJ))
	{
		var main_source_mVMUMnJ = [];
	}
	var main_source = main_source_mVMUMnJ.some(main_source_mVMUMnJ_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_view_selection').closest('.control-group').show();
		if (jform_mVMUMnJtlU_required)
		{
			updateFieldRequired('view_selection',0);
			jQuery('#jform_view_selection').prop('required','required');
			jQuery('#jform_view_selection').attr('aria-required',true);
			jQuery('#jform_view_selection').addClass('required');
			jform_mVMUMnJtlU_required = false;
		}

	}
	else
	{
		jQuery('#jform_view_selection').closest('.control-group').hide();
		if (!jform_mVMUMnJtlU_required)
		{
			updateFieldRequired('view_selection',1);
			jQuery('#jform_view_selection').removeAttr('required');
			jQuery('#jform_view_selection').removeAttr('aria-required');
			jQuery('#jform_view_selection').removeClass('required');
			jform_mVMUMnJtlU_required = true;
		}
	}
}

// the mVMUMnJ Some function
function main_source_mVMUMnJ_SomeFunc(main_source_mVMUMnJ)
{
	// set the function logic
	if (main_source_mVMUMnJ == 1)
	{
		return true;
	}
	return false;
}

// the IBBCRTc function
function IBBCRTc(main_source_IBBCRTc)
{
	if (isSet(main_source_IBBCRTc) && main_source_IBBCRTc.constructor !== Array)
	{
		var temp_IBBCRTc = main_source_IBBCRTc;
		var main_source_IBBCRTc = [];
		main_source_IBBCRTc.push(temp_IBBCRTc);
	}
	else if (!isSet(main_source_IBBCRTc))
	{
		var main_source_IBBCRTc = [];
	}
	var main_source = main_source_IBBCRTc.some(main_source_IBBCRTc_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_table_main').closest('.control-group').show();
		if (jform_IBBCRTcbUX_required)
		{
			updateFieldRequired('db_table_main',0);
			jQuery('#jform_db_table_main').prop('required','required');
			jQuery('#jform_db_table_main').attr('aria-required',true);
			jQuery('#jform_db_table_main').addClass('required');
			jform_IBBCRTcbUX_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_table_main').closest('.control-group').hide();
		if (!jform_IBBCRTcbUX_required)
		{
			updateFieldRequired('db_table_main',1);
			jQuery('#jform_db_table_main').removeAttr('required');
			jQuery('#jform_db_table_main').removeAttr('aria-required');
			jQuery('#jform_db_table_main').removeClass('required');
			jform_IBBCRTcbUX_required = true;
		}
	}
}

// the IBBCRTc Some function
function main_source_IBBCRTc_SomeFunc(main_source_IBBCRTc)
{
	// set the function logic
	if (main_source_IBBCRTc == 2)
	{
		return true;
	}
	return false;
}

// the ihwGAYE function
function ihwGAYE(main_source_ihwGAYE)
{
	if (isSet(main_source_ihwGAYE) && main_source_ihwGAYE.constructor !== Array)
	{
		var temp_ihwGAYE = main_source_ihwGAYE;
		var main_source_ihwGAYE = [];
		main_source_ihwGAYE.push(temp_ihwGAYE);
	}
	else if (!isSet(main_source_ihwGAYE))
	{
		var main_source_ihwGAYE = [];
	}
	var main_source = main_source_ihwGAYE.some(main_source_ihwGAYE_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_db_selection').closest('.control-group').show();
		if (jform_ihwGAYEqUl_required)
		{
			updateFieldRequired('db_selection',0);
			jQuery('#jform_db_selection').prop('required','required');
			jQuery('#jform_db_selection').attr('aria-required',true);
			jQuery('#jform_db_selection').addClass('required');
			jform_ihwGAYEqUl_required = false;
		}

	}
	else
	{
		jQuery('#jform_db_selection').closest('.control-group').hide();
		if (!jform_ihwGAYEqUl_required)
		{
			updateFieldRequired('db_selection',1);
			jQuery('#jform_db_selection').removeAttr('required');
			jQuery('#jform_db_selection').removeAttr('aria-required');
			jQuery('#jform_db_selection').removeClass('required');
			jform_ihwGAYEqUl_required = true;
		}
	}
}

// the ihwGAYE Some function
function main_source_ihwGAYE_SomeFunc(main_source_ihwGAYE)
{
	// set the function logic
	if (main_source_ihwGAYE == 2)
	{
		return true;
	}
	return false;
}

// the sjihbTt function
function sjihbTt(addcalculation_sjihbTt)
{
	// set the function logic
	if (addcalculation_sjihbTt == 1)
	{
		jQuery('#jform_php_calculation').closest('.control-group').show();
		if (jform_sjihbTtOsz_required)
		{
			updateFieldRequired('php_calculation',0);
			jQuery('#jform_php_calculation').prop('required','required');
			jQuery('#jform_php_calculation').attr('aria-required',true);
			jQuery('#jform_php_calculation').addClass('required');
			jform_sjihbTtOsz_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_calculation').closest('.control-group').hide();
		if (!jform_sjihbTtOsz_required)
		{
			updateFieldRequired('php_calculation',1);
			jQuery('#jform_php_calculation').removeAttr('required');
			jQuery('#jform_php_calculation').removeAttr('aria-required');
			jQuery('#jform_php_calculation').removeClass('required');
			jform_sjihbTtOsz_required = true;
		}
	}
}

// the EaalDSf function
function EaalDSf(addcalculation_EaalDSf,gettype_EaalDSf)
{
	if (isSet(addcalculation_EaalDSf) && addcalculation_EaalDSf.constructor !== Array)
	{
		var temp_EaalDSf = addcalculation_EaalDSf;
		var addcalculation_EaalDSf = [];
		addcalculation_EaalDSf.push(temp_EaalDSf);
	}
	else if (!isSet(addcalculation_EaalDSf))
	{
		var addcalculation_EaalDSf = [];
	}
	var addcalculation = addcalculation_EaalDSf.some(addcalculation_EaalDSf_SomeFunc);

	if (isSet(gettype_EaalDSf) && gettype_EaalDSf.constructor !== Array)
	{
		var temp_EaalDSf = gettype_EaalDSf;
		var gettype_EaalDSf = [];
		gettype_EaalDSf.push(temp_EaalDSf);
	}
	else if (!isSet(gettype_EaalDSf))
	{
		var gettype_EaalDSf = [];
	}
	var gettype = gettype_EaalDSf.some(gettype_EaalDSf_SomeFunc);


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

// the EaalDSf Some function
function addcalculation_EaalDSf_SomeFunc(addcalculation_EaalDSf)
{
	// set the function logic
	if (addcalculation_EaalDSf == 1)
	{
		return true;
	}
	return false;
}

// the EaalDSf Some function
function gettype_EaalDSf_SomeFunc(gettype_EaalDSf)
{
	// set the function logic
	if (gettype_EaalDSf == 1 || gettype_EaalDSf == 3)
	{
		return true;
	}
	return false;
}

// the EVaCfhZ function
function EVaCfhZ(addcalculation_EVaCfhZ,gettype_EVaCfhZ)
{
	if (isSet(addcalculation_EVaCfhZ) && addcalculation_EVaCfhZ.constructor !== Array)
	{
		var temp_EVaCfhZ = addcalculation_EVaCfhZ;
		var addcalculation_EVaCfhZ = [];
		addcalculation_EVaCfhZ.push(temp_EVaCfhZ);
	}
	else if (!isSet(addcalculation_EVaCfhZ))
	{
		var addcalculation_EVaCfhZ = [];
	}
	var addcalculation = addcalculation_EVaCfhZ.some(addcalculation_EVaCfhZ_SomeFunc);

	if (isSet(gettype_EVaCfhZ) && gettype_EVaCfhZ.constructor !== Array)
	{
		var temp_EVaCfhZ = gettype_EVaCfhZ;
		var gettype_EVaCfhZ = [];
		gettype_EVaCfhZ.push(temp_EVaCfhZ);
	}
	else if (!isSet(gettype_EVaCfhZ))
	{
		var gettype_EVaCfhZ = [];
	}
	var gettype = gettype_EVaCfhZ.some(gettype_EVaCfhZ_SomeFunc);


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

// the EVaCfhZ Some function
function addcalculation_EVaCfhZ_SomeFunc(addcalculation_EVaCfhZ)
{
	// set the function logic
	if (addcalculation_EVaCfhZ == 1)
	{
		return true;
	}
	return false;
}

// the EVaCfhZ Some function
function gettype_EVaCfhZ_SomeFunc(gettype_EVaCfhZ)
{
	// set the function logic
	if (gettype_EVaCfhZ == 2 || gettype_EVaCfhZ == 4)
	{
		return true;
	}
	return false;
}

// the PTyAUzG function
function PTyAUzG(main_source_PTyAUzG)
{
	if (isSet(main_source_PTyAUzG) && main_source_PTyAUzG.constructor !== Array)
	{
		var temp_PTyAUzG = main_source_PTyAUzG;
		var main_source_PTyAUzG = [];
		main_source_PTyAUzG.push(temp_PTyAUzG);
	}
	else if (!isSet(main_source_PTyAUzG))
	{
		var main_source_PTyAUzG = [];
	}
	var main_source = main_source_PTyAUzG.some(main_source_PTyAUzG_SomeFunc);


	// set this function logic
	if (main_source)
	{
		jQuery('#jform_php_custom_get').closest('.control-group').show();
		if (jform_PTyAUzGqtR_required)
		{
			updateFieldRequired('php_custom_get',0);
			jQuery('#jform_php_custom_get').prop('required','required');
			jQuery('#jform_php_custom_get').attr('aria-required',true);
			jQuery('#jform_php_custom_get').addClass('required');
			jform_PTyAUzGqtR_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_custom_get').closest('.control-group').hide();
		if (!jform_PTyAUzGqtR_required)
		{
			updateFieldRequired('php_custom_get',1);
			jQuery('#jform_php_custom_get').removeAttr('required');
			jQuery('#jform_php_custom_get').removeAttr('aria-required');
			jQuery('#jform_php_custom_get').removeClass('required');
			jform_PTyAUzGqtR_required = true;
		}
	}
}

// the PTyAUzG Some function
function main_source_PTyAUzG_SomeFunc(main_source_PTyAUzG)
{
	// set the function logic
	if (main_source_PTyAUzG == 3)
	{
		return true;
	}
	return false;
}

// the TuRxzZw function
function TuRxzZw(main_source_TuRxzZw)
{
	if (isSet(main_source_TuRxzZw) && main_source_TuRxzZw.constructor !== Array)
	{
		var temp_TuRxzZw = main_source_TuRxzZw;
		var main_source_TuRxzZw = [];
		main_source_TuRxzZw.push(temp_TuRxzZw);
	}
	else if (!isSet(main_source_TuRxzZw))
	{
		var main_source_TuRxzZw = [];
	}
	var main_source = main_source_TuRxzZw.some(main_source_TuRxzZw_SomeFunc);


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

// the TuRxzZw Some function
function main_source_TuRxzZw_SomeFunc(main_source_TuRxzZw)
{
	// set the function logic
	if (main_source_TuRxzZw == 1 || main_source_TuRxzZw == 2)
	{
		return true;
	}
	return false;
}

// the cOupVhV function
function cOupVhV(add_php_before_getitem_cOupVhV,gettype_cOupVhV)
{
	if (isSet(add_php_before_getitem_cOupVhV) && add_php_before_getitem_cOupVhV.constructor !== Array)
	{
		var temp_cOupVhV = add_php_before_getitem_cOupVhV;
		var add_php_before_getitem_cOupVhV = [];
		add_php_before_getitem_cOupVhV.push(temp_cOupVhV);
	}
	else if (!isSet(add_php_before_getitem_cOupVhV))
	{
		var add_php_before_getitem_cOupVhV = [];
	}
	var add_php_before_getitem = add_php_before_getitem_cOupVhV.some(add_php_before_getitem_cOupVhV_SomeFunc);

	if (isSet(gettype_cOupVhV) && gettype_cOupVhV.constructor !== Array)
	{
		var temp_cOupVhV = gettype_cOupVhV;
		var gettype_cOupVhV = [];
		gettype_cOupVhV.push(temp_cOupVhV);
	}
	else if (!isSet(gettype_cOupVhV))
	{
		var gettype_cOupVhV = [];
	}
	var gettype = gettype_cOupVhV.some(gettype_cOupVhV_SomeFunc);


	// set this function logic
	if (add_php_before_getitem && gettype)
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').show();
		if (jform_cOupVhVAjI_required)
		{
			updateFieldRequired('php_before_getitem',0);
			jQuery('#jform_php_before_getitem').prop('required','required');
			jQuery('#jform_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_php_before_getitem').addClass('required');
			jform_cOupVhVAjI_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitem').closest('.control-group').hide();
		if (!jform_cOupVhVAjI_required)
		{
			updateFieldRequired('php_before_getitem',1);
			jQuery('#jform_php_before_getitem').removeAttr('required');
			jQuery('#jform_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_php_before_getitem').removeClass('required');
			jform_cOupVhVAjI_required = true;
		}
	}
}

// the cOupVhV Some function
function add_php_before_getitem_cOupVhV_SomeFunc(add_php_before_getitem_cOupVhV)
{
	// set the function logic
	if (add_php_before_getitem_cOupVhV == 1)
	{
		return true;
	}
	return false;
}

// the cOupVhV Some function
function gettype_cOupVhV_SomeFunc(gettype_cOupVhV)
{
	// set the function logic
	if (gettype_cOupVhV == 1 || gettype_cOupVhV == 3)
	{
		return true;
	}
	return false;
}

// the gkhfYbE function
function gkhfYbE(add_php_after_getitem_gkhfYbE,gettype_gkhfYbE)
{
	if (isSet(add_php_after_getitem_gkhfYbE) && add_php_after_getitem_gkhfYbE.constructor !== Array)
	{
		var temp_gkhfYbE = add_php_after_getitem_gkhfYbE;
		var add_php_after_getitem_gkhfYbE = [];
		add_php_after_getitem_gkhfYbE.push(temp_gkhfYbE);
	}
	else if (!isSet(add_php_after_getitem_gkhfYbE))
	{
		var add_php_after_getitem_gkhfYbE = [];
	}
	var add_php_after_getitem = add_php_after_getitem_gkhfYbE.some(add_php_after_getitem_gkhfYbE_SomeFunc);

	if (isSet(gettype_gkhfYbE) && gettype_gkhfYbE.constructor !== Array)
	{
		var temp_gkhfYbE = gettype_gkhfYbE;
		var gettype_gkhfYbE = [];
		gettype_gkhfYbE.push(temp_gkhfYbE);
	}
	else if (!isSet(gettype_gkhfYbE))
	{
		var gettype_gkhfYbE = [];
	}
	var gettype = gettype_gkhfYbE.some(gettype_gkhfYbE_SomeFunc);


	// set this function logic
	if (add_php_after_getitem && gettype)
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').show();
		if (jform_gkhfYbErVj_required)
		{
			updateFieldRequired('php_after_getitem',0);
			jQuery('#jform_php_after_getitem').prop('required','required');
			jQuery('#jform_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_php_after_getitem').addClass('required');
			jform_gkhfYbErVj_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitem').closest('.control-group').hide();
		if (!jform_gkhfYbErVj_required)
		{
			updateFieldRequired('php_after_getitem',1);
			jQuery('#jform_php_after_getitem').removeAttr('required');
			jQuery('#jform_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_php_after_getitem').removeClass('required');
			jform_gkhfYbErVj_required = true;
		}
	}
}

// the gkhfYbE Some function
function add_php_after_getitem_gkhfYbE_SomeFunc(add_php_after_getitem_gkhfYbE)
{
	// set the function logic
	if (add_php_after_getitem_gkhfYbE == 1)
	{
		return true;
	}
	return false;
}

// the gkhfYbE Some function
function gettype_gkhfYbE_SomeFunc(gettype_gkhfYbE)
{
	// set the function logic
	if (gettype_gkhfYbE == 1 || gettype_gkhfYbE == 3)
	{
		return true;
	}
	return false;
}

// the GqMVAul function
function GqMVAul(gettype_GqMVAul)
{
	if (isSet(gettype_GqMVAul) && gettype_GqMVAul.constructor !== Array)
	{
		var temp_GqMVAul = gettype_GqMVAul;
		var gettype_GqMVAul = [];
		gettype_GqMVAul.push(temp_GqMVAul);
	}
	else if (!isSet(gettype_GqMVAul))
	{
		var gettype_GqMVAul = [];
	}
	var gettype = gettype_GqMVAul.some(gettype_GqMVAul_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').show();
		if (jform_GqMVAulNwz_required)
		{
			updateFieldRequired('add_php_after_getitem',0);
			jQuery('#jform_add_php_after_getitem').prop('required','required');
			jQuery('#jform_add_php_after_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitem').addClass('required');
			jform_GqMVAulNwz_required = false;
		}

		jQuery('#jform_add_php_before_getitem').closest('.control-group').show();
		if (jform_GqMVAulMPH_required)
		{
			updateFieldRequired('add_php_before_getitem',0);
			jQuery('#jform_add_php_before_getitem').prop('required','required');
			jQuery('#jform_add_php_before_getitem').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitem').addClass('required');
			jform_GqMVAulMPH_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitem').closest('.control-group').hide();
		if (!jform_GqMVAulNwz_required)
		{
			updateFieldRequired('add_php_after_getitem',1);
			jQuery('#jform_add_php_after_getitem').removeAttr('required');
			jQuery('#jform_add_php_after_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitem').removeClass('required');
			jform_GqMVAulNwz_required = true;
		}
		jQuery('#jform_add_php_before_getitem').closest('.control-group').hide();
		if (!jform_GqMVAulMPH_required)
		{
			updateFieldRequired('add_php_before_getitem',1);
			jQuery('#jform_add_php_before_getitem').removeAttr('required');
			jQuery('#jform_add_php_before_getitem').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitem').removeClass('required');
			jform_GqMVAulMPH_required = true;
		}
	}
}

// the GqMVAul Some function
function gettype_GqMVAul_SomeFunc(gettype_GqMVAul)
{
	// set the function logic
	if (gettype_GqMVAul == 1 || gettype_GqMVAul == 3)
	{
		return true;
	}
	return false;
}

// the mVOBZID function
function mVOBZID(add_php_getlistquery_mVOBZID,gettype_mVOBZID)
{
	if (isSet(add_php_getlistquery_mVOBZID) && add_php_getlistquery_mVOBZID.constructor !== Array)
	{
		var temp_mVOBZID = add_php_getlistquery_mVOBZID;
		var add_php_getlistquery_mVOBZID = [];
		add_php_getlistquery_mVOBZID.push(temp_mVOBZID);
	}
	else if (!isSet(add_php_getlistquery_mVOBZID))
	{
		var add_php_getlistquery_mVOBZID = [];
	}
	var add_php_getlistquery = add_php_getlistquery_mVOBZID.some(add_php_getlistquery_mVOBZID_SomeFunc);

	if (isSet(gettype_mVOBZID) && gettype_mVOBZID.constructor !== Array)
	{
		var temp_mVOBZID = gettype_mVOBZID;
		var gettype_mVOBZID = [];
		gettype_mVOBZID.push(temp_mVOBZID);
	}
	else if (!isSet(gettype_mVOBZID))
	{
		var gettype_mVOBZID = [];
	}
	var gettype = gettype_mVOBZID.some(gettype_mVOBZID_SomeFunc);


	// set this function logic
	if (add_php_getlistquery && gettype)
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').show();
		if (jform_mVOBZIDJfr_required)
		{
			updateFieldRequired('php_getlistquery',0);
			jQuery('#jform_php_getlistquery').prop('required','required');
			jQuery('#jform_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_php_getlistquery').addClass('required');
			jform_mVOBZIDJfr_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_getlistquery').closest('.control-group').hide();
		if (!jform_mVOBZIDJfr_required)
		{
			updateFieldRequired('php_getlistquery',1);
			jQuery('#jform_php_getlistquery').removeAttr('required');
			jQuery('#jform_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_php_getlistquery').removeClass('required');
			jform_mVOBZIDJfr_required = true;
		}
	}
}

// the mVOBZID Some function
function add_php_getlistquery_mVOBZID_SomeFunc(add_php_getlistquery_mVOBZID)
{
	// set the function logic
	if (add_php_getlistquery_mVOBZID == 1)
	{
		return true;
	}
	return false;
}

// the mVOBZID Some function
function gettype_mVOBZID_SomeFunc(gettype_mVOBZID)
{
	// set the function logic
	if (gettype_mVOBZID == 2 || gettype_mVOBZID == 4)
	{
		return true;
	}
	return false;
}

// the PoGBgSs function
function PoGBgSs(add_php_before_getitems_PoGBgSs,gettype_PoGBgSs)
{
	if (isSet(add_php_before_getitems_PoGBgSs) && add_php_before_getitems_PoGBgSs.constructor !== Array)
	{
		var temp_PoGBgSs = add_php_before_getitems_PoGBgSs;
		var add_php_before_getitems_PoGBgSs = [];
		add_php_before_getitems_PoGBgSs.push(temp_PoGBgSs);
	}
	else if (!isSet(add_php_before_getitems_PoGBgSs))
	{
		var add_php_before_getitems_PoGBgSs = [];
	}
	var add_php_before_getitems = add_php_before_getitems_PoGBgSs.some(add_php_before_getitems_PoGBgSs_SomeFunc);

	if (isSet(gettype_PoGBgSs) && gettype_PoGBgSs.constructor !== Array)
	{
		var temp_PoGBgSs = gettype_PoGBgSs;
		var gettype_PoGBgSs = [];
		gettype_PoGBgSs.push(temp_PoGBgSs);
	}
	else if (!isSet(gettype_PoGBgSs))
	{
		var gettype_PoGBgSs = [];
	}
	var gettype = gettype_PoGBgSs.some(gettype_PoGBgSs_SomeFunc);


	// set this function logic
	if (add_php_before_getitems && gettype)
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').show();
		if (jform_PoGBgSsRAP_required)
		{
			updateFieldRequired('php_before_getitems',0);
			jQuery('#jform_php_before_getitems').prop('required','required');
			jQuery('#jform_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_php_before_getitems').addClass('required');
			jform_PoGBgSsRAP_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_before_getitems').closest('.control-group').hide();
		if (!jform_PoGBgSsRAP_required)
		{
			updateFieldRequired('php_before_getitems',1);
			jQuery('#jform_php_before_getitems').removeAttr('required');
			jQuery('#jform_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_php_before_getitems').removeClass('required');
			jform_PoGBgSsRAP_required = true;
		}
	}
}

// the PoGBgSs Some function
function add_php_before_getitems_PoGBgSs_SomeFunc(add_php_before_getitems_PoGBgSs)
{
	// set the function logic
	if (add_php_before_getitems_PoGBgSs == 1)
	{
		return true;
	}
	return false;
}

// the PoGBgSs Some function
function gettype_PoGBgSs_SomeFunc(gettype_PoGBgSs)
{
	// set the function logic
	if (gettype_PoGBgSs == 2 || gettype_PoGBgSs == 4)
	{
		return true;
	}
	return false;
}

// the wpkYIZn function
function wpkYIZn(add_php_after_getitems_wpkYIZn,gettype_wpkYIZn)
{
	if (isSet(add_php_after_getitems_wpkYIZn) && add_php_after_getitems_wpkYIZn.constructor !== Array)
	{
		var temp_wpkYIZn = add_php_after_getitems_wpkYIZn;
		var add_php_after_getitems_wpkYIZn = [];
		add_php_after_getitems_wpkYIZn.push(temp_wpkYIZn);
	}
	else if (!isSet(add_php_after_getitems_wpkYIZn))
	{
		var add_php_after_getitems_wpkYIZn = [];
	}
	var add_php_after_getitems = add_php_after_getitems_wpkYIZn.some(add_php_after_getitems_wpkYIZn_SomeFunc);

	if (isSet(gettype_wpkYIZn) && gettype_wpkYIZn.constructor !== Array)
	{
		var temp_wpkYIZn = gettype_wpkYIZn;
		var gettype_wpkYIZn = [];
		gettype_wpkYIZn.push(temp_wpkYIZn);
	}
	else if (!isSet(gettype_wpkYIZn))
	{
		var gettype_wpkYIZn = [];
	}
	var gettype = gettype_wpkYIZn.some(gettype_wpkYIZn_SomeFunc);


	// set this function logic
	if (add_php_after_getitems && gettype)
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').show();
		if (jform_wpkYIZnaGg_required)
		{
			updateFieldRequired('php_after_getitems',0);
			jQuery('#jform_php_after_getitems').prop('required','required');
			jQuery('#jform_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_php_after_getitems').addClass('required');
			jform_wpkYIZnaGg_required = false;
		}

	}
	else
	{
		jQuery('#jform_php_after_getitems').closest('.control-group').hide();
		if (!jform_wpkYIZnaGg_required)
		{
			updateFieldRequired('php_after_getitems',1);
			jQuery('#jform_php_after_getitems').removeAttr('required');
			jQuery('#jform_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_php_after_getitems').removeClass('required');
			jform_wpkYIZnaGg_required = true;
		}
	}
}

// the wpkYIZn Some function
function add_php_after_getitems_wpkYIZn_SomeFunc(add_php_after_getitems_wpkYIZn)
{
	// set the function logic
	if (add_php_after_getitems_wpkYIZn == 1)
	{
		return true;
	}
	return false;
}

// the wpkYIZn Some function
function gettype_wpkYIZn_SomeFunc(gettype_wpkYIZn)
{
	// set the function logic
	if (gettype_wpkYIZn == 2 || gettype_wpkYIZn == 4)
	{
		return true;
	}
	return false;
}

// the WIkoAta function
function WIkoAta(gettype_WIkoAta)
{
	if (isSet(gettype_WIkoAta) && gettype_WIkoAta.constructor !== Array)
	{
		var temp_WIkoAta = gettype_WIkoAta;
		var gettype_WIkoAta = [];
		gettype_WIkoAta.push(temp_WIkoAta);
	}
	else if (!isSet(gettype_WIkoAta))
	{
		var gettype_WIkoAta = [];
	}
	var gettype = gettype_WIkoAta.some(gettype_WIkoAta_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').show();
		if (jform_WIkoAtaVxU_required)
		{
			updateFieldRequired('add_php_after_getitems',0);
			jQuery('#jform_add_php_after_getitems').prop('required','required');
			jQuery('#jform_add_php_after_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_after_getitems').addClass('required');
			jform_WIkoAtaVxU_required = false;
		}

		jQuery('#jform_add_php_before_getitems').closest('.control-group').show();
		if (jform_WIkoAtasum_required)
		{
			updateFieldRequired('add_php_before_getitems',0);
			jQuery('#jform_add_php_before_getitems').prop('required','required');
			jQuery('#jform_add_php_before_getitems').attr('aria-required',true);
			jQuery('#jform_add_php_before_getitems').addClass('required');
			jform_WIkoAtasum_required = false;
		}

		jQuery('#jform_add_php_getlistquery').closest('.control-group').show();
		if (jform_WIkoAtadRL_required)
		{
			updateFieldRequired('add_php_getlistquery',0);
			jQuery('#jform_add_php_getlistquery').prop('required','required');
			jQuery('#jform_add_php_getlistquery').attr('aria-required',true);
			jQuery('#jform_add_php_getlistquery').addClass('required');
			jform_WIkoAtadRL_required = false;
		}

	}
	else
	{
		jQuery('#jform_add_php_after_getitems').closest('.control-group').hide();
		if (!jform_WIkoAtaVxU_required)
		{
			updateFieldRequired('add_php_after_getitems',1);
			jQuery('#jform_add_php_after_getitems').removeAttr('required');
			jQuery('#jform_add_php_after_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_after_getitems').removeClass('required');
			jform_WIkoAtaVxU_required = true;
		}
		jQuery('#jform_add_php_before_getitems').closest('.control-group').hide();
		if (!jform_WIkoAtasum_required)
		{
			updateFieldRequired('add_php_before_getitems',1);
			jQuery('#jform_add_php_before_getitems').removeAttr('required');
			jQuery('#jform_add_php_before_getitems').removeAttr('aria-required');
			jQuery('#jform_add_php_before_getitems').removeClass('required');
			jform_WIkoAtasum_required = true;
		}
		jQuery('#jform_add_php_getlistquery').closest('.control-group').hide();
		if (!jform_WIkoAtadRL_required)
		{
			updateFieldRequired('add_php_getlistquery',1);
			jQuery('#jform_add_php_getlistquery').removeAttr('required');
			jQuery('#jform_add_php_getlistquery').removeAttr('aria-required');
			jQuery('#jform_add_php_getlistquery').removeClass('required');
			jform_WIkoAtadRL_required = true;
		}
	}
}

// the WIkoAta Some function
function gettype_WIkoAta_SomeFunc(gettype_WIkoAta)
{
	// set the function logic
	if (gettype_WIkoAta == 2 || gettype_WIkoAta == 4)
	{
		return true;
	}
	return false;
}

// the sSlmiqZ function
function sSlmiqZ(gettype_sSlmiqZ)
{
	if (isSet(gettype_sSlmiqZ) && gettype_sSlmiqZ.constructor !== Array)
	{
		var temp_sSlmiqZ = gettype_sSlmiqZ;
		var gettype_sSlmiqZ = [];
		gettype_sSlmiqZ.push(temp_sSlmiqZ);
	}
	else if (!isSet(gettype_sSlmiqZ))
	{
		var gettype_sSlmiqZ = [];
	}
	var gettype = gettype_sSlmiqZ.some(gettype_sSlmiqZ_SomeFunc);


	// set this function logic
	if (gettype)
	{
		jQuery('#jform_pagination').closest('.control-group').show();
		if (jform_sSlmiqZpRY_required)
		{
			updateFieldRequired('pagination',0);
			jQuery('#jform_pagination').prop('required','required');
			jQuery('#jform_pagination').attr('aria-required',true);
			jQuery('#jform_pagination').addClass('required');
			jform_sSlmiqZpRY_required = false;
		}

	}
	else
	{
		jQuery('#jform_pagination').closest('.control-group').hide();
		if (!jform_sSlmiqZpRY_required)
		{
			updateFieldRequired('pagination',1);
			jQuery('#jform_pagination').removeAttr('required');
			jQuery('#jform_pagination').removeAttr('aria-required');
			jQuery('#jform_pagination').removeClass('required');
			jform_sSlmiqZpRY_required = true;
		}
	}
}

// the sSlmiqZ Some function
function gettype_sSlmiqZ_SomeFunc(gettype_sSlmiqZ)
{
	// set the function logic
	if (gettype_sSlmiqZ == 2)
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
